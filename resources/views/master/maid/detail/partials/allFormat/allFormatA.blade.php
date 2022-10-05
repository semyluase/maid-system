<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

$marital = [
    1 => 'Single',
    2 => 'Married',
    3 => 'Divorced',
    4 => 'Widowed',
];

$education = [
    1 => 'Kindergarten',
    2 => 'Primary School',
    3 => 'Junior High School',
    4 => 'Senior High School',
    5 => 'Bachelor',
    6 => 'Master',
    7 => 'Doctor',
];

?>
<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-center">
                    Personal Biodata
                </h3>
            </div>
            <div class="card-body">
                <div class="row mb-3 border-bottom border-dark border-top bg-info">
                    <div class="col">
                        <h2 class="text-center">
                            B I O D A T A
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <table class="table table-borderless">
                            <tr>
                                <td>Application number</td>
                                <td>:</td>
                                <td>
                                    <div class="row">
                                        <div class="col border-dark border-bottom text-primary">
                                            {{ $maid->code_maid }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td>:</td>
                                <td>
                                    <div class="row">
                                        <div class="col border-dark border-bottom text-primary">
                                            {{ $maid->full_name }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Place, date of birth</td>
                                <td>:</td>
                                <td>
                                    <div class="row">
                                        <div class="col border-dark border-bottom text-primary">
                                            {{ $maid->place_of_birth }},
                                            {{ Carbon::parse($maid->date_of_birth)->isoFormat('DD MMMM YYYY') }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Height</td>
                                <td>:</td>
                                <td>
                                    <div class="row">
                                        <div class="col border-dark border-bottom text-primary">
                                            {{ $maid->height }}
                                        </div>
                                        <div class="col">
                                            Weight
                                        </div>
                                        <div class="col border-dark border-bottom text-primary">
                                            {{ $maid->weight }}
                                        </div>
                                        <div class="col">
                                            Religion
                                        </div>
                                        <div class="col border-dark border-bottom text-primary">
                                            {{ convertReligion($maid->religion) }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td>:</td>
                                <td>
                                    <div class="row">
                                        <div class="col border-dark border-bottom text-primary text-uppercase">
                                            {{ $maid->address }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Brother & Sister</td>
                                <td>:</td>
                                <td>
                                    <div class="row">
                                        <div class="col border-dark border-bottom text-primary">
                                            {{ $maid->number_of_siblings }}
                                        </div>
                                        <div class="col">
                                            I'm number
                                        </div>
                                        <div class="col border-dark border-bottom text-primary">
                                            {{ $maid->number_in_family }}
                                        </div>
                                        <div class="col">
                                            Telp
                                        </div>
                                        <div class="col border-dark border-bottom text-primary">
                                            {{ $maid->contact ? $maid->contact : '-' }}
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Marital Status</td>
                                <td>:</td>
                                <td>
                                    <div class="row">
                                        @foreach ($marital as $m => $value)
                                            <div class="col mb-3">
                                                <div class="form-check icheck-greensea">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="flexCheckDefault"
                                                        {{ $m == $maid->marital ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        {{ $value }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Heir name</td>
                                <td>:</td>
                                <td>
                                    <div class="row">
                                        <div class="col border-dark border-bottom text-primary">
                                            {{ $maid->note ? $maid->note : '-' }}</div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Education</td>
                                <td>:</td>
                                <td>
                                    <div class="row">
                                        @foreach ($education as $e => $value)
                                            <div class="col-4 mb-3">
                                                <div class="form-check icheck-greensea">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="flexCheckDefault"
                                                        {{ $e == $maid->education ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        {{ $value }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Language</td>
                                <td>:</td>
                                <td>
                                    <div class="row">
                                        @foreach ($languages as $language)
                                            <div class="col-4 mb-3">
                                                <div class="form-check icheck-greensea">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="flexCheckDefault"
                                                        {{ $language->answer == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        {{ $language->question }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>Cooking ability</td>
                                <td>:</td>
                                <td>
                                    <div class="row">
                                        @foreach ($specialities as $speciality)
                                            <div class="col mb-3">
                                                <div class="form-check icheck-greensea">
                                                    <input class="form-check-input" type="checkbox" value=""
                                                        id="flexCheckDefault"
                                                        {{ $speciality->answer == 1 ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="flexCheckDefault">
                                                        {{ $speciality->question }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    <div class="row mb-3 justify-content-between">
                                        <div class="col-5 text-center bg-light-secondary text-primary">
                                            I CAN SERVE YOU BETTER
                                        </div>
                                        <div
                                            class="col-6 text-center bg-info border-bottom border-top border-dark text-primary">
                                            WORK CHOSEN
                                        </div>
                                    </div>
                                    <div class="row justify-content-between">
                                        <div class="col-5">
                                            <img src="{{ asset($maid->picture_location . $maid->picture_name) }}"
                                                alt="Photo of {{ $maid->code_maid }}" class="img-thumbnail">
                                        </div>
                                        <div class="col-6">
                                            <div class="row">
                                                @foreach ($willingnesses as $willingness)
                                                    <div class="col-6 mb-3">
                                                        <div class="form-check icheck-greensea">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="" id="flexCheckDefault"
                                                                {{ $willingness->answer == 1 ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                {{ $willingness->question }}
                                                            </label>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="col bg-info text-center text-primary border-bottom border-top border-dark">
                                                    Interview Appraisal</div>
                                            </div>
                                            <div class="row">
                                                <div class="col">
                                                    <table class="table table-borderless">
                                                        <tr>
                                                            <td></td>
                                                            <td colspan="2" class="text-center">
                                                                Fair
                                                            </td>
                                                            <td colspan="3" class="text-center">
                                                                Good
                                                            </td>
                                                            <td colspan="2" class="text-center">
                                                                Excellent</td>
                                                        </tr>
                                                        @foreach ($interviews as $interview)
                                                            <tr>
                                                                <td>{{ $interview->question }}
                                                                </td>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input"
                                                                            type="checkbox" value=""
                                                                            id="flexCheckDefault"
                                                                            {{ $interview->rate == 1 ? 'checked' : '' }}>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input"
                                                                            type="checkbox" value=""
                                                                            id="flexCheckDefault"
                                                                            {{ $interview->rate == 2 ? 'checked' : '' }}>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input"
                                                                            type="checkbox" value=""
                                                                            id="flexCheckDefault"
                                                                            {{ $interview->rate == 3 ? 'checked' : '' }}>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input"
                                                                            type="checkbox" value=""
                                                                            id="flexCheckDefault"
                                                                            {{ $interview->rate == 4 ? 'checked' : '' }}>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input"
                                                                            type="checkbox" value=""
                                                                            id="flexCheckDefault"
                                                                            {{ $interview->rate == 5 ? 'checked' : '' }}>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input"
                                                                            type="checkbox" value=""
                                                                            id="flexCheckDefault"
                                                                            {{ $interview->rate == 6 ? 'checked' : '' }}>
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input"
                                                                            type="checkbox" value=""
                                                                            id="flexCheckDefault"
                                                                            {{ $interview->rate == 7 ? 'checked' : '' }}>
                                                                    </div>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </table>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="col bg-info text-center text-primary border-bottom border-top border-dark">
                                                    REMARKS</div>
                                            </div>
                                            @foreach ($maid->workExperience as $work)
                                                <div class="row">
                                                    <div class="col text-justify text-primary">
                                                        {{ $work->country }}
                                                        ({{ $work->year_start }} -
                                                        {{ $work->year_end }})
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col text-justify text-primary">
                                                        {{ $work->description }}
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
