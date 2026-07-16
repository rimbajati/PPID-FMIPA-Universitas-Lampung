<h3>Halo, {{ $permohonan->nama }}</h3>
<p>Status permohonan Anda telah diupdate oleh Admin PPID FMIPA Unila.</p>

<div style="border: 1px solid #ddd; padding: 15px; border-radius: 8px; margin: 15px 0;">
    <h4 style="margin-top: 0;">Detail Permohonan:</h4>
    <p><strong>Nomor Tiket:</strong> {{ $permohonan->no_tiket }}</p>
    <p><strong>Rincian Informasi:</strong> {{ $permohonan->info_diminta }}</p>
    <p><strong>Status Baru:</strong> <span style="color: #0095e8; font-weight: bold;">{{ $permohonan->status }}</span></p>
</div>

@if($permohonan->catatan_admin)
    <div style="background: #f4f4f4; padding: 15px; border-radius: 8px; margin-bottom: 15px;">
        <strong>Catatan/Jawaban Admin:</strong>
        <p>{{ $permohonan->catatan_admin }}</p>
    </div>
@endif

@if($permohonan->status == 'DITERIMA' && $permohonan->file_jawaban)
    <p>Kami telah melampirkan berkas jawaban pada email ini. Anda juga dapat mengunduhnya melalui tautan berikut:</p>
    <a href="{{ asset('storage/'.$permohonan->file_jawaban) }}" style="background: #0095e8; color: #fff; padding: 10px 15px; text-decoration: none; border-radius: 5px;">Unduh Berkas Jawaban</a>
@endif

<p>Terima kasih telah menggunakan layanan PPID FMIPA Universitas Lampung.</p>

