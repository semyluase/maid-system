<?php

use Illuminate\Support\Carbon;

$codeMaid = $maid ? $maid->code_maid : '';

?>
<div class="row mt-3">
    <div class="col-8">
        <div class="row mb-3">
            <div class="col-lg-4 col-6">
                <label for="codeMaid" class="form-label">Code Maid<span class="text-danger">*</span></label>
                <input type="text" name="codeMaid" id="codeMaid" class="form-control" aria-describedby="codeHelp"
                    value="{{ $codeMaid }}" {{ $codeMaid != '' ? 'readonly' : '' }}>
                <input type="hidden" name="countryRequest" id="countryRequest" class="form-control"
                    value="{{ request('country') }}">
                <div id="codeHelp" class="form-text">Press enter to generate Code</div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6 mb-3">
                <label for="fullnameMaid" class="form-label">Fullname</label>
                <input type="text" name="fullnameMaid" id="fullnameMaid" class="form-control"
                    value="{{ $maid->full_name }}">
            </div>
            <div class="col-6 mb-3 pt-3 mt-3">
                <div class="form-check form-check-inline icheck-greensea">
                    <input class="form-check-input" type="radio" name="sexMaid" id="male" value="1"
                        {{ $maid->sex == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="male">Male</label>
                </div>
                <div class="form-check form-check-inline icheck-greensea">
                    <input class="form-check-input" type="radio" name="sexMaid" id="female" value="2"
                        {{ $maid->sex == 2 ? 'checked' : '' }}>
                    <label class="form-check-label" for="female">Female</label>
                </div>
            </div>
            <div class="col-6 mb-3">
                <label for="pobMaid" class="form-label">Place Of Birth</label>
                <input type="text" name="pobMaid" id="pobMaid" class="form-control"
                    value="{{ $maid->place_of_birth }}">
            </div>
            <div class="col-6 mb-3">
                <label for="dobMaid" class="form-label">Date Of Birth</label>
                <div class="input-group">
                    <input type="text" name="dobMaid" id="dobMaid" class="form-control"
                        aria-describedby="btn-calendar-dob"
                        value="{{ Carbon::parse($maid->date_of_birth)->isoFormat('DD-MM-YYYY') }}">
                    <button class="btn btn-outline-primary" type="button" id="btn-calendar-dob"><i
                            class="fa-solid fa-calendar-alt"></i></button>
                </div>
            </div>
            <div class="col-6 mb-3">
                <label for="addressMaid" class="form-label">Address</label>
                <textarea rows="6" name="addressMaid" id="addressMaid" class="form-control">{{ $maid->address }}</textarea>
            </div>
            <div class="col-6 mb-3">
                <label for="contactMaid" class="form-label">Contact</label>
                <input type="tel" name="contactMaid" id="contactMaid" class="form-control"
                    value="{{ $maid->contact }}">
            </div>
            <div class="col-6 mb-3">
                <label for="photoMaid" class="form-label">Photo</label>
                <input class="form-control" type="file" id="photoMaid" name="photoMaid">
            </div>
            <div class="col-6 mb-3">
                <label for="youtubeMaid" class="form-label">Youtube Link</label>
                <input type="text" name="youtubeMaid" id="youtubeMaid" class="form-control"
                    value="{{ $maid->youtube_link }}">
            </div>
        </div>
    </div>
    <div class="col-4">
        <img src="{{ asset($maid->picture_location . $maid->picture_name) }}" class="img-thumbnail"
            id="photoMaidPreview" alt="Photo" style="max-height: 29em !important; max-width: 100%;">
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <label for="heightMaid" class="form-label">Height</label>
        <input type="number" min="0" name="heightMaid" id="heightMaid" class="form-control"
            value="{{ $maid->height }}">
    </div>
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <label for="weightMaid" class="form-label">Weight</label>
        <input type="number" min="0" name="weightMaid" id="weightMaid" class="form-control"
            value="{{ $maid->weight }}">
    </div>
</div>
<div class="row mb-3">
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <label for="educationMaid" class="form-label">Education Background</label>
        <select name="educationMaid" id="educationMaid" class="form-select choices"></select>
    </div>
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <label for="religionMaid" class="form-label">Religion</label>
        <select name="religionMaid" id="religionMaid" class="form-select choices"></select>
    </div>
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <label for="maritalMaid" class="form-label">Marital Status</label>
        <select name="maritalMaid" id="maritalMaid" class="form-select choices"></select>
    </div>
</div>
<div class="row mb-3">
    <div class="col-3 mb-3">
        <label for="pasporNoMaid" class="form-label">Passport No</label>
        <input type="text" name="pasporNoMaid" id="pasporNoMaid" class="form-control"
            value="{{ $maid->paspor_no }}">
    </div>
    <div class="col-3 mb-3">
        <label for="placeIssueMaid" class="form-label">Issued Place</label>
        <input type="text" name="placeIssueMaid" id="placeIssueMaid" class="form-control"
            value="{{ $maid->paspor_issue }}">
    </div>
    <div class="col-3 mb-3">
        <label for="doiPasporMaid" class="form-label">Issued Date</label>
        <div class="input-group">
            <input type="text" name="doiPasporMaid" id="doiPasporMaid" class="form-control"
                aria-describedby="btn-calendar-dob"
                value="{{ $maid->paspor_date != null ? Carbon::parse($maid->paspor_date)->isoFormat('DD-MM-YYYY') : '' }}">
            <button class="btn btn-outline-primary" type="button" id="btn-calendar-doi"><i
                    class="fa-solid fa-calendar-alt"></i></button>
        </div>
    </div>
    <div class="col-3 mb-3">
        <label for="doePasporMaid" class="form-label">Expired Date</label>
        <div class="input-group">
            <input type="text" name="doePasporMaid" id="doePasporMaid" class="form-control"
                aria-describedby="btn-calendar-dob"
                value="{{ $maid->expire_date != null ? Carbon::parse($maid->expire_date)->isoFormat('DD-MM-YYYY') : '' }}">
            <button class="btn btn-outline-primary" type="button" id="btn-calendar-doe"><i
                    class="fa-solid fa-calendar-alt"></i></button>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <label for="heirMaid" class="form-label">Heir Name</label>
        <input type="text" name="heirMaid" id="heirMaid" class="form-control" value="{{ $maid->hobby }}">
    </div>
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <label for="siblingsMaid" class="form-label">Brother & Sister</label>
        <input type="number" min="0" name="siblingsMaid" id="siblingsMaid" class="form-control"
            value="{{ $maid->number_of_siblings }}">
    </div>
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <label for="positionMaid" class="form-label">Position in the Family</label>
        <input type="number" min="0" name="positionMaid" id="positionMaid" class="form-control"
            value="{{ $maid->number_in_family }}">
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <label for="familyMaid" class="form-label">Family Backgroud</label>
        <input type="text" name="familyMaid" id="familyMaid" class="form-control"
            value="{{ $maid->family_background }}">
    </div>
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <label for="childrenNumberMaid" class="form-label">Number of Children</label>
        <input type="number" min="0" name="childrenNumberMaid" id="childrenNumberMaid" class="form-control"
            value="{{ $maid->number_of_children }}">
    </div>
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <label for="childrenAgeMaid" class="form-label">Age</label>
        <input type="text" name="childrenAgeMaid" id="childrenAgeMaid" class="form-control"
            value="{{ $maid->children_ages }}">
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <label for="spouseNameMaid" class="form-label">Spouse's Name</label>
        <input type="text" name="spouseNameMaid" id="spouseNameMaid" class="form-control"
            value="{{ $maid->spouse_name }}">
    </div>
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <label for="spouseAgeMaid" class="form-label">Spouse's Age</label>
        <input type="number" min="0" name="spouseAgeMaid" id="spouseAgeMaid" class="form-control"
            value="{{ $maid->spouse_age }}">
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <label for="fatherNameMaid" class="form-label">Father's Name</label>
        <input type="text" name="fatherNameMaid" id="fatherNameMaid" class="form-control"
            value="{{ $maid->father_name }}">
    </div>
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <label for="fatherAgeMaid" class="form-label">Father's Age</label>
        <input type="number" min="0" name="fatherAgeMaid" id="fatherAgeMaid" class="form-control"
            value="{{ $maid->father_age }}">
    </div>
</div>
<div class="row">
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <label for="motherNameMaid" class="form-label">Mother's Name</label>
        <input type="text" name="motherNameMaid" id="motherNameMaid" class="form-control"
            value="{{ $maid->mother_name }}">
    </div>
    <div class="col-lg-3 col-md-4 col-6 mb-3">
        <label for="motherAgeMaid" class="form-label">Mother's Age</label>
        <input type="number" min="0" name="motherAgeMaid" id="motherAgeMaid" class="form-control"
            value="{{ $maid->mother_age }}">
    </div>
</div>
