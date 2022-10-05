<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Question;

?>
@extends('layouts.main')
@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>{{ $pageTitle }}</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col h3 text-center text-dark fw-bold">BIO-DATA OF FOREIGN DOMESTIC WORKER (FDW)</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col text-justify text-dark">*Please ensure that you run through the information within
                            the biodata as it is an important document to help you select a suitable FDW</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-8">
                            <div class="row mb-3">
                                <div class="col h5 text-justify text-dark">(A) <span
                                        class="ms-2 text-decoration-underline">PROFILE
                                        OF FDW</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col h5 text-justify text-dark">(A1) <span class="ms-2">Personal
                                        Information</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="text-justify text-dark m-0" style="font-size: 1.2rem !important;">1. Name :
                                        {{ $maid->full_name }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="text-justify text-dark m-0" style="font-size: 1.2rem !important;">2. Date of
                                        Birth
                                        :
                                        {{ Carbon::parse($maid->date_of_birth)->isoFormat('DD MMMM YYYY') }}</div>
                                </div>
                                <div class="col">
                                    <div class="text-justify text-dark m-0" style="font-size: 1.2rem !important;">Age :
                                        {{ Carbon::parse($maid->date_of_birth)->age }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="text-justify text-dark m-0" style="font-size: 1.2rem !important;">3. Place
                                        of
                                        Birth
                                        :
                                        {{ $maid->place_of_birth }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="text-justify text-dark m-0" style="font-size: 1.2rem !important;">4. Height
                                        &
                                        Weight
                                        :
                                        {{ $maid->height }} cm {{ $maid->weight }} kg</d>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="text-justify text-dark m-0" style="font-size: 1.2rem !important;">5.
                                        Nationality
                                        :
                                        {{ $maid->nationality }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="text-justify text-dark m-0" style="font-size: 1.2rem !important;">6.
                                        Residential address in home country
                                        :
                                        {{ $maid->address }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="text-justify text-dark m-0" style="font-size: 1.2rem !important;">7.
                                        Name of
                                        Port/Airport to be Repatriated to
                                        :
                                        {{ $maid->port_airport_name }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="text-justify text-dark m-0" style="font-size: 1.2rem !important;">8.
                                        Contact
                                        Number in Home Country
                                        :
                                        {{ $maid->contact }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="text-justify text-dark m-0" style="font-size: 1.2rem !important;">9.
                                        Religion
                                        :
                                        {{ convertReligion($maid->religion) }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="text-justify text-dark m-0" style="font-size: 1.2rem !important;">10.
                                        Education Level
                                        :
                                        {{ convertEducation($maid->education) }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="text-justify text-dark m-0" style="font-size: 1.2rem !important;">11.
                                        Number
                                        of Siblings
                                        :
                                        {{ $maid->number_of_siblings }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="text-justify text-dark m-0" style="font-size: 1.2rem !important;">
                                        12. Marital
                                        Status
                                        :
                                        {{ convertMaritalStatus($maid->marital) }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="text-justify text-dark m-0" style="font-size: 1.2rem !important;">
                                        13. Number
                                        of Children
                                        :
                                        {{ $maid->number_of_children }}</div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    <div class="text-justify text-dark m-0" style="font-size: 1.2rem !important;">-.
                                        Age(s) of
                                        Children (if any)
                                        :
                                        {{ $maid->children_ages }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-4">
                            <img src="{{ asset($maid->picture_location . $maid->picture_name) }}"
                                alt="Photo Of {{ $maid->code_maid }}" class="img-thumbnail" style="max-height: 500px;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="row mb-3">
                                <div class="col h5 text-justify text-dark">(A2) <span class="ms-2">Medical
                                        History/Dietary
                                        Restrictions</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col">
                                    @if ($medicals)
                                        <div class="row mb-3">
                                            <?php $no = 0; ?>
                                            @foreach ($medicals as $medical)
                                                <?php

                                                $medicalChilds = Question::medicalMaid($maid->id)
                                                    ->where('is_active', true)
                                                    ->where('is_child', true)
                                                    ->where('parent_id', $medical->id)
                                                    ->country(request('country'))
                                                    ->get();

                                                ?>
                                                @if ($medical->is_check)
                                                    <div class="col-6 mb-3">
                                                        <div class="text-justify text-dark m-0"
                                                            style="font-size: 1.2rem !important;">
                                                            {{ Str::lower(integerToRoman($no)) }}.
                                                            {{ $medical->question }} <span
                                                                class="ms-5 me-5">{!! $medical->answer == 1 ? '&#10003;' : '' !!}
                                                                Yes</span><span class="ms-5 me-5">{!! $medical->answer == 1 ? '' : '&#10003;' !!}
                                                                No</span>
                                                        </div>
                                                    </div>
                                                @elseif ($medical->is_input)
                                                    <div class="col-12 mb-3">
                                                        <div class="text-justify text-dark m-0"
                                                            style="font-size: 1.2rem !important;">
                                                            {{ $medical->question }} : <span
                                                                class="ms-5">{{ $medical->note ? $medical->note : 'N/A' }}</span>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-12 mb-3">
                                                        <div class="text-justify text-dark m-0"
                                                            style="font-size: 1.2rem !important;">
                                                            {{ $medical->question }}</div>
                                                    </div>
                                                @endif
                                                @if ($medicalChilds)
                                                    @foreach ($medicalChilds as $medicalChild)
                                                        @if ($medicalChild->is_check)
                                                            <div class="col-6 mb-3">
                                                                <div class="text-justify text-dark m-0"
                                                                    style="font-size: 1.2rem !important;">
                                                                    {{ $medicalChild->question }} <span
                                                                        class="ms-5 me-5">{!! $medicalChild->answer == 1 ? '&#10003;' : '' !!}
                                                                        Yes</span><span
                                                                        class="ms-5 me-5">{!! $medicalChild->answer == 1 ? '' : '&#10003;' !!}
                                                                        No</span>
                                                                </div>
                                                            </div>
                                                        @elseif ($medicalChild->is_input)
                                                            <div class="col-12 mb-3">
                                                                <div class="text-justify text-dark m-0"
                                                                    style="font-size: 1.2rem !important;">
                                                                    {{ $medicalChild->question }} : <span
                                                                        class="ms-5">{{ $medicalChild->note ? $medicalChild->note : 'N/A' }}</span>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <div class="col-12 mb-3">
                                                                <div class="text-justify text-dark m-0"
                                                                    style="font-size: 1.2rem !important;">
                                                                    {{ $medicalChild->question }} :</div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                <?php $no++; ?>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col h5 text-justify text-dark">(A3) <span class="ms-2">Others</span></div>
                    </div>
                    <div class="row mb-3">
                        @if ($others)
                            @foreach ($others as $other)
                                @if ($other->is_check)
                                    <div class="col">
                                        <div class="text-justify text-dark m-0" style="font-size: 1.2rem !important;">
                                            {{ $other->question }}
                                            <span class="ms-5 me-5">{{ $other->answer == 1 ? 'checked' : '' }}</span>
                                        </div>
                                    </div>
                                @elseif ($other->is_input)
                                    <div class="col-6 mb-3">
                                        <div class="text-dark text-justify" style="font-size: 1.2rem !important;">
                                            {{ $other->question }} : {{ $other->note }}
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endif
                    </div>
                    <div class="row mb-3">
                        <div class="col h5 text-justify text-dark">(B) <span class="ms-2 text-decoration-underline">SKILLS
                                OF FDW</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col h5 text-justify text-dark">(B1) <span class="ms-2">Methods
                                of Evaluation
                                of
                                Skills</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        @foreach ($methods as $method)
                            <?php
                            $methodChilds = Question::methodMaid($maid->id)
                                ->where('is_active', true)
                                ->country(request('country'))
                                ->where('is_child', true)
                                ->where('parent_id', $method->id)
                                ->orderBy('id')
                                ->get();
                            ?>
                            @if ($method->is_check)
                                <div class="col-12 mb-3">
                                    <div class="text-justify text-dark fw-normal m-0"
                                        style="font-size: 1.2rem !important;">
                                        {!! $method->answer == 1
                                            ? '<span class="border border-dark font-semibold">&#10003;</span>'
                                            : '<span class="border border-dark text-white">&#10003;</span>' !!} <span class="ms-5 me-5">{{ $method->question }}
                                        </span>
                                    </div>
                                </div>
                            @endif
                            @if ($methodChilds)
                                @foreach ($methodChilds as $metChild)
                                    @if ($metChild->is_check)
                                        <div class="col-12 mb-3 ms-5 ps-3">
                                            <div class="text-justify text-dark fw-normal m-0"
                                                style="font-size: 1.2rem !important;">
                                                {!! $metChild->answer == 1
                                                    ? '<span class="border border-dark font-semibold">&#10003;</span>'
                                                    : '<span class="border border-dark text-white">&#10003;</span>' !!} <span class="ms-5 me-5">{{ $metChild->question }}
                                                </span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        <div class="col-12">
                            <table class="table table-bordered border-dark">
                                <thead class="bg-light-secondary">
                                    <tr class="text-center fw-normal">
                                        <th><span class="font-bold">S/No</span></th>
                                        <th><span class="font-bold">Areas of Work</span></th>
                                        <th><span class="font-bold">Willingness</span>
                                            <div class="fw-normal">Yes/No</div>
                                        </th>
                                        <th><span class="font-bold">Experience</span>
                                            <div class="fw-normal">Yes/No</div>
                                            <div class="fw-normal">If yes, state the no. of years</div>
                                        </th>
                                        <th><span class="font-bold">Assessment/Observation</span>
                                            <div class="fw-normal">Please state qualitative observations of FDW and/or rate
                                                the</div>
                                            <div class="fw-normal">FDW (indicate N.A. Of no evaluation was done)</div>
                                            <div class="fw-normal">Poor..................Excellent...N.A</div>
                                            <div class="fw-normal">
                                                <span class="ms-2">1</span>
                                                <span class="ms-2">2</span>
                                                <span class="ms-2">3</span>
                                                <span class="ms-2">4</span>
                                                <span class="ms-2">5</span>
                                                <span class="ms-2">N.A</span>
                                            </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="text-center">
                                    @foreach ($specialities as $speciality)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div>{{ $speciality->question }}</div>
                                                @if ($speciality->id == 38)
                                                    <div>Please specify age range:</div>
                                                    @if ($speciality->note)
                                                        <div class="text-decoration-underline">{{ $speciality->note }}
                                                        </div>
                                                    @else
                                                        <div class="text-decoration-underline">
                                                            N/A</div>
                                                    @endif
                                                @elseif ($speciality->id == 42)
                                                    <div>Please specify cuisines:</div>
                                                    @if ($speciality->note)
                                                        <div class="text-decoration-underline">{{ $speciality->note }}
                                                        </div>
                                                    @else
                                                        <div class="text-decoration-underline">
                                                            N/A</div>
                                                    @endif
                                                @elseif ($speciality->id == 43)
                                                    <div>Please specify:</div>
                                                    @if ($speciality->note)
                                                        <div class="text-decoration-underline">{{ $speciality->note }}
                                                        </div>
                                                    @else
                                                        <div class="text-decoration-underline">
                                                            N/A</div>
                                                    @endif
                                                @elseif ($speciality->id == 44)
                                                    <div>Please specify:</div>
                                                    @if ($speciality->note)
                                                        <div class="text-decoration-underline">{{ $speciality->note }}
                                                        </div>
                                                    @else
                                                        <div class="text-decoration-underline">
                                                            N/A</div>
                                                    @endif
                                                @endif
                                            </td>
                                            <td>
                                                <div>{{ $speciality->willingness == 1 ? 'YES' : 'NO' }}</div>
                                            </td>
                                            <td>
                                                <div>
                                                    {{ $speciality->experience == 1 ? $speciality->note_experience : 'NO' }}
                                                </div>
                                            </td>
                                            <td>
                                                <div class="text-left">Rate :
                                                    {{ $speciality->rate ? $speciality->rate : 0 }}</div>
                                                <div class="text-left">{{ $speciality->note_observetion }}</div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col h5 text-justify text-dark">(C) <span
                                class="ms-2 text-decoration-underline">EMPLOYMENT
                                HISTORY
                                OF FDW</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col h5 text-justify text-dark">(C1) <span class="ms-2">Employment History
                                Overseas</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <table class="table table-bordered border-dark">
                                <thead class="bg-light-secondary">
                                    <tr class="fw-bold text-center">
                                        <td colspan="2">Date</td>
                                        <td rowspan="2">Country (including FDW's home
                                            country)</td>
                                        <td rowspan="2">Employer</td>
                                        <td rowspan="2">Work Duties</td>
                                        <td rowspan="2">Remarks</td>
                                    </tr>
                                    <tr class="fw-bold text-center">
                                        <td>From</td>
                                        <td>To</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($maid->workExperience as $work)
                                        <tr>
                                            <td>{{ $work->year_start }}</td>
                                            <td>{{ $work->year_end }}</td>
                                            <td>{{ $work->country }}</td>
                                            <td>{{ $work->employeer_singapore }}</td>
                                            <td>{{ $work->description }}</td>
                                            <td>{{ $work->remarks }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col h5 text-justify text-dark">(C2) <span class="ms-2">Employment History In
                                Singapore</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="text-justify text-dark fw-normal" style="font-size: 1.2rem !important;">
                                Previous working experience in Singapore {!! $maid->work_singapore == 1
                                    ? '<span class="border border-dark font-semibold me-2 ms-5">&#10003;</span>'
                                    : '<span class="border border-dark text-white me-2 ms-5">&#10003;</span>' !!} Yes {!! $maid->work_singapore == 0
                                    ? '<span class="border border-dark font-semibold me-2 ms-5">&#10003;</span>'
                                    : '<span class="border border-dark text-white me-2 ms-5">&#10003;</span>' !!}
                                No
                            </div>
                            <div class="text-justify text-dark fw-normal" style="font-size: 1.2rem !important;">(The EA is
                                required to obtain the FDW’s employment history from MOM and furnish the employer with the
                                employment history of the FDW. The employer may also verify the FDW’s employment history in
                                Singapore through WPOL using SingPass)</div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col h5 text-justify text-dark">(C3) <span class="ms-2">Feedback
                                From
                                Previous
                                Employers In Singapore</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            <div class="text-justify text-dark fw-normal" style="font-size: 1.2rem !important;">Feedback
                                was/was not obtained by the EA from the previous employers. If feedback was obtained (attach
                                testimonial if possible), please indicate the feedback in the table below:</div>
                            <table class="table table-bordered border-dark">
                                <thead class="text-center fw-bold">
                                    <tr class="text-dark">
                                        <th></th>
                                        <th>Feedback</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($maid->workExperience as $work)
                                        @if ($work->work_singapore)
                                            <tr>
                                                <td>
                                                    <div class="text-center text-dark font-bold">Employeer
                                                        {{ $loop->iteration }}
                                                    </div>
                                                    <div class="text-center text-dark font-bold">
                                                        {{ $work->employeer_singapore }}
                                                    </div>
                                                </td>
                                                <td>{{ $work->employeer_singapore_feedback }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col h5 text-justify text-dark">(D) <span
                                class="ms-2 text-decoration-underline">AVAILABILITY OF FDW TO BE
                                INTERVIEWED BY
                                PROSPECTIVE
                                EMPLOYER</span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col">
                            @foreach ($interviews as $interview)
                                <div class="row mb-3">
                                    <div class="text-dark">
                                        @if ($interview->answer)
                                            <span class="border border-dark font-semibold me-3">&#10003;</span>
                                        @else
                                            <span class="border border-dark text-white me-3">&#10003;</span>
                                        @endif
                                        {{ $interview->question }}
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col h5 text-justify text-dark">(E) <span class="ms-2 text-decoration-underline">OTHER
                                REMARKS</span>
                        </div>
                    </div>
                    <div class="row me-3">
                        <div class="col">
                            <div class="border border-dark text-dark" style="min-height: 10rem; width: 100%;">
                                {{ $maid->note }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
