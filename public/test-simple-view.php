<?php
require __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../bootstrap/app.php';

// Test if we can render a simple string
echo "<h1>Simple View Test</h1>";

// Test if Blade engine works
try {
    $blade = $app['view'];
    
    // Test simple template
    $html = '<div style="background: #E83F6F; color: white; padding: 20px; margin: 10px;">';
    $html .= '<h3>Direct HTML Test</h3>';
    $html .= '<p>If you see this with pink background, PHP is working</p>';
    $html .= '<p>Time: ' . date('Y-m-d H:i:s') . '</p>';
    $html .= '</div>';
    
    echo $html;
    
    echo "<h2>View Factory Test:</h2>";
    if ($blade) {
        echo "View Factory: YES<br>";
    } else {
        echo "View Factory: NO<br>";
    }
    
    echo "<h2>File Check:</h2>";
    $authLogin = __DIR__.'/../resources/views/auth/login.blade.php';
    $layoutsApp = __DIR__.'/../resources/views/layouts/app.blade.php';
    
    echo "auth/login.blade.php: " . (file_exists($authLogin) ? "EXISTS" : "MISSING") . "<br>";
    echo "layouts/app.blade.php: " . (file_exists($layoutsApp) ? "EXISTS" : "MISSING") . "<br>";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "<br>";
}
?>
