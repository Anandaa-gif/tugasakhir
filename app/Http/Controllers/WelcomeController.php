<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {
        $bukus = Buku::latest()->take(12)->get(); // Ambil 12 buku terbaru
        return view('welcome', compact('bukus'));
    }
}
