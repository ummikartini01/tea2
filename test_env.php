<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

echo "Testing environment loading...\n";
echo "TELEGRAM_BOT_TOKEN from env(): " . env('TELEGRAM_BOT_TOKEN') . "\n";
echo "TELEGRAM_BOT_TOKEN from config: " . config('services.telegram.bot_token') . "\n";

?>
