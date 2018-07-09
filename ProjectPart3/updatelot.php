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
header{
	
	font-family: Arial;
	text-align: center;
}

</style>
<header><h1>Update Lot Information</h1></header>
</html>
<?php

$validform=true;

$LotID = $_GET['LotID'];

//echo"The user entered: " . $LotID . "<br/>";
//use GET  values to view current data//If no GET values use POST data values to update
if ($LotID==""){
	//echo "They didn't use GET. Are they POSTing anything?<br/>";
	$LotID=$_POST['LotID'];
	if ($LotID==''){
		
		$validform=false;
	}
	else{
		
		echo"<center><header><h1>The use submitted an update for Bidder ID:" . $LotID . "</h1></header></center><br/>";
		//validation start
		$Description = htmlentities($_POST['Description']);
		if($Description=='') {
			$validform = false;
			$Descriptionerrormessage = 'Description is a required field.<br />';
		} else {
			$emptyform = false;
			if (strlen($Description)>999) {
				$validform = false;
				$Descriptionrormessage = 'Description must be less than 999 characters long.<br />';
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
		//validation finished**************************************************
		if ($validform){
			//echo "Going to update LotID: " . $LotID . "<br/>";
			
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
			$SQL=" UPDATE Lot SET LotID=:LotID, Description=:Description, CategoryID=:CategoryID, WinningBidder=:WinningBidder, Delivered=:Delivered";
			//ALL USER ENTERED VALUES are going to be parameters -> variable names that start with a colon
			$SQL.=" WHERE LotID=:LotID;";
			//echo "This is the SQL statement: " . $SQL . "<br/>";
			//echo "Preparing to update Bidder record.<br/>";
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
				
				echo"Error adding Lot record: " . $e->getMessage();
				die;
			}
			echo "<center><header><h2>The Record has been updated<h2></header></center><br/>";
			Header("Locaton: viewlot.php");
			echo"<center><a href='AuctionAdminDashboard.php' class='button'>Click Here to return to the Auction Administrator Dashboard</a></center>";
			die;
			
		}
	}
}
else if(!is_numeric($LotID)){
	
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
//echo"Connection to Bidder database succeeded.<br/>";

//SQL statement will have have any user-entered data, so PREPARE not needed
$SQL="SELECT LotID, Description, CategoryID, WinningBidder, Delivered FROM Lot WHERE LotID=:LotID;";

try{
			
	$sth=$conn->prepare($SQL);
	$sth->bindParam(":LotID", $LotID);
	$sth->execute();

		
}
	catch(PDOException $e){
			
		echo"Error selecting Lot record: " . $e->getMessage();
		die;
	}
//echo "Query executed sucessfully.<br/>";
//are there records in the set?

if($sth->rowCount()!=1){
	
	echo "Error. No records returned or more than one record was returned<br/>";
	$validform=false;
}
else{
	echo"<center>" . $sth->rowCount() . " record returned</center><br/>";
	$result= $sth->fetch();
	$LotID= $result['LotID'];
	$Description= $result['Description'];
	$CategoryID= $result['CategoryID'];
	$WinningBidder= $result['WinningBidder'];
	$Delivered= $result['Delivered'];
	
	
}
//$result is an array that holds the dataset
if ($validform==false){
	
	echo "Data was invalid. Please contact technical support.<br/>";
}
else{
	
	//echo "User wants to update Lot with LotID=" . $LotID . "<br/>";
}
	







?>
<html>
<body>
<form action="updatelot.php" method="post">

<font face="Arial">


<table align="center">

	<tr>
		<th colspan="3">Lot Entry Form:</th>
	</tr>
	
	<tr>
		<th>Lot ID:</th>
		<td><?php echo $LotID; ?><input type="hidden" name="LotID" value="<?php echo $LotID; ?>"> </td>
			<td><span style="color: red;"><?php echo $LotIDerrormessage; ?></span></td>
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
<br/><center><a href='AuctionAdminDashboard.php' class='button'>Click Here to go to the Auction Administrator Dashboard</a></center>

</font>
</form>
</body>
</html>