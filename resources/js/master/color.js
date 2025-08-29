
let global_color_id = 0;
$(function(){
	let base_url_new = $('meta[name="base_url"]').attr('content');
	var load_url_color =base_url_new+'/admin/color';
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
	$('#copy-print-csv-color').DataTable( {
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
		], ajax:{url:load_url_color,dataSrc:""},
		 columns: [
   //          { data: null,
			// 	render: function (data, type, row, meta) {
			// 		return meta.row + 1;
			// 	}
			// },
            { data: 'color' },
       //       { data: 'created_at',render: function (data) {
			    //     var date = new Date(data);
			    //     var month = date.getMonth() + 1;
			    //     return (month.toString().length > 1 ? month : "0" + month) + "/" + date.getDate() + "/" + date.getFullYear()+' '+date.getHours()+':'+date.getMinutes();
			    // } },
            {
                data: null,
                render: function (response) {
                	return  `<i class="fa fa-edit edit-color"   data-id="${response.id}" />`;
                },
                orderable: false
            }
        ],
		'iDisplayLength': 5,
	});



	$("#color-store-ajax").submit( function(event) {
		let url =  $(this).attr('action');
		let method =  $(this).attr('method');
		let _this =  $(this);
		//alert(method);
		event.preventDefault();
		let data =  $(this).serialize();

		$(".color_head").each(function (index, el) {
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
				  text: "color is added",
				  icon: "success",
				});
			$("#color-store-ajax")[0].reset();
			load_table();
			//refresh_color();
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
			_show_errors_color(data,_this);
		})
		.always(function() {
			console.log("complete");
		});
	});

	$('body').on('click','.delete-color',function(){
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
			url: base_url_new+'/admin/color/'+id,
			type: 'DELETE',
			dataType: 'json',
		})
		.done(function() {
			load_table();
			swal({
				  title: "color Deleted!",
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



	$('body').on('click','.edit-color',function(){
		var id = $(this).attr('data-id');
		global_color_id = id;
		$.ajax({
			url: base_url_new+'/admin/color/'+id,
			type: 'GET',
			dataType: 'json',
		})
		.done(function(response) {
			console.log(response);
			_set_edit_value_colors(response);
		})
		.fail(function(e) {
			console.log("error",e);
		})
		.always(function() {
			console.log("complete");
		});
		
	});

	$('body').on('click','.btn-update-color',function(e){
		e.preventDefault();
		let url = base_url_new+'/admin/color/'+global_color_id;
		
		// var company_name  = 	$("#color-store-ajax input[name='company_name']").val();
		// var head_office   = 	$("#color-store-ajax input[name='head_office']").val();
		// var branch_office = 	$("#color-store-ajax input[name='branch_office']").val();

		// var temp_address  = $("#color-store-ajax input[name='temp_address']").val();
		// var colorin  		  = $("#color-store-ajax input[name='colorin']").val();
		// var udyam_reg_no = $("#color-store-ajax input[name='udyam_reg_no']").val();
		// var color 		= $("#color-store-ajax input[name='color']").val();	
		
		var color 		= $("#color-store-ajax input[name='color']").val();
		// var issue_date = $("#color-store-ajax input[name='issue_date']").val();	
		
		// var  expiry_date = $("#color-store-ajax input[name='expiry_date']").val();	
		// var type = $("#color-store-ajax input[name='type']").val();	
		// var mobile = $("#color-store-ajax input[name='mobile']").val();	
		// var email = $("#color-store-ajax input[name='email']").val();	
		// var pincode = $("#color-store-ajax input[name='pincode']").val();	
		// var head = [];
		
		$(".color_head").each(function (index, el) {
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
			data: {color},
		})
		.done(function(resp) {
			
			console.log(resp);
			swal({
				  title: "Good job!",
				  text: "color is updated",
				  icon: "success",
				});
			
			load_table();
			$('.add-more-color a').click();
			//$("#color-store-ajax")[0].reset();
		})
		.fail(function(error) {
			console.log(error);
			swal({
				  title: "Something wrong!",
				  text: "Please check your field",
				  icon: "error",
				});
			let data =error.responseJSON.errors;
			_show_errors_color(data,_this);
		});


	});

	function load_table(){
      $('#copy-print-csv-color').DataTable().ajax.reload();
	}




});

$(".add-more-color a").click(function(e){
		e.preventDefault();
		$('.btn-add-color').removeClass('d-none');
		$('.btn-update-color').addClass('d-none');
		$("#color-store-ajax").removeClass('vibrate');
		$(".add-more-color").addClass('d-none');
		$("#color-store-ajax")[0].reset();
});
function _show_errors_color(data,_this){
		$("span.text-danger").remove();
		$("span.text-success").remove();
		if (data.color) {
           $('<span class="text-danger">' + data.color[0] + "</span>").insertAfter($('input[name="color"]', _this));
       }
      
       
}
function _set_edit_value_colors(data){
		
		$("#color-store-ajax").removeClass('vibrate');
		$("#color-store-ajax input[name='color']").val(data.color);
		
		
		$('.btn-add-color').addClass('d-none');
		$('.btn-update-color').removeClass('d-none');
		$("#color-store-ajax").addClass('vibrate');
		$(".add-more-color").removeClass('d-none');
		
	
       
}


  var color_maxField = 10; //Input fields increment limitation
    var addButton_color = $(".add_button_color"); //Add button selector
    var wrapper_color = $(".field_wrapper_color"); //Input field wrapper_color
   var fieldHTML_color =  '<div class="col-xl-12 col-lg-12 color col-md-12 col-sm-12 col-12">'+
'															<div class="form-group">'+
'																<label for="inputEmail">Head : *</label>'+
'																<textarea class="form-control color_head" name="head[]"></textarea>'+
'															</div>'+
'															<span class=" remove_button_color btn btn-danger"> Remove </span>'+
'														</div>';

    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton_color).click(function () {
        //Check maximum number of input fields
        if (x < color_maxField) {
            x++; //Increment field counter
            $(wrapper_color).append(fieldHTML_color); //Add field html
        }
    });

    $(wrapper_color).on("click", ".remove_button_color", function (e) {
        e.preventDefault();
        $(this).closest('.color').remove()
        x--; //Decrement field counter
    });