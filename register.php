<?php
    require_once "phps/database/database.php";
        // validate từ BE;
    require_once "phps/customer/validate.php";
    session_start();
        $query = "SELECT * FROM users";   
        $password = $username = $tel = ''; 
    if (!empty($_POST)) {
        if (isset($_POST['username'])) {
            $username = $_POST['username'];}
        if (isset($_POST['password'])) {
            $password = $_POST['password'];}
        if (isset($_POST['email'])) {
            $email = $_POST['email'];}
        if (isset($_POST['fullname'])) {
            $fullname = $_POST['fullname'];}
        if (isset($_POST['address'])) {
            $address = $_POST['address'];}
        if (isset($_POST['tel'])) {
            $tel = $_POST['tel'];}
        // Check nếu không có lỗi khi nhập dữ liệu thì cho insert vào db
        if (empty($err)) {
            // gọi function executeResult từ database.php ==> fetch ra dữ liệu
            $result = executeResult($query);
            // nếu đã có user trong db thì check:
            if ($result != null && count($result) > 0) {
                foreach($result as $userlist){
                // check nếu username đã có trong db thì thông báo:
                    if ($username == $userlist["USERNAME"]) {
                        echo "<script type='text/javascript'>alert('Username already exists. Please choose another');</script>";
                    }else{
                        // check pass và passcheck giống nhau thì insert vào db
                        if ($password == $_POST['passwordCheck']) {
                            $pass = password_hash($password, PASSWORD_DEFAULT);
                            $query2 = "INSERT INTO users(USERNAME,PASSWORD,FULLNAME,ADDRESS,PHONENUMBER,EMAIL) value('$username','$pass','$fullname','$address','$tel','$email')";
                            executeRe($query2);
                            header('location: login.php');
                        }else{
                            echo "<script type='text/javascript'>alert('password is wrong');</script>";
                        }
                    }
                }
            // nếu chưa có dữ liệu nào trong db thì insert vào
            }else{
                if ($password == $_POST['passwordCheck']) {
                    $pass = password_hash($password, PASSWORD_DEFAULT);
                    $query2 = "INSERT INTO users(USERNAME,PASSWORD,FULLNAME,ADDRESS,PHONENUMBER,EMAIL) value('$username','$pass','$fullname','$address','$tel','$email')";
                    executeRe($query2);
                    header('location: login.php');
                }else{
                    echo "<script type='text/javascript'>alert('password is wrong');</script>";
                }
            }
        }else{
                echo "<script type='text/javascript'>alert('Can not add account');</script>";
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
                        <a id="customerProfileButton" href="#" class="navbar__link">
                        <span><?php echo $user['FULLNAME']; ?></span>
                        </a>
                        <a class="navbar__link" href="phps/customer/logoutcus.php">
                            <span>Logout</span>
                        </a>
                        <?php } else {?>
                        <a class="navbar__link" href="login.php">
                            <span>Login</span>
                        </a>
                        <a class="navbar__link navbar__link--is-active" href="register.php">
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
                        <a href="login.php" class="login-form__navbar-link">
                            <span>Login</span>
                        </a>
                        <a href="register.php" class="login-form__navbar-link login-form__navbar-link-active">
                            <span>Register</span>
                        </a>
                    </div>
                    <form class="login-form__input-area" action="" method="POST">
                        <div class="login-form__input-row">
                            <div class="login-form__input-label">
                                <label for="username">Username</label>
                            </div>
                            <div class="login-form__input-box">
                                <input type="text" class="form-control" id="username" placeholder="Username" name="username" pattern=".{5,20}" title="5-20 characters" required>
                                <span style="color: red"><?php echo (isset($err['username'])) ? $err['username']: ''; ?></span>
                            </div>
                        </div>
                        <div class="login-form__input-row">
                            <div class="login-form__input-label">
                                <label for="password">Password</label>
                            </div>
                            <div class="login-form__input-box">
                                <input type="password" class="form-control" id="password" placeholder="Password" name="password" required>
                                <span style="color: red"><?php echo (isset($err['password'])) ? $err['password']: ''; ?></span>
                            </div>
                        </div>
                        <div class="login-form__input-row">
                            <div class="login-form__input-label">
                                <label for="passwordCheck">Confirm password</label>
                            </div>
                            <div class="login-form__input-box">
                                <input type="password" class="form-control" id="passwordCheck" placeholder="Confirm" name="passwordCheck" required>
                                <span style="color: red"><?php echo (isset($err['password'])) ? $err['password']: ''; ?></span>
                            </div>
                        </div>
                        <div class="login-form__input-row">
                            <div class="login-form__input-label">
                                <label for="fullname">Full name</label>
                            </div>
                            <div class="login-form__input-box">
                                <input type="text" class="form-control" id="fullname" placeholder="Full name" name="fullname" required>
                                <span style="color: red"><?php echo (isset($err['fullname'])) ? $err['fullname']: ''; ?></span>
                            </div>
                        </div>
                        <div class="login-form__input-row">
                            <div class="login-form__input-label">
                                <label for="email">Email</label>
                            </div>
                            <div class="login-form__input-box">
                                <input type="text" class="form-control" id="email" placeholder="Email" name="email" required>
                                <span style="color: red"><?php echo (isset($err['email'])) ? $err['email']: ''; ?></span>
                            </div>
                        </div>
                        <div class="login-form__input-row">
                            <div class="login-form__input-label">
                                <label for="address">Address</label>
                            </div>
                            <div class="login-form__input-box">
                                <input type="text" class="form-control" id="address" placeholder="Address" name="address" required>
                                <span style="color: red"><?php echo (isset($err['address'])) ? $err['address']: ''; ?></span>
                            </div>
                        </div>
                        <div class="login-form__input-row">
                            <div class="login-form__input-label">
                                <label for="phone">Phone</label>
                            </div>
                            <div class="login-form__input-box">
                                <input type="text" class="form-control" id="phone" placeholder="Phone" name="tel" pattern="[0-9]{10}" title="10 numbers" required>
                                <span style="color: red"><?php echo (isset($err['tel'])) ? $err['tel']: ''; ?></span>
                            </div>
                        </div>
                        <div class="login-form__action-area">
                            <button class="reg-button" type="submit">
                                <span>Register</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>