@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Manajemen Lowongan</h4>
            <small class="text-muted">Kelola data lowongan pekerjaan</small>
        </div>
        <button class="btn btn-primary shadow-sm" id="btnTambah">
            <i class="bi bi-plus-circle"></i> Tambah Lowongan
        </button>
    </div>

    {{-- CARD --}}
    <div class="card shadow-sm border-0">
        <div class="card-body">

            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="5%">#</th>
                        <th>Posisi</th>
                        <th>Perusahaan</th>
                        <th>Lokasi</th>
                        <th width="15%" class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody id="tableLowongan">
                    {{-- Data AJAX --}}
                </tbody>
            </table>

        </div>
    </div>
</div>

<div class="modal fade" id="modalLowongan" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <form id="formLowongan">
                @csrf
                <input type="hidden" id="id">

                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">
                        <i class="bi bi-briefcase"></i> Form Lowongan
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Posisi</label>
                            <input type="text" id="posisi" class="form-control" placeholder="Contoh: Web Developer" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Perusahaan</label>
                            <input type="text" id="perusahaan" class="form-control" placeholder="Nama perusahaan" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Lokasi Kerja</label>
                            <input type="text" id="lokasi_kerja" class="form-control" placeholder="Bandung" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Gaji</label>
                            <input type="number" id="gaji" class="form-control" placeholder="Opsional">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Deskripsi</label>
                            <textarea id="deskripsi" class="form-control" rows="3" placeholder="Deskripsi singkat pekerjaan"></textarea>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button class="btn btn-primary">
                        <i class="bi bi-save"></i> Simpan
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
@endsection


@push('scripts')
<script>
$(document).ready(function () {

    loadData();

    function loadData() {
        $.get('/lowongan/data', function (res) {
            let html = '';
            $.each(res.data, function (i, v) {
                html += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${v.posisi}</td>
                        <td>${v.perusahaan}</td>
                        <td>${v.lokasi_kerja}</td>
                        <td>
                            <button class="btn btn-warning btn-sm btnEdit" data-id="${v.id}">
                                Edit
                            </button>
                            <button class="btn btn-danger btn-sm btnHapus" data-id="${v.id}">
                                Hapus
                            </button>
                        </td>
                    </tr>
                `;
            });
            $('#tableLowongan').html(html);
        });
    }

    // TOMBOL TAMBAH
    $('#btnTambah').click(function () {
        $('#formLowongan')[0].reset();
        $('#id').val('');
        $('#modalLowongan').modal('show');
    });

    // SIMPAN
    $('#formLowongan').submit(function (e) {
        e.preventDefault();

        $.post('/lowongan', {
            _token: $('meta[name="csrf-token"]').attr('content'),
            id: $('#id').val(),
            posisi: $('#posisi').val(),
            perusahaan: $('#perusahaan').val(),
            lokasi_kerja: $('#lokasi_kerja').val(),
            deskripsi: $('#deskripsi').val(),
            gaji: $('#gaji').val()
        }, function () {
            $('#modalLowongan').modal('hide');
            loadData();
        });
    });

    // EDIT
    $(document).on('click', '.btnEdit', function () {
        let id = $(this).data('id');

        $.get('/lowongan/' + id + '/edit', function (res) {
            $('#id').val(res.id);
            $('#posisi').val(res.posisi);
            $('#perusahaan').val(res.perusahaan);
            $('#lokasi_kerja').val(res.lokasi_kerja);
            $('#deskripsi').val(res.deskripsi);
            $('#gaji').val(res.gaji);
            $('#modalLowongan').modal('show');
        });
    });

    // HAPUS
    $(document).on('click', '.btnHapus', function () {
        let id = $(this).data('id');

        if (confirm('Yakin hapus data?')) {
            $.ajax({
                url: '/lowongan/' + id,
                type: 'DELETE',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                success: function () {
                    loadData();
                }
            });
        }
    });

});
</script>
@endpush
