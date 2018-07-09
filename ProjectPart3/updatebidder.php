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

$BidderID = $_GET['BidderID'];

//echo"The user entered: " . $BidderID . "<br/>";
//use GET  values to view current data//If no GET values use POST data values to update
if ($BidderID==""){
	//echo "They didn't use GET. Are they POSTing anything?<br/>";
	$BidderID=$_POST['BidderID'];
	if ($BidderID==''){
		
		$validform=false;
	}
	else{
		
		//echo"The use submitted an update for Bidder ID:" . $BidderID . "<br/>";
		//validation start
		if (is_numeric($BidderID)) {
			if ($BidderID<=0 or $rid > 150) {
				$validform = false;
				$BidderIDerrormessage = 'The Bidder ID must be greater than zero and less than 2147482647.';
			} 
			else {
		//it's okay
			}
		} 
		else {
		$validform = false;
		$BidderIDerrormessage = 'The Bidder ID must be an integer.';
		}
		$Name = htmlentities($_POST['Name']);

		if($Name=='') {
			$validform = false;
			$Nameerrormessage = 'Name is a required field.';
		} else {
			$emptyform = false;
			if (strlen($name)>75) {
				$validform = false;
				$Nameerrormessage = 'The name must be less than 75 characters long.';
			}
		}

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
		$Paid = htmlentities($_POST['Paid']);
		if($Paid==''){
			
			$validform= false;
			$Paiderrormessage='*A Paid Status must be selected';
		}
		//validation finished**************************************************
		if ($validform){
			//echo "Going to update BidderID: " . $BidderID . "<br/>";
			
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
			//echo"Connecting to Database Bidder....<br/>";
			try{
				//if executing query command, NO USER ENTERED fields should be in query string
				$conn->query("USE zbiss001_Auction");		
			
			}
			catch(PDOException $e){
				
				echo"Error Connecting to database: " . $e->getMessage();
				die;
			}
			//echo"Connection to the Bidder database succeeded.<br/>";
			//echo"Preparing SQL statement.<br/>";
			//NO VARIABLES ALLOWED IN SQL
			$SQL=" UPDATE Bidder SET BidderID=:BidderID, Name=:Name, Address=:Address, CellNumber=:CellNumber, HomeNumber=:HomeNumber, Email=:Email, Paid=:Paid";
			//ALL USER ENTERED VALUES are going to be parameters -> variable names that start with a colon
			$SQL.=" WHERE BidderID=:BidderID;";
			//echo "This is the SQL statement: " . $SQL . "<br/>";
			//echo "Preparing to update Bidder record.<br/>";
			try{
				
				$sth = $conn->prepare($SQL);
				$sth ->bindParam(":BidderID", $BidderID);
				$sth ->bindParam(":Name", $Name);
				$sth ->bindParam(":Address", $Address);
				$sth ->bindParam(":CellNumber", $CellNumber);
				$sth ->bindParam(":HomeNumber", $HomeNumber);
				$sth ->bindParam(":Email", $Email);
				$sth ->bindParam(":Paid", $Paid);
				$sth->execute();
			
			}
			catch(PDOException $e){
				
				echo"Error adding Bidder record: " . $e->getMessage();
				die;
			}
			echo "<br/><br/><br/><center><header><h1>Record update Successful!</h1></header></b><br/>";
			Header("Locaton: viewbidder.php");
			echo"<a href='AuctionAdminDashboard.php' class='button'>Click Here to return to the Auction Administrator Dashboard</a></center>";
			die;
			
		}
	}
}
else if(!is_numeric($BidderID)){
	
	$validform=false;
	
}
//echo "Connecting to database.<br/>";
	//connect to the database
	//
	try{
		//variable stores the connection -> $conn
		//PDO = PHP Data Oject -> helps prevent SQL injections
		//hose= Database server host name
		//Username = name of read only user
		//password = that user's password
		//mysql:host="database server", "username","password"
		$conn= new PDO("mysql:host=db77a.pair.com","zbiss001_4_r","3iLZ5tqA");
		$conn-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
	}
	catch(PDOException $e){
			
		echo"Error Connecting to server: " . $e->getMessage();
		die;
	}
	//echo"Connection Successful.<br/>";
	//echo"Connecting to Database Bidder....<br/>";
try{
		//if executing query command, NO USER ENTERED fields should be in query string
		$conn->query("USE zbiss001_Auction");		
		
	}
	catch(PDOException $e){
			
		echo"Error Connecting to database: " . $e->getMessage();
		die;
	}
//echo"Connection to recipes database succeeded.<br/>";

//SQL statement will have have any user-entered data, so PREPARE not needed
$SQL="SELECT BidderID, Name, Address, CellNumber, HomeNumber, Email, Paid FROM Bidder WHERE BidderID=:BidderID;";

try{
			
	$sth=$conn->prepare($SQL);
	$sth->bindParam(":BidderID", $BidderID);
	$sth->execute();

		
}
	catch(PDOException $e){
			
		echo"Error selecting Bidder record: " . $e->getMessage();
		die;
	}
//echo "Query executed sucessfully.<br/>";
//are there records in the set?

if($sth->rowCount()!=1){
	
	echo "Error. No records returned or more than one record was returned<br/>";
	$validform=false;
}
else{
	//echo $sth->rowCount() . " records returned<br/><br/>";
	$result= $sth->fetch();
	$BidderID= $result['BidderID'];
	$Name= $result['Name'];
	$Address= $result['Address'];
	$CellNumber= $result['CellNumber'];
	$HomeNumber= $result['HomeNumber'];
	$Email= $result['Email'];
	$Paid= $result['Paid'];
	
	
}
//$result is an array that holds the dataset
if ($validform==false){
	
	echo "Data was invalid. Please contact technical support.<br/>";
}
else{
	
	echo "<center><header><h1>Update BidderID #" . $BidderID . "</h1></header></center><br/>";
}
	







?>
<html>

<body>

<form action="updatebidder.php" method="post">
<!--
BidderID: <?php echo $BidderID; ?><input type="hidden" name="BidderID" value="<?php echo $BidderID; ?>">
<span style="color: red;"><?php echo $riderrormessage; ?></span><br />

Name:<input type="text" name="Name" value="<?php echo $Name; ?>">
<span style="color: red;"><?php echo $Nameerrormessage; ?></span><br />

Address:<input type="text" name="Address" value="<?php echo $Address; ?>">
<span style="color: red;"><?php echo $Addresserrormessage; ?></span><br />

Cell Number (XXX-XXXX):<input type="text" name="CellNumber" value="<?php echo $CellNumber; ?>">
<span style="color: red;"><?php echo $CellNumbererrormessage; ?></span><br />

Home Number(XXX-XXXX):<input type="text" name="HomeNumber" value="<?php echo $HomeNumber; ?>">
<span style="color: red;"><?php echo $HomeNumbererrormessage; ?></span><br />

Email Address:<input type="text" name="Email" value="<?php echo $Email; ?>">
<span style="color: red;"><?php echo $Emailerrormessage; ?></span><br /><br/>

Paid Status:<br />
<input type="radio" name="Paid" value="1"<?php if ($Paid=='1'){ echo ' checked';} ?>> Paid<br />
<input type="radio" name="Paid" value="0"<?php if ($Paid=='0'){ echo ' checked';} ?>> Not Paid<br />
<span style="color: red;"><?php echo $Paiderrormessage; ?></span><br />

<br/>
<input type="submit" value="submit">
-->

<table align="center">

	<tr>
		<th colspan="3">Update Bidder Entry Form:</th>
	</tr>
	
	<tr>
		<th>Bidder ID:</th>
		<td><?php echo $BidderID; ?><input type="hidden" name="BidderID" value="<?php echo $BidderID; ?>"> </td>
			<td><span style="color: red;"><?php echo $riderrormessage; ?></span></td>
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
		<th>Paid Status:</th>
		<td class="leftjust"><input type="radio" name="Paid" value="1"<?php if ($Paid=='1'){ echo ' checked';} ?>> Paid<br />
			<input type="radio" name="Paid" value="0"<?php if ($Paid=='0'){ echo ' checked';} ?>> Not Paid<br /></td>
			</th>
		<td><span style="color: red;"><?php echo $Paiderrormessage; ?></td>
	</tr>
	
	<tr>
		<td colspan="3"><input type="submit" value="submit"></td>
	</tr>
	
</table>

<br/>
<center>
<a href='AuctionAdminDashboard.php' class='button'>Click Here to go to the Auction Administrator Dashboard</a>
</center>
</form>
</body>
</html>