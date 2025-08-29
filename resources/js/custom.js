var baseUrl =  $("meta[name=base_url]").attr('content');

$(document).ready(function(event){
            

            $('form').on('focus', 'input[type=number]', function (e) {
                  $(this).on('wheel.disableScroll', function (e) {
                    e.preventDefault()
                  })
                })
                $('form').on('blur', 'input[type=number]', function (e) {
                  $(this).off('wheel.disableScroll')
                })
                $("input[type=number]").on("focus", function() {
                    $(this).on("keydown", function(event) {
                        if (event.keyCode === 38 || event.keyCode === 40) {
                            event.preventDefault();
                        }
                    });
                });

         $('.select-2').select2();

        $("#business_type").change(function(){
          //alert('xd');
          const date = new Date();
          const short_code  = $(this).val();
          const sn = $(this).attr('data-sn');
          const last2year = new Date().getFullYear().toString().slice(-2);
          const day = date.getDate();
          const month = date.getMonth() + 1;
          $("input[name='business_short_code']").val(short_code);
          $("#sn").val(sn);
          $("#employee_code").val(`${short_code}${last2year}${day}${month}${sn}`)
        });


$('input[type="number"]').keyup(function(e){

        var val = $(this).val();

        // $(this).val(val.replace(/[^0-9\s]/gi, '').replace(/[_\s]/g, ''));

        // var number = $(this).val();
        // if(number.length > 10){
        //     $(this).val($(this).val().substring(0, 10));
        // }
        // if(number.length == 10){
        //     $(this).val( number.replace(/^0+/, ''));
        // }
    });

        


});
    function refresh_city(){
        
        // alert('x');
        $.ajax({
          url: baseUrl+'/admin/fetch/city',
          type: 'GET',
        })
        .done(function(result) {
          $('select[name="city"]').html(result.city);
          //console.log('newstate',result);
        })
        .fail(function(error) {
          console.log(error);
        });
    }
    function refresh_state(){
        
        // alert('x');
        $.ajax({
          url: baseUrl+'/admin/fetch/city',
          type: 'GET',
        })
        .done(function(result) {
          $('select[name="state"]').html(result.state);
          //console.log('newstate',result);
        })
        .fail(function(error) {
          console.log(error);
        });
    }

    

    // $('body').on('focusout', 'input#pincode', function(event) {
    //     event.preventDefault();
    //     /* Act on the event */
    //     var pincode = parseInt($(this).val());
    //     console.log('sddd', $(this).val().length);
    //     if( $(this).val().length != 6 )
    //       return false;
    //     $('#loading-wrapper').css('display','block');
    //     //console.log('sddd', );

    //     $.ajax({
    //       url: baseUrl+'/searchPincode?pincode=' + pincode,
    //       type: 'GET',
    //     })
    //     .done(function(result) {
    //       if(result.error == false){
    //         console.log(result.data.city);
    //         $("input[name='city']").val(result.data.city);
    //         $("input[name='state']").val(result.data.state);
    //         $('#loading-wrapper').css('display','none');
    //       }
    //       console.log(result);
    //     })
    //     .fail(function(error) {
    //       console.log(error);
    //     });
    //   });