<?php




$conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
//echo "Подключение успешно установлено";
    


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


/*** Отправляем увеомление в MAX в ЧАТ ***/
function send_noti_MAX ($message){
    file_get_contents("https://san-dez.ru/my_script/wappi_Max/chatBot.php?mes=".urlencode($message));
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

function sendTelegram($mess,$chatid)
{
    $token = "6843410151:AAEztaRwqsdj2d3vKhBxVKwkcrIqzeq4YOM";
    $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($mess));
}
*/








// Функция проверки телефона
function validatePhone($phone) {
    // Убираем все нецифровые символы
    $cleanPhone = preg_replace('/\D/', '', $phone);
    
    // Проверяем, что номер начинается с 7 или 8 и имеет 10 цифр (без кода страны)
    if (preg_match('/^(7|8)\d{10}$/', $cleanPhone)) {
        // Приводим к формату +7XXXXXXXXXX
        $formatted = '+7' . substr($cleanPhone, -10);
        return $formatted;
    }
    return false;
}

// Функция проверки имени
function validateName($name) {
    $name = trim($name);
    // Разрешаем буквы, пробелы, дефисы, апострофы
    if (preg_match('/^[a-zA-Zа-яА-ЯёЁ\s\-\']{2,50}$/u', $name)) {
        return $name;
    }
    return false;
}


/*
// Проверяем, что запрос — POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405); // Method Not Allowed
    echo json_encode([
        'success' => false,
        'message' => 'Недопустимый метод запроса'
    ]);
    exit;
}



// Получаем и декодируем JSON из тела запроса
$input = file_get_contents('php://input');
$data = json_decode($input, true);
*/



// Получаем данные из формы
$name_leads = $_POST['name_leads'] ?? '';
$name = $_POST['name'] ?? '';
$mail = $_POST['mail'] ?? '';
$phone = phone_format($_POST['phone']) ?? '';
$site = $_POST['site'] ?? $_SERVER['HTTP_HOST'] ?? '';
$url = $_POST['url'] ?? $_SERVER['REQUEST_URI'] ?? '';
$roistat = $_POST['roistat_visit'] ?? '';
$ycid = $_POST['ycid'] ?? '';
$utm_source = $_POST['utm_source'] ?? '';
$utm_medium = $_POST['utm_medium'] ?? '';
$utm_campaign = $_POST['utm_campaign'] ?? '';
$utm_content = $_POST['utm_content'] ?? '';
$utm_term = $_POST['utm_term'] ?? '';
$source = $_POST['source'] ?? 'website_form';
$id_crm = $_POST['order_id'] ?? '';
$privacy = $_POST['privacy'] ?? 'false';

// Функция для безопасной очистки данных
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    $data = trim($data);
    $data = strip_tags($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

// Очищаем полученные данные
$sanitizedData = sanitizeInput([
    'name_leads' => $name_leads,
    'name' => $name,
    'mail' => $mail,
    'phone' => $phone,
    'site' => $site,
    'url' => $url,
    'roistat' => $roistat,
    'ycid' => $ycid,
    'utm_source' => $utm_source,
    'utm_medium' => $utm_medium,
    'utm_campaign' => $utm_campaign,
    'utm_content' => $utm_content,
    'utm_term' => $utm_term,
    'source' => $source,
    'order_id' => $id_crm,
    'privacy' => $privacy
]);


// Валидация обязательных полей
$errors = [];

if (empty($name) && empty($name_leads)) {
    $errors[] = 'Имя обязательно для заполнения';
}
if (empty($phone)) {
    $errors[] = 'Телефон обязателен для заполнения';
}
if ($privacy !== 'on') {
    $errors[] = 'Необходимо согласие на обработку персональных данных';
}

// Если есть ошибки валидации, возвращаем их как текст
if (!empty($errors)) {
    http_response_code(422);
    foreach ($errors as $error) {
        echo $error . '<br>';
    }
    exit;
}






// Валидация обязательных полей
if (empty($sanitizedData['name'])) {
    $errors[] = 'Имя обязательно для заполнения';
} else {
    $validatedName = validateName($sanitizedData['name']);
    if (!$validatedName) {
        $errors[] = 'Некорректное имя';
    }
}

if (empty($sanitizedData['phone'])) {
    $errors[] = 'Телефон обязателен для заполнения';
} else {
    $validatedPhone = validatePhone($sanitizedData['phone']);
    if (!$validatedPhone) {
        $errors[] = 'Некорректный формат телефона';
    }
}

if (empty($sanitizedData['privacy']) || $sanitizedData['privacy'] !== 'on') {
    $errors[] = 'Необходимо согласие на обработку персональных данных';
}

// Если есть ошибки валидации, возвращаем их
if (!empty($errors)) {
    sent_Loop('errors - '.$errors,0);
    //http_response_code(422); // Unprocessable Entity
    echo  'message - Ошибки валидации';
    exit;
}




// Подготавливаем данные для сохранения/отправки
$finalData = [
    'name' => $validatedName,
    'phone' => $validatedPhone,
    'message' => $sanitizedData['message'] ?? '',
    'area' => $sanitizedData['area'] ?? '',
    // Все скрытые поля UTM и прочие
    'yclid' => $sanitizedData['yclid'] ?? '',
    'utm_source' => $sanitizedData['utm_source'] ?? '',
    'utm_medium' => $sanitizedData['utm_medium'] ?? '',
    'utm_campaign' => $sanitizedData['utm_campaign'] ?? '',
    'utm_content' => $sanitizedData['utm_content'] ?? '',
    'utm_term' => $sanitizedData['utm_term'] ?? '',
    'referrer_url' => $sanitizedData['referrer_url'] ?? '',
    'url' => $sanitizedData['url'] ?? '',
    'roistat_visit' => $sanitizedData['roistat_visit'] ?? '',
    'ip' => $_SERVER['REMOTE_ADDR'] ?? '',
    'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
    'timestamp' => date('Y-m-d H:i:s')
];

// Здесь можно добавить:
// 1. Сохранение в базу данных
// 2. Отправку email
// 3. Интеграцию с CRM
/*
// Пример сохранения в файл (для тестирования)
$logFile = 'form_submissions.log';
$logEntry = date('Y-m-d H:i:s') . ' | ' . json_encode($finalData, JSON_UNESCAPED_UNICODE) . PHP_EOL;
file_put_contents($logFile, $logEntry, FILE_APPEND | LOCK_EX);
*/


sent_Loop($phone,0);





/*
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
*/


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
    send_noti_MAX($message);
    sent_Loop($message,1);

    /*
    if($site=='san-dez.ru' || $site==''){
        $metriks_id_schetchik = 97574764;
        $tokenYa = "y0_AgAAAAB2YcxHAAz9CQAAAAEc8EgpAAAeTMYl9JZAh5sHnEl8n_Hpf8_gFg"; // san-dez
    }
    if($site=='xn-----8kcaaiejjavmb1acem4amnaho2a2c1b6c2p.xn--p1ai' || $site=='xn-----8kcaaiejjavmb1acem4amnaho2a2c1b6c2p.xn--p1a' || $site == 'дезинфекция-клопов-тараканов.рф' || $site == 'https://дезинфекция-клопов-тараканов.рф' || $site == 'xn-----8kcaaiejjavmb1acem'){
        $metriks_id_schetchik = 98748423;
        $tokenYa = "y0__xDautmVCBjSoDgghILquhMGIA76MivvUFRINzIychmJEuSkqw"; // дезинфекция-клопов-тараканов.рф
    }
    */
    
    if($ycid != ''){
        $yclid = $ycid;
                if($site == ''){
                    $metriks_id_schetchik = '97574764'; //san-dez
                    $token = "y0_AgAAAAB2YcxHAAz9CQAAAAEc8EgpAAAeTMYl9JZAh5sHnEl8n_Hpf8_gFg";
                    
                    $orders = "ClientID,Target,DateTime".PHP_EOL;		
                    $orders .= $yclid.",lead,".time().PHP_EOL;
                    $counterId = $metriks_id_schetchik;
                    $boundary = "7zDUQOAIAE9hEWoV";
                    $filename = 'data.csv';
                    $data = "--------------------------$boundary\x0D\x0A";
                    $data .= "Content-Disposition: form-data; name=\"file\"; filename=\"$filename\"\x0D\x0A";
                    $data .= "Content-Type: text/csv\x0D\x0A\x0D\x0A";
                    $data .= $orders . "\x0A\x0D\x0A";
                    $data .= "--------------------------$boundary--";
                    $url = "https://api-metrika.yandex.net/management/v1/counter/".$counterId."/offline_conversions/upload?client_id_type=CLIENT_ID&oauth_token=".$token;
                    
                    $yaInfo = getInfoYa($url,$token,$data,$boundary);
                    $yaInfo = json_decode($yaInfo["response"]["html"],true);
                    sent_Loop("Конверсия в Метрику: " .$yaInfo,0);
                    
                    $metriks_id_schetchik = '98748423'; //дезинфекция.рф
                    $token = "y0__xDautmVCBjSoDgghILquhMGIA76MivvUFRINzIychmJEuSkqw";
                    
                    $orders = "ClientID,Target,DateTime".PHP_EOL;		
                    $orders .= $yclid.",lead,".time().PHP_EOL;
                    $counterId = $metriks_id_schetchik;
                    $boundary = "7zDUQOAIAE9hEWoV";
                    $filename = 'data.csv';
                    $data = "--------------------------$boundary\x0D\x0A";
                    $data .= "Content-Disposition: form-data; name=\"file\"; filename=\"$filename\"\x0D\x0A";
                    $data .= "Content-Type: text/csv\x0D\x0A\x0D\x0A";
                    $data .= $orders . "\x0A\x0D\x0A";
                    $data .= "--------------------------$boundary--";
                    $url = "https://api-metrika.yandex.net/management/v1/counter/".$counterId."/offline_conversions/upload?client_id_type=CLIENT_ID&oauth_token=".$token;
                    
                    $yaInfo = getInfoYa($url,$token,$data,$boundary);
                    $yaInfo = json_decode($yaInfo["response"]["html"],true);
                    sent_Loop("Конверсия в Метрику: " .$yaInfo,0);
                }
                if($site == 'san-dez.ru'){
                    $metriks_id_schetchik = '97574764';
                    $token = "y0_AgAAAAB2YcxHAAz9CQAAAAEc8EgpAAAeTMYl9JZAh5sHnEl8n_Hpf8_gFg";
                    
                    $orders = "ClientID,Target,DateTime".PHP_EOL;		
                    $orders .= $yclid.",lead,".time().PHP_EOL;
                    $counterId = $metriks_id_schetchik;
                    $boundary = "7zDUQOAIAE9hEWoV";
                    $filename = 'data.csv';
                    $data = "--------------------------$boundary\x0D\x0A";
                    $data .= "Content-Disposition: form-data; name=\"file\"; filename=\"$filename\"\x0D\x0A";
                    $data .= "Content-Type: text/csv\x0D\x0A\x0D\x0A";
                    $data .= $orders . "\x0A\x0D\x0A";
                    $data .= "--------------------------$boundary--";
                    $url = "https://api-metrika.yandex.net/management/v1/counter/".$counterId."/offline_conversions/upload?client_id_type=CLIENT_ID&oauth_token=".$token;
                    
                    $yaInfo = getInfoYa($url,$token,$data,$boundary);
                    $yaInfo = json_decode($yaInfo["response"]["html"],true);
                    sent_Loop("Конверсия в Метрику: " .$yaInfo,0);
                }
                if($site != 'san-dez.ru' && $site != ''){
                    $metriks_id_schetchik = '98748423';
                    $token = "y0__xDautmVCBjSoDgghILquhMGIA76MivvUFRINzIychmJEuSkqw";
                    
                    $orders = "ClientID,Target,DateTime".PHP_EOL;		
                    $orders .= $yclid.",lead,".time().PHP_EOL;
                    $counterId = $metriks_id_schetchik;
                    $boundary = "7zDUQOAIAE9hEWoV";
                    $filename = 'data.csv';
                    $data = "--------------------------$boundary\x0D\x0A";
                    $data .= "Content-Disposition: form-data; name=\"file\"; filename=\"$filename\"\x0D\x0A";
                    $data .= "Content-Type: text/csv\x0D\x0A\x0D\x0A";
                    $data .= $orders . "\x0A\x0D\x0A";
                    $data .= "--------------------------$boundary--";
                    $url = "https://api-metrika.yandex.net/management/v1/counter/".$counterId."/offline_conversions/upload?client_id_type=CLIENT_ID&oauth_token=".$token;
                    
                    $yaInfo = getInfoYa($url,$token,$data,$boundary);
                    $yaInfo = json_decode($yaInfo["response"]["html"],true);
                    sent_Loop("Конверсия в Метрику: " .$yaInfo,0);
                    
                }
        
    }
    
    /*
    // Успешный ответ
    //http_response_code(200);
    echo json_encode([
        'success' => true,
        'message' => 'Заявка успешно отправлена!',
        'data' => [
            'name' => $finalData['name'],
            'phone' => $finalData['phone']
        ]
    ]);
    */
            
        /*    
        $sql2 = "SELECT * FROM tg_bot";
        if($conn->query($sql2)){
            $result = $conn->query($sql2); 
        
            foreach($result as $row){
                 
                $chat_id = $row["chat_id"];
                //sendTelegram(array('chat_id' => $chat_id,'text' => $message));
                //sendTelegram($message,$chat_id);
            }
        }*/
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