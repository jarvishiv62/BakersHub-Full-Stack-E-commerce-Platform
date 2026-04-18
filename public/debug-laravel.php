<?php
require __DIR__.'/../vendor/autoload.php';

echo "=== Laravel Debug ===<br>";

try {
    $app = require __DIR__.'/../bootstrap/app.php';
    echo "1. App bootstrap: SUCCESS<br>";
    
    // Test kernel
    $kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
    echo "2. HTTP Kernel: SUCCESS<br>";
    
    // Test environment
    echo "3. Environment Variables:<br>";
    echo "   APP_ENV: " . env('APP_ENV', 'NOT_SET') . "<br>";
    echo "   APP_DEBUG: " . env('APP_DEBUG', 'NOT_SET') . "<br>";
    echo "   APP_KEY: " . (env('APP_KEY') ? 'SET' : 'NOT_SET') . "<br>";
    echo "   DB_CONNECTION: " . env('DB_CONNECTION', 'NOT_SET') . "<br>";
    
    // Test simple request
    $request = Illuminate\Http\Request::create('/health', 'GET');
    echo "4. Request creation: SUCCESS<br>";
    
    // Test route handling
    try {
        $response = $kernel->handle($request);
        echo "5. Route handling: SUCCESS<br>";
        echo "   Response status: " . $response->getStatusCode() . "<br>";
        echo "   Response content: " . $response->getContent() . "<br>";
    } catch (Exception $e) {
        echo "5. Route handling: ERROR<br>";
        echo "   Error: " . $e->getMessage() . "<br>";
        echo "   File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
    }
    
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
}
?>
