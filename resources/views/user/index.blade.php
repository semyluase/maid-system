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
                            <h4 class="card-title">Manage User</h4>
                        </div>
                        <div class="col-6 d-flex hstack gap-2 justify-content-end">
                            <a href="javascript:;" class="btn btn-primary" id="btn-add"><i
                                    class="fa-solid fa-plus me-2"></i>Add New User</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <table class="table table-striped table-responsive" id="tb-user">
                                <thead>
                                    <tr>
                                        <th scope="col">Username</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Role</th>
                                        <th scope="col">Status</th>
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
    <div class="modal fade" id="modalUser" tabindex="-1" aria-labelledby="modalUserLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalUserLabel">Data User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control">
                            <div class="invalid-feedback" id="usernameFeedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="nameUser" class="form-label">Name</label>
                            <input type="text" name="nameUser" id="nameUser" class="form-control">
                            <div class="invalid-feedback" id="nameUserFeedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="emailUser" class="form-label">Email User</label>
                            <input type="email" name="emailUser" id="emailUser" class="form-control">
                            <div class="invalid-feedback" id="emailUserFeedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="countryUser" class="form-label">Country</label>
                            <select type="text" name="countryUser" id="countryUser"
                                class="choices form-control"></select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="roleUser" class="form-label">Role</label>
                            <select type="text" name="roleUser" id="roleUser" class="choices form-control"></select>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="row">
                                <div class="col">
                                    <label for="formal" class="form-label">Format</label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="formal" id="formalTrue"
                                            value="true">
                                        <label class="form-check-label" for="formalTrue">Formal</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="formal" id="formalFalse"
                                            value="false">
                                        <label class="form-check-label" for="formalFalse">Informal</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="passwordUser" class="form-label">Password</label>
                            <input type="password" name="passwordUser" id="passwordUser" class="form-control">
                            <div class="invalid-feedback" id="passwordUserFeedback"></div>
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
