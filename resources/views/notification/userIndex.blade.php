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
                    <h3>{{ $pageTitle }}</h3>
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
                            <h4>Notification</h4>
                        </div>
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col">
                                    @livewire('notification-user')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
