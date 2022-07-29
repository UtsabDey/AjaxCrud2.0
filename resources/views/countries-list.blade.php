<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Ajax Crud</title>

    <link rel="stylesheet" href="{{ asset('bootstrap/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('datatable/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.0/font/bootstrap-icons.css">
</head>

<body>
    <div class="container my-3">
        <h2 class="bg-info text-light shadow">
            <marquee behavior="" direction="">Laravel-8 Ajax Crud Application</marquee>
        </h2>
        <div class="row my-5">
            <div class="col-sm-8">
                <div class="card shadow">
                    <div class="card-header bg-info d-flex justify-content-between align-items-center">
                        <h3 class="text-light">Country List</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped table-bordered table-hover table-responsive table-condensed"
                            id="countries-table">
                            <thead>
                                <th>ID</th>
                                <th>Country Name</th>
                                <th>Capital City</th>
                                <th class="d-flex justify-content-center">Actions</th>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="card shadow">
                    <div class="card-header bg-info d-flex justify-content-between align-items-center">
                        <h3 class="text-white" id="addT">Add Countries</h3>
                    </div>
                    <div class="card-body">
                        <form action="{{ url('/add-country') }}" method="POST" id="add-country-form">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Country Name</label>
                                <input type="text" class="form-control" name="country_name" id="country_name">
                                <span class="text-danger country_name_error" id="country_name_error"></span>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Capital City</label>
                                <input type="text" class="form-control" name="capital_city" id="capital_city">
                                <span class="text-danger capital_city_error" id="capital_city_error"></span>
                            </div>
                            <button type="submit" class="btn btn-sm btn-success me-2" id="addButton"><i
                                    class="bi bi-plus-circle me-1"></i>Add</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('edit-country-modal')

    <script src="{{ asset('jquery/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('datatable/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('datatable/js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="{{ asset('sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="{{ asset('toastr/toastr.min.js') }}"></script>

    <script>
        toastr.options.preventDuplicates = true;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(function() {

            // Add New Country
            $('#add-country-form').on('submit', function(e) {
                e.preventDefault();
                // alert('Add Country');
                var form = this;
                $.ajax({
                    type: "POST",
                    url: $(form).attr('action'),
                    data: new FormData(form),
                    processData: false,
                    dataType: "json",
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.text-danger').text('');
                    },
                    success: function(data) {
                        if (data.code == 400) {
                            $.each(data.error, function(key, value) {
                                $(form).find('span.' + key + '_error').text(value[0]);
                            });
                        } else {
                            $(form)[0].reset();
                            //  alert(data.message);
                            $('#countries-table').DataTable().ajax.reload(null, false);
                            toastr.success(data.message);
                        }
                    }
                });
            });

            // Get All Data
            $('#countries-table').DataTable({
                processing: true,
                info: true,
                ajax: "{{ url('get-country') }}",
                "pageLength": 5,
                "aLengthMenu": [
                    [5, 10, 25, 50, -1],
                    [5, 10, 25, 50, "All"]
                ],
                columns: [
                    // {
                    //     data: 'id',
                    //     name: 'id'
                    // },
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'country_name',
                        name: 'country_name'
                    },
                    {
                        data: 'capital_city',
                        name: 'capital_city'
                    },
                    {
                        data: 'actions',
                        name: 'actions'
                    },
                ]
            });

            // Edit Country
            $(document).on('click', '#editCountryBtn', function() {
                var country_id = $(this).data('id');
                $.post('<?= url('countryDetails') ?>', {
                    country_id: country_id
                }, function(data) {
                    //  alert(data.details.country_name);
                    $('.editCountry').find('input[name="cid"]').val(data.details.id);
                    $('.editCountry').find('input[name="country_name"]').val(data.details
                        .country_name);
                    $('.editCountry').find('input[name="capital_city"]').val(data.details
                        .capital_city);
                    $('.editCountry').modal('show');
                }, 'json');
            });

            //UPDATE COUNTRY DETAILS
            $('#update-country-form').on('submit', function(e) {
                e.preventDefault();
                var form = this;
                $.ajax({
                    url: $(form).attr('action'),
                    method: $(form).attr('method'),
                    data: new FormData(form),
                    processData: false,
                    dataType: 'json',
                    contentType: false,
                    beforeSend: function() {
                        $(form).find('span.text-danger').text('');
                    },
                    success: function(data) {
                        if (data.code == 400) {
                            $.each(data.error, function(prefix, val) {
                                $(form).find('span.' + prefix + '_error').text(val[0]);
                            });
                        } else {
                            $('#countries-table').DataTable().ajax.reload(null, false);
                            $('.editCountry').modal('hide');
                            $('.editCountry').find('form')[0].reset();
                            toastr.success(data.message);
                        }
                    }
                });
            });

            //DELETE COUNTRY RECORD
            $(document).on('click', '#deleteCountryBtn', function() {
                var country_id = $(this).data('id');
                var url = '<?= url('deleteCountry') ?>';
                swal.fire({
                    title: 'Are you sure?',
                    html: 'You want to <b>delete</b> this country',
                    showCancelButton: true,
                    showCloseButton: true,
                    cancelButtonText: 'Cancel',
                    confirmButtonText: 'Yes, Delete',
                    cancelButtonColor: '#d33',
                    confirmButtonColor: '#556ee6',
                    width: 300,
                    allowOutsideClick: false
                }).then(function(result) {
                    if (result.value) {
                        $.post(url, {
                            country_id: country_id
                        }, function(data) {
                            if (data.code == 200) {
                                $('#countries-table').DataTable().ajax.reload(null, false);
                                toastr.success(data.message);
                            } else {
                                toastr.error(data.message);
                            }
                        }, 'json');
                    }
                });
            });
        });
    </script>
</body>

</html>
