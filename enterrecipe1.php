<?php
//THIS IS THE ORIGINAL COPY
$validForm=true;
$emptyform=true;

$rid= htmlentities($_POST['rid']);
$title= htmlentities($_POST['title']);
$card= htmlentities($_POST['card']);
$servingqty= htmlentities($_POST['servingqty']);
$servingtype= htmlentities($_POST['servingtype']);
$timeprepqty= htmlentities($_POST['timeprepqty']);
$timecookqty= htmlentities($_POST['timecookqty']);
$picture= htmlentities($_POST['picture']);

//RID validation
if ($rid==''){
	$validForm=false;
	//$riderrormessage='The Title is a required field.';
	$emptyform=true;
	
}
else{
	if(is_numeric($rid)){
		if($rid<=0 or $rid>2147483647){
			$validForm=false;
			$riderrormessage='The Recipe ID must be greater than zero or less than 2147483647';
		}
		//its okay
	}
	else{
		$validForm=false;
		$riderrormessage='The recipe ID must be an integer.';
		
	}
		
}
	
//Title Validation
if ($title==''){
	$validForm=false;
	
	
}
else{
	
	$emptyform=false;
	
	if(strlen($title)>75){
		
	$validForm=false;
	$titleerrormessage='The Title can only be up to 75 characters long.';	
	}
}

//timeprepqty validation
if ($timeprepqty==''){
	$validForm=false;
	//$riderrormessage='The Title is a required field.';
	
}
else{
	if(is_numeric($timeprepqty)){
		if($timeprepqty<=0){
			$validForm=false;
			$timeprepqtyerrormessage='The Time prep quantity must be greater than zero';
		}
		//its okay
	}
	else{
		$validForm=false;
		$timeprepqtyerrormessage='The Time prep quantity must be an integer.';
		
	}
		
	}
	
//timecookqty validation
if ($timecookqty==''){
	$validForm=false;
	//$riderrormessage='The Title is a required field.';
	
}
else{
	if(is_numeric($timecookqty)){
		if($timecookqty<=0){
			$validForm=false;
			$timecookqtyerrormessage='The Cooking Time must be greater than zero';
		}
		//its okay
	}
	else{
		$validForm=false;
		$timecookqtyerrormessage='The Cooking Time must be an integer.';
		
	}
		
	}
//card validation
if ($card==''){
	$validForm=false;
	
	
}
else{
	
	$emptyform=false;
	
	if(strlen($card)>999){
		
	$validForm=false;
	$titleerrormessage='The card can only be up to 70 characters long.';	
	}
}
//picture validation
if ($picture==''){
	$validForm=false;
	
	
}
else{
	
	$emptyform=false;
	
	if(strlen($picture)>999){
		
	$validForm=false;
	$pictureerrormessage='The picture URL can only be up to 70 characters long.';	
	}
}
//servingqty validation
if ($servingqty==''){
	$validForm=false;
	//$riderrormessage='The Title is a required field.';
	$emptyform=true;
	
}
else{
	if(is_numeric($servingqty)){
		if($servingqty<=0){
			$validForm=false;
			$servingqtyerrormessage='The Serving Quantity must be greater than zero';
		}
		//its okay
	}
	else{
		$validForm=false;
		$servingqtyerrormessage='The Serving Quantity must be an integer.';
		
	}
		
	}

	
//emptyform error message	
if($emptyform==true){
	$riderrormessage='The recipe ID is a required field.';
	$titleerrormessage='The Title is a required field.';
	$timeprepqtyerrormessage='The Time Preparation is a required field';
	$timecookqtyerrormessage='The Time Cook is a required field';
	$carderrormessage='The description is a required field';
	$pictureerrormessage='The Picture URL is a required field';
	$servingqtyerrormessage='The serving quantity is a required field';
}
else{echo'All Data was valid';}
?>
<html>
<body>

<header>
<h1>Recipe Entry Form</h1>
</header>

<!--this will bring me to this server when a recipe rid is submitted-->
<form method="POST" action="enterrecipe.php"> 

Enter Recipe Number:<input type="text" name= "rid" value="<?php echo $rid; ?>">
<span style="color: red;"><?php echo $riderrormessage; ?></span> <br />

Title:<input type="text" name= "title" value="<?php echo $title; ?>">
<span style="color: red;"><?php echo $titleerrormessage; ?></span> <br />

<!--width and height of box can be set using style-->
Description: <textarea name="card" style="width:300px; height: 100px;">
<?php echo $card; ?>

</textarea>
<span style="color: red;"><?php echo $carderrormessage; ?></span><br />

<!--This is how to do a dropdown menu-->
Serves: <input type="text" name="servingqty" value="<?php echo $servingqty; ?>">
<span style="color: red;"><?php echo $servingqtyerrormessage; ?></span>

<select name="servingtype">
	<option value="People">People</option>
	<option value="Portions">Portions</option>
	<option value="Servings">Servings</option>
</select>
<br/>

Prep Time: <input type="text" name="timeprepqty"value="<?php echo $timeprepqty; ?>">
<span style="color: red;"><?php echo $timeprepqtyerrormessage; ?></span> minutes<br/>

Cook Time: <input type="text" name="timecookqty" value="<?php echo $timecookqty; ?>">
<span style="color: red;"><?php echo $timecookqtyerrormessage; ?></span> minutes<br/>

Picture URL: <input type="text" name="picture" value="<?php echo $picture; ?>">
<span style="color: red;"><?php echo $pictureerrormessage; ?></span>
<!--"http://sharing.kshb.com/sharekgtv/photo/2014/08/15/instant_ramen_noodles_1408131512923_7390899_ver1.0_640_480.jpg">--><br/>

Category: <br/><input type="radio" name="cat" value="Dinner">Dinner<br/>
	<input type="radio" name="cat" value="Breakfast">Breakfast<br/>
	<input type="radio" name="cat" value="Lunch">Lunch<br/>
	<input type="radio" name="cat" value="Dessert">Dessert<br/>

<input type="submit">

</form>
</body>
</html>