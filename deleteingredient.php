<?php 
	$validform = true;
	$rid = $_POST['rid'];
	echo "The user entered rid: ". $rid . "<br />";
	if ($rid=="") {
		$validform = false;
	} else if (!is_numeric($rid)) {
		$validform = false;
	}
	$iid = $_POST['iid'];
	echo "The user entered iid: ". $iid . "<br />";
	if ($iid=="") {
		$validform = false;
	} else if (!is_numeric($iid)) {
		$validform = false;
	}
	//do the rest of the necessary validation!
	$confirm = $_GET['confirm'];
	if ($confirm=='yes') {
		$rid = htmlentities($_GET['rid']); //also need to validate
		$iid = htmlentities($_GET['iid']);
		//delete the record, use cookies to store current values
		echo "Going to delete iid: ". $iid ." from rid: ". $rid . "<br />";
		echo "Connecting to database server.<br />";
		try {
			$conn = new PDO("mysql:host=db126a.pair.com","mdias001_w","T5k8Buf5");
		} catch(PDOException $e) { //this should tell us if there was a connection problem
			echo "Error connecting to server: " . $e->getMessage();
			die;
		}
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$conn->query("USE mdias001_recipes");
		} catch (PDOException $e) {
			echo "Error connecting to database: " . $e->getMessage();
			die;
		}
		echo "Connection to recipes database succeeded.<br />";
//get data from database, store values in cookies
$SQL = "SELECT rid, iid, qty, unit, item, inote FROM ingredient";
		$SQL .= " WHERE rid = :rid AND iid = :iid;"; //this should only return 1 record
		try {
			$sth = $conn->prepare($SQL);
			$sth->bindParam(":rid", $rid); 
			$sth->bindParam(":iid", $iid); 
			$sth->execute();
		} catch (PDOException $e) {
			echo "Error selecting ingredient records: " . $e->getMessage();
			die;
		}
		echo "Query executed successfully. <br />";
		//are there records in the set?
		if($sth->rowCount()!=1) {
			echo "Error.No ingredients returned or more than one ingredient returned.<br />";
			die;
		} 
		//$result is an array that holds the dataset
		$result = $sth->fetch();
			//in an array, refer to column with string inside brackets ['rid']
			echo "Storing values<br/>";
			echo "rid=" . $result['rid'] . "<br/>";
			echo "iid=" . $result['iid'] . "<br/>";
			echo "qty=" . $result['qty'] . "<br/>";
			echo "unit=" . $result['unit'] . "<br/>";
			echo "item=" . $result['item'] . "<br/>";
			echo "inote=" . $result['inote'] . "<br/>";
			setcookie("rid",$result['rid']);
			setcookie("iid",$result['iid']);
			setcookie("qty",$result['qty']);
			setcookie("unit",$result['unit']);
			setcookie("item",$result['item']);
			setcookie("inote",$result['inote']);
// Now that its stored, go ahead and delete the record
		//SQL statement HAS user-entered data, so BIND needed
		$SQL = "DELETE FROM ingredient WHERE rid=:rid AND iid=:iid;";
		try {
			$sth = $conn->prepare($SQL);
			$sth->bindParam(":rid", $rid);
			$sth->bindParam(":iid", $iid);
			$sth->execute();
		} catch (PDOException $e) {
			echo "Error deleting ingredient record: " . $e->getMessage();
			die;
		}
		echo "Ingredient " . $iid ." deleted";
		echo " from Recipe " . $rid .". <br />";
//		header("Location:viewrecipe.php?rid=". $rid);
//		echo "<a href='viewrecipe.php?rid=". $rid ."'>Return to recipe.</a><br />";
		echo"Ingredient Deleted <a href='undodeleteingredient.php'>Undo</a>";
		die;
	}
	
if ($validform==false) {
	echo "Data was invalid. Please contact technical support.";
} else {
	echo "User wants to delete ingredient=". $iid ." from rid=". $rid ."<br />";
/////section with getting data from database
		try {
			$conn = new PDO("mysql:host=db126a.pair.com","mdias001_r","Ysjy3Ueu");
		} catch(PDOException $e) { //this should tell us if there was a connection problem
			echo "Error connecting to server: " . $e->getMessage();
			die;
		}
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {
			$conn->query("USE mdias001_recipes");
		} catch (PDOException $e) {
			echo "Error connecting to database: " . $e->getMessage();
			die;
		}
		$SQL = "SELECT title, item FROM Recipe, ingredient";
		$SQL .= " WHERE Recipe.rid = ingredient.rid"; //this part makes it so the tables are "inner joined"
		$SQL .= " AND Recipe.rid=:rid AND ingredient.iid = :iid;";
		try {
			$sth = $conn->prepare($SQL);
			$sth->bindParam(":rid", $rid);
			$sth->bindParam(":iid", $iid);
			$sth->execute();
		} catch (PDOException $e) {
			echo "Error selecting recipe/ingredient records: " . $e->getMessage();
			die;
		}
		if($sth->rowCount()!=1) {
			echo "Error. No records were returned or more than one record was returned.<br />";
			$validform = false;
		} else {
			echo $sth->rowCount() . " records returned.<br />";
			$result = $sth->fetch();
			$title = $result['title'];
			$item = $result['item'];
		}


////end of section for getting data from database with names of ingredient and recipe	
	echo "Are you sure you want to delete '". $item ."' from your ". $title ." recipe? ";
	echo "<a href='deleteingredient.php?rid=". $rid ."&iid=". $iid ."&confirm=yes'>yes</a> | ";
	echo "<a href='listrecipes.php'>no</a><br />";
}
?>















