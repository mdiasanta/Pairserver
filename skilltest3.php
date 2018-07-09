<?php
error_reporting(E_ALL);
//form validation for each variable
$validform1 = false;
$validform2= false;
$validform3= false;
$emptyform=true;

//html entities declaration for use with PHP
$pwd = htmlentities($_POST['pwd']);
$repwd = htmlentities($_POST['repwd']);
$fname = htmlentities($_POST['fname']);
$lname = htmlentities($_POST['lname']);
$email = htmlentities($_POST['email']);
$reemail = htmlentities($_POST['reemail']);
//Name Validation
if(empty($fname or $lname)){
	//$fnameerrormessage='First Name field is blank';
	$fnameerrormessage='*';
	//$lnameerrormessage='Last Name field is blank';
	$lnameerrormessage='*';
}
else{
	$emptyform=false;
	
	if(!preg_match("/^[a-zA-Z]{1,}$/", $fname)){

		$fnameerrormessage='First Name needs to be Alphabetical';
		
	}
	if(!preg_match("/^[a-zA-Z]{1,}$/", $lname)){

		$lnameerrormessage='Last Name needs to be Alphabetical';
	}
	else{
	
	$validform1=true;
	$nameConfirm="<br/>Name Data was valid";
	}
}	
//password validation
if(empty($pwd)){
	//$pwderrormessage='Password is blank';
	$pwderrormessage='*';
	//$repwderrormessage='Password re-entry is blank';
	$repwderrormessage='*';
}
else{
	if(!preg_match("/^(?=.*?[a-zA-Z])(?=.*?[0-9]).{8,}$/", $pwd)){
	///^[a-zA-Z]{8,}[0-9]{1,}$/
		$pwderrormessage='Password must be 8 characters long with atleast 1 number';
	}
	else if($pwd!=$repwd){
	$pwderrormessage= 'Passwords does not match';
	}
	else{
	$validform2=true;
	$passwordConfirm="<br/>Password Data was valid";
	}
}	
//Email Validation
if(empty($email)){

	//$emailerrormessage="Email Field is Blank";
	$emailerrormessage="*";
}
if(empty($reemail)){

	//$reemailerrormessage="Email Field is Blank";
	$reemailerrormessage="*";
}
Else{

	if(!preg_match("/^[a-zA-Z0-9]{1,}\@[a-zA-Z0-9]{2,}\.[a-zA-Z0-9]{3,}$/", $email)) {
	
		$emailerrormessage='E-mail must be in the format: user@domain';
	} 
	else if($email!=$reemail){

		$reemailerrormessage='Emails must match';
	}
	else{
		$validform3=true;
		$emailConfirm="<br/> Email Data was valid";
	}
}
//Valid Form Message Screen
if($validform1 and $validform2 and $validform3==true ){

echo"Congratulations!";
echo $nameConfirm;
echo $passwordConfirm;
echo $emailConfirm;  

die;

if ($emptyform==true){

	$fnameerrormessage= '';
}
}
?>
<html>
<body>
<form action="skilltest3.php" method="post">

<header>
<h1>Information Entry Form<h1/>
<h2>Please fill in the following form:</h2>
</header>
<span style="color: red;">*required field.</span><br/>
Enter the First Name: <input type="text" name="fname" value="<?php echo $fname; ?>">
<span style="color: red;"><?php echo $fnameerrormessage; ?></span><br />

Enter the Last Name: <input type="text" name="lname" value="<?php echo $lname; ?>">
<span style="color: red;"><?php echo $lnameerrormessage; ?></span><br /><br/>

Enter Password: <input type="password" name="pwd" value="<?php echo $pwd; ?>">
<span style="color: red;"><?php echo $pwderrormessage; ?></span><br />

Re-enter Password: <input type="password" name="repwd" value="<?php echo $repwd; ?>">
<span style="color: red;"><?php echo $repwderrormessage; ?></span><br /><br/>

Enter Email Address:<input type="text" name="email" value="<?php echo $email; ?>">
<span style="color: red;"><?php echo $emailerrormessage; ?></span><br />

Re-enter Email Address:<input type="text" name="reemail" value="<?php echo $reemail; ?>">
<span style="color: red;"><?php echo $reemailerrormessage; ?></span><br /><br/>

<b>Press Submit when you are ready<br/><input type="submit">
</form>
</body>
</html>
