<?php
$validform=true;

$uid = $_GET['uid'];
$fname = htmlentities($_POST['fname']);
$lname = htmlentities($_POST['lname']);
$address = htmlentities($_POST['address']);
$city = htmlentities($_POST['city']);
$state = htmlentities($_POST['state']);
$zip = htmlentities($_POST['zip']);


echo"The user entered: " . $uid . "<br/>";

if ($uid==""){
	echo "They didn't use GET. Are they POSTing anything?<br/>";
	$uid=$_POST['uid'];
	if ($uid==''){
		
		$validform=false;
	}
	else{
		
		echo"The use submitted an update for uid:" . $uid . "<br/>";
		
		if (is_numeric($uid)) {
				if ($uid<=0 or $uid > 999) {
					$validform = false;
					$uiderrormessage = 'Invalid UID length';
				} else {
				//it's okay
				}
			} else {
				$validform = false;
				$uiderrormessage = 'The User ID must be an integer.';
			}
		if($fname=='') {
			$validform = false;
			$fnameerrormessage = 'The First Name is a required field.';
		} else {
			$emptyform = false;
			if (strlen($fname)>30) {
				$validform = false;
				$fnameerrormessage = 'The First Name must be less than 30 characters long.';
			}
		}
		if($lname=='') {
			$validform = false;
			$lnameerrormessage = 'The First Name is a required field.';
		} else {
			$emptyform = false;
			if (strlen($lname)>30) {
				$validform = false;
				$lnameerrormessage = 'The Last Name must be less than 30 characters long.';
			}
		}
		if($address=='') {
			$validform = false;
			$addresserrormessage = 'The address is a required field.';
		} else {
			$emptyform = false;
			if (strlen($address)>30) {
				$validform = false;
				$addresserrormessage = 'The address must be less than 30 characters long.';
			}
		}
		if($city=='') {
			$validform = false;
			$cityerrormessage = 'The city is a required field.';
		} else {
			$emptyform = false;
			if (strlen($city)>30) {
				$validform = false;
				$cityerrormessage = 'The city must be less than 30 characters long.';
			}
		}
		if($state=='') {
			$validform = false;
			$stateerrormessage = 'The state is a required field.';
		} else {
			$emptyform = false;
			if (strlen($state)>30) {
				$validform = false;
				$stateerrormessage = 'The state must be less than 30 characters long.';
			}
		}
		if($zip=='') {
			$validform = false;
			$ziperrormessage = 'zip code is a required field.';
		} 
		else {
			$emptyform = false;
			if (preg_match("/^[0-9]{5}$/", $zip)) {
				/*if ($zip<=0 or $zip >= 9999) {
					$validform = false;
					$ziperrormessage = 'The zip code must be between one and 999.';
				} else {
				//it's okay
				}*/
			} 
			else {
				$validform = false;
				$ziperrormessage = 'The zip code must be an integer with 5 digits.';
			}

			
		}
		if ($emptyform == true) {
			$uiderrormessage = '';
			$fnameerrormessage = '';
			$lnameerrormessage = '';
			$cityerrormessage = '';
			$addresserrormessage = '';
			$stateerrormessage = '';
			$ziperrormessage = '';
			
		} 
		//validation complete
		if ($validform){
								
								echo "Going to update UID: " . $uid . "<br/>";
								
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
									$conn= new PDO("mysql:host=db80b.pair.com","mdias001_2_w","uJAvbMP3");
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
									$conn->query("USE mdias001_OrderEntry");		
								
								}
								catch(PDOException $e){
									
									echo"Error Connecting to database: " . $e->getMessage();
									die;
								}
								echo"Connection to the recipe database succeeded.<br/>";
								echo"Preparing SQL statement.<br/>";
								//NO VARIABLES ALLOWED IN SQL
								$SQL=" UPDATE Customers SET uid=:uid, fname=:fname, lname=:lname, address=:address, city=:city, state=:state, zip=:zip";
								//ALL USER ENTERED VALUES are going to be parameters -> variable names that start with a colon
								$SQL.=" WHERE uid=:uid;";
								echo "This is the SQL statement: " . $SQL . "<br/>";
								echo "Preparing to update Customer record.<br/>";
								try{
									
									$sth = $conn->prepare($SQL);
									$sth ->bindParam(":uid", $uid);
									$sth ->bindParam(":fname", $fname);
									$sth ->bindParam(":lname", $lname);
									$sth ->bindParam(":address", $address);
									$sth ->bindParam(":city", $city);
									$sth ->bindParam(":state", $state);
									$sth ->bindParam(":zip", $zip);
									$sth->execute();
								
								}
								catch(PDOException $e){
									
									echo"Error adding Customer record: " . $e->getMessage();
									die;
								}
								echo "Records added to database<br/>";
								echo "<a href='Skill3_Retrieve.php'>Click Here to Return to Customer List</a><br/>";
								Header("Locaton: Skill1_SQL.php");
								die;
								
		}
	}
}//end of first if statement
else if(!is_numeric($uid)){
	
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
		$conn= new PDO("mysql:host=db80b.pair.com","mdias001_2_r","7hsL5K6H");
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
		$conn->query("USE mdias001_OrderEntry");		
		
	}
	catch(PDOException $e){
			
		echo"Error Connecting to database: " . $e->getMessage();
		die;
	}
echo"Connection to recipes database succeeded.<br/>";

//SQL statement will have have any user-entered data, so PREPARE not needed
$SQL="SELECT uid, fname, lname, address, city, state, zip FROM Customers WHERE uid=:uid;";

try{
			
	$sth=$conn->prepare($SQL);
	$sth->bindParam(":uid", $uid);
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
	$uid= $result['uid'];
	$fname=$result['fname'];
	$lname=$result['lname'];
	$address=$result['address'];
	$city=$result['city'];
	$state=$result['state'];
	$zip=$result['zip'];
	
	
}
//$result is an array that holds the dataset
if ($validform==false){
	
	echo "Data was invalid. Please contact technical support.<br/>";
}
else{
	
	echo "User wants to update Customer with UID=" . $uid . "<br/>";
}













?>

<html>
<body>
<form action="Skill3_Update.php" method="post">
<header><h1>Edit Customer Information Entry Form</h1><h2>Please Enter the Following Information: </h2></header>

Enter User ID:<input type="text" name="uid" value="<?php echo $uid; ?>">
<span style="color: red;"><?php echo $uiderrormessage; ?></span><br/>

Enter First Name:<input type="text" name="fname" value="<?php echo $fname; ?>">
<span style="color: red;"><?php echo $fnameerrormessage; ?></span><br/>

Enter Last Name:<input type="text" name="lname" value="<?php echo $lname; ?>">
<span style="color: red;"><?php echo $lnameerrormessage; ?></span><br/>

Enter Address:<input type="text" name="address" value="<?php echo $address; ?>">
<span style="color: red;"><?php echo $addresserrormessage; ?></span><br/>

Enter City:<input type="text" name="city" value="<?php echo $city; ?>">
<span style="color: red;"><?php echo $cityerrormessage; ?></span><br/>

Enter State:<input type="text" name="state" value="<?php echo $state; ?>">
<span style="color: red;"><?php echo $stateerrormessage; ?></span><br/>

Enter Zip:<input type="text" name="zip" value="<?php echo $zip; ?>">
<span style="color: red;"><?php echo $ziperrormessage; ?></span><br/>

<input type="submit">

<br/><br/><a href='Skill3_Retrieve.php'>Click here to Go back to Customer list.</a><br />
</body>
</html>