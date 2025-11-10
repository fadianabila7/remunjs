<?php
class Log_user_activity
{

    public function log_url()
    {
        date_default_timezone_set('Asia/Jakarta'); // Pastikan waktu di-set ke Asia/Jakarta

        $CI = &get_instance();

        $url        = current_url();
        $fallbackIp = $CI->input->ip_address();
        $userAgent  = $CI->input->user_agent();
        $ipAddress  = $this->get_public_ip($fallbackIp);
        $timestamp  = date("Y-m-d H:i:s"); // Format: 2025-06-05 15:23:01

        $logLine = "[{$timestamp}] IP: {$ipAddress} | URL: {$url} | Agent: {$userAgent}\n";

        // Simpan ke log file per hari
        $logFile = APPPATH . 'logs/user_activity_' . date('Y-m-d') . '.log';
        file_put_contents($logFile, $logLine, FILE_APPEND);
    }

    private function get_public_ip($fallback)
    {
        $api = 'https://api.ipify.org?format=json';

        try {
            $ctx = stream_context_create([
                'http' => [
                    'timeout' => 3
                ]
            ]);
            $response = file_get_contents($api, false, $ctx);
            if ($response) {
                $json = json_decode($response, true);
                if (isset($json['ip'])) {
                    return $json['ip'];
                }
            }
        } catch (Exception $e) {
            // Abaikan jika gagal
        }

        return $fallback;
    }
}
