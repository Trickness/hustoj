<?php 
	require('../include/db_info.inc.php');

?>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link rel=stylesheet href='../template/<?php echo $OJ_TEMPLATE?>/<?php echo isset($OJ_CSS)?$OJ_CSS:"hoj.css" ?>' type='text/css'>
<?php function checkcontest($MSG_CONTEST){
		require_once("../include/db_info.inc.php");
		$sql="SELECT count(*) FROM `contest` WHERE `end_time`>NOW() AND `defunct`='N'";
		$result=mysql_query($sql);
		$row=mysql_fetch_row($result);
		if (intval($row[0])==0) $retmsg=$MSG_CONTEST;
		else $retmsg=$row[0]."<font color=red>&nbsp;$MSG_CONTEST</font>";
		mysql_free_result($result);
		return $retmsg;
	}
	function checkmail(){
		require_once("../include/db_info.inc.php");
		$sql="SELECT count(1) FROM `mail` WHERE 
				new_mail=1 AND `to_user`='".$_SESSION['user_id']."'";
		$result=mysql_query($sql);
		if(!$result) return false;
		$row=mysql_fetch_row($result);
		$retmsg="<font color=red>(".$row[0].")</font>";
		mysql_free_result($result);
		return $retmsg;
	}
	
	if(isset($OJ_LANG)){
		require_once("../lang/$OJ_LANG.php");
		if(file_exists("../faqs.$OJ_LANG.php")){
			$OJ_FAQ_LINK="../faqs.$OJ_LANG.php";
		}
	}else{
		require_once("../lang/en.php");
	}
	

	if($OJ_ONLINE){
		require_once('../include/online.php');
		$on = new online();
	}
?>
</head>
<body>
<div id="wrapper">
<div id=head>
<h2><img id=logo src=../image/logo.png><font color="red">重庆市第十八中学信息学竞赛小组 论坛̳</font></h2>
</div><!--end head-->
<div id=subhead>
<div id=menu >

<div class='btn' >
		<a  href="../<?php echo $OJ_HOME?>"><?php if ($url=="JudgeOnline") echo "<span class='_selected'>";?>
								<?php echo $MSG_HOME?>
								<?php if ($url=="JudgeOnline") echo "</span>";?>
		</a>
		</div>
		<div class='btn' >
		<a  href="../bbs.php"><?php if ($url==$OJ_BBS.".php") echo "<span class='_selected'>";?>
		<?php echo $MSG_BBS?><?php if ($url==$OJ_BBS.".php") echo "</span>";?></a>
		</div>
		<div class='btn' >
		<a  href="../problemset.php"><?php if ($url=="problemset.php") echo "<span class='_selected'>";?>
		<?php echo $MSG_PROBLEMS?><?php if ($url=="problemset.php") echo "</span>";?></a>
		</div>
		<div class='btn' >
		<a  href="../status.php"><?php if ($url=="status.php") echo "<span class='_selected'>";?>
		<?php echo $MSG_STATUS?><?php if ($url=="status.php") echo "</span>";?></a>
		</div>
		<div class='btn' >
		<a  href="../ranklist.php"><?php if ($url=="ranklist.php") echo "<span class='_selected'>";?>
		<?php echo $MSG_RANKLIST?><?php if ($url=="ranklist.php") echo "</span>";?></a>
		</div>
		<div class='btn' >
		<a  href="../contest.php"><?php if ($url=="contest.php") echo "<span class='_selected'>";?>
		<?php echo checkcontest($MSG_CONTEST)?><?php if ($url=="contest.php") echo "</span>";?></a>
		</div>
        <div class='btn' >
		<a  href="../recent-contest.php"><?php if ($url=="recent-contest.php") echo "<span class='_selected'>";?>
		<?php echo $MSG_RECENT_CONTEST?><?php if ($url=="recent-contest.php") echo "</span>";?></a>
		</div>
		<div class='btn' ><?php if ($url==isset($OJ_FAQ_LINK)?$OJ_FAQ_LINK:"faqs.php") echo "<span class='_selected'>";?>
		<a  href="../<?php echo isset($OJ_FAQ_LINK)?$OJ_FAQ_LINK:"faqs.php"?>"><?php echo $MSG_FAQ?><?php if ($url==isset($OJ_FAQ_LINK)?$OJ_FAQ_LINK:"faqs.php") echo "</span>";?></a>
		</div>
		<?php if(isset($OJ_DICT)&&$OJ_DICT&&$OJ_LANG=="cn"){?>
					  <div class='btn' >
							  <span  style="color:1a5cc8" id="dict_status"></span>
					  </div>
					  <script src="../include/underlineTranslation.js" type="text/javascript"></script>
					  <script type="text/javascript">dictInit();</script>
		<?php }?>


</div><!--end menu-->
<div id=profile >

<?php if (isset($_SESSION['user_id'])){
				$sid=$_SESSION['user_id'];
				print "&nbsp;<a href=../modifypage.php>$MSG_USERINFO
					</a><a href='../userinfo.php?user=$sid'>
				<font color=red>$sid</font></a>";
				$mail=checkmail();
				if ($mail)
					print "<a href=../mail.php>$mail</a>";
				print "<a href=../logout.php>$MSG_LOGOUT</a>";
			}else{
				print "<a href=../loginpage.php>$MSG_LOGIN</a>";
				print "<a href=../registerpage.php>$MSG_REGISTER</a>";
			}
			if (isset($_SESSION['administrator'])||isset($_SESSION['contest_creator'])){
				print "<a href=../admin>$MSG_ADMIN</a>";
			
			}
		?>


</div><!--end profile-->
</div><!--end subhead-->
<div id=broadcast>
<?php echo "<marquee id=broadcast scrollamount=1 direction=up scrolldelay=250>";
	echo "<font color=red>";
	echo file_get_contents($OJ_SAE?"saestor://web/msg.txt":"../admin/msg.txt");
	echo "</font>";
	echo "</marquee>";


?>
</div><!--end broadcast-->
 
<div id=main>
