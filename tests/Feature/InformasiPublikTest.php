<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\InformasiPublik;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InformasiPublikTest extends TestCase
{
    use RefreshDatabase;

    public function test_non_admin_cannot_access_informasi_publik_admin_index()
    {
        $user = User::factory()->create([
            'nama_lengkap' => 'Regular User',
            'email' => 'user@gmail.com',
            'role' => 'user',
        ]);

        $this->actingAs($user);

        $response = $this->get('/admin/informasi-publik');
        $response->assertRedirect('/');
    }

    public function test_admin_can_access_informasi_publik_admin_index()
    {
        $admin = User::factory()->create([
            'nama_lengkap' => 'Admin PPID',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $response = $this->get('/admin/informasi-publik');
        $response->assertOk();
    }

    public function test_ajax_store_validation_fails_and_returns_json_errors()
    {
        $admin = User::factory()->create([
            'nama_lengkap' => 'Admin PPID',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        // Submit empty form via Ajax
        $response = $this->post('/admin/informasi-publik', [], [
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'rincian_informasi',
            'sub_informasi',
            'kategori',
            'opsi_format'
        ]);
    }

    public function test_admin_can_store_informasi_publik_with_file()
    {
        Storage::fake('local');

        $admin = User::factory()->create([
            'nama_lengkap' => 'Admin PPID',
            'email' => 'admin@gmail.com',
            'role' => 'admin',
        ]);

        $this->actingAs($admin);

        $file = UploadedFile::fake()->create('dokumen.pdf', 500);

        $response = $this->post('/admin/informasi-publik', [
            'rincian_informasi' => 'baru',
            'rincian_informasi_baru' => 'Rincian Baru',
            'sub_informasi' => 'Sub Informasi Dokumen Baru',
            'kategori' => 'Informasi Tersedia Setiap Saat',
            'opsi_format' => 'file',
            'berkas' => $file,
        ]);

        $response->assertRedirect('/admin/informasi-publik');
        $this->assertDatabaseHas('informasi_publik', [
            'rincian_informasi' => 'Rincian Baru',
            'sub_informasi' => 'Sub Informasi Dokumen Baru',
            'kategori' => 'Informasi Tersedia Setiap Saat',
            'tipe_informasi' => 'pdf',
        ]);

        $info = InformasiPublik::first();
        Storage::disk('local')->assertExists($info->jalur_informasi);
    }
}
