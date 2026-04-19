<?php
require __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../bootstrap/app.php';

// Test basic view rendering
try {
    $viewFactory = $app['view'];
    
    echo "<h1>View Test</h1>";
    
    // Test simple string rendering
    echo "<h2>1. Simple String Test:</h2>";
    echo $viewFactory->make('test-simple', ['message' => 'Hello from view!'])->render();
    
    echo "<h2>2. Layout Test:</h2>";
    // Test if layout exists
    if (file_exists(__DIR__.'/../resources/views/layouts/app.blade.php')) {
        echo "Layout file exists: YES<br>";
    } else {
        echo "Layout file exists: NO<br>";
    }
    
    echo "<h2>3. Home View Test:</h2>";
    // Test if home view exists
    if (file_exists(__DIR__.'/../resources/views/home.blade.php')) {
        echo "Home view exists: YES<br>";
    } else {
        echo "Home view exists: NO<br>";
    }
    
    echo "<h2>4. Login View Test:</h2>";
    // Test if login view exists
    if (file_exists(__DIR__.'/../resources/views/auth/login.blade.php')) {
        echo "Login view exists: YES<br>";
    } else {
        echo "Login view exists: NO<br>";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
