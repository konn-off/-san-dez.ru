<?php 
$token = '35042f12fc9bb52b979d15404ef65c2fa8ce1867';
$profile_id = '6cce2eb5-9d11';
$url_api = 'https://wappi.pro';

$phone = $_GET['phone'];
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
//san-dez.ru/my_script/wappi/test_api.php?type_mes=get_mes&phone=79299850300
//san-dez.ru/my_script/wappi/test_api.php?type_mes=get_mes_id&id_mes=01C8CDC3F44827AA0142740D0BBC7F11
function recuest_api($token,$profile_id,$url_file,$phone,$mes,$type_mes,$id_mes,$caption,$file_name){
   
   if($type_mes=='get_mes'){ 
      $GETPOST = 'GET';
      $postParams = '';
      $getParams = [ 'profile_id'  => $profile_id, 'chat_id'  => $phone ];
      $url_api = 'https://wappi.pro/api/sync/messages/get?'.http_build_query($getParams);
         //https://wappi.pro/api/sync/messages/get?profile_id={{profile_id}}&chat_id=79115576367&limit=1&date=2019-11-02T23:16:58&offset=0&order=desc
   }
   
   if($type_mes=='get_mes_id'){ 
      $GETPOST = 'GET';
      $postParams = '';
      $getParams = [ 'profile_id'  => $profile_id, 'message_id'  => $id_mes ];
      $url_api = 'https://wappi.pro/api/sync/messages/id/get?'.http_build_query($getParams);
         //https://wappi.pro/api/sync/messages/get?profile_id={{profile_id}}&chat_id=79115576367&limit=1&date=2019-11-02T23:16:58&offset=0&order=desc
   }
   
   if($type_mes=='get_media'){ 
      $GETPOST = 'GET';
      $postParams = '';
      $getParams = [ 'profile_id'  => $profile_id, 'message_id'  => $id_mes ];
      $url_api = 'https://wappi.pro/api/sync/message/media/download?'.http_build_query($getParams);
         //https://wappi.pro/api/sync/messages/get?profile_id={{profile_id}}&chat_id=79115576367&limit=1&date=2019-11-02T23:16:58&offset=0&order=desc
   }
   
   if($type_mes=='file'){  
      $GETPOST = 'POST';
      $postParams = '{
         "url":"'.$url_file.'",
         "caption": "'.$caption.'",
         "file_name": "'.$file_name.'",
         "recipient": "'.$phone.'"
      }';
      $url_api = 'https://wappi.pro/api/sync/message/file/url/send?profile_id='.$profile_id;
   } 

   if($type_mes=='text'){ 
      $GETPOST = 'POST';
      /*$postParams = '{
         "body":"'.$mes.'",
         "recipient":"'.$phone.'"
      }';*/
      
      $array = array(
         'body'  => $mes,
         'recipient'  => $phone
      );
      $postParams = json_encode($array);

      $url_api = 'https://wappi.pro/api/sync/message/send?profile_id='.$profile_id;
   }
   
   if($type_mes=='reaction'){ 
      $GETPOST = 'POST';
      $postParams = '{
         "body":"'.$mes.'",
         "message_id":"'.$id_mes.'"
      }';
      $url_api = 'https://wappi.pro/api/sync/message/reaction?profile_id='.$profile_id;
   }
   
   if($type_mes=='read'){ 
      $GETPOST = 'POST';
      $postParams = '{
         "message_id":"'.$id_mes.'"
      }';
      $url_api = 'https://wappi.pro/api/sync/message/mark/read?profile_id='.$profile_id.'&mark_all=true';
   }
   
   if($type_mes=='reply'){ 
      $GETPOST = 'POST';
      $postParams = '{
         "body":"'.$mes.'",
         "message_id":"'.$id_mes.'"
      }';
      $url_api = 'https://wappi.pro/api/sync/message/reply?profile_id='.$profile_id;
   }
   
   if($type_mes=='delete'){ 
      $GETPOST = 'POST';
      $postParams = '{
         "message_id":"'.$id_mes.'"
      }';
      $url_api = 'https://wappi.pro/api/sync/message/delete?profile_id='.$profile_id;
   }
   
   if($type_mes=='edit'){ 
      $GETPOST = 'POST';
      $postParams = '{
         "body":"'.$mes.'",
         "message_id":"'.$id_mes.'"
      }';
      $url_api = 'https://wappi.pro/api/sync/message/edit?profile_id='.$profile_id;
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




$mes = 'Строка1
Строка 2 

Строка 3';


/*$mes = 'Строка1';*/
$phone = '79521716699';

if(isset($_GET['type_mes'])){
$data=recuest_api($token,$profile_id,$url_file,$phone,$mes,$type_mes,$id_mes,$caption,$file_name);
print_r($data);
}













//echo '<video controls><source type="video/mp4" src="'.$data['file_link'].'"/></video>';



?>
