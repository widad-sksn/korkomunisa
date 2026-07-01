<?php

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $url = 'https://immkorkom.unisayogya.ac.id/register';
    $data = [
        'name' => 'AI Test User',
        'email' => 'aitest' . time() . '@unisayogya.ac.id',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'komisariat' => 'Korkom UNISA',
        'bidang' => 'Bidang Kaderisasi',
        'jabatan' => 'Anggota'
    ];

    $user = \App\Models\User::create($data);

    event(new \Illuminate\Auth\Events\Registered($user));
    echo "Success!";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
