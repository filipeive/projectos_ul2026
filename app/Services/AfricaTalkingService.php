<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

/**
 * SmsService — httpSMS only driver.
 * Uses httpsms.com API to send SMS via the physical device registered in the account.
 *
 * Required .env:
 *   SMS_DRIVER=httpsms
 *   HTTPSMS_KEY=<api_key>
 *   HTTPSMS_FROM=<your_registered_phone_number>  e.g. +258847xxxxxx
 */
class AfricaTalkingService
{
    /**
     * Send an SMS via httpSMS.
     *
     * @param string $to      Destination phone number (local or international format)
     * @param string $message Message content
     * @return array [bool $success, string $statusMessage]
     */
    public static function sendSms(string $to, string $message): array
    {
        return self::sendViaHttpSms($to, $message);
    }

    /**
     * Send SMS via httpSMS (httpsms.com)
     */
    private static function sendViaHttpSms(string $to, string $message): array
    {
        $apiKey = env('HTTPSMS_KEY');
        $from   = env('HTTPSMS_FROM');

        if (empty($apiKey) || empty($from)) {
            Log::warning('[SMS] httpSMS configuration missing in .env (HTTPSMS_KEY or HTTPSMS_FROM).');
            return [false, 'Configuração do httpSMS em falta no .env.'];
        }

        // Normalize destination number
        $to = self::normalizePhone($to);
        if ($to === null) {
            return [false, 'Número de telefone inválido ou não reconhecido.'];
        }

        // Normalize source number
        $from = self::normalizePhone($from);
        if ($from === null) {
            return [false, 'Número de origem (HTTPSMS_FROM) inválido no .env.'];
        }

        $url  = 'https://api.httpsms.com/v1/messages/send';
        $body = json_encode([
            'content' => $message,
            'from'    => $from,
            'to'      => $to,
        ]);

        try {
            $ch = curl_init();
            curl_setopt_array($ch, [
                CURLOPT_URL            => $url,
                CURLOPT_POST           => true,
                CURLOPT_POSTFIELDS     => $body,
                CURLOPT_HTTPHEADER     => [
                    'x-api-key: '    . $apiKey,
                    'Content-Type: application/json',
                    'Accept: application/json',
                ],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 5,
                CURLOPT_TIMEOUT        => 10,
            ]);

            $response = curl_exec($ch);

            if ($response === false) {
                $error = curl_error($ch);
                curl_close($ch);
                Log::error('[SMS] cURL error (httpSMS): ' . $error);
                return [false, 'Erro de rede: ' . $error];
            }

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $result = json_decode($response, true);

            if ($httpCode >= 200 && $httpCode < 300) {
                Log::info("[SMS] Mensagem enviada com sucesso via httpSMS para {$to}.");
                return [true, 'SMS enviado com sucesso.'];
            }

            // Build human-readable error
            $detail = $result['message'] ?? $response;
            if (is_array($detail) || is_object($detail)) {
                $detail = json_encode($detail, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
            }

            Log::error("[SMS] httpSMS error HTTP {$httpCode}: {$detail}");
            return [false, 'httpSMS: ' . $detail];

        } catch (\Throwable $e) {
            Log::error('[SMS] Exception (httpSMS): ' . $e->getMessage());
            return [false, 'Erro interno: ' . $e->getMessage()];
        }
    }

    /**
     * Normalize a phone number to E.164 international format (+258XXXXXXXXX for MZ numbers).
     * Returns null if the number cannot be normalized.
     */
    private static function normalizePhone(string $phone): ?string
    {
        // Strip spaces, dashes, parentheses
        $phone = preg_replace('/[\s\-().]+/', '', $phone);

        // Already in E.164 format
        if (preg_match('/^\+\d{8,15}$/', $phone)) {
            return $phone;
        }

        // Mozambique: starts with 82|83|84|85|86|87 + 7 digits
        if (preg_match('/^(8[2-7])\d{7}$/', $phone)) {
            return '+258' . $phone;
        }

        // Mozambique with country code without +
        if (preg_match('/^258(8[2-7]\d{7})$/', $phone)) {
            return '+' . $phone;
        }

        // Generic numeric with enough digits — add + prefix
        if (preg_match('/^\d{8,15}$/', $phone)) {
            return '+' . $phone;
        }

        return null;
    }
}
