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
        \Illuminate\Support\Facades\Mail::fake();

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
            'cara_ambil' => 'Melalui Email atau Website',
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
            'cara_memperoleh' => 'Melalui Email atau Website',
        ]);

        // Assert file was stored
        $pengajuan = Pengajuan::first();
        Storage::disk('public')->assertExists($pengajuan->lampiran_identitas);

        \Illuminate\Support\Facades\Mail::assertSent(\App\Mail\PengajuanSubmittedMail::class, function (\App\Mail\PengajuanSubmittedMail $mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        $this->assertDatabaseHas('status_histories', [
            'pengajuan_id' => $pengajuan->id,
            'status' => 'DIAJUKAN',
            'catatan' => null,
        ]);
    }

    public function test_user_can_submit_keberatan_layanan()
    {
        Storage::fake('public');
        \Illuminate\Support\Facades\Mail::fake();

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
            'lampiran_pendukung' => $dokumenKeberatanFile,
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

        \Illuminate\Support\Facades\Mail::assertSent(\App\Mail\PengajuanSubmittedMail::class, function (\App\Mail\PengajuanSubmittedMail $mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        $this->assertDatabaseHas('status_histories', [
            'pengajuan_id' => $keberatan->id,
            'status' => 'DIAJUKAN',
            'catatan' => null,
        ]);
    }

    public function test_user_can_update_permohonan_layanan()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'nama_lengkap' => 'Rimba Jati Dwi Djatmiko',
            'email' => 'rimbamiko1@gmail.com',
        ]);

        $this->actingAs($user);

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
            'cara_memperoleh' => 'Melalui Email atau Website',
            'lampiran_identitas' => 'temp_identitas.jpg',
            'status' => 'DIAJUKAN'
        ]);

        $response = $this->put(route('layanan.update', $permohonan->id), [
            'pekerjaan' => 'Masyarakat Umum',
            'kategori_pemohon' => 'Perorangan',
            'no_identitas' => '9876543210987654',
            'telepon' => '08987654321',
            'alamat' => 'Jl. Baru No. 10',
            'info_diminta' => 'Permohonan info baru',
            'tujuan' => 'Tujuan baru',
            'cara_ambil' => 'Mengambil langsung ke FMIPA',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('pengajuans', [
            'id' => $permohonan->id,
            'pekerjaan' => 'Masyarakat Umum',
            'no_identitas' => '9876543210987654',
            'no_hp' => '08987654321',
            'alamat' => 'Jl. Baru No. 10',
            'info_diminta' => 'Permohonan info baru',
            'tujuan_permohonan' => 'Tujuan baru',
            'cara_memperoleh' => 'Mengambil langsung ke FMIPA',
        ]);
    }

    public function test_user_can_delete_permohonan_layanan()
    {
        $user = User::factory()->create([
            'nama_lengkap' => 'Rimba Jati Dwi Djatmiko',
            'email' => 'rimbamiko1@gmail.com',
        ]);

        $this->actingAs($user);

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

        $response = $this->delete(route('layanan.destroy', $permohonan->id));

        $this->assertDatabaseMissing('pengajuans', [
            'id' => $permohonan->id,
        ]);
    }

    public function test_user_cannot_delete_processed_permohonan_layanan()
    {
        $user = User::factory()->create([
            'nama_lengkap' => 'Rimba Jati Dwi Djatmiko',
            'email' => 'rimbamiko1@gmail.com',
        ]);

        $this->actingAs($user);

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
            'status' => 'DIPROSES'
        ]);

        $response = $this->deleteJson(route('layanan.destroy', $permohonan->id));

        $response->assertStatus(403);
        $response->assertJson([
            'success' => false,
            'message' => 'Hanya pengajuan berstatus diajukan yang dapat dihapus.'
        ]);
        $this->assertDatabaseHas('pengajuans', [
            'id' => $permohonan->id,
        ]);
    }

    public function test_user_cannot_delete_permohonan_when_status_is_perbaikan()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $permohonan = Pengajuan::create([
            'user_id' => $user->id,
            'jenis_layanan' => 'Permohonan',
            'no_tiket' => 'REQ-PERBAIKAN-DEL',
            'nama' => $user->nama_lengkap,
            'email' => $user->email,
            'pekerjaan' => 'Mahasiswa',
            'kategori_pemohon' => 'Perorangan',
            'no_identitas' => '1234567890123456',
            'no_hp' => '081234567890',
            'alamat' => 'Bandar Lampung',
            'info_diminta' => 'Permohonan info',
            'tujuan_permohonan' => 'Tujuan',
            'cara_memperoleh' => 'Email',
            'lampiran_identitas' => 'temp.jpg',
            'status' => 'PERBAIKAN'
        ]);

        $response = $this->deleteJson(route('layanan.destroy', $permohonan->id));

        $response->assertStatus(403);
        $response->assertJson([
            'success' => false,
            'message' => 'Hanya pengajuan berstatus diajukan yang dapat dihapus.'
        ]);
        $this->assertDatabaseHas('pengajuans', [
            'id' => $permohonan->id,
        ]);
    }

    public function test_user_cannot_delete_others_permohonan_layanan()
    {
        $user1 = User::factory()->create();
        $user2 = User::factory()->create();

        $this->actingAs($user1);

        $permohonan = Pengajuan::create([
            'user_id' => $user2->id,
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

        $response = $this->deleteJson(route('layanan.destroy', $permohonan->id));

        $response->assertStatus(403);
        $this->assertDatabaseHas('pengajuans', [
            'id' => $permohonan->id,
        ]);
    }

    public function test_admin_can_update_status()
    {
        Storage::fake('public');
        \Illuminate\Support\Facades\Mail::fake();

        $admin = User::factory()->create([
            'nama_lengkap' => 'Admin PPID',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);

        $user = User::factory()->create([
            'nama_lengkap' => 'Rimba Jati Dwi Djatmiko',
            'email' => 'rimbamiko1@gmail.com',
        ]);

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

        $this->actingAs($admin);

        $fileJawaban = UploadedFile::fake()->create('jawaban.pdf', 100);

        $response = $this->put("/admin/pengajuan/{$permohonan->id}/status", [
            'status' => 'DITERIMA',
            'catatan_admin' => 'Data disetujui silakan unduh berkas',
            'file_jawaban' => $fileJawaban,
        ]);

        $response->assertRedirect();
        $response->assertSessionHasNoErrors();

        $this->assertDatabaseHas('pengajuans', [
            'id' => $permohonan->id,
            'status' => 'DITERIMA',
            'catatan_admin' => 'Data disetujui silakan unduh berkas',
        ]);

        $updated = Pengajuan::find($permohonan->id);
        Storage::disk('public')->assertExists($updated->file_jawaban);

        \Illuminate\Support\Facades\Mail::assertSent(\App\Mail\PengajuanStatusChangedMail::class, function (\App\Mail\PengajuanStatusChangedMail $mail) use ($user) {
            return $mail->hasTo($user->email) && $mail->pengajuan->status === 'DITERIMA';
        });

        $this->assertDatabaseHas('status_histories', [
            'pengajuan_id' => $permohonan->id,
            'status' => 'DITERIMA',
            'catatan' => 'Data disetujui silakan unduh berkas',
        ]);
    }

    public function test_admin_cannot_access_user_routes()
    {
        $admin = User::factory()->create([
            'nama_lengkap' => 'Admin PPID',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        // Access /layanan
        $response = $this->get(route('layanan.index'));
        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('error', 'Administrator tidak dapat mengakses halaman pemohon.');

        // Access /profile
        $response = $this->get(route('user.profile'));
        $response->assertRedirect(route('admin.dashboard'));
        $response->assertSessionHas('error', 'Administrator tidak dapat mengakses halaman pemohon.');
    }

    public function test_admin_status_update_validation()
    {
        $admin = User::factory()->create([
            'nama_lengkap' => 'Admin PPID',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);

        $user = User::factory()->create([
            'nama_lengkap' => 'Rimba Jati Dwi Djatmiko',
            'email' => 'rimbamiko1@gmail.com',
        ]);

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

        $this->actingAs($admin);

        // 1. Changing to DITOLAK without catatan_admin should fail validation
        $response = $this->put("/admin/pengajuan/{$permohonan->id}/status", [
            'status' => 'DITOLAK',
            'catatan_admin' => '',
        ]);
        $response->assertSessionHasErrors('catatan_admin');

        // 2. Changing to DIPROSES without catatan_admin should succeed
        $response2 = $this->put("/admin/pengajuan/{$permohonan->id}/status", [
            'status' => 'DIPROSES',
            'catatan_admin' => '',
        ]);
        $response2->assertSessionHasNoErrors();
        $this->assertDatabaseHas('pengajuans', [
            'id' => $permohonan->id,
            'status' => 'DIPROSES',
            'catatan_admin' => null,
        ]);
    }

    public function test_admin_can_delete_pengajuan()
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'nama_lengkap' => 'Admin PPID',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);

        $user = User::factory()->create();

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

        $this->actingAs($admin);

        $response = $this->delete("/admin/pengajuan/{$permohonan->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('pengajuans', [
            'id' => $permohonan->id
        ]);
    }

    public function test_admin_can_bulk_delete_pengajuan()
    {
        Storage::fake('public');

        $admin = User::factory()->create([
            'nama_lengkap' => 'Admin PPID',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);

        $user = User::factory()->create();

        $p1 = Pengajuan::create([
            'user_id' => $user->id,
            'jenis_layanan' => 'Permohonan',
            'no_tiket' => 'REQ-1',
            'nama' => 'User One',
            'email' => 'one@gmail.com',
            'pekerjaan' => 'Mahasiswa',
            'kategori_pemohon' => 'Perorangan',
            'no_identitas' => '1234567890123456',
            'no_hp' => '081234567890',
            'alamat' => 'Alamat One',
            'info_diminta' => 'Rincian One',
            'tujuan_permohonan' => 'Tujuan One',
            'cara_memperoleh' => 'Email',
            'lampiran_identitas' => 'one.jpg',
            'status' => 'DIAJUKAN'
        ]);

        $p2 = Pengajuan::create([
            'user_id' => $user->id,
            'jenis_layanan' => 'Permohonan',
            'no_tiket' => 'REQ-2',
            'nama' => 'User Two',
            'email' => 'two@gmail.com',
            'pekerjaan' => 'Mahasiswa',
            'kategori_pemohon' => 'Perorangan',
            'no_identitas' => '1234567890123456',
            'no_hp' => '081234567890',
            'alamat' => 'Alamat Two',
            'info_diminta' => 'Rincian Two',
            'tujuan_permohonan' => 'Tujuan Two',
            'cara_memperoleh' => 'Email',
            'lampiran_identitas' => 'two.jpg',
            'status' => 'DIAJUKAN'
        ]);

        $this->actingAs($admin);

        $response = $this->delete("/admin/pengajuan/bulk-delete", [
            'ids' => [$p1->id, $p2->id]
        ]);

        $response->assertRedirect();
        $this->assertDatabaseMissing('pengajuans', [
            'id' => $p1->id
        ]);
        $this->assertDatabaseMissing('pengajuans', [
            'id' => $p2->id
        ]);
    }

    public function test_admin_can_filter_pengajuan_by_status()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $p1 = Pengajuan::create([
            'user_id' => $user->id, 'jenis_layanan' => 'Permohonan', 'no_tiket' => 'T-1',
            'nama' => 'User One', 'email' => 'one@gmail.com', 'pekerjaan' => 'Mahasiswa', 'kategori_pemohon' => 'Perorangan',
            'no_identitas' => '1234567890123456', 'no_hp' => '081234567890', 'alamat' => 'Alamat',
            'info_diminta' => 'Minta info', 'tujuan_permohonan' => 'Tujuan', 'cara_memperoleh' => 'Email', 'status' => 'DIAJUKAN',
            'lampiran_identitas' => 'temp.jpg'
        ]);

        $p2 = Pengajuan::create([
            'user_id' => $user->id, 'jenis_layanan' => 'Permohonan', 'no_tiket' => 'T-2',
            'nama' => 'User Two', 'email' => 'two@gmail.com', 'pekerjaan' => 'Mahasiswa', 'kategori_pemohon' => 'Perorangan',
            'no_identitas' => '1234567890123456', 'no_hp' => '081234567890', 'alamat' => 'Alamat',
            'info_diminta' => 'Minta info', 'tujuan_permohonan' => 'Tujuan', 'cara_memperoleh' => 'Email', 'status' => 'DIPROSES',
            'lampiran_identitas' => 'temp.jpg'
        ]);

        $this->actingAs($admin);

        $response = $this->get('/admin/pengajuan?status=DIPROSES');
        $response->assertStatus(200);
        $response->assertViewHas('permohonans');

        $permohonans = $response->original->getData()['permohonans'];
        $this->assertTrue($permohonans->contains($p2));
        $this->assertFalse($permohonans->contains($p1));
    }

    public function test_admin_can_filter_pengajuan_by_jenis_layanan()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $p1 = Pengajuan::create([
            'user_id' => $user->id, 'jenis_layanan' => 'Permohonan', 'no_tiket' => 'T-1',
            'nama' => 'User One', 'email' => 'one@gmail.com', 'pekerjaan' => 'Mahasiswa', 'kategori_pemohon' => 'Perorangan',
            'no_identitas' => '1234567890123456', 'no_hp' => '081234567890', 'alamat' => 'Alamat',
            'info_diminta' => 'Minta info', 'tujuan_permohonan' => 'Tujuan', 'cara_memperoleh' => 'Email', 'status' => 'DIAJUKAN',
            'lampiran_identitas' => 'temp.jpg'
        ]);

        $p2 = Pengajuan::create([
            'user_id' => $user->id, 'jenis_layanan' => 'Keberatan', 'no_tiket' => 'T-2',
            'nama' => 'User Two', 'email' => 'two@gmail.com', 'pekerjaan' => 'Mahasiswa', 'kategori_pemohon' => 'Perorangan',
            'no_identitas' => '1234567890123456', 'no_hp' => '081234567890', 'alamat' => 'Alamat',
            'tujuan_keberatan' => 'Tujuan keberatan', 'alasan_keberatan' => 'Alasan keberatan', 'status' => 'DIAJUKAN',
            'lampiran_identitas' => 'temp.jpg'
        ]);

        $this->actingAs($admin);

        $response = $this->get('/admin/pengajuan?jenis_layanan=Keberatan');
        $response->assertStatus(200);

        $permohonans = $response->original->getData()['permohonans'];
        $this->assertTrue($permohonans->contains($p2));
        $this->assertFalse($permohonans->contains($p1));
    }

    public function test_admin_can_search_pengajuan_by_keyword()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $p1 = Pengajuan::create([
            'user_id' => $user->id, 'jenis_layanan' => 'Permohonan', 'no_tiket' => 'TIKET-XYZ',
            'nama' => 'Budi Santoso', 'email' => 'budi@gmail.com', 'pekerjaan' => 'Mahasiswa', 'kategori_pemohon' => 'Perorangan',
            'no_identitas' => '1234567890123456', 'no_hp' => '081234567890', 'alamat' => 'Alamat',
            'info_diminta' => 'Minta dokumen Rektorat', 'tujuan_permohonan' => 'Tujuan', 'cara_memperoleh' => 'Email', 'status' => 'DIAJUKAN',
            'lampiran_identitas' => 'temp.jpg'
        ]);

        $p2 = Pengajuan::create([
            'user_id' => $user->id, 'jenis_layanan' => 'Permohonan', 'no_tiket' => 'TIKET-ABC',
            'nama' => 'Ani Wijaya', 'email' => 'ani@gmail.com', 'pekerjaan' => 'Mahasiswa', 'kategori_pemohon' => 'Perorangan',
            'no_identitas' => '1234567890123456', 'no_hp' => '081234567890', 'alamat' => 'Alamat',
            'info_diminta' => 'Minta jadwal kuliah', 'tujuan_permohonan' => 'Tujuan', 'cara_memperoleh' => 'Email', 'status' => 'DIAJUKAN',
            'lampiran_identitas' => 'temp.jpg'
        ]);

        $this->actingAs($admin);

        // Cari dengan kata kunci "Budi"
        $response = $this->get('/admin/pengajuan?search=Budi');
        $response->assertStatus(200);
        $permohonans = $response->original->getData()['permohonans'];
        $this->assertTrue($permohonans->contains($p1));
        $this->assertFalse($permohonans->contains($p2));

        // Cari dengan tiket "XYZ"
        $response2 = $this->get('/admin/pengajuan?search=XYZ');
        $response2->assertStatus(200);
        $permohonans2 = $response2->original->getData()['permohonans'];
        $this->assertTrue($permohonans2->contains($p1));
        $this->assertFalse($permohonans2->contains($p2));
    }

    public function test_user_can_filter_and_search_own_pengajuan()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $p1 = Pengajuan::create([
            'user_id' => $user->id,
            'jenis_layanan' => 'Permohonan',
            'no_tiket' => 'TIKET-PEMOHON-1',
            'nama' => $user->nama_lengkap,
            'email' => $user->email,
            'pekerjaan' => 'Mahasiswa',
            'kategori_pemohon' => 'Perorangan',
            'no_identitas' => '1234567890123456',
            'no_hp' => '081234567890',
            'alamat' => 'Bandar Lampung',
            'info_diminta' => 'Data Anggaran FMIPA',
            'tujuan_permohonan' => 'Riset',
            'cara_memperoleh' => 'Email',
            'lampiran_identitas' => 'temp.jpg',
            'status' => 'DIAJUKAN'
        ]);

        $p2 = Pengajuan::create([
            'user_id' => $user->id,
            'jenis_layanan' => 'Keberatan',
            'no_tiket' => 'TIKET-PEMOHON-2',
            'nama' => $user->nama_lengkap,
            'email' => $user->email,
            'pekerjaan' => 'Mahasiswa',
            'kategori_pemohon' => 'Perorangan',
            'no_identitas' => '1234567890123456',
            'no_hp' => '081234567890',
            'alamat' => 'Bandar Lampung',
            'tujuan_keberatan' => 'Keberatan Biaya',
            'alasan_keberatan' => 'Informasi tidak disediakan',
            'lampiran_identitas' => 'temp.jpg',
            'status' => 'DIPROSES'
        ]);

        // Filter Jenis Layanan
        $res = $this->get('/layanan?jenis_layanan=Permohonan');
        $res->assertStatus(200);
        $items = $res->original->getData()['pengajuans'];
        $this->assertTrue($items->contains($p1));
        $this->assertFalse($items->contains($p2));

        // Filter Status
        $resStatus = $this->get('/layanan?status=DIPROSES');
        $resStatus->assertStatus(200);
        $itemsStatus = $resStatus->original->getData()['pengajuans'];
        $this->assertFalse($itemsStatus->contains($p1));
        $this->assertTrue($itemsStatus->contains($p2));

        // Search
        $resSearch = $this->get('/layanan?search=Anggaran');
        $resSearch->assertStatus(200);
        $itemsSearch = $resSearch->original->getData()['pengajuans'];
        $this->assertTrue($itemsSearch->contains($p1));
        $this->assertFalse($itemsSearch->contains($p2));
    }

    public function test_admin_can_update_status_to_perbaikan_with_mandatory_catatan()
    {
        Storage::fake('public');
        \Illuminate\Support\Facades\Mail::fake();

        $admin = User::factory()->create(['role' => 'admin']);
        $user = User::factory()->create();

        $permohonan = Pengajuan::create([
            'user_id' => $user->id,
            'jenis_layanan' => 'Permohonan',
            'no_tiket' => 'REQ-PERBAIKAN-1',
            'nama' => 'User Perbaikan',
            'email' => 'userperbaikan@gmail.com',
            'pekerjaan' => 'Mahasiswa',
            'kategori_pemohon' => 'Perorangan',
            'no_identitas' => '1234567890123456',
            'no_hp' => '081234567890',
            'alamat' => 'Bandar Lampung',
            'info_diminta' => 'Data Informasi',
            'tujuan_permohonan' => 'Riset',
            'cara_memperoleh' => 'Email',
            'lampiran_identitas' => 'temp.jpg',
            'status' => 'DIPROSES'
        ]);

        $this->actingAs($admin);

        // Update to PERBAIKAN without catatan should fail
        $failResponse = $this->put("/admin/pengajuan/{$permohonan->id}/status", [
            'status' => 'PERBAIKAN',
            'catatan_admin' => '',
        ]);
        $failResponse->assertSessionHasErrors('catatan_admin');

        // Update to PERBAIKAN with catatan should succeed
        $successResponse = $this->put("/admin/pengajuan/{$permohonan->id}/status", [
            'status' => 'PERBAIKAN',
            'catatan_admin' => 'Nama pada form tidak sesuai dengan foto KTP.',
        ]);
        $successResponse->assertSessionHasNoErrors();
        $this->assertDatabaseHas('pengajuans', [
            'id' => $permohonan->id,
            'status' => 'PERBAIKAN',
            'catatan_admin' => 'Nama pada form tidak sesuai dengan foto KTP.',
        ]);
    }

    public function test_user_can_update_permohonan_when_status_is_perbaikan()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $permohonan = Pengajuan::create([
            'user_id' => $user->id,
            'jenis_layanan' => 'Permohonan',
            'no_tiket' => 'REQ-PERBAIKAN-2',
            'nama' => 'User Perbaikan 2',
            'email' => 'user2@gmail.com',
            'pekerjaan' => 'Mahasiswa',
            'kategori_pemohon' => 'Perorangan',
            'no_identitas' => '1234567890123456',
            'no_hp' => '081234567890',
            'alamat' => 'Bandar Lampung',
            'info_diminta' => 'Data Kurikulum Lama',
            'tujuan_permohonan' => 'Tugas',
            'cara_memperoleh' => 'Melalui Email atau Website',
            'lampiran_identitas' => 'temp.jpg',
            'status' => 'PERBAIKAN',
            'catatan_admin' => 'Tolong perbarui rincian informasi.',
        ]);

        $response = $this->put(route('layanan.update', $permohonan->id), [
            'pekerjaan' => 'Mahasiswa',
            'kategori_pemohon' => 'Perorangan',
            'no_identitas' => '1234567890123456',
            'telepon' => '081234567890',
            'alamat' => 'Bandar Lampung',
            'info_diminta' => 'Data Kurikulum Terbaru 2026',
            'tujuan' => 'Tugas Akhir Spesifik',
            'cara_ambil' => 'Melalui Email atau Website',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('pengajuans', [
            'id' => $permohonan->id,
            'info_diminta' => 'Data Kurikulum Terbaru 2026',
            'status' => 'DIAJUKAN',
        ]);
    }
}
