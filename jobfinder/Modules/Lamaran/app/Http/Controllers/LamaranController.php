<?php

namespace Modules\Lamaran\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Lamaran\Models\Lamaran;
use Modules\Lowongan\Models\Lowongan;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class LamaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
     public function index()
    {
        // ADMIN: lihat semua lamaran
        if (Auth::user()->role === 'admin') {
            $lamarans = Lamaran::with('lowongan','user')->get();
        }
        // PELAMAR: hanya miliknya
        else {
            $lamarans = Lamaran::where('user_id', Auth::id())
                ->with('lowongan')
                ->get();
        }

        $lowongans = Lowongan::all();

        return view('lamaran::index', compact('lamarans','lowongans'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('lamaran::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'lowongan_id' => 'required',
            'deskripsi_lamaran' => 'required',
            'cv_file' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg|max:2048'
        ]);

        $file = $request->file('cv_file');
        $path = $file->store('cv', 'public');

        Lamaran::create([
            'user_id' => Auth::id(),
            'lowongan_id' => $request->lowongan_id,
            'deskripsi_lamaran' => $request->deskripsi_lamaran,
            'cv_file' => $path
        ]);

        return response()->json(['message'=>'Lamaran berhasil dikirim']);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('lamaran::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('lamaran::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $lamaran = Lamaran::findOrFail($id);

        // ADMIN boleh hapus semua
        // PELAMAR hanya miliknya
        if (
            Auth::user()->role !== 'admin' &&
            $lamaran->user_id !== Auth::id()
        ) {
            abort(403);
        }

        Storage::disk('public')->delete($lamaran->cv_file);
        $lamaran->delete();

        return response()->json(['message' => 'Lamaran dihapus']);
    }

}

