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
            <div class="card">
                <div class="card-header">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="card-title">History Maid</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <table class="table table-striped table-responsive" id="tb-maid">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Code Maid</th>
                                        <th scope="col">Fullname</th>
                                        <th scope="col">Country</th>
                                        <th scope="col">User</th>
                                        <th scope="col">Delete</th>
                                        <th scope="col">#</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
