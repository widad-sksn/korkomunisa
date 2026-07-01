<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $user = \App\Models\User::create([
        'name' => 'Test User',
        'email' => 'test_error_500@gmail.com',
        'password' => \Illuminate\Support\Facades\Hash::make('password123'),
        'komisariat' => 'Korkom UNISA',
        'bidang' => null,
        'jabatan' => null,
    ]);

    event(new \Illuminate\Auth\Events\Registered($user));
    echo "Success!";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
