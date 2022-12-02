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
            <div class="row mb-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="h4">Maid</div>
                            </div>
                        </div>
                        <div class="card-body">
                        </div>
                        <div class="card-footer">
                            <div class="d-flex gap-3 justify-content-end">
                                <a href="javascript:;" class="btn btn-outline-danger" id="btn-cancel"><i
                                        class="fa-solid fa-times me-2"></i>Cancel</a>
                                <a href="javascript:;" class="btn btn-outline-primary" id="btn-save"><i
                                        class="fa-solid fa-save me-2"></i>Save Data</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
