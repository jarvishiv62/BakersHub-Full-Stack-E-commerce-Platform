<?php
// Minimal test to check if PHP/Apache is working
echo "PHP is working! " . date('Y-m-d H:i:s');
echo "<br>PHP Version: " . phpversion();
echo "<br>Server: " . ($_SERVER['SERVER_SOFTWARE'] ?? 'Unknown');
echo "<br>Document Root: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Unknown');

// Test if composer autoload works
if (file_exists(__DIR__.'/../vendor/autoload.php')) {
    echo "<br>Composer autoload: FOUND";
    require __DIR__.'/../vendor/autoload.php';
    echo "<br>Composer autoload: LOADED";
} else {
    echo "<br>Composer autoload: NOT FOUND";
}

// Test if Laravel bootstrap works
if (file_exists(__DIR__.'/../bootstrap/app.php')) {
    echo "<br>Laravel bootstrap: FOUND";
    try {
        $app = require __DIR__.'/../bootstrap/app.php';
        echo "<br>Laravel bootstrap: LOADED";
    } catch (Exception $e) {
        echo "<br>Laravel bootstrap: ERROR - " . $e->getMessage();
    }
} else {
    echo "<br>Laravel bootstrap: NOT FOUND";
}
?>
