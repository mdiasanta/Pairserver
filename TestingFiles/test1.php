<?php
$validform = true;
$emptyform = true;

$uid = htmlentities($_POST['uid']);

if ($uid=='') { 
	$validform = false;
	$uiderrormessage = 'The recipe ID is required.';
} 
else {
	$emptyform = false;
	if (is_numeric($uid)) {
		if ($uid<=0 or $uid > 2147482647) {
			$validform = false;
			$uiderrormessage = 'The recipe ID must be greater than zero and less than 2147482647.';
		} 
		else {
		//it's okay
		}
	} 
	else {
		$validform = false;
		$uiderrormessage = 'The recipe ID must be an integer.';
	}
}
if ($emptyform == true) {
	$uiderrormessage = '';
	$titleerrormessage = '';
	$carderrormessage = '';
	$servingqtyerrormessage = '';
	$servingtypeerrormessage = '';
	$timeprepqtyerrormessage = '';
	$timecookqtyerrormessage = '';
	$caterrormessage = '';
	$pictureerrormessage = '';
}


?>
<html>
<body>
<form action ="test1.php" method="post">
<header>
	<h1>Welcome to the Entry Form</h1>
	<h2>Please Fill in the Following Information:</h2>
</header>

Enter the UID: <input type="text" name="uid" value="<?php echo $uid; ?>">
<span style="color: red;"><?php echo $uiderrormessage; ?></span><br/>
Enter the First Name: <input type="text" name="fname" value="<?php echo $fname; ?>">
<span style="color: red;"><?php echo $fnameerrormessage; ?></span><br/>
Enter the Last Name: <input type="text" name="lname" value="<?php echo $lname; ?>">
<span style="color: red;"><?php echo $lnameerrormessage; ?></span><br/>
Enter the Date: <input type="text" name="date" value="<?php echo $date; ?>">
<span style="color: red;"><?php echo $daterrormessage; ?></span><br/><br/>

<b>Submit when you are ready</b><br/>
<input type="submit" value="submit">
</body>
</html>