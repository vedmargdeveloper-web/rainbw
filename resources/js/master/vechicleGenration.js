
let global_vechicleGenration_id = 0;
$(function(){
	let base_url_new = $('meta[name="base_url"]').attr('content');
	var load_url_color =base_url_new+'/admin/vehicle-id-genration';
	$.ajaxSetup({
	    headers: {
	        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	    }
	});
	$('#copy-print-csv-vechicleGenration').DataTable( {
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
            // { data: 'id' },
            { data: null,render:function(res){
                return res.item?.name;
            } },
            { data: null,render:function(res){
                return res.colors?.color ?? '';
            } },
            {
            	data:"vechicle_id"
            },
            {
            	data:"value"
            },
            {
                data: null,
                render: function (response) {
                	return  `<i class="fa fa-edit edit-vechicleGenration"   data-id="${response.id}" />`;
                },
                orderable: false
            }
        ],
		'iDisplayLength': 5,
	});

	$("#vechicleGenration-store-ajax").submit( function(event) {
		event.preventDefault();
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
				  text: "vechicle id Genrated ",
				  icon: "success",
				});
			$("#color-store-ajax")[0].reset();
			load_table();
			//refresh_color();
			$("span.text-danger").remove();
			$("span.text-success").remove();
			$("#vechicleGenration-store-ajax")[0].reset();
            //$("#dealer-store-ajax .add_button").click();
            $('select[name="items_id"]').prop('selectedIndex',0);
            $('select[name="colors_id"]').prop('selectedIndex',0);
		})
		.fail(function(error) {
			console.log('error',error);
			swal({
				  title: "Something wrong!",
				  text: "Please check your field",
				  icon: "error",
				});
			let data = error.responseJSON.errors;
			_show_errors_color(data,_this);
		})
		.always(function() {
			console.log("complete");
		});
	});

	$('body').on('click','.delete-vechicleGenration',function(){
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
			url: base_url_new+'/admin/vehicle-id-genration/'+id,
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



	$('body').on('click','.edit-vechicleGenration',function(){
		var id = $(this).attr('data-id');
		global_vechicleGenration_id = id;
		$.ajax({
			url: base_url_new+'/admin/vehicle-id-genration/'+id,
			type: 'GET',
			dataType: 'json',
		})
		.done(function(response) {
			console.log(response);
			_set_edit_value_color(response);
		})
		.fail(function(e) {
			console.log("error",e);
		})
		.always(function() {
			console.log("complete");
		});
		
	});

	$('body').on('click','.btn-update-vechicleGenration',function(e){
		e.preventDefault();
		let url = base_url_new+'/admin/vehicle-id-genration/'+global_vechicleGenration_id;
		var items_id 		= $("#vechicleGenration-store-ajax select[name='items_id']").val();
		var colors_id 		= $("#vechicleGenration-store-ajax select[name='colors_id']").val();
		var vechicle_id 		= $("#vechicleGenration-store-ajax input[name='vechicle_id']").val();
		var value 		= $("#vechicleGenration-store-ajax input[name='value']").val();
		let method =  'PATCH';
		let _this =  $(this);
		event.preventDefault();
		let data =  $(this).serialize();
		$.ajax({
			url: url,
			type: method,
			dataType: 'json',
			data: {items_id,colors_id,vechicle_id,value},
		})
		.done(function(resp) {
			swal({
				  title: "Good job!",
				  text: "Vehicle id Updated",
				  icon: "success",
				});
			load_table();
			$("span.text-danger").remove();
			$("span.text-success").remove();
			$("#vechicleGenration-store-ajax")[0].reset();
            $(".add-more-vechicleGenration a").click();
           // alert();
            $('select[name="items_id"]').prop('selectedIndex',0);
            $('select[name="colors_id"]').prop('selectedIndex',0);
			
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
      $('#copy-print-csv-vechicleGenration').DataTable().ajax.reload();
	}
});

$(".add-more-vechicleGenration a").click(function(e){
		e.preventDefault();
		$('.btn-add-vechicleGenration').removeClass('d-none');
		$('.btn-update-vechicleGenration').addClass('d-none');
		$("#color-store-ajax").removeClass('vibrate');
		$(".add-more-vechicleGenration").addClass('d-none');
		$("#color-store-ajax")[0].reset();
});
function _show_errors_color(data,_this){
		$("span.text-danger").remove();
		$("span.text-success").remove();
		console.log('database',data);
		// if (data) {
			if (data.items_id) {
			        $('<span class="text-danger">' + data.items_id[0] + "</span>").insertAfter($('select[name="items_id"]', _this));
			    }

		   	if (data.colors_id) {
		        $('<span class="text-danger">' + data.colors_id[0] + "</span>").insertAfter($('select[name="colors_id"]', _this));
		    }

		    if (data.vechicle_id) {
		        $('<span class="text-danger">' + data.vechicle_id[0] + "</span>").insertAfter($('input;[name="vechicle_id"]', _this));
		    }
           
           // $('<span class="text-danger">' + data.colors_id[0] + "</span>").insertAfter($('select[name="colors_id"]', _this));
           // $('<span class="text-danger">' + data.vechicle_id[0] + "</span>").insertAfter($('input[name="vechicle_id"]', _this));
       //}       
}
function _set_edit_value_color(data){
        console.log(data);
		$('select[name="colors_id"]').val(data.colors.id);
		$('select[name="items_id"]').val(data.item.id);
		$('input[name="vechicle_id"]').val(data.vechicle_id);
		$('input[name="value"]').val(data.value);

		$('select[name="colors_id"]').find('option[value="'+data.colors.id+'"]').attr("selected",true);
		$('select[name="items_id"]').find('option[value="'+data.item.id+'"]').attr("selected",true);
		// console.log('xxd df',data.colors.id);
		// console.log('xxd df',data.item.id);
		//return;
		// $('input[name="colors_id"]').val(data.colors.id);
		$("#color-store-ajax").removeClass('vibrate');
		//$('option[value=2]').attr('selected','selected');
		//alert('xi d');
		
		$('.btn-add-vechicleGenration').addClass('d-none');
		$('.btn-update-vechicleGenration').removeClass('d-none');
		$("#color-store-ajax").addClass('vibrate');
		$(".add-more-vechicleGenration").removeClass('d-none');       
}
