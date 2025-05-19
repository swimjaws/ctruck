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

    $query = "delete from carinfo where idx=$idx";
    $db_function->update_db($query,$dbconn);
		
	$querydi = "select * from carinfo_img where j_idx=$idx order by j_no asc";
	$result = $db_function->select_db($querydi,$dbconn);	
	while($rs=mysql_fetch_array($result))
	{
		unlink($_SERVER['DOCUMENT_ROOT']."/carimg/{$rs['j_file']}");
	}

	$queryd = "delete from carinfo_img where j_idx=$idx";
    $db_function->delete_db($queryd,$dbconn);
	
	//echo("<meta http-equiv='refresh' content='0;url=list.php?pagenum=$pagenum'>");
?>
<script>
	alert("삭제가 완료되었습니다.");
	parent.list();
</script>