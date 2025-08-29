
//let global_heads_id = 0;
$(function(){
	let base_url_new = $('meta[name="base_url"]').attr('content');
	var load_url_heads =base_url_new+'/admin/heads';
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
	$('#copy-print-csv-heads').DataTable( {
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
		], ajax:{url:load_url_heads,dataSrc:""},
		 columns: [
  
            { data: 'name' },
       //       { data: 'created_at',render: function (data) {
			    //     var date = new Date(data);
			    //     var month = date.getMonth() + 1;
			    //     return (month.toString().length > 1 ? month : "0" + month) + "/" + date.getDate() + "/" + date.getFullYear()+' '+date.getHours()+':'+date.getMinutes();
			    // } },
            {
                data: null,
                render: function (response) {
                	return  `<i class="fa fa-edit edit-heads"   data-id="${response.id}" />`;
                },
                orderable: false
            }
        ],
		'iDisplayLength': 5,
	});



	$("#heads-store-ajax").submit( function(event) {
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
				  text: "heads is added",
				  icon: "success",
				});
			$("#heads-store-ajax")[0].reset();
			load_table();
			refresh_heads();
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
			_show_errors_heads(data,_this);
		})
		.always(function() {
			console.log("complete");
		});
	});

	$('body').on('click','.delete-heads',function(){
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
			url: base_url_new+'/admin/heads/'+id,
			type: 'DELETE',
			dataType: 'json',
		})
		.done(function() {
			load_table();
			swal({
				  title: "heads Deleted!",
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



	$('body').on('click','.edit-heads',function(){
		var id = $(this).attr('data-id');
		global_heads_id = id;
		$.ajax({
			url: base_url_new+'/admin/heads/'+id,
			type: 'GET',
			dataType: 'json',
		})
		.done(function(response) {
			console.log(response);
			_set_edit_value_heads(response);
		})
		.fail(function(e) {
			console.log("error",e);
		})
		.always(function() {
			console.log("complete");
		});
		
	});

	$('body').on('click','.btn-update-heads',function(e){
		e.preventDefault();
		let url 	= base_url_new+'/admin/heads/'+global_heads_id;
		var heads 	= $("#heads-store-ajax input[name='heads']").val();
		$(".heads_head").each(function (index, el) {
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
			data: {heads},
		})
		.done(function(resp) {
			
			console.log(resp);
			swal({
				  title: "Good job!",
				  text: "heads is updated",
				  icon: "success",
				});
			
			load_table();
			$('.add-more-heads a').click();
			//$("#heads-store-ajax")[0].reset();
		})
		.fail(function(error) {
			console.log(error);
			swal({
				  title: "Something wrong!",
				  text: "Please check your field",
				  icon: "error",
				});
			let data =error.responseJSON.errors;
			_show_errors_heads(data,_this);
		});


	});

	function load_table(){
      $('#copy-print-csv-heads').DataTable().ajax.reload();
	}




});

$(".add-more-heads a").click(function(e){
		e.preventDefault();
		$('.btn-add-heads').removeClass('d-none');
		$('.btn-update-heads').addClass('d-none');
		$("#heads-store-ajax").removeClass('vibrate');
		$(".add-more-heads").addClass('d-none');
		$("#heads-store-ajax")[0].reset();
});
function _show_errors_heads(data,_this){
		$("span.text-danger").remove();
		$("span.text-success").remove();
		if (data.heads) {
           $('<span class="text-danger">' + data.heads[0] + "</span>").insertAfter($('input[name="heads"]', _this));
       }
      
       
}
function _set_edit_value_heads(data){
		
		$("#heads-store-ajax").removeClass('vibrate');
		$("#heads-store-ajax input[name='heads']").val(data.name);
		
		
		$('.btn-add-heads').addClass('d-none');
		$('.btn-update-heads').removeClass('d-none');
		$("#heads-store-ajax").addClass('vibrate');
		$(".add-more-heads").removeClass('d-none');
		
	
       
}


  var heads_maxField = 10; //Input fields increment limitation
    var addButton_heads = $(".add_button_heads"); //Add button selector
    var wrapper_heads = $(".field_wrapper_heads"); //Input field wrapper_heads
   var fieldHTML_heads =  '<div class="col-xl-12 col-lg-12 heads col-md-12 col-sm-12 col-12">'+
'															<div class="form-group">'+
'																<label for="inputEmail">Head : *</label>'+
'																<textarea class="form-control heads_head" name="head[]"></textarea>'+
'															</div>'+
'															<span class=" remove_button_heads btn btn-danger"> Remove </span>'+
'														</div>';

    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton_heads).click(function () {
        //Check maximum number of input fields
        if (x < heads_maxField) {
            x++; //Increment field counter
            $(wrapper_heads).append(fieldHTML_heads); //Add field html
        }
    });

    $(wrapper_heads).on("click", ".remove_button_heads", function (e) {
        e.preventDefault();
        $(this).closest('.heads').remove()
        x--; //Decrement field counter
    });