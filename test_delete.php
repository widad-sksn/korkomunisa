<?php
$user = App\Models\User::create([
    'name' => 'Test User',
    'email' => 'testdelete@example.com',
    'password' => bcrypt('password'),
    'komisariat' => 'IMM FST'
]);
echo "User created: " . $user->id . "\n";

$user->delete();
echo "User deleted.\n";

$user2 = App\Models\User::create([
    'name' => 'Test User 2',
    'email' => 'testdelete@example.com',
    'password' => bcrypt('password'),
    'komisariat' => 'IMM FST'
]);
echo "User 2 created: " . $user2->id . "\n";
