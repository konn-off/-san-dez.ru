<?php
$result = shell_exec('which ffmpeg');
if (trim($result)) {
    echo 'FFmpeg установлен по пути: ' . trim($result);
} else {
    echo 'FFmpeg не установлен';
}
?>