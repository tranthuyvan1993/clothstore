<?php
require_once('../database/database.php');
if (!empty($_POST)) {
	if(isset($_POST['action'])){
		$action=$_POST['action'];
		switch ($action) {
			case 'delete':
			echo "xóa";
			if (isset($_POST['IDBRAND'])) {
				$id    = $_POST['IDBRAND'];
				$query = 'delete from brands where IDBRAND= '.$id;
				executeRe($query);
				echo "đã xóa rồi nhé";
			}
			break;
		}
	}
}
