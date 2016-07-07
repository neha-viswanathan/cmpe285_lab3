<?php
//extract Form data
extract($_POST);

//create a database connection.
$link = mysqli_connect("swmonkcom.ipagemysql.com", "swmonk", "cmpe285", "sportshop");
if($link === false){
    die("ERROR: Could not connect to database <br><br> " . mysqli_connect_error());
}

//read all the form data into variables
$uid=mysqli_real_escape_string($link, $_POST['userid']);
$pwd=mysqli_real_escape_string($link, $_POST['pwd']);
$fn = mysqli_real_escape_string($link,$_POST['fname']);
$ln = mysqli_real_escape_string($link,$_POST['lname']);
$address = mysqli_real_escape_string($link,$_POST['addr']);
$cnum = mysqli_real_escape_string($link,$_POST['cell']);
$hnum = mysqli_real_escape_string($link,$_POST['home']);
$emailid =mysqli_real_escape_string($link, $_POST['email']);

//Check if the user Id is already registered. Is true, display an error
$sql1 = "SELECT * FROM buyer WHERE userid = '$uid'";
$result1 = mysqli_query($link, $sql1);
if($result1) {
    if(mysqli_num_rows($result1) > 0) {
		while($row = mysqli_fetch_array($result1)) {
			if($row['userid'] === $uid) {
				echo '<font color="red"><strong>Oh no! Looks like this User ID exists! <em><u>' . $uid . '</u></em></strong></font><br><br>' . mysqli_error($link);
				echo '<a href="http://www.swmonk.com/userreg/">Try with a different User ID</a><br>';
				break;
			}
		}
		mysqli_free_result($result1);
	} //Else, create the new user in the database
	else {
		$sql2 = "INSERT INTO buyer (userid, password, fname, lname, addr, cell, home, email) VALUES ('$uid', '$pwd', '$fn', '$ln', '$address', '$cnum', '$hnum', '$emailid')";
		$result2 = mysqli_query($link, $sql2);
		if($result2) {
			echo '<font color="green"><strong>User registration successful!</strong></font><br><br>';
			echo ' Hi <em><font color=" #6600ff"><strong>' . $uid . '</strong></font></em>, Welcome to The Sport Shop!<br><br>';
			echo '<a href="http://www.swmonk.com/account/">Login to your account</a><br>';
		}
		else {
			echo '<font color="red"><strong>Oops! Looks like there is a problem at this time. Please try again later!</strong></font> <br><br>' ;
		}
	}
}

//close the database connection
mysqli_close($link);
?>