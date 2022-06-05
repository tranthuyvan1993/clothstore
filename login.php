<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/graciousgarments/phps/database/database.php';
    session_start();
    $username = $password = $tel = '';
    if (!empty($_POST)) {
        if(isset($_POST['username'])){
            $username = $_POST['username'];
        }
        if(isset($_POST['password'])){
            $password = $_POST['password'];
        }
        if(isset($_POST['checkbox'])){
            $checkbox = $_POST['checkbox'];
        }
        $connect = mysqli_connect(HOST,USERNAME,PASS,DATABASE);  
        // $connect   -> set_charset("utf8");
        $query1 = "SELECT * FROM ADMIN WHERE username = '$username'";  
        $query2 = "SELECT * FROM users WHERE username = '$username'";  

        $result1 = mysqli_query($connect, $query1);  
        $result2 = mysqli_query($connect, $query2); 
        // Nếu có thông tin trong db thì check password
        if (mysqli_num_rows($result1) > 0) {
            while ($row = mysqli_fetch_array($result1)) {
                if ($password == $row["PASSWORD"] && $username == $row["USERNAME"]) {
                    echo "<script type='text/javascript'>alert('Đăng nhập thành công. Xin chào " . $username . "');</script>";
                    // Lưu thông tin đăng nhập của admin vào Session
                    $_SESSION['admin'] = $row;
                    header('location: phps/product/');
                } else {
                    echo '<script>alert("Invalid username or password")</script>';
                }
            }
        } else {
            echo '<script>alert("Invalid username or password")</script>';
        }
        // Nếu có thông tin trong db thì check password
        if (mysqli_num_rows($result2) > 0) {
            while ($row = mysqli_fetch_array($result2)) {
                if (password_verify($password, $row["PASSWORD"])) {
                    echo "<script type='text/javascript'>alert('Đăng nhập thành công. Xin chào Cus " . $username . "');</script>";
                    // Lưu thông tin đăng nhập của users vào Session
                    $_SESSION['user'] = $row;
                    header('location: index.php');
                } else {
                    echo '<script>alert("Invalid username or password")</script>';
                }
            }
        } else {
            echo '<script>alert("Invalid username or password")</script>';
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
                        <a class="navbar__link navbar__link--is-active" href="login.php">
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
    <section class="login-page login-page-bg">
        <div class="acrylic-layer acrylic__light">
            <div class="login-form-container">
                <div class="login-form__navbar">
                    <a href="#" class="login-form__navbar-link login-form__navbar-link-active">
                        <span>Login</span>
                    </a>
                    <a href="register.php" class="login-form__navbar-link">
                        <span>Register</span>
                    </a>
                </div>
                <form class="login-form__input-area" action="" method="POST">
                    <div class="login-form__input-row">
                        <div class="login-form__input-label">
                            <label for="username">Username</label>
                        </div>
                        <div class="login-form__input-box">
                            <input type="text" class="form-control" id="username" placeholder="Username" name="username" value="">
                        </div>
                    </div>
                    <div class="login-form__input-row">
                        <div class="login-form__input-label">
                            <label for="password">Password</label>
                        </div>
                        <div class="login-form__input-box">
                            <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                        </div>
                    </div>
                    <div class="login-form__action-area">
                        <button class="login-button" type="submit">
                            <span>Login</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>        
    </section>
</body>
</html>
