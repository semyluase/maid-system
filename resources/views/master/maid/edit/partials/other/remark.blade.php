<div class="row">
    <div class="col-6">
        <div class="row mb-3">
            <div class="col-4">
                <label for="contactMaid" class="form-label">Contact</label>
                <input type="tel" name="contactMaid" id="contactMaid" class="form-control" value="{{ $maid->contact }}">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-6">
                <label for="addressMaid" class="form-label">Address</label>
                <textarea rows="6" name="addressMaid" id="addressMaid" class="form-control">{{ $maid->address }}</textarea>
            </div>
        </div>
    </div>
    <div class="col-6">
        <div class="row mb-3">
            <div class="col-6">
                <label for="noteMaid" class="form-label">Note</label>
                <textarea rows="6" name="noteMaid" id="noteMaid" class="form-control">{{ $maid->note }}</textarea>
            </div>
        </div>
    </div>
</div>
