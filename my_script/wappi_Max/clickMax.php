<?
if(isset($_REQUEST)){
    $messanger = $_REQUEST['messanger'];
    $utm_term = $_REQUEST['utm_term'];
    $utm_content = $_REQUEST['utm_content'];
    $utm_medium = $_REQUEST['utm_medium'];
    $utm_campaign = $_REQUEST['utm_campaign'];
    $utm_source = $_REQUEST['utm_source'];
    $yclid = $_REQUEST['yclid'];
    $referrer_url = $_REQUEST['referrer_url'];
    $url = $_REQUEST['url'];
    $site = $_REQUEST['site'];
    $roistat = $_REQUEST['roistat'];
    
    $mes = 'utm_term - '.$utm_term.'
    utm_content - '.$utm_content.'
    utm_medium - '.$utm_medium.'
    utm_campaign - '.$utm_campaign.'
    utm_source - '.$utm_source.'
    yclid - '.$yclid.'
    referrer_url - '.$referrer_url.'
    site - '.$site.'
    roistat - '.$roistat.'
    url - '.$url;
    
    //echo $mes;
    
    
    
    $conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
    if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
    //echo "Подключение успешно установлено";
    
    $date = time();
    $date_time = date('d.m.Y H:i:s', $date);
    
     
    $name_data = "(datetime, data, messanger, site, url, roistat, yclid, utm_source, utm_medium, utm_campaign, utm_content, utm_term)";
    $data = "('".$date."', '".$date_time."', '".$messanger."', '".$site."', '".$url."', '".$roistat."', '".$yclid."', '".$utm_source."', '".$utm_medium."', '".$utm_campaign."', '".$utm_content."', '".$utm_term."')";
                    
    $sql = "INSERT INTO click_max $name_data VALUES $data"; 
    if($conn->query($sql)){ echo "Данные успешно добавлены"; } else { echo "Ошибка: " . $conn->error; }
    
    if($messanger=="max" || $messanger == ''){    
        $url = 'https://max.ru/u/f9LHodD0cOJX4nrIs9ILi70dJil3TpvdOGW529qlZvZhfuPWEM5g5O-B2Z8';
    }
    if($messanger=="Tg"){    
        $url = 'https://t.me/sandez26';//tel:+74994906979https://t.me/sandez26?start=vk
    }
    
    function redirect($url, $code = 302)
    {
        header('Location: ' . $url, true, $code);
        echo "<script>window.location.replace('" . $url . "');</script>";
        echo 'Перенаправление… Перейдите по <a href="' . $url . '">ссылке</a>.';
        exit();
    }
    redirect($url);
}

?>