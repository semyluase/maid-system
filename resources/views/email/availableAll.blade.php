<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>


<?php
use Illuminate\Support\Carbon;
?>


<body>
    <section class="container">
        <div class="row">
            <div class="col">
                <h4 class="text-center">{{ $mailData['title'] }}</h4>
            </div>
        </div>
        <div class="row my-5">
            <div class="col">
                <div class="text-center">
                    Here we send you our available biodata.<br>Kindly upload Job Order once employer is confirmed or
                    contact our admin for booking of further inquiry.<br><br><br>Happy Marketing!
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="table-responsive">
                    <table class="table table-bordered border border-1 border-dark">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Code</td>
                                <td>Name</td>
                                <td>Age</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mailData['maid'] as $maid)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $maid->code_maid }}</td>
                                    <td>{{ $maid->full_name }}</td>
                                    <td>
                                        {{ Carbon::parse($maid->date_of_birth)->age }} Years
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="row my-5 py-5">
            <div class="col">
                {{ config('app.name') }}
            </div>
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
</body>

</html>
