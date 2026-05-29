<?php


function sendPachca($mess)
{
    $url = "https://api.pachca.com/webhooks/01KKXMA9WRQ161QZ937JE6X8D6";
    
    // Определяем данные для отправки
    $json_data = json_encode(array(
        'message' => $mess
    ));
    
    // Контекст для JSON-запроса
    $context = stream_context_create(array(
        'http' => array(
            'method' => 'POST',
            'header' => "Content-Type: application/json\r\n" .
                       "Content-Length: " . strlen($json_data),
            'content' => $json_data
        )
    ));
    
    // Отправляем POST-запрос
    $response = file_get_contents('https://api.pachca.com/webhooks/01KKXMA9WRQ161QZ937JE6X8D6', false, $context);
    
    // Выводим ответ сервера
    echo $response;
    
    
    
    
    
    /*
    // URL для отправки запроса
    //$url = 'https://api.example.com/endpoint';
    
    // Инициализация cURL
    $ch = curl_init($url);
    
    // Подготовка данных в формате JSON
    $data = array(
        'message' => 'Тестовое сообщение'
    );
    
    // Кодирование массива в JSON
    $json_data = json_encode($data);
    
    // Настройка параметров cURL
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($json_data)
    ));
    
    // Выполнение запроса
    $response = curl_exec($ch);
    
    // Проверка на ошибки
    if(curl_errno($ch)) {
        echo 'Ошибка cURL: ' . curl_error($ch);
    } else {
        // Декодирование ответа
        $result = json_decode($response, true);
        print_r($result);
    }
    
    // Закрытие сессии cURL
    curl_close($ch);


*/
    
}

$mess = 'Тестовое сообщение';

sendPachca($mess);