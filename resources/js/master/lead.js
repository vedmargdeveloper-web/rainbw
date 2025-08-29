
let global_lead_id = 0;
$(function(){
	let base_url_new = $('meta[name="base_url"]').attr('content');
	var load_url_lead =base_url_new+'/admin/lead';
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
	$('#copy-print-csv-lead').DataTable( {
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
		], ajax:{url:load_url_lead,dataSrc:""},
		 columns: [
   //          { data: null,
			// 	render: function (data, type, row, meta) {
			// 		return meta.row + 1;
			// 	}
			// },
            { data: 'lead' },
       //       { data: 'created_at',render: function (data) {
			    //     var date = new Date(data);
			    //     var month = date.getMonth() + 1;
			    //     return (month.toString().length > 1 ? month : "0" + month) + "/" + date.getDate() + "/" + date.getFullYear()+' '+date.getHours()+':'+date.getMinutes();
			    // } },
            {
                data: null,
                render: function (response) {
                	return  `<i class="fa fa-edit edit-lead"   data-id="${response.id}" />`;
                },
                orderable: false
            },
            {
                data: null,
                render: function (response) {
                	return  `<i class="fa fa-trash delete-lead"   data-id="${response.id}" />`;
                },
                orderable: false
            }
        ],
		'iDisplayLength': 5,
	});



	$("#lead-store-ajax").submit( function(event) {
		let url =  $(this).attr('action');
		let method =  $(this).attr('method');
		let _this =  $(this);
		//alert(method);
		event.preventDefault();
		let data =  $(this).serialize();

		$(".lead_head").each(function (index, el) {
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
				  text: "lead is added",
				  icon: "success",
				});
			$("#lead-store-ajax")[0].reset();
			load_table();
			refresh_lead();
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
			_show_errors_lead(data,_this);
		})
		.always(function() {
			console.log("complete");
		});
	});

	$('body').on('click','.delete-lead',function(){
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
			url: base_url_new+'/admin/lead/'+id,
			type: 'DELETE',
			dataType: 'json',
		})
		.done(function() {
			load_table();
			swal({
				  title: "lead Deleted!",
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



	$('body').on('click','.edit-lead',function(){
		var id = $(this).attr('data-id');
		global_lead_id = id;
		$.ajax({
			url: base_url_new+'/admin/lead/'+id,
			type: 'GET',
			dataType: 'json',
		})
		.done(function(response) {
			console.log(response);
			_set_edit_value_lead(response);
		})
		.fail(function(e) {
			console.log("error",e);
		})
		.always(function() {
			console.log("complete");
		});
		
	});

	$('body').on('click','.btn-update-lead',function(e){
		e.preventDefault();
		let url = base_url_new+'/admin/lead/'+global_lead_id;
		
		// var company_name  = 	$("#lead-store-ajax input[name='company_name']").val();
		// var head_office   = 	$("#lead-store-ajax input[name='head_office']").val();
		// var branch_office = 	$("#lead-store-ajax input[name='branch_office']").val();

		// var temp_address  = $("#lead-store-ajax input[name='temp_address']").val();
		// var leadin  		  = $("#lead-store-ajax input[name='leadin']").val();
		// var udyam_reg_no = $("#lead-store-ajax input[name='udyam_reg_no']").val();
		var lead = $("#lead-store-ajax input[name='lead']").val();	
		var lead_heads_id = $("#lead-store-ajax select[name='lead_heads_id']").val();	
		//alert(lead_heads_id);


		let method =  'PATCH';
		let _this =  $(this);
		//alert(method);
		event.preventDefault();
		let data =  $(this).serialize();
		$.ajax({
			url: url,
			type: method,
			dataType: 'json',
			data: {lead,lead_heads_id},
		})
		.done(function(resp) {
			
			console.log(resp);
			swal({
				  title: "Good job!",
				  text: "lead is updated",
				  icon: "success",
				});
			
			load_table();
			$('.add-more-lead a').click();
			$("span.text-danger").remove();
			$("span.text-success").remove();
			//$("#lead-store-ajax")[0].reset();
		})
		.fail(function(error) {
			console.log(error);
			swal({
				  title: "Something wrong!",
				  text: "Please check your field",
				  icon: "error",
				});
			let data =error.responseJSON.errors;
			_show_errors_lead(data,_this);
		});


	});

	function load_table(){
      $('#copy-print-csv-lead').DataTable().ajax.reload();
	}




});

$(".add-more-lead a").click(function(e){
		e.preventDefault();
		$('.btn-add-lead').removeClass('d-none');
		$('.btn-update-lead').addClass('d-none');
		$("#lead-store-ajax").removeClass('vibrate');
		$(".add-more-lead").addClass('d-none');
		$("#lead-store-ajax")[0].reset();
});
function _show_errors_lead(data,_this){
		$("span.text-danger").remove();
		$("span.text-success").remove();
		if (data.lead) {
           $('<span class="text-danger">' + data.lead[0] + "</span>").insertAfter($('input[name="lead"]', _this));
       }
      
       
}
function _set_edit_value_lead(data){
		
		$('select[name="lead_heads_id"]').val('');
		$('select[name="lead_heads_id"]').val(data.lead_heads_id);

		$("#lead-store-ajax").removeClass('vibrate');
		$("#lead-store-ajax input[name='lead']").val(data.lead);
		
		$('select[name="lead_heads_id"]').find('option[value="'+data.lead_heads_id+'"]').attr("selected",true);		
		
		$('.btn-add-lead').addClass('d-none');
		$('.btn-update-lead').removeClass('d-none');
		$("#lead-store-ajax").addClass('vibrate');
		$(".add-more-lead").removeClass('d-none');
}


  var lead_maxField = 10; //Input fields increment limitation
    var addButton_lead = $(".add_button_lead"); //Add button selector
    var wrapper_lead = $(".field_wrapper_lead"); //Input field wrapper_lead
   var fieldHTML_lead =  '<div class="col-xl-12 col-lg-12 lead col-md-12 col-sm-12 col-12">'+
'															<div class="form-group">'+
'																<label for="inputEmail">Head : *</label>'+
'																<textarea class="form-control lead_head" name="head[]"></textarea>'+
'															</div>'+
'															<span class=" remove_button_lead btn btn-danger"> Remove </span>'+
'														</div>';

    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton_lead).click(function () {
        //Check maximum number of input fields
        if (x < lead_maxField) {
            x++; //Increment field counter
            $(wrapper_lead).append(fieldHTML_lead); //Add field html
        }
    });

    $(wrapper_lead).on("click", ".remove_button_lead", function (e) {
        e.preventDefault();
        $(this).closest('.lead').remove()
        x--; //Decrement field counter
    });