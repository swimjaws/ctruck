<?
	include $_SERVER["DOCUMENT_ROOT"]."/common/db_info.php";
	include $_SERVER["DOCUMENT_ROOT"]."/common/myFunction.php";
	
	#######################################
	# DBConnection u
	$db_function = new db_function();
	#######################################
	
	include $_SERVER["DOCUMENT_ROOT"]."/common/CommonLib.php";
	mysql_query('set names utf8');
?>
<?
	if(!$_SESSION[admin_id]){
	echo "<script language=javascript>
		  location.href = '/adm/';
		  </script>";
	}
	
	$imgcnt = count($attachfile)-1;
	
	$carname = addslashes($carname);
	$bigo = addslashes($bigo);
	$content = addslashes($content);
	
	$query = " update carinfo
                	set maker = '$maker',
					cartype = '$cartype',
					carkind = '$carkind',
					carname = '$carname',
					carnumber = '$carnumber',
					divinumber = '$divinumber',
					pidnum = '$pidnum',
					price = '$price', 
					price_t = '$price_t', 
					distance = '$distance',
					makeyear = '$makeyear',
					makemonth = '$makemonth',
					makeyear2 = '$makeyear2',
					makemonth2 = '$makemonth2',
					ton = '$ton',
					gear = '$gear',
					color = '$color',					
					seize = '$seize',
					pledge = '$pledge',
					carnum = '$carnum',
					option1 = '$option1',
					option2 = '$option2',
					option3 = '$option3',
					option4 = '$option4',
					option5 = '$option5',
					option6 = '$option6',
					option7 = '$option7',
					option8 = '$option8',
					option9 = '$option9',
					option10 = '$option10',
					option11 = '$option11',
					option12 = '$option12',
					boxlong = '$boxlong',
					boxlong_text = '$boxlong_text',
					shaft = '$shaft',
					bigo = '$bigo',
					url = '$yurl',	
					content = '$content' where idx=$idx ";
    $db_function->insert_db($query,$dbconn);
	
	$queryd = "delete from carinfo_img where j_idx=$idx";
    $db_function->delete_db($queryd,$dbconn);
	
	$j = 0;
	for ($i=$imgcnt; $i>=0; $i--) {
		$query = "insert into carinfo_img
                	set j_idx = '$idx',
					j_no = '$j',
					j_file = '$attachfile[$i]',
					j_filesize = '$fsize[$i]',
					j_file_org = '$fname[$i]'";
		$db_function->insert_db($query,$dbconn);
		$j = $j+1;
	}
	
	echo("<meta http-equiv='refresh' content='0;url=view.php?idx=$idx&pagenum=$pagenum&keyfield=$keyfield&keyword=$keyword'>");
?>