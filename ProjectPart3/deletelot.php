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
header{
	
	text-align:center;
}
</style>
<font face="Arial">
</html>
<?php
$validform=true;

$LotID = $_GET['LotID'];
//echo"The user entered: " . $LotID . "<br/>";

if ($LotID==""){
	$validform=false;
	
}
else if(!is_numeric($LotID)){
	
	$validform=false;
	
}

	$confirm = $_GET['confirm'];
	if ($confirm=='yes') {
		//delete the record
		//echo "Going to delete Lot ID: ". $LotID . "<br />";
		//echo "Connecting to database server.<br />";
		try {
			//variable stores the connection -> $conn
			//PDO is a php data object -> helps prevent SQL injection
			//host = Database server host name
			//username = name of READ/WRITE user
			//password = that user's password recipe
			$conn = new PDO("mysql:host=db77a.pair.com","zbiss001_4_w","pC2bCnsn");
		} catch(PDOException $e) { //this should tell us if there was a connection problem
			echo "Error connecting to server: " . $e->getMessage();
			die;
		}
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Connection to server succeeded.<br />";
		//echo "Connecting to database recipes...<br />";
		try {
			//if executing a query, NO USER ENTERED fields should be in query string!
			$conn->query("USE zbiss001_Auction;");
		} catch (PDOException $e) {
			echo "Error connecting to database: " . $e->getMessage();
			die;
		}
		//echo "Connection to recipes database succeeded.<br />";
		//SQL statement HAS user-entered data, so BIND needed mdias001_recipes
		$SQL = "DELETE FROM Lot WHERE LotID=:LotID;";
		try {
			$sth = $conn->prepare($SQL);
			$sth->bindParam(":LotID", $LotID);
			$sth->execute();
		} catch (PDOException $e) {
			echo "Error deleting Lot record: " . $e->getMessage();
			die;
		}
		echo "<header><h1>Lot ID " . $LotID ." has been deleted </h1><header><br />";
		echo "<a href='AuctionAdminDashboard.php' class='button'>Return to Auction Administrator Dashboard.</a><br />";
		die;
	}

//do the rest of the necessary validation
if ($validform==false) {
	echo "Data was invalid. Please contact technical support.";
} else {
	echo "User wants to delete Lot with Lot ID=". $LotID ."<br /><br />";
	echo "<b>Are you sure you want to delete Lot #". $LotID ."?</b><br/>. ";
	echo "<a href='deletelot.php?LotID=". $LotID ."&confirm=yes' class='button'>yes</a> | ";
	echo "<a href='viewlot.php' class='button'>no</a><br />";
}


?>
<html>
</font>
</html>