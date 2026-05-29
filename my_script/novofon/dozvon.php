<?php
//Key - appid_2706587

//Secret - aoz798sqedln44tw5arc95cdzzbzosbhybgcl9rw










    
    
    
    
function call($method, $params, $format = 'json')
    {
        

        
        $params['format'] = $format;

        $options = [
            CURLOPT_URL => 'https://api.novofon.com' . $method,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_CONNECTTIMEOUT => 10,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            // => [$this, 'parseHeaders'],
            CURLOPT_HTTPHEADER => getAuthHeader($method, $params),
        ];

        $ch = curl_init();

        
        $options[CURLOPT_URL] = 'https://api.novofon.com' . $method . '?' . httpBuildQuery($params);
        

        curl_setopt_array($ch, $options);

        $response = curl_exec($ch);
        $error = curl_error($ch);

        //$this->httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        if ($error) {
            throw new ApiException($error);
        }

        return $response;
    }



function parseHeaders($curl, $line)
    {
        if (preg_match('/^X-RateLimit-([a-z]+):\s([0-9]+)/i', $line, $match)) {
            $this->limits[$match[1]] = (int)$match[2];
        }

        return strlen($line);
    }
    
    
    
function httpBuildQuery($params = [])
    {
        return http_build_query($params, '', '&', PHP_QUERY_RFC1738);
    }
    


function encodeSignature($signatureString)
    {
        $secret = 'aoz798sqedln44tw5arc95cdzzbzosbhybgcl9rw';
        return base64_encode(hash_hmac('sha1', $signatureString, $secret));
    }
    
    
    

function getAuthHeader($method, $params)
    {
        $params = array_filter($params, function ($a) {
            return !is_object($a);
        });
        ksort($params);
        $paramsString = httpBuildQuery($params);
        $signature = encodeSignature($method . $paramsString . md5($paramsString));
        
        $userKey = 'appid_2706587';
        
        return ['Authorization: ' . $userKey . ':' . $signature];
    }
    
    
//from '79812993328'  74991124034
//$params = [];
$params = array(
    'from' => '79812993328',
    'to' => '79521716699',
    'predicted' => ''
);    

print_r(call('/v1/request/callback/', $params));
















?>