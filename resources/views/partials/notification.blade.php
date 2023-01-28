<li class="nav-item dropdown me-6 pe-5">
    {{--

    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
        <li>
            <h6 class="dropdown-header">Notifications</h6>
        </li>
        @if (collect($notifications)->count() > 0)
            @foreach ($notifications as $n)
                <li>
                    <a class="dropdown-item"><strong class="text-muted">{{ Str::upper($n->type) }}</strong> -
                        {{ Str::title(Str::words($n->message, 5, '...')) }}</a>
                </li>
            @endforeach
            <hr class="divider">
            <li>
                <small>
                    <a href="javascript:;" class="dropdown-item text-center text-muted">Show all notification</a>
                </small>
            </li>
        @else
            <li>
                <a class="dropdown-item">No notification available</a>
            </li>
        @endif
    </ul> --}}
    <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell fs-3 text-dark position-relative">
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                style="font-size: 0.7rem;">
                @livewire('notification-total')
                <span class="visually-hidden">Notification</span>
            </span>
        </i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
        <li>
            <h6 class="dropdown-header">Notifications</h6>
        </li>
        @livewire('show-notification')
    </ul>
</li>
