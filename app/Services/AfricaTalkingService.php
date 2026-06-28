<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class AfricaTalkingService
{
    /**
     * Legacy service name kept for controller compatibility.
     *
     * @param string $to The phone number in international format, e.g. +258841234567
     * @param string $message The message content
     * @return array [bool $success, string $message]
     */
    public static function sendSms($to, $message)
    {
        return self::sendViaHttpSms($to, $message);
    }

    private static function sendViaHttpSms($to, $message)
    {
        $apiKey = env('HTTPSMS_KEY');
        $from = env('HTTPSMS_FROM');

        if (empty($apiKey) || empty($from)) {
            Log::warning('httpSMS configuration is missing in .env.');
            return [false, 'Configuração do httpSMS em falta no .env.'];
        }

        $to = self::normalizePhoneNumber($to);
        $from = self::normalizePhoneNumber($from);

        $payload = [
            'content' => $message,
            'from' => $from,
            'to' => $to,
        ];

        try {
            $ch = curl_init('https://api.httpsms.com/v1/messages/send');

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload, JSON_UNESCAPED_UNICODE));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'x-api-key: ' . $apiKey,
                'Content-Type: application/json',
                'Accept: application/json',
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);

            $response = curl_exec($ch);

            if ($response === false) {
                $error = curl_error($ch);
                curl_close($ch);

                Log::error('Erro cURL ao enviar SMS via httpSMS: ' . $error);
                return [false, 'Erro de rede cURL: ' . $error];
            }

            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($status >= 200 && $status < 300) {
                Log::info("SMS enviado com sucesso via httpSMS para {$to}: " . $response);
                return [true, 'SMS enviado com sucesso.'];
            }

            $detail = self::extractErrorDetail($response);
            Log::error("Erro ao enviar SMS via httpSMS. Status: {$status} Response: " . $detail);

            return [false, 'Resposta httpSMS: ' . $detail];
        } catch (\Throwable $e) {
            Log::error('Excepção ao enviar SMS via httpSMS: ' . $e->getMessage());
            return [false, 'Erro de ligação: ' . $e->getMessage()];
        }
    }

    private static function normalizePhoneNumber($phone)
    {
        $phone = trim((string) $phone);
        $phone = preg_replace('/[^\d+]/', '', $phone);

        if (str_starts_with($phone, '00')) {
            $phone = '+' . substr($phone, 2);
        }

        if (preg_match('/^8[2-7]\d{7}$/', $phone)) {
            return '+258' . $phone;
        }

        if (preg_match('/^2588[2-7]\d{7}$/', $phone)) {
            return '+' . $phone;
        }

        if (!str_starts_with($phone, '+')) {
            return '+' . $phone;
        }

        return $phone;
    }

    private static function extractErrorDetail($response)
    {
        $decoded = json_decode($response, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return (string) $response;
        }

        $detail = $decoded['message']
            ?? $decoded['error']
            ?? $decoded['detail']
            ?? $decoded;

        if (is_array($detail) || is_object($detail)) {
            return json_encode($detail, JSON_UNESCAPED_UNICODE);
        }

        return (string) $detail;
    }
}
