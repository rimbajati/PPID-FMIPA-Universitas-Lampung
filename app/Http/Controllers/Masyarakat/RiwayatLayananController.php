<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Models\Keberatan;
use App\Models\Permohonan;
use Illuminate\Http\Request;

class RiwayatLayananController extends Controller
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'no_tiket' => 'required|string|max:40',
            ]);
        }

        $ticket = strtoupper(trim((string) $request->input('no_tiket', '')));
        $allLayans = collect();
        $hasSearched = $ticket !== '';
        $notFound = false;

        if ($ticket !== '') {
            $permohonan = Permohonan::whereRaw('UPPER(no_tiket) = ?', [$ticket])->first();

            if ($permohonan) {
                $allLayans->push($this->payloadPermohonan($permohonan));

                $keberatans = Keberatan::where('permohonan_id', $permohonan->id)->latest()->get();
                foreach ($keberatans as $keberatan) {
                    $allLayans->push($this->payloadKeberatan($keberatan, $permohonan));
                }
            } else {
                $keberatan = Keberatan::whereRaw('UPPER(no_tiket) = ?', [$ticket])->first();
                if ($keberatan) {
                    $permohonanRef = Permohonan::find($keberatan->permohonan_id);
                    $allLayans->push($this->payloadKeberatan($keberatan, $permohonanRef));
                } else {
                    $notFound = true;
                }
            }
        }

        return view('masyarakat.layanan.riwayat.index', compact('allLayans', 'ticket', 'hasSearched', 'notFound'));
    }

    /**
     * Payload publik: cukup untuk pelacakan, tanpa identitas, kontak, atau berkas pemohon.
     */
    private function payloadPermohonan(Permohonan $permohonan): array
    {
        $status = $permohonan->status ?: 'Diajukan';
        $saluranDigital = $this->isSaluranDigital($permohonan->cara_memperoleh_informasi);

        return [
            'type' => 'permohonan',
            'jenis_label' => 'Permohonan Informasi',
            'no_tiket' => $permohonan->no_tiket,
            'status' => $status,
            'nama_pemohon' => $permohonan->nama_lengkap,
            'waktu_pengajuan' => $permohonan->created_at?->translatedFormat('d F Y, H:i') . ' WIB',
            'cara_memperoleh' => $permohonan->cara_memperoleh_informasi,
            'info_diminta' => $permohonan->informasi_yang_diminta,
            'tujuan_penggunaan' => $permohonan->tujuan_penggunaan_informasi,
            'no_identitas' => $permohonan->no_identitas,
            'pekerjaan' => $permohonan->pekerjaan,
            'jenis_identitas' => $permohonan->jenis_identitas,
            'judul' => $permohonan->informasi_yang_diminta,
            'pokok_layanan' => $permohonan->informasi_yang_diminta,
            'jenis_permohonan' => $permohonan->jenis_permohonan,
            'saluran_penyampaian' => $saluranDigital
                ? 'Salinan digital'
                : 'Pengambilan atau melihat di tempat',
            'saluran_digital' => $saluranDigital,
            'tanggal_pengajuan' => $permohonan->created_at?->translatedFormat('d F Y') ?? '-',
            'created_at_formatted' => $permohonan->created_at?->translatedFormat('d F Y, H:i') . ' WIB',
            'updated_at_formatted' => $permohonan->updated_at?->translatedFormat('d F Y, H:i') . ' WIB',
            'estimasi_selesai' => $permohonan->created_at?->copy()->addDays(10)->translatedFormat('d F Y') ?? '-',
            'sla_keterangan' => 'Paling lambat 10 hari kerja sejak pengajuan, sesuai UU KIP.',
            'status_keterangan' => $this->keteranganStatus('permohonan', $status),
            'langkah_berikutnya' => $this->langkahBerikutnya('permohonan', $status),
            'berkas_identitas_diterima' => filled($permohonan->file_identitas),
            'catatan_diproses' => $permohonan->catatan_diproses,
            'catatan_selesai' => $permohonan->catatan_selesai,
            'jawaban' => $permohonan->jawaban,
            'alasan_ditolak' => $permohonan->alasan_ditolak,
            'has_keberatan' => $permohonan->keberatans()->exists(),
            'jawaban_files' => $permohonan->jawabanFiles->map(fn($f) => [
                'name' => $f->file_name,
                'url'  => asset('storage/' . $f->file_path),
                'size' => $f->file_size,
            ])->values()->all(),
        ];
    }

    private function payloadKeberatan(Keberatan $keberatan, ?Permohonan $permohonan): array
    {
        $status = $keberatan->status ?: 'Diajukan';

        return [
            'type' => 'keberatan',
            'jenis_label' => 'Pengajuan Keberatan',
            'no_tiket' => $keberatan->no_tiket,
            'status' => $status,
            'nama_pemohon' => $permohonan?->nama_lengkap,
            'waktu_pengajuan' => $keberatan->created_at?->translatedFormat('d F Y, H:i') . ' WIB',
            'judul' => $keberatan->alasan_keberatan,
            'alasan_keberatan' => $keberatan->alasan_keberatan,
            'kronologi_keberatan' => $keberatan->kronologi_keberatan,
            'pokok_layanan' => $keberatan->alasan_keberatan,
            'tiket_permohonan_asal' => $permohonan?->no_tiket,
            'cara_memperoleh' => $permohonan?->cara_memperoleh_informasi,
            'tanggal_pengajuan' => $keberatan->created_at?->translatedFormat('d F Y') ?? '-',
            'created_at_formatted' => $keberatan->created_at?->translatedFormat('d F Y, H:i') . ' WIB',
            'updated_at_formatted' => $keberatan->updated_at?->translatedFormat('d F Y, H:i') . ' WIB',
            'estimasi_selesai' => $keberatan->created_at?->copy()->addDays(30)->translatedFormat('d F Y') ?? '-',
            'sla_keterangan' => 'Paling lambat 30 hari kerja sejak pengajuan keberatan.',
            'status_keterangan' => $this->keteranganStatus('keberatan', $status),
            'langkah_berikutnya' => $this->langkahBerikutnya('keberatan', $status),
            'berkas_pendukung_diterima' => filled($keberatan->file_pendukung),
            'catatan_diproses' => $keberatan->catatan_diproses,
            'catatan_selesai' => $keberatan->catatan_selesai,
            'jawaban' => $keberatan->jawaban,
            'alasan_ditolak' => $keberatan->alasan_ditolak,
            'jawaban_files' => $keberatan->jawabanFiles->map(fn($f) => [
                'name' => $f->file_name,
                'url'  => asset('storage/' . $f->file_path),
                'size' => $f->file_size,
            ])->values()->all(),
        ];
    }

    private function isSaluranDigital(?string $cara): bool
    {
        $cara = strtolower((string) $cara);

        return $cara !== '' && (str_contains($cara, 'email') || str_contains($cara, 'digital'));
    }

    private function keteranganStatus(string $type, string $status): string
    {
        $isKeberatan = $type === 'keberatan';

        return match ($status) {
            'Diproses' => $isKeberatan
                ? 'Keberatan sedang ditinjau dan dikoordinasikan dengan Atasan PPID.'
                : 'Permohonan sedang diperiksa dan disiapkan oleh petugas PPID.',
            'Selesai' => $isKeberatan
                ? 'Tanggapan atas keberatan telah diputuskan.'
                : 'Permohonan telah dipenuhi. Hasil disampaikan sesuai saluran yang dipilih saat pengajuan.',
            'Ditolak' => $isKeberatan
                ? 'Pengajuan keberatan tidak dapat dipenuhi. Alasan tercantum pada riwayat proses.'
                : 'Permohonan tidak dapat dipenuhi. Alasan tercantum pada riwayat proses.',
            default => $isKeberatan
                ? 'Keberatan sudah masuk sistem dan menunggu pemeriksaan Atasan PPID.'
                : 'Permohonan sudah masuk sistem dan menunggu pemeriksaan petugas PPID.',
        };
    }

    private function langkahBerikutnya(string $type, string $status): string
    {
        $isKeberatan = $type === 'keberatan';

        return match ($status) {
            'Diproses' => 'Tidak ada tindakan yang perlu Anda lakukan saat ini. Pantau halaman ini hingga status diperbarui.',
            'Selesai' => $isKeberatan
                ? 'Periksa pemberitahuan resmi yang dikirim ke saluran yang Anda daftarkan saat pengajuan.'
                : 'Terima hasil sesuai saluran penyampaian: salinan digital atau pengambilan/melihat di Dekanat FMIPA Unila pada jam kerja.',
            'Ditolak' => $isKeberatan
                ? 'Proses keberatan di tingkat PPID FMIPA telah selesai. Anda dapat menempuh upaya hukum lanjutan sesuai ketentuan UU KIP.'
                : 'Anda dapat mengajukan keberatan atas permohonan ini jika tidak sependapat dengan keputusan PPID.',
            default => 'Simpan nomor tiket ini. Gunakan halaman ini untuk memantau progres tanpa membagikan data pribadi Anda.',
        };
    }
}
