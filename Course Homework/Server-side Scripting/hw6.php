<html>
<head>
<meta charset="UTF-8">
<title>CSCI571 HW6 Rebecca Lin 6432461489</title>
<style type="text/css">
	body{
		font-size:18px; 
		font-family:"Times New Roman", Times, serif;}
	.r{
		width:100%;
	}
	td{
		padding:5px;
	}
	.d{
		background-color:FFFFEB;
		border: 1px solid black;
		border-radius:6px;
		padding:6px;
		text-align: left;
	}
</style>
<?php if(isset($_POST["submit"]) && $_POST["address"]!==""):

	$address_t=urlencode($_POST["address"]);
    $city_t=trim($_POST["city"]);
    $state_t=urlencode($_POST["state"]);
    
    $generatelink="&address=".$address_t."&citystatezip=".$city_t."%2C+".$state_t."&rentzestimate=true";
    //generate link for search
    
    function Getxml($input){
    	
        $zwurl = "http://www.zillow.com/webservice/GetDeepSearchResults.htm?";
        $zwsid = "zws-id=X1-ZWz1b2gr8bmvpn_9vdv4";
        $url = $zwurl.$zwsid.$input;
        $sxml = simplexml_load_file($url);
        if ($sxml === false){
            //echo "<p>Malformed XML. Please fix your query and try again.</p>";
            return false;
        }
        return $sxml;
    }
    
    
    if(GetXml($generatelink)){
    	
    	$xml=GetXml($generatelink);
    	
    	if($xml->message->code=="508"){
    		$_SESSION["s"]=2;
    		//echo "<h>No exact match found -- Verify that the given address is correct</h>";
    	}else{
    
    	//check if we already run the php	
    	$_SESSION["s"]=1;
    	
    	//generate header after we got details from xml
    	$address=$xml->response->results->result->address->street;
    	$city=$xml->response->results->result->address->city;
    	$state=$xml->response->results->result->address->state;
    	$link=$xml->response->results->result->links->homedetails;
    	$zip=$xml->response->results->result->address->zipcode;
    	
    	$detailad=str_replace("+", " ", $address).", ".$city.", ".$state."-".$zip;
    	
    	$data=$xml->response->results->result;
    	
    	$PropertyType=$data->useCode;
    	$YearBuilt=$data->yearBuilt;
    	$LotSize=$data->lotSizeSqFt;
    	$FinishedArea=$data->finishedSqFt;
    	$Bathrooms=$data->bathrooms;
    	$Bedrooms=$data->bedrooms;
    	$TaxAY=$data->taxAssessmentYear;
    	$TaxA=$data->taxAssessment;
    	$LSP=$data->lastSoldPrice;
    	$LSD=$data->lastSoldDate;
    	$ZPED=$data->zestimate->amount;
    	$Z_Date=$data->zestimate->{'last-updated'} ;
    	$DaysOverallC_t=$data->zestimate->valueChange;
    	$DaysOverallC=abs(floatval($DaysOverallC_t));
    	$AllTimeLow=$data->zestimate->valuationRange->low;
    	$AllTimeHigh=$data->zestimate->valuationRange->high;
    	$RentZVD=$data->rentzestimate->amount;
    	$Z_R_Date=$data->rentzestimate->{'last-updated'} ;
   		$DaysRentC_t=$data->rentzestimate->valueChange;
   		$DaysRentC=abs(floatval($DaysRentC_t));		
    	$AllTimeRentLow=$data->rentzestimate->valuationRange->low;
    	$AllTimeRentHigh=$data->rentzestimate->valuationRange->high;
    	}	
    	
    }else{
    	echo "<h>Please try again.</h>";
    }

?>    		
    		
<?php endif; ?>

<script type="text/javascript">
function checkinput(){
    var location = inputform.address.value.trim();
    var city = inputform.city.value.trim();
    var state=inputform.state.value;
    if(location.length===0 && city.length===0 && state==""){
    	alert("Please enter value for Street Address, City and State.");
        <?php $_POST="" ?>
        return false;
    }else if(location.length===0 && city.length===0){
    	alert("Please enter value for Street Address and City.\n");
        <?php $_POST="" ?>
        return false;
    }else if(location.length===0 && state==""){
    	alert("Please enter value for Street Address and State.\n");
        <?php $_POST="" ?>
        return false;
    }else if(city.length===0 && state==""){
    	alert("Please enter value for City and State.\n");
        <?php $_POST="" ?>
        return false;   
    }else if(location.length===0){
        alert("Please enter Street Address.\n");
        <?php $_POST="" ?>
        return false;
    }else if(city.length===0){
    	alert("Please enter City.\n");
        <?php $_POST="" ?>
        return false;
    }else if(state==""){
    	alert("Please select a State.\n");
        <?php $_POST="" ?>
        return false;
    }
    
    return true;
}

</script>

</head>
<body>
<center>

<h1>Real Estate Search</h1>
<form method="POST" id="inputform" onsubmit="return checkinput();" >
<table frame="box" >
<tr><td>Street Address*:</td>
<td><input type="text" name="address" size=30></td></tr>

<tr><td>City*:</td>
<td><input type="text" name="city" size=30></td></tr>

<tr><td>State*:</td>
<td><select name="state">

	<option value="" selected="selected"></option>
	<option value="AK">AK</option>
	<option value="AL">AL</option>
	<option value="AR">AR</option>
	<option value="AZ">AZ</option>
	<option value="CA">CA</option>
	<option value="CO">CO</option>
	<option value="CT">CT</option>
	<option value="DC">DC</option>
	<option value="DE">DE</option>
	<option value="FL">FL</option>
	<option value="GA">GA</option>
	<option value="HI">HI</option>
	<option value="IA">IA</option>
	<option value="ID">ID</option>
	<option value="IL">IL</option>
	<option value="IN">IN</option>
	<option value="KS">KS</option>
	<option value="KY">KY</option>
	<option value="LA">LA</option>
	<option value="MA">MA</option>
	<option value="MD">MD</option>
	<option value="ME">ME</option>
	<option value="MI">MI</option>
	<option value="MN">MN</option>
	<option value="MO">MO</option>
	<option value="MS">MS</option>
	<option value="MT">MT</option>
	<option value="NC">NC</option>
	<option value="ND">ND</option>
	<option value="NE">NE</option>
	<option value="NH">NH</option>
	<option value="NJ">NJ</option>
	<option value="NM">NM</option>
	<option value="NV">NV</option>
	<option value="NY">NY</option>
	<option value="OH">OH</option>
	<option value="OK">OK</option>
	<option value="OR">OR</option>
	<option value="PA">PA</option>
	<option value="RI">RI</option>
	<option value="SC">SC</option>
	<option value="SD">SD</option>
	<option value="TN">TN</option>
	<option value="TX">TX</option>
	<option value="UT">UT</option>
	<option value="VA">VA</option>
	<option value="VT">VT</option>
	<option value="WA">WA</option>
	<option value="WI">WI</option>
	<option value="WV">WV</option>
	<option value="WY">WY</option>
	</select></td></tr>

<tr><td></td><td><input type="submit" value="Search" name="submit"></td>
<td><img src="http://www.zillow.com/widgets/GetVersionedResource.htm?path=/static/logos/Zillowlogo_150x40.gif" width="150" height="40" alt="Zillow Real Estate Search" /></td></tr>
<tr><td><p>* - <i>Mandatory fields</i></p></td></tr>
</table>
</form>
<div id="ResultArea" style="visibility:hidden;">
<h1>Search Result</h1>
<p class="d">See more details for <a href="<?php echo $link ?>"><?php echo $detailad ?></a> on Zillow</p>
<table class="r">
 		<tr><td>Property Type:</td><td><?php echo $PropertyType ?></td>
 			<td>Last Sold Price:</td><td><?php echo "$".number_format(floatval($LSP), 2, '.', ',') ?></td></tr>
 			
 		<tr><td>Year Built:</td><td><?php echo $YearBuilt ?></td>
 			<td>Last Sold Date:</td><td><?php echo date_format(date_create($LSD,timezone_open("America/Los_Angeles")), 'd-M-Y') ?></td></tr>
 			
 		<tr><td>Lot Size::</td><td><?php echo $LotSize." sq. ft." ?></td>
 			<td>Zestimate<sup>&#0174</sup> Property Estimate as of <?php echo date_format(date_create($Z_Date,timezone_open("America/Los_Angeles")), 'd-M-Y') ?>:</td><td><?php echo "$".number_format(floatval($ZPED), 2, '.', ',') ?></td></tr>
 		
 		<tr><td>Finished Area:</td><td><?php echo $FinishedArea." sq. ft." ?></td>
 			<td>30 Days Overall Change<?php if($DaysOverallC_t<0){?> <img src="down_r.gif"/> <?php }else{ ?> <img src="up_g.gif"/> <?php } ?>:</td><td><?php echo "$".number_format(floatval($DaysOverallC), 2, '.', ',') ?></td></tr>
 		
 		<tr><td>Bathrooms:</td><td><?php echo $Bathrooms ?></td>
 			<td>All Time Property Range:</td><td><?php echo "$".number_format(floatval($AllTimeLow), 2, '.', ',')." - $".number_format(floatval($AllTimeHigh), 2, '.', ',') ?></td></tr>
 		
 		<tr><td>Bedrooms:</td><td><?php echo $Bedrooms ?></td>
 			<td>Rent Zestimate<sup>&#0174</sup> Valuation as of <?php echo date_format(date_create($Z_R_Date,timezone_open("America/Los_Angeles")), 'd-M-Y') ?>:</td><td><?php echo "$".number_format(floatval($RentZVD), 2, '.', ',') ?></td></tr>
 		
 		<tr><td>Tax Assessment Year:</td><td><?php echo $TaxAY ?></td>
 			<td>30 Days Rent Change<?php if($DaysRentC_t<0){?> <img src="down_r.gif"/> <?php }else{ ?> <img src="up_g.gif"/> <?php } ?>:</td><td><?php echo "$".number_format(floatval($DaysRentC), 2, '.', ',') ?></td></tr>
 		
 		<tr><td>Tax Assessment:</td><td><?php echo "$".number_format(floatval($TaxA), 2, '.', ',') ?></td>
 			<td>All Time Rent Range:</td><td><?php echo "$".number_format(floatval($AllTimeRentLow), 2, '.', ',')." - $".number_format(floatval($AllTimeRentHigh), 2, '.', ',') ?></td></tr>
 		</table>
 		
<p><sup>&copy</sup> Zillow, Inc., 2006-2014. Use is subject to <a href="http://www.zillow.com/corp/Terms.htm">Term of Use</a></p>
<a href="http://www.zillow.com/zestimate/" >What's a Zestimate</a>
</div>
</center>
<?php
if ($_SESSION["s"]===1){
    echo "<script type=\"text/javascript\">document.getElementById(\"ResultArea\").style.visibility=\"visible\";</script>";
    
}else if($_SESSION["s"]===2){ 
	
	$Notfound="<h>No exact match found -- Verify that the given address is correct</h>";
	echo "<script type=\"text/javascript\">document.getElementById(\"ResultArea\").innerHTML=\"".$Notfound."\";";
	echo "document.getElementById(\"ResultArea\").style.visibility=\"visible\";</script>";
}?>
</body>
</html>
