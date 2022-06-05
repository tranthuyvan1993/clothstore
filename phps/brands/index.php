<?php
require_once '../database/database.php';
session_start();
$admin = (isset($_SESSION['admin'])) ? $_SESSION['admin'] : [];
?>
<!DOCTYPE html>
<html>
<head>
	<title>Cloth Store</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<div>
			<ul class="nav nav-pills">
				<li class="nav-item">
					<a href="#" title="" class="nav-link active">Brands Management</a>
				</li>
				<li class="nav-item">
					<a href="../product/" title="" class="nav-link">Products Management</a>
				</li>
				<li class="nav-item">
					<?php if (isset($admin['FULLNAME'])) {?>
						<a href="#" title="" title="" class="nav-link">Welcome Admin: <?php echo $admin['FULLNAME']; ?></a>
					</li>
					<li class="nav-item">
						<a href="../admin/logoutadmin.php" class="nav-link">Logout</a>
					</li>
				<?php }
?>
			</ul>
		</div>
		<div class="jumbotron text-center">
			<h1>brands Management</h1>
			<p>Hope you have a wonderful shopping time!</p>
		</div>
		<a href='input.php' title=""><button class="btn btn-outline-primary">Add Brand</button></a>
		<form class="" method="POST" action="">
			<table class="table table-bordered">
				<thead>
					<tr>
						<th>STT</th>
						<th style="width: 10%">Area</th>
						<th style="width: 20%">IMG</th>
						<th>created_at</th>
						<th>updated_at</th>
						<th>BRAND_INFO</th>
						<th style="width: 20%">Function</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<?php
$index = 1;
$query = 'select * from brands';
$brandslist = executeResult($query);

if ($brandslist != null && count($brandslist) > 0) {
	foreach ($brandslist as $catalist) {
		echo '<tr>
								<td>' . $index++ . '</td>
								<td>' . $catalist['BRAND_NAME'] . '</td>
								<td><img src="' . $catalist['IMG'] . '" style="width: 20%"></td>
								<td>' . $catalist['created_at'] . '</td>
								<td>' . $catalist['updated_at'] . '</td>
								<td>' . $catalist['BRAND_INFO'] . '</td>
								<td><a style="color: white" href="input.php?id=' . $catalist['IDBRAND'] . '" class="btn btn-warning">Edit</a>
									<button class="btn btn-danger" onclick="deleted(' . $catalist['IDBRAND'] . ')">Delete</button></td>
								</tr>
								';
	}
} else {
	echo ("chưa có dữ liệu");
}

?>
					</tr>
				</tbody>
			</table>
		</form>
		<script type="text/javascript">
			function deleted(id){
				option = confirm('Bạn có muốn xóa không?')
				if (!option) {
					return;
				}
				$.post('deletestd.php',{
					'IDBRAND'    :id,
					'action':'delete'
					//action để có thể thực hiện với các chức năng khác
				}, function(data){
					alert('đã xóa rồi nhé');
					location.reload();
				})
			}
		</script>
	</body>
	</html>