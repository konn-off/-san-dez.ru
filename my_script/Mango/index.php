<style>
.call_info p {
    font-size: 14px;
}
.call_info img {
    width: 25px;
    margin-right: 10px;
}
.call_info {
    display: flex;
    justify-content: flex-start;
    align-items: center;
}
.call {
    display: flex;
    flex-direction: column;
    border: 1px solid #b1adad;
    padding: 5px;
    border-radius: 8px;
}
.call_play p {
    margin: 0;
    font-size: 14px;
    color: #797777;
}
</style>

<?php 
 
if(isset($_GET['phone'])){
    $phone = $_GET['phone'];
    echo $phone;


    $conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
    if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
    //echo "Подключение успешно установлено";

    $sql = "SELECT * FROM calls WHERE call_from = '".$phone."' || call_to = '".$phone."'";
    
    $result = $conn->query($sql);
    //$row = $result->fetch_array();

    while($row = $result->fetch_assoc())
    {
        
        //echo 'entry_id - '.$row['entry_id'];
        echo '<div class="all_calls">
            <div class="call">
                <div class="call_info">
                    <img src="https://san-dez.ru/my_script/Mango/';
                    if($row['call_direction']==1){echo 'incall.png">';}//входящий
                    if($row['call_direction']==2){echo 'outcall.png">';}//исходящий
                    if(trim($row['recording_id'])!=''){$recording_id=trim($row['recording_id']);
                        $gfg = time() + 300;
                        $url = 'https://app.mango-office.ru/vpbx/queries/recording/link/'.$recording_id.'/play/zgfl3zi0aq0klr28mnfxvdktet54uc9k/'.$gfg.'/';
                        //$url = $url.$row['recording_id'].'/play/zgfl3zi0aq0klr28mnfxvdktet54uc9k/'.$gfg.'/';
                        $sign = hash('sha256', 'zgfl3zi0aq0klr28mnfxvdktet54uc9k'.$gfg.$recording_id.'jevd4335ktfwa8vnl0a73lr84n3op2yy');
                        $url = $url.$sign;
                        echo '<a href="'.$url.'" target="_blank"><img src="https://san-dez.ru/my_script/Mango/play.png"></a>';
                    }
                    echo '<p>'.date("d.m / H:i:s",$row['create_time']).'</p>
                </div>
                <div class="call_play">
                    <p>';
                    if($row['entry_result']==1){echo 'Разговор состоялся';}
                    if($row['entry_result']==0){echo 'Звонок пропущен, разговор не состоялся';}
                    echo '</p>
                </div>
            </div>
        </div>';
    }

}


//MToxMDE1MjY2OToyMzgwODc0MzAyMDow
//MToxMDE1MjY2OToyMzgwNzAyOTA0Mjow
if(isset($_GET['play'])){

    $gfg = time() + 300;
    $url = 'https://app.mango-office.ru/vpbx/queries/recording/link/';
    $url = $url.$recording_id.'/play/zgfl3zi0aq0klr28mnfxvdktet54uc9k/'.$gfg.'/';
    $sign = hash('sha256', 'zgfl3zi0aq0klr28mnfxvdktet54uc9k'.$gfg.$recording_id.'jevd4335ktfwa8vnl0a73lr84n3op2yy');
    $url = $url.$sign;
    echo '<a href="'.$url.'" target="_blank">'.$url.'</a>';
    
    function getcontents($url){
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	//curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: text/html; charset=UTF-8'));
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    	//curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    	//curl_setopt($ch, CURLOPT_ENCODING, 'identity');
    	$output = curl_exec($ch);
    	curl_close($ch);
    }	
 
 
    //echo htmlentities(getcontents($url));
    
    
    //$text = file_get_contents($url);
    //$text = "\xEF\xBB\xBF" .  $text;
    //print_r( getcontents('https://app.mango-office.ru/vpbx/queries/recording/link/0d0a984b45c0/play/5f4dcaa765d61d8327deb882cf9'));
    //echo '<textarea>'.getcontents($url).'</textarea>';
    


    //echo '<audio controls="" autoplay="" name="media"><source src="'.$content.'" type="audio/mpeg"></audio>';
    
/*    
    $postParams = '{
         "body":"'.MToxMDE1MjY2OToyMzgwODc0MzAyMDow.'",
         "message_id":"'.$id_mes.'"
      }';
    
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://app.mango-office.ru/vpbx/queries/recording/post',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => POST,
      CURLOPT_POSTFIELDS => $postParams,
      //CURLOPT_HTTPHEADER => array( 'Authorization: '.$token ),
   ));
   
   $response = curl_exec($curl);

   curl_close($curl);  
   print_r(json_decode($response, true));
   
POST https://app.mango-office.ru/vpbx/queries/recording/post
 vpbx_api_key = 1234567890qwerty,
 sign = 1234567890qwert,
 json = { "recording_id": "d12a45f67b90c12345",
 "action": "play" }

*/ 
 
 
 
 
}

/*
<div class="all_calls">
    <div class="call">
        <div class="call_info">
            <img src="https://san-dez.ru/my_script/Mango/incall.png">
            <img src="https://san-dez.ru/my_script/Mango/play.png">
            <p>22.06 15:25:36</p>
        </div>
        <div class="call_play">
            <p>звонок успешен и разговор состоялся</p>
        </div>
    </div>
</div>
*/



















?>
















