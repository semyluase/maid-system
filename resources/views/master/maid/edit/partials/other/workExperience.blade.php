<div class="row my-3">
    <div class="col-12">
        <table class="table table-stripped table-bordered border border-dark" id="tb-work-experience">
            <thead>
                <tr class="text-dark text-center font-semibold">
                    <th scope="col" rowspan="2">#</th>
                    <th scope="col" colspan="2">Date</th>
                    <th scope="col" rowspan="2">Location</th>
                    <th scope="col" rowspan="2">Description/Work Duties</th>
                    <th scope="col" rowspan="2">
                        <a href="javascript:;" class="btn btn-primary btn-block" id="btn-add-work"><i
                                class="fa-solid fa-plus me-2"></i>Add
                            Data</a>
                    </th>
                </tr>
                <tr class="text-dark text-center font-semibold">
                    <th scope="col">From</th>
                    <th scope="col">To</th>
                </tr>
            </thead>
        </table>
    </div>
</div>
<script>
    let country = "{{ request('country') }}";
</script>
@include('master.maid.edit.partials.other.modal.workExperience')
