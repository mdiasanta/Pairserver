<?php
//To check if cookie is stored, use this statement
//echo $_COOKIE["rid"];

$rid=htmlentities($_COOKIE["rid"]);
$iid=htmlentities($_COOKIE["iid"]);
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
			$qty = htmlentities($_COOKIE['qty']);
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
			$unit = htmlentities($_COOKIE['unit']);
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
			$item = htmlentities($_COOKIE['item']);
			$inote = htmlentities($_COOKIE['inote']);
			/* Assuming all of the data was validated 
			*/
}
echo "Going to restore rid=" . $rid . ", iid=" . $iid . "<br/>";

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
		
$SQL="INSERT INTO ingredient (rid, iid, qty, unit, item, inote)";
$SQL.="VALUES(:rid, :iid, :qty, :unit, :item, :inote);";

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
			echo "Error selecting ingredient records: " . $e->getMessage();
			die;
		}
		echo "Record Stored Successfully. <br />";
		echo "<a href='viewrecipe.php?rid=" . $rid ."'> Return to View Recipe</a><br/>";


?>