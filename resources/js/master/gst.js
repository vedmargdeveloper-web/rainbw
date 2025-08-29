
let global_gst_id = 0;
$(function(){
	//var load_url ='https://logodost.com/admin/ajax-fetch/gst';
	
	let base_url_new = $('meta[name="base_url"]').attr('content');
	var load_url_gst =base_url_new+'/admin/ajax-fetch/gst';
	//alert();
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
	$('#copy-print-csv-gst').DataTable( {
		dom: 'Bfrtip',pageLength: 50,
		scrollY: '400px',
		scrollX: '100%',
        scrollCollapse: true,
        paging: false,
		buttons: [
			'copyHtml5',
			'excelHtml5',
			'csvHtml5',
			'pdfHtml5',
            {
               extend: 'print',
               exportOptions: {
               columns: [ 0,1,2,3,4,5,6,7,8,9,10,11,12,13,14] //Your Column value those you want
                   }
             },,
		], ajax:load_url_gst,
		 columns: [
            { data: 'company_name' },
            { data: 'head_office' },
            { data: 'branch_office' },
            { data: 'type' },
            { data: 'temp_address' },
            { data: 'gstin' },
            { data: 'udyam_reg_no' },
            { data: 'pincode' },
			{ data: null,render:function(res){
                //console.log('xsdflk',res.state);
                return res.state != null   ? res.state.state : '';
            } },
            { data: null,render:function(res){
               	return res.city != null   ? res.city.city : '';
                // return res.city.city;
            } },
            { data: 'issue_date' },
            { data: 'expiry_date' },
            { data: 'mobile' },
            { data: 'email' },
           	{ data: null,render:function(res){
            	return res.head != 'null'   ? JSON.parse(res.head).toString() : '';
            } },
            { data: 'created_at',render: function (data) {
			        var date = new Date(data);
			        var month = date.getMonth() + 1;
			        return (month.toString().length > 1 ? month : "0" + month) + "/" + date.getDate() + "/" + date.getFullYear()+' '+date.getHours()+':'+date.getMinutes();
			    } },
            {
                data: null,
                render: function (response) {
                	return  `<i class="fa fa-edit edit-gst"   data-id="${response.id}" />`;
                },
                orderable: false
            },
            {
                data: null,
                render: function (response) {
                	return  `<i class="fa fa-trash delete-gst"   data-id="${response.id}" />`;
                },
                orderable: false
            }
        ],

		'iDisplayLength': 5,
	});






	$("#gst-store-ajax").submit( function(event) {
		let url =  $(this).attr('action');
		let method =  $(this).attr('method');
		let _this =  $(this);
		//alert(method);
		event.preventDefault();
		let data =  $(this).serialize();
		let head_error = 0;

		$(".gst_head").each(function (index, el) {
            if ($(this).val() == "") {
                swal({
                    title: "Something Wrong !",
                    text: "Head  is required",
                    icon: "error",
                });
                return false;
            }
        });

        if(head_error > 0){
        	return false;
        }

		$.ajax({
			url: url,
			type: method,
			dataType: 'json',
			data: data,
		})
		.done(function() {
			
			swal({
				  title: "Good job!",
				  text: "Gst is added",
				  icon: "success",
				});
			$("#gst-store-ajax")[0].reset();
			load_table();
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
			_show_errors_gst(data,_this);
		})
		.always(function() {
			console.log("complete");
		});
	});

	$('body').on('click','.delete-gst',function(){
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
			url: base_url_new+'/admin/gst/'+id,
			type: 'DELETE',
			dataType: 'json',
		})
		.done(function() {
			load_table();
			swal({
				  title: "gst Deleted!",
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



	$('body').on('click','.edit-gst',function(){
		var id = $(this).attr('data-id');
		global_gst_id = id;
		$.ajax({
			url: base_url_new+'/admin/gst/'+id,
			type: 'GET',
			dataType: 'json',
		})
		.done(function(response) {
			console.log(response);
			_set_edit_value_gst(response);
		})
		.fail(function(e) {
			console.log("error",e);
		})
		.always(function() {
			console.log("complete");
		});
		
	});

	$('body').on('click','.btn-update-gst',function(e){
		e.preventDefault();
		let url = base_url_new+'/admin/gst/'+global_gst_id;
		
		var company_name  = 	$("#gst-store-ajax input[name='company_name']").val();
		var head_office   = 	$("#gst-store-ajax input[name='head_office']").val();
		var branch_office = 	$("#gst-store-ajax input[name='branch_office']").val();

		var temp_address  = $("#gst-store-ajax input[name='temp_address']").val();
		var gstin  		  = $("#gst-store-ajax input[name='gstin']").val();
		var udyam_reg_no = $("#gst-store-ajax input[name='udyam_reg_no']").val();
		var state 		= $("#gst-store-ajax select[name='state']").val();	
		
		var city 		= $("#gst-store-ajax select[name='city']").val();
		var issue_date = $("#gst-store-ajax input[name='issue_date']").val();	
		
		var  expiry_date = $("#gst-store-ajax input[name='expiry_date']").val();	
		var type = $("#gst-store-ajax select[name='type']").val();	
		var mobile = $("#gst-store-ajax input[name='mobile']").val();	
		var email = $("#gst-store-ajax input[name='email']").val();	
		var pincode = $("#gst-store-ajax input[name='pincode']").val();	
		var head = [];
		
		var head_error = 0;
		
		$(".gst_head").each(function (index, el) {
            if ($(this).val() == "") {
                swal({
                    title: "Something Wrong !",
                    text: "Head  is required",
                    icon: "error",
                });
                head_error++;
                return false;
            }
            head[index] =  $(this).val();
        });
        
        if(head_error > 0){
        	return false;
        }

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
			data: {company_name,head_office,branch_office,temp_address,head,gstin,udyam_reg_no,state,city,issue_date,expiry_date,type,mobile,email},
		})
		.done(function(resp) {
			
			console.log(resp);
			swal({
				  title: "Good job!",
				  text: "gst is updated",
				  icon: "success",
				});
			
			load_table();
			//$("#gst-store-ajax")[0].reset();
			$('.add-more-gst a').click();
			$('.remove_button_gst').click();
		})
		.fail(function(error) {
			console.log(error);
			swal({
				  title: "Something wrong!",
				  text: "Please check your field",
				  icon: "error",
				});
			let data =error.responseJSON.errors;
			_show_errors_gst(data,_this);
		});


	});

	function load_table(){
      $('#copy-print-csv-gst').DataTable().ajax.reload();
	}




});

$(".add-more-gst a").click(function(e){
		e.preventDefault();
		$('.btn-add-gst').removeClass('d-none');
		$('.btn-update-gst').addClass('d-none');
		$("#gst-store-ajax").removeClass('vibrate');
		$(".add-more-gst").addClass('d-none');
		$("#gst-store-ajax")[0].reset();
});
function _show_errors_gst(data,_this){
		$("span.text-danger").remove();
		$("span.text-success").remove();
		if (data.company_name) {
           $('<span class="text-danger">' + data.company_name[0] + "</span>").insertAfter($('input[name="company_name"]', _this));
       }
       if (data.head_office) {
           $('<span class="text-danger">' + data.head_office[0] + "</span>").insertAfter($('input[name="head_office"]', _this));
       }
       if (data.branch_office) {
           $('<span class="text-danger">' + data.branch_office[0] + "</span>").insertAfter($('input[name="branch_office"]', _this));
       }
       if (data.temp_address) {
           $('<span class="text-danger">' + data.temp_address[0]+ "</span>").insertAfter($('input[name="temp_address"]', _this));
       }
       if (data.gstin) {
           $('<span class="text-danger">' + data.gstin[0]+ "</span>").insertAfter($('input[name="gstin"]', _this));
       }
       if (data.udyam_reg_no) {
           $('<span class="text-danger">' + data.udyam_reg_no[0] + "</span>").insertAfter($('input[name="udyam_reg_no"]', _this));
       }if (data.pincode) {
           $('<span class="text-danger">' + data.pincode[0] + "</span>").insertAfter($('input[name="pincode"]', _this));
       }
       if (data.state) {
           $('<span class="text-danger">' + data.state[0] + "</span>").insertAfter($('input[name="state"]', _this));
       }
       if (data.city) {
           $('<span class="text-danger">' + data.city[0] + "</span>").insertAfter($('input[name="city"]', _this));
       }
       if (data.type) {
           $('<span class="text-danger">' + data.type[0] + "</span>").insertAfter($('input[name="type"]', _this));
       }
       if (data.issue_date) {
           $('<span class="text-danger">' + data.issue_date[0] + "</span>").insertAfter($('input[name="issue_date"]', _this));
       }
       if (data.expiry_date) {
           $('<span class="text-danger">' + data.expiry_date[0] + "</span>").insertAfter($('input[name="expiry_date"]', _this));
       }
       if (data.mobile) {
           $('<span class="text-danger">' + data.mobile[0] + "</span>").insertAfter($('input[name="mobile"]', _this));
       }
       if (data.email) {
           $('<span class="text-danger">' + data.email[0] + "</span>").insertAfter($('input[name="email"]', _this));
       }
       
}
function _set_edit_value_gst(data){
		console.log(data);
		$("#gst-store-ajax").removeClass('vibrate');
		$("#gst-store-ajax input[name='company_name']").val(data.company_name);
		$("#gst-store-ajax input[name='head_office']").val(data.head_office);
		$("#gst-store-ajax input[name='branch_office']").val(data.branch_office);
		$("#gst-store-ajax input[name='temp_address']").val(data.temp_address);
		$("#gst-store-ajax input[name='gstin']").val(data.gstin);
		$("#gst-store-ajax input[name='udyam_reg_no']").val(data.udyam_reg_no);
		// $("#gst-store-ajax select[name='state']").val(data.state);	
		// $("#gst-store-ajax select[name='city']").val(data.city);	
		$('select[name="city"]').find('option[value="'+data.city+'"]').attr("selected",true);
    	$('select[name="state"]').find('option[value="'+data.state+'"]').attr("selected",true);
    	$('select[name="type"]').find('option[value="'+data.type+'"]').attr("selected",true);

		$("#gst-store-ajax input[name='issue_date']").val(data.issue_date);	
		$("#gst-store-ajax input[name='expiry_date']").val(data.expiry_date);	
		$("#gst-store-ajax input[name='type']").val(data.type);	
		$("#gst-store-ajax input[name='mobile']").val(data.mobile);	
		$("#gst-store-ajax input[name='email']").val(data.email);	
		$("#gst-store-ajax input[name='pincode']").val(data.pincode);	
		let wrapper = $(".field_wrapper_gst");
		let head = JSON.parse(data.head);

    	$(wrapper).html('');
		 $.each(head, function(index, val) {
    	    var fieldHTML_gst =  '<div class="col-xl-12 col-lg-12 gst col-md-12 col-sm-12 col-12">'+
'															<div class="form-group">'+
'																<label for="inputEmail">Head : *</label>'+
'																<textarea class="form-control gst_head"  name="head[]">'+val+'</textarea>'+
'															</div>'+
'															<span class=" remove_button_gst btn btn-danger"> Remove </span>'+
'														</div>';
		$(wrapper).append(fieldHTML_gst);         
    });
		$('.btn-add-gst').addClass('d-none');
		$('.btn-update-gst').removeClass('d-none');
		$("#gst-store-ajax").addClass('vibrate');
		$(".add-more-gst").removeClass('d-none');
		
	
       
}


  var gst_maxField = 10; //Input fields increment limitation
    var addButton_gst = $(".add_button_gst"); //Add button selector
    var wrapper_gst = $(".field_wrapper_gst"); //Input field wrapper_gst
   var fieldHTML_gst =  '<div class="col-xl-12 col-lg-12 gst col-md-12 col-sm-12 col-12">'+
'															<div class="form-group">'+
'																<label for="inputEmail">Head : *</label>'+
'																<textarea class="form-control gst_head" name="head[]"></textarea>'+
'															</div>'+
'															<span class=" remove_button_gst btn btn-danger"> Remove </span>'+
'														</div>';

    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton_gst).click(function () {
        //Check maximum number of input fields
        if (x < gst_maxField) {
            x++; //Increment field counter
            $(wrapper_gst).append(fieldHTML_gst); //Add field html
        }
    });

    $(wrapper_gst).on("click", ".remove_button_gst", function (e) {
        e.preventDefault();
        $(this).closest('.gst').remove()
        x--; //Decrement field counter
    });