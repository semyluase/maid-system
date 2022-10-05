@if (collect($medicals)->count() > 0)
    <div class="row">
        @foreach ($medicals as $medical)
            @if ($medical->is_check)
                <div class="col-4 mb-3">
                    <label for="#" class="form-label">{{ $medical->question }}</label>
                    <div class="row">
                        <div class="col">
                            <div class="form-check form-check-inline icheck-greensea">
                                <input class="form-check-input" type="radio" name="medicalMaid[{{ $medical->id }}]"
                                    id="medicalMaidYes{{ $medical->id }}" value="1"
                                    {{ $medical->answer == 1 ? 'checked' : '' }}>
                                <label class="form-check-label" for="medicalMaidYes{{ $medical->id }}">Yes</label>
                            </div>
                            <div class="form-check form-check-inline icheck-danger">
                                <input class="form-check-input" type="radio" name="medicalMaid[{{ $medical->id }}]"
                                    id="medicalMaidNo{{ $medical->id }}" value="0"
                                    {{ $medical->answer == 1 ? '' : 'checked' }}>
                                <label class="form-check-label" for="medicalMaidNo{{ $medical->id }}">No</label>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif
