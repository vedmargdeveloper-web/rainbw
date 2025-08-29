//let base_url =  window.location.host+'/rainbow';
////alert(base_url);
let global_dealer_id = 0;
let global_dealer_type = 0;
$(function () {

        let base_url_new = $('meta[name="base_url"]').attr('content');
        var load_url_dealer =base_url_new+'/admin/customers';

    $("#copy-print-csv-dealer").DataTable({
        dom: "Bfrtip",
        pageLength: 50,
        scrollY: '400px',
        scrollX: '100%',
        scrollCollapse: true,
        paging: false,
        buttons: ["copyHtml5", "excelHtml5", "csvHtml5", "pdfHtml5",
            {
               extend: 'print',
               exportOptions: {
               columns: [ 0,1,2,3,4,5,6,7,8,9,10,11] //Your Column value those you want
                   }
             },],
        ajax: { url: load_url_dealer, dataSrc: "" },
        columns: [
            // { data: "id" },
            { data: null,
                render: function (data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: null,render:function(res){
                return res.type.type;
            } },
            { data: "company_name" },
            { data: "address" },
            { data: null,render:function(res){
                return res.city == null ? '' : res.city.city;
                //return res.city.city;
            } },
            { data: null,render:function(res){
                return res.state == null ? '' : res.state.state;
            } },
            { data: "pincode" },
            { data: "gstin" },
            { data: null,render:function(res){
            	return  res.contact_person_name != 'null' ? JSON.parse(res.contact_person_name).toString() : '';
            } },
            { data: null,render:function(res){
            	console.log(res.mobile);
                return res.mobile != 'null' ? JSON.parse(res.mobile).toString() : '';
            } },{ data: "cwhatsapp" },
            { data: null,render:function(res){
            	return  res.designation != 'null' ? JSON.parse(res.designation).toString() : '';
            } },
            { data: "email" },
            { data: 'created_at',render: function (data) {
                    var date = new Date(data);
                    var month = date.getMonth() + 1;
                    return (month.toString().length > 1 ? month : "0" + month) + "/" + date.getDate() + "/" + date.getFullYear()+' '+date.getHours()+':'+date.getMinutes();
                } },
            {
                data: null,
                render: function (response) {
                    return `<i class="fa fa-edit edit-dealer"   data-id="${response.id}" />`;
                },
                orderable: false,
            },
            {
                data: null,
                render: function (response) {
                    return `<i class="fa fa-trash delete-dealer"   data-id="${response.id}" />`;
                },
                orderable: false,
            },
        ],
    });

    $("#dealer-store-ajax").submit(function (event) {
        let url = $(this).attr("action");
        let method = $(this).attr("method");
        let _this = $(this);
        let  error_count = 0;
        $(".contact-person-name").each(function (index, el) {
            if ($(this).val() == "") {
                swal({
                    title: "Something Wrong !",
                    text: "Contact Person Phone is required",
                    icon: "error",
                });
                $('.text-danger').remove();
                $('<p class="text-danger">Name is required</p>').insertAfter(this)
                error_count++;
                return false;
            }
            
        });

        $(".contact-person-phone").each(function (index, el) {
            if ($(this).val() == "") {
                swal({
                    title: "Something Wrong !",
                    text: "Contact Person Phone is required",
                    icon: "error",
                });
                error_count++;
                return false;
            }
        });
        
        var phone_length_error = 0;

        $(".contact-person-phone").each(function (index, el) {
                    var phone = $(this).val();
                    
                    if(phone.length <  10  || phone.length >  10 ){
                        $('.text-danger').remove();
                        $('<p class="text-danger">Invalid Phone</p>').insertAfter(this)
                        phone_length_error = 1;
                    }
                    
        });
        if(phone_length_error > 0 ){
           return false;
        }

       // return false;


        if(global_dealer_type != 2){
            // alert(global_dealer_type);
            $(".contact-person-designation").each(function (index, el) {
                if ($(this).val() == "") {
                    swal({
                        title: "Something Wrong !",
                        text: "Contact person designation is required",
                        icon: "error",
                    });
                    $('.text-danger').remove();
                    $('<p class="text-danger">Designation is required</p>').insertAfter(this)
                    error_count++;
                    return false;
                }
            });
        }
        if(error_count > 0 ){
            return false;
        }
         $('.text-danger').remove();
       	   
      //  alert(method);
        event.preventDefault();
        let data = $(this).serialize();
        // alert(data);
        // return;
        $.ajax({
            url: url,
            type: method,
            dataType: "json",
            data: data,
        })
            .done(function (response) {
                // console.log(response);
                $("#copy-print-csv-dealer").DataTable().ajax.reload();
                swal({
                    title: "Good job!",
                    text: "Added Successfully",
                    icon: "success",
                });
                $("span.text-danger").remove();
                $("span.text-success").remove();
                $("#dealer-store-ajax")[0].reset();
                //$("#dealer-store-ajax .add_button").click();
                $('select[name="state"]').prop('selectedIndex',0);
                $('select[name="city"]').prop('selectedIndex',0);
            })
            .fail(function (error) {
                console.log(error);
                swal({
                    title: "Something wrong!",
                    text: "Please check your field",
                    icon: "error",
                });
                let data = error.responseJSON.errors;
                _show_errors_dealer(data, _this);
            })
            .always(function () {
                console.log("complete");
            });
    });

    $("body").on("click", ".delete-dealer", function () {
        var id = $(this).attr("data-id");
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover this imaginary file!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: base_url_new+"/admin/customers/" + id,
                    type: "DELETE",
                    dataType: "json",
                })
                    .done(function () {
                        load_table();
                        swal({
                            title: "Customer Deleted!",
                            text: "",
                            icon: "success",
                        });
                    })
                    .fail(function (e) {
                        console.log(e);
                        alert("something wrong");
                    });
            } else {
                return true;
            }
        });
        // if(!confirm('Are you sure want to delete this?')){
        // 	return false;
        // }
    });

    $("body").on("click", ".edit-dealer", function () {
        var id = $(this).attr("data-id");
        global_dealer_id = id;
        $.ajax({
            url: base_url_new+"/admin/customers/" + id,
            type: "GET",
            dataType: "json",
        })
            .done(function (response) {
                console.log(response);
                _set_edit_value_dealer(response);
            })
            .fail(function (e) {
                console.log("error", e);
            })
            .always(function () {
                console.log("complete");
            });
    });

    $('select[name="customer_type"]').change(function (e) {
        let type = $(this).val();
        if(type==2){
            global_dealer_type = type;
            $("#dealer-store-ajax input[name='gstin']").prop('disabled',true);
            $("#dealer-store-ajax .contact-person-designation").prop('disabled',true);
        }else{
            $("#dealer-store-ajax input[name='gstin']").prop('disabled',false);
            $("#dealer-store-ajax .contact-person-designation").prop('disabled',false);
            global_dealer_type = type;
        }
    });

    $("body").on("click", ".btn-update-dealer", function (e) {
        e.preventDefault();
        let url = base_url_new+"/admin/customers/" + global_dealer_id;

        var customer_type = $("#dealer-store-ajax select[name='customer_type']").val();
        //alert(customer_type);
        var company_name = $("#dealer-store-ajax input[name='company_name']").val();
        var address = $("#dealer-store-ajax input[name='address']").val();
        var address1 = $("#dealer-store-ajax input[name='address1']").val();
        var pincode = $("#dealer-store-ajax input[name='pincode']").val();
        var city = $("#dealer-store-ajax select[name='city']").val();
        var state = $("#dealer-store-ajax select[name='state']").val();
        var gstin = $("#dealer-store-ajax input[name='gstin']").val();
        var allocation = $('input[name="allocation"]').val();
        var cwhatsapp = $('input[name="cwhatsapp"]').val();
        if($('input[name="allocation"]').is(':checked')){
            allocation =1;
        }else{
            allocation =0;
        }
        // alert(allocation);
        // return;
        //var contact_person_name = $("#dealer-store-ajax input[name='contact_person_name']").val();
        
        // alert(city);
        // return;

        var email = $("#dealer-store-ajax input[name='email']").val();
        let contact_person_name  = [];
        let mobile  = [];
        let designation  = [];
        let error_count = 0;

        $(".contact-person-name").each(function (index, el) {
            if ($(this).val() == "") {

                $('.text-danger').remove();
                $('<p class="text-danger">Name is required</p>').insertAfter(this);
                console.log('blnak ');
                swal({
                    title: "Something Wrong !",
                    text: "Contact Person Name is required",
                    icon: "error",
                });
                error_count++;
               
                return false;
            }
            contact_person_name[index] =  $(this).val();
            console.log('blnak 2');
        });
        
       // $('.text-danger').remove();

        $(".contact-person-phone").each(function (index, el) {
            if ($(this).val() == "") {
                swal({
                    title: "Something Wrong !",
                    text: "Contact Person Phone is required",
                    icon: "error",
                });
                error_count++;

                return false;
            }
             mobile[index] =  $(this).val();
        });


        var phone_length_error = 0;

        $(".contact-person-phone").each(function (index, el) {
                    var phone = $(this).val();
                    
                    if(phone.length <  10  || phone.length >  10 ){
                        $('.text-danger').remove();
                        $('<p class="text-danger">Invalid Phone</p>').insertAfter(this)
                        phone_length_error = 1;
                    }
                    
        });
        if(phone_length_error > 0 ){
           return false;
        }


        $(".contact-person-designation").each(function (index, el) {
            if ($(this).val() == "") {
                swal({
                    title: "Something Wrong !",
                    text: "Contact person designation is required",
                    icon: "error",
                });
                error_count++;
                $('.text-danger').remove();
                $('<p class="text-danger">Designation is required</p>').insertAfter(this)
                return false;
            }
            designation[index] =  $(this).val();
        });

        if(error_count > 0){
            return false;
        }
          $('.text-danger').remove();
       //  console.log(designation);
       // return false;
        let method = "PATCH";
        //console.log();
        let _this = $(this).parent('div.row.gutters').closest('form');

        //alert(method);
        event.preventDefault();
        let data = $(this).serialize();
        $.ajax({
            url: url,
            type: method,
            dataType: "json",
            data: { customer_type, company_name,cwhatsapp, address, pincode, city, state, gstin,address1, contact_person_name, mobile, email,designation,allocation },
        })
            .done(function (resp) {
                console.log(resp);
                swal({
                    title: "Good job!",
                    text: "Customer is updated",
                    icon: "success",
                });
                $("#copy-print-csv-dealer").DataTable().ajax.reload();
                //$("#dealer-store-ajax")[0].reset();
                $('.add-more-dealer a').click();
                $("span.text-danger").remove();
                $("span.text-success").remove();
                $('select[name="state"]').prop('selectedIndex',0);
                $('select[name="city"]').prop('selectedIndex',0);
                $("#dealer-store-ajax .add_button").click();
                $('.remove_button').hide();
                
            })
            .fail(function (error) {
                console.log(error);
                swal({
                    title: "Something wrong!",
                    text: "Please check your field",
                    icon: "error",
                });
                 let data = error.responseJSON.errors;
                _show_errors_dealer(data, _this);
            });
    });

    function load_table() {
        $("#copy-print-csv-dealer").DataTable().ajax.reload();
    }

    var maxField = 10; //Input fields increment limitation
    var addButton = $(".add_button"); //Add button selector
    var wrapper = $(".field_wrapper"); //Input field wrapper
    var fieldHTML =
        '<div class="row dynamic">' +
        '			                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 ">' +
        '			                                            <div class="form-group">' +
        '			                                                <label for="inputEmail">Contact Persion Name *</label>' +
        '			                                                <input type="text" name="contact_person_name[]" value="" class="form-control contact-person-name" id="" placeholder="Contact person name">' +
        "			                                            </div>" +
        "			                                        </div>" +
        "" +
        '			                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 ">' +
        '			                                            <div class="form-group">' +
        '			                                                <label for="inputEmail">Phone No *</label>' +
        '			                                                <input type="number" name="mobile[]" value="" class="form-control contact-person-phone" id="" placeholder="Mobile"> ' +
        "			                                            </div>" +
        "			                                        </div>" +
        '			                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 ">' +
        '			                                            <div class="form-group">' +
        '			                                                <label for="inputEmail">Designation *</label>' +
        '			                                                <input type="text" name="designation[]" value="" class="form-control contact-person-designation" id="" placeholder="Designation">' +
        "			                                            </div>" +
        "			                                        </div>" +
        '			                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 ">' +
        '			                                            <div class="form-group">' +
        '			                                                <label for="inputEmail"></label>' +
        '			                                                <a href="" class="remove_button  btn btn-danger">Remove </a>' +
        "			                                            </div>" +
        "			                                        </div>" +
        "			                                </div>";

    var x = 1; //Initial field counter is 1

    //Once add button is clicked
    $(addButton).click(function () {
        //Check maximum number of input fields
        if (x < maxField) {
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); //Add field html
        }
    });

    //Once remove button is clicked
    $(wrapper).on("click", ".remove_button", function (e) {
        e.preventDefault();
        console.log($(this).closest("div.row.dynamic").remove());
        $(this).parent("div.row").remove(); //Remove field html
        x--; //Decrement field counter
    });
});

$(".add-more-dealer a").click(function (e) {
    e.preventDefault();
    $(".btn-add-dealer").removeClass("d-none");
    $(".btn-update-dealer").addClass("d-none");
    $("#dealer-store-ajax").removeClass("vibrate");
    $(".add-more-dealer").addClass("d-none");
    $("#dealer-store-ajax")[0].reset();
    $('.dynamic').html('');
});
function _show_errors_dealer(data, _this) {

    $("span.text-danger").remove();
    $("span.text-success").remove();
    if (data.customer_type) {
        $('<span class="text-danger">' + data.customer_type[0] + "</span>").insertAfter($('select[name="customer_type"]', _this));
    }
    if (data.allocation) {
        $('input[name="allocation"]').prop('checked', parseInt(data.allocation) > 0 ? true : false );
    }
    if (data.company_name) {
        $('<span class="text-danger">' + data.company_name[0] + "</span>").insertAfter($('input[name="company_name"]', _this));
    }
    if (data.address) {
        $('<span class="text-danger">' + data.address[0] + "</span>").insertAfter($('input[name="address"]', _this));
    }
    if (data.pincode) {
        $('<span class="text-danger">' + data.pincode[0] + "</span>").insertAfter($('input[name="pincode"]', _this));
    }
    if (data.city) {
       // alert(data.city);
        $('<span class="text-danger">' + data.city[0] + "</span>").insertAfter($('select[name="city"]', _this));
    }
    if (data.state) {
        $('<span class="text-danger">' + data.state[0] + "</span>").insertAfter($('select[name="state"]', _this));
    }
    if (data.gstin) {
        $('<span class="text-danger">' + data.gstin[0] + "</span>").insertAfter($('input[name="gstin"]', _this));
    }
    if (data.contact_person_name) {
        $('<span class="text-danger">' + data.contact_person_name[0] + "</span>").insertAfter($('input[name="contact_person_name"]', _this));
    }
    if (data.mobile) {
        $('<span class="text-danger">' + data.mobile[0] + "</span>").insertAfter($('input[name="mobile"]', _this));
    }
    if (data.email) {
        $('<span class="text-danger">' + data.email[0] + "</span>").insertAfter($('input[name="email"]', _this));
    }
    if (data.cwhatsapp) {
        $('<span class="text-danger">' + data.cwhatsapp[0] + "</span>").insertAfter($('input[name="cwhatsapp"]', _this));
    }
}
function _set_edit_value_dealer(data) {

    $("#dealer-store-ajax").removeClass("vibrate");
    $("#dealer-store-ajax input[name='customer_type']").val(data.customer_type);
    $("#dealer-store-ajax input[name='company_name']").val(data.company_name);
    $("#dealer-store-ajax input[name='address']").val(data.address);
    $("#dealer-store-ajax input[name='address1']").val(data.address1);
    $('input[name="allocation"]').prop('checked', parseInt(data.allocation) > 0 ? true : false );
    $("#dealer-store-ajax input[name='pincode']").val(data.pincode);

    // $("#dealer-store-ajax select[name='city']").val(data.city);
    // $("#dealer-store-ajax select[name='state']").val(data.state);
    $("#dealer-store-ajax input[name='gstin']").val(data.gstin);
   // console.log('ddddd',data);
    
    // $('select[name="city"]').find('option[value=""]').attr("selected",true);
    // $('select[name="state"]').find('option[value=""]').attr("selected",true);
    $('select[name="customer_type"]').val('');
    $('select[name="city"]').val('');
    $('select[name="state"]').val('');

    $('select[name="city"]').val(data.city);
    $('select[name="state"]').val(data.state);
    
    $('input[name="cwhatsapp"]').val( data.cwhatsapp );
    $('select[name="customer_type"]').val(data.customer_type);

    //$('select[name="state"]').find('option[value="'+data.state+'"]').attr("selected",true);
    $('select[name="customer_type"]').find('option[value="'+data.customer_type+'"]').attr("selected",true);

    let type = data.customer_type;
        if(type==2){
            global_dealer_type = type;
            $("#dealer-store-ajax input[name='gstin']").prop('disabled',true);
            $("#dealer-store-ajax .contact-person-designation").prop('disabled',true);
        }else{
            $("#dealer-store-ajax input[name='gstin']").prop('disabled',false);
            $("#dealer-store-ajax .contact-person-designation").prop('disabled',false);
            global_dealer_type = type;
        }    


    let name = JSON.parse(data.contact_person_name);
    console.log(name);
    let mobile = JSON.parse(data.mobile);
    let designation = JSON.parse(data.designation);
    let wrapper = $(".field_wrapper");
    let no_value = "x";
    $(wrapper).html('');
    var fieldHTML;
    $.each(name, function(index, val) {
        //debugger;
        let designation_v ="";
        if(designation != null){
            designation_v = designation[index];
        }
    	fieldHTML ='<div class="row dynamic">' +
        '			                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 ">' +
        '			                                            <div class="form-group">' +
        '			                                                <label for="inputEmail">Contact Persion Name *</label>' +
        '			                                                <input type="text" name="contact_person_name[]" value="'+val+'" class="form-control contact-person-name" id="" placeholder="Contact person name">' +
        "			                                            </div>" +
        "			                                        </div>" +
        "" +
        '			                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 ">' +
        '			                                            <div class="form-group">' +
        '			                                                <label for="inputEmail">Phone No *</label>' +
        '			                                                <input type="number" name="mobile[]" value="'+mobile[index]+'" class="form-control contact-person-phone" id="" placeholder="Mobile"> ' +
        "			                                            </div>" +
        "			                                        </div>" +
        '			                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 ">' +
        '			                                            <div class="form-group">' +
        '			                                                <label for="inputEmail">Designation *</label>' +
        '			                                                <input type="text" name="designation[]" value="'+designation_v+'" class="form-control contact-person-designation" id="" placeholder="Designation">' +
        "			                                            </div>" +
        "			                                        </div>" ;
        if(index !=0){
        fieldHTML +='			                                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 ">' +
        '			                                            <div class="form-group">' +
        '			                                                <label for="inputEmail"></label>' +
        '			                                                <a href="" class="remove_button btn btn-danger">Remove </a>' +
        "			                                            </div>" +
        "			                                        </div>" ;
        }
        "			                                </div>";
        //fieldHTML  = 'xs';
		$(wrapper).append(fieldHTML);   
        console.log(fieldHTML);

          
    });

    $("#dealer-store-ajax input[name='contact_person_name']").val(data.contact_person_name);
    $("#dealer-store-ajax input[name='mobile']").val(data.mobile);
    $("#dealer-store-ajax input[name='email']").val(data.email);

    $(".btn-add-dealer").addClass("d-none");
    $(".btn-update-dealer").removeClass("d-none");
    $("#dealer-store-ajax").addClass("vibrate");
    $(".add-more-dealer").removeClass("d-none");

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
