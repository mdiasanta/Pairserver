<?php
//this is php code
//this section is for processing things before the file starts being sent
$validForm= true; //This section is for error checking
$errormessage = ' ';
//you MUST always use htmlntities
$rid = htmlentities($_GET["rid"]);//dollarsign in front means its a variable
$qty=htmlentities($_GET["qty"]);
$unit=htmlentities($_GET["unit"]);
$item=htmlentities($_GET["item"]);
$inote=htmlentities($_GET["inote"]);

//these two methods validate whether rid is an int or not
if ($rid==""){
	
	echo 'Recipe ID is a required field<br/>';
	$validForm=false;
}
	else {
		echo "Not blank";
		
			if (is_numeric($rid)){
		
	}
		else{
			echo 'recipe ID is not numeric <br/>';
			$validForm=false;
			//die;
		}
	}


	
if($rid<=0){
	 echo 'recipe ID must be a positive number <br/>';
	 $validForm=false;
	//die;	
}

if ($validForm==false){
	
	echo 'Press the back button on your browser';
	die;
}

?>

<html>
<!--set background color-->
<body style="background-color: #FFFFDD;">

<!--This is how to output the input you entered much like cout --><!--php code starts with ?-->
This is the ingredient you entered:<br/>
This is the recipe ID you entered:	<?php echo $rid; ?><br/>
Quantity: <?php echo $qty; ?><br/>
Unit: <?php echo $unit; ?><br/>
Item: <?php echo $item; ?><br/>
inote: <?php echo $inote; ?><br/>


</body>
</html>