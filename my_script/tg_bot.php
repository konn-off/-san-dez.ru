<?php 

// https://api.telegram.org/bot6843410151:AAEztaRwqsdj2d3vKhBxVKwkcrIqzeq4YOM/setwebhook?url=https://san-dez.ru/my_script/tg_bot.php
// https://t.me/Rodorra_Bot

$data = file_get_contents('php://input');
$data = json_decode($data, true);

file_put_contents(__DIR__ . '/message.txt', print_r($data, true));


//$token ='6843410151:AAERG49__xZQiew2XDkkr-WqO87Oo5-FCWc';
$token = '6843410151:AAEztaRwqsdj2d3vKhBxVKwkcrIqzeq4YOM';


/*
function sendTelegram($response)
{
	$ch = curl_init('https://api.telegram.org/6843410151:AAEztaRwqsdj2d3vKhBxVKwkcrIqzeq4YOM/sendMessage');  
	curl_setopt($ch, CURLOPT_POST, 1);  
	curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$res = curl_exec($ch);
	curl_close($ch);
 
	return $res;
}
*/


function sendTelegram($mess,$chatid)
{
    $token = "6843410151:AAEztaRwqsdj2d3vKhBxVKwkcrIqzeq4YOM";
    $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($mess));
}




if (!empty($data['message']['text'])) {
	
	$text = $data['message']['text'];
	$chat_id = $data['message']['from']['id'];
	$name = $data['message']['from']['first_name'];
	$surname = $data['message']['from']['last_name'];
	$username = $data['message']['from']['username'];
	$message_id = $data['message']['message_id'];
	$date_time = date('d.m.Y H:i:s');
	
	$conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
	if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
	//echo "Подключение успешно установлено";
	
	if(mb_substr_count($text, 'auth')!=0){
		//sendTelegram(array('chat_id' => $chat_id,'text' => 'Привет! Напиши пароль'));
		sendTelegram('Привет! Напиши пароль',$chat_id);
	}
	else {
		
		$sql2 = "SELECT * FROM tg_bot WHERE chat_id = $chat_id";
		if($conn->query($sql2)){
			$result = $conn->query($sql2);
			if($result->num_rows != 0){
			}
		}
		
		if($text=='123456'){
			$mes = 'Спасибо! Пароль верный';
			//sendTelegram(array('chat_id' => $chat_id,'text' => $mes));
			sendTelegram($mes,$chat_id);
			
			$sql6 = "UPDATE tg_bot SET message_id = '$message_id+1' WHERE chat_id = '$chat_id'";
			$conn->query($sql6);
			
			$sql2 = "SELECT * FROM tg_bot WHERE chat_id = $chat_id";
			if($conn->query($sql2)){
				$result = $conn->query($sql2);
				if($result->num_rows == 0){ 
								
					$sql = "INSERT INTO tg_bot (chat_id) VALUES ('".$chat_id."')"; 
					if($conn->query($sql)){ echo "Данные успешно добавлены"; } else { echo "Ошибка: " . $conn->error; }
					
					$mes = 'Перейдите по ссылке https://san-dez.ru/my_script/all_leads_save/select.php?men='.$chat_id;
					//sendTelegram(array('chat_id' => $chat_id,'text' => $mes));
					sendTelegram($mes,$chat_id);
					
					$sql6 = "UPDATE tg_bot SET date_time = '$date_time', message_id = '$message_id+1', name='$name', surname='$surname', username='$username' WHERE chat_id = '$chat_id'";
					$conn->query($sql6);
				}
				else{
					$row = $result->fetch_array();
					if($row['name']=='' || $row['surname']=='' || $row['phone']==''){
						$mes = 'Перейдите по ссылке https://san-dez.ru/my_script/all_leads_save/select.php?men='.$chat_id;
						//sendTelegram(array('chat_id' => $chat_id,'text' => $mes));
						sendTelegram($mes,$chat_id);
						
						$sql6 = "UPDATE tg_bot SET date_time = '$date_time', message_id = '$message_id+1', name='$name', surname='$surname', username='$username' WHERE chat_id = '$chat_id'";
						$conn->query($sql6);

					}
				}
			}
		
		
		}else {
			$mes = 'Ошибка! Пароль НЕ верный, напиши пароль';
		}
		//sendTelegram(array('chat_id' => $chat_id,'text' => $mes));
	}
	
	//sendTelegram(array('chat_id' => $data['message']['chat']['id'],'text' => 'Фото сохранено'));

}else {exit();}













?>