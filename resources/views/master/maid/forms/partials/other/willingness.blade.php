@if (collect($willingnesses)->count() > 0)
    <div class="row">
        @foreach ($willingnesses as $willingness)
            @if ($willingness->is_check)
                <div class="col-3 mb-3">
                    <div class="form-check form-check-inline icheck-greensea">
                        <input class="form-check-input" type="checkbox" name="willingnessMaid[{{ $willingness->id }}]"
                            id="willingnessMaid{{ $willingness->id }}" value="1">
                        <label class="form-check-label"
                            for="willingnessMaid{{ $willingness->id }}">{{ $willingness->question }}</label>
                    </div>
                </div>
            @elseif ($willingness->is_input)
                <div class="col-3 mb-3">
                    <label for="willingnessMaid{{ $willingness->id }}"
                        class="form-label">{{ $willingness->question }}</label>
                    <input type="text" name="willingnessMaid[{{ $willingness->id }}]"
                        id="willingnessMaid[{{ $willingness->id }}]" class="form-control">
                </div>
            @endif
        @endforeach
    </div>
@endif
