<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pengajuan;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class LayananTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_submit_permohonan_layanan()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'nama_lengkap' => 'Rimba Jati Dwi Djatmiko',
            'email' => 'rimbamiko1@gmail.com',
        ]);

        $this->actingAs($user);

        $identitasFile = UploadedFile::fake()->image('ktp.jpg');

        $response = $this->post(route('layanan.store'), [
            'jenis_layanan' => 'Permohonan',
            'nama' => 'Rimba Jati Dwi Djatmiko',
            'no_identitas' => '1234567890123456',
            'telepon' => '081234567890',
            'alamat' => 'Jl. Sumantri Brojonegoro No. 1, Bandar Lampung',
            'pekerjaan' => 'Mahasiswa',
            'kategori_pemohon' => 'Perorangan',
            'identitas' => $identitasFile,
            'info_diminta' => 'Permohonan informasi kurikulum FMIPA',
            'tujuan' => 'Untuk keperluan penelitian tugas akhir',
            'cara_ambil' => 'Email',
            'pernyataan' => '1',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('pengajuans', [
            'user_id' => $user->id,
            'jenis_layanan' => 'Permohonan',
            'nama' => 'Rimba Jati Dwi Djatmiko',
            'no_identitas' => '1234567890123456',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Sumantri Brojonegoro No. 1, Bandar Lampung',
            'pekerjaan' => 'Mahasiswa',
            'kategori_pemohon' => 'Perorangan',
            'info_diminta' => 'Permohonan informasi kurikulum FMIPA',
            'tujuan_permohonan' => 'Untuk keperluan penelitian tugas akhir',
            'cara_memperoleh' => 'Email',
        ]);

        // Assert file was stored
        $pengajuan = Pengajuan::first();
        Storage::disk('public')->assertExists($pengajuan->lampiran_identitas);
    }

    public function test_user_can_submit_keberatan_layanan()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'nama_lengkap' => 'Rimba Jati Dwi Djatmiko',
            'email' => 'rimbamiko1@gmail.com',
        ]);

        $this->actingAs($user);

        // Create a previous permohonan first
        $permohonan = Pengajuan::create([
            'user_id' => $user->id,
            'jenis_layanan' => 'Permohonan',
            'no_tiket' => 'REQ-12345',
            'nama' => 'Rimba Jati Dwi Djatmiko',
            'email' => 'rimbamiko1@gmail.com',
            'pekerjaan' => 'Mahasiswa',
            'kategori_pemohon' => 'Perorangan',
            'no_identitas' => '1234567890123456',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Sumantri Brojonegoro No. 1, Bandar Lampung',
            'info_diminta' => 'Permohonan informasi kurikulum FMIPA',
            'tujuan_permohonan' => 'Untuk keperluan penelitian tugas akhir',
            'cara_memperoleh' => 'Email',
            'lampiran_identitas' => 'temp_identitas.jpg',
            'status' => 'DIAJUKAN'
        ]);

        $dokumenKeberatanFile = UploadedFile::fake()->image('bukti.jpg');

        $response = $this->post(route('layanan.store'), [
            'jenis_layanan' => 'Keberatan',
            'permohonan_terkait_id' => $permohonan->id,
            'tujuan_keberatan' => 'Ingin informasi segera diproses',
            'alasan_keberatan' => 'Informasi tidak diberikan dalam jangka waktu yang ditentukan',
            'no_identitas' => '1234567890123456',
            'telepon' => '081234567890',
            'alamat' => 'Jl. Sumantri Brojonegoro No. 1, Bandar Lampung',
            'pekerjaan' => 'Mahasiswa',
            'kategori_pemohon' => 'Perorangan',
            'dokumen_pendukung' => $dokumenKeberatanFile,
            'pernyataan' => '1',
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('pengajuans', [
            'user_id' => $user->id,
            'jenis_layanan' => 'Keberatan',
            'permohonan_terkait_id' => $permohonan->id,
            'tujuan_keberatan' => 'Ingin informasi segera diproses',
            'alasan_keberatan' => 'Informasi tidak diberikan dalam jangka waktu yang ditentukan',
            'no_identitas' => '1234567890123456',
            'no_hp' => '081234567890',
            'alamat' => 'Jl. Sumantri Brojonegoro No. 1, Bandar Lampung',
            'pekerjaan' => 'Mahasiswa',
            'kategori_pemohon' => 'Perorangan',
            'nama' => 'Rimba Jati Dwi Djatmiko',
            'email' => 'rimbamiko1@gmail.com',
        ]);

        $keberatan = Pengajuan::where('jenis_layanan', 'Keberatan')->first();
        Storage::disk('public')->assertExists($keberatan->lampiran_pendukung);
    }
}
