<?php
error_reporting(E_ALL);
//form validation for each variable
$validform = false;
$validform1= false;
//html entities declaration for use with PHP
$pwd = htmlentities($_POST['pwd']);
$repwd = htmlentities($_POST['repwd']);
$fname = htmlentities($_POST['fname']);
$lname = htmlentities($_POST['lname']);
//Name Validation
if(empty($fname or $lname)){
	$fnameerrormessage='First Name field is blank';
	$lnameerrormessage='Last Name field is blank';
}
else{
	if(!preg_match("/^[a-zA-Z]{1,}$/", $fname)){

		$fnameerrormessage='First Name needs to be at least 1 character long or Alphabetical';
	}
	if(!preg_match("/^[a-zA-Z]{1,}$/", $lname)){

		$lnameerrormessage='Last Name needs to be at least 1 characters long or Alphabetical';
	}
	else{
	
	$validform=true;
	$Confirmation1="<br/>Name Data was valid";
	}
}	
//password validation
if(empty($pwd)){
	$pwderrormessage='Password is blank';
	$repwderrormessage='Password re-entry is blank';
}
else{
	if(!preg_match("/^[a-zA-Z0-9]{8,}$/", $pwd)){
	
		$pwderrormessage='password needs to be at least 8 characters';
	}
	else if($pwd!=$repwd){
	$pwderrormessage= 'Passwords does not match';
	}
	else{
	$validform1=true;
	$Confirmation2="<br/>Password Data was valid";
	}
}	
//Valid Form Message Screen
if($validform and $validform1==true){

echo"Congratulations!";
echo $Confirmation1;
echo $Confirmation2;
die;
}
?>
<html>
<body>
<form action="skilltest2.php" method="post">

<header>
<h1>Information Entry Form<h1/>
</header>


Enter the First Name: <input type="text" name="fname" value="<?php echo $fname; ?>">
<span style="color: red;"><?php echo $fnameerrormessage; ?></span><br />

Enter the Last Name: <input type="text" name="lname" value="<?php echo $lname; ?>">
<span style="color: red;"><?php echo $lnameerrormessage; ?></span><br />

Enter Password: <input type="password" name="pwd" value="<?php echo $pwd; ?>">
<span style="color: red;"><?php echo $pwderrormessage; ?></span><br />

Re-enter Password: <input type="password" name="repwd" value="<?php echo $repwd; ?>">
<span style="color: red;"><?php echo $repwderrormessage; ?></span><br />


<input type="submit">
</form>
</body>
</html>
