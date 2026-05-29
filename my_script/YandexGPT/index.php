<?php

//Секретный ключ. Сохраните его, чтобы использовать в коде
//AQVNyIXey22hJDteZ0Nc5IoxgtFJ1fhBZvzf3JlA
//Идентификатор API-ключа
//aje8gnfcmrd14gtlspq3


//y0__xD_lboMGMHdEyDf6LnTFjCz8OmeCCx-GWsxchXK0tXEcnT5IxD3Q4zl

if (isset($_REQUEST['audio'])) {
    $audioFileName = $_REQUEST['audio'];
    $token = 'AQVNyIXey22hJDteZ0Nc5IoxgtFJ1fhBZvzf3JlA'; # IAM-токен
    $folderId = "b1gk16iujqbcpvv92p0s";//"aje8gnfcmrd14gtlspq3"; # Идентификатор каталога
    //$audioFileName = "https://wapi-uploads7d.storage.yandexcloud.net/95c2a15f-47f6/1cf47921-039c-4a7e-821c-265b6666847d.ogg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=YCAJEx61R4C7kz0v5oC6y60Gx%2F20260306%2Fru-central1%2Fs3%2Faws4_request&X-Amz-Date=20260306T115325Z&X-Amz-Expires=172800&X-Amz-SignedHeaders=host&response-content-disposition=inline%3B%20filename%3D%22fb950ce7-bfbd-44d7-9a30-3b00a233447b.ogg%22%3B%20filename%2A%3DUTF-8%27%27fb950ce7-bfbd-44d7-9a30-3b00a233447b.ogg&x-id=GetObject&X-Amz-Signature=851585c794be9d1255936c349b904524e09fd13086b9950629a59845205137f8";
    
    $file = fopen($audioFileName, 'rb');
    //$file = file_get_contents($file);
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://stt.api.cloud.yandex.net/speech/v1/stt:recognize?lang=ru-RU&folderId=${folderId}&format=oggopus");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Api-Key ' . $token));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
    
    curl_setopt($ch, CURLOPT_INFILE, $file);
    curl_setopt($ch, CURLOPT_INFILESIZE, filesize($audioFileName));
    $res = curl_exec($ch);
    curl_close($ch);
    $decodedResponse = json_decode($res, true);
    if (isset($decodedResponse["result"])) {
        echo $decodedResponse["result"];
    } else {
        echo "Error code: " . $decodedResponse["error_code"] . "\r\n";
        echo "Error message: " . $decodedResponse["error_message"] . "\r\n";
    }
    
    fclose($file);
}









?>