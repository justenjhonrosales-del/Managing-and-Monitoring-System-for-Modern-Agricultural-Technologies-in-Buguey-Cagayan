@extends('rental.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-edit"></i> Edit Technology
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('rental.technologies.update', $technology) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="name" class="form-label">Technology Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                id="name" name="name" required value="{{ old('name', $technology->name) }}">
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                id="description" name="description" rows="4"
                                placeholder="Enter technology description...">{{ old('description', $technology->description) }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="image_path" class="form-label">Image URL</label>
                            <input type="url" class="form-control @error('image_path') is-invalid @enderror"
                                id="image_path" name="image_path" placeholder="https://example.com/image.jpg"
                                value="{{ old('image_path', $technology->image_path) }}">
                            @error('image_path')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="total_quantity" class="form-label">Total Quantity</label>
                            <input type="number" class="form-control @error('total_quantity') is-invalid @enderror"
                                id="total_quantity" name="total_quantity" min="1" required
                                value="{{ old('total_quantity', $technology->total_quantity) }}">
                            @error('total_quantity')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select @error('status') is-invalid @enderror"
                                id="status" name="status" required>
                                <option value="available" {{ old('status', $technology->status) == 'available' ? 'selected' : '' }}>
                                    Available
                                </option>
                                <option value="fixing" {{ old('status', $technology->status) == 'fixing' ? 'selected' : '' }}>
                                    Under Maintenance
                                </option>
                            </select>
                            @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Technology
                            </button>
                            <a href="{{ route('rental.dashboard') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
