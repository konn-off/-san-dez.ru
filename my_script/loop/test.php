<?php
/*
Описание токена: Notice
Идентификатор токена: nnotm3bx4tdjjf53bmxd8jj6ae
Токен доступа: z7yik7i1i3yifdywyd3xf97t9c

https://san-dez.loop.ru/san-dez/channels/88edb268943c247ff67123796a7e9cf1
*/

/*
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://san-dez.loop.ru/api/v4/channels',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Accept: application/json',
    'Authorization: Bearer z7yik7i1i3yifdywyd3xf97t9c'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
print_r ( $response );
*/


function sent_mes($mess,$channel_id){
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://san-dez.loop.ru/api/v4/posts',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
          "channel_id": "'.$channel_id.'",
          "message": "'.$mess.'"
        }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Accept: application/json',
        'Authorization: Bearer z7yik7i1i3yifdywyd3xf97t9c'
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    echo $response;
}



$mess = '123Первое тестовое сообщение';
$channel_id = 'c3akro5iypyxjjtna1b664yxpe';
sent_mes($mess,$channel_id);

?>