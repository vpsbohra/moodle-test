<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Add page to admin menu.
 *
 * @package    auth_stripe
 * @copyright  2011 The Open University
 * @license    http://virasatsolutions.com/ GNU GPL v3 or later
 */
 
  ?>
  <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="/assets/css/style.css" rel="stylesheet">
        <!-- Adding HTML5.js -->
        <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/html5shiv/3.6.2/html5shiv.js"></script>
        
        
        <script type="text/javascript" src="https://js.stripe.com/v2/">
        </script>
        
        
        <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.js"></script>
        <script type="text/javascript" src="http://malsup.github.io/jquery.form.js"></script>
        <script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
        
        
        <!-- Setting the stripe publishable key.-->
        <script>Stripe.setPublishableKey("pk_test_51HHyJqLMwTSPe21Gd7tDhVFNUR71jIJR0hdpzB49ZARxYI1fHCxAhqiqYbQdzmgYM9MbZU1zNBMa8etKj06SobtB00UOQDe4xu");
        </script>
        
        
        <meta charset="utf-8">
  	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Checkout</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">  

<script type="text/javascript">

    var apiKey = "<?php echo $CFG->stripe_publickey; ?>";
    var stripe_payUSD = "<?php echo $CFG->stripe_payUSD; ?>";
  

    //set your publishable key
    //Stripe.setPublishableKey(apiKey);
    
    //alert(apiKey);

    //callback to handle the response from stripe
    
    
    
    
    function stripeResponseHandler(status, response) {
            //alert(response.error);
        if (response.error) {
            alert(response.error.message);
            //enable the submit button
            $('#payBtn').removeAttr("disabled");
            //display the errors on the form
            $(".payment-errors").text(response.error.message);
		
        } 
        
        else 
        {
            //alert("Hello123");
            var form$ = $("#paymentFrm");
            //get token id
            var token = response['id'];
		
            //insert the token into the form
            form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
            //submit form to the server
            form$.get(0).submit();
        }
    }

$(document).ready(function() {
    
    
	
//	alert("Yayy");
	
    //on form submit
    //$("#payBtn").click(function(event) {
       
        $("#paymentFrm").on('submit', function(e) {
         var expiry = document.getElementById("card-expiry-year").value;
       // alert(expiry);
        var month = expiry.substr(0, 2);
        //alert(month);
        var year = expiry.substr(3, 7);
       //alert(year);
        //disable the submit button to prevent repeated clicks
        //$('#payBtn').attr("disabled", "disabled");
        
        //create single-use token to charge the user
        Stripe.createToken({
            number: $('#card-number').val(),
            cvc: $('#card-cvc').val(),
            exp_month: month,
            exp_year: year
        }, stripeResponseHandler);
//alert("hello new");
        //submit from callback
        return false;
    });
});
</script>


<body>

    <?php 
    
require_once('../../config.php');
require_once('Stripe/init.php');
global $DB, $USER, $CFG, $OUTPUT;
require_login();
$useremail = $USER->email;
$Userid = $USER->id;
if (isloggedin() && !isguestuser()) {
//header("Location: /admin");
} else {
    
    header("Location: /admin");
}
// $courseid = required_param('courseid', PARAM_RAW);
echo $OUTPUT->header();
//print_header();
//echo $OUTPUT->navbar();
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
  $(document).ready(function() {
   $('#card-expiry-year').datepicker({
     changeMonth: true,
     changeYear: true,
     dateFormat: 'mm/y'
  });
});
</script>        
<div id="ccn-main-region11" class="courses-list111">
    
<div class="container">
    <h2 class="titl-sondc">Checkout</h2>
<div class="row">
  	<div class="col-md-8" id="payment_form">
  	    <div class="form-group-554">
  <div class="payment-errors"></div>
</div>
  		<form action="paymentintendsca.php" id="paymentFrm" method="POST">
  	        <h3 id="pay_info_h3">Payment Information</h3>
  	    
  	        <div class="form-group">
                <div class="icon-container" style="margin-left:18px;padding-top: 0px;margin-bottom: 17px;">
           		    <i class="fa fa-cc-amex" style="font-size:30px;color:blue;padding:5px;"></i>
           		    <i class="fa fa-cc-mastercard" style="font-size:27px;color:red;background-color: black;color:red;padding:1px;"></i>
              	    <i class="fa fa-cc-visa" style="font-size:30px;color: blue;padding:5px;"></i>
              	    <i class="fa fa-cc-discover" style="font-size:30px;color:red;padding:5px;"></i>
                </div>
           
            
                    <div class="col-md-12">
                        <label for="ccnum" class="label_txt">Card number:</label>
                        <input type="text" id="card-number" class="form-control" name="cardnumber" placeholder="1234-1234-1234-1234" maxlength="16" data-stripe="number" required >
                    </div>
                   </div>
      <div class="form-group" id="exp_year_div">
          <div class="col-md-12">
            <div class = "row">
                <div class = "col-md-6">
                    <label for="expyear" id="exp_year_label" class="label_txt">Expiry date:</label>
                    <input  type='text' id="card-expiry-year" class="form-control" name="exp_year" placeholder="mm/yy">
                </div>
              
                <div class = "col-md-6">
                       <label for="cvv" id="cvv_label" class="label_txt">CVV:</label>
                    <input  id="card-cvc" name="cvv" class="form-control" placeholder="Enter CVV" data-stripe="cvc" required >
                </div>
            </div>
        </div> </div>
       
            <div class="form-group" id="card_name_div"> 
                    <div class = "col-md-12">
                         <label class="label_txt" for="cname" class="label_txt">Name on card:</label>
                        <input type="text" class="form-control" id="cname" name="cardname" placeholder="Enter card holder name">
                    </div>
            </div>
        <div class="col-md-12">
           <h4 id="pinfo">Personal Information</h4> 
            
        </div>
					<div class="form-group" id="country_div"> 
						<div class = "col-md-12">
						<label  for="country" id="country_label" class="label_txt">Country or region:</label>
		<select class="form-control" name="country" id="country_id" autocomplete="country"required >
            <option value="" selected="">Select country or region</option>
            <option value="AF">Afghanistan</option>
            <option value="AX">Åland Islands</option>
            <option value="AL">Albania</option>
            <option value="DZ">Algeria</option>
            <option value="AS">American Samoa</option>
            <option value="AD">Andorra</option>
            <option value="AO">Angola</option>
            <option value="AI">Anguilla</option>
            <option value="AQ">Antarctica</option>
            <option value="AG">Antigua and Barbuda</option>
            <option value="AR">Argentina</option>
            <option value="AM">Armenia</option>
            <option value="AW">Aruba</option>
            <option value="AU">Australia</option>
            <option value="AT">Austria</option>
            <option value="AZ">Azerbaijan</option>
            <option value="BS">Bahamas</option>
            <option value="BH">Bahrain</option>
            <option value="BD">Bangladesh</option>
            <option value="BB">Barbados</option>
            <option value="BY">Belarus</option>
            <option value="BE">Belgium</option>
            <option value="BZ">Belize</option>
            <option value="BJ">Benin</option>
            <option value="BM">Bermuda</option>
            <option value="BT">Bhutan</option>
            <option value="BO">Bolivia (Plurinational State of)</option>
            <option value="BQ">Bonaire, Sint Eustatius and Saba</option>
            <option value="BA">Bosnia and Herzegovina</option>
            <option value="BW">Botswana</option>
            <option value="BV">Bouvet Island</option>
            <option value="BR">Brazil</option>
            <option value="IO">British Indian Ocean Territory</option>
            <option value="BN">Brunei Darussalam</option>
            <option value="BG">Bulgaria</option>
            <option value="BF">Burkina Faso</option>
            <option value="BI">Burundi</option>
            <option value="CV">Cabo Verde</option>
            <option value="KH">Cambodia</option>
            <option value="CM">Cameroon</option>
            <option value="CA">Canada</option>
            <option value="KY">Cayman Islands</option>
            <option value="CF">Central African Republic</option>
            <option value="TD">Chad</option>
            <option value="CL">Chile</option>
            <option value="CN">China</option>
            <option value="CX">Christmas Island</option>
            <option value="CC">Cocos (Keeling) Islands</option>
            <option value="CO">Colombia</option>
            <option value="KM">Comoros</option>
            <option value="CG">Congo</option>
            <option value="CD">Congo (the Democratic Republic of the)</option>
            <option value="CK">Cook Islands</option>
            <option value="CR">Costa Rica</option>
            <option value="CI">Côte d'Ivoire</option>
            <option value="HR">Croatia</option>
            <option value="CU">Cuba</option>
            <option value="CW">Curaçao</option>
            <option value="CY">Cyprus</option>
            <option value="CZ">Czechia</option>
            <option value="DK">Denmark</option>
            <option value="DJ">Djibouti</option>
            <option value="DM">Dominica</option>
            <option value="DO">Dominican Republic</option>
            <option value="EC">Ecuador</option>
            <option value="EG">Egypt</option>
            <option value="SV">El Salvador</option>
            <option value="GQ">Equatorial Guinea</option>
            <option value="ER">Eritrea</option>
            <option value="EE">Estonia</option>
            <option value="SZ">Eswatini</option>
            <option value="ET">Ethiopia</option>
            <option value="FK">Falkland Islands (Malvinas)</option>
            <option value="FO">Faroe Islands</option>
            <option value="FJ">Fiji</option>
            <option value="FI">Finland</option>
            <option value="FR">France</option>
            <option value="GF">French Guiana</option>
            <option value="PF">French Polynesia</option>
            <option value="TF">French Southern Territories</option>
            <option value="GA">Gabon</option>
            <option value="GM">Gambia</option>
            <option value="GE">Georgia</option>
            <option value="DE">Germany</option>
            <option value="GH">Ghana</option>
            <option value="GI">Gibraltar</option>
            <option value="GR">Greece</option>
            <option value="GL">Greenland</option>
            <option value="GD">Grenada</option>
            <option value="GP">Guadeloupe</option>
            <option value="GU">Guam</option>
            <option value="GT">Guatemala</option>
            <option value="GG">Guernsey</option>
            <option value="GN">Guinea</option>
            <option value="GW">Guinea-Bissau</option>
            <option value="GY">Guyana</option>
            <option value="HT">Haiti</option>
            <option value="HM">Heard Island and McDonald Islands</option>
            <option value="VA">Holy See</option>
            <option value="HN">Honduras</option>
            <option value="HK">Hong Kong</option>
            <option value="HU">Hungary</option>
            <option value="IS">Iceland</option>
            <option value="IN">India</option>
            <option value="ID">Indonesia</option>
            <option value="IR">Iran (Islamic Republic of)</option>
            <option value="IQ">Iraq</option>
            <option value="IE">Ireland</option>
            <option value="IM">Isle of Man</option>
            <option value="IL">Israel</option>
            <option value="IT">Italy</option>
            <option value="JM">Jamaica</option>
            <option value="JP">Japan</option>
            <option value="JE">Jersey</option>
            <option value="JO">Jordan</option>
            <option value="KZ">Kazakhstan</option>
            <option value="KE">Kenya</option>
            <option value="KI">Kiribati</option>
            <option value="KP">Korea (the Democratic People's Republic of)</option>
            <option value="KR">Korea (the Republic of)</option>
            <option value="KW">Kuwait</option>
            <option value="KG">Kyrgyzstan</option>
            <option value="LA">Lao People's Democratic Republic</option>
            <option value="LV">Latvia</option>
            <option value="LB">Lebanon</option>
            <option value="LS">Lesotho</option>
            <option value="LR">Liberia</option>
            <option value="LY">Libya</option>
            <option value="LI">Liechtenstein</option>
            <option value="LT">Lithuania</option>
            <option value="LU">Luxembourg</option>
            <option value="MO">Macao</option>
            <option value="MG">Madagascar</option>
            <option value="MW">Malawi</option>
            <option value="MY">Malaysia</option>
            <option value="MV">Maldives</option>
            <option value="ML">Mali</option>
            <option value="MT">Malta</option>
            <option value="MH">Marshall Islands</option>
            <option value="MQ">Martinique</option>
            <option value="MR">Mauritania</option>
            <option value="MU">Mauritius</option>
            <option value="YT">Mayotte</option>
            <option value="MX">Mexico</option>
            <option value="FM">Micronesia (Federated States of)</option>
            <option value="MD">Moldova (the Republic of)</option>
            <option value="MC">Monaco</option>
            <option value="MN">Mongolia</option>
            <option value="ME">Montenegro</option>
            <option value="MS">Montserrat</option>
            <option value="MA">Morocco</option>
            <option value="MZ">Mozambique</option>
            <option value="MM">Myanmar</option>
            <option value="NA">Namibia</option>
            <option value="NR">Nauru</option>
            <option value="NP">Nepal</option>
            <option value="NL">Netherlands</option>
            <option value="NC">New Caledonia</option>
            <option value="NZ">New Zealand</option>
            <option value="NI">Nicaragua</option>
            <option value="NE">Niger</option>
            <option value="NG">Nigeria</option>
            <option value="NU">Niue</option>
            <option value="NF">Norfolk Island</option>
            <option value="MK">North Macedonia</option>
            <option value="MP">Northern Mariana Islands</option>
            <option value="NO">Norway</option>
            <option value="OM">Oman</option>
            <option value="PK">Pakistan</option>
            <option value="PW">Palau</option>
            <option value="PS">Palestine, State of</option>
            <option value="PA">Panama</option>
            <option value="PG">Papua New Guinea</option>
            <option value="PY">Paraguay</option>
            <option value="PE">Peru</option>
            <option value="PH">Philippines</option>
            <option value="PN">Pitcairn</option>
            <option value="PL">Poland</option>
            <option value="PT">Portugal</option>
            <option value="PR">Puerto Rico</option>
            <option value="QA">Qatar</option>
            <option value="RE">Réunion</option>
            <option value="RO">Romania</option>
            <option value="RU">Russian Federation</option>
            <option value="RW">Rwanda</option>
            <option value="BL">Saint Barthélemy</option>
            <option value="SH">Saint Helena, Ascension and Tristan da Cunha</option>
            <option value="KN">Saint Kitts and Nevis</option>
            <option value="LC">Saint Lucia</option>
            <option value="MF">Saint Martin (French part)</option>
            <option value="PM">Saint Pierre and Miquelon</option>
            <option value="VC">Saint Vincent and the Grenadines</option>
            <option value="WS">Samoa</option>
            <option value="SM">San Marino</option>
            <option value="ST">Sao Tome and Principe</option>
            <option value="SA">Saudi Arabia</option>
            <option value="SN">Senegal</option>
            <option value="RS">Serbia</option>
            <option value="SC">Seychelles</option>
            <option value="SL">Sierra Leone</option>
            <option value="SG">Singapore</option>
            <option value="SX">Sint Maarten (Dutch part)</option>
            <option value="SK">Slovakia</option>
            <option value="SI">Slovenia</option>
            <option value="SB">Solomon Islands</option>
            <option value="SO">Somalia</option>
            <option value="ZA">South Africa</option>
            <option value="GS">South Georgia and the South Sandwich Islands</option>
            <option value="SS">South Sudan</option>
            <option value="ES">Spain</option>
            <option value="LK">Sri Lanka</option>
            <option value="SD">Sudan</option>
            <option value="SR">Suriname</option>
            <option value="SJ">Svalbard and Jan Mayen</option>
            <option value="SE">Sweden</option>
            <option value="CH">Switzerland</option>
            <option value="SY">Syrian Arab Republic</option>
            <option value="TW">Taiwan</option>
            <option value="TJ">Tajikistan</option>
            <option value="TZ">Tanzania, the United Republic of</option>
            <option value="TH">Thailand</option>
            <option value="TL">Timor-Leste</option>
            <option value="TG">Togo</option>
            <option value="TK">Tokelau</option>
            <option value="TO">Tonga</option>
            <option value="TT">Trinidad and Tobago</option>
            <option value="TN">Tunisia</option>
            <option value="TR">Turkey</option>
            <option value="TM">Turkmenistan</option>
            <option value="TC">Turks and Caicos Islands</option>
            <option value="TV">Tuvalu</option>
            <option value="UG">Uganda</option>
            <option value="UA">Ukraine</option>
            <option value="AE">United Arab Emirates</option>
            <option value="GB">United Kingdom</option>
            <option value="US">United States</option>
            <option value="UM">United States Minor Outlying Islands</option>
            <option value="UY">Uruguay</option>
            <option value="UZ">Uzbekistan</option>
            <option value="VU">Vanuatu</option>
            <option value="VE">Venezuela (Bolivarian Republic of)</option>
            <option value="VN">Viet Nam</option>
            <option value="VG">Virgin Islands (British)</option>
            <option value="VI">Virgin Islands (U.S.)</option>
            <option value="WF">Wallis and Futuna</option>
            <option value="EH">Western Sahara</option>
            <option value="YE">Yemen</option>
            <option value="ZM">Zambia</option>
            <option value="ZW">Zimbabwe</option>
        </select>
						</div>
					</div>
        
				<div class="form-group" id="zipcode_div"> 
				  <div class = "col-md-12">
				  <label  for="zipcode" id="zipcode_label" class="label_txt">ZIP code:</label>
				   <input  id="zipcode" class="form-control" name="zipcode" required>
				  </div>
				</div>
        
        </div>
        
    
<div class = "col-md-4" id="your_orders">
    <h3 id="your_order_h3">Your Order</h3>
   <?php $courseid=$_GET['courseid'];
   $courseprice=$_GET['price'];
   $timeslot=$_GET['timeslot'];
    $course = $DB->get_record('course', array('id' => $courseid));
//echo ($course->price);
//print_object($course);
?>
<div class='container'>
    <form action="paymentintendsca.php" id="paymentFrm" method="POST">
        <div class='borderBox1'>
            <div class ="row">
                <div class = "col-md-8">
                    <label id="course_name"><?php echo ($course->fullname); ?></label>
                </div>
               
                <div class = "col-md-4">
                    <label id="cost">$<?php echo $courseprice;?></label>
                </div>
			</div></div>
        <div class='borderBox1'>
            <div class = "row">
                <div class = "col-md-8">
                    <label id="subt">Subtotal</label>
                </div>
                <div class = "col-md-4">
                    <label id="cost">$<?php echo $courseprice;?></label>
                </div>
               
            </div></div>
        	
            <div class = "row">
                <div class = "col-md-8">
                    <label id="tot">Total</label>
                </div>
                <div class = "col-md-4">
                    <label id="cost"><strong>$<?php echo $courseprice;?></strong></label>
                </div>
            </div>
        <button type="primary" style='background:#FF566E;border:none;border-radius:23px;margin-top: 27px;font-size: 17px' class="btn btn-primary btn-lg btn-block">Pay now</button>
        <input type='hidden' name='city' value='<?php echo $USER->city;?>'> 
        <input type='hidden' name='Useremail' value='<?php echo $useremail;?>'> 
        <input type='hidden' name='amount' value='<?php echo $courseprice;?>'> 
        <input type='hidden' name='summary' value='<?php echo $course->summary;?>'> 
        <input type='hidden' name='courseid' value='<?php echo $courseid;?>'> 
        
        <input type='hidden' name='timeslot' value='<?php echo $timeslot;?>'> 
        <input type='hidden' name='Userid' value='<?php echo $Userid;?>'> 
        <input type='hidden'name='currency_code' value='USD'> <input type='hidden'
        name='item_name' value='<?php echo $course->fullname; ?>'> <input type='hidden'
        name='item_number' value='1'>
    </form>
    	<div class=""><strong>Your Time slot:</strong> <?php echo $timeslot;?></div>
    </div>
</div>


</div>
</div>
</div>
<?php echo $OUTPUT->footer(); ?>

</body>
<style>

.navbar-light{
     background-color: aliceblue;
}
/*body{
     background-color: aliceblue;
    overflow-x: hidden; //horizontal
    overflow-y: scroll; //vertical
   
}*/

.payment-errors {
    color: red;
}

#group1{
 height: 72px;
  width: 532px;
}

#group1_container{
    height: 56px;
   width: 158px;
}


#course{
 height: 26px;
  width: 126px;
  color: #656C7C;
  font-size: 16px;
  letter-spacing: 0.09px;
  line-height: 26px;
  text-align: center;
}

#course_dash{
  height: 26px;
  width: 145px;
  color: #656C7C;
  font-family: Inter;
  font-size: 16px;
  letter-spacing: 0.09px;
  line-height: 26px;
  text-align: center;
}

#benjamin{
      height: 32px;
  width: 153px;
}


.container-fluid{
	margin-top: 10px;
	color:grey;
}


#Checkout{
  height: 70px;
  width: 770px;
  color: #14294C;
  font-family: "Frank Ruhl Libre";
  font-size: 50px;
  font-weight: bold;
  margin-left: 45px;
  margin-top: 65px;
}


#paymentFrm{
 /* height: 832px;
  width: 990px;*/
  border-radius: 20px;
  background-color: #FFFFFF;
  padding-bottom: 33px;
 /* margin-left: 45px;
  margin-top: 64px;*/
}


#pay_info_h3{
  margin-bottom: 15px;
  padding-top:48px;
  color: #4F5F79;
  font-size: 20px;
  font-weight: 700;
  margin-left: 20px;
}

/*#pinfo{
  margin-left:33px;
  height: 30px;
  width: 208px;
  color: #4F5F79;
  font-family: Inter;
  font-size: 20px;
  font-weight: 600;
  letter-spacing: 0.08px;
  line-height: 30px;
}*/

#card_no_div{
  height: 94px;
  width: 781px;
  margin-left:33px;
}

/*#exp_year_div{
    height: 111px;
    width: 661px;
    margin-left:33px;
}*/

/*#country_div{
  height: 101px;
  width: 781px;
  margin-left:33px;
}

#zipcode_div{
  height: 82px;
  width: 781px;
  margin-left:33px;
}

#card_name_div{
  height: 110px;
  width: 781px;
  margin-left:33px;
}*/

#label_txt{
  height: 28px;
  width: 781px;
  color: #4F5F79;
  font-family: Inter;
  font-size: 16px;
  letter-spacing: 0;
  line-height: 28px;
}


.background_input{
box-sizing: border-box;
  height: 47px;
  width: 100%;
  border: 1px solid #4F5F79;
  border-radius: 5px;
}

.background_input_expiry{
  box-sizing: border-box;
  height: 47px;
  width: 376px;
  border: 1px solid #9BADEA;
  border-radius: 5px;
}

/*#card-cvc{
 box-sizing: border-box;
  height: 47px;
  width: 446px;
  border: 1px solid #9BADEA;
  border-radius: 5px;
}*/

#your_orders{
  /*margin-top: 64px;
  height: 435px;
  width: 408px;*/
  border-radius: 20px;
  background-color: #FFFFFF;
}

hr{
  box-sizing: border-box;
  height: 1px;
  width: 344px;
  border: 1px solid #E2E2E2;
}

#your_order_h3{
  margin-top:48px;  
  color: #4F5F79;
  font-size: 20px;
  font-weight: 600;
  letter-spacing: 0.08px;
  line-height: 30px;
  margin-left: 18px;
}

#course_name{
  color: #4F5F79;
  font-size: 16px;
  letter-spacing: 0;
  line-height: 28px;
}

#tot{
  color: #4F5F79;
  font-size: 20px !important;
  letter-spacing: 0;
  line-height: 34px;
}

#subt{
  color: #4F5F79;
  font-size: 16px;
  letter-spacing: 0;
  line-height: 28px;
}

#cost{
  color: #4F5F79;
  font-size: 16px;
  letter-spacing: 0;
  line-height: 28px;
}


/*button{
    
  border-radius: 30px;
  background-color: #FF566E;
  border:none;
  color:white;
  margin-top: 11px;

}*/
/*#card-expiry-year{
  box-sizing: border-box;
  border: 1px solid #4F5F79;
  border-radius: 5px;
  height: 47px;
  color: #4F5F79;
  font-family: Inter;
  font-size: 16px;
  letter-spacing: 0;
  line-height: 24px;
  width: 100%;
}*/

section.inner_page_breadcrumb.ccn_breadcrumb_m {
    display: none;
}

.search_overlay {
    display: none;
}	
h2.titl-sondc {
    margin-bottom: 100px;
    font-size: 50px;
}
body label {
    font-size: 17px !important;
}
body {
    background-color: #f8f9fb !important;
}

.borderBox1 {
    border-bottom: 1px solid #ddd;
    margin: 8px 0px;
    padding: 10px 0;
}

</style> 
