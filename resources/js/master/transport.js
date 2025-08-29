
//let global_transport_id = 0;
$(function(){
	let base_url_new = $('meta[name="base_url"]').attr('content');
	var load_url_transport =base_url_new+'/admin/transport';
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
	$('#copy-print-csv-transport').DataTable( {
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
		], ajax:{url:load_url_transport,dataSrc:""},
		 columns: [
  
            { data: 'transport' },
       //       { data: 'created_at',render: function (data) {
			    //     var date = new Date(data);
			    //     var month = date.getMonth() + 1;
			    //     return (month.toString().length > 1 ? month : "0" + month) + "/" + date.getDate() + "/" + date.getFullYear()+' '+date.getHours()+':'+date.getMinutes();
			    // } },
            {
                data: null,
                render: function (response) {
                	return  `<i class="fa fa-edit edit-transport" data-id="${response.id}" />`;
                },
                orderable: false
            }
        ],
		'iDisplayLength': 5,
	});



	$("#transport-store-ajax").submit( function(event) {
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
				  text: "transport is added",
				  icon: "success",
				});
			$("#transport-store-ajax")[0].reset();
			load_table();
			//refresh_transport();
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
			_show_errors_transport(data,_this);
		})
		.always(function() {
			console.log("complete");
		});
	});

	$('body').on('click','.delete-transport',function(){
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
			url: base_url_new+'/admin/transport/'+id,
			type: 'DELETE',
			dataType: 'json',
		})
		.done(function() {
			load_table();
			swal({
				  title: "transport Deleted!",
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



	$('body').on('click','.edit-transport',function(){
		var id = $(this).attr('data-id');
		global_transport_id = id;
		$.ajax({
			url: base_url_new+'/admin/transport/'+id,
			type: 'GET',
			dataType: 'json',
		})
		.done(function(response) {
			 console.log(response);
			_set_edit_value_transport(response);
		})
		.fail(function(e) {
			console.log("error",e);
		})
		.always(function() {
			console.log("complete");
		});
		
	});

	$('body').on('click','.btn-update-transport',function(e){
		e.preventDefault();
		let url 	= base_url_new+'/admin/transport/'+global_transport_id;
		var transport 	= $("#transport-store-ajax input[name='transport']").val();
		$(".transport_head").each(function (index, el) {
            if ($(this).val() == "") {
                swal({
                    title:"Something Wrong !",
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
			data: {transport},
		})
		.done(function(resp) {
			
			console.log(resp);
			swal({
				  title: "Good job!",
				  text: "transport is updated",
				  icon: "success",
				});
			
			load_table();
			$('.add-more-transport a').click();
			//$("#transport-store-ajax")[0].reset();
		})
		.fail(function(error) {
			console.log(error);
			swal({
				  title: "Something wrong!",
				  text: "Please check your field",
				  icon: "error",
				});
			let data =error.responseJSON.errors;
			_show_errors_transport(data,_this);
		});


	});

	function load_table(){
      $('#copy-print-csv-transport').DataTable().ajax.reload();
	}




});

$(".add-more-transport a").click(function(e){
		e.preventDefault();
		$('.btn-add-transport').removeClass('d-none');
		$('.btn-update-transport').addClass('d-none');
		$("#transport-store-ajax").removeClass('vibrate');
		$(".add-more-transport").addClass('d-none');
		$("#transport-store-ajax")[0].reset();
});
function _show_errors_transport(data,_this){
		$("span.text-danger").remove();
		console.log(data);
		$("span.text-success").remove();
		if (data.transport) {
           $('<span class="text-danger">' + data.transport[0] + "</span>").insertAfter($('input[name="transport"]', _this));
       }
      
       
}
function _set_edit_value_transport(data){
		
		$("#transport-store-ajax").removeClass('vibrate');
		$("#transport-store-ajax input[name='transport']").val(data.transport);
		
		
		$('.btn-add-transport').addClass('d-none');
		$('.btn-update-transport').removeClass('d-none');
		$("#transport-store-ajax").addClass('vibrate');
		$(".add-more-transport").removeClass('d-none');       
}
