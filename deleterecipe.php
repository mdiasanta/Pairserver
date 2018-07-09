<?php
$validform=true;

$rid = $_GET['rid'];
echo"The user entered: " . $rid . "<br/>";

if ($rid==""){
	$validform=false;
	
}
else if(!is_numeric($rid)){
	
	$validform=false;
	
}

	$confirm = $_GET['confirm'];
	if ($confirm=='yes') {
		//delete the record
		echo "Going to delete rid: ". $rid . "<br />";
		echo "Connecting to database server.<br />";
		try {
			//variable stores the connection -> $conn
			//PDO is a php data object -> helps prevent SQL injection
			//host = Database server host name
			//username = name of READ/WRITE user
			//password = that user's password recipe
			$conn = new PDO("mysql:host=db126a.pair.com","mdias001_w","T5k8Buf5");
		} catch(PDOException $e) { //this should tell us if there was a connection problem
			echo "Error connecting to server: " . $e->getMessage();
			die;
		}
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "Connection to server succeeded.<br />";
		echo "Connecting to database recipes...<br />";
		try {
			//if executing a query, NO USER ENTERED fields should be in query string!
			$conn->query("USE mdias001_recipes;");
		} catch (PDOException $e) {
			echo "Error connecting to database: " . $e->getMessage();
			die;
		}
		echo "Connection to recipes database succeeded.<br />";
		//SQL statement HAS user-entered data, so BIND needed mdias001_recipes
		$SQL = "DELETE FROM Recipe WHERE rid=:rid;";
		try {
			$sth = $conn->prepare($SQL);
			$sth->bindParam(":rid", $rid);
			$sth->execute();
		} catch (PDOException $e) {
			echo "Error deleting recipe record: " . $e->getMessage();
			die;
		}
		echo "Recipe " . $rid ." deleted. <br />";
		echo "<a href='listrecipes.php'>Return to recipe list.</a><br />";
		die;
	}

//do the rest of the necessary validation
if ($validform==false) {
	echo "Data was invalid. Please contact technical support.";
} else {
	echo "User wants to delete recipe with rid=". $rid ."<br />";
	echo "Are you sure you want to delete recipe #". $rid ."? ";
	echo "<a href='deleterecipe.php?rid=". $rid ."&confirm=yes'>yes</a> | ";
	echo "<a href='listrecipes.php'>no</a><br />";
}


?>