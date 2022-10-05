@if (collect($languages)->count() > 0)
    <div class="row">
        @foreach ($languages as $language)
            @if ($language->is_check)
                <div class="col-4 mb-3">
                    <div class="form-check form-check-inline icheck-greensea">
                        <input class="form-check-input" type="checkbox" name="languageMaid[{{ $language->id }}]"
                            id="languageMaid{{ $language->id }}" value="{{ $language->id }}"
                            {{ $language->answer == 1 ? 'checked' : '' }}>
                        <label class="form-check-label"
                            for="languageMaid{{ $language->id }}">{{ $language->question }}</label>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif
