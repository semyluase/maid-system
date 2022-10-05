<div class="row mb-3">
    <div class="col">
        <table class="table table-striped table-bordered border-dark" id="tb-work-experience">
            <thead class="bg-light-secondary">
                <tr class="text-center font-semibold">
                    <th scope="col" colspan="2">Date</th>
                    <th scope="col" rowspan="2">Country (including FDW's home country)</th>
                    <th scope="col" rowspan="2">Employer</th>
                    <th scope="col" rowspan="2">Work Duties</th>
                    <th scope="col" rowspan="2">Remarks</th>
                    <th scope="col" rowspan="2">
                        <a href="javascript:;" class="btn btn-primary" id="btn-add-work"><i
                                class="fa-solid fa-plus me-2"></i>Add data work</a>
                    </th>
                </tr>
                <tr class="text-center font-semibold">
                    <th scope="col">From</th>
                    <th scope="col">To</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<div class="row mb-3">
    <div class="col">
        <label for="" class="form-label">Previous working experience in Singapore</label>
        <div class="form-check form-check-inline icheck-greensea">
            <input class="form-check-input" type="radio" name="workSingaporeMaid" id="workSingaporeMaidYes"
                value="1">
            <label class="form-check-label" for="workSingaporeMaidYes">Yes</label>
        </div>
        <div class="form-check form-check-inline icheck-greensea">
            <input class="form-check-input" type="radio" name="workSingaporeMaid" id="workSingaporeMaidNo"
                value="0">
            <label class="form-check-label" for="workSingaporeMaidNo">No</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <table class="table table-striped table-bordered border-dark" id="tb-work-experience-feedback">
            <thead class="bg-light-secondary">
                <tr class="text-center font-semibold">
                    <th scope="col">Employer</th>
                    <th scope="col">Feedback</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
@include('master.maid.forms.partials.singapore.modal.workExperience')
