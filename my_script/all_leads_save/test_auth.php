<?php

setcookie('manager', '', time() - 3600);
//setcookie('manager', 'id_telegram', strtotime('+1 days'));



/*
 
*/

if(isset($_GET['men'])){
    setcookie('manager', $_GET["men"], strtotime('+1 days'), '/');
    echo '<meta http-equiv="refresh" content="0;url=https://san-dez.ru/my_script/all_leads_save/test_auth.php">';
    die();
}

if(!$_COOKIE ['manager']){

    echo '<meta http-equiv="refresh" content="5;url=https://t.me/MirMil_bot?start=auth">';
    echo '<h3>Необходима авторизация. Сейчас откроется Телеграм бот.</h3>';
    die();
}

echo "Страница с заявками<br>";

if($_COOKIE ['manager']){
    //setcookie('manager', '', time() + 3);
    echo $_COOKIE['manager'];
}



print_r($_COOKIE);












?>