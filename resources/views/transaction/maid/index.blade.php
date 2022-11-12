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
                                    <form action="/transaction/maids" method="get">
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
                                                    @if ($maid->is_uploaded)
                                                        <a href="{{ url('') }}/transaction/maids/{{ $maid->code_maid }}"
                                                            class="badge bg-success text-bg-success text-decoration-none"><small>Uploaded</small></a>
                                                    @endif
                                                </div>
                                                @if ($maid->is_bookmark)
                                                    <p class="card-text">Booked By {{ $maid->userBookmark->name }} till
                                                        {{ Carbon::parse($maid->max_bookmark_at)->isoFormat('DD MMMM YYYY') }}
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
                                                @if ($maid->is_uploaded)
                                                    <button type="button" class="btn btn-link p-2 m-1 text-decoration-none"
                                                        title="Document"
                                                        onclick="{{ url('transaction/maids/document/') . $maid->code_maid }}">
                                                        <i
                                                            class="bi bi-eye d-flex align-items-center justify-content-center text-primary"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-link p-2 m-1 text-decoration-none"
                                                        title="Approve"
                                                        onclick="fnTransactionMaid.onApproved('{{ $maid->code_maid }}')">
                                                        <i
                                                            class="bi bi-person-check d-flex align-items-center justify-content-center text-primary"></i>
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
    <div class="modal fade text-left" id="approved" tabindex="-1" aria-labelledby="myModalLabel160"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h5 class="modal-title white" id="myModalLabel160">
                        Approval Worker
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="message" class="form-label">Message</label>
                            <input type="hidden" name="maidID" class="form-control" id="maidID">
                            <textarea name="message" id="message" rows="8" class="form-control"></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" id="btn-accept" data-csrf="{{ csrf_token() }}">
                        <span class="d-none d-sm-block"><i class="fa-solid fa-check me-2"></i>Accept</span>
                    </button>
                    <button type="button" class="btn btn-danger" id="btn-reject" data-csrf="{{ csrf_token() }}">
                        <span class="d-none d-sm-block"><i class="fa-solid fa-times me-2"></i>Reject</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade text-left" id="activities" tabindex="-1" aria-labelledby="myModalLabel160"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title white" id="myModalLabel160">
                        History Activities
                    </h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-x">
                            <line x1="18" y1="6" x2="6" y2="18"></line>
                            <line x1="6" y1="6" x2="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <div id="sectionActivities"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
