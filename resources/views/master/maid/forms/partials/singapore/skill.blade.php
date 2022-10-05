<?php
use App\Models\Question;
?>
@if (collect($methods)->count() > 0)
    <div class="row mb-3">
        @foreach ($methods as $method)
            <?php
            $methodChilds = Question::where('is_active', true)
                ->where('is_method', true)
                ->where('is_child', true)
                ->where('parent_id', $method->id)
                ->country(request('country'))
                ->get();
            ?>
            @if ($method->is_check)
                <div class="col-12 mb-3">
                    <div class="form-check form-check-inline icheck-greensea">
                        <input class="form-check-input" type="checkbox" name="methodMaid[{{ $method->id }}]"
                            id="methodMaid{{ $method->id }}" value="1">
                        <label class="form-check-label"
                            for="methodMaid{{ $method->id }}">{{ $method->question }}</label>
                    </div>
                </div>
            @elseif ($method->is_input)
                <div class="col-12">
                    <div class="row">
                        <div class="col-5 mb-3">
                            <label for="methodMaid{{ $method->id }}"
                                class="form-label">{{ $method->question }}</label>
                            <input type="text" name="methodMaid[{{ $method->id }}]"
                                id="methodMaid[{{ $method->id }}]" class="form-control">
                        </div>
                    </div>
                </div>
            @else
                <div class="col-12">
                    <div class="row">
                        <div class="col-5 mb-3">
                            <label for="methodMaid{{ $method->id }}"
                                class="form-label">{{ $method->question }}</label>
                        </div>
                    </div>
                </div>
            @endif
            @if ($methodChilds)
                @foreach ($methodChilds as $metChild)
                    @if ($metChild->is_check)
                        <div class="col-12 mb-3 ms-5 ps-3">
                            <div class="form-check form-check-inline icheck-greensea">
                                <input class="form-check-input" type="checkbox" name="methodMaid[{{ $metChild->id }}]"
                                    id="methodMaid{{ $metChild->id }}" value="1">
                                <label class="form-check-label"
                                    for="methodMaid{{ $metChild->id }}">{{ $metChild->question }}</label>
                            </div>
                        </div>
                    @elseif ($metChild->is_input)
                        <div class="col-12 ms-5 ps-3">
                            <div class="row">
                                <div class="col-5 mb-3">
                                    <label for="methodMaid{{ $metChild->id }}"
                                        class="form-label">{{ $metChild->question }}</label>
                                    <input type="text" name="methodMaid[{{ $metChild->id }}]"
                                        id="methodMaid[{{ $metChild->id }}]" class="form-control">
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-12">
                            <div class="row">
                                <div class="col-5 mb-3">
                                    <label for="methodMaid{{ $metChild->id }}"
                                        class="form-label">{{ $metChild->question }}</label>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        @endforeach
    </div>
@endif
<div class="row mb-3">
    <div class="col-12">
        @if ($specialities)
            @foreach ($specialities as $speciality)
                <div class="divider-left-center divider">
                    <div class="divider-text">{{ $speciality->question }}</div>
                </div>
                @if ($speciality->id == 38)
                    <div class="row mb-3">
                        <div class="col-4">Please specify age range:</div>
                        <div class="col-4"><input type="text" name="skillMaid[{{ $speciality->id }}]"
                                id="skillMaid[{{ $speciality->id }}]" class="form-control"></div>
                    </div>
                @elseif ($speciality->id == 42)
                    <div class="row mb-3">
                        <div class="col-4">Please specify cuisines:</div>
                        <div class="col-4"><input type="text" name="skillMaid[{{ $speciality->id }}]"
                                id="skillMaid[{{ $speciality->id }}]" class="form-control"></div>
                    </div>
                @elseif ($speciality->id == 43 && $speciality->id == 43)
                    <div class="row mb-3">
                        <div class="col-4">Please specify :</div>
                        <div class="col-4"><input type="text" name="skillMaid[{{ $speciality->id }}]"
                                id="skillMaid[{{ $speciality->id }}]" class="form-control"></div>
                    </div>
                @endif
                <div class="row mb-3">
                    <div class="col-3">Willingness</div>
                    <div class="col-4">
                        <div class="form-check form-check-inline icheck-greensea">
                            <input class="form-check-input" type="radio"
                                name="skillMaidWillingness[{{ $speciality->id }}]"
                                id="skillMaidWillingnessYes[{{ $speciality->id }}]" value="1"
                                {{ $speciality->id == 43 ? 'disabled' : '' }}>
                            <label class="form-check-label"
                                for="skillMaidWillingnessYes[{{ $speciality->id }}]">Yes</label>
                        </div>
                        <div class="form-check form-check-inline icheck-greensea">
                            <input class="form-check-input" type="radio"
                                name="skillMaidWillingness[{{ $speciality->id }}]"
                                id="skillMaidWillingnessNo[{{ $speciality->id }}]" value="0"
                                {{ $speciality->id == 43 ? 'disabled' : '' }}>
                            <label class="form-check-label"
                                for="skillMaidWillingnessNo[{{ $speciality->id }}]">No</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">Experience</div>
                    <div class="col-3">
                        <div class="form-check form-check-inline icheck-greensea">
                            <input class="form-check-input" type="radio"
                                name="skillMaidExperience[{{ $speciality->id }}]"
                                id="skillMaidExperienceYes[{{ $speciality->id }}]" value="1">
                            <label class="form-check-label"
                                for="skillMaidExperienceYes[{{ $speciality->id }}]">Yes</label>
                        </div>
                        <div class="form-check form-check-inline icheck-greensea">
                            <input class="form-check-input" type="radio"
                                name="skillMaidExperience[{{ $speciality->id }}]"
                                id="skillMaidExperienceNo[{{ $speciality->id }}]" value="0">
                            <label class="form-check-label"
                                for="skillMaidExperienceNo[{{ $speciality->id }}]">No</label>
                        </div>
                    </div>
                    <div class="col-6">
                        <input type="text" name="skillMaidExperienceNote[{{ $speciality->id }}]"
                            id="skillMaidExperienceNote[{{ $speciality->id }}]" class="form-control"
                            placeholder="If yes, state the no. of years">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">Rate</div>
                    <div class="col-6">
                        <div class="form-check form-check-inline icheck-greensea">
                            <input class="form-check-input" type="radio"
                                name="skillMaidRate[{{ $speciality->id }}]"
                                id="skillMaidRate1[{{ $speciality->id }}]" value="1">
                            <label class="form-check-label" for="skillMaidRate1[{{ $speciality->id }}]">1</label>
                        </div>
                        <div class="form-check form-check-inline icheck-greensea">
                            <input class="form-check-input" type="radio"
                                name="skillMaidRate[{{ $speciality->id }}]"
                                id="skillMaidRate2[{{ $speciality->id }}]" value="2">
                            <label class="form-check-label" for="skillMaidRate2[{{ $speciality->id }}]">2</label>
                        </div>
                        <div class="form-check form-check-inline icheck-greensea">
                            <input class="form-check-input" type="radio"
                                name="skillMaidRate[{{ $speciality->id }}]"
                                id="skillMaidRate3[{{ $speciality->id }}]" value="3">
                            <label class="form-check-label" for="skillMaidRate3[{{ $speciality->id }}]">3</label>
                        </div>
                        <div class="form-check form-check-inline icheck-greensea">
                            <input class="form-check-input" type="radio"
                                name="skillMaidRate[{{ $speciality->id }}]"
                                id="skillMaidRate4[{{ $speciality->id }}]" value="4">
                            <label class="form-check-label" for="skillMaidRate4[{{ $speciality->id }}]">4</label>
                        </div>
                        <div class="form-check form-check-inline icheck-greensea">
                            <input class="form-check-input" type="radio"
                                name="skillMaidRate[{{ $speciality->id }}]"
                                id="skillMaidRate5[{{ $speciality->id }}]" value="5">
                            <label class="form-check-label" for="skillMaidRate5[{{ $speciality->id }}]">5</label>
                        </div>
                        <div class="form-check form-check-inline icheck-greensea">
                            <input class="form-check-input" type="radio"
                                name="skillMaidRate[{{ $speciality->id }}]"
                                id="skillMaidRateNA[{{ $speciality->id }}]" value="0">
                            <label class="form-check-label" for="skillMaidRateNA[{{ $speciality->id }}]">NA</label>
                        </div>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-3">
                        Assessment/Observation
                    </div>
                    <div class="col-6">
                        <textarea type="text" name="skillMaidObservationNote[{{ $speciality->id }}]"
                            id="skillMaidObservationNote[{{ $speciality->id }}]" rows="5" class="form-control"></textarea>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
