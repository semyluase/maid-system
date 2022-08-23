<form action="#" method="post" enctype="multipart/form-data" id="formDataMaid">
    <div class="row mb-3">
        <div class="col-2">
            <label for="prefixMaid" class="form-label">Prefix</label>
            <input type="text" name="prefixMaid" id="prefixMaid" class="form-control">
            <input type="hidden" name="idMaid" class="form-control idMaid">
            <div class="invalid-feedback" id="prefixMaidFeedback"></div>
        </div>
        <div class="col-2 mt-3 pt-3">
            <input type="text" name="indexMaid" id="indexMaid" class="form-control" readonly>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-3 col-md-4 col-sm-6">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" name="firstName" id="firstName" class="form-control">
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" name="lastName" id="lastName" class="form-control">
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <div class="row">
                <div class="col-6">
                    <label for="placeOfBirth" class="form-label">Place of Birth</label>
                    <input type="text" name="placeBirthMaid" id="placeBirthMaid" class="form-control">
                </div>
                <div class="col-6">
                    <label for="dateOfBirth" class="form-label">Date of Birth</label>
                    <input type="text" name="dateBirthMaid" id="dateBirthMaid" class="form-control">
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-3 col-md-4 col-sm-6">
            <label for="heightMaid" class="form-label">Height</label>
            <input type="number" name="heightMaid" min="0" id="heightMaid" class="form-control">
            <div class="invalid-feedback" id="heightMaidFeedback"></div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <label for="weightMaid" class="form-label">Weight</label>
            <input type="number" name="weightMaid" min="0" id="weightMaid" class="form-control">
            <div class="invalid-feedback" id="weightMaidFeedback"></div>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <label for="bloodType" class="form-label">Blood Type</label>
            <input type="number" name="bloodType" min="0" id="bloodType" class="form-control">
            <div class="invalid-feedback" id="bloodTypeFeedback"></div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-3 col-md-4 col-sm-6">
            <label for="educationMaid" class="form-label">Last Education</label>
            <select name="educationMaid" id="educationMaid" class="form-select choices"></select>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6">
            <label for="religionMaid" class="form-label">Religion</label>
            <select name="religionMaid" id="religionMaid" class="form-select choices"></select>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
            <label for="provinceMaid" class="form-label">Province</label>
            <select name="provinceMaid" id="provinceMaid" class="form-select choices"></select>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
            <label for="regencyMaid" class="form-label">Regency</label>
            <select name="regencyMaid" id="regencyMaid" class="form-select choices"></select>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
            <label for="districtMaid" class="form-label">District</label>
            <select name="districtMaid" id="districtMaid" class="form-select choices"></select>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
            <label for="villageMaid" class="form-label">Village</label>
            <select name="villageMaid" id="villageMaid" class="form-select choices"></select>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
            <label for="addressMaid" class="form-label">Address</label>
            <textarea name="addressMaid" id="addressMaid" class="form-control" rows="5"></textarea>
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
            <label for="contactMaid" class="form-label">Contact</label>
            <input type="tel" name="contactMaid" id="contactMaid" class="form-control">
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
            <label for="portOrAirport" class="form-label">Port/Airport Name</label>
            <input type="text" name="portOrAirport" id="portOrAirport" class="form-control">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
            <label for="numberInFamily" class="form-label">Number in Family</label>
            <input type="number" name="numberInFamily" min="0" id="numberInFamily" class="form-control">
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
            <label for="brotherMaid" class="form-label">Brother</label>
            <input type="number" name="brotherMaid" min="0" id="brotherMaid" class="form-control">
        </div>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
            <label for="sisterMaid" class="form-label">Sister</label>
            <input type="number" name="sisterMaid" min="0" id="sisterMaid" class="form-control">
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
            <figure class="figure border border-1 border-primary rounded bg-secondary"
                style="width: 100%; height:30rem;">
                <img src="" alt="Maid Photo" class="figure-img img-fluid rounded">
            </figure>
        </div>
        <div class="col-lg-4 col-md-6 col-sm-12 mb-3">
            <div class="row mb-3">
                <div class="col-12">
                    <label for="formFile" class="form-label">Maid Photo</label>
                    <input class="form-control" type="file" id="formFile">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <label for="youtubeMaid" class="form-label">URL Maid Video</label>
                    <input type="text" class="form-control" id="youtubeMaid" name="youtubeMaid">
                </div>
            </div>
        </div>
    </div>
    <hr class="divider">
    <div class="row">
        <div class="col d-flex gap-3 justify-content-end">
            <a href="javascript:;" class="btn btn-outline-danger"><i class="fa-solid fa-times me-2"></i>Cancel</a>
            <a href="javascript:;" class="btn btn-outline-success"><i class="fa-solid fa-chevron-right me-2"></i>Next
                Step</a>
        </div>
    </div>
</form>
