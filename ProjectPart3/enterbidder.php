<html>
<body bgcolor="F0F8FF">
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

$BidderID = htmlentities($_POST['BidderID']);

$Name = htmlentities($_POST['Name']);

if($Name=='') {
	$validform = false;
	$Nameerrormessage = '*Name is a required field.';
} else {
	$emptyform = false;
	if (strlen($name)>75) {
		$validform = false;
		$Nameerrormessage = '*The name must be less than 75 characters long.';
	}
}

$Address = htmlentities($_POST['Address']);
if($Address=='') {
	$validform = false;
	$Addresserrormessage = '*Address is a required field.';
} else {
	$emptyform = false;
	if (strlen($Address)>999) {
		$validform = false;
		$Addresserrormessage = '*Description must be less than 999 characters long.<br />';
	}
}

$CellNumber = htmlentities($_POST['CellNumber']);
if(!preg_match("/^[0-9]{3}\-[0-9]{4}$/", $CellNumber)) {
	
		$CellNumbererrormessage='*CellNumber must be in the format: XXX-XXXX';
	}
	
$HomeNumber = htmlentities($_POST['HomeNumber']);
if(!preg_match("/^[0-9]{3}\-[0-9]{4}$/", $HomeNumber)) {
	
		$HomeNumbererrormessage='*HomeNumber must be in the format: XXX-XXXX';
	}
	
$Email = htmlentities($_POST['Email']);
if(!preg_match("/^[a-zA-Z0-9]{1,}\@[a-zA-Z0-9]{2,}\.[a-zA-Z0-9]{3,}$/", $Email)) {
	
		$Emailerrormessage='*E-mail must be in the format: user@domain';
	}
	
if ($emptyform == true) {
	$Nameerrormessage = '';
	$Addresserrormessage = '';
	$CellNumbererrormessage = '';
	$HomeNumbererrormessage = '';
	$Emailerrormessage = '';
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
		
		do {
			$proposedID = mt_rand(1,1000);
			$SQL = "SELECT BidderID FROM Bidder WHERE BidderID=:proposedID;";
			try {
				$sth = $conn->prepare($SQL);
				$sth->bindParam(":proposedID", $proposedID);
				$sth->execute();
			} catch (PDOException $e) {
				echo "Error selecting recipe records: " . $e->getMessage();
				die;
			}
			//echo "Query executed successfully. <br />";
			//are there records in the set?
			if($sth->rowCount()==0) {
				//echo "No records returned, can use proposedID.<br />";
				$BidderID = $proposedID;
				//echo "Your BidderID is " . $BidderID . "<br/>";
			} else {
				//echo $sth->rowCount() . " records returned. Try again.<br />";
			}
		} while ($sth->rowCount()>0);
				
		//echo"Preparing SQL statement.<br/>";
		//NO VARIABLES ALLOWED IN SQL
		$SQL=" INSERT INTO Bidder(BidderID, Name, Address, CellNumber, HomeNumber, Email)";
		//ALL USER ENTERED VALUES are going to be parameters -> variable names that start with a colon
		$SQL.=" VALUES(:BidderID, :Name, :Address, :CellNumber, :HomeNumber, :Email);";
		//echo "This is the SQL statement: " . $SQL . "<br/>";
		//echo "Preparing to add recipe record.<br/>";
		try{
			
			$sth = $conn->prepare($SQL);
			$sth ->bindParam(":BidderID", $BidderID);
			$sth ->bindParam(":Name", $Name);
			$sth ->bindParam(":Address", $Address);
			$sth ->bindParam(":CellNumber", $CellNumber);
			$sth ->bindParam(":HomeNumber", $HomeNumber);
			$sth ->bindParam(":Email", $Email);
			
			
			$sth->execute();
		
		}
		catch(PDOException $e){
			
			echo"Error adding recipe record: " . $e->getMessage();
			die;
		}
		//echo "Records added to database<br/><br/>";
		echo"<center>";
		echo "<header><h1>Your BidderID is <font color='red'>" . $BidderID . "</font></h1>";
		echo "<h2>Please use this number when placing your bids.</h2></header><br/>";
		echo"<a href='enterbidder.php' class='button'>Click Here to enter another Bidder</a><br/><br/>";
		echo"<a href='UserMenu.php' class='button'>Click Here to Return to User Menu</a>";
		echo"</center>";
		die;
		
	}
}




?>


<html>
<head>
</head>
<body>
<form action="enterbidder.php" method="post">

<font face="Arial">
<header><h1><center>Bidder Information<center></h1><h2><center>Enter the following bidder information:</center></h2></header><br/> 
<font color="red"><center>**Please note that your bidder number will automatically be assigned after submission**</center></font><br/><br/>

<table align="center">

	<tr>
		<th colspan="3">New Bidder Entry Form:</th>
	</tr>
	
	<tr>
		<th>Name:</th>
		<td class="leftjust"><input type="text" name="Name" value="<?php echo $Name; ?>"></td>
			<td><span style="color: red;"><?php echo $Nameerrormessage; ?></span></td>
	</tr>
	
	<tr>
		<th>Address:</th>
		<td><input type="text" name="Address" value="<?php echo $Address; ?>"></td>
			<td><span style="color: red;"><?php echo $Addresserrormessage; ?></span></td>
	</tr>
	
	<tr>
		<th>Cell Number (XXX-XXXX):</th>
		<td class="leftjust"><input type="text" name="CellNumber" value="<?php echo $CellNumber; ?>"></td>
			<td><span style="color: red;"><?php echo $CellNumbererrormessage; ?></span></td>
	</tr>
	
	<tr>
		<th>Home Number(XXX-XXXX):</th>
		<td class="leftjust"><input type="text" name="HomeNumber" value="<?php echo $HomeNumber; ?>"></td>
			<td><span style="color: red;"><?php echo $HomeNumbererrormessage; ?></span></td>
	</tr>
	
	<tr>
		<th>Email Address:</th>
		<td class="leftjust"><input type="text" name="Email" value="<?php echo $Email; ?>"></td>
			<td><span style="color: red;"><?php echo $Emailerrormessage; ?></span></td>
	</tr>
	
	<tr>
		<td colspan="3"><input type="submit" value="submit"></td>
	</tr>
	
</table>
<!--
Name:<input type="text" name="Name" value="<?php echo $Name; ?>">
<span style="color: red;"><?php echo $Nameerrormessage; ?></span><br />

Address:<input type="text" name="Address" value="<?php echo $Address; ?>">
<span style="color: red;"><?php echo $Addresserrormessage; ?></span><br />

Cell Number (XXX-XXXX):<input type="text" name="CellNumber" value="<?php echo $CellNumber; ?>">
<span style="color: red;"><?php echo $CellNumbererrormessage; ?></span><br />

Home Number(XXX-XXXX):<input type="text" name="HomeNumber" value="<?php echo $HomeNumber; ?>">
<span style="color: red;"><?php echo $HomeNumbererrormessage; ?></span><br />

Email Address:<input type="text" name="Email" value="<?php echo $Email; ?>">
<span style="color: red;"><?php echo $Emailerrormessage; ?></span><br />

<br/>
<input type="submit" value="submit">
-->
<br/>
<center>
<a href='UserMenu.php' class='button'>Click Here to Return to User Menu</a>
</center>
</font>



</body>



</html>