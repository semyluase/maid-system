<form action="#" method="post" id="form-family">
    <div class="row mb-3">
        <div class="col-8 d-flex justify-content-end">
            <a href="javascript:;" class="btn btn-primary" id="btn-add-family"><i class="fa-solid fa-plus me-2"></i>Add New
                Data</a>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-8">
            <div class="row" id="families[]">
                <div class="col-6 mb-3">
                    <select name="family-relation" id="family-relation" class="form-select choices"></select>
                </div>
                <div class="col-6 mb-3">
                    <input type="text" class="form-control" name="family-name" id="family-name"
                        placeholder="Full Name">
                </div>
                <div class="col-6 mb-3">
                    <input type="text" class="form-control" name="family-dob" id="family-dob"
                        placeholder="DD/MM/YYYY" readonly>
                </div>
                <div class="col-6 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="family-passed-away"
                            id="family-passed-away">
                        <label class="form-check-label" for="family-passed-away">
                            Is Passed Away
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
