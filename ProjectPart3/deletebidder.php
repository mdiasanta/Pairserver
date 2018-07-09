<html>
<style>

header{
	
	text-align:center;
	font-family: Arial;
	
}

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
</style>

<header><h1>Bidder Deletion</h1></header>

</html>
<?php
$validform=true;

$BidderID = $_GET['BidderID'];
//echo"The user entered: " . $BidderID . "<br/>";

if ($BidderID==""){
	$validform=false;
	
}
else if(!is_numeric($BidderID)){
	
	$validform=false;
	
}

	$confirm = $_GET['confirm'];
	if ($confirm=='yes') {
		//delete the record
		//echo "Going to delete Bidder ID: ". $BidderID . "<br />";
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
		$SQL = "DELETE FROM Bidder WHERE BidderID=:BidderID;";
		try {
			$sth = $conn->prepare($SQL);
			$sth->bindParam(":BidderID", $BidderID);
			$sth->execute();
		} catch (PDOException $e) {
			echo "Error deleting recipe record: " . $e->getMessage();
			die;
		}
		echo "<header><h2>Bidder ID " . $BidderID ." had been deleted. </h2></header><br /><br/>";
		echo "<center><a href='AuctionAdminDashboard.php' class='button'>Return to Auction Admin Dashboard.</a></center><br />";
		die;
	}

//do the rest of the necessary validation
if ($validform==false) {
	echo "Data was invalid. Please contact technical support.";
} else {
	//echo "User wants to delete Bidder with Bidder ID=". $BidderID ."<br />";
	echo "<font face='Arial'><center><b>Are you sure you want to delete Bidder #". $BidderID ."? </b></font><br/>";
	echo "<a href='deletebidder.php?BidderID=". $BidderID ."&confirm=yes' class='button'>Yes</a> | ";
	echo "<a href='viewbidder.php' class='button'>No</a></center><br />";
}


?>
