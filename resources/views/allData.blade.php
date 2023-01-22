<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('resource/bootstrap/css/bootstrap.min.css') }}">
</head>

<body class="antialiased">

    <div class="container">
        <div class="col-md-12 mt-5">
            <div class="card my-5">
                <h2 class="card-title text-center text-decoration-underline">Jquery CRUD with DataTable server side
                    Processing</h2>
                <div class="col-md-12 p-4">
                    <div class="text-end">
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-sm btn-primary mb-3" data-bs-toggle="modal"
                            data-bs-target="#exampleModal">
                            Add New
                        </button>
                    </div>

                    <table class="table table-hover" id="users-table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">First</th>
                                <th scope="col">Last</th>
                                <th scope="col">Pic</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="validation_error">

                    </ul>
                    <form id="insert" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6">
                            <label for="validationCustom01" class="form-label">First name</label>
                            <input type="text" class="form-control" name="first" id="validationCustom01" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom02" class="form-label">Last name</label>
                            <input type="text" class="form-control" name="last" id="validationCustom02" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="validationCustom05" class="form-label">Image</label>
                            <input type="file" class="form-control" name="image" id="validationCustom05" required>

                        </div>
                        <div class="col-12 modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary"
                                data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary insert">Save</button>
                        </div>

                    </form>
                </div>

            </div>
        </div>
    </div>


     <!-- Edit Modal -->
     <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="update_validation_error">

                    </ul>
                    <form id="update" class="row g-3 needs-validation" novalidate enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6">
                            <label for="validationCustom01" class="form-label">First name</label>
                            <input type="text" class="form-control" name="first" id="first" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="validationCustom02" class="form-label">Last name</label>
                            <input type="text" class="form-control" name="last" id="last" required>
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="validationCustom05" class="form-label">Image</label>
                            <input type="file" class="form-control" name="image" required>
                        </div>
                        <span class="col-md-12" id="previous_image">
                            
                        </span>
                        <input type="hidden" name="id" id="id">
                        <div class="col-12 modal-footer">
                            <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-sm btn-primary update">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <script src="{{ asset('resource/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('resource/jquery.js') }}"></script>

    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-html5-2.3.3/b-print-2.3.3/datatables.min.css" />

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs5/jszip-2.5.0/dt-1.13.1/b-2.3.3/b-html5-2.3.3/b-print-2.3.3/datatables.min.js">
    </script>

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    {{--   
        // if there is resource controller and named route 
        // var id =$(this).val();
        // var url = "{{ route('availableRooms', ":id") }}";
        // url = url.replace(':id', id); 
    --}}

    <script>
        $(document).ready(function() {

            $('#users-table').DataTable({
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'print',
                        text: 'Print',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'PDF',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        text: 'XML',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'copy',
                        text: 'Copy',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        text: 'CSV',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'excel',
                        text: 'Excel',
                        exportOptions: {
                            columns: ':visible'
                        }
                    }

                ],
                processing: true,
                serverSide: true,
                ajax: '{{ route('users.data') }}',
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'first',
                        name: 'first'
                    },
                    {
                        data: 'last',
                        name: 'last'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return '<img src="{{ asset('images') }}' + '/' + data +
                                '" width="80" height="80">';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ]
            });

            // insert data
            $(document).on('submit', '#insert', function(e) {
                e.preventDefault();
                // console.log('ok');
                $('.insert').html('<span class="spinner-border spinner-border-sm"></span>')
                $.ajax({
                    type: "post",
                    url: "{{ route('store.data') }}",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 200) {
                            // console.log(response); 
                            $('.modal').modal('hide')
                            $('#users-table').DataTable().ajax.reload(); // refresh data table
                            $('#insert')[0].reset();
                            $('.insert').text('Save')
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal
                                        .stopTimer)
                                    toast.addEventListener('mouseleave', Swal
                                        .resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            })
                        } else {
                            $('#validation_error').html("");
                            $('#validation_error').addClass('alert alert-danger ps-4');
                            $.each(response.error, function(key, err_value) {
                                $('#validation_error').append('<li>' + err_value +
                                    '</li>');
                            });
                        }

                    },
                    error: function(response) {
                        console.error();

                    }
                });

            })

            
            $(document).on('click', '.deleteButton', function(e) {
                // alert('ok')
                var id = $(this).attr('data-id');
                 
                // alert(id);
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-success',
                        cancelButton: 'btn btn-danger me-3'
                    },
                    buttonsStyling: false
                })

                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'No, cancel!',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        var url = "{{ route('delete.data', ":id") }}";
                        url = url.replace(':id', id);
                        $.ajax({
                            type: "get",
                            url:url,
                            success: function(response) {
                                if (response.status == 200) {
                                    $('#users-table').DataTable().ajax
                                        .reload(); // refresh data table
                                    swalWithBootstrapButtons.fire(
                                        'Deleted!',
                                        'Your file has been deleted.',
                                        'success'
                                    )
                                } else {
                                    alert('Something went wrong')
                                }

                            }
                        });
                    } else if (
                        /* Read more about handling dismissals below */
                        result.dismiss === Swal.DismissReason.cancel
                    ) {
                        swalWithBootstrapButtons.fire(
                            'Cancelled',
                            'Your file is safe :)',
                            'error'
                        )
                    }
                })
            })


            $(document).on('click','.editButton',function (e) {
                e.preventDefault();
                var id = $(this).attr('href');
                // alert(id)
                var url = "{{ route('edit.data', ":id") }}";
                url = url.replace(':id', id);
                $.ajax({
                    type: "get",
                    url: url,
                    success: function (response) {
                        console.log(response);
                        $('#first').val(response.first)
                        $('#last').val(response.last)
                        $('#id').val(response.id)
                        $('#previous_image').html('<img style="width: 100px; height: 90px;" src="{{ asset('images') }}/'+response.image+'" alt="">')
                    }
                });
            });

            $(document).on('submit','#update',function (e) {
                e.preventDefault();
                // alert('ok')
                $('.update').html('<span class="spinner-border spinner-border-sm"></span>')
                var id = $('#id').val();
                // alert(id)
                var url = "{{ route('update.data' , ":id") }}"
                url = url.replace(':id',id);
                $.ajax({
                    type: "post",
                    url: url,
                    data: new FormData(this),
                    cache:false,
                    contentType:false,
                    processData:false,
                    success: function (response) {
                        // console.log(response);
                        if (response.status == 200) {
                            // console.log(response); 
                            $('.modal').modal('hide')
                            $('#users-table').DataTable().ajax.reload(); // refresh data table
                            $('#update')[0].reset();
                            $('.update').text('Update')
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true,
                                didOpen: (toast) => {
                                    toast.addEventListener('mouseenter', Swal
                                        .stopTimer)
                                    toast.addEventListener('mouseleave', Swal
                                        .resumeTimer)
                                }
                            })

                            Toast.fire({
                                icon: 'warning',
                                title: response.message
                            })
                        } else {
                            $('#update_validation_error').html("");
                            $('#update_validation_error').addClass('alert alert-danger ps-4');
                            $.each(response.error, function(key, err_value) {
                                $('#update_validation_error').append('<li>' + err_value +
                                    '</li>');
                            });
                            $('.update').text('Update')
                        }

                    }
                });

            });
        });
    </script>
</body>

</html>
