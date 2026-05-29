<?php
//nV5P7d1JexIxE2_cHv9op4K6-tRzfwTKzc4H3paEZjnYDZ-7lB2QGuNIMI0HJCyy
$token = 'ZPae6I71gBvQvgyb8WM6MQ1z4BHEVaZfPfQwpAJUrCtlh9mr9shomwXg083fFah3';

$dialogId = 'nV5P7d1JexIxE2_cHv9op4K6-tRzfwTKzc4H3paEZjnYDZ-7lB2QGuNIMI0HJCyy';

$getParams = [
        'token'  => $token,
        'dialogId'  => $dialogId,
        'pageSize'  => 100
    ];

    $ch = curl_init('https://api.teletype.app/public/api/v1/messages?' . http_build_query($getParams));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    
    $res = curl_exec($ch);
    
    curl_close($ch);
    
    //echo $html;
    
    //Обратная конвертация (ответ так же получен в формате JSON)
    $res = json_decode($res, true);
    
    print_r($res);
?>