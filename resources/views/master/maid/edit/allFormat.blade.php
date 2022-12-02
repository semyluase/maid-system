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
                        <form action="#" method="post" id="form-data-edit" enctype="multipart/form-data">
                            @csrf
                            <div class="card-header">
                                <div class="card-title">
                                    <div class="h4">Maid</div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="divider-left divider">
                                    <div class="divider-text">Data Maid</div>
                                </div>
                                @include('master.maid.edit.partials.allFormat.data')
                                <div class="divider-left divider">
                                    <div class="divider-text">Work Experience</div>
                                </div>
                                @include('master.maid.edit.partials.allFormat.workExperience')
                                <div class="divider-left divider">
                                    <div class="divider-text">Language</div>
                                </div>
                                @include('master.maid.edit.partials.allFormat.language')
                                <div class="divider-left divider">
                                    <div class="divider-text">Medical</div>
                                </div>
                                @include('master.maid.edit.partials.allFormat.medical')
                                <div class="divider-left divider">
                                    <div class="divider-text">Cooking Ability</div>
                                </div>
                                @include('master.maid.edit.partials.allFormat.cooking')
                                <div class="divider-left divider">
                                    <div class="divider-text">Work Chosen</div>
                                </div>
                                @include('master.maid.edit.partials.allFormat.work')
                                <div class="divider-left divider">
                                    <div class="divider-text">Interview Appraisal</div>
                                </div>
                                @include('master.maid.edit.partials.allFormat.interview')
                                <div class="divider-left divider">
                                    <div class="divider-text">
                                        @include('master.maid.edit.partials.allFormat.remarks')
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="d-flex gap-3 justify-content-end">
                                        <a href="javascript:;" class="btn btn-outline-danger" id="btn-cancel"
                                            onclick="window.close()"><i class="fa-solid fa-times me-2"></i>Cancel</a>
                                        <a href="javascript:;" class="btn btn-outline-primary" id="btn-save"><i
                                                class="fa-solid fa-save me-2"></i>Save Data</a>
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
