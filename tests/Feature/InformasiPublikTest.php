<?php

namespace Tests\Feature;

use App\Models\InformasiPublik;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InformasiPublikTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
    }

    public function test_public_user_can_view_informasi_publik_page()
    {
        InformasiPublik::create([
            'judul_informasi' => 'Test Judul',
            'deskripsi_informasi' => 'Test Deskripsi',
            'kategori_informasi' => 'Informasi Setiap Saat',
            'tahun_terbit' => '2025',
            'jenis_informasi' => 'link',
            'link_informasi' => 'https://example.com'
        ]);

        $response = $this->get('/informasi-publik');

        $response->assertStatus(200);
        $response->assertSee('Test Judul');
    }

    public function test_admin_can_access_admin_informasi_publik_index()
    {
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $response = $this->actingAs($admin)->get('/admin/informasi-publik');

        $response->assertStatus(200);
    }

    public function test_admin_store_validation_errors()
    {
        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $response = $this->actingAs($admin)->post('/admin/informasi-publik', [], [
            'Accept' => 'application/json'
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'judul_informasi',
            'deskripsi_informasi',
            'tahun_terbit',
            'kategori_informasi',
            'jenis_informasi'
        ]);
    }

    public function test_admin_can_store_informasi_publik_with_file()
    {
        Storage::fake('local');

        $admin = User::factory()->create([
            'role' => 'admin'
        ]);

        $file = UploadedFile::fake()->create('dokumen.pdf', 100, 'application/pdf');

        $response = $this->actingAs($admin)->post('/admin/informasi-publik', [
            'judul_informasi' => 'Dokumen Baru',
            'deskripsi_informasi' => 'Deskripsi Dokumen Baru',
            'kategori_informasi' => 'Informasi Setiap Saat',
            'tahun_terbit' => '2025',
            'jenis_informasi' => 'file',
            'file_informasi' => $file,
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('informasi_publik', [
            'judul_informasi' => 'Dokumen Baru',
            'deskripsi_informasi' => 'Deskripsi Dokumen Baru',
            'kategori_informasi' => 'Informasi Setiap Saat',
            'tahun_terbit' => '2025',
            'jenis_informasi' => 'file',
        ]);

        $info = InformasiPublik::first();
        Storage::disk('local')->assertExists($info->file_informasi);
    }
}
