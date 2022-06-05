<?php
    require_once 'database/database.php';
    // session_start();
    // $count = 1
    $count = 0;
    if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
    }
    foreach ($_SESSION['cart'] as $items) {
    $count += $items['num'];
    }
?>
<script type="text/javascript">
    function addMoreCart(delta){
    num = parseInt($('[name=num]').val())
    num += delta
    if(num<1) num=1;
    $('[name=num]').val(num)
    }
    function fixCartNum(){
    $('[name=num]').val(Math.abs($('[name=num]').val()))
    }
</script>