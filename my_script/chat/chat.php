<?
    $conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
    //$conn = new mysqli("m27zp.spectrum.myjino.ru", "753958_wp7", "bQX7m33xc", "753958_wp7");
    if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
    //echo "Подключение успешно установлено";


include 'chat-mes-shablon.php';

    
if (isset($_GET['action']) && $_GET['action']=='start'){
    $user_cookie = $_GET['user_cookie'];
    
    include 'chat-html.php';
    include 'chat-css.php';
}


function phone_filter ($s) { //фильтр символов проверяемой лексемы
    return preg_replace (array("/\-/u","/[^\d\+]/u"),"",$s);
}
 
function is_phone ($s) { //проверка лексемы на соответствие шаблону
    return preg_match("/^(\+7|8)(\d{10})$/u",$s) ? 1 : 0;
}

function is_phone_search_text ($data) { //проверка лексемы на соответствие шаблону
    define ('TEST_LIMIT','12'); //лимит проверяемой длины строк
 
    $data = preg_replace ("/\s+/u"," ",$data); //убрали лишние разделители
    $tokens = preg_split("/\s/u",$data); //получили массив лексем
    $tokens = array_filter ($tokens, function ($item) {return !empty($item);} );
    //отфильтровали пустые лексемы
    $len = count($tokens); $result = array (); $i = 0;
    for ($i=0; $i<$len; $i++) { //цикл по лексемам
        if (is_phone(phone_filter($tokens[$i]))) 
        $result[] = $tokens[$i]; //сама фильтрованная лексема есть номер
        else { //или пробуем сливать лексему с несколькими последующими
            $test = $tokens[$i]; $j = $i+1;
            while (1) {
                $test .= $tokens[$j]; 
                $test = phone_filter ($test);
                if (is_phone($test)) { $result[] = $test; $i=$j; break; }
                else if ($j>=$len or strlen($test)>TEST_LIMIT) break;
                $j++;
            } 
        } 
    }
 
    return $result; //вывод результатов
}


if (isset($_GET['action']) && $_GET['action']=='load_mes'){
    $user_cookie = $_GET['user_cookie'];
    

    
    $sql = "SELECT * FROM chat WHERE user_cookie = '$user_cookie' ORDER BY datatime";
    
    if($result = $conn->query($sql)){
        $rowsCount = $result->num_rows; // количество полученных строк
        
        if($rowsCount==0){
            $name = 'user_cookie, autor, mes, yclid';
            $data = "'".$user_cookie."', 'operator', '".$sh_start_mes."', '".$user_cookie."'";
            
            $datatime = time();
            $a = "(datatime,".$name.")";
            $b = "('".$datatime."',".$data.")";
            
            $sql = "INSERT INTO chat $a VALUES $b"; 
            if($conn->query($sql)){ /*echo "Данные успешно добавлены";*/ } else { echo "Ошибка: " . $conn->error; }

            echo '<div class="first-message-date">'.date("d.m.Y").'</div>';
            echo $sh_start_mes;
            echo '<div class="message-time-operator">'.date("H:i").'</div>';
        }
        else {
            $data_mes = '';
            foreach($result as $row){
                if($data_mes != date("d.m.Y",$row["datatime"])){
                    echo '<div class="first-message-date">'.date("d.m.Y",$row["datatime"]).'</div>';
                }
                if($row["autor"]=='user'){ echo '<div class="mes-wrapper-user"> <div class="mes-user">'.$row["mes"].'</div> </div>'; }
                else { echo $row["mes"]; }
                echo '<div class="message-time-'.$row["autor"].'">'.date("H:i",$row["datatime"]).'</div>';
                $data_mes = date("d.m.Y",$row["datatime"]);
                //if($row["contact_form"]=='1'){  echo $sh_servise_contact2; echo $chat_form_contact; }
            }
        }
        
    } else{
        echo "Ошибка: " . $conn->error;
    }
    
    // Удаляем сообщения в базе на которые посетитель не ответил. Сервисные приветственные сообщения.
    $datatimeHour = $datatime-3600;
    $sql = "SELECT * FROM `chat` WHERE datatime<$datatimeHour GROUP BY `user_cookie` HAVING COUNT(*) = 1";
    if($result = $conn->query($sql)){
        $rowsCount = $result->num_rows; // количество полученных строк
        if($rowsCount>0){
            foreach($result as $row){
                $id_chat = $row['id'];
                $sql = "DELETE FROM `chat` WHERE id='$id_chat'";
                $conn->query($sql);
            }
        }
    }
    
    $conn->close();
    
}


if(isset($_GET['action']) && $_GET['action']=='new_mes'){
    $user_cookie = $_GET['user_cookie'];
    $user_mes = $_GET['user_mes'];
    $contact_phone = '';
    $contact_mail = '';
    $contact_name = '';
    $id_client_amo = 0;
    $yclid = $_GET['yclid'];
    
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
    
    //$sql = "SELECT * FROM chat WHERE user_cookie = '$user_cookie' && id_client_amo != '0' ORDER BY datatime";
    $sql = "SELECT * FROM chat WHERE user_cookie = '$user_cookie' && phone != '' ORDER BY datatime";
    if($result = $conn->query($sql)){
        $rowsCount = $result->num_rows; // количество полученных строк
        if($rowsCount!=0){
            foreach($result as $row){ 
                $id_client_amo = $row["id_client_amo"]; 
                $contact_phone = $row["phone"];
                $contact_name = $row["name"];
            }
        }
    }
    if (is_phone_search_text($user_mes)[0]!=''){ $contact_phone = is_phone_search_text($user_mes)[0]; }
    if($rowsCount==0 && is_phone_search_text($user_mes)[0]==''){ $contact_form = 1; } else { $contact_form = 0; }
    $name = 'user_cookie, autor, mes, contact_form, utm_source, utm_medium, utm_campaign, utm_content, utm_term, name, email, phone, id_client_amo, yclid';
    $data = "'".$user_cookie."', 'user', '".$user_mes."', '".$contact_form."', '".$utm_source."', '".$utm_medium."', '".$utm_campaign."', '".$utm_content."', '".$utm_term."', '".$contact_name."', '".$contact_mail."', '".$contact_phone."', '".$id_client_amo."', '".$user_cookie."'";
            
    $datatime = time();
    $a = "(datatime,".$name.")";
    $b = "('".$datatime."',".$data.")";
            
    $sql = "INSERT INTO chat $a VALUES $b"; 
    if($conn->query($sql)){ 
        $id_mess = $conn->insert_id;
        /*echo "Данные успешно добавлены";*/
        if($rowsCount==0){
            /*echo "Есть номер телефона в сообщении";*/
            if (is_phone_search_text($user_mes)[0]!=''){
                echo '<div class="servise-mes-contact">Ваш номер телефона '.is_phone_search_text($user_mes)[0].'</div>';
                echo $sh_servise_contact_phone_user.$konvers_mes;
                $mes = $user_mes;
                //include 'save_amo.php';
                include 'save_lead.php';
                $sql = "UPDATE chat SET contact_form = '0', id_client_amo = '$id_client', save_crm = '1' WHERE id = '$id_mess'";
                $conn->query($sql);
            }
            else {
                echo $sh_servise_contact2;
                echo $chat_form_contact;
            }
            
        } 
        else {
            foreach($result as $row){ $id_client_crm = $row["id_client_crm"]; }
            //include 'save_mes_amo.php';
            include 'save_mes_lead.php';
            echo '<div class="mes-wrapper-user"> <div class="mes-user">'.$user_mes.'</div> </div><div class="message-time-user"> '.date("H:i",$datatime).' </div>';
            echo $keep_online_message;
        }
    
    } 
    else { echo "Ошибка: " . $conn->error; }
}

if(isset($_GET['action']) && $_GET['action']=='save_contact'){
    $user_cookie = $_GET['user_cookie'];
    $contact_mail = $_GET['contact_mail'];
    $contact_phone = $_GET['contact_phone'];
    $contact_name = $_GET['contact_name'];
    $sql = "SELECT * FROM chat WHERE user_cookie = '$user_cookie' && contact_form = '1'";
        if($result = $conn->query($sql)){
            
            foreach($result as $row){
                $mes = $row["mes"];
                echo '<div class="mes-wrapper-user"> <div class="mes-user">'.$row["mes"].'</div> </div>'; 
                echo '<div class="message-time-'.$row["autor"].'">'.date("H:i",$row["datatime"]).'</div>';
            }
            echo $sh_servise_contact3.$keep_online_message.$konvers_mes;
        }
    
    //include 'save_amo.php';
    include 'save_lead.php';
    $sql = "UPDATE chat SET contact_form = '0', name = '$contact_name', phone = '$contact_phone', email = '$contact_mail', id_client_amo = '$id_client', utm_source = '$utm_source', utm_medium = '$utm_medium', utm_campaign = '$utm_campaign', utm_content = '$utm_content', utm_term = '$utm_term', yclid = '$user_cookie', save_crm = '1' WHERE user_cookie = '$user_cookie' && contact_form = '1'";
    $conn->query($sql);
        
    
}





if(isset($_GET['action']) && $_GET['action']=='load_mes_vopros'){
    echo $sh_servise_vopros_varianty;
}









if(!isset($_GET['action'])){

    $sql = "SELECT * FROM `chat` GROUP BY `user_cookie` HAVING COUNT(*) > 1";
    if($result = $conn->query($sql)){
        echo $shablon_html_start;
        $rowsCount = $result->num_rows; // количество полученных строк
        echo '<p>Всего записей - '.$rowsCount.'<p>';  
        echo '<div class="chats">';
        foreach($result as $row){
            $user_cookie = $row['user_cookie'];
            $sqll = "SELECT * FROM `chat` WHERE user_cookie=$user_cookie";
            if($result2 = $conn->query($sqll)){
                echo '<div class="chat_mes">';
                foreach($result2 as $row2){
                    echo '<p>'.$row2["user_cookie"].' - '.$row2["autor"].' = '.$row2["mes"].'</p>';
                }
                echo '</div>';
            }
        }
        echo '</div>';
        echo $shablon_html_end;
    }
}

/*
<div class="first-message-date">18.01.2024</div>
            
            <div class="mes-wrapper-operator">
                <div class="chat_ava-operator">
                    <img src="https://roskod.ru/wp-content/uploads/2024/01/me79vbl3kc72stza26i42tmst9p7mflc.png" alt="Менеджер по работе с клиентами Надежда">
                </div>
                <div class="mes-operator">
                    <p class="operator-name">Менеджер по работе с клиентами Надежда </p>
                    Здравствуйте! 
Чем я могу Вам помочь?
Отвечу Вам здесь. Или напишите свой номер телефона, и я Вам сразу перезвоню!
                    
                </div>
                
            </div>
            <div class="message-time-operator">
                13:41
            </div>
            
            <div class="mes-wrapper-user">
                
                <div class="mes-user">
                    Вопрос посетителя
                </div>
                
            </div>
            <div class="message-time-user">
                13:41
            </div>
            
            <div class="servise-mes-contact">
                Извините, сейчас я не могу Вам ответить. Можете оставить мне свой номер телефона или Email, я свяжусь с Вами чуть позже!
            </div>
            
            <div class="chat_form_contact">
                <div class="contact_mail">
                    <svg data-v-7c7a3ea8="" data-v-1293f02c="" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-icon icon"><path data-v-7c7a3ea8="" d="M256 8C118.941 8 8 118.919 8 256c0 137.058 110.919 248 248 248 52.925 0 104.68-17.078 147.092-48.319 5.501-4.052 6.423-11.924 2.095-17.211l-5.074-6.198c-4.018-4.909-11.193-5.883-16.307-2.129C346.93 457.208 301.974 472 256 472c-119.373 0-216-96.607-216-216 0-119.375 96.607-216 216-216 118.445 0 216 80.024 216 200 0 72.873-52.819 108.241-116.065 108.241-19.734 0-23.695-10.816-19.503-33.868l32.07-164.071c1.449-7.411-4.226-14.302-11.777-14.302h-12.421a12 12 0 0 0-11.781 9.718c-2.294 11.846-2.86 13.464-3.861 25.647-11.729-27.078-38.639-43.023-73.375-43.023-68.044 0-133.176 62.95-133.176 157.027 0 61.587 33.915 98.354 90.723 98.354 39.729 0 70.601-24.278 86.633-46.982-1.211 27.786 17.455 42.213 45.975 42.213C453.089 378.954 504 321.729 504 240 504 103.814 393.863 8 256 8zm-37.92 342.627c-36.681 0-58.58-25.108-58.58-67.166 0-74.69 50.765-121.545 97.217-121.545 38.857 0 58.102 27.79 58.102 65.735 0 58.133-38.369 122.976-96.739 122.976z"></path></svg>
                    <input placeholder="Ваш Email">
                </div>
                <div class="contact_phone">
                    <i aria-hidden="true" class="icon icon-phone1"></i>
                    <input placeholder="Ваш телефон">
                </div>
                <div class="contact_button">
                    <button>Продолжить</button>
                </div>
            </div>
            
            <div class="keep-online-message">
                Спасибо Вам! Я постараюсь связаться с Вами как можно скорее.
            </div>
         */   
?>