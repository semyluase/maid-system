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
                                    <form action="/workers" method="get">
                                        <div class="input-group">
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
                                                    <input type="hidden" name="start_age"
                                                        value="{{ request('start_age') }}">
                                                @endif
                                                @if (request('end_age'))
                                                    <input type="hidden" name="end_age" value="{{ request('end_age') }}">
                                                @endif
                                                @if (request('education'))
                                                    <input type="hidden" name="education"
                                                        value="{{ request('education') }}">
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
                        <div class="col-12">
                            {{ $maids->links() }}
                        </div>
                    </div>
                    <div class="row">
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
                            <div class="col-lg-3 col-md-3 col-sm-12">
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
                                            <h6 class="card-title" style="font-size: 1rem;">
                                                {{ $maid->code_maid . ' - ' . $maid->full_name . ' (' . Carbon::parse($maid->date_of_birth)->age . ' Years)' }}
                                            </h6>
                                            <div class="row my-0 py-0" style="margin-bottom:-1.25rem !important;">
                                                <div class="col-6">
                                                    <p class=" text-left" style="font-size: .98rem !important;">
                                                        Religion</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class=" text-right" style="font-size: .98rem !important;">
                                                        {{ convertReligion($maid->religion) }}</p>
                                                </div>
                                            </div>
                                            <div class="row my-0 py-0" style="margin-bottom:-1.25rem !important;">
                                                <div class="col-6">
                                                    <p class=" text-left" style="font-size: .98rem !important;">
                                                        Marital</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class=" text-right" style="font-size: .98rem !important;">
                                                        {{ convertMaritalStatus($maid->marital) }}</p>
                                                </div>
                                            </div>
                                            <div class="row my-0 py-0" style="margin-bottom:-1.25rem !important;">
                                                <div class="col-6">
                                                    <p class=" text-left" style="font-size: .98rem !important;">
                                                        Height</p>
                                                </div>
                                                <div class="col-6">
                                                    <p class=" text-right" style="font-size: .98rem !important;">
                                                        {{ $maid->height }} cm</p>
                                                </div>
                                            </div>
                                            <div class="row my-0 py-0" style="margin-bottom:-1.25rem !important;">
                                                <div class="col-6">
                                                    <p class=" text-left" style="font-size: .98rem !important;">
                                                        Weight</p>
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
                                            <form action="{{ url('') }}/workers/upload">
                                                <input type="hidden" name="worker" class="form-control" id="worker"
                                                    value="{{ $maid->code_maid }}">
                                                <button type="submit" class="btn btn-link p-2 m-1 text-decoration-none"
                                                    title="Upload Docs">
                                                    <i
                                                        class="bi bi-upload d-flex align-items-center justify-content-center text-secondary"></i>
                                                </button>
                                            </form>
                                            @if ($maid->youtube_link)
                                                <button type="button" class="btn btn-link p-2 m-1 text-decoration-none"
                                                    title="Video" onclick="window.open('{{ $maid->youtube_link }}')">
                                                    <i
                                                        class="fa-solid fa-film d-flex align-items-center justify-content-center text-primary"></i>
                                                </button>
                                            @endif
                                            @if (!$maid->is_all_format)
                                                <button type="button" class="btn btn-link p-2 m-1 text-decoration-none"
                                                    title="Download"
                                                    onclick="window.open('{{ url('') }}/master/maids/download-data?maid={{ $maid->code_maid }}&country={{ $country }}')">
                                                    <i
                                                        class="bi bi-file-arrow-down d-flex align-items-center justify-content-center text-primary"></i>
                                                </button>
                                            @else
                                                @if (auth()->user()->is_formal && auth()->user()->country->code == 'MY')
                                                    <button type="button"
                                                        class="btn btn-link p-2 m-1 text-decoration-none" title="Download"
                                                        onclick="window.open('{{ url('') }}/master/maids/download-data?maid={{ $maid->code_maid }}&country={{ $country }}&format=formatA')">
                                                        <i
                                                            class="bi bi-file-arrow-down d-flex align-items-center justify-content-center text-primary"></i>
                                                    </button>
                                                @elseif(auth()->user()->is_formal && auth()->user()->country->code == 'BN')
                                                    <button type="button"
                                                        class="btn btn-link p-2 m-1 text-decoration-none" title="Download"
                                                        onclick="window.open('{{ url('') }}/master/maids/download-data?maid={{ $maid->code_maid }}&country={{ $country }}&format=formatB')">
                                                        <i
                                                            class="bi bi-file-arrow-down d-flex align-items-center justify-content-center text-primary"></i>
                                                    </button>
                                                @endif
                                            @endif
                                            <button type="button" class="btn btn-link p-2 m-1 text-decoration-none"
                                                title="Download Excel"
                                                onclick="window.open('{{ url('') }}/master/maids/export-excel?maid={{ $maid->code_maid }}&country={{ $country }}')">
                                                <i
                                                    class="bi bi-file-earmark-excel d-flex align-items-center justify-content-center text-primary"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
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
                <form action="{{ url('') }}/workers" method="get">
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
