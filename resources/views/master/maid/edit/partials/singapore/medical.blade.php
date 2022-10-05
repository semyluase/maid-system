<?php
use App\Models\Question;
?>
@if (collect($medicals)->count() > 0)
    <div class="row">
        @foreach ($medicals as $medical)
            <?php
            $medicalsChild = Question::medicalMaid($maid->id)
                ->where('is_active', true)
                ->where('is_child', true)
                ->where('parent_id', $medical->id)
                ->country(request('country'))
                ->get();
            ?>
            @if ($medical->is_check)
                <div class="col-3 mb-3">
                    <div class="form-check form-check-inline icheck-greensea">
                        <input class="form-check-input" type="checkbox" name="medicalMaid[{{ $medical->id }}]"
                            id="medicalMaid{{ $medical->id }}" {{ $medical->answer ? 'checked' : '' }}>
                        <label class="form-check-label"
                            for="medicalMaid{{ $medical->id }}">{{ $medical->question }}</label>
                    </div>
                </div>
            @elseif ($medical->is_input)
                <div class="col-12">
                    <div class="row">
                        <div class="col-5 mb-3">
                            <label for="medicalMaid{{ $medical->id }}"
                                class="form-label">{{ $medical->question }}</label>
                            <input type="text" name="medicalMaid[{{ $medical->id }}]"
                                id="medicalMaid[{{ $medical->id }}]" class="form-control" value="{{ $medical->note }}">
                        </div>
                    </div>
                </div>
            @else
                <div class="col-12">
                    <div class="row">
                        <div class="col-5 mb-3">
                            <label for="medicalMaid{{ $medical->id }}"
                                class="form-label">{{ $medical->question }}</label>
                        </div>
                    </div>
                </div>
            @endif
            @if ($medicalsChild)
                @foreach ($medicalsChild as $medChild)
                    @if ($medChild->is_check)
                        <div class="col-3 mb-3">
                            <div class="form-check form-check-inline icheck-greensea">
                                <input class="form-check-input" type="checkbox" name="medicalMaid[{{ $medChild->id }}]"
                                    id="medicalMaid{{ $medChild->id }}" {{ $medChild->answer ? 'checked' : '' }}>
                                <label class="form-check-label"
                                    for="medicalMaid{{ $medChild->id }}">{{ $medChild->question }}</label>
                            </div>
                        </div>
                    @elseif ($medChild->is_input)
                        <div class="col-12">
                            <div class="row">
                                <div class="col-5 mb-3">
                                    <label for="medicalMaid{{ $medChild->id }}"
                                        class="form-label">{{ $medChild->question }}</label>
                                    <input type="text" name="medicalMaid[{{ $medChild->id }}]"
                                        id="medicalMaid[{{ $medChild->id }}]" class="form-control"
                                        value="{{ $medChild->note }}">
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-12">
                            <div class="row">
                                <div class="col-5 mb-3">
                                    <label for="medicalMaid{{ $medChild->id }}"
                                        class="form-label">{{ $medChild->question }}</label>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        @endforeach
    </div>
@endif
