<?php
@extends('rental.layout')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-12">
            <h1 class="mb-4">
                <i class="fas fa-tractor"></i> Technology Management
                <a href="{{ route('rental.technologies.create') }}" class="btn btn-primary float-end">
                    <i class="fas fa-plus"></i> Add New Technology
                </a>
            </h1>
        </div>
    </div>

    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Total Units</th>
                                <th>Available</th>
                                <th>Status</th>
                                <th style="width: 150px;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($technologies as $tech)
                            <tr>
                                <td><strong>{{ $tech->name }}</strong></td>
                                <td>{{ Str::limit($tech->description, 50) }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $tech->total_quantity }}</span>
                                </td>
                                <td>
                                    <span class="badge bg-success">{{ $tech->available_quantity }}</span>
                                </td>
                                <td>
                                    @if ($tech->available_quantity > 0)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle"></i> Available
                                    </span>
                                    @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-exclamation-circle"></i> Low Stock
                                    </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('rental.technologies.show', $tech) }}" class="btn btn-info" title="View">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('rental.technologies.edit', $tech) }}" class="btn btn-primary" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('rental.technologies.destroy', $tech) }}" method="POST"
                                            style="display:inline;"
                                            onsubmit="return confirm('Are you sure you want to delete this technology? This action cannot be undone.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-5">
                                    <div style="color: #999;">
                                        <i class="fas fa-inbox" style="font-size: 48px; margin-bottom: 20px; display: block;"></i>
                                        <p class="text-muted">No technologies found.</p>
                                        <a href="{{ route('rental.technologies.create') }}" class="btn btn-primary btn-sm">
                                            <i class="fas fa-plus"></i> Add First Technology
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($technologies->hasPages())
                <div class="card-footer">
                    {{ $technologies->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection