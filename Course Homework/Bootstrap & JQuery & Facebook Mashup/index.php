<?php 
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');
header('Content-Type: application/json');
$address_t=$_GET["streetInput"];
$city_t=$_GET["cityInput"];
$state_t=$_GET["stateInput"];

$generatelink="&address=".$address_t."&citystatezip=".$city_t."%2C+".$state_t."&rentzestimate=true";
//generate link for search
    
	//get Xml for Basic Info
    function Getxml($input){
    	
        $zwurl = "http://www.zillow.com/webservice/GetDeepSearchResults.htm?";
        $zwsid = "zws-id=X1-ZWz1b2gr8bmvpn_9vdv4";
        $url = $zwurl.$zwsid.$input;
        $sxml = simplexml_load_file($url);
        if ($sxml === false){
            
            return false;
        }
        return $sxml;
    }
    
    //get Xml for Historical Chart
    function GetCharturl($input,$duration){
    	
    	//$input is zpid
        $zwurl = "http://www.zillow.com/webservice/GetChart.htm?";
        $zwsid = "zws-id=X1-ZWz1b2gr8bmvpn_9vdv4";
        $url = $zwurl.$zwsid."&unit-type=percent&zpid=".$input."&width=600&height=300&chartDuration=".$duration;
        $sxml = simplexml_load_file($url);
        if ($sxml === false){
            
            return false;
        }
        $chartUrl=$sxml->response->url;
        return (string)$chartUrl;        
        
    }
    
    if(GetXml($generatelink)){
    	
    	$xml=GetXml($generatelink);
    	
    	if($xml->message->code=="508"){
    		
    		$dataarray = array("status"=>"No exact match found--Verify that the given address is correct");
    		
    		//generate JSON from php array
			$json=json_encode($dataarray);

    		//return to browser
    		echo $json;
    		
    	}else{
    		
    		//get data from xml document
    		
    		$data=$xml->response->results->result;
    		
    		$link=(string)$data->links->homedetails;
	    	$address=(string)$data->address->street;
	    	$city=(string)$data->address->city;
	    	$state=(string)$data->address->state;
	    	$zip=(string)$data->address->zipcode;
	    	$latitude=(string)$data->address->latitude;
	    	$longitude=(string)$data->address->longitude;
	    	$PropertyType=(string)$data->useCode;
	    	$YearBuilt=(string)$data->yearBuilt;
	    	$LotSize=number_format(floatval($data->lotSizeSqFt));
	    	$FinishedArea=number_format(floatval($data->finishedSqFt));
	    	$Bathrooms=(string)$data->bathrooms;
	    	$Bedrooms=(string)$data->bedrooms;
	    	$TaxAY=(string)$data->taxAssessmentYear;
	    	$TaxA=number_format(floatval($data->taxAssessment), 2, '.', ',');
	    	$LSP=number_format(floatval($data->lastSoldPrice), 2, '.', ',');	    	
	    	$LSD=date_format(date_create($data->lastSoldDate,timezone_open("America/Los_Angeles")), 'd-M-Y');
	    	$ZPED=number_format(floatval($data->zestimate->amount), 2, '.', ',');
	    	$Z_Date=date_format(date_create($data->zestimate->{'last-updated'},timezone_open("America/Los_Angeles")), 'd-M-Y');
	    	$DaysOverallC_t=$data->zestimate->valueChange;
    		if($DaysOverallC_t<0){
	    		$DaysOverallC_S="-";
	    	}else{
	    		$DaysOverallC_S="+";
	    	}
	    	$DaysOverallC=number_format(abs(floatval($DaysOverallC_t)), 2, '.', ',');
	    	$AllTimeLow=number_format(floatval($data->zestimate->valuationRange->low), 2, '.', ',');
	    	$AllTimeHigh=number_format(floatval($data->zestimate->valuationRange->high), 2, '.', ',');
	    	$RentZVD=number_format(floatval($data->rentzestimate->amount), 2, '.', ',');    	
	    	$Z_R_Date=date_format(date_create($data->rentzestimate->{'last-updated'},timezone_open("America/Los_Angeles")), 'd-M-Y');
	    	$DaysRentC_t=$data->rentzestimate->valueChange;
    		if($DaysRentC_t<0){
	    		$DaysRentC_S="-";
	    	}else{
	    		$DaysRentC_S="+";
	    	}		
	   		$DaysRentC=number_format(abs(floatval($DaysRentC_t)), 2, '.', ',');
	    	$AllTimeRentLow=number_format(floatval($data->rentzestimate->valuationRange->low), 2, '.', ',');
	    	$AllTimeRentHigh=number_format(floatval($data->rentzestimate->valuationRange->high), 2, '.', ',');
	    	
	    	
    		
    		//fill xml data into php array
    		$dataarray = array(
    			"status"=>"Success",
    			"result"=> array(
    		
    				"homedetails"=>$link,
    				"street"=>$address,
    				"city"=>$city,
    				"state"=>$state,
    				"zipcode"=>$zip,
    				"latitude"=>$latitude,
    				"longitude"=>$longitude,
    				"useCode"=>$PropertyType,
    				"lastSoldPrice"=>$LSP,
    				"yearBuilt"=>$YearBuilt,
    				"lastSoldDate"=>$LSD,
    				"lotSizeSqFt"=>$LotSize,
    				"estimateLastUpdate"=>$Z_Date,
    				"estimateAmount"=>$ZPED,
    				"finishedSqFt"=>$FinishedArea,
    				"estimateValueChangeSign"=>$DaysOverallC_S,
    				"imgn"=>"http://www-scf.usc.edu/~csci571/2014Spring/hw6/down_r.gif",
    				"imgp"=>"http://www-scf.usc.edu/~csci571/2014Spring/hw6/up_g.gif",
    				"estimateValueChange"=>$DaysOverallC,
    				"bathrooms"=>$Bathrooms,
    				"estimateValuationRangeLow"=>$AllTimeLow,
    				"estimateValuationRangeHigh"=>$AllTimeHigh,
    				"bedrooms"=>$Bedrooms,
    				"restimateLastUpdate"=>$Z_R_Date,
    				"restimateAmount"=>$RentZVD,
    				"taxAssessmentYear"=>$TaxAY,
    				"restimateValueChangeSign"=>$DaysRentC_S,
    				"restimateValueChange"=>$DaysRentC,
    				"taxAssessment"=>$TaxA,
    				"restimateValuationRangeLow"=>$AllTimeRentLow,
    				"restimateValuationRangeHigh"=>$AllTimeRentHigh
    			),
    			
    			"chart" => array(
    				
    				"1year"=> array(
    					"url"=>GetCharturl($data->zpid,"1year")
    				),
    				"5year"=> array(
    					"url"=>GetCharturl($data->zpid,"5year")
    				),
    				"10year"=> array(
    					"url"=>GetCharturl($data->zpid,"10year")
    				)
    			)
			);
    	
    	
			//generate JSON from php array
			$json=json_encode($dataarray);

    		//return to browser
    		echo $json;
    	
    	}	
    	
    }else{
    	echo "<h>Please try again.</h>";
    }
    
    
?>


	
	
	
	