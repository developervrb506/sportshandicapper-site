<?php
header('Content-Type: text/plain');
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;

try {
    // Check database connection
    $db = DB::connection()->getPdo();
    echo "Database connection: OK\n\n";
    
    // List all tables
    $tables = DB::select('SHOW TABLES');
    echo "Tables in database:\n";
    foreach ($tables as $table) {
        $tableName = (array)$table)[0];
        echo "  - $tableName\n";
    }
    echo "\n";
    
    // Check each table row count
    foreach ($tables as $table) {
        $tableName = (array)$table)[0];
        $count = DB::table($tableName)->count();
        echo "{$tableName}: $count rows\n";
        
        // Show first row for key tables
        if ($count > 0 && in_array($tableName, ['users', 'tips', 'articles'])) {
            $first = DB::table($tableName)->first();
            if ($first) {
                echo "  First row: ";
                foreach ((array)$first as $key => $value) {
                    if ($key === 'password' || $key === 'remember_token') {
                        echo "$key=[HIDDEN] ";
                    } elseif (is_string($value) && strlen($value) > 50) {
                        echo "$key=" . substr($value, 0, 50) . "... ";
                    } else {
                        echo "$key=$value ";
                    }
                }
                echo "\n";
            }
        }
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}