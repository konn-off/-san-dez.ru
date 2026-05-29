<?php

/// os_v2_org_i7njhf6ocfh6bhv42bfeytiet7x6stjdp7ke6d5psrmuv4jyu6llo6pgvli7nvh553jgp6hqpfxdltvlqii62wbaegzuz7md5y44v6i

//$API_KEY = 'os_v2_org_i7njhf6ocfh6bhv42bfeytiet7x6stjdp7ke6d5psrmuv4jyu6llo6pgvli7nvh553jgp6hqpfxdltvlqii62wbaegzuz7md5y44v6i';




/*
// Базовые параметры
$url = 'https://api.onesignal.com/notifications';
$apiKey = 'os_v2_org_i7njhf6ocfh6bhv42bfeytiet7x6stjdp7ke6d5psrmuv4jyu6llo6pgvli7nvh553jgp6hqpfxdltvlqii62wbaegzuz7md5y44v6i'; // Замените на ваш реальный API ключ
$appId = '3865f40a-a3ce-4230-bce8-85507a9feffa';  // Замените на ваш реальный App ID

// Данные для отправки
$notificationData = [
    'target_channel' => 'push',
    'included_segments' => '[Total Subscriptions]', //7b49b820-1187-4635-86ac-46846b8d928e
    'app_id' => $appId,
    'contents' => [
        'en' => 'Hello, world',
        'es' => 'Hola mundo',
        'fr' => 'Bonjour le monde',
        'zh-Hans' => '你好世界'
    ]
];

// Инициализация cURL
$ch = curl_init();

// Настройка параметров cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notificationData));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Key ' . $apiKey
]);

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






/**
 * Отправка push-уведомления через OneSignal API
 * 
 * Документация: https://documentation.onesignal.com/reference/create-notification
 */

// ========== НАСТРОЙКИ ==========
// Вставьте свои данные из панели управления OneSignal
$ONESIGNAL_APP_ID   = '3865f40a-a3ce-4230-bce8-85507a9feffa';
$ONESIGNAL_REST_KEY = 'os_v2_org_i7njhf6ocfh6bhv42bfeytiet7x6stjdp7ke6d5psrmuv4jyu6llo6pgvli7nvh553jgp6hqpfxdltvlqii62wbaegzuz7md5y44v6i';

// Параметры уведомления (можно задать через аргументы командной строки или изменить здесь)
$title   = $argv[1] ?? 'Тестовое уведомление';
$message = $argv[2] ?? 'Привет! Это сообщение отправлено через PHP-скрипт.';
$segment = $argv[3] ?? 'All'; // можно 'Active Users', 'Subscribed Users' или конкретный тег
// ===============================

/**
 * Функция отправки уведомления
 *
 * @param string $appId
 * @param string $restKey
 * @param string $title
 * @param string $message
 * @param string $segment
 * @return array Ответ от API
 */
function sendOneSignalNotification($appId, $restKey, $title, $message, $segment = 'All') {
    $url = "https://onesignal.com/api/v1/notifications";

    $fields = [
        'app_id' => $appId,
        'included_segments' => [$segment],
        'headings' => ['en' => $title],
        'contents' => ['en' => $message],
        // Дополнительные параметры (опционально):
        // 'data' => ['key1' => 'value1'],          // пользовательские данные
        // 'ios_badgeType' => 'Increase',
        // 'ios_badgeCount' => 1,
        // 'web_url' => 'https://example.com',      // при клике на уведомление
        // 'small_icon' => 'ic_stat_onesignal_default'
    ];

    $fields = json_encode($fields);

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json; charset=utf-8',
        'Authorization: Basic ' . $restKey
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // для локальной отладки можно false, в продакшене лучше true

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error    = curl_error($ch);
    curl_close($ch);

    if ($error) {
        return ['error' => $error];
    }

    $result = json_decode($response, true);
    $result['http_code'] = $httpCode;
    return $result;
}

// Отправляем уведомление
$result = sendOneSignalNotification($ONESIGNAL_APP_ID, $ONESIGNAL_REST_KEY, $title, $message, $segment);

// Выводим результат
echo "Результат отправки:\n";
if (isset($result['id'])) {
    echo "✅ Уведомление отправлено! ID: " . $result['id'] . "\n";
    echo "Получателей: " . ($result['recipients'] ?? 'неизвестно') . "\n";
} else {
    echo "❌ Ошибка:\n";
    print_r($result);
}




?>


































