<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/graciousgarments/phps/database/database.php';
    // $fullname = $age = $address = '';
    $proname = $proprice = $proimg= $idbrand =$prodesc= $created_at = $updated_at='';
    // khởi tạo các giá trị bằng rỗng khi load trang
    if (!empty($_POST)) {
        date_default_timezone_set('Asia/Bangkok'); 
            //set time theo múi giờ Việt Nam, nếu không set là nó lưu theo giờ Mỹ Đình
            $created_at = $updated_at = date('Y-m-d H:i:s');
            // echo $created_at; echo $updated_at; die();
        if (isset($_POST['submit'])) {
        	$id =$_POST['id'];
            //đoạn này là xử lý file upload ảnh.
            $proimg=basename($_FILES['img']['name']);
            // var_dump($proimg); die();
            // lấy ra tên của ảnh dựa vào input "img"
            $target_dir = "../../images/products/"; //file lưu ảnh
            $target_file = $target_dir.$proimg; //lưu tên ảnh vào trong file để lưu
            move_uploaded_file($_FILES["img"]["tmp_name"], $target_file);
            // khi upload 1 file ảnh từ 1 ổ bất kỳ nó sẽ lưu lại file ảnh đó trong thư mục img.
            $filename = basename($_FILES['file']['name']);

    // destination of the file on the server
			$destination = 'fileupload/' . $filename;

    // get the file extension
    		$extension = pathinfo($filename, PATHINFO_EXTENSION);

    // the physical file on a temporary uploads directory on the server
			$file = $_FILES['file']['tmp_name'];
    		$size = $_FILES['file']['size'];
    		if ($_FILES['file']['size'] > 1000000) { // file shouldn't be larger than 1Megabyte
		    	echo "File too large!";
		    } else {
		        // move the uploaded (temporary) file to the specified destination
		    	move_uploaded_file($file, $destination);
        }
        if (isset($_POST['proname'])) {
            $proname =$_POST['proname'];
            $proname = str_replace("'", "\\'", $proname);
        }
        if (isset($_POST['price'])) {
            $proprice =$_POST['price'];
            $proprice = str_replace("'", "\\'", $proprice); //str_replace là để tránh lỗi SQL injection
        }
        if (isset($_POST['idbrand'])) {
            $idbrand =$_POST['idbrand'];
            $idbrand = str_replace("'", "\\'", $idbrand);
        }
        if (isset($_POST['desc'])) {
            $prodesc =$_POST['desc'];
            $prodesc = str_replace("'", "\\'", $prodesc);
        }
        // Nếu có id ==> gọi đến update
        if ($id!='') {
        	// Nếu file ảnh trống và file doc có thì update những cái có còn ảnh dữ nguyên.
            if($_FILES['img']['size'] == 0 && $_FILES['file']['size'] > 0) {
            $query = "update products set FILE_NAME = '$filename', PRODUCT_NAME='$proname',PRICE='$proprice',IDBRAND='$idbrand',`desc`='$prodesc',updated_at='$updated_at' where IDPRODUCTS='$id'";
            }
            // Nếu file ảnh có và file doc trống thì update những cái có còn doc dữ nguyên.
            elseif($_FILES['file']['size'] == 0 && $_FILES['img']['size'] > 0) {
            $query = "update products set IMG='$proimg',PRODUCT_NAME='$proname',PRICE='$proprice',IDBRAND='$idbrand',`desc`='$prodesc',updated_at='$updated_at' where IDPRODUCTS='$id'";

            }
            // Nếu file ảnh trống và file doc trống thì update những cái có còn ảnh và doc dữ nguyên.
            elseif($_FILES['file']['size'] == 0 && $_FILES['img']['size'] == 0) {
            $query = "update products set PRODUCT_NAME='$proname',PRICE='$proprice',IDBRAND='$idbrand',`desc`='$prodesc',updated_at='$updated_at' where IDPRODUCTS='$id'";
            }
            else{
            // Ngoài các trường hợp trên thì update hết :)))
                $query = "update products set FILE_NAME = '$filename',PRODUCT_NAME='$proname',PRICE='$proprice',IMG='$proimg',IDBRAND='$idbrand',`desc`='$prodesc',updated_at='$updated_at' where IDPRODUCTS='$id'";
            // update nhiều giá trị thì dùng dấu ,; - update sản phẩm khi admin edit;
            }
            // Nếu update được thì thông báo
            if (executeRe($query)==true) {
		    		echo"<script type='text/javascript'>alert('Sửa dữ liệu thành công');</script>";
		    		header('location: index.php');
		    	}
		    	else{
		    		$proname = $proprice = $filename= $idbrand =$prodesc='';
		    	}
        } 
        // Nếu không có id thì là thêm mới sản phẩm
        else{
        	$query = "insert into products(PRODUCT_NAME,PRICE,FILE_NAME,IMG,`DESC`,IDBRAND,created_at,updated_at) value('$proname','$proprice','$filename','$proimg','$prodesc','$idbrand','$created_at','$updated_at')";
        	// executeRe($query);
        	if (executeRe($query)==true) {
        		echo"<script type='text/javascript'>alert('Thêm dữ liệu thành công');</script>";
        		header('location: index.php');
        	}
        	else{
        		$proname = $proprice = $filename= $idbrand =$prodesc='';
        	}
        }
        // var_dump($query);die();
            // insert dữ liệu mới
        }
    }
    // Đoạn này để lấy dữ liệu có sẵn từ db đổ về trang khi update
    $id='';
    if (isset($_GET['id'])) {
        $id    = $_GET['id'];
        $query = 'select * from products where IDPRODUCTS='.$id;
        $productlist = executeResult($query);
        if ($productlist!=null && count($productlist)>0) {
            $prolist = $productlist[0];
            $proname = $prolist['PRODUCT_NAME'];
            $proprice = $prolist['PRICE'];
            $proimg= $prolist['IMG'];
            $prodesc= $prolist['DESC'];
            $idbrand= $prolist['IDBRAND'];
            // đoạn này lấy ra giá trị đã tồn lại trong database để khi edit nó sẽ hiện lên giá trị đó
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
		<h1>ADD/EDIT PRODUCTS</h1>
	</div>
	<div class="container" margin="50px">
		
		<form action="" method="POST" enctype="multipart/form-data">
			<div class="form-group">
				<input type="number" name="id" id="id" value="<?=$id?>" style="display: none" >
				<!-- Nếu không có cái dòng input id này thì khi post dữ liệu lên sẽ k nhận được đâu là $id cả -->
			</div>
			<div class="form-group">
				<label for="proname">PRODUCT_NAME: </label>
				<input type="text" class="form-control" id="title" placeholder="Enter proname" name="proname" value="<?=$proname?>" requried>
				<!-- Phải cho value="..." khi nó mới điền vào ô giá trị lấy từ database ra để update -->
			</div>
			<div class="form-group">
				<label for="namecata">Select Brands: </label>
				<select name="idbrand" class="form-control">
					<?php
					$query = 'select * from brands';
					$brandlist = executeResult($query);
					foreach ($brandlist as $list) {
						if ($list['IDBRAND'] == $idbrand) {
							echo '<option selected value="'.$list['IDBRAND'].'">'.$list['BRAND_NAME'].'</option>
							';
						}else{
							echo '<option value="'.$list['IDBRAND'].'">'.$list['BRAND_NAME'].'</option>
							';
						}
					}
					?>
				</select>
				<!-- Phải cho value="..." khi nó mới điền vào ô giá trị lấy từ database ra để update -->
			</div>
			<div class="form-group">
				<label for="namecata">Price: </label>
				<input type="number" class="form-control" id="price" placeholder="Enter price" name="price" value="<?=$proprice?>" required>
			</div>
			<div class="form-group">
				<label for="namecata">IMG: </label>
				<input type="file" class="form-control" name="img" id="img" placeholder="Enter img" accept="image/*" onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
				<!-- <img src="img/10k-2-in-1-running-shorts-QBd76d.jpg" style="max-width: 200px" id="imgChange"> -->
				<?php  
					if(empty($_FILES['proimg'])){
						echo'<img id="output" src="" width="100" height="100">';
					}
				?>
			</div>
			<div class="form-group">
				<label for="namecata">DECRIPTION FILE: </label>
				<input type="file" class="form-control" name="file" id="file" placeholder="Enter file to download" accept=".doc, .docx">
			</div>
			<div class="form-group">
				<label for="namecata">Description: </label>
				<textarea class="form-control" id="desc" placeholder="Enter desc" name="desc" rows="5" required><?=$prodesc?></textarea>
				<!-- textarea không có value như input nên phải viết riêng như trên nhé -->
			</div>
			<button class="btn btn-success" type="submit" name="submit">Submit</button>
			<a href="index.php" title="" ><button class="btn btn-success" type="button">HOME</button></a>
		</form>
	</div>
	<script type="text/javascript">
		//Viết $ function là để thực thi cuối cùng sau khi load xong trang web. Cách tham khảo summernote: https://summernote.org/getting-started/#run-summernote
		$(function(){
			$('#desc').summernote({
				height: 300, 
				minHeight: null,           
				maxHeight: null,           
				focus: true  
			});
		})
	</script>
</body>
</html>
