<?

function writeToLog($data, $title = '') {
	$log = "\n------------------------\n";
	$log .= date("Y.m.d G:i:s") . "\n";
	$log .= (strlen($title) > 0 ? $title : 'DEBUG') . "\n";
	$log .= print_r ($data,1);
	$log .= "\n------------------------\n";
	file_put_contents(getcwd() . '/hook1.log', $log, FILE_APPEND);
	return true;
}

/*$rawdata = file_get_contents("php://input");
$decoded = json_decode($rawdata);*/
//print_r ($decoded);
//writeToLog($decoded, 'incoming');
//writeToLog($_REQUEST, 'incoming');



$name = '';
$mail = '';
$site = '';
$url = '';
$roistat = '';
$ycid = '';
$utm_source = '';
$utm_medium = '';
$utm_campaign = '';
$utm_content = '';
$utm_term = '';
$source = '';
$phone = $_REQUEST['src'];
if($_REQUEST['callstatus']=='BUSY'){$callstatus = 'номер занят';}
if($_REQUEST['callstatus']=='ANSWERED'){$callstatus = 'отвечен';}
if($_REQUEST['callstatus']=='NO ANSWER'){$callstatus = 'не отвечен';}

$name_leads = Звонок - '.$callstatus.';



$message = '
		Новая сделка
		Сообщение - Звонок - '.$callstatus.'
		Телефон - '.$phone;
		
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
	

if(isset($phone) && $phone!=''){
	
	
	$conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
	if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
	//echo "Подключение успешно установлено";

	$date = time();

	$name_data = "(date, name_leads, name, mail, phone, site, url, roistat, ycid, utm_source, utm_medium, utm_campaign, utm_content, utm_term, source)";
	$data = "('".$date."', '".$name_leads."', '".$name."', '".$mail."', '".$phone."', '".$site."', '".$url."', '".$roistat."', '".$ycid."', '".$utm_source."', '".$utm_medium."', '".$utm_campaign."', '".$utm_content."', '".$utm_term."', '".$source."')";
			
	$sql = "INSERT INTO all_leads $name_data VALUES $data"; 
	if($conn->query($sql)){ echo "Данные успешно добавлены"; } else { echo "Ошибка: " . $conn->error; }
}


/*

if(isset($_REQUEST['reff'])){$reff = $_REQUEST['reff'];} else{$reff = '';} 
if(isset($_REQUEST['name'])){$name = $_REQUEST['name'];} else{$name = '';} 
if(isset($_REQUEST['mail'])){$mail = $_REQUEST['mail'];} else{$mail = '';} 
if(isset($_REQUEST['phone'])){$phone = $_REQUEST['phone'];}
if(isset($_REQUEST['url'])){$url = $_REQUEST['url'];}
if(isset($_REQUEST['site'])){$site = $_REQUEST['site'];}
if(isset($_REQUEST['roistat'])){$roistat = $_REQUEST['roistat'];}
if(isset($_REQUEST['ycid'])){$ycid = $_REQUEST['ycid'];}
if(isset($_REQUEST['utm_source'])){$utm_source = $_REQUEST['utm_source'];}
if(isset($_REQUEST['utm_medium'])){$utm_medium = $_REQUEST['utm_medium'];}
if(isset($_REQUEST['utm_campaign'])){$utm_campaign = $_REQUEST['utm_campaign'];}
if(isset($_REQUEST['utm_content'])){$utm_content = $_REQUEST['utm_content'];}
if(isset($_REQUEST['utm_term'])){$utm_term = $_REQUEST['utm_term'];}
	
if(isset($phone) && $phone!=''){
		
	$conn = new mysqli("pkw8p.spectrum.myjino.ru", "753958_wp8", "(nYf5Ze2m6d]/", "753958_wp8");
	if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
	//echo "Подключение успешно установлено";
	



	if ($utm_source==''){
		if ($reff==''){$utm_source='Прямой заход';}
		else {
			if (strpos($reff, 'yandex') !== false){ $utm_source='SEO_yandex'; } 
			else
			{ 
				if (strpos($reff, 'google') !== false){ $utm_source='SEO_google'; } 
				else { $ffsdsf = explode('?',$reff); $utm_source=$ffsdsf[0]; }
			} 
		}
	}

	$name_leads = 'Новая заявка с сайта '.$site; 
	$source = 'Звонок';

	$date = time();

	$name_data = "(date, name_leads, name, mail, phone, site, url, roistat, ycid, utm_source, utm_medium, utm_campaign, utm_content, utm_term, source)";
	$data = "('".$date."', '".$name_leads."', '".$name."', '".$mail."', '".$phone."', '".$site."', '".$url."', '".$roistat."', '".$ycid."', '".$utm_source."', '".$utm_medium."', '".$utm_campaign."', '".$utm_content."', '".$utm_term."', '".$source."')";
			
	$sql = "INSERT INTO all_leads $name_data VALUES $data"; 
	if($conn->query($sql)){ echo "Данные успешно добавлены"; } else { echo "Ошибка: " . $conn->error; }
	
	
	include 'new_leads_amo.php';	
	
	
	
}*/








	
	
	
	
	
	
	
	
	
?>