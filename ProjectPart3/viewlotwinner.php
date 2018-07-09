<html>
<body style="background-color:#B5d3e7;">
<form method="get" action="viewlotwinner.php">
<font face="Arial">
<header>
<h1><center>Lot Winner List</center></h1>
<h2><center>To Check the winning status of other Bidder ID records, Enter the Bidder ID Below:</center></h2>
</header>

<center>
Bidder ID:
<input type="text" name="LotWinner">

<input type="submit">
</center>

<style>
a.button {
    background-color: #4CAF50; /* Green */
    border: none;
    color: white;
    padding: 10px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 14px;
	font-family: Arial;
}

table {
    border-collapse: collapse;
	font-family: Arial;
}

table, th, td {
    border: 1px solid black;
}

th, td {
	padding: 10px;
    text-align: center;
	   
}

tr:hover{background-color:#f5f5f5}

input[type=text] {
    width: 130px;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    background-color: white;
    background-image: url('searchicon.png');
    background-position: 10px 10px; 
    background-repeat: no-repeat;
    padding: 12px 20px 12px 40px;
    -webkit-transition: width 0.4s ease-in-out;
    transition: width 0.4s ease-in-out;
}

input[type=text]:focus {
    width: 75%;
}
</style>
</font>
</form> 
<html>

<?php
$LotWinner=htmlentities($_GET["LotWinner"]);

//echo "<br/>Connecting to database.<br/>";
	//connect to the database
	//
	try{
		//variable stores the connection -> $conn
		//PDO = PHP Data Oject -> helps prevent SQL injections
		//hose= Database server host name
		//Username = name of read only user
		//password = that user's password
		//mysql:host="database server", "username","password"
		$conn= new PDO("mysql:host=db77a.pair.com","zbiss001_4_r","3iLZ5tqA");
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
		$conn->query("USE zbiss001_Auction");		
		
	}
	catch(PDOException $e){
			
		echo"Error Connecting to database: " . $e->getMessage();
		die;
	}
//echo"Connection to recipes database succeeded.<br/>";

//SQL statement will NOT have any user-entered data, so PREPARE not needed
//$SQL="SELECT LotID, Description, CategoryID, WinningBidder, Delivered FROM Lot WHERE WinningBidder=:LotWinner;";
$SQL="SELECT Bidder.BidderID, Bidder.Name, Lot.CategoryID, Lot.LotID, Bidder.Paid FROM Bidder INNER JOIN Lot ON Bidder.BidderID=Lot.WinningBidder WHERE WinningBidder=:LotWinner;";
//SQL statement WILL have user-entered data, so BIND needed
//$SQL="SELECT rid, title, cat FROM Recipe";
//$SQL .=" WHERE cat >= :BegCat AND cat <= :EndCat;";

try{
			
	$sth=$conn->prepare($SQL);
	//Bind Added
	$sth->bindParam(":LotWinner", $LotWinner);
	
	
	$sth->execute();

		
}
	catch(PDOException $e){
			
		echo"Error selecting recipe record: " . $e->getMessage();
		die;
	}
//echo "Query executed sucessfully.<br/>";

//are there records in the set?
if($sth->rowCount()==0){
	
	echo "<br/><center><b><font color='red'>You have not won any bids at this time, Please check back later...</font></b><br/>";
	echo "<br/><br/><a href='UserMenu.php' class='button'>Click Here to Return to User Menu</a><br/></center>";
	die;
}
else{
	echo "<center>" . $sth->rowCount() . " records returned<br/><br/>";
	echo"<header><h1>";
	echo "<b>Bidder #" . $LotWinner . " has won the following lot(s)!</b><br/>";
	echo"</h1></header>";
	echo "<font color='red'><b>**If the Lots have not been paid, please pay the Lots in order to receive your Prize**</b></font></center><br/>";
}
if ($result['paid']=="0"){
	
	$result['paid']=="false";
}
echo"<center><table>";
	echo"<tr>";
		echo"<th>Bidder ID</th>";
		echo"<th>Name:</th>";
		echo"<th>Category ID</th>";
		echo"<th>Lot ID</th>";
		echo"<th>Paid Status</th>";
		
//$result is an array that holds the dataset
while($result= $sth->fetch()){
	
	echo"</tr>";
		echo"<td>" . $result['BidderID'] . "</td>";
		echo"<td>" . $result['Name'] . "</td>";
		echo"<td>" . $result['CategoryID'] . "</td>";
		echo"<td>" . $result['CategoryID'] . "</td>";
		echo"<td>"; 
			if($paid=="0")
			{echo"Not Paid";}
			else{
				
				echo "Paid";
				echo"<br/><br/>";
				
			}
		echo"</td>";
	echo"<tr>";
	echo"</tr>";
}

//in an array, refer to column with string inside brackets['rid']

echo"</center></table>";
?>


<html>

<body bgcolor="F0F8FF">

<br/>
<center>
<a href='UserMenu.php' class='button'>Click Here to Return to User Menu</a>
</center>

</body>
</html>
