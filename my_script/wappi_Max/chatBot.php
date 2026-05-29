<?php


///-72256037346650

$token = '35042f12fc9bb52b979d15404ef65c2fa8ce1867';
$profile_id = '2bbed96c-4994';

$mes = $_GET['mes'];
$chat_id = '-72256037346650';

function recuest_api($token,$profile_id,$mes,$chat_id){

    $array = array(
        'body'  => $mes,
        'chat_id' => $chat_id
    );
    $postParams = json_encode($array);
    $url_api = 'https://wappi.pro/maxapi/sync/message/send?profile_id='.$profile_id;


    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => $url_api,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $postParams,
        CURLOPT_HTTPHEADER => array( 'Authorization: '.$token ),
    ));
   
    $response = curl_exec($curl);

    curl_close($curl);  
    return json_decode($response, true);
}


recuest_api($token,$profile_id,$mes,$chat_id);

























