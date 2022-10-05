@if (collect($specialities)->count() > 0)
    <div class="row">
        @foreach ($specialities as $speciality)
            @if ($speciality->is_check)
                <div class="col-3 mb-3">
                    <div class="form-check form-check-inline icheck-greensea">
                        <input class="form-check-input" type="checkbox" name="cookingMaid[{{ $speciality->id }}]"
                            id="cookingMaid{{ $speciality->id }}" value="1"
                            {{ $speciality->answer == 1 ? 'checked' : '' }}>
                        <label class="form-check-label"
                            for="cookingMaid{{ $speciality->id }}">{{ $speciality->question }}</label>
                    </div>
                </div>
            @elseif ($speciality->is_input)
                <div class="col-3 mb-3">
                    <label for="cookingMaid{{ $speciality->id }}" class="form-label">{{ $speciality->question }}</label>
                    <input type="text" name="cookingMaid[{{ $speciality->id }}]"
                        id="cookingMaid[{{ $speciality->id }}]" class="form-control" value="{{ $speciality->note }}">
                </div>
            @endif
        @endforeach
    </div>
@endif
