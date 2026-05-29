<?php

///[vpbx_api_key] => zgfl3zi0aq0klr28mnfxvdktet54uc9k

function writeToLog($data, $title = '') {
    $log = "\n------------------------\n";
    $log .= date("Y.m.d G:i:s") . "\n";
    $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
    $log .= print_r ($data,1);
    $log .= "\n------------------------\n";
    file_put_contents(getcwd() . '/hook_callibri.log', $log, FILE_APPEND);
    return true;
}

/*** Отправляем увеомление в Телеграм МНЕ ***/
function send_notification2 ($message){
    $token = "6843410151:AAERG49__xZQiew2XDkkr-WqO87Oo5-FCWc"; //наш токен от telegram bot -а
    $chatid = "608866610";// ИД чата telegrm
    $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($message));
}




$data = json_decode(file_get_contents('php://input'), true);

//writeToLog($_REQUEST, 'incoming_REQUEST');
//writeToLog($data, 'incoming_data');

/*if($_REQUEST){
    send_notification2 ('Уведомление от Манго');
}*/


$conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
//echo "Подключение успешно установлено";

$data = json_decode($_REQUEST['json'],true);

if($data['call_direction']){
    
    $entry_id = trim($data['entry_id']);
    $call_direction = $data['call_direction'];
    $call_from = $data['from']['number'];
    $call_to = $data['to']['number'];
    $create_time = $data['create_time'];
    $talk_time = $data['talk_time'];
    $entry_result = $data['entry_result'];
    //send_notification2 ('Уведомление о завершении вызова '.$entry_id);
    
    $name_data = "(entry_id, call_direction, call_from, call_to, create_time, talk_time, entry_result)";
    $data = "('".$entry_id."', '".$call_direction."', '".$call_from."', '".$call_to."', '".$create_time."', '".$talk_time."', '".$entry_result."')";
                
    $sql = "INSERT INTO calls $name_data VALUES $data"; 
    if($conn->query($sql)){ echo "Данные успешно добавлены"; } else { echo "Ошибка: " . $conn->error; }

}


if($data['recording_id']){
    $entry_id = $data['entry_id'];
    $recording_id = trim($data['recording_id']);
    //send_notification2 ('Уведомление о записи разговора '.$entry_id);
    $sql = "UPDATE calls SET recording_id='".$recording_id."' WHERE entry_id='".$entry_id."'"; $conn->query($sql);
}




















?>