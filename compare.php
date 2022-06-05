<?php
    require_once 'phps/database/database.php';
    $id1= $_GET['id1'];
    $id2= $_GET['id2'];
    $query2 = "select p.DESC as `DESC`, p.IMG as IMG, b.IDBRAND as IDBRAND,b.BRAND_NAME as BRAND_NAME, p.PRODUCT_NAME as PRODUCT_NAME, IDPRODUCTS, p.PRICE as PRICE, p.IMG as IMG from products p, brands b where p.IDBRAND = b.IDBRAND and (IDPRODUCTS='$id1' or IDPRODUCTS='$id2')";
    $result = executeResult($query2);
    foreach ($result as $product) {
            // var_dump($result);
        $num1 = $product['PRICE'];
            // $formatnum1 = number_format($num1, 2, ',', '.');
        $formatnum1 = number_format($num1, 0, ',', '.');
            //Số 0 là chữ số thập phân, dấu ',' ;là tách sau số thập phân==> 10.000,00
        $name = $product['PRODUCT_NAME'];
        echo '
        <div class="product-tiles__col">
            <div class="product-card">
                <div class="product-card__thumbnail">
                    <a href="showproducts.php?id=' . $product['IDPRODUCTS'] . '"><img src="images/products/' . $product['IMG'] . '" alt=""></a>
                </div>
                <div class="product-card__text-area">
                    <div class="product-name" title="' . $product['PRODUCT_NAME'] . '">
                        <a href="showproducts.php?id=' . $product['IDPRODUCTS'] . '">' . strtoupper($product['PRODUCT_NAME']) . '</a>
                    </div>
                    <div class="product-brand"> 
                        <a href="brands/showbrands.php?id=' . $product['IDBRAND'] . '">' . strtoupper($product['BRAND_NAME']) . '</a>
                    </div>
                    <div class="product-price">
                        <span>' . $formatnum1 . ' VND</span>
                    </div>
                    <div class="product-specs">
                        <span>' .($product['DESC']) . '</span>
                    </div>                                
                </div>
            </div>
        </div>';
    }
?>