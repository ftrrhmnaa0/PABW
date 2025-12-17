@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">
                @if(Auth::user()->role === 'admin')
                    Manajemen Lamaran Pelamar
                @else
                    Riwayat Lamaran Saya
                @endif
            </h4>
            <small class="text-muted">
                @if(Auth::user()->role === 'admin')
                    Admin dapat melihat dan menghapus semua lamaran
                @else
                    Daftar lamaran yang pernah Anda kirim
                @endif
            </small>
        </div>
    </div>

    {{-- CARD --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>

                        @if(Auth::user()->role === 'admin')
                            <th>Pelamar</th>
                        @endif

                        <th>Lowongan</th>
                        <th>Deskripsi</th>
                        <th>CV</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($lamarans as $i => $lamaran)
                        <tr>
                            <td>{{ $i + 1 }}</td>

                            @if(Auth::user()->role === 'admin')
                                <td>
                                    <span class="fw-semibold">
                                        {{ $lamaran->user->name }}
                                    </span><br>
                                    <small class="text-muted">
                                        {{ $lamaran->user->email }}
                                    </small>
                                </td>
                            @endif

                            <td>
                                <span class="badge bg-primary">
                                    {{ $lamaran->lowongan->posisi }}
                                </span>
                            </td>

                            <td>{{ $lamaran->deskripsi_lamaran }}</td>

                            <td>
                                @if($lamaran->cv_file)
                                    <a href="{{ asset('storage/'.$lamaran->cv_file) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-info">
                                        <i class="bi bi-file-earmark-text"></i> Lihat CV
                                    </a>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <button class="btn btn-sm btn-danger btnHapus"
                                        data-id="{{ $lamaran->id }}">
                                    <i class="bi bi-trash"></i> Hapus
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                Belum ada data lamaran
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

    {{-- FORM TAMBAH LAMARAN (PELAMAR SAJA) --}}
    @if(Auth::user()->role !== 'admin')
    <div class="card shadow-sm border-0 mt-4">
        <div class="card-body">

            <h5 class="fw-bold mb-3">Kirim Lamaran Baru</h5>

            <form id="formLamaran" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Lowongan</label>
                    <select name="lowongan_id" class="form-control" required>
                        <option value="">-- Pilih Lowongan --</option>
                        @foreach($lowongans as $l)
                            <option value="{{ $l->id }}">
                                {{ $l->posisi }} - {{ $l->perusahaan }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Deskripsi Lamaran</label>
                    <textarea name="deskripsi_lamaran"
                              class="form-control"
                              rows="3"
                              required></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Upload CV</label>
                    <input type="file"
                           name="cv_file"
                           class="form-control"
                           required>
                </div>

                <button class="btn btn-primary">
                    <i class="bi bi-send"></i> Kirim Lamaran
                </button>
            </form>

        </div>
    </div>
    @endif

</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {

    // HAPUS LAMARAN
    $('.btnHapus').click(function () {

        let id = $(this).data('id');

        if (confirm('Yakin hapus lamaran ini?')) {
            $.ajax({
                url: '/lamaran/' + id,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    location.reload();
                },
                error: function () {
                    alert('Gagal menghapus lamaran');
                }
            });
        }
    });

    // SUBMIT LAMARAN
    $('#formLamaran').submit(function (e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: '/lamaran',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function () {
                alert('Lamaran berhasil dikirim');
                location.reload();
            },
            error: function () {
                alert('Gagal upload lamaran');
            }
        });
    });

});
</script>
@endpush
