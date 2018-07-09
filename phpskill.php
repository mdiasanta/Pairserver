<?php
error_reporting(E_ALL);
$emptyform=true;
$validform1=true;

//htmlentities declaration
$name = htmlentities($_POST['name']);
$pwd = htmlentities($_POST['pwd']);
$repwd = htmlentities($_POST['repwd']);

//Name Validation
if ($name==''){
	$validform1=false;
	$nameerrormessage="Name Cannot be blank";

}
else{

	$emptyform=false;
	if(!preg_match("/^[a-zA-Z]{1,}$/", $name)){
		
		$validform1=false;
		$nameerrormessage='Name needs to be Alphabetical';
		
	}
	else{
		
		$namevalid=1;
		$nameconfirm="Name Data is valid";
		
	}

}
//Password Validation
if(empty($pwd)){
	//$pwderrormessage='Password is blank';
	$validform1=false;
	$pwderrormessage='*Required Field';
	//$repwderrormessage='Password re-entry is blank';
	$repwderrormessage='*Required Field';
}
else{
	$emptyform=false;
	if(!preg_match("/^(?=.*?[a-zA-Z])(?=.*?[0-9]).{1,}$/", $pwd)){
	///^[a-zA-Z]{8,}[0-9]{1,}$/
		$validform1=false;
		$pwderrormessage='Password must have at least 1 number';
	}
	else if($pwd!=$repwd){
		$validform1=false;
		$pwderrormessage= 'Passwords do not match';
	}
	else{
	$pwdvalid=1;
	$passwordConfirm="<br/>Password Data was valid";
	}
}	

if ($emptyform==true){
	
	$nameerrormessage='*';
	$pwderrormessage='*';
	$repwderrormessage='*';
}
if ($namevalid and $pwdvalid==1){
	
	echo"Congratulations!<br/> All Data valid";
	die;
}
/*else{
	if ($validform1==true){
	echo"all data is valid";
	die;
	}*/
//}


?>

<html>
<body>
<form action="phpskill.php" method="post">
<header>
	<h1>PHP SKILL</h1>
	<h2>Please Enter the Following informtaion</h2>
</header>
<span style="color: red;">*Required Field</span><br/>
Name:<input type="text" name="name" value="<?php echo $name; ?>">
<span style="color: red;"><?php echo $nameerrormessage; ?></span><br/><br/>
Password: <input type="password" name="pwd" value="<?php echo $pwd; ?>">
<span style="color: red;"><?php echo $pwderrormessage; ?></span><br/>
Re-enter Password: <input type="password" name="repwd" value="<?php echo $repwd; ?>">
<span style="color: red;"><?php echo $repwderrormessage; ?></span><br/><br/>



<b>Press Submit when you are ready</b><br/>
<input type="submit" value="submit">
</body>
</html>