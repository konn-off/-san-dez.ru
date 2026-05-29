<?php
//$token = '54ed3ea058c6875d73478b8b3cad2c62024221ec';  san-dez.ru/my_script/wappi_Max/Api_Max.php?type_mes=text&phone=26931546
//$profile_id = 'ee64083d-37b7';
$token = '35042f12fc9bb52b979d15404ef65c2fa8ce1867';
$profile_id = '2bbed96c-4994';
$url_api = 'https://wappi.pro';

$phone = preg_replace("/[^0-9]/", '', $_GET['phone']);
//$mes = str_replace(array("\r\n", "\r", "\n"), "<br>", $_GET['mes']); 
$chat_id = $_GET['chat_id'];
$mes = $_GET['mes'];
$type_mes = $_GET['type_mes']; 
$id_mes = $_GET['id_mes'];
$caption = $_GET['caption'];  //подпись к файлу
$file_name = $_GET['file_name'];
$url_file = $_GET['url_file']; 

///file (Отправить изображение, видео или документ) 
///text (Отправить тест)
///reaction (Отправить реакцию на сообщение) 
///read (Отметить сообщение прочитанным) 
///reply (Ответить на сообщение) 
///delete (Удалить сообщение) 
///edit (Изменить сообщение)
///get_mes (Получить сообщения из чата)
//get_mes_id (Получить сообщение по id)
//print_r($_GET);
//https://san-dez.ru/my_script/wappi/api.php?phone=79521716699&type_mes=file&caption=Это подпись к файлу&file_name=Name_file.png&url_file=https://png.pngtree.com/png-clipart/20201208/big/pngtree-saint-nicholas-day-cartoon-snowflake-streamer-gift-png-image_5544807.png


/*** Отправляем увеомление в Телеграм МНЕ ***/
function send_notification2 ($message){
    $token = "6843410151:AAEztaRwqsdj2d3vKhBxVKwkcrIqzeq4YOM"; //наш токен от telegram bot -а
    $chatid = "608866610";// ИД чата telegrm
    $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($message));
}



function recuest_api($token,$profile_id,$url_file,$phone,$mes,$type_mes,$id_mes,$caption,$file_name,$chat_id){

   if($type_mes=='get_mes'){ 
      $GETPOST = 'GET';
      $postParams = '';
      $getParams = [ 'profile_id'  => $profile_id, 'chat_id'  => $chat_id, 'limit' => 100 ];
      $url_api = 'https://wappi.pro/maxapi/sync/messages/get?'.http_build_query($getParams);
         //https://wappi.pro/api/sync/messages/get?profile_id={{profile_id}}&chat_id=79115576367&limit=1&date=2019-11-02T23:16:58&offset=0&order=desc
   }
   
   if($type_mes=='get_mes_id'){ 
      $GETPOST = 'GET';
      $postParams = '';
      $getParams = [ 'profile_id'  => $profile_id, 'message_id'  => $id_mes ];
      $url_api = 'https://wappi.pro/maxapi/sync/messages/id/get?'.http_build_query($getParams);
         //https://wappi.pro/api/sync/messages/get?profile_id={{profile_id}}&chat_id=79115576367&limit=1&date=2019-11-02T23:16:58&offset=0&order=desc
   }
   
   if($type_mes=='get_media'){ 
      $GETPOST = 'GET';
      $postParams = '';
      $getParams = [ 'profile_id'  => $profile_id, 'message_id'  => $id_mes ];
      $url_api = 'https://wappi.pro/maxapi/sync/message/media/download?'.http_build_query($getParams);
         //https://wappi.pro/api/sync/messages/get?profile_id={{profile_id}}&chat_id=79115576367&limit=1&date=2019-11-02T23:16:58&offset=0&order=desc
   }
   
   if($type_mes=='file'){ 
      $GETPOST = 'POST';
      $postParams = '{
         "url":"'.$url_file.'",
         "caption": "'.$caption.'",
         "file_name": "'.$file_name.'",
         "recipient": "'.$phone.'",
         "chat_id" => "'.$chat_id.'"
      }';
      $url_api = 'https://wappi.pro/maxapi/sync/message/file/url/send?profile_id='.$profile_id;
   } 
   
   if($type_mes=='text'){ 
      $GETPOST = 'POST';
      /*$postParams = '{
         "body":"'.$mes.'",
         "recipient":"'.$phone.'"
      }';*/
      $array = array(
         'body'  => $mes,
         'recipient'  => $phone,
         'chat_id' => $chat_id
      );
      $postParams = json_encode($array);
      $url_api = 'https://wappi.pro/maxapi/sync/message/send?profile_id='.$profile_id;
   }
   
   if($type_mes=='reaction'){ 
      $GETPOST = 'POST';
      $postParams = '{
         "body":"'.$mes.'",
         "message_id":"'.$id_mes.'"
      }';
      $url_api = 'https://wappi.pro/maxapi/sync/message/reaction?profile_id='.$profile_id;
   }
   
   if($type_mes=='read'){ 
      $GETPOST = 'POST';
      $postParams = '{
         "message_id":"'.$id_mes.'"
      }';
      $url_api = 'https://wappi.pro/maxapi/sync/message/mark/read?profile_id='.$profile_id;//&mark_all=true
   }
   
   if($type_mes=='reply'){ 
      $GETPOST = 'POST';
      $postParams = '{
         "body":"'.$mes.'",
         "message_id":"'.$id_mes.'"
      }';
      $url_api = 'https://wappi.pro/maxapi/sync/message/reply?profile_id='.$profile_id;
   }
   
   if($type_mes=='delete'){ 
      $GETPOST = 'POST';
      $postParams = '{
         "message_id":"'.$id_mes.'"
      }';
      $url_api = 'https://wappi.pro/maxapi/sync/message/delete?profile_id='.$profile_id;
   }
   
   if($type_mes=='edit'){ 
      $GETPOST = 'POST';
      $postParams = '{
         "body":"'.$mes.'",
         "message_id":"'.$id_mes.'"
      }';
      $url_api = 'https://wappi.pro/maxapi/sync/message/edit?profile_id='.$profile_id;
   }
      
   $curl = curl_init();

   curl_setopt_array($curl, array(
      CURLOPT_URL => $url_api,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => $GETPOST,
      CURLOPT_POSTFIELDS => $postParams,
      CURLOPT_HTTPHEADER => array( 'Authorization: '.$token ),
   ));
   
   $response = curl_exec($curl);

   curl_close($curl);  
   return json_decode($response, true);
}




$conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
   if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
   //echo "Подключение успешно установлено";



if($type_mes=='get_mes'){ 

   
   
   
   if($chat_id=='' && $phone != ''){
      $sql_idChatMax = "SELECT * FROM all_leads WHERE phone = $phone LIMIT 1";
      $result = $conn->query($sql_idChatMax);
      $row = $result->fetch_array();
      $chat_id = $row['chat_id_max'];
   }
   $data=recuest_api($token,$profile_id,$url_file,$phone,$mes,$type_mes,$id_mes,$caption,$file_name,$chat_id);
   $data = $data['messages'];
   
   $reaction_mes = array();

   for ($n = 0; $n < count($data); $n++) {
      if($data[$n]['type']=='reaction'){
         $ffff=$data[$n]['stanzaId'];
         $reaction_mes[$ffff] = $data[$n]['body'];
         unset($data[$n]);
      }
   }
   $data = array_values($data);
   //print_r($reaction_mes);
   
   $name = ''; $ava = ''; $phone = ''; $file = ''; $mess = ''; $mes_name_men='';
   
   
   
   for ($n = 0; $n < count($data); $n++) {
      if($data[$n]['fromMe']==NULL){
         $name = $data[$n]['senderName'];
         //$ava = $data[$n]['client']['avatar'];
         $phone = preg_replace('/[^0-9]/', '', $data[$n]['from']);
      }
      
      $ids = $data[$n]['id'];
      /*$sql6 = "SELECT * FROM mes_men WHERE ids = '".$ids."' && name_men != ''";
      $result = $conn->query($sql6);
      if($result->num_rows != 0){
         $row = $result->fetch_array();
         $mes_name_men = '<p class="mes_name_men" data_idTG = "'.$row['id_men'].'"><span>'.$row['name_men'].'</span></p>';
      }else{
         $mes_name_men='';
      }*/
      
      
      if($data[$n]['type']=='vcard' && $data[$n]['isDeleted']==NULL){
         $file = $file. $data[$n]['body']['display_name'].'<br><br>'.$data[$n]['body']['phone']; 
      }
         
      if($data[$n]['type']=='image' && $data[$n]['isDeleted']==NULL){
         $file = $file.'<img src="'.$data[$n]['s3Info']['url'].'" class="wz_mes_images"><p>'.$data[$n]['body']['caption'].'</p>';
      }
      if($data[$n]['type']=='audio' && $data[$n]['isDeleted']==NULL){
         $file = $file.'<audio src="'.$data[$n]['s3Info']['url'].'"  controls="controls">
            Ваш браузер не поддерживает элемент <code>audio</code>.
         </audio><div class="transcriptAudio">';
         
         
         
         $sql = "SELECT * FROM transcryptAudio WHERE id_mes = '".$ids."'";
         if($conn->query($sql)){
            $result = $conn->query($sql); 
            if($result->num_rows != 0){
               $row = $result->fetch_array();
               
               $file = $file.$row['text'];
            }else{
               /*//send_notification2 ($data[$n]['s3Info']['url']);
               $name_data = "(id_mes, url_voice)";
               $data = "('".$ids."', '".$data[$n]['s3Info']['url']."')";
                          
               $sql2 = "INSERT INTO transcryptAudio $name_data VALUES $data";
               $conn->query($sql2);
               //$last_id = $conn->insert_id;
               
               
               $data = [
                   'id_mes' => $ids//,
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
               
               $file = $file.$response;
               
               $sql3 = "UPDATE transcryptAudio SET text='".$response."' WHERE id_mes='".$ids."'";
               $conn->query($sql3);*/
               
               /*$name_data = "(id_mes, text)";
               $data = "('".$ids."', '".$response."')";
                          
               $sql2 = "INSERT INTO transcryptAudio $name_data VALUES $data"; 
               if($conn->query($sql2)){
                  
               }*/

            }
         }
         
         
         
         $file = $file.'</div>';
      }
      if($data[$n]['type']=='video' && $data[$n]['isDeleted']==NULL){
         $data_id=recuest_api($token,$profile_id,$url_file,$phone,$mes,'get_media',$ids,$caption,$file_name);
         $file = $file.'<video controls width="100%">
         <source src="'.$data_id['file_link'].'" >
            Ваш браузер не поддерживает встроенные видео :(
         </video>';
      }
      
      if($data[$n]['type']=='sticker' && $data[$n]['isDeleted']==NULL){
         $file = $file.'<img src="'.$data[$n]['s3Info']['url'].'" class="wz_mes_images"><p>'.$data[$n]['body']['caption'].'</p>';
      }
      
      if($data[$n]['type']=='location' && $data[$n]['isDeleted']==NULL){
         //Location: 56.129196, 37.504322
         $location = str_replace('Location: ', '', $data[$n]['body']);
         $location = explode(',',$location);
         
         $Latitude = trim($location[0]);
         $Longitude = trim($location[1]);
         
         $location1 = $Latitude.','.$Longitude;
         $location2 = $Longitude.','.$Latitude;
         $url_map = "https://yandex.ru/maps/?ll=".$location2."&mode=search&pt=".$location1."&sll=".$location2."&text=".$location1."&z=16.16";
         $file = $file."Геолокация: ".$data[$n]['body']['degreesLatitude'].", ".$data[$n]['body']['degreesLongitude']."<br><a href='".$url_map."' target='_blank'>https://yandex.ru/maps/</a>";
         //https://www.google.com/maps/search/?api=1&query=55.6268594,37.6514628
      }
      
      if($data[$n]['type']=='document' && $data[$n]['isDeleted']==NULL){//img/file_icon.png
         $file = $file.'<a href="'.$data[$n]['s3Info']['url'].'" target="_blank" ><img src="';
         if(!$data[$n]['body']['JPEGThumbnail']){
            $file = $file.'https://san-dez.ru/my_script/all_leads_save/img/pdf-donw.png';
         }else{
            $file = $file.'data:image/jpg;base64,'.$data[$n]['body']['JPEGThumbnail'];
         }
         $file = $file.'">'.$data[$n]['body']['fileName'].'</a>';
      }
      
      $mess=$mess. '<div id="'.$ids.'" class="';
      if($data[$n]['fromMe']==NULL){$mess=$mess. 'mes-client';}else{$mess=$mess. 'mes-manager';}
      $mess=$mess. '"><div class="menu_mes">...</div>'; 
      
      if($data[$n]['fromMe']==NULL && $data[$n]['isDeleted']==NULL){$mess=$mess.'<div class="menu_mes_spisok"><p>Ответить</p></div>'.$mes_name_men;}
      if($data[$n]['fromMe']!=NULL && $data[$n]['isDeleted']==NULL){$mess=$mess. '<div class="menu_mes_spisok"><p>Ответить</p><p>Редактировать</p><p>Удалить</p></div>'.$mes_name_men;}
      
      if($data[$n]['isReply']!=NULL){
         $idReply = $data[$n]['stanzaId'];
         $data_id=recuest_api($token,$profile_id,$url_file,$phone,$mes,'get_mes_id',$idReply,$caption,$file_name,$chat_id);
         $mess=$mess. '<a class="mes_reply" href="#'.$data_id['message']['id'].'"><span>'.$data_id['message']['senderName'].'</span>'.$data_id['message']['body'].'</a>'; 
      }
      
      if($data[$n]['type']=='text' && $data[$n]['isDeleted']==NULL){$mess=$mess.'<div class="mes_chat">'.str_replace(PHP_EOL, '<br>', $data[$n]['body']).'</div>';}
      
      if($data[$n]['isDeleted']!=NULL){$mess=$mess.'🚫 Сообщение было удалено';}
      
      $mess=$mess.$file.'<p class="date">';
      if($data[$n]['fromMe']==NULL){$mess=$mess. '<span>'.date('d.m H:i',substr($data[$n]['time'], 0, -3)).'</span><span>'; if($data[$n]['isEdited']=='1'){$mess=$mess. 'Изменено';}$mess=$mess. '</span>';}
      if($data[$n]['fromMe']==1){$mess=$mess. '<span></span><span>'.date('d.m H:i',substr($data[$n]['time'], 0, -3)).'</span>'; }
      $mess=$mess. '</p>';
      if($data[$n]['fromMe']==1){
         $mess=$mess. '<p class="status_mes"><span>';
         if($data[$n]['isEdited']=='1'){$mess=$mess. 'Изменено';} $mess=$mess. '</span><span>';
         if($data[$n]['delivery_status']=='read'){$mess=$mess. 'Просмотрено';}
         if($data[$n]['delivery_status']=='pending'){$mess=$mess. 'Отправляется';}
         if($data[$n]['delivery_status']=='error'){$mess=$mess. 'Ошибка при отправке';}
         if($data[$n]['delivery_status']=='delivered'){$mess=$mess. 'Доставлено';}
         if($data[$n]['delivery_status']=='temporary ban'){$mess=$mess. 'Заблокировано';}
         if($data[$n]['delivery_status']=='undelivered'){$mess=$mess. 'Не доставлено';}
         $mess=$mess. '</span></p>';
         //if($dialogId=='ioAGxq90hMk6n4wohPmjskNd3Q7xV04KIrN7YKPaR417_M_QfRBQUtEKjh5P9Tj_'){$mess=$mess.$data[$n]['id'];}
         
      }
      
      
      $mess=$mess. '</div>';
      
      if(isset($reaction_mes[$ids])){
         if($data[$n]['fromMe']==NULL){$mess=$mess. '<div class="mes-client_reaction">';}else{$mess=$mess. '<div class="mes-manager_reaction">';}       
          $mess=$mess.$reaction_mes[$ids].'</div>';
      }
 
      
      
      $file = '';
      
      
      /*
      echo 'id - '. $data[$n]['id'].'<br>';
      echo 'type - '. $data[$n]['type'].'<br>';
      echo 'from - '. $data[$n]['from'].'<br>';
      echo 'to - '. $data[$n]['to'].'<br>';
      echo 'fromMe - '. $data[$n]['fromMe'].'<br>';
      echo 'senderName - '. $data[$n]['senderName'].'<br>';
      echo 'time - '. $data[$n]['time'].'<br>';
      echo 'body - '. $data[$n]['body'].'<br>';
      echo 'stanzaId - '. $data[$n]['stanzaId'].'<br>';
      echo 'chatId - '. $data[$n]['chatId'].'<br>';
      echo 'isForwarded - '. $data[$n]['isForwarded'].'<br>';
      echo 'isReply - '. $data[$n]['isReply'].'<br>';
      echo 'caption - '. $data[$n]['caption'].'<br>';
      echo 'isRead - '. $data[$n]['isRead'].'<br>';
      echo 'delivery_status - '. $data[$n]['delivery_status'].'<br>';
      echo 's3Info - '. print_r($data[$n]['s3Info']).'<br>';
      echo 'poll_votes - '. $data[$n]['poll_votes'].'<br>';
      echo 'poll_options - '. $data[$n]['poll_options'].'<br>';
      echo 'poll_select_count - '. $data[$n]['poll_select_count'].'<br>';
      echo 'isEdited - '. $data[$n]['isEdited'].'<br>';
      echo 'isFromAPI - '. $data[$n]['isFromAPI'].'<br>';
      echo 'isDeleted - '. $data[$n]['isDeleted'].'<br>';
      echo 'isPinned - '. $data[$n]['isPinned'].'<br><br><br>';
      */
   }
   echo $name.':::'.$ava.':::'.$phone.':::'.$mess;
   //print_r($data);
}
//print_r(recuest_api($token,$profile_id,$url_file,$phone,$mes,$type_mes,$id_mes,$caption,$file_name));



if($type_mes=='text' || $type_mes=='reply'){
   
   $data=recuest_api($token,$profile_id,$url_file,$phone,$mes,$type_mes,$id_mes,$caption,$file_name,$chat_id);
   //print_r($data);
   $status = $data['status'];
   $message_id = $data['message_id'];
   $error = $data['error'];
   if($chat_id==''){
      $id_mes = $message_id;
      $data=recuest_api($token,$profile_id,$url_file,$phone,$mes,'get_mes_id',$id_mes,$caption,$file_name,$chat_id);
      $chat_id = $data['message']['chatId'];
      $sql4 = "UPDATE all_leads SET chat_id_max = '".$chat_id."' WHERE phone = '".$phone."'"; 
      $conn->query($sql4);
   }
   if($message_id!=''){
      echo 'ok';
      $sql4 = "UPDATE all_leads SET dialog_wiev = 0 WHERE chat_id_max = '".$chat_id."'"; 
      $conn->query($sql4);
   
   /*
      $id_men = $_GET['id_men']; $name_men = $_GET['name_men'];
      $name_data = "(ids, id_men, name_men)";
      $data = "('".$message_id."', '".$id_men."','".$name_men."')";
                       
      $sql = "INSERT INTO mes_men $name_data VALUES $data"; 
      if($conn->query($sql)){ 
         //echo "Данные успешно добавлены";
      } else { send_notification2 ("Ошибка SQL при отправки сообщения: " . $conn->error); }
*/
   }
   if($status == 'error'){
      echo $error;
   }


}



if($type_mes=='edit'){

$data=recuest_api($token,$profile_id,$url_file,$phone,$mes,$type_mes,$id_mes,$caption,$file_name,$chat_id);

}

if($type_mes=='delete'){

$data=recuest_api($token,$profile_id,$url_file,$phone,$mes,$type_mes,$id_mes,$caption,$file_name,$chat_id);

}

if($type_mes=='read'){ 
   $data=recuest_api($token,$profile_id,$url_file,$phone,$mes,$type_mes,$id_mes,$caption,$file_name,$chat_id); 
   $sql4 = "UPDATE all_leads SET dialog_wiev = 0 WHERE chat_id_max = '".$chat_id."'"; 
   $conn->query($sql4);
}


?>