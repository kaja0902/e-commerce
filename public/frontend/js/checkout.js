$(document).ready(function () {
    $('.razorpay_btn').click(function (e) { 
        e.preventDefault();

        var firstname  = $('.firstname').val();
        var lastname = $('.lastname').val();
        var email  = $('.email').val();
        var phone = $('.phone').val();
        var adress1 = $('.adress1').val();
        var city = $('.city').val();
        var country = $('.country').val();
        var zipcode = $('.zipcode').val();

        if(!firstname){
            fname_error = "First Name Is required";
            $('#fname_error').html('');
            $('#fname_error').html(fname_error);
        }else{
            fname_error = "";
            $('#fname_error').html('');
        }

        if(!lastname){
            lname_error = "Last Name Is required";
            $('#lname_error').html('');
            $('#lname_error').html(lname_error);
        }else{
            lname_error = "";
            $('#lname_error').html('');
        }

        if(!email){
            email_error = "Email Is required";
            $('#email_error').html('');
            $('#email_error').html(email_error);
        }else{
            email_error = "";
            $('#email_error').html('');
        }

        if(!phone){
            phone_error = "Phone Is required";
            $('#phone_error').html('');
            $('#phone_error').html(phone_error);
        }else{
            phone_error = "";
            $('#phone_error').html('');
        }

        if(!adress1){
            adress1_error = "Adress 1 Is required";
            $('#adress1_error').html('');
            $('#adress1_error').html(adress1_error);
        }else{
            adress1_error = "";
            $('#adress1_error').html('');
        }

        if(!city){
            city_error = "City Is required";
            $('#city_error').html('');
            $('#city_error').html(city_error);
        }else{
            city_error = "";
            $('#city_error').html('');
        }

        if(!country){
            country_error = "Country Is required";
            $('#country_error').html('');
            $('#country_error').html(city_error);
        }else{
            country_error = "";
            $('#country_error').html('');
        }

        if(!zipcode){
            country_error = "Zipcode Is required";
            $('#zipcode_error').html('');
            $('#zipcode_error').html(zipcode_error);
        }else{
            zipcode_error = "";
            $('#zipcode_error').html('');
        }

        if(fname_error !== '' || lname_error!== '' || email_error!== '' || phone_error!=='' || adress1_error!=='' || city_error!=='' || country_error!=='' || zipcode_error!==''){
            return false;
        }else{

            var data = {
                'firstname': firstname,
                'lastname': lastname,
                'email': email,
                'phone': phone,
                'adress1': adress1,
                'city': city,
                'country': country,
                'zipcode': zipcode
            }

            $.ajax({
                method: "POST",
                url: "/proceed-to-pay",
                data: data,
                success: function (response) {
                    //alert(response.total_price)
                    
                }
            });
        }
        
        
        
    });
});