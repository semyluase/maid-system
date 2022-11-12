<?php

use Illuminate\Support\Carbon;
use App\Models\Country;

?>
@extends('layouts.main')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row mb-3">
                <div class="col-6 col-md-6">
                    <a href="{{ url('') }}/master/maids">
                        <h3>{{ $pageTitle }}</h3>
                    </a>
                </div>
                <div class="col-6 d-flex justify-content-end">
                    <div class="dropdown">
                        <a class="btn btn-primary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <i class="fa-solid fa-plus me-2"></i>Add New
                            Maid
                        </a>

                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="javascript:;"
                                    onclick="window.open('{{ url('') }}/master/maids/register-maid?country=HK')">Hongkong</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"
                                    onclick="window.open('{{ url('') }}/master/maids/register-maid?country=SG')">Singapore</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"
                                    onclick="window.open('{{ url('') }}/master/maids/register-maid?country=TW')">Taiwan</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"
                                    onclick="window.open('{{ url('') }}/master/maids/register-maid?country=MY')">Malaysia</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"
                                    onclick="window.open('{{ url('') }}/master/maids/register-maid?country=BN')">Brunei</a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"
                                    onclick="window.open('{{ url('') }}/master/maids/register-maid?country=ALL')">All
                                    Format</a>
                            </li>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-6">
                                    <form action="/master/maids" method="get">
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="search" name="search"
                                                aria-describedby="btn-search" value="{{ request('search') }}">
                                            @if (request('country'))
                                                <input type="hidden" name="country" value="{{ request('country') }}">
                                            @endif
                                            <button class="btn btn-outline-primary" type="submit" id="btn-search"><i
                                                    class="fa-solid fa-search me-2"></i>Search</button>
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
                        <div class="col-6 d-flex gap-2">
                            <a href="{{ url('') }}/transaction/maids"
                                class="badge bg-primary text-bg-primary text-decoration-none">Approval
                                Workers</a>
                            <a href="{{ url('') }}/booked/maids"
                                class="badge bg-primary text-bg-primary text-decoration-none">Booking
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
                                    $country = 'ALL';
                                }

                                ?>
                                <div class="col-12 col-md-6 col-lg-4 col-xl-3 mb-3">
                                    <div class="card shadow">
                                        <div class="card-content">
                                            @if ($maid->picture_name)
                                                <img class="card-img-bottom img-fluid"
                                                    src="{{ asset($maid->picture_location . $maid->picture_name) }}"
                                                    alt="Photo of {{ $maid->code_maid }}"
                                                    style="height: 20rem; object-fit: fill">
                                            @else
                                                <img class="card-img-bottom img-fluid"
                                                    src="{{ asset('assets/image/web/no_content.jpg') }}" alt="No Content"
                                                    style="height: 20rem; object-fit: fill">
                                            @endif
                                            <div class="card-body">
                                                <h4 class="card-title">
                                                    {{ $maid->code_maid . ' - ' . $maid->full_name . ' (' . Carbon::parse($maid->date_of_birth)->age . ' Years)' }}
                                                </h4>
                                                <div class="btn-group align-items-center gap-2 mb-2">
                                                    <a href="{{ url('') }}/master/maids?country={{ $country }}"
                                                        class="badge bg-info text-bg-info"><small>{{ Country::where('code', $country)->first()->name }}</small></a>
                                                    @if ($maid->is_bookmark)
                                                        <a href="#"
                                                            class="badge bg-danger text-bg-danger text-decoration-none"><small>Booked</small></a>
                                                    @endif
                                                    @if ($maid->is_uploaded)
                                                        <a href="{{ url('') }}/transaction/maids/{{ $maid->code_maid }}"
                                                            class="badge bg-success text-bg-success text-decoration-none"><small>Uploaded</small></a>
                                                    @endif
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p class="text-dark text-left">Religion</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="text-dark text-right">
                                                            {{ convertReligion($maid->religion) }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p class="text-dark text-left">Marital Status</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="text-dark text-right">
                                                            {{ convertMaritalStatus($maid->marital) }}</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p class="text-dark text-left">Height/Weight</p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p class="text-dark text-right">
                                                            {{ $maid->height }} cm/{{ $maid->weight }} kg</p>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="text-dark text-left">Work Experience</div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col">
                                                        <ul class="list-group">
                                                            @if (collect($maid->workExperience)->count() > 0)
                                                                @foreach ($maid->workExperience as $work)
                                                                    <li class="list-group-item text-dark">
                                                                        {{ $work->country }}
                                                                        ({{ $work->year_start }} - {{ $work->year_end }})
                                                                    </li>
                                                                @endforeach
                                                            @else
                                                                <li class="list-group-item text-dark">
                                                                    No Results
                                                                </li>
                                                            @endif
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="btn-group align-items-center mx-2 px-1">
                                                @if (collect($maid->historyAction)->count() > 0)
                                                    <button type="button"
                                                        class="btn btn-link p-2 m-1 text-decoration-none" title="Timeline"
                                                        onclick="window.open('{{ url('') }}/timeline/maids?maid={{ $maid->code_maid }}')">
                                                        <i
                                                            class="bi bi-clock-history d-flex align-items-center justify-content-center text-primary"></i>
                                                    </button>
                                                @endif
                                                <button type="button" class="btn btn-link p-2 m-1 text-decoration-none"
                                                    title="Detail"
                                                    onclick="window.open('{{ url('') }}/master/maids/{{ $maid->code_maid }}?country={{ $country }}')">
                                                    <i
                                                        class="bi bi-eye d-flex align-items-center justify-content-center text-primary"></i>
                                                </button>
                                                @if ($maid->youtube_link)
                                                    <button type="button"
                                                        class="btn btn-link p-2 m-1 text-decoration-none" title="Video"
                                                        onclick="window.open('{{ $maid->youtube_link }}')">
                                                        <i
                                                            class="fa-solid fa-film d-flex align-items-center justify-content-center text-primary"></i>
                                                    </button>
                                                @endif
                                                <button type="button" class="btn btn-link p-2 m-1 text-decoration-none"
                                                    title="Edit"
                                                    onclick="window.open('{{ url('') }}/master/maids/{{ $maid->code_maid }}/edit?country={{ $country }}')">
                                                    <i
                                                        class="bi bi-pencil-square d-flex align-items-center justify-content-center text-primary"></i>
                                                </button>
                                                @if (!$maid->is_all_format)
                                                    <button type="button"
                                                        class="btn btn-link p-2 m-1 text-decoration-none" title="Download"
                                                        onclick="window.open('{{ url('') }}/master/maids/download-data?maid={{ $maid->code_maid }}&country={{ $country }}')">
                                                        <i
                                                            class="bi bi-file-arrow-down d-flex align-items-center justify-content-center text-primary"></i>
                                                    </button>
                                                @else
                                                    <button type="button"
                                                        class="btn btn-link dropdown-toggle p-2 pb-0 m-1 text-decoration-none"
                                                        data-bs-toggle="dropdown" aria-expanded="false"
                                                        style="line-height: 0 !important;" title="Download">
                                                        <i
                                                            class="bi bi-file-arrow-down d-flex align-items-center justify-content-center text-primary"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a class="dropdown-item" href="javascript:;"
                                                                onclick="window.open('{{ url('') }}/master/maids/download-data?maid={{ $maid->code_maid }}&country={{ $country }}&format=formatA')">Format
                                                                A</a></li>
                                                        <li><a class="dropdown-item" href="javascript:;"
                                                                onclick="window.open('{{ url('') }}/master/maids/download-data?maid={{ $maid->code_maid }}&country={{ $country }}&format=formatB')">Format
                                                                B</a></li>
                                                    </ul>
                                                @endif
                                                @if (auth()->user()->role->slug == 'super-admin')
                                                    <button type="button"
                                                        class="btn btn-link p-2 m-1 text-decoration-none" title="Delete"
                                                        onclick="fnMaid.onDelete('{{ $maid->id }}','{{ $maid->code_maid }}','{{ csrf_token() }}')">
                                                        <i
                                                            class="bi bi-trash d-flex align-items-center justify-content-center text-primary"></i>
                                                    </button>
                                                @endif
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
@endsection
