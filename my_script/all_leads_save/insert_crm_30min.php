<?php
/*** Отправляем увеомление в Телеграм МНЕ ***/
function send_notification2 ($message){
    $token = "6843410151:AAEztaRwqsdj2d3vKhBxVKwkcrIqzeq4YOM"; //наш токен от telegram bot -а
    $chatid = "608866610";// ИД чата telegrm
    $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($message));
}
function sendTelegram($mess,$chatid)
{
    $token = "6843410151:AAEztaRwqsdj2d3vKhBxVKwkcrIqzeq4YOM";
    $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($mess));
}



$conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
//echo "Подключение успешно установлено";


if(date("H")>20 || date("H")==00 || date("H")>00 && date("H")<10){
    $Time30 = time()-3600;// 1 час
}else{    
    $Time30 = time()-1800;// 30 мин
}

$sql = "SELECT * FROM all_leads WHERE `id_crm`='' && `dialog_wiev` = 1 && `last_mes_time` < $Time30";
    if($conn->query($sql)){
        $result = $conn->query($sql); 
        
        if($result->num_rows != 0){
            send_notification2 ($result->num_rows.' Сделок отправлено в СРМ');
            
            foreach($result as $row){
                     
                $id = $row["id"];
                $name = $row["name"];
                $phone = $row["phone"];
                
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
                
                $sql4 = "UPDATE all_leads SET id_crm = '".$id_crm."' WHERE id = '".$id."'"; 
                $conn->query($sql4);
            }
        }
    }































?>