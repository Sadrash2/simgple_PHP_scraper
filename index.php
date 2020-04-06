<?php

/*

UrlGetContentsCurl ( string url [, int timeout [, bool content [, int offset [, int maxlen]]]] )

Arguments:
  string url:   url with its protocole. For ex.
                http://www.abc.org/rfc/rfc2606.txt
                ftp://ftp.abc.org/in-notes/rfc2606.txt
  int timeout:  time limit.
                Optional. Default: current value of max_execution_time.
  bool content: true to get the content. False, the function returns the response time
                of the page or file.
                Optional. Default: true.
  int offset:   offset applied to start the content capture.
                Optional. Default: 0 (start of the page)
  int maxlen:   number of bytes to capture satrting at offset.
                Optional. Default: null (all the file/page)

Returns:
  False         failure to connect to the server or to receive a 200 OK status from the server in due time.
  String        The actual content of page/file if [content] is set to true
  Float         Response time to establish the connection to the server and to receive the 200 OK status
                for the requested file/page ([content] set to false)

*/


function GetContentsCurl(){
  // parse the argument passed and set default values
  $arg_names    = array('url', 'timeout', 'getContent', 'offset', 'maxLen');
  $arg_passed   = func_get_args();
  $arg_nb       = count($arg_passed);
  if (!$arg_nb){
    echo 'At least one argument is needed for this function';
    return false;
  }
  $arg = array (
    'url'       => null,
    'timeout'   => ini_get('max_execution_time'),
    'getContent'=> true,
    'offset'    => 0,
    'maxLen'    => null
  );
  foreach ($arg_passed as $k=>$v){
    $arg[$arg_names[$k]] = $v;
  }

  // CURL connection and result
  $ch = curl_init($arg['url']);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
  curl_setopt($ch, CURLOPT_RESUME_FROM, $arg['offset']);
  curl_setopt($ch, CURLOPT_TIMEOUT, $arg['timeout']);
  $result  = curl_exec($ch);
  $elapsed = curl_getinfo ($ch, CURLINFO_TOTAL_TIME);
  $CurlErr = curl_error($ch);
  curl_close($ch);
  if ($CurlErr) {
    echo $CurlErr;
    return false;
  }elseif ($arg['getContent']){
    return $arg['maxLen']
      ? substr($result, 0, $arg['maxLen'])
      : $result;
  }
  return $elapsed;
}

function runner($type==null,$key){
if($type==''){
$query="//".$key;
}
else{
$query="//*[@id='.$key.']";
}

$url='http://house.speakingsame.com/profile.php?q=LYNBROOK,%20VIC';
$timeout    = 50000;
$getContent = true;
$offset     = 0;
$maxLen     = 500000;

$html=GetContentsCurl($url, $timeout, $getContent,  $offset, $maxLen);
$scriptDocument = new DOMDocument();
//disable libxml errors
libxml_use_internal_errors(TRUE); 
//check if any html is actually returned
if(!empty($html)){ 
	//loadHTML
	$scriptDocument->loadHTML($html);
	//clear errors for yucky html
	libxml_clear_errors(); 
	//init DOMXPath
	$scriptDOMXPath = new DOMXPath($scriptDocument);
	//get all the h2's with an id
   //$test= $scriptDOMXPath->query("//table"); // general element
   //$test= $scriptDOMXPath->query("//*[@id='demo']"); // specific element
   
   $features=$query;
   if($features->length > 0){ // can loop or dump
		foreach($auction as $row){
		$features= $row->nodeValue. ' <br>';
		}
   }
   var_dump($features);
  
}
}

?>
