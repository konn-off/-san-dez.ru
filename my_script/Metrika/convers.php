<?php
//SELECT `ycid` FROM `all_leads` WHERE `id` > 8415 && `source`='Telegram' && `ycid` !='' && `povtor_lead` = 0 || `id` > 8415 && `source`='MAX' && `ycid` !='' && `povtor_lead` = 0

//$token = "y0__xDautmVCBjSoDgghILquhMGIA76MivvUFRINzIychmJEuSkqw"; // дезинфекция-клопов-тараканов.рф
//$token = "y0_AgAAAAB2YcxHAAz9CQAAAAEc8EgpAAAeTMYl9JZAh5sHnEl8n_Hpf8_gFg"; // san-dez
if($site=='san-dez.ru' || $site==''){
    $metriks_id_schetchik = '97574764';
}
if($site=='xn-----8kcaaiejjavmb1acem4amnaho2a2c1b6c2p.xn--p1ai'|| $site=='xn-----8kcaaiejjavmb1acem4amnaho2a2c1b6c2p.xn--p1a' || $site == 'дезинфекция-клопов-тараканов.рф' || $site == 'https://дезинфекция-клопов-тараканов.рф'){
    $metriks_id_schetchik = '98748423';
}            
            
$yclid = 1749548647642322299;
$metriks_id_schetchik = 98748423;

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



if(isset($_GET['f'])){
    $metriks_id_schetchik = 98748423;
    $token = "y0__xDautmVCBjSoDgghILquhMGIA76MivvUFRINzIychmJEuSkqw"; // дезинфекция-клопов-тараканов.рф
    //$token = "y0_AgAAAAB2YcxHAAz9CQAAAAEc8EgpAAAeTMYl9JZAh5sHnEl8n_Hpf8_gFg"; // san-dez
    
    $conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
    if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
    //echo "Подключение успешно установлено";
            
    $sql = "SELECT * FROM all_leads WHERE id > 8415 && source='Telegram' && ycid !='' && povtor_lead = 0 || id > 8415 && source='MAX' && ycid !='' && povtor_lead = 0";
    if($conn->query($sql)){
        $result = $conn->query($sql); 
        if($result->num_rows != 0){
            foreach($result as $row){
                $yclid = $row['ycid'];        
                
                $orders = "ClientID,Target,DateTime".PHP_EOL;		
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
        
                echo 'Отправили конверсию<br>';
                $yaInfo = getInfoYa($url,$token,$data,$boundary);
                $yaInfo = json_decode($yaInfo["response"]["html"],true);
                echo '<br><br>';
            }
        }
    }
    
    
            //echo 'Отправили конверсию<br><br>';
            //$yaInfo = getInfoYa($url,$token,$data,$boundary);
            //$yaInfo = json_decode($yaInfo["response"]["html"],true);
        
}































?>