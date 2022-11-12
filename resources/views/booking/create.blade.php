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
                    <a href="{{ url('') }}/booking/maids">
                        <h3>{{ $pageTitle }}</h3>
                    </a>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row mb-3">
                <div class="col-10 col-md-10 col-lg-8 col-xl-6 mb-3">
                    <div class="card shadow">
                        <div class="card-header">
                            <h3 class="card-title">Booking Worker</h3>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="user-assign" class="form-label">Agency</label>
                                    <select name="user-assign" id="user-assign" class="form-select choices"></select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="maids" class="form-label">Workers</label>
                                    <select name="maids" id="maids" class="form-select choices multiple"
                                        multiple></select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="maids" class="form-label">Booking For (days)</label>
                                    <input type="number" name="days" id="days" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col d-flex justify-content-end gap-2">
                                    <a href="{{ url('') }}/booking/maids" class="btn btn-danger"><i
                                            class="fa-solid fa-times me-2"></i>Cancel</a>
                                    <a href="javascript:;" class="btn btn-primary" id="btn-save"
                                        data-csrf="{{ csrf_token() }}"><i class="fa-solid fa-save me-2"></i>Save</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
