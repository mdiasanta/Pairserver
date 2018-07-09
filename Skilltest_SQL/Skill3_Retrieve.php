<html>
<body>
<header><h1>Customer Table</h1>
<h2>

To add records to the database<a href="http://mdias001.pairserver.com/Skilltest_SQL/Skill1_SQL.php"> Click Here</a><br/>
</h2>

<form method="get" action="Skill3_ZipSelect.php">
<b>Fill out Form to Specify Zipcode Range</b><br/>
Enter the beginning Zipcode:
<input type="text" name="BegZip"><br/>
Enter the ending Zipcode:
<input type="text" name="EndZip"><br/>
<input type="submit">

<header>

</body>
</html>
<?php
$BegZip=htmlentities($_GET["BegZip"]);
$EndZip=htmlentities($_GET["EndZip"]);

echo"<br/>The following is a list of all customers in the customer database<br/>";
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
	//echo"Connecting to Database Recipe....<br/>";
try{
		//if executing query command, NO USER ENTERED fields should be in query string
		$conn->query("USE mdias001_OrderEntry");		
		
	}
	catch(PDOException $e){
			
		echo"Error Connecting to database: " . $e->getMessage();
		die;
	}
//echo"Connection to recipes database succeeded.<br/>";
//CONTINUE HERE*********************************************************************************************************************************************************************
//SQL statement will NOT have any user-entered data, so PREPARE not needed
$SQL="SELECT fname, lname, zip, uid FROM Customers ORDER BY lname";

try{
			
	$sth=$conn->prepare($SQL);
	$sth->execute();

		
}
	catch(PDOException $e){
			
		echo"Error selecting Zip record: " . $e->getMessage();
		die;
	}
/*$SQL="SELECT fname, lname, zip, uid FROM Customers";
$SQL .=" WHERE zip >= :BegZip AND zip <= :EndZip;";

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
	}*/
	
//echo "Query executed sucessfully.<br/>";
//are there records in the set?
if($sth->rowCount()==0){
	
	echo "No records returned<br/>";
	die;
}
else{
	echo $sth->rowCount() . " <b>records returned</b><br/><br/>";
	
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



</form>

</body>
</html>