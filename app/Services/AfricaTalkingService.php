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

        if ($driver === 'twilio') {
            return self::sendViaTwilio($to, $message);
        }
        if ($driver === 'd7') {
            return self::sendViaD7($to, $message);
        }
        if ($driver === 'vonage') {
            return self::sendViaVonage($to, $message);
        }
        if ($driver === 'httpsms') {
            return self::sendViaHttpSms($to, $message);
        }
        if ($driver === 'africastalking') {
            return self::sendViaAfricaTalking($to, $message);
        }

        // Fallbacks for compatibility if driver name is not explicit
        if (!empty(env('HTTPSMS_KEY'))) {
            return self::sendViaHttpSms($to, $message);
        }
        if (!empty(env('D7_TOKEN'))) {
            return self::sendViaD7($to, $message);
        }
        if (!empty(env('TWILIO_SID'))) {
            return self::sendViaTwilio($to, $message);
        }
        if (!empty(env('VONAGE_KEY'))) {
            return self::sendViaVonage($to, $message);
        }

        return self::sendViaAfricaTalking($to, $message);
    }

    /**
     * Send SMS via httpSMS (httpsms.com)
     */
    private static function sendViaHttpSms($to, $message)
    {
        $apiKey = env('HTTPSMS_KEY');
        $from = env('HTTPSMS_FROM');

        if (empty($apiKey) || empty($from)) {
            Log::warning("httpSMS configuration is missing in .env.");
            return [false, "Configuração do httpSMS em falta no .env."];
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
            $to = '+' . $to;
        }

        // Clean from number
        $from = trim(str_replace(' ', '', $from));
        if (preg_match('/^(82|83|84|85|86|87)\d{7,8}$/', $from)) {
            $from = '+258' . $from;
        } elseif (str_starts_with($from, '258') && strlen($from) === 12) {
            $from = '+' . $from;
        }
        if (!str_starts_with($from, '+')) {
            $from = '+' . $from;
        }

        $url = 'https://api.httpsms.com/v1/messages/send';

        $data = [
            'content' => $message,
            'from' => $from,
            'to' => $to
        ];

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'x-api-key: ' . $apiKey,
                'Content-Type: application/json',
                'Accept: application/json'
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);

            $response = curl_exec($ch);
            
            if ($response === false) {
                $error = curl_error($ch);
                curl_close($ch);
                Log::error("Erro cURL ao enviar SMS via httpSMS: " . $error);
                return [false, "Erro de rede cURL: " . $error];
            }
            
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $result = json_decode($response, true);

            if ($status >= 200 && $status < 300) {
                Log::info("SMS enviado com sucesso via httpSMS para {$to}: " . $response);
                return [true, "SMS enviado com sucesso."];
            }

            Log::error("Erro ao enviar SMS via httpSMS. Status: {$status} Body: {$response}");
            return [false, "Resposta httpSMS: " . ($result['message'] ?? $response)];
        } catch (\Exception $e) {
            Log::error("Excepção ao enviar SMS via httpSMS: " . $e->getMessage());
            return [false, "Erro de ligação: " . $e->getMessage()];
        }
    }

    /**
     * Send SMS via D7 Networks
     */
    private static function sendViaD7($to, $message)
    {
        $token = env('D7_TOKEN');
        $originator = env('D7_ORIGINATOR', 'TechHub');

        if (empty($token)) {
            Log::warning("D7 Networks configuration is missing in .env.");
            return [false, "Configuração do D7 Networks em falta no .env."];
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
            $to = '+' . $to;
        }

        $url = 'https://api.d7networks.com/messages/v1/send';

        $data = [
            'messages' => [
                [
                    'channel' => 'sms',
                    'recipients' => [
                        $to
                    ],
                    'content' => $message,
                    'msg_type' => 'text',
                    'data_coding' => 'text'
                ]
            ],
            'message_globals' => [
                'originator' => $originator
            ]
        ];

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Authorization: Bearer ' . $token,
                'Content-Type: application/json',
                'Accept: application/json'
            ]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);

            $response = curl_exec($ch);
            
            if ($response === false) {
                $error = curl_error($ch);
                curl_close($ch);
                Log::error("Erro cURL ao enviar SMS via D7 Networks: " . $error);
                return [false, "Erro de rede cURL: " . $error];
            }
            
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $result = json_decode($response, true);

            if ($status >= 200 && $status < 300) {
                Log::info("SMS enviado com sucesso via D7 Networks para {$to}: " . $response);
                return [true, "SMS enviado com sucesso."];
            }

            Log::error("Erro ao enviar SMS via D7 Networks. Status: {$status} Body: {$response}");
            return [false, "Resposta D7 Networks: " . ($result['detail'] ?? $response)];
        } catch (\Exception $e) {
            Log::error("Excepção ao enviar SMS via D7 Networks: " . $e->getMessage());
            return [false, "Erro de ligação: " . $e->getMessage()];
        }
    }

    /**
     * Send SMS via Vonage
     */
    private static function sendViaVonage($to, $message)
    {
        $apiKey = env('VONAGE_KEY');
        $apiSecret = env('VONAGE_SECRET');
        $from = env('VONAGE_NUMBER', 'TechHub');

        if (empty($apiKey) || empty($apiSecret)) {
            Log::warning("Vonage configuration is missing in .env.");
            return [false, "Configuração do Vonage em falta no .env."];
        }

        // Clean phone number: remove spaces
        $to = trim(str_replace(' ', '', $to));
        
        // If it starts with 8, assume Mozambique and prefix 258
        if (preg_match('/^(82|83|84|85|86|87)\d{7,8}$/', $to)) {
            $to = '258' . $to;
        } elseif (str_starts_with($to, '+')) {
            $to = ltrim($to, '+');
        }

        $url = 'https://rest.nexmo.com/sms/json';

        $data = [
            'api_key' => $apiKey,
            'api_secret' => $apiSecret,
            'to' => $to,
            'from' => $from,
            'text' => $message
        ];

        try {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);

            $response = curl_exec($ch);
            
            if ($response === false) {
                $error = curl_error($ch);
                curl_close($ch);
                Log::error("Erro cURL ao enviar SMS via Vonage: " . $error);
                return [false, "Erro de rede cURL: " . $error];
            }
            
            $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            $result = json_decode($response, true);

            if ($status >= 200 && $status < 300 && isset($result['messages'][0]['status']) && $result['messages'][0]['status'] == '0') {
                Log::info("SMS enviado com sucesso via Vonage para {$to}: " . $response);
                return [true, "SMS enviado com sucesso."];
            }

            $errMsg = $result['messages'][0]['error-text'] ?? $response;
            Log::error("Erro ao enviar SMS via Vonage. Status: {$status} Response: " . $errMsg);
            return [false, "Resposta Vonage: " . $errMsg];
        } catch (\Exception $e) {
            Log::error("Excepção ao enviar SMS via Vonage: " . $e->getMessage());
            return [false, "Erro de ligação: " . $e->getMessage()];
        }
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
