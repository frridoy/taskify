@php
    use Illuminate\Support\Str;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- bootstrap css link -->
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous" /> --}}

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/css/bootstrap.min.css" />


    <!-- bootstrap icon link -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.3/font/bootstrap-icons.min.css" />

    <!-- Link Swiper's CSS -->
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/9.4.1/swiper-bundle.css">

    {{-- DATATABLES --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.0/css/buttons.dataTables.min.css">

    <script src="{{ asset('js/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('js/customSweetalert2.js') }}"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/css/select2.min.css" rel="stylesheet" />

    <link href="{{ asset('css/iziToast.css') }}" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

    <!-- custom css link -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/dash-style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/lab-style.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/custom-select2.css') }}" />


    {{-- Favicon --}}
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">


    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.css" rel="stylesheet">



    <title></title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <style>
        .dataTable {
            min-height: 380px;
        }

        .dataTables_filter {
            margin-bottom: 10px;
        }

        .select2-search__field {
            background-color: white !important;
        }

        .error {
            color: red !important;
        }

        .invalid-feedback {
            color: red;
            font-size: 0.875em;
        }

        /* Ensure the main content pushes footer down */
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .main-content {
            flex: 1;
        }

        .footer-bg {
            background-color: #f8f9fa;
            text-align: center;
            margin-top: 50px;

        }
    </style>

    @stack('css')
</head>

<body>
    @include('partials.top-bar')
    <div class="d-flex">
        @include('partials.sidebar')
        <main class="dashboard-main">
            @include('partials.header')
            @yield('content')
            {{-- @include('dashboard.partials.footer') --}}
        </main>
    </div>




    <script src="{{ asset('js/iziToast.js') }}"></script>
    @include('vendor.lara-izitoast.toast')

    <!-- bootstrap js link -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous">
    </script> --}}

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0-alpha1/js/bootstrap.bundle.min.js"></script>

    {{-- DATATABLES --}}
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>


    <!-- custom js -->
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- <script src="{{ asset('js/dashboardCartCalculation.js') }}"></script> --}}
    <script src="{{ asset('js/date.js') }}"></script>
    <script src="{{ asset('js/dbActionConfirmation.js') }}"></script>
    {{-- <script src="{{ asset('js/dbCalculation.js') }}"></script> --}}
    <script src="{{ asset('js/dbPassToggle.js') }}"></script>
    <script src="{{ asset('js/dbPaymentWith.js') }}"></script>
    <script src="{{ asset('js/dbSelectChange.js') }}"></script>
    {{-- <script src="{{ asset('js/dbTablecheck.js') }}"></script> --}}
    <script src="{{ asset('js/dbUploadTemplateLogo.js') }}"></script>
    <script src="{{ asset('js/editProfile.js') }}"></script>
    <script src="{{ asset('js/labRegPayCal.js') }}"></script>
    <script src="{{ asset('js/passwordShow.js') }}"></script>
    {{-- <script src="{{ asset('js/stickyNav.js') }}"></script> --}}
    <script src="{{ asset('js/tmRemarkChecked.js') }}"></script>
    {{-- <script src="{{ asset('js/transferLab.js') }}"></script> --}}
    <script src="{{ asset('js/uploadFile.js') }}"></script>
    <script src="{{ asset('js/uplodSignture.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Function to open sidebar on mobile
            $('#openSidebar').click(function() {
                $('.dashboard-sidebar-bg').removeClass('sidebar-closed');
                $('.dashboard-sidebar-bg').addClass('sidebar-open');
            });

            // Function to close sidebar on mobile
            $('#closeSidebar').click(function() {
                $('.dashboard-sidebar-bg').addClass('sidebar-closed');
                $('.dashboard-sidebar-bg').removeClass('sidebar-open');
            });



            $('.select2').select2({
                width: '100%',
                tags: true
            });

            $('.summernote').summernote({
                height: 300,
            });
            $('.dropdown-toogle').dropdown();
        });

        // $('.dataTable').DataTable({
        //     pageLength: 30,
        //     "ordering": true,
        //     "lengthMenu": [10, 20, 30, 50, 100, 500]
        // });
    </script>

    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.7.2/js/buttons.colVis.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.dataTable').DataTable({
                "ordering": true,
                pageLength: 100,
                "lengthMenu": [10, 20, 30, 50, 100, 500],
                dom: 'Bfrtip',
                buttons: [
                    'pageLength',
                    {
                        extend: 'copy',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                var columnCount = $('.dataTable thead th').length;
                                return idx < (columnCount - 1);
                            }
                        }
                    },
                    {
                        extend: 'csv',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                var columnCount = $('.dataTable thead th').length;
                                return idx < (columnCount - 1);
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                var columnCount = $('.dataTable thead th').length;
                                return idx < (columnCount - 1);
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                var columnCount = $('.dataTable thead th').length;
                                return idx < (columnCount - 1);
                            }
                        }
                    },
                    {
                        extend: 'print',
                        exportOptions: {
                            columns: function(idx, data, node) {
                                var columnCount = $('.dataTable thead th').length;
                                return idx < (columnCount - 1);
                            }
                        }
                    }
                ]
            });
        });
    </script>

    @stack('js')
</body>

</html>
