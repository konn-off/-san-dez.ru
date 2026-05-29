<?

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






$conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }


//CRM
$url = 'https://ru.dez-crm.ru/backend/api/roistat/exchange/all?projectNumber=';
$id_proect = 257603;


//roistat
$api = "0e40c56e395b38087d5d656e162152b7";
//$api = "02712ee9ebfe890157cea3e83084992a";
$project = "257603";

$col = 0;
$col_roistat =0;
$col_roistat_nado =0;
$col_roistat_creat =0;
$col_roistat_obn =0;
$col_roistat_nan =0;

function status_order ($status) {
    if($status == 1){ $status_lead = 'Новые звонки Mango'; }
    if($status == 8){ $status_lead = 'Дубликат'; }
    if($status == 2){ $status_lead = 'Взято в работу'; }
    if($status == 3){ $status_lead = 'Спам-Повторный звонок'; }
    if($status == 5){ $status_lead = 'Автодозвон'; }
    if($status == 4){ $status_lead = 'Коллбек'; }
    if($status == -9){ $status_lead = 'Выполненная'; }
    if($status == -99){ $status_lead = 'Отклоненная'; }
    if($status == -1){ $status_lead = 'Оформленная'; }
    if($status == 6){ $status_lead = 'Не оформлен'; }
    return $status_lead;
}


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



$curl = curl_init();

curl_setopt_array($curl, array(
    CURLOPT_URL => $url.$id_proect,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array("content-type: application/json"),
));

$response = json_decode(curl_exec($curl), 1);
$err = curl_error($curl);

curl_close($curl);
//print_r($response);
echo count($response['orders']).'<br><br>';
for ($i = 0; $i <= count($response['orders']); $i++) {
    
    $id_crm = $response['orders'][$i]['id'];
    echo 'id_crm - '.$id_crm.'<br>';
    $status = $response['orders'][$i]['status'];
    if($id_crm !='' ){
        $price = $response['orders'][$i]['price'];
        $cost = $response['orders'][$i]['cost'];
        $marza = $price-$cost;
        if($cost == ''){$cost=0;}else{$cost = round($cost);}
        $date_create_t = $response['orders'][$i]['date_create'];
        $date_create_f = date("d.m.Y H:i:s",$date_create_t);
        $manager_id = $response['orders'][$i]['manager_id'];
        $status_lead = status_order ($response['orders'][$i]['status']);
        
        $city = $response['orders'][$i]['fields']['TOWN'];
        $pest = $response['orders'][$i]['fields']['PEST'];
        
        $sql = "SELECT * FROM all_leads WHERE id_crm = '$id_crm'";
        $result = $conn->query($sql);
        
        echo 'в базе сделка с срм_ид - '.$result->num_rows.'<br>';
        if($result->num_rows != 0){ 
            $row = $result->fetch_array();
            
            $id_lead = $row['id']; //echo 'id_lead - '.$id_lead.'<br>';
            $status_lead_base = $row['status_lead']; //echo 'status_lead_base - '.$status_lead_base.'<br>';
            $status_base = $row['status']; //echo 'status_base - '.$status_base.'<br>';
            $price_base = $row['price']; //echo 'price_base - '.$price_base.'<br>';
            $cost_base = $row['cost']; //echo 'cost_base - '.$cost_base.'<br>';
            $date_create_t_base = $row['date_create_t']; //echo 'date_create_t_base - '.$date_create_t_base.'<br>';
            $date_create_f_base = $row['date_create_f']; //echo 'date_create_f_base - '.$date_create_f_base.'<br>';
            $manager_id_base = $row['manager_id']; //echo 'manager_id_base - '.$manager_id_base.'<br>';
            $city_base = $row['city']; //echo 'city_base - '.$city_base.'<br>';
            $pest_base = $row['pest']; //echo 'pest_base - '.$pest_base.'<br>';
            $yclid = $row['ycid'];
            $site = $row['site'];
            
            if( $status_base != $status || $cost_base != $cost || $price_base != $price || $date_create_t_base == '' || $date_create_f_base == '' || $manager_id_base != $manager_id || $city_base != $city || $pest_base != $pest ) {
                
                
                echo $status_base.' = '.$status.'<br>';
                echo $cost_base.' = '.$cost.'<br>';
                echo $price_base.' = '.$price.'<br>';
                echo $date_create_t_base.' = <br>';
                echo $date_create_f_base.' = <br>';
                echo $manager_id_base.' = '.$manager_id.'<br>';
                echo $city_base.' = '.$city.'<br>';
                echo $pest_base.' = '.$pest.'<br>';
    
    
                $sql = "UPDATE all_leads SET status_lead='$status_lead', status='$status', manager_id='$manager_id', cost='$cost', price='$price', date_create_t='$date_create_t', date_create_f='$date_create_f', city='$city', pest='$pest' WHERE id='$id_lead'"; $conn->query($sql);
                if($conn->query($sql)){ echo "Данные успешно добавлены"; $col++; } else { echo "Ошибка: " . $conn->error; }
            }
            
            
            if($status == -1 && $yclid != '' && $status_base != -1 || $status == 6 && $yclid != '' && $status_base != 6 || $status == -9 && $yclid != '' && $status_base != -9){
                
                if($site=='san-dez.ru'){$counterId = 97574764; $kval_lead = 'kval_lead';}//id счетчика
                if($site=='дезинфекция-клопов-тарака' || $site=='xn-----8kcaaiejjavmb1acem'){$counterId = 98748423;}
                
                $token = "y0_AgAAAAB2YcxHAAz9CQAAAAEc8EgpAAAeTMYl9JZAh5sHnEl8n_Hpf8_gFg";
                $orders = "ClientID,Target,DateTime,Price".PHP_EOL;		
                
                
                //ym(97574764,'reachGoal','test_lead')
                $orders .= $yclid.",kval_lead,".$row['date'].",0".PHP_EOL;
                
                if($status==-1){
                  $orders .= $yclid.",oform_lead,".$row['date'].",0".PHP_EOL;
                }
                
                if($status==-9){
                  $orders .= $yclid.",sale_lead,".$row['date'].",".$marza.PHP_EOL;
                }    
                
                //$counterId = 97574764; //id счетчика
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
                
                sent_Loop($orders,0);
                sent_Loop($yaInfo,0);
                //send_notification2 ($orders);
                //send_notification2 ($yaInfo);
            }
            
            
        }
        else {// нет в базе сделкс с срм_ид ищем номер тел в Роистат
            if($col_roistat<20){
                $link = "https://cloud.roistat.com/api/v1/project/orders/".$id_crm."/info?key=".$api."&project=".$project;
        
                $curl = curl_init();
        
                curl_setopt_array($curl, array(
                    CURLOPT_URL => $link,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "GET",
                    CURLOPT_HTTPHEADER => array("content-type: application/json"),
                ));
        
                $res = json_decode(curl_exec($curl), 1);
                $err = curl_error($curl);
                //curl_close($curl);
        
                if(isset($res['order']['client_phones'][0])){ //Нашли в Роистат сделку и телефон
                    $phone = $res['order']['client_phones'][0];
                    echo 'phone - '.$phone; //телефон
                    $host = $res['order']['visits']['host'];
                    $url_conv = $res['order']['visits']['landing_page'];
                    $roistat = $res['order']['visit_id'];
                    $yclid = $res['order']['visit']['visit_fields']['yandex_metrica_clientid'];
                    $direct_source = $res['order']['visit']['marker_info']['1']['marker'];
                    $campaign = $res['order']['visit']['marker_info']['2']['alias'];
                    $content = $res['order']['visit']['marker_info']['3']['marker'];
                    $term = $res['order']['visit']['marker_info']['5']['marker'];
                    
                    if($status == 8){$povtor_lead = 1;}else{$povtor_lead = 0;}
                    
                    $sql3 = "SELECT * FROM all_leads WHERE phone = '$phone' && povtor_lead=0";
                    $result = $conn->query($sql3);
                    $row = $result->fetch_array();

                    if($result->num_rows == 0){ // Если сделки в базе нет, создаем
                        $name_data = "(date, name_leads, phone, site, url, roistat, ycid, utm_source, utm_campaign, utm_content, utm_term, source, id_crm, status_lead, status, manager_id, cost, price, date_create_t, date_create_f, city, pest, povtor_lead )";
                        $dataddd = "('".$date_create_t."', 'Из Роистата', '".$phone."', '".$host."', '".$url_conv."', '".$roistat."', '".$yclid."', 'yandex_".$direct_source."', '".$campaign."', '".$content."', '".$term."', 'создано в Роистат', '".$id_crm."', '".$status_lead."', '".$status."', '".$manager_id."', '".$cost."', '".$price."', '".$date_create_t."', '".$date_create_f."', '".$city."', '".$pest."', '".$povtor_lead."')";
                                    
                        $sql4 = "INSERT INTO all_leads $name_data VALUES $dataddd"; 
                        if($conn->query($sql4)){ echo "Сделка создана<br>"; $col_roistat_creat++; } else { echo "Ошибка: " . $conn->error; }
                    }
                    if($result->num_rows != 0 && $row['id_crm'] != '' && $row['id_crm'] != $id_crm){ // Если сделка в базе с номером есть, но id_crm не пусто, создаем сделку - повторная продажа
                        $name_data = "(date, name_leads, phone, site, url, roistat, ycid, utm_source, utm_campaign, utm_content, utm_term, source, id_crm, status_lead, status, manager_id, cost, price, date_create_t, date_create_f, city, pest, povtor_lead )";
                        $dataddd = "('".$date_create_t."', 'Из Роистата Повторная сделка', '".$phone."', '".$host."', '".$url_conv."', '".$roistat."', '".$yclid."', 'yandex_".$direct_source."', '".$campaign."', '".$content."', '".$term."', 'создано в Роистат Повторная сделка', '".$id_crm."', '".$status_lead."', '".$status."', '".$manager_id."', '".$cost."', '".$price."', '".$date_create_t."', '".$date_create_f."', '".$city."', '".$pest."', '".$povtor_lead."')";
                                    
                        $sql5 = "INSERT INTO all_leads $name_data VALUES $dataddd"; 
                        if($conn->query($sql5)){ echo "Сделка создана Повторная сделка<br>"; $col_roistat_creat++; } else { echo "Ошибка: " . $conn->error; }
                    }
                    else {
                        $sql = "UPDATE all_leads SET id_crm='$id_crm', status_lead='$status_lead', status='$status', manager_id='$manager_id', cost='$cost', price='$price', date_create_t='$date_create_t', date_create_f='$date_create_f', city='$city', pest='$pest' WHERE phone=$phone && povtor_lead=0"; $conn->query($sql);
                        if($conn->query($sql)){ echo "Данные успешно добавлены<br>"; $col++; $col_roistat_obn++; } else { echo "Ошибка: " . $conn->error; }
                    }
            
            
                    
                    
                    
                }else{echo 'НЕ Нашли в Роистат сделку и телефон'; $col_roistat_nan++;
                    echo 'date_create - '.$response['orders'][$i]['date_create'].' - '.date("d.m.Y H:i:s",$response['orders'][$i]['date_create']).'<br>';
                    echo 'status - '.status_order ($response['orders'][$i]['status']).'<br>';
                    echo 'price - '.$response['orders'][$i]['price'].'<br>';
                    echo 'manager_id - '.$response['orders'][$i]['manager_id'].'<br>';
                    echo 'cost - '.$response['orders'][$i]['cost'].'<br>';
                    echo 'pest - '.$pest.'<br>';
                    echo 'city - '.$city.'<br>';
                }
                $col_roistat++;
            }else{$col_roistat_nado++;}
        }
    }
    echo '<br><br>';
}

if($col != 0){
$message = '
Обновлено сделок - '.$col.'
Запросов в Роистат - '.$col_roistat.'
в Роистат не найдено - '.$col_roistat_nan.'
Создано из Роистат - '.$col_roistat_creat.'
Сделок надо искать в Роистат - '.$col_roistat_nado;

sent_Loop($message,0);            
    //send_notification2 ($message);
}
?>