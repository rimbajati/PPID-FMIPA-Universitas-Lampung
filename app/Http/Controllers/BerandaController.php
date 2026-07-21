<?php

namespace App\Http\Controllers;

use App\Models\Beranda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;

class BerandaController extends Controller
{
    /**
     * Memastikan tabel database `berandas` tersedia secara otomatis
     */
    private function ensureTableExists()
    {
        if (!Schema::hasTable('berandas')) {
            try {
                Artisan::call('migrate', ['--force' => true]);
            } catch (\Throwable $e) {
                Schema::create('berandas', function (Blueprint $table) {
                    $table->id();
                    $table->string('hero_tagline')->nullable();
                    $table->string('hero_judul_1')->nullable();
                    $table->string('hero_judul_2')->nullable();
                    $table->string('hero_subjudul')->nullable();
                    $table->string('hero_search_placeholder')->nullable();
                    $table->text('hero_cta_user_text')->nullable();
                    $table->string('alur_judul')->nullable();
                    $table->text('alur_subjudul')->nullable();
                    $table->json('alur_steps')->nullable();
                    $table->string('stats_tagline')->nullable();
                    $table->string('stats_judul')->nullable();
                    $table->text('stats_deskripsi')->nullable();
                    $table->timestamps();
                });
            }
        }
    }

    /**
     * Tampilkan halaman form edit Beranda untuk Admin
     */
    public function edit()
    {
        $this->ensureTableExists();
        $beranda = Beranda::getData();
        return view('admin.kelola_konten.beranda.edit', compact('beranda'));
    }

    /**
     * Simpan pembaruan konten Beranda oleh Admin
     */
    public function update(Request $request)
    {
        $this->ensureTableExists();

        $request->validate([
            'hero_tagline' => 'required|string|max:255',
            'hero_judul_1' => 'required|string|max:255',
            'hero_judul_2' => 'nullable|string|max:255',
            'hero_subjudul' => 'nullable|string|max:255',
            'alur_judul' => 'required|string|max:255',
            'stats_judul' => 'required|string|max:255',
        ]);

        // Process Alur Steps JSON
        $alurSteps = [];
        if ($request->has('alur_steps') && is_array($request->alur_steps)) {
            foreach ($request->alur_steps as $item) {
                if (!empty($item['title'])) {
                    $alurSteps[] = [
                        'icon' => $item['icon'] ?? 'fa-file-lines',
                        'title' => $item['title'],
                        'desc' => $item['desc'] ?? '',
                    ];
                }
            }
        }

        // Save to DB
        $beranda = Beranda::first() ?? new Beranda();
        $beranda->hero_tagline = $request->hero_tagline;
        $beranda->hero_judul_1 = $request->hero_judul_1;
        $beranda->hero_judul_2 = $request->hero_judul_2;
        $beranda->hero_subjudul = $request->hero_subjudul;
        $beranda->hero_search_placeholder = $request->hero_search_placeholder;
        $beranda->hero_cta_user_text = $request->hero_cta_user_text;
        
        $beranda->alur_judul = $request->alur_judul;
        $beranda->alur_subjudul = $request->alur_subjudul;
        $beranda->alur_steps = $alurSteps;

        $beranda->stats_tagline = $request->stats_tagline;
        $beranda->stats_judul = $request->stats_judul;
        $beranda->stats_deskripsi = $request->stats_deskripsi;
        $beranda->save();

        return redirect()->back()->with('success', 'Konten Beranda Utama berhasil diperbarui!');
    }
}
