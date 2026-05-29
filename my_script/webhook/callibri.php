<?

function writeToLog($data, $title = '') {
    $log = "\n------------------------\n";
    $log .= date("Y.m.d G:i:s") . "\n";
    $log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
    $log .= print_r ($data,1);
    $log .= "\n------------------------\n";
    file_put_contents(getcwd() . '/hook_callibri.log', $log, FILE_APPEND);
    return true;
}



//$data = json_decode(file_get_contents('php://input'), true);

writeToLog($_REQUEST, 'incoming');

$phone = $_REQUEST['phone'];


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
//$quis = $answers;
$site = '';
$url = '';
$roistat = '';
$ycid = '';
$utm_source = $_REQUEST['utm_source'];
$utm_medium = $_REQUEST['utm_medium'];
$utm_campaign = $_REQUEST['utm_campaign'];
$utm_content = $_REQUEST['utm_content'];
$utm_term = $_REQUEST['utm_term'];
$source = $_REQUEST['name_channel'];
$phone = phone_format($phone);
$referrer_url = '';//$_REQUEST['referer'];
//$id_crm = $data['order_id'];


if(isset($phone) && $phone!=''){
    
    
    
    $roistatData = array(
        
        'roistat' => $roistat,
        'key'     => 'NTYxODdiMGRkMjFjYmFmYTlhMDQ0M2NiZTEwNWViNDA6MjU3NjAz', // Ключ для интеграции с CRM, указывается в настройках интеграции с CRM.
        'title'   => 'Заявка с сайта от Алексея', // Название сделки
        'comment' => '', // Комментарий к сделке
        'name'    => '', // Имя клиента
        'email'   => '', // Email клиента
        'phone'   => $phone, // Номер телефона клиента
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
    
    $conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
    if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
    //echo "Подключение успешно установлено";

    $date = time();
    $povtor_lead=0;
    $sql2 = "SELECT * FROM all_leads WHERE phone = $phone";
    if($conn->query($sql2)){
        $result = $conn->query($sql2);
        if($result->num_rows != 0){ $povtor_lead=1; }
    }

    $name_data = "(date, name_leads, name, mail, phone, site, url, roistat, ycid, utm_source, utm_medium, utm_campaign, utm_content, utm_term, source, coment, id_crm, povtor_lead)";
    $data = "('".$date."', '".$name_leads."', '".$name."', '".$mail."', '".$phone."', '".$site."', '".$url."', '".$roistat."', '".$ycid."', '".$utm_source."', '".$utm_medium."', '".$utm_campaign."', '".$utm_content."', '".$utm_term."', '".$source."', '".$quis."', '".$id_crm."', '".$povtor_lead."')";
            
    $sql = "INSERT INTO all_leads $name_data VALUES $data"; 
    if($conn->query($sql)){ echo "Данные успешно добавлены"; } else { echo "Ошибка: " . $conn->error; }



    $message = '
    Новая сделка
    Сообщение - '.$source.'
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
}    
    
    

http_response_code(200);
exit;








?>