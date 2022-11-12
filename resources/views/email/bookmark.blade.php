<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('assets/mazer/dist/assets/css/bootstrap.css') }}">
    <title>{{ config('app.name') }}</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col">
                <h4 class="text-center">{{ $mailData['title'] }}</h4>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <p class="text-center">{{ $mailData['codeMaid'] }} Has been booked by {{ $mailData['agency'] }} till
                    {{ $mailData['dateBook'] }}</p>
            </div>
        </div>
        <div class="row my-5 py-5">
            <div class="col">
                {{ config('app.name') }}
            </div>
        </div>
    </div>
</body>

</html>
