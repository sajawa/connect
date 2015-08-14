<?php
$aSendSeqNo = rand(0,32767);					//傳送序號,自編,最大長度20
$aFunCode = "10000";							//功能代碼,存戶編號,最大長度5
$aUserData = "測試交易";							//特店顯示資料,自定,最大長度32
$aONO = "2012103011550001";						//訂單編號,自編,最大長度20
$aInAccountNo = "1000000000000001";				//銷帳編號,存戶編號+繳款人銷帳編號,限數字,最大長度16
$aAmount = "10";								//金額,純數字,最大長度11
$aRsURL = urlencode("http://connect.iwantit.com.tw/firstbank/receiver.php");	//測試結果返回網址,上線後為固定值

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://connect.iwantit.com.tw/firstbank/connect_encode.php");
curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_TIMEOUT, 30);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "FunCode=".$aFunCode."&SendSeqNo=".$aSendSeqNo."&UserData=".$aUserData."&ONO=".$aONO."&InAccountNo=".$aInAccountNo."&Amount=".$aAmount."&RsURL=".$aRsURL);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$CardPayRq = curl_exec($ch);
curl_close($ch);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
</head>

<body>
SendSeqNo 傳送序號：<span style='color:red;'><?php echo $aSendSeqNo ?></span><br /><br />
FunCode 功能代碼：<span style='color:red;'><?php echo $aFunCode ?></span><br /><br />
UserData 特店顯示資料：<span style='color:red;'><?php echo $aUserData ?></span><br /><br />
ONO 訂單編號：<span style='color:red;'><?php echo $aONO ?></span><br /><br />
InAccountNo 銷帳編號：<span style='color:red;'><?php echo $aInAccountNo ?></span><br /><br />
Amount 金額：<span style='color:red;'><?php echo $aAmount ?></span><br /><br />
=====================================================================================<br /><br />
<?php if($CardPayRq != "Error" && $CardPayRq != "Null"){ ?>
測試收款網址：<span style='color:red;'>https://teatm.firstbank.com.tw/acq/cardpay</span><br />
<form id="form1" name="form1" method="post" action="https://teatm.firstbank.com.tw/acq/cardpay">
  <label for="CardPayRq">CardPayRq 加密傳遞資料：</label><textarea name="CardPayRq" id="CardPayRq" cols="45" rows="5" style="color:red;"><?php echo $CardPayRq ?></textarea>
  <input type="submit" name="button" id="button" value="送出" />
</form>
<?php }else{ ?>
加密失敗
<?php } ?>
</body>
</html>
