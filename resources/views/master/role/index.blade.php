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
                            <h4 class="card-title">Master Role</h4>
                        </div>
                        <div class="col-6 d-flex hstack gap-2 justify-content-end">
                            <a href="javascript:;" class="btn btn-primary" id="btn-add"><i
                                    class="fa-solid fa-plus me-2"></i>Add New</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <table class="table table-striped table-responsive" id="tb-role">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Insert</th>
                                        <th scope="col">Update</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="modalRole" tabindex="-1" aria-labelledby="modalRoleLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalRoleLabel">Data Role</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="nameRole" class="form-label">Name Role <small class="text-muted">(abbreviation or
                                    role name)</small></label>
                            <input type="text" name="nameRole" id="nameRole" class="form-control">
                            <input type="hidden" name="idRole" id="idRole" class="form-control">
                            <input type="hidden" name="oldSlugRole" id="oldSlugRole" class="form-control">
                            <div class="invalid-feedback" id="nameRoleFeedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="descriptionRole" class="form-label">Description <small class="text-muted">(Full name
                                    or description role)</small></label>
                            <input type="text" name="descriptionRole" id="descriptionRole" class="form-control">
                            <div class="invalid-feedback" id="descriptionRoleFeedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i
                            class="fa-solid fa-times me-2"></i>Batal</button>
                    <button type="button" class="btn btn-outline-primary" id="btn-submit"
                        data-csrf="{{ csrf_token() }}"><i class="fa-solid fa-save me-2"></i>Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection
