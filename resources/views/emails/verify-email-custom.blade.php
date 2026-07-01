@extends('emails.layouts.base')

@section('title', 'Verifikasi Email Akun Anda - IMM KORKOM UNISA')

@section('content')
    <h2>Halo, {{ $user->name }}! 👋</h2>
    <p>Terima kasih telah mendaftar di Portal IMM Korkom Universitas 'Aisyiyah Yogyakarta.</p>
    <p>Untuk menjaga keamanan akun Anda dan memastikan bahwa email ini benar milik Anda, silakan verifikasi alamat email Anda dengan mengeklik tombol di bawah ini:</p>
    
    @include('emails.components.button', ['url' => $url, 'slot' => 'Verifikasi Email Saya'])
    
    <p>Jika Anda tidak pernah merasa mendaftar di sistem kami, Anda dapat mengabaikan dan menghapus email ini dengan aman.</p>
    
    <p style="margin-top: 30px; margin-bottom: 0;">
        Salam hangat,<br>
        <strong>Tim Admin IMM Korkom UNISA</strong>
    </p>

    @include('emails.components.alt-link', ['url' => $url])
@endsection
