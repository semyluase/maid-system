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
                                <div class="col-6">
                                    <form action="/booked/maids" method="get">
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
                                <div class="col-12 col-md-12 col-lg-6 col-xl-4 mb-3">
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
                                                <div class="btn-group align-items-center gap-2">
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
                                                    <button type="button" class="btn btn-link p-2 m-1 text-decoration-none"
                                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Activities"
                                                        onclick="window.open('{{ url('') }}/timelines/maids?maid={{ $maid->code_maid }}')">
                                                        <i
                                                            class="bi bi-clock-history d-flex align-items-center justify-content-center text-primary"></i>
                                                    </button>
                                                @endif
                                                <form action="{{ url('') }}/booked/maids/{{ $maid->code_maid }}"
                                                    method="post">
                                                    @csrf
                                                    @method('delete')
                                                    <button type="submit" class="btn btn-link p-2 m-1 text-decoration-none"
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
@endsection
