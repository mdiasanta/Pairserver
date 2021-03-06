<html>
<form method="get" action="listrecipes.php">
<header>
<h1><center>Recipe List<center></h1>
<h2>To select categories, please fill in fields below</h2>
</header>
Enter the beginning category:
<input type="text" name="BegCat"><br/>
Enter the ending category:
<input type="text" name="EndCat"><br/>
<input type="submit">
</form> 
<html>

<?php
$BegCat=htmlentities($_GET["BegCat"]);
$EndCat=htmlentities($_GET["EndCat"]);
echo "Going to return records with category between " . $BegCat . " and " . $EndCat . ".<br/>";

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

//SQL statement will NOT have any user-entered data, so PREPARE not needed
$SQL="SELECT rid, title, cat FROM Recipe;";

//SQL statement WILL have user-entered data, so BIND needed
//$SQL="SELECT rid, title, cat FROM Recipe";
//$SQL .=" WHERE cat >= :BegCat AND cat <= :EndCat;";

try{
			
	$sth=$conn->prepare($SQL);
	//Bind Added
	$sth->bindParam(":BegCat", $BegCat);
	$sth->bindParam(":EndCat", $EndCat);
	
	$sth->execute();

		
}
	catch(PDOException $e){
			
		echo"Error selecting recipe record: " . $e->getMessage();
		die;
	}
echo "Query executed sucessfully.<br/>";
//are there records in the set?
if($sth->rowCount()==0){
	
	echo "No records returned<br/>";
	die;
}
else{
	echo $sth->rowCount() . " records returned<br/><br/>";
	
}
//$result is an array that holds the dataset
while($result= $sth->fetch()){
	
	echo "Recipe ID: " . $result['rid'] . "<br/>";
	echo "Title: " . $result['title'] . "<br/>";
	echo "Category: " . $result['cat'] . "<br/>";	
	echo "<a href='deleterecipe.php?rid=" . $result['rid'] . "'>Delete Recipe #" . $result[rid] . "</a><br/>";
	echo "<a href='updaterecipe.php?rid=" . $result['rid'] . "'>Update Recipe #" . $result[rid] . "</a><br/>";
	echo "<a href='viewrecipe.php?rid=" . $result['rid'] . "'>View/Add ingredients for Recipe #" . $result[rid] . "</a><br/><br/>";
	}
//in an array, refer to column with string inside brackets['rid']


?>


<html>

<body bgcolor="F0F8FF">




</body>
</html>