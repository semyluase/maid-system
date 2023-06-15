<?php
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
?>
@extends('layouts.userMain')
@section('content')
    <div class="page-heading">
        <h3>{{ $pageTitle }}</h3>
    </div>
    <div class="page-content">
        <section class="row">
            @if (collect($maids)->count() > 0)
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-center mb-5">
                                <div class="col-lg-8 col-12">
                                    <form action="/my-workers" method="get">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="search" name="search"
                                                aria-describedby="btn-search" value="{{ request('search') }}">
                                            @if (request('code'))
                                                <input type="hidden" name="code" value="{{ request('code') }}">
                                            @endif
                                            @if (request('name'))
                                                <input type="hidden" name="name" value="{{ request('name') }}">
                                            @endif
                                            @if (request('start_age'))
                                                <input type="hidden" name="start_age" value="{{ request('start_age') }}">
                                            @endif
                                            @if (request('end_age'))
                                                <input type="hidden" name="end_age" value="{{ request('end_age') }}">
                                            @endif
                                            @if (request('education'))
                                                <input type="hidden" name="education" value="{{ request('education') }}">
                                            @endif
                                            @if (request('marital'))
                                                <input type="hidden" name="marital" value="{{ request('marital') }}">
                                            @endif
                                            <button class="btn btn-outline-primary" type="submit" id="btn-search"><i
                                                    class="fa-solid fa-search me-2"></i>Search</button>
                                            <button class="btn btn-outline-primary" type="button"
                                                id="btn-additional-search" data-bs-toggle="modal"
                                                data-bs-target="#modal-additional-search"><i
                                                    class="fa-solid fa-filter me-2"></i>Additional Search</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row my-2">
                        <div class="col-12">
                            <a href="{{ url('') }}/workers/send-batch-mail" target="_blank"
                                class="badge bg-primary text-bg-primary text-decoration-none">Available
                                Workers Mail</a>
                        </div>
                    </div>
                    <div class="row my-3 justify-content-center">
                        {{ $maids->links() }}
                    </div>
                    <div class="row">
                        @if (collect($maids)->count() > 0)
                            @foreach ($maids as $maid)
                                <div class="col-lg-3 col-md-4 col-sm-12">
                                    <div class="card" style="height: 47em;">
                                        <div class="card-content">
                                            @if ($maid->picture_name)
                                                <img class="card-img-bottom img-fluid"
                                                    src="{{ asset($maid->picture_location . $maid->picture_name) }}"
                                                    alt="Photo of {{ $maid->code_maid }}"
                                                    style="height: 20rem; object-fit: cover; object-position: 100% 0;">
                                            @else
                                                <img class="card-img-bottom img-fluid"
                                                    src="{{ asset('assets/image/web/no_content.jpg') }}" alt="No Content"
                                                    style="height: 20rem; object-fit: cover; object-position: 50% 0;">
                                            @endif
                                            <div class="card-body">
                                                <h4 class="card-title">{{ $maid->code_maid }} - {{ $maid->full_name }}
                                                    ({{ Carbon::parse($maid->date_of_birth)->age }} Years)
                                                </h4>
                                                <div class="row mb-3">
                                                    <div class="col d-flex gap-2">
                                                        @if ($maid->is_bookmark == 1 && $maid->is_uploaded == 0)
                                                            <span class="badge text-bg-primary">Bookmark till
                                                                {{ Carbon::parse($maid->bookmark_max_at)->isoFormat('DD MMM YYYY') }}</span>
                                                        @endif
                                                        @if ($maid->is_uploaded == 1 && $maid->is_taken == 0)
                                                            <span class="badge text-bg-primary">Wait Approval</span>
                                                        @endif
                                                        @if ($maid->is_taken)
                                                            <span class="badge text-bg-primary">Taken</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="row my-0 py-0" style="margin-bottom:-1.25rem !important;">
                                                    <div class="col-6">
                                                        <p class=" text-left" style="font-size: .98rem !important;">Religion
                                                        </p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class=" text-right" style="font-size: .98rem !important;">
                                                            {{ convertReligion($maid->religion) }}</p>
                                                    </div>
                                                </div>
                                                <div class="row my-0 py-0" style="margin-bottom:-1.25rem !important;">
                                                    <div class="col-6">
                                                        <p class=" text-left" style="font-size: .98rem !important;">Marital
                                                        </p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class=" text-right" style="font-size: .98rem !important;">
                                                            {{ convertMaritalStatus($maid->marital) }}</p>
                                                    </div>
                                                </div>
                                                <div class="row my-0 py-0" style="margin-bottom:-1.25rem !important;">
                                                    <div class="col-6">
                                                        <p class=" text-left" style="font-size: .98rem !important;">Height
                                                        </p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class=" text-right" style="font-size: .98rem !important;">
                                                            {{ $maid->height }} cm</p>
                                                    </div>
                                                </div>
                                                <div class="row my-0 py-0" style="margin-bottom:-1.25rem !important;">
                                                    <div class="col-6">
                                                        <p class=" text-left" style="font-size: .98rem !important;">Weight
                                                        </p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class=" text-right" style="font-size: .98rem !important;">
                                                            {{ $maid->weight }} kg
                                                        </p>
                                                    </div>
                                                </div>
                                                <div class="row my-0 py-0" style="margin-bottom:-1.25rem !important;">
                                                    <div class="col">
                                                        <div class=" text-left" style="font-size: .98rem !important;">
                                                            Experience</div>
                                                    </div>
                                                </div>
                                                <div class="row my-0 py-0"
                                                    style="margin-top:1.25rem !important; margin-bottom:-1.25rem !important;">
                                                    <div class="col">
                                                        <ul class="list-group" style="font-size: .98rem !important;">
                                                            @if (collect($maid->workExperience)->count() > 0)
                                                                @if (collect($maid->workExperience)->count() >= 3)
                                                                    @foreach ($maid->workExperience as $key => $work)
                                                                        @if ($key < 3)
                                                                            <li class="list-group-item"
                                                                                style="font-size: .98rem !important;">
                                                                                {{ $work->country }}
                                                                                ({{ $work->year_start }} -
                                                                                {{ $work->year_end }})
                                                                            </li>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                                @if (collect($maid->workExperience)->count() == 2)
                                                                    @foreach ($maid->workExperience as $key => $work)
                                                                        <li class="list-group-item"
                                                                            style="font-size: .98rem !important;">
                                                                            {{ $work->country }}
                                                                            ({{ $work->year_start }} -
                                                                            {{ $work->year_end }})
                                                                        </li>
                                                                    @endforeach
                                                                    <li class="list-group-item"
                                                                        style="font-size: .98rem !important;">
                                                                        None
                                                                    </li>
                                                                @endif
                                                                @if (collect($maid->workExperience)->count() == 1)
                                                                    @foreach ($maid->workExperience as $key => $work)
                                                                        <li class="list-group-item"
                                                                            style="font-size: .98rem !important;">
                                                                            {{ $work->country }}
                                                                            ({{ $work->year_start }} -
                                                                            {{ $work->year_end }})
                                                                        </li>
                                                                    @endforeach
                                                                    <li class="list-group-item"
                                                                        style="font-size: .98rem !important;">
                                                                        None
                                                                    </li>
                                                                    <li class="list-group-item"
                                                                        style="font-size: .98rem !important;">
                                                                        None
                                                                    </li>
                                                                @endif
                                                            @else
                                                                <li class="list-group-item"
                                                                    style="font-size: .98rem !important;">
                                                                    None
                                                                </li>
                                                                <li class="list-group-item"
                                                                    style="font-size: .98rem !important;">
                                                                    None
                                                                </li>
                                                                <li class="list-group-item"
                                                                    style="font-size: .98rem !important;">
                                                                    None
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="btn-group align-items-center mx-2 px-1">
                                                @if (collect($maid->historyAction)->count() > 0)
                                                    <button type="button"
                                                        class="btn btn-link p-2 m-1 text-decoration-none"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Activities"
                                                        onclick="window.open('{{ url('') }}/timelines/maids?maid={{ $maid->code_maid }}')">
                                                        <i
                                                            class="bi bi-clock-history d-flex align-items-center justify-content-center text-primary"></i>
                                                    </button>
                                                @endif
                                                <form action="{{ url('') }}/my-workers/upload">
                                                    <input type="hidden" name="worker" class="form-control"
                                                        id="worker" value="{{ $maid->code_maid }}">
                                                    <button type="submit"
                                                        class="btn btn-link p-2 m-1 text-decoration-none"
                                                        title="Upload Docs">
                                                        <i
                                                            class="bi bi-upload d-flex align-items-center justify-content-center text-secondary"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-12 mb-3">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="h4 text-center">
                                            No Data Results
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="row my-3 justify-content-center">
                        {{ $maids->links() }}
                    </div>
                </div>
            @else
                <div class="col-12">
                    <div class="h5 text-center">No data results</div>
                </div>
            @endif
        </section>
    </div>
    <div class="modal fade" id="modal-additional-search" tabindex="-1" aria-labelledby="modal-additional-search-label"
        aria-hidden="true">
        @php
            $marital = [
                1 => 'Single',
                2 => 'Married',
                3 => 'Widowed',
                4 => 'Divorced',
            ];

            $education = [
                1 => 'Kindergarten',
                2 => 'Primary School',
                3 => 'Junior High School',
                4 => 'Senior High School',
                5 => 'Bachelor',
                6 => 'Master',
                7 => 'Doctor',
            ];
        @endphp
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-additional-search-label">Additional Search</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('') }}/my-workers" method="get">
                    <div class="modal-body">
                        <div class="row mb-3">
                            <div class="col">
                                <label for="code" class="form-label">Code Worker</label>
                                <input type="text" name="code" id="code" class="form-control"
                                    value="{{ request('code') }}" placeholder="Code Worker">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="name" class="form-label">Worker Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    value="{{ request('name') }}" placeholder="Worker Name">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="start-age" class="form-label">Worker Age</label>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" name="start_age" id="start_age" class="form-control"
                                            value="{{ request('start_age') }}" placeholder="Start Age">
                                    </div>
                                    <div class="col">
                                        <input type="text" name="end_age" id="end_age" class="form-control"
                                            value="{{ request('end_age') }}" placeholder="End Age">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="name" class="form-label">Worker Education</label>
                                <div class="input-group">
                                    @foreach ($education as $edu => $value)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="education"
                                                id="{{ $edu }}" value="{{ $edu }}"
                                                {{ request('education') == $edu ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="{{ $edu }}">{{ $value }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col">
                                <label for="name" class="form-label">Worker Marital Status</label>
                                <div class="input-group">
                                    @foreach ($marital as $m => $value)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="marital"
                                                id="{{ $m }}" value="{{ $m }}"
                                                {{ request('marital') == $m ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="{{ $m }}">{{ $value }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i
                                class="fa-solid fa-times me-2"></i>Cancel</button>
                        <button type="submit" class="btn btn-outline-primary"><i
                                class="fa-solid fa-search me-2"></i>Search</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
