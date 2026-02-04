<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
    require_once __DIR__ . '/Core/Session.php';
    require_once __DIR__ . '/Core/Helpers/LinkHelper.php';
    require_once __DIR__ . '/Core/Helpers/AssetHelper.php';
}
