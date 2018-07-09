<?php
$validform=true;

$uid = $_GET['uid'];
echo"The user has entered: " . $uid . "<br/>";

if ($uid==""){
	$validform=false;
	
}
else if(!is_numeric($uid)){
	
	$validform=false;
	
}

	$confirm = $_GET['confirm'];
	if ($confirm=='yes') {
		//delete the record
		echo "Preparing to delete Customer #: ". $uid . "...<br />";
		//echo "Connecting to database server.<br />";
		try {
			//variable stores the connection -> $conn
			//PDO is a php data object -> helps prevent SQL injection
			//host = Database server host name
			//username = name of READ/WRITE user
			//password = that user's password recipe
			$conn = new PDO("mysql:host=db80b.pair.com","mdias001_2_w","uJAvbMP3");
		} catch(PDOException $e) { //this should tell us if there was a connection problem
			echo "Error connecting to server: " . $e->getMessage();
			die;
		}
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		//echo "Connection to server succeeded.<br />";
		//echo "Connecting to database Customer...<br />";
		try {
			//if executing a query, NO USER ENTERED fields should be in query string!
			$conn->query("USE mdias001_OrderEntry");
		} catch (PDOException $e) {
			echo "Error connecting to database: " . $e->getMessage();
			die;
		}
		//echo "Connection to recipes database succeeded.<br />";
		//SQL statement HAS user-entered data, so BIND needed mdias001_recipes
		$SQL = "DELETE FROM Customers WHERE uid=:uid;";
		try {
			$sth = $conn->prepare($SQL);
			$sth->bindParam(":uid", $uid);
			$sth->execute();
		} catch (PDOException $e) {
			echo "Error deleting User ID record: " . $e->getMessage();
			die;
		}
		echo "Customer # " . $uid ." has successfully been deleted. <br /><br/>";
		echo "<a href='Skill3_Retrieve.php'>Click here to return to Customer list.</a><br />";
		die;
	}

//do the rest of the necessary validation
if ($validform==false) {
	echo "Data was invalid. Please contact technical support.";
} else {
	echo "User wants to delete Customer with User ID# ". $uid ."<br />";
	echo "Are you sure you want to delete Customer with User ID# ". $uid ."? ";
	echo "<a href='Skill3_Delete.php?uid=". $uid ."&confirm=yes'>yes</a> | ";
	echo "<a href='Skill3_Retrieve.php'>no</a><br />";
}


?>