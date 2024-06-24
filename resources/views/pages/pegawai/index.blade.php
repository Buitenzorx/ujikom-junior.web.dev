@extends('layouts.dashboard')

@section('content')
    <div class="d-flex align-items-center justify-content-between">
        <h3>Pegawai</h3>
        <button class="btn btn-primary sm" data-bs-toggle="modal" data-bs-target="#addModal">
            <i class="fas fa-plus">Tambah Pegawai</i>
        </button>
    </div>

    <table id="table-pegawai" class="table table-striped" style="width: 100%">
        <thead class="table-dark">
            <tr>
                <th scope="col">No</th>
                <th scope="col">Foto</th>
                <th scope="col">Nama</th>
                <th scope="col">Email</th>
                <th scope="col">No Hp</th>
                <th scope="col">Alamat</th>
                <th scope="col">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $pegawai)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>
                        @if ($pegawai->avatar == null)
                            <span class="badge bg-danger"> Tidak Ada Foto</span>
                        @else
                        @endif
                        <img class="img-thumbnail" src="{{ asset('storage/' . $pegawai->foto) }} "
                            alt="{{ $pegawai->nama }}" width="50">
                    </td>
                    <td>{{ $pegawai->name }}</td>
                    <td>{{ $pegawai->email }}</td>
                    <td>{{ $pegawai->no_hp }}</td>
                    <td>{{ $pegawai->alamat }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="addName" class="form-label">Nama Pegawai</label>
                            <input type="name" class="form-control" id="addName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="addEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="addEmail" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="addPassword" class="form-label">Password</label>
                            <input type="password" class="form-control" id="addPassword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="addPhoneNumber" class="form-label">Nomer HP</label>
                            <input type="phone_number" class="form-control" id="addPhoneNumber" name="phone_number">
                        </div>
                        <div class="mb-3">
                            <label for="addAlamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="addAlamat" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="addAvatar" class="form-label">Foto</label>
                            <input class="form-control" type="file" id="addAvatar" name="avatar">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script>
        function createUser() {
            const url = "{{ route('api.users.store') }}";
            let data = {
                name: $('#addName').val(),
                email: $('#addEmail').val(),
                phone_number: $('#addPhoneNumber').val(),
                password: $('#addPassword').val(),
                alamat: $('#addPassword').val(),
                avatar: $('#addAvatar').prop('files')[0]
            }
            $.post(url, data)
                .data(response) => {
                    toastr.success(response.message, 'Sukses')
                    setTimeout(() => {
                        location.reload()
                    }, 1000);
                };
            .fail((error)) => {
                let response = error.responseJSON
                toastr.error(response.message, 'Error')
                if (response.errors) {
                    for (const error in response.errors) {
                        let input = $('#addForm input[name="${error}"]')
                        input.addClass('is-invalid');
                        let feedbackElement = '<div class="invalid-feedback">'
                        feedbackElement += '<ul class="list-unstyled">'
                        response.errors[error].forEach((message)) => {
                            feedbackElement += '<ul'
                            feedbackElement += '</div'
                        }
                        input.after(feedbackElement)
                    }
                }
            }
        }
        $(document).ready(function() {
            new DataTable('#table-pegawai', {
                info: false,
                ordering: false,
                paging: false
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
@endsection
@push('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    
@endpush
