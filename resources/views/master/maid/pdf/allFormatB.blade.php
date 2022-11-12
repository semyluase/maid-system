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
            margin: 50px 64px;
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
    <div style="color: #0a0a0a; font-size:16px; text-align: center; font-weight: 700">PT. GRAHA MITRA BALINDO</div>
    <div style="border:solid 2px #0a0a0a;">
        <div
            style="font-size:14px; text-align: center; font-weight: 400; padding-top: 2px; padding-bottom: 2px; border-bottom: 2px #0a0a0a solid;">
            APPLICATION'S INFORMATION</div>
        <div>
            <div style="border-bottom: #0a0a0a solid 3px;">
                <table style="width: 100%;">
                    <tbody>
                        <tr>
                            <td style="width: 75%;">
                                <table style="width: 100%;">
                                    <tbody>
                                        <tr>
                                            <td style="width: 25%;">Nama</td>
                                            <td>:</td>
                                            <td
                                                style="width: 75%; border-bottom: #0a0a0a solid 1px; text-align: center;">
                                                {{ $maid->full_name }}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 25%;">Alamat</td>
                                            <td>:</td>
                                            <td
                                                style="width: 75%; border-bottom: #0a0a0a solid 1px; text-align: center;">
                                                {{ $maid->address }}</td>
                                        </tr>
                                        <tr>
                                            <td style="width: 25%;">No. Telp</td>
                                            <td>:</td>
                                            <td
                                                style="width: 75%; border-bottom: #0a0a0a solid 1px; text-align: center;">
                                                {{ $maid->contact }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                            <td style="width: 25%;">
                                <table style="width: 100%; border-collapse: collapse;">
                                    <tbody>
                                        <tr>
                                            <td style="border: #0a0a0a solid 1px; text-align: center;">Kode</td>
                                        </tr>
                                        <tr style="padding: 2px 3px;">
                                            <td style="border: #0a0a0a solid 1px; text-align: center;">
                                                {{ $maid->code_maid }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div>
                <table style="width: 100%; border-collapse: collapse; text-align: center">
                    <tr style="border-bottom: #aaaaaa solid 1px;">
                        <td style="width: 33.3%; border-right: #0a0a0a 3px solid;">Tempat Lahir</td>
                        <td style="width: 33.3%; border-right: #0a0a0a 3px solid;">Tanggal Lahir</td>
                        <td style="width: 33.3%; ">Umur</td>
                    </tr>
                    <tr style="border-bottom: #0a0a0a solid 3px;">
                        <td style="width: 33.3%; border-right: #0a0a0a 3px solid;">{{ $maid->place_of_birth }}</td>
                        <td style="width: 33.3%; border-right: #0a0a0a 3px solid;">
                            {{ Carbon::parse($maid->date_of_birth)->isoFormat('DD MMMM YYYY') }}</td>
                        <td style="width: 33.3%; ">{{ Carbon::parse($maid->date_of_birth)->age }}</td>
                    </tr>
                </table>
            </div>
            <div>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="border-bottom: #0a0a0a solid 3px;">
                        <td style="width: 20%;">Status</td>
                        @foreach ($marital as $m => $value)
                            <td style="width: 20%;">
                                {!! $m == $maid->marital
                                    ? '<span style="border: #0a0a0a solid 1px; margin-right:5px;">V</span>'
                                    : '<span style="border: #0a0a0a solid 1px; margin-right:5px; color:#ffffff;">V</span>' !!}
                                <span style="margin-right: 5px;">{{ $value }}</span>
                            </td>
                        @endforeach
                    </tr>
                </table>
            </div>
            <div>
                <table style="width: 100%; border-collapse: collapse; text-align: center">
                    <tr style="border-bottom: #aaaaaa solid 1px;">
                        <td style="width: 20%; border-right: #0a0a0a 3px solid;">Tinggi</td>
                        <td style="width: 20%; border-right: #0a0a0a 3px solid;">Berat</td>
                        <td style="width: 20%; border-right: #0a0a0a 3px solid;">Suku</td>
                        <td style="width: 20%; border-right: #0a0a0a 3px solid;">Agama</td>
                        <td style="width: 20%; ">Hobby</td>
                    </tr>
                    <tr style="border-bottom: #0a0a0a solid 3px;">
                        <td style="width: 20%; border-right: #0a0a0a 3px solid;">{{ $maid->height }}</td>
                        <td style="width: 20%; border-right: #0a0a0a 3px solid;">
                            {{ $maid->weight }}</td>
                        <td style="width: 20%; border-right: #0a0a0a 3px solid;">
                            {{ $maid->ethnic }}</td>
                        <td style="width: 20%; border-right: #0a0a0a 3px solid;">
                            {{ convertReligion($maid->religion) }}</td>
                        <td style="width: 20%; ">{{ $maid->hobby }}</td>
                    </tr>
                </table>
            </div>
            <div>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="border-bottom: #0a0a0a solid 3px;">
                        <td style="width: 20%;">Bahasa</td>
                        <td>
                            @foreach ($languages as $language)
                                {!! $language->answer == 1
                                    ? '<span style="border: #0a0a0a solid 1px; margin-right:5px;">V</span>'
                                    : '<span style="border: #0a0a0a solid 1px; margin-right:5px; color:#ffffff;">V</span>' !!} <span
                                    style="margin-right: 5px;">{{ $language->question }}</span>
                            @endforeach
                        </td>
                    </tr>
                </table>
            </div>
            <div>
                <table style="width: 100%; border-collapse: collapse; text-align: center">
                    <tr style="border-bottom: #aaaaaa solid 1px;">
                        <td style="width: 20%; border-right: #0a0a0a 3px solid;">No. Paspor</td>
                        <td style="width: 20%; border-right: #0a0a0a 3px solid;">Tempat Issue</td>
                        <td style="width: 20%; border-right: #0a0a0a 3px solid;">Tanggal Issue</td>
                        <td style="width: 20%; ">Masa Berlaku</td>
                    </tr>
                    <tr style="border-bottom: #0a0a0a solid 3px;">
                        <td style="width: 20%; border-right: #0a0a0a 3px solid;">{{ $maid->paspor_no }}</td>
                        <td style="width: 20%; border-right: #0a0a0a 3px solid;">
                            {{ $maid->paspor_issue }}</td>
                        <td style="width: 20%; border-right: #0a0a0a 3px solid;">
                            {{ $maid->paspor_date ? Carbon::parse($maid->paspor_date)->isoFormat('DD MMMM YYYY') : '' }}
                        </td>
                        <td style="width: 20%; ">
                            {{ $maid->expire_date ? Carbon::parse($maid->expire_date)->isoFormat('DD MMMM YYYY') : '' }}
                        </td>
                    </tr>
                </table>
            </div>
            <div>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="border-bottom: #0a0a0a solid 3px;">
                        <td>
                            @foreach ($medicals as $medical)
                                <span style="margin-right: 5px;">{{ $medical->question }}</span>
                                {!! $medical->answer == 1
                                    ? '<span style="border: #0a0a0a solid 1px; margin-right:5px;">V</span>'
                                    : '<span style="border: #0a0a0a solid 1px; margin-right:5px; color:#ffffff;">V</span>' !!} <span style="margin-right: 5px;">Y</span>
                                {!! $medical->answer == 0
                                    ? '<span style="border: #0a0a0a solid 1px; margin-right:5px;">V</span>'
                                    : '<span style="border: #0a0a0a solid 1px; margin-right:5px; color:#ffffff;">V</span>' !!} <span style="margin-right: 5px;">N</span>
                            @endforeach
                        </td>
                    </tr>
                </table>
            </div>
            <div>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="border-bottom: #0a0a0a solid 3px;">
                        <td style="width: 20%;">Pendidikan</td>
                        <td>
                            @foreach ($education as $e => $value)
                                {!! $e == $maid->education
                                    ? '<span style="border: #0a0a0a solid 1px; margin-right:5px;">V</span>'
                                    : '<span style="border: #0a0a0a solid 1px; margin-right:5px; color:#ffffff;">V</span>' !!} <span style="margin-right: 15px;">{{ $value }}</span>
                            @endforeach
                        </td>
                    </tr>
                </table>
            </div>
            <div>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr style="border-bottom: #0a0a0a solid 3px;">
                        <td style="width: 50%; border-right: #0a0a0a solid 3px;">
                            <table style="width:100%;">
                                <tbody>
                                    <tr style="border-bottom: #0a0a0a solid 3px;">
                                        <td colspan="4" style="text-align: center;">
                                            Latar Belakang Keluarga
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: #aaaaaa solid 1px;">
                                        <td style="text-align: center;">
                                            Ayah
                                        </td>
                                        <td style="border-right: #0a0a0a solid 1px; text-align: center;">
                                            Umur
                                        </td>
                                        <td style="text-align: center;">
                                            Ibu
                                        </td>
                                        <td style="text-align: center;">
                                            Umur
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: #0a0a0a solid 1px;">
                                        <td style="text-align: center;">
                                            {{ $maid->father_name }}
                                        </td>
                                        <td style="border-right: #0a0a0a solid 1px; text-align: center;">
                                            {{ $maid->father_age }}
                                        </td>
                                        <td style="text-align: center;">
                                            {{ $maid->mother_name }}
                                        </td>
                                        <td style="text-align: center;">
                                            {{ $maid->mother_age }}
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: #aaaaaa solid 1px;">
                                        <td colspan="4" style="text-align: center;">
                                            Nama suami/istri : {{ $maid->spouse_name }}
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: #0a0a0a solid 1px;">
                                        <td colspan="4" style="text-align: center;">
                                            Umur : {{ $maid->spouse_age }}
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: #aaaaaa solid 1px;">
                                        <td colspan="4" style="text-align: center;">
                                            Jumlah saudara/saudari : {{ $maid->number_of_siblings }}
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: #0a0a0a solid 1px;">
                                        <td colspan="4" style="text-align: center;">
                                            Sendiri urutan : {{ $maid->number_in_family }}
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: #aaaaaa solid 1px;">
                                        <td colspan="4" style="text-align: center;">
                                            Jumlah anak : {{ $maid->number_of_children }}
                                        </td>
                                    </tr>
                                    <tr style="border-bottom: #0a0a0a solid 1px;">
                                        <td colspan="4" style="text-align: center;">
                                            Umur : {{ $maid->children_ages }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="4" style="text-align: center; font-weight: 700;">
                                            Pengalaman Kerja
                                        </td>
                                    </tr>
                                    @foreach ($maid->workExperience as $work)
                                        <tr>
                                            <td colspan="4">
                                                {{ $work->country }}
                                                ({{ $work->year_start }} -
                                                {{ $work->year_end }})
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">
                                                {{ $work->description }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </td>
                        <td style="width: 50%;">
                            <table style="width:100%;">
                                <tbody>
                                    <tr>
                                        <td style="text-align: center;">
                                            <img src="{{ $photo }}" alt="Photo of {{ $maid->code_maid }}"
                                                style="width: 250px; height: 350px;">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

</body>

</html>
