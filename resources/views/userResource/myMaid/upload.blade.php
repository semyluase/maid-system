<?php
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
?>
@extends('layouts.userMain')
@section('content')
    <div class="page-heading">
        <div class="row">
            <div class="col-6">
                <h3>{{ $pageTitle }}</h3>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <a href="{{ url('') }}/workers" class="btn btn-outline-primary"><i
                        class="fa-solid fa-arrow-left me-2"></i>Back to list</a>
            </div>
        </div>
    </div>
    <div class="page-content mb-5">
        <section class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-12">
                        <div class="card shadow">
                            <div class="card-content">
                                @if ($maid->picture_name)
                                    <img class="card-img-bottom img-fluid"
                                        src="{{ asset($maid->picture_location . $maid->picture_name) }}"
                                        alt="Photo of {{ $maid->code_maid }}" style="height: 30rem; object-fit: fill">
                                @else
                                    <img class="card-img-bottom img-fluid"
                                        src="{{ asset('assets/image/web/no_content.jpg') }}" alt="No Content"
                                        style="height: 20rem; object-fit: fill">
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-6 col-sm-12">
                        <div class="card shadow">
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="card-text font-semibold">Fullname</div>
                                            <div class="card-text">{{ $maid->full_name }}</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="card-text font-semibold">Place of birth</div>
                                            <div class="card-text">{{ $maid->place_of_birth }}</div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col">
                                            <div class="card-text font-semibold">Date of birth</div>
                                            <div class="card-text">
                                                {{ Carbon::parse($maid->date_of_birth)->isoFormat('DD MMMM YYYY') }}
                                                ({{ Carbon::parse($maid->date_of_birth)->age }} Years)</div>
                                        </div>
                                    </div>
                                    <form action="{{ url('') }}/my-workers" method="post" id="form-booking"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="maidCode" class="form-control" id="maidCode"
                                            value="{{ $maid->code_maid }}">
                                        <div class="row mb-3">
                                            <div class="col">
                                                <input type="file" class="form-control" multiple id="uploadDoc"
                                                    name="uploadDoc[]" aria-label="Upload Doc">
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <div class="col d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary" id="btn-save"><i
                                                        class="fa-solid fa-upload me-2"></i>Upload</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
