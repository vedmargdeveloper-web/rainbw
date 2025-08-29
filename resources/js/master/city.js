
let global_city_id = 0;
$(function(){
	let base_url_new = $('meta[name="base_url"]').attr('content');
	var load_url_city =base_url_new+'/admin/city';
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
	$('#copy-print-csv-city').DataTable( {
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
		], ajax:{url:load_url_city,dataSrc:""},
		 columns: [
   //          { data: null,
			// 	render: function (data, type, row, meta) {
			// 		return meta.row + 1;
			// 	}
			// },
            { data: 'city' },
       //       { data: 'created_at',render: function (data) {
			    //     var date = new Date(data);
			    //     var month = date.getMonth() + 1;
			    //     return (month.toString().length > 1 ? month : "0" + month) + "/" + date.getDate() + "/" + date.getFullYear()+' '+date.getHours()+':'+date.getMinutes();
			    // } },
            {
                data: null,
                render: function (response) {
                	return  `<i class="fa fa-edit edit-city"   data-id="${response.id}" />`;
                },
                orderable: false
            },
            {
                data: null,
                render: function (response) {
                	return  `<i class="fa fa-trash delete-city"   data-id="${response.id}" />`;
                },
                orderable: false
            }
        ],
		'iDisplayLength': 5,
	});



	$("#city-store-ajax").submit( function(event) {
		let url =  $(this).attr('action');
		let method =  $(this).attr('method');
		let _this =  $(this);
		//alert(method);
		event.preventDefault();
		let data =  $(this).serialize();

		$(".city_head").each(function (index, el) {
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
				  text: "city is added",
				  icon: "success",
				});
			$("#city-store-ajax")[0].reset();
			load_table();
			refresh_city();
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
			_show_errors_city(data,_this);
		})
		.always(function() {
			console.log("complete");
		});
	});

	$('body').on('click','.delete-city',function(){
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
			url: base_url_new+'/admin/city/'+id,
			type: 'DELETE',
			dataType: 'json',
		})
		.done(function() {
			load_table();
			swal({
				  title: "city Deleted!",
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



	$('body').on('click','.edit-city',function(){
		var id = $(this).attr('data-id');
		global_city_id = id;
		$.ajax({
			url: base_url_new+'/admin/city/'+id,
			type: 'GET',
			dataType: 'json',
		})
		.done(function(response) {
			console.log(response);
			_set_edit_value_city(response);
		})
		.fail(function(e) {
			console.log("error",e);
		})
		.always(function() {
			console.log("complete");
		});
		
	});

	$('body').on('click','.btn-update-city',function(e){
		e.preventDefault();
		let url = '/admin/city/'+global_city_id;
		
		var company_name  = 	$("#city-store-ajax input[name='company_name']").val();
		var head_office   = 	$("#city-store-ajax input[name='head_office']").val();
		var branch_office = 	$("#city-store-ajax input[name='branch_office']").val();

		var temp_address  = $("#city-store-ajax input[name='temp_address']").val();
		var cityin  		  = $("#city-store-ajax input[name='cityin']").val();
		var udyam_reg_no = $("#city-store-ajax input[name='udyam_reg_no']").val();
		var city 		= $("#city-store-ajax input[name='city']").val();	
		
		var city 		= $("#city-store-ajax input[name='city']").val();
		var issue_date = $("#city-store-ajax input[name='issue_date']").val();	
		
		var  expiry_date = $("#city-store-ajax input[name='expiry_date']").val();	
		var type = $("#city-store-ajax input[name='type']").val();	
		var mobile = $("#city-store-ajax input[name='mobile']").val();	
		var email = $("#city-store-ajax input[name='email']").val();	
		var pincode = $("#city-store-ajax input[name='pincode']").val();	
		var head = [];
		
		$(".city_head").each(function (index, el) {
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
			url: base_url_new+url,
			type: method,
			dataType: 'json',
			data: {company_name,head_office,branch_office,temp_address,head,cityin,udyam_reg_no,city,city,issue_date,expiry_date,type,mobile,email},
		})
		.done(function(resp) {
			
			console.log(resp);
			swal({
				  title: "Good job!",
				  text: "city is updated",
				  icon: "success",
				});
			
			load_table();
			$('.add-more-city a').click();
			//$("#city-store-ajax")[0].reset();
		})
		.fail(function(error) {
			console.log(error);
			swal({
				  title: "Something wrong!",
				  text: "Please check your field",
				  icon: "error",
				});
			let data =error.responseJSON.errors;
			_show_errors_city(data,_this);
		});


	});

	function load_table(){
      $('#copy-print-csv-city').DataTable().ajax.reload();
	}




});

$(".add-more-city a").click(function(e){
		e.preventDefault();
		$('.btn-add-city').removeClass('d-none');
		$('.btn-update-city').addClass('d-none');
		$("#city-store-ajax").removeClass('vibrate');
		$(".add-more-city").addClass('d-none');
		$("#city-store-ajax")[0].reset();
});
function _show_errors_city(data,_this){
		$("span.text-danger").remove();
		$("span.text-success").remove();
		if (data.city) {
           $('<span class="text-danger">' + data.city[0] + "</span>").insertAfter($('input[name="city"]', _this));
       }
      
       
}
function _set_edit_value_city(data){
		
		$("#city-store-ajax").removeClass('vibrate');
		$("#city-store-ajax input[name='city']").val(data.city);
		
		
		$('.btn-add-city').addClass('d-none');
		$('.btn-update-city').removeClass('d-none');
		$("#city-store-ajax").addClass('vibrate');
		$(".add-more-city").removeClass('d-none');
		
	
       
}


  var city_maxField = 10; //Input fields increment limitation
    var addButton_city = $(".add_button_city"); //Add button selector
    var wrapper_city = $(".field_wrapper_city"); //Input field wrapper_city
   var fieldHTML_city =  '<div class="col-xl-12 col-lg-12 city col-md-12 col-sm-12 col-12">'+
'															<div class="form-group">'+
'																<label for="inputEmail">Head : *</label>'+
'																<textarea class="form-control city_head" name="head[]"></textarea>'+
'															</div>'+
'															<span class=" remove_button_city btn btn-danger"> Remove </span>'+
'														</div>';

    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton_city).click(function () {
        //Check maximum number of input fields
        if (x < city_maxField) {
            x++; //Increment field counter
            $(wrapper_city).append(fieldHTML_city); //Add field html
        }
    });

    $(wrapper_city).on("click", ".remove_button_city", function (e) {
        e.preventDefault();
        $(this).closest('.city').remove()
        x--; //Decrement field counter
    });