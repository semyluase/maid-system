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
                        @if (collect($maids)->count() > 0)
                            @foreach ($maids as $maid)
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
                                                <div class="table-responsive">
                                                    <table class="table table-borderless">
                                                        <tbody>
                                                            <tr>
                                                                <td>Place of birth</td>
                                                                <td>:</td>
                                                                <td>{{ $maid->place_of_birth ? Str::title($maid->place_of_birth) : '-' }}
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Date of birth</td>
                                                                <td>:</td>
                                                                <td>
                                                                    @if ($maid->date_of_birth)
                                                                        {{ Carbon::parse($maid->date_of_birth)->isoFormat('DD MMMM YYYY') }}
                                                                        ({{ Carbon::parse($maid->date_of_birth)->age }}
                                                                        Years)
                                                                    @else
                                                                        -
                                                                    @endif
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <p class="card-text">
                                                    {{ Carbon::parse($maid->max_bookmark_at)->diffForHumans(Carbon::parse($maid->updated_at)) }}
                                                </p>
                                            </div>
                                            <div class="btn-group align-items-center mx-2 px-1">
                                                <form action="{{ url('') }}/my-workers/upload">
                                                    <input type="hidden" name="worker" class="form-control" id="worker"
                                                        value="{{ $maid->code_maid }}">
                                                    <button type="submit" class="btn btn-link p-2 m-1 text-decoration-none"
                                                        title="Upload Docs">
                                                        <i
                                                            class="bi bi-upload d-flex align-items-center justify-content-center text-secondary"></i>
                                                    </button>
                                                </form>
                                            </div>
                                            @if ($maid->youtube_link)
                                                <div class="btn-group align-items-center mx-2 px-1">
                                                    <button type="button" class="btn btn-link p-2 m-1 text-decoration-none"
                                                        onclick="window.open('{{ $maid->youtube_link }}','_blanks')">
                                                        <i
                                                            class="bi bi-upload d-flex align-items-center justify-content-center text-secondary"></i>
                                                    </button>
                                                </div>
                                            @endif
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
@endsection
