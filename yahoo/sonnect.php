<?php
set_time_limit(600);

switch($_POST['mode'])
{
    case "AddEmpAccount":			//新增員工
		$re_post = 'mode=AddEmpAccount&add_EmployeeId='.$_POST["add_EmployeeId"].'&add_Name='.$_POST["add_Name"].'&add_Birthday='.$_POST["add_Birthday"].'&add_Email='.$_POST["add_Email"].'&add_Phone='.$_POST["add_Phone"].'&add_LastFiveNumberOfId='.$_POST["add_LastFiveNumberOfId"];
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
	    break;
	case "DepartEmployee":			//員工離職
		$re_post = 'mode=DepartEmployee&depart_EmployeeId='.$_POST["depart_EmployeeId"];
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
		break;
	case "RechargeEmpFund":			//查詢灌點來源->新增員工灌點->查詢待審核名單->員工灌點審核
		$re_post = 'mode=GetFundSource';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "http://connect.iwantit.com.tw/yahoo/connect_send.php");
		curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $re_post);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$post_re = curl_exec($ch);	//API_20121214152604018CP00284｜APR0000<br />1525｜95｜95點[福利金採購]｜false
		curl_close($ch);
		
		$i_GetFundSource = explode("<br />", $post_re);
		$j_GetFundSource = explode("｜", $i_GetFundSource[0]);
		if($j_GetFundSource[1] == "APR0000")
		{
			//recharge_RechargeId			企業主帳號灌點來源ID	1525
			//recharge_RechargeCause		灌點原因				自動灌點					●
			//recharge_ApplyTotalAmount		新增總點數			1
			//recharge_EffectiveDate		點數生效日			2012-12-14T00:00:00		●
			//recharge_ExpirationDate		點數過期日			灌點來源不可回收需空白
			//recharge_ExpirationType		點數到期處理方式		灌點來源不可回收需空白
			//recharge_EmpId				工號					S0006					●
			//recharge_EmpName				姓名					陳凱文					●
			//recharge_Points				點數					1						●
			
			$k_GetFundSource = explode("｜", $i_GetFundSource[1]);
			
			$re_post = 'mode=RechargeEmpFund&recharge_RechargeId='.$k_GetFundSource[0].'&recharge_RechargeCause='.$_POST["recharge_RechargeCause"].'&recharge_ApplyTotalAmount='.$_POST["recharge_Points"].'&recharge_EffectiveDate='.$_POST["recharge_EffectiveDate"].'&recharge_ExpirationDate=&recharge_ExpirationType=&recharge_EmpId='.$_POST["recharge_EmpId"].'&recharge_EmpName='.$_POST["recharge_EmpName"].'&recharge_Points='.$_POST["recharge_Points"];
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "http://connect.iwantit.com.tw/yahoo/connect_send.php");
			curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 30);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $re_post);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$post_re = curl_exec($ch);	//API_20121214154545134CP00284｜APR0000
			curl_close($ch);
			
			sleep(10);	//剛建立完成在查詢待審核名單是看不到的
			
			$i_RechargeEmpFund = explode("｜", $post_re);
			if($i_RechargeEmpFund[1] == "APR0000")
			{
				$re_post = 'mode=QueryEmpApproveFund';
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, "http://connect.iwantit.com.tw/yahoo/connect_send.php");
				curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
				curl_setopt($ch, CURLOPT_POST, 1);
				curl_setopt($ch, CURLOPT_TIMEOUT, 30);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_POSTFIELDS, $re_post);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$post_re = curl_exec($ch);	//API_20121214160349267CP00284｜APR0000<br />S0006｜陳凱文｜199952｜0｜kevin.chen@saja.com.tw｜是｜1｜2012-12-05T00:00:00｜2112-12-04T23:59:59｜0
											//API_20121214160349267CP00284｜APR0000<br />S0006｜陳凱文｜199952｜0｜kevin.chen@saja.com.tw｜是｜1｜2012-12-05T00:00:00｜2112-12-04T23:59:59｜0<br />S0006｜陳凱文｜201149｜0｜kevin.chen@saja.com.tw｜是｜1｜2012-12-14T00:00:00｜2112-12-14T23:59:59｜0
				curl_close($ch);
				
				$i_QueryEmpApproveFund = explode("<br />", $post_re);
				$j_QueryEmpApproveFund = explode("｜", $i_QueryEmpApproveFund[0]);
				if($j_QueryEmpApproveFund[1] == "APR0000")
				{
					for($i=0; $i<count($i_QueryEmpApproveFund);$i++)	//避免複數筆資料，使用迴圈審核
					{
						$k_QueryEmpApproveFund = explode("｜", $i_QueryEmpApproveFund[$i]);
						
						$i_check = 0;
						
						$k_QueryEmpApproveFund[0]."｜".$_POST["recharge_EmpId"]."<br />".$k_QueryEmpApproveFund[2]."<br />";
						
						if($k_QueryEmpApproveFund[0] == $_POST["recharge_EmpId"])	//比對工號
						{
							//Approve_FundId				灌點序號				199952
							//Approve_Status				審核狀態				13
							
							$re_post = 'mode=ApproveEmpFund&Approve_FundId='.$k_QueryEmpApproveFund[2].'&Approve_Status=13';
							$ch = curl_init();
							curl_setopt($ch, CURLOPT_URL, "http://connect.iwantit.com.tw/yahoo/connect_send.php");
							curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
							curl_setopt($ch, CURLOPT_POST, 1);
							curl_setopt($ch, CURLOPT_TIMEOUT, 30);
							curl_setopt($ch, CURLOPT_HEADER, 0);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
							curl_setopt($ch, CURLOPT_POSTFIELDS, $re_post);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							$post_re = curl_exec($ch);	//"API_20121214160737773CP00284｜APR0000";
							curl_close($ch);
							
							$i_ApproveEmpFund = explode("｜", $post_re);
							if($i_ApproveEmpFund[1] == "APR0000")
							{
								$i_check = $i_check + 1;
							}
							
							sleep(10);	//避免產生APR0007（同一個Api Key在未完成作業之前不能重覆申請相同的Request），使用等待每筆處理10秒
						}
					}
					
					//------------------------------------------------------------------------------------------------------
					
					if($i_check > 0)	//迴圈跑完了
					{
						echo "complete";
					}
					else
					{
						echo "error4";
					}
				}
				else
				{
					echo "error3";
				}
			}
			else
			{
				echo "error2";
			}
		}
		else
		{
			echo "error1";
		}
		break;
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
}
</script>
</head>

<body>
<div style="margin:0 auto; width:735px;">
    <div style="width:150px; position:relative; float:left;">
      <input name="mode" type="radio" id="r_AddEmpAccount" value="AddEmpAccount" onclick="changeStyle('AddEmpAccount')"<?php if($_POST['mode'] == "AddEmpAccount" || $_POST['mode'] == ""){echo ' checked="checked "';}; ?>/>
      <label for="r_AddEmpAccount" style="position:relative; top:-2px;">新增員工</label>
      <br />
      <input type="radio" name="mode" id="r_DepartEmployee" value="DepartEmployee" onclick="changeStyle('DepartEmployee')"<?php if($_POST['mode'] == "DepartEmployee"){echo ' checked="checked "';}; ?>/>
      <label for="r_DepartEmployee" style="position:relative; top:-2px;">員工離職</label>
      <br />
      <input type="radio" name="mode" id="r_RechargeEmpFund" value="RechargeEmpFund" onclick="changeStyle('RechargeEmpFund')"<?php if($_POST['mode'] == "RechargeEmpFund"){echo ' checked="checked "';}; ?>/>
      <label for="r_RechargeEmpFund" style="position:relative; top:-2px;">員工灌點</label>
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
        <label for="recharge_RechargeCause">灌點原因：</label>
        <input name="recharge_RechargeCause" type="text" value="<?php echo $_POST['recharge_RechargeCause']; ?>" />
        <br />
        <br />
        <label for="recharge_EffectiveDate">點數生效日：</label>
        <input name="recharge_EffectiveDate" type="text" value="<?php echo $_POST['recharge_EffectiveDate']; ?>"/> <span style="color:#F00; font-weight:bold;">2011-11-11T00:00:00</span>
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
    </div>
    <div style="clear:both;"><label for="textarea">結果：</label><textarea name="textarea" id="textarea" style="width:733px; background-color:#CCC; border:#333 1px solid;" rows="10"><?php echo $post_re; ?></textarea></div>
</div>
<script language="javascript">
document.getElementById('r_<?php if($_POST['mode']!=""){echo $_POST['mode'];}else{echo "AddEmpAccount";} ?>').checked = true;
</script>
</body>
</html>