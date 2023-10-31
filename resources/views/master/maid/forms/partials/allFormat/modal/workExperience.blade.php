<?php

$codeMaid = $maid ? $maid->code_maid : '';

?>
<div class="modal fade" id="modal-work-experience" tabindex="-1" aria-labelledby="modal-work-experience-label"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal-work-experience-label">Data Work Experience</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <input type="hidden" name="idWorkMaid" class="form-control" id="idWorkMaid">
            <div class="modal-body" id="modal-old-experiences">
                <div class="row mb-3">
                    <div class="col">
                        <label for="startWork" class="form-label">From</label>
                        <select name="startWork" id="startWork" class="form-select choices"></select>
                    </div>
                    <div class="col">
                        <label for="endWork" class="form-label">To</label>
                        <select name="endWork" id="endWork" class="form-select choices"></select>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col">
                        <label for="locationWork" class="form-label">Location</label>
                        <input type="text" name="locationWork" id="locationWork" class="form-control">
                    </div>
                    <div class="col pt-3 mt-3">
                        <div class="form-check icheck-greensea">
                            <input class="form-check-input" type="checkbox" value="1" name="overseasWork"
                                id="overseasWork">
                            <label class="form-check-label" for="overseasWork">
                                Overseas
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-9">
                        <label for="descriptionWork" class="form-label">Description/Work Duties</label>
                        <textarea name="descriptionWork" id="descriptionWork" cols="" rows="7" class="form-control"></textarea>
                    </div>
                </div>
                <div id="new-experience">
                    <div class="row mb-3">
                        <div class="col">
                            <label for="locationWorkNew" class="form-label">Location</label>
                            <input type="text" name="locationWorkNew" id="locationWorkNew" class="form-control">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <label for="startWorkNew" class="form-label">From</label>
                            <select name="startWorkNew" id="startWorkNew" class="form-select choices"></select>
                        </div>
                        <div class="col">
                            <label for="endWorkNew" class="form-label">To</label>
                            <select name="endWorkNew" id="endWorkNew" class="form-select choices"></select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal"><i
                        class="fa-solid fa-times me-2"></i>Cancel</button>
                <button type="button" class="btn btn-outline-primary" id="btn-save-work"
                    data-csrf="{{ csrf_token() }}"><i class="fa-solid fa-save me-2"></i>Save
                    Data</button>
            </div>
        </div>
    </div>
</div>
