$("#password-ajax").submit( function(event) {
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
		.done(function(respon) {
			console.log(respon);
			swal({
				  title: "Good job!",
				  text: "Password is updated",
				  icon: "success",
				});
			$("#password-ajax")[0].reset();
		})
		.fail(function(error) {
			console.log(error);
			swal({
				  title: "Something wrong!",
				  text: "Please check your field",
				  icon: "error",
				});
			let data =error.responseJSON.errors;
			_show_errors_password(data,_this);
		})
		.always(function() {
			console.log("complete");
		});
	});

$('body').on('change','.change-password-user-select',function(){
	let user_id =  $(this).val();
	//alert(user_id);
		$.ajax({
			url: base_url_new+'/admin/ajax-fetch/user/',
			type: 'GET',
			data:{id:user_id},
			dataType: 'json',
		})
		.done(function(response) {
			//console.log(response);
			$('input[name="user_id"]').val(response.employee_code);
			//_set_edit_value(response);
		})
		.fail(function(e) {
			console.log("error",e);
		})
		.always(function() {
			console.log("complete");
		});
});

function _show_errors_password(data,_this){
		$("span.text-danger").remove();
		$("span.text-success").remove();
		if (data.password_confirmation) {
           $('<span class="text-danger">' + data.password_confirmation[0] + "</span>").insertAfter($('input[name="password_confirmation"]', _this));
       }
       if (data.password) {
           $('<span class="text-danger">' + data.password[0] + "</span>").insertAfter($('input[name="password"]', _this));
       }
       if (data.user_id) {
           $('<span class="text-danger">' + data.user_id[0] + "</span>").insertAfter($('input[name="user_id"]', _this));
       }
       if (data.username) {
           $('<span class="text-danger">' + data.username[0] + "</span>").insertAfter($('input[name="username"]', _this));
       }
      
       
}