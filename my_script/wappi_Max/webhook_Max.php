
<?php




function writeToLog($data, $title = '') {
    $log = "\n------------------------\n";
    $log .= date("Y.m.d G:i:s") . "\n";
    $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
    $log .= print_r ($data,1);
    $log .= "\n------------------------\n";
    file_put_contents(getcwd() . '/hookMax.log', $log, FILE_APPEND);
    return true;
}



$data = json_decode(file_get_contents('php://input'), true);
$gg = $data['messages'];

writeToLog($data, 'incoming_raw');
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




function phone_filter ($s) { //фильтр символов проверяемой лексемы
    return preg_replace (array("/\-/u","/[^\d\+]/u"),"",$s);
}
 
function is_phone ($s) { //проверка лексемы на соответствие шаблону
    return preg_match("/^(\+7|8)(\d{10})$/u",$s) ? 1 : 0;
}

function is_phone_search_text ($data) { //проверка лексемы на соответствие шаблону
    define ('TEST_LIMIT','12'); //лимит проверяемой длины строк
 
    $data = preg_replace ("/\s+/u"," ",$data); //убрали лишние разделители
    $tokens = preg_split("/\s/u",$data); //получили массив лексем
    $tokens = array_filter ($tokens, function ($item) {return !empty($item);} );
    //отфильтровали пустые лексемы
    $len = count($tokens); $result = array (); $i = 0;
    for ($i=0; $i<$len; $i++) { //цикл по лексемам
        if (is_phone(phone_filter($tokens[$i]))) 
        $result[] = $tokens[$i]; //сама фильтрованная лексема есть номер
        else { //или пробуем сливать лексему с несколькими последующими
            $test = $tokens[$i]; $j = $i+1;
            while (1) {
                $test .= $tokens[$j]; 
                $test = phone_filter ($test);
                if (is_phone($test)) { $result[] = $test; $i=$j; break; }
                else if ($j>=$len or strlen($test)>TEST_LIMIT) break;
                $j++;
            } 
        } 
    }
 
    return $result; //вывод результатов
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
    $token = "6843410151:AAEztaRwqsdj2d3vKhBxVKwkcrIqzeq4YOM"; //наш токен от telegram bot -а
    $chatid = "608866610";// ИД чата telegrm
    $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($message));
}

/*** Отправляем увеомление в MAX в ЧАТ ***/
function send_noti_MAX ($message){
    file_get_contents("https://san-dez.ru/my_script/wappi_Max/chatBot.php?mes=".urlencode($message));
}



/*** Отправляем увеомление в Месcенджер Loop ***/
function sent_Loop($mess,$for){
    if($for==0){$url = 'https://san-dez.loop.ru/hooks/crjxgcihnjr6xqcp3xhhpighih';} // В канал для меня
    if($for==1){$url = 'https://san-dez.loop.ru/hooks/hq8ahfi817rbzk4u4taea4fjey';} // В канал для всех
    // Инициализация cURL сессии
    $ch = curl_init();
    
    // Настройка параметров запроса
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode([
            'text' => $mess
        ]),
        CURLOPT_HTTPHEADER => [
            'Content-Type: application/json'
        ],
        CURLOPT_SSL_VERIFYPEER => false // Отключить проверку SSL (можно убрать для продакшена)
    ]);
    // Выполнение запроса
    $response = curl_exec($ch);
    // Проверка на ошибки
    if(curl_errno($ch)) {
        echo 'cURL error: ' . curl_error($ch);
    } 
    else {
        // Получение HTTP статуса
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        // Вывод ответа
        /*echo "HTTP статус: $httpCode\n";
        echo "Ответ сервера:\n";
        var_dump($response);*/
    }
    // Закрытие сессии
    curl_close($ch);
}



/*
function sendTelegram($response)
{
    $ch = curl_init('https://api.telegram.org/6843410151:AAEztaRwqsdj2d3vKhBxVKwkcrIqzeq4YOM/sendMessage');  
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
sent_Loop('Есть Хук MAX - '.$data['type'].', '.$data['from'].' - '.$data['body'],0);

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
$contact_phone ='';
$type_mess = $data['type'];
$chat_id_max = $data['chatId'];

$id_mes = $data['id'];



if($chat_id_max == '-72256037346650'){
    exit();
}

if($type_mess=='text'){
    $text_mess = $data['body'];
    //"Код на скидку - 192917"
    //$roistat = explode("Код на скидку", $text_mess);
    
    //$roistat = preg_replace("/[^0-9]/", '', $roistat[1]);
    
    
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
    if(strlen($phone)<11){
        //$phone= 'id_MAX:'.$chat_id_max;
        if (is_phone_search_text($text_mess)[0]!=''){ $phone = phone_format(is_phone_search_text($text_mess)[0]); }else{ $phone = ''; }
    }else{$phone=phone_format($phone);}
}

//send_notification2 ('name - '.$name.' phone - '.$phone);

$source = 'MAX';
$name_leads = 'Заявка Max';
$mail = '';
$site = '';


//if($phone!=''){
    
    $conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
    if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
    //echo "Подключение успешно установлено";
    
    
    if($type_mess=='audio'){
        $audio_mes = $data['body'];
        
        $sql = "SELECT * FROM transcryptAudio WHERE id_mes = '".$id_mes."'";
        if($conn->query($sql)){
            $result = $conn->query($sql); 
            if($result->num_rows != 0){
               //$row = $result->fetch_array();
               
               //$file = $file.$row['text'];
            }else{
               //send_notification2 ($data[$n]['s3Info']['url']);
               $name_data = "(id_mes, url_voice)";
               $data = "('".$id_mes."', '".$audio_mes."')";
                          
               $sql2 = "INSERT INTO transcryptAudio $name_data VALUES $data";
               $conn->query($sql2);
               //$last_id = $conn->insert_id;
               
               
               $data = [
                   'id_mes' => $id_mes//,
                   //'audio' => $last_id//$data[$n]['s3Info']['url']
               ];
               
               $context = stream_context_create([
                   'http' => [
                       'method'  => 'POST',
                       'header'  => 'Content-Type: application/x-www-form-urlencoded',
                       'content' => http_build_query($data)
                   ]
               ]);
               
               $response = file_get_contents('https://san-dez.ru/my_script/GigaChat/index.php', false, $context);                                          
               
               //$file = $file.$response;
               
               $sql3 = "UPDATE transcryptAudio SET text='".$response."' WHERE id_mes='".$id_mes."'";
               $conn->query($sql3);
               /*$name_data = "(id_mes, text)";
               $data = "('".$ids."', '".$response."')";
                          
               $sql2 = "INSERT INTO transcryptAudio $name_data VALUES $data"; 
               if($conn->query($sql2)){
                  
               }*/

            }
        }
        /*$sql = "SELECT * FROM transcryptAudio WHERE id_mes = '".$id_mes."'";
        if($conn->query($sql)){
            $result = $conn->query($sql); 
            if($result->num_rows == 0){
               $data = [
                   'id_mes' => $id_mes,
                   'audio' => $audio_mes
               ];
               
               $context = stream_context_create([
                   'http' => [
                       'method'  => 'POST',
                       'header'  => 'Content-Type: application/x-www-form-urlencoded',
                       'content' => http_build_query($data)
                   ]
               ]);
               
               $response = file_get_contents('https://san-dez.ru/my_script/GigaChat/index.php', false, $context);
               
               
               $name_data = "(id_mes, text)";
               $data = "('".$id_mes."', '".$response."')";
                          
               $sql2 = "INSERT INTO transcryptAudio $name_data VALUES $data"; 
               if($conn->query($sql2)){
                  //send_notification2 ('Сохранили в базу');
                  sent_Loop('Сохранили в базу',0);
               }

            }
        }*/
    }

    
    $utm_source = '';$utm_medium = '';$utm_campaign = '';$utm_content = '';$utm_term = '';$yclid = '';$referrer_url = '';$url = '';
    $date = time();
    
    $povtor_lead=0;
    $sql2 = "SELECT * FROM all_leads WHERE chat_id_max = $chat_id_max";
    if($conn->query($sql2)){
        $result = $conn->query($sql2); 
        if($result->num_rows != 0){
            $povtor_lead=1;
        }else{
            $povtor_lead=0;
        }
    }
    
    
    if($povtor_lead == 0){
        $dateff = $date-180;
        $sql2 = "SELECT * FROM click_max WHERE id_lead = '' && datetime > $dateff";
        if($conn->query($sql2)){
            $result = $conn->query($sql2); 
            if($result->num_rows != 0){ 
                
                $row = $result->fetch_array();
                //$datetime = $row['datetime']+300;
                //if($datetime > $date){
                $id_click_max = $row['id'];
                    $utm_source = $row['utm_source'];
                    $utm_medium = $row['utm_medium'];
                    $utm_campaign = $row['utm_campaign'];
                    $utm_content = $row['utm_content'];
                    $utm_term = $row['utm_term' ];
                    $site = $row['site'];
                    $url = $row['url'];
                    $referrer_url = $row['referrer_url'];
                    $yclid = $row['yclid'];
                //}
            }
        }
    }
    
    if($site=='san-dez.ru' || $site==''){
        $metriks_id_schetchik = 97574764;
        $tokenYa = "y0_AgAAAAB2YcxHAAz9CQAAAAEc8EgpAAAeTMYl9JZAh5sHnEl8n_Hpf8_gFg"; // san-dez
    }
    if($site=='xn-----8kcaaiejjavmb1acem4amnaho2a2c1b6c2p.xn--p1ai' || $site=='xn-----8kcaaiejjavmb1acem4amnaho2a2c1b6c2p.xn--p1a' || $site == 'дезинфекция-клопов-тараканов.рф' || $site == 'https://дезинфекция-клопов-тараканов.рф'){
        $metriks_id_schetchik = 98748423;
        $tokenYa = "y0__xDautmVCBjSoDgghILquhMGIA76MivvUFRINzIychmJEuSkqw"; // дезинфекция-клопов-тараканов.рф
    }



    //$datePast = $date-7200;// 2часа
    $datePast = strtotime('today midnight');
    //$sql3 = "SELECT * FROM all_leads WHERE phone = $phone && date > $datePast";
    $sql3 = "SELECT * FROM all_leads WHERE chat_id_max = $chat_id_max LIMIT 1";
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
            
            $sql4 = "SELECT * FROM all_leads WHERE chat_id_max = $chat_id_max ORDER BY id DESC LIMIT 1";
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
    
        
            
        
        
    //send_notification2 ('povtor_lead - '.$povtor_lead.' povtor_lead_nedavno - '.$povtor_lead_nedavno);
    
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
        
        $name_data = "(date, name_leads, name, mail, phone, site, url, roistat, ycid, utm_source, utm_medium, utm_campaign, utm_content, utm_term, source, povtor_lead, id_crm, dialogId, dialog_wiev, last_mes, last_mes_time, chat_id_max, last_messenger, notise_audio)";
        $data = "('".$date."', '".$name_leads."', '".$name."', '".$mail."', '".$phone."', '".$site."', '".$url."', '".$roistat."', '".$yclid."', '".$utm_source."', '".$utm_medium."', '".$utm_campaign."', '".$utm_content."', '".$utm_term."', '".$source."', '".$povtor_lead."', '".$id_crm."', '".$dialogId."', 1, '".$text_mess."', '".$date."', '".$chat_id_max."', 'max', 1)";
                    
        $sql = "INSERT INTO all_leads $name_data VALUES $data"; 
        if($conn->query($sql)){ $messageMy = "Данные успешно добавлены"; 
            $id = $conn->insert_id;
            //$id = mysql_insert_id();
            //send_notification2 ($messageMy.' - '.$id);
            sent_Loop($messageMy.' - '.$id,0);
            if($id_click_max){
                $sql4 = "UPDATE click_max SET id_lead = $id WHERE id = '".$id_click_max."'"; 
                $conn->query($sql4);
            }
            
        } else { sent_Loop("Ошибка: " .$conn->error,0); /*send_notification2 ("Ошибка: " .$conn->error);*/ }
        
        
        
    
        
        
        
        if($yclid != ''){
            
        
            //$token = "y0__xDautmVCBjSoDgghILquhMGIA76MivvUFRINzIychmJEuSkqw"; // дезинфекция-клопов-тараканов.рф
            //$token = "y0_AgAAAAB2YcxHAAz9CQAAAAEc8EgpAAAeTMYl9JZAh5sHnEl8n_Hpf8_gFg"; // san-dez
            $orders = "ClientID,Target,DateTime".PHP_EOL;		
            
            
            //ym(97574764,'reachGoal','test_lead')
            $orders .= $yclid.",lead,".time().PHP_EOL;
            //$orders .= $yclid.",lead2,".time().PHP_EOL;
                
            
            $counterId = $metriks_id_schetchik; //97574764; //id счетчика
            $boundary = "7zDUQOAIAE9hEWoV";
            $filename = 'data.csv';
            
            $data = "--------------------------$boundary\x0D\x0A";
            $data .= "Content-Disposition: form-data; name=\"file\"; filename=\"$filename\"\x0D\x0A";
            $data .= "Content-Type: text/csv\x0D\x0A\x0D\x0A";
            $data .= $orders . "\x0A\x0D\x0A";
            $data .= "--------------------------$boundary--";
            
            $url = "https://api-metrika.yandex.net/management/v1/counter/".$counterId."/offline_conversions/upload?client_id_type=CLIENT_ID&oauth_token=".$token;
            
            //if($povtor_lead==0){

                $yaInfo = getInfoYa($url,$tokenYa,$data,$boundary);
                $yaInfo = json_decode($yaInfo["response"]["html"],true);
                //send_notification2 ("Конверсия в Метрику: " .json_decode($yaInfo["response"]["html"],true));
                sent_Loop("Конверсия в Метрику Max: " .$yaInfo,0);
            //}
        }
    
        

    }
    else{//$povtor_lead == 1
        if($povtor_lead_nedavno==0){
            $name_data = "(date, name_leads, name, mail, phone, site, url, roistat, ycid, utm_source, utm_medium, utm_campaign, utm_content, utm_term, source, povtor_lead, id_crm, dialogId, dialog_wiev, chat_id_max, last_messenger, notise_audio)";
            $data = "('".$date."', '".$name_leads."', '".$name."', '".$mail."', '".$phone."', '".$site."', '".$url."', '".$roistat."', '".$yclid."', '".$utm_source."', '".$utm_medium."', '".$utm_campaign."', '".$utm_content."', '".$utm_term."', '".$source."', '".$povtor_lead."', '".$id_crm."', '".$dialogId."', 1, '".$chat_id_max."', 'max', 1)";
                        
            $sql = "INSERT INTO all_leads $name_data VALUES $data"; 
            if($conn->query($sql)){ /*echo "Данные успешно добавлены";*/ } else { sent_Loop("Ошибка: " .$conn->error,0); /*send_notification2 ("Ошибка: " .$conn->error);*/ }
            
            $sql4 = "UPDATE all_leads SET dialog_wiev = 1, last_mes = '".$text_mess."', last_mes_time = '".$date."', notise_audio = 1 WHERE chat_id_max = '".$chat_id_max."'"; 
            $conn->query($sql4);
        }
        if($phone !='' ){ $fffs = 'phone = '.$phone.',';}else{ $fffs = ''; }
        $sql4 = "UPDATE all_leads SET dialog_wiev = 1,".$fffs." last_mes = '".$text_mess."', last_mes_time = '".$date."', notise_audio = 1 WHERE chat_id_max = '".$chat_id_max."'"; 
        $conn->query($sql4);
    }
        
    
        
        
        
    if($type_mess=='incoming_call'){
$message = '
Звонок на Max от клиента
Имя - '.$name.'
Телефон - '.$phone.'
utm_source - '.$utm_source.'
utm_medium - '.$utm_medium.'
tm_campaign - '.$utm_campaign.'
utm_content - '.$utm_content.'
utm_term - '.$utm_term.'
yclid - '.$yclid.'
roistat - '.$roistat.'
order_id - '.$id_crm;
        }else{
$message = '
Новое сообщение в Max от клиента
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
        send_noti_MAX ($message);
        sent_Loop($message,1);
        /*
        $sql2 = "SELECT * FROM tg_bot";
        if($conn->query($sql2)){
            $result = $conn->query($sql2); 
        
            foreach($result as $row){
                $chat_id = $row["chat_id"];
                //send_notification2 ($chat_id);
                
                //sendTelegram(array('chat_id' => $chat_id,'text' => $message));
                sendTelegram($message,$chat_id);
                
            }
        }*/
        
        /*send_notification2 ($message);
    send_notification2 ('Есть оповещение');*/
//}














?>