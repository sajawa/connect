<?php
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://connect.saja.com.tw/firstbank/receiver_decode.php");
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "CardPayRs=".urlencode($_REQUEST['CardPayRs']));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$CardPayRs = curl_exec($ch);
curl_close($ch);

$CPR_Array = explode("｜", mb_convert_encoding($CardPayRs, 'UTF-8', 'BIG-5'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>

<body>
<?php if($CardPayRs != "Error" && $CardPayRs != "Null"){ ?>
<?php
switch ($CPR_Array[0])
{
	case "0";
		$bResults="收款交易成功";
		break;
	case "V211";
		$bResults="傳送序號重複,訊息丟棄";
		break;
	case "V212";
		$bResults="此筆訂單之收款資料已存在且已成功付款";
		break;
	case "V213";
		$bResults="此筆訂單之收款資料已存在,但交易仍在進行中";
		break;
	case "V213";
		$bResults="此筆訂單之收款資料已存在,但主機交易中斷狀態不明";
		break;
	case "V213";
		$bResults="主機交易逾時 Pending";
		break;
	default:
		$bResults="收款交易失敗";
}
?>
	TradingResults 交易結果：<span style='color:red;'><?php echo $bResults ?></span><br /><br /><br />
    RC 回覆碼：<span style='color:red;'><?php echo $CPR_Array[0] ?></span><br /><br />
    SendSeqNo 傳送序號：<span style='color:red;'><?php echo $CPR_Array[1] ?></span><br /><br />
    MID 特店代碼：<span style='color:red;'><?php echo $CPR_Array[2] ?></span><br /><br />
    ONO 訂單編號：<span style='color:red;'><?php echo $CPR_Array[3] ?></span><br /><br />
    InAccountNo 銷帳編號：<span style='color:red;'><?php echo $CPR_Array[4] ?></span><br /><br />
    Amount 金額：<span style='color:red;'><?php echo $CPR_Array[5] ?></span><br /><br />
    TxnDate 交易日期：<span style='color:red;'><?php echo $CPR_Array[6] ?></span><br /><br />
    TxnTime 交易時間：<span style='color:red;'><?php echo $CPR_Array[7] ?></span><br /><br />
    OutBankId 轉出行代號：<span style='color:red;'><?php echo $CPR_Array[8] ?></span><br /><br />
    AtmSeqNo 交易序號：<span style='color:red;'><?php echo $CPR_Array[9] ?></span><br /><br />
    Fee 付款人手續費：<span style='color:red;'><?php echo $CPR_Array[10] ?></span><br /><br />
    MAC 押碼：<span style='color:red;'><?php echo $CPR_Array[11] ?></span><br /><br />
	<?php if($CPR_Array[12] != "Failure"){ ?>
        VerificationResults 驗證結果：<span style='color:red;'>驗證成功</span>
    <?php }else{ ?>
        VerificationResults 驗證結果：<span style='color:red;'>驗證失敗</span>
    <?php } ?>
<?php }else{ ?>
    TradingResults 交易結果：<span style='color:red;'>交易錯誤</span>
<?php } ?>
</body>
</html>