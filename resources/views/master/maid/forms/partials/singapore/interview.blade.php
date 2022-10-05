@if (collect($interviews)->count() > 0)
    <div class="row">
        @foreach ($interviews as $interview)
            @if ($interview->is_check)
                <div class="col-12 mb-3">
                    <div class="form-check form-check-inline icheck-greensea">
                        <input class="form-check-input" type="checkbox" name="interviewMaid[{{ $interview->id }}]"
                            id="interviewMaid{{ $interview->id }}" value="1">
                        <label class="form-check-label"
                            for="interviewMaid{{ $interview->id }}">{{ $interview->question }}</label>
                    </div>
                </div>
            @elseif ($interview->is_input)
                <div class="col-12 mb-3">
                    <label for="interviewMaid{{ $interview->id }}" class="form-label">{{ $interview->question }}</label>
                    <input type="text" name="interviewMaid[{{ $interview->id }}]"
                        id="interviewMaid[{{ $interview->id }}]" class="form-control">
                </div>
            @endif
        @endforeach
    </div>
@endif
