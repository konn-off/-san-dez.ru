<?php

$conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
//echo "Подключение успешно установлено";
    
$sql = "SELECT * FROM calls";
    
$result = $conn->query($sql);    

$data=array();
while($row = $result->fetch_assoc()){
    $entry_id = trim($row['entry_id']);
    $recording_id = trim($row['recording_id']);
    $id = $row['id'];
    echo '"'.$row['entry_id'].'" - "'.$entry_id.'" === "'.$row['recording_id'].'" - "'.$recording_id.'"<br><br>';
    //$sql = "UPDATE calls SET recording_id='".$recording_id."', entry_id='".$entry_id."' WHERE id='".$id."'"; $conn->query($sql);
    /*if(in_array($ff, $data)){
        echo $row['id'].' - '.$ff.'<br>';
        $id = $row['id'];
        $sqlf = "DELETE FROM calls WHERE id='".$id."'";$conn->query($sqlf);
    }
    $data[]=$ff;*/
}


























?>