<?php
$state=htmlentities($_POST[state]);
$party=htmlentities($_POST[party]);
$cuckchoice=htmlentities($_POST[cuckchoice]);
$party="ind";
$partyvalue=0;
$cuckvalue=0;
$emptyform=true;

if($party="dem"){
	
	$partyvalue=1;
	$partymessage="You voted for a corrupt candidate<br/>";
	$img="<img src= \"http://i3.kym-cdn.com/photos/images/facebook/001/020/360/462.jpg\">";

	
}
else if($party="rep"){
	
	//$partyimg="";
	$partyvalue=2;
	$partymessage="You voted for the God Emperor<br/>";
}
else if($party="other"){
	$partyvalue=3;
	$partymessage="You voted for a loser<br/>";
}
else{
	
	$emptyform=false;
}
if($cuckchoice="cuck"){
	
	$cuckvalue=1;
	$cuckmessage="You are a liberal cuck<br/>";
}
else{
	
	$cuckvalue=2;
	$cuckmessage="You are a patriot, Pepe salutes you<br/>";
}


if($empty==true){	
	echo $partymessage;
	echo $cuckmessage;
	echo $partyimg;
	die;
}
	




?>
<html>
<body>
<form method="POST" action="Voting.php">

<header>
<h1>Voter Check</h1>
</header>
Which State did you vote in?<input type="text" name="state"><br/><br/>
Which party do you belong to?<br/>
Democrat<input type="radio" name="party" value="dem"><br/>
Republican<input type="radio" name="party" value="rep"><br/>
Independent<input type="radio" name="party" value="ind"><br/><br/>
Are you a cuck?<br/>
Yes<input type="radio" name="cuckchoice" value="cuck"><br/>
No<input type="radio" name="cuckchoice" value="nocuck"><br/>
<?php echo $img; ?>

<br/>
<input type="submit">
</body>
</html>