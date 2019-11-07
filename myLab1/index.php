<?php 
	session_start();
?>

<DOCTYPE html>
<html>
<head>
	<title>Ebeb - Home</title>
	<link rel="icon" type="icon/png" href="assets/images/icon.png">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
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
			<div class="login">
				<?php
					if(!empty($_SESSION['password']) && !empty($_SESSION['first_name'])){
						echo '<a href="user-profile.php">My profile</a>';
						echo '<span style="font-size: 22px;">|</span>';
						echo '<a href="logout.php">Logout</a>';
					}else{ 
				?>
					<form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="login-form">
						<input type="first_name" name="first_name" placeholder="first_name">
						<input type="password" name="password1" placeholder="password1">
						<button type="submit" name="submit">Sign In</button>
						<span>|</span>
						<a href="register.php">Sign Up</a>
					</form>
					
				<?php
					}
				?>
			</div>
		</content>
		<div class="separator"></div>
		<h1 class="title">hello!</h1>
		<?php
			require_once 'connectionWeb.php';
			 
			$link = mysqli_connect($host, $user, $password, $database) 
			    or die("Ошибка " . mysqli_error($link)); 
			     
			$query ="SELECT * FROM `users` LEFT JOIN `roles` ON `users`.role_id=`roles`.id";
			 
			$result = mysqli_query($link, $query); 
			if($result)
			{
			    $rows = mysqli_num_rows($result);

			    echo '<table class="tg">
				  <tr>
				    <th>#</th>
				    <th>first name</th>
				    <th>last name</th>
				    <th>photo</th>
				    <th>role</th>';
				   
				if($rows[5] == 1) echo '</tr>';
			    for ($i = 0; $i < $rows; ++$i)
			    {
					$row = mysqli_fetch_row($result);
			        echo "<tr>";
			            for ($j = 0; $j < 5; ++$j){
							if($j != 3 && $j !=4)
			            	if($j == 0){
			            		echo "<td><a href='user-profile.php?id=".$row[0]."'>$row[$j]</a></td>";
			            	}else{
			            		echo "<td>$row[$j]</td>";
			            	}
			            }
			            echo '<td style="background-image: url('.$row[4].'); background-size: contain; background-repeat: no-repeat; background-position: center;"></td>';
						echo "<td>$row[7]</td>";
			       		if(isset($_SESSION['first_name']) && isset($_SESSION['password']) && ($_SESSION['role_id'] == 1)){
			       			echo'<td><a class="delete-button-td" name="delete-user" href="delete.php?id='.$row[0].'">Delete</a></td>';
			       		}
			        echo "</tr>";
			    }
			    echo "</table>";
			    
			    mysqli_free_result($result);
			}
			mysqli_close($link);
		?>
	</div>
	<footer class="footer">
		<h3>Copyright © 1995-2019 eBay Inc.</h3>
	</footer>
</body>
</html>
<?php 
$dbc = mysqli_connect('localhost', 'root', '', 'lab1');
if(isset($_POST['submit'])){
	$user_first_name = $_POST['first_name'];
	$user_password = $_POST['password1'];
	if(!empty($user_first_name) && !empty($user_password)){
		$query = "SELECT * FROM `users` WHERE first_name = '$user_first_name' AND password = '$user_password'";
		$data = mysqli_query($dbc, $query);
	    if(mysqli_num_rows($data) == 1){
	    	$field = mysqli_fetch_array($data);
			$_SESSION['userID'] = $field['id'];
			$_SESSION['first_name'] = $field['first_name'];
			$_SESSION['last_name'] = $field['last_name'];
			$_SESSION['photo'] = $field['photo'];
			$_SESSION['role_id'] = $field['role_id'];
			$_SESSION['password'] = $field['password'];
			echo "<script language=javascript>document.location.href='user-profile.php'</script>";
	    }else{
	    	echo '<div class="error-msg">Email or password are not correct</div>';
	    }

	}else{
		echo '<div class="error-msg">Please fill up all the fields</div>';
	}
}
?>