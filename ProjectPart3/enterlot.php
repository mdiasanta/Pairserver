<html>
<style>
a.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
	font-family: Arial;
}

table {
    border-collapse: collapse;
	font-family: Arial;
	text-align: center;
}

table, th, td {
    border: 1px solid black;
}
td.leftjust{
	
	text-align: left;
}

th, td {
	padding: 10px;
    text-align: center;
	   
}
</style>

</html>
<?php 

$validform=true;
$emptyform=true;

$LotID = htmlentities($_POST['LotID']);
if($LotID=='') {
	$validform = false;
	$LotIDerrormessage = '*Lot ID is a required field.';
} else {
	$emptyform = false;
	if (preg_match("/^[0-9]{1,3}$/", $LotID)) {
		if ($LotID<=0 or $LotID >= 1000) {
			$validform = false;
			$LotIDerrormessage = '*Lot ID must be an integer between 1 and 999.';
		} else {
		//it's okay
		}
	} else {
		$validform = false;
		$LotIDerrormessage = '*Lot ID must be an integer with at most 3 digits.';
	}
}

$Description = htmlentities($_POST['Description']);
if($Description=='') {
	$validform = false;
	$Descriptionerrormessage = '*Description is a required field.<br />';
} else {
	$emptyform = false;
	if (strlen($Description)>999) {
		$validform = false;
		$Descriptionrormessage = '*Description must be less than 999 characters long.<br />';
	}
}
$CategoryID = htmlentities($_POST['CategoryID']);
if($CategoryID=='') {
	$validform = false;
	$CategoryIDerrormessage = '*Category ID is a required field.';
} else {
	$emptyform = false;
	if (preg_match("/^[0-9]{1,3}$/", $CategoryID)) {
		if ($CategoryID<=0 or $CategoryID >= 1000) {
			$validform = false;
			$CategoryIDerrormessage = '*Category ID must be an integer between 1 and 999.';
		} else {
		//it's okay
		}
	} else {
		$validform = false;
		$CategoryIDerrormessage = '*Category ID must be an integer with at most 3 digits.';
	}
}
$WinningBidder = htmlentities($_POST['WinningBidder']);
if($WinningBidder=='') {
	$validform = false;
	$WinningBiddererrormessage = '*Winning Bidder is a required field.';
} else {
	$emptyform = false;
	if (preg_match("/^[0-9]{1,3}$/", $WinningBidder)) {
		if ($WinningBidder<=0 or $WinningBidder >= 1000) {
			$validform = false;
			$WinningBiddererrormessage = '*Winning Bidder must be an integer between 1 and 999.';
		} else {
		//it's okay
		}
	} else {
		$validform = false;
		$WinningBiddererrormessage = '*Winning Bidder must be an integer with at most 3 digits.';
	}
}
$Delivered = htmlentities($_POST['Delivered']);

if($Delivered==''){
	
	$validform= false;
	$Deliverederrormessage='*A delivered Status must be selected';
}

/*
$Address = htmlentities($_POST['Address']);
if($Address=='') {
	$validform = false;
	$Addresserrormessage = 'Address is a required field.';
} else {
	$emptyform = false;
	if (strlen($Address)>999) {
		$validform = false;
		$Addresserrormessage = 'Description must be less than 999 characters long.<br />';
	}
}

$CellNumber = htmlentities($_POST['CellNumber']);
if(!preg_match("/^[0-9]{3}\-[0-9]{4}$/", $CellNumber)) {
	
		$CellNumbererrormessage='CellNumber must be in the format: XXX-XXXX';
	}
	
$HomeNumber = htmlentities($_POST['HomeNumber']);
if(!preg_match("/^[0-9]{3}\-[0-9]{4}$/", $HomeNumber)) {
	
		$HomeNumbererrormessage='HomeNumber must be in the format: XXX-XXXX';
	}
	
$Email = htmlentities($_POST['Email']);
if(!preg_match("/^[a-zA-Z0-9]{1,}\@[a-zA-Z0-9]{2,}\.[a-zA-Z0-9]{3,}$/", $Email)) {
	
		$Emailerrormessage='E-mail must be in the format: user@domain';
	}
*/	
if ($emptyform == true) {
	$LotIDerrormessage = '';
	$Descriptionerrormessage = '';
	$CategoryIDerrormessage = '';
	$WinningBiddererrormessage = '';
	$Deliverederrormessage = '';
}
else{
	
	if ($validform==true) {
		//echo "All data was valid.<br/>";
		//echo "Connecting to database.<br/>";
		//connect to the database
		//
		try{
			//variable stores the connection -> $conn
			//PDO = PHP Data Oject -> helps prevent SQL injections
			//hose= Database server host name
			//Username = name of read/write user_error
			//password = that user's password
			//mysql:host="database server", "username","password"
			$conn= new PDO("mysql:host=db77a.pair.com","zbiss001_4_w","pC2bCnsn");
			$conn-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
		}
		catch(PDOException $e){
			
			echo"Error Connecting to server: " . $e->getMessage();
			die;
		}
		//echo"Connection Successful.<br/>";
		
		//echo"Connecting to Database Auction....<br/>";
		try{
			//if executing query command, NO USER ENTERED fields should be in query string
			$conn->query("USE zbiss001_Auction");		
		
		}
		catch(PDOException $e){
			
			echo"Error Connecting to database: " . $e->getMessage();
			die;
		}
		//echo"Connection to the Auction database succeeded.<br/>";
		
				
		//echo"Preparing SQL statement.<br/>";
		//NO VARIABLES ALLOWED IN SQL
		$SQL=" INSERT INTO Lot(LotID, Description, CategoryID, WinningBidder, Delivered)";
		//ALL USER ENTERED VALUES are going to be parameters -> variable names that start with a colon
		$SQL.=" VALUES(:LotID, :Description, :CategoryID, :WinningBidder, :Delivered);";
		//echo "This is the SQL statement: " . $SQL . "<br/>";
		//echo "Preparing to add recipe record.<br/>";
		try{
			
			$sth = $conn->prepare($SQL);
			$sth ->bindParam(":LotID", $LotID);
			$sth ->bindParam(":Description", $Description);
			$sth ->bindParam(":CategoryID", $CategoryID);
			$sth ->bindParam(":WinningBidder", $WinningBidder);
			$sth ->bindParam(":Delivered", $Delivered);
			
			
			$sth->execute();
		
		}
		catch(PDOException $e){
			
			echo"Error adding recipe record: " . $e->getMessage();
			echo"<br/><br/><a href='enterlot.php' class='button'>Click Here to enter another Lot</a>";
			die;
		}
		echo "<br/><br/><br/><center><header><h1>Lot Has Been Successfully Added!</h1></header></b><br/>";
		Header("Locaton: viewbidder.php");
		echo"<a href='AuctionAdminDashboard.php' class='button'>Click Here to return to the Auction Administrator Dashboard</a></center>";
		die;
	}
}




?>
<html>
<body bgcolor="F0F8FF">
<head>
</head>

<body>
<form action="enterlot.php" method="post">

<font face="Arial">
<header><h1><center>Lot Information</center></h1><h2><center>To create a New Lot, Enter the New Lot Information:</center></h2></header><br/> 
<table align="center">

	<tr>
		<th colspan="3">New Lot Entry Form:</th>
	</tr>
	
	<tr>
		<th>Lot ID:</th>
		<td class="leftjust"><input type="text" name="LotID" value="<?php echo $LotID; ?>"></td>
			<td><span style="color: red;"><?php echo $LotIDerrormessage; ?></span><br /><br/></td>
	</tr>
	
	<tr>
		<th>Description: </th>
		<td><textarea name="Description" style="width: 300px; height: 80px;">
			<?php echo $Description; ?></textarea></td>
		<td><span style="color: red;"><?php echo $Descriptionerrormessage; ?></span><br/></td>
	</tr>
	
	<tr>
		<th>CategoryID:</th>
		<td class="leftjust"><input type="text" name="CategoryID" value="<?php echo $CategoryID; ?>"></td>
		<td><span style="color: red;"><?php echo $CategoryIDerrormessage; ?></span><br /><br/></td>
	</tr>
	
	<tr>
		<th>WinningBidder:</th>
		<td class="leftjust"><input type="text" name="WinningBidder" value="<?php echo $WinningBidder; ?>"></td>
			<td><span style="color: red;"><?php echo $WinningBiddererrormessage; ?></span></td>
	</tr>
	
	<tr>
		<th>Delivered Status:</th>
		<td class="leftjust"><input type="radio" name="Delivered" value="1"<?php if ($Delivered=='1'){ echo ' checked';} ?>> Delivered<br />
			<input type="radio" name="Delivered" value="0"<?php if ($Delivered=='0'){ echo ' checked';} ?>> Not Delivered<br /></td>
		<td><span style="color: red;"><?php echo $Deliverederrormessage; ?></span></td>
	</tr>
	
	<tr>
		<td colspan="3"><input type="submit" value="submit"></td>
	</tr>
	
</table>
<!--
Lot ID:<input type="text" name="LotID" value="<?php echo $LotID; ?>">
<span style="color: red;"><?php echo $LotIDerrormessage; ?></span><br /><br/>

Description: <textarea name="Description" style="width: 300px; height: 80px;">
<?php echo $Description; ?></textarea>
<span style="color: red;"><?php echo $Descriptionerrormessage; ?></span><br/>

CategoryID:<input type="text" name="CategoryID" value="<?php echo $CategoryID; ?>">
<span style="color: red;"><?php echo $CategoryIDerrormessage; ?></span><br /><br/>

WinningBidder:<input type="text" name="WinningBidder" value="<?php echo $WinningBidder; ?>">
<span style="color: red;"><?php echo $WinningBiddererrormessage; ?></span><br /><br/>


Delivered Status:<br />
<input type="radio" name="Delivered" value="1"<?php if ($Delivered=='1'){ echo ' checked';} ?>> Delivered<br />
<input type="radio" name="Delivered" value="0"<?php if ($Delivered=='0'){ echo ' checked';} ?>> Not Delivered<br />
<span style="color: red;"><?php echo $Deliverederrormessage; ?></span><br />


<br/>

<input type="submit" value="submit">
-->
</font>
<br/>



<table align="center">
	<tr>
		<th colspan="4">Administrator Dashboard</th>
	</tr>
	
	<tr>
		<th>Data Entry</th>
		<td colspan="2"><a href='enterbidder.php' class='button'>Enter Bidder</a><br/><br/>Enter New Bidder Information</td>
		<td><a href='enterlot.php' class='button'>Enter Lot</a><br/><br/>Enter a New Lot</td>
		
	</tr>
	
	
	<tr>
		<th>Data View</th>
		<td colspan="2"><a href='viewbidder.php' class='button'>View Bidder</a><br/><br/>View All Bidders</td>
		<td><a href='viewlotwinner.php' class='button'>View Lot Winners</a><br/><br/>View Lot Winner Report</td>
		
	</tr>
	
	<tr>
		<th>Report View</th>
		<td><a href='viewlot.php' class='button'>View All Lot</a><br/><br/>View All Lots</td>
		
		<td><a href='viewlotnotdelivered.php' class='button'>View Undelivered Lots</a><br/><br/>View Underlivered Lot Winners Report</td>
		<td><a href='viewwinnernopay.php' class='button'>View Winners who haven't paid</a><br/><br/>View Unpaid Lot Winners Report</td>
	</tr>
</table>




</body>



</html>