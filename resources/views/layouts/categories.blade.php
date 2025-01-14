@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Categories</h1>
        </div>

        <div class="section-body">
            <button class="btn btn-primary mb-3" id="createCategoryButton">Create Category</button>
            <div class="table-responsive">
                <table class="table table-striped" id="categoryTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
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
        <form id="createForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createModalLabel">Create Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="createName">Name</label>
                        <input type="text" id="createName" class="form-control" required>
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
                    <h5 class="modal-title" id="editModalLabel">Edit Category</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="editCategoryId">
                    <div class="form-group">
                        <label for="editName">Name</label>
                        <input type="text" id="editName" class="form-control" required>
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

        fetchCategories();

        // Fetch all categories and populate the table
        function fetchCategories() {
            $.ajax({
                url: '/categories/fetch',
                method: 'GET',
                success: function (response) {
                    let rows = '';
                    response.data.forEach((category, index) => {
                        rows += `
                            <tr>
                                <td>${index + 1}</td>
                                <td>${category.name}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm editCategory" data-id="${category.id}" data-name="${category.name}">Edit</button>
                                    <button class="btn btn-danger btn-sm deleteCategory" data-id="${category.id}">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                    $('#categoryTable tbody').html(rows);
                },
            });
        }

        // Show Create Modal
        $('#createCategoryButton').click(function () {
            $('#createForm')[0].reset();
            $('#createModal').modal('show');
        });

        // Handle Create Form Submission
        $('#createForm').submit(function (e) {
            e.preventDefault();

            const name = $('#createName').val();

            $.ajax({
                url: '/categories',
                method: 'POST',
                data: { name },
                success: function (response) {
                    alert('Category created successfully');
                    $('#createModal').modal('hide');
                    fetchCategories();
                },
                error: function (xhr) {
                    alert('Error creating category');
                }
            });
        });

        // Show modal for editing
        $(document).on('click', '.editCategory', function () {
            const id = $(this).data('id');
            const name = $(this).data('name');

            $('#editCategoryId').val(id);
            $('#editName').val(name);

            $('#editModal').modal('show');
        });

        // Handle edit form submission
        $('#editForm').submit(function (e) {
            e.preventDefault();

            const id = $('#editCategoryId').val();
            const name = $('#editName').val();

            $.ajax({
                url: `/categories/${id}`,
                method: 'PUT',
                data: { name },
                success: function (response) {
                    alert(response.message);
                    $('#editModal').modal('hide');
                    fetchCategories();
                },
                error: function (xhr) {
                    alert('Error updating category');
                }
            });
        });

        // Handle delete button click
        $(document).on('click', '.deleteCategory', function () {
            const id = $(this).data('id');

            if (confirm('Are you sure you want to delete this category?')) {
                $.ajax({
                    url: `/categories/${id}`,
                    method: 'DELETE',
                    success: function (response) {
                        alert(response.message);
                        fetchCategories();
                    },
                    error: function (xhr) {
                        alert('Error deleting category');
                    }
                });
            }
        });
    });
</script>
@endpush
