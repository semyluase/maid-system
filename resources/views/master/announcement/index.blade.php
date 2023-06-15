@extends('layouts.main')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/mazer/dist/assets/vendors/quill/quill.snow.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/mazer/dist/assets/vendors/quill/quill.bubble.css') }}">
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $pageTitle }}</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card" id="table-card">
                <div class="card-header">
                    <div class="row mb-3">
                        <div class="col-6">
                            <h4 class="card-title">Announcement</h4>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4 pb-4">
                        <div class="col">
                            <div id="body">{!! $announcement->body !!}</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col d-flex justify-content-end">
                            <button type="button" class="btn btn-primary" id="btn-save-announcement"
                                data-csrf="{{ csrf_token() }}"><i class="fa-solid fa-save me-2"></i>Save
                                Announcement</button>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="table-responsive">
                                <table class="table table-striped table-responsive" id="tb-contact-person">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Name</th>
                                            <th scope="col">Branch</th>
                                            <th scope="col">Whatsapp</th>
                                            <th scope="col">Code</th>
                                            <th scope="col">
                                                <div class="d-flex gap-2">
                                                    <a href="javascript:;" class="btn btn-primary btn-sm"
                                                        id="btn-add-contact-person"><i class="fa-solid fa-plus me-2"></i>New
                                                        Contact Person</a>
                                                    <a href="javascript:;" class="btn btn-outline-primary btn-sm"
                                                        id="btn-sort-contact-person"><i
                                                            class="fa-solid fa-sync me-2"></i>Sort Contact Person</a>
                                                </div>
                                            </th>
                                        </tr>
                                    </thead>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade" id="modal-contact-person" tabindex="-1" aria-labelledby="modal-contact-person-label"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-contact-person-label">Contact Person</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" id="name" class="form-control">
                            <input type="hidden" name="id-contact" id="id-contact" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="branch" class="form-label">Branch</label>
                            <input type="text" name="branch" id="branch" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="whatsapp" class="form-label">Whatsapp</label>
                            <input type="text" name="whatsapp" id="whatsapp" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="code" class="form-label">Code</label>
                            <input type="text" name="code" id="code" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i
                            class="fa-solid fa-times me-2"></i>Cancel</button>
                    <button type="button" class="btn btn-outline-primary" id="btn-save"
                        data-csrf="{{ csrf_token() }}"><i class="fa-solid fa-save me-2"></i>Save</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal-sort-contact-person" tabindex="-1" aria-labelledby="modal-contact-person-label"
        aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-contact-person-label">Sort Contact Person</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- <div class="row mb-3">
                        <div class="col">
                            <table class="table table-striped table-sortable" id="tb-sort" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Branch</th>
                                        <th>Code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($contactPerson as $contact)
                                        <tr>
                                            <td>
                                                <span class="fa-solid fa-grip-lines-vertical" id="index"
                                                    data-sort="{{ $contact->id }}"></span>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                {{ $contact->name }}
                                            </td>
                                            <td>
                                                {{ $contact->branch }}
                                            </td>
                                            <td>
                                                {{ $contact->code }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div> --}}
                    <div id="simple-list" class="row">
                        <div id="example1" class="list-group col">

                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i
                            class="fa-solid fa-times me-2"></i>Cancel</button>
                    <button type="button" class="btn btn-outline-primary" id="btn-save-sort"
                        data-csrf="{{ csrf_token() }}"><i class="fa-solid fa-save me-2"></i>Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
