@if (collect($languages)->count() > 0)
    <div class="row">
        @foreach ($languages as $language)
            @if ($language->is_check)
                <div class="col-12 mb-3">
                    <label for="#" class="form-label">{{ $language->question }}</label>
                    <div class="row">
                        <div class="col">
                            <div class="form-check form-check-inline icheck-greensea">
                                <input class="form-check-input" type="radio" name="languageRateMaid[{{ $language->id }}]"
                                    id="languageRateMaidPoor{{ $language->id }}" value="1"
                                    {{ $language->rate == 1 ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="languageRateMaidPoor{{ $language->id }}">Poor</label>
                            </div>
                            <div class="form-check form-check-inline icheck-greensea">
                                <input class="form-check-input" type="radio"
                                    name="languageRateMaid[{{ $language->id }}]"
                                    id="languageRateMaidFair{{ $language->id }}" value="2"
                                    {{ $language->rate == 2 ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="languageRateMaidFair{{ $language->id }}">Fair</label>
                            </div>
                            <div class="form-check form-check-inline icheck-greensea">
                                <input class="form-check-input" type="radio"
                                    name="languageRateMaid[{{ $language->id }}]"
                                    id="languageRateMaidGood{{ $language->id }}" value="3"
                                    {{ $language->rate == 3 ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="languageRateMaidGood{{ $language->id }}">Good</label>
                            </div>
                            <div class="form-check form-check-inline icheck-greensea">
                                <input class="form-check-input" type="radio"
                                    name="languageRateMaid[{{ $language->id }}]"
                                    id="languageRateMaidVeryGood{{ $language->id }}" value="4"
                                    {{ $language->rate == 4 ? 'checked' : '' }}>
                                <label class="form-check-label" for="languageRateMaidVeryGood{{ $language->id }}">Very
                                    Good</label>
                            </div>
                            <div class="form-check form-check-inline icheck-greensea">
                                <input class="form-check-input" type="radio"
                                    name="languageRateMaid[{{ $language->id }}]"
                                    id="languageRateMaidExcellent{{ $language->id }}" value="5"
                                    {{ $language->rate == 5 ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="languageRateMaidExcellent{{ $language->id }}">Excellent</label>
                            </div>
                            <div class="form-check form-check-inline icheck-greensea">
                                <input class="form-check-input" type="radio"
                                    name="languageRateMaid[{{ $language->id }}]"
                                    id="languageRateMaidNa{{ $language->id }}" value="0"
                                    {{ $language->rate == 0 ? 'checked' : '' }}>
                                <label class="form-check-label" for="languageRateMaidNa{{ $language->id }}">N/A</label>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif
