<?

	
	$roistat_visit = $user_cookie; //$_COOKIE['roistat_visit']
	
	$utm = explode("&",$_GET['utm']);
	$utm_source=''; $utm_medium=''; $utm_campaign=''; $utm_content=''; $utm_term=''; $yclid='';
	
	for ($i = 0; $i <= count($utm); $i++) {
		$h = explode("=",$utm[$i]);
		if($h[0]=='utm_source'){$utm_source=$h[1];}
		if($h[0]=='utm_medium'){$utm_medium=$h[1];}
		if($h[0]=='utm_campaign'){$utm_campaign=$h[1];}
		if($h[0]=='utm_content'){$utm_content=$h[1];}
		if($h[0]=='utm_term'){$utm_term=$h[1];}
	}

	if ($utm_source==''){
		$referrer_url = $_GET['referrer_url'];
		if ($referrer_url==''){$utm_source='Прямой заход';}
		else {
			if (strpos($referrer_url, 'yandex') !== false){ $utm_source='SEO_yandex'; } 
			else
			{ 
				if (strpos($referrer_url, 'google') !== false){ $utm_source='SEO_google'; } 
				else { $ffsdsf = explode('?',$referrer_url); $utm_source=$ffsdsf[0]; }
			} 
		}
	}

	$url = $_GET['url'];

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
	$resps = array();
	foreach($q['response']['account']['users'] as $key => $value)
	{ 
	   if($value['login'] == "123@dreemteem.ru") continue;
		  if($value['login'] == "231@roskod.ru") continue;
		  if($value['login'] == "120@roskod.ru") continue;
		if($value['login'] == "109@dreemteem.ru") continue;
		if($value['login'] == "291@eancom.org") continue;
		$resps[] = $value['id'];
	}
   
	$resp = file_get_contents(dirname(__file__)."/lastresp.txt");
	if(!isset($resps[$resp])) $resp = 0;
	file_put_contents(dirname(__file__)."/lastresp.txt", $resp+1);

	curl_setopt($ch, CURLOPT_URL, "https://".$amo_domain.".amocrm.ru/private/api/v2/json/leads/set");
	$leads['request']['leads']['add'] = array(
		array(
			'name' => "Новая заявка с сайта Unikod.org",
			'responsible_user_id' => $resps[$resp],
			//'pipeline_id' => 4217805, //Воронка Новые ШК в АМО koddd3
			'pipeline_id' => 339684, //Воронка ШК в АМО koddd3
			//'pipeline_id' => 3742381, //Воронка ШК в АМО napb
			'custom_fields' => array(
			  array(
				'id' => 1466131, //1294341
				'values' => array(
				  array(
					'value' => $roistat_visit,//$_GET['roistat-promo-code'], $_COOKIE['roistat_visit'],
				  )
				)
			  ),
			  array(
				'id' => 1294241,
				'values' => array(
				  array(
					'value' => $roistat_visit,//$_GET['roistat-promo-code'], $_COOKIE['roistat_visit'],
				  )
				)
			  ),
			  array(
				'id' => 1295309, //1289806 сайт
				'values' => array(
				  array(
					'value' => $url,
				  )
				)
			  ),
			  array(
				'id' => 1466143, //1289806 сайт from
				'values' => array(
				  array(
					'value' => $url,
				  )
				)
			  ),
			  array(
				'id' => 1295578, // 1289820 источник (заявка с сайта)
				'values' => array(
				  array(
					'value' => 'чат',
				  )
				)
			  ),
			  array(
				'id' => 1466115, // 1289808 utm_source
				'values' => array(
				  array(
					'value' => $utm_source,
				  )
				)
			  ),
			  array(
				'id' => 1466119, // 1289810 utm_campaign
				'values' => array(
				  array(
					'value' => $utm_campaign,
				  )
				)
			  ),
			  array(
				'id' => 1466123, // 1289812 utm_content
				'values' => array(
				  array(
					'value' => $utm_content,
				  )
				)
			  ),
			  array(
				'id' => 1466121, // 1289814 utm_term
				'values' => array(
				  array(
					'value' => $utm_term,
				  )
				)
			  ),
			  array(
				'id' => 1466149, //  Yclid
				'values' => array(
				  array(
					'value' => $yclid,
				  )
				)
			  )
			)
		)
	);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($leads));
	$q = json_decode(curl_exec($ch), 1); 
		
		if($_GET['name'] == '' || !isset($_GET['name'])) { $name = "Имя не известно"; }
		else { $name = $_GET['name']; }
		
		$id_client = $q['response']['leads']['add'][0]['id'];
		
	curl_setopt($ch, CURLOPT_URL, "https://".$amo_domain.".amocrm.ru/private/api/v2/json/contacts/set");
	$contacts['request']['contacts']['add']=array(
		array(
			'name' => $name, 
			'linked_leads_id' => array($q['response']['leads']['add'][0]['id']),
			'custom_fields' => array(
			  array(
				'id' => 841572, // 560144
				'values' => array(
				  array(
					'value' => $contact_phone,
					'enum' => 'WORK' 
				  )
				)
			  ),
			  array(
				'id' => 841574, // 560144
				'values' => array(
				  array(
					'value' => $contact_mail,
					'enum' => 'WORK' 
				  )
				)
			  )
		)));
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($contacts));
	curl_exec($ch); 
	$text = "Сообщение из чата".PHP_EOL;
	$text .= $mes;
	$notes['request']['notes']['add']=array(array('element_id'=>$id_client, 'element_type'=>2, 'note_type'=>4, 'text'=>$text));
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notes));
			curl_setopt($ch, CURLOPT_URL, "https://".$amo_domain.".amocrm.ru/private/api/v2/json/notes/set");
			$q = json_decode(curl_exec($ch), 1);
	
	
		$message = '
		Новая сделка - <a href="https://koddd3.amocrm.ru/leads/detail/'.$id_client.'">https://koddd3.amocrm.ru/leads/detail/'.$id_client.'</a>';
		
		$token = "2097657903:AAEOna1ch6u3EKi_U9w_VjYHyPWPPaTPO4o"; //наш токен от telegram bot -а
		$chatid = "608866610"; //ИД чата telegrm 789
		$chatid2 = "1465982232"; //ИД чата telegrm Анатолий
		$chatid3 = "5903532273"; //ИД чата telegrm 655 Регина
		$chatid4 = "1068146620"; //ИД чата telegrm 621 Ольга

		$tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($message));
		$tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid2."&text=".urlencode($message));
		//$tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid3."&text=".urlencode($message));
		$tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid4."&text=".urlencode($message));
		
		
		// массив для переменных, которые будут переданы с запросом
		$paramsArray = array(
			'name_leads' => 'Новая заявка с сайта Unikod.org', 
			'name' => $name,
			'mail' => $contact_mail,
			'phone' => $contact_phone,
			'site' => 'unikod.org',
			'url' => $url,
			'roistat' => $roistat_visit,
			'ycid' => $yclid,
			'utm_source' => $utm_source,
			'utm_medium' => $utm_medium,
			'utm_campaign' => $utm_campaign,
			'utm_content' => $utm_content,
			'utm_term' => $utm_term,
			'source' => 'чат'
		); 	
		$vars = http_build_query($paramsArray); // преобразуем массив в URL-кодированную строку
		// создаем параметры контекста
		$options = array(
			'http' => array(  
				'method'  => 'POST',  // метод передачи данных
				'header'  => 'Content-type: application/x-www-form-urlencoded',  // заголовок 
				'content' => $vars,  // переменные
			)  
		);  
		$context  = stream_context_create($options);  // создаём контекст потока
		$result = file_get_contents('https://roskod.ru/my_script/all_leads_save/insert.php', false, $context); //отправляем запрос
	?>