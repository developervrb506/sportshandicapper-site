<?php
header('Content-Type: text/plain');
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

try {
    // Test database connection
    DB::connection()->getPdo();
    echo "✓ Database connection: OK\n\n";
    
    // Check admin user
    $admin = DB::table('users')
        ->where('email', 'admin@inspin.local')
        ->first();
    
    if ($admin) {
        echo "✓ Admin user found:\n";
        echo "  ID: {$admin->id}\n";
        echo "  Email: {$admin->email}\n";
        echo "  Name: {$admin->name}\n";
        echo "  Role: {$admin->role}\n";
        
        // Verify password
        $passwordCorrect = Hash::check('password123', $admin->password);
        echo "  Password correct: " . ($passwordCorrect ? 'YES' : 'NO') . "\n\n";
    } else {
        echo "✗ Admin user NOT found!\n\n";
    }
    
    // Check tips count
    $tipCount = DB::table('tips')->count();
    echo "✓ Tips in database: {$tipCount}\n\n";
    
    // Check articles count
    $articleCount = DB::table('articles')->count();
    echo "✓ Articles in database: {$articleCount}\n\n";
    
    echo "If all checks show ✓, you should be able to login at:\n";
    echo "http://inspin.infinityfreeapp.com/login\n";
    echo "Email: admin@inspin.local\n";
    echo "Password: password123\n";
    
} catch (Exception $e) {
    echo "✗ ERROR: " . $e->getMessage() . "\n";
    echo "Trace: " . $e->getTraceAsString() . "\n";
}