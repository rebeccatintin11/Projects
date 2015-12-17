<?php 
 include 'AdminLogin.php';
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" href="css/layout.css" type="text/css" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
<meta charset="UTF-8">
<title>JEP Online Platform</title>
<script type="text/javascript" src="js/jquery-1.11.0.pack.js"></script>  
<script type="text/javascript" src="js/jquery.blockUI.js"></script>

<div><b>Select the students you want this document be assigned to.</b></div>
<script type="text/javascript">

	//slide the dropdown lists 
	var slideflag=true;
	$(document).ready(function()
	{
  		$("#flip").click(function()
  		{
    		if(slideflag==true)
    		{
    			slideflag=false;
    			$("#panel").slideUp("slow");
    			document.getElementById("flip").src="images/showOptionsImg.jpg";

    		}
    		else
    		{
    			slideflag=true;
    			$("#panel").slideDown("slow");
	    		document.getElementById("flip").src="images/hideOptionsImg.jpg";

    		}
    		});
	});
	 
	//hide the dropdown lists after click the search bottom
	$(document).ready(function()
	{
  		$("#search").click(function()
  		{
    		$("#panel").slideUp("slow");
    		document.getElementById("flip").src="images/showOptionsImg.jpg";
  		});
	});

	function showinfo(myusername,first_name,last_name,site_id,course,professor,supervisor,major,room,car,housing,international,assigned_as,PA,team,semester)
	{
		$(document).ready(function()
		{
     		$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
     		
     		//the sql start form empty string and add tehm one by one
		var str="";
			
  		if(first_name!="")
  		{
  			str = str + "AND V.first_name=\'" + first_name + "\' "; 
  		}
  		
  		if(last_name!="")
  		{
  			str = str + "AND V.last_name=\'" + last_name + "\' "; 
  		}

  		
  		if(site_id!="")
  		{
  			str = str + "AND S.site_id=\'" + site_id + "\' "; 
  		}
  		
  		if(course!="")
  		{
  			str = str + "AND V.course=\'" + course + "\' "; 
  		}

  		
  		if(professor!="")
  		{
  			str = str + "AND V.professor=\'" + professor + "\' "; 
  		}
  		
  		if(supervisor!="")
  		{
  			str = str + "AND V.supervisor=\'" + supervisor + "\' "; 
  		}

  		
  		if(major!="")
  		{
  			str = str + "AND V.major=\'" + major + "\' "; 
  		}
  		
  		if(room!="")
  		{
  			str = str + "AND V.room=\'" + room + "\' "; 
  		}

  		
  		if(car!="")
  		{
  			str = str + "AND V.car=" + car + " "; 
  		}
  		
  		if(housing!="")
  		{
  			str = str + "AND V.housing=\'" + housing + "\' "; 
  		}

  		
  		if(international!="")
  		{
  			str = str + "AND V.international=" + international + " "; 
  		}
  		
  		if(assigned_as!="")
  		{
  			str = str + "AND V.assigned_as=\'" + assigned_as + "\' "; 
  		}

  		
  		if(PA!="")
  		{
  			str = str + "AND V.pa_usc_id=" + PA + " "; 
  		}
  		
  		if(team!="")
  		{
  			str = str + "AND V.team=\'" + team + "\' "; 
  		}

		if(semester!="")
  		{
  			str = str + "AND V.semester=\'" + semester + "\' "; 
  		}

     		
     		$.post("AddStudent_DetailTable.php",{str:str},function(result)
    		{
      			$("#txtHint").html(result);
    		});
    		
   		});
	}


	
</script>



</head>
<body >
	
	
		<img id="flip"   onmouseover="" style="cursor: pointer;" src="images/hideOptionsImg.jpg" alt="Smiley face" width="70" height="40">
<div id="panel">
	
	<?php
	
	include 'studentdrop.php';
	
	?>
	   </div>
	   
	<div id="txtHint"><b>Information will be listed here.</b></div>
   
			
			
</div>
</body>
</html>