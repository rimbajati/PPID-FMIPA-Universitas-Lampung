<?php

namespace App\Http\Controllers\Masyarakat;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Admin\KontenController as AdminKontenController;

class ProfilController extends Controller
{
    public function index()
    {
        $profil  = AdminKontenController::getProfil();
        $halaman = AdminKontenController::getHalamanProfil();
        return view('masyarakat.profil.index', compact('profil', 'halaman'));
    }
}
