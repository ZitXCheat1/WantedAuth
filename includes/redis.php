<?php
include_once (($_SERVER['DOCUMENT_ROOT'] == "/usr/share/nginx/html/panel" || $_SERVER['DOCUMENT_ROOT'] == "/usr/share/nginx/html/api") ? "/usr/share/nginx/html" : $_SERVER['DOCUMENT_ROOT']) . '/includes/credentials.php'; // reference credentials

$redis = null;

if (!class_exists('Redis')) {
        return;
}

try {
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);

        global $redisPass;

        if(!empty($redisPass)) {
                $redis->auth($redisPass);
        }
} catch (\Throwable $e) {
        $redis = null;
}
