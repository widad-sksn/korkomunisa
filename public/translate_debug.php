<?php
require __DIR__.'/../vendor/autoload.php';

use Stichoza\GoogleTranslate\GoogleTranslate;

try {
    $tr = new GoogleTranslate('en', 'id');
    $result = $tr->translate('Halo dunia. Ini adalah tes terjemahan dari server Proxmox.');
    echo "<h1>Translation SUCCESS!</h1>";
    echo "<p>Result: " . htmlspecialchars($result) . "</p>";
} catch (\Exception $e) {
    echo "<h1>Translation FAILED!</h1>";
    echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
