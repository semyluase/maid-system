<div class="card">
    <div class="card-header">
        <h4>Agency</h4>
    </div>
    <div class="card-content pb-4">
        @if (collect($agencies)->count() > 0)
            @foreach ($agencies as $agency)
                <div class="recent-message d-flex px-4 py-3">
                    <div class="avatar avatar-lg">
                        <img src="{{ asset('assets/image/user/' . $agency->image) }}" />
                    </div>
                    <div class="name ms-4">
                        <h5 class="mb-1">{{ $agency->name }}</h5>
                        <h6 class="text-muted mb-0">{{ $agency->username }}</h6>
                    </div>
                </div>
            @endforeach
        @else
            <div class="recent-message d-flex px-4 py-3">
                <div class="name ms-4">
                    <h5 class="mb-1">No Agency</h5>
                </div>
            </div>
        @endif
    </div>
</div>
