<?php

// function tail($file, $num_to_get=10)
// {
	// $data = '';

	// $fp = fopen($file, 'r');
	// $position = filesize($file);
	// fseek($fp, $position-1);
	// $chunklen = 4096;
	// while($position >= 0)
	// {
		// $position = $position - $chunklen;
		// if ($position < 0) { $chunklen = abs($position); $position=0;}
		// fseek($fp, $position);
		// $data = fread($fp, $chunklen). $data;

	// }
	// fclose($fp);
	// return $data;
// }
$dbhost = 'localhost';
$dbname = 'test';
$username = 'root';
$password = 'root';



$temp_file = 'chatrec201512099.log';
$fp = fopen($temp_file ,"r+") or die("open file failure!");
$total_line = 0;
$content = '';


if ($fp) { 
$i = 1; 
while (!feof($fp)) { 
//修改第二行数据 
if ($i <= 5) { 
fseek($fp, 0, SEEK_CUR); 
//fwrite($fp, '#'); 
//break; 
 
$res = fgets($fp); 
$ares = explode('%#!@$^', $res);
foreach($ares as $v) {
			//$arrayyy[$k] = explode('%#!@$^', $v); 
		if($v == '50055215')  echo $i;
			
} 
$i++; 
echo $res;
echo "<br/>";
} 
}
}

if($fpp){
	
    // while(stream_get_line($fp,8192,"\n")){
        // $total_line++;
    // }
	//while(false != ($a = fread($fp, 8192))){//返回false表示已经读取到文件末尾
    //    $content .= $a;
   //}
	//$position = filesize($temp_file);
	//echo $position;
	// $n = 3;
	// $pos = -1;
	  // $eof = "";
	  // $str = "";
	  // fseek($fp, -1, SEEK_END);
	  // while($n > 0){
		  //$eof = fgetc($fp);
		// while(($eof = fgetc($fp)) !== false)
			// {
				// if($eof == "\n" && $str) break;
				
				// $str = $eof . $str;
				// fseek($fp, -2 * 8, SEEK_CUR);
			// }
			// $n --;
			// echo $n;
		// }
		//fclose($fp);
		if($link = mysql_connect($dbhost, $username, $password)) {
			echo 'connectted';			
		} else {
			echo 'Can not connect to MySQL server';
		}
		mysql_select_db($dbname, $link);
		print_r($link);
		//$content = file_get_contents($temp_file); 
		$array = explode("\r\n", $content); 
		foreach($array as $k => $v) {
			$arrayyy[$k] = explode('%#!@$^', $v); 
			//print_r($arrayy[$k][1]);
			
		}
		
		foreach($arrayyy AS $v) {
				
			$sql = "INSERT INTO log VALUES ('', '$v[0]', '$v[1]', '$v[2]', '$v[3]', '$v[4]', '$v[5]')";
			mysql_query($sql,$link);	

		}	
}

//$strr = "";
//$res = tail($temp_file);
//$handler = fopen($temp_file, "r");
// fseek($handler, -1, SEEK_END);			//读末尾
//fwrite($handler, "want to add this");
// while(($c = fgetc($handler)) !== false)
// {
	// if($c == "\n" && $strr) break;
	
	// $strr = $c . $strr;
	//echo "<br/>";
	//echo $strr;
	// fseek($handler, -2 , SEEK_CUR);			//往上读
// }
// echo "<br/>";
//$strr .= fgetss($handler, 4096);
//$contents = fread($handler, filesize($temp_file));
//echo $strr;
//$data = explode('%#!@$^', $strr);
//print_r($data);
?>