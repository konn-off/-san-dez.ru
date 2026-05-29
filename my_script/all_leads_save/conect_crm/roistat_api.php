<?
/*echo 'lklk';
$roistat_api = '0e40c56e395b38087d5d656e162152b7';
$roistat_project = '257603';


curl 'https://cloud.roistat.com/api/v1/project/clients?project=12345' \
--request POST \
--header 'Content-type: application/json' \
--header 'Api-key: {KEY}' \
--data '{"filters": [["phone","=","79880002233"]]}'


$data = array( 'filters' => array( 'phone' => '79523845025' ));	
//$data = '{"filters": [["phone","=","79523845025"]]}';	



 
$ch = curl_init('https://cloud.roistat.com/api/v1/project/calltracking/phone/list?project='.$roistat_project);
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Api-key: '.$roistat_api));
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, JSON_UNESCAPED_UNICODE)); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_HEADER, false);
$res = curl_exec($ch);
curl_close($ch);
 
$res = json_encode($res, JSON_UNESCAPED_UNICODE);
print_r($res);

*/

$api = "0e40c56e395b38087d5d656e162152b7";
//$api = "02712ee9ebfe890157cea3e83084992a";
$project = "257603";

//$link = "https://cloud.roistat.com/api/v1/project/integration/order/list?key=".$api."&project=".$project;
//$link = "https://cloud.roistat.com/api/v1/project/clients?key=".$api."&project=".$project;
$link = "https://cloud.roistat.com/api/v1/project/orders/P438575/info?key=".$api."&project=".$project;

$curl = curl_init();

curl_setopt_array($curl, array(
	CURLOPT_URL => $link,
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_ENCODING => "",
	CURLOPT_MAXREDIRS => 10,
	CURLOPT_TIMEOUT => 30,
	CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	CURLOPT_CUSTOMREQUEST => "GET",
	//CURLOPT_POSTFIELDS => "{\"filters\":[[\"phone\",\"=\",\"79880002233\"]],\"limit\": 100,\"offset\": 0}",
	//CURLOPT_POSTFIELDS => "{\"filters\": {\"and\": [[\"creation_date\",\">\",\"2024-09-11T21:00:00+0000\"],[\"creation_date\",\"<\",\"2022-09-11T21:00:00+0000\"]]}}",
	//CURLOPT_POSTFIELDS => "{\"extend\":[\"visit\"],\"filters\":[[\"id\",\"=\",\"P423078\"]]}",
	//CURLOPT_POSTFIELDS => "{\"extend\":[\"visit\"],\"filters\":[[\"client_phones\",\"=\",\"79880002233\"]],\"limit\": 100,\"offset\": 0}",
	//CURLOPT_POSTFIELDS => "{\"limit\": 100,\"offset\": 0}",
	CURLOPT_HTTPHEADER => array("content-type: application/json"),
));

	$response = json_decode(curl_exec($curl), 1);
	$err = curl_error($curl);

	curl_close($curl);
print_r($response);
if(isset($response['order']['client_phones'][0])){
	echo $response['order']['client_phones'][0].' '.$response['order']['fields_data']['Менеджер']; //телефон
}else{echo 'no';}


?>