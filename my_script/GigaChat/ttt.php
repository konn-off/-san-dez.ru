<?php
$audioFileName = file_get_contents("https://wapi-uploads7d.storage.yandexcloud.net/95c2a15f-47f6/1cf47921-039c-4a7e-821c-265b6666847d.ogg?X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=YCAJEx61R4C7kz0v5oC6y60Gx%2F20260306%2Fru-central1%2Fs3%2Faws4_request&X-Amz-Date=20260306T115325Z&X-Amz-Expires=172800&X-Amz-SignedHeaders=host&response-content-disposition=inline%3B%20filename%3D%22fb950ce7-bfbd-44d7-9a30-3b00a233447b.ogg%22%3B%20filename%2A%3DUTF-8%27%27fb950ce7-bfbd-44d7-9a30-3b00a233447b.ogg&x-id=GetObject&X-Amz-Signature=851585c794be9d1255936c349b904524e09fd13086b9950629a59845205137f8");

echo $audioFileName['size'];


?>




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