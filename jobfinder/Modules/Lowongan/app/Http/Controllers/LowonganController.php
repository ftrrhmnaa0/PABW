<?php

namespace Modules\Lowongan\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Lowongan\Models\Lowongan;
use Illuminate\Support\Facades\Auth;

class LowonganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private function adminOnly()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin');
        }
    }

    public function index()
    {
        $this->adminOnly();
        return view('lowongan::index');
    }

    public function data()
    {
        $this->adminOnly();
        return response()->json([
            'data' => Lowongan::all()
        ]);
    }

    public function store(Request $request)
    {
        $this->adminOnly();

        Lowongan::updateOrCreate(
            ['id' => $request->id],
            [
                'posisi' => $request->posisi,
                'perusahaan' => $request->perusahaan,
                'lokasi_kerja' => $request->lokasi_kerja,
                'deskripsi' => $request->deskripsi,
                'gaji' => $request->gaji
            ]
        );

        return response()->json(['success' => true]);
    }

    public function edit($id)
    {
        $this->adminOnly();
        return response()->json(Lowongan::findOrFail($id));
    }

    public function destroy($id)
    {
        $this->adminOnly();
        Lowongan::destroy($id);
        return response()->json(['success' => true]);
    }
}