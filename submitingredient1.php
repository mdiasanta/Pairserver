<?php
//this is php code
//this section is for processing things before the file starts being sent

error_reporting( E_ALL);
/*This set of code is for showing errors
ini_set("display_errors", 1);
ini_set("track_errors", 1);
ini_set("html_errors", 1);
error_reporting(E_ALL); */

//This section is for error checking
$validForm= true;
$errormessage = ' ';
//setting up function function getValue($variableName){}
function getValue($variableName){
	
	$returnedValue = htmlentities($_POST[$variableName]);
	return $returnedValue;

}


//this replaces the commented out code below; using a function reduces the redundancy in the code
$rid=getValue("rid");
$qty=getValue("qty");
$unit=getValue("unit");
$item=getValue("item");
$inote=getValue("inote");
$phone=getValue("phone");
$date=getValue("date");
$email=getValue("email");

function isNumeric($thisVariable){
	if ($thisVariable==""){
		
		return false;
	}
	else{
		
		if (is_numeric($thisVariable)){
			
			if($thisVariable<=0){
				
				return false;
			}
			else if($thisVariable>2147483647){
				
				return false;
			}
			else{
				
				return true;
			}
			
			
		}
		else{
				
				return false;
			}
	}
}
//check if RID is valid
if (isNumeric($rid)){
	
}
else{
	echo "RID is invalid. it must be a positive number<br/>";
	$validForm=false;
	
}
//check if QTY is valid
if (isNumeric($qty)){
	
}
else{
	echo"QTY is invalid. it must be a postiive number<br/>";
	$validForm=false;
}

//String length function NOT WORKING FOR NOW
function validText($thisVariable,$minLength,$maxLength){
	
	if(strlen($thisVariable)<$minLength){
		
		return false;
	}
	else if(strlen($thisVariable)>$maxLength){
		
		return false;
	}
	else if (!ctype_alpha($thisVariable)){
		
		return false;
	}
	else{
		
		return true;
	}
}
if (validText($unit,1,30)){
	
}
else{
	echo "Unit is invalid. It must be between 1 and 30 characters<br/>";
	$validForm=false;
}
//you MUST always use htmlntities
/*$rid = htmlentities($_POST["rid"]);//dollarsign in front means its a variable
$qty=htmlentities($_POST["qty"]);
$unit=htmlentities($_POST["unit"]);
$item=htmlentities($_POST["item"]);
$inote=htmlentities($_POST["inote"]);
$phone=htmlentities($_POST["phone"]);
$date=htmlentities($_POST["date"]);
$email=htmlentities($_POST["email"]); */

//regular expressions are the format of a field; 
//if (preg_match)("/^[allowed characters]{number of characters}$/"),$variable)){}
//don't rely on preg_match for validation
if(preg_match("/^\([0-9]{3}\)[0-9]{3}-[0-9]{4}$/", $phone)) {

} 
  else{
		echo 'Phone # must be in the format (000), you typed '.$phone.'<br/>';
		$validForm=false;
	}

//putting a \ behaind a / treats the forward slash as a character instead of a command
if(preg_match("/^[0-9]{2}\/[0-9]{2}\/[0-9]{4}$/", $date)) {

} 
  else{
		echo 'Date must be in the format MM/DD/YY, you typed '.$date.'<br/>';
		$validForm=false;
	}
//the a-zA-Z0-9 will include those characters	
if(preg_match("/^[a-zA-Z0-9]{1,}\@[a-zA-Z0-9]{2,}\.[a-zA-Z0-9]{3,}$/", $email)) {

} 
  else{
		echo 'E-mail must be in the format user@domain, you typed: '.$email.'<br/>';
		$validForm=false;
	}
	
//these two methods validate whether rid is an int or not
//you MUST validate ALL user data in PHP
/*if ($rid==""){
	
	echo 'Recipe ID is a required field<br/>';
	$validForm=false;
}
	else {
		
		//echo "Not blank";
		//Nested if
		if (is_numeric($rid)){
		
			if($rid<=0){
				echo 'recipe ID must be a positive number <br/>';
				$validForm=false;
				
			}
			else if($rid>2147483647){
			
				echo 'Recipe ID must be less than 2147483647<br/>';
				$validForm=false;
			}
		}
		
	else{
		echo 'recipe ID is not numeric <br/>';
		$validForm=false;
	}
				
	}*/
	
//Unit Validation
/*if($unit==""){
	
	echo 'Unit ID is a required field<br/>';
	$validForm=false;
}
	else{
		//rejects if input is a number
		if (!ctype_alpha($unit)){
			
			echo 'Unit ID must only be letters<br/>';
			$validForm=false;
		}
		
		else if (strlen($unit)>30){
			
			//echo'Maximum length of unit is 30<br/>';
			$validForm=false;
		}
	}*/

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
This is the E-mail:	<?php echo $email; ?><br/>
This is the Phone Number:	<?php echo $phone; ?><br/>
This is the date:	<?php echo $date; ?><br/>
</body>
</html>