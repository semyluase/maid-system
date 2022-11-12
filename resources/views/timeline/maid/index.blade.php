<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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

                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Activities {{ $maid->code_maid }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col">
                                    <ul class="timeline">
                                        @foreach ($histories as $history)
                                            <li class="timeline-item mb-5">
                                                <h5 class="fw-bold">{{ Str::title($history->type_action) }} -
                                                    {{ $history->userAction->name }}</h5>
                                                <p class="text-muted mb-2 fw-bold">
                                                    {{ Carbon::parse($history->date_action)->isoFormat('DD MMMM YYYY') }}
                                                </p>
                                                <p class="text-muted">
                                                    {{ $history->message }}
                                                </p>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
