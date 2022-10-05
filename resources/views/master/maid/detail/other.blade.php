<?php

use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

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
                <div class="card-content">
                    <img src="{{ asset('assets/image/header/header.png') }}" alt="Header GMBalindo"
                        class="card-image-top img-fluid" style="max-height: 18rem; min-width: 100%;">
                </div>
                <div class="card-body bg-light-info">
                    <div class="row">
                        <div class="col-6">
                            <table class="border-0 text-dark" style="width: 100%;">
                                <tr class="font-semibold">
                                    <td>編號 / Code</td>
                                    <td>:</td>
                                    <td>{{ $maid->code_maid }}</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>姓名 / Name</td>
                                    <td>:</td>
                                    <td>{{ $maid->full_name }}</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>國家 / Country</td>
                                    <td>:</td>
                                    <td>{{ $maid->country }}</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>始訓日期 / Start of Training</td>
                                    <td>:</td>
                                    <td>{{ Carbon::parse($maid->start_training)->isoFormat('DD MMMM YYYY') }}</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>年齡 / Age</td>
                                    <td>:</td>
                                    <td>{{ Carbon::parse($maid->date_of_birth)->age }} 年 / Years</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>出生地點 / Place of Birth</td>
                                    <td>:</td>
                                    <td>{{ $maid->place_of_birth }}</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>出生日期 / Date of Birth</td>
                                    <td>:</td>
                                    <td>{{ Carbon::parse($maid->date_of_birth)->isoFormat('DD MMMM YYYY') }}</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>身高 / Height</td>
                                    <td>:</td>
                                    <td>{{ $maid->height ? $maid->height : 0 }} cm</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>體重 / Weight</td>
                                    <td>:</td>
                                    <td>{{ $maid->weight ? $maid->weight : 0 }} kg</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>學歷 / Education Background</td>
                                    <td>:</td>
                                    <td>{{ convertEducation($maid->education) }}</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>宗教 / Religion</td>
                                    <td>:</td>
                                    <td>{{ convertReligion($maid->religion) }}</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>婚姻 / Marital Status</td>
                                    <td>:</td>
                                    <td>{{ convertMaritalStatus($maid->marital) }}</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>家中排行 / Position in the Family</td>
                                    <td>:</td>
                                    <td>{{ $maid->number_in_family }}</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>姐妹 / Sister</td>
                                    <td>:</td>
                                    <td>{{ $maid->sister }}</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>兄弟 / Brother</td>
                                    <td>:</td>
                                    <td>{{ $maid->brother }}</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>家庭背景 / Family Background</td>
                                    <td>:</td>
                                    <td>{{ $maid->family_background }}</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>兒女數目 / Number of Children</td>
                                    <td>:</td>
                                    <td>{{ $maid->number_of_children }}</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>兒女年齡 / Age</td>
                                    <td>:</td>
                                    <td>{{ $maid->children_ages }}</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>{{ $maid->sex == 1 ? '妻子的名字 / Wife Name' : ($maid->sex == 2 ? '丈夫姓名 / Husband Name' : '配偶的姓名 / Spouse Name') }}
                                    </td>
                                    <td>:</td>
                                    <td>{{ $maid->spouse_name }}</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>丈夫年齡 / Age</td>
                                    <td>:</td>
                                    <td>{{ $maid->spouse_passed_away == 1 ? 'Passed Away' : $maid->spouse_age . ' 年 / Years' }}
                                    </td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>父親姓名 / Father Name</td>
                                    <td>:</td>
                                    <td>{{ $maid->father_name }}</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>丈夫年齡 / Age</td>
                                    <td>:</td>
                                    <td>{{ $maid->father_passed_away == 1 ? 'Passed Away' : $maid->father_age . ' 年 / Years' }}
                                    </td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>母親姓名 / Mother Name</td>
                                    <td>:</td>
                                    <td>{{ $maid->father_name }}</td>
                                </tr>
                                <tr class="font-semibold">
                                    <td>丈夫年齡 / Age</td>
                                    <td>:</td>
                                    <td>{{ $maid->mother_passed_away == 1 ? 'Passed Away' : $maid->mother_age . ' 年 / Years' }}
                                    </td>
                                </tr>
                                <tr class="font-semibold">
                                    <td colspan="3" class="text-center">
                                        <img src="{{ asset($maid->picture_location . $maid->picture_name) }}"
                                            alt="{{ 'Photo of ' . $maid->code_maid }}" class="img-thumbnail" width="50%"
                                            height="70%">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-6 font-semibold">
                            <div class="row mb-2">
                                <div class="col border border-dark">
                                    <div class="text-center text-dark font-bold">工作經驗 / Working Experience</div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="text-dark font-bold">國外工作經驗 / Overseas Experience:</div>
                                </div>
                            </div>
                            @if (collect($maid->workExperience)->filter(fn($value, $key) => $value->work_overseas == 1)->count() > 0)
                                @foreach ($maid->workExperience as $work)
                                    @if ($work->work_overseas)
                                        <div class="row" style="min-height: 5rem;">
                                            <div class="col">
                                                <div class="card rounded-0 border border-dark bg-transparent px-0 mx-0"
                                                    style="min-height: 5rem;">
                                                    <div class="card-body bg-transparent p-0 m-0">
                                                        <p class="card-text">{{ $work->country }}
                                                            ({{ $work->year_start . ' - ' . $work->year_end }})
                                                        </p>
                                                        <p class="card-text">{{ $work->description }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="row" style="min-height: 5rem;">
                                    <div class="col">
                                        <div class="card rounded-0 border border-dark bg-transparent px-0 mx-0"
                                            style="min-height: 5rem;">
                                            <div class="card-body bg-transparent p-0 m-0">
                                                <p class="card-text"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row mb-2">
                                <div class="col">
                                    <div class="text-dark font-bold">國內工作經驗 / Domestic Experience:</div>
                                </div>
                            </div>
                            @if (collect($maid->workExperience)->filter(fn($value, $key) => $value->work_overseas == 0)->count() > 0)
                                @foreach ($maid->workExperience as $work)
                                    @if (!$work->work_overseas)
                                        <div class="row" style="min-height: 5rem;">
                                            <div class="col">
                                                <div class="card rounded-0 border border-dark bg-transparent px-0 mx-0"
                                                    style="min-height: 5rem;">
                                                    <div class="card-body bg-transparent p-0 m-0">
                                                        <p class="card-text text-dark p-0 m-0">{{ $work->country }}
                                                            ({{ $work->year_start . ' - ' . $work->year_end }})
                                                        </p>
                                                        <p class="card-text text-dark p-0 m-0">{{ $work->description }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            @else
                                <div class="row" style="min-height: 5rem;">
                                    <div class="col">
                                        <div class="card rounded-0 border border-dark bg-transparent px-0 mx-0"
                                            style="min-height: 5rem;">
                                            <div class="card-body bg-transparent p-0 m-0">
                                                <p class="card-text"></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            <div class="row mb-2">
                                <div class="col border border-dark">
                                    <div class="text-center text-dark font-bold">外語能力 / Languages</div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <table class="border-0" style="width: 100%;">
                                        @foreach ($languages as $language)
                                            <tr class="text-dark font-semibold">
                                                @if ($language->is_check)
                                                    <td>{{ $language->question_hk }} / {{ $language->question }}</td>
                                                    <td>:</td>
                                                    @if ($language->rate == 1)
                                                        <td>差劲 / Poor</td>
                                                    @elseif ($language->rate == 2)
                                                        <td>公平的 / Fair</td>
                                                    @elseif ($language->rate == 3)
                                                        <td>好的 / Good</td>
                                                    @elseif ($language->rate == 4)
                                                        <td>很好 / Very Good</td>
                                                    @elseif ($language->rate == 5)
                                                        <td>出色的 / Excellent</td>
                                                    @else
                                                        <td>N/A</td>
                                                    @endif
                                                @elseif ($language->is_input)
                                                    <td>{{ $language->note }}</td>
                                                    <td>:</td>
                                                    @if ($language->rate == 1)
                                                        <td>差劲 / Poor</td>
                                                    @elseif ($language->rate == 2)
                                                        <td>公平的 / Fair</td>
                                                    @elseif ($language->rate == 3)
                                                        <td>好的 / Good</td>
                                                    @elseif ($language->rate == 4)
                                                        <td>很好 / Very Good</td>
                                                    @elseif ($language->rate == 5)
                                                        <td>出色的 / Excellent</td>
                                                    @else
                                                        <td>N/A</td>
                                                    @endif
                                                @endif
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col border border-dark">
                                    <div class="text-center text-dark font-bold">女傭是否同意以下條件 / Willingness</div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <table class="border-0" style="width: 100%;">
                                        @foreach ($willingnesses as $willingness)
                                            <tr class="text-dark font-semibold">
                                                <td>{{ $willingness->question_hk }} / {{ $willingness->question }}</td>
                                                <td>:</td>
                                                @if ($willingness->is_check)
                                                    <td>是/Yes {!! $willingness->answer ? '<span class="border border-dark ms-2 me-2" style="min-width: 10px;">V</span>' : '' !!}</td>
                                                    <td>不/No {!! $willingness->answer ? '' : '<span class="border border-dark ms-2 me-2" style="min-width: 10px;">V</span>' !!}</td>
                                                @elseif ($willingness->is_input)
                                                    <td colspan="2">{{ $willingness->note }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col border border-dark">
                                    <div class="text-center text-dark font-bold">女傭特殊工作經驗 / Speciality</div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <table class="border-0" style="width: 100%;">
                                        @foreach ($specialities as $speciality)
                                            <tr class="text-dark font-semibold">
                                                <td>{{ $speciality->question_hk }} / {{ $speciality->question }}</td>
                                                <td>:</td>
                                                @if ($speciality->is_check)
                                                    <td>是/Yes {!! $speciality->answer ? '<span class="border border-dark ms-2 me-2" style="min-width: 10px;">V</span>' : '' !!}</td>
                                                    <td>不/No {!! $speciality->answer ? '' : '<span class="border border-dark ms-2 me-2" style="min-width: 10px;">V</span>' !!}</td>
                                                @elseif ($speciality->is_input)
                                                    <td colspan="2">{{ $speciality->note }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col border border-dark">
                                    <div class="text-center text-dark font-bold">其他 / Others</div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <table class="border-0" style="width: 100%;">
                                        @foreach ($others as $other)
                                            <tr class="text-dark font-semibold">
                                                <td>{{ $other->question_hk }} / {{ $other->question }}</td>
                                                <td>:</td>
                                                @if ($other->is_check)
                                                    <td>是/Yes {!! $other->answer ? '<span class="border border-dark ms-2 me-2" style="min-width: 10px;">V</span>' : '' !!}</td>
                                                    <td>不/No {!! $other->answer ? '' : '<span class="border border-dark ms-2 me-2" style="min-width: 10px;">V</span>' !!}</td>
                                                @elseif ($other->is_input)
                                                    <td colspan="2">{{ $other->note }}</td>
                                                @endif
                                            </tr>
                                        @endforeach
                                    </table>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col border border-dark">
                                    <div class="text-center text-dark font-bold">備註 / Remarks</div>
                                </div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-12">
                                    <div class="row" style="min-height: 5rem;">
                                        <div class="col">
                                            <div class="card rounded-0 border border-dark bg-transparent px-0 mx-0"
                                                style="min-height: 5rem;">
                                                <div class="card-body bg-transparent p-0 m-0">
                                                    @if ($maid->address)
                                                        <p class="card-text text-dark p-0 m-0">Address :
                                                            {{ $maid->address }}</p>
                                                    @endif
                                                    @if ($maid->contact)
                                                        <p class="card-text text-dark p-0 m-0">Contact :
                                                            {{ $maid->contact }}</p>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
