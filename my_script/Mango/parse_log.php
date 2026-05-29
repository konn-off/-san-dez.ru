<?php

$conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
//echo "Подключение успешно установлено";

// Определить путь к файлу лога: `$logFile = 'path/to/log_file.log'`.  
$logFile = 'hook_callibri.log';
// Открыть файл для чтения: `$handle = fopen($logFile, 'r')`. 
$handle = fopen($logFile, 'r');
// Создать пустой массив для хранения записей лога: `$logEntries =`.  
$logEntries = array();
$line1='';
// Читать файл лога построчно: `while (($line = fgets($handle)) !== false)`.  
while (($line = fgets($handle)) !== false){
    $line1=$line1.$line;
}
//echo $line1;
$l=explode('------------------------',$line1);
//echo count($l);
for ($n = 0; $n <= count($l); $n++) {
    //echo 'Z'.$l[$n].'<br>';
    if($l[$n]!=''){
        $logEntries[] = $l[$n];
    }
}
    //echo 'Z'.$l[0].'<br>';
    //
//print_r($logEntries); 
$n=0;
$logEntr = array();
foreach ($logEntries as $entry) {
    $f=explode('[json] =>',$entry);
    if($f[1]!=''){
        $fff = str_replace('{','',$f[1]);
        $fff = str_replace('}','',$fff);
        $fff = str_replace('"','',$fff);
        $logEntr[] = str_replace(')','',$fff);
    }
    //echo $entry . '<br><br><br>';
}

$logEntr2 = array();
foreach ($logEntr as $entry) {
    $pos = strpos($entry,'call_direction');
    if($pos === false){}else{
        $newString = preg_replace("/from:number/i", "from_number", $entry);
        $newString = preg_replace("/to:number/i", "to_number", $newString);
        $newString = preg_replace("/to:extension/i", "to_extension", $newString);
        $newString = preg_replace("/from:extension/i", "from_extension", $newString);
        
    
        $logEntr2[] = $newString;
    }
    $pos = strpos($entry,'recording_id');
    if($pos === false){}else{
        $logEntr2[] = $entry;
    }
}


foreach ($logEntr2 as $entry) {
    $d= explode(',', $entry);
    echo $entry.'<br>';
    $entry_id='';
    $call_from='';
    $call_to='';
    $create_time='';
    $talk_time='';
    $entry_result='';
    $call_direction='';
    $recording_id='';
//echo count($d);
    for($j = 0; $j < count($d); $j++){
        
        //echo 'ydd'.$j.' - '.$d[$j].'<br>';
        $bb = explode(':',$d[$j]);  
        //echo 'ydds'.$j.' - '.$bb[0].' - '.$bb[1].'<br>';
        
        if($j==0){$entry_id=$d[$j];}
        //if($bb[0]=='entry_id'){$entry_id=$bb[1];}
        if($bb[0]=='call_direction'){$call_direction=$bb[1];}
        if($bb[0]=='from_number'){$call_from=$bb[1];}
        if($bb[0]=='to_number'){$call_to=$bb[1];}
        if($bb[0]=='create_time'){$create_time=$bb[1];}
        if($bb[0]=='talk_time'){$talk_time=$bb[1];}
        if($bb[0]=='entry_result'){$entry_result=$bb[1];}
        if($bb[0]=='recording_id'){$recording_id=$bb[1];}
        
    }
    $entry_id = explode(':',$entry_id); $entry_id = $entry_id[1];
    echo '<br><br>yddf - '.$entry_id.' '.$call_direction.' '.$call_from.' '.$call_to.' '.$create_time.' '.$talk_time.' '.$entry_result.' '.$recording_id.'<br>';
    
    if($call_direction!=''){
        echo $entry_id.' - Уведомление о завершении вызова '.$call_direction.'<br><br><br>';
        $name_data = "(entry_id, call_direction, call_from, call_to, create_time, talk_time, entry_result)";
        $data = "('".$entry_id."', '".$call_direction."', '".$call_from."', '".$call_to."', '".$create_time."', '".$talk_time."', '".$entry_result."')";
                    
        $sql = "INSERT INTO calls $name_data VALUES $data"; 
        if($conn->query($sql)){ echo "Данные успешно добавлены"; } else { echo "Ошибка: " . $conn->error; }
    }
    if($recording_id!=''){
        echo $entry_id.' - Уведомление о записи разговора '.$recording_id.'<br><br><br>';
        $sql = "UPDATE calls SET recording_id='".$recording_id."' WHERE entry_id='".$entry_id."'"; $conn->query($sql);
    }
}
//print_r($logEntr2); 













    
// Для каждой строки вызывать функцию `parseLogLine()`.  
// Добавлять запись лога в массив: `$logEntries = $entry`.  
// Закрыть файл: `fclose($handle)`. [1](https://amazingalgorithms.com/snippets/php/parsing-log-files/)














































?>