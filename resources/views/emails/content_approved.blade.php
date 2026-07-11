<!DOCTYPE html>
<html>
<head>
    <title>Konten Anda Telah Disetujui</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; padding: 20px;">
    <div style="max-width: 600px; margin: auto; border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
        <h2 style="color: #2c5282;">Selamat! Konten Anda Telah Disetujui</h2>
        <p>Halo, <strong>{{ $model->user->name ?? 'Penulis' }}</strong>!</p>
        
        <p>Kabar baik! {{ $model instanceof \App\Models\Article ? 'Tulisan' : 'Kegiatan' }} Anda yang berjudul:</p>
        
        <blockquote style="font-size: 18px; font-weight: bold; border-left: 4px solid #2c5282; padding-left: 10px; color: #555;">
            "{{ is_array($model->title) ? ($model->title['id'] ?? $model->title['en'] ?? $model->title['ar']) : $model->title }}"
        </blockquote>
        
        <p>Telah disetujui oleh Administrator dan kini sudah terbit di website IMM Korkom UNISA.</p>
        
        <p>Terima kasih atas kontribusi Anda. Teruslah berkarya!</p>
        
        <p style="margin-top: 30px;">Salam hangat,<br>
        <strong>Tim Admin IMM Korkom UNISA</strong></p>
    </div>
</body>
</html>
