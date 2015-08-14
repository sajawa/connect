<?php






$n_AgentKey = "agentkey";
$n_ApiKey = "ApiKey_CP00284";
$n_SaltKey = "CP002848e6be";
$n_AesKey = "1978llym9TseRHvVb1zkvrALi98OasGTppR+5BvQuow=";
$n_AesKeyIV = "1oLpvkxlirMbncMp8bAvBw==";
$n_ShaKey = "1978llym9TseRHvVb1zkvrALi98OasGTppR+5BvQuow=";
$client = new SOAPClient('http://vm-pp-wf2.shp.tw1.yahoo.net/WebService/CommonWebService.asmx?wsdl');
$return = $client->GetCurrentTimeStamp();
$n_TimeStamp = $return->GetCurrentTimeStampResult;






switch($_POST['mode'])
{
    case "AddEmpAccount":		//新增員工帳號
		$add_EmployeeId = $_POST['add_EmployeeId'];							//工號
		$add_Name = $_POST['add_Name'];										//員工姓名
		$add_Birthday = $_POST['add_Birthday'];								//生日
		$add_Email = $_POST['add_Email'];									//Email
		$add_Phone = $_POST['add_Phone'];									//電話
		$add_LastFiveNumberOfId = $_POST['add_LastFiveNumberOfId'];			//身分證末五碼
		$n_xml = '<?xml version="1.0" encoding="utf-8"?><AddingEmployeeRequest><Employees><Employee><EmployeeId>'.$add_EmployeeId.'</EmployeeId><Name>'.$add_Name.'</Name><Birthday>'.$add_Birthday.'</Birthday><Email>'.$add_Email.'</Email><Phone>'.$add_Phone.'</Phone><LastFiveNumberOfId>'.$add_LastFiveNumberOfId.'</LastFiveNumberOfId></Employee></Employees></AddingEmployeeRequest>';
        break;
    case "DepartEmployee":		//離職員工
		$depart_EmployeeId = $_POST['depart_EmployeeId'];					//工號
		$n_xml = '<?xml version="1.0" encoding="utf-8"?><DepartEmployeeRequestEntity><Employees><EmployeeId>'.$depart_EmployeeId.'</EmployeeId></Employees></DepartEmployeeRequestEntity>';
        break;
    case "RechargeEmpFund":		//新增員工灌點
		$recharge_RechargeId = $_POST['recharge_RechargeId'];				//企業主帳號灌點來源ID
		$recharge_RechargeCause = $_POST['recharge_RechargeCause'];			//灌點原因
		$recharge_ApplyTotalAmount = $_POST['recharge_ApplyTotalAmount'];	//新增總點數
		$recharge_EffectiveDate = $_POST['recharge_EffectiveDate'];			//點數生效日
		$recharge_ExpirationDate = $_POST['recharge_ExpirationDate'];		//點數過期日
		$recharge_ExpirationType = $_POST['recharge_ExpirationType'];		//點數到期處理方式
		$recharge_EmpId = $_POST['recharge_EmpId'];							//工號
		$recharge_EmpName = $_POST['recharge_EmpName'];						//姓名
		$recharge_Points = $_POST['recharge_Points'];						//點數
		$n_xml = '<?xml version="1.0" encoding="utf-8"?><RechargeEmpFundRequestEntity><RechargeId>'.$recharge_RechargeId.'</RechargeId><RechargeCause>'.$recharge_RechargeCause.'</RechargeCause><ApplyTotalAmount>'.$recharge_ApplyTotalAmount.'</ApplyTotalAmount><EffectiveDate>'.$recharge_EffectiveDate.'</EffectiveDate><ExpirationDate>'.$recharge_ExpirationDate.'</ExpirationDate><ExpirationType>'.$recharge_ExpirationType.'</ExpirationType><EmployeeFunds><EmployeeFundEntity><EmpId>'.$recharge_EmpId.'</EmpId><EmpName>'.$recharge_EmpName.'</EmpName><Points>'.$recharge_Points.'</Points></EmployeeFundEntity></EmployeeFunds></RechargeEmpFundRequestEntity>';
        break;
    case "ApproveEmpFund":		//員工灌點審核
		$approve_FundId = $_POST['Approve_FundId'];							//灌點序號
		$approve_Status = $_POST['Approve_Status'];							//審核狀態
		$n_xml = '<?xml version="1.0" encoding="utf-8"?><ApproveEmpFundRequestEntity><ApproveEmpFunds><ApproveEmpFundEntity><FundId>'.$approve_FundId.'</FundId><Status>'.$approve_Status.'</Status></ApproveEmpFundEntity></ApproveEmpFunds></ApproveEmpFundRequestEntity>';
        break;
    case "GetFundSource":		//查詢灌點來源
    case "QueryEmpApproveFund":	//查詢待審核名單
        $n_xml = $n_TimeStamp;												//不需額外傳遞其他參數。
        break;
}
$n_PlainText = $n_ApiKey.",".$n_xml;
//echo '<label for="textarea">明文：</label><textarea name="textarea" id="textarea" style="width:733px; background-color:#CCC; border:#333 1px solid;" rows="5">'.$n_PlainText.'</textarea><br /><br />';






function pkcs5_pad ($text, $blocksize)
{
    $pad = $blocksize - (strlen($text) % $blocksize);
    return $text.str_repeat(chr($pad), $pad);
}
$n_CipherText = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_128, base64_decode($n_AesKey), pkcs5_pad($n_PlainText, 16), MCRYPT_MODE_CBC, base64_decode($n_AesKeyIV)));
//echo '<label for="textarea">密文：</label><textarea name="textarea" id="textarea" style="width:733px; background-color:#CCC; border:#333 1px solid;" rows="5">'.$n_CipherText.'</textarea><br /><br />';






$n_ShaData = $n_TimeStamp.$n_ApiKey.$n_SaltKey.$n_CipherText;
$n_Signature = hash_hmac("sha512", $n_ShaData, $n_ShaKey);
//echo '<label for="textarea">簽章：</label><textarea name="textarea" id="textarea" style="width:733px; background-color:#CCC; border:#333 1px solid;" rows="5">'.$n_Signature.'</textarea><br /><br />';






switch($_POST['mode'])
{
    case "AddEmpAccount":		//新增員工帳號
    case "DepartEmployee":		//離職員工
		$wsdl = 'http://vm-pp-wf2.shp.tw1.yahoo.net/WebService/EmployeeAccountWebService.asmx?wsdl';
        break;
    case "RechargeEmpFund":		//新增員工灌點
    case "ApproveEmpFund":		//員工灌點審核
    case "GetFundSource":		//查詢灌點來源
    case "QueryEmpApproveFund":	//查詢待審核名單
		$wsdl = 'http://vm-pp-wf2.shp.tw1.yahoo.net/WebService/FundWebService.asmx?wsdl';
        break;
}
//echo "<span style='color:red;'>SOAP位置：".$wsdl."</span><br /><br />";
require_once 'lib/nusoap.php';
$client_array = new nusoap_client($wsdl,true);
$requestContext = array("requestContext"=>array("AgentKey"=>$n_AgentKey,		//福委公司代碼
												"ApiKey"=>$n_ApiKey,			//Request傳過來的ApiKey
												"TimeStamp"=>$n_TimeStamp,		//Response時的TimeStamp	
												"Ciphertext"=>$n_CipherText,	//明文內容：API單號與狀態碼
												"Signature"=>$n_Signature));	//將上述的資料透過secrete key製作簽章
//echo '<label for="textarea">傳送：</label><textarea name="textarea" id="textarea" style="width:733px; background-color:#CCC; border:#333 1px solid;" rows="5">'; print_r($requestContext); echo '</textarea><br /><br />';






//echo "<span style='color:red;'>呼叫函式：".$_POST['mode']."</span><br /><br />";
$return_array = $client_array->call($_POST['mode'],$requestContext);
//echo '<label for="textarea">回應：</label><textarea name="textarea" id="textarea" style="width:733px; background-color:#CCC; border:#333 1px solid;" rows="5">'; print_r($return_array); echo '</textarea><br /><br />';






switch($_POST['mode'])
{
    case "AddEmpAccount":		//新增員工帳號
		$u_Ciphertext = $return_array[AddEmpAccountResult][Ciphertext];
        break;
    case "DepartEmployee":		//離職員工
		$u_Ciphertext = $return_array[DepartEmployeeResult][Ciphertext];
        break;
    case "RechargeEmpFund":		//新增員工灌點
		$u_Ciphertext = $return_array[RechargeEmpFundResult][Ciphertext];
        break;
    case "ApproveEmpFund":		//員工灌點審核
		$u_Ciphertext = $return_array[ApproveEmpFundResult][Ciphertext];
        break;
    case "GetFundSource":		//查詢灌點來源
		$u_Ciphertext = $return_array[GetFundSourceResult][Ciphertext];
		break;
    case "QueryEmpApproveFund":	//查詢待審核名單
        $u_Ciphertext = $return_array[QueryEmpApproveFundResult][Ciphertext];
        break;
}
//echo '<label for="textarea">密文：</label><textarea name="textarea" id="textarea" style="width:733px; background-color:#CCC; border:#333 1px solid;" rows="5">'.$u_Ciphertext.'</textarea><br /><br />';






$u_PlainText = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, base64_decode($n_AesKey), base64_decode($u_Ciphertext), MCRYPT_MODE_CBC, base64_decode($n_AesKeyIV));
//echo '<label for="textarea">明文：</label><textarea name="textarea" id="textarea" style="width:733px; background-color:#CCC; border:#333 1px solid; border:#333 1px solid;" rows="5">'.$u_PlainText.'</textarea><br /><br />';






$u_source = explode(",", $u_PlainText);

$xml_aa = '<?xml version="1.0" encoding="utf-8"?>';
switch($_POST['mode'])
{
    case "AddEmpAccount":		//新增員工帳號
    case "DepartEmployee":		//離職員工
    case "RechargeEmpFund":		//新增員工灌點
    case "ApproveEmpFund":		//員工灌點審核
		$xml_bb = '</BaseApiExecutedResultEntity>';
        break;
    case "GetFundSource":		//查詢灌點來源
		$xml_bb = '</FundSourceApiExecutedResultEntity>';
		break;
    case "QueryEmpApproveFund":	//查詢待審核名單
        $xml_bb = '</ApproveEmpsApiExecutedResultEntity>';
        break;
}
$xml_a = explode($xml_aa, $u_source[1]);
$xml_b = explode($xml_bb, $xml_a[1]);

$u_xml = simplexml_load_string($xml_aa.$xml_b[0].$xml_bb);
//echo '<label for="textarea">結果：</label><textarea name="textarea" id="textarea" style="width:733px; background-color:#CCC; border:#333 1px solid;" rows="5">';
echo (string)$u_xml->ApiApplyNum."｜";	//API單號
echo (string)$u_xml->ReturnCode;		//狀態碼

//APR0000	API資料格式正確，接收執行
//APR0001	API資料格式錯誤
//APR0002	成功取得企業灌點來源
//APR0003	取得企業灌點來源發生錯誤
//APR0004	成功取得灌點審核名單
//APR0005	取得灌點審核名單發生錯誤
//APR0007	同一個Api Key在未完成作業之前不能重覆申請相同的Request
//APR0008	找不到ApiKey對應的資料
//APR0009	部份成功與失敗: 部份驗證成功執行，部份格式錯誤

switch($_POST['mode'])
{
    case "GetFundSource":		//查詢灌點來源
		$x = substr_count($u_PlainText, "<RechargeId>")-1;
		for($i=0; $i<=$x; $i++)
		{
			if($i==0){echo "<br />";};
			echo (string)$u_xml->Source->FundSourceInfo[$i]->RechargeId."｜";		//灌點來源編號
			echo (string)$u_xml->Source->FundSourceInfo[$i]->RechargeAmnt."｜";		//灌點來源點數
			echo (string)$u_xml->Source->FundSourceInfo[$i]->RechargeNote."｜";		//灌點來源備註
			echo (string)$u_xml->Source->FundSourceInfo[$i]->RechargeRecycleable;	//是否可設定回收
			if($i!=$x){echo "<br />";};
		}
        break;
    case "QueryEmpApproveFund":	//查詢待審核名單
		$x = substr_count($u_PlainText, "<EmployeeId>")-1;
		for($i=0; $i<=$x; $i++)
		{
			if($i==0){echo "<br />";};
			echo (string)$u_xml->ApproveEmpFundInfo->ApproveEmpFundInfo[$i]->EmployeeId."｜";		//工號
			echo (string)$u_xml->ApproveEmpFundInfo->ApproveEmpFundInfo[$i]->Name."｜";				//姓名
			echo (string)$u_xml->ApproveEmpFundInfo->ApproveEmpFundInfo[$i]->FundId."｜";			//灌點序號
			echo (string)$u_xml->ApproveEmpFundInfo->ApproveEmpFundInfo[$i]->FundStatus."｜";		//灌點狀態
			echo (string)$u_xml->ApproveEmpFundInfo->ApproveEmpFundInfo[$i]->Email."｜";				//Email
			echo (string)$u_xml->ApproveEmpFundInfo->ApproveEmpFundInfo[$i]->Activated."｜";			//帳號是否開通
			echo (string)$u_xml->ApproveEmpFundInfo->ApproveEmpFundInfo[$i]->Amount."｜";			//福利金點數
			echo (string)$u_xml->ApproveEmpFundInfo->ApproveEmpFundInfo[$i]->EffectiveDate."｜";		//生效日
			echo (string)$u_xml->ApproveEmpFundInfo->ApproveEmpFundInfo[$i]->ExpirationDate."｜";	//到期日
			echo (string)$u_xml->ApproveEmpFundInfo->ApproveEmpFundInfo[$i]->ExpirationType;		//到期處理方式
			if($i!=$x){echo "<br />";};
		}
        break;
}
//echo '</textarea>';






?>