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

/**/$rawdata = file_get_contents("php://input");
$decoded = json_decode($rawdata);
//print_r ($decoded);
writeToLog($decoded, 'rawdata');
writeToLog($_REQUEST, 'REQUEST');

?>