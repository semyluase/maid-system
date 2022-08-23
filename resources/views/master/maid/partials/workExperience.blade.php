<form action="#" method="post" id="form-work-experience">
    <div class="row mb-3">
        <div class="col-12 d-flex justify-content-end">
            <a href="javascript:;" class="btn btn-primary" id="btn-add-work"><i class="fa-solid fa-plus me-3"></i>Add New
                Data</a>
        </div>
    </div>
    <div class="row mb-3" id="work-experience[]">
        <div class="row mb-3">
            <div class="col-3 mb-3">
                <label for="work-location" class="form-label">Location</label>
                <input type="text" name="work-location" id="work-location" class="form-control">
            </div>
            <div class="col-3 mb-3">
                <label for="work-start" class="form-label">From</label>
                <input type="text" name="work-start" id="work-start" class="form-control">
            </div>
            <div class="col-3 mb-3">
                <label for="work-end" class="form-label">Until</label>
                <input type="text" name="work-end" id="work-end" class="form-control">
            </div>
            <div class="col-3 mb-3 mt-3 pt-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" name="work-present"
                        id="work-present">
                    <label class="form-check-label" for="work-present">
                        Is Present?
                    </label>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-5">
                <label for="work-description" class="form-label">Work Description</label>
                <textarea name="work-description" id="work-description" rows="4" class="form-control"></textarea>
            </div>
            <div class="col-7 mt-3 pt-3">
                <div class="row mb-3">
                    <div class="col-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="work-overseas"
                                id="work-overseas">
                            <label class="form-check-label" for="work-overseas">
                                Overseas
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" value="1" name="work-singpore"
                                id="work-singpore">
                            <label class="form-check-label" for="work-singpore">
                                Singapore
                            </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-4">
                <label for="work-employeer" class="form-label">Employeer</label>
                <input type="text" name="work-employeer" id="work-employeer" class="form-control">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-5">
                <label for="work-feedback" class="form-label">Employeer Feedback</label>
                <textarea name="work-feedback" id="work-feedback" rows="4" class="form-control"></textarea>
            </div>
        </div>
    </div>
</form>
