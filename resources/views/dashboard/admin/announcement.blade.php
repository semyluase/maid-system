<?php
use Illuminate\Support\Carbon;
?>
<div class="card shadow">
    <div class="card-header">
        <div class="row">
            <div class="col-6">
                <h4>Announcement</h4>
            </div>
            <div class="col-6 d-flex justify-content-end">
                <button class="btn btn-primary" onclick="window.open('{{ url('') }}/announcements')"><i
                        class="fa-solid fa-download me-2"></i>Announcement</button>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if (collect($announcement)->count() > 0)
            <div class="row">
                <div class="col">
                    <p class="text-justify">
                        {!! $announcement->body !!}
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="table-responsive">
                        <table class="table table-lg table-striped">
                            <thead>
                                <tr>
                                    <th scope="col">No</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Branch</th>
                                    <th scope="col">Whatsapp</th>
                                    <th scope="col">Code</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (collect($contactPersons)->count() > 0)
                                    @foreach ($contactPersons as $contactPerson)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $contactPerson->name }}</td>
                                            <td>{{ $contactPerson->branch }}</td>
                                            <td>{{ $contactPerson->whatsapp }}</td>
                                            <td>{{ $contactPerson->code }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="5" class="text-center">No Results</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="text-justify">*for example biodata code <strong>"K3500"</strong>, sales can call direct
                        to code <strong>"K"</strong></div>
                </div>
            </div>
            <hr class="divider">
            <div class="row">
                <div class="col d-flex gap-1">
                    <div class="text-black"><i class="fa-brands fa-whatsapp me-1"></i>+6281-282828-600</div>
                    <div class="text-black"><i class="fa-brands fa-facebook me-1"></i>graha mitra balindo</div>
                    <div class="text-black"><i class="fa-brands fa-instagram me-1"></i>daftargmb</div>
                    <div class="text-black"><i class="fa-brands fa-line me-1"></i>daftargmb</div>
                </div>
            </div>
        @else
            <h5 class="font-semibold">No Announcement</h5>
        @endif
    </div>
</div>
