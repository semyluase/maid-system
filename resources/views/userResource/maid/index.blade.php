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
            @if ($maids)
                <div class="col-12">
                    <div class="row justify-content-center mb-5">
                        <div class="col-lg-6 col-12">
                            <form action="/workers" method="get">
                                <div class="input-group">
                                    <input type="text" class="form-control" placeholder="search here..." id="search"
                                        name="search" aria-describedby="btn-search" value="{{ request('search') }}">
                                    <button class="btn btn-outline-primary" type="submit" id="btn-search"><i
                                            class="fa-solid fa-search me-2"></i>Search</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="row my-3 justify-content-center">
                        {{ $maids->links() }}
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
                                $country = 'ALL';
                            }

                            ?>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="card">
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
                                            <h4 class="card-title">{{ $maid->code_maid }} - {{ $maid->full_name }}</h4>
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
                                            <form action="{{ url('') }}/workers/bookmark">
                                                <input type="hidden" name="worker" class="form-control" id="worker"
                                                    value="{{ $maid->code_maid }}">
                                                <button type="submit" class="btn btn-link p-2 m-1 text-decoration-none">
                                                    <i
                                                        class="bi bi-bookmark d-flex align-items-center justify-content-center text-secondary"></i>
                                                </button>
                                            </form>
                                        </div>
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
@endsection
