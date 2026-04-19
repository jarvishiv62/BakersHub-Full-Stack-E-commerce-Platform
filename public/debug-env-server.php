<?php
echo "=== Server Environment Debug ===<br>";

echo "1. \$_ENV Variables:<br>";
foreach (['APP_ENV', 'APP_DEBUG', 'APP_KEY', 'DB_CONNECTION', 'DB_HOST'] as $key) {
    echo "   $key: " . ($_ENV[$key] ?? 'NOT_SET') . "<br>";
}

echo "<br>2. getenv() Variables:<br>";
foreach (['APP_ENV', 'APP_DEBUG', 'APP_KEY', 'DB_CONNECTION', 'DB_HOST'] as $key) {
    echo "   $key: " . (getenv($key) ?: 'NOT_SET') . "<br>";
}

echo "<br>3. \$_SERVER Variables:<br>";
foreach (['APP_ENV', 'APP_DEBUG', 'APP_KEY', 'DB_CONNECTION', 'DB_HOST'] as $key) {
    echo "   $key: " . ($_SERVER[$key] ?? 'NOT_SET') . "<br>";
}

echo "<br>4. All \$_ENV:<br>";
foreach ($_ENV as $key => $value) {
    if (strpos($key, 'APP_') === 0 || strpos($key, 'DB_') === 0) {
        echo "   $key: $value<br>";
    }
}
?>
