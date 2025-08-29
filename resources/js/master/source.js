
let global_source_id = 0;
$(function(){
	let base_url_new = $('meta[name="base_url"]').attr('content');
	var load_url_source =base_url_new+'/admin/source';
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
	$('#copy-print-csv-source').DataTable( {
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
		], ajax:{url:load_url_source,dataSrc:""},
		 columns: [
   //          { data: null,
			// 	render: function (data, type, row, meta) {
			// 		return meta.row + 1;
			// 	}
			// },
            { data: 'source' },
       //       { data: 'created_at',render: function (data) {
			    //     var date = new Date(data);
			    //     var month = date.getMonth() + 1;
			    //     return (month.toString().length > 1 ? month : "0" + month) + "/" + date.getDate() + "/" + date.getFullYear()+' '+date.getHours()+':'+date.getMinutes();
			    // } },
            {
                data: null,
                render: function (response) {
                	return  `<i class="fa fa-edit edit-source"   data-id="${response.id}" />`;
                },
                orderable: false
            },
            {
                data: null,
                render: function (response) {
                	return  `<i class="fa fa-trash delete-source"   data-id="${response.id}" />`;
                },
                orderable: false
            }
        ],
		'iDisplayLength': 5,
	});



	$("#source-store-ajax").submit( function(event) {
		let url =  $(this).attr('action');
		let method =  $(this).attr('method');
		let _this =  $(this);
		//alert(method);
		event.preventDefault();
		let data =  $(this).serialize();

		$(".source_head").each(function (index, el) {
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
				  text: "source is added",
				  icon: "success",
				});
			$("#source-store-ajax")[0].reset();
			load_table();
			refresh_source();
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
			_show_errors_source(data,_this);
		})
		.always(function() {
			console.log("complete");
		});
	});

	$('body').on('click','.delete-source',function(){
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
			url: base_url_new+'/admin/source/'+id,
			type: 'DELETE',
			dataType: 'json',
		})
		.done(function() {
			load_table();
			swal({
				  title: "source Deleted!",
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



	$('body').on('click','.edit-source',function(){
		var id = $(this).attr('data-id');
		global_source_id = id;
		$.ajax({
			url: base_url_new+'/admin/source/'+id,
			type: 'GET',
			dataType: 'json',
		})
		.done(function(response) {
			console.log(response);
			_set_edit_value_source(response);
		})
		.fail(function(e) {
			console.log("error",e);
		})
		.always(function() {
			console.log("complete");
		});
		
	});

	$('body').on('click','.btn-update-source',function(e){
		e.preventDefault();
		let url = base_url_new+'/admin/source/'+global_source_id;
		
		var company_name  = 	$("#source-store-ajax input[name='company_name']").val();
		var head_office   = 	$("#source-store-ajax input[name='head_office']").val();
		var branch_office = 	$("#source-store-ajax input[name='branch_office']").val();

		var temp_address  = $("#source-store-ajax input[name='temp_address']").val();
		var sourcein  		  = $("#source-store-ajax input[name='sourcein']").val();
		var udyam_reg_no = $("#source-store-ajax input[name='udyam_reg_no']").val();
		var source 		= $("#source-store-ajax input[name='source']").val();	
		
		var source 		= $("#source-store-ajax input[name='source']").val();
		var issue_date = $("#source-store-ajax input[name='issue_date']").val();	
		
		var  expiry_date = $("#source-store-ajax input[name='expiry_date']").val();	
		var type = $("#source-store-ajax input[name='type']").val();	
		var mobile = $("#source-store-ajax input[name='mobile']").val();	
		var email = $("#source-store-ajax input[name='email']").val();	
		var pincode = $("#source-store-ajax input[name='pincode']").val();	
		var head = [];
		
		$(".source_head").each(function (index, el) {
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
			data: {company_name,head_office,branch_office,temp_address,head,sourcein,udyam_reg_no,source,source,issue_date,expiry_date,type,mobile,email},
		})
		.done(function(resp) {
			
			console.log(resp);
			swal({
				  title: "Good job!",
				  text: "source is updated",
				  icon: "success",
				});
			
			load_table();
			$('.add-more-source a').click();
			$("span.text-danger").remove();
			$("span.text-success").remove();
			//$("#source-store-ajax")[0].reset();
		})
		.fail(function(error) {
			console.log(error);
			swal({
				  title: "Something wrong!",
				  text: "Please check your field",
				  icon: "error",
				});
			let data =error.responseJSON.errors;
			_show_errors_source(data,_this);
		});


	});

	function load_table(){
      $('#copy-print-csv-source').DataTable().ajax.reload();
	}




});

$(".add-more-source a").click(function(e){
		e.preventDefault();
		$('.btn-add-source').removeClass('d-none');
		$('.btn-update-source').addClass('d-none');
		$("#source-store-ajax").removeClass('vibrate');
		$(".add-more-source").addClass('d-none');
		$("#source-store-ajax")[0].reset();
});
function _show_errors_source(data,_this){
		$("span.text-danger").remove();
		$("span.text-success").remove();
		if (data.source) {
           $('<span class="text-danger">' + data.source[0] + "</span>").insertAfter($('input[name="source"]', _this));
       }
      
       
}
function _set_edit_value_source(data){
		
		$("#source-store-ajax").removeClass('vibrate');
		$("#source-store-ajax input[name='source']").val(data.source);
		
		
		$('.btn-add-source').addClass('d-none');
		$('.btn-update-source').removeClass('d-none');
		$("#source-store-ajax").addClass('vibrate');
		$(".add-more-source").removeClass('d-none');
		
	
       
}


  var source_maxField = 10; //Input fields increment limitation
    var addButton_source = $(".add_button_source"); //Add button selector
    var wrapper_source = $(".field_wrapper_source"); //Input field wrapper_source
   var fieldHTML_source =  '<div class="col-xl-12 col-lg-12 source col-md-12 col-sm-12 col-12">'+
'															<div class="form-group">'+
'																<label for="inputEmail">Head : *</label>'+
'																<textarea class="form-control source_head" name="head[]"></textarea>'+
'															</div>'+
'															<span class=" remove_button_source btn btn-danger"> Remove </span>'+
'														</div>';

    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton_source).click(function () {
        //Check maximum number of input fields
        if (x < source_maxField) {
            x++; //Increment field counter
            $(wrapper_source).append(fieldHTML_source); //Add field html
        }
    });

    $(wrapper_source).on("click", ".remove_button_source", function (e) {
        e.preventDefault();
        $(this).closest('.source').remove()
        x--; //Decrement field counter
    });