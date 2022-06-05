<?php  
    require_once $_SERVER['DOCUMENT_ROOT'] . '/graciousgarments/phps/database/database.php';
    session_start();
    $count = 0; //Số lượng trong giỏ hàng
    // Lấy ra thống tin sản phẩm cần so sánh với sản phẩm đang có 
    $querycompare = 'select * from products order by PRODUCT_NAME';
    $resultcompare = executeResult($querycompare);
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    foreach ($_SESSION['cart'] as $items) {
        $count += $items['num'];
    }
    // Chức năng tải file xuống
    if (isset($_GET['file_id'])) {
        $id = $_GET['file_id'];
        $query = "SELECT * FROM products WHERE IDPRODUCTS = '$id'";
        $productlist = executeResult($query);
        if ($productlist != null && count($productlist) > 0) {
            foreach ($productlist as $product) {
                $filepath = 'phps/product/fileupload/' . $product['FILE_NAME'];
            }
        }
        if (file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($filepath));
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            // header('Content-Length: ' . filesize('img/' . $file['name']));
            readfile('phps/product/fileupload/' . $product['FILE_NAME']);
            exit;
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="styles/index.css">
    <script type="module" src="https://unpkg.com/@fluentui/web-components"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script type="text/javascript" src="scripts/index.js" defer></script>
    <title>Gracious Garments</title>
</head>
<body>
    <div id="header" class="header-area"> <!--header/navigation bar-->
        <header>
            <div id="navbar" class="navbar">
                <a class="navbar__logo-container" href="index.php">
                    <div class="navbar__logo">
                        <img src="images/ggLogo.png" alt="">
                        <div class="navbar__title">
                            <span class="primary-color__text">Gracious</span> <span class="secondary-color__text">Garments</span>
                        </div>
                    </div>
                </a>
                <div class="navbar__link-container">
                    <nav class="navbar__page-section">
                        <a class="navbar__link" href="index.php">
                            <span>Home</span>
                        </a>
                        <a id="brandButton" class="navbar__link" onclick="toggleBrandMenu();">
                            <span>Brands</span>
                        </a>
                        <a class="navbar__link" href="contacts.php">
                            <span>Contacts</span>
                        </a>
                    </nav>
                    <nav class="navbar__user-section">
                        <?php if (isset($user['FULLNAME'])) {?>
                            <a id="customerProfileButton" href="#" class="navbar__link" title="<?php echo $user['FULLNAME']; ?>">
                                <span><?php echo $user['FULLNAME']; ?></span>
                            </a>
                            <a class="navbar__link" href="phps/customer/logoutcus.php">
                                <span>Logout</span>
                            </a>
                        <?php } else {?>
                            <a class="navbar__link" href="login.php">
                                <span>Login</span>
                            </a>
                            <a class="navbar__link" href="register.php">
                                <span>Register</span>
                            </a>
                        <?php }?>
                        <a class="navbar__link cart-area" href="cartdetail.php">
                            <?php require_once 'phps/showcart.php'; ?>
                            <div class="cart-count">
                                <span><?=$count?></span>
                            </div>                            
                            <img class="cart-icon" src="icons/cart_24_regular.svg">
                            <span>Cart</span>
                        </a>
                    </nav>
                </div>
            </div>
        </header>
    </div>
    <section id="brandMenuContainer" class="brand-menu-container"> <!--brand menu-->
        <div id="brandMenu" class="brand-menu acrylic__light">
            <?php require_once 'phps/brands.php';?>
            <div class="brand-menu__close-button__container">
                <button id="brandMenuCloseButton" class="brand-menu__close-button" onclick="closeBrandMenu();">
                    <img src="icons/dismiss_32_regular.svg">
                </button>
            </div>
        </div>
    </section>
    <section class="main-product-section">
        <!-- Lấy ra thông tin sản phẩm đang được trỏ đến -->
        <?php
        $id = '';
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $query = 'select p.DESC as `DESC`, p.IMG as IMG, b.IDBRAND as IDBRAND,b.BRAND_NAME as BRAND_NAME, p.PRODUCT_NAME as PRODUCT_NAME, IDPRODUCTS, p.PRICE as PRICE, p.IMG as IMG from products p, brands b where p.IDBRAND = b.IDBRAND and IDPRODUCTS= ' . $id;
            $result = executeResult($query);
            if ($result) {
                foreach ($result as $product) {
                    $num1 = $product['PRICE'];
                    $formatnum1 = number_format($num1, 0, ',', '.');
                                //Số 0 là chữ số thập phân, dấu ',' ;là tách sau số thập phân==> 10.000,00
                                // echo $formatnum;
                    $name = $product['PRODUCT_NAME'];
                // in ra thông tin sản phẩm
                    echo '
                    <div class="product-overview-area">
                        <div class="product-thumbnail">
                            <img src="images/products/' . $product['IMG'] . '">
                        </div>
                        <div class="product-overview">
                            <div class="product-overview__title">
                                <span>' . strtoupper($product['PRODUCT_NAME']) . '</span>
                            </div>
                            <div class="product-overview__brand">
                                <a href="showbrands.php?id=' . $product['IDBRAND'] . '">
                                    <span>' . strtoupper($product['BRAND_NAME']) . '</span>
                                </a>
                            </div>
                            <div class="product-overview__price">
                                <span>' . $formatnum1 . ' VND</span>
                            </div>
                            <div class="product-overview__addcart">
                                <button class="addcart-button" onclick="add2Cart(' . $product['IDPRODUCTS'] . ',1)">
                                    <span>Add to cart</span>
                                </button>
                            </div>
                            <div class="product-overview__specs">
                                <span>' . $product['DESC'] . '</span>
                            </div>
                            <button class="download-button">
                                <a href="showproducts.php?file_id='.$id.'">
                                    <span>Download product details</span>
                                </a>
                            </button>
                            <button class="show-compare-button" onclick="toggleCompareForm()">
                                <span>Compare with another product</span>
                            </button>
                        </div>
                    </div>';
                }
            }
        }
        ?>
        <!-- So sánh với sản phẩm khác -->
        <div id="compareForm" class="product-compare-area">
            <div class="product-compare__row">
                <div class="product-compare__col">
                    <fluent-combobox id="combobox1" placeholder="Type or choose a product" disabled>
                        <?php foreach ($result as $item) : ?>
                            <fluent-option value="<?= $item['IDPRODUCTS'] ?>" selected><?= strtoupper($item['PRODUCT_NAME']) ?></fluent-option>
                        <?php endforeach; ?>
                    </fluent-combobox>
                </div>
                <button class="product-compare__button" type="button" onclick="showSelectedProduct()">
                    <span>Compare</span>
                </button>
                <div class="product-compare__col">
                    <fluent-combobox id="combobox2"placeholder="Type or choose a product" autocomplete="both">
                        <?php foreach ($resultcompare as $item) : ?>
                            <fluent-option value="<?= $item['IDPRODUCTS']?>"><?= strtoupper($item['PRODUCT_NAME']) ?></fluent-option>
                        <?php endforeach; ?>
                    </fluent-combobox>
                </div>
            </div>
            <div id="compareArea" class="compare-page"></div>
        </div>
    </section>
    <div class="footer-area">
        <footer>
            <div class="footer__info-area">
                <div>
                    <span>Address: 59 Huynh Thuc Khang st</span>
                </div>
                <div>
                    <span>Email: hieu1871998@gmail.com</span>
                </div>
            </div>
            <div class="footer__logo-area">
                <img src="images/ggLogo.png">
                <div class="footer__logo-title">
                    <span class="primary-color__text">Gracious</span> <span class="secondary-color__text">Garments</span>
                </div>
            </div>
        </footer>
    </div>
    <?php require_once 'phps/database/database.php'; 
    ?>
</body>
</html>