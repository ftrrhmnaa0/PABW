@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Pendaftaran</h3>
        </div>
        <div class="card-body">

            <!-- Tombol Tambah -->
            <button type="button"
                class="btn btn-primary mb-3"
                data-bs-toggle="modal"
                data-bs-target="#pendaftaranModal">
                <i class="fas fa-plus"></i> Tambah Data
            </button>

            <!-- Tabel -->
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="pendaftarantable">
                    <thead class="table-light">
                        <tr>
                            <th width="5%">No</th>
                            <th>Nama</th>
                            <th>Asal Sekolah</th>
                            <th>Prodi Tujuan</th>
                            <th width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- diisi AJAX -->
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="pendaftaranModal" tabindex="-1"
     aria-labelledby="pendaftaranModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="pendaftaranModalLabel">Form Pendaftaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="pendaftaranForm">
                    @csrf
                    <input type="hidden" id="id" name="id">

                    <div class="mb-3">
                        <label class="form-label">Nama <span class="text-danger">*</span></label>
                        <input type="text" id="nama" name="nama" class="form-control">
                        <div class="invalid-feedback" id="nama-error"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Asal Sekolah <span class="text-danger">*</span></label>
                        <input type="text" id="asal_sekolah" name="asal_sekolah" class="form-control">
                        <div class="invalid-feedback" id="asal_sekolah-error"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Prodi Tujuan <span class="text-danger">*</span></label>
                        <input type="text" id="prodi_tujuan" name="prodi_tujuan" class="form-control">
                        <div class="invalid-feedback" id="prodi_tujuan-error"></div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button class="btn btn-primary" id="saveBtn">
                    <span class="submit-text">Simpan</span>
                    <span class="spinner-border spinner-border-sm d-none"></span>
                </button>
            </div>

        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    loadData();

    function loadData() {
        $.get("{{ route('pendaftaran.data') }}", function (data) {
            let html = '';
            let no = 1;

            if (data.length > 0) {
                data.forEach(item => {
                    html += `
                        <tr>
                            <td>${no++}</td>
                            <td>${item.nama}</td>
                            <td>${item.asal_sekolah}</td>
                            <td>${item.prodi_tujuan}</td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-warning edit" data-id="${item.id}">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="btn btn-sm btn-danger delete" data-id="${item.id}">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>`;
                });
            } else {
                html = `<tr><td colspan="5" class="text-center">Tidak ada data</td></tr>`;
            }

            $('#pendaftarantable tbody').html(html);
        });
    }

    $('#saveBtn').click(function () {
        $.post("{{ route('pendaftaran.store') }}", $('#pendaftaranForm').serialize(), function () {
            bootstrap.Modal.getInstance(document.getElementById('pendaftaranModal')).hide();
            $('#pendaftaranForm')[0].reset();
            loadData();
        }).fail(xhr => {
            if (xhr.status === 422) {
                $.each(xhr.responseJSON.errors, (key, val) => {
                    $('#' + key).addClass('is-invalid');
                    $('#' + key + '-error').text(val[0]);
                });
            }
        });
    });

    $(document).on('click', '.edit', function () {
        const id = $(this).data('id');

        $.get('/pendaftaran/' + id + '/edit', function (data) {
            $('#id').val(data.id);
            $('#nama').val(data.nama);
            $('#asal_sekolah').val(data.asal_sekolah);
            $('#prodi_tujuan').val(data.prodi_tujuan);

            $('#pendaftaranModalLabel').text('Edit Pendaftaran');

            new bootstrap.Modal(
                document.getElementById('pendaftaranModal')
            ).show();
        });

    });


    $(document).on('click', '.delete', function () {
        if (!confirm('Hapus data ini?')) return;

        $.ajax({
            url: "{{ route('pendaftaran.index') }}/" + $(this).data('id'),
            type: 'DELETE',
            success: () => loadData()
        });
    });

});
</script>
@endpush
