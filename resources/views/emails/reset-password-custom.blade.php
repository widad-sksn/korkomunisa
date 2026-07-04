@extends('emails.layouts.base')

@section('title', 'Permintaan Reset Password / Password Reset Request / طلب إعادة تعيين كلمة المرور')

@section('content')
    <h2>Halo / Hello / مرحبًا, {{ $user->name }}!</h2>
    
    <p><strong>[ID]</strong> Kami menerima permintaan untuk mereset kata sandi akun Anda di Portal IMM Korkom Universitas 'Aisyiyah Yogyakarta.</p>
    <p><strong>[EN]</strong> We received a password reset request for your account on the IMM Korkom Universitas 'Aisyiyah Yogyakarta Portal.</p>
    <p dir="rtl" style="text-align: right;"><strong>[AR]</strong> تلقينا طلبًا لإعادة تعيين كلمة المرور لحسابك في بوابة IMM Korkom Universitas 'Aisyiyah Yogyakarta.</p>
    
    @component('emails.components.panel')
        <tr>
            <th>Waktu Permintaan / Time</th>
            <td>: {{ $time }}</td>
        </tr>
        <tr>
            <th>IP Address</th>
            <td>: {{ $ip }}</td>
        </tr>
        <tr>
            <th>Perangkat / Device</th>
            <td>: {{ $browser }}</td>
        </tr>
        <tr>
            <th>OS</th>
            <td>: {{ $os }}</td>
        </tr>
    @endcomponent

    <p>Jika ini memang Anda, silakan klik tombol di bawah ini untuk membuat kata sandi baru:</p>
    <p>If this was you, please click the button below to create a new password:</p>
    <p dir="rtl" style="text-align: right;">إذا كان هذا أنت، يرجى النقر على الزر أدناه لإنشاء كلمة مرور جديدة:</p>
    
    @include('emails.components.button', ['url' => $url, 'slot' => 'Reset Password / إعادة تعيين كلمة المرور'])
    
    <p style="margin-top: 15px;">
        <small>Tautan reset kata sandi ini akan kedaluwarsa dalam 60 menit. Jika Anda tidak pernah meminta reset kata sandi, tidak ada tindakan lebih lanjut yang diperlukan. Akun Anda tetap aman.</small><br>
        <small>This password reset link will expire in 60 minutes. If you did not request a password reset, no further action is required. Your account remains secure.</small><br>
        <div dir="rtl" style="text-align: right;"><small>ستنتهي صلاحية رابط إعادة تعيين كلمة المرور هذا خلال 60 دقيقة. إذا لم تطلب إعادة تعيين كلمة المرور، فلا يلزم اتخاذ أي إجراء إضافي. حسابك لا يزال آمنًا.</small></div>
    </p>
    
    <p style="margin-top: 30px; margin-bottom: 0;">
        Salam hangat / Best regards / أطيب التحيات,<br>
        <strong>Tim Admin IMM Korkom UNISA</strong>
    </p>

    @include('emails.components.alt-link', ['url' => $url])
@endsection
