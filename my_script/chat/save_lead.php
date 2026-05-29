<?

	
	$roistat_visit = $user_cookie; //$_COOKIE['roistat_visit']
	
	$utm = explode("&",$_GET['utm']);
	$utm_source=''; $utm_medium=''; $utm_campaign=''; $utm_content=''; $utm_term=''; 
	
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
	
	
	$message = '
		Новая сделка
		Сообщение - '.$mes.'
		Имя - 
		Телефон - '.$contact_phone.'
		utm_source - '.$utm_source.'
		utm_medium - '.$utm_medium.'
		utm_campaign - '.$utm_campaign.'
		utm_content - '.$utm_content.'
		utm_term - '.$utm_term.'
		yclid - '.$yclid;
		
		$token = "6843410151:AAERG49__xZQiew2XDkkr-WqO87Oo5-FCWc"; //наш токен от telegram bot -а
		$chatid = "608866610";// ИД чата telegrm
		$chatid2 = "271142636";// ИД чата telegrm клиент
		$chatid3 = "1587801533";// ИД чата telegrm клиент2
		
		
	$tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($message));
	$tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid2."&text=".urlencode($message));
	$tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid3."&text=".urlencode($message));
		
		
	$to      = 'sanitar-centr@yandex.ru';
	$subject = 'Новая заявка';
	$headers = array(
		'From' => 'webmaster@san-dez.ru',
		'Reply-To' => 'webmaster@san-dez.ru',
		'X-Mailer' => 'PHP/' . phpversion()
	);
	
	mail($to, $subject, $message, $headers);	
		
		
		?>
		
		
		