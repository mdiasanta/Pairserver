<?php 
	$validform = true;
	$rid = $_GET['rid'];
	if ($rid=="") {
		echo "They didn't use GET. Are they POSTing anything? </br>";
		$rid = $_POST['rid'];
		if ($rid==''){
			$validform = false;
		} else {
			echo "The user submitted a POST. Add ingredient to: ". $rid . "<br />";
			if (is_numeric($rid)) {
				if ($rid<=0 or $rid > 2147482647) {
					$validform = false;
					$riderrormessage = 'The recipe ID must be greater than zero and less than 2147482647.';
				} else {
				//it's okay
				}
			} else {
				$validform = false;
				$riderrormessage = 'The recipe ID must be an integer.';
			}
			/////////////////////////Here we will validate ingredient instead of recipe
			$qty = htmlentities($_POST['qty']);
			if($qty=='') {
				$validform = false;
				$qtyerrormessage = '*Required';
			} else {
				$emptyform = false;
				if (preg_match("/^[0-9]{1,3}$/", $qty)) {
					if ($qty<=0 or $qty >= 1000) {
						$validform = false;
						$qtyerrormessage = 'Must be between one and 999';
					} else {
					//it's okay
					}
				} else {
					$validform = false;
					$qtyerrormessage = 'Must be an integer with at most 3 digits';
				}
			}
			$unit = htmlentities($_POST['unit']);
			if($unit=='') {
				$validform = false;
				$uniterrormessage = 'The unit is a required field.';
			} else {
				$emptyform = false;
				if (strlen($unit)>30) {
					$validform = false;
					$uniterrormessage = 'The unit must be less than 30 characters long.';
				}
			}
			$item = htmlentities($_POST['item']);
			$inote = htmlentities($_POST['inote']);
			/* Assuming all of the data was validated 
			*/

//validation finished			
			if ($validform) {
				echo "Going to add ingredient to rid: ". $rid . "<br />";
				echo "All data was valid.<br />";
				echo "Connecting to database server.<br />";
				try {
					//variable stores the connection -> $conn
					//PDO is a php data object -> helps prevent SQL injection
					//host = Database server host name
					//username = name of read/write user
					//password = that user's password
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
					$conn->query("USE mdias001_recipes");
				} catch (PDOException $e) {
					echo "Error connecting to database: " . $e->getMessage();
					die;
				}
				echo "Connection to recipes database succeeded.<br />";
///begin assign iid sequentially
		$SQL = "SELECT MAX(iid) AS Maxiid FROM ingredient WHERE rid=:rid;";
		try {
			$sth = $conn->prepare($SQL);
			$sth->bindParam(":rid", $rid);
			$sth->execute();
		} catch (PDOException $e) {
			echo "Error selecting ingredient records: " . $e->getMessage();
			die;
		}
		echo "Query executed successfully. <br />";
		//are there records in the set?
		if($sth->rowCount()==0) {
			echo "No records returned, next iid is 1.<br />";
			$iid = 1;
		} else {
			echo $sth->rowCount() . " records returned.<br />";
			$result = $sth->fetch();
			echo "Max iid is ". $result['Maxiid'] ."<br />";
			if ($result['Maxiid']=='') {
				$iid = 1;
			} else {
				$iid = $result['Maxiid'] + 1;
			} 
			echo "Next iid is ". $iid ."<br />";
		}
//end assign iid sequentially
				echo "Preparing SQL statement.<br />";
				//NO VARIABLES ALLOWED IN SQL
				//ALL USER ENTERED VALUES are going to be parameters -> variable names that start with a colon
				$SQL = "INSERT INTO ingredient (rid, iid, qty, unit, item, inote) VALUES ";
				$SQL .= "(:rid, :iid, :qty, :unit, :item, :inote);";
				echo "This is the SQL statement: " . $SQL . "<br />";
				echo "Preparing to update recipe record. <br />";
				try {
					$sth = $conn->prepare($SQL);
					$sth->bindParam(":rid", $rid);
					$sth->bindParam(":iid", $iid);
					$sth->bindParam(":qty", $qty);
					$sth->bindParam(":unit", $unit);
					$sth->bindParam(":item", $item);
					$sth->bindParam(":inote", $inote);
					$sth->execute();
				} catch (PDOException $e) {
					echo "Error adding ingredient record: " . $e->getMessage();
					die;
				}
				echo "Record updated in database. <br />";
				Header("Location: viewrecipe.php?rid=". $rid);

				die;
			}
		}
	} else if (!is_numeric($rid)) {
		$validform = false;
	}
	echo "The user entered rid: ". $rid . "<br />";
		echo "Connecting to database server.<br />";
		try {
			//variable stores the connection -> $conn
			//PDO is a php data object -> helps prevent SQL injection
			//host = Database server host name
			//username = name of READ ONLY user
			//password = that user's password
			$conn = new PDO("mysql:host=db126a.pair.com","mdias001_r","Ysjy3Ueu");
		} catch(PDOException $e) { //this should tell us if there was a connection problem
			echo "Error connecting to server: " . $e->getMessage();
			die;
		}
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		echo "Connection to server succeeded.<br />";
		echo "Connecting to database recipes...<br />";
		try {
			//if executing a query, NO USER ENTERED fields should be in query string!
			$conn->query("USE mdias001_recipes");
		} catch (PDOException $e) {
			echo "Error connecting to database: " . $e->getMessage();
			die;
		}
		echo "Connection to recipes database succeeded.<br />";
		//SQL statement will have user-entered data, so BIND needed
		$SQL = "SELECT rid, title, card, servingqty, servingtype";
		$SQL .= ", timeprepqty, timecookqty, cat, picture FROM Recipe WHERE rid=:rid;";
		try {
			$sth = $conn->prepare($SQL);
			$sth->bindParam(":rid", $rid);
			$sth->execute();
		} catch (PDOException $e) {
			echo "Error selecting recipe records: " . $e->getMessage();
			die;
		}
		echo "Query executed successfully. <br />";
		//is there one record in the set?
		if($sth->rowCount()!=1) {
			echo "Error. No records were returned or more than one record was returned.<br />";
			$validform = false;
		} else {
			echo $sth->rowCount() . " records returned.<br />";
			$result = $sth->fetch();
			$rid = $result['rid'];
			$title = $result['title'];
			$card = $result['card'];
			$servingqty = $result['servingqty'];
			$servingtype = $result['servingtype'];
			$timeprepqty = $result['timeprepqty'];
			$timecookqty = $result['timecookqty'];
			$cat = $result['cat'];
			$picture = $result['picture'];
		}
		//$result is an array that holds the dataset

	
if ($validform==false) {
	echo "Data was invalid. Please contact technical support.";
} else {
	echo "User wants to update recipe with rid=". $rid ."<br />";
}
?>
<html>
<!--javascript functions go in header-->
<head>
<script>

function deleteRecord(rid,iid){
	
	var html;
	html="Are you sure?";
	html+="<a href='deleteingredient.php?rid="+ rid +"&iid="+ iid +"&confirm=yes'>";
	html+="Yes</a>";
	html+=" <a href='#' onclick='return false;'>No</a>";
	document.getElementById("delete"+iid).innerHTML = html;
	
	
}
</script>
</head>
<body>
Add Ingredients to Recipe #<?php echo $rid; ?>, <?php echo $title; ?> 


<?php
		$SQL = "SELECT rid, iid, qty, unit, item, inote FROM ingredient";
		$SQL .= " WHERE rid = :rid ORDER BY iid;"; //ORDER BY puts in ascending order
		try {
			$sth = $conn->prepare($SQL);
			$sth->bindParam(":rid", $rid); 
			$sth->execute();
		} catch (PDOException $e) {
			echo "Error selecting ingredient records: " . $e->getMessage();
			die;
		}
		echo "Query executed successfully. <br />";
		//are there records in the set?
		if($sth->rowCount()==0) {
			echo "No ingredients returned.<br />";
			//die;
		} else {
			echo $sth->rowCount() . " ingredients returned.<br />";
		}
		//$result is an array that holds the dataset
		echo "<table border='1'>";
		echo "<tr><th>Ingred. ID</th><th>Qty</th><th>Unit</th><th>Item</th><th>Item Note</th></tr>";
		while($result = $sth->fetch()) {
			//in an array, refer to column with string inside brackets ['rid']
////pick up here next class, going to make a table
			echo "<tr><td align='right'>" . $result['iid'] . "</td>";
			echo "<td align='right'>" . $result['qty'] . "</td>";
			echo "<td align='right'>" . $result['unit'] . "</td>";
			echo "<td align='right'>" . $result['item'] . "</td>";
			echo "<td align='right'>" . $result['inote'] . "</td>";
			//JAVASCRIPT*************************
			echo "<td id='delete"  . $result['iid'] . "'>";
//*********************************************************************************************
?>

<form action='deleteingredient.php' method='post'>
<input type='hidden' name='rid' value='<?php echo $result['rid'] ?>'>
<input type='hidden' name='iid' value='<?php echo $result['iid'] ?>'>
<input type='button' value='Delete' onclick='deleteRecord(<?php echo $result['rid'] ?>,<?php echo $result['iid'] ?>);'>
</form>

<?php
			
			echo "</td>";
			echo "</tr>";
		}
//		echo "</table>";

?>
<form action="viewrecipe.php" method="post">
<tr style="background-color: #AAAA00">
<td><input type="hidden" name="rid" value="<?php echo $rid; ?>"></td>
<td><input type="text" size="2" name="qty" value="<?php echo $qty; ?>"></td>
<td><input type="text" size="6" name="unit" value="<?php echo $unit; ?>"></td>
<td><input type="text" size="12" name="item" value="<?php echo $item; ?>"></td>
<td><input type="text" size="8" name="inote" value="<?php echo $inote; ?>"></td>
<td><input type="submit" value="Add New"></td>
</tr>
<?php 
if (!$validform) {
	echo "<tr>";
	echo "<td></td>";
	echo "<td><span style='color: red;'>". $qtyerrormessage ."</span></td>";
	echo "<td><span style='color: red;'>". $uniterrormessage ."</span></td>";
	echo "<td><span style='color: red;'>". $itemerrormessage ."</span></td>";
	echo "<td><span style='color: red;'>". $inoteerrormessage ."</span></td>";
	echo "</tr>";
}
?>
</form>
</table>
</body>
</html>
