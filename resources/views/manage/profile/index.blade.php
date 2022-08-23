@extends('layouts.main')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $pageTitle }}</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <h4 class="card-title">My Profile</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" name="username" id="username" class="form-control"
                                        value="{{ auth()->user()->username }}" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="profilName" class="form-label">Name</label>
                                    <input type="text" name="profilName" id="profilName" class="form-control"
                                        value="{{ auth()->user()->name }}">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="profileEmail" class="form-label">Email</label>
                                    <input type="email" name="profileEmail" id="profileEmail" class="form-control"
                                        value="{{ auth()->user()->email }}">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-3">
                                    <a href="javascript:;" class="btn btn-outline-primary" id="simpan-profile"
                                        data-csrf="{{ csrf_token() }}"><i class="fas fa-save me-2"></i>Save</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <h4 class="card-title">Change Password</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="oldPassword" class="form-label">Old Password</label>
                                    <input type="password" name="oldPassword" id="oldPassword" class="form-control"
                                        autocomplete="off" value="">
                                    <div class="invalid-feedback oldPasswordFeedback"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="newPassword" class="form-label">New Password</label>
                                    <input type="password" name="newPassword" id="newPassword" class="form-control">
                                    <div class="invalid-feedback newPasswordFeedback"></div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="confirmPassword" class="form-label">Re-Type New Password</label>
                                    <input type="password" name="confirmPassword" id="confirmPassword" class="form-control">
                                    <div class="invalid-feedback confirmPasswordFeedback"></div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-12">
                                    <a href="javascript:;" class="btn btn-outline-primary" id="ganti-password"
                                        data-csrf="{{ csrf_token() }}"><i class="fas fa-key me-2"></i>Change Password</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
