<?php

function sent_Loop($mess){
    // Инициализация cURL сессии
    $ch = curl_init();
    
    // Настройка параметров запроса
    curl_setopt_array($ch, [
        CURLOPT_URL => 'https://san-dez.loop.ru/hooks/crjxgcihnjr6xqcp3xhhpighih',
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



$mess = '
Новое сообщение в Telegram от клиента
Имя - НК
Телефон - 
utm_source - 
utm_medium - 
utm_campaign - 
utm_content - 
utm_term - 
yclid - 
roistat - 0
order_id - P507770';
                
sent_Loop($mess);