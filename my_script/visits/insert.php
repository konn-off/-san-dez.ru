<?
if(isset($_REQUEST)){
    $utm_term = $_REQUEST['utm_term'];
    $utm_content = $_REQUEST['utm_content'];
    $utm_medium = $_REQUEST['utm_medium'];
    $utm_campaign = $_REQUEST['utm_campaign'];
    $utm_source = $_REQUEST['utm_source'];
    $yclid = $_REQUEST['yclid'];
    $referrer_url = $_REQUEST['referrer_url'];
    $url = $_REQUEST['url'];
    $site = $_REQUEST['site'];
    $roistat = $_REQUEST['roistat_visit'];
    
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
    
    echo $mes;
    
    
    
    $conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
    if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
    //echo "Подключение успешно установлено";
    
    $date = time();
    $date_time = date('d.m.Y H:i:s', $date);
    
    $sql2 = "SELECT * FROM visits WHERE roistat = $roistat";
    if($conn->query($sql2)){
        $result = $conn->query($sql2);
        if($result->num_rows != 0){ 
            echo 'Повторный визит'; 
        } 
        else { 
            $name_data = "(date, date_time, site, url, roistat, yclid, utm_source, utm_medium, utm_campaign, utm_content, utm_term)";
            $data = "('".$date."', '".$date_time."', '".$site."', '".$url."', '".$roistat."', '".$yclid."', '".$utm_source."', '".$utm_medium."', '".$utm_campaign."', '".$utm_content."', '".$utm_term."')";
                    
            $sql = "INSERT INTO visits $name_data VALUES $data"; 
            if($conn->query($sql)){ echo "Данные успешно добавлены"; } else { echo "Ошибка: " . $conn->error; }
        }
    }
    
    
}

?>