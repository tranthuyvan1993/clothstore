<?php
    session_start();
    // !-- Lấy thông tin user từ Session -->
    $user = (isset($_SESSION['user'])) ? $_SESSION['user'] : [];
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="icon" type="image/x-icon" href="images/favicon.ico">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.6.1/font/bootstrap-icons.css">
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
                        <a class="navbar__link navbar__link--is-active cart-area " href="cartdetail.php">
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
    <div class="cart-table-area">
        <table class="cart-table">
            <tr>
                <th>NO</th>
                <th>IMAGE</th>
                <th>NAME</th>
                <th>BRAND</th>
                <th>PRICE</th>
                <th>QUANTITY</th>
                <th>TOTAL</th>
                <th></th>
            </tr>
        <!-- Lấy thông tin giỏ hàng từ Session -->
        <?php
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            $index = 0;
            echo "<br/>";
            foreach ($_SESSION['cart'] as $item) {
                // var_dump($item);
                echo '<tr>
                        <td>' . (++$index) . '</td>
                        <td>
                            <img src="images/products/' . $item['IMG'] . '" alt=""/>
                        </td>
                        <td>' . strtoupper($item['PRODUCT_NAME']) . '</td>
                        <td>' . strtoupper($item['BRAND_NAME']) . '</td>
                        <td>' . number_format($item['PRICE']) . ' VND</td>
                        <td class="cart-table__input-cell">
                            <div class="cart-table__input-area">
                                <button class="cart-table__button" onclick="addMoreCart(' . $item['IDPRODUCTS'] . ', -1)">
                                    <img class="cart-table__button-icon" src="icons/subtract_12_regular.svg">
                                </button>
                                <input class="cart-table__input" type="number" id="num_' . $item['IDPRODUCTS'] . '" value="' . $item['num'] . '" onchange="fixCartNum(' . $item['IDPRODUCTS'] . ')"/>
                                <button class="cart-table__button" onclick="addMoreCart(' . $item['IDPRODUCTS'] . ', 1)">
                                    <img class="cart-table__button-icon" src="icons/add_12_regular.svg">
                                </button>
                            </div>
                        </td>
                        <td>' . number_format($item['PRICE'] * $item['num']) . ' VND</td>
                        <td>
                            <button class="cart-table__button" onclick="updateCart(' . $item['IDPRODUCTS'] . ', 0)">
                                <span>Remove<span>
                            </button>
                        </td>
                    </tr>';
            }
        ?>
        </table>
    </div>
<!-- Function thêm/xóa sản phẩm gọi đến từ file phps/api/api.php -->
    <script type="text/javascript">
        function addMoreCart(IDPRODUCTS, delta) {
            num = parseInt($('#num_' + IDPRODUCTS).val())
            // console.log(IDPRODUCTS + "," + num)
            num += delta
            $('#num_' + IDPRODUCTS).val(num)
            updateCart(IDPRODUCTS, num)
            // update lại num để tính tiền và số lượng trong giỏ hàng
        }
// Fuction này để đảm bảo giá trị không được âm
        function fixCartNum(IDPRODUCTS) {
            $('#num_' + IDPRODUCTS).val(Math.abs($('#num_' + IDPRODUCTS).val()))
            updateCart(IDPRODUCTS, $('#num_' + IDPRODUCTS).val())
            // update lại num để tính tiền và số lượng trong giỏ hàng
        }
    // Update giỏ hàng khi sửa/ xóa (Khi click Remove, sẽ để số lượng về 0)
        function updateCart(IDPRODUCTS, num) {
            $.post('http://localhost/graciousgarments/phps/api/api_cart.php', {
                'action': 'update_cart',
                'IDPRODUCTS': IDPRODUCTS,
                'num': num
            }, function(data) {
                location.reload()
            })
        }
    </script>
</body>
</html>