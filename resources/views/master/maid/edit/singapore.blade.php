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
                    <form action="#" method="post" id="form-data" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <div class="h4">Maid</div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="divider-left divider">
                                    <div class="divider-text fw-bold">Personal Information</div>
                                </div>
                                @include('master.maid.edit.partials.singapore.data')
                                <div class="divider-left divider">
                                    <div class="divider-text fw-bold">Medical History/Dietary Restrictions</div>
                                </div>
                                @include('master.maid.edit.partials.singapore.medical')
                                <div class="divider-left divider">
                                    <div class="divider-text fw-bold">Other</div>
                                </div>
                                @include('master.maid.edit.partials.singapore.other')
                                <div class="divider-left divider">
                                    <div class="divider-text fw-bold">Methods of Evaluation of Skills</div>
                                </div>
                                @include('master.maid.edit.partials.singapore.skill')
                                <div class="divider-left divider">
                                    <div class="divider-text fw-bold">Employment History Overseas</div>
                                </div>
                                @include('master.maid.edit.partials.singapore.workExperience')
                                <div class="divider-left divider">
                                    <div class="divider-text fw-bold">Availability of FDW To Be Interviewed By Prospective
                                        Employer</div>
                                </div>
                                @include('master.maid.edit.partials.singapore.interview')
                                <div class="divider-left divider">
                                    <div class="divider-text fw-bold">Other Remarks</div>
                                </div>
                                @include('master.maid.edit.partials.singapore.remarks')
                            </div>
                            <div class="card-footer">
                                <div class="d-flex gap-3 justify-content-end">
                                    <a href="javascript:;" class="btn btn-outline-danger" id="btn-cancel"
                                        onclick="window.close()"><i class="fa-solid fa-times me-2"></i>Cancel</a>
                                    <a href="javascript:;" class="btn btn-outline-primary" id="btn-save"><i
                                            class="fa-solid fa-save me-2"></i>Save Data</a>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection
