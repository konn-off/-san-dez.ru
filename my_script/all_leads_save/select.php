<?
/*if(isset($_GET['men'])){
    setcookie('manager', $_GET["men"], strtotime('+1 days'), '/');
    echo '<meta http-equiv="refresh" content="0;url=https://san-dez.ru/my_script/all_leads_save/select.php">';
    die();
}

if(!$_COOKIE ['manager']){

    echo '<meta http-equiv="refresh" content="5;url=https://t.me/MirMil_bot?start=auth">';
    echo '<h3>Необходима авторизация. Сейчас откроется Телеграм бот.</h3>';
    die();
}
*/

$conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
//echo "Подключение успешно установлено";

if(isset($_GET['fiter_source'])){ $sd = '';
    $fiter_source = $_GET['fiter_source'];
}

//&& source IN ($fiter_source)   && status = 0

function phone_format($phone) 
{
    $phone = trim($phone);
 
    $res = preg_replace(
        array(
            '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{3})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
            '/[\+]?([7|8])[-|\s]?(\d{3})[-|\s]?(\d{3})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
            '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',
            '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{2})[-|\s]?(\d{2})[-|\s]?(\d{2})/',	
            '/[\+]?([7|8])[-|\s]?\([-|\s]?(\d{4})[-|\s]?\)[-|\s]?(\d{3})[-|\s]?(\d{3})/',
            '/[\+]?([7|8])[-|\s]?(\d{4})[-|\s]?(\d{3})[-|\s]?(\d{3})/',					
        ), 
        array(
            '7$2$3$4$5', 
            '7$2$3$4$5', 
            '7$2$3$4$5', 
            '7$2$3$4$5', 	
            '7$2$3$4', 
            '7$2$3$4', 
        ), 
        $phone
    );
    if(str_split($res)[0]==9){$res='7'.$res;}
    return $res;
}

function UPDATE_status($id){
     
  //  $sqlUp = "UPDATE all_leads SET status=1 WHERE id=$id";
  //  echo $conn->query($sqlUp);
}


$dateNow = date('Y-m-d'); 
$yesterday = date('Y-m-d',strtotime($dateNow)-86400);


$fiter_all = '';

if(isset($_GET['fiter_source'])){
    $fiter_all=$fiter_all."&& source IN (".$_GET['fiter_source'].")";
}
if(isset($_GET['fiter_utm_source'])){
    $fiter_all=$fiter_all."&& utm_source IN (".$_GET['fiter_utm_source'].")";
}









if(isset($_GET['phone'])){$stsusSQL = " phone=".$_GET['phone'];}
else{
    if(isset($_GET['povtor_lead'])){$stsusSQL = "&& povtor_lead=".$_GET['povtor_lead'];}else{$stsusSQL = "";}
}

if(isset($_GET['date_on']) && isset($_GET['date_off'])){ 
    $date_on = $_GET['date_on']; $date_on_s = strtotime($date_on);
    $date_off = $_GET['date_off']; $date_off_s = strtotime($date_off)+86400;$date_off_s_cost = strtotime($date_off);
}else {
    $date_on = $dateNow; $date_off = $dateNow;
    $date_on_s = strtotime($date_on);
    $date_off_s_cost = strtotime($date_off);
    $date_off_s = strtotime($date_off)+86400;
}

if(!isset($_GET['phone'])){
    //сделки по дате и фильту
    $sql_filters = "SELECT * FROM all_leads WHERE date BETWEEN  $date_on_s AND $date_off_s $stsusSQL ORDER BY date";
    
    //сделки по дате и фильту
    $sql = "SELECT * FROM all_leads WHERE date BETWEEN  $date_on_s AND $date_off_s $stsusSQL $fiter_all ORDER BY date";
    //расходы по дате и фильту
    $sql_cost = "SELECT * FROM all_leads_cost WHERE date_time BETWEEN  $date_on_s AND $date_off_s_cost";
}else{
    //сделки по фильту
    $sql_filters = "SELECT * FROM all_leads WHERE $stsusSQL ORDER BY date";
    
    //сделки по фильту
    $sql = "SELECT * FROM all_leads WHERE $stsusSQL $fiter_all ORDER BY date";
    //расходы по фильту
    $sql_cost = "SELECT * FROM all_leads_cost WHERE $stsusSQL";
}    
$result = $conn->query($sql);
$row = $result->fetch_array();
$result_filters = $conn->query($sql_filters);




$cost=0;
if(!isset($_GET['phone'])){
    $result_cost = $conn->query($sql_cost);
    
    while($row = $result_cost->fetch_assoc())
    {
        $cost = $cost+$row['cost'];
    }
}
//$date_cost = $date_on.'/'.$date_off;
//echo $date_cost;
?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявки на san-dez.ru</title>
    <link rel="stylesheet" href="style.css?v=7">
    
    <meta property="og:title" content="Заявки Дезинфекция">
    <meta property="og:description" content="Заявки и сообщения Дезинфекция">
    <!--meta property="og:image" content="https://example.com/image.jpg">
    <meta property="og:url" content="https://example.com/"-->
    
    <!-- Novofon -->
    <!--script type="text/javascript" async src="https://widget.novofon.ru/novofon.js?k=OfZE5XLH0Qf3SOsaIPnGC8adNDpccWWS"></script-->
<!-- Novofon -->

    <!--script src="https://cdn.onesignal.com/sdks/web/v16/OneSignalSDK.page.js" defer></script>
    <script>
      window.OneSignalDeferred = window.OneSignalDeferred || [];
      OneSignalDeferred.push(async function(OneSignal) {
        await OneSignal.init({
          appId: "3865f40a-a3ce-4230-bce8-85507a9feffa",
          safari_web_id: "web.onesignal.auto.4463433a-b41c-4a34-809b-879a9d93883b",
          notifyButton: {
            enable: true,
            size: 'medium',
          },
        });
      });
    </script-->
    
</head>
<body>
    <header>
      <div class='date_div'>
          Работает с 21-06-2024 
          <a href="?date_on=<? echo date("Y-m-d",strtotime($date_on)-86400);?>&date_off=<? echo date("Y-m-d",strtotime($date_on)-86400);?>"><button class='date_but_nazad'><-</button></a>
          <a href="?date_on=<? echo date("Y-m-d",strtotime($date_on)+86400);?>&date_off=<? echo date("Y-m-d",strtotime($date_on)+86400);?>"><button class='date_but_pered'>-></button></a>
          <input type='date' name='date_on' class='date_on' value='<? echo $date_on;?>' />
          <input type='date' name='date_off' class='date_off' value='<? echo $date_off;?>' />
          <button class='date_but'>ok</button>
          Всего записей <? echo $result->num_rows; ?>
          <a href="https://san-dez.ru/my_script/all_leads_save/select.php?date_on=<? echo $yesterday;?>&date_off=<? echo $yesterday;?>">Вчера</a>
          <a href="https://san-dez.ru/my_script/all_leads_save/select.php?date_on=<? echo $dateNow;?>&date_off=<? echo $dateNow;?>">Сегодня</a>
          <? 
          if(isset($_GET['povtor_lead']) && $_GET['povtor_lead']==0){
            echo '<a href="https://san-dez.ru/my_script/all_leads_save/select.php?date_on='.$date_on.'&date_off='.$date_off.'"><button class="in_duble">Показать дубли</button></a>';
          } 
          else {
            echo '<a href="https://san-dez.ru/my_script/all_leads_save/select.php?date_on='.$date_on.'&date_off='.$date_off.'&povtor_lead=0"><button class="out_duble">Скрыть дубли</button></a>';  
          }
         
          ?>
            <input type="text" name="search" id="search" placeholder="Поиск по телефону" <?php if(isset($_GET['phone'])){echo 'value="'.$_GET['phone'].'"';}?>  />
            <?php if(isset($_GET['phone'])){
                echo '<span><img src="img/close.png" class="close_search"></span>';
                
            }?>
            <button class="search_but">Поиск</button>

          
        </div>
    </header>
    <main>
        <article>
            <section>
                <div class='close'></div>
                <table class='ttt'>
                <tr>
                    <th class="t_date">Дата/время</th>
                    <th>Оператор</th>
                    <th>ID crm</th>
                    <th>Статус</th>
                    <th>Звонки</th>
                    <th class="t_comment">Комментарий</th>
                    <th>Выручка</th>
                    <th>Стоимость</th>
                    <th>Маржа</th>
                    <th class="t_title">Название зделки</th>
                    <th>Имя</th>
                    <th>Mail</th>
                    <th>Телефон</th>
                    <th><span class="source <? if(isset($_GET['fiter_source'])){echo ' sale'; $fil = explode(',',str_replace('"','',$_GET['fiter_source']));} ?>">Источник</span>
                        <div class='filter_source'>
                            <?
                            $ds = array();
                            foreach($result_filters as $row){ $ds[] = $row['source']; }
                            $source = array(); $q=0;  
                            foreach($result_filters as $row){
                                if(!in_array($row['source'], $source)){
                                    $source[] = $row['source'];
                                    echo '<div>'.count(array_keys($ds, $row['source'])).'<input type="checkbox" id="source_'.$q.'" name="source" value="'.$row['source'].'"';  if(isset($_GET['fiter_source']) && in_array($row['source'],$fil)){echo ' checked';} echo '/><label for="source_'.$q.'">'.$row['source'].'</label></div>';
                                    $q++;
                                }
                            }
                            ?>
                            
                            <div><button class='filter_source_but'>показать</button></div>
                        </div>
                    </th>
                    <th><span class="site">Сайт</span>
                        <div class='filter_site'>
                            <?
                            $ds = array();
                            foreach($result_filters as $row){ $ds[] = $row['site']; }
                            $site = array(); $q=0;  
                            foreach($result_filters as $row){
                                if(!in_array($row['site'], $site)){
                                    $site[] = $row['site'];
                                    echo '<div>'.count(array_keys($ds, $row['site'])).'<input type="checkbox" id="site_'.$q.'" name="site" value="'.$row['site'].'" /><label for="site_'.$q.'">'.$row['site'].'</label></div>';
                                    $q++;
                                }
                            }
                            ?>
                            
                            <div><button class='filter_site_but'>показать</button></div>
                        </div>
                    </th>
                    <th>URL</th>
                    <th><span class="utm_source <? if(isset($_GET['fiter_utm_source'])){echo ' sale'; $fil = explode(',',str_replace('"','',$_GET['fiter_utm_source']));} ?>">utm_source</span>
                        <div class='filter_utm_source'>
                            <?
                            $ds = array();
                            foreach($result_filters as $row){ $ds[] = urldecode($row['utm_source']); }
                            $source = array(); $q=0;  
                            foreach($result_filters as $row){
                                if(!in_array(urldecode($row['utm_source']), $source)){
                                    $source[] = urldecode($row['utm_source']);
                                    echo '<div>'.count(array_keys($ds, urldecode($row['utm_source']))).'<input type="checkbox" id="utm_source_'.$q.'" name="utm_source" value="'.$row['utm_source'].'"';  if(isset($_GET['fiter_utm_source']) && in_array($row['utm_source'],$fil)){echo ' checked';} echo '/><label for="utm_source_'.$q.'">'.urldecode($row['utm_source']).'</label></div>';
                                    $q++;
                                }
                            }
                            ?>
                            
                            <div><button class='filter_utm_source_but'>показать</button></div>
                        </div>
                    </th>
                    <th><span class="utm_medium">utm_medium</span>
                        <div class='filter_utm_medium'>
                            <?
                            $ds = array();
                            foreach($result_filters as $row){ $ds[] = urldecode($row['utm_medium']); }
                            $source = array(); $q=0;  
                            foreach($result_filters as $row){
                                if(!in_array(urldecode($row['utm_medium']), $source)){
                                    $source[] = urldecode($row['utm_medium']);
                                    echo '<div>'.count(array_keys($ds, urldecode($row['utm_medium']))).'<input type="checkbox" id="utm_medium_'.$q.'" name="utm_medium" value="'.$row['utm_medium'].'" /><label for="utm_medium_'.$q.'">'.urldecode($row['utm_medium']).'</label></div>';
                                    $q++;
                                }
                            }
                            ?>
                            
                            <div><button class='filter_utm_medium_but'>показать</button></div>
                        </div>
                    </th>
                    <th><span class="utm_campaign">utm_campaign</span>
                        <div class='filter_utm_campaign'>
                            <?
                            $ds = array();
                            foreach($result_filters as $row){ $ds[] = urldecode($row['utm_campaign']); }
                            $source = array(); $q=0;  
                            foreach($result_filters as $row){
                                if(!in_array(urldecode($row['utm_campaign']), $source)){
                                    $source[] = $row['utm_campaign'];
                                    echo '<div>'.count(array_keys($ds, urldecode($row['utm_campaign']))).'<input type="checkbox" id="utm_campaign_'.$q.'" name="utm_campaign" value="'.$row['utm_campaign'].'" /><label for="utm_campaign_'.$q.'">'.urldecode($row['utm_campaign']).'</label></div>';
                                    $q++;
                                }
                            }
                            ?>
                            
                            <div><button class='filter_utm_campaign_but'>показать</button></div>
                        </div>
                    </th>
                    <th><span class="utm_content">utm_content</span>
                        <div class='filter_utm_content'>
                            <?
                            $ds = array();
                            foreach($result_filters as $row){ $ds[] = urldecode($row['utm_content']); }
                            $source = array(); $q=0;  
                            foreach($result_filters as $row){
                                if(!in_array(urldecode($row['utm_content']), $source)){
                                    $source[] = urldecode($row['utm_content']);
                                    echo '<div>'.count(array_keys($ds, urldecode($row['utm_content']))).'<input type="checkbox" id="utm_content_'.$q.'" name="utm_content" value="'.$row['utm_content'].'" /><label for="utm_content_'.$q.'">'.urldecode($row['utm_content']).'</label></div>';
                                    $q++;
                                }
                            }
                            ?>
                            
                            <div><button class='filter_utm_content_but'>показать</button></div>
                        </div>
                    </th>
                    <th><span class="utm_term">utm_term</span>
                        <div class='filter_utm_term'>
                            <?
                            $ds = array();
                            foreach($result_filters as $row){ $ds[] = urldecode($row['utm_term']); }
                            $source = array(); $q=0;  
                            foreach($result_filters as $row){
                                if(!in_array(urldecode($row['utm_term']), $source)){
                                    $source[] = urldecode($row['utm_term']);
                                    echo '<div>'.count(array_keys($ds, urldecode($row['utm_term']))).'<input type="checkbox" id="utm_term_'.$q.'" name="utm_term" value="'.$row['utm_term'].'" /><label for="utm_term_'.$q.'">'.urldecode($row['utm_term']).'</label></div>';
                                    $q++;
                                }
                            }
                            ?>
                            
                            <div><button class='filter_utm_term_but'>показать</button></div>
                        </div>
                    </th>
                    <th>roistat</th>
                    <th>ycid</th>
                    
                </tr> <!--ряд с ячейками заголовков-->
<?
$result = $conn->query($sql);
$row = $result->fetch_array();
if($result->num_rows > 0){
    $base_phone = array();
    $spam = 0;
    $all_lead = 0;
    $sale_lead = 0;
    $oform_lead = 0;
    $neoform_lead = 0;
    $work_lead = 0;
    $otmena_lead = 0;
    $price_all = 0;
    $cost_all = 0;

    foreach($result as $row){
        $all_lead++;
        $id=$row['id'];
        $messenger_activ = '';
        if($row['chat_id_max']!=''){
            $messenger_activ = 'max';
        }
        if($row['chat_id_tg']!=''){
            $messenger_activ = 'tg';
        }
        if(in_array(phone_format($row['phone']), $base_phone)){ $stat=1;} else {$stat=0;}
        echo "
        <tr "; if($row['povtor_lead']==1){ echo 'class="duble"'; }  echo ">
            <td>".date("d-m-Y H:i:s",$row['date'])."</td>
            <td>".$row['manager_id']."</td>
            <td>"; if($row['id_crm'] != ''){echo $row['id_crm'];}else{echo "<img class='insert_lead_roistat' data-id='".$id."' src='img/send.png' title='Отправить контакт в CRM'>";} echo "</td>
            
            <td "; if($stat==0 && $row['status']=='2'){echo 'class="work"'; $work_lead++;}
            if($stat==0 && $row['status']=='-1'){echo 'class="oform"'; $oform_lead++;}
            if($stat==0 && $row['status']=='-9'){echo 'class="sale"'; $sale_lead++;}
            if($stat==0 && $row['status']=='-99'){echo 'class="otmena"'; $otmena_lead++;}
            if($stat==0 && $row['status']=='6'){echo 'class="neoform"'; $neoform_lead++;}
            if($stat==0 && $row['status']=='3' || $stat==0 && $row['status']=='5' || $stat==0 && $row['status']=='8'){echo 'class="spam"'; $spam++;} echo" >";
            if($row['status']==''){echo "--";}
            if($row['status']=='1'){echo "Новые звонки Mango";}
            if($row['status']=='8'){echo "Дубликат";}
            if($row['status']=='2'){echo "Взято в работу";}
            if($row['status']=='3'){echo "Спам-Повторный звонок";}
            if($row['status']=='5'){echo "Автодозвон";}
            if($row['status']=='4'){echo "Коллбек";}
            if($row['status']=='-9'){echo "Выполненная";}
            if($row['status']=='-99'){echo "Отклоненная";}
            if($row['status']=='-1'){echo "Оформленная";}
            if($row['status']=='6'){echo "Не оформлен";}
            $ghgj = $row['phone'];
            echo "</td><td>";
            
            if($ghgj != ''){
                echo "<div class='calls_lead' data-phone='".$ghgj."'><img src='https://san-dez.ru/my_script/Mango/outcall.png'> ";
                $sqlCall = "SELECT * FROM calls WHERE call_from = '".$ghgj."' || call_to = '".$ghgj."'";
                $resultCall = $conn->query($sqlCall);
                echo $resultCall->num_rows."</div>";
            }
            echo "</td>
            <td><div id='coment' data-id='".$id."' contenteditable='true'>".$row['coment']."</div></td>
            <!--td><input type='text' name='price' value='".$row['price']."' id='earnings' data-id='".$id."'></td-->
            <td>".$row['price']."</td>";
            $price_all= $price_all + $row['price']; echo "
            <td>".$row['cost']."</td>";
            $cost_all= $cost_all + $row['cost'];
            $marzha = $row['price']-$row['cost']; echo "
            <td>".$marzha."</td>
            <td>".$row['name_leads']; if($row['dialogId']!= 'В WhatsApp не существует пользователя с таким номером'){echo "<button class='but_wz_sent' data-id_crm='".$row['id_crm']."' id='".$row['dialogId']."' data-phone='".$row['phone']."' data-chat_id_max='".$row['chat_id_max']."' data-chat_id_tg='".$row['chat_id_tg']."'  data-messenger_activ='".$messenger_activ."'>Написать</button>";} if($row['dialog_wiev']==1){echo '<img class="new_mes" src="img/whatsapp_icon.png">';} echo "</td>
            <td>".$row['name']."</td>
            <td>".$row['mail']."</td>
            <td class='td_phone'><p>".$row['phone'];
            
            $phone_filters = "SELECT * FROM all_leads WHERE phone = $ghgj";
            $result_phone_filters = $conn->query($phone_filters);
            if($result_phone_filters->num_rows > 1 && !isset($_GET['phone'])){
                echo "<img src='img/magnifier.png' class='search_phone' data-phone='".$row['phone']."'>";
            }
            
            echo "</p></td>
            <td>".$row['source']."</td>
            <td>".$row['site']."</td>
            <td>".$row['url']."</td>
            <td>".urldecode($row['utm_source'])."</td>
            <td>".urldecode($row['utm_medium'])."</td>
            <td>".urldecode($row['utm_campaign'])."</td>
            <td>".urldecode($row['utm_content'])."</td>
            <td>".urldecode($row['utm_term'])."</td>
            <td>".$row['roistat']."</td>
            <td>".$row['ycid']."</td>
            
        </tr> <!--ряд с ячейками тела таблицы-->"; 
        $base_phone[] = phone_format($row['phone']);
        
    }
}
$conn->close();
?>
                </table>
                
                
                <div class="stata">
                    <span class="stata_t">Всего <? echo $result->num_rows; ?></span>
                    
                    <span class="stata_t">Спам/повтор: <? echo $spam;?>шт. / CR <? echo round($spam / $all_lead*100, 1);?>%</span>
                    <span class="stata_t">Выпол/оформ: <? echo $sale_lead;?>шт. / <? echo $oform_lead;?>шт. / CR <? echo round($sale_lead / $all_lead*100, 1);?>%.</span>
                    <span class="stata_t">Выручка: <? echo $price_all;?>р.</span>
                    <span class="stata_t">Ср чек: <? echo round($price_all/$sale_lead);?>р.</span>
                    <span class="stata_t">Расход: <? echo $cost;?>р</span>
                    <span class="stata_t">CPL: <? echo round($cost / $all_lead);?>р</span>
                    <span class="stata_t">CPO: <? echo round($cost / $sale_lead);?>р</span>
                    <span class="stata_t">Прибыль: <? echo round($price_all - $cost_all - $cost);?>р</span>
                </div>
            </section>
        </article>
    </main>
    <footer>
      <div class="block_mes_wz">
          <div class="fghj">
        <span class="close_block_mes_wz"><img src="img/close.png"></span> <span class="id_crm"></span><span class="wz_phone"></span><span class="view_mes" title="Отметить прочитано"><img src="img/view-watch.png"></span></div>
        <div class="vibor_messenger_block">
            <div><p class="wz_name"></p></div>
            <div class="vibor_messenger_but">
                <!--p><img src="img/WhatsApp.png" class="but_messenger_wz" data-status_messenger=""></p-->
                <p><img src="img/Max.png" class="but_messenger_max" data-status_messenger=""></p>
                <p><img src="img/Tg.png" class="but_messenger_tg" data-status_messenger=""></p>
            </div>
            
        </div>
        <div class="mes_wz">
            <!--div class="mes-client">Здравствуйте! Отправьте это сообщение и я сразу пришлю цены на дезинсекцию тараканов и клопов. Код на скидку - 166433
                <p class="date">17:13</p>
            </div>
            <div class="mes-manager">Добрый день,занимаюсь тем же   
                <p class="date">17:15</p>
            </div-->
        </div>
        <div class="shablon_mes_wz">
            <p>Здравствуйте! От каких насекомых нужна обработка?</p>
            <p>Сколько комнат? Какой город?</p>
            <p>Вам когда нужно сделать обработку?</p>
            <p>Напишите Ваш номер телефона</p>
            <p>Необходимо подготовить помещение к обработке, нужно убрать предметы личной гигиены и продукты питания с открытого доступа, всё остальное оставляете на своих местах, необходимо покинуть помещение всем без исключений в целях безопасности на время проведения работ и проветривания, примерно на 1,5–2 часа, после вернуться и провести влажную уборку, заменить постельное белье и перестирать его не менее 60 градусов.</p>
            <p>Необходимо подготовить помещение к обработке, нужно убрать предметы личной гигиены и продукты питания с открытого доступа и максимально освободить на кухне напольные и навесные шкафчики от всего содержимого, чтобы мастер смог тщательно всё обработать, необходимо покинуть помещение всем без исключений в целях безопасности на время проведения работ и проветривания, примерно на 1,5–2 часа, после вернуться и провести влажную уборку, и будет безопасно.</p>
            <p>Есть два способа обработки:

1- механический, используется помповый распылитель, обработка проводится точечно по местам скопления насекомых. Стоимость 1000 рублей.

2- генератор холодного тумана, автоматическое распыление средства под высоким давлением, за счет чего попадает во все труднодоступные места. Стоимость 1800 рублей.

Можно будет уже на адресе со специалистом определиться по способу, у него оба варианта всегда с собой.

Гарантия 3 года по договору, договор подписывается перед обработкой с мастером.</p>
            <p>На какой день и время Вас записать?</p>
            <p>Здравствуйте. Это Центр дезинфекции.
Подскажите, пожалуйста: 
1) в каком городе вы находитесь
2) скольки комнатная квартира 
3) от каких вредителей необходима обработка?
И я Вас смогу сориентировать по стоимости.</p>
            <p>Есть обработка в таком случае препаратами перетроидами, они используются в больницах при лежачих больных а это значит что они максимально безопасны для людей и животных НО максимально эффективны для насекомых. 
При такой обработке не нужно покидать помещение, после обработки влажная уборка минимальная и замена постельного белья. 
По цене за всю квартиру 7600р будет стоить</p>
            <!--p>Записала Вас на  . Специалист свяжется с Вами заранее, обычно звонит за час до выезда. +7 (812) 507-83-01- номер телефона колл-центра (работает круглосуточно). в случае возникновения каких-либо вопросов можете также звонить по этому номеру.</p-->
            <!--p>Записала Вас на  . Специалист свяжется с Вами заранее, обычно звонит за час до выезда. +7 (499) 490-69-79, +7 (499) 346-78-47 -
номер телефона колл-центра (работает круглосуточно). в случае возникновения каких-либо вопросов можете также звонить по этому номеру.</p-->
<p>Записала Вас на  . Специалист свяжется с Вами заранее, обычно звонит за час до выезда. +79923298324- номер телефона колл-центра (работает круглосуточно). в случае возникновения каких-либо вопросов можете также звонить по этому номеру.</p>
<p>через 7-10 дней возможно потребуется повторная, это будет зависеть от стадии заражения, мастер после осмотра даст рекомендации и пропишет их в договоре. На повторную обработку 50% скидка предоставляется. Обычно рекомендуем  в целях профилактики сделать повторную обработку, даже если насекомых больше нет после первичной</p>
            <p>Напишите, пожалуйста, полностью Ваш адрес, и ваше имя, и контактный номер телефона</p>
            <p>Здравствуйте, в этом месяце действует уникальное предложение: обработка + защитный барьер в подарок — это дополнительная присадка к основной обработке, защищает помещение от проникновения насекомых 1,5-2 года. Срок действия до 30.05, торопитесь сделать обработку, пока есть свободные места. Быстро. Качественно. Гарантия.</p>
            <p>Гарантия 3 года по договору, договор подписывается перед обработкой с мастером.</p>
            <p>Мы официальная компания, препараты профессиональные сертифицированные, имеется лицензия! Мастер предоставит договор с гарантией 3 года. Вам совершенно нечего опасаться.</p>
            <p>У нас есть несколько способов обработки:
1 способ – это размещение специализированной отравы-приманки, 
2 способ - выгон грызунов химическим продувом под давлением с помощью мобильного
 распылителя,
3 способ – монтаж ловушек, 
4 способ также возможна обработка специализированной пеной.
По стоимости один из способов будет … (в зависимости от помещения) По способу 
обработки можно определиться с мастером на месте: у него все с собой, он произведет 
полный осмотр помещения и даст рекомендации по способу.</p>
<p>Это базовая обработка за всю квартиру, при начальной стадии вполне достаточно. Можно сделать усиленную двойную или тройную ( 2х или 3х компонентную) то и оплата будет двойная или тройная соответственно. После осмотра, выявления стадии заражения мастер обязан вам предложить разные варианты обработки далее уже ваш выбор.</p>
        </div>
        <div class="mes_wz_sent">
            <div class="reply_mes_text">
                <span>"Сообщение на которое я отвечаю..."</span>
                <img src="img/close.png">
            </div>
            
            <textarea></textarea>
            <input type="hidden" class="wz_chat_open" value="0">
            <input type="hidden" class="wz_dialogId">
            <input type="hidden" class="wz_chat_id_max">
            <input type="hidden" class="wz_chat_id_tg">
            <input type="hidden" class="wz_messenger_activ">
            <div class="fghj">
                <p>
                    <button class="but_mes_sent" data-type_mes="text">Отправить</button>
                    
                    <div class="but_mes_file"><svg width="19" height="20" viewBox="0 0 19 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M17.654 9.71218L10.2369 17.1293C8.20292 19.1632 4.90517 19.1632 2.87119 17.1293C0.837208 15.0952 0.837208 11.7975 2.87119 9.76353L9.99135 2.64336C11.3474 1.28738 13.5458 1.28738 14.9019 2.64336C16.2578 3.99935 16.2578 6.19784 14.9019 7.55383L7.79312 14.6626C7.11508 15.3406 6.01583 15.3406 5.33784 14.6626C4.65984 13.9846 4.65984 12.8853 5.33784 12.2074L11.8185 5.72668" stroke="#333" stroke-width="2.08333" stroke-linecap="round" stroke-linejoin="round"></path></svg>
                    </div>
                    <input type="file" id="js-file">
                </p>
                <p style="text-align:right;">
                    <button class="but_mes_shablon">Шаблоны</button>
                </p>
            </div>
        </div>
      </div>
      <div class="blok_notifications">
          <!--div class="new_mes_noti" data-id_mes="123455">
              <p class="close_new_mes_noti"><img src="img/close.png"></p>
              <div class="info_new_mes_noti"><span>bodrovae83</span> <span>P475000</span></div>
              <p>Скажите пожалуйста, а чем обработка будет?
И через сколько можно заходить в квартиру?</p>
          </div>
          <div class="new_mes_noti" data-id_mes="P474923">
              <p class="close_new_mes_noti"><img src="img/close.png"></p>
              <div class="info_new_mes_noti"><span>Мухаммадякуб</span> <span>P475000</span></div>
              <p>Я очень прошу вас. Что пусть хорошее лекарство брат ваш специалист.
Ато наш начальник потом мне не говорил что почему до сехпор есть клопов.</p>
          </div>
          <div class="new_mes_noti" data-id_mes="P474895">
              <p class="close_new_mes_noti"><img src="img/close.png"></p>
              <div class="info_new_mes_noti"><span>raifkorenov</span> <span>P475000</span></div>
              <p>Добрый день меня зовут раиф надо избавиться от клопов Чебоксары комната</div>
          </div-->
      </div>
        <div class="bg_fon"></div>
        <div class="calls_leads_info"></div>
        <audio id="notification-sound" src="https://san-dez.ru/my_script/all_leads_save/img/melodic-sms-notification.mp3"></audio>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="app_Max_Tg.js?v=5" defer></script> 
    
    <!--script src="//code.jivo.ru/widget/lAwj8ShwjY" async></script-->
    
    

</body>
</html>




