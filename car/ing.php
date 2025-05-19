<?
	include $_SERVER["DOCUMENT_ROOT"]."/common/db_info.php";
	include $_SERVER["DOCUMENT_ROOT"]."/common/myFunction.php";
	header("content-type:text/html; charset=utf-8");
	
	#######################################
	# DBConnection包访 按眉积己
	$db_function = new db_function();
	#######################################
	
	if(!$_SESSION[admin_id]){
	echo "<script language=javascript>
		  location.href = '/adm/';
		  </script>";
	}
?>
<?
	
	$query = "update carinfo set issale='Y' where idx=$idx";
	$db_function->update_db($query,$dbconn);
	
	
	//echo("<meta http-equiv='refresh' content='0;url=list.php?pagenum=$pagenum'>");
	
?>
<script language="javascript">
	alert("Change ok!");
	parent.list();
</script>