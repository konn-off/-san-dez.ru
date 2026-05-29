<?

function getInfoYa($url,$token,$data,$boundary){
    
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');	
    
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host:api-metrika.yandex.net','Authorization: OAuth '.$token,"Content-Type: multipart/form-data; boundary=------------------------$boundary","Content-Length: " . strlen($data)));
  
    $response = array();
    $response['html']     = curl_exec($ch);
    $response['err']      = curl_errno($ch);
    $response['errmsg']   = curl_error($ch);
    $response['header']   = curl_getinfo($ch);
    
    
    
    curl_close($ch);		
    
    
    return $response;		
}
  
  
  
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



/*** Отправляем увеомление в Телеграм МНЕ ***/
function send_notification2 ($message){
    $token = "6843410151:AAERG49__xZQiew2XDkkr-WqO87Oo5-FCWc"; //наш токен от telegram bot -а
    $chatid = "608866610";// ИД чата telegrm
    $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($message));
}


function sendTelegram($response)
{
    $ch = curl_init('https://api.telegram.org/bot6843410151:AAERG49__xZQiew2XDkkr-WqO87Oo5-FCWc/sendMessage');  
    curl_setopt($ch, CURLOPT_POST, 1);  
    curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $res = curl_exec($ch);
    curl_close($ch);
 
    return $res;
}







// eP78s9IDVhhV6qu_mZfggsjg-LLiIYNBfdAugzHbU_hjfUM6S_H9jEVOWsi8Gndd
function writeToLog($data, $title = '') {
    $log = "\n------------------------\n";
    $log .= date("Y.m.d G:i:s") . "\n";
    $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
    
    $log .= print_r ($data,1);
    
    $log .= "\n------------------------\n";
    file_put_contents(getcwd() . '/hookTeletype.log', $log, FILE_APPEND);
    return true;
}

$rawdata = file_get_contents("php://input");
//$decoded = json_decode($rawdata);
//print_r ($decoded);
//writeToLog($decoded, 'incoming_raw');
//writeToLog($_REQUEST, 'incoming_TEST');

$data = json_decode($_REQUEST['payload'], JSON_UNESCAPED_UNICODE);

//writeToLog($data, 'incoming_REQUEST');

$dialogId = $data['message']['dialogId'];
$id_Client_Teletype = $data['message']['client']['id'];
$text_mess = $data['message']['text'];

$roistat = preg_replace("/[^0-9]/", '', $text_mess);
$name = $data['message']['client']['name'];
$phone = phone_format($data['message']['client']['phone']);

/*
$id_Client_Teletype = $_POST['id_Client_Teletype'];


$roistat = $_POST['roistat'];
$name = $_POST['name'];
$phone = phone_format($_POST['phone']);
*/
//writeToLog($phone, 'incoming_r');
//writeToLog($text_mess, 'incoming_r');
$source = 'WhatsApp';
$name_leads = 'Заявка WZ';
$mail = '';
$site = 'san-dez.ru';






if($phone!=''){
    
    $conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
    if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
    //echo "Подключение успешно установлено";

    
    $utm_source = '';$utm_medium = '';$utm_campaign = '';$utm_content = '';$utm_term = '';$yclid = '';$referrer_url = '';$url = '';
    $date = time();
    $povtor_lead=0;
    
    if($roistat != ''){
    
        $sql2 = "SELECT * FROM visits WHERE roistat = $roistat";
        if($conn->query($sql2)){
            $result = $conn->query($sql2); 
            if($result->num_rows != 0){ 
                
                $row = $result->fetch_array();
                
                $utm_source = $row['utm_source'];
                $utm_medium = $row['utm_medium'];
                $utm_campaign = $row['utm_campaign'];
                $utm_content = $row['utm_content'];
                $utm_term = $row['utm_term' ];
                $site = $row['site'];
                $url = $row['url'];
                $referrer_url = $row['referrer_url'];
                $yclid = $row['yclid'];
                
            }
        }
    }


    $datePast = $date-7200;
    
    $sql3 = "SELECT * FROM all_leads WHERE phone = $phone && date > $datePast";
    if($conn->query($sql3)){
        $result = $conn->query($sql3);
        if($result->num_rows != 0){ $povtor_lead_nedavno=1; } else { $povtor_lead_nedavno=0; }
        
        $sql4 = "UPDATE all_leads SET dialog_wiev = 1, last_mes = '".$text_mess."' WHERE dialogId = '".$dialogId."'"; 
        $conn->query($sql4);
    }
    
    
    
    if($povtor_lead_nedavno==0){
        
        
    
        $roistatData = array(
            
            'roistat' => $roistat,
            'key'     => 'NTYxODdiMGRkMjFjYmFmYTlhMDQ0M2NiZTEwNWViNDA6MjU3NjAz', // Ключ для интеграции с CRM, указывается в настройках интеграции с CRM.
            'title'   => 'Заявка с сайта от Алексея', // Название сделки
            //'comment' => '', // Комментарий к сделке
            'name'    => $name, // Имя клиента
            'email'   => '', // Email клиента
            'phone'   => $phone, // Номер телефона клиента
    
            //'is_need_callback' => '0',  // Если указано значение '1', на номер клиента будет инициироваться обратный звонок после создания заявки в Roistat (независимо от того, включен ли обратный звонок в Ловце лидов). 
                                    //Если указано значение '0', для данной формы обратный звонок инициироваться не будет (даже если в Ловце лидов включен обратный звонок). 
            //'callback_phone' => '<Номер для переопределения>', // Переопределяет номер, указанный в настройках обратного звонка.
            'sync'    => '1', //
            //'is_need_check_order_in_processing' => '1', // Настройка стандартной проверки заявок на дубли. 
                                                    // Если установлено значение '1', на дубли будут проверяться заявки за последние 12 часов только в статусах группы "В работе". 
                                                    // Если установлено значение '0', будут проверяться все заявки за последние 12 часов. 
                                                    // Данный параметр не участвует в пользовательской проверке на дубли.
            //'is_need_check_order_in_processing_append' => '1', // Если создана дублирующая заявка, в нее будет добавлен комментарий об этом
            //'is_skip_sending' => '1', // Не отправлять заявку в CRM.
            'fields'  => array(
            // Массив дополнительных полей. Если дополнительные поля не нужны, оставьте массив пустым.
            // Примеры дополнительных полей смотрите в таблице ниже.
            // Помимо массива fields, который используется для сделки, есть еще массив client_fields, который используется для установки полей контакта.
            "charset" => "Windows-1251", // Сервер преобразует значения полей из указанной кодировки в UTF-8.
            ),
        );
    
        $f = json_decode(file_get_contents("https://cloud.roistat.com/api/proxy/1.0/leads/add?" . http_build_query($roistatData)), true );
    
        $id_crm = $f['data'];
        
        
        
        
        $sql2 = "SELECT * FROM all_leads WHERE phone = $phone";
        if($conn->query($sql2)){
            $result = $conn->query($sql2);
            if($result->num_rows != 0){ $povtor_lead=1; } else { $povtor_lead=0; }
        }
        
        $name_data = "(date, name_leads, name, mail, phone, site, url, roistat, ycid, utm_source, utm_medium, utm_campaign, utm_content, utm_term, source, povtor_lead, id_crm, dialogId, dialog_wiev)";
        $data = "('".$date."', '".$name_leads."', '".$name."', '".$mail."', '".$phone."', '".$site."', '".$url."', '".$roistat."', '".$yclid."', '".$utm_source."', '".$utm_medium."', '".$utm_campaign."', '".$utm_content."', '".$utm_term."', '".$source."', '".$povtor_lead."', '".$id_crm."', '".$dialogId."', 1)";
                    
        $sql = "INSERT INTO all_leads $name_data VALUES $data"; 
        if($conn->query($sql)){ echo "Данные успешно добавлены"; } else { echo "Ошибка: " . $conn->error; }
        
        $sql4 = "UPDATE all_leads SET dialog_wiev = 1, last_mes = '".$text_mess."' WHERE dialogId = '".$dialogId."'"; 
        $conn->query($sql4);
    
        
        
        
        
        $message = '
            Новая сделка
            Сообщение - Заявка WZ
            Имя - 
            Телефон - '.$phone.'
            utm_source - '.$utm_source.'
            utm_medium - '.$utm_medium.'
            utm_campaign - '.$utm_campaign.'
            utm_content - '.$utm_content.'
            utm_term - '.$utm_term.'
            yclid - '.$yclid.'
            roistat - '.$roistat.'
            order_id - '.$id_crm;
            
            
        $sql2 = "SELECT * FROM tg_bot";
        if($conn->query($sql2)){
            $result = $conn->query($sql2); 
        
            foreach($result as $row){
                 
                $chat_id = $row["chat_id"];
                sendTelegram(array('chat_id' => $chat_id,'text' => $message));
            }
        }    
        /*
        $token = "6843410151:AAERG49__xZQiew2XDkkr-WqO87Oo5-FCWc"; //наш токен от telegram bot -а
        $chatid = "608866610";// ИД чата telegrm
        $chatid2 = "271142636";// ИД чата telegrm клиент
        $chatid3 = "1587801533";// ИД чата telegrm клиент2
        $chatid4 = "883627670";// ИД чата telegrm клиент3
            
        
        //$tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($f)); 
        
        
        $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($message)); 
        $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid2."&text=".urlencode($message));
        $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid3."&text=".urlencode($message));
        $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid4."&text=".urlencode($message));
        */
    
        $token = "y0_AgAAAAB2YcxHAAz9CQAAAAEc8EgpAAAeTMYl9JZAh5sHnEl8n_Hpf8_gFg";
        $orders = "ClientID,Target,DateTime".PHP_EOL;		
        
        
        //ym(97574764,'reachGoal','test_lead')
        $orders .= $yclid.",lead,".time().PHP_EOL;
            
        
        $counterId = 97574764; //id счетчика
        $boundary = "7zDUQOAIAE9hEWoV";
        $filename = 'data.csv';
        
        $data = "--------------------------$boundary\x0D\x0A";
        $data .= "Content-Disposition: form-data; name=\"file\"; filename=\"$filename\"\x0D\x0A";
        $data .= "Content-Type: text/csv\x0D\x0A\x0D\x0A";
        $data .= $orders . "\x0A\x0D\x0A";
        $data .= "--------------------------$boundary--";
        
        $url = "https://api-metrika.yandex.net/management/v1/counter/".$counterId."/offline_conversions/upload?client_id_type=CLIENT_ID&oauth_token=".$token;
        
        if($povtor_lead==0){
            
            $yaInfo = getInfoYa($url,$token,$data,$boundary);
            //$yaInfo = json_decode($yaInfo["response"]["html"],true);
        
        }
        
    
        

    }
    if($povtor_lead_nedavno==1){
        $message = '
            Повтор недавно сделка
            Сообщение - Заявка WZ
            Имя - 
            Телефон - '.$phone.'
            utm_source - '.$utm_source.'
            utm_medium - '.$utm_medium.'
            utm_campaign - '.$utm_campaign.'
            utm_content - '.$utm_content.'
            utm_term - '.$utm_term.'
            yclid - '.$yclid.'
            roistat - '.$roistat.'
            order_id - '.$id_crm;
        
        
        $sql2 = "SELECT * FROM tg_bot";
        if($conn->query($sql2)){
            $result = $conn->query($sql2); 
        
            foreach($result as $row){
                 
                $chat_id = $row["chat_id"];
                sendTelegram(array('chat_id' => $chat_id,'text' => $message));
            }
        }
        
        
        /*$token = "6843410151:AAERG49__xZQiew2XDkkr-WqO87Oo5-FCWc"; //наш токен от telegram bot -а
        $chatid = "608866610";// ИД чата telegrm
        $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($message));
        
        
        $token = "6843410151:AAERG49__xZQiew2XDkkr-WqO87Oo5-FCWc"; //наш токен от telegram bot -а
        $chatid = "608866610";// ИД чата telegrm
        $chatid2 = "271142636";// ИД чата telegrm клиент
        $chatid3 = "1587801533";// ИД чата telegrm клиент2
        $chatid4 = "883627670";// ИД чата telegrm клиент3
            
        
        //$tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($f)); 
        
        
        $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($message)); 
        $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid2."&text=".urlencode($message));
        $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid3."&text=".urlencode($message));
        $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid4."&text=".urlencode($message));
        */
    }

}













































?>




