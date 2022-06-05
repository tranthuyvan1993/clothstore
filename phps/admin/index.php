<?php
require_once "../database/database.php";
session_start();
$username = $password = $tel = '';
if (!empty($_POST)) {
	if (isset($_POST['username'])) {
		$username = $_POST['username'];
	}
	if (isset($_POST['password'])) {
		$password = $_POST['password'];
	}
	if (isset($_POST['checkbox'])) {
		$checkbox = $_POST['checkbox'];
	}
	$connect = mysqli_connect(HOST, USERNAME, PASS, DATABASE);
	$connect->set_charset("utf8");
	$query = "SELECT * FROM ADMIN WHERE username = '$username'";
	$result = mysqli_query($connect, $query);
	// header('location: welcome.php');
	if (mysqli_num_rows($result) > 0) {
		while ($row = mysqli_fetch_array($result)) {
			if ($password == $row["PASSWORD"] && $username == $row["USERNAME"]) {
				echo "<script type='text/javascript'>alert('Đăng nhập thành công. Xin chào " . $username . "');</script>";
				// executeRe($query);
				$_SESSION['admin'] = $row;
				header('location: ../product');
			} else {
				echo '<script>alert("Invalid username or password")</script>';
			}
		}
	} else {
		echo '<script>alert("Invalid username or password")</script>';
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login Form</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body style="background-color: black">
	<div class="container" style="width: 500px; height: auto; background-color: #B07F32;">
		<div>
			<ul class="nav nav-pills">
				<li class="nav-item">
					<a href="#" class="nav-link active" >Login Form</a>
				</li>
			</ul>
		</div>
		<div>
			<h1 style="text-align: center">Login Page</h1>
		</div>
		<form action="" method="POST">
			<div class="form-group">
				<label for="Fullname">User name: </label>
				<input type="text" class="form-control" id="username" placeholder="Enter User name" name="username" value="">
			</div>
			<div class="form-group">
				<label for="Fullname">Password: </label>
				<input type="password" class="form-control" id="password" placeholder="Enter Password" name="password" required>
			</div>
			<button style="margin-bottom: 10px" class="btn btn-success" type="submit">Login</button>
		</form>
	</div>
</body>
</html>
