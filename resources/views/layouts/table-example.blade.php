@extends('layouts.app')

@section('title', 'Books')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Books</h1>
        </div>

        <div class="section-body">
            <button class="btn btn-primary mb-3" id="createBookButton">Create Book</button>
            <div class="table-responsive">
                <table class="table table-striped" id="bookTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Judul</th>
                            <th>Penulis</th>
                            <th>Kategori</th>
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
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel" aria-hidden="true" enctype="multipart/form-data">
    <div class="modal-dialog" role="document">
        <form id="createForm">
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
                        <input type="text" id="createJudul" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="createPenulis">Penulis</label>
                        <input type="text" id="createPenulis" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="createKategori">Kategori</label>
                        <select id="createKategori" class="form-control" required>
                            <!-- Options akan diisi oleh JavaScript -->
                        </select>
                    </div>
                    <div class="form-group">
    <label for="createImage">Image</label>
    <input type="file" id="createImage" class="form-control">
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
        <form id="editForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Book</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editBookId">
                    <div class="form-group">
                        <label for="editJudul">Judul</label>
                        <input type="text" id="editJudul" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editPenulis">Penulis</label>
                        <input type="text" id="editPenulis" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="editKategori">Kategori</label>
                        <select id="editKategori" class="form-control" required>
                            <!-- Options akan diisi oleh JavaScript -->
                        </select>
                    </div>
                    <div class="form-group">
    <label for="editImage">Image</label>
    <input type="file" id="editImage" class="form-control">
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        fetchBooks();
        fetchCategories();

        // Fetch all books and populate the table
        function fetchBooks() {
            $.ajax({
                url: '/books/fetch',
                method: 'GET',
                success: function (response) {
                    console.log(response); 
                    let rows = '';
                    response.data.forEach((book, index) => {
                        rows += `
    <tr>
        <td>${index + 1}</td>
        <td>${book.judul}</td>
        <td>${book.penulis}</td>
        <td>${book.kategori_id ? book.kategori_id : '-'}</td>
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

        // Fetch categories for dropdowns
        function fetchCategories() {
            $.ajax({
                url: '/categories/fetch', // Pastikan route ini ada
                method: 'GET',
                success: function (response) {
                    let options = '<option value="">Select Category</option>';
                    response.data.forEach(category => {
                        options += `<option value="${category.id}">${category.name}</option>`;
                    });
                    $('#createKategori').html(options);
                    $('#editKategori').html(options);
                }
            });
        }

        // Show Create Modal
        $('#createBookButton').click(function () {
            $('#createForm')[0].reset();
            $('#createModal').modal('show');
        });

        // Handle Create Form Submission
        $('#createForm').submit(function (e) {
    e.preventDefault();
    let formData = new FormData();
    formData.append('judul', $('#createJudul').val());
    formData.append('penulis', $('#createPenulis').val());
    formData.append('kategori_id', $('#createKategori').val());
    formData.append('image', $('#createImage')[0].files[0]);

    $.ajax({
        url: '/books',
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            alert('Book created successfully');
            $('#createModal').modal('hide');
            fetchBooks();
        },
        error: function (xhr) {
            alert('Error creating book');
        }
    });
});

    
        // Show modal for editing
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

        // Handle edit form submission
        $('#editForm').submit(function (e) {
    e.preventDefault();
    let id = $('#editBookId').val();
    let formData = new FormData();
    formData.append('judul', $('#editJudul').val());
    formData.append('penulis', $('#editPenulis').val());
    formData.append('kategori_id', $('#editKategori').val());
    formData.append('image', $('#editImage')[0].files[0]);

    $.ajax({
        url: `/books/${id}`,
        method: 'POST',
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
            alert(response.message);
            $('#editModal').modal('hide');
            fetchBooks();
        },
        error: function (xhr) {
            alert('Error updating book');
        }
    });
});

        // Handle delete button click
        $(document).on('click', '.deleteBook', function () {
            const id = $(this).data('id');

            if (confirm('Are you sure you want to delete this book?')) {
                $.ajax({
                    url: `/books/${id}`,
                    method: 'DELETE',
                    success: function (response) {
                        alert(response.message);
                        fetchBooks();
                    },
                    error: function (xhr) {
                        alert('Error deleting book');
                    }
                });
            }
        });
    });
</script>
@endpush
