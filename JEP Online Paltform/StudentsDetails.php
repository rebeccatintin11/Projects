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


<script type="text/javascript">


//export table to excel
var tableToExcel = (function() {
  var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
    , base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))) }
    , format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p]; }) }
  return function(table, name) {
    if (!table.nodeType) table = document.getElementById(table)
    var ctx = {worksheet: name || 'Worksheet', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
  }
})()
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

     		
     		$.post("Studenttable.php",{str:str},function(result)
    		{
      			$("#txtHint").html(result);
    		});
    		
   		});
	}

	function showhistory(usc_id,site_id,course)
	{
		$(document).ready(function()
		{
     		$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
     		
     		$.post("Historytable.php",{usc_id:usc_id,site_id:site_id,course:course},function(result)
    		{
      			$("#txtHint").html(result);
    		});
    		
   		});
	}	

	
function showdetail(usc_id)
	{
		$(document).ready(function()
		{
     		$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);

     		$.post("Detailtable.php",{usc_id:usc_id},function(result)
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
	   
	<input type="button" onclick="tableToExcel('infotable', 'Table')" value="Export to Excel">
	<div id="txtHint"><b>Information will be listed here.</b></div>
   
			
			
</div>
</body>
</html>