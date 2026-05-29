<?php

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

/*
function sendTelegram($response)
{
    $ch = curl_init('https://api.telegram.org/bot6843410151:AAEztaRwqsdj2d3vKhBxVKwkcrIqzeq4YOM/sendMessage');  
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



if(isset($_REQUEST['name_leads'])){$name_leads = $_REQUEST['name_leads'];}else{$name_leads = '';} 
if(isset($_REQUEST['name'])){$name = $_REQUEST['name'];}else{$name = '';} 
if(isset($_REQUEST['mail'])){$mail = $_REQUEST['mail'];}else{$mail = '';} 
if(isset($_REQUEST['phone'])){$phone = phone_format($_REQUEST['phone']);}else{$phone = '';} 
if(isset($_REQUEST['site'])){$site = $_REQUEST['site'];}else{$site = '';} 
if(isset($_REQUEST['url'])){$url = $_REQUEST['url'];}else{$url = '';} 
if(isset($_REQUEST['roistat'])){$roistat = $_REQUEST['roistat'];}else{$roistat = '';}
if(isset($_REQUEST['ycid'])){$ycid = $_REQUEST['ycid'];}else{$ycid = '';}
if(isset($_REQUEST['utm_source'])){$utm_source = $_REQUEST['utm_source'];}else{$utm_source = '';}
if(isset($_REQUEST['utm_medium'])){$utm_medium = $_REQUEST['utm_medium'];}else{$utm_medium = '';}
if(isset($_REQUEST['utm_campaign'])){$utm_campaign = $_REQUEST['utm_campaign'];}else{$utm_campaign = '';}
if(isset($_REQUEST['utm_content'])){$utm_content = $_REQUEST['utm_content'];}else{$utm_content = '';}
if(isset($_REQUEST['utm_term'])){$utm_term = $_REQUEST['utm_term'];}else{$utm_term = '';}
if(isset($_REQUEST['source'])){$source = $_REQUEST['source'];}else{$source = '';}
if(isset($_REQUEST['order_id'])){$id_crm = $_REQUEST['order_id'];}else{$id_crm = '';}

if($phone!=''){
    $date = time();
    $povtor_lead=0;
    $sql2 = "SELECT * FROM all_leads WHERE phone = $phone";
    if($conn->query($sql2)){
        $result = $conn->query($sql2);
        if($result->num_rows != 0){ $povtor_lead=1; } else { $povtor_lead=0; }
    }
    
    $name_data = "(date, name_leads, name, mail, phone, site, url, roistat, ycid, utm_source, utm_medium, utm_campaign, utm_content, utm_term, source, povtor_lead, id_crm)";
    $data = "('".$date."', '".$name_leads."', '".$name."', '".$mail."', '".$phone."', '".$site."', '".$url."', '".$roistat."', '".$ycid."', '".$utm_source."', '".$utm_medium."', '".$utm_campaign."', '".$utm_content."', '".$utm_term."', '".$source."', '".$povtor_lead."', '".$id_crm."')";
                
    $sql = "INSERT INTO all_leads $name_data VALUES $data"; 
    if($conn->query($sql)){ echo "Данные успешно добавлены"; } else { echo "Ошибка: " . $conn->error; }
    
    $message = '
            Новая сделка
            Сообщение - Заказ звонка
            Имя - 
            Телефон - '.$phone.'
            utm_source - '.$utm_source.'
            utm_medium - '.$utm_medium.'
            utm_campaign - '.$utm_campaign.'
            utm_content - '.$utm_content.'
            utm_term - '.$utm_term.'
            yclid - '.$ycid.'
            roistat - '.$roistat.'
            order_id - '.$id_crm;
            
            
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


if(isset($_REQUEST['price'])){
    $price = $_REQUEST['price'];
    $id = $_REQUEST['id'];
    echo '$price - '.$id.' - '.$price;
    $sql = "UPDATE all_leads SET price=$price WHERE id=$id"; $conn->query($sql);
    //if($conn->query($sql)){ echo "Данные успешно добавлены"; } else { echo "Ошибка: " . $conn->error; }
}

if(isset($_REQUEST['status_lead'])){
    $status_lead = $_REQUEST['status_lead'];
    $id = $_REQUEST['id'];
    echo '$status_lead - '.$id.' - '.$status_lead;
    $sql = "UPDATE all_leads SET status_lead='$status_lead' WHERE id=$id"; $conn->query($sql);
    //if($conn->query($sql)){ echo "Данные успешно добавлены"; } else { echo "Ошибка: " . $conn->error; }
}
    
    
if(isset($_REQUEST['coment'])){
    $coment = $_REQUEST['coment'];
    $id = $_REQUEST['id'];
    echo '$coment - '.$id.' - '.$coment;
    $sql = "UPDATE all_leads SET coment='$coment' WHERE id=$id"; $conn->query($sql);
    //if($conn->query($sql)){ echo "Данные успешно добавлены"; } else { echo "Ошибка: " . $conn->error; }
}    
    
    
if(isset($_REQUEST['cost'])){
    $data = str_replace(array("<br />", "<br>", "\r", "\n"), '', $_REQUEST['cost']);
    $col_upd = 0;
    $col_new = 0;
    $datad = explode(':',$data);
    $count_data = count($datad); echo 'всего - '.$count_data.'<br>_____<br>'; 
    
    for($i = 0; $i < $count_data; $i++){
        $d = explode('/',$datad[$i]);
        $date_cost = $d[0]; //echo 'date_cost - '.$date_cost.'<br>';
        $date_time = strtotime($date_cost); //echo 'date_time - '.$date_time.'<br>';
        $campaign_name = $d[1]; //echo 'campaign_name - '.$campaign_name.'<br>';
        $campaign_id = $d[2]; //echo 'campaign_id - '.$campaign_id.'<br>';
        $group_name = $d[3]; //echo 'group_name - '.$group_name.'<br>';
        $group_obv = $d[4]; //echo 'group_obv - '.$group_obv.'<br>';
        if($d[5] == "поиск"){ $type_place = "yandex_search"; }
        if($d[5] == "сети"){ $type_place = "yandex_context"; }
        $view_obv = $d[6]; //echo 'view_obv - '.$view_obv.'<br>';
        $click_obv = $d[7]; //echo 'click_obv - '.$click_obv.'<br>';
        $cost_obv = $d[8]; //echo 'cost_obv - '.$cost_obv.'<br><br>';
        
        if($date_cost != ''){
            $sql1 = "SELECT * FROM all_leads_cost WHERE date = '$date_cost' && group_obv = '$group_obv' && campaign_id = '$campaign_id' && type_place = '$type_place'";
            $result = $conn->query($sql1);
        
            $num_rows = $result->num_rows;
            
            //echo 'в базе сделка с срм_ид - '.$num_rows.'<br><br>';
            if($num_rows != 0){
                $row = $result->fetch_array();
                $id = $row['id'];
                $sql = "UPDATE all_leads_cost SET campaign_name='$campaign_name', campaign_id='$campaign_id', group_name='$group_name', type_place='$type_place', view='$view_obv', click='$click_obv', cost='$cost_obv' WHERE id=$id"; 
                $conn->query($sql);
                if($conn->query($sql)){ /*echo "Данные успешно обновлены<br>";*/ $col_upd++; } else { echo "Ошибка: " . $conn->error; }
            }
            else {
                $name_data = "(date, date_time, campaign_name, campaign_id, group_name, group_obv, type_place, view, click, cost )";
                $dataddd = "('".$date_cost."', '".$date_time."', '".$campaign_name."', '".$campaign_id."', '".$group_name."', '".$group_obv."', '".$type_place."', '".$view_obv."', '".$click_obv."', '".$cost_obv."')";
                                        
                $sql4 = "INSERT INTO all_leads_cost $name_data VALUES $dataddd"; 
                if($conn->query($sql4)){ /*echo "Данные успешно добавлены<br>";*/ $col_new++; } else { echo "Ошибка: " . $conn->error; }
            }
        }
    }
    
    echo 'Обновлено - '.$col_upd.'<br>';
    echo 'Добавлено - '.$col_new.'<br>';
}     
    
    
    
if(isset($_REQUEST['insert_lead_roistat'])){
    $id = $_REQUEST['insert_lead_roistat'];
    
    $sql1 = "SELECT * FROM all_leads WHERE id = '$id'";
    $result = $conn->query($sql1);
    $row = $result->fetch_array();
    $roistat = $row['roistat'];
    $phone = $row['phone'];
    $name = $row['name'];
    
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
    
    $sql = "UPDATE all_leads SET id_crm='$id_crm' WHERE id=$id"; $conn->query($sql);
    //if($conn->query($sql)){ echo "Данные успешно добавлены"; } else { echo "Ошибка: " . $conn->error; }
}
    
    
?>