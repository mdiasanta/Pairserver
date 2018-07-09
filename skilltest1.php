<?php
//this is php code
//this section is for processing things before the file starts being sent
$validForm= true; //This section is for error checking
$errormessage = ' ';
error_reporting( E_ALL);
//you MUST always use htmlntities
$fName = htmlentities($_GET["fName"]);//dollarsign in front means its a variable
$lName=htmlentities($_GET["lName"]);
$pwd=htmlentities($_GET["pwd"]);

if(preg_match("/^[a-zA-Z0-9]{8,}$/", $pwd)) {

} 
  else{
		echo 'Password must be atleast 8 characters long.
		You Typed: '.$pwd.'<br/>';
		$validForm=false;
	}

if ($fName==""){
	
	echo 'fName is a required field<br/>';
	
	$validForm=false;
}
if ($lName==""){
	
	echo 'lName is a required field<br/>';
	
	$validForm=false;
}
if($pwd===0 and $repwd===0){
	
	echo 'Passwords must match<br/>';
	$validForm=false;
}
else{
	
}
if ($validForm==false){
	
	echo'Press the back button to resubmit<br/>';
	die;
}
else if ($validForm==true){
	
	echo'All information has been successfully submitted<br/>';
	die;
}
?>
<form method="GET" action="Voting.php">
<html>
<!--set background color-->
<body style="background-color: #FFFFDD;">

<!--This is how to output the input you entered much like cout --><!--php code starts with ?-->
This is the information you entered:<br/>
This is the Fist Name you entered:	<?php echo $fName; ?><br/>
This is the Last Name you entered:	<?php echo $lName; ?><br/>
This is the Password you entered: <?php echo $pwd?>;<br/>

</body>
</html>