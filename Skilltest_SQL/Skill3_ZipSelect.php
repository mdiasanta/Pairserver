<?php
$BegZip=htmlentities($_GET["BegZip"]);
$EndZip=htmlentities($_GET["EndZip"]);
echo "<header><h1>Zip Code Specified Customer List</h1></header>";
echo "<b>Displaying records with Zip Codes between " . $BegZip . " and " . $EndZip . ".</b><br/>";

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
		$conn= new PDO("mysql:host=db80b.pair.com","mdias001_2_w","uJAvbMP3");
		$conn-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			
	}
	catch(PDOException $e){
			
		echo"Error Connecting to server: " . $e->getMessage();
		die;
	}
	//echo"Connection Successful.<br/>";
	//echo"Connecting to Database Customer....<br/>";
try{
		//if executing query command, NO USER ENTERED fields should be in query string
		$conn->query("USE mdias001_OrderEntry");		
		
	}
	catch(PDOException $e){
			
		echo"Error Connecting to database: " . $e->getMessage();
		die;
	}
//echo"Connection to Customer database succeeded.<br/>";
//CONTINUE HERE*********************************************************************************************************************************************************************
//SQL statement will NOT have any user-entered data, so PREPARE not needed
/*$SQL="SELECT fname, lname, zip, uid FROM Customers";

try{
			
	$sth=$conn->prepare($SQL);
	$sth->execute();

		
}
	catch(PDOException $e){
			
		echo"Error selecting Zip record: " . $e->getMessage();
		die;
	}*/
$SQL="SELECT fname, lname, zip, uid FROM Customers";
$SQL .=" WHERE zip >= :BegZip AND zip <= :EndZip ORDER BY lname;";

try{
			
	$sth=$conn->prepare($SQL);
	//Bind Added
	$sth->bindParam(":BegZip", $BegZip);
	$sth->bindParam(":EndZip", $EndZip);
	
	$sth->execute();

		
}
catch(PDOException $e){
			
		echo"Error selecting recipe record: " . $e->getMessage();
		die;
	}
	
//echo "Query executed sucessfully.<br/>";
//are there records in the set?
if($sth->rowCount()==0){
	
	echo "No records returned<br/>";
	echo "<a href='Skill3_Retrieve.php" . $result['uid'] . "'>Click Here to Return to Customer List" . $result[uid] . "</a><br/>";
	die;
}
else{
	echo $sth->rowCount() . "<b> records returned</b><br/><br/>";
	
	
}
//$result is an array that holds the dataset
while($result= $sth->fetch()){
	
	echo "Last Name: " . $result['lname'] . "<br/>";
	echo "First Name: " . $result['fname'] . "<br/>";
	echo "User ID: " . $result['uid'] . "<br/>";
	echo "Zip Code: " . $result['zip'] . "<br/>";	
	echo "<a href='Skill3_Delete.php?uid=" . $result['uid'] . "'>Delete User #" . $result[uid] . "</a><br/>";
	echo "<a href='Skill3_Update.php?uid=" . $result['uid'] . "'>Update User #" . $result[uid] . "</a><br/><br/>";
	}


?>


<html>
<body>
<a href="http://mdias001.pairserver.com/Skilltest_SQL/Skill3_Retrieve.php"><b>Click Here To Return to Customer List</b></a>


</body>
</html>