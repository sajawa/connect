<?php
$CardPayRs = $_POST['CardPayRs'];

if($CardPayRs != "")
{
	$decord = base64_decode($CardPayRs);
	
	if(substr_count($decord, '<?xml version="1.0" encoding="Big5"?>') == 1 && substr_count($decord, '<CardPayRs>') == 1 && substr_count($decord, '</CardPayRs>') == 1)
	{
		$xml = simplexml_load_string($decord);
		$data_MAC = encrypt((string)$xml->RC, (string)$xml->SendSeqNo, (string)$xml->MID, (string)$xml->ONO, (string)$xml->InAccountNo, (string)$xml->Amount);
		
		if($data_MAC == (string)$xml->MAC)
		{
			$aResults = "Success"; //MAC比對成功
		}
		else
		{
			$aResults = "Failure"; //MAC比對錯誤
		}
		
		$overResult = (string)$xml->RC."｜".(string)$xml->SendSeqNo."｜".(string)$xml->MID."｜".(string)$xml->ONO."｜".(string)$xml->InAccountNo."｜".(string)$xml->Amount."｜".(string)$xml->TxnDate."｜".(string)$xml->TxnTime."｜".(string)$xml->OutBankId."｜".(string)$xml->AtmSeqNo."｜".(string)$xml->Fee."｜".(string)$xml->MAC."｜".$aResults;
	}
	else
	{
		$overResult = "Error"; //XML格式錯誤
	}
	
	$link = mysql_connect("210.71.253.163","iwantit_p664","d52jA6Equvakupajacha");
	mysql_select_db("iwantit_log",$link);
	$sql = "INSERT into firstbank_decode (adate, CardPayRs, RC, SendSeqNo, MID, ONO, InAccountNo, Amount, TxnDate, TxnTime, OutBankId, AtmSeqNo, Fee, MAC, VerificationResults) Values	('".date("Y-m-d H:i:s")."', '".$CardPayRs."', '".(string)$xml->RC."', '".(string)$xml->SendSeqNo."', '".(string)$xml->MID."', '".(string)$xml->ONO."', '".(string)$xml->InAccountNo."', '".(string)$xml->Amount."', '".(string)$xml->TxnDate."', '".(string)$xml->TxnTime."', '".(string)$xml->OutBankId."', '".(string)$xml->AtmSeqNo."', '".(string)$xml->Fee."', '".(string)$xml->MAC."', '".$aResults."')";
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

function encrypt($RC,$SendSeqNo,$MID,$ONO,$InAccountNo,$Amount)
{
	$iv = "00000000";
	$key = "JC26T8I3A49BHGEC8KCKUF43";
	$text = $RC.$SendSeqNo.$MID.$ONO.$InAccountNo.$Amount;
	
	$text = sha1($text).'00000000';
	
	$text = pack('H*',$text);
	$crypttext = mcrypt_encrypt(MCRYPT_tripledes, $key, $text, MCRYPT_MODE_CBC, $iv);
	
	$base64_crypttext = base64_encode($crypttext);
	return $base64_crypttext;
}

?>