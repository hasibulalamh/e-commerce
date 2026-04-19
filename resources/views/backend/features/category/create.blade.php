@extends('backend.master')
@section('content')
<div class="content-page">
    <div class="content">
        <!-- Start Content-->
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-12">
                    <a href="{{ route('category.list') }}" class="btn btn-secondary float-end">
                        <i class="fas fa-list"></i> View Categories
                    </a>
                </div>
            </div>

            <div class="container mt-5">
                <h2 class="mb-4">Create New Category</h2>

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Category Name -->
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <input name="name" type="text" class="form-control" id="categoryName"
                                    placeholder="Enter category name" required />
                            </div>

                            <!-- Category Description -->
                            <div class="mb-3">
                                <label for="categoryDescription" class="form-label">Description</label>
                                <textarea name="description" class="form-control" id="categoryDescription" rows="3"
                                    placeholder="Enter category description" required></textarea>
                            </div>

                            <!-- Category Image -->
                            <div class="mb-3">
                                <label for="categoryImage" class="form-label">Category Image</label>
                                <input name="image" class="form-control" type="file" id="categoryImage"
                                    accept="image/*" />
                                <img id="imagePreview" src="#" alt="Preview Image" class="mt-2 img-thumbnail d-none"
                                    style="width: 100px; height: 100px;">
                            </div>

                            <!-- Display Order -->
                            <div class="mb-3">
                                <label for="displayOrder" class="form-label">Display Order</label>
                                <input name="display_order" type="number" class="form-control" id="displayOrder"
                                    placeholder="Enter display order" required min="1" />
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <div class="form-check">
                                    <input name="status" class="form-check-input" type="radio" id="statusActive"
                                        value="active" checked />
                                    <label class="form-check-label" for="statusActive">
                                        Active
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input name="status" class="form-check-input" type="radio" id="statusInactive"
                                        value="inactive" />
                                    <label class="form-check-label" for="statusInactive">
                                        Inactive
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Create
                                Category</button>
                        </form>
                    </div>
                </div>

                <hr class="my-4">
                <div class="card border-success">
                    <div class="card-header bg-success text-white">
                        <h6 class="mb-0 text-white">
                            <i class="fas fa-file-excel"></i> Bulk Import Categories (CSV/Excel)
                        </h6>
                    </div>
                    <div class="card-body">
                        <p class="text-muted small mb-3">
                            Upload a CSV or Excel file to import multiple categories at once. <br>
                            <strong>Required columns:</strong> <code>name, description, display_order, status</code>
                        </p>
                        <form action="{{ route('category.import') }}" method="POST" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
                            @csrf
                            <input type="file" name="file" class="form-control" accept=".xlsx,.xls,.csv" style="max-width: 350px;" required>
                            <button type="submit" class="btn btn-success">
                                <i class="fas fa-upload"></i> Import Now
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<!-- Image Preview Script -->
<script>
    document.getElementById('categoryImage').addEventListener('change', function(event) {
        let reader = new FileReader();
        reader.onload = function() {
            let img = document.getElementById('imagePreview');
            img.src = reader.result;
            img.classList.remove('d-none');
        };
        reader.readAsDataURL(event.target.files[0]);
    });
</script>

@endsection