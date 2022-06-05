<?php require_once 'phps/database/database.php'; ?>
<!-- Gọi đến file phps/database/database.php ==> trang này có chức năng tạo kết nối đến database và tạo 1 số hàm tương tác với dữ liệu -->
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
    <?php session_start();
        $user = (isset($_SESSION['user'])) ? $_SESSION['user'] : [];
        $count = 0; //mặc định giỏ hàng số lượng bằng 0.
        // Start Session để lấy thông tin user đăng nhập và thông tin giỏ hàng.

    ?>
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
                        <a class="navbar__link navbar__link--is-active" href="index.php">
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
                        <!-- Lấy thông tin Username từ Session -->
                        <?php if (isset($user['FULLNAME'])) {?>
                        <a id="customerProfileButton" href="#" class="navbar__link" title="<?php echo $user['FULLNAME']; ?>">
                            <span><?php echo $user['FULLNAME']; ?></span>
                        </a>
                        <!-- Logout bằng cách gọi đến file phps/customer/logoutcus.php và unset session -->
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
                            <!-- Gọi đến file phps/showcart.php và thể hiện số lượng sản phẩm trong giỏ hàng -->
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
    <section class="product-tiles"> <!--products-->
        <!-- Gọi đến file  phps/products.php và show sản phẩm ra-->
            <?php require_once 'phps/products.php';?>
    </section>
    <div class="pagelist-area">
        <?php require_once 'phps/pageslist.php';?>
    </div>
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
</body>
</html>