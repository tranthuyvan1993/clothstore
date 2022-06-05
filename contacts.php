<?php  
// Start Session để lấy thông tin của user và giỏ hàng
session_start();
$user = (isset($_SESSION['user'])) ? $_SESSION['user'] : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="styles/index.css">
    <script type="module" src="https://unpkg.com/@fluentui/web-components"></script>
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
                        <a class="navbar__link navbar__link--is-active" href="contacts.php">
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
    <section class="main-contact-section"> <!--main page contents-->
        <div class="contact-info-area">
            <div class="contact-info-area__logo-container">
                <img src="images/ggLogo.png">
                <div class="contact-info-area__logo-title">
                    <span class="primary-color__text">Gracious</span> <span class="secondary-color__text">Garments</span>
                </div>
            </div>
            <div class="contact-info-area__info-container">
                <address>
                    <div>
                        <span class="primary-color__text">Address:</span><a class="neutral-color__text" href="" onclick="initMap();return false;"> 59 Huynh Thuc Khang St, Hanoi, Vietnam</a>
                    </div>
                    <div>
                        <span class="primary-color__text">Email:</span> <a class="neutral-color__text" href="mailto:hieu1871998@gmail.com">hieu1871998@gmail.com</a>
                    </div>
                </address>
            </div>
        </div>
        <div class="gmaps-area">
            <div id="gmaps" class="gmaps">
                <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB1_jKxZMHv4z8B6PIWB1sS6NIBTgPR_F4&callback=initMap&libraries=&v=weekly" async></script>
            </div>
        </div>
    </section>
    <script type="text/javascript" src="scripts/index.js"></script>
</body>
</html>