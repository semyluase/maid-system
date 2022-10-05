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
            <div class="row my-3 justify-content-center">
                {{ $maids->links() }}
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
                                    <div class="card rounded-top"
                                        style="max-height: 34rem !important; min-height: 34rem !important;">
                                        <div class="card-header">
                                            <h4 class="card-title">
                                                {{ $maid->code_maid . ' - ' . $maid->full_name . ' (' . Carbon::parse($maid->date_of_birth)->age . ' Years)' }}
                                            </h4>
                                            <div class="card-text">
                                                <a href="{{ url('') }}/master/maids?country={{ $country }}"
                                                    class="badge bg-info text-bg-info">
                                                    {{ Country::where('code', $country)->first()->name }}
                                                </a>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                            <img src="{{ asset('assets/image/maids/photos/' . $maid->picture_name) }}"
                                                alt="{{ $maid->code_maid }}" class="card-image-top img-fluid"
                                                style="max-height: 18rem; min-width: 100%;">
                                        </div>
                                        <div class="card-footer">
                                            <div class="row d-flex">
                                                <div class="col mb-3 mb-3">
                                                    <button type="button" class="btn btn-outline-info"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-title="Detail Data"
                                                        onclick="window.open('{{ url('') }}/master/maids/{{ $maid->code_maid }}?country={{ $country }}')">
                                                        <i class="fa-solid fa-eye"></i>
                                                    </button>
                                                </div>
                                                @if ($maid->youtube_link)
                                                    <div class="col mb-3">
                                                        <button type="button" class="btn btn-outline-dark"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Detail Data"
                                                            onclick="window.open('{{ $maid->youtube_link }}')">
                                                            <i class="fa-solid fa-video"></i>
                                                        </button>
                                                    </div>
                                                @endif
                                                <div class="col mb-3">
                                                    <button type="button" class="btn btn-outline-primary"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-title="Download Data"
                                                        onclick="window.open('{{ url('') }}/master/maids/download-data?maid={{ $maid->code_maid }}&country={{ $country }}')">
                                                        <i class="fa-solid fa-download"></i>
                                                    </button>
                                                </div>
                                                <div class="col mb-3">
                                                    <button type="button" class="btn btn-outline-warning"
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        data-bs-title="Edit Data"
                                                        onclick="window.open('{{ url('') }}/master/maids/{{ $maid->code_maid }}/edit?country={{ $country }}')">
                                                        <i class="fa-solid fa-edit"></i>
                                                    </button>
                                                </div>
                                                @if (auth()->user()->role->slug == 'super-admin')
                                                    <div class="col mb-3">
                                                        <button type="button" class="btn btn-outline-danger"
                                                            data-bs-toggle="tooltip" data-bs-placement="top"
                                                            data-bs-title="Delete Data"
                                                            onclick="fnMaid.onDelete('{{ $maid->id }}','{{ $maid->code_maid }}','{{ csrf_token() }}')">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </button>
                                                    </div>
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
