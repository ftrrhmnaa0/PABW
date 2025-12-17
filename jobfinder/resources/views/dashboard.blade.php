@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- HEADER --}}
    <div class="mb-4">
        <h3 class="fw-bold">
            Selamat Datang, {{ Auth::user()->name }}
        </h3>
        <small class="text-muted">
            @if(Auth::user()->role === 'admin')
                Dashboard Admin JobFinder
            @else
                Dashboard Pelamar JobFinder
            @endif
        </small>
    </div>

    {{-- STATISTIK --}}
    <div class="row g-4 mb-4">

        {{-- ADMIN --}}
        @if(Auth::user()->role === 'admin')
            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Total Lowongan</h6>
                        <h3 class="fw-bold">
                            {{ \Modules\Lowongan\Models\Lowongan::count() }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Total Lamaran</h6>
                        <h3 class="fw-bold">
                            {{ \Modules\Lamaran\Models\Lamaran::count() }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Total Pengguna</h6>
                        <h3 class="fw-bold">
                            {{ \App\Models\User::count() }}
                        </h3>
                    </div>
                </div>
            </div>
        @endif

        {{-- PELAMAR --}}
        @if(Auth::user()->role !== 'admin')
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Total Lamaran Saya</h6>
                        <h3 class="fw-bold">
                            {{ \Modules\Lamaran\Models\Lamaran::where('user_id', Auth::id())->count() }}
                        </h3>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <h6 class="text-muted">Lowongan Tersedia</h6>
                        <h3 class="fw-bold">
                            {{ \Modules\Lowongan\Models\Lowongan::count() }}
                        </h3>
                    </div>
                </div>
            </div>
        @endif

    </div>

    {{-- AKSI CEPAT --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <h5 class="fw-bold mb-3">Aksi Cepat</h5>

            <div class="d-flex flex-wrap gap-2">

                @if(Auth::user()->role === 'admin')
                    <a href="/lowongan" class="btn btn-primary">
                        <i class="bi bi-briefcase"></i> Kelola Lowongan
                    </a>

                    <a href="/lamaran" class="btn btn-success">
                        <i class="bi bi-folder"></i> Kelola Lamaran
                    </a>
                @else
                    <a href="/lamaran" class="btn btn-primary">
                        <i class="bi bi-send"></i> Kirim / Lihat Lamaran
                    </a>

                    <a href="/lowongan" class="btn btn-outline-secondary">
                        <i class="bi bi-search"></i> Lihat Lowongan
                    </a>
                @endif

                <a href="/profile" class="btn btn-outline-dark">
                    <i class="bi bi-person"></i> Profil Saya
                </a>

            </div>

        </div>
    </div>

</div>
@endsection
