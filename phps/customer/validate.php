<?php
    $err = [];
    // validate require từ php
    $username = $address = $password = $fullname =$passwordCheck= $tel = $email = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["username"])) {
            $err['username'] = "Username is required";
        }
        if (empty($_POST["fullname"])) {
            $err['fullname'] = "Fullname is required";
        }
        if (empty($_POST["password"])) {
            $err['password'] = "Password is required";
        }
        if (empty($_POST["passwordCheck"])) {
            $err['passwordCheck'] = "Password is required";
        }
        if (empty($_POST["address"])) {
            $err['address'] = "Address is required";
        }
        if (empty($_POST["email"])) {
            $err['email'] = "Email is required";
        }
        if (empty($_POST["tel"])) {
            $err['tel'] = "Phone number is required";
        }
    }
?>