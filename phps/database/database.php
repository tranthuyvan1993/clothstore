<?php
const HOST = 'localhost';
const USERNAME = 'root';
const PASS = '';
const DATABASE = 'gg_db';
function createDB() {
	$conn = new mysqli(HOST, USERNAME, PASS);
	$conn->set_charset("utf8");
	$query = 'CREATE DATABASE if not exists ' . DATABASE . ' CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci';
	// $query = 'create database CHARACTER SET utf8 COLLATE utf8_vietnamese_ci if not exists '.DATABASE;
	mysqli_query($conn, $query);
	if ($conn->query($query) === TRUE) {
		echo "<style>.topbar {display:none;}database ok</style>";}
	// echo "database create";}
	else {
		echo "Error creating database: " . $conn->error;
	}
	mysqli_close($conn);
}
function createTables() {
	$conn = new mysqli(HOST, USERNAME, PASS, DATABASE);
	$conn->set_charset("utf8");
	$errors = [];

	$table1 = 'create table if not exists brands(
		IDBRAND INT PRIMARY KEY AUTO_INCREMENT,
		BRAND_NAME VARCHAR(100) NOT NULL UNIQUE,
		IMG varchar(400) NOT NULL,
		created_at datetime,
		updated_at datetime);';
	$table2 = 'create table if not exists products(
		IDPRODUCTS INT PRIMARY KEY AUTO_INCREMENT,
		PRODUCT_NAME VARCHAR(100) NOT NULL,
		IDBRAND INT NOT NULL,
		IMG varchar(400) NOT NULL,
		`DESC` TEXT NOT NULL,
		PRICE DECIMAL NOT NULL,
		created_at datetime,
		updated_at datetime,
		FOREIGN KEY (IDBRAND)
        REFERENCES BRANDS(IDBRAND)
        ON DELETE CASCADE);';
	$table3 = 'create table if not exists USERS(
    	IDUSER INT PRIMARY KEY AUTO_INCREMENT,
		USERNAME VARCHAR(20) UNIQUE NOT NULL,
		PASSWORD VARCHAR(200),
		FULLNAME VARCHAR(50) NOT NULL,
		ADDRESS VARCHAR(200) NOT NULL,
		PHONENUMBER VARCHAR(12) NOT NULL);';
	$table4 = 'create table if not exists ADMIN(
    	IDADMIN INT PRIMARY KEY AUTO_INCREMENT,
		USERNAME VARCHAR(20) UNIQUE NOT NULL,
		PASSWORD VARCHAR(20) NOT NULL,
		FULLNAME VARCHAR(50) NOT NULL,
		ADDRESS VARCHAR(200) NOT NULL,
		PHONENUMBER VARCHAR(12) NOT NULL);';
	$tables = [$table1, $table2, $table3, $table4];
	foreach ($tables as $k => $sql) {
		$query = @$conn->query($sql);

		if (!$query) {
			$errors[] = "<style>.topbar {display:none;}Table $k : Creation failed ($conn->error)</style>";
		}
	}
	foreach ($errors as $msg) {
		echo "$msg <br>";
	}
	mysqli_close($conn);
}
function executeRe($query) {
	$conn = mysqli_connect(HOST, USERNAME, PASS, DATABASE);
	$conn->set_charset("utf8");
	if ($conn->connect_error) {
		var_dump($conn->connect_error);
		die();
	}
	// mysqli_query($conn,$query); -- Nếu thêm cả câu này là nó insert 2 lần đấy nhé.
	if($conn->query($query) === TRUE) {
		return true;
	} else {
		return false;
	}
	mysqli_close($conn);
}
function executeUp($query) {
	$conn = mysqli_connect(HOST, USERNAME, PASS, DATABASE);
	$conn->set_charset("utf8");
	if ($conn->connect_error) {
		var_dump($conn->connect_error);
		die();
	}
	// mysqli_query($conn,$query); -- Nếu thêm cả câu này là nó insert 2 lần đấy nhé.
	if ($conn->query($query) === TRUE) {
		echo '<script>alert("Đã đổi mật khẩu rồi nhé")</script>';
		// header('location: index.php');
	} else {
		echo "<script type='text/javascript'>alert('Không thể insert. Vui lòng nhập lại');</script>";
	}
	mysqli_close($conn);
}
function executeResult($query) {
	$conn = new mysqli(HOST, USERNAME, PASS, DATABASE);
	$conn->set_charset("utf8");
	$list = [];
	$result = mysqli_query($conn, $query);
	if ($result) {
		while ($row = mysqli_fetch_array($result, 1)) {
			$list[] = $row;
		}
		return $list;
	}
	mysqli_close($conn);
}
function executeCart($query, $isSingle = false) {
	$data = null;

	//open connection
	$conn = mysqli_connect(HOST, USERNAME, PASS, DATABASE);
	mysqli_set_charset($conn, 'utf8');

	//query
	$resultset = mysqli_query($conn, $query);
	if ($isSingle) {
		$data = mysqli_fetch_array($resultset, 1);
	} else {
		$data = [];
		while (($row = mysqli_fetch_array($resultset, 1)) != null) {
			$data[] = $row;
		}
	}

	//close connection
	mysqli_close($conn);

	return $data;
}
createDB();
// createTables();
