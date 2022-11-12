@extends('layouts.userMain')
@section('content')
    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-9">
                @include('dashboard.user.maidTransaction')
                @include('dashboard.user.announcement')
            </div>
        </section>
    </div>
@endsection
