<?
	include $_SERVER["DOCUMENT_ROOT"]."/common/db_info.php";
	include $_SERVER["DOCUMENT_ROOT"]."/common/myFunction.php";
	
	#######################################
	# DBConnection u
	$db_function = new db_function();
	#######################################
	
	include $_SERVER["DOCUMENT_ROOT"]."/common/CommonLib.php";
	
	if(!$_SESSION[admin_id]){
	echo "<script language=javascript>
		  location.href = '/adm/';
		  </script>";
	}
?>
<?
	$query = "select * from carinfo where idx=$idx";
	$edit = mysql_fetch_array($db_function->select_db($query,$dbconn));
	
	/* $memo = stripslashes($edit[memo]);
	$memo = str_replace( "\"", "&quot;",  $memo ); */
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title><?php include $_SERVER['DOCUMENT_ROOT']."/adm/inc/admin_title.php"; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="javascript" src="/common/CommonLib.js"></script>
<link href="/adm/css/common.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/adm/dist/sidebar-menu.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.1/jquery.min.js"></script>
<script type="text/javascript" src="/common/editor/js/HuskyEZCreator.js" charset="utf-8"></script>
<script language="javascript">
	function save()
	{
		var frm = document.frm;
			frm.action = "img_order_ok.php";
			frm.target = "_self";
			frm.submit();
	}
	
function list()
{
	var frm = document.frm;
		frm.action = "list.php";
		frm.target = "_self";
		frm.submit();
}

function view()
{
	var frm = document.frm;
		frm.action = "view.php?idx=<?php echo $idx;?>";
		frm.target = "_self";
		frm.submit();
}
	
</script>

<style>
#dragandrophandler
{
border:2px dotted #0B85A1;
width:1250px;
color:#92AAB0;
text-align:center; vertical-align:middle;
padding:30px 10px 30px 10px;
margin-bottom:10px;
font-size:200%;
}
.exp {font-size:14px;}
.progressBar {
    width: 200px;
    height: 18px;
    border: 1px solid #ddd;
    border-radius: 5px; 
    overflow: hidden;
    display:inline-block;
    margin:0px 10px 5px 5px;
    vertical-align:top;
}
 
.progressBar div {
    height: 100%;
    color: #fff;
    text-align: right;
    line-height: 18px; /* same as #progressBar height if we want text middle aligned */
    width: 0;
    background-color: #0ba1b5; border-radius: 3px; 
}
.statusbar
{
    border-top:1px solid #A9CCD1;
    min-height:20px;
    width:700px;
    padding:5px 10px 0px 10px;
    vertical-align:top;
}
.statusbar:nth-child(odd){
    /* background:#EBEFF0; */
}
.fileimg, .fileorder
{
display:inline-block;
vertical-align:top;
width:100px;
text-align:center;
}
.fileorder input {
	text-align:center;
}
.filename
{
display:inline-block;
vertical-align:top;
width:250px;
}
.filesize
{
display:inline-block;
vertical-align:top;
color:#30693D;
width:100px;
margin-left:10px;
margin-right:5px;
}
.del
{
display:inline-block;
}
.abort{
    background-color:#A8352F;
    -moz-border-radius:4px;
    -webkit-border-radius:4px;
    border-radius:4px;display:inline-block;
    color:#fff;
    font-family:arial;font-size:13px;font-weight:normal;
    padding:4px 15px;
    cursor:pointer;
    vertical-align:top
    }
.content {
	width:auto;
}
</style>
</head>
<body leftmargin="0" topmargin="0"  onLoad="">
<form name="frm" method="post">
<input type="hidden" name="idx" value="<?=$idx?>">
<input type="hidden" name="filename" size="200">
	<div id="navigation">
		<div class="header">
			<?php include $_SERVER['DOCUMENT_ROOT']."/adm/inc/head.php"; ?>
		</div>
	</div>
<div id="wrap">
	<div class="side-bar">
		<?php include $_SERVER['DOCUMENT_ROOT']."/adm/inc/sub-nav.php"; ?>
	</div>
	<div class="content">
		<table width="100%" height="35" border="0" cellpadding="0" cellspacing="0">
			<tr>
                <td>HOME > 차량관리 > 차량사진 순서변경</td>
			</tr>
		</table>
		<table width="100%" border="0" cellpadding="0" cellspacing="0">
			<tr>
			    <td height="45"><div class="hetxt">차량사진 순서변경</div></td>
			</tr>
			<tr>
			    <td height="20"></td>
			</tr>
		</table>
		<!-- 등록-->
			<div class="reg-box">
			<table class="cotable"  cellpadding="5" cellspacing="0">
				<tr>
					<th>매물명</th>
					<td><?=$edit[carname]?></td>
				</tr>
				<tr>
					<th>매물번호</th>
					<td><?=$edit[carnum]?></td>
				</tr>
				<tr>
					<th>이미지등록</th>
					<td>
						<p>※ 이미지는 순서가 가장 낮은것이 대표이미지가 되며, 오름차순으로 표시됩니다. </p>
						<div class="statusbar" style="background:#fefefe;">
							<div class='fileimg'>이미지</div>
							<div class='filename'>파일명</div>
							<div class="filesize">용량</div>
							<div class="fileorder">순서</div>
						</div>
						<?
							$query = "select * from carinfo_img where j_idx=$idx and j_file<>'' order by j_no asc";
							$result = $db_function->select_db($query,$dbconn);	
							
							while($rs=mysql_fetch_array($result))
							{
						?>
						<div id="d<?=$rs[idx]?>" class="statusbar" style="background:#efefef;">
							<div class='fileimg'><img src="/carimg/<?=$rs[j_file]?>" style="max-height:60px;"></div>
							<div class='filename'><?=$rs[j_file_org]?></div>
							<div class="filesize"><?=$rs[j_filesize]?> </div>
							<div class="fileorder"><input type="number" name="forder[<?=$rs[j_no]?>]" value="<?=($rs[j_no]+1)?>" style="width:50px;"></div>
							<input type="hidden" name="fidx[<?=$rs[j_no]?>]" value="<?=$rs[idx]?>">
							<input type="hidden" name="attachfile[<?=$rs[j_no]?>]" value="<?=$rs[j_file]?>">
							<input type="hidden" name="fname[<?=$rs[j_no]?>]" value="<?=$rs[j_file_org]?>">
							<input type="hidden" name="fsize[<?=$rs[j_no]?>]" value="<?=$rs[j_filesize]?>">
						</div>
						<? } ?>
					</td>
			  </tr>
			</table>
			</div>
			<table width="100%" border="0" cellpadding="0" cellspacing="0">
			  <tr>
			    <td width="50%" height="50" align="left"><a href="javascript:save()" class="cregbtn">사진순서 저장</a></td>
			    <td width="50%" height="50" align="left"><a href="javascript:view()" class="cregbtn">상품보기</a> <a href="javascript:list()" class="cregbtn">목록보기</a></td>
			  </tr>
			</table>
			<!-- //등록-->
	</div>
</div>
</form>
</body>
</html>
