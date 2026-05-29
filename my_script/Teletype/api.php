<?php

/*** Отправляем увеомление в Телеграм МНЕ ***/
function send_notification2 ($message){
    $token = "6843410151:AAERG49__xZQiew2XDkkr-WqO87Oo5-FCWc"; //наш токен от telegram bot -а
    $chatid = "608866610";// ИД чата telegrm
    $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($message));
}


// ZPae6I71gBvQvgyb8WM6MQ1z4BHEVaZfPfQwpAJUrCtlh9mr9shomwXg083fFah3
$token = 'ZPae6I71gBvQvgyb8WM6MQ1z4BHEVaZfPfQwpAJUrCtlh9mr9shomwXg083fFah3';

$dialogId = $_GET['dialogId'];
$mes = str_replace(PHP_EOL, '<br>', $_GET['mes']); 


$conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
//echo "Подключение успешно установлено";


if($_GET['type']=='all_new_mes'){
    
    $sql = "SELECT * FROM all_leads WHERE last_mes!='' && dialog_wiev=1 ORDER BY date";
    $result = $conn->query($sql);
    //echo $result->num_rows;
    if($result->num_rows != 0){
        $mess = '';
        while($row = $result->fetch_assoc())
        {
            if($row['chat_id_tg'] != ''){$messenger_activ = 'tg';}
            if($row['chat_id_max'] != ''){$messenger_activ = 'max';}
            $mess=$mess. '<div class="new_mes_noti" data-messenger_activ="'.$messenger_activ.'" data-chat_id_tg="'.$row['chat_id_tg'].'" data-chat_id_max="'.$row['chat_id_max'].'" data-id_dialog="'.$row['dialogId'].'" data-id_crm="'.$row['id_crm'].'" data-phone="'.$row['phone'].'"><!--p class="close_new_mes_noti"><img src="img/close.png"></p--><div class="info_new_mes_noti"><span>'.$row['name'].'</span> <span>'.$row['id_crm'].'</span></div><p>'.$row['last_mes'].'</p></div>';
        }
        echo $mess;
    }
    
    
}


if($_GET['type']=='notise_audio'){
    
    $sql = "SELECT * FROM all_leads WHERE notise_audio = 1";
    $result = $conn->query($sql);
    //echo $result->num_rows;
    if($result->num_rows != 0){
        while($row = $result->fetch_assoc())
        {
            $id = $row['id'];
            $sql4 = "UPDATE all_leads SET notise_audio = '0' WHERE id = '".$id."'"; 
            $conn->query($sql4);
        }
        echo 1;
    }
    
    
}





if($_GET['type']=='all_mes'){
    //Подготовка массива спараметрами
    $getParams = [
        'token'  => $token,
        'dialogId'  => $dialogId,
        'pageSize'  => 100
    ];

    $ch = curl_init('https://api.teletype.app/public/api/v1/messages?' . http_build_query($getParams));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    
    $res = curl_exec($ch);
    
    curl_close($ch);
    
    //echo $html;
    
    //Обратная конвертация (ответ так же получен в формате JSON)
    $res = json_decode($res, true);
    
    $data = $res['data']['items'];
    
    $name = '';//$data[0]['client']['name'];
    $ava = '';//$data[0]['client']['avatar'];
    $phone = '';//$data[0]['client']['phone'];
    $file = '';
    $mess = '';
    
    
    for ($n = 0; $n < count($data); $n++) {
    //for ($n = count($data); $n == 0; $n-1) {
        if($data[$n]['operator']==NULL){
            $name = $data[$n]['client']['name'];
            $ava = $data[$n]['client']['avatar'];
            $phone = $data[$n]['client']['phone'];
        }
        
        $ids = $data[$n]['id'];
        $sql6 = "SELECT * FROM mes_men WHERE ids = '".$ids."' && name_men != ''";
        $result = $conn->query($sql6);
        if($result->num_rows != 0){
            $row = $result->fetch_array();
            $mes_name_men = '<p class="mes_name_men" data_idTG = "'.$row['id_men'].'"><span>'.$row['name_men'].'</span></p>';
        }else{
            $mes_name_men='';
        }
        /**/
        if($data[$n]['attachments']!=''){
            foreach ($data[$n]['attachments'] as $key) {
                if($key['type']=='image'){
                    $file = $file.'<img src="'.$key['url'].'" title="'.$key['filename'].'" class="wz_mes_images">';
                }
                if($key['type']=='audio'){
                    $file = $file.'<audio src="'.$key['url'].'"  controls="controls">
                        Ваш браузер не поддерживает элемент <code>audio</code>.
                    </audio>';
                }
                if($key['type']=='video'){
                    $file = $file.'<video controls width="100%">
                    <source src="'.$key['url'].'" >
                    Ваш браузер не поддерживает встроенные видео :(
                    </video>';
                }
                if($key['type']!='video' && $key['type']!='audio' && $key['type']!='image'){
                    $file = $file.'<a href="'.$key['url'].'" target="_blank" ><img src="img/file_icon.png">'.$key['filename'].'</a>';
                }
                
            }
        }
        
        $timestamp = strtotime($data[$n]['sentAt']['date']);
        $mess=$mess. '<div class="';
        if($data[$n]['operator']==NULL){$mess=$mess. 'mes-client';}else{$mess=$mess. 'mes-manager';}
        $mess=$mess. '">'.$mes_name_men.str_replace(PHP_EOL, '<br>', $data[$n]['text']).$file.'<p class="date">'.date('d.m H:i',$timestamp).'</p>';
        if($data[$n]['operator']!=NULL){
            $mess=$mess. '<p class="status_mes">';
            if($data[$n]['seen']==1){$mess=$mess. 'Просмотрено';}else{
                if($data[$n]['status']==10){$mess=$mess. 'Отправляется';}
                if($data[$n]['status']==20){$mess=$mess. 'Ошибка при отправке';}
                if($data[$n]['status']==30){$mess=$mess. 'Доставлено';}
            }
            $mess=$mess. '</p>';
            //if($dialogId=='ioAGxq90hMk6n4wohPmjskNd3Q7xV04KIrN7YKPaR417_M_QfRBQUtEKjh5P9Tj_'){$mess=$mess.$data[$n]['id'];}
        }
        $mess=$mess. '</div>';
        $file = '';
    } 
    
    echo $name.':::'.$ava.':::'.$phone.':::'.$mess;
    
    //Удобно просматриваем массив
    //echo '<pre>'; print_r($res); echo '</pre>';
}



if($_GET['type']=='sent_mes'){ 
    $array = array(
        'token'  => $token,
        'dialogId'  => $dialogId,
        'text'  => $mes
    );		
     
    $ch = curl_init('https://api.teletype.app/public/api/v1/message/send');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Auth-Token: '.$token));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($array, '', '&'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $html = curl_exec($ch);
    $html = json_decode($html, true);
    curl_close($ch);	
     
    //$conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
    //if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
    //echo "Подключение успешно установлено";
    $sql4 = "UPDATE all_leads SET dialog_wiev = 0 WHERE dialogId = '".$dialogId."'"; 
    $conn->query($sql4);

    $id_men = $_GET['id_men']; $name_men = $_GET['name_men'];
    $name_data = "(ids, id_men, name_men)";
    $data = "('".$html['data']['ids'][0]."', '".$id_men."','".$name_men."')";
                    
    $sql = "INSERT INTO mes_men $name_data VALUES $data"; 
    if($conn->query($sql)){ /*echo "Данные успешно добавлены";*/ } else { send_notification2 ("Ошибка SQL при отправки сообщения: " . $conn->error); }
    //send_notification2 ($html['data']['ids'][0]);
}



if($_GET['type']=='new_dialog'){ 
    $phone = $_GET['clientPhone'];
    $array = array(
        'token'  => $token,
        'channelId'  => '3AYnoyXGveoAUIKvIlrvWffY9Gn2Ss1wITV6aRxXFjO5LcJgHewEod-bEkr8Uii7',
        'clientPhone'  => $phone
    );		
     
    $ch = curl_init('https://api.teletype.app/public/api/v1/dialog/create');
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-Auth-Token: '.$token));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($array, '', '&'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    $html = curl_exec($ch);
    $html = json_decode($html, true);
    curl_close($ch);	
    //print_r($html);
    
    if($html['success']=='true'){
        $dialogId = $html['data']['id'];
        echo $dialogId;
    }else{
        echo 'Ошибка - '.$html['errors'][0]['message'];
    }
    
    if($dialogId != ''){
        $sql4 = "UPDATE all_leads SET dialogId = '".$dialogId."' WHERE phone = '".$phone."'"; 
        $conn->query($sql4);
    }
    
    if($html['errors'][0]['code']=='404'){
        $sql4 = "UPDATE all_leads SET dialogId = '".$html['errors'][0]['message']."' WHERE phone = '".$phone."'"; 
        $conn->query($sql4);
    }
    
    
    //send_notification2 ($html['data']['id']);
}




if($_GET['type']=='view_mes'){ 
    
    $sql4 = "UPDATE all_leads SET dialog_wiev = 0 WHERE dialogId = '".$dialogId."'"; 
    $conn->query($sql4);
}








//https://api.teletype.app/public/api/v1/messages?token='.$token.'&dialogId='.$dialogId
// ioAGxq90hMk6n4wohPmjskNd3Q7xV04KIrN7YKPaR417_M_QfRBQUtEKjh5P9Tj_




//san-dez.ru/my_script/Teletype/api.php?dialogId=ioAGxq90hMk6n4wohPmjskNd3Q7xV04KIrN7YKPaR417_M_QfRBQUtEKjh5P9Tj_&type=all_mes
?>
