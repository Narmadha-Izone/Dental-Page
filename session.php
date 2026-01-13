<?php
session_start();

if (!isset($_SESSION['username']) || !isset($_SESSION['logged_in'])) {
    header("Location: index.php");
    exit;
}

// Prevent browser caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");
?>
