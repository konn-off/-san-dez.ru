<?php
$data = json_decode(trim(file_get_contents('php://input')), true);
// В $data будет массив ключ => значение с информацией о звонке
//file_put_contents('webhook-log.txt', "{$data['caller']} -> {$data['callee']}\n", FILE_APPEND); 



function writeToLog($data, $title = '') {
    $log = "\n------------------------\n";
    $log .= date("Y.m.d G:i:s") . "\n";
    $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
    $log .= print_r ($data,1);
    $log .= "\n------------------------\n";
    file_put_contents(getcwd() . '/hook1.log', $log, FILE_APPEND);
    return true;
}

/*$rawdata = file_get_contents("php://input");
$decoded = json_decode($rawdata);*/
//print_r ($decoded);
//writeToLog($decoded, 'incoming');
//writeToLog($_REQUEST, 'incoming');





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




$name = '';
$mail = '';
$site = $data['domain'];
$url = $data['landing_page'];
$roistat = $data['visit_id'];
$ycid = $data['metrika_client_id'];
$utm_source = $data['utm_source'];
$utm_medium = $data['utm_medium'];
$utm_campaign = $data['utm_campaign'];
$utm_content = $data['utm_content'];
$utm_term = $data['utm_term'];
$source = 'Звонок';
$phone = phone_format($data['caller']);
$id_crm = $data['order_id'];

if($data['status']=='ACRIVE'){$callstatus = 'звонок в процессе';}
if($data['status']=='ANSWER'){$callstatus = 'звонок был принят и обработан сотрудником';}
if($data['status']=='BUSY'){$callstatus = 'входящий звонок был, но линия была занята';}
if($data['status']=='NOANSWER'){$callstatus = 'входящий вызов состоялся, но в течение времени ожидания ответа не был принят сотрудником';}
if($data['status']=='CANCEL'){$callstatus = 'входящий вызов состоялся, но был завершен до того, как сотрудник ответил';}
if($data['status']=='CONGESTION'){$callstatus = 'вызов не состоялся из-за технических проблем';}
if($data['status']=='CHANUNAVAIL'){$callstatus = 'вызываемый номер был недоступен';}
if($data['status']=='DONTCALL'){$callstatus = 'входящий вызов был отменен';}
if($data['status']=='TORTURE'){$callstatus = 'входящий вызов был перенаправлен на автоответчик';}

$name_leads = 'Звонок - '.$callstatus;

$message = '
        Новая сделка
        Сообщение - Звонок - '.$callstatus.'
        Телефон - '.$phone.'
        utm_source - '.$utm_source.'
        utm_medium - '.$utm_medium.'
        utm_campaign - '.$utm_campaign.'
        utm_content - '.$utm_content.'
        utm_term - '.$utm_term.'
        yclid - '.$ycid.'
        roistat - '.$roistat.'
        order_id - '.$id_crm;
        
        $token = "6843410151:AAERG49__xZQiew2XDkkr-WqO87Oo5-FCWc"; //наш токен от telegram bot -а
        $chatid = "608866610";// ИД чата telegrm
        $chatid2 = "271142636";// ИД чата telegrm клиент
        $chatid3 = "1587801533";// ИД чата telegrm клиент2
        $chatid4 = "883627670";// ИД чата telegrm клиент3
        
        
    $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($message));
    $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid2."&text=".urlencode($message));
    $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid3."&text=".urlencode($message));
    $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid4."&text=".urlencode($message));



if(isset($phone) && $phone!=''){


    $conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
    if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
    //echo "Подключение успешно установлено";

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
}









