@extends('emails.layouts.base')

@section('title', 'Status Artikel Anda / Your Article Status / حالة مقالتك')

@section('content')
    <h2>Halo / Hello / مرحبًا, {{ $user->name }}! 👋</h2>
    
    <p>🇮🇩 <strong>[ID]</strong> Terima kasih telah mengirimkan artikel berjudul <strong>"{{ $article->title }}"</strong>. Mohon maaf, saat ini artikel Anda belum dapat kami publikasikan (dikembalikan ke status Draft). Silakan periksa kembali dan perbaiki artikel Anda, lalu ajukan ulang.</p>
    
    <p>🇺🇸 <strong>[EN]</strong> Thank you for submitting the article titled <strong>"{{ $article->title }}"</strong>. We apologize, but your article cannot be published at this time (returned to Draft status). Please review and improve your article, then submit it again.</p>
    
    <p dir="rtl" style="text-align: right;">🇸🇦 <strong>[AR]</strong> شكرًا لك على إرسال المقال بعنوان <strong>"{{ $article->title }}"</strong>. نعتذر، ولكن لا يمكن نشر مقالتك في هذا الوقت (تمت إعادتها إلى حالة المسودة). يرجى مراجعة مقالتك وتحسينها، ثم إرسالها مرة أخرى.</p>
    
    @include('emails.components.button', ['url' => route('articles.edit', $article->slug ?? $article->id), 'slot' => 'Perbaiki Artikel / Edit Article / تحرير المقال'])
    
    <p style="margin-top: 30px; margin-bottom: 0;">
        Salam hangat / Best regards / أطيب التحيات,<br>
        <strong>Tim Admin IMM Korkom UNISA</strong>
    </p>

    @include('emails.components.alt-link', ['url' => route('articles.edit', $article->slug ?? $article->id)])
@endsection
