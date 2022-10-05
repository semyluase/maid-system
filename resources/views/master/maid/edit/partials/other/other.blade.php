@if (collect($others)->count() > 0)
    <div class="row">
        @foreach ($others as $other)
            @if ($other->is_check)
                <div class="col-3 mb-3">
                    <div class="form-check form-check-inline icheck-greensea">
                        <input class="form-check-input" type="checkbox" name="otherMaid[{{ $other->id }}]"
                            id="otherMaid{{ $other->id }}" value="{{ $other->id }}"
                            {{ $other->answer == 1 ? 'checked' : '' }}>
                        <label class="form-check-label" for="otherMaid{{ $other->id }}">{{ $other->question }}</label>
                    </div>
                </div>
            @elseif ($other->is_input)
                <div class="col-3 mb-3">
                    <label for="otherMaid{{ $other->id }}" class="form-label">{{ $other->question }}</label>
                    <input type="text" name="otherMaid[{{ $other->id }}]" id="otherMaid[{{ $other->id }}]"
                        class="form-control" value="{{ $other->note }}">
                </div>
            @endif
        @endforeach
    </div>
@endif
