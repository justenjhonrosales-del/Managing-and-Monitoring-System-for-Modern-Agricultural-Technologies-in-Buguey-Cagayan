<?php
@extends('rental.layout')

@section('content')
<div class="container-fluid">

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <i class="fas fa-cube" style="font-size: 32px; color: #388e3c;"></i>
                <div class="number">{{ $totalAvailable }}</div>
                <div class="label">Available Units</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <i class="fas fa-hourglass-half" style="font-size: 32px; color: #ffc107;"></i>
                <div class="number">{{ $totalPending }}</div>
                <div class="label">Pending Rentals</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="stat-card">
                <i class="fas fa-wrench" style="font-size: 32px; color: #dc3545;"></i>
                <div class="number">{{ $totalFixing }}</div>
                <div class="label">Units Under Repair</div>
            </div>
        </div>
    </div>

    <!-- Equipment Display -->
    <div class="row mb-4">
        <div class="col-md-12">
            <h2 class="mb-3">
                <i class="fas fa-tractor"></i> Renting
                <a href="{{ route('rental.technologies.create') }}" class="btn btn-sm btn-primary float-end">
                    <i class="fas fa-plus"></i> Add Equipment
                </a>
            </h2>
        </div>
    </div>

    <div class="row mb-5">
        @foreach ($technologies as $tech)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                @if ($tech->image_path)
                <img src="{{ $tech->image_path }}" alt="{{ $tech->name }}" class="card-img-top tech-image">
                @else
                <div class="card-img-top tech-image bg-secondary d-flex align-items-center justify-content-center">
                    <i class="fas fa-tractor text-white" style="font-size: 48px;"></i>
                </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $tech->name }}</h5>
                    <p class="card-text text-muted">{{ $tech->description }}</p>
                    <div class="mb-3">
                        <span class="badge badge-available">
                            <i class="fas fa-check-circle"></i> Available: {{ $tech->available_quantity }}/{{ $tech->total_quantity }}
                        </span>
                    </div>
                    <div class="mb-3">
                        @if ($tech->getPendingCount() > 0)
                        <span class="badge badge-pending">
                            <i class="fas fa-hourglass-half"></i> Pending: {{ $tech->getPendingCount() }}
                        </span>
                        @endif
                        @if ($tech->getFixingCount() > 0)
                        <span class="badge badge-fixing">
                            <i class="fas fa-wrench"></i> Fixing: {{ $tech->getFixingCount() }}
                        </span>
                        @endif
                    </div>
                    <div class="btn-group w-100" role="group">
                        <a href="{{ route('rental.technologies.edit', $tech) }}" class="btn btn-sm btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('rental.technologies.destroy', $tech) }}" method="POST"
                            style="display:inline;" onsubmit="return confirm('Delete this equipment?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Recent Rentals -->
    <div class="row mt-5">
        <div class="col-md-12">
            <h2 class="mb-3">
                <i class="fas fa-list"></i> Recent Rental Requests
            </h2>
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Equipment</th>
                                <th>Renter</th>
                                <th>Email</th>
                                <th>Rental Date</th>
                                <th>Status</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($rentals as $rental)
                            <tr>
                                <td>{{ $rental->technology->name }}</td>
                                <td>{{ $rental->renter_name }}</td>
                                <td>{{ $rental->renter_email }}</td>
                                <td>{{ $rental->rental_date->format('M d, Y') }}</td>
                                <td>
                                    <form action="{{ route('rental.update-status', $rental) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" class="form-select form-select-sm"
                                            onchange="this.form.submit()">
                                            <option value="pending" {{ $rental->status == 'pending' ? 'selected' : '' }}>
                                                Pending
                                            </option>
                                            <option value="approved" {{ $rental->status == 'approved' ? 'selected' : '' }}>
                                                Approved
                                            </option>
                                            <option value="fixing" {{ $rental->status == 'fixing' ? 'selected' : '' }}>
                                                Fixing
                                            </option>
                                            <option value="returned" {{ $rental->status == 'returned' ? 'selected' : '' }}>
                                                Returned
                                            </option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                                        data-bs-target="#logModal{{ $rental->id }}">
                                        <i class="fas fa-file-alt"></i> Logs
                                    </button>

                                    <!-- Log Modal -->
                                    <div class="modal fade" id="logModal{{ $rental->id }}" tabindex="-1">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Update Notes for {{ $rental->renter_name }}</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <form action="{{ route('rental.add-log', $rental) }}" method="POST">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Current Notes:</label>
                                                            <p class="form-control-plaintext">
                                                                {{ $rental->notes ?? 'No notes added yet' }}</p>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="notes" class="form-label">Add/Update Notes:</label>
                                                            <textarea class="form-control" id="notes" name="notes"
                                                                rows="4" placeholder="Add your notes here...">{{ $rental->notes }}</textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary">
                                                            <i class="fas fa-save"></i> Save Notes
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <form action="{{ route('rental.rentals.destroy', $rental) }}" method="POST" style="display:inline;" onsubmit="return confirm('Delete this rental request?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <i class="fas fa-inbox text-muted"></i>
                                    <p class="text-muted">No rental requests yet</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    {{ $rentals->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection