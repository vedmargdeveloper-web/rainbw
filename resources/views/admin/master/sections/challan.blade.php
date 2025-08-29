    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base_url" content="{{ url('/') }}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
	<div class="main-container">
				<div class="content-wrapper">
					<div class="row gutters">

						<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
							<center><h4 id="">Challan Type</h4></center>
							<div class="card">
									<div class="card-body">
										<div class="row">

											<div class="col-md-4">
                                            <form action="{{ route('challan-type.store') }}" id="challan-type-store-ajax" method="post">
                                                @csrf
                                                <div class="form-group">
                                                    <label>Challan Type *</label>
                                                    <input type="text" name="type_name" class="form-control" placeholder="Challan Type">
                                                </div>
                                                <button type="submit" class="btn btn-primary btn-add-challan-type mb-2">Add Challan Type</button>
                                                <button type="button" class="btn btn-primary d-none btn-update-challan-type mb-2">Update Challan</button>
                                            </form>
                                        </div>
                                         <div class="col-md-8">
                                         <div class="table-container">
											<div class="table-responsive">
                                            <table class="table custom-table" >
                                               
                                                <thead>
                                                    <tr>
                                                        <th>Challan Type</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="challan-type-table-body">
                                                    @foreach ($challanTypes as $challan)
                                                        <tr data-id="{{ $challan->id }}">
                                                            <td class="challan-name">{{ $challan->type_name }}</td>
                                                            <td>
                                                                <a href="javascript:void(0);" class="edit-challan-type btn btn-sm btn-light"
                                                                    data-id="{{ $challan->id }}" data-name="{{ $challan->type_name }}">
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                <button type="button" class="delete-challan-type btn btn-sm btn-light"
                                                                    data-id="{{ $challan->id }}">
                                                                    <i class="fa fa-trash"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                             </div>
                                           </div>
                                        </div>

                                    </div>
                                </div>
							</div>
						</div>
					</div>
				</div>
			</div>
            <script>
            $(function () {
                let base_url_new = $('meta[name="base_url"]').attr('content');
                let global_color_id = null;

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $('body').on('click', '.btn-add-challan-typee', function (e) {
                    e.preventDefault();

                    const type_name = $("#challan-type-store-ajax input[name='type_name']").val();

                    if (!type_name) {
                        swal("Validation Error", "Challan Type is required.", "error");
                        return;
                    }

                    $.ajax({
                        url: `${base_url_new}/admin/challan-type/store`,
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            type_name: type_name
                        },
                        success: function () {
                            swal("Success", "Challan Type added successfully.", "success").then(() => {
                                location.reload(); // Reload after success message
                            });
                        },
                        error: function () {
                            swal("Error", "Addition failed.", "error");
                        }
                    });
                });


                // DELETE
               $('body').on('click', '.delete-challan-type', function () {
                    const id = $(this).data('id');
                    swal({
                        title: "Are you sure?",
                        text: "Once deleted, you will not be able to recover this Challan Type!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            $.ajax({
                                url: `${base_url_new}/admin/challan-type/delete/${id}`,
                                type: 'DELETE',
                                success: function () {
                                    swal("Deleted!", "Challan Type has been deleted.", "success").then(() => {
                                        location.reload(); 
                                    });
                                },
                                error: function () {
                                    swal("Error", "Something went wrong!", "error");
                                }
                            });
                        }
                    });
                });

                // EDIT
                $('body').on('click', '.edit-challan-type', function () {
                    const id = $(this).data('id');
                    global_color_id = id;
                    $.ajax({
                        url: `${base_url_new}/admin/challan-type/edit/${id}`,
                        type: 'GET',
                        dataType: 'json',
                        success: function (response) {
                            $("#challan-type-store-ajax input[name='type_name']").val(response.data.type_name);
                            $('.btn-update-challan-type').removeClass('d-none');
                            $('.btn-add-challan-type').addClass('d-none');
                        },
                        error: function () {
                            swal("Error", "Unable to fetch Challan Type.", "error");
                        }
                    });
                });

                $('body').on('click', '.btn-update-challan-type', function (e) {
                    e.preventDefault();

                    const type_name = $("#challan-type-store-ajax input[name='type_name']").val();

                    if (!type_name) {
                        swal("Validation Error", "Challan Type is required.", "error");
                        return;
                    }

                    $.ajax({
                        url: `${base_url_new}/admin/challan-type/update/${global_color_id}`,
                        type: 'POST',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            _method: 'PATCH',
                            type_name: type_name
                        },
                        success: function () {
                            swal("Success", "Challan Type updated successfully.", "success").then(() => {
                                location.reload(); 
                            });
                        },
                        error: function () {
                            swal("Error", "Update failed.", "error");
                        }
                    });
                });


                function load_table() {
                    $.get(`${base_url_new}/admin/challan-type/list`, function (data) {
                        $('#challan-type-table-body').html(data); // This assumes you're returning a rendered `<tr>` list from your controller/view
                    });
                }
            });
</script>
