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
		$query = "update carinfo set best_Fl='N' where idx=$chk[$i]";
     	$db_function->update_db($query,$dbconn);
	}
?>
<script language="JavaScript">
	alert("추천 해제되었습니다.");
	parent.result_ok();
</script>