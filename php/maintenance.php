<?php
require_once "request_utils.php";

function runMaintenance($conn) {
    $file = __DIR__ . "/../cache/last_maintenance.txt";

    // Create cache folder if it doesn't exist
    if (!file_exists(dirname($file))) {
        mkdir(dirname($file), 0777, true);
    }

    $now = time();
    $lastRun = file_exists($file) ? (int)file_get_contents($file) : 0;
    $interval = 1; // 10 minutes

    if (($now - $lastRun) >= $interval) {
        expireRequests($conn);
        hideTier1Requests($conn);
        file_put_contents($file, $now);
    }
}