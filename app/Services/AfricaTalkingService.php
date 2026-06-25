<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class AfricaTalkingService
{
    /**
     * Send an SMS using the configured driver (Africa's Talking or Twilio).
     *
     * @param string $to The phone number in international format (e.g. +258841234567)
     * @param string $message The message content
     * @return array [bool $success, string $message/error]
     */
    public static function sendSms($to, $message)
    {
        $driver = env('SMS_DRIVER', 'africastalking');

        if ($driver === 'twilio' || !empty(env('TWILIO_SID'))) {
            return self::sendViaTwilio($to, $message);
        }

        return self::sendViaAfricaTalking($to, $message);
    }

    /**
     * Send SMS via Twilio
     */
    private static function sendViaTwilio($to, $message)
    {
        $sid = env('TWILIO_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        $from = env('TWILIO_NUMBER');

        if (empty($sid) || empty($authToken) || empty($from)) {
            Log::warning("Twilio configuration is missing in .env.");
            return [false, "Configuração do Twilio em falta no .env."];
        }

        // Clean phone number: remove spaces
        $to = trim(str_replace(' ', '', $to));
        
        // If it starts with 8, assume Mozambique and prefix +258
        if (preg_match('/^(82|83|84|85|86|87)\d{7,8}$/', $to)) {
            $to = '+258' . $to;
        } elseif (str_starts_with($to, '258') && strlen($to) === 12) {
            $to = '+' . $to;
        }

        if (!str_starts_with($to, '+')) {
            Log::warning("Twilio: Número de telefone inválido: {$to}");
            return [false, "Número de telefone deve estar no formato internacional (ex: +25884xxxxxxx)."];
        }

        $url = "https://api.twilio.com/2010-04-01/Accounts/{$sid}/Messages.json";

        $data = [
            'To'   => $to,
            'From' => $from,
            'Body' => $message
        ];

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_USERPWD, "$sid:$authToken");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);

            $response = curl_exec($ch);
            
            if ($response === false) {
                $error = curl_error($ch);
                curl_close($ch);
                Log::error("Erro cURL ao enviar SMS via Twilio: " . $error);
                return [false, "Erro de rede cURL: " . $error];
            }
            
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $result = json_decode($response, true);

            if ($status >= 200 && $status < 300) {
                Log::info("SMS enviado com sucesso via Twilio para {$to}: " . $response);
                return [true, "SMS enviado com sucesso."];
            }

            Log::error("Erro ao enviar SMS via Twilio. Status: {$status} Body: {$response}");
            return [false, "Resposta Twilio: " . ($result['message'] ?? $response)];
        } catch (\Exception $e) {
            Log::error("Excepção ao enviar SMS via Twilio: " . $e->getMessage());
            return [false, "Erro de ligação: " . $e->getMessage()];
        }
    }

    /**
     * Send SMS via Africa's Talking
     */
    private static function sendViaAfricaTalking($to, $message)
    {
        $apiKey = env('AFRIKATALKINGAPI');
        $username = env('AFRIKATALKING_USERNAME', 'sandbox');

        if (empty($apiKey)) {
            Log::warning("Africa's Talking API Key is not set in .env.");
            return [false, "API Key não configurada no .env."];
        }

        // Clean phone number: remove spaces
        $to = trim(str_replace(' ', '', $to));
        
        // If it starts with 8, assume Mozambique and prefix +258
        if (preg_match('/^(82|83|84|85|86|87)\d{7,8}$/', $to)) {
            $to = '+258' . $to;
        } elseif (str_starts_with($to, '258') && strlen($to) === 12) {
            $to = '+' . $to;
        }

        if (!str_starts_with($to, '+')) {
            Log::warning("Africa's Talking: Número de telefone inválido: {$to}");
            return [false, "Número de telefone deve estar no formato internacional (ex: +25884xxxxxxx)."];
        }

        // Sandbox URL or Production URL
        $url = ($username === 'sandbox')
            ? 'https://api.sandbox.africastalking.com/version1/messaging'
            : 'https://api.africastalking.com/version1/messaging';

        $data = [
            'username' => $username,
            'to'       => $to,
            'message'  => $message
        ];

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'apikey: ' . $apiKey,
                'Accept: application/json',
                'Content-Type: application/x-www-form-urlencoded'
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);

            $response = curl_exec($ch);
            
            if ($response === false) {
                $error = curl_error($ch);
                curl_close($ch);
                Log::error("Erro cURL ao enviar SMS via Africa's Talking: " . $error);
                return [false, "Erro de rede cURL: " . $error];
            }
            
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $result = json_decode($response, true);

            if ($status >= 200 && $status < 300) {
                Log::info("SMS enviado com sucesso via Africa's Talking: " . $response);
                return [true, "SMS enviado com sucesso."];
            }

            Log::error("Erro ao enviar SMS via Africa's Talking. Status: {$status} Body: {$response}");
            return [false, "Resposta do servidor: " . ($result['SMSMessageData']['Recipients'][0]['status'] ?? $response)];
        } catch (\Exception $e) {
            Log::error("Excepção ao enviar SMS via Africa's Talking: " . $e->getMessage());
            return [false, "Erro de ligação: " . $e->getMessage()];
        }
    }
}
