<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use App\Models\Question;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">
    <title>{{ $title }}</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 14px;
            max-width: 100%;
        }

        .container {
            margin: 2rem 1.5rem !important;
        }

        body {
            margin-top: 1.9cm;
        }

        .pagenum:before {
            content: counter(page);
        }

        .kolom {
            float: left !important;
            width: 50% !important;
            /* padding: 8px !important; */
        }

        /* Clear floats after the columns */
        .baris {
            margin-right: 0.3rem !important;
            margin-left: 0.3rem !important;
            padding: 0 0.3rem !important;
            padding-bottom: 8px !important;
        }

        .baris:after {
            content: "" !important;
            display: table !important;
            clear: both !important;
        }

        .kolomCheck {
            float: left !important;
            width: 50% !important;
            padding: 8px !important;
        }

        /* Clear floats after the columns */
        .baris-check {
            padding: 0 0.3rem !important;
        }

        .baris-check:after {
            content: "" !important;
            display: table !important;
            clear: both !important;
        }

        table,
        td,
        th {
            border: 1px solid #242424;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ $header }}" alt="Header PDF" class="bg-white" style="width: 100%; margin-top:-1.9cm;">
    </header>
    <div class="container">
        <div class="row mb-3">
            <div class="col">
                <div class="fw-bold text-center" style="font-size: 16px !important;">BIO-DATA OF FOREIGN DOMESTIC WORKER
                    (FDW)</div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div style="font-weight: lighter !important; font-size: 12px !important;">*Please ensure that
                    you run through the information within
                    the
                    biodata as it is an important document to help you select a suitable FDW</div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-8">
                <div style="font-weight: bold !important; font-size: 14px !important;">
                    (A) <u
                        style="font-weight: bold !important; font-size: 14px !important; margin-left: 35px !important;">PROFILE
                        OF FDW</u> </div>
            </div>
        </div>
        <div class="baris mb-3">
            <div class="kolom">
                <div class="row mb-3">
                    <div class="col">
                        <div style="font-weight: bold !important; font-size: 14px !important; left:-8px !important;">
                            A1 <span
                                style="font-weight: bold !important; font-size: 14px !important; margin-left: 35px !important;">Personal
                                Information</span> </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div style="font-weight: lighter !important; font-size: 14px !important;">
                            1. <span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">Code
                                :
                            </span><span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">{{ $maid->code_maid }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div style="font-weight: lighter !important; font-size: 14px !important;">
                            2. <span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">Name
                                :
                            </span><span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">{{ $maid->full_name }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div style="font-weight: lighter !important; font-size: 14px !important;">
                            3. <span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important; margin-left: 15px !important;">Date
                                Of Birth
                                :
                            </span><span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">{{ Carbon::parse($maid->date_of_birth)->isoFormat('DD MMMM YYYY') }}</span>
                            <span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">Age
                                :
                            </span><span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">{{ Carbon::parse($maid->date_of_birth)->age }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div style="font-weight: lighter !important; font-size: 14px !important;">
                            4. <span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">Place
                                Of Birth
                                :
                            </span><span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">{{ $maid->place_of_birth }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div style="font-weight: lighter !important; font-size: 14px !important;">
                            5. <span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">Height
                                & Weight
                                :
                            </span><span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">{{ $maid->height }}
                                cm</span><span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">{{ $maid->weight }}
                                kg</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div style="font-weight: lighter !important; font-size: 14px !important;">
                            6. <span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">Nationality
                                :
                            </span><span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">{{ $maid->nationality }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div style="font-weight: lighter !important; font-size: 14px !important;">
                            7. <span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">Residential
                                address in home country
                                :
                            </span><span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">{{ $maid->address }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div style="font-weight: lighter !important; font-size: 14px !important;">
                            8. <span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">Name
                                of port / airport to be repatriated to
                                :
                            </span><span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">{{ $maid->port_airport_name }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div style="font-weight: lighter !important; font-size: 14px !important;">
                            9. <span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">Contact
                                number in home country
                                :
                            </span><span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">{{ $maid->contact }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div style="font-weight: lighter !important; font-size: 14px !important;">
                            10. <span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">Religion
                                :
                            </span><span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">{{ convertReligion($maid->religion) }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div style="font-weight: lighter !important; font-size: 14px !important;">
                            11. <span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">Education
                                level
                                :
                            </span><span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">{{ convertEducation($maid->education) }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div style="font-weight: lighter !important; font-size: 14px !important;">
                            12. <span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">Number
                                of siblings
                                :
                            </span><span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">{{ $maid->number_of_siblings }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div style="font-weight: lighter !important; font-size: 14px !important;">
                            13. <span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">Marital
                                status
                                :
                            </span><span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">{{ convertMaritalStatus($maid->marital) }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div style="font-weight: lighter !important; font-size: 14px !important;">
                            14. <span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">Number
                                of children
                                :
                            </span><span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">{{ $maid->number_of_children }}</span>
                        </div>
                    </div>
                </div>
                <div class="row mb-2">
                    <div class="col">
                        <div style="font-weight: lighter !important; font-size: 14px !important;">
                            -. <span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">Age(s)
                                of children (if any)
                                :
                            </span><span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">{{ $maid->children_ages }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="kolom">
                <div class="row mb-3 justify-content-center">
                    <div class="col-4 text-center">
                        <img src="{{ $photo }}" alt="Photo of {{ $maid->code_maid }}" style="height: 435px;"
                            class="text-center">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div style="font-weight: bold !important; font-size: 14px !important;">
                    A2 <span
                        style="font-weight: bold !important; font-size: 14px !important; margin-left: 35px !important;">Medical
                        History/Dietary Restrictions</span> </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <?php $no = 0; ?>
                @foreach ($medicals as $medical)
                    <?php

                    $medicalChilds = Question::medicalMaid($maid->id)
                        ->where('is_active', true)
                        ->where('is_child', true)
                        ->where('parent_id', $medical->id)
                        ->country(request('country'))
                        ->orderBy('id')
                        ->get();

                    ?>
                    <div class="row mb-2">
                        <div class="col">
                            @if ($medical->is_input)
                                <div style="font-weight: lighter !important; font-size: 14px !important;">
                                    {{ $medical->question }} :
                                    <span
                                        style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">
                                        {{ $medical->note ? $medical->note : 'N/A' }}
                                    </span>
                                </div>
                            @elseif($medical->is_check)
                                @foreach ($medicalsLeft as $left)
                                    @if ($left->id == $medical->id)
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <span
                                                    style="font-weight: lighter !important; font-size: 14px !important;">{{ Str::lower(integerToRoman($no)) }}.</span>
                                                <span
                                                    style="font-weight: lighter !important; font-size: 14px !important; margin-left: 10px !important;">{{ $left->question }}</span>
                                            </div>
                                            <div class="col-6">
                                                {!! $left->answer == 1
                                                    ? '<span style="border: solid 1px #242424; font-weight: lighter !important; font-size: 14px !important; margin-left: 35px !important;">V</span>'
                                                    : '<span style="border: solid 1px #242424; font-weight: lighter !important; font-size: 14px !important; margin-left: 35px !important; color:#fff !important">V</span>' !!}
                                                <span
                                                    style="font-weight: lighter !important; font-size: 14px !important; margin-left: 10px !important;">YES</span>
                                                {!! $left->answer == 1
                                                    ? '<span style="border: solid 1px #242424; font-weight: lighter !important; font-size: 14px !important; margin-left: 35px !important; color:#fff !important;">V</span>'
                                                    : '<span style="border: solid 1px #242424; font-weight: lighter !important; font-size: 14px !important; margin-left: 35px !important;">V</span>' !!}
                                                <span
                                                    style="font-weight: lighter !important; font-size: 14px !important; margin-left: 10px !important;">NO</span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                                @foreach ($medicalsRight as $right)
                                    @if ($right->id == $medical->id)
                                        <div class="row mb-2">
                                            <div class="col-6">
                                                <span
                                                    style="font-weight: lighter !important; font-size: 14px !important;">{{ Str::lower(integerToRoman($no)) }}.</span>
                                                <span
                                                    style="font-weight: lighter !important; font-size: 14px !important; margin-left: 10px !important;">{{ $right->question }}</span>
                                            </div>
                                            <div class="col-6">
                                                {!! $right->answer == 1
                                                    ? '<span style="border: solid 1px #242424; font-weight: lighter !important; font-size: 14px !important; margin-left: 35px !important;">V</span>'
                                                    : '<span style="border: solid 1px #242424; font-weight: lighter !important; font-size: 14px !important; margin-left: 35px !important; color:#fff !important">V</span>' !!}
                                                <span
                                                    style="font-weight: lighter !important; font-size: 14px !important; margin-left: 10px !important;">YES</span>
                                                {!! $right->answer == 1
                                                    ? '<span style="border: solid 1px #242424; font-weight: lighter !important; font-size: 14px !important; margin-left: 35px !important; color:#fff !important;">V</span>'
                                                    : '<span style="border: solid 1px #242424; font-weight: lighter !important; font-size: 14px !important; margin-left: 35px !important;">V</span>' !!}
                                                <span
                                                    style="font-weight: lighter !important; font-size: 14px !important; margin-left: 10px !important;">NO</span>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="row mb-2">
                                    <span
                                        style="font-weight: lighter !important; font-size: 14px !important;">{{ $medical->question }}</span>
                                </div>
                            @endif
                        </div>
                        <div class="col">
                            @foreach ($medicalChilds as $medicalChild)
                                @if ($medicalChild->is_check)
                                    {!! $medicalChild->answer == 1
                                        ? '<span style="border: solid 1px #242424; font-weight: lighter !important; font-size: 14px !important; margin-left: 35px !important;">V</span>'
                                        : '<span style="border: solid 1px #242424; font-weight: lighter !important; font-size: 14px !important; margin-left: 35px !important; color:#fff !important;">V</span>' !!}
                                    <span
                                        style="font-weight: lighter !important; font-size: 14px !important; margin-left: 10px !important;">{{ $medicalChild->question }}</span>
                                @elseif ($medicalChild->is_input)
                                    <div style="font-weight: lighter !important; font-size: 14px !important;">
                                        {{ $medicalChild->question }} :
                                        <span
                                            style="font-weight: lighter !important; font-size: 14px !important; margin-left: 15px !important;">
                                            {{ $medicalChild->note ? $medicalChild->note : 'N/A' }}
                                        </span>
                                    </div>
                                @else
                                    <div class="row mb-2">
                                        <span
                                            style="font-weight: lighter !important; font-size: 14px !important;">{{ $medicalChild->question }}</span>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    <?php $no++; ?>
                @endforeach
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div style="font-weight: bold !important; font-size: 14px !important;">
                    A3 <span
                        style="font-weight: bold !important; font-size: 14px !important; margin-left: 35px !important;">Other</span>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="baris">
                    @foreach ($others as $other)
                        <div class="kolom">
                            <span
                                style="font-weight: lighter !important; font-size: 14px !important;">{{ $other->question }}
                                : </span>
                            <span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 10px !important;">{{ $other->note ? $other->note : 'N/A' }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-8">
                <div style="font-weight: bold !important; font-size: 14px !important;">
                    (B) <u
                        style="font-weight: bold !important; font-size: 14px !important; margin-left: 35px !important;">SKILLS
                        OF FDW</u> </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-8">
                <div style="font-weight: bold !important; font-size: 14px !important;">
                    B1 <span
                        style="font-weight: bold !important; font-size: 14px !important; margin-left: 35px !important;">Methods
                        of Evaluation of Skills</span> </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
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
                    <div class="row mb-2">
                        <div class="col">
                            {!! $method->answer == 1
                                ? '<span style="border: solid 1px #242424; font-weight: lighter !important; font-size: 14px !important; margin-left: 35px !important;">V</span>'
                                : '' !!}
                            {!! $method->answer == 1
                                ? ''
                                : '<span style="border: solid 1px #242424; font-weight: lighter !important; font-size: 14px !important; margin-left: 35px !important;">V</span>' !!}
                            <span
                                style="font-weight: lighter !important; font-size: 14px !important; margin-left: 10px !important;">{{ $method->question }}</span>
                        </div>
                    </div>
                    @foreach ($methodChilds as $methodChild)
                        <div class="row mb-2">
                            <div class="col">
                                {!! $methodChild->answer == 1
                                    ? '<span style="border: solid 1px #242424; font-weight: lighter !important; font-size: 14px !important; margin-left: 35px !important;">V</span>'
                                    : '<span style="border: solid 1px #242424; font-weight: lighter !important; font-size: 14px !important; margin-left: 35px !important; color:#fff !important;">V</span>' !!}
                                <span
                                    style="font-weight: lighter !important; font-size: 14px !important; margin-left: 10px !important;">{{ $methodChild->question }}</span>
                            </div>
                        </div>
                    @endforeach
                @endforeach
                <table class="table table-bordered border-dark">
                    <tr style="background: #a1a1a1 !important;" class="text-center">
                        <th>
                            <div>
                                <b>S/No</b>
                            </div>
                        </th>
                        <th>
                            <div>
                                <b>Areas of Work</b>
                            </div>
                        </th>
                        <th>
                            <div>
                                <b>Willingness</b>
                            </div>
                            <div style="font-weight: lighter !important; font-size: 14px !important;">
                                Yes/No
                            </div>
                        </th>
                        <th>
                            <div>
                                <b>Experience</b>
                            </div>
                            <div style="font-weight: lighter !important; font-size: 14px !important;">
                                Yes/No
                            </div>
                            <div style="font-weight: lighter !important; font-size: 14px !important;">
                                If yes, state the no. of years
                            </div>
                        </th>
                        <th>
                            <div>
                                <b>Assessment/Observation</b>
                            </div>
                            <div style="font-weight: lighter !important; font-size: 14px !important;">
                                Please state qualitative observations of FDW and/or rate the FDW (indicate N.A. Of no
                                evaluation was done)
                            </div>
                            <div style="font-weight: lighter !important; font-size: 14px !important;">
                                Poor..................Excellent...N.A
                            </div>
                            <div style="font-weight: lighter !important; font-size: 14px !important;">
                                <span class="me-2">1</span><span class="me-2">2</span><span
                                    class="me-2">3</span><span class="me-2">4</span><span
                                    class="me-2">5</span>N.A
                            </div>
                        </th>
                    </tr>
                    @foreach ($specialities as $speciality)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <p>{{ $speciality->question }}</p>
                                @if ($speciality->id == 38)
                                    <p>Please specify age range:</p>
                                    @if ($speciality->note)
                                        <p class="text-decoration-underline">{{ $speciality->note }}
                                        </p>
                                    @else
                                        <p class="text-decoration-underline">
                                            N/A</p>
                                    @endif
                                @elseif ($speciality->id == 42)
                                    <p>Please specify cuisines:</p>
                                    @if ($speciality->note)
                                        <p class="text-decoration-underline">{{ $speciality->note }}
                                        </p>
                                    @else
                                        <p class="text-decoration-underline">
                                            N/A</p>
                                    @endif
                                @elseif ($speciality->id == 43)
                                    <p>Please specify:</p>
                                    @if ($speciality->note)
                                        <p class="text-decoration-underline">{{ $speciality->note }}
                                        </p>
                                    @else
                                        <p class="text-decoration-underline">
                                            N/A</p>
                                    @endif
                                @elseif ($speciality->id == 44)
                                    <p>Please specify:</p>
                                    @if ($speciality->note)
                                        <p class="text-decoration-underline">{{ $speciality->note }}
                                        </p>
                                    @else
                                        <p class="text-decoration-underline">
                                            N/A</p>
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
                </table>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-8">
                <div style="font-weight: bold !important; font-size: 14px !important;">
                    (C) <u
                        style="font-weight: bold !important; font-size: 14px !important; margin-left: 35px !important;">EMPLOYMENT
                        HISTORY
                        OF FDW</u> </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-8">
                <div style="font-weight: bold !important; font-size: 14px !important;">
                    C1 <span
                        style="font-weight: bold !important; font-size: 14px !important; margin-left: 35px !important;">Employment
                        History Overseas</span> </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                <table class="table table-bordered border-dark text-center">
                    <tr style="background: #a1a1a1 !important;" class="text-center">
                        <th colspan="2">
                            <div>
                                <b>Date</b>
                            </div>
                        </th>
                        <th rowspan="2">
                            <div>
                                <b>Country (including FDW's home country)</b>
                            </div>
                        </th>
                        <th rowspan="2">
                            <div>
                                <b>Employer</b>
                            </div>
                        </th>
                        <th rowspan="2">
                            <div>
                                <b>Work Duties</b>
                            </div>
                        </th>
                        <th rowspan="2">
                            <div>
                                <b>Remarks</b>
                            </div>
                        </th>
                    </tr>
                    <tr style="background: #a1a1a1 !important;" class="text-center">
                        <th>From</th>
                        <th>To</th>
                    </tr>
                    @if (collect($maid->workExperience)->count() > 0)
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
                    @else
                        <tr>
                            <td colspan="6">No Result for work overseas</td>
                        </tr>
                    @endif
                </table>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-8">
                <div style="font-weight: bold !important; font-size: 14px !important;">
                    C2 <span
                        style="font-weight: bold !important; font-size: 14px !important; margin-left: 35px !important;">Employment
                        History in Singapore</span> </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                <div class="text-justify text-dark fw-normal" style="font-size: 14px !important;">
                    Previous working experience in Singapore {!! $maid->work_singapore == 1
                        ? '<span class="border border-dark font-semibold me-2 ms-5" style="border: solid 1px #242424 !important;">V</span>'
                        : '<span class="border border-dark text-white me-2 ms-5" style="border: solid 1px #242424 !important; color:#fff !important;">V</span>' !!} Yes {!! $maid->work_singapore == 0
                        ? '<span class="border border-dark font-semibold me-2 ms-5" style="border: solid 1px #242424 !important;">V</span>'
                        : '<span class="border border-dark text-white me-2 ms-5" style="border: solid 1px #242424 !important; color:#fff !important;">V</span>' !!}
                    No
                </div>
                <p class="text-justify text-dark fw-normal"
                    style="font-size: 14px; !important; text-align: justify !important;">(The EA is
                    required to obtain the FDW’s employment history from MOM and furnish the employer with the
                    employment history of the FDW. The employer may also verify the FDW’s employment history in
                    Singapore through WPOL using SingPass)</p>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-8">
                <div style="font-weight: bold !important; font-size: 14px !important;">
                    C3 <span
                        style="font-weight: bold !important; font-size: 14px !important; margin-left: 35px !important;">Feedback
                        from previous employers in Singapore</span> </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                <div class="text-justify text-dark fw-normal"
                    style="font-size: 14px !important; text-align: justify !important;">Feedback
                    was/was not obtained by the EA from the previous employers. If feedback was obtained (attach
                    testimonial if possible), please indicate the feedback in the table below:</div>
                <table class="table table-bordered border-dark text-center">
                    <tr style="background: #a1a1a1 !important;" class="text-center">
                        <th>
                            <div>
                                <b>Date</b>
                            </div>
                        </th>
                        <th>
                            <div>
                                <b>Country (including FDW's home country)</b>
                            </div>
                        </th>
                    </tr>
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
                </table>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-8">
                <div style="font-weight: bold !important; font-size: 14px !important;">
                    (D) <u
                        style="font-weight: bold !important; font-size: 14px !important; margin-left: 35px !important;">AVAILABILITY
                        OF FDW TO BE INTERVIEWED BY PROSPECTIVE EMPLOYER</u> </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                @foreach ($interviews as $interview)
                    <div class="row mb-2">
                        <div class="text-dark">
                            @if ($interview->answer == 1)
                                <span class="me-3" style="border: solid 1px #242424 !important;">V</span>
                            @else
                                <span class="me-3"
                                    style="border: solid 1px #242424 !important; color:#fff !important;">V</span>
                            @endif
                            {{ $interview->question }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-8">
                <div style="font-weight: bold !important; font-size: 14px !important;">
                    (E) <u
                        style="font-weight: bold !important; font-size: 14px !important; margin-left: 35px !important;">OTHER
                        REMARKS</u> </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="border border-dark"
                    style="min-height: 10rem; width: 100%; border : solid 1px #242424 !important;">
                    {{ $maid->note }}
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <table class="table table-bordered" style="border: none; !important;">
                    <tr style="min-height: 35px !important; border-collapse: separate !important;">
                        <td style="border : none;">
                            <div
                                style="min-height: 150px !important; max-width: 70% !important; border-bottom: #242424 solid 1px !important; margin: 2px !important; padding: 2px !important;">
                            </div>
                        </td>
                        <td style="border : none;">
                            <div
                                style="min-height: 150px !important; max-width: 70% !important; border-bottom: #242424 solid 1px !important; margin: 2px !important; padding: 2px !important;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: none; padding-left: 10px !important;">FDW Name and Signature</td>
                        <td style="border: none; padding-left: 10px !important;">EA Personnel Name and Registration
                            Number</td>
                    </tr>
                    <tr>
                        <td style="border: none; padding-left: 10px !important;">Date : </td>
                        <td style="border: none; padding-left: 10px !important;">Date : </td>
                    </tr>
                    <tr>
                        <td style="border: none; padding-left: 10px !important;" class="mt-5 pt-5" colspan="2">
                            I have gone through
                            the <span class="pagenum"></span> page biodata of this FDW and confirm that I would like to
                            employ her</td>
                    </tr>
                    <tr style="min-height: 35px !important; border-collapse: separate !important;">
                        <td style="border : none;" colspan="2">
                            <div
                                style="min-height: 150px !important; max-width: 50% !important; border-bottom: #242424 solid 1px !important; margin: 2px !important; padding: 2px !important;">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="border: none; padding-left: 10px !important;">Employer Name and NRIC No.</td>
                    </tr>
                    <tr>
                        <td style="border: none; padding-left: 10px !important;">Date:</td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="row mb-3 mt-5 pt-5 text-center">
            <div class="col">
                ***************
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <u><b>IMPORTANT NOTES FOR EMPLOYERS WHEN USING THE SERVICES OF AN EA</b></u>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <ul>
                    <li style="text-align: justify !important;">Do consider asking for an FDW who is able to
                        communicate in a language you require, and
                        interview her (in person/phone/videoconference) to ensure that she can communicate adequately.
                    </li>
                    <li style="text-align: justify !important;">Do consider requesting for an FDW who has a proven
                        ability to perform the chores you require,
                        for example, performing household chores (especially if she is required to hang laundry from a
                        high-rise unit), cooking and caring for young children or the elderly.</li>
                    <li style="text-align: justify !important;">Do work together with the EA to ensure that a suitable
                        FDW is matched to you according to your
                        needs and requirements.</li>
                    <li style="text-align: justify !important;">You may wish to pay special attention to your
                        prospective FDW’s employment history and feedback
                        from the FDW’s previous employer(s) before employing her.</li>
                </ul>
            </div>
        </div>
    </div>
</body>

</html>
