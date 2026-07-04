@extends('emails.layouts.base')

@section('title', 'Verifikasi Email Akun Anda / Verify Your Email / التحقق من بريدك الإلكتروني')

@section('content')
    <h2>Halo / Hello / مرحبًا, {{ $user->name }}! 👋</h2>
    
    <p>🇮🇩 <strong>[ID]</strong> Terima kasih telah mendaftar di Portal IMM Korkom Universitas 'Aisyiyah Yogyakarta. Untuk menjaga keamanan akun Anda dan memastikan bahwa email ini benar milik Anda, silakan verifikasi alamat email Anda dengan mengeklik tombol di bawah ini:</p>
    
    <p>🇺🇸 <strong>[EN]</strong> Thank you for registering on the IMM Korkom Universitas 'Aisyiyah Yogyakarta Portal. To keep your account secure and verify that this email belongs to you, please verify your email address by clicking the button below:</p>
    
    <p dir="rtl" style="text-align: right;">🇸🇦 <strong>[AR]</strong> شكرًا لتسجيلك في بوابة IMM Korkom Universitas 'Aisyiyah Yogyakarta. للحفاظ على أمان حسابك والتحقق من أن هذا البريد الإلكتروني يخصك، يرجى التحقق من عنوان بريدك الإلكتروني بالنقر على الزر أدناه:</p>
    
    @include('emails.components.button', ['url' => $url, 'slot' => 'Verifikasi Email / Verify Email / تحقق من البريد'])
    
    <p style="margin-top: 15px;">
        <small>🇮🇩 Jika Anda tidak pernah merasa mendaftar di sistem kami, Anda dapat mengabaikan dan menghapus email ini dengan aman.</small><br>
        <small>🇺🇸 If you did not create an account, no further action is required and you can safely ignore this email.</small><br>
        <div dir="rtl" style="text-align: right;"><small>🇸🇦 إذا لم تقم بإنشاء حساب، فلا يلزم اتخاذ أي إجراء إضافي ويمكنك تجاهل هذا البريد الإلكتروني بأمان.</small></div>
    </p>
    
    <p style="margin-top: 30px; margin-bottom: 0;">
        Salam hangat / Best regards / أطيب التحيات,<br>
        <strong>Tim Admin IMM Korkom UNISA</strong>
    </p>

    @include('emails.components.alt-link', ['url' => $url])
@endsection
