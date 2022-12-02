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
                                <h3>Available Worker</h3>
                            </div>
                        </div>
                        <form action="{{ url('') }}/mail/broadcasting" method="post">
                            @csrf
                            <div class="card-body">
                                <div class="row mb-3">
                                    <div class="col-8">
                                        <label for="codeMaid" class="form-label">Worker</label>
                                        <input type="text" name="codeMaid" id="codeMaid" class="form-control"
                                            value="{{ $maid->code_maid }}" readonly>
                                        <input type="hidden" name="country" id="country" class="form-control"
                                            value="{{ $country }}" readonly>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-8">
                                        <label for="agency" class="form-label">Destination Mail</label>
                                        <input type="text" name="agency" id="agency" class="form-control border-3">
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <div class="row">
                                    <div class="col d-flex justify-content-end gap-2">
                                        <a href="javascript:;" class="btn btn-danger" onclick="window.close()"><i
                                                class="fa-solid fa-times me-2"></i>Cancel</a>
                                        <button type="submit" class="btn btn-primary" id="btn-save"
                                            data-csrf="{{ csrf_token() }}"><i class="fa-solid fa-envelope me-2"></i>Send
                                            Email</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
