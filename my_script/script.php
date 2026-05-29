<?

$conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
//echo "Подключение успешно установлено";
    


function phone_format($phone) 
{
    $phone = trim($phone);
 
    $res = preg_replace(
        array(
            '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{3})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
            '/[\+]?([7|8])[-|\s]?(\d{3})[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
            '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
            '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',	
            '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{3})/',
            '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{3})[-|\s]?(\d{3})/',					
        ), 
        array(
            '7$2$3$4$5', 
            '7$2$3$4$5', 
            '7$2$3$4$5', 
            '7$2$3$4$5', 	
            '7$2$3$4', 
            '7$2$3$4', 
        ), 
        $phone
    );
    if(str_split($res)[0]==9){$res='7'.$res;}
    return $res;
}

    
if(isset($_REQUEST['roistat_id'])){
    $roistat_id = $_REQUEST['roistat_id'];    
    $sql2 = "SELECT * FROM all_leads WHERE roistat = $roistat_id LIMIT 1";
    if($conn->query($sql2)){
        $result = $conn->query($sql2);
        //$row = $result->fetch_array();
        //echo count($result);
        echo $result->num_rows;
    }
}    

/**/
if(isset($_REQUEST['upd_povtor_lead'])){
    $base_phone = array();
    $sql2 = "SELECT * FROM all_leads";
    if($conn->query($sql2)){
        $result = $conn->query($sql2);
        foreach($result as $row){
            $id = $row['id'];
            $phone = $row['phone'];
            
            echo $id.' - '.$phone.' - ';
            if(in_array($phone, $base_phone)){ echo 'повтор<br>'; $povtor_lead=1; } else { echo 'новый<br>'; $povtor_lead=0; }
              
            $sql = "UPDATE all_leads SET povtor_lead=$povtor_lead WHERE id=$id"; $conn->query($sql);
            $base_phone[] = $phone;
        }
    }
}


if(isset($_REQUEST['prov_phone'])){
    $phone = phone_format($_REQUEST['phone']);
    $sql2 = "SELECT * FROM all_leads WHERE phone = $phone LIMIT 1";
    if($conn->query($sql2)){
        $result = $conn->query($sql2);
        if($result->num_rows != 0){ echo 'yes';
            $contact_phone = $phone;
            $yclid  = $_REQUEST['yclid'];
            $utm_source  =  urldecode($_REQUEST['utm_source']);
            $utm_medium  =  urldecode($_REQUEST['utm_medium']);
            $utm_campaign =  urldecode($_REQUEST['utm_campaign']);
            $utm_content =  urldecode($_REQUEST['utm_content']);
            $utm_term =  urldecode($_REQUEST['utm_term']);
            $referrer_url =  urldecode($_REQUEST['referrer_url']);
            $url =  urldecode($_REQUEST['input_url']);
            $roistat_visit = $_REQUEST['roistat_visit'];
                
            if ($utm_source==''){
                $referrer_url = $_REQUEST['referrer_url'];
                if ($referrer_url==''){$utm_source='Прямой заход';}
                else {
                    if (strpos($referrer_url, 'yandex') !== false){ $utm_source='SEO_yandex'; } 
                    else
                    { 
                        if (strpos($referrer_url, 'google') !== false){ $utm_source='SEO_google'; } 
                        else { $ffsdsf = explode('?',$referrer_url); $utm_source=$ffsdsf[0]; }
                    } 
                }
            }
            
            
            $message = '
                Сделка повтор
                Сообщение - Заказ звонка
                Имя - 
                Телефон - '.$contact_phone.'
                utm_source - '.$utm_source.'
                utm_medium - '.$utm_medium.'
                utm_campaign - '.$utm_campaign.'
                utm_content - '.$utm_content.'
                utm_term - '.$utm_term.'
                yclid - '.$yclid.'
                roistat - '.$roistat_visit;
                /*// Отправка данных*/
            $roistatData = array(
                //'roistat_visit' => isset($_COOKIE['roistat_visit']) ? $_COOKIE['roistat_visit'] : null,
                'roistat_visit' => $roistat_visit,
                'key'     => '02712ee9ebfe890157cea3e83084992a',
                'title'   => 'Заявка с сайта от Алексея', // Постоянное значение
                'name'    => '',
                'phone'   => $contact_phone//,
                //'comment'   => 'Тестовая заявка через WebHook Roistat'
            );
            file_get_contents("https://cloud.roistat.com/integration/webhook?" . http_build_query($roistatData));
                
            $token = "6843410151:AAEztaRwqsdj2d3vKhBxVKwkcrIqzeq4YOM"; //наш токен от telegram bot -а
            $chatid = "608866610";// ИД чата telegrm
            $chatid2 = "271142636";// ИД чата telegrm клиент
            $chatid3 = "1587801533";// ИД чата telegrm клиент2
            $chatid4 = "883627670";// ИД чата telegrm клиент3
            
            $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($message)); 
            $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid2."&text=".urlencode($message));
            $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid3."&text=".urlencode($message));
            $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid4."&text=".urlencode($message));

            
            // массив для переменных, которые будут переданы с запросом
            $paramsArray = array(
                'name_leads' => 'Заявка с сайта san-dez.ru', 
                'name' => '',
                'mail' => '',
                'phone' => $contact_phone,
                'site' => 'san-dez.ru',
                'url' => $url,
                'roistat' => $roistat_visit,
                'ycid' => $yclid,
                'utm_source' => $utm_source,
                'utm_medium' => $utm_medium,
                'utm_campaign' => $utm_campaign,
                'utm_content' => $utm_content,
                'utm_term' => $utm_term,
                'source' => 'Заявка'
            );  
            $vars = http_build_query($paramsArray); // преобразуем массив в URL-кодированную строку
            // создаем параметры контекста
            $options = array(
                'http' => array(  
                    'method'  => 'POST',  // метод передачи данных
                    'header'  => 'Content-type: application/x-www-form-urlencoded',  // заголовок 
                    'content' => $vars,  // переменные
                )  
            );  
            $context  = stream_context_create($options);  // создаём контекст потока
            $result = file_get_contents('https://san-dez.ru/my_script/all_leads_save/insert.php', false, $context); //отправляем запрос	
        }

    }
}


if(isset($_REQUEST['spam_phone'])){
    $phone = phone_format($_REQUEST['phone']);
    
    if($phone!=''){
        
        $contact_phone = $phone;
        $yclid  = $_REQUEST['yclid'];
        $utm_source  =  urldecode($_REQUEST['utm_source']);
        $utm_medium  =  urldecode($_REQUEST['utm_medium']);
        $utm_campaign =  urldecode($_REQUEST['utm_campaign']);
        $utm_content =  urldecode($_REQUEST['utm_content']);
        $utm_term =  urldecode($_REQUEST['utm_term']);
        $referrer_url =  urldecode($_REQUEST['referrer_url']);
        $url =  urldecode($_REQUEST['input_url']);
        $roistat_visit = $_REQUEST['roistat_visit'];
                
        if ($utm_source==''){
            $referrer_url = $_REQUEST['referrer_url'];
            if ($referrer_url==''){$utm_source='Прямой заход';}
            else {
                if (strpos($referrer_url, 'yandex') !== false){ $utm_source='SEO_yandex'; } 
                else
                { 
                    if (strpos($referrer_url, 'google') !== false){ $utm_source='SEO_google'; } 
                    else { $ffsdsf = explode('?',$referrer_url); $utm_source=$ffsdsf[0]; }
                } 
            }
        }
            
            
        $message = '
            Сделка может спам
            Сообщение - Заказ звонка
            Имя - 
            Телефон - '.$contact_phone.'
            utm_source - '.$utm_source.'
            utm_medium - '.$utm_medium.'
            utm_campaign - '.$utm_campaign.'
            utm_content - '.$utm_content.'
            utm_term - '.$utm_term.'
            yclid - '.$yclid.'
            roistat - '.$roistat_visit;
            /*// Отправка данных*/
        $roistatData = array(
            //'roistat_visit' => isset($_COOKIE['roistat_visit']) ? $_COOKIE['roistat_visit'] : null,
            'roistat_visit' => $roistat_visit,
            'key'     => '02712ee9ebfe890157cea3e83084992a',
            'title'   => 'Заявка с сайта от Алексея', // Постоянное значение
            'name'    => '',
            'phone'   => $contact_phone//,
            //'comment'   => 'Тестовая заявка через WebHook Roistat'
        );
        file_get_contents("https://cloud.roistat.com/integration/webhook?" . http_build_query($roistatData));
                
        $token = "6843410151:AAEztaRwqsdj2d3vKhBxVKwkcrIqzeq4YOM"; //наш токен от telegram bot -а
        $chatid = "608866610";// ИД чата telegrm
        $chatid2 = "271142636";// ИД чата telegrm клиент
        $chatid3 = "1587801533";// ИД чата telegrm клиент2
        $chatid4 = "883627670";// ИД чата telegrm клиент3
            
        $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($message)); 
        $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid2."&text=".urlencode($message));
        $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid3."&text=".urlencode($message));
        $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid4."&text=".urlencode($message));
            
        // массив для переменных, которые будут переданы с запросом
        $paramsArray = array(
            'name_leads' => 'Заявка с сайта san-dez.ru', 
            'name' => '',
            'mail' => '',
            'phone' => $contact_phone,
            'site' => 'san-dez.ru',
            'url' => $url,
            'roistat' => $roistat_visit,
            'ycid' => $yclid,
            'utm_source' => $utm_source,
            'utm_medium' => $utm_medium,
            'utm_campaign' => $utm_campaign,
            'utm_content' => $utm_content,
            'utm_term' => $utm_term,
            'source' => 'Заявка'
        );  
        $vars = http_build_query($paramsArray); // преобразуем массив в URL-кодированную строку
        // создаем параметры контекста
        $options = array(
            'http' => array(  
                'method'  => 'POST',  // метод передачи данных
                'header'  => 'Content-type: application/x-www-form-urlencoded',  // заголовок 
                'content' => $vars,  // переменные
            )  
        );  
        $context  = stream_context_create($options);  // создаём контекст потока
        $result = file_get_contents('https://san-dez.ru/my_script/all_leads_save/insert.php', false, $context); //отправляем запрос	
    }

    
}
   
    
    
if(isset($_REQUEST['send_notification'])){
    $message = $_REQUEST['send_notification'];
    $token = "6843410151:AAEztaRwqsdj2d3vKhBxVKwkcrIqzeq4YOM"; //наш токен от telegram bot -а
    $chatid = "608866610";// ИД чата telegrm
    $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($message));
}
    
?>