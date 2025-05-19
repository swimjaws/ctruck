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

	for($i=0; $i<count($chk); $i++){
		//echo $chk[$i];
		
		$querydi = "select * from carinfo_img where j_idx='{$chk[$i]}' order by j_no asc";
		$result = $db_function->select_db($querydi,$dbconn);	
		while($rs=mysql_fetch_array($result))
		{
			unlink($_SERVER['DOCUMENT_ROOT']."/carimg/{$rs['j_file']}");
		}
		
		$queryd = "delete from carinfo_img where j_idx='{$chk[$i]}'";
    	$db_function->delete_db($queryd,$dbconn);
		
		$query = "delete from carinfo where idx='{$chk[$i]}'";
     	$db_function->update_db($query,$dbconn);
		
	}
?>
<script language="JavaScript">
	alert("삭제가 완료되었습니다.");
	parent.result_ok();
</script>