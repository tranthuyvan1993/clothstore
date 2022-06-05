<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . '/graciousgarments/phps/database/database.php';
  $index = 1;
  $query = 'select * from brands';
  $brandslist = executeResult($query);

  if ($brandslist != null && count($brandslist) > 0) {
    foreach ($brandslist as $catalist) {
      echo '
        <a href="phps/brands/showbrands.php?id=' . $catalist['IDBRAND'] . '">
            <div class="brand-holder">
                <div>
                    <a class="primary-color__text" href="./showbrands.php?id=' . $catalist['IDBRAND'] . '"><img class="brand-logo" src="'.$catalist['IMG'] . '" alt=""></a>
                </div>
                <div class="brand-text-area">
                    <div class="brand-title">
                        <a class="primary-color__text" href="./showbrands.php?id=' . $catalist['IDBRAND'] . '">' .strtoupper($catalist['BRAND_NAME']) . '</a>
                    </div>
                    <div class="brand-des neutral-color__text">
                        <span>' . $catalist['BRAND_INFO'] . '</span>
                    </div>
                </div>
            </div>
        </a>';
    }
  }
?>