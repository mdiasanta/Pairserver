<?php

$validform=true;

$rid = $_GET['rid'];

echo"The user entered: " . $rid . "<br/>";
//use GET  values to view current data//If no GET values use POST data values to update
if ($rid==""){
	echo "They didn't use GET. Are they POSTing anything?<br/>";
	$rid=$_POST['rid'];
	if ($rid==''){
		
		$validform=false;
	}
	else{
		
		echo"The use submitted a POST. Add ingredient to:" . $rid . "<br/>";
		//validation start
		if (is_numeric($rid)) {
			if ($rid<=0 or $rid > 2147482647) {
				$validform = false;
				$riderrormessage = 'The recipe ID must be greater than zero and less than 2147482647.';
			} 
			else {
		//it's okay
			}
		} 
		else {
		$validform = false;
		$riderrormessage = 'The recipe ID must be an integer.';
		}
		
		$qty = htmlentities($_POST['qty']);
		if($qty=='') {
			$validform = false;
			$qtyerrormessage = 'Quantity is a required field.';
		} else {
			$emptyform = false;
			if (preg_match("/^[0-9]{1,3}$/", $qty)) {
				if ($qty<=0 or $qty >= 1000) {
					$validform = false;
					$qtyerrormessage = 'The quantity must be between one and 999.';
				} else {
				//it's okay
				}
			} else {
				$validform = false;
				$qtyerrormessage = 'The quantity must be an integer with at most 3 digits.';
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
				$uniterrormessage = 'The title must be less than 30 characters long.';
			}
		}
		$item = htmlentities($_POST['item']);
		$inote = htmlentities($_POST['inote']);

		// Assuming all data was validated
		
		//validation finished
		if ($validform){
			
			echo "Going to add ingredient to rid: " . $rid . "<br/>";
			
			echo "All data was valid.<br/>";
			echo "Connecting to database.<br/>";
			//connect to the database
			//
			try{
				//variable stores the connection -> $conn
				//PDO = PHP Data Oject -> helps prevent SQL injections
				//hose= Database server host name
				//Username = name of read/write user_error
				//password = that user's password
				//mysql:host="database server", "username","password"
				$conn= new PDO("mysql:host=db126a.pair.com","mdias001_w","T5k8Buf5");
				$conn-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
			}
			catch(PDOException $e){
				
				echo"Error Connecting to server: " . $e->getMessage();
				die;
			}
			echo"Connection Successful.<br/>";
			echo"Connecting to Database Recipe....<br/>";
			try{
				//if executing query command, NO USER ENTERED fields should be in query string
				$conn->query("USE mdias001_recipes");		
			
			}
			catch(PDOException $e){
				
				echo"Error Connecting to database: " . $e->getMessage();
				die;
			}
			echo"Connection to the recipe database succeeded.<br/>";
// Begin assign iid sequentially
		$SQL="SELECT MAX(iid) AS Maxiid FROM ingredient WHERE rid=:rid;";
				try{
							
					$sth=$conn->prepare($SQL);
					//Bind Added
					$sth->bindParam(":rid", $rid);
					//$sth->bindParam(":iid", $iid);
					$sth->execute();

						
				}
					catch(PDOException $e){
							
						echo"Error selecting recipe record: " . $e->getMessage();
						die;
					}
				echo "Query executed sucessfully.<br/>";
				//are there records in the set?
				if($sth->rowCount()==0){
					
					echo "No records returned, next iid is 1.<br/>";
					$iid=1;
				}
				else{
					echo $sth->rowCount() . " records returned<br/><br/>";
					$result=$sth->fetch();
					echo "Max IID is " . $result['Maxiid'] . "<br/>";
					if($result['Maxiid']==''){
						$iid=1;
					}
					else{
						$iid=$result['Maxiid'] + 1;
						
					}
					echo "New IID is " . $iid . "<br/>";
					
				}
// End Assign iid sequentially

			echo"Preparing SQL statement.<br/>";
			//NO VARIABLES ALLOWED IN SQL
			$SQL=" INSERT INTO ingredient (rid, iid, qty, unit, item, inote) VALUES";
			//ALL USER ENTERED VALUES are going to be parameters -> variable names that start with a colon
			$SQL.="(:rid, :iid, :qty, :unit, :item, :inote);";
			echo "This is the SQL statement: " . $SQL . "<br/>";
			echo "Preparing to update recipe record.<br/>";
			try{
				
				$sth = $conn->prepare($SQL);
				$sth ->bindParam(":rid", $rid);
				$sth ->bindParam(":iid", $iid);
				$sth ->bindParam(":qty", $qty);
				$sth ->bindParam(":unit", $unit);
				$sth ->bindParam(":item", $item);
				$sth ->bindParam(":inote", $inote);
				$sth->execute();
			
			}
			catch(PDOException $e){
				
				echo"Error adding recipe record: " . $e->getMessage();
				die;
			}
			echo "Records added to database<br/>";
			echo "<a href='listrecipes.php?rid=" . $result['rid'] . "'>List Recipes" . $result[rid] . "</a><br/>";
			Header("Locaton: listrecipes.php?rid=" . $rid);
			die;
			
		}
	}
	
}
else if(!is_numeric($rid)){
	
	$validform=false;
	
}
echo "Connecting to database.<br/>";
	//connect to the database
	//
	try{
		//variable stores the connection -> $conn
		//PDO = PHP Data Oject -> helps prevent SQL injections
		//hose= Database server host name
		//Username = name of read only user
		//password = that user's password
		//mysql:host="database server", "username","password"
		$conn= new PDO("mysql:host=db126a.pair.com","mdias001_r","Ysjy3Ueu");
		$conn-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
	}
	catch(PDOException $e){
			
		echo"Error Connecting to server: " . $e->getMessage();
		die;
	}
	echo"Connection Successful.<br/>";
	echo"Connecting to Database Recipe....<br/>";
try{
		//if executing query command, NO USER ENTERED fields should be in query string
		$conn->query("USE mdias001_recipes");		
		
	}
	catch(PDOException $e){
			
		echo"Error Connecting to database: " . $e->getMessage();
		die;
	}
echo"Connection to recipes database succeeded.<br/>";

//SQL statement will have have any user-entered data, so PREPARE not needed
$SQL="SELECT rid, title, card, servingqty, servingtype, timeprepqty, timecookqty, cat, picture FROM Recipe WHERE rid=:rid;";

try{
			
	$sth=$conn->prepare($SQL);
	$sth->bindParam(":rid", $rid);
	$sth->execute();

		
}
	catch(PDOException $e){
			
		echo"Error selecting recipe record: " . $e->getMessage();
		die;
	}
echo "Query executed sucessfully.<br/>";
//are there records in the set?
if($sth->rowCount()!=1){
	
	echo "Error. No records returned or more than one record was returned<br/>";
	$validform=false;
}
else{
	echo $sth->rowCount() . " records returned<br/><br/>";
	$result= $sth->fetch();
	$rid= $result['rid'];
	$title=$result['title'];
	$card=$result['card'];
	$servingqty=$result['servingqty'];
	$servingtype=$result['servingtype'];
	$timeprepqty=$result['timeprepqty'];
	$timecookqty=$result['timecookqty'];
	$cat=$result['cat'];
	
	
}
//$result is an array that holds the dataset
if ($validform==false){
	
	echo "Data was invalid. Please contact technical support.<br/>";
}
else{
	
	echo "User wants to update recipe with rid=" . $rid . "<br/>";
}
	







?>
<html>
<body>


Add Ingredients to Recipe #: <?php echo $rid; ?><input type="hidden" name="rid" value="<?php echo $rid; ?>">
<span style="color: red;"><?php echo $riderrormessage; ?></span><br />

<?php
$SQL="SELECT rid, iid, qty, unit, item, inote FROM ingredient";
$SQL .=" WHERE rid >= :rid ORDER BY iid;";// ORDER BY puts in ascending order

try{
			
	$sth=$conn->prepare($SQL);
	//Bind Added
	$sth->bindParam(":rid", $rid);
	
	$sth->execute();

		
}
	catch(PDOException $e){
			
		echo"Error selecting ingredient records: " . $e->getMessage();
		die;
	}
echo "Query executed sucessfully.<br/>";
//are there records in the set?
if($sth->rowCount()==0){
	
	echo "No records returned<br/>";
	//die;
}
else{
	echo $sth->rowCount() . " records returned<br/><br/>";
	
}
//Create a table
echo"<style>
table, th, td {
    border: 1px solid black;
}
</style>";
echo "<table>";
echo "<tr><th>Ingred. ID</th><th>Qty</th><th>Unit</th><th>Item</th><th>Item Note</th>";
echo "<tr><td align='right'>" . $result['rid'] . "</td></tr>";
//$result is an array that holds the dataset
while($result= $sth->fetch()){
	
	echo "<tr><td align='right'>" . $result['iid'] . "</td>";
		echo"<td align right'>" . $result['qty'] . "</td>";
		echo"<td align right'>" . $result['unit'] . "</td>";
		echo"<td align right'>" . $result['item'] . "</td>";
		echo"<td align right'>" . $result['inote'] . "</td>";
		echo"<td>";
		echo"<form action='deleteingredient.php' method='post'>";
		echo"<input type='text' name='rid' value='".$result['rid']."'>";
		echo"<input type='text' name='rid' value='".$result['iid']."'>";
		echo"<td>";
		echo"<td><input type='submit' value='Delete'></td>";
	echo"</tr>";
	}


?>
<form action="viewrecipe.php" method="post">
<tr style="background-color: #CCCC00">
<tr></tr>
<td></td>
<td>Quantity: <input type="text" size="2" name="qty" value="<?php echo $qty; ?>"></td>

<td>Unit: <input type="text" size="8" name="unit" value="<?php echo $unit; ?>"></td>

<td>Item: <input type="text" size="12" name="item" value="<?php echo $item; ?>"></td>

<td>Item Note: <input type="text" size="8" name="inote" value="<?php echo $inote; ?>"></td>
<td><input type="submit"></td>

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

<!--End of Table-->
</table>

<br/>
<a href='listrecipes.php'> Click here to Return to List Recipes</a><br/>

</form>
</body>
</html>