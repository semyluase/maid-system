<?php

use Illuminate\Support\Carbon;
use App\Models\Country;

?>
@extends('layouts.main')
@section('content')
    <script>
        document.querySelector('#sidebar').classList.remove('active')
    </script>
    <div class="page-heading">
        <div class="page-title">
            <div class="row mb-3">
                <div class="col-6 col-md-6">
                    <a href="{{ url('') }}/booked/maids">
                        <h3>{{ $pageTitle }}</h3>
                    </a>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <a href="{{ url('') }}/booked/maids/create" class="btn btn-primary" id="btn-add"><i
                            class="fa-solid fa-plus me-2"></i>Booking
                        Worker</a>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-8">
                                    <form action="/booked/maids" method="get">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="search" name="search"
                                                aria-describedby="btn-search" value="{{ request('search') }}">
                                            @if (request('country'))
                                                <input type="hidden" name="country" value="{{ request('country') }}">
                                            @endif
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
                                            @if (request('countries'))
                                                <input type="hidden" name="countries" value="{{ request('countries') }}">
                                            @endif
                                            @if (request('education'))
                                                <input type="hidden" name="education" value="{{ request('education') }}">
                                            @endif
                                            @if (request('marital'))
                                                <input type="hidden" name="marital" value="{{ request('marital') }}">
                                            @endif
                                            @if (request('category'))
                                                <input type="hidden" name="category" value="{{ request('category') }}">
                                            @endif
                                            @if (request('branch'))
                                                <input type="hidden" name="branch" value="{{ request('branch') }}">
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
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row my-3">
                        <div class="col-12 d-flex gap-2">
                            @php
                                $countries = [
                                    [
                                        'code' => 'HK',
                                        'name' => 'Hongkong',
                                    ],
                                    [
                                        'code' => 'TW',
                                        'name' => 'Taiwan',
                                    ],
                                    [
                                        'code' => 'SG',
                                        'name' => 'Singapore',
                                    ],
                                    [
                                        'code' => 'MY',
                                        'name' => 'Malaysia',
                                    ],
                                    [
                                        'code' => 'BN',
                                        'name' => 'Brunei',
                                    ],
                                    [
                                        'code' => 'FM',
                                        'name' => 'Formal',
                                    ],
                                ];
                            @endphp
                            @foreach ($countries as $country)
                                <a href="{{ url('') }}/booked/maids?country={{ $country['code'] }}"
                                    class="badge bg-success text-bg-success text-decoration-none">{{ $country['name'] }}</a>
                            @endforeach
                        </div>
                    </div>
                    <div class="row my-3">
                        <div class="col-6 d-flex gap-2">
                            <a href="{{ url('') }}/master/maids"
                                class="badge bg-primary text-bg-primary text-decoration-none">All
                                Workers</a>
                            <a href="{{ url('') }}/transaction/maids"
                                class="badge bg-primary text-bg-primary text-decoration-none">Approval
                                Workers</a>
                            <a href="{{ url('') }}/taken/maids"
                                class="badge bg-primary text-bg-primary text-decoration-none">Taken
                                Workers</a>
                        </div>
                        <div class="col-6 d-flex justify-content-end">
                            {{ $maids->links() }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <div class="row mb-3">
                        @if ($maids->count() > 0)
                            @foreach ($maids as $maid)
                                <?php

                                $country = '';

                                if ($maid->is_hongkong) {
                                    $country = 'HK';
                                }

                                if ($maid->is_singapore) {
                                    $country = 'SG';
                                }

                                if ($maid->is_taiwan) {
                                    $country = 'TW';
                                }

                                if ($maid->is_malaysia) {
                                    $country = 'MY';
                                }

                                if ($maid->is_brunei) {
                                    $country = 'BN';
                                }

                                if ($maid->is_all_format) {
                                    $country = 'FM';
                                }

                                ?>
                                <div class="col-12 col-md-3 col-lg-3 col-xl-3 mb-3">
                                    <div class="card shadow">
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
                                                <h6 class="card-title" style="font-size: 1rem;">
                                                    {{ $maid->code_maid . ' - ' . $maid->full_name . ' (' . Carbon::parse($maid->date_of_birth)->age . ' Years)' }}
                                                </h6>
                                                <div class="align-items-center gap-2">
                                                    <a href="{{ url('') }}/master/maids?country={{ $country }}"
                                                        class="badge bg-info text-bg-info"><small>{{ Country::where('code', $country)->first()->name }}</small></a>
                                                    @if ($maid->is_bookmark)
                                                        <a href="#"
                                                            class="badge bg-danger text-bg-danger text-decoration-none"><small>Booked</small></a>
                                                    @endif
                                                </div>
                                                @if ($maid->is_bookmark)
                                                    <p class="card-text">Booked By {{ $maid->userBookmark->name }} till
                                                        {{ Carbon::parse($maid->bookmark_max_at)->isoFormat('DD MMMM YYYY') }}
                                                    </p>
                                                @endif
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
                                                <form action="{{ url('') }}/booked/maids/{{ $maid->code_maid }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit"
                                                        class="btn btn-link p-2 m-1 text-decoration-none"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Cancel Booking">
                                                        <i
                                                            class="bi bi-x-circle d-flex align-items-center justify-content-center text-danger"></i>
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
                </div>
            </div>
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

            $countries = [
                'HK' => 'Hongkong',
                'SG' => 'Singapore',
                'TW' => 'Taiwan',
                'MY' => 'Malaysia',
                'BN' => 'Brunei',
                'FM' => 'All Formal',
            ];

            $categories = [
                'taken' => 'Taken',
                'hold' => 'Hold',
                'upload' => 'JO Uploaded',
                'avail' => 'Available',
            ];

            $branch = [
                'K' => 'Kendal',
                'T' => 'Tegal',
                'G' => 'Grobogan',
                'B' => 'Banyumas',
            ];
        @endphp
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modal-additional-search-label">Additional Search</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ url('') }}/booked/maids" method="get">
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
                                <label for="name" class="form-label">Worker Country</label>
                                <div class="input-group">
                                    @foreach ($countries as $c => $value)
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="countries"
                                                id="{{ $c }}" value="{{ $c }}"
                                                {{ request('countries') == $c ? 'checked' : '' }}>
                                            <label class="form-check-label"
                                                for="{{ $c }}">{{ $value }}</label>
                                        </div>
                                    @endforeach
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
                        @if (auth()->user()->role->id == 1)
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">Status</label>
                                    <div class="input-group">
                                        @foreach ($categories as $c => $value)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="category"
                                                    id="{{ $c }}" value="{{ $c }}"
                                                    {{ request('category') == $c ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="{{ $c }}">{{ $value }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="name" class="form-label">Branch</label>
                                    <div class="input-group">
                                        @foreach ($branch as $b => $value)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="branch"
                                                    id="{{ $b }}" value="{{ $b }}"
                                                    {{ request('branch') == $b ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="{{ $b }}">{{ $value }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
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
