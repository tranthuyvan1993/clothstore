<?php
require_once('../database/database.php');
if (!empty($_POST)) {
	if(isset($_POST['action'])){
		$action=$_POST['action'];
		switch ($action) {
			case 'delete':
			echo "xóa";
			if (isset($_POST['id'])) {
				$id    = $_POST['id'];
				$query = 'delete from products where IDPRODUCTS= '.$id;
				//xóa xong thì update lại trong db
				executeRe($query);
			}
			break;
		}
		echo $query;
	}
}