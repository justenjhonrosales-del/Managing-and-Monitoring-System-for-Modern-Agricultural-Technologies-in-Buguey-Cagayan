@extends('rental.layout')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-handshake"></i> Create New Rental Request
                    </h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('rental.rentals.store') }}" method="POST" id="rentalForm">
                        @csrf
                        
                        <!-- Row 1: Customer Information -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="renter_name" class="form-label">
                                    <i class="fas fa-user"></i> Customer Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('renter_name') is-invalid @enderror"
                                    id="renter_name" name="renter_name" required value="{{ old('renter_name') }}"
                                    placeholder="Enter customer name">
                                @error('renter_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="renter_phone" class="form-label">
                                    <i class="fas fa-phone"></i> Contact Number <span class="text-danger">*</span>
                                </label>
                                <input type="tel" class="form-control @error('renter_phone') is-invalid @enderror"
                                    id="renter_phone" name="renter_phone" required value="{{ old('renter_phone') }}"
                                    placeholder="Ex. 09151234567">
                                @error('renter_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 2: Email and Date -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="renter_email" class="form-label">
                                    <i class="fas fa-envelope"></i> Email Address <span class="text-danger">*</span>
                                </label>
                                <input type="email" class="form-control @error('renter_email') is-invalid @enderror"
                                    id="renter_email" name="renter_email" required value="{{ old('renter_email') }}"
                                    placeholder="customer@example.com">
                                @error('renter_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="rental_date" class="form-label">
                                    <i class="fas fa-calendar"></i> Rental Date <span class="text-danger">*</span>
                                </label>
                                <input type="date" class="form-control @error('rental_date') is-invalid @enderror"
                                    id="rental_date" name="rental_date" required value="{{ old('rental_date') }}">
                                @error('rental_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 3: Address -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="renter_address" class="form-label">
                                    <i class="fas fa-map-marker-alt"></i> Address <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('renter_address') is-invalid @enderror"
                                    id="renter_address" name="renter_address" rows="3" required 
                                    placeholder="Enter complete address">{{ old('renter_address') }}</textarea>
                                @error('renter_address')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Maps Section -->
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label class="form-label">
                                    <i class="fas fa-map"></i> Location Map
                                </label>
                                <div id="map" style="width: 100%; height: 300px; border-radius: 10px; border: 1px solid #ddd;"></div>
                                <small class="text-muted d-block mt-2">Map location helps track rental pickup/delivery points</small>
                            </div>
                        </div>

                        <hr>

                        <!-- Row 4: Equipment Selection -->
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="technology_id" class="form-label">
                                    <i class="fas fa-tractor"></i> Equipment to Rent <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('technology_id') is-invalid @enderror"
                                    id="technology_id" name="technology_id" required onchange="calculatePayment()">
                                    <option value="">-- Select Equipment --</option>
                                    @foreach($technologies as $tech)
                                    <option value="{{ $tech->id }}" data-price="100">{{ $tech->name }}</option>
                                    @endforeach
                                </select>
                                @error('technology_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Row 5: Rental Duration -->
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="rental_hours" class="form-label">
                                    <i class="fas fa-clock"></i> Hours <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control @error('rental_hours') is-invalid @enderror"
                                    id="rental_hours" name="rental_hours" min="0" required value="{{ old('rental_hours', 0) }}"
                                    onchange="calculatePayment()">
                                @error('rental_hours')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-3 mb-3">
                                <label for="rental_days" class="form-label">
                                    <i class="fas fa-calendar-alt"></i> Days <span class="text-danger">*</span>
                                </label>
                                <input type="number" class="form-control @error('rental_days') is-invalid @enderror"
                                    id="rental_days" name="rental_days" min="0" required value="{{ old('rental_days', 0) }}"
                                    onchange="calculatePayment()">
                                @error('rental_days')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="payment_amount" class="form-label">
                                    <i class="fas fa-money-bill-wave"></i> Total Payment <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">₱</span>
                                    <input type="number" class="form-control @error('payment_amount') is-invalid @enderror"
                                        id="payment_amount" name="payment_amount" min="0" step="0.01" required 
                                        value="{{ old('payment_amount', 0) }}" readonly>
                                </div>
                                @error('payment_amount')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <!-- Row 6: Payment Status -->
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <div class="form-check form-check-lg">
                                    <input type="checkbox" class="form-check-input" id="fully_paid" name="fully_paid"
                                        {{ old('fully_paid') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="fully_paid">
                                        <i class="fas fa-check-circle"></i> <strong>Fully Paid</strong>
                                        <span class="text-muted d-block" style="font-size: 12px;">Check this box if customer has paid the full amount</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="row mt-4">
                            <div class="col-md-12 d-flex gap-2">
                                <button type="reset" class="btn btn-secondary btn-lg" onclick="resetForm()">
                                    <i class="fas fa-redo"></i> Clear
                                </button>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane"></i> Submit
                                </button>
                                <a href="{{ route('rental.dashboard') }}" class="btn btn-outline-secondary btn-lg">
                                    <i class="fas fa-arrow-left"></i> Back
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Leaflet Maps CSS and JS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js"></script>

<script>
    // Initialize map
    let map;
    let marker;

    function initMap() {
        // Default to Philippines coordinates
        map = L.map('map').setView([12.8797, 121.7740], 6);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap contributors',
            maxZoom: 19,
        }).addTo(map);

        // Add click event to set location
        map.on('click', function(e) {
            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng).addTo(map);
            }
        });
    }

    // Calculate total payment
    function calculatePayment() {
        const hours = parseInt(document.getElementById('rental_hours').value) || 0;
        const days = parseInt(document.getElementById('rental_days').value) || 0;
        
        // Base rate: ₱50 per hour, ₱500 per day
        const hourlyRate = 50;
        const dailyRate = 500;
        
        const totalPayment = (hours * hourlyRate) + (days * dailyRate);
        document.getElementById('payment_amount').value = totalPayment.toFixed(2);
    }

    // Reset form
    function resetForm() {
        document.getElementById('rentalForm').reset();
        document.getElementById('payment_amount').value = '0.00';
        if (marker) {
            map.removeLayer(marker);
            marker = null;
        }
    }

    // Initialize map on page load
    window.addEventListener('DOMContentLoaded', function() {
        initMap();
    });
</script>

<style>
    .form-label {
        font-weight: 600;
        color: #0d47a1;
        margin-bottom: 8px;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 2px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #388e3c;
        box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
    }

    .btn-lg {
        padding: 12px 30px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 8px;
    }

    .gap-2 {
        gap: 10px;
    }

    hr {
        margin: 30px 0;
        border-top: 2px dashed #e0e0e0;
    }

    .form-check-lg .form-check-input {
        width: 1.5em;
        height: 1.5em;
        margin-top: 0.3em;
    }

    .form-check-lg .form-check-label {
        margin-left: 0.5rem;
        font-size: 16px;
    }
</style>
@endsection
