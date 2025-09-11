var Global_item_serial_no = 0;
var Global_default_gst = "UTTAR PRADESH"; //$("#default_gst").html().substring(0, 2);
var Global_client_gst = "UTTAR PRADESH";
var Global_tax_apply = 0;
var uttar_pradesh_code = 24;
var global_client_value = "";

//for refresh first selected gst
// alert();
$(function () {
    $(".main-gst-selection").change();
    setGstDefaultValue();
    //alert(attr);
});

$("body").on("change", ".main-gst-selection", function () {
    let id = $(this).val();
    $.ajax({
        url: "/admin/gst/" + id,
        type: "GET",
        dataType: "json",
    })
        .done(function (response) {
            // console.log(response.type);
            // console.log(response);
            setGstDefaultValue();

            // debugger;

            if (response.type == "permanent") {
                $("#udyam_no").html("");
                $("#temp").html("Udyam Reg. No. :");
                $("#udyam_no").html(response.udyam_reg_no);
            } else {
                $("#udyam_no").html("");
                $("#temp").html("Temp Gst :");
                $("#udyam_no").html("" + response.gstin);
            }
            if (response.head) {
                let head = JSON.parse(response.head);
                $(".gst-head-ul").html(``);
                $.each(head, function (index, val) {
                    $(".gst-head-ul").append(`<li>${val}</li>`);
                });
                // $("#udyam_no").html(response.udyam_reg_no);
                $("#head_office").html(response.head_office);
                // alert(response.branch_office);
                $("#branch_office").html(response.branch_office);
                if (response.temp_address) {
                    $("#temp_address").html("Temp Address : " + response.temp_address);
                } else {
                    $("#temp_address").html("");
                }
                $("#head_mobile").html(response.mobile);
                $("#head_email").html(response.email);
            }
        })
        .fail(function (e) {
            console.log("error", e);
        })
        .always(function () {
            console.log("complete");
        });
});

$("#unique_id").change(function () {
    var base_url = $('meta[name="base_url"]').attr("content");
    window.location = base_url + "/admin/pitch/" + $(this).val();
});

$("#quotation_unique_id").change(function () {
    var base_url = $('meta[name="base_url"]').attr("content");
    window.location = base_url + "/admin/quotation/" + $(this).val();
});
$("#inquiry_unique_id").change(function () {
    var base_url = $('meta[name="base_url"]').attr("content");
    window.location = base_url + "/admin/inquiry/" + $(this).val() + "/edit";
});
        $(document).ready(function () {
            $("#change_billing_type").html(capitalize($("#invoice_type").val()));
        });
       $("#invoice_type").change(function () {
            var code = $(this).val().substring(0, 2).toUpperCase();
            var default_invoice_no = $("#default-invoice-no").text();
            $("#footer_invoice_type").html($(this).val());
            $("#change_billing_type").html(capitalize($(this).val()));

            // Ajax request to get totalInvoice
            $.ajax({
                type: 'get',
                url: 'https://techdost.in/rainbow/admin/invoice/create',
                data: {
                    invoice_type: $(this).val()
                },
                success: function (response) {
                    // Display the totalInvoice count in the specified <span> element
                    $("#total-invoice-count").text(response.totalInvoice);
                    
                    // Append the totalInvoice count to the invoice_no variable
                    final_code_with_count = default_invoice_no.replace("X", code).trim() + (response.totalInvoice + 1);

                    // Update the hidden input and display element with the new invoice_no
                    $("#invoice_no_hidden").val(final_code_with_count);
                    $("#invoice_no_display").text(final_code_with_count);
                },
                error: function (error) {
                    console.log('Error:', error);
                }
            });
        });




function capitalize(str) {
    return str.replace(/^\w/, (s) => s.toUpperCase());
}

$(".select-2").select2();

$(".btn-submit").click(function (e) {
    e.preventDefault();


    if ($("input[name='billing_date']").val() == "") {
        swal("Billing Date !", "Billing Date is required", "error", {
            button: "Ok!",
        });
        return false;
    }
    if ($("input[name='prate[]']").val() == 0) {
        swal("Rate!", "Rate is required", "error", {
            button: "Ok!",
        });
        return false;
    }
    if ($("input[name='event_date']").val() == "") {
        swal("Event Date !", "Event Date is required", "error", {
            button: "Ok!",
        });
        return false;
    }

    if ($("select[name='gst_id']").val() == "") {
        swal("Gst !", "Please select Gst", "error", {
            button: "Ok!",
        });
        return false;
    }
    if ($("input[name='cpincode[]']").val() == "") {
        swal("Customer !", "Please select any one Customer", "error", {
            button: "Ok!",
        });
    }

    var page_name = $('meta[name="page"]').attr("content");

    if (page_name != "quotation") {
        if ($('input[name="customer_id"]').val() == "0") {
        } else {
            if ($(".invoice-customer-type").val() == null) {
                swal("Customer !", "Please select Customer ", "error", {
                    button: "Ok!",
                });
                return false;
            }
        }
    }
    if ($(".invoice-delivery-address").val() == "") {
        swal("Delivery !", "Please select Delivery Address ", "error", {
            button: "Ok!",
        });
        return false;
    }

    // if($("input[name='amount_in_word']").val() == undefined){
    //     swal("Product !", "Please select any one Product", "error", {
    //         button: "Ok!",
    //     });
    //     return false;
    // }
    //$("input[name='supply_id']").val();
    if ($("input[name='supply_id']").val() == "") {
        swal("Supplier !", "Please select Supply Address", "error", {
            button: "Ok!",
        });
        return false;
    }

    let count_item = 0;
    let count_prate = 0;
    $(".select-item-product").each(function () {
        if ($(this).val() == "") {
            count_item++;
        }
    });
    $("input[name='prate[]']").each(function () {
        if ($(this).val() == 0) {
            count_prate++;
        }
    });

    if (count_prate > 0) {
        swal("Rate!", "Rate is required", "error", {
            button: "Ok!",
        });
        return false;
    }
    if (count_item > 0) {
        swal("Item !", "Please select Item ", "error", {
            button: "Ok!",
        });
        return false;
    }
    $("#invoice-submit").submit();
});

var baseUrl = $("meta[name=base_url]").attr("content");

$("form").on("focus", "input[type=number]", function (e) {
    $(this).on("wheel.disableScroll", function (e) {
        e.preventDefault();
    });
});

$("form").on("blur", "input[type=number]", function (e) {
    $(this).off("wheel.disableScroll");
});

$("input[type=number]").on("focus", function () {
    $(this).on("keydown", function (event) {
        if (event.keyCode === 38 || event.keyCode === 40) {
            event.preventDefault();
        }
    });
});

$("#compition").click(function (e) {
    //e.preventDefault();
    // $('input[name="customer_type"]').change();
    let   compition = 0;
    let customer_type = $('input[name="customer_type"]:checked').val();
    if($("#compition").is(":checked")){
         compition = $("#compition").val();    
    }
    //let customer_type = $('input[name="customer_type"]:checked').val();

    var baseUrl = $("meta[name=base_url]").attr("content");
    url = baseUrl + "/admin/fetch/customers/" + customer_type+'/'+compition;
    //alert(url);
    // alert(url);
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
    })
    .done(function (success) {
        console.log(success);
        $(".invoice-customer-type").html(success.option);
        $("#cp_type").text(success.type);
    })
    .fail(function (e) {
        console.log("error", e);
    });


});

$('input[name="customer_type"]').change(function (e) {
    var customer_type = $(this).val();
    var compition = 0;
    if(customer_type==2){
        $("#compition").prop('checked',false);
    }
    if($("#compition").is(":checked")){
        var compition = $("#compition").val();    
    }
    // alert(compition);   
    // return false;
    // var customer_type = $(this).val();
    if(customer_type == 2){
        $('input[name="cgstin"]').removeAttr('required');
        $('input[name="cgstin"]').removeClass('mandatory');
        $('input[name="cgstin"]').attr('disabled', true);
        // $("input").prop('disabled', true);
    }else{
        $('input[name="cgstin"]').prop('required',true);
        $('input[name="cgstin"]').addClass('mandatory');
        $('input[name="cgstin"]').attr('disabled', false);
    }

                
                let dynamic_option_city = $("#get_pre_city").html();
                let dynamic_option_state = $("#get_pre_state").html();
                $("input[name='caddress']").val("");
                //ccity-div 8439129846

                $(".ccity-div").html("");

                $(".ccity-div").html("<select class='select-2' name='ccity' class='custom-pincode' >" + dynamic_option_city + "</select>");
                $(".cstate-div").html("<select class='select-2' name='cstate'>" + dynamic_option_state + "</select>");

                //$("#company_name").show();
                // $('.select-2').val('');
                $(".select-2").select2();

                $("input[name='ccity']").val("");
                $("input[name='caddress1']").val("");

                $("input[name='cstate']").val("");
                $("input[name='cpincode']").val("");
                $("input[name='cemail']").val("");
                $("input[name='clandmark']").val("");
                // $("input[name='cgstin']").val("");
                $("input[name='contact_person_c']").val("");
                $("input[name='customer_id']").val("0");
                $("input[name='cmobile']").val("");
                $(".contact-person").html("");
                $(".contact-person").html('<input type="text" name="contact_person_c"  value="">');
                $("input[name='dstate']").val("");
                $("input[name='dpincode']").val("");
                $("input[name='dmobile']").val("");
                $("input[name='dcity']").val("");
                $("input[name='dperson']").val("");
                $("input[name='dlandmark']").val("");
                $("input[name='daddress']").val("");
                $("input[name='daddress1']").val("");
                $("input[name='delivery_id']").val("");
                $("input[name='creadyness']").val("");
                $("input[name='remark']").val("");
                $("input[name='cwhatsapp']").val("");
                // $('select').prop('selectedIndex',0);
                // $("input[type=date]").val("")
                $(".history-btn").hide();

                $('input[name="qty[]"]').val('');
                $('input[name="days[]"]').val('');
                // $('input').val('');
                //$('form')[0].reset();


    // global_client_value = customer_type;
    var baseUrl = $("meta[name=base_url]").attr("content");
    url = baseUrl + "/admin/fetch/customers/" + customer_type+'/'+compition;
    //alert(url);
    // alert(url);
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
    })
        .done(function (success) {
            console.log(success);
            $(".invoice-customer-type").html(success.option);
            $("#cp_type").text(success.type);
        })
        .fail(function (e) {
            console.log("error", e);
        });
});

let global_cphone = [];



$(".invoice-customer-type").change(function () {
    var user_id = $(this).val();

    url = baseUrl + "/admin/fetch/customer/details/" + user_id;
    //alert(url);
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
    })
        .done(function (success) {
               console.log('new v2',success);
            $("#company_name").hide();
            //console.log("okdd", success.gstin);
            if (user_id == "other") {
                let dynamic_option_city = $("#get_pre_city").html();
                let dynamic_option_state = $("#get_pre_state").html();
                $("input[name='caddress']").val("");
                //ccity-div 8439129846
                $(".history-btn").hide();
                $(".ccity-div").html("");

                $(".ccity-div").html("<select class='select-2' name='ccity' class='custom-pincode' >" + dynamic_option_city + "</select>");
                $(".cstate-div").html("<select class='select-2' name='cstate'>" + dynamic_option_state + "</select>");

                $("#company_name").show();

                $(".select-2").select2();
                $("input[name='ccity']").val("");

                $("input[name='cstate']").val("");
                $("input[name='cpincode']").val("");
                $("input[name='cemail']").val("");
                $("input[name='clandmark']").val("");
                $("input[name='cgstin']").val("");
                $("input[name='contact_person_c']").val("");
                $("input[name='customer_id']").val("0");
                $("input[name='cmobile']").val("");
                $("input[name='cwhatsapp']").val("");
                $("input[name='creadyness']").val("");
                $(".contact-person").html("");
                $(".contact-person").html('<input type="text" name="contact_person_c"  value="">');
            } else {
                $(".ccity-div").html("");
                $(".ccity-div").html('<input type="text" name="ccity" class="custom-pincode" value="">');

                $(".cstate-div").html("");
                $(".cstate-div").html('<input type="text" name="cstate" class="custom-state" value="">');
            }

            Global_client_gst = success.state != null ? success.state.state.toLowerCase() : "";

            console.log("testing+", Global_client_gst);

            $("input[name='customer_id']").val(success.id);

            $("input[name='caddress']").val(success.address);
            $("input[name='caddress1']").val(success.address1);
            // alert(success.state);
            $("input[name='ccity']").val(success.city.city);
            //console.log('xsdkdk',( success.state != null )  ? success.state.state.toLowerCase() : '');
            $("input[name='cstate']").val(success.state != null ? success.state.state.toLowerCase() : "");
            $("input[name='clandmark']").val(success.landmark);

            $("input[name='cpincode']").val(success.pincode);
            $("input[name='cwhatsapp']").val(success.cwhatsapp);

            //$("input[name='cmobile']").val(success.mobile);
            $("input[name='cemail']").val(success.email);
            //console.log(success)
            $("input[name='cgstin']").val(success.gstin);

            $("#cgstin").html(success.gstin);
            $("#customer_id").val(success.id);
            $("#cemail").html(success.email);
            $("#cmobile").html(success.mobile);
            $("#ccontact-person").html(success.contact_person_name);

            $("#cpincode").html(success.pincode);
            $("#cstate").html(success.state);
            $("#ccity").html(success.city);
            $("#caddress").html(success.address);

            let person_name = JSON.parse(success.contact_person_name);
            let mobile = JSON.parse(success.mobile);
            // console.log("xdd", mobile);

            if (person_name.length > 1) {
                //console.log(person_name);
                alert('we are working...');
                $(".contact-person").html("");
                $(".contact-person").html('<select class="select-two-name" name="contact_person_c" required></select>');
                $(".select-two-name").append(``);
                $(".select-two-name").append(`<option value=''>Please select</option>`);
                global_cphone = mobile;
                $.each(person_name, function (index, val) {
                    $(".select-two-name").append(`<option value="${index}">${val}</option>`);
                });
                $(".select-two-name").select2();
               // $("input[name='cmobile']").val("");
            } else {
                // alert('xd');
                $(".contact-person").html("");
                $(".contact-person").html('<input type="text" name="contact_person_c">');
                $("input[name='contact_person_c']").val(person_name[0]);
                $("input[name='cmobile']").val(mobile[0]);
            }
            $("#customer_mobile").focusout();
        })

        .fail(function () {
            console.log("error");
        });
});

$("body").on("change", ".select-two-name", function () {
    $("input[name='cmobile']").val(global_cphone[$(this).val()]);
    $("#select_two_phone").val(global_cphone[$(this).val()]);
    $("#select_two_name").val($(".select-two-name :selected").text());
    $("#customer_mobile").focusout();
});
    
    $('.history-btn').click(function(){
        $('#show-history-popup').modal('show');
    });

$(".invoice-delivery-address").change(function () {
    var user_id = $(this).val();
    // alert(user_id);
    //$(".venue_name").hide();
    //$("#venue_name").hide();
    if (user_id == "other") {
        // debugger;
        $("input[name='dstate']").val("");
        $("input[name='dpincode']").val("");
        $("input[name='dmobile']").val("");
        $("input[name='dcity']").val("");
        $("input[name='dperson']").val("");
        $("input[name='dlandmark']").val("");
        $("input[name='daddress']").val("");
        $("input[name='daddress1']").val("");
        $("input[name='delivery_id']").val("");
        $(".venue_name").show();
        $("#venue_name").show();

        let dynamic_option_city = $("#get_pre_city").html();
        let dynamic_option_state = $("#get_pre_state").html();

        //$("input[name='caddress']").val("");

        $(".dcity-div").html("");
        $(".dstate-div").html("");

        $(".dcity-div").html("<select class='select-2' name='dcity' class='custom-pincode' >" + dynamic_option_city + "</select>");
        $(".dstate-div").html("<select class='select-2' name='dstate'>" + dynamic_option_state + "</select>");


    } else {
        // $(".venue_name").show();
        $("#venue_name").show();
        //alert('xdd');
        $(".dcity-div").html("");
        $(".dcity-div").html('<input type="text" name="dcity" class="custom-pincode" value="">');

        $(".dstate-div").html("");
        $(".dstate-div").html('<input type="text" name="dstate" class="custom-state" value="">');
    }
    url = baseUrl + "/admin/fetch/delivery/details/" + user_id;
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
    })
        .done(function (success) {
         
            $("#daddress").html(success.address);
            $("#dcity").html(success.city);
            $("input[name='dstate']").val(success.state != null ? success.state.state.toLowerCase() : "");
            $("input[name='dpincode']").val(success.pincode);
            //$("input[name='dmobile']").val(success.mobile);
            $("input[name='dcity']").val(success.city.city);
            // $("input[name='dperson']").val(success.contact_person_name);
            $("input[name='dlandmark']").val(success.landmark);
            $("input[name='daddress']").val(success.address);
            $("input[name='daddress1']").val(success.address1);
            $("input[name='delivery_id']").val(success.id);
            $("#dmobile").html(success.mobile);
            $("#dpincode").html(success.pincode);
            $("#dlandmark").html(success.landmark);
            $("#dperson").html(success.contact_person_name);
            $("#dstate").html(success.state);
        })
        .fail(function () {
            console.log("error");
        });
});

$(".invoice-supply-address").change(function () {
    var user_id = $(this).val();
    url = baseUrl + "/admin/fetch/delivery/details/" + user_id;
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
    })
        .done(function (success) {
            $("input[name='saddress']").val(success.address + ' ' + success.address1);
            $("input[name='supply_id']").val(success.id);
            $("input[name='scity']").val(success.city.city);
            $("input[name='svenue']").val(success.venue);
            $("input[name='smobile']").val(success.mobile);
            $("input[name='spincode']").val(success.pincode);
            $("input[name='slandmark']").val(success.landmark);
            $("input[name='sperson']").val(success.contact_person_name);
            $("input[name='sstate']").val(success.state.state);
            $("input[name='supplyaddress']").val(success.state);

            $("#supplyaddress").html(
                `${success.venue ? success.venue : ''} ${success.address} ${success.address1} ${success.city.city} ${success.state.state}  ${success.pincode}  ${success.landmark == null ? "" : success.landmark} <br/> ${success.contact_person_name == null ? "" : success.contact_person_name}  `
            );
        })
        .fail(function () {
            console.log("error");
        });
});

$(".add-product-btn").click(function () {
    var product_id = $(".select-item-product").val();
    var selected_product_qty = $('input[name="qty"]').val();
    var amount = $('input[name="amount"]').val();
    var day = $('input[name="day"]').val();

    if (validation(product_id, selected_product_qty, amount, day)) {
        return false;
    }

    insertProductList(product_id, selected_product_qty, amount, day);
});

$('body').on('focusin','input',function(){
                this.select();
            });

$('body').on('focusout','input',function(){
    if($(this).val() ==''){
        $(this).val(0);
    }
});

$("body").on("focusout", ".item-gross-total", function () {
    

    var current_value = $(this).val();
    $(this).val(current_value == "" ? 0 : current_value);

    $(".select-item-product").change();
    /* Act on the event */

    var div_gross_total = $(this).parents().closest("tr").children("td.gross-amount");
    var input_gross_total = $(this).parents().closest("tr").children("input.pgros_amount");
    var input_ptax_amount = $(this).parents().closest("tr").children("input.ptax_amount");
    var item_discount_current = $(this).parents().closest("tr").children("td.my-discount").children("input.td-input-width").val();
        item_discount_current = (item_discount_current == undefined) ? 0 : item_discount_current; 
    var div_tax_amount = $(this).parents().closest("tr").children("td.tax-amount");

    var div_total_amount = $(this).parents().closest("tr").children("td.total-amount");

    var this_item_rate = $(this).parent().closest("tr").children("td.item_rate").children("input.td-input-width").val();

    var this_item_pday = $(this).parent().closest("tr").children("td.item_pday").children("input.td-input-width").val();

    var this_item_qty = $(this).parent().closest("tr").children("td.item_qty").children("input.td-input-width").val();
    var input_product_total_amount = $(this).parents().closest("tr").children("input.ptotal_amount");

    $(div_gross_total).text(this_item_rate * this_item_qty * this_item_pday);

    var total_gross_amount = (this_item_rate*this_item_qty*this_item_pday);
    //debugger;
        //debugger;
    if ($('meta[name="page"]').attr("content") == "pitch") {
        $(".select-item-product").change();
        total_gross_amount = Number(total_gross_amount) - Number(item_discount_current);
    }else{
        total_gross_amount = Number(total_gross_amount) - Number(item_discount_current);
    }

    // added code on 5 aug 23
    var tax = parseFloat($(this).closest('td').siblings('.cgst').text());
    tax += parseFloat($(this).closest('td').siblings('.sgst').text());
    if( !tax ) {
        tax = parseFloat($(this).closest('td').siblings('.igst').text());
    }

    var tax_amount = (total_gross_amount * tax) / 100;

    

    // commented code on 5 aug 23
    // console.log('Global_tax_apply',Global_tax_apply);
    // var tax_amount = (total_gross_amount * Global_tax_apply) / 100;

    //debugger;
    //alert(Global_tax_apply);
    $(div_tax_amount).text(tax_amount.toFixed(2));
    //    alert('xd');
    $(input_ptax_amount).val(tax_amount.toFixed(2));
    var grand_total = total_gross_amount + tax_amount;
    $(div_total_amount).text(grand_total.toFixed(2));
    $(input_gross_total).val(total_gross_amount.toFixed(2));
    $(input_product_total_amount).val(grand_total);
    get_item_sum_with_tax();
    $('.item-discount').focusout();
});

$("body").on("focusout", ".pitching-item-gross-total", function () {
    var current_value = $(this).val();
    $(this).val(current_value == "" ? 0 : current_value);

    $(".select-item-product").change();
    /* Act on the event */
    console.l
    var div_gross_total = $(this).parents().closest("tr").children("td.gross-amount");

    var input_gross_total = $(this).parents().closest("tr").children("input.pgros_amount");

    var input_ptax_amount = $(this).parents().closest("tr").children("input.ptax_amount");
    var item_discount_current = $(this).parents().closest("tr").children("td.my-discount").children("input.td-input-width").val();
    console.log("parentt", item_discount_current);
    var div_tax_amount = $(this).parents().closest("tr").children("td.tax-amount");

    var div_total_amount = $(this).parents().closest("tr").children("td.total-amount");

    var this_item_rate = $(this).parent().closest("tr").children("td.item_rate").children("input.td-input-width").val();

    var this_item_pday = $(this).parent().closest("tr").children("td.item_pday").children("input.td-input-width").val();

    var this_item_qty = $(this).parent().closest("tr").children("td.item_qty").children("input.td-input-width").val();
    var input_product_total_amount = $(this).parents().closest("tr").children("input.ptotal_amount");

    $(div_gross_total).text(this_item_rate * this_item_qty * this_item_pday);

    var total_gross_amount = parseInt(this_item_rate) * parseInt(this_item_qty) * parseInt(this_item_pday);

    //debugger;
    if ($('meta[name="page"]').attr("content") == "pitch") {
        $(".select-item-product").change();
        total_gross_amount = parseInt(total_gross_amount) - parseInt(item_discount_current);
    }

    //console.log('globale',Global_tax_apply);

    var tax_amount = (total_gross_amount * Global_tax_apply) / 100;

    //debugger;
    //alert(Global_tax_apply);
    $(div_tax_amount).text(tax_amount.toFixed(2));
    //    alert('xd');
    $(input_ptax_amount).val(tax_amount.toFixed(2));
    var grand_total = total_gross_amount + tax_amount;
    $(div_total_amount).text(grand_total.toFixed(2));
    $(input_gross_total).val(total_gross_amount.toFixed(2));
    $(input_product_total_amount).val(grand_total);
    get_item_sum_with_tax();
});

//$('.item-discount').focusout(function(event) {

$("body").on("focusout", ".item-discount", function () {
    //alert('xdxxxxxxxxx');
    $(".select-item-product").change();
    var div_gross_total = parseInt($(this).parents().closest("tr").children("td.gross-amount").text());
    var div_tax_amount = $(this).parents().closest("tr").children("td.tax-amount");

    var input_product_total_amount = $(this).parents().closest("tr").children("input.ptotal_amount");

    var input_product_ptax_amount = $(this).parents().closest("tr").children("input.ptax_amount");

    var discount_amount = $(this).val();
    var this_item_rate = $(this).parent().closest("tr").children("td.item_rate").children("input.td-input-width").val();
    var div_total_amount = $(this).parents().closest("tr").children("td.total-amount");
    var this_item_pday = $(this).parent().closest("tr").children("td.item_pday").children("input.td-input-width").val();

    var this_item_qty = $(this).parent().closest("tr").children("td.item_qty").children("input.td-input-width").val();

    $(div_gross_total).text(this_item_rate * this_item_qty * this_item_pday);
    // alert(discount_amount);
    var total_gross_amount = this_item_rate * this_item_qty * this_item_pday;
    //alert(total_gross_amount);
    if (total_gross_amount < discount_amount) {
        swal("Invalid Discount !", "Discount amount can't be greater than gross amount,", "error", {
            button: "Ok!",
        });
        $(this).val(0);
        return false;
    }
    var total_gross_amount = (this_item_rate * this_item_qty * this_item_pday) - discount_amount;

    //alert(tax_amount);

    //alert('xd');
    //debugger;


    // added on 5 aug
    var tax = parseFloat($(this).closest('td').siblings('.cgst').text());
    tax += parseFloat($(this).closest('td').siblings('.sgst').text());
    if( !tax ) {
        tax = parseFloat($(this).closest('td').siblings('.igst').text());
    }

    var tax_amount = (total_gross_amount * tax) / 100;

    // removed on 5 aug
    // var tax_amount = (total_gross_amount * Global_tax_apply) / 100;

    //alert(tax_amount);
    //debugger;
    // alert(Global_tax_apply);
    $(div_tax_amount).text(tax_amount);
    $(div_total_amount).text((total_gross_amount + tax_amount).toFixed(2));
    $(input_product_total_amount).val(total_gross_amount + tax_amount);
    $(input_product_ptax_amount).val(tax_amount);
    get_item_sum_with_tax();

    // debugger;
});

$("body").on("change", ".select-item-product", function () {
    var product_id = $(this).val();
    // console.log("select item calling");

    var div_sgt = $(this).parents().closest("tr").children("td.sgst");
    var div_igst = $(this).parents().closest("tr").children("td.igst");
    var div_cgst = $(this).parents().closest("tr").children("td.cgst");

    var input_sgt = $(this).parents().closest("tr").children("input.sgst");
    var input_igst = $(this).parents().closest("tr").children("input.igst");
    var input_cgst = $(this).parents().closest("tr").children("input.cgst");

    var input_phsn = $(this).parents().closest("tr").children("input.phsn");
    var div_input_phsn = $(this).parents().closest("tr").children("td.hsn");

     var input_psac = $(this).parents().closest("tr").children("input.psac");
    var div_input_psac = $(this).parents().closest("tr").children("td.sac");

    var input_pdescription = $(this).parents().closest("tr").children("input.pdescription");
    var input_pname = $(this).parents().closest("tr").children("input.pname");
    var input_item_display = $(this).parents().closest("tr").children("td.item-display");
    // console.log('phsnxx',$(this).parents().closest("tr").children("td.hsn"));
    // console.log('div_sgt--',div_input_phsn);

    url = baseUrl + "/admin/fetch/product/details/" + product_id;
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
    })
        .done(function (product) {
            // console.log(product);
            $(input_psac).val(product.hsn);
            $(div_input_psac).text(product.hsn);
            $(input_phsn).val(product.sac);
            $(div_input_phsn).text(product.sac);
            $(input_pname).val(product.name);
            $(input_pdescription).val(product.description);
            $(input_pdescription).val(product.description);
            $(input_item_display).text(product.description);

            let the_client_name = $(".invoice-customer-type option:selected").text().trim();

            if (the_client_name == "Other") {
                Global_client_gst = $('select[name="cstate"]').val();
            } else {
                Global_client_gst = $('input[name="cstate"]').val();
               // console.log("global client", Global_client_gst.toLowerCase());
            }

            //console.log("Global_default_gst client", Global_default_gst.toLowerCase());
            // console.log("Global_default_gst ", Global_default_gst.toLowerCase());
            // if($(el).not("select"))

            // alert(Global_client_gst);
            // alert(Global_default_gst);

            if (Global_client_gst.toLowerCase() != Global_default_gst.toLowerCase()) {
                ///alert(Global_client_gst);
                //alert(Global_default_gst.toLowerCase());
//                console.log("deafault gst", Global_default_gst.toLowerCase());
                //console.log(" gst", Global_client_gst);

                $(div_sgt).text(0);
                $(div_cgst).text(0);
                $(div_igst).text(product.igst);

                $(input_sgt).val(0);
                $(input_cgst).val(0);
                $(input_igst).val(product.igst);

                //console.log('samegst');
                Global_tax_apply = parseInt(product.igst);
            } else {
                $(div_sgt).text(product.sgst);
                $(div_cgst).text(product.cgst);
                $(div_igst).text(0);

                $(input_sgt).val(product.sgst);
                $(input_cgst).val(product.cgst);
                $(input_igst).val(0);
                //console.log('samegst-dd-d');
                Global_tax_apply = parseInt(product.cgst) + parseInt(product.sgst);
            }
        })
        .fail(function (error) {
            //console.log("error", error);
        });
});

function insertProductList(product_id, selected_product_qty, amount, day) {
    Global_item_serial_no++;
    url = baseUrl + "/admin/fetch/product/details/" + product_id;
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
    })
        .done(function (product) {
            //alert(selected_product_qty);
            //  var myvar = '';

            var myvar =
                '<tr  class="center item ">' +
                '<td class="space">' +
                Global_item_serial_no +
                '<span class="remove-btn">X</span></td>' +
                "" +
                '<td class="sac">' +
                product.sac +
                '</td><input type="hidden" name="psac[]" value="' +
                product.sac +
                '<td class="hsn">' +
                product.hsn +
                '</td><input type="hidden" name="phsn[]" value="' +
                product.hsn +
                '"><input type="hidden" name="item_id[]" value="' +
                product.id +
                '">' +
                "<td > " +
                product.description +
                '</td><input type="hidden" name="pdescription[]" value="' +
                product.description +
                '">' +
                '<td class="item">' +
                product.name +
                '</td><input type="hidden" name="pname[]" value="' +
                product.name +
                '">' +
                "<td>" +
                amount +
                '</td><input type="hidden" name="prate[]" value="' +
                amount +
                '">' +
                "<td>" +
                selected_product_qty +
                "</td>" +
                "<td>" +
                day +
                '</td><input type="hidden" name="pday[]" value="' +
                day +
                '">' +
                '<td class="gross-amount">' +
                day * selected_product_qty * amount +
                "</td><td>D</td>";

            var gross_total_amount = parseFloat(day * selected_product_qty * amount);

            var gst = parseFloat(product.cgst) + parseFloat(product.sgst);
            var tax_amount = (gross_total_amount * gst) / 100;

            if (Global_client_gst == Global_default_gst.toLowerCase()) {
                var same =
                    "                            <td>" +
                    product.cgst +
                    '</td><input type="hidden" name="cgst[]" value="' +
                    product.cgst +
                    '">' +
                    "                            <td>" +
                    product.sgst +
                    '</td><input type="hidden" name="sgst[]" value="' +
                    product.sgst +
                    '">' +
                    '                            <td>0</td> <input type="hidden" name="igst[]" value="0">';
            } else {
                var same =
                    '   <td>0</td><input type="hidden" name="cgst[]" value="0">' +
                    '  <td>0</td><input type="hidden" name="sgst[]" value="0">' +
                    "                            <td>" +
                    product.igst +
                    '</td><input type="hidden" name="igst[]" value="' +
                    product.igst +
                    '">';
            }

            var other =
                ' <td class="tax-amount">' +
                tax_amount +
                "</td>" +
                '                            <td class="total-amount">' +
                (parseFloat(gross_total_amount) + parseFloat(tax_amount)) +
                '</td><input type="hidden" name="pqty[]" value="' +
                selected_product_qty +
                '"><input type="hidden" name="pgros_amount[]" value="' +
                gross_total_amount +
                '"><input type="hidden" name="ptax_amount[]" value="' +
                tax_amount +
                '">' +
                "</tr>";
            var contact = myvar + same + other;

            $(contact).insertBefore(".bottom-footer-tr");
            get_item_sum_with_tax();
            _reset();
        })
        .fail(function (error) {
            console.log("error", error);
        });
}

$("body").on("click", ".remove-btn", function () {
    $(this).closest("tr").remove();
    get_item_sum_with_tax();
});

function _reset() {
    //$("input").val("");
    $('input[name="qty"]').val("");
    $('input[name="amount"]').val("");
    $('input[name="day"]').val("");
    $(".select-item-product").val(null).trigger("change");
}

function create_input(input_name, value, placement) {
    $("<input type='hidden' name='" + input_name + "' value='" + value + "'>").insertAfter("#" + placement);
}

function get_item_sum_with_tax() {
    var tax_sum = 0;
    var grand_sum = 0;
    var gross_sum = 0;
    var net_discount = 0;
   // debugger;
    $("td.tax-amount").each(function () {
        tax_sum += isNaN(parseFloat($(this).text())) ? 0 : parseFloat($(this).text());
    });
    $("td.total-amount").each(function () {
        grand_sum += isNaN(parseFloat($(this).text())) ? 0 : parseFloat($(this).text());
    });

    $("td.gross-amount").each(function () {
        gross_sum += isNaN(parseFloat($(this).text())) ? 0 : parseFloat($(this).text());
    });

    $('input[type="number"].item-discount').each(function () {
        net_discount += isNaN(parseFloat($(this).text())) ? 0 : parseFloat($(this).text());
    });

    //alert(gross_sum);
    $("#display-total-tax-amount").text(tax_sum.toFixed(2));

    $("#total_tax_amount").val(tax_sum.toFixed(2));

    $("#display-grand-amount").text(grand_sum.toFixed(2));
    $("#total_grand_amount").val(grand_sum.toFixed(2));

    $("#total_net_discount").val(net_discount.toFixed(2));
    //$("#total_net_discount").text(net_discount.toFixed(2));

    $("#display-gross-total-amount").text(gross_sum.toFixed(2));
    $("#total_gross_sum").val(gross_sum.toFixed(2));
    // console.log(tax_sum);
    $("#amountinword").html(numToWord(parseInt(grand_sum.toFixed(2))));
    $("#amount_in_words").val(numToWord(parseInt(grand_sum.toFixed(2))));
    // create_input("amount_in_word", numToWord(parseInt(grand_sum)), "amountinword");
}

function setGstDefaultValue(){
    let attr = $('.main-gst-selection').find('option:selected').attr('data-state');
    // debugger;
    if( attr  == 24 ){
            Global_default_gst = 'UTTAR PRADESH';
    }else{
            Global_default_gst = 'Delhi';  
    }

    $('.select-item-product').change();
    
    //console.log(setGstDefaultValue());
}

// change_billing_type

function validation(product_id, selected_product_qty, amount, day) {
    if (product_id == "") {
        swal("Product !", "Please Select Product!", "error", {
            button: "Ok!",
        });
        return true;
    }

    if (amount == "" || amount <= 0) {
        swal("Amount !", "Invalid Amount", "error", {
            button: "Ok!",
        });
        return true;
    }
    if (day == "" || day <= 0) {
        swal("Amount !", "Invalid Day", "error", {
            button: "Ok!",
        });
        return true;
    }
}

const numToWordObj = {
    0: "zero",
    1: "one",
    2: "two",
    3: "three",
    4: "four",
    5: "five",
    6: "six",
    7: "seven",
    8: "eight",
    9: "nine",
    10: "ten",
    11: "eleven",
    12: "twelve",
    13: "thirteen",
    14: "fourteen",
    15: "fifteen",
    16: "sixteen",
    17: "seventeen",
    18: "eighteen",
    19: "nineteen",
    20: "twenty",
    30: "thirty",
    40: "forty",
    50: "fifty",
    60: "sixty",
    70: "seventy",
    80: "eighty",
    90: "ninety",
};

const placement = {
    100: " hundred",
    1000: " thousand",
    1000000: " million",
    1000000000000: " trillion",
};

const numToWord = (num) => {
    const limiter = (val) => num < val;
    const limiterIndex = Object.keys(placement).findIndex(limiter);
    const limiterKey = Object.keys(placement)[limiterIndex];
    const limiterVal = Object.values(placement)[limiterIndex - 1];
    const limiterMod = Object.keys(placement)[limiterIndex - 1];

    if (numToWordObj[num]) {
        return numToWordObj[num];
    }
    if (num < 100) {
        let whole = Math.floor(num / 10) * 10;
        let part = num % 10;
        return numToWordObj[whole] + " " + numToWordObj[part];
    }

    if (num < limiterKey) {
        let whole = Math.floor(num / limiterMod);
        let part = num % limiterMod;
        if (part === 0) {
            return numToWord(whole) + limiterVal;
        } else {
            return numToWord(whole) + limiterVal + " and " + numToWord(part);
        }
    }
};
