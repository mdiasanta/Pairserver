<html>
<body style="background-color:#B5d3e7;">
<font face="Arial">
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
<header>
	<h1><center>View Lot (Admin View)</center></h1>
</header>
<center><a href='enterlot.php' class="button">Click Here to Enter a New Lot</a></center>

<!--<center><input type="text" name="search" placeholder="Search.."></center>-->


<script>
   
</script>

</font>
</body>
</html>
<?php
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
$SQL="SELECT LotID, Description, CategoryID, WinningBidder, Delivered FROM Lot;";

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
//echo "Query executed sucessfully.<br/>";
//are there records in the set?
if($sth->rowCount()==0){
	
	echo "No records returned<br/>";
	die;
}
else{
	echo"<center>" . $sth->rowCount() . " records returned</center><br/>";
	
}
//$result is an array that holds the dataset
echo"<center><table>";
	echo"<tr>";
		echo"<th>Lot ID</th>";
		echo"<th>Description</th>";
		echo"<th>CategoryID</th>";
		echo"<th>Winning Bidder</th>";
		echo"<th>Delivered</th>";
		echo"<th>Update Lot</th>";
		echo"<th>Delete Lot</th>";
		echo"<th>View Lot Winner</th>";

while($result= $sth->fetch()){
	
	
	echo"</tr>";
		echo"<td>" . $result['LotID'] . "</td>";
		echo"<td>" . $result['Description'] . "</td>";
		echo"<td>" . $result['CategoryID'] . "</td>";
		echo"<td>" . $result['WinningBidder'] . "</td>";
		echo"<td>"; 
			if ($result['Delivered']=="0"){ 
			
			echo"Not Delivered";
			}	
			else{
				echo"Delivered";
			}
		echo"</td>";
		echo"<td><a href='updatelot.php?LotID=" . $result['LotID'] . "' class='button'>Update Lot #" . $result[LotID] . "</a></td>";
		echo"<td><a href='deletelot.php?LotID=" . $result['LotID'] . "' class='button'>Delete Lot #" . $result[LotID] . "</a></td>";
		echo"<td><a href='viewlotwinner.php?LotWinner=" . $result['WinningBidder'] . "' class='button'>View Lot Winner</a></td>";
	echo"<tr>";
	echo"</tr>";
	//echo "Lot ID: " . $result['LotID'] . "<br/>";
	//echo "Description: " . $result['Description'] . "<br/>";
	//echo "CategoryID: " . $result['CategoryID'] . "<br/>";
	//echo "WinningBidder: " . $result['WinningBidder'] . "<br/>";
	
	/*echo "Delivered: ";
	if ($result['Delivered']=="1"){ 
		
		echo"Not Delivered";
	}
	else{
		echo"Delivered";
	}*/
	
	
	//echo "<br/><br/><a href='deletelot.php?LotID=" . $result['LotID'] . "'>Delete Lot #" . $result[LotID] . "</a><br/>";
	//echo "<a href='updatelot.php?LotID=" . $result['LotID'] . "'>Update Lot #" . $result[LotID] . "</a><br/>";
	//echo "<a href='viewlotwinner.php?BidderID=" . $result['BidderID'] . "'>View Lot Winner </a><br/><br/>";
	}
	echo"</center></table>";
?>
<html>
<br/><br/>
<table align="center">
	<tr>
		<th colspan="4">Administrator Dashboard</th>
	</tr>
	
	<tr>
		<th>Data Entry</th>
		<td colspan="2"><a href='enterbidder.php' class='button'>Enter Bidder</a><br/><br/>Enter New Bidder Information</td>
		<td><a href='enterlot.php' class='button'>Enter Lot</a><br/><br/>Enter a New Lot</td>
		
	</tr>
	
	
	<tr>
		<th>Data View</th>
		<td colspan="2"><a href='viewbidder.php' class='button'>View Bidder</a><br/><br/>View All Bidders</td>
		<td><a href='viewlotwinner.php' class='button'>View Lot Winners</a><br/><br/>View Lot Winner Report</td>
		
	</tr>
	
	<tr>
		<th>Report View</th>
		<td><a href='viewlot.php' class='button'>View All Lot</a><br/><br/>View All Lots</td>
		
		<td><a href='viewlotnotdelivered.php' class='button'>View Undelivered Lots</a><br/><br/>View Underlivered Lot Winners Report</td>
		<td><a href='viewwinnernopay.php' class='button'>View Winners who haven't paid</a><br/><br/>View Unpaid Lot Winners Report</td>
	</tr>
</table>
</html>