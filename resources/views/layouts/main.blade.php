<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title . ' | ' . env('APP_NAME', 'Template') }}</title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/mazer/dist/assets/css/bootstrap.css') }}?{{ rand() }}">
    <link rel="stylesheet"
        href="{{ asset('assets/mazer/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}?{{ rand() }}">
    <link rel="stylesheet"
        href="{{ asset('assets/mazer/dist/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}?{{ rand() }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}?{{ rand() }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/freezeUI/freeze-ui.min.css') }}?{{ rand() }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/icheck/icheck-bootstrap.min.css') }}?{{ rand() }}">
    <link rel="stylesheet"
        href="{{ asset('assets/mazer/dist/assets/vendors/rater-js/style.css') }}?{{ rand() }}">
    <link rel="stylesheet"
        href="{{ asset('assets/mazer/dist/assets/vendors/sweetalert2/sweetalert2.min.css') }}?{{ rand() }}">
    <link rel="stylesheet"
        href="{{ asset('assets/mazer/dist/assets/vendors/toastify/toastify.css') }}?{{ rand() }}">
    <link rel="stylesheet" href="{{ asset('assets/mazer/dist/assets/vendors/iconly/bold.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/flagIcons/css/flag-icons.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/mazer/dist/assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}?{{ rand() }}">
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/datepicker/css/datepicker-bs5.min.css') }}?{{ rand() }}">
    <link rel="stylesheet"
        href="{{ asset('assets/mazer/dist/assets/vendors/choices.js/choices.min.css') }}?{{ rand() }}">
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/jstree/themes/default/style.min.css') }}?{{ rand() }}">
    <link rel="stylesheet" href="{{ asset('assets/mazer/dist/assets/css/app.css') }}?{{ rand() }}">
    {{-- <link rel="shortcut icon" href="{{ asset('assets/mazer/dist/assets/images/favicon.svg') }}" type="image/x-icon"> --}}
    <link rel="shortcut icon" href="{{ asset('assets/image/header/logo.ico') }}" type="image/x-icon">
    @livewireStyles()

    <script>
        const baseUrl = '{{ url('') }}'
    </script>
</head>

<body>
    <div id="app">
        @include('partials.sidebar')
        <div id="main" class='layout-navbar'>
            @include('partials.topbar')
            <div id="main-content">
                @yield('content')
            </div>
            <footer class="bg-white bg-gradient">
                <div class="footer clearfix text-muted">
                    <div class="row">
                        <div class="col-12">
                            <div class="float-end py-4 pe-3">
                                <p>{{ now()->isoFormat('Y') }} &copy;
                                    <a href="#">SCD</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/mazer/dist/assets/vendors/jquery/jquery.min.js') }}?{{ rand() }}"></script>
    <script
        src="{{ asset('assets/mazer/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}?{{ rand() }}">
    </script>
    <script src="{{ asset('assets/vendor/fontawesome/js/all.min.js') }}?{{ rand() }}"></script>
    <script src="{{ asset('assets/vendor/freezeUI/freeze-ui.es5.min.js') }}?{{ rand() }}"></script>
    <script src="{{ asset('assets/mazer/dist/assets/vendors/sweetalert2/sweetalert2.min.js') }}?{{ rand() }}">
    </script>
    <script src="{{ asset('assets/mazer/dist/assets/vendors/toastify/toastify.js') }}?{{ rand() }}"></script>
    <script src="{{ asset('assets/mazer/dist/assets/vendors/rater-js/rater-js.js') }}?{{ rand() }}"></script>
    <script
        src="{{ asset('assets/mazer/dist/assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}?{{ rand() }}">
    </script>
    <script src="{{ asset('assets/vendor/momentjs/min/moment-with-locales.min.js') }}?{{ rand() }}"></script>
    <script src="{{ asset('assets/vendor/datepicker/js/datepicker-full.min.js') }}?{{ rand() }}"></script>
    <script src="{{ asset('assets/vendor/sortableEs6/Sortable.min.js') }}?{{ rand() }}"></script>
    <script
        src="{{ asset('assets/mazer/dist/assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}?{{ rand() }}">
    </script>
    <script src="{{ asset('assets/mazer/dist/assets/vendors/choices.js/choices.min.js') }}?{{ rand() }}">
    </script>
    <script src="{{ asset('assets/vendor/jstree/jstree.min.js') }}?{{ rand() }}"></script>
    <script src="{{ asset('assets/mazer/dist/assets/js/bootstrap.bundle.min.js') }}?{{ rand() }}"></script>
    <script src="{{ asset('assets/mazer/dist/assets/js/mazer.js') }}?{{ rand() }}"></script>
    <script>
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success mx-2',
                cancelButton: 'btn btn-danger mx-2'
            },
            buttonsStyling: false
        })

        const blockUI = () => {
            FreezeUI({
                text: 'Processing'
            });
        }

        const unBlockUI = () => {
            UnFreezeUI();
        }

        const blockModal = () => {
            FreezeUI({
                selector: '.modal-content',
                text: 'Processing'
            });
        }

        const unBlockModal = () => {
            UnFreezeUI();
        }

        const loggedOut = async (csrf) => {
            await swalWithBootstrapButtons.fire({
                title: 'Log Out',
                text: "Are you sure to logged out?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes'
            }).then(async (result) => {
                console.log(result);
                if (result.value) {
                    const url = `${baseUrl}/logout`;

                    const fetchOptions = {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            'X-CSRF-TOKEN': csrf
                        },
                    };

                    const response = await fetch(url, fetchOptions)
                        .then(response => {
                            if (!response.ok) {
                                const errorMessage = response.text();
                                throw new Error(errorMessage);
                            }

                            return response.json()
                        }).then(response => {
                            location.replace(`${baseUrl}/login`);
                        });
                }
            });
        }

        const myProfile = async () => {
            location.replace(`${baseUrl}/manage/profile`);
        }
    </script>
    <?php
    $js = isset($js) ? $js : [];
    if ($js) {
        for ($i = 0; $i < count($js); $i++) {
            echo '<script src="' . asset($js[$i]) . '?' . rand() . '"></script>';
        }
    }
    ?>
    @livewireScripts()
</body>

</html>
