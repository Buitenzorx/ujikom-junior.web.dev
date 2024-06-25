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
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $pegawai)
                <tr>
                    <th scope="row">{{ $loop->iteration }}</th>
                    <td>{{ $pegawai->name }}</td>
                    <td>{{ $pegawai->email }}</td>
                    <td>{{ $pegawai->created_at->format('d M Y, H:i:s') }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $pegawai->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="deletePegawai({{ $pegawai->id }})">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>

                <!-- Edit Modal -->
                <div class="modal fade" id="editModal{{ $pegawai->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Pegawai</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editForm{{ $pegawai->id }}">
                                    <div class="mb-3">
                                        <label for="editName{{ $pegawai->id }}" class="form-label">Nama Pegawai</label>
                                        <input type="text" class="form-control" id="editName{{ $pegawai->id }}"
                                            name="name" value="{{ $pegawai->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editEmail{{ $pegawai->id }}" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="editEmail{{ $pegawai->id }}"
                                            name="email" value="{{ $pegawai->email }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editPhoneNumber{{ $pegawai->id }}" class="form-label">Nomer HP</label>
                                        <input type="text" class="form-control" id="editPhoneNumber{{ $pegawai->id }}"
                                            name="phone_number" value="{{ $pegawai->phone_number }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="editAlamat{{ $pegawai->id }}" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="editAlamat{{ $pegawai->id }}" rows="3" name="alamat">{{ $pegawai->alamat }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="editAvatar{{ $pegawai->id }}" class="form-label">Foto</label>
                                        <input class="form-control" type="file" id="editAvatar{{ $pegawai->id }}"
                                            name="avatar">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Batal</button>
                                        <button type="button" class="btn btn-primary"
                                            onclick="updatePegawai({{ $pegawai->id }})">Simpan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>

    <!-- Add Modal -->
    <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Pegawai</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addForm">
                        <div class="mb-3">
                            <label for="addName" class="form-label">Nama Pegawai</label>
                            <input type="text" class="form-control" id="addName" name="name" required>
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
                            <input type="text" class="form-control" id="addPhoneNumber" name="phone_number">
                        </div>
                        <div class="mb-3">
                            <label for="addAlamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="addAlamat" rows="3" name="alamat"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="addAvatar" class="form-label">Foto</label>
                            <input class="form-control" type="file" id="addAvatar" name="avatar">
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-primary" onclick="createUser()">Tambah</button>
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
            const url = "{{ route('api.pegawai.store') }}";
            let formData = new FormData();
            formData.append('name', $('#addName').val());
            formData.append('email', $('#addEmail').val());
            formData.append('phone_number', $('#addPhoneNumber').val());
            formData.append('password', $('#addPassword').val());
            formData.append('alamat', $('#addAlamat').val());
            formData.append('avatar', $('#addAvatar').prop('files')[0]);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    toastr.success(response.message, 'Sukses');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                },
                error: function(error) {
                    let response = error.responseJSON;
                    toastr.error(response.message, 'Error');
                    if (response.errors) {
                        for (const error in response.errors) {
                            let input = $('#addForm input[name="' + error + '"]');
                            input.addClass('is-invalid');
                            let feedbackElement = '<div class="invalid-feedback">';
                            feedbackElement += '<ul class="list-unstyled">';
                            response.errors[error].forEach((message) => {
                                feedbackElement += '<li>' + message + '</li>';
                            });
                            feedbackElement += '</ul></div>';
                            input.after(feedbackElement);
                        }
                    }
                }
            });
        }

        function deletePegawai(id) {
            const url = "{{ route('api.pegawai.destroy', ':id') }}".replace(':id', id);
            if (confirm('Apakah anda yakin ingin menghapus pegawai ini?')) {
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        toastr.success(response.message, 'Sukses');
                        setTimeout(() => {
                            location.reload();
                        }, 1000);
                    },
                    error: function(error) {
                        let response = error.responseJSON;
                        toastr.error(response.message, 'Error');
                    }
                });
            }
        }

        function updatePegawai(id) {
            const url = "{{ route('api.pegawai.update', ':id') }}".replace(':id', id);
            let formData = new FormData();
            formData.append('name', $('#editName' + id).val());
            formData.append('email', $('#editEmail' + id).val());
            formData.append('phone_number', $('#editPhoneNumber' + id).val());
            formData.append('alamat', $('#editAlamat' + id).val());
            formData.append('avatar', $('#editAvatar' + id).prop('files')[0]);

            $.ajax({
                url: url,
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    toastr.success(response.message, 'Sukses');
                    setTimeout(() => {
                        location.reload();
                    }, 1000);
                },
                error: function(error) {
                    let response = error.responseJSON;
                    toastr.error(response.message, 'Error');
                    if (response.errors) {
                        for (const error in response.errors) {
                            let input = $('#editForm' + id + ' input[name="' + error + '"]');
                            input.addClass('is-invalid');
                            let feedbackElement = '<div class="invalid-feedback">';
                            feedbackElement += '<ul class="list-unstyled">';
                            response.errors[error].forEach((message) => {
                                feedbackElement += '<li>' + message + '</li>';
                            });
                            feedbackElement += '</ul></div>';
                            input.after(feedbackElement);
                        }
                    }
                }
            });
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
