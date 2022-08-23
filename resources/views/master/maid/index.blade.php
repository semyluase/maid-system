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
            <div class="row mb-3" id="tb-maid-section">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-6">
                                    <div class="card-title">
                                        <div class="h4">Maid</div>
                                    </div>
                                </div>
                                <div class="col-6 d-flex justify-content-end">
                                    <a href="javascript:;" class="btn btn-primary" id="btn-add"><i
                                            class="fa-solid fa-plus me-2"></i>Add New Maid</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-responsive table-striped" id="tb-maid" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Maid Code</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Date of Birth</th>
                                                <th scope="col">#</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
