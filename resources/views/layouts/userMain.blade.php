<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ $title . ' | ' . env('APP_NAME', 'Template') }}</title>

    <link rel="stylesheet" href="{{ asset('assets/mazer/dist/assets/css/bootstrap.css') }}?v={{ rand() }}">
    <link rel="stylesheet"
        href="{{ asset('assets/mazer/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.css') }}?v={{ rand() }}">
    <link rel="stylesheet"
        href="{{ asset('assets/mazer/dist/assets/vendors/bootstrap-icons/bootstrap-icons.css') }}?v={{ rand() }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/css/all.min.css') }}?v={{ rand() }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/freezeUI/freeze-ui.min.css') }}?v={{ rand() }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/icheck/icheck-bootstrap.min.css') }}?v={{ rand() }}">
    <link rel="stylesheet"
        href="{{ asset('assets/mazer/dist/assets/vendors/rater-js/style.css') }}?v={{ rand() }}">
    <link rel="stylesheet"
        href="{{ asset('assets/mazer/dist/assets/vendors/sweetalert2/sweetalert2.min.css') }}?v={{ rand() }}">
    <link rel="stylesheet"
        href="{{ asset('assets/mazer/dist/assets/vendors/toastify/toastify.css') }}?v={{ rand() }}">
    <link rel="stylesheet"
        href="{{ asset('assets/mazer/dist/assets/vendors/jquery-datatables/jquery.dataTables.bootstrap5.min.css') }}?v={{ rand() }}">
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/datepicker/css/datepicker-bs5.min.css') }}?v={{ rand() }}">
    <link rel="stylesheet"
        href="{{ asset('assets/mazer/dist/assets/vendors/choices.js/choices.min.css') }}?v={{ rand() }}">
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/jstree/themes/default/style.min.css') }}?v={{ rand() }}">
    <link rel="stylesheet" href="{{ asset('assets/mazer/dist/assets/css/main/app.css') }}" />
    {{-- <link rel="shortcut icon" href="{{ asset('assets/mazer/dist/assets/images/logo/favicon.svg') }}"
        type="image/x-icon" /> --}}
    <link rel="shortcut icon" href="{{ asset('assets/image/header/logo.ico') }}" type="image/png" />

    <link rel="stylesheet" href="{{ asset('assets/mazer/dist/assets/vendors/iconly/bulk.css') }}" />
    @livewireStyles()

    <script>
        const baseUrl = '{{ url('') }}'
    </script>
</head>

<body>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <header class="mb-5">
                <div class="header-top">
                    @include('partials.userTopbar')
                </div>
                <nav class="main-navbar">
                    <div class="container">
                        @include('partials.userNavbar')
                    </div>
                </nav>
            </header>

            <div class="content-wrapper container">
                @yield('content')
            </div>

            <footer class="fixed-bottom">
                <div class="container">
                    <div class="footer clearfix mb-0 text-muted">
                        <div class="float-end">
                            <p>{{ now()->isoFormat('Y') }} &copy;
                                <a href="#">SCD</a>
                            </p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/mazer/dist/assets/vendors/jquery/jquery.min.js') }}?v={{ rand() }}"></script>
    <script
        src="{{ asset('assets/mazer/dist/assets/vendors/perfect-scrollbar/perfect-scrollbar.min.js') }}?v={{ rand() }}">
    </script>
    <script src="{{ asset('assets/vendor/fontawesome/js/all.min.js') }}?v={{ rand() }}"></script>
    <script src="{{ asset('assets/vendor/freezeUI/freeze-ui.es5.min.js') }}?v={{ rand() }}"></script>
    <script src="{{ asset('assets/mazer/dist/assets/vendors/sweetalert2/sweetalert2.min.js') }}?v={{ rand() }}">
    </script>
    <script src="{{ asset('assets/mazer/dist/assets/vendors/toastify/toastify.js') }}?v={{ rand() }}"></script>
    <script src="{{ asset('assets/mazer/dist/assets/vendors/rater-js/rater-js.js') }}?v={{ rand() }}"></script>
    <script
        src="{{ asset('assets/mazer/dist/assets/vendors/jquery-datatables/jquery.dataTables.min.js') }}?v={{ rand() }}">
    </script>
    <script src="{{ asset('assets/vendor/momentjs/min/moment-with-locales.min.js') }}?v={{ rand() }}"></script>
    <script src="{{ asset('assets/mazer/dist/assets/vendors/ckeditor/ckeditor.js') }}?v={{ rand() }}"></script>
    <script src="{{ asset('assets/vendor/datepicker/js/datepicker-full.min.js') }}?v={{ rand() }}"></script>
    <script
        src="{{ asset('assets/mazer/dist/assets/vendors/jquery-datatables/custom.jquery.dataTables.bootstrap5.min.js') }}?v={{ rand() }}">
    </script>
    <script src="{{ asset('assets/mazer/dist/assets/vendors/choices.js/choices.min.js') }}?v={{ rand() }}">
    </script>
    <script src="{{ asset('assets/vendor/jstree/jstree.min.js') }}?v={{ rand() }}"></script>
    <script src="{{ asset('assets/mazer/dist/assets/js/bootstrap.bundle.min.js') }}?v={{ rand() }}"></script>
    <script src="{{ asset('assets/mazer/dist/assets/js/pages/horizontal-layout.js') }}?v={{ rand() }}"></script>
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
            echo '<script src="' . asset($js[$i]) . '?v=' . rand() . '"></script>';
        }
    }
    ?>
    @livewireScripts()
</body>

</html>
