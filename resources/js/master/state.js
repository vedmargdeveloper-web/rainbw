
let global_state_id = 0;
$(function(){
	let base_url_new = $('meta[name="base_url"]').attr('content');
	var load_url_state =base_url_new+'/admin/state';
	
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});

	//$('#copy-print-csv-state').append('<caption style="caption-side: bottom">State\'</caption>');

	$('#copy-print-csv-state').DataTable( {
		dom: 'Bfrtip',
		// pageLength: 50,
		scrollY: '160px',
        scrollCollapse: true,
        paging: false,
		buttons: [
			'excelHtml5',
			'csvHtml5',{
				extend:'pdf',
				 title: ''
			},
			{
	           extend: 'print',
	           exportOptions: {
	           columns: [ 0, 1] //Your Column value those you want
	               },
	               title:''
             },
		], ajax:{url:load_url_state,dataSrc:""},
		 columns: [
         //    { data: null,
			      //  render: function (data, type, row, meta) {
			      //       return meta.row + 1;
			      //  }
        	// },
            { data: 'state' },
       //      { data: 'created_at',render: function (data) {
			    //     var date = new Date(data);
			    //     var month = date.getMonth() + 1;
			    //     return (month.toString().length > 1 ? month : "0" + month) + "/" + date.getDate() + "/" + date.getFullYear()+' '+date.getHours()+':'+date.getMinutes();
			    // } },
            {
                data: null,
                render: function (response) {
                	return  `<i class="fa fa-edit edit-state"   data-id="${response.id}" />`;
                },
                orderable: false
            },
            {
                data: null,
                render: function (response) {
                	return  `<i class="fa fa-trash delete-state"   data-id="${response.id}" />`;
                },
                orderable: false
            }
        ],
		'iDisplayLength': 5,
	});


	$("#state-store-ajax").submit( function(event) {
		let url =  $(this).attr('action');
		let method =  $(this).attr('method');
		let _this =  $(this);
		//alert(method);
		event.preventDefault();
		let data =  $(this).serialize();

		$(".state_head").each(function (index, el) {
            if ($(this).val() == "") {
                swal({
                    title: "Something Wrong !",
                    text: "Head  is required",
                    icon: "error",
                });
                return false;
            }
        });

		$.ajax({
			url: url,
			type: method,
			dataType: 'json',
			data: data,
		})
		.done(function() {
			
			swal({
				  title: "Good job!",
				  text: "state is added",
				  icon: "success",
				});
			$("#state-store-ajax")[0].reset();
			load_table();
			refresh_state();
			$("span.text-danger").remove();
			$("span.text-success").remove();
		})
		.fail(function(error) {
			console.log(error);
			swal({
				  title: "Something wrong!",
				  text: "Please check your field",
				  icon: "error",
				});
			let data =error.responseJSON.errors;
			_show_errors_state(data,_this);
		})
		.always(function() {
			console.log("complete");
		});
	});

	$('body').on('click','.delete-state',function(){
		var id = $(this).attr('data-id');
		 swal({
             title: "Are you sure?",
             text: "Once deleted, you will not be able to recover this imaginary file!",
             icon: "warning",
             buttons: true,
             dangerMode: true,
           })
          .then((willDelete) => {
               if (willDelete) {
                    	$.ajax({
			url: base_url_new+'/admin/state/'+id,
			type: 'DELETE',
			dataType: 'json',
		})
		.done(function() {
			load_table();
			swal({
				  title: "state Deleted!",
				  text: "",
				  icon: "success",
				});
		})
		.fail(function(e) {
			alert('something wrong');
		});
		
               } else {
                    return true;
           }
        });
		// if(!confirm('Are you sure want to delete this?')){
		// 	return false;
		// }
		
	});



	$('body').on('click','.edit-state',function(){
		var id = $(this).attr('data-id');
		global_state_id = id;
		$.ajax({
			url: base_url_new+'/admin/state/'+id,
			type: 'GET',
			dataType: 'json',
		})
		.done(function(response) {
			console.log(response);
			_set_edit_value_state(response);
		})
		.fail(function(e) {
			console.log("error",e);
		})
		.always(function() {
			console.log("complete");
		});
		
	});

	$('body').on('click','.btn-update-state',function(e){
		e.preventDefault();
		let url = base_url_new+'/admin/state/'+global_state_id;
		
		var company_name  = 	$("#state-store-ajax input[name='company_name']").val();
		var head_office   = 	$("#state-store-ajax input[name='head_office']").val();
		var branch_office = 	$("#state-store-ajax input[name='branch_office']").val();

		var temp_address  = $("#state-store-ajax input[name='temp_address']").val();
		var statein  		  = $("#state-store-ajax input[name='statein']").val();
		var udyam_reg_no = $("#state-store-ajax input[name='udyam_reg_no']").val();
		var state 		= $("#state-store-ajax input[name='state']").val();	
		
		var city 		= $("#state-store-ajax input[name='city']").val();
		var issue_date = $("#state-store-ajax input[name='issue_date']").val();	
		
		var  expiry_date = $("#state-store-ajax input[name='expiry_date']").val();	
		var type = $("#state-store-ajax input[name='type']").val();	
		var mobile = $("#state-store-ajax input[name='mobile']").val();	
		var email = $("#state-store-ajax input[name='email']").val();	
		var pincode = $("#state-store-ajax input[name='pincode']").val();	
		var head = [];
		
		$(".state_head").each(function (index, el) {
            if ($(this).val() == "") {
                swal({
                    title: "Something Wrong !",
                    text: "Head  is required",
                    icon: "error",
                });
                return false;
            }
            head[index] =  $(this).val();
        });

        // console.log(head);
        // return false;


		let method =  'PATCH';
		let _this =  $(this);
		//alert(method);
		event.preventDefault();
		let data =  $(this).serialize();
		$.ajax({
			url: url,
			type: method,
			dataType: 'json',
			data: {company_name,head_office,branch_office,temp_address,head,statein,udyam_reg_no,state,city,issue_date,expiry_date,type,mobile,email},
		})
		.done(function(resp) {
			
			console.log(resp);
			swal({
				  title: "Good job!",
				  text: "state is updated",
				  icon: "success",
				});
			
			load_table();
			reset_after_update();
			//$("#state-store-ajax")[0].reset();
		})
		.fail(function(error) {
			console.log(error);
			swal({
				  title: "Something wrong!",
				  text: "Please check your field",
				  icon: "error",
				});
			let data =error.responseJSON.errors;
			_show_errors_state(data,_this);
		});


	});

	function load_table(){
      $('#copy-print-csv-state').DataTable().ajax.reload();
	}
	function reset_after_update(){
		$('.add-more-state a').click();
	}




});




$(".add-more-state a").click(function(e){
		e.preventDefault();
		$('.btn-add-state').removeClass('d-none');
		$('.btn-update-state').addClass('d-none');
		$("#state-store-ajax").removeClass('vibrate');
		$(".add-more-state").addClass('d-none');
		$("#state-store-ajax")[0].reset();
});
function _show_errors_state(data,_this){
		$("span.text-danger").remove();
		$("span.text-success").remove();
		if (data.state) {
           $('<span class="text-danger">' + data.state[0] + "</span>").insertAfter($('input[name="state"]', _this));
       }
      
       
}
function _set_edit_value_state(data){
		
		$("#state-store-ajax").removeClass('vibrate');
		$("#state-store-ajax input[name='state']").val(data.state);
		
		
		$('.btn-add-state').addClass('d-none');
		$('.btn-update-state').removeClass('d-none');
		$("#state-store-ajax").addClass('vibrate');
		$(".add-more-state").removeClass('d-none');
		
	
       
}


  var state_maxField = 10; //Input fields increment limitation
    var addButton_state = $(".add_button_state"); //Add button selector
    var wrapper_state = $(".field_wrapper_state"); //Input field wrapper_state
   var fieldHTML_state =  '<div class="col-xl-12 col-lg-12 state col-md-12 col-sm-12 col-12">'+
'															<div class="form-group">'+
'																<label for="inputEmail">Head : *</label>'+
'																<textarea class="form-control state_head" name="head[]"></textarea>'+
'															</div>'+
'															<span class=" remove_button_state btn btn-danger"> Remove </span>'+
'														</div>';

    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton_state).click(function () {
        //Check maximum number of input fields
        if (x < state_maxField) {
            x++; //Increment field counter
            $(wrapper_state).append(fieldHTML_state); //Add field html
        }
    });

    $(wrapper_state).on("click", ".remove_button_state", function (e) {
        e.preventDefault();
        $(this).closest('.state').remove()
        x--; //Decrement field counter
    });



