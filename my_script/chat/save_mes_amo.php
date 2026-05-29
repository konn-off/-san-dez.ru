<?

$amo_login = "123@dreemteem.ru";
	$amo_domain = "koddd3";
	$amo_hash = "18105c462e97c6a01ec1de6bfa4b3d9c9645423c";
	

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, "amoCRM-API-client/1.0");
	curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_COOKIEFILE, dirname(__FILE__)."/cookieamo9349.txt"); 
	curl_setopt($ch, CURLOPT_COOKIEJAR, dirname(__FILE__)."/cookieamo9349.txt"); 
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_URL, "https://".$amo_domain.".amocrm.ru/private/api/auth.php?type=json");
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array("USER_LOGIN" => $amo_login, "USER_HASH" => $amo_hash)));
	$q = json_decode(curl_exec($ch), 1); 
	curl_setopt($ch, CURLOPT_POST, 0);		
	curl_setopt($ch, CURLOPT_URL, "https://".$amo_domain.".amocrm.ru/private/api/v2/json/accounts/current");
	$q = json_decode(curl_exec($ch), 1);
	
	$text = "Сообщение из чата".PHP_EOL;
	$text .= $user_mes;
	$notes['request']['notes']['add']=array(array('element_id'=>$id_client_amo, 'element_type'=>2, 'note_type'=>4, 'text'=>$text));
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notes));
			curl_setopt($ch, CURLOPT_URL, "https://".$amo_domain.".amocrm.ru/private/api/v2/json/notes/set");
			$q = json_decode(curl_exec($ch), 1);
			
		$message = '
		Новое сообщение в сделке из чата - <a href="https://koddd3.amocrm.ru/leads/detail/'.$id_client_amo.'">https://koddd3.amocrm.ru/leads/detail/'.$id_client_amo.'</a>';
		
		$token = "2097657903:AAEOna1ch6u3EKi_U9w_VjYHyPWPPaTPO4o"; //наш токен от telegram bot -а
		$chatid = "608866610"; //ИД чата telegrm 789
		$chatid2 = "1465982232"; //ИД чата telegrm Анатолий
		$chatid3 = "5903532273"; //ИД чата telegrm 655 Регина
		$chatid4 = "1068146620"; //ИД чата telegrm 621 Ольга

		$tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($message));
		$tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid2."&text=".urlencode($message));
		//$tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid3."&text=".urlencode($message));
		$tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid4."&text=".urlencode($message));
?>