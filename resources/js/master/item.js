let base_url =  window.location.host+'/rainbow';
//alert(base_url);
let global_item_id = 0;
$(function(){
	
	let base_url_new = $('meta[name="base_url"]').attr('content');
	
	var load_url_item =base_url_new+'/admin/ajax-fetch/items';

	//var load_url ='https://logodost.com/admin/ajax-fetch/items';
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
	$('#copy-print-csv-data').DataTable( {
		dom: 'Bfrtip',pageLength: 50,
		scrollY: '400px',
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
	           columns: [ 0, 1,2,3,4,5,6] //Your Column value those you want
	               }
             },
		], ajax: load_url_item,
		columnDefs: [{
		    "defaultContent": "-",
		    "targets": "_all"
		  }],
		 columns: [
            { data: 'name' },
            { data: 'hsn' },
            { data: 'sac'},
            { data: 'status' },
            { data: 'cgst' },
            { data: 'sgst' },
            { data: 'igst' },
            { data: 'description' },
           { data: 'created_at',render: function (data) {
           	
		        var date = new Date(data);
		        var month = date.getMonth() + 1;
		        return (month.toString().length > 1 ? month : "0" + month) + "/" + date.getDate() + "/" + date.getFullYear()+' '+date.getHours()+':'+date.getMinutes();
		    } },
            {
                data: null,
                render: function (response) {
                	return  `<i class="fa fa-edit edit-item"   data-id="${response.id}" />`;
                },
                orderable: false
            },
            {
                data: null,
                render: function (response) {
                	return  `<i class="fa fa-trash delete-item"   data-id="${response.id}" />`;
                },
                orderable: false
            }
        ],

		'iDisplayLength': 5,
	});


	$("#item-store-ajax").submit( function(event) {
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
			$('#copy-print-csv-data').DataTable().ajax.reload();
			swal({
				  title: "Good job!",
				  text: "Item is added",
				  icon: "success",
				});
			$("span.text-danger").remove();
    		$("span.text-success").remove();
			$("#item-store-ajax")[0].reset();
		})
		.fail(function(error) {
			console.log(error);
			swal({
				  title: "Something wrong!",
				  text: "Please check your field",
				  icon: "error",
				});
			let data =error.responseJSON.errors;
			_show_errors(data,_this);
		})
		.always(function() {
			console.log("complete");
		});
	});

	$('body').on('click','.delete-item',function(){
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
			url: base_url_new+'/admin/item/'+id,
			type: 'DELETE',
			dataType: 'json',
		})
		.done(function() {
			load_table();
			swal({
				  title: "Item Deleted!",
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



	$('body').on('click','.edit-item',function(){
		var id = $(this).attr('data-id');
		global_item_id = id;
		$.ajax({
			url: base_url_new+'/admin/item/'+id,
			type: 'GET',
			dataType: 'json',
		})
		.done(function(response) {
			console.log(response);
			_set_edit_value(response);
		})
		.fail(function(e) {
			console.log("error",e);
		})
		.always(function() {
			console.log("complete");
		});
		
	});

	$('body').on('click','.btn-update-item',function(e){
		e.preventDefault();
		let url = base_url_new+'/admin/item/'+global_item_id;
		
		let name = $('input[name="name"]').val();
		let hsn = $('input[name="hsn"]').val();
		let cgst = $('input[name="cgst"]').val();
		let sgst = $('input[name="sgst"]').val();
		let sac = $('input[name="sac"]').val();
		let igst = $('input[name="igst"]').val();
		let status = $('input[name="status"]').val();
		let description = $('input[name="description"]').val();

		let method =  'PATCH';
		let _this =  $(this);
		//alert(method);
		event.preventDefault();
		let data =  $(this).serialize();
		$.ajax({
			url: url,
			type: method,
			dataType: 'json',
			data: {name,hsn,sgst,cgst,igst,status,description,sac},
		})
		.done(function(resp) {
			
			console.log(resp);
			swal({
				  title: "Good job!",
				  text: "Item is updated",
				  icon: "success",
				});
			$('#copy-print-csv-data').DataTable().ajax.reload();
			//$("#item-store-ajax")[0].reset();
			$('.add-more-item a').click();
		})
		.fail(function(error) {
			console.log(error);
			swal({
				  title: "Something wrong!",
				  text: "Please check your field",
				  icon: "error",
				});
			let data =error.responseJSON.errors;
			_show_errors(data,_this);
		});


	});

	function load_table(){
      $('#copy-print-csv-data').DataTable().ajax.reload();
	}




});

$(".add-more-item a").click(function(e){
		e.preventDefault();
		$('.btn-add-item').removeClass('d-none');
		$('.btn-update-item').addClass('d-none');
		$("#item-store-ajax").removeClass('vibrate');
		$(".add-more-item").addClass('d-none');
		$("#item-store-ajax")[0].reset();
});
function _show_errors(data,_this){
		$("span.text-danger").remove();
		$("span.text-success").remove();
		if (data.name) {
           $('<span class="text-danger">' + data.name[0] + "</span>").insertAfter($('input[name="name"]', _this));
       }
       if (data.hsn) {
           $('<span class="text-danger">' + data.hsn[0] + "</span>").insertAfter($('input[name="hsn"]', _this));
       }
       if (data.status) {
           $('<span class="text-danger">' + data.status[0] + "</span>").insertAfter($('input[name="status"]', _this));
       }
       if (data.cgst) {
           $('<span class="text-danger">' + data.cgst[0]+ "</span>").insertAfter($('input[name="cgst"]', _this));
       }
       if (data.sgst) {
           $('<span class="text-danger">' + data.sgst[0]+ "</span>").insertAfter($('input[name="sgst"]', _this));
       }
       if (data.igst) {
           $('<span class="text-danger">' + data.igst[0] + "</span>").insertAfter($('input[name="igst"]', _this));
       }if (data.description) {
           $('<span class="text-danger">' + data.description[0] + "</span>").insertAfter($('input[name="description"]', _this));
       }
       if (data.status) {
           $('<span class="text-danger">' + data.status[0] + "</span>").insertAfter($('input[name="status"]', _this));
       }
       
}
function _set_edit_value(data){
		$("#item-store-ajax").removeClass('vibrate');
		$("#item-store-ajax input[name='name']").val(data.name);
		$("#item-store-ajax input[name='hsn']").val(data.hsn);
		$("#item-store-ajax input[name='cgst']").val(data.cgst);
		$("#item-store-ajax input[name='igst']").val(data.igst);
		$("#item-store-ajax input[name='sgst']").val(data.sgst);
		$("#item-store-ajax input[name='sac']").val(data.sac);
		$("#item-store-ajax input[name='description']").val(data.description);
		$('.btn-add-item').addClass('d-none');
		$('.btn-update-item').removeClass('d-none');
		$("#item-store-ajax").addClass('vibrate');
		$(".add-more-item").removeClass('d-none');
		
		// if (data.name) {
  //          $('<span class="text-danger">' + data.name[0] + "</span>").insertAfter($('input[name="name"]', _this));
  //      }
       // if (data.hsn) {
       //     $('<span class="text-danger">' + data.hsn[0] + "</span>").insertAfter($('input[name="hsn"]', _this));
       // }
       // if (data.status) {
       //     $('<span class="text-danger">' + data.status[0] + "</span>").insertAfter($('input[name="status"]', _this));
       // }
       // if (data.cgst) {
       //     $('<span class="text-danger">' + data.cgst[0]+ "</span>").insertAfter($('input[name="cgst"]', _this));
       // }
       // if (data.sgst) {
       //     $('<span class="text-danger">' + data.sgst[0]+ "</span>").insertAfter($('input[name="sgst"]', _this));
       // }
       // if (data.igst) {
       //     $('<span class="text-danger">' + data.igst[0] + "</span>").insertAfter($('input[name="igst"]', _this));
       // }if (data.description) {
       //     $('<span class="text-danger">' + data.description[0] + "</span>").insertAfter($('input[name="description"]', _this));
       // }
       // if (data.status) {
       //     $('<span class="text-danger">' + data.status[0] + "</span>").insertAfter($('input[name="status"]', _this));
       // }
       
}