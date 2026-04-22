@extends('backend.master')

@section('title', 'Profile - Admin Dashboard')
@section('breadcrumb', 'Profile')

@push('styles')
<style>
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 12px;
        padding: 3rem 2rem;
        margin-bottom: 2rem;
        color: white;
        position: relative;
        overflow: hidden;
    }

    .profile-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: url('data:image/svg+xml,<svg width="100" height="100" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid" width="20" height="20" patternUnits="userSpaceOnUse"><path d="M 20 0 L 0 0 0 20" fill="none" stroke="white" stroke-width="0.5" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)" /></svg>');
        opacity: 0.3;
    }

    .profile-avatar {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        border: 5px solid white;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        object-fit: cover;
    }

    .profile-card {
        border-radius: 12px;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        margin-bottom: 1.5rem;
        transition: all 0.3s;
    }

    .profile-card:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.12);
    }

    .info-item {
        display: flex;
        align-items: center;
        padding: 1rem 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-icon {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        color: white;
    }

    .info-label {
        font-size: 0.875rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
    }

    .info-value {
        font-weight: 600;
        color: #212529;
    }

    .stat-card {
        text-align: center;
        padding: 1.5rem;
        border-radius: 12px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        margin-bottom: 1rem;
    }

    .stat-value {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 0.875rem;
        opacity: 0.9;
    }

    .activity-item {
        display: flex;
        padding: 1rem;
        border-bottom: 1px solid #f0f0f0;
        transition: all 0.3s;
    }

    .activity-item:hover {
        background: #f8f9fa;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        flex-shrink: 0;
    }

    .activity-icon.success {
        background: rgba(46, 184, 92, 0.1);
        color: #2eb85c;
    }

    .activity-icon.info {
        background: rgba(51, 153, 255, 0.1);
        color: #39f;
    }

    .activity-icon.warning {
        background: rgba(249, 177, 21, 0.1);
        color: #f9b115;
    }

    .btn-edit-profile {
        background: white;
        color: #667eea;
        border: 2px solid white;
        padding: 0.5rem 1.5rem;
        border-radius: 8px;
        font-weight: 600;
        transition: all 0.3s;
    }

    .btn-edit-profile:hover {
        background: transparent;
        color: white;
        border-color: white;
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <!-- Profile Header -->
    <div class="profile-header">
        <div class="row align-items-center position-relative">
            <div class="col-md-auto text-center text-md-start mb-3 mb-md-0">
                <img src="https://ui-avatars.com/api/?name={{auth()->user()->name}}&size=120&background=fff&color=667eea&bold=true"
                     alt="Profile"
                     class="profile-avatar">
            </div>
            <div class="col-md">
                <h2 class="mb-2">{{auth()->user()->name}}</h2>
                <p class="mb-2 opacity-75">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    {{auth()->user()->email}}
                </p>
                <div class="d-flex gap-2 flex-wrap">
                    <span class="badge bg-white text-dark px-3 py-2">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1">
                            <path d="M12 2L2 7l10 5 10-5-10-5z"></path>
                            <path d="M2 17l10 5 10-5"></path>
                            <path d="M2 12l10 5 10-5"></path>
                        </svg>
                        Administrator
                    </span>
                    <span class="badge bg-white text-dark px-3 py-2">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        Joined {{ auth()->user()->created_at->format('M Y') }}
                    </span>
                </div>
            </div>
            <div class="col-md-auto text-center text-md-end">
                <a href="{{route('profile.edit')}}" class="btn btn-edit-profile">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="me-1">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    Edit Profile
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column -->
        <div class="col-lg-4">
            <!-- Stats -->
            <div class="row">
                <div class="col-6 mb-3">
                    <div class="stat-card">
                        <div class="stat-value">156</div>
                        <div class="stat-label">Total Orders</div>
                    </div>
                </div>
                <div class="col-6 mb-3">
                    <div class="stat-card" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <div class="stat-value">48</div>
                        <div class="stat-label">Products</div>
                    </div>
                </div>
                <div class="col-6 mb-3">
                    <div class="stat-card" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <div class="stat-value">892</div>
                        <div class="stat-label">Customers</div>
                    </div>
                </div>
                <div class="col-6 mb-3">
                    <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                        <div class="stat-value">$12.5K</div>
                        <div class="stat-label">Revenue</div>
                    </div>
                </div>
            </div>

            <!-- Personal Information -->
            <div class="card profile-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Personal Information</h5>
                </div>
                <div class="card-body">
                    <div class="info-item">
                        <div class="info-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </svg>
                        </div>
                        <div>
                            <div class="info-label">Full Name</div>
                            <div class="info-value">{{auth()->user()->name}}</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                        </div>
                        <div>
                            <div class="info-label">Email</div>
                            <div class="info-value">{{auth()->user()->email}}</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="info-label">Phone</div>
                            <div class="info-value">+880 1712-345678</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                        </div>
                        <div>
                            <div class="info-label">Location</div>
                            <div class="info-value">Dhaka, Bangladesh</div>
                        </div>
                    </div>

                    <div class="info-item">
                        <div class="info-icon">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                                <line x1="16" y1="2" x2="16" y2="6"></line>
                                <line x1="8" y1="2" x2="8" y2="6"></line>
                                <line x1="3" y1="10" x2="21" y2="10"></line>
                            </svg>
                        </div>
                        <div>
                            <div class="info-label">Member Since</div>
                            <div class="info-value">{{ auth()->user()->created_at->format('d M, Y') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column -->
        <div class="col-lg-8">
            <!-- Recent Activities -->
            <div class="card profile-card">
                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Activities</h5>
                    <span class="badge bg-primary">Today</span>
                </div>
                <div class="card-body p-0">
                    <div class="activity-item">
                        <div class="activity-icon success">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <polyline points="20 6 9 17 4 12"></polyline>
                            </svg>
                        </div>
                        <div class="grow">
                            <div class="fw-semibold">Order #ORD-123 completed</div>
                            <div class="small text-muted">Successfully processed payment and shipped the order</div>
                            <div class="small text-muted mt-1">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                2 hours ago
                            </div>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon info">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            </svg>
                        </div>
                        <div class="grow">
                            <div class="fw-semibold">Added new product</div>
                            <div class="small text-muted">Successfully added "Samsung Galaxy S24" to inventory</div>
                            <div class="small text-muted mt-1">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                5 hours ago
                            </div>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon warning">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                        </div>
                        <div class="grow">
                            <div class="fw-semibold">Low stock alert</div>
                            <div class="small text-muted">Product "iPhone 15 Pro" is running low on stock (5 units left)</div>
                            <div class="small text-muted mt-1">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                Yesterday
                            </div>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon success">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>
                        </div>
                        <div class="grow">
                            <div class="fw-semibold">New customer registered</div>
                            <div class="small text-muted">John Doe (john@example.com) created an account</div>
                            <div class="small text-muted mt-1">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                2 days ago
                            </div>
                        </div>
                    </div>

                    <div class="activity-item">
                        <div class="activity-icon info">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="3"></circle>
                                <path d="M12 1v6m0 6v6"></path>
                            </svg>
                        </div>
                        <div class="grow">
                            <div class="fw-semibold">Profile updated</div>
                            <div class="small text-muted">Updated profile information and preferences</div>
                            <div class="small text-muted mt-1">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <polyline points="12 6 12 12 16 14"></polyline>
                                </svg>
                                3 days ago
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer bg-white text-center">
                    <a href="#" class="text-decoration-none">View All Activities →</a>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card profile-card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{route('product.create')}}" class="btn btn-outline-primary w-100 p-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-2">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <line x1="12" y1="8" x2="12" y2="16"></line>
                                    <line x1="8" y1="12" x2="16" y2="12"></line>
                                </svg>
                                <div class="fw-semibold">Add Product</div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{route('orders.list')}}" class="btn btn-outline-success w-100 p-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-2">
                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                </svg>
                                <div class="fw-semibold">View Orders</div>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="{{route('category.create')}}" class="btn btn-outline-info w-100 p-3">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="mb-2">
                                    <rect x="3" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="3" width="7" height="7"></rect>
                                    <rect x="14" y="14" width="7" height="7"></rect>
                                    <rect x="3" y="14" width="7" height="7"></rect>
                                </svg>
                                <div class="fw-semibold">Add Category</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
