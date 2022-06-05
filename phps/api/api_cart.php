<?php
// session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/graciousgarments/phps/database/database.php';
// Tránh lỗi SQL Injection
function fixSqlInject($sql) {
	$sql = str_replace('\\', '\\\\', $sql);
	$sql = str_replace('\'', '\\\'', $sql);
	return $sql;
}
// Lấy ra giá trị khi nhập
function getPost($key) {
	$value = '';
	if (isset($_POST[$key])) {
		$value = $_POST[$key];
		$value = fixSqlInject($value);
	}
	return trim($value);
}
$action = getPost('action');
// tùy chọn để ajax gọi đến
switch ($action) {
case 'cart':
	addCart();
	break;
case 'update_cart':
	updateCart();
	break;
}
// Thêm vào giỏ hàng
function addCart() {
	session_start();
	$id = getPost('IDPRODUCTS');
	$num = getPost('num');
	$isFind = false;
	if (!isset($_SESSION['cart'])) {
		$_SESSION['cart'] = [];
	}
	// var_dump($_SESSION['cart']);
	// nếu giỏ hàng đã tồn tại sản phẩm thì tăng số lượng lên
	for ($i = 0; $i < count($_SESSION['cart']); $i++) {
		if ($_SESSION['cart'][$i]['IDPRODUCTS'] == $id) {
			$_SESSION['cart'][$i]['num'] += $num;
			$isFind = true;
			break;
		}
	}
// Nếu giỏ hàng chưa có sản phẩm đó thì lấy thông tin sản phẩm đó và thêm vào
	if (!$isFind) {
		$query = 'select p.IMG as IMG, b.IDBRAND as IDBRAND,b.BRAND_NAME as BRAND_NAME, p.PRODUCT_NAME as PRODUCT_NAME, p.IDPRODUCTS as IDPRODUCTS, p.PRICE as PRICE, p.IMG as IMG from products p, brands b where p.IDBRAND = b.IDBRAND and IDPRODUCTS= ' . $id;
		$result = executeCart($query, true);
		// var_dump($result);die();
		$result['num'] = $num;
		$_SESSION['cart'][] = $result;
	}
}
// Update giỏ hàng
function updateCart() {
	session_start();
	$id = getPost('IDPRODUCTS');
	$num = getPost('num');

	if (!isset($_SESSION['cart'])) {
		$_SESSION['cart'] = [];
	}

	for ($i = 0; $i < count($_SESSION['cart']); $i++) {
		if ($_SESSION['cart'][$i]['IDPRODUCTS'] == $id) {
			$_SESSION['cart'][$i]['num'] = $num;
			if ($num <= 0) {
				// Câu lệnh để xóa giỏ hàng khi số lượng bằng 0;
				array_splice($_SESSION['cart'], $i, 1);
			}
			break;
		}
	}
}