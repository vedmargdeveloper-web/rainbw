var Global_item_serial_no = 0;
var Global_default_gst = "UTTAR PRADESH"; //$("#default_gst").html().substring(0, 2);
var Global_client_gst = "UTTAR PRADESH";
var Global_tax_apply = 0;
var tax_calculated = true;

//for refresh first selected gst


$(function(){
    $('.main-gst-selection').change();
    setGstDefaultValue();
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
                setGstDefaultValue();
            // console.log(response);
            if(response.type == 'permanent'){
                $('#udyam_no').html('');
                $('#temp').html('Udyam Reg. No. :');
                $("#udyam_no").html(response.udyam_reg_no);
            }else{
                $('#udyam_no').html('');
                $('#temp').html('Temp Gst :');
                $('#udyam_no').html(''+response.gstin);
            }
            if(response.head){
                let head = JSON.parse(response.head);
                $('.gst-head-ul').html(``);
            $.each(head, function(index, val) {
                 $('.gst-head-ul').append(`<li>${val}</li>`);
            });
           // $("#udyam_no").html(response.udyam_reg_no);
            $("#head_office").html(response.head_office);
            // alert(response.branch_office);
            $("#branch_office").html(response.branch_office);
            if(response.temp_address){
                
                $("#temp_address").html('Temp Address : '+ response.temp_address);

            }else{
                $("#temp_address").html('');
                
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

$('#booking_unique_id').change(function() {
        var base_url  =  $('meta[name="base_url"]').attr('content');
        window.location =  base_url+'/admin/booking/'+ $(this).val();
});

$('#unique_id').change(function() {
        var base_url  =  $('meta[name="base_url"]').attr('content');
        window.location =  base_url+'/admin/pitch/'+ $(this).val();
});

$("#invoice_type").change(function () {
    
    var code = $(this).val().substring(0, 2).toUpperCase();
    var invoice_no = $("#default-invoice-no").text();
    //alert(invoice_no);
    $("#footer_invoice_type").html($(this).val());
    $("#change_billing_type").html(capitalize($(this).val() ));

    final_code = invoice_no.replace("X", code);
    $("#invoice_no").text(final_code);
    $("input[name='invoice_no']").text(final_code);
    //$("#invoice_no").text(final_code);
    //alert(final_code);
});
function capitalize( str ){
    return str.replace(/^\w/, (s) => s.toUpperCase() );
}

$(".select-2").select2();

$(".btn-submit").click(function (e) {
    e.preventDefault();
    
    let booking_typenew =$("select[name='booking_type']").val();

    if(booking_typenew == ''){
        swal("Booking Type !", "Booking Type is required", "error", {
            button: "Ok!",
        });
        return false;
    }
    
    if ($("input[name='billing_date']").val() == '') {
        swal("Booking Date !", "Booking Date is required", "error", {
            button: "Ok!",
        });
        return false;
    }


    if ($("input[name='event_date']").val() == '') {
        swal("Event Date !", "Event Date is required", "error", {
            button: "Ok!",
        });
        return false;
    }

    if ($("select[name='gst_id']").val() == '') {
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
    

    if($('input[name="customer_id"]').val() == '0'){
        
    }
    else{
        
        //  if ($(".invoice-customer-type").val() == null) {
        // swal("Customer !", "Please select Customer ", "error", {
        //     button: "Ok!",
        // });
        // return false;
    }
     
    
       if($(".invoice-delivery-address").val() == "") {
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
    $(".select-item-product").each(function () {
        if ($(this).val() == "") {
            count_item++;
        }
    });
    if (count_item > 0) {
        swal("Item !", "Please select Item ", "error", {
            button: "Ok!",
        });
        return false;
    }

   // alert('submit');

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

$('input[name="customer_type"]').change(function (e) {
    var customer_type = $(this).val();
    var baseUrl = $("meta[name=base_url]").attr("content");
    url = baseUrl + "/admin/fetch/customers/" + customer_type;
    // /alert(url);
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
    })
        .done(function (success) {
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
    $.ajax({
        url: url,
        type: "GET",
        dataType: "json",
    })
        .done(function (success) {
            //console.log('relatin',success);
            $("#company_name").hide();
            console.log('okdd',success.gstin);
        if(user_id == 'other'){
             let dynamic_option_city = $("#get_pre_city").html();
             let dynamic_option_state = $("#get_pre_state").html();
             $("input[name='caddress']").val(''); 
             //ccity-div 8439129846 
             
             $(".ccity-div").html(""); 
             
             $(".ccity-div").html("<select class='select-2' name='ccity' class='custom-pincode' >"+dynamic_option_city+"</select>");  
             $(".cstate-div").html("<select class='select-2' name='cstate'>"+dynamic_option_state+"</select>");  

             $("#company_name").show();

             $('.select-2').select2();
             $("input[name='ccity']").val('');   
             
             $("input[name='cstate']").val('');   
             $("input[name='cpincode']").val('');   
             $("input[name='cemail']").val('');   
             $("input[name='clandmark']").val('');   
             $("input[name='cgstin']").val('');   
             $("input[name='contact_person_c']").val('');
             $("input[name='customer_id']").val('0'); 
             $("input[name='cmobile']").val('');   
             $(".contact-person").html(""); 
             $(".contact-person").html('<input type="text" name="contact_person_c"  value="">');
        } else{
            $(".ccity-div").html(""); 
            $(".ccity-div").html('<input type="text" name="ccity" class="custom-pincode" value="">');

            $(".cstate-div").html(""); 
            $(".cstate-div").html('<input type="text" name="cstate" class="custom-state" value="">');
        }             
        
            Global_client_gst = ( success.state != null )  ? success.state.state.toLowerCase() : '';
            
            console.log('testing+',Global_client_gst);
            
            $("input[name='customer_id']").val(success.id);

            $("input[name='caddress']").val(success.address);
            $("input[name='caddress1']").val(success.address1);
             console.log(success);
            $("input[name='ccity']").val(success.city.city);
            //console.log('xsdkdk',( success.state != null )  ? success.state.state.toLowerCase() : '');
            $("input[name='cstate']").val(( success.state != null )  ? success.state.state.toLowerCase() : '');
            $("input[name='clandmark']").val(success.landmark);

            $("input[name='cpincode']").val(success.pincode);

            $("input[name='cmobile']").val(success.mobile);
            $("input[name='cemail']").val(success.email);
            //console.log(success)
            $("input[name='cgstin']").val(success.gstin);

            $("#cgstin").html(success.gstin);
            $("#customer_id").val(success.id);
            $("#cemail").html(success.email);
            // $("#cmobile").html(success.mobile);
            $("#ccontact-person").html(success.contact_person_name);

            $("#cpincode").html(success.pincode);
            $("#cstate").html(success.state);
            $("#ccity").html(success.city);
            $("#caddress").html(success.address);
            
            let person_name = JSON.parse(success.contact_person_name);
            let mobile = JSON.parse(success.mobile);
            console.log("xdd", person_name);


            if (person_name.length > 1) {
                //console.log(person_name);
                $(".contact-person").html("");
                $(".contact-person").html('<select class="select-two-name" name="contact_person_c"></select>');
                $(".select-two-name").append(``);
                $(".select-two-name").append(`<option value=''>Please select</option>`);
                global_cphone = mobile;
                $.each(person_name, function (index, val) {
                    $(".select-two-name").append(`<option value="${index}">${val}</option>`);
                });

                $(".select-two-name").select2();
                $("input[name='cmobile']").val('');
            } else {
                // alert('xd');
                $(".contact-person").html("");
                $(".contact-person").html('<input type="text" name="contact_person_c">');
                $("input[name='contact_person_c']").val(person_name[0]);
                $("input[name='cmobile']").val(mobile[0]);
            }
        })

        .fail(function () {
            console.log("error");
        });
});

$("body").on("change", ".select-two-name", function () {
    //alert();
    //alert($('.select-two-name :selected').text());
    $("input[name='cmobile']").val(global_cphone[$(this).val()]);
    $("#select_two_phone").val(global_cphone[$(this).val()]);
    $("#select_two_name").val($('.select-two-name :selected').text());
});

$(".invoice-delivery-address").change(function () {
    var user_id = $(this).val();
    $(".venue_name").hide();
    $("#venue_name").hide();
    if(user_id == 'other'){
            $("input[name='dstate']").val('');
            $("input[name='dpincode']").val('');
            $("input[name='dmobile']").val('');
            $("input[name='dcity']").val('');
            $("input[name='dperson']").val('');
            $("input[name='dlandmark']").val('');
            $("input[name='daddress']").val('');
            $("input[name='daddress1']").val('');
            $("input[name='delivery_id']").val('');
            
            $(".venue_name").show();
            $("#venue_name").show();

            let dynamic_option_city = $("#get_pre_city").html();
            let dynamic_option_state = $("#get_pre_state").html();
            
            $("input[name='caddress']").val(''); 
             
            $(".dcity-div").html(""); 
            $(".dstate-div").html(""); 
             
            $(".dcity-div").html("<select class='select-2' name='dcity' class='custom-pincode' >"+dynamic_option_city+"</select>");  
            $(".dstate-div").html("<select class='select-2' name='dstate'>"+dynamic_option_state+"</select>");  

    }else{

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
            console.log(success);
            $("#daddress").html(success.address);
            $("#dcity").html(success.city);
            $("input[name='dstate']").val(( success.state != null )  ? success.state.state.toLowerCase() : '');
            $("input[name='dpincode']").val(success.pincode);
            $("input[name='dmobile']").val(success.mobile);
            $("input[name='dcity']").val(success.city.city);
            $("input[name='dperson']").val(success.contact_person_name);
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
            $("input[name='saddress']").val(success.address);
            $("input[name='supply_id']").val(success.id);
            $("input[name='scity']").val(success.city.city);
            $("input[name='smobile']").val(success.mobile);
            $("input[name='spincode']").val(success.pincode);
            $("input[name='slandmark']").val(success.landmark);
            $("input[name='sperson']").val(success.contact_person_name);
            $("input[name='sstate']").val(success.state.state);
            $("input[name='supplyaddress']").val(success.state);

            $("#supplyaddress").html(`${success.address}  ${success.city.city} ${success.state.state}  ${success.pincode}  ${success.landmark == null ? '' : success.landmark } <br/> ${ success.contact_person_name == null ? '' : success.contact_person_name }  `);
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

$("body").on("focusout", ".item-gross-total", function () {
    $('.select-item-product').change();
    /* Act on the event */
    var div_gross_total = $(this).parents().closest("tr").children("td.gross-amount");

    var input_gross_total = $(this).parents().closest("tr").children("input.pgros_amount");
    

    var input_ptax_amount = $(this).parents().closest("tr").children("input.ptax_amount");

    var div_tax_amount = $(this).parents().closest("tr").children("td.tax-amount");

    var div_total_amount = $(this).parents().closest("tr").children("td.total-amount");

    var this_item_rate = $(this).parent().closest("tr").children("td.item_rate").children("input.td-input-width").val();

    var this_item_pday = $(this).parent().closest("tr").children("td.item_pday").children("input.td-input-width").val();

    var this_item_qty = $(this).parent().closest("tr").children("td.item_qty").children("input.td-input-width").val();
    var input_product_total_amount = $(this).parents().closest("tr").children("input.ptotal_amount");

    $(div_gross_total).text(this_item_rate * this_item_qty * this_item_pday);

    var total_gross_amount = this_item_rate * this_item_qty * this_item_pday;

   

    var tax_amount = (total_gross_amount * Global_tax_apply) / 100;
    //debugger;

    
   
    if(tax_calculated){
        var grand_total = total_gross_amount + tax_amount;
         $(div_tax_amount).text(tax_amount.toFixed(2));
         $(input_ptax_amount).val(tax_amount.toFixed(2));
    }else{
        var grand_total = total_gross_amount;
    }
    


    $(div_total_amount).text(grand_total.toFixed(2));
    $(input_gross_total).val(total_gross_amount.toFixed(2));
    $(input_product_total_amount).val(grand_total);
    get_item_sum_with_tax();
});

//$('.item-discount').focusout(function(event) {

$("body").on("focusout", ".item-discount", function () {
    $('.select-item-product').change();
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
    var total_gross_amount = this_item_rate * this_item_qty * this_item_pday ;
    //alert(total_gross_amount);
    if(total_gross_amount < discount_amount){
        swal("Invalid Discount !", "Discount amount can't be greater than gross amount,", "error", {
            button: "Ok!",
        });
        $(this).val(0);
        return false;
    }
    var total_gross_amount = this_item_rate * this_item_qty * this_item_pday - discount_amount;

    //alert(tax_amount);

    //alert('xd');
    //debugger;
   
    //alert(tax_amount);
    //debugger;
   // alert(Global_tax_apply);
    
     if(tax_calculated){
        var tax_amount = (total_gross_amount * Global_tax_apply) / 100;
        $(div_total_amount).text((total_gross_amount + tax_amount).toFixed(2));
        $(input_product_ptax_amount).val(tax_amount);
        $(div_tax_amount).text(tax_amount);
    }else{
        $(div_total_amount).text(total_gross_amount.toFixed(2));
        $(input_product_ptax_amount).val(0);
        $(div_tax_amount).text(0);
    }



    
    
    get_item_sum_with_tax();

    // debugger;
});

$("body").on("change", ".select-item-product", function () {
    var product_id = $(this).val();

    var div_sgt = $(this).parents().closest("tr").children("td.sgst");
    var div_igst = $(this).parents().closest("tr").children("td.igst");
    var div_cgst = $(this).parents().closest("tr").children("td.cgst");

    var input_sgt = $(this).parents().closest("tr").children("input.sgst");
    var input_igst = $(this).parents().closest("tr").children("input.igst");
    var input_cgst = $(this).parents().closest("tr").children("input.cgst");

    var input_psac = $(this).parents().closest("tr").children("input.psac");
    var div_input_psac = $(this).parents().closest("tr").children("td.sac");
    var input_phsn = $(this).parents().closest("tr").children("input.phsn");
    var div_input_phsn = $(this).parents().closest("tr").children("td.hsn");
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
            console.log(product);
            $(input_psac).val(product.hsn);
            $(div_input_psac).text(product.hsn);
            $(input_phsn).val(product.sac);
            $(div_input_phsn).text(product.sac);
            $(input_pname).val(product.name);
            $(input_pdescription).val(product.description);
            $(input_pdescription).val(product.description);
            $(input_item_display).text(product.description);
            
            let the_client_name = $('.invoice-customer-type option:selected').text().trim();
            
            
            if(the_client_name == 'Other'){
                Global_client_gst  = $('select[name="cstate"]').val();
            
            }else{
                Global_client_gst  = $('input[name="cstate"]').val();
                //console.log('cccccxss',Global_client_gst);
            }

            //alert(Global_client_gst);
            
            if (Global_client_gst.toLowerCase() != Global_default_gst.toLowerCase()) {
                // debugger;
                ///alert(Global_client_gst);
                //alert(Global_default_gst.toLowerCase());
                console.log('deafault gst', Global_default_gst.toLowerCase());
                console.log(' gst', Global_client_gst);

                $(div_sgt).text(0);
                $(div_cgst).text(0);
                tax_calculated ? $(div_igst).text(product.igst) : $(div_igst).text(0);

                $(input_sgt).val(0);
                $(input_cgst).val(0);
                tax_calculated ? $(input_igst).val(product.igst) : $(div_igst).text(0);

                Global_tax_apply = parseInt(product.igst);
            } else {
                
                tax_calculated ? $(div_sgt).text(product.sgst) : $(div_sgt).text(0);
                tax_calculated ? $(div_cgst).text(product.cgst) : $(div_cgst).text(0);
                $(div_igst).text(0);

                tax_calculated ? $(input_sgt).val(product.sgst) : $(input_sgt).val(0);
                tax_calculated ? $(input_cgst).val(product.cgst) : $(input_cgst).val(0);
                $(input_igst).val(0);

                Global_tax_apply = parseInt(product.cgst) + parseInt(product.sgst);
            }

            console.log('sdfasd asdf');
        })
        .fail(function (error) {
            console.log("error", error);
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
            
            // alert('xdd');

            var other =
                ' <td class="tax-amount">' +
                tax_amount +
                "</td>" +
                '                            <td class="total-amount">' +
                tax_calculated ? (parseFloat(gross_total_amount) + parseFloat(tax_amount)) : 0 +
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

$("#booking_type").change(function (e) {
   
    var type = $(this).val();
        if(type==2){
            tax_calculated = false;
            $('.item-discount').focusout();
        }else{
            tax_calculated = true;
            $('.item-discount').focusout();
        }
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
    $("td.tax-amount").each(function () {
        tax_sum += parseFloat($(this).text());
    });
    $("td.total-amount").each(function () {
        grand_sum += parseFloat($(this).text());
    });
    $("td.gross-amount").each(function () {
        gross_sum += parseFloat($(this).text());
    });

    $('input[type="number"].item-discount').each(function () {
        net_discount += parseFloat($(this).val());
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
    // alert('ddd');
    // debugger;
    console.log(' xdasdfadf asdf ');
    let attr = $('.main-gst-selection').find('option:selected').attr('data-state');

    if( attr  == 24 ){
            Global_default_gst = 'UTTAR PRADESH';
    }else{
            Global_default_gst = 'Delhi';  
    }
    $('.select-item-product').change();
    console.log('Global_default_gst',Global_default_gst);
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
