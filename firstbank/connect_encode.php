<?php
$data_SendSeqNo = $_POST['SendSeqNo'];														//肚癳腹,程20
$data_FunCode = $_POST['FunCode'];															//
$data_UserData = mb_convert_encoding($_POST['UserData'], 'BIG-5', 'UTF-8');					//疭┍陪ボ戈,程32
$data_ONO = $_POST['ONO'];																	//璹虫絪腹,程20
$data_InAccountNo = $_POST['InAccountNo'];													//綪眀絪腹,程16
$data_Amount = $_POST['Amount'];															//肂,程11
$data_RsURL = urldecode($_POST['RsURL']);													//肚URL,程50

if($data_SendSeqNo != "" && $data_FunCode != "" && $data_UserData != "" && $data_ONO != "" && $data_InAccountNo != "" && $data_Amount != "")
{
	$data_MID = "T00250898891";																		//疭┍絏,程15
	$data_MAC = encrypt($data_SendSeqNo, $data_MID, $data_ONO, $data_InAccountNo, $data_Amount);	//┿絏,程32
	//$data_RsURL = "http://connect.iwantit.com.tw/firstbank/connect_receiver.php";								//肚URL,程50
	
	$overResult = base64_encode('<?xml version="1.0" encoding="Big5"?><CardPayRq><SendSeqNo>'.$data_SendSeqNo.'</SendSeqNo><MID>'.$data_MID.'</MID><FunCode>'.$data_FunCode.'</FunCode><UserData>'.$data_UserData.'</UserData><ONO>'.$data_ONO.'</ONO><InAccountNo>'.$data_InAccountNo.'</InAccountNo><Amount>'.$data_Amount.'</Amount><MAC>'.$data_MAC.'</MAC><RsURL>'.$data_RsURL.'</RsURL></CardPayRq>');
	
	$link = mysql_connect("210.71.253.163","iwantit_p664","d52jA6Equvakupajacha");
	mysql_select_db("iwantit_log",$link);
	$sql = "INSERT into firstbank_encode (adate, SendSeqNo, FunCode, UserData, ONO, InAccountNo, Amount, MAC, CardPayRq) Values ('".date("Y-m-d H:i:s")."', '".$data_SendSeqNo."', '".$data_FunCode."', '".$data_UserData."', '".$data_ONO."', '".$data_InAccountNo."', '".$data_Amount."', '".$data_MAC."', '".$overResult."')";
	mysql_query("SET NAMES 'big5'"); 
	mysql_query("SET CHARACTER SET big5");
	mysql_query("SET CHARACTER_SET_RESULTS=big5");
	$result = mysql_query($sql,$link);
	mysql_close($link);
	
	if($result)
	{
		$finalResult = $overResult;
	}
	else
	{
		$finalResult = "Error";
	}
}
else
{
	$finalResult = "Null";
}

echo $finalResult;

function encrypt($SendSeqNo,$MID,$ONO,$InAccountNo,$Amount)
{
	$iv = "00000000";
	$key = "JC26T8I3A49BHGEC8KCKUF43";
	$text = $SendSeqNo.$MID.$ONO.$InAccountNo.$Amount;
	
	$text = sha1($text).'00000000';

	$text = pack('H*',$text);
	$crypttext = mcrypt_encrypt(MCRYPT_tripledes, $key, $text, MCRYPT_MODE_CBC, $iv);
	
	$base64_crypttext = base64_encode($crypttext);
	return $base64_crypttext;
}
?>