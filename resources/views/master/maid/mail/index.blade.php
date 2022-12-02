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
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-8">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <h3>Available Worker Mail</h3>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="country" class="form-label">Country</label>
                                    <select name="country" id="country" class="form-select border-3 choices"></select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <label for="workers" class="form-label">Workers</label>
                                    <select name="workers" id="workers"
                                        class="form-select border-3 choices multiple-remove" multiple></select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <label for="agencies" class="form-label">Email</label>
                                    <input name="agencies" id="agencies" class="form-control border-3">
                                    <small>Use , if email is more than 1</small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col d-flex justify-content-end gap-2">
                                    <button class="btn btn-outline-danger" id="btn-cancel" onclick="window.close()"><i
                                            class="fa-solid fa-times me-2"></i>Cancel</button>
                                    <button class="btn btn-outline-primary" id="btn-send"
                                        data-csrf="{{ csrf_token() }}"><i class="fa-solid fa-envelope me-2"></i>Send
                                        Mail</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
