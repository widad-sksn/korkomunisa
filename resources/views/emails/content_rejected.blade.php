<!DOCTYPE html>
<html>
<head>
    <title>Pemberitahuan Status Konten</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; padding: 20px;">
    <div style="max-width: 600px; margin: auto; border: 1px solid #ddd; padding: 20px; border-radius: 8px;">
        <h2 style="color: #e53e3e;">Status Konten Anda</h2>
        <p>Halo, <strong>{{ $model->user->name ?? 'Penulis' }}</strong>!</p>
        
        <p>Terima kasih telah mengirimkan draf {{ $model instanceof \App\Models\Article ? 'tulisan' : 'kegiatan' }} Anda. Setelah kami meninjau konten yang berjudul:</p>
        
        <blockquote style="font-size: 18px; font-weight: bold; border-left: 4px solid #e53e3e; padding-left: 10px; color: #555;">
            "{{ is_array($model->title) ? ($model->title['id'] ?? $model->title['en'] ?? $model->title['ar']) : $model->title }}"
        </blockquote>
        
        <p>Mohon maaf, saat ini konten tersebut <strong>belum dapat disetujui</strong> untuk diterbitkan. Hal ini bisa terjadi karena tidak memenuhi standar pedoman penulisan atau membutuhkan perbaikan lebih lanjut.</p>
        
        <p>Anda dapat mengedit draf tersebut melalui dasbor akun Anda dan mengirimkannya kembali untuk ditinjau ulang.</p>
        
        <p style="margin-top: 30px;">Tetap semangat berkarya!<br>
        <strong>Tim Admin IMM Korkom UNISA</strong></p>
    </div>
</body>
</html>
