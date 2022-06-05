<?php
	require_once ($_SERVER['DOCUMENT_ROOT'] . '/graciousgarments/phps/database/database.php');
    // select 
    $sql = 'select count(IDPRODUCTS) as number from products';
    $result = executeResult($sql);

    if ($result != null && count($result) > 0) {
        $number = $result[0]['number'];
        // echo "<br>"; -- làm này để xuống dòng nhé.
        // echo $number;
    }

    if ($result <= 0) {
        echo '<li class="page-item"><a class="page-link" href="?page=1">Last</a></li>';
    }
    // số lượng sản phẩm trên trang
    $pronumber = 20;
    // tính số trang = tổng số sản phẩm (count)/số sản phẩm trên trang
    $page = ceil($number / $pronumber);
    
    //đoạn này là: nếu có số page trên get thì nó sẽ thể hiện trang hiện tại bằng số page đó
    if (isset($_GET['page'])) {
        $currentPage = $_GET['page']; //nếu không có câu này thì lúc nào nó cũng mặc định page là 1. vì nó k nhảy trang hiện tại đâu;
        if ($currentPage <= 0) {
            header('location: ?page=1');
        }
    } else {
        $currentPage = 1;
    }

    $index = ($currentPage - 1) * $pronumber;
	if ($currentPage - 4 >= 1) {
		echo '
			<div class="page-item">
				<a class="page-link" href="?page=1">First</a>
			</div>';
	}
	if ($currentPage > 1) {
		echo '
			<div class="page-item">
				<a class="page-link" href="?page=' . ($currentPage - 1) . '">Previous</a>
			</div>';
	}
	for ($i = 1; $i <= $page; $i++) {
		if ($i != $currentPage) {
			if ($i >= $currentPage - 3 && $i <= $currentPage + 3) {
				echo '
					<div class="page-item">
						<a class="page-link" href="?page=' . $i . '">' . $i . '</a>
					</div>';
			}
		} else {
			echo '
				<div class="page-item page__is-active">
					<a class="page-link">' . $i . '</a>
				</div>';
		}
	}
	if ($currentPage < $page) {
		echo '
			<div class="page-item">
				<a class="page-link" href="?page=' . ($currentPage + 1) . '">Next</a>
			</div>';
	}
	if ($page - $currentPage >= 4) {
		echo '
			<div class="page-item">
				<a class="page-link" href="?page=' . $page . '">Last</a>
			</div>';
	}
?>