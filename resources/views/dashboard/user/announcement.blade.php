<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Announcement</h4>
            </div>
            <div class="card-body">
                @if (collect($announcement)->count() > 0)
                    <div class="row mb-4">
                        <div class="col">
                            <div class="h5 text-bold text-primary">
                                {{ $announcement->title }}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            {!! $announcement->body !!}
                        </div>
                    </div>
                @else
                    <div class="row mb-4">
                        <div class="col">
                            <div class="h5 text-bold text-primary">
                                No New Announcement
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
