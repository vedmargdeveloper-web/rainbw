
let global_occasion_id = 0;
$(function(){
	let base_url_new = $('meta[name="base_url"]').attr('content');
	var load_url_occasion =base_url_new+'/admin/occasion';
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
	$('#copy-print-csv-occasion').DataTable( {
		dom: 'Bfrtip',
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
	               },title:''
             },
		], ajax:{url:load_url_occasion,dataSrc:""},
		 columns: [
   //          { data: null,
			// 	render: function (data, type, row, meta) {
			// 		return meta.row + 1;
			// 	}
			// },
            { data: 'occasion' },
       //       { data: 'created_at',render: function (data) {
			    //     var date = new Date(data);
			    //     var month = date.getMonth() + 1;
			    //     return (month.toString().length > 1 ? month : "0" + month) + "/" + date.getDate() + "/" + date.getFullYear()+' '+date.getHours()+':'+date.getMinutes();
			    // } },
            {
                data: null,
                render: function (response) {
                	console.log('hum');
                	return  `<i class="fa fa-edit edit-occasion"   data-id="${response.id}" />`;
                },
                orderable: false
            },
            {
                data: null,
                render: function (response) {
                	return  `<i class="fa fa-trash delete-occasion"   data-id="${response.id}" />`;
                },
                orderable: false
            }
        ],
		'iDisplayLength': 5,
	});



	$("#occasion-store-ajax").submit( function(event) {
		let url =  $(this).attr('action');
		let method =  $(this).attr('method');
		let _this =  $(this);
		//alert(method);
		event.preventDefault();
		// alert('xd');
		// return;
		let data =  $(this).serialize();

		$(".occasion_head").each(function (index, el) {
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
				  text: "occasion is added",
				  icon: "success",
				});
			$("#occasion-store-ajax")[0].reset();
			load_table();
			refresh_occasion();
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
			_show_errors_occasion(data,_this);
		})
		.always(function() {
			console.log("complete");
		});
	});

	$('body').on('click','.delete-occasion',function(){
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
			url: base_url_new+'/admin/occasion/'+id,
			type: 'DELETE',
			dataType: 'json',
		})
		.done(function() {
			load_table();
			swal({
				  title: "occasion Deleted!",
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



	$('body').on('click','.edit-occasion',function(){
		var id = $(this).attr('data-id');
		global_occasion_id = id;
		$.ajax({
			url: base_url_new+'/admin/occasion/'+id,
			type: 'GET',
			dataType: 'json',
		})
		.done(function(response) {
			console.log(response);
			_set_edit_value_occasion(response);
		})
		.fail(function(e) {
			console.log("error",e);
		})
		.always(function() {
			console.log("complete");
		});
		
	});

	$('body').on('click','.btn-update-occasion',function(e){
		e.preventDefault();
		let url = base_url_new+'/admin/occasion/'+global_occasion_id;
		
		var company_name  = 	$("#occasion-store-ajax input[name='company_name']").val();
		var head_office   = 	$("#occasion-store-ajax input[name='head_office']").val();
		var branch_office = 	$("#occasion-store-ajax input[name='branch_office']").val();

		var temp_address  = $("#occasion-store-ajax input[name='temp_address']").val();
		var occasionin  		  = $("#occasion-store-ajax input[name='occasionin']").val();
		var udyam_reg_no = $("#occasion-store-ajax input[name='udyam_reg_no']").val();
		var occasion 		= $("#occasion-store-ajax input[name='occasion']").val();	
		
		var occasion 		= $("#occasion-store-ajax input[name='occasion']").val();
		var issue_date = $("#occasion-store-ajax input[name='issue_date']").val();	
		
		var  expiry_date = $("#occasion-store-ajax input[name='expiry_date']").val();	
		var type = $("#occasion-store-ajax input[name='type']").val();	
		var mobile = $("#occasion-store-ajax input[name='mobile']").val();	
		var email = $("#occasion-store-ajax input[name='email']").val();	
		var pincode = $("#occasion-store-ajax input[name='pincode']").val();	
		var head = [];
		
		$(".occasion_head").each(function (index, el) {
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
			data: {company_name,head_office,branch_office,temp_address,head,occasionin,udyam_reg_no,occasion,occasion,issue_date,expiry_date,type,mobile,email},
		})
		.done(function(resp) {
			
			console.log(resp);
			swal({
				  title: "Good job!",
				  text: "occasion is updated",
				  icon: "success",
				});
			
			load_table();
			$('.add-more-occasion a').click();
			$("span.text-danger").remove();
			$("span.text-success").remove();
			//$("#occasion-store-ajax")[0].reset();
		})
		.fail(function(error) {
			console.log(error);
			swal({
				  title: "Something wrong!",
				  text: "Please check your field",
				  icon: "error",
				});
			let data =error.responseJSON.errors;
			_show_errors_occasion(data,_this);
		});


	});

	function load_table(){
      $('#copy-print-csv-occasion').DataTable().ajax.reload();
	}




});

$(".add-more-occasion a").click(function(e){
		e.preventDefault();
		$('.btn-add-occasion').removeClass('d-none');
		$('.btn-update-occasion').addClass('d-none');
		$("#occasion-store-ajax").removeClass('vibrate');
		$(".add-more-occasion").addClass('d-none');
		$("#occasion-store-ajax")[0].reset();
});
function _show_errors_occasion(data,_this){
		$("span.text-danger").remove();
		$("span.text-success").remove();
		if (data.occasion) {
           $('<span class="text-danger">' + data.occasion[0] + "</span>").insertAfter($('input[name="occasion"]', _this));
       }
      
       
}
function _set_edit_value_occasion(data){
		
		$("#occasion-store-ajax").removeClass('vibrate');
		$("#occasion-store-ajax input[name='occasion']").val(data.occasion);
		
		
		$('.btn-add-occasion').addClass('d-none');
		$('.btn-update-occasion').removeClass('d-none');
		$("#occasion-store-ajax").addClass('vibrate');
		$(".add-more-occasion").removeClass('d-none');
		
	
       
}


  var occasion_maxField = 10; //Input fields increment limitation
    var addButton_occasion = $(".add_button_occasion"); //Add button selector
    var wrapper_occasion = $(".field_wrapper_occasion"); //Input field wrapper_occasion
   var fieldHTML_occasion =  '<div class="col-xl-12 col-lg-12 occasion col-md-12 col-sm-12 col-12">'+
'															<div class="form-group">'+
'																<label for="inputEmail">Head : *</label>'+
'																<textarea class="form-control occasion_head" name="head[]"></textarea>'+
'															</div>'+
'															<span class=" remove_button_occasion btn btn-danger"> Remove </span>'+
'														</div>';

    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton_occasion).click(function () {
        //Check maximum number of input fields
        if (x < occasion_maxField) {
            x++; //Increment field counter
            $(wrapper_occasion).append(fieldHTML_occasion); //Add field html
        }
    });

    $(wrapper_occasion).on("click", ".remove_button_occasion", function (e) {
        e.preventDefault();
        $(this).closest('.occasion').remove()
        x--; //Decrement field counter
    });