@if (collect($willingnesses)->count() > 0)
    <div class="row">
        @foreach ($willingnesses as $willingness)
            @if ($willingness->is_check)
                <div class="col-3 mb-3">
                    <div class="form-check form-check-inline icheck-greensea">
                        <input class="form-check-input" type="checkbox" name="workChosenMaid[{{ $willingness->id }}]"
                            id="workChosenMaid{{ $willingness->id }}" value="1"
                            {{ $willingness->answer == 1 ? 'checked' : '' }}>
                        <label class="form-check-label"
                            for="workChosenMaid{{ $willingness->id }}">{{ $willingness->question }}</label>
                    </div>
                </div>
            @elseif ($willingness->is_input)
                <div class="col-3 mb-3">
                    <label for="workChosenMaid{{ $willingness->id }}"
                        class="form-label">{{ $willingness->question }}</label>
                    <input type="text" name="workChosenMaid[{{ $willingness->id }}]"
                        id="workChosenMaid[{{ $willingness->id }}]" class="form-control"
                        value="{{ $willingness->note }}">
                </div>
            @endif
        @endforeach
    </div>
@endif
