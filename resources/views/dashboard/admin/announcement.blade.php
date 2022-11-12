<?php
use Illuminate\Support\Carbon;
?>
<div class="card shadow">
    <div class="card-header">
        <h4 class="card-title">Announcement</h4>
    </div>
    <div class="card-body">
        @if (collect($announcement)->count() > 0)
            <div class="row">
                <div class="col">
                    <h5 class="font-semibold">{{ $announcement->title }}</h5>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="text-justify">
                        {!! $announcement->body !!}
                    </p>
                </div>
            </div>
        @else
            <h5 class="font-semibold">No Announcement</h5>
        @endif
    </div>
</div>
