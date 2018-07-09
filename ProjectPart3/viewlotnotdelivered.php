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
	<h1><center>View Lot Not Delivered (Admin View)</center></h1>
</header>

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

//echo"Connection to recipes database succeeded.<br/>";

//SQL statement will NOT have any user-entered data, so PREPARE not needed
//$SQL="SELECT LotID, Description, CategoryID, WinningBidder, Delivered FROM Lot WHERE WinningBidder=:LotWinner;";
$SQL="SELECT Bidder.BidderID, Bidder.Name, Bidder.Address, Bidder.HomeNumber, Lot.LotID, Lot.Delivered, Bidder.Paid FROM Bidder INNER JOIN Lot ON Bidder.BidderID=Lot.WinningBidder WHERE Lot.Delivered=0 ORDER BY Lot.LotID;";
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
	
	echo "<br/><b>There are no Non-Delivered lots at this time, Please check back later...</b><br/>";
	echo "<br/><br/><a href='AuctionAdminDashboard.php' class='button'>Return to Auction Administrator Dashboard</a><br/>";
	die;
}
else{
	echo"<center>";
	echo $sth->rowCount() . " records returned";
	echo"</center>";
	
}

echo"<center><table>";

echo"<tr>";
echo"<th colspan='9'>Lots Not Delivered</th>";
echo"</tr>";

	echo"<tr>";
		echo"<th>Lot ID:</th>";
		echo"<th>Bidder ID:</th>";
		echo"<th>Name:</th>";
		echo"<th>Address:</th>";
		echo"<th>HomeNumber:</th>";
		echo"<th>Paid Status:</th>";
		echo"<th>Update Bidder:</th>";
		echo"<th>Delete Bidder:</th>";
		echo"<th>User View: Winning Status:</th>";
//$result is an array that holds the dataset
while($result= $sth->fetch()){
	
	echo"</tr>";
		echo"<td>" . $result['LotID'] . "</td>";
		echo"<td>" . $result['BidderID'] . "</td>";
		echo"<td>" . $result['Name'] . "</td>";
		echo"<td>" . $result['Address'] . "</td>";
		echo"<td>" . $result['HomeNumber'] . "</td>";
		echo"<td>"; 
			if($result['Paid']=="1")
			{echo"Paid";}
			else{
				
				echo "Not Paid";
				
				
			}
		echo"</td>";
		echo"<td><a href='updatebidder.php?BidderID=" . $result['BidderID'] . "' class='button'>Update Bidder #" . $result[BidderID] . "</a></td>";
		echo"<td><a href='deletebidder.php?BidderID=" . $result['BidderID'] . "' class='button'>Delete Bidder #" . $result[BidderID] . "</a></td>";
		echo "<td><a href='viewlotwinner.php?LotWinner=" . $result['BidderID'] . "' class='button'>View Winning Status </a></td>";
	
	}
echo"</table></center>";
?>
<html>
<br/>
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