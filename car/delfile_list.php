<?
	include $_SERVER["DOCUMENT_ROOT"]."/common/db_info.php";
	include $_SERVER["DOCUMENT_ROOT"]."/common/myFunction.php";
	
	#######################################
	# DBConnection u
	$db_function = new db_function();
	#######################################
	
	include $_SERVER["DOCUMENT_ROOT"]."/common/CommonLib.php";
	
	if(!$_SESSION[admin_id]){
		echo "403";
		die();
	}
	
	if($_POST['fnm']) {
		@unlink($_SERVER['DOCUMENT_ROOT']."/carimg/{$_POST['fnm']}");
		echo "200";
	} else {
		
		$f_idx = str_replace("d","", $_POST['fid']);
		
		$querydi = "select * from carinfo_img where idx='{$f_idx}' limit 1";
		$result = $db_function->select_db($querydi,$dbconn);	
		while($rs=mysql_fetch_array($result))
		{
			@unlink($_SERVER['DOCUMENT_ROOT']."/carimg/{$rs['j_file']}");
		}

		$queryd = "delete from carinfo_img where idx='{$f_idx}' limit 1";
		$db_function->delete_db($queryd,$dbconn);
		
		echo "200";
	
	}
?>
