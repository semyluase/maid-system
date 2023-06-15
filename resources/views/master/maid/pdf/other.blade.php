<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;700&display=swap');

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
            font-family: 'Poppins', sans-serif;
            font-size: 9px;
            max-width: 100%;
        }

        .column {
            float: left !important;
            width: 50% !important;
            padding: 5px !important;
        }

        /* Clear floats after the columns */
        .row {
            margin-right: 2.5rem !important;
            margin-left: 1rem !important;
            padding: 0 1rem !important;
            padding-bottom: 8px !important;
        }

        .row:after {
            content: "" !important;
            display: table !important;
            clear: both !important;
        }

        .text-mandarin {
            font-family: 'simsun' !important;
        }

        table tr {
            padding: 2px;
            margin: 2px;
        }

        table tr td {
            padding: 0;
            margin: 1rem;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ $header }}" alt="Header PDF" class="bg-white" style="width: 100%;">
    </header>
    <div class="row text-mandarin">
        <div class="column">
            <div class="text-center border border-1 border-dark" style="border: 1px solid #1b1b1b;"><span
                    class="text-mandarin">女傭履歷表</span> / Biodata
            </div>
            <table class="border-0" style="width: 100%;">
                <tr>
                    <td colspan="3">
                        <table class="border-0" style="width: 65%;">
                            <tr>
                                <td><span class="text-mandarin">編號</span> / Code</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ $maid->code_maid }}</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">姓名</span> / Name</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ Str::upper($maid->full_name) }}</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">國家</span> / Country</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ Str::upper($maid->country) }}</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">始訓日期</span> / Start Training</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ Carbon::parse($maid->date_training)->isoFormat('DD MMMM YYYY') }}</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">年齡</span> / Age</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ Carbon::parse($maid->date_of_birth)->age }} <span
                                        class="text-mandarin">年</span>/Years</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">出生地點</span>/ Place of Birth</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ $maid->place_of_birth }}</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">出生日期</span> / Date of Birth</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ Carbon::parse($maid->date_of_birth)->isoFormat('DD MMMM YYYY') }}</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">身高</span> / Height</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ $maid->height }} cm</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">體重</span> / Weight</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ $maid->weight }} kg</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">學歷</span> / Education Background</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ convertEducation($maid->education) }}</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">宗教</span> / Religion</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ convertReligion($maid->religion) }}</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">婚姻</span> / Marital Status</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ convertMaritalStatus($maid->marital) }}</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">家中排行</span> / Position In Family</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ $maid->number_in_family }}</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">姐妹</span> / Sister</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ $maid->sister }}</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">兄弟</span> / Brother</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ $maid->brother }}</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">家庭背景</span> / Family Background</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ $maid->family_background }}</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">兒女數目</span> / Number of Children</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ $maid->number_of_children }}</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">兒女年齡</span> / Age</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ $maid->children_ages }} <span class="text-mandarin">年</span> / Years</td>
                            </tr>
                            <tr>
                                <td><span
                                        class="text-mandarin">{{ $maid->sex == 1 ? '妻子的名字' : ($maid->sex == 2 ? '丈夫姓名' : '配偶的姓名') }}</span>
                                    /
                                    {{ $maid->sex == 1 ? 'Wife Name' : ($maid->sex == 2 ? 'Husband Name' : 'Spouse Name') }}
                                </td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ $maid->spouse_name }}</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">丈夫年齡</span> / Age</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ $maid->spouse_passed_away == 1 ? 'Passed Away' : $maid->spouse_age }} <span
                                        class="text-mandarin">年</span> / Years</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">父親姓名</span> / Father Name</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ $maid->father_name }}</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">父親年齡</span> / Age</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ $maid->father_passed_away == 1 ? 'Passed Away' : $maid->father_age }} <span
                                        class="text-mandarin">年</span> / Years</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">母親姓名</span> / Mother Name</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ $maid->mother_name }}</td>
                            </tr>
                            <tr>
                                <td><span class="text-mandarin">母親年齡</span> / Age</td>
                                <td style="margin-left 1rem !important; margin-right : 1rem !important;">:</td>
                                <td>{{ $maid->mother_passed_away == 1 ? 'Passed Away' : $maid->mother_age }} <span
                                        class="text-mandarin">年</span> / Years</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="padding-top: 1rem; text-align: center !important;">
                        <img src="{{ $photo }}" alt="Photo from {{ $maid->code_maid }}"
                            style="width: 100%; min-height:45%; max-height:48%; text-align: center !important;">
                    </td>
                </tr>
            </table>
        </div>
        <div class="column">
            <div class="text-center border border-1 border-dark" style="border: 1px solid #1b1b1b;"><span
                    class="text-mandarin">工作經驗</span> / Working
                Experience</div>
            <div class="text-left">
                <span class="text-mandarin">國外工作經驗</span> / Overseas Experience :
            </div>
            @if (collect($overseases)->count() > 0)
                @foreach ($overseases as $overseas)
                    <div style="min-height: 48px; border: 1px solid #1b1b1b; margin-bottom: 5px;">
                        <p class="text-mandarin" style="margin-bottom: 1px;">
                            {{ $overseas->country }} ({{ $overseas->year_start . ' - ' . $overseas->year_end }})
                        </p>
                        <p class="text-mandarin">
                            {{ $overseas->description }}
                        </p>
                    </div>
                @endforeach
            @else
                <div style="min-height: 48px; border: 1px solid #1b1b1b; margin-bottom: 5px;">
                </div>
            @endif
            <div class="text-left">
                <span class="text-mandarin">國內工作經驗</span> / Domestic Experience :
            </div>
            @if (collect($domestics)->count() > 0)
                @foreach ($domestics as $domestic)
                    <div class="text-mandarin" style="min-height: 48px; border: 1px solid #1b1b1b; margin-bottom: 5px;">
                        <p class="text-mandarin" style="margin-bottom: 1px;">
                            {{ $domestic->country }} ({{ $domestic->year_start . ' - ' . $domestic->year_end }})
                        </p>
                        <p class="text-mandarin">
                            {{ $domestic->description }}
                        </p>
                    </div>
                @endforeach
            @else
                <div style="min-height: 48px; border: 1px solid #1b1b1b; margin-bottom: 5px;">
                </div>
            @endif
            <div class="text-center border border-1 border-dark text-mandarin" style="border: 1px solid #1b1b1b;">
                <span class="text-mandarin">外語能力</span> / Languages</div>
            <table class="border-0" style="width: 100%;">
                @foreach ($languages as $language)
                    <tr>
                        @if ($language->is_check)
                            <td>
                                <span class="text-mandarin">{{ $language->question_hk }}</span>
                                /
                                {{ $language->question }}
                            </td>
                            <td>:</td>
                            @if ($language->rate == 1)
                                <td><span class="text-mandarin">差劲</span> / Poor</td>
                            @elseif ($language->rate == 2)
                                <td><span class="text-mandarin">公平的</span> / Fair</td>
                            @elseif ($language->rate == 3)
                                <td><span class="text-mandarin">好的</span> / Good</td>
                            @elseif ($language->rate == 4)
                                <td><span class="text-mandarin">很好</span> / Very Good</td>
                            @elseif ($language->rate == 5)
                                <td><span class="text-mandarin">出色的</span> / Excellent</td>
                            @else
                                <td>N/A</td>
                            @endif
                        @elseif ($language->is_input)
                            <td>{{ $language->note }}</td>
                            <td>:</td>
                            @if ($language->rate == 1)
                                <td><span class="text-mandarin">差劲</span> / Poor</td>
                            @elseif ($language->rate == 2)
                                <td><span class="text-mandarin">公平的</span> / Fair</td>
                            @elseif ($language->rate == 3)
                                <td><span class="text-mandarin">好的</span> / Good</td>
                            @elseif ($language->rate == 4)
                                <td><span class="text-mandarin">很好</span> / Very Good</td>
                            @elseif ($language->rate == 5)
                                <td><span class="text-mandarin">出色的</span> / Excellent</td>
                            @else
                                <td>N/A</td>
                            @endif
                        @endif
                    </tr>
                @endforeach
            </table>
            <div class="text-center border border-1 border-dark text-mandarin" style="border: 1px solid #1b1b1b;">
                <span class="text-mandarin">女傭是否同意以下條件</span> / Willingness
            </div>
            <table class="border-0" style="width: 100%;">
                @foreach ($willingnesses as $willingness)
                    <tr>
                        @if ($willingness->is_check)
                            <td>
                                <span class="text-mandarin">{{ $willingness->question_hk }}</span>
                                /
                                {{ $willingness->question }}
                            </td>
                            <td>:</td>
                            <td><span class="text-mandarin">是</span>/Yes
                                {!! $willingness->answer == 1
                                    ? '<span style="margin-left:5px !important;">V</span>'
                                    : '<span style="margin-left:5px !important; color:#ffffff;">V</span>' !!}</td>
                            <td><span class="text-mandarin">不</span>/No
                                {!! $willingness->answer == 0
                                    ? '<span style="margin-left:5px !important;">V</span>'
                                    : '<span style="margin-left:5px !important; color:#ffffff;">V</span>' !!}</td>
                        @elseif ($willingness->is_input)
                            <td>{{ $willingness->note }}</td>
                            <td>:</td>
                            <td colspan="2">{{ $willingness->note }}</td>
                        @endif
                    </tr>
                @endforeach
            </table>
            <div class="text-center border border-1 border-dark" style="border: 1px solid #1b1b1b;"><span
                    class="text-mandarin">女傭特殊工作經驗</span> / Speciality</div>
            <table class="border-0" style="width: 100%;">
                @foreach ($specialities as $speciality)
                    <tr>
                        @if ($speciality->is_check)
                            <td>
                                <span class="text-mandarin">{{ $speciality->question_hk }}</span>
                                /
                                {{ $speciality->question }}
                            </td>
                            <td>:</td>
                            <td><span class="text-mandarin">是</span>/Yes
                                {!! $speciality->answer == 1
                                    ? '<span style="margin-left:5px !important; padding-right:13px !important;">V</span>'
                                    : '<span style="margin-left:5px !important; padding-right:13px !important; color:#ffffff;">V</span>' !!}</td>
                            <td><span class="text-mandarin">不</span>/No
                                {!! $speciality->answer == 0
                                    ? '<span style="margin-left:5px !important; padding-right:13px !important;">V</span>'
                                    : '<span style="margin-left:5px !important; padding-right:13px !important; color:#ffffff;">V</span>' !!}</td>
                        @elseif ($speciality->is_input)
                            <td>{{ $speciality->note }}</td>
                            <td>:</td>
                            <td colspan="2">{{ $speciality->note }}</td>
                        @endif
                    </tr>
                @endforeach
            </table>
            <div class="text-center border border-1 border-dark" style="border: 1px solid #1b1b1b;"><span
                    class="text-mandarin">其他</span> / Other</div>
            <table class="border-0" style="width: 100%;">
                @foreach ($others as $other)
                    <tr>
                        @if ($other->is_check)
                            <td>
                                <span class="text-mandarin">{{ $other->question_hk }}</span>
                                /
                                {{ $other->question }}
                            </td>
                            <td>:</td>
                            <td><span class="text-mandarin">是</span>/Yes
                                {!! $other->answer == 1
                                    ? '<span style="margin-left: 5px !important;">V</span>'
                                    : '<span style="margin-left:5px !important; color:#ffffff;">V</span>' !!}</td>
                            <td><span class="text-mandarin">不</span>/No
                                {!! $other->answer == 0
                                    ? '<span style="margin-left: 5px !important;">V</span>'
                                    : '<span style="margin-left:5px !important; color:#ffffff;">V</span>' !!}</td>
                        @elseif ($other->is_input)
                            <td>{{ $other->note }}</td>
                            <td>:</td>
                            <td colspan="2">{{ $other->note }}</td>
                        @endif
                    </tr>
                @endforeach
            </table>
            <div class="text-center border border-1 border-dark" style="border: 1px solid #1b1b1b;"><span
                    class="text-mandarin">其他</span> / Remarks</div>
            <div style="min-height: 48px; margin-top: 5px!important; border: 1px solid #1b1b1b;">
                @if ($maid->address != null)
                    <p style="margin: 2px important;">Address : {{ $maid->address }}</p>
                @endif
                @if ($maid->contact != null)
                    <p style="margin: 2px important;">Contact : {{ $maid->contact }}</p>
                @endif
                @if ($maid->note != null)
                    <p style="margin: 2px important;">Note : {{ $maid->note }}</p>
                @endif
            </div>
        </div>
    </div>
    <p style="margin: 1rem 2.5rem !important;">Foreign Domestic Worker Declaration (<span
            class="text-mandarin">外籍家庭傭工聲明</span>)
    </p>
    <p style="margin: 1rem 2.5rem !important;">
        I hereby declare that all information given above are true, correct, and complete. The Agency Shall Not
        Liable If It Is Subsequently Established That The FDW Had Lied About Herself In The FDW's Biodata.
    </p>
    <p style="margin: 1rem 2.5rem !important;">
        ...........................................
    </p>
    <p style="margin: 1rem 2.5rem !important;">
        Foreign Domestic Worker's Signature (<span class="text-mandarin">外籍家庭傭工簽署</span>)
    </p>
</body>

</html>
