@extends('layouts.main')

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $pageHead }}</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-lg-12 col-md-6 col-sm-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <h4 class="card-title">Manage Role Menu</h4>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-4">
                                    <select class="choices form-control" name="role" id="role"></select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div id="jstree-menu"></div>
                                    <div class="form-group" style="margin-top: 20px;">
                                        <a href="javascript:;" class="btn btn-primary d-none" id="simpan-jstree"
                                            data-csrf="{{ csrf_token() }}"><i class="fas fa-save me-2"></i>Save</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
