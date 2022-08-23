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
                            <div class="row">
                                <div class="col-12">
                                    <ul class="nav nav-tabs nav-fill" id="myTab" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link active" id="data-maid-tab" data-bs-toggle="tab"
                                                data-bs-target="#data-maid" type="button" role="tab"
                                                aria-controls="data-maid" aria-selected="true">Data Maid</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="family-maid-tab" data-bs-toggle="tab"
                                                data-bs-target="#family-maid" type="button" role="tab"
                                                aria-controls="family-maid" aria-selected="false">Family</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="work-experience-maid-tab" data-bs-toggle="tab"
                                                data-bs-target="#work-experience-maid" type="button" role="tab"
                                                aria-controls="work-experience-maid" aria-selected="false">Work
                                                Experience</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="language-maid-tab" data-bs-toggle="tab"
                                                data-bs-target="#language-maid" type="button" role="tab"
                                                aria-controls="language-maid" aria-selected="false">Language</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="document-maid-tab" data-bs-toggle="tab"
                                                data-bs-target="#document-maid" type="button" role="tab"
                                                aria-controls="document-maid" aria-selected="false">Document</button>
                                        </li>
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link" id="other-maid-tab" data-bs-toggle="tab"
                                                data-bs-target="#other-maid" type="button" role="tab"
                                                aria-controls="other-maid" aria-selected="false">Other Data</button>
                                        </li>
                                    </ul>
                                    <div class="tab-content mt-4" id="myTabContent">
                                        <div class="tab-pane fade show active" id="data-maid" role="tabpanel"
                                            aria-labelledby="data-maid-tab">
                                            @include('master.maid.partials.dataMaid')
                                        </div>
                                        <div class="tab-pane fade" id="family-maid" role="tabpanel"
                                            aria-labelledby="family-maid-tab">
                                            @include('master.maid.partials.family')
                                        </div>
                                        <div class="tab-pane fade" id="work-experience-maid" role="tabpanel"
                                            aria-labelledby="work-experience-maid-tab">
                                            @include('master.maid.partials.workExperience')
                                        </div>
                                        <div class="tab-pane fade" id="language-maid" role="tabpanel"
                                            aria-labelledby="language-maid-tab">...</div>
                                        <div class="tab-pane fade" id="document-maid" role="tabpanel"
                                            aria-labelledby="document-maid-tab">...</div>
                                        <div class="tab-pane fade" id="other-maid" role="tabpanel"
                                            aria-labelledby="other-maid-tab">...</div>
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
