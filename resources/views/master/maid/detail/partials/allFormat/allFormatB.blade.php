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
                <div class="card-title text-center h1">
                    PT. GRAHA MITRA BALINDO
                </div>
            </div>
            <div class="card-body">
                <div class="row border border-3 border-dark">
                    <div class="col">
                        <div class="row border-bottom border-3 border-dark">
                            <div class="col">
                                <h2 class="text-center">
                                    APPLICATION'S INFORMATION
                                </h2>
                            </div>
                        </div>
                        <div class="row border-bottom border-3 border-dark">
                            <div class="col-9">
                                <table class="table table-borderless">
                                    <tr>
                                        <td>Nama</td>
                                        <td>:</td>
                                        <td>
                                            <div class="row">
                                                <div class="col border-dark border-bottom text-dark text-center">
                                                    {{ $maid->full_name }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td rowspan="2">Alamat</td>
                                        <td rowspan="2">:</td>
                                        <td>
                                            <div class="row">
                                                <div
                                                    class="col text-uppercase border-dark border-bottom text-dark text-center">
                                                    {{ $maid->address }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col border-dark border-bottom text-dark text-center py-1">

                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>No. Telp</td>
                                        <td>:</td>
                                        <td>
                                            <div class="row">
                                                <div class="col border-dark border-bottom text-dark text-center py-1">
                                                    {{ $maid->contact }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-3 mt-3 font-bold">
                                <table class="table table-bordered border-2 border-dark">
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col text-dark text-center">
                                                    Kode
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <div class="row">
                                                <div class="col text-dark text-center py-4 mx-auto">
                                                    {{ $maid->code_maid }}
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row text-center">
                            <div class="col-4 border-end border-bottom border-3 border-dark font-bold text-dark">
                                Tempat Lahir
                            </div>
                            <div class="col-4 border-end border-bottom border-3 border-dark font-bold text-dark">
                                Tanggal Lahir
                            </div>
                            <div class="col-4 border-bottom border-3 border-dark font-bold text-dark">
                                Umur
                            </div>
                        </div>
                        <div class="row border-bottom border-3 border-dark text-center">
                            <div class="col-4 border-end border-3 border-dark text-dark">
                                {{ $maid->place_of_birth }}
                            </div>
                            <div class="col-4 border-end border-3 border-dark text-dark">
                                {{ Carbon::parse($maid->date_of_birth)->isoFormat('DD MMMM YYYY') }}
                            </div>
                            <div class="col-4 text-dark">
                                {{ Carbon::parse($maid->date_of_birth)->age }} Thn
                            </div>
                        </div>
                        <div class="row text-center border-bottom border-dark border-3 text-dark">
                            <div class="col my-auto">
                                Status
                            </div>
                            @foreach ($marital as $m => $v)
                                <div class="col">
                                    <div class="form-check icheck-greensea">
                                        <input class="form-check-input" type="checkbox" value="" id="marital"
                                            {{ $maid->marital == $m ? 'checked' : '' }}>
                                        <label class="form-check-label" for="marital">
                                            {{ $v }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row text-center">
                            <div class="col border-end border-bottom border-3 border-dark font-bold text-dark">
                                Tinggi
                            </div>
                            <div class="col border-end border-bottom border-3 border-dark font-bold text-dark">
                                Berat
                            </div>
                            <div class="col border-end border-bottom border-3 border-dark font-bold text-dark">
                                Suku
                            </div>
                            <div class="col border-end border-bottom border-3 border-dark font-bold text-dark">
                                Agama
                            </div>
                            <div class="col border-bottom border-3 border-dark font-bold text-dark">
                                Hobby
                            </div>
                        </div>
                        <div class="row border-bottom border-3 border-dark text-center">
                            <div class="col border-end border-3 border-dark text-dark">
                                {{ $maid->height }} cm
                            </div>
                            <div class="col border-end border-3 border-dark text-dark">
                                {{ $maid->weight }} kg
                            </div>
                            <div class="col border-end border-3 border-dark text-dark">
                                {{ $maid->ethnic }}
                            </div>
                            <div class="col border-end border-3 border-dark text-dark">
                                {{ convertReligion($maid->religion) }}
                            </div>
                            <div class="col border-3 border-dark font-bold text-dark">
                                {{ $maid->hobby }}
                            </div>
                        </div>
                        <div class="row border-bottom border-3 border-dark text-center">
                            <div class="col text-dark">
                                Bahasa
                            </div>
                            @foreach ($languages as $l)
                                <div class="col border-start border-3 border-dark">
                                    <div class="form-check icheck-greensea">
                                        <input class="form-check-input" type="checkbox" value="" id="language"
                                            {{ $l->answer == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label" for="language">
                                            {{ $l->question }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row text-center">
                            <div class="col border-end border-bottom border-3 border-dark font-bold text-dark">
                                No. Paspor
                            </div>
                            <div class="col border-end border-bottom border-3 border-dark font-bold text-dark">
                                Tempat Issue
                            </div>
                            <div class="col border-end border-bottom border-3 border-dark font-bold text-dark">
                                Tanggal Issue
                            </div>
                            <div class="col border-bottom border-3 border-dark font-bold text-dark">
                                Masa Berlaku
                            </div>
                        </div>
                        <div class="row border-bottom border-3 border-dark text-center">
                            <div class="col border-end border-3 border-dark text-dark">
                                {{ $maid->paspor_no ? $maid->paspor_no : '-' }}
                            </div>
                            <div class="col border-end border-3 border-dark text-dark">
                                {{ $maid->paspor_issue ? $maid->paspor_issue : '-' }}
                            </div>
                            <div class="col border-end border-3 border-dark text-dark">
                                {{ $maid->paspor_date ? Carbon::parse($maid->paspor_date)->isoFormat('DD MMMM YYYY') : '-' }}
                            </div>
                            <div class="col border-3 border-dark font-bold text-dark">
                                {{ $maid->expire_date ? Carbon::parse($maid->expire_date)->isoFormat('DD MMMM YYYY') : '-' }}
                            </div>
                        </div>
                        <div class="row border-bottom border-3 border-dark text-center">
                            @foreach ($medicals as $medical)
                                <div class="col text-dark">
                                    <div class="row">
                                        <div class="col mt-1">
                                            {{ $medical->question }}
                                        </div>
                                        <div class="col">
                                            <div class="form-check icheck-greensea">
                                                <input class="form-check-input" type="radio" value=""
                                                    id="medical{{ $medical->id }}"
                                                    {{ $medical->answer == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label"
                                                    for="medical{{ $medical->id }}">Yes</label>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-check icheck-greensea">
                                                <input class="form-check-input" type="radio" value=""
                                                    id="medical{{ $medical->id }}"
                                                    {{ $medical->answer == 1 ? '' : 'checked' }}>
                                                <label class="form-check-label"
                                                    for="medical{{ $medical->id }}">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row border-bottom border-3 border-dark text-center">
                            <div class="col text-dark">
                                Pendidikan
                            </div>
                            @foreach ($education as $e => $v)
                                <div class="col">
                                    <div class="form-check icheck-greensea">
                                        <input class="form-check-input" type="checkbox" value=""
                                            id="education" {{ $maid->education == $e ? 'checked' : '' }}>
                                        <label class="form-check-label" for="education">
                                            {{ $v }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="row border-bottom border-3 border-dark text-center">
                            <div class="col-8 border-end border-3 border-dark">
                                <div class="row">
                                    <div class="col border-bottom border-3 border-dark text-center text-dark h3">
                                        Latar Belakang Keluarga
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 text-center text-dark">
                                        Ayah
                                    </div>
                                    <div class="col-6 text-center text-dark">
                                        Umur
                                    </div>
                                </div>
                                <div class="row border-bottom border-3 border-dark">
                                    <div class="col-6 text-center text-dark">
                                        {{ $maid->father_name ? $maid->father_name : '-' }}
                                    </div>
                                    <div class="col-6 text-center text-dark">
                                        {{ $maid->father_age ? $maid->father_age : '-' }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6 text-center text-dark">
                                        Nama Suami/Istri :
                                    </div>
                                    <div class="col-6 text-center text-dark">
                                        {{ $maid->spouse_name ? $maid->spouse_name : '-' }}
                                    </div>
                                </div>
                                <div class="row border-bottom border-3 border-dark">
                                    <div class="col-6 text-center text-dark">
                                        Umur :
                                    </div>
                                    <div class="col-6 text-center text-dark">
                                        {{ $maid->spouse_age ? $maid->spouse_age : '-' }}
                                    </div>
                                </div>
                                <div class="row border-bottom border-3 border-dark">
                                    <div class="col text-center text-dark">
                                        Jumlah Saudara dan Saudari
                                    </div>
                                    <div class="col text-center text-dark">
                                        {{ $maid->number_of_siblings ? $maid->number_of_siblings : '-' }}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-center font-bold text-dark">
                                        Pengalaman Kerja
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col text-center text-dark">
                                        @foreach ($maid->workExperience as $work)
                                            <div class="row">
                                                <div class="col text-justify text-dark">
                                                    {{ $work->country }}
                                                    ({{ $work->year_start }} -
                                                    {{ $work->year_end }})
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col text-justify text-dark">
                                                    {{ $work->description }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="col-8 border-end border-3 border-dark">
                            </div>
                            <div class="col-4 text-center text-dark">
                                <img src="{{ asset($maid->picture_location . $maid->picture_name) }}" alt=""
                                    style="max-height: 350px !important; max-width:250px !important;">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
