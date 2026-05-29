<?php
$data = file_get_contents('php://input');
$data = json_decode($data, true);

//file_put_contents(__DIR__ . '/message.txt', print_r($data, true));


//$token ='6843410151:AAERG49__xZQiew2XDkkr-WqO87Oo5-FCWc';
$token = '6843410151:AAEztaRwqsdj2d3vKhBxVKwkcrIqzeq4YOM';

function sendTelegram($mess,$chatid)
{
    $token = "6843410151:AAEztaRwqsdj2d3vKhBxVKwkcrIqzeq4YOM";
    $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($mess));
}


if(isset($_GET['text'])){
    //$token = "2097657903:AAEOna1ch6u3EKi_U9w_VjYHyPWPPaTPO4o"; //наш токен от telegram bot -а
    /*$token = "6843410151:AAEztaRwqsdj2d3vKhBxVKwkcrIqzeq4YOM";
    $chatid = "608866610";// ИД чата telegrm
    $mess = $_GET['text']; //сообщение, которое мы удем оправлять
    $tbot = file_get_contents("https://api.telegram.org/bot".$token."/sendMessage?chat_id=".$chatid."&text=".urlencode($mess));
    */
    
    sendTelegram($_GET['text'],'608866610');
}



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


sendTelegram(array('chat_id' => '608866610','text' => 'Привет!'));
*/

?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>san-dez.ru</title>
    <link rel="stylesheet" href="style.css">
    
    <meta property="og:title" content="Заголовок страницы в OG">
    <meta property="og:description" content="Описание страницы в OG">
    <meta property="og:image" content="https://example.com/image.jpg">
    <meta property="og:url" content="https://example.com/">
    
    <!-- Novofon -->
    <script type="text/javascript" async src="https://widget.novofon.ru/novofon.js?k=OfZE5XLH0Qf3SOsaIPnGC8adNDpccWWS"></script>
<!-- Novofon -->
</head>
<body>
    <header>
      
    </header>
    <main>
        <article>
            <section>
            <p>Бла бла бла</p>
                
                
                
            </section>
        </article>
    </main>
    <footer>
      <p>
          
      </p>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="app.js" defer></script> 
    
    <!--script src="//code.jivo.ru/widget/lAwj8ShwjY" async></script-->
    
    

</body>
</html>




