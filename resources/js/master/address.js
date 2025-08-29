
let global_address_id = 0;
$(function(){
	
	let base_url_new = $('meta[name="base_url"]').attr('content');
	var load_url_address =base_url_new+'/admin/address';

	//var load_url ='https://logodost.com/admin/address';

	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
	$('#copy-print-csv-address').DataTable( {
		dom: 'Bfrtip',
		pageLength: 50,
		scrollY: '400px',
        scrollCollapse: true,
        paging: false,
		buttons: [
			'copyHtml5',
			'excelHtml5',
			'csvHtml5',
			'pdfHtml5',
			'print',
		], ajax: load_url_address,
		 columns: [
            { data: 'venue' },
            { data: 'address' },
            { data: 'type' },
            { data: null,render:function(res){
                return res.city == null ? '' : res.city.city;
            } },
            { data: null,render:function(res){
                return res.state == null ? '' : res.state.state;
            } },
            { data: 'pincode' },
            { data: 'landmark' },
            { data: 'contact_person_name' },
            { data: 'mobile' },
            {
                data: null,
                render: function (response) {
                	return  `<i class="fa fa-edit edit-address"   data-id="${response.id}" />`;
                },
                orderable: false
            },
            {
                data: null,
                render: function (response) {
                	return  `<i class="fa fa-trash delete-address"   data-id="${response.id}" />`;
                },
                orderable: false
            }
        ],

		'iDisplayLength': 5,
	});


	$("#address-store-ajax").submit( function(event) {
		let url =  $(this).attr('action');
		let method =  $(this).attr('method');
		let _this =  $(this);
		//alert(method);
		event.preventDefault();
		let data =  $(this).serialize();


		$.ajax({
			url: url,
			type: method,
			dataType: 'json',
			data: data,
		})
		.done(function() {
			
			swal({
				  title: "Good job!",
				  text: "Address is added",
				  icon: "success",
				});
			$("#address-store-ajax")[0].reset();
			load_table();
		})
		.fail(function(error) {
			swal({
				  title: "Something wrong!",
				  text: "Please check your field",
				  icon: "error",
				});
			let data =error.responseJSON.errors;
			_show_errors_addresss(data,_this);
		})
		.always(function() {
		});
	});

	$('body').on('click','.delete-address',function(){
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
			url: base_url_new+'/admin/address/'+id,
			type: 'DELETE',
			dataType: 'json',
		})
		.done(function() {
			load_table();
			swal({
				  title: "address Deleted!",
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



	$('body').on('click','.edit-address',function(){
		var id = $(this).attr('data-id');
		global_address_id = id;
		$.ajax({
			url: base_url_new+'/admin/address/'+id,
			type: 'GET',
			dataType: 'json',
		})
		.done(function(response) {
			_set_edit_value_addresss(response);
		})
		.fail(function(e) {
		})
		.always(function() {
		});
		
	});


	$("#address-type").change(function(){
			let  type = $(this).val();
			if(type == 'supply'){
					hide_supply_filed();
			}else{
					show_supply_filed();
			}
			//alert(type);
	});



	$('body').on('click','.btn-update-address',function(e){
		e.preventDefault();
		let url = base_url_new+'/admin/address/'+global_address_id;
		
		var company_name  = 	$("#address-store-ajax input[name='company_name']").val();
		var head_office   = 	$("#address-store-ajax input[name='head_office']").val();
		var branch_office = 	$("#address-store-ajax input[name='branch_office']").val();

		var address  = $("#address-store-ajax input[name='address']").val();
		var address1  = $("#address-store-ajax input[name='address1']").val();
		var gstin  		  = $("#address-store-ajax input[name='gstin']").val();
		var udyam_reg_no = $("#address-store-ajax input[name='udyam_reg_no']").val();
		var state 		= $("#address-store-ajax select[name='state']").val();	
		
		var city 		= $("#address-store-ajax select[name='city']").val();
		var issue_date = $("#address-store-ajax select[name='issue_date']").val();	
		
		var  venue = $("#address-store-ajax input[name='venue']").val();	
		var type = $("#address-store-ajax input[name='type']").val();	
		var mobile = $("#address-store-ajax input[name='mobile']").val();	
		var email = $("#address-store-ajax input[name='email']").val();	
		var pincode = $("#address-store-ajax input[name='pincode']").val();	
		var type = $("#address-store-ajax select[name='type']").val();	



		var head = [];
		
		// $(".gst_head").each(function (index, el) {
  //           if ($(this).val() == "") {
  //               swal({
  //                   title: "Something Wrong !",
  //                   text: "Head  is required",
  //                   icon: "error",
  //               });
  //               return false;
  //           }
  //           head[index] =  $(this).val();
  //       });

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
			data: {type,pincode,company_name,head_office,address1,branch_office,address,head,gstin,udyam_reg_no,state,city,issue_date,venue,type,mobile,email},
		})
		.done(function(resp) {
			swal({
				  title: "Good job!",
				  text: "Address is updated",
				  icon: "success",
				});
			
			load_table();

			//$("#address-store-ajax")[0].reset();
		})
		.fail(function(error) {
			swal({
				  title: "Something wrong!",
				  text: "Please check your field",
				  icon: "error",
				});
			let data =error.responseJSON.errors;
			_show_errors_addresss(data,_this);
		});


	});

	function load_table(){
		$("span.text-danger").remove();
		$("span.text-success").remove();
      $('#copy-print-csv-address').DataTable().ajax.reload();
	}
});

$(".add-more-address a").click(function(e){
	e.preventDefault();
	$('.btn-add-address').removeClass('d-none');
	$('.btn-update-address').addClass('d-none');
	$("#address-store-ajax").removeClass('vibrate');
	$(".add-more-address").addClass('d-none');
	$("#address-store-ajax")[0].reset();
});
function _show_errors_addresss(data,_this) {
	$("span.text-danger").remove();
	$("span.text-success").remove();
	if (data.address) {
		//alert('xd');
       $('<span class="text-danger">' + data.address[0] + "</span>").insertAfter($('input[name="address"]', _this));
   }
   if (data.city) {
       $('<span class="text-danger">' + data.city[0] + "</span>").insertAfter($('select[name="city"]', _this));
   }
   if (data.contact_person_name) {
       $('<span class="text-danger">' + data.contact_person_name[0] + "</span>").insertAfter($('input[name="contact_person_name"]', _this));
   }
   if (data.email) {
       $('<span class="text-danger">' + data.email[0]+ "</span>").insertAfter($('input[name="email"]', _this));
   }
   if (data.landmark) {
       $('<span class="text-danger">' + data.landmark[0]+ "</span>").insertAfter($('input[name="landmark"]', _this));
   }
   if (data.mobile) {
       $('<span class="text-danger">' + data.mobile[0] + "</span>").insertAfter($('input[name="mobile"]', _this));
   }
   if (data.pincode) {
       $('<span class="text-danger">' + data.pincode[0] + "</span>").insertAfter($('input[name="pincode"]', _this));
   }
   if (data.state) {
       $('<span class="text-danger">' + data.state[0] + "</span>").insertAfter($('select[name="state"]', _this));
   }
   if (data.type) {
       $('<span class="text-danger">' + data.type[0] + "</span>").insertAfter($('input[name="type"]', _this));
   }
   if (data.venue) {
       $('<span class="text-danger">' + data.venue[0] + "</span>").insertAfter($('input[name="venue"]', _this));
   }
}

function hide_supply_filed(){
				$('.venue').hide();
				$('.landmark').hide();
				$('.contact-person').hide();
				$('.mobile').hide();
				$('.tag-pincode').hide();
}
function show_supply_filed(){
				$('.venue').show();
				$('.landmark').show();
				$('.contact-person').show();
				$('.mobile').show();
				$('.tag-pincode').show();
}

function _set_edit_value_addresss(data){
			if(data.type == "supply"){
				hide_supply_filed();
			}else{
				show_supply_filed();
			}
		$("#address-store-ajax").removeClass('vibrate');
		$("#address-store-ajax input[name='address']").val(data.address);
		$("#address-store-ajax input[name='address1']").val(data.address1);
	//	$("#address-store-ajax input[name='city']").val(data.city);
		$("#address-store-ajax input[name='contact_person_name']").val(data.contact_person_name);
		$("#address-store-ajax input[name='email']").val(data.email);
		$("#address-store-ajax input[name='landmark']").val(data.landmark);
		$("#address-store-ajax input[name='mobile']").val(data.mobile);
		$("#address-store-ajax input[name='pincode']").val(data.pincode);	
		//$("#address-store-ajax input[name='state']").val(data.state);	
		//$("#address-store-ajax input[name='type']").val(data.type);	
		$("#address-store-ajax input[name='venue']").val(data.venue);	
		
		$('select[name="city"]').val('');
	    $('select[name="state"]').val('');

	    $('select[name="city"]').val(data.city);
	    $('select[name="state"]').val(data.state);
		// $('select[name="city"]').find('option[value="'+data.city+'"]').attr("selected",true);
  //   	$('select[name="state"]').find('option[value="'+data.state+'"]').attr("selected",true);
    	//$('select[name="type"]').find('option[value="'+data.type+'"]').attr("selected",true);

		$('#address-type').find('option[value="'+data.type+'"]').attr("selected",true);
		
// 		let wrapper = $(".field_wrapper_addresss");
// 		let head = JSON.parse(data.head);

//     	$(wrapper).html('');
// 		 $.each(head, function(index, val) {
//     	    var fieldHTML_addresss =  '<div class="col-xl-12 col-lg-12 address col-md-12 col-sm-12 col-12">'+
// '															<div class="form-group">'+
// '																<label for="inputEmail">Head : *</label>'+
// '																<textarea class="form-control gst_head"  name="head[]">'+val+'</textarea>'+
// '															</div>'+
// '															<span class=" remove_button_addresss btn btn-danger"> Remove </span>'+
// '														</div>';
// 		$(wrapper).append(fieldHTML_addresss);         
//     });
		$('.btn-add-address').addClass('d-none');
		$('.btn-update-address').removeClass('d-none');
		$("#address-store-ajax").addClass('vibrate');
		$(".add-more-address").removeClass('d-none');
		
	
       
}


  var gst_maxField = 10; //Input fields increment limitation
    var addButton_addresss = $(".add_button_addresss"); //Add button selector
    var wrapper_addresss = $(".field_wrapper_addresss"); //Input field wrapper_addresss
   var fieldHTML_addresss =  '<div class="col-xl-12 col-lg-12 address col-md-12 col-sm-12 col-12">'+
'															<div class="form-group">'+
'																<label for="inputEmail">Head : *</label>'+
'																<textarea class="form-control gst_head" name="head[]"></textarea>'+
'															</div>'+
'															<span class=" remove_button_addresss btn btn-danger"> Remove </span>'+
'														</div>';

    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton_addresss).click(function () {
        //Check maximum number of input fields
        if (x < gst_maxField) {
            x++; //Increment field counter
            $(wrapper_addresss).append(fieldHTML_addresss); //Add field html
        }
    });

    $(wrapper_addresss).on("click", ".remove_button_addresss", function (e) {
        e.preventDefault();
        $(this).closest('.gst').remove()
        x--; //Decrement field counter
    });