<?php
session_start();
$dbc = mysqli_connect('localhost', 'root', '', 'lab1');
if(isset($_POST['submit'])){
	$firstname = $_POST['firstname'];
	$lastname = $_POST['lastname'];
	$email = $_POST['email'];
	$password1 = $_POST['password1'];
	$password2 = $_POST['password2'];
	if(!empty($firstname) && !empty($lastname) && !empty($password1) && !empty($password2) && ($password1 == $password2)){
		if(iconv_strlen($password1) > 5){
			$query = "SELECT * FROM `users` WHERE first_name = '$first_name'";
			$data = mysqli_query($dbc, $query);
			$role = $_POST['role'];
			if(mysqli_num_rows($data) == 0){
				if($role == 'admin'){
					$role = 1;
					$photo = 'assets/images/admin.png';
				}else{
					$role = 2;
					$photo = 'assets/images/user.png';
				}
				$query = "INSERT INTO `users` (first_name, last_name, photo, role_id, password) VALUES ('$firstname', '$lastname', '$photo', '$role', '$password2')";
				mysqli_query($dbc, $query);
				$lastID = mysqli_insert_id($dbc);
				$sqlSelect = "SELECT * FROM `users` WHERE id='$lastID'";
				$records = mysqli_query($dbc, $sqlSelect);
				$field = mysqli_fetch_array($records);
				$_SESSION['userID'] = $field['id'];
				$_SESSION['first_name'] = $field['first_name'];
				$_SESSION['last_name'] = $field['last_name'];
				$_SESSION['photo'] = $field['photo'];
				$_SESSION['role_id'] = $field['role_id'];
				$_SESSION['password'] = $field['password'];

				echo "<script language=javascript>document.location.href='user-profile.php'</script>";
			}else{
				echo '<div class="error-msg">User with such email already exists</div>';
			}
		}else{
			echo '<div class="error-msg">password minimum length is 6 symbols</div>';
		}
	}else{
		echo '<div class="error-msg">Please fill up all the fields</div>';
	}
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Ebeb - Register</title>
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
	<link rel="icon" type="icon/png" href="assets/images/icon.png">
</head>
<body>
	<header class="header">
		<h1>Daily Deals | Sell | Help & Contact</h1>
	</header>
	<div class="content-container">
		<content class="content">
			<div class="logo">
				<a href="index.php">
					<img src="assets/images/logo.png">
				</a>
			</div>
		</content>
		<div class="separator"></div>
		<h1 class="title">registration</h1>
		<div class="form-holder">
			<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="register-form">
				<label for="firstname">First name:</label>
				<input type="text" name="firstname">
				<label for="lastname">Last name:</label>
				<input type="text" name="lastname">
				<label for="role">Choose role:</label>
				<select type="role" name="role">
				   <option value="admin">Admin</option>
				   <option value="user" selected >User</option>
				</select>
				<label for="password">Enter the password:</label>
				<input type="password" name="password1">
				<label for="password">Enter the password again:</label>
				<input type="password" name="password2">
				<button type="submit" name="submit">Sign Up</button>
			</form>
		</div>
	</div>
	<footer class="footer">
		<h3>Copyright © 1995-2019 eBay Inc. All Rights Reserved.</h3>
	</footer>
</body>
</html>