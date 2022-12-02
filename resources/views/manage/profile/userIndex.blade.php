@extends('layouts.userMain')

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
                <div class="col-lg-12 col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <h4 class="card-title">My Profile</h4>
                                </div>
                            </div>
                        </div>
                        <form action="{{ url('') }}/manage/profile/change-profile/{{ auth()->user()->username }}"
                            method="post" id="form-profile" enctype="multipart/form-data">
                            @csrf
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4 border-end">
                                        <div class="row">
                                            <div class="col-12 d-flex justify-content-center">
                                                <img src="{{ asset('assets/image/user/' . auth()->user()->image) }}"
                                                    width="40%" class="rounded" id="profilePicture"
                                                    alt="Avatar of {{ auth()->user()->name }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col text-center">
                                                <small>max image size 800px x 800px</small>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <div class="h5">{{ auth()->user()->name }}</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12 text-center">
                                                <div class="h6">{{ auth()->user()->role->description }}</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="h6 text-primary text-left">About Me</div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="text-justify" id="aboutMeText">{{ auth()->user()->about_me }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8">
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
                                                <input type="email" name="profileEmail" id="profileEmail"
                                                    class="form-control" value="{{ auth()->user()->email }}">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="oldPassword" class="form-label">About Me</label>
                                                <textarea name="aboutMe" id="aboutMe" rows="5" class="form-control">{{ auth()->user()->about_me }}</textarea>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="oldPassword" class="form-label">Old Password</label>
                                                <input type="password" name="oldPassword" id="oldPassword"
                                                    class="form-control" placeholder="Old Password" autocomplete="off"
                                                    value="">
                                                <div class="invalid-feedback oldPasswordFeedback"></div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-6">
                                                <label for="newPassword" class="form-label">New Password</label>
                                                <input type="password" placeholder="New Password" name="newPassword"
                                                    id="newPassword" class="form-control">
                                                <div class="invalid-feedback newPasswordFeedback"></div>
                                            </div>
                                            <div class="col-6">
                                                <label for="confirmPassword" class="form-label">Confirm Password</label>
                                                <input type="password" name="confirmPassword" id="confirmPassword"
                                                    placeholder="Confirm Password" class="form-control">
                                                <div class="invalid-feedback confirmPasswordFeedback"></div>
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col-12">
                                                <label for="profilePictureFile" class="form-label">Profile Picture</label>
                                                <input class="form-control" type="file" id="profilePictureFile"
                                                    name="profilePictureFile" value="{{ auth()->user()->image }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <a href="javascript:;" class="btn btn-outline-primary"
                                            data-csrf={{ csrf_token() }} id="simpan-profile"><i
                                                class="fas fa-save me-2"></i>Save</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
