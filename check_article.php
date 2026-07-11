<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$a = App\Models\Portfolio::first();
if ($a) {
    echo "Title Translations:\n";
    print_r($a->getTranslations('title'));
    echo "\nContent Translations:\n";
    print_r($a->getTranslations('description'));
} else {
    echo "No portfolios found.\n";
}
