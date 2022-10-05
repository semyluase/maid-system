@if (collect($specialities)->count() > 0)
    <div class="row">
        @foreach ($specialities as $speciality)
            @if ($speciality->is_check)
                <div class="col-3 mb-3">
                    <div class="form-check form-check-inline icheck-greensea">
                        <input class="form-check-input" type="checkbox" name="specialityMaid[{{ $speciality->id }}]"
                            id="specialityMaid{{ $speciality->id }}" value="{{ $speciality->id }}"
                            {{ $speciality->answer == 1 ? 'checked' : '' }}>
                        <label class="form-check-label"
                            for="specialityMaid{{ $speciality->id }}">{{ $speciality->question }}</label>
                    </div>
                </div>
            @elseif ($speciality->is_input)
                <div class="col-3 mb-3">
                    <label for="specialityMaid{{ $speciality->id }}"
                        class="form-label">{{ $speciality->question }}</label>
                    <input type="text" name="specialityMaid[{{ $speciality->id }}]"
                        id="specialityMaid[{{ $speciality->id }}]" class="form-control"
                        value="{{ $speciality->note }}">
                </div>
            @endif
        @endforeach
    </div>
@endif
