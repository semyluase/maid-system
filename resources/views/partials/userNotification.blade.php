<div class="dropdown me-3 pe-3 d-none d-md-block d-lg-block d-xl-block">
    <a class="dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="bi bi-bell fs-3 position-relative">
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.7rem;">
                @livewire('notification-total-user')
            </span>
        </i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
        <li>
            <h6 class="dropdown-header">Notifications</h6>
        </li>
        @livewire('show-notification-user')
    </ul>
</div>