<?php
require_once('../database/database.php');
// $fullname = $age = $address = '';
$namecata = $cataimg= $catadesc = $catainfo ='';

if (!empty($_POST)) {
	if(isset($_POST['namecata'])){
		$namecata = $_POST['namecata'];
		date_default_timezone_set('Asia/Ho_Chi_Minh');
		$created_at = $updated_at = date('Y-m-d H:s:i');
		//Lấy ra thời gian hiện tai
		$namecata = str_replace("'", "\\'", $namecata);
		// Câu này để tránh lỗi SQL injection có ký tự '', nếu câu insert hoặc update để ký tự "" thì sửa lại là được
	}
	if (isset($_POST['id'])) {
		$id =$_POST['id'];
	}
	if (isset($_POST['catainfo'])) {
		$catainfo =$_POST['catainfo'];
	}
	if (isset($_POST['catadesc'])) {
		$catadesc =$_POST['catadesc'];
	}
	if (isset($_POST['img'])) {
		$cataimg =$_POST['img'];
		$cataimg = str_replace("'", "\\'", $cataimg);
	}
	if ($id!='') {
		//update student
		$query = "update brands set BRAND_INFO = '$catainfo', BRAND_DESC = '$catadesc', BRAND_NAME='$namecata',IMG='$cataimg',updated_at='$updated_at' where IDBRAND='$id'";
		// update nhiều giá trị thì dùng dấu ,;
	} else{
		$query = "insert into brands(BRAND_NAME,created_at,updated_at,IMG, BRAND_INFO, BRAND_DESC) value('$namecata','$created_at','$updated_at','$cataimg', '$catainfo', '$catadesc')";
		// echo $query;
		// die(); 
		// Phải có dòng die này nó mới in ra cái $query được.
	}
	// echo $query;
	if (executeRe($query)) {
		echo"<script type='text/javascript'>alert('Thêm dữ liệu thành công');</script>";
	}else{
		$namecata = ''; $cataimg='';
	}
}
$id='';
if (isset($_GET['id'])) {
	$id    = $_GET['id'];
	$query = 'select * from brands where IDBRAND='.$id;
	$brandslist = executeResult($query);
	if ($brandslist!=null && count($brandslist)>0) {
		$catalist = $brandslist[0];
		$namecata = $catalist['BRAND_NAME'];
		$cataimg= $catalist['IMG'];
		$catainfo = $catalist['BRAND_INFO'];
		$catadesc = $catalist['BRAND_DESC'];
	}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>PHP 1</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
	<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
	<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
</head>
<body>
	<div class="jumbotron text-center" style="height: 200px">
		<h1>ADD/EDIT BRANDS</h1>
	</div>
	<div class="container" margin="50px">
		<form action="" method="POST">
			<div class="form-group">
				<label for="namecata">Name Brand: </label>
				<input type="number" name="id" id="id" value="<?=$id?>" style="display: none">
				<!-- Nếu không có cái dòng input id này thì khi post dữ liệu lên sẽ k nhận được đâu là $id cả -->
				<input type="text" class="form-control" id="namecata" placeholder="Enter namebrands" name="namecata" value="<?=$namecata?>" required>
				<!-- Phải cho value="..." khi nó mới điền vào ô giá trị lấy từ database ra để update -->
			</div>
			<div class="form-group">
				<label for="namecata">IMG: </label>
				<input type="text" class="form-control" id="img" placeholder="Enter img" name="img" value="<?=$cataimg?>" onchange="updateImg()" required>
				<img src="<?=$cataimg?>" style="max-width: 200px" id="imgChange">
			</div>
			<div class="form-group">
				<label for="namecata">BRAND_INFO: </label>
				<input type="text" class="form-control" id="catainfo" placeholder="Enter brands information" name="catainfo" value="<?=$catainfo?>" required>
			</div>
			<div class="form-group">
				<label for="namecata">BRAND_DESCRIPTION: </label>
				<textarea class="form-control" id="catadesc" placeholder="Enter desc" name="catadesc" rows="5"><?=$catadesc?></textarea>
				<!-- textarea không có value như input nên phải viết riêng như trên nhé -->
			</div>
			<button class="btn btn-success" type="submit">Submit</button>
			<a href="index.php" title="" ><button class="btn btn-success" type="button">HOME</button></a>
		</form>
	</div>
	<script type="text/javascript">
		function updateImg(){
			$('#imgChange').attr('src',$('#img').val())
		}
		$(function(){
			$('#catadesc').summernote({
				height: 300, 
				minHeight: null,           
				maxHeight: null,           
				focus: true  
			});
		})
		//Viết $ function là để thực thi cuối cùng sau khi load xong trang web. Cách tham khảo summernote: https://summernote.org/getting-started/#run-summernote
	</script>
</body>
</html>
