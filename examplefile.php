<?php
error_reporting(E_ALL);

$validform = true;
$emptyform = true;
$rid = htmlentities($_POST['rid']);
if ($rid=='') {
	$validform = false;
	$riderrormessage = 'The recipe ID is required.';
} else {
	$emptyform = false;
	if (is_numeric($rid)) {
		if ($rid<=0 or $rid > 2147482647) {
			$validform = false;
			$riderrormessage = 'The recipe ID must be greater than zero and less than 2147482647.';
		} else {
		//it's okay
		}
	} else {
		$validform = false;
		$riderrormessage = 'The recipe ID must be an integer.';
	}
}
$title = htmlentities($_POST['title']);
if($title=='') {
	$validform = false;
	$titleerrormessage = 'The title is a required field.';
} else {
	$emptyform = false;
	if (strlen($title)>75) {
		$validform = false;
		$titleerrormessage = 'The title must be less than 75 characters long.';
	}
}
$card = htmlentities($_POST['card']);
if($card=='') {
	$validform = false;
	$carderrormessage = 'Description is a required field.<br />';
} else {
	$emptyform = false;
	if (strlen($card)>999) {
		$validform = false;
		$carderrormessage = 'Description must be less than 999 characters long.<br />';
	}
}
$servingqty = htmlentities($_POST['servingqty']);
if($servingqty=='') {
	$validform = false;
	$servingqtyerrormessage = 'Serving Quantity is a required field.';
} else {
	$emptyform = false;
	if (preg_match("/^[0-9]{1,3}$/", $servingqty)) {
		if ($servingqty<=0 or $servingqty >= 1000) {
			$validform = false;
			$servingqtyerrormessage = 'The serving quantity must be between one and 999.';
		} else {
		//it's okay
		}
	} else {
		$validform = false;
		$servingqtyerrormessage = 'The serving quantity must be an integer with at most 3 digits.';
	}
}
$servingtype = htmlentities($_POST['servingtype']);
if($servingtype=='') {
	$validform = false;
	$servingtypeerrormessage = 'Serving type is a required field.';
} else {
	$emptyform = false;
	if (strlen($servingtype)>999) {
		$validform = false;
		$servingtypeerrormessage = 'Serving Type must be less than 999 characters long.';
	} else {
		if ($servingtype == 'Servings' or $servingtype == 'Portions' or $servingtype == 'People') {
		} else {
			$validform = false;
			$servingtypeerrormessage = 'Serving Type must be either Servings, Portions, or People.';
		}
	}
}
$timeprepqty = htmlentities($_POST['timeprepqty']);
if($timeprepqty=='') {
	$validform = false;
	$timeprepqtyerrormessage = 'Prep Time is a required field.';
} else {
	$emptyform = false;
	if (preg_match("/^[0-9]{1,3}$/", $timeprepqty)) {
		if ($timeprepqty<=0 or $timeprepqty >= 1000) {
			$validform = false;
			$timeprepqtyerrormessage = 'Prep time must be between one and 999 minutes.';
		} else {
		//it's okay
		}
	} else {
		$validform = false;
		$timeprepqtyerrormessage = 'Prep time must be an integer with at most 3 digits.';
	}
}
$timecookqty = htmlentities($_POST['timecookqty']);
if($timecookqty=='') {
	$validform = false;
	$timecookqtyerrormessage = 'Cook Time is a required field.';
} else {
	$emptyform = false;
	if (preg_match("/^[0-9]{1,3}$/", $timecookqty)) {
		if ($timecookqty<=0 or $timecookqty >= 1000) {
			$validform = false;
			$timecookqtyerrormessage = 'Cook time must be between one and 999 minutes.';
		} else {
		//it's okay
		}
	} else {
		$validform = false;
		$timecookqtyerrormessage = 'Cook time must be an integer with at most 3 digits.';
	}
}
$cat = htmlentities($_POST['cat']);
if($cat=='') {
	$validform = false;
	$caterrormessage = 'Category is a required field.';
} else {
	$emptyform = false;
	if (strlen($cat)>999) {
		$validform = false;
		$caterrormessage = 'Category must be less than 999 characters long.';
	} else {
		if ($cat == 'Breakfast' or $cat == 'Lunch' or $cat == 'Dinner' or $cat == 'Dessert') {
		} else {
			$validform = false;
			$caterrormessage = 'Category must be either Servings, Portions, or People.';
		}
	}
}
$picture = htmlentities($_POST['picture']);
if($cat=='') { //User decided that picture is not required
//	$validform = false;
//	$pictureerrormessage = 'Picture is a required field.';
} else {
	$emptyform = false;
	if (strlen($picture)>999) {
		$validform = false;
		$pictureerrormessage = 'Picture must be less than 999 characters long.';
	}
}
if ($emptyform == true) {
	$riderrormessage = '';
	$titleerrormessage = '';
	$carderrormessage = '';
	$servingqtyerrormessage = '';
	$servingtypeerrormessage = '';
	$timeprepqtyerrormessage = '';
	$timecookqtyerrormessage = '';
	$caterrormessage = '';
	$pictureerrormessage = '';
} else {
	if ($validform==true) {
		echo "All data was valid.";
		die;
	}
}
?>
<html>
<body>
Recipe Entry Form
<form action="examplefile.php" method="post">

Recipe Number: <input type="text" name="rid" value="<?php echo $rid; ?>">
<span style="color: red;"><?php echo $riderrormessage; ?></span><br />

Title: <input type="text" name="title" value="<?php echo $title; ?>">
<span style="color: red;"><?php echo $titleerrormessage; ?></span><br />

Description: <textarea name="card" style="width: 300px; height: 80px;">
<?php echo $card; ?></textarea><br />
<span style="color: red;"><?php echo $carderrormessage; ?></span>

Serves: <input type="text" name="servingqty" value="<?php echo $servingqty; ?>">
<select name="servingtype">
	<option value=""<?php if ($servingtype==''){ echo ' selected';} ?>>Choose...</option>
	<option value="People"<?php if ($servingtype=='People'){ echo ' selected';} ?>>People</option>
	<option value="Portions"<?php if ($servingtype=='Portions'){ echo ' selected';} ?>>Portions</option>
	<option value="Servings"<?php if ($servingtype=='Servings'){ echo ' selected';} ?>>Servings</option>
</select>
<span style="color: red;"><?php echo $servingqtyerrormessage; ?></span>
<span style="color: red;"><?php echo $servingtypeerrormessage; ?></span><br />

Prep Time: <input type="text" name="timeprepqty" value="<?php echo $timeprepqty; ?>"> minutes
<span style="color: red;"><?php echo $timeprepqtyerrormessage; ?></span><br />

Cook Time: <input type="text" name="timecookqty" value="<?php echo $timecookqty; ?>"> minutes
<span style="color: red;"><?php echo $timecookqtyerrormessage; ?></span><br />

Category:<br />
<input type="radio" name="cat" value="Breakfast"<?php if ($cat=='Breakfast'){ echo ' checked';} ?>> Breakfast<br />
<input type="radio" name="cat" value="Lunch"<?php if ($cat=='Lunch'){ echo ' checked';} ?>> Lunch<br />
<input type="radio" name="cat" value="Dinner"<?php if ($cat=='Dinner' or $cat == ''){ echo ' checked';} ?>> Dinner<br />
<input type="radio" name="cat" value="Dessert"<?php if ($cat=='Dessert'){ echo ' checked';} ?>> Dessert<br />
<span style="color: red;"><?php echo $caterrormessage; ?></span><br />

Picture URL: <input type="text" name="picture" value="<?php echo $picture; ?>">
<span style="color: red;"><?php echo $pictureerrormessage; ?></span><br />
<input type="submit">
</form>
</body>
</html>
