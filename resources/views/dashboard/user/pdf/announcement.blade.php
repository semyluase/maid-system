<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Announcement</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: Arial, Helvetica, sans-serif
        }

        body {
            margin-top: 2rem;
            font-size: 11px;
        }

        .container {
            margin: 2rem 3rem;
        }

        .contact {
            margin: 2rem 0;
        }

        table {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            font-size: 11px;
            width: 100%;
        }

        table td,
        table th {
            border: 1px solid #ddd;
            padding: 8px;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #48c99a;
            color: white;
        }

        footer {
            margin: 0.5rem 3rem;
        }
    </style>
</head>

<body>
    <header>
        <img src="{{ $header }}" alt="" style="width: 100%; margin-top:-2rem;">
    </header>
    <div class="container">
        {!! $announcement->body !!}
        <div class="contact">
            <table>
                <tr>
                    <th>Name</th>
                    <th>Branch</th>
                    <th>Whatsapp</th>
                    <th>Code</th>
                </tr>
                @foreach ($contactPersons as $contact)
                    <tr>
                        <td>{{ $contact->name }}</td>
                        <td>{{ $contact->branch }}</td>
                        <td>{{ $contact->whatsapp }}</td>
                        <td>{{ $contact->code }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
        <div class="row">
            <div class="col">
                <div class="text-justify">*for example biodata code <strong>"K3500"</strong>, sales can call
                    direct
                    to code <strong>"K"</strong></div>
            </div>
        </div>
    </div>
    <hr>
    <footer>
        <span class="text-black"><img src="{{ $whatsapp }}" alt="" style="width: 12px;">
            +6281-282828-600</span>
        <span class="text-black"><img src="{{ $facebook }}" alt="" style="width: 12px;"> graha mitra
            balindo</span>
        <span class="text-black"><img src="{{ $instagram }}" alt="" style="width: 12px;"> daftargmb</span>
        <span class="text-black"><img src="{{ $line }}" alt="" style="width: 12px;"> daftargmb</span>
    </footer>
</body>

</html>
