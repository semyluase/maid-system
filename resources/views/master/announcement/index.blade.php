@extends('layouts.main')
@section('content')
    <style>
        .ck-editor__editable[role="textbox"] {
            /* editing area */
            min-height: 200px;
            margin-bottom: 2rem;
        }
    </style>
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
                        <div class="col-6 d-flex hstack gap-2 justify-content-end">
                            <a href="javascript:;" class="btn btn-primary" id="btn-add"><i
                                    class="fa-solid fa-plus me-2"></i>New Data</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col">
                            <table class="table table-striped table-responsive" id="tb-announcement">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Duration</th>
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
    <div class="modal fade" id="modalAnnouncement" tabindex="-1" aria-labelledby="modalAnnouncementLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAnnouncementLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="titleAnnouncement" class="form-label">Title</label>
                            <input type="text" name="titleAnnouncement" id="titleAnnouncement" class="form-control">
                            <input type="hidden" name="idAnnouncement" id="idAnnouncement" class="form-control">
                            <input type="hidden" name="oldSlugAnnouncement" id="oldSlugAnnouncement" class="form-control">
                            <div class="invalid-feedback" id="titleAnnouncementFeedback"></div>
                        </div>
                    </div>
                    <div class="row mb-6">
                        <div class="col">
                            <label for="bodyAnnouncement" class="form-label">Body</label>
                            <textarea id="bodyAnnouncement" class="form-control" rows="10" name="bodyAnnouncement"></textarea>
                            <div class="invalid-feedback" id="bodyAnnouncementFeedback"></div>
                        </div>
                    </div>
                    <div class="row mb-3 mt-6">
                        <div class="col">
                            <label for="durationAnnouncement" class="form-label">Start - End Announcement</label>
                            <div class="input-group mb-3 input-daterange" id="rangeDateAnnouncement">
                                <input type="text" class="form-control" id="startDate" name="startDate">
                                <span class="input-group-text">to</span>
                                <input type="text" class="form-control" id="endDate" name="endDate">
                            </div>
                            <div class="invalid-feedback" id="rangeDateAnnouncementFeedback"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i
                            class="fa-solid fa-times me-2"></i>Cancel</button>
                    <button type="button" class="btn btn-outline-primary" id="btn-save" data-csrf="{{ csrf_token() }}"><i
                            class="fa-solid fa-save me-2"></i>Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection
