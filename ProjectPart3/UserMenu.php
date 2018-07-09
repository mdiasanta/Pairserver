<html>
<body style="background-color:#B5d3e7;">
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

<table align="center">
	<tr>
		<th colspan="4">User Dashboard</th>
	</tr>
	
	<tr>
		<th>Data Entry</th>
		<td colspan="1"><a href='enterbidder.php' class='button'>Enter Bidder</a><br/><br/>Enter New Bidder Information</td>
		
	</tr>
	
	
	<tr>
		<th>Data View</th>
		<td><a href='viewlotwinner.php' class='button'>View Lot Winners</a><br/><br/>View Lot Winner Report</td>
		
	</tr>
	
</table>
</html>