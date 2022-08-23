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
                            <h4 class="card-title">Master Enumertion</h4>
                        </div>
                        <div class="col-6 d-flex hstack gap-2 justify-content-end">
                            <a href="javascript:;" class="btn btn-primary" id="btn-add"><i
                                    class="fa-solid fa-plus me-2"></i>New Data</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <table class="table table-striped table-responsive" id="tb-enum">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Name <small class="text-muted">(HK)</small></th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Insert</th>
                                        <th scope="col">Update</th>
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
    <div class="modal fade" id="modalEnum" tabindex="-1" aria-labelledby="modalEnumLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEnumLabel">Data Enumeration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="codeEnum" class="form-label">Code</label>
                            <input type="text" name="codeEnum" id="codeEnum" class="form-control">
                            <input type="hidden" name="idEnum" id="idEnum" class="form-control">
                            <input type="hidden" name="oldSlugEnum" id="oldSlugEnum" class="form-control">
                            <div class="invalid-feedback" id="codeEnumFeedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="nameEnum" class="form-label">Name</label>
                            <input type="text" name="nameEnum" id="nameEnum" class="form-control">
                            <div class="invalid-feedback" id="nameEnumFeedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="nameHKEnum" class="form-label">Name <small class="text-muted">(HK)</small></label>
                            <input type="text" name="nameHKEnum" id="nameHKEnum" class="form-control">
                            <div class="invalid-feedback" id="nameHKEnumFeedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="categoryEnum" class="form-label">Category</label>
                            <input type="text" name="categoryEnum" id="categoryEnum" class="form-control">
                            <div class="invalid-feedback" id="categoryEnumFeedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i
                            class="fa-solid fa-times me-2"></i>Cancel</button>
                    <button type="button" class="btn btn-outline-primary" id="btn-submit"
                        data-csrf="{{ csrf_token() }}"><i class="fa-solid fa-save me-2"></i>Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
