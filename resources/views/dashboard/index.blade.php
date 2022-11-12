@extends('layouts.main')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $pageTitle }}</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                @include('dashboard.admin.maidTransaction')
            </div>
            <div class="row">
                <div class="col-12 col-lg-8">
                    <div class="row">
                        <div class="col">
                            @include('dashboard.admin.cardMaid')
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            @include('dashboard.admin.announcement')
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-4">
                    @include('dashboard.admin.user')
                </div>
            </div>
        </section>
    </div>
@endsection
