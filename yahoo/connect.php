<?php
switch($_POST['mode'])
{
    case "AddEmpAccount":
		$re_post = 'mode=AddEmpAccount&add_EmployeeId='.$_POST["add_EmployeeId"].'&add_Name='.$_POST["add_Name"].'&add_Birthday='.$_POST["add_Birthday"].'&add_Email='.$_POST["add_Email"].'&add_Phone='.$_POST["add_Phone"].'&add_LastFiveNumberOfId='.$_POST["add_LastFiveNumberOfId"];
	    break;
	case "DepartEmployee":
		$re_post = 'mode=DepartEmployee&depart_EmployeeId='.$_POST["depart_EmployeeId"];
		break;
	case "RechargeEmpFund":
		$re_post = 'mode=RechargeEmpFund&recharge_RechargeId='.$_POST["recharge_RechargeId"].'&recharge_RechargeCause='.$_POST["recharge_RechargeCause"].'&recharge_ApplyTotalAmount='.$_POST["recharge_ApplyTotalAmount"].'&recharge_EffectiveDate='.$_POST["recharge_EffectiveDate"].'&recharge_ExpirationDate='.$_POST["recharge_ExpirationDate"].'&recharge_ExpirationType='.$_POST["recharge_ExpirationType"].'&recharge_EmpId='.$_POST["recharge_EmpId"].'&recharge_EmpName='.$_POST["recharge_EmpName"].'&recharge_Points='.$_POST["recharge_Points"];
		break;
	case "ApproveEmpFund":
		$re_post = 'mode=ApproveEmpFund&Approve_FundId='.$_POST["Approve_FundId"].'&Approve_Status='.$_POST["Approve_Status"];
		break;
	case "GetFundSource":
		$re_post = 'mode=GetFundSource';
		break;
	case "QueryEmpApproveFund":
		$re_post = 'mode=QueryEmpApproveFund';
		break;
}
if($_POST['mode'] == "AddEmpAccount" || $_POST['mode'] == "DepartEmployee" || $_POST['mode'] == "RechargeEmpFund" || $_POST['mode'] == "ApproveEmpFund" || $_POST['mode'] == "GetFundSource" || $_POST['mode'] == "QueryEmpApproveFund")
{
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://connect.iwantit.com.tw/yahoo/connect_send.php");
	curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $re_post);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$post_re = curl_exec($ch);
	curl_close($ch);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title></title>
<style type="text/css">
body, td, th {
	font-size: 10pt;
	color: #333;
}
</style>
<script language="javascript">
function changeStyle(str)
{
    if(str == "AddEmpAccount"){document.getElementById('AddEmpAccount').style.display='block';}else{document.getElementById('AddEmpAccount').style.display='none';}
    if(str == "DepartEmployee"){document.getElementById('DepartEmployee').style.display='block';}else{document.getElementById('DepartEmployee').style.display='none';}
    if(str == "RechargeEmpFund"){document.getElementById('RechargeEmpFund').style.display='block';}else{document.getElementById('RechargeEmpFund').style.display='none';}
    if(str == "ApproveEmpFund"){document.getElementById('ApproveEmpFund').style.display='block';}else{document.getElementById('ApproveEmpFund').style.display='none';}
    if(str == "GetFundSource"){document.getElementById('GetFundSource').style.display='block';}else{document.getElementById('GetFundSource').style.display='none';}
    if(str == "QueryEmpApproveFund"){document.getElementById('QueryEmpApproveFund').style.display='block';}else{document.getElementById('QueryEmpApproveFund').style.display='none';}
}
</script>
</head>

<body>
<div style="margin:0 auto; width:735px;">
    <div style="width:150px; position:relative; float:left;">
      <input name="mode" type="radio" id="r_AddEmpAccount" value="AddEmpAccount" onclick="changeStyle('AddEmpAccount')"<?php if($_POST['mode'] == "AddEmpAccount" || $_POST['mode'] == ""){echo ' checked="checked "';}; ?>/>
      <label for="r_AddEmpAccount" style="position:relative; top:-2px;">a. 新增員工帳號</label>
      <br />
      <input type="radio" name="mode" id="r_DepartEmployee" value="DepartEmployee" onclick="changeStyle('DepartEmployee')"<?php if($_POST['mode'] == "DepartEmployee"){echo ' checked="checked "';}; ?>/>
      <label for="r_DepartEmployee" style="position:relative; top:-2px;">d. 離職員工</label>
      <br />
      <input type="radio" name="mode" id="r_RechargeEmpFund" value="RechargeEmpFund" onclick="changeStyle('RechargeEmpFund')"<?php if($_POST['mode'] == "RechargeEmpFund"){echo ' checked="checked "';}; ?>/>
      <label for="r_RechargeEmpFund" style="position:relative; top:-2px;">2. 新增員工灌點</label>
      <br />
      <input type="radio" name="mode" id="r_ApproveEmpFund" value="ApproveEmpFund" onclick="changeStyle('ApproveEmpFund')"<?php if($_POST['mode'] == "ApproveEmpFund"){echo ' checked="checked "';}; ?>/>
      <label for="r_ApproveEmpFund" style="position:relative; top:-2px;">4. 員工灌點審核</label>
      <br />
      <input type="radio" name="mode" id="r_GetFundSource" value="GetFundSource" onclick="changeStyle('GetFundSource')"<?php if($_POST['mode'] == "GetFundSource"){echo ' checked="checked "';}; ?>/>
      <label for="r_GetFundSource" style="position:relative; top:-2px;">1. 查詢灌點來源</label>
      <br />
      <input type="radio" name="mode" id="r_QueryEmpApproveFund" value="QueryEmpApproveFund" onclick="changeStyle('QueryEmpApproveFund')"<?php if($_POST['mode'] == "QueryEmpApproveFund"){echo ' checked="checked "';}; ?>/>
      <label for="r_QueryEmpApproveFund" style="position:relative; top:-2px;">3. 查詢待審核名單</label>
    </div>
    <div style="width:560px; position:relative; float:left; margin-left:25px;">
      <div id="AddEmpAccount" style="background-color:#CCC; border:#333 1px solid; padding:5px;<?php if($_POST['mode'] != "AddEmpAccount" && $_POST['mode'] != ""){echo ' display:none;';}; ?>"> <span style="color:#F00;">新增員工帳號</span><br />
        <br />
        <form id="form1" name="form1" method="post" action="">
        <input name="mode" type="hidden" value="AddEmpAccount" />
        <label for="add_EmployeeId">工號：</label>
        <input name="add_EmployeeId" type="text" value="<?php echo $_POST['add_EmployeeId']; ?>" />
        <br />
        <br />
        <label for="add_Name">員工姓名：</label>
        <input name="add_Name" type="text" value="<?php echo $_POST['add_Name']; ?>" />
        <br />
        <br />
        <label for="add_Birthday">生日：</label>
        <input name="add_Birthday" type="text" value="<?php echo $_POST['add_Birthday']; ?>" /> <span style="color:#F00; font-weight:bold;">2011-11-11T00:00:00</span>
        <br />
        <br />
        <label for="add_Email">Email：</label>
        <input name="add_Email" type="text" value="<?php echo $_POST['add_Email']; ?>" />
        <br />
        <br />
        <label for="add_Phone">電話：</label>
        <input name="add_Phone" type="text" value="<?php echo $_POST['add_Phone']; ?>" />
        <br />
        <br />
        <label for="add_LastFiveNumberOfId">身分證末五碼：</label>
        <input name="add_LastFiveNumberOfId" type="text" value="<?php echo $_POST['add_LastFiveNumberOfId']; ?>" />
        <br />
        <br />
        <input name="" type="submit" value="送出" />
        </form>
      </div>
      <div id="DepartEmployee" style="background-color:#CCC; border:#333 1px solid; padding:5px;<?php if($_POST['mode'] != "DepartEmployee"){echo ' display:none;';}; ?>"> <span style="color:#F00;">離職員工</span><br />
        <br />
        <form id="form1" name="form1" method="post" action="">
        <input name="mode" type="hidden" value="DepartEmployee" />
        <label for="depart_EmployeeId">工號：</label>
        <input name="depart_EmployeeId" type="text" value="<?php echo $_POST['depart_EmployeeId']; ?>" />
        <br />
        <br />
        <input name="" type="submit" value="送出" />
        </form>
      </div>
      <div id="RechargeEmpFund" style="background-color:#CCC; border:#333 1px solid; padding:5px;<?php if($_POST['mode'] != "RechargeEmpFund"){echo ' display:none;';}; ?>"> <span style="color:#F00;">新增員工灌點</span><br />
        <br />
        <form id="form1" name="form1" method="post" action="">
        <input name="mode" type="hidden" value="RechargeEmpFund" />
        <label for="recharge_RechargeId">企業主帳號灌點來源ID：</label>
        <input name="recharge_RechargeId" type="text" value="<?php echo $_POST['recharge_RechargeId']; ?>" />
        <br />
        <br />
        <label for="recharge_RechargeCause">灌點原因：</label>
        <input name="recharge_RechargeCause" type="text" value="<?php echo $_POST['recharge_RechargeCause']; ?>" />
        <br />
        <br />
        <label for="recharge_ApplyTotalAmount">新增總點數：</label>
        <input name="recharge_ApplyTotalAmount" type="text" value="<?php echo $_POST['recharge_ApplyTotalAmount']; ?>" />
        <br />
        <br />
        <label for="recharge_EffectiveDate">點數生效日：</label>
        <input name="recharge_EffectiveDate" type="text" value="<?php echo $_POST['recharge_EffectiveDate']; ?>"/> <span style="color:#F00; font-weight:bold;">2011-11-11T00:00:00</span>
        <br />
        <br />
        <label for="recharge_ExpirationDate">點數過期日：</label>
        <input name="recharge_ExpirationDate" type="text" value="<?php echo $_POST['recharge_ExpirationDate']; ?>" disabled="disabled" style="background-color:#999;" /> <span style="color:#F00; font-weight:bold;">灌點來源不可回收需空白</span>
        <br />
        <br />
        <label for="recharge_ExpirationType">點數到期處理方式：</label>
        <select name="recharge_ExpirationType" id="select" disabled="disabled" style="background-color:#999;" >
          <option value="" <?php if($_POST['recharge_ExpirationType']==""){echo'selected="selected"';} ?>></option>
          <option value="0" <?php if($_POST['recharge_ExpirationType']=="0"){echo'selected="selected"';} ?>>到期作廢</option>
          <option value="1" <?php if($_POST['recharge_ExpirationType']=="1"){echo'selected="selected"';} ?>>到期回收</option>
        </select> <span style="color:#F00; font-weight:bold;">灌點來源不可回收需空白</span>
        <br />
        <br />
        <label for="recharge_EmpId">工號：</label>
        <input name="recharge_EmpId" type="text" value="<?php echo $_POST['recharge_EmpId']; ?>" />
        <br />
        <br />
        <label for="recharge_EmpName">姓名：</label>
        <input name="recharge_EmpName" type="text" value="<?php echo $_POST['recharge_EmpName']; ?>" />
        <br />
        <br />
        <label for="recharge_Points">點數：</label>
        <input name="recharge_Points" type="text" value="<?php echo $_POST['recharge_Points']; ?>" />
        <br />
        <br />
        <input name="" type="submit" value="送出" />
        </form>
      </div>
      <div id="ApproveEmpFund" style="background-color:#CCC; border:#333 1px solid; padding:5px;<?php if($_POST['mode'] != "ApproveEmpFund"){echo ' display:none;';}; ?>"> <span style="color:#F00;">員工灌點審核</span><br />
        <br />
        <form id="form1" name="form1" method="post" action="">
        <input name="mode" type="hidden" value="ApproveEmpFund" />
        <label for="Approve_FundId">灌點序號：</label>
        <input name="Approve_FundId" type="text" value="<?php echo $_POST['Approve_FundId']; ?>" />
        <br />
        <br />
        <label for="Approve_Status">審核狀態：</label>
        <select name="Approve_Status" id="select">
          <option value="12" <?php if($_POST['Approve_Status']=="12"){echo'selected="selected"';} ?>>審核不通過</option>
          <option value="13" <?php if($_POST['Approve_Status']=="13"){echo'selected="selected"';} ?>>審核通過</option>
        </select>
        <br />
        <br />
        <input name="" type="submit" value="送出" />
        </form>
      </div>
      <div id="GetFundSource" style="background-color:#CCC; border:#333 1px solid; padding:5px;<?php if($_POST['mode'] != "GetFundSource"){echo ' display:none;';}; ?>"> <span style="color:#F00;">查詢灌點來源</span><br />
		<br />
        <form id="form1" name="form1" method="post" action="">
        <input name="mode" type="hidden" value="GetFundSource" />
        <input name="" type="submit" value="送出" />
        </form>
      </div>
      <div id="QueryEmpApproveFund" style="background-color:#CCC; border:#333 1px solid; padding:5px;<?php if($_POST['mode'] != "QueryEmpApproveFund"){echo ' display:none;';}; ?>"> <span style="color:#F00;">查詢待審核名單</span><br />
      	<br />
        <form id="form1" name="form1" method="post" action="">
        <input name="mode" type="hidden" value="QueryEmpApproveFund" />
        <input name="" type="submit" value="送出" />
        </form>
      </div>
    </div>
    <div style="clear:both;"><label for="textarea">結果：</label><textarea name="textarea" id="textarea" style="width:733px; background-color:#CCC; border:#333 1px solid;" rows="10"><?php echo $post_re; ?></textarea></div>
</div>
<script language="javascript">
document.getElementById('r_<?php if($_POST['mode']!=""){echo $_POST['mode'];}else{echo "AddEmpAccount";} ?>').checked = true;
</script>
</body>
</html>
