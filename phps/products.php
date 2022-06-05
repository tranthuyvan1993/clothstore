<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/graciousgarments/phps/database/database.php';
    // select 
    $pronumber = 20;
    // giá trị index ==> vị trí của sản phẩm bắt đầu của 1 trang
    if (isset($_GET['page'])) {
        $currentPage = $_GET['page']; //nếu không có câu này thì lúc nào nó cũng mặc định page là 1. vì nó k nhảy trang hiện tại đâu;
        if ($currentPage <= 0) {
            header('location: ?page=1');
        }
    } else {
        $currentPage = 1;
    }
    $index = ($currentPage - 1) * $pronumber;
    // Lấy ra các thông tin của sản phẩm trong 1 trang (số lượng sản phẩm từ sản phẩm thứ index ==> 20)
    $query = 'select p.updated_at as updated_at, b.IDBRAND as IDBRAND,b.BRAND_NAME as BRAND_NAME, p.PRODUCT_NAME as PRODUCT_NAME, IDPRODUCTS, p.PRICE, p.IMG as IMG from products p, brands b where p.IDBRAND = b.IDBRAND order by updated_at desc limit ' . $index . ', '.$pronumber.'';
    $result = executeResult($query);
    $i = 0;
    if ($result != null && count($result) > 0) {
        foreach ($result as $product) {
        $num1 = $product['PRICE'];
        // $formatnum1 = number_format($num1, 2, ',', '.');
        $formatnum1 = number_format($num1, 0, ',', '.');
        //Số 0 là chữ số thập phân, dấu ',' ;là tách sau số thập phân==> 10.000,00
        if ($i % 4 == 0) {
            echo '<div class="product-tiles__row">';
        }
        $i++;
        // in ra các thông tin của sản phẩm
        echo '
            <div class="product-tiles__col">
                <div class="product-card">
                    <div class="product-card__thumbnail">
                        <a href="showproducts.php?id=' . $product['IDPRODUCTS'] . '"><img src="http://localhost/graciousgarments/images/products/' . $product['IMG'] . '" alt=""></a>
                    </div>
                    <div class="product-card__text-area">
                        <div class="product-name" title="' . $product['PRODUCT_NAME'] . '">
                            <a href="showproducts.php?id=' . $product['IDPRODUCTS'] . '">' . strtoupper($product['PRODUCT_NAME']) . '</a>
                        </div>
                        <div class="product-brand">
                                <a href="showbrands.php?id=' . $product['IDBRAND'] . '">' . strtoupper($product['BRAND_NAME']) . '</a>
                            </div>
                        <div class="product-price">
                            <span>' . $formatnum1 . ' VND</span>
                        </div>
                    </div>
                    <div class="product-card__action-area">
                        <button class="product-card__button" onclick="add2Cart(' . $product['IDPRODUCTS'] . ',1)">
                            <span>Add to cart</span>
                            <img class="icon" src="icons/cart_20_regular.svg">
                        </button>
                    </div>
                </div>
            </div>
        ';
        if ($i % 4 == 0) {
            echo '</div>';
        }
    }
    }
    
?>
<!-- Function thêm sản phẩm vào giỏ hàng, gọi đến trang api để xử lý function -->