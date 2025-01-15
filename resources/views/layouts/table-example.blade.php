@extends('layouts.app')

@section('title', 'Books')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Books</h1>
        </div>

        <div class="section-body">
        <div class="d-flex mb-3">
    <button class="btn btn-primary mr-2" id="createBookButton">Create Book</button>
    <select id="filterKategori" class="form-control mr-2" style="width: 200px;">
        <option value="">All Categories</option>
    </select>
    <div class="input-group" style="width: 200px;">
        <input type="text" id="searchBook" class="form-control" placeholder="Search by Title">
        <div class="input-group-append">
            <span class="input-group-text">
                <i class="fa fa-search"></i>
            </span>
        </div>
    </div>
</div>
            <div class="table-responsive">
                <table class="table table-striped" id="bookTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Image</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<!-- Modal for Create -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <form id="createForm" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="createModalLabel">Create Book</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="createJudul">Judul</label>
                <input type="text" id="createJudul" name="judul" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="createPenulis">Penulis</label>
                <input type="text" id="createPenulis" name="penulis" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="createKategori">Kategori</label>
                <select id="createKategori" name="kategori_id" class="form-control" required>
                    <!-- Options akan diisi oleh JavaScript -->
                </select>
            </div>
            <div class="form-group">
                <label for="createImage">Image</label>
                <input type="file" id="createImage" name="image" class="form-control" required>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Create</button>
        </div>
    </div>
</form>
    </div>
</div>

<!-- Modal for Edit -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <form id="editForm" enctype="multipart/form-data">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="editModalLabel">Edit Book</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="editBookId" name="id"> <!-- Pastikan ada name="id" -->
            <div class="form-group">
                <label for="editJudul">Judul</label>
                <input type="text" id="editJudul" name="judul" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="editPenulis">Penulis</label>
                <input type="text" id="editPenulis" name="penulis" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="editKategori">Kategori</label>
                <select id="editKategori" name="kategori_id" class="form-control" required>
                    <!-- Options akan diisi oleh JavaScript -->
                </select>
            </div>
            <div class="form-group">
                <label for="editImage">Image</label>
                <input type="file" id="editImage" name="image" class="form-control">
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
    </div>
</form>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function () {
    // Setup CSRF Token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    fetchBooks();
    fetchCategories();

    function fetchBooks(categoryId = '', searchTerm = '') {
        $.ajax({
            url: '/books/fetch',
            method: 'GET',
            data: { category: categoryId, search: searchTerm },
            success: function (response) {
                let rows = '';
                response.data.forEach((book, index) => {
                    rows += `
                        <tr>
                            <td>${index + 1}</td>
                            <td>${book.judul}</td>
                            <td>${book.penulis}</td>
                            <td>
                                <img src="/${book.image}" alt="${book.judul}" style="width: 50px; height: 50px;">
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm editBook" data-id="${book.id}" data-judul="${book.judul}" data-penulis="${book.penulis}" data-kategori="${book.kategori_id}">Edit</button>
                                <button class="btn btn-danger btn-sm deleteBook" data-id="${book.id}">Delete</button>
                            </td>
                        </tr>
                    `;
                });
                $('#bookTable tbody').html(rows);
            },
        });
    }

    function fetchCategories() {
        $.ajax({
            url: '/categories/fetch',
            method: 'GET',
            success: function (response) {
                let options = '<option value="">All Categories</option>';
                response.data.forEach(category => {
                    options += `<option value="${category.id}">${category.name}</option>`;
                });
                $('#filterKategori').html(options);
                $('#createKategori').html(options);
                $('#editKategori').html(options);
            }
        });
    }

    $('#createBookButton').click(function () {
        $('#createForm')[0].reset();
        $('#createModal').modal('show');
    });

    $('#createForm').submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);

    Swal.fire({
        title: 'Processing...',
        text: 'Please wait',
        didOpen: () => {
            Swal.showLoading();
        },
        allowOutsideClick: false,
    });

    $.ajax({
        url: '/books',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            Swal.fire('Success!', 'Book created successfully', 'success');
            $('#createModal').modal('hide');
            fetchBooks();
        },
        error: function (xhr) {
            Swal.fire('Error!', 'Failed to create book. Check your input.', 'error');
            console.error(xhr.responseJSON);
        }
    });
});

    $(document).on('click', '.editBook', function () {
        const id = $(this).data('id');
        const judul = $(this).data('judul');
        const penulis = $(this).data('penulis');
        const kategori_id = $(this).data('kategori');

        $('#editBookId').val(id);
        $('#editJudul').val(judul);
        $('#editPenulis').val(penulis);
        $('#editKategori').val(kategori_id);

        $('#editModal').modal('show');
    });

    $('#editForm').submit(function (e) {
    e.preventDefault();
    let formData = new FormData(this);
    let id = $('#editBookId').val();

    formData.append('_method', 'PUT'); // Tambahkan metode PUT untuk Laravel

    Swal.fire({
        title: 'Processing...',
        text: 'Please wait',
        didOpen: () => {
            Swal.showLoading();
        },
        allowOutsideClick: false,
    });

    $.ajax({
        url: `/books/${id}`,
        method: 'POST', // Gunakan POST untuk mendukung FormData
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            Swal.fire('Success!', response.message, 'success');
            $('#editModal').modal('hide');
            fetchBooks();
        },
        error: function (xhr) {
            Swal.fire('Error!', 'Failed to update book. Check your input.', 'error');
            console.error(xhr.responseJSON); // Log error untuk debugging
        }
    });
});

    $(document).on('click', '.deleteBook', function () {
        const id = $(this).data('id');

        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this book!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Processing...',
                    text: 'Please wait',
                    didOpen: () => {
                        Swal.showLoading();
                    },
                    allowOutsideClick: false,
                });

                $.ajax({
                    url: `/books/${id}`,
                    method: 'DELETE',
                    success: function (response) {
                        Swal.fire('Deleted!', response.message, 'success');
                        fetchBooks();
                    },
                    error: function () {
                        Swal.fire('Error!', 'Error deleting book', 'error');
                    }
                });
            }
        });
    });

    $('#filterKategori').change(function () {
        const categoryId = $(this).val();
        const searchTerm = $('#searchBook').val();
        fetchBooks(categoryId, searchTerm);
    });

    $('#searchBook').keyup(function () {
        const searchTerm = $(this).val();
        const categoryId = $('#filterKategori').val();
        fetchBooks(categoryId, searchTerm);
    });
});
</script>
@endpush
