<?php
	$dbc = mysqli_connect('localhost', 'root', '', 'lab1');
	$userID = $_GET['id'];
	$query = "DELETE FROM `users` WHERE id = $userID";
	$data = mysqli_query($dbc, $query);
	echo "<script language=javascript>document.location.href='index.php'</script>";
?>