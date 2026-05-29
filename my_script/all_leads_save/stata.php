<?

$conn = new mysqli("localhost", "j0967975_sandez", "pxK&5sk2#U", "j0967975_sandez");
if($conn->connect_error){ die("Ошибка: " . $conn->connect_error); }
//echo "Подключение успешно установлено";

if(isset($_GET['fiter_source'])){ $sd = '';
    $fiter_source = $_GET['fiter_source'];
}

//&& source IN ($fiter_source)   && status = 0






$dateNow = date('Y-m-d'); 
$yesterday = date('Y-m-d',strtotime($dateNow)-86400);

//if(isset($_GET['povtor_lead'])){$stsusSQL = "&& povtor_lead=".$_GET['povtor_lead'];}else{$stsusSQL = "";}

if(isset($_GET['date_on']) && isset($_GET['date_off'])){ 
    $date_on = $_GET['date_on']; $date_on_s = strtotime($date_on);
    $date_off = $_GET['date_off']; $date_off_s = strtotime($date_off)+86399;$date_off_s_cost = strtotime($date_off);
}else {
    $date_on = date('Y-m').'-01'; $date_off = $dateNow;
    $date_on_s = strtotime($date_on);
    $date_off_s_cost = strtotime($date_off);
    $date_off_s = strtotime($date_off)+86399;
}

//сделки по дате и фильту
$sql = "SELECT * FROM all_leads WHERE date BETWEEN  $date_on_s AND $date_off_s && povtor_lead=0 ORDER BY date";
//расходы по дате и фильту
$sql_cost = "SELECT * FROM all_leads_cost WHERE date_time BETWEEN  $date_on_s AND $date_off_s_cost";
    
$result = $conn->query($sql);
$row = $result->fetch_array();
$row2 = $row;

$cost=0;
$result_cost = $conn->query($sql_cost);

while($row = $result_cost->fetch_assoc())
{
    $cost = $cost+$row['cost'];
}

//$date_cost = $date_on.'/'.$date_off;
//echo $date_cost;




    



function getDatesFromRange($start, $end, $format = 'd-m-Y') {
    $array = array();
    $interval = new DateInterval('P1D');

    $realEnd = new DateTime($end);
    $realEnd->add($interval);

    $period = new DatePeriod(new DateTime($start), $interval, $realEnd);

    foreach($period as $date) { 
        $array[] = $date->format($format); 
    }

    return $array;
}

    
$DatesFromTo = getDatesFromRange($date_on, $date_off);

$day_week = array('ВС', 'ПН', 'ВТ', 'СР', 'ЧТ','ПТ','СБ');


?>


<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Статистика san-dez.ru</title>
    <link rel="stylesheet" href="style.css">
    
    <meta property="og:title" content="Заголовок страницы в OG">
    <meta property="og:description" content="Описание страницы в OG">
    <meta property="og:image" content="https://example.com/image.jpg">
    <meta property="og:url" content="https://example.com/">
</head>
<body>
    <header>
        <div class='date_div'>
            Работает с 21-06-2024
            <input type='date' name='date_on' class='date_on' value='<? echo $date_on;?>' />
            <input type='date' name='date_off' class='date_off' value='<? echo $date_off;?>' />
            <button class='date_but'>ok</button>
            Всего записей <? echo $result->num_rows; ?>
            <a href="https://san-dez.ru/my_script/all_leads_save/stata.php?date_on=<? echo $yesterday;?>&date_off=<? echo $yesterday;?>">Вчера</a>
            <a href="https://san-dez.ru/my_script/all_leads_save/stata.php?date_on=<? echo $dateNow;?>&date_off=<? echo $dateNow;?>">Сегодня</a>
            <div class="insert_cost_form">
                <textarea></textarea>
                <button>Добавить</button>
            </div>
            <select name="table_vid">
                <option value="table_all" <? if(!isset($_GET['table_vid']) || $_GET['table_vid'] != 'table_day'){ echo 'selected'; } ?> >За период</option>
                <option value="table_day" <? if(isset($_GET['table_vid']) && $_GET['table_vid'] == 'table_day'){ echo 'selected'; } ?> >По дням</option>
            </select>
            <button class="insert_cost">Загрузить расходы</button>
          
        </div>
    </header>
    <main>
        <article>
            <section>
                <table class='ttt'>
                    <tr>
                        <th class="t_date">Дата</th>
                        <th>utm_source</th>
                        <th>utm_campaign</th>
                        <th>utm_content</th>
                        <th>Сделки</th>
                        <th class="table_spam">Спам</th>
                        <th class="table_spam">%</th>
                        <th>НЕ Спам</th>
                        <th class="table_oform">Оформ</th>
                        <th class="table_oform">%</th>
                        <th class="table_sale">Вып</th>
                        <th class="table_sale">%</th>
                        <th class="table_otmen">Отмен</th>
                        <th class="table_otmen">%</th>
                        <th class="table_otmen">Не оформ</th>
                        <th class="table_otmen">%</th>
                        <th>В работе</th>
                        <th>%</th>
                        <th>Расход</th>
                        <th>Выручка</th>
                        <th class="table_prib">Прибыль</th>
                        <th>CPL</th>
                        <th>CPO</th>
                        <th>Ср чек</th>
                        <th>Показы</th>
                        <th>Переходы</th>
                        <th>CTR%</th>
                        <th>CPC</th>
                        <th>CR%</th>
                    </tr>
                
<?
$col = 0; 
//if(isset($_GET['table_vid']) && $_GET['table_vid'] == 'table_day'){
    foreach ($DatesFromTo as $key => $value) { $col++;  
        $date_on_s = strtotime($value);
        $date_off_s = strtotime($value)+86400;
        $sqlData = "SELECT * FROM all_leads WHERE date BETWEEN $date_on_s AND $date_off_s && povtor_lead=0 ORDER BY date";
        $resultData = $conn->query($sqlData);
        $leads = $resultData->num_rows; 
        $spam_l = 0; $oform_l = 0; $sale_l = 0; $otmen_l = 0; $ne_oform_l = 0; $work_l = 0;  $price_l = 0; $cost_sd = 0; $yandex_context = 0; $yandex_search = 0; $pryamoy_visit = 0;
        while($row = $resultData->fetch_assoc())
        {
            if($row['status']==3 || $row['status']==8){ $spam_l++; }
            if($row['status']=='-1'){ $oform_l++; }
            if($row['status']=='-9'){ $sale_l++; }
            if($row['status']=='-99'){ $otmen_l++; }
            if($row['status']==6){ $ne_oform_l++; }
            if($row['status']==1 || $row['status']==2 || $row['status']==4 || $row['status']==5){ $work_l++; }
            $price_l = $price_l+$row['price'];
            $cost_sd = $cost_sd+$row['cost'];
            if($row['utm_source']=='yandex_context'){ $yandex_context++; }
            if($row['utm_source']=='yandex_search'){ $yandex_search++; }
            if($row['utm_source']=='' || $row['utm_source']=='Прямой заход'){ $pryamoy_visit++; }
        }
        
        $spam_p = round(($spam_l/$leads)*100); $nespam_l = $leads-$spam_l; $oform_p = round(($oform_l/$nespam_l)*100); $sale_p = round(($sale_l/$nespam_l)*100);
        $otmen_p = round(($otmen_l/$nespam_l)*100); $ne_oform_p = round(($ne_oform_l/$nespam_l)*100); $work_p = round(($work_l/$nespam_l)*100);
        
        $sqlDataCost = "SELECT * FROM all_leads_cost WHERE date_time = $date_on_s";
        $resultDataCost = $conn->query($sqlDataCost);
        $view_l = 0; $click_l = 0; $cost_l = 0;
        while($row = $resultDataCost->fetch_assoc())
        {
            $view_l=$view_l+$row['view'];
            $click_l=$click_l+$row['click'];
            $cost_l=$cost_l+$row['cost'];
        }
        $cr_click = round(($click_l/$view_l)*100, 1);
        $cpc = round($cost_l/$click_l);
        $prib_l = $price_l-$cost_sd-$cost_l;
        $cpl = round($cost_l/$nespam_l);
        $cpo = round($cost_l/$sale_l);
        $cr_check = round($price_l/$sale_l); 
        $cr_site = round(($nespam_l/$click_l)*100, 1);
        
        echo '<tr class="table_day"><td>'.$value.' '.$day_week[date('w', strtotime($value))].'</td>
        <td><span class="table_open" id="table_hiddeh_'.$col.'">раскрыть</span></td>
        <td></td>
        <td></td>
        <td>'.$leads.'</td>
        <td class="table_spam">'.$spam_l.'</td>
        <td class="table_spam">'.$spam_p.'%</td>
        <td>'.$nespam_l.'</td>
        <td class="table_oform">'.$oform_l.'</td>
        <td class="table_oform">'.$oform_p.'%</td>
        <td class="table_sale">'.$sale_l.'</td>
        <td class="table_sale">'.$sale_p.'%</td>
        <td class="table_spam">'.$otmen_l.'</td>
        <td class="table_spam">'.$otmen_p.'%</td>
        <td class="table_spam">'.$ne_oform_l.'</td>
        <td class="table_spam">'.$ne_oform_p.'%</td>
        <td>'.$work_l.'</td>
        <td>'.$work_p.'%</td>
        <td>'.$cost_l.'</td>
        <td>'.$price_l.'</td>
        <td class="table_prib">'.$prib_l.'</td>
        <td>'.$cpl.'</td>
        <td>'.$cpo.'</td>
        <td>'.$cr_check.'</td>
        <td>'.$view_l.'</td>
        <td>'.$click_l.'</td>
        <td>'.$cr_click.'</td>
        <td>'.$cpc.'</td>
        <td>'.$cr_site.'</td>
        </tr>';
        
        if($yandex_search!=0){$col2=$col.'s';
            $sqlData = "SELECT * FROM all_leads WHERE date BETWEEN $date_on_s AND $date_off_s && povtor_lead=0 && utm_source='yandex_search'";
            $resultData = $conn->query($sqlData);
            $leads = $resultData->num_rows;
            $spam_l = 0; $oform_l = 0; $sale_l = 0; $otmen_l = 0; $ne_oform_l = 0; $work_l = 0;  $price_l = 0; $cost_sd = 0; 
            while($row = $resultData->fetch_assoc())
            {
                if($row['status']==3 || $row['status']==8){ $spam_l++; }
                if($row['status']=='-1'){ $oform_l++; }
                if($row['status']=='-9'){ $sale_l++; }
                if($row['status']=='-99'){ $otmen_l++; }
                if($row['status']==6){ $ne_oform_l++; }
                if($row['status']==1 || $row['status']==2 || $row['status']==4 || $row['status']==5){ $work_l++; }
                $price_l = $price_l+$row['price'];
                $cost_sd = $cost_sd+$row['cost'];
            }
            
            $spam_p = round(($spam_l/$leads)*100); $nespam_l = $leads-$spam_l; $oform_p = round(($oform_l/$nespam_l)*100); $sale_p = round(($sale_l/$nespam_l)*100);
            $otmen_p = round(($otmen_l/$nespam_l)*100); $ne_oform_p = round(($ne_oform_l/$nespam_l)*100); $work_p = round(($work_l/$nespam_l)*100);
            
            $sqlDataCost = "SELECT * FROM all_leads_cost WHERE date_time = $date_on_s && type_place='yandex_search'";
            $resultDataCost = $conn->query($sqlDataCost);
            $view_l = 0; $click_l = 0; $cost_l = 0; $arrayCampaign = array(); $arrayGroup = array();
            while($row = $resultDataCost->fetch_assoc())
            {
                $view_l=$view_l+$row['view'];
                $click_l=$click_l+$row['click'];
                $cost_l=$cost_l+$row['cost'];
                if (!in_array($row['campaign_id']."/".$row['campaign_name'], $arrayCampaign)) {
                    $arrayCampaign[] = $row['campaign_id']."/".$row['campaign_name'];
                }
                
            }
    
            $cr_click = round(($click_l/$view_l)*100, 1);
            $cpc = round($cost_l/$click_l);
            $prib_l = $price_l-$cost_sd-$cost_l;
            $cpl = round($cost_l/$nespam_l);
            $cpl = round($cost_l/$nespam_l);
            $cpo = round($cost_l/$sale_l);
            $cr_check = round($price_l/$sale_l); 
            $cr_site = round(($nespam_l/$click_l)*100, 1);
            
            echo '<tr class="table_day table_hiddeh_'.$col.' hidd"><td></td>
            <td>yandex_search</td>
            <td><span class="table_open2" id="table_hiddeh2_'.$col2.'">раскрыть</span></td>
            <td></td>
            <td>'.$leads.'</td>
            <td class="table_spam">'.$spam_l.'</td>
            <td class="table_spam">'.$spam_p.'%</td>
            <td>'.$nespam_l.'</td>
            <td class="table_oform">'.$oform_l.'</td>
            <td class="table_oform">'.$oform_p.'%</td>
            <td class="table_sale">'.$sale_l.'</td>
            <td class="table_sale">'.$sale_p.'%</td>
            <td class="table_spam">'.$otmen_l.'</td>
            <td class="table_spam">'.$otmen_p.'%</td>
            <td class="table_spam">'.$ne_oform_l.'</td>
            <td class="table_spam">'.$ne_oform_p.'%</td>
            <td>'.$work_l.'</td>
            <td>'.$work_p.'%</td>
            <td>'.$cost_l.'</td>
            <td>'.$price_l.'</td>
            <td class="table_prib">'.$prib_l.'</td>
            <td>'.$cpl.'</td>
            <td>'.$cpo.'</td>
            <td>'.$cr_check.'</td>
            <td>'.$view_l.'</td>
            <td>'.$click_l.'</td>
            <td>'.$cr_click.'</td>
            <td>'.$cpc.'</td>
            <td>'.$cr_site.'</td>
            </tr>';
            
            
            //ищем гр об по каждой кампании в расходах
            //echo 'arrayCampaign = '.count($arrayCampaign);
            for ($i = 0; $i < count($arrayCampaign); $i++) { $col3= $col2.'s';
                $camp = explode('/',$arrayCampaign[$i]);
                $campaign_id = $camp[0];
                $campaign_name = $camp[1];
    
                $sqlDataCost = "SELECT * FROM all_leads_cost WHERE date_time = $date_on_s && type_place='yandex_search' && campaign_id='$campaign_id'";
                $resultDataCost = $conn->query($sqlDataCost);
                $view_l = 0; $click_l = 0; $cost_l = 0; $arrayGroup = array();
                while($row = $resultDataCost->fetch_assoc())
                {
                    $view_l=$view_l+$row['view'];
                    $click_l=$click_l+$row['click'];
                    $cost_l=$cost_l+$row['cost'];
                    if (!in_array($row['group_obv']."/".$row['group_name'], $arrayGroup)) {
                        $arrayGroup[] = $row['group_obv']."/".$row['group_name'];
                    }
                }
    
                $zapros = " date BETWEEN ".$date_on_s." AND ".$date_off_s." && povtor_lead=0 && utm_source='yandex_search'";
                for ($k = 0; $k < count($arrayGroup); $k++) {
                    $Group = explode('/',$arrayGroup[$k]);
                    $group_obv = $Group[0];
                    $group_name = $Group[1];
                    
                    if($k==0){$zapros = $zapros." && utm_content='".$group_obv."'";}
                    else {$zapros = $zapros." || date BETWEEN ".$date_on_s." AND ".$date_off_s." && povtor_lead=0 && utm_source='yandex_search' && utm_content='".$group_obv."'";}
                    
                }
               
                $sqlData = "SELECT * FROM all_leads WHERE $zapros";
                $resultData = $conn->query($sqlData);
                $leads = $resultData->num_rows;
                $spam_l = 0; $oform_l = 0; $sale_l = 0; $otmen_l = 0; $ne_oform_l = 0; $work_l = 0;  $price_l = 0; $cost_sd = 0; 
                
                while($row = $resultData->fetch_assoc())
                {
                    if($row['status']==3 || $row['status']==8){ $spam_l++; }
                    if($row['status']=='-1'){ $oform_l++; }
                    if($row['status']=='-9'){ $sale_l++; }
                    if($row['status']=='-99'){ $otmen_l++; }
                    if($row['status']==6){ $ne_oform_l++; }
                    if($row['status']==1 || $row['status']==2 || $row['status']==4 || $row['status']==5){ $work_l++; }
                    $price_l = $price_l+$row['price'];
                    $cost_sd = $cost_sd+$row['cost'];
                }
                
                $spam_p = round(($spam_l/$leads)*100); $nespam_l = $leads-$spam_l; $oform_p = round(($oform_l/$nespam_l)*100); $sale_p = round(($sale_l/$nespam_l)*100);
                $otmen_p = round(($otmen_l/$nespam_l)*100); $ne_oform_p = round(($ne_oform_l/$nespam_l)*100); $work_p = round(($work_l/$nespam_l)*100);
                
                $cr_click = round(($click_l/$view_l)*100, 1);
                $cpc = round($cost_l/$click_l);
                $prib_l = $price_l-$cost_sd-$cost_l;
                $cpl = round($cost_l/$nespam_l);
                $cpl = round($cost_l/$nespam_l);
                $cpo = round($cost_l/$sale_l);
                $cr_check = round($price_l/$sale_l); 
                $cr_site = round(($nespam_l/$click_l)*100, 1);
                
                echo '<tr class="table_day table_hiddeh2_'.$col2.' hidd"><td></td>
                <td></td>
                <td>'.$campaign_name.'</td>
                <td><span class="table_open3" id="table_hiddeh3_'.$col3.'">раскрыть</span></td>
                <td>'.$leads.'</td>
                <td class="table_spam">'.$spam_l.'</td>
                <td class="table_spam">'.$spam_p.'%</td>
                <td>'.$nespam_l.'</td>
                <td class="table_oform">'.$oform_l.'</td>
                <td class="table_oform">'.$oform_p.'%</td>
                <td class="table_sale">'.$sale_l.'</td>
                <td class="table_sale">'.$sale_p.'%</td>
                <td class="table_spam">'.$otmen_l.'</td>
                <td class="table_spam">'.$otmen_p.'%</td>
                <td class="table_spam">'.$ne_oform_l.'</td>
                <td class="table_spam">'.$ne_oform_p.'%</td>
                <td>'.$work_l.'</td>
                <td>'.$work_p.'%</td>
                <td>'.$cost_l.'</td>
                <td>'.$price_l.'</td>
                <td class="table_prib">'.$prib_l.'</td>
                <td>'.$cpl.'</td>
                <td>'.$cpo.'</td>
                <td>'.$cr_check.'</td>
                <td>'.$view_l.'</td>
                <td>'.$click_l.'</td>
                <td>'.$cr_click.'</td>
                <td>'.$cpc.'</td>
                <td>'.$cr_site.'</td>
                </tr>';
                
                for ($d = 0; $d < count($arrayGroup); $d++) { 
                    $camp = explode('/',$arrayGroup[$d]);
                    $Group_id = $camp[0];
                    $Group_name = $camp[1];
                    
                    $sqlDataCost = "SELECT * FROM all_leads_cost WHERE date_time = $date_on_s && type_place='yandex_search' && group_obv='".$Group_id."'";
                    $resultDataCost = $conn->query($sqlDataCost);
                    $view_l = 0; $click_l = 0; $cost_l = 0; 
                    while($row = $resultDataCost->fetch_assoc())
                    {
                        $view_l=$view_l+$row['view'];
                        $click_l=$click_l+$row['click'];
                        $cost_l=$cost_l+$row['cost'];
                        
                    }
                    
                    $zapros = " date BETWEEN ".$date_on_s." AND ".$date_off_s." && povtor_lead=0 && utm_source='yandex_search' && utm_content='".$Group_id."'";
                    $sqlData = "SELECT * FROM all_leads WHERE $zapros";
                    $resultData = $conn->query($sqlData);
                    $leads = $resultData->num_rows;
                    $spam_l = 0; $oform_l = 0; $sale_l = 0; $otmen_l = 0; $ne_oform_l = 0; $work_l = 0;  $price_l = 0; $cost_sd = 0; 
                    
                    while($row = $resultData->fetch_assoc())
                    {
                        if($row['status']==3 || $row['status']==8){ $spam_l++; }
                        if($row['status']=='-1'){ $oform_l++; }
                        if($row['status']=='-9'){ $sale_l++; }
                        if($row['status']=='-99'){ $otmen_l++; }
                        if($row['status']==6){ $ne_oform_l++; }
                        if($row['status']==1 || $row['status']==2 || $row['status']==4 || $row['status']==5){ $work_l++; }
                        $price_l = $price_l+$row['price'];
                        $cost_sd = $cost_sd+$row['cost'];
                    }
                    
                    $spam_p = round(($spam_l/$leads)*100); $nespam_l = $leads-$spam_l; $oform_p = round(($oform_l/$nespam_l)*100); $sale_p = round(($sale_l/$nespam_l)*100);
                    $otmen_p = round(($otmen_l/$nespam_l)*100); $ne_oform_p = round(($ne_oform_l/$nespam_l)*100); $work_p = round(($work_l/$nespam_l)*100);
                    
                    $cr_click = round(($click_l/$view_l)*100, 1);
                    $cpc = round($cost_l/$click_l);
                    $prib_l = $price_l-$cost_sd-$cost_l;
                    $cpl = round($cost_l/$nespam_l);
                    $cpl = round($cost_l/$nespam_l);
                    $cpo = round($cost_l/$sale_l);
                    $cr_check = round($price_l/$sale_l); 
                    $cr_site = round(($nespam_l/$click_l)*100, 1);
                    
                    echo '<tr class="table_day table_hiddeh3_'.$col3.' hidd"><td></td>
                    <td></td>
                    <td></td>
                    <td>'.$Group_name.'</td>
                    <td>'.$leads.'</td>
                    <td class="table_spam">'.$spam_l.'</td>
                    <td class="table_spam">'.$spam_p.'%</td>
                    <td>'.$nespam_l.'</td>
                    <td class="table_oform">'.$oform_l.'</td>
                    <td class="table_oform">'.$oform_p.'%</td>
                    <td class="table_sale">'.$sale_l.'</td>
                    <td class="table_sale">'.$sale_p.'%</td>
                    <td class="table_spam">'.$otmen_l.'</td>
                    <td class="table_spam">'.$otmen_p.'%</td>
                    <td class="table_spam">'.$ne_oform_l.'</td>
                    <td class="table_spam">'.$ne_oform_p.'%</td>
                    <td>'.$work_l.'</td>
                    <td>'.$work_p.'%</td>
                    <td>'.$cost_l.'</td>
                    <td>'.$price_l.'</td>
                    <td class="table_prib">'.$prib_l.'</td>
                    <td>'.$cpl.'</td>
                    <td>'.$cpo.'</td>
                    <td>'.$cr_check.'</td>
                    <td>'.$view_l.'</td>
                    <td>'.$click_l.'</td>
                    <td>'.$cr_click.'</td>
                    <td>'.$cpc.'</td>
                    <td>'.$cr_site.'</td>
                    </tr>';
                }
                
                
                
            }
    
            
            
            
    
            
    
            
            
            
            
            
        }
        if($yandex_context!=0){$col2=$col.'c';
            $sqlData = "SELECT * FROM all_leads WHERE date BETWEEN $date_on_s AND $date_off_s && povtor_lead=0 && utm_source='yandex_context'";
            $resultData = $conn->query($sqlData);
            $leads = $resultData->num_rows;
            $spam_l = 0; $oform_l = 0; $sale_l = 0; $otmen_l = 0; $ne_oform_l = 0; $work_l = 0;  $price_l = 0; $cost_sd = 0; 
            while($row = $resultData->fetch_assoc())
            {
                if($row['status']==3 || $row['status']==8){ $spam_l++; }
                if($row['status']=='-1'){ $oform_l++; }
                if($row['status']=='-9'){ $sale_l++; }
                if($row['status']=='-99'){ $otmen_l++; }
                if($row['status']==6){ $ne_oform_l++; }
                if($row['status']==1 || $row['status']==2 || $row['status']==4 || $row['status']==5){ $work_l++; }
                $price_l = $price_l+$row['price'];
                $cost_sd = $cost_sd+$row['cost'];
            }
            
            $spam_p = round(($spam_l/$leads)*100); $nespam_l = $leads-$spam_l; $oform_p = round(($oform_l/$nespam_l)*100); $sale_p = round(($sale_l/$nespam_l)*100);
            $otmen_p = round(($otmen_l/$nespam_l)*100); $ne_oform_p = round(($ne_oform_l/$nespam_l)*100); $work_p = round(($work_l/$nespam_l)*100);
            
            $sqlDataCost = "SELECT * FROM all_leads_cost WHERE date_time = $date_on_s && type_place='yandex_context'";
            $resultDataCost = $conn->query($sqlDataCost);
            $view_l = 0; $click_l = 0; $cost_l = 0; $arrayCampaign = array(); $arrayGroup = array();
            while($row = $resultDataCost->fetch_assoc())
            {
                $view_l=$view_l+$row['view'];
                $click_l=$click_l+$row['click'];
                $cost_l=$cost_l+$row['cost'];
                if (!in_array($row['campaign_id']."/".$row['campaign_name'], $arrayCampaign)) {
                    $arrayCampaign[] = $row['campaign_id']."/".$row['campaign_name'];
                }
                
            }
    
            $cr_click = round(($click_l/$view_l)*100, 1);
            $cpc = round($cost_l/$click_l);
            $prib_l = $price_l-$cost_sd-$cost_l;
            $cpl = round($cost_l/$nespam_l);
            $cpl = round($cost_l/$nespam_l);
            $cpo = round($cost_l/$sale_l);
            $cr_check = round($price_l/$sale_l); 
            $cr_site = round(($nespam_l/$click_l)*100, 1);
            
            echo '<tr class="table_day table_hiddeh_'.$col.' hidd"><td></td>
            <td>yandex_context</td>
            <td><span class="table_open2" id="table_hiddeh2_'.$col2.'">раскрыть</span></td>
            <td></td>
            <td>'.$leads.'</td>
            <td class="table_spam">'.$spam_l.'</td>
            <td class="table_spam">'.$spam_p.'%</td>
            <td>'.$nespam_l.'</td>
            <td class="table_oform">'.$oform_l.'</td>
            <td class="table_oform">'.$oform_p.'%</td>
            <td class="table_sale">'.$sale_l.'</td>
            <td class="table_sale">'.$sale_p.'%</td>
            <td class="table_spam">'.$otmen_l.'</td>
            <td class="table_spam">'.$otmen_p.'%</td>
            <td class="table_spam">'.$ne_oform_l.'</td>
            <td class="table_spam">'.$ne_oform_p.'%</td>
            <td>'.$work_l.'</td>
            <td>'.$work_p.'%</td>
            <td>'.$cost_l.'</td>
            <td>'.$price_l.'</td>
            <td class="table_prib">'.$prib_l.'</td>
            <td>'.$cpl.'</td>
            <td>'.$cpo.'</td>
            <td>'.$cr_check.'</td>
            <td>'.$view_l.'</td>
            <td>'.$click_l.'</td>
            <td>'.$cr_click.'</td>
            <td>'.$cpc.'</td>
            <td>'.$cr_site.'</td>
            </tr>';
            
            //ищем гр об по каждой кампании в расходах
        
            for ($i = 0; $i < count($arrayCampaign); $i++) { $col3= $col2.'c';
                $camp = explode('/',$arrayCampaign[$i]);
                $campaign_id = $camp[0];
                $campaign_name = $camp[1];
    
                $sqlDataCost = "SELECT * FROM all_leads_cost WHERE date_time = $date_on_s && type_place='yandex_context' && campaign_id='$campaign_id'";
                $resultDataCost = $conn->query($sqlDataCost);
                $view_l = 0; $click_l = 0; $cost_l = 0; $arrayGroup = array();
                while($row = $resultDataCost->fetch_assoc())
                {
                    $view_l=$view_l+$row['view'];
                    $click_l=$click_l+$row['click'];
                    $cost_l=$cost_l+$row['cost'];
                    if (!in_array($row['group_obv']."/".$row['group_name'], $arrayGroup)) {
                        $arrayGroup[] = $row['group_obv']."/".$row['group_name'];
                    }
                }
    
                $zapros = " date BETWEEN ".$date_on_s." AND ".$date_off_s." && povtor_lead=0 && utm_source='yandex_context'";
                for ($k = 0; $k < count($arrayGroup); $k++) {
                    $Group = explode('/',$arrayGroup[$k]);
                    $group_obv = $Group[0];
                    $group_name = $Group[1];
                    
                    if($k==0){$zapros = $zapros." && utm_content='".$group_obv."'";}
                    else {$zapros = $zapros." || date BETWEEN ".$date_on_s." AND ".$date_off_s." && povtor_lead=0 && utm_source='yandex_context' && utm_content='".$group_obv."'";}
                    
                }
            
                $sqlData = "SELECT * FROM all_leads WHERE $zapros";
                $resultData = $conn->query($sqlData);
                $leads = $resultData->num_rows;
                $spam_l = 0; $oform_l = 0; $sale_l = 0; $otmen_l = 0; $ne_oform_l = 0; $work_l = 0;  $price_l = 0; $cost_sd = 0; 
                
                while($row = $resultData->fetch_assoc())
                {
                    if($row['status']==3 || $row['status']==8){ $spam_l++; }
                    if($row['status']=='-1'){ $oform_l++; }
                    if($row['status']=='-9'){ $sale_l++; }
                    if($row['status']=='-99'){ $otmen_l++; }
                    if($row['status']==6){ $ne_oform_l++; }
                    if($row['status']==1 || $row['status']==2 || $row['status']==4 || $row['status']==5){ $work_l++; }
                    $price_l = $price_l+$row['price'];
                    $cost_sd = $cost_sd+$row['cost'];
                }
                
                $spam_p = round(($spam_l/$leads)*100); $nespam_l = $leads-$spam_l; $oform_p = round(($oform_l/$nespam_l)*100); $sale_p = round(($sale_l/$nespam_l)*100);
                $otmen_p = round(($otmen_l/$nespam_l)*100); $ne_oform_p = round(($ne_oform_l/$nespam_l)*100); $work_p = round(($work_l/$nespam_l)*100);
                
                $cr_click = round(($click_l/$view_l)*100, 1);
                $cpc = round($cost_l/$click_l);
                $prib_l = $price_l-$cost_sd-$cost_l;
                $cpl = round($cost_l/$nespam_l);
                $cpl = round($cost_l/$nespam_l);
                $cpo = round($cost_l/$sale_l);
                $cr_check = round($price_l/$sale_l); 
                $cr_site = round(($nespam_l/$click_l)*100, 1);
                
                echo '<tr class="table_day table_hiddeh2_'.$col2.' hidd"><td></td>
                <td></td>
                <td>'.$campaign_name.'</td>
                <td><span class="table_open3" id="table_hiddeh3_'.$col3.'">раскрыть</span></td>
                <td>'.$leads.'</td>
                <td class="table_spam">'.$spam_l.'</td>
                <td class="table_spam">'.$spam_p.'%</td>
                <td>'.$nespam_l.'</td>
                <td class="table_oform">'.$oform_l.'</td>
                <td class="table_oform">'.$oform_p.'%</td>
                <td class="table_sale">'.$sale_l.'</td>
                <td class="table_sale">'.$sale_p.'%</td>
                <td class="table_spam">'.$otmen_l.'</td>
                <td class="table_spam">'.$otmen_p.'%</td>
                <td class="table_spam">'.$ne_oform_l.'</td>
                <td class="table_spam">'.$ne_oform_p.'%</td>
                <td>'.$work_l.'</td>
                <td>'.$work_p.'%</td>
                <td>'.$cost_l.'</td>
                <td>'.$price_l.'</td>
                <td class="table_prib">'.$prib_l.'</td>
                <td>'.$cpl.'</td>
                <td>'.$cpo.'</td>
                <td>'.$cr_check.'</td>
                <td>'.$view_l.'</td>
                <td>'.$click_l.'</td>
                <td>'.$cr_click.'</td>
                <td>'.$cpc.'</td>
                <td>'.$cr_site.'</td>
                </tr>';
                
                
                for ($d = 0; $d < count($arrayGroup); $d++) { 
                    $camp = explode('/',$arrayGroup[$d]);
                    $Group_id = $camp[0];
                    $Group_name = $camp[1];
                    
                    $sqlDataCost = "SELECT * FROM all_leads_cost WHERE date_time = $date_on_s && type_place='yandex_context' && group_obv='".$Group_id."'";
                    $resultDataCost = $conn->query($sqlDataCost);
                    $view_l = 0; $click_l = 0; $cost_l = 0; 
                    while($row = $resultDataCost->fetch_assoc())
                    {
                        $view_l=$view_l+$row['view'];
                        $click_l=$click_l+$row['click'];
                        $cost_l=$cost_l+$row['cost'];
                        
                    }
                    
                    $zapros = " date BETWEEN ".$date_on_s." AND ".$date_off_s." && povtor_lead=0 && utm_source='yandex_context' && utm_content='".$Group_id."'";
                    $sqlData = "SELECT * FROM all_leads WHERE $zapros";
                    $resultData = $conn->query($sqlData);
                    $leads = $resultData->num_rows;
                    $spam_l = 0; $oform_l = 0; $sale_l = 0; $otmen_l = 0; $ne_oform_l = 0; $work_l = 0;  $price_l = 0; $cost_sd = 0; 
                    
                    while($row = $resultData->fetch_assoc())
                    {
                        if($row['status']==3 || $row['status']==8){ $spam_l++; }
                        if($row['status']=='-1'){ $oform_l++; }
                        if($row['status']=='-9'){ $sale_l++; }
                        if($row['status']=='-99'){ $otmen_l++; }
                        if($row['status']==6){ $ne_oform_l++; }
                        if($row['status']==1 || $row['status']==2 || $row['status']==4 || $row['status']==5){ $work_l++; }
                        $price_l = $price_l+$row['price'];
                        $cost_sd = $cost_sd+$row['cost'];
                    }
                    
                    $spam_p = round(($spam_l/$leads)*100); $nespam_l = $leads-$spam_l; $oform_p = round(($oform_l/$nespam_l)*100); $sale_p = round(($sale_l/$nespam_l)*100);
                    $otmen_p = round(($otmen_l/$nespam_l)*100); $ne_oform_p = round(($ne_oform_l/$nespam_l)*100); $work_p = round(($work_l/$nespam_l)*100);
                    
                    $cr_click = round(($click_l/$view_l)*100, 1);
                    $cpc = round($cost_l/$click_l);
                    $prib_l = $price_l-$cost_sd-$cost_l;
                    $cpl = round($cost_l/$nespam_l);
                    $cpl = round($cost_l/$nespam_l);
                    $cpo = round($cost_l/$sale_l);
                    $cr_check = round($price_l/$sale_l); 
                    $cr_site = round(($nespam_l/$click_l)*100, 1);
                    
                    echo '<tr class="table_day table_hiddeh3_'.$col3.' hidd"><td></td>
                    <td></td>
                    <td></td>
                    <td>'.$Group_name.'</td>
                    <td>'.$leads.'</td>
                    <td class="table_spam">'.$spam_l.'</td>
                    <td class="table_spam">'.$spam_p.'%</td>
                    <td>'.$nespam_l.'</td>
                    <td class="table_oform">'.$oform_l.'</td>
                    <td class="table_oform">'.$oform_p.'%</td>
                    <td class="table_sale">'.$sale_l.'</td>
                    <td class="table_sale">'.$sale_p.'%</td>
                    <td class="table_spam">'.$otmen_l.'</td>
                    <td class="table_spam">'.$otmen_p.'%</td>
                    <td class="table_spam">'.$ne_oform_l.'</td>
                    <td class="table_spam">'.$ne_oform_p.'%</td>
                    <td>'.$work_l.'</td>
                    <td>'.$work_p.'%</td>
                    <td>'.$cost_l.'</td>
                    <td>'.$price_l.'</td>
                    <td class="table_prib">'.$prib_l.'</td>
                    <td>'.$cpl.'</td>
                    <td>'.$cpo.'</td>
                    <td>'.$cr_check.'</td>
                    <td>'.$view_l.'</td>
                    <td>'.$click_l.'</td>
                    <td>'.$cr_click.'</td>
                    <td>'.$cpc.'</td>
                    <td>'.$cr_site.'</td>
                    </tr>';
                }
                
                
                
            }
            
            
            
            
        }
        if($pryamoy_visit!=0){
            
            
            $sqlData = "SELECT * FROM all_leads WHERE date BETWEEN $date_on_s AND $date_off_s && povtor_lead=0 && utm_source='' ||  date BETWEEN $date_on_s AND $date_off_s && povtor_lead=0 && utm_source='Прямой заход'";
            $resultData = $conn->query($sqlData);
            $leads = $resultData->num_rows;
            $spam_l = 0; $oform_l = 0; $sale_l = 0; $otmen_l = 0; $ne_oform_l = 0; $work_l = 0;  $price_l = 0; $cost_sd = 0; 
            while($row = $resultData->fetch_assoc())
            {
                if($row['status']==3 || $row['status']==8){ $spam_l++; }
                if($row['status']=='-1'){ $oform_l++; }
                if($row['status']=='-9'){ $sale_l++; }
                if($row['status']=='-99'){ $otmen_l++; }
                if($row['status']==6){ $ne_oform_l++; }
                if($row['status']==1 || $row['status']==2 || $row['status']==4 || $row['status']==5){ $work_l++; }
                $price_l = $price_l+$row['price'];
                $cost_sd = $cost_sd+$row['cost'];
            }
            
            $spam_p = round(($spam_l/$leads)*100); $nespam_l = $leads-$spam_l; $oform_p = round(($oform_l/$nespam_l)*100); $sale_p = round(($sale_l/$nespam_l)*100);
            $otmen_p = round(($otmen_l/$nespam_l)*100); $ne_oform_p = round(($ne_oform_l/$nespam_l)*100); $work_p = round(($work_l/$nespam_l)*100);
            
            
            $view_l = 0; $click_l = 0; $cost_l = 0; 
            
            $cr_click = round(($click_l/$view_l)*100, 1);
            $cpc = round($cost_l/$click_l);
            $prib_l = $price_l-$cost_sd-$cost_l;
            $cpl = round($cost_l/$nespam_l);
            $cpl = round($cost_l/$nespam_l);
            $cpo = round($cost_l/$sale_l);
            $cr_check = round($price_l/$sale_l); 
            $cr_site = round(($nespam_l/$click_l)*100, 1);
            
            echo '<tr class="table_day table_hiddeh_'.$col.' hidd"><td></td>
            <td>Прямой заход</td>
            <td></td>
            <td></td>
            <td>'.$leads.'</td>
            <td class="table_spam">'.$spam_l.'</td>
            <td class="table_spam">'.$spam_p.'%</td>
            <td>'.$nespam_l.'</td>
            <td class="table_oform">'.$oform_l.'</td>
            <td class="table_oform">'.$oform_p.'%</td>
            <td class="table_sale">'.$sale_l.'</td>
            <td class="table_sale">'.$sale_p.'%</td>
            <td class="table_spam">'.$otmen_l.'</td>
            <td class="table_spam">'.$otmen_p.'%</td>
            <td class="table_spam">'.$ne_oform_l.'</td>
            <td class="table_spam">'.$ne_oform_p.'%</td>
            <td>'.$work_l.'</td>
            <td>'.$work_p.'%</td>
            <td>'.$cost_l.'</td>
            <td>'.$price_l.'</td>
            <td class="table_prib">'.$prib_l.'</td>
            <td>'.$cpl.'</td>
            <td>'.$cpo.'</td>
            <td>'.$cr_check.'</td>
            <td>'.$view_l.'</td>
            <td>'.$click_l.'</td>
            <td>'.$cr_click.'</td>
            <td>'.$cpc.'</td>
            <td>'.$cr_site.'</td>
            </tr>';
            
            
            
            
        }
    }
//}///if(isset($_GET['table_vid']) && $_GET['table_vid'] == 'table_day')
if(isset($_GET['date_on']) && isset($_GET['date_off'])){ 
    $date_on = $_GET['date_on']; $date_on_s = strtotime($date_on);
    $date_off = $_GET['date_off']; $date_off_s = strtotime($date_off)+86399;$date_off_s_cost = strtotime($date_off);
}else {
    $date_on = date('Y-m').'-01'; $date_off = $dateNow;
    $date_on_s = strtotime($date_on);
    $date_off_s_cost = strtotime($date_off);
    $date_off_s = strtotime($date_off)+86399;
}
$col++;

echo '<tr style="border: 3px solid #333;"></tr>';
//else {
        //$date_on_s = strtotime($value);
        //$date_off_s = strtotime($value)+86400;
        $sqlData = "SELECT * FROM all_leads WHERE date BETWEEN $date_on_s AND $date_off_s && povtor_lead=0 ORDER BY date";
        $resultData = $conn->query($sqlData);
        $leads = $resultData->num_rows; 
        $spam_l = 0; $oform_l = 0; $sale_l = 0; $otmen_l = 0; $ne_oform_l = 0; $work_l = 0;  $price_l = 0; $cost_sd = 0; $yandex_context = 0; $yandex_search = 0; $pryamoy_visit = 0;
        while($row = $resultData->fetch_assoc())
        {
            if($row['status']==3 || $row['status']==8){ $spam_l++; }
            if($row['status']=='-1'){ $oform_l++; }
            if($row['status']=='-9'){ $sale_l++; }
            if($row['status']=='-99'){ $otmen_l++; }
            if($row['status']==6){ $ne_oform_l++; }
            if($row['status']==1 || $row['status']==2 || $row['status']==4 || $row['status']==5){ $work_l++; }
            $price_l = $price_l+$row['price'];
            $cost_sd = $cost_sd+$row['cost'];
            if($row['utm_source']=='yandex_context'){ $yandex_context++; }
            if($row['utm_source']=='yandex_search'){ $yandex_search++; }
            if($row['utm_source']=='' || $row['utm_source']=='Прямой заход'){ $pryamoy_visit++; }
        }
        
        $spam_p = round(($spam_l/$leads)*100); $nespam_l = $leads-$spam_l; $oform_p = round(($oform_l/$nespam_l)*100); $sale_p = round(($sale_l/$nespam_l)*100);
        $otmen_p = round(($otmen_l/$nespam_l)*100); $ne_oform_p = round(($ne_oform_l/$nespam_l)*100); $work_p = round(($work_l/$nespam_l)*100);
        
        
        $sqlDataCost = "SELECT * FROM all_leads_cost WHERE date_time BETWEEN $date_on_s AND $date_off_s";
        $resultDataCost = $conn->query($sqlDataCost);
        $view_l = 0; $click_l = 0; $cost_l = 0;
        while($row = $resultDataCost->fetch_assoc())
        {
            $view_l=$view_l+$row['view'];
            $click_l=$click_l+$row['click'];
            $cost_l=$cost_l+$row['cost'];
        }
        $cr_click = round(($click_l/$view_l)*100, 1);
        $cpc = round($cost_l/$click_l);
        $prib_l = $price_l-$cost_sd-$cost_l;
        $cpl = round($cost_l/$nespam_l);
        $cpo = round($cost_l/$sale_l);
        $cr_check = round($price_l/$sale_l); 
        $cr_site = round(($nespam_l/$click_l)*100, 1);
        
        echo '<tr class="table_all"><td>За период</td>
        <td><span class="table_open" id="table_hiddeh_'.$col.'">раскрыть</span></td>
        <td></td>
        <td></td>
        <td>'.$leads.'</td>
        <td class="table_spam">'.$spam_l.'</td>
        <td class="table_spam">'.$spam_p.'%</td>
        <td>'.$nespam_l.'</td>
        <td class="table_oform">'.$oform_l.'</td>
        <td class="table_oform">'.$oform_p.'%</td>
        <td class="table_sale">'.$sale_l.'</td>
        <td class="table_sale">'.$sale_p.'%</td>
        <td class="table_spam">'.$otmen_l.'</td>
        <td class="table_spam">'.$otmen_p.'%</td>
        <td class="table_spam">'.$ne_oform_l.'</td>
        <td class="table_spam">'.$ne_oform_p.'%</td>
        <td>'.$work_l.'</td>
        <td>'.$work_p.'%</td>
        <td>'.$cost_l.'</td>
        <td>'.$price_l.'</td>
        <td class="table_prib">'.$prib_l.'</td>
        <td>'.$cpl.'</td>
        <td>'.$cpo.'</td>
        <td>'.$cr_check.'</td>
        <td>'.$view_l.'</td>
        <td>'.$click_l.'</td>
        <td>'.$cr_click.'</td>
        <td>'.$cpc.'</td>
        <td>'.$cr_site.'</td>
        </tr>';
        
        if($yandex_search!=0){$col2=$col.'s';
            $sqlData = "SELECT * FROM all_leads WHERE date BETWEEN $date_on_s AND $date_off_s && povtor_lead=0 && utm_source='yandex_search'";
            $resultData = $conn->query($sqlData);
            $leads = $resultData->num_rows;
            $spam_l = 0; $oform_l = 0; $sale_l = 0; $otmen_l = 0; $ne_oform_l = 0; $work_l = 0;  $price_l = 0; $cost_sd = 0; 
            while($row = $resultData->fetch_assoc())
            {
                if($row['status']==3 || $row['status']==8){ $spam_l++; }
                if($row['status']=='-1'){ $oform_l++; }
                if($row['status']=='-9'){ $sale_l++; }
                if($row['status']=='-99'){ $otmen_l++; }
                if($row['status']==6){ $ne_oform_l++; }
                if($row['status']==1 || $row['status']==2 || $row['status']==4 || $row['status']==5){ $work_l++; }
                $price_l = $price_l+$row['price'];
                $cost_sd = $cost_sd+$row['cost'];
            }
            
            $spam_p = round(($spam_l/$leads)*100); $nespam_l = $leads-$spam_l; $oform_p = round(($oform_l/$nespam_l)*100); $sale_p = round(($sale_l/$nespam_l)*100);
            $otmen_p = round(($otmen_l/$nespam_l)*100); $ne_oform_p = round(($ne_oform_l/$nespam_l)*100); $work_p = round(($work_l/$nespam_l)*100);
            
            $sqlDataCost = "SELECT * FROM all_leads_cost WHERE date_time BETWEEN $date_on_s AND $date_off_s && type_place='yandex_search'";
            $resultDataCost = $conn->query($sqlDataCost);
            $view_l = 0; $click_l = 0; $cost_l = 0; $arrayCampaign = array(); $arrayGroup = array();
            while($row = $resultDataCost->fetch_assoc())
            {
                $view_l=$view_l+$row['view'];
                $click_l=$click_l+$row['click'];
                $cost_l=$cost_l+$row['cost'];
                if (!in_array($row['campaign_id']."/".$row['campaign_name'], $arrayCampaign)) {
                    $arrayCampaign[] = $row['campaign_id']."/".$row['campaign_name'];
                }
                
            }
    
            $cr_click = round(($click_l/$view_l)*100, 1);
            $cpc = round($cost_l/$click_l);
            $prib_l = $price_l-$cost_sd-$cost_l;
            $cpl = round($cost_l/$nespam_l);
            $cpl = round($cost_l/$nespam_l);
            $cpo = round($cost_l/$sale_l);
            $cr_check = round($price_l/$sale_l);
            $cr_site = round(($nespam_l/$click_l)*100, 1);
            
            echo '<tr class="table_all table_hiddeh_'.$col.' hidd"><td></td>
            <td>yandex_search</td>
            <td><span class="table_open2" id="table_hiddeh2_'.$col2.'">раскрыть</span></td>
            <td></td>
            <td>'.$leads.'</td>
            <td class="table_spam">'.$spam_l.'</td>
            <td class="table_spam">'.$spam_p.'%</td>
            <td>'.$nespam_l.'</td>
            <td class="table_oform">'.$oform_l.'</td>
            <td class="table_oform">'.$oform_p.'%</td>
            <td class="table_sale">'.$sale_l.'</td>
            <td class="table_sale">'.$sale_p.'%</td>
            <td class="table_spam">'.$otmen_l.'</td>
            <td class="table_spam">'.$otmen_p.'%</td>
            <td class="table_spam">'.$ne_oform_l.'</td>
            <td class="table_spam">'.$ne_oform_p.'%</td>
            <td>'.$work_l.'</td>
            <td>'.$work_p.'%</td>
            <td>'.$cost_l.'</td>
            <td>'.$price_l.'</td>
            <td class="table_prib">'.$prib_l.'</td>
            <td>'.$cpl.'</td>
            <td>'.$cpo.'</td>
            <td>'.$cr_check.'</td>
            <td>'.$view_l.'</td>
            <td>'.$click_l.'</td>
            <td>'.$cr_click.'</td>
            <td>'.$cpc.'</td>
            <td>'.$cr_site.'</td>
            </tr>';
            
            
            //ищем гр об по каждой кампании в расходах
            //echo 'arrayCampaign = '.count($arrayCampaign);
            for ($i = 0; $i < count($arrayCampaign); $i++) { $col3= $col2.'s';
                $camp = explode('/',$arrayCampaign[$i]);
                $campaign_id = $camp[0];
                $campaign_name = $camp[1];
    
                $sqlDataCost = "SELECT * FROM all_leads_cost WHERE date_time BETWEEN $date_on_s AND $date_off_s && type_place='yandex_search' && campaign_id='$campaign_id'";
                $resultDataCost = $conn->query($sqlDataCost);
                $view_l = 0; $click_l = 0; $cost_l = 0; $arrayGroup = array();
                while($row = $resultDataCost->fetch_assoc())
                {
                    $view_l=$view_l+$row['view'];
                    $click_l=$click_l+$row['click'];
                    $cost_l=$cost_l+$row['cost'];
                    if (!in_array($row['group_obv']."/".$row['group_name'], $arrayGroup)) {
                        $arrayGroup[] = $row['group_obv']."/".$row['group_name'];
                    }
                }
    
                $zapros = " date BETWEEN ".$date_on_s." AND ".$date_off_s." && povtor_lead=0 && utm_source='yandex_search'";
                for ($k = 0; $k < count($arrayGroup); $k++) {
                    $Group = explode('/',$arrayGroup[$k]);
                    $group_obv = $Group[0];
                    $group_name = $Group[1];
                    
                    if($k==0){$zapros = $zapros." && utm_content='".$group_obv."'";}
                    else {$zapros = $zapros." || date BETWEEN ".$date_on_s." AND ".$date_off_s." && povtor_lead=0 && utm_source='yandex_search' && utm_content='".$group_obv."'";}
                    
                }
               
                $sqlData = "SELECT * FROM all_leads WHERE $zapros";
                $resultData = $conn->query($sqlData);
                $leads = $resultData->num_rows;
                $spam_l = 0; $oform_l = 0; $sale_l = 0; $otmen_l = 0; $ne_oform_l = 0; $work_l = 0;  $price_l = 0; $cost_sd = 0; 
                
                while($row = $resultData->fetch_assoc())
                {
                    if($row['status']==3 || $row['status']==8){ $spam_l++; }
                    if($row['status']=='-1'){ $oform_l++; }
                    if($row['status']=='-9'){ $sale_l++; }
                    if($row['status']=='-99'){ $otmen_l++; }
                    if($row['status']==6){ $ne_oform_l++; }
                    if($row['status']==1 || $row['status']==2 || $row['status']==4 || $row['status']==5){ $work_l++; }
                    $price_l = $price_l+$row['price'];
                    $cost_sd = $cost_sd+$row['cost'];
                }
                
                $spam_p = round(($spam_l/$leads)*100); $nespam_l = $leads-$spam_l; $oform_p = round(($oform_l/$nespam_l)*100); $sale_p = round(($sale_l/$nespam_l)*100);
                $otmen_p = round(($otmen_l/$nespam_l)*100); $ne_oform_p = round(($ne_oform_l/$nespam_l)*100); $work_p = round(($work_l/$nespam_l)*100);
                
                $cr_click = round(($click_l/$view_l)*100, 1);
                $cpc = round($cost_l/$click_l);
                $prib_l = $price_l-$cost_sd-$cost_l;
                $cpl = round($cost_l/$nespam_l);
                $cpl = round($cost_l/$nespam_l);
                $cpo = round($cost_l/$sale_l);
                $cr_check = round($price_l/$sale_l);
                $cr_site = round(($nespam_l/$click_l)*100, 1);
                
                echo '<tr class="table_all table_hiddeh2_'.$col2.' hidd"><td></td>
                <td></td>
                <td>'.$campaign_name.'</td>
                <td><span class="table_open3" id="table_hiddeh3_'.$col3.'">раскрыть</span></td>
                <td>'.$leads.'</td>
                <td class="table_spam">'.$spam_l.'</td>
                <td class="table_spam">'.$spam_p.'%</td>
                <td>'.$nespam_l.'</td>
                <td class="table_oform">'.$oform_l.'</td>
                <td class="table_oform">'.$oform_p.'%</td>
                <td class="table_sale">'.$sale_l.'</td>
                <td class="table_sale">'.$sale_p.'%</td>
                <td class="table_spam">'.$otmen_l.'</td>
                <td class="table_spam">'.$otmen_p.'%</td>
                <td class="table_spam">'.$ne_oform_l.'</td>
                <td class="table_spam">'.$ne_oform_p.'%</td>
                <td>'.$work_l.'</td>
                <td>'.$work_p.'%</td>
                <td>'.$cost_l.'</td>
                <td>'.$price_l.'</td>
                <td class="table_prib">'.$prib_l.'</td>
                <td>'.$cpl.'</td>
                <td>'.$cpo.'</td>
                <td>'.$cr_check.'</td>
                <td>'.$view_l.'</td>
                <td>'.$click_l.'</td>
                <td>'.$cr_click.'</td>
                <td>'.$cpc.'</td>
                <td>'.$cr_site.'</td>
                </tr>';
                
                for ($d = 0; $d < count($arrayGroup); $d++) { 
                    $camp = explode('/',$arrayGroup[$d]);
                    $Group_id = $camp[0];
                    $Group_name = $camp[1];
                    
                    $sqlDataCost = "SELECT * FROM all_leads_cost WHERE date_time BETWEEN $date_on_s AND $date_off_s && type_place='yandex_search' && group_obv='".$Group_id."'";
                    $resultDataCost = $conn->query($sqlDataCost);
                    $view_l = 0; $click_l = 0; $cost_l = 0; 
                    while($row = $resultDataCost->fetch_assoc())
                    {
                        $view_l=$view_l+$row['view'];
                        $click_l=$click_l+$row['click'];
                        $cost_l=$cost_l+$row['cost'];
                        
                    }
                    
                    $zapros = " date BETWEEN ".$date_on_s." AND ".$date_off_s." && povtor_lead=0 && utm_source='yandex_search' && utm_content='".$Group_id."'";
                    $sqlData = "SELECT * FROM all_leads WHERE $zapros";
                    $resultData = $conn->query($sqlData);
                    $leads = $resultData->num_rows;
                    $spam_l = 0; $oform_l = 0; $sale_l = 0; $otmen_l = 0; $ne_oform_l = 0; $work_l = 0;  $price_l = 0; $cost_sd = 0; 
                    
                    while($row = $resultData->fetch_assoc())
                    {
                        if($row['status']==3 || $row['status']==8){ $spam_l++; }
                        if($row['status']=='-1'){ $oform_l++; }
                        if($row['status']=='-9'){ $sale_l++; }
                        if($row['status']=='-99'){ $otmen_l++; }
                        if($row['status']==6){ $ne_oform_l++; }
                        if($row['status']==1 || $row['status']==2 || $row['status']==4 || $row['status']==5){ $work_l++; }
                        $price_l = $price_l+$row['price'];
                        $cost_sd = $cost_sd+$row['cost'];
                    }
                    
                    $spam_p = round(($spam_l/$leads)*100); $nespam_l = $leads-$spam_l; $oform_p = round(($oform_l/$nespam_l)*100); $sale_p = round(($sale_l/$nespam_l)*100);
                    $otmen_p = round(($otmen_l/$nespam_l)*100); $ne_oform_p = round(($ne_oform_l/$nespam_l)*100); $work_p = round(($work_l/$nespam_l)*100);
                    
                    $cr_click = round(($click_l/$view_l)*100, 1);
                    $cpc = round($cost_l/$click_l);
                    $prib_l = $price_l-$cost_sd-$cost_l;
                    $cpl = round($cost_l/$nespam_l);
                    $cpl = round($cost_l/$nespam_l);
                    $cpo = round($cost_l/$sale_l);
                    $cr_check = round($price_l/$sale_l);
                    $cr_site = round(($nespam_l/$click_l)*100, 1);
                    
                    echo '<tr class="table_all table_hiddeh3_'.$col3.' hidd"><td></td>
                    <td></td>
                    <td></td>
                    <td>'.$Group_name.'</td>
                    <td>'.$leads.'</td>
                    <td class="table_spam">'.$spam_l.'</td>
                    <td class="table_spam">'.$spam_p.'%</td>
                    <td>'.$nespam_l.'</td>
                    <td class="table_oform">'.$oform_l.'</td>
                    <td class="table_oform">'.$oform_p.'%</td>
                    <td class="table_sale">'.$sale_l.'</td>
                    <td class="table_sale">'.$sale_p.'%</td>
                    <td class="table_spam">'.$otmen_l.'</td>
                    <td class="table_spam">'.$otmen_p.'%</td>
                    <td class="table_spam">'.$ne_oform_l.'</td>
                    <td class="table_spam">'.$ne_oform_p.'%</td>
                    <td>'.$work_l.'</td>
                    <td>'.$work_p.'%</td>
                    <td>'.$cost_l.'</td>
                    <td>'.$price_l.'</td>
                    <td class="table_prib">'.$prib_l.'</td>
                    <td>'.$cpl.'</td>
                    <td>'.$cpo.'</td>
                    <td>'.$cr_check.'</td>
                    <td>'.$view_l.'</td>
                    <td>'.$click_l.'</td>
                    <td>'.$cr_click.'</td>
                    <td>'.$cpc.'</td>
                    <td>'.$cr_site.'</td>
                    </tr>';
                }
                
                
                
            }
    
            
            
            
    
            
    
            
            
            
            
            
        }
        if($yandex_context!=0){$col2=$col.'c';
            $sqlData = "SELECT * FROM all_leads WHERE date BETWEEN $date_on_s AND $date_off_s && povtor_lead=0 && utm_source='yandex_context'";
            $resultData = $conn->query($sqlData);
            $leads = $resultData->num_rows;
            $spam_l = 0; $oform_l = 0; $sale_l = 0; $otmen_l = 0; $ne_oform_l = 0; $work_l = 0;  $price_l = 0; $cost_sd = 0; 
            while($row = $resultData->fetch_assoc())
            {
                if($row['status']==3 || $row['status']==8){ $spam_l++; }
                if($row['status']=='-1'){ $oform_l++; }
                if($row['status']=='-9'){ $sale_l++; }
                if($row['status']=='-99'){ $otmen_l++; }
                if($row['status']==6){ $ne_oform_l++; }
                if($row['status']==1 || $row['status']==2 || $row['status']==4 || $row['status']==5){ $work_l++; }
                $price_l = $price_l+$row['price'];
                $cost_sd = $cost_sd+$row['cost'];
            }
            
            $spam_p = round(($spam_l/$leads)*100); $nespam_l = $leads-$spam_l; $oform_p = round(($oform_l/$nespam_l)*100); $sale_p = round(($sale_l/$nespam_l)*100);
            $otmen_p = round(($otmen_l/$nespam_l)*100); $ne_oform_p = round(($ne_oform_l/$nespam_l)*100); $work_p = round(($work_l/$nespam_l)*100);
            
            $sqlDataCost = "SELECT * FROM all_leads_cost WHERE date_time BETWEEN $date_on_s AND $date_off_s && type_place='yandex_context'";
            $resultDataCost = $conn->query($sqlDataCost);
            $view_l = 0; $click_l = 0; $cost_l = 0; $arrayCampaign = array(); $arrayGroup = array();
            while($row = $resultDataCost->fetch_assoc())
            {
                $view_l=$view_l+$row['view'];
                $click_l=$click_l+$row['click'];
                $cost_l=$cost_l+$row['cost'];
                if (!in_array($row['campaign_id']."/".$row['campaign_name'], $arrayCampaign)) {
                    $arrayCampaign[] = $row['campaign_id']."/".$row['campaign_name'];
                }
                
            }
    
            $cr_click = round(($click_l/$view_l)*100, 1);
            $cpc = round($cost_l/$click_l);
            $prib_l = $price_l-$cost_sd-$cost_l;
            $cpl = round($cost_l/$nespam_l);
            $cpl = round($cost_l/$nespam_l);
            $cpo = round($cost_l/$sale_l);
            $cr_check = round($price_l/$sale_l);
            $cr_site = round(($nespam_l/$click_l)*100, 1);
            
            echo '<tr class="table_all table_hiddeh_'.$col.' hidd"><td></td>
            <td>yandex_context</td>
            <td><span class="table_open2" id="table_hiddeh2_'.$col2.'">раскрыть</span></td>
            <td></td>
            <td>'.$leads.'</td>
            <td class="table_spam">'.$spam_l.'</td>
            <td class="table_spam">'.$spam_p.'%</td>
            <td>'.$nespam_l.'</td>
            <td class="table_oform">'.$oform_l.'</td>
            <td class="table_oform">'.$oform_p.'%</td>
            <td class="table_sale">'.$sale_l.'</td>
            <td class="table_sale">'.$sale_p.'%</td>
            <td class="table_spam">'.$otmen_l.'</td>
            <td class="table_spam">'.$otmen_p.'%</td>
            <td class="table_spam">'.$ne_oform_l.'</td>
            <td class="table_spam">'.$ne_oform_p.'%</td>
            <td>'.$work_l.'</td>
            <td>'.$work_p.'%</td>
            <td>'.$cost_l.'</td>
            <td>'.$price_l.'</td>
            <td class="table_prib">'.$prib_l.'</td>
            <td>'.$cpl.'</td>
            <td>'.$cpo.'</td>
            <td>'.$cr_check.'</td>
            <td>'.$view_l.'</td>
            <td>'.$click_l.'</td>
            <td>'.$cr_click.'</td>
            <td>'.$cpc.'</td>
            <td>'.$cr_site.'</td>
            </tr>';
            
            //ищем гр об по каждой кампании в расходах
        
            for ($i = 0; $i < count($arrayCampaign); $i++) { $col3= $col2.'c';
                $camp = explode('/',$arrayCampaign[$i]);
                $campaign_id = $camp[0];
                $campaign_name = $camp[1];
    
                $sqlDataCost = "SELECT * FROM all_leads_cost WHERE date_time BETWEEN $date_on_s AND $date_off_s && type_place='yandex_context' && campaign_id='$campaign_id'";
                $resultDataCost = $conn->query($sqlDataCost);
                $view_l = 0; $click_l = 0; $cost_l = 0; $arrayGroup = array();
                while($row = $resultDataCost->fetch_assoc())
                {
                    $view_l=$view_l+$row['view'];
                    $click_l=$click_l+$row['click'];
                    $cost_l=$cost_l+$row['cost'];
                    if (!in_array($row['group_obv']."/".$row['group_name'], $arrayGroup)) {
                        $arrayGroup[] = $row['group_obv']."/".$row['group_name'];
                    }
                }
    
                $zapros = " date BETWEEN ".$date_on_s." AND ".$date_off_s." && povtor_lead=0 && utm_source='yandex_context'";
                for ($k = 0; $k < count($arrayGroup); $k++) {
                    $Group = explode('/',$arrayGroup[$k]);
                    $group_obv = $Group[0];
                    $group_name = $Group[1];
                    
                    if($k==0){$zapros = $zapros." && utm_content='".$group_obv."'";}
                    else {$zapros = $zapros." || date BETWEEN ".$date_on_s." AND ".$date_off_s." && povtor_lead=0 && utm_source='yandex_context' && utm_content='".$group_obv."'";}
                    
                }

                $sqlData = "SELECT * FROM all_leads WHERE $zapros";
                $resultData = $conn->query($sqlData);
                $leads = $resultData->num_rows;
                $spam_l = 0; $oform_l = 0; $sale_l = 0; $otmen_l = 0; $ne_oform_l = 0; $work_l = 0;  $price_l = 0; $cost_sd = 0; 
                
                while($row = $resultData->fetch_assoc())
                {
                    if($row['status']==3 || $row['status']==8){ $spam_l++; }
                    if($row['status']=='-1'){ $oform_l++; }
                    if($row['status']=='-9'){ $sale_l++; }
                    if($row['status']=='-99'){ $otmen_l++; }
                    if($row['status']==6){ $ne_oform_l++; }
                    if($row['status']==1 || $row['status']==2 || $row['status']==4 || $row['status']==5){ $work_l++; }
                    $price_l = $price_l+$row['price'];
                    $cost_sd = $cost_sd+$row['cost'];
                }
                
                $spam_p = round(($spam_l/$leads)*100); $nespam_l = $leads-$spam_l; $oform_p = round(($oform_l/$nespam_l)*100); $sale_p = round(($sale_l/$nespam_l)*100);
                $otmen_p = round(($otmen_l/$nespam_l)*100); $ne_oform_p = round(($ne_oform_l/$nespam_l)*100); $work_p = round(($work_l/$nespam_l)*100);
                
                $cr_click = round(($click_l/$view_l)*100, 1);
                $cpc = round($cost_l/$click_l);
                $prib_l = $price_l-$cost_sd-$cost_l;
                $cpl = round($cost_l/$nespam_l);
                $cpl = round($cost_l/$nespam_l);
                $cpo = round($cost_l/$sale_l);
                $cr_check = round($price_l/$sale_l);
                $cr_site = round(($nespam_l/$click_l)*100, 1);
                
                echo '<tr class="table_all table_hiddeh2_'.$col2.' hidd"><td></td>
                <td></td>
                <td>'.$campaign_name.'</td>
                <td><span class="table_open3" id="table_hiddeh3_'.$col3.'">раскрыть</span></td>
                <td>'.$leads.'</td>
                <td class="table_spam">'.$spam_l.'</td>
                <td class="table_spam">'.$spam_p.'%</td>
                <td>'.$nespam_l.'</td>
                <td class="table_oform">'.$oform_l.'</td>
                <td class="table_oform">'.$oform_p.'%</td>
                <td class="table_sale">'.$sale_l.'</td>
                <td class="table_sale">'.$sale_p.'%</td>
                <td class="table_spam">'.$otmen_l.'</td>
                <td class="table_spam">'.$otmen_p.'%</td>
                <td class="table_spam">'.$ne_oform_l.'</td>
                <td class="table_spam">'.$ne_oform_p.'%</td>
                <td>'.$work_l.'</td>
                <td>'.$work_p.'%</td>
                <td>'.$cost_l.'</td>
                <td>'.$price_l.'</td>
                <td class="table_prib">'.$prib_l.'</td>
                <td>'.$cpl.'</td>
                <td>'.$cpo.'</td>
                <td>'.$cr_check.'</td>
                <td>'.$view_l.'</td>
                <td>'.$click_l.'</td>
                <td>'.$cr_click.'</td>
                <td>'.$cpc.'</td>
                <td>'.$cr_site.'</td>
                </tr>';
                
                
                for ($d = 0; $d < count($arrayGroup); $d++) { 
                    $camp = explode('/',$arrayGroup[$d]);
                    $Group_id = $camp[0];
                    $Group_name = $camp[1];
                    
                    $sqlDataCost = "SELECT * FROM all_leads_cost WHERE date_time BETWEEN $date_on_s AND $date_off_s && type_place='yandex_context' && group_obv='".$Group_id."'";
                    $resultDataCost = $conn->query($sqlDataCost);
                    $view_l = 0; $click_l = 0; $cost_l = 0; 
                    while($row = $resultDataCost->fetch_assoc())
                    {
                        $view_l=$view_l+$row['view'];
                        $click_l=$click_l+$row['click'];
                        $cost_l=$cost_l+$row['cost'];
                        
                    }
                    
                    $zapros = " date BETWEEN ".$date_on_s." AND ".$date_off_s." && povtor_lead=0 && utm_source='yandex_context' && utm_content='".$Group_id."'";
                    $sqlData = "SELECT * FROM all_leads WHERE $zapros";
                    $resultData = $conn->query($sqlData);
                    $leads = $resultData->num_rows;
                    $spam_l = 0; $oform_l = 0; $sale_l = 0; $otmen_l = 0; $ne_oform_l = 0; $work_l = 0;  $price_l = 0; $cost_sd = 0; 
                    
                    while($row = $resultData->fetch_assoc())
                    {
                        if($row['status']==3 || $row['status']==8){ $spam_l++; }
                        if($row['status']=='-1'){ $oform_l++; }
                        if($row['status']=='-9'){ $sale_l++; }
                        if($row['status']=='-99'){ $otmen_l++; }
                        if($row['status']==6){ $ne_oform_l++; }
                        if($row['status']==1 || $row['status']==2 || $row['status']==4 || $row['status']==5){ $work_l++; }
                        $price_l = $price_l+$row['price'];
                        $cost_sd = $cost_sd+$row['cost'];
                    }
                    
                    $spam_p = round(($spam_l/$leads)*100); $nespam_l = $leads-$spam_l; $oform_p = round(($oform_l/$nespam_l)*100); $sale_p = round(($sale_l/$nespam_l)*100);
                    $otmen_p = round(($otmen_l/$nespam_l)*100); $ne_oform_p = round(($ne_oform_l/$nespam_l)*100); $work_p = round(($work_l/$nespam_l)*100);
                    
                    $cr_click = round(($click_l/$view_l)*100, 1);
                    $cpc = round($cost_l/$click_l);
                    $prib_l = $price_l-$cost_sd-$cost_l;
                    $cpl = round($cost_l/$nespam_l);
                    $cpl = round($cost_l/$nespam_l);
                    $cpo = round($cost_l/$sale_l);
                    $cr_check = round($price_l/$sale_l);
                    $cr_site = round(($nespam_l/$click_l)*100, 1);
                    
                    echo '<tr class="table_all table_hiddeh3_'.$col3.' hidd"><td></td>
                    <td></td>
                    <td></td>
                    <td>'.$Group_name.'</td>
                    <td>'.$leads.'</td>
                    <td class="table_spam">'.$spam_l.'</td>
                    <td class="table_spam">'.$spam_p.'%</td>
                    <td>'.$nespam_l.'</td>
                    <td class="table_oform">'.$oform_l.'</td>
                    <td class="table_oform">'.$oform_p.'%</td>
                    <td class="table_sale">'.$sale_l.'</td>
                    <td class="table_sale">'.$sale_p.'%</td>
                    <td class="table_spam">'.$otmen_l.'</td>
                    <td class="table_spam">'.$otmen_p.'%</td>
                    <td class="table_spam">'.$ne_oform_l.'</td>
                    <td class="table_spam">'.$ne_oform_p.'%</td>
                    <td>'.$work_l.'</td>
                    <td>'.$work_p.'%</td>
                    <td>'.$cost_l.'</td>
                    <td>'.$price_l.'</td>
                    <td class="table_prib">'.$prib_l.'</td>
                    <td>'.$cpl.'</td>
                    <td>'.$cpo.'</td>
                    <td>'.$cr_check.'</td>
                    <td>'.$view_l.'</td>
                    <td>'.$click_l.'</td>
                    <td>'.$cr_click.'</td>
                    <td>'.$cpc.'</td>
                    <td>'.$cr_site.'</td>
                    </tr>';
                }
                
                
                
            }
            
            
            
            
        }
        if($pryamoy_visit!=0){
            
            
            $sqlData = "SELECT * FROM all_leads WHERE date BETWEEN $date_on_s AND $date_off_s && povtor_lead=0 && utm_source='' ||  date BETWEEN $date_on_s AND $date_off_s && povtor_lead=0 && utm_source='Прямой заход'";
            $resultData = $conn->query($sqlData);
            $leads = $resultData->num_rows;
            $spam_l = 0; $oform_l = 0; $sale_l = 0; $otmen_l = 0; $ne_oform_l = 0; $work_l = 0;  $price_l = 0; $cost_sd = 0; 
            while($row = $resultData->fetch_assoc())
            {
                if($row['status']==3 || $row['status']==8){ $spam_l++; }
                if($row['status']=='-1'){ $oform_l++; }
                if($row['status']=='-9'){ $sale_l++; }
                if($row['status']=='-99'){ $otmen_l++; }
                if($row['status']==6){ $ne_oform_l++; }
                if($row['status']==1 || $row['status']==2 || $row['status']==4 || $row['status']==5){ $work_l++; }
                $price_l = $price_l+$row['price'];
                $cost_sd = $cost_sd+$row['cost'];
            }
            
            $spam_p = round(($spam_l/$leads)*100); $nespam_l = $leads-$spam_l; $oform_p = round(($oform_l/$nespam_l)*100); $sale_p = round(($sale_l/$nespam_l)*100);
            $otmen_p = round(($otmen_l/$nespam_l)*100); $ne_oform_p = round(($ne_oform_l/$nespam_l)*100); $work_p = round(($work_l/$nespam_l)*100);
            
            
            $view_l = 0; $click_l = 0; $cost_l = 0; 
            
            $cr_click = round(($click_l/$view_l)*100, 1);
            $cpc = round($cost_l/$click_l);
            $prib_l = $price_l-$cost_sd-$cost_l;
            $cpl = round($cost_l/$nespam_l);
            $cpl = round($cost_l/$nespam_l);
            $cpo = round($cost_l/$sale_l);
            $cr_check = round($price_l/$sale_l);
            $cr_site = round(($nespam_l/$click_l)*100, 1);
            
            echo '<tr class="table_all table_hiddeh_'.$col.' hidd"><td></td>
            <td>Прямой заход</td>
            <td></td>
            <td></td>
            <td>'.$leads.'</td>
            <td class="table_spam">'.$spam_l.'</td>
            <td class="table_spam">'.$spam_p.'%</td>
            <td>'.$nespam_l.'</td>
            <td class="table_oform">'.$oform_l.'</td>
            <td class="table_oform">'.$oform_p.'%</td>
            <td class="table_sale">'.$sale_l.'</td>
            <td class="table_sale">'.$sale_p.'%</td>
            <td class="table_spam">'.$otmen_l.'</td>
            <td class="table_spam">'.$otmen_p.'%</td>
            <td class="table_spam">'.$ne_oform_l.'</td>
            <td class="table_spam">'.$ne_oform_p.'%</td>
            <td>'.$work_l.'</td>
            <td>'.$work_p.'%</td>
            <td>'.$cost_l.'</td>
            <td>'.$price_l.'</td>
            <td class="table_prib">'.$prib_l.'</td>
            <td>'.$cpl.'</td>
            <td>'.$cpo.'</td>
            <td>'.$cr_check.'</td>
            <td>'.$view_l.'</td>
            <td>'.$click_l.'</td>
            <td>'.$cr_click.'</td>
            <td>'.$cpc.'</td>
            <td>'.$cr_site.'</td>
            </tr>';
            
            
            
            
        }
//}                       
                        
                        
                    







?>
                </table>
            </section>
        </article>
    </main>
    <footer>
      <p></p>
    </footer>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="app.js" defer></script> 
</body>
</html>