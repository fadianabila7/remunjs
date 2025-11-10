<?php
class Log_user_activity
{

    public function log_url()
    {
        date_default_timezone_set('Asia/Jakarta'); // Pastikan waktu di-set ke Asia/Jakarta

        $CI = &get_instance();

        $url        = current_url();
        $userAgent = $CI->input->user_agent();
        $ipAddress = $CI->input->ip_address();
        $timestamp  = date("Y-m-d H:i:s");

        $ip = isset($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $_SERVER['REMOTE_ADDR'];


        // log_message('info', 'IP Asli: ' . $ip);
        $logLine = "[{$timestamp}] IP: {$ip} | URL: {$url} | Agent: {$userAgent}\n";

        // Simpan ke log file per hari
        $logFile = '../../logs/operator/user_activity1_' . date('Y-m-d') . '.log';
        file_put_contents($logFile, $logLine, FILE_APPEND);
    }
}
