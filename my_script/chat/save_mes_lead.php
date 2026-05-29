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
	
	
	$message = '
		Новая сделка
		Сообщение - '.$user_mes.'
		Имя - 
		Телефон - '.$contact_phone.'
		$utm_source - '.$utm_source.'
		$utm_medium - '.$utm_medium.'
		$utm_campaign - '.$utm_campaign.'
		$utm_content - '.$utm_content.'
		$utm_term - '.$utm_term.'
		$yclid - '.$yclid;
		
		$token = "2097657903:AAEOna1ch6u3EKi_U9w_VjYHyPWPPaTPO4o"; //наш токен от telegram bot -а
		$chatid = "608866610"; //ИД чата telegrm 789
		$chatid2 = "271142636";// ИД чата telegrm клиент
		
		
		
	$tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($message));	
	$tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid2."&text=".urlencode($message));	
		
	$to      = 'sanitar-centr@yandex.ru';
	$subject = 'Повторное сообщение из чата';
	$headers = array(
		'From' => 'webmaster@san-dez.ru',
		'Reply-To' => 'webmaster@san-dez.ru',
		'X-Mailer' => 'PHP/' . phpversion()
	);
	
	mail($to, $subject, $message, $headers);	
		
		
		
	// массив для переменных, которые будут переданы с запросом
	$paramsArray = array(
		'name_leads' => 'Новая заявка с сайта san-dez.ru', 
	    'name' => '',
	    'mail' => '',
	    'phone' => $contact_phone,
	    'site' => 'san-dez.ru',
	    'url' => $url,
	    'roistat' => '',
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
	$result = file_get_contents('https://san-dez.ru/my_script/all_leads_save/insert.php', false, $context); //отправляем запрос	
		
		?>