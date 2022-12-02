@if (collect($interviews)->count() > 0)
    <div class="row">
        @foreach ($interviews as $interview)
            @if ($interview->is_check)
                <div class="col-12 mb-3">
                    <label for="#" class="form-label">{{ $interview->question }}</label>
                    <div class="row">
                        <div class="col">
                            <div class="form-check form-check-inline icheck-greensea">
                                <input class="form-check-input" type="checkbox"
                                    name="interviewRateMaid[{{ $interview->id }}]"
                                    id="interviewRateMaidFair1{{ $interview->id }}" value="1">
                                <label class="form-check-label" for="interviewRateMaidFair1{{ $interview->id }}">Fair
                                    1</label>
                            </div>
                            <div class="form-check form-check-inline icheck-greensea">
                                <input class="form-check-input" type="checkbox"
                                    name="interviewRateMaid[{{ $interview->id }}]"
                                    id="interviewRateMaidFair2{{ $interview->id }}" value="2">
                                <label class="form-check-label" for="interviewRateMaidFair2{{ $interview->id }}">Fair
                                    2</label>
                            </div>
                            <div class="form-check form-check-inline icheck-greensea">
                                <input class="form-check-input" type="checkbox"
                                    name="interviewRateMaid[{{ $interview->id }}]"
                                    id="interviewRateMaidGood1{{ $interview->id }}" value="3">
                                <label class="form-check-label" for="interviewRateMaidGood1{{ $interview->id }}">Good
                                    1</label>
                            </div>
                            <div class="form-check form-check-inline icheck-greensea">
                                <input class="form-check-input" type="checkbox"
                                    name="interviewRateMaid[{{ $interview->id }}]"
                                    id="interviewRateMaidGood2{{ $interview->id }}" value="4">
                                <label class="form-check-label" for="interviewRateMaidGood2{{ $interview->id }}">Good
                                    2</label>
                            </div>
                            <div class="form-check form-check-inline icheck-greensea">
                                <input class="form-check-input" type="checkbox"
                                    name="interviewRateMaid[{{ $interview->id }}]"
                                    id="interviewRateMaidGood3{{ $interview->id }}" value="5">
                                <label class="form-check-label" for="interviewRateMaidGood3{{ $interview->id }}">Good
                                    3</label>
                            </div>
                            <div class="form-check form-check-inline icheck-greensea">
                                <input class="form-check-input" type="checkbox"
                                    name="interviewRateMaid[{{ $interview->id }}]"
                                    id="interviewRateMaidExcellent1{{ $interview->id }}" value="6">
                                <label class="form-check-label"
                                    for="interviewRateMaidExcellent1{{ $interview->id }}">Excellent 1</label>
                            </div>
                            <div class="form-check form-check-inline icheck-greensea">
                                <input class="form-check-input" type="checkbox"
                                    name="interviewRateMaid[{{ $interview->id }}]"
                                    id="interviewRateMaidExcellent2{{ $interview->id }}" value="7">
                                <label class="form-check-label"
                                    for="interviewRateMaidExcellent2{{ $interview->id }}">Excellent 2</label>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
    </div>
@endif
