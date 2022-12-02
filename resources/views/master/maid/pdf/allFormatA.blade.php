<?php

use Illuminate\Support\Carbon;

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
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&family=Roboto:wght@300;400;500;700&display=swap');

        @font-face {
            font-family: 'yusei magic';
            src: url('assets/fonts/yuseimagic/YuseiMagic-Regular.ttf') format('truetype');
        }

        @font-face {
            font-family: 'simsun';
            src: url('assets/fonts/simsun/simsun.ttf') format('truetype');
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Popins', sans-serif;
            font-size: 12px;
            max-width: 100%;
        }

        body {
            margin: 0 64px 0 64px;
        }

        .text-mandarin {
            font-family: 'simsun' !important;
        }

        table tr {
            padding: 2px;
            margin: 2px;
        }

        td {
            padding-bottom: 4px;
            padding-top: 4px;
            padding-right: 2px;
            padding-left: 2px;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ $header }}" alt="Header PDF" class="bg-white" style="width: 100%;">
    </header>
    <div style="color: #8d3f3f; font-size:20px; text-align: center; font-weight: 700">PERSONAL BIODATA</div>
    <div
        style="border-style:solid none; border-top-width: 1px; border-bottom-width: 2px; border-color: #0a0a0a; background: rgba(18, 141, 199, 0.836)">
        <div style="color: #0f29a0; font-size:16px; text-align: center; font-weight: 400">B I O D A T A</div>
    </div>
    <div style="margin: 2px 0;"></div>
    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 25%;">Application number</td>
                <td>:</td>
                <td colspan="5" style="width:73%;border-bottom: #0a0a0a solid 1px; color: #0f29a0;">
                    {{ $maid->code_maid }}</td>
            </tr>
            <tr>
                <td style="width: 25%;">Name</td>
                <td>:</td>
                <td colspan="5" style="width:73%;border-bottom: #0a0a0a solid 1px; color: #0f29a0;">
                    {{ $maid->full_name }}</td>
            </tr>
            <tr>
                <td style="width: 25%;">Place, date of birth</td>
                <td>:</td>
                <td colspan="5" style="width:73%;border-bottom: #0a0a0a solid 1px; color: #0f29a0;">
                    {{ $maid->place_of_birth }},
                    {{ Carbon::parse($maid->date_of_birth)->isoFormat('DD MMMM YYYY') }}</td>
            </tr>
            <tr>
                <td style="width: 25%;">Height</td>
                <td>:</td>
                <td style="width:14%;border-bottom: #0a0a0a solid 1px; color: #0f29a0;">{{ $maid->height }} CM</td>
                <td style="width: 14%;">Weight</td>
                <td style="width:14%;border-bottom: #0a0a0a solid 1px; color: #0f29a0;">{{ $maid->weight }} KG</td>
                <td style="width: 14%;">Religion</td>
                <td style="width:14%;border-bottom: #0a0a0a solid 1px; color: #0f29a0;">
                    {{ convertReligion($maid->religion) }}</td>
            </tr>
            <tr>
                <td style="width: 25%;">Address</td>
                <td>:</td>
                <td colspan="5" style="width:73%;border-bottom: #0a0a0a solid 1px; color: #0f29a0;">
                    {{ $maid->address }}</td>
            </tr>
            <tr>
                <td style="width: 25%;">Brother & Sister</td>
                <td>:</td>
                <td style="width:14%;border-bottom: #0a0a0a solid 1px; color: #0f29a0;">{{ $maid->number_of_siblings }}
                </td>
                <td style="width: 14%;">I'm number</td>
                <td style="width:14%;border-bottom: #0a0a0a solid 1px; color: #0f29a0;">{{ $maid->number_in_family }}
                </td>
                <td style="width: 14%;">Telp</td>
                <td style="width:14%;border-bottom: #0a0a0a solid 1px; color: #0f29a0;">
                    {{ $maid->contact }}</td>
            </tr>
            <tr>
                <td style="width: 25%;">Marital status</td>
                <td colspan="6" style="width:75%;border-bottom: #0a0a0a solid 1px;">
                    @foreach ($marital as $m => $value)
                        {!! $m == $maid->marital
                            ? '<span style="border: #0a0a0a solid 1px; margin-right:5px;">V</span>'
                            : '<span style="border: #0a0a0a solid 1px; margin-right:5px; color:#ffffff;">V</span>' !!} <span style="margin-right: 5px;">{{ $value }}</span>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td style="width: 25%;">Heir name</td>
                <td>:</td>
                <td colspan="5" style="width:73%;border-bottom: #0a0a0a solid 1px; color: #0f29a0;">
                    {{ $maid->hobby }}</td>
            </tr>
            <tr>
                <td style="width: 25%;">Number and ages of children</td>
                <td>:</td>
                <td colspan="5" style="width:73%;border-bottom: #0a0a0a solid 1px; color: #0f29a0;">
                    {{ $maid->number_of_children }}, {{ $maid->children_ages }}</td>
            </tr>
            <tr>
                <td style="width: 25%;">Education</td>
                <td colspan="6" style="width:75%;border-bottom: #0a0a0a solid 1px;">
                    @foreach ($education as $e => $value)
                        {!! $e == $maid->education
                            ? '<span style="border: #0a0a0a solid 1px; margin-right:5px;">V</span>'
                            : '<span style="border: #0a0a0a solid 1px; margin-right:5px; color:#ffffff;">V</span>' !!} <span style="margin-right: 10px;">{{ $value }}</span>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td style="width: 25%;">Language</td>
                <td colspan="6" style="width:75%;border-bottom: #0a0a0a solid 1px;">
                    @foreach ($languages as $language)
                        {!! $language->answer == 1
                            ? '<span style="border: #0a0a0a solid 1px; margin-right:5px;">V</span>'
                            : '<span style="border: #0a0a0a solid 1px; margin-right:5px; color:#ffffff;">V</span>' !!} <span style="margin-right: 5px;">{{ $language->question }}</span>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td style="width: 25%;">Cooking ability</td>
                <td colspan="6" style="width:75%;border-bottom: #0a0a0a solid 1px;">
                    @foreach ($specialities as $speciality)
                        {!! $speciality->answer == 1
                            ? '<span style="border: #0a0a0a solid 1px; margin-right:5px;">V</span>'
                            : '<span style="border: #0a0a0a solid 1px; margin-right:5px; color:#ffffff;">V</span>' !!} <span style="margin-right: 10px;">{{ $speciality->question }}</span>
                    @endforeach
                </td>
            </tr>
            <tr>
                <td style="width: 45%;">
                    <table style="width:100%;">
                        <tbody>
                            <tr>
                                <td style="background: #aaaaaa; text-align: center;">
                                    I CAN SERVE YOU BETTER
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: center;">
                                    <img src="{{ $photo }}" alt="Photo of {{ $maid->code_maid }}"
                                        style="width: 250px; height: 350px;">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                <td colspan="6" style="width:55%;">
                    <table style="width:100%;">
                        <tbody>
                            <tr>
                                <td
                                    style="background: rgba(18, 141, 199, 0.836); text-align: center; border-bottom:#0a0a0a 2px solid; border-top: #0a0a0a 1px solid; font-size: 16px;">
                                    WORK CHOSEN
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    @foreach ($willingnesses as $willingness)
                                        @if ($willingness->is_check)
                                            {!! $willingness->answer == 1
                                                ? '<span style="border: #0a0a0a solid 1px; margin-right:5px;">V</span>'
                                                : '<span style="border: #0a0a0a solid 1px; margin-right:5px; color:#ffffff;">V</span>' !!} <span
                                                style="margin-right: 10px;">{{ $willingness->question }}</span>
                                        @else
                                            {!! $willingness->note != null
                                                ? '<span style="border: #0a0a0a solid 1px; margin-right:5px; margin-bottom:20px;">V</span>'
                                                : '<span style="border: #0a0a0a solid 1px; margin-right:5px; color:#ffffff; margin-bottom:20px;">V</span>' !!} <span
                                                style="margin-right: 10px; margin-bottom:20px;">{{ $willingness->question }}
                                                : </span>
                                            @if ($willingness->note != null)
                                                <span
                                                    style="margin-right: 10px;"><u>{{ $willingness->note }}</u></span>
                                            @else
                                                <span
                                                    style="margin-right: 10px; margin-bottom:20px;">..............................</span>
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="background: rgba(18, 141, 199, 0.836); text-align: center; border-bottom:#0a0a0a 2px solid; border-top: #0a0a0a 1px solid; font-size: 16px;">
                                    INTERVIEW APPRAISAL
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <table style="width: 100%;">
                                        <tr>
                                            <td></td>
                                            <td colspan="2" style="text-align: center;">
                                                Fair
                                            </td>
                                            <td colspan="3" style="text-align: center;">
                                                Good
                                            </td>
                                            <td colspan="2" style="text-align: center;">
                                                Excellent</td>
                                        </tr>
                                        @foreach ($interviews as $interview)
                                            <tr>
                                                <td>{{ $interview->question }}</td>
                                                <td>{!! $interview->rate == 1
                                                    ? '<span style="border: #0a0a0a solid 1px; margin-right:5px;">V</span>'
                                                    : '<span style="border: #0a0a0a solid 1px; margin-right:5px; color:#ffffff;">V</span>' !!}</td>
                                                <td>{!! $interview->rate == 2
                                                    ? '<span style="border: #0a0a0a solid 1px; margin-right:5px;">V</span>'
                                                    : '<span style="border: #0a0a0a solid 1px; margin-right:5px; color:#ffffff;">V</span>' !!}</td>
                                                <td>{!! $interview->rate == 3
                                                    ? '<span style="border: #0a0a0a solid 1px; margin-right:5px;">V</span>'
                                                    : '<span style="border: #0a0a0a solid 1px; margin-right:5px; color:#ffffff;">V</span>' !!}</td>
                                                <td>{!! $interview->rate == 4
                                                    ? '<span style="border: #0a0a0a solid 1px; margin-right:5px;">V</span>'
                                                    : '<span style="border: #0a0a0a solid 1px; margin-right:5px; color:#ffffff;">V</span>' !!}</td>
                                                <td>{!! $interview->rate == 5
                                                    ? '<span style="border: #0a0a0a solid 1px; margin-right:5px;">V</span>'
                                                    : '<span style="border: #0a0a0a solid 1px; margin-right:5px; color:#ffffff;">V</span>' !!}</td>
                                                <td>{!! $interview->rate == 6
                                                    ? '<span style="border: #0a0a0a solid 1px; margin-right:5px;">V</span>'
                                                    : '<span style="border: #0a0a0a solid 1px; margin-right:5px; color:#ffffff;">V</span>' !!}</td>
                                                <td>{!! $interview->rate == 7
                                                    ? '<span style="border: #0a0a0a solid 1px; margin-right:5px;">V</span>'
                                                    : '<span style="border: #0a0a0a solid 1px; margin-right:5px; color:#ffffff;">V</span>' !!}</td>
                                            </tr>
                                        @endforeach
                                    </table>
                                </td>
                            </tr>
                            <tr>
                                <td
                                    style="background: rgba(18, 141, 199, 0.836); text-align: center; border-bottom:#0a0a0a 2px solid; border-top: #0a0a0a 1px solid; font-size: 16px;">
                                    REMARKS
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    @foreach ($maid->workExperience as $work)
                                        <div>{{ $work->country }}
                                            ({{ $work->year_start }} -
                                            {{ $work->year_end }})
                                        </div>
                                        <div>{{ $work->description }}
                                        </div>
                                    @endforeach
                                    <div>Note : {{ $maid->note }}
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>

</html>
