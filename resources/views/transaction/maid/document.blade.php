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
                            <h4 class="card-title">Job Document</h4>
                        </div>
                        <div class="col-6 d-flex hstack gap-2 justify-content-end">
                            <a href="javascript:;" class="btn btn-primary" onclick="window.close()"><i
                                    class="fa-solid fa-arrow-left me-2"></i>Back</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @foreach ($documents as $document)
                        <div class="row mb-3">
                            <div class="col">
                                <img src="{{ asset($document->doc_location . $document->doc_filename) }}" alt="Document"
                                    class="img-fluid">
                            </div>
                        </div>
                    @endforeach
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-primary"
                                onclick="window.open('{{ url('') }}/transaction/maids/downloads?maids={{ $maid->code_maid }}','_blanks')"><i
                                    class="fa-solid fa-download me-2"></i>Download Data</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
