
<?php




function writeToLog($data, $title = '') {
    $log = "\n------------------------\n";
    $log .= date("Y.m.d G:i:s") . "\n";
    $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
    $log .= print_r ($data,1);
    $log .= "\n------------------------\n";
    file_put_contents(getcwd() . '/hook6.log', $log, FILE_APPEND);
    return true;
}



$data = json_decode(file_get_contents('php://input'), true);
$gg = $data['messages'];

//writeToLog($data, 'incoming_raw');
$data = $data['messages'][0];

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

/*
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
*/

function sendTelegram($mess,$chatid)
{
    $token = "6843410151:AAEztaRwqsdj2d3vKhBxVKwkcrIqzeq4YOM";
    $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($mess));
}

//send_notification2 ('Есть Хук');
//send_notification2 ($data['wh_type']);


//$dialogId = $data['messages']['dialogId'];
//$id_Client_Teletype = $data['messages']['client']['id'];

/*
if($data['wh_type']=='authorization_status'){
    if($data['status']=='offline'){
        $message = 'Авторизация Whatsapp отключилась. Скоро заработает!';
    }
    if($data['status']=='online'){
        $message = 'Whatsapp работает!!!';
    }
    $sql2 = "SELECT * FROM tg_bot";
        if($conn->query($sql2)){
            $result = $conn->query($sql2); 
        
            foreach($result as $row){
                 
                $chat_id = $row["chat_id"];
                sendTelegram(array('chat_id' => $chat_id,'text' => $message));
            }
        }
    exit();
}
*/

$type_mess = $data['type'];

if($type_mess=='chat'){
    $text_mess = $data['body'];
    //"Код на скидку - 192917"
    $roistat = explode("Код на скидку", $text_mess);
    
    $roistat = preg_replace("/[^0-9]/", '', $roistat[1]);
}else{
    $text_mess = '';
    $roistat = '';
}




//send_notification2 ('roistat - '.$roistat.' text_mess - '.$text_mess);


if($gg['wh_type']=='incoming_call'){
    if($gg['type']=='incoming_call'){
        $name = $gg['contact']['PushName'];
        $phone = $gg['number'];
        if(strlen($phone)>11){}else{$phone=phone_format($phone);}
    }else{
        exit();
    }
}
else{
    $name = $data['senderName'];
    $phone = preg_replace('/[^0-9]/', '',$data['from']);
    if(strlen($phone)>11){}else{$phone=phone_format($phone);}
}

//send_notification2 ('name - '.$name.' phone - '.$phone);

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
    
    if($site=='san-dez.ru'){
        $metriks_id_schetchik = '97574764';
    }
    if($site=='xn-----8kcaaiejjavmb1acem4amnaho2a2c1b6c2p.xn--p1ai' || $site == 'дезинфекция-клопов-тараканов.рф' || $site == 'https://дезинфекция-клопов-тараканов.рф'){
        $metriks_id_schetchik = '98748423';
    }
    if($site==''){
        $metriks_id_schetchik = '97574764';
    }


    //$datePast = $date-7200;// 2часа
    $datePast = strtotime('today midnight');
    //$sql3 = "SELECT * FROM all_leads WHERE phone = $phone && date > $datePast";
    $sql3 = "SELECT * FROM all_leads WHERE phone = $phone LIMIT 1";
    if($conn->query($sql3)){
        $result = $conn->query($sql3);
        if($result->num_rows != 0){ 
            $povtor_lead = 1;
            $row = $result->fetch_array();
            $id_crm = $row['id_crm'];
            
            $roistat = $row['roistat'];
            $utm_source = $row['utm_source'];
            $utm_medium = $row['utm_medium'];
            $utm_campaign = $row['utm_campaign'];
            $utm_content = $row['utm_content'];
            $utm_term = $row['utm_term' ];
            $site = $row['site'];
            $url = $row['url'];
            $referrer_url = $row['referrer_url'];
            $yclid = $row['ycid'];
            
            $sql4 = "SELECT * FROM all_leads WHERE phone = $phone ORDER BY id DESC LIMIT 1";
            if($conn->query($sql4)){
                $result4 = $conn->query($sql4);
                if($result4->num_rows != 0){
                    $row4 = $result4->fetch_array();
                    if($row4['date']>$datePast){ $povtor_lead_nedavno=1; }else{ $povtor_lead_nedavno=0; }
                }
            }
            
                
        } else { 
            $povtor_lead=0;
            $povtor_lead_nedavno=0; 
        }
        
    }
    
    
    
    if($povtor_lead == 0){
        
        
    /*
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
            
            'fields'  => array(
                "charset" => "Windows-1251", // Сервер преобразует значения полей из указанной кодировки в UTF-8.
            ),
        );
    
        $f = json_decode(file_get_contents("https://cloud.roistat.com/api/proxy/1.0/leads/add?" . http_build_query($roistatData)), true );
    
        $id_crm = $f['data'];
    */    
    $id_crm = '';    
        
        
        /*$sql2 = "SELECT * FROM all_leads WHERE phone = $phone";
        if($conn->query($sql2)){
            $result = $conn->query($sql2);
            if($result->num_rows != 0){ $povtor_lead=1; } else { $povtor_lead=0; }
        }*/
        
        $name_data = "(date, name_leads, name, mail, phone, site, url, roistat, ycid, utm_source, utm_medium, utm_campaign, utm_content, utm_term, source, povtor_lead, id_crm, dialogId, dialog_wiev, last_mes, last_mes_time)";
        $data = "('".$date."', '".$name_leads."', '".$name."', '".$mail."', '".$phone."', '".$site."', '".$url."', '".$roistat."', '".$yclid."', '".$utm_source."', '".$utm_medium."', '".$utm_campaign."', '".$utm_content."', '".$utm_term."', '".$source."', '".$povtor_lead."', '".$id_crm."', '".$dialogId."', 1, '".$text_mess."', '".$date."')";
                    
        $sql = "INSERT INTO all_leads $name_data VALUES $data"; 
        if($conn->query($sql)){ echo "Данные успешно добавлены"; } else { echo "Ошибка: " . $conn->error; }
        
        
        
    
        
        
        
        
            
        
        //$token = "y0__xDautmVCBjSoDgghILquhMGIA76MivvUFRINzIychmJEuSkqw"; // дезинфекция-клопов-тараканов.рф
        $token = "y0_AgAAAAB2YcxHAAz9CQAAAAEc8EgpAAAeTMYl9JZAh5sHnEl8n_Hpf8_gFg"; // san-dez
        $orders = "ClientID,Target,DateTime".PHP_EOL;		
        
        
        //ym(97574764,'reachGoal','test_lead')
        $orders .= $yclid.",lead,".time().PHP_EOL;
        $orders .= $yclid.",lead2,".time().PHP_EOL;
            
        
        $counterId = $metriks_id_schetchik; //97574764; //id счетчика
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
    else{//$povtor_lead == 1
        if($povtor_lead_nedavno==0){
            $name_data = "(date, name_leads, name, mail, phone, site, url, roistat, ycid, utm_source, utm_medium, utm_campaign, utm_content, utm_term, source, povtor_lead, id_crm, dialogId, dialog_wiev)";
            $data = "('".$date."', '".$name_leads."', '".$name."', '".$mail."', '".$phone."', '".$site."', '".$url."', '".$roistat."', '".$yclid."', '".$utm_source."', '".$utm_medium."', '".$utm_campaign."', '".$utm_content."', '".$utm_term."', '".$source."', '".$povtor_lead."', '".$id_crm."', '".$dialogId."', 1)";
                        
            $sql = "INSERT INTO all_leads $name_data VALUES $data"; 
            if($conn->query($sql)){ echo "Данные успешно добавлены"; } else { echo "Ошибка: " . $conn->error; }
            
            $sql4 = "UPDATE all_leads SET dialog_wiev = 1, last_mes = '".$text_mess."', last_mes_time = '".$date."' WHERE phone = '".$phone."'"; 
            $conn->query($sql4);
        }
        $sql4 = "UPDATE all_leads SET dialog_wiev = 1, last_mes = '".$text_mess."', last_mes_time = '".$date."' WHERE phone = '".$phone."'"; 
        $conn->query($sql4);
    }
        
        if($gg['type']=='incoming_call'){
            $message = '
                Звонок на Whatsapp от клиента
                Имя - '.$name.'
                Телефон - '.$phone.'
                utm_source - '.$utm_source.'
                utm_medium - '.$utm_medium.'
                utm_campaign - '.$utm_campaign.'
                utm_content - '.$utm_content.'
                utm_term - '.$utm_term.'
                yclid - '.$yclid.'
                roistat - '.$roistat.'
                order_id - '.$id_crm;
        }else{
        $message = '
                Новое сообщение от клиента
                Имя - '.$name.'
                Телефон - '.$phone.'
                utm_source - '.$utm_source.'
                utm_medium - '.$utm_medium.'
                utm_campaign - '.$utm_campaign.'
                utm_content - '.$utm_content.'
                utm_term - '.$utm_term.'
                yclid - '.$yclid.'
                roistat - '.$roistat.'
                order_id - '.$id_crm;
        }           
            
        $sql2 = "SELECT * FROM tg_bot";
        if($conn->query($sql2)){
            $result = $conn->query($sql2); 
        
            foreach($result as $row){
                 
                $chat_id = $row["chat_id"];
                //sendTelegram(array('chat_id' => $chat_id,'text' => $message));
                sendTelegram($message,$chat_id);
            }
        }
        
        
        
    

}














?>