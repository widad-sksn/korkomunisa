@extends('emails.layouts.base')

@section('title', 'Permintaan Reset Password - IMM KORKOM UNISA')

@section('content')
    <h2>Halo, {{ $user->name }}!</h2>
    <p>Kami menerima permintaan untuk mereset kata sandi akun Anda di Portal IMM Korkom Universitas 'Aisyiyah Yogyakarta.</p>
    
    @component('emails.components.panel')
        <tr>
            <th>Waktu Permintaan</th>
            <td>: {{ $time }}</td>
        </tr>
        <tr>
            <th>IP Address</th>
            <td>: {{ $ip }}</td>
        </tr>
        <tr>
            <th>Perangkat / Browser</th>
            <td>: {{ $browser }}</td>
        </tr>
        <tr>
            <th>Sistem Operasi</th>
            <td>: {{ $os }}</td>
        </tr>
    @endcomponent

    <p>Jika ini memang Anda, silakan klik tombol di bawah ini untuk membuat kata sandi baru:</p>
    
    @include('emails.components.button', ['url' => $url, 'slot' => 'Reset Kata Sandi'])
    
    <p>Tautan reset kata sandi ini akan kedaluwarsa dalam 60 menit.</p>
    <p>Jika Anda tidak pernah meminta reset kata sandi, <strong>tidak ada tindakan lebih lanjut yang diperlukan</strong>. Akun Anda tetap aman.</p>
    
    <p style="margin-top: 30px; margin-bottom: 0;">
        Salam hangat,<br>
        <strong>Tim Admin IMM Korkom UNISA</strong>
    </p>

    @include('emails.components.alt-link', ['url' => $url])
@endsection
