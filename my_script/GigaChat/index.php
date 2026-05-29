<?php


/*** Отправляем увеомление в Телеграм МНЕ ***/
function send_notification2 ($message){
    $token = "6843410151:AAEztaRwqsdj2d3vKhBxVKwkcrIqzeq4YOM"; //наш токен от telegram bot -а
    $chatid = "608866610";// ИД чата telegrm
    $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($message));
}



/*
Authorization Key передается в заголовке запроса на получение Access Token. (Токен действует 30 минут. После его нужно запрашивать снова)
Значение поля является результатом кодирования пары Client ID:Client Secret в base64

Authorization Key - MDE5YzBlYzAtNWMzMy03ZjgxLWE0MzItZmQ0MDZlNzg2MTMxOmYzNWMwOWNlLTUyYWMtNDI0ZC04NTk1LWM2MzU3MTNkN2Q2Ng==


Вы также можете использовать пару Client ID:Client Secret
Закодируйте пару Client ID:Client Secret в base64 и передавайте ее в заголовке запроса на получение Access Token

Client Secret - f35c09ce-52ac-424d-8595-c635713d7d66

Client ID - 019c0ec0-5c33-7f81-a432-fd406e786131

*/

function new_token(){
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://ngw.devices.sberbank.ru:9443/api/v2/oauth',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS => 'scope=SALUTE_SPEECH_PERS',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/x-www-form-urlencoded',
            'Accept: application/json',
            'RqUID: 3247264f-803f-48b6-bbaf-1f3414bc966e',
            'Authorization: Basic MDE5YzBlYzAtNWMzMy03ZjgxLWE0MzItZmQ0MDZlNzg2MTMxOmYzNWMwOWNlLTUyYWMtNDI0ZC04NTk1LWM2MzU3MTNkN2Q2Ng=='
      ),
    ));
    
    $response = curl_exec($curl);
    $responseData = json_decode($response, true);
    curl_close($curl);
    //echo $responseData['access_token'];
    
    $access_token = $responseData['access_token'];
    return $access_token;
}




function recognizeaudio($access_token,$request_file_id){
    //if(isset($_GET['ikl2'])){ ///Ставим задачу распознавать
    //$access_token = new_token();
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://smartspeech.sber.ru/rest/v1/speech:async_recognize',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
      "options": {
        "model": "general",
        "audio_encoding": "MP3",
        "language": "ru-RU"
      },
      "request_file_id": "'.$request_file_id.'"
    }\' \\',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Authorization: Bearer '.$access_token
      ),
    ));
    
    $response = curl_exec($curl);
    $responseData = json_decode($response, true);
    curl_close($curl);
    return $responseData['result']['id'];
    //echo $response;

}
///// {"status":200,"result":{"id":"f3fec892ab70e588ee5df339f3f92418","created_at":"2026-01-30T16:59:38.821491157+03:00","updated_at":"2026-01-30T16:59:38.821491273+03:00","status":"NEW"}}
///3e81c3e8bb0eaa0d3fd62de1a059d580




function resultaudio($access_token,$responseFileId){
    //if(isset($_GET['ikl'])){ ///Скачать результат
    
    
    // ID файла для скачивания
    //$responseFileId = 'd7611531-3d35-4c5f-9734-d160c7851d77'; // Замените на реальный ID файла
    
    // Токен авторизации
    //$access_token = new_token(); // Замените на ваш реальный токен
    
    // Формируем URL с параметром
    $url = 'https://smartspeech.sber.ru/rest/v1/data:download?response_file_id='.$responseFileId;
    
    // Инициализация cURL сессии
    $ch = curl_init();
    
    // Настройка параметров запроса
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true, // аналог флага -L
        
        // Установка заголовков
        CURLOPT_HTTPHEADER => [
            'Accept: application/octet-stream',
            'Authorization: Bearer ' . $access_token
        ]
    ]);
    
    // Выполнение запроса
    $response = curl_exec($ch);
    // Обработка ответа
        $responseData = json_decode($response, true);
        
        if(json_last_error() === JSON_ERROR_NONE) {
            //print_r($responseData);
            //echo count($responseData);
            for ($i = 0; $i < count($responseData); $i++) {
                echo "<p>" . $responseData[$i]['results'][0]['normalized_text']. "</p>";
            }
        } else {
            echo 'Ошибка при парсинге JSON';
        }
    
    // Закрытие сессии
    curl_close($ch);

}

///Array ( [0] => Array ( [results] => Array ( [0] => Array ( [text] => [normalized_text] => [start] => 0s [end] => 0s [word_alignments] => Array ( ) ) ) [eou] => 1 [emotions_result] => Array ( [positive] => 0 [neutral] => 1 [negative] => 0 ) [processed_audio_start] => 0s [processed_audio_end] => 3.273999872s [backend_info] => Array ( [model_name] => transcribation_hq [model_version] => M-03.007.00-transcribation_hq-02 [server_version] => 03.007.00-rh8-trt10-cuda12-01 ) [channel] => 0 [speaker_info] => Array ( [speaker_id] => -1 [main_speaker_confidence] => 0 ) [eou_reason] => ORGANIC [insight] => [person_identity] => Array ( [age] => AGE_NONE [gender] => GENDER_NONE [age_score] => 0 [gender_score] => 0 ) ) )



function statusaudio($access_token,$idfile){
    //if(isset($_GET['ikl3'])){ ///Статус задачи распознать
    //$access_token = new_token();
    $curl = curl_init();
    
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://smartspeech.sber.ru/rest/v1/task:get?id='.$idfile,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Bearer '.$access_token
      ),
    ));
    
    $response = curl_exec($curl);
    //echo $response;
    $responseData = json_decode($response, true);
    return $responseData['result']['response_file_id'];
    curl_close($curl);
    


}
////{"status":200,"result":{"id":"f3fec892ab70e588ee5df339f3f92418","created_at":"2026-01-30T16:59:38.821491+03:00","updated_at":"2026-01-30T16:59:39.331924+03:00","status":"DONE","response_file_id":"e2b0df12-b073-4cb1-8a62-a823d1a0e0b5"}}
///Возможные значения: [NEW, RUNNING, CANCELED, DONE, ERROR]

//Статус задачи. Статус DONE означает завершение обработки задачи.
///response_file_id":"d4d59d23-6fbf-4e52-891b-8e2ef6d33b8a"

//{"status":200,"result":{"id":"3e81c3e8bb0eaa0d3fd62de1a059d580","created_at":"2026-01-30T17:27:52.319429+03:00","updated_at":"2026-01-30T17:27:52.538864+03:00","status":"DONE","response_file_id":"7ca9e19a-2713-49d3-bf23-affc357a5f44"}}

//935d8595-485c-4ee5-8610-58050caf9964




// {"access_token":"eyJjdHkiOiJqd3QiLCJlbmMiOiJBMjU2Q0JDLUhTNTEyIiwiYWxnIjoiUlNBLU9BRVAtMjU2In0.LP4MnQlj-KU0hFY1gsWR9WzWBjR5SIpcW4WKoMjctTGErkDwC937X7U5fUipXQeZkj0GXdsTpLM7aDEESLoZVoD6KXsK0x6NBUkApgucjp9ZvV7ZIMOZPVPtRsa-OdqJ94TT8_Zaqwoj1eLOlhuz_znW3fi3ejwrf9FJNMJ_t09MCGnHcQWhcGorasZppN5aGxCXiadZ3gdcX81hE9E-yWKi8bWCiM9AaaVIWgenTLOqVPfKu_IyoUKBbBr6s0a0Tv5ENwdkiB1L8BrYCZ1sgnCOa2CBCewes-g4m4VvXwbq6PmuiGiZ5NsZckkcEFXmFgkdIIC9Xe5Myoj32LXjwg.eybgjCqszWzee6l8skYQHA.sKA9BUvr4GHwZTKlIPepVSI-h-V4enh8sPxT1iW3W3_DXpHfCDV5It4He4r2_svEIqFcwc4rswoXdseLd-sFj26Vg5kBgRh9fAylIGg6Bvd-Z1GY6nBp7_0SDBxSWb6Z1VhIawsGvwhXFgbyYK7x5s8-ULSX8eWnYruYyigQRNaXr2Z_yTcOZF0tFP5d8kOHaEi3hbwzeaYlJ0Lxd8Z-hzUKbO91_b1jMcumUY2-V2dbZFCgj8H4IVpfMTcw6AcIgNfaIUMrAnCBSP0jAQPq0xFwtqaltQ7OAZr4dJcYdJqHS_xmpB5_GbosZBZ_7XYNNv3GcUDj_SqJ1k6feIPgHb4UDjhFExALn8bod7HySA0t-hFGdGFvnTYb2zHRtzxzqCxcWTYwOOgTPoCOzSIgYo3GWEhdMOWROYCdFITLwWaXaS8ZYc5rxmTD9hPCVhH6bAI3fXMd3J6Kgal48WZ_FZrKxSSkIdYH-E8uN_M0jwWmbjrlHJI1RUAy9tfAS8FsW9n68GHGRy7CvCB9c-kuvx7hsiZNEHjarwdOi9HR4D5Yb4BXAm4MgqeXGOBHgFcP1t6ghWHaTqoEucxY7QTB1Shvp9fSXjgwJQhrfJJekniyXiF8HMK1iGqEG_A1FM7JFXhNtX3bXMf-2vL2moKPbSpwG6qZY8S4sZ0ieEEmOfm4F8gB8ZniLV9H_t-ZAGgTQd5kD5QIQ9KoiRTmRuCJUqoIXjUt64dRQ9mxql9G03g.5KlRer-5cYKD9xJqOAVuCSC7EruQawBOkfvmVvkm7MI","expires_at":1769780633540}












function uploadaudio($file){
    $access_token = new_token();
    
    $filePath='https://san-dez.ru/my_script/GigaChat/Example.ogg';
    
    // Инициализация cURL сессии
    $ch = curl_init();

    // Настройка параметров запроса
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://smartspeech.sber.ru/rest/v1/data:upload',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true, // аналог флага -L
        
        // Установка заголовков
        CURLOPT_HTTPHEADER => [
            'Content-Type: audio/ogg;codecs=opus',
            'Accept: application/json',
            'Authorization: Bearer '.$access_token // Замените <TOKEN> на ваш реальный токен
        ],
        
        // Установка POST данных (аудио файл)
        CURLOPT_POST => true,
        //CURLOPT_POSTFIELDS => file_get_contents($file['tmp_name']) //file_get_contents($filePath)
        CURLOPT_POSTFIELDS => file_get_contents($file)
        //CURLOPT_POSTFIELDS => readfile($file)
    ]);

    // Выполнение запроса
    $response = curl_exec($ch);
    

    
    // Проверка на ошибки
    if(curl_errno($ch)) {
        echo 'cURL error: ' . curl_error($ch);
    } else {
        // Обработка ответа
        $responseData = json_decode($response, true);
        
        if(json_last_error() === JSON_ERROR_NONE) {
            //print_r($responseData);
            // ставим задачу распознать аудио
            $request_file_id = $responseData['result']['request_file_id'];
            //echo '<br>$request_file_id = '.$request_file_id.'<br>';

            $idfile = recognizeaudio($access_token,$request_file_id);
            //echo '<br>$idfile = '.$idfile.'<br>';
            
            sleep(3);
            // проверяем статус
            //echo statusaudio($access_token,$idfile);
            $response_file_id = statusaudio($access_token,$idfile);
            //echo '<br>$response_file_id = '.$response_file_id.'<br>';

            // получаем текст
            echo resultaudio($access_token,$response_file_id);
        } else {
            echo 'Ошибка при парсинге JSON';
        }
    }
    
    // Закрытие сессии
    curl_close($ch);
}

///Array ( [status] => 200 [result] => Array ( [request_file_id] => 71a4cf53-9f7a-4af4-a39d-7e1d9374a77d ) )
///[request_file_id] => 94a2c950-b883-45a7-b8cc-0f1acd50944a
//5864c8c9-d59f-40bc-99d2-1c2e54a576b8
//1468e27f-2cd8-43f5-a99b-1d0fbd642172









//$request_file_id = abb85464-9857-492d-a1e2-9adfb671ef15

//$idfile = 2c6b27a532a88150dde06f79250285e2   285d558d2b68b00ee390310981993a37

//$response_file_id = 6e64c853-8f64-4375-80d4-bf8edfbd21a0
if(isset($_GET['response_file_id'])){
    $response_file_id = $_GET['response_file_id'];
    $access_token = new_token();
    echo resultaudio($access_token,$response_file_id);
}


if(isset($_GET['idfile'])){
    $idfile = $_GET['idfile'];
    $access_token = new_token();
    echo statusaudio($access_token,$idfile);
}


if (isset($_FILES['audio_file'])) {
    // Получаем информацию о файле
    //send_notification2 ('скрипт запуск - audio_file');
    $file = $_FILES['audio_file'];
    echo ' есть файл';
    uploadaudio($file);
    
}

if (isset($_REQUEST['audio'])) {
    
    //send_notification2 ('скрипт запуск - ');
    // Получаем информацию о файле
    $file = $_REQUEST['audio'];
    //$file = 'https://wapi-uploads7d.storage.yandexcloud.net/2bbed96c-4994/112fed09-6dde-4da0-9e67-80a116bc33a8.mpeg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=YCAJEx61R4C7kz0v5oC6y60Gx%2F20260405%2Fru-central1%2Fs3%2Faws4_request&X-Amz-Date=20260405T073826Z&X-Amz-Expires=172800&X-Amz-SignedHeaders=host&x-id=GetObject&X-Amz-Signature=3f337257487ff7063e5a96cbde1db838b147884713b16fac9f1ebdc2e453b291';
    
    echo ' есть файл '.$file.'<br><br>';
    uploadaudio($file);
}


if (isset($_REQUEST['id_mes'])) {
    $id_mes = $_REQUEST['id_mes'];
    $conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
    if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
    //echo "Подключение успешно установлено";
    
    $sql = "SELECT * FROM transcryptAudio WHERE id_mes = '".$id_mes."'";
    if($conn->query($sql)){
        $result = $conn->query($sql); 
        if($result->num_rows != 0){
            $row = $result->fetch_array();
            $file = $row['url_voice'];
        }
    }
    
    uploadaudio($file);
    
}


/*
if (isset($_GET['jjj'])) {
    
    //send_notification2 ('скрипт запуск - ');
    // Получаем информацию о файле
    
    
    $audioFileName = 'https://wapi-uploads7d.storage.yandexcloud.net/95c2a15f-47f6/be72f456-fa9a-479a-8627-e992bbe731a9.ogg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=YCAJEx61R4C7kz0v5oC6y60Gx%2F20260305%2Fru-central1%2Fs3%2Faws4_request&X-Amz-Date=20260305T194404Z&X-Amz-Expires=172800&X-Amz-SignedHeaders=host&response-content-disposition=inline%3B%20filename%3D%22d159e394-ddc9-40ed-a409-0e03a4ca722e.ogg%22%3B%20filename%2A%3DUTF-8%27%27d159e394-ddc9-40ed-a409-0e03a4ca722e.ogg&x-id=GetObject&X-Amz-Signature=6de65c3763c2982598a1270561ea2caff0272f8b7e8d08fbc32d51ef7e4e182c';
    $file = fopen($audioFileName, 'rb');
    //$file = 'https://san-dez.ru/my_script/GigaChat/Example.ogg';
    //echo ' есть файл';
    uploadaudio($file);
}
*/
/*


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Загрузка аудиофайлов</title>
</head>
<body>
    <h2>Загрузка аудиофайлов</h2>
    
    <!-- Форма для загрузки файла -->
    <form action="" method="post" enctype="multipart/form-data">
        <label for="audio_file">Выберите аудиофайл:</label><br>
        <input type="file" id="audio_file" name="audio_file" 
               accept=".mp3,.wav,.ogg,.flac" required><br><br>
        
        <input type="submit" value="Загрузить аудио">
    </form>
</body>
</html>
*/
