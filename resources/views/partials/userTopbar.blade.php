<div class="container">
    <div class="logo">
        <a class="h4 text-primary" href="{{ url('') }}">
            <img class="avatar avatar-xl" src="{{ asset('assets/image/header/logo.png') }}" alt="Logo"
                style="width: 40px; height: 40px;">
            {{ config('app.name') }}
        </a>
    </div>
    <div class="header-top-right">
        @include('partials.userNotification')

        <div class="dropdown">
            <a href="#" id="topbarUserDropdown"
                class="user-dropdown d-flex align-items-center dropend dropdown-toggle" data-bs-toggle="dropdown"
                aria-expanded="false">
                <div class="avatar avatar-md2">
                    <img src="{{ asset('assets/image/user/' . auth()->user()->image) }}" alt="Avatar" />
                </div>
                <div class="text">
                    <h6 class="user-dropdown-name">{{ Auth::user()->name }}</h6>
                    <p class="user-dropdown-status text-sm text-muted">
                        {{ Auth::user()->role->description }}
                    </p>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow-lg" aria-labelledby="topbarUserDropdown">
                <li>
                    <h6 class="dropdown-header">Hello, {{ Auth::user()->name }}</h6>
                </li>
                <li><a class="dropdown-item" href="{{ url('') }}/manage/profile">My Profile</a></li>
                <li>
                    <hr class="dropdown-divider" />
                </li>
                <li>
                    <a class="dropdown-item" href="javascript:;" onclick="loggedOut('{{ csrf_token() }}')"><i
                            class="fa-solid fa-arrow-right-to-bracket me-2"></i>Logout</a>
                </li>
            </ul>
        </div>

        <!-- Burger button responsive -->
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </div>
</div>
