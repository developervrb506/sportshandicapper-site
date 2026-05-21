<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
echo "Tips: ".\App\Models\Tip::count().PHP_EOL;
echo "Articles: ".\App\Models\Article::count().PHP_EOL;
echo "Tickets: ".\App\Models\SupportTicket::count().PHP_EOL;
echo "Contests: ".\App\Models\Contest::count().PHP_EOL;
echo "Users: ".\App\Models\User::count().PHP_EOL;
echo "Consensus: ".\App\Models\BettingConsensus::count().PHP_EOL;
echo "Packages: ".\App\Models\Package::count().PHP_EOL;
