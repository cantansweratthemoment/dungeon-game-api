<?php

function logger($message)
{
    $log_dirname = '../logs';
    if (!file_exists($log_dirname)) {
        mkdir($log_dirname, 0777, true);
    }
    $log_file_data = $log_dirname . '/log_' . date('d-M-Y') . '.log';
    file_put_contents($log_file_data, $message . "\n", FILE_APPEND);
}