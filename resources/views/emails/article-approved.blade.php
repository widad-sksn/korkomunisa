@extends('emails.layouts.base')

@section('title', 'Artikel Anda Telah Disetujui / Your Article is Approved / تمت الموافقة على مقالتك')

@section('content')
    <h2>Halo / Hello / مرحبًا, {{ $user->name }}! 👋</h2>
    
    <p><strong>[ID]</strong> Selamat! Artikel Anda yang berjudul <strong>"{{ $article->title }}"</strong> telah disetujui oleh admin dan sekarang sudah dipublikasikan di website IMM Korkom UNISA. Terima kasih atas kontribusi Anda dalam berbagi gagasan, narasi, dan pemikiran.</p>
    
    <p><strong>[EN]</strong> Congratulations! Your article titled <strong>"{{ $article->title }}"</strong> has been approved by the admin and is now published on the IMM Korkom UNISA website. Thank you for your contribution in sharing ideas, narratives, and thoughts.</p>
    
    <p dir="rtl" style="text-align: right;"><strong>[AR]</strong> تهانينا! تمت الموافقة على مقالتك بعنوان <strong>"{{ $article->title }}"</strong> من قبل المسؤول وتم نشرها الآن على موقع IMM Korkom UNISA. نشكرك على مساهمتك في مشاركة الأفكار والروايات والخواطر.</p>
    
    @include('emails.components.button', ['url' => route('articles.show_public', $article->slug ?? $article->id), 'slot' => 'Lihat Artikel / View Article / عرض المقال'])
    
    <p style="margin-top: 30px; margin-bottom: 0;">
        Salam hangat / Best regards / أطيب التحيات,<br>
        <strong>Tim Admin IMM Korkom UNISA</strong>
    </p>

    @include('emails.components.alt-link', ['url' => route('articles.show_public', $article->slug ?? $article->id)])
@endsection
