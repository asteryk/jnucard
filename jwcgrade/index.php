<?php
include "jwcpic.class.php";
include 'simple_html_dom.php';
function echopicstring()
{
	$result="";
	$jwc = new Jwcpic();
	$content = $jwc->pic_to_string();
	$verify=strlen($content["string"]);
		if ($verify>3&&$verify!=0) {
			$result=jwc_curl($content["cookie"],$content["string"]);
		}else{
			//echo "wrong";
			$result = echopicstring();
		}
	if ($result == "wrong") {
		$result = echopicstring();
	}
	return $result;
}
function jwc_curl($cookie,$jwcpic){
	$header = array( 
	'CLIENT-IP:202.116.1.251', 
	'X-FORWARDED-FOR:202.116.1.251', 
	); 
	$cookie_jar = tempnam('./tmp','JSESSIONID');
	$url = "http://202.116.0.176/Login.aspx";
	$post_data = array(
		"__VIEWSTATE"=>"/wEPDwUKMjA1ODgwODUwMg9kFgJmD2QWAgIBDw8WAh4EVGV4dAUk5pqo5Y2X5aSn5a2m57u85ZCI5pWZ5Yqh566h55CG57O757ufZGRkmlKcLw0rOdqjE6pm9KqQBjteY3E=",
		"__VIEWSTATEGENERATOR"=>"C2EE9ABB",
		"__EVENTVALIDATION"=>"/wEWBwLK+pMNAoOdsPYMAtWn3MkMAqL7pscOAoLch4YMAq3zo/AFAu/dqr0H7wgEN4XKQDto4EOtNq8qeT0sZcg=",
		"txtYHBS"=>$_GET['id'],
		"txtYHMM"=>$_GET['password'],
		"txtFJM"=>$jwcpic,
		"btnLogin"=>"登    录",
		);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// post数据
	curl_setopt($ch, CURLOPT_POST, 1);
	// post的变量
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar); 
	$output2 = curl_exec($ch);
	curl_close($ch);
	//=======================================
	//用课表的title区别来做是否进入失败的验证
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://202.116.0.176/Secure/PaiKeXuanKe/wfrm_XK_MainCX.aspx");
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);        
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
	$output3 = curl_exec($ch);
	//echo $output3;
	curl_close($ch);
	// 解析 HTML 的 <head> 区段   
	preg_match("/<head.*>(.*)<\/head>/smUi",$output3, $htmlHeaders);   
	if(!count($htmlHeaders)){   
	   echo "无法解析数据中的 <head> 区段";   
	   exit;   
	}
	// 取得 <title> 中的文字    
	if(preg_match("/<title>(.*)<\/title>/Ui",$htmlHeaders[1], $htmlTitles)){   
	   	if(!count($htmlTitles)){   
	       echo "无法解析 <title> 的内容";   
	       exit;   
	   	} 
	   $title=$htmlTitles[1];   
	   //var_dump(trim($title)); 
	   //var_dump("帐号登陆日志");  
	}
	//验证title是否正常
	//=======================================================================   
	if (strlen(trim($title)) != 12) {
		$output5 = "wrong";
	}else{
		$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://202.116.0.176/Secure/Cjgl/Cjgl_Cjcx_WdCj.aspx");
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);        
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
	$output4 = curl_exec($ch);
	//echo $output3;
	curl_close($ch);
	$html = new simple_html_dom();
	$html->load($output4);
	//========================================================
	$postone = $html->find('#__VIEWSTATE',0)->value;
	$posttwo = $html->find('#__VIEWSTATEGENERATOR',0)->value;
	$postthree = $html->find('#__EVENTVALIDATION',0)->value;
	$postname = $html->find('#txtXM',0)->value;
	$postnum = $html->find('#txtXH',0)->value;
	$postYXZY = $html->find('#txtYXZY',0)->value;
	$postLB = $html->find('#rbtnListLBXX_1',0)->value;
	//$postXXLB = $html->find('option',0)->value;
	//================================================
	$cookie_jar2 = tempnam('./tmp','JSESSIONID');
	$url = "http://202.116.0.176/Secure/Cjgl/Cjgl_Cjcx_WdCj.aspx";
	$post_data1 = array(
		"__EVENTTARGET"=>"lbtnQuery",
		"__EVENTARGUMENT"=>"",
		"__VIEWSTATE"=>$postone,
		"__VIEWSTATEGENERATOR"=>$posttwo,
		"__EVENTVALIDATION"=>$postthree,
		"txtXH"=>$postnum,
		"txtXM"=>$postname,
		"txtYXZY"=>$postYXZY,
		"rbtnListLBXX"=>$postLB,
		"ddlXXLB"=>urldecode("%D6%F7%D0%DE"),
		);
	//var_dump($post_data1);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	// post数据
	curl_setopt($ch, CURLOPT_POST, 1);
	// post的变量
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data1);
	curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_jar);
	curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar2); 
	$output5 = curl_exec($ch);
	curl_close($ch);
	$html->clear();
	}
	return $output5;
}
function json_output(){
	if (verify()) {
		$output = echopicstring();
		$html = new simple_html_dom();
		$html->load($output);
		$count_all = 0;
		$count_title = 0;
		$count_grade = 0;
		$count_grade_all = 0;
		$count_term = 0;
		$isfirst = 0;
		$flag = 0;
		$content = array();
		$coures_grade_content = array();
		$json_array = array();
		$json_array['stuname'] =  mb_convert_encoding($html->find('#txtXM',0)->value, "UTF-8", "GBK");
		foreach ($html->find('table[class=Gridview] td') as $value) {
			if (strip_tags($value) != "&nbsp;"&&strip_tags($value) != '--------'&&strip_tags($value) != '------------------------------------------------'&&strip_tags($value) != '----'&&strip_tags($value) !='---------') {
				//$content[$count_all] = iconv('UTF-8','GBK//IGNORE',trim(strip_tags($value)));
				$content[$count_all] = trim(strip_tags($value));
				if (strpos($content[$count_all],"-") == 4) {
					
					$term = mb_convert_encoding($content[$count_all], "UTF-8", "GBK");
					$json_array[$count_term]['term'] = $term;
					$count_title++;
					$count_grade = 0;
					$flag = 1;
				}

				if (strpos($content[$count_all],":") == 18&&$flag == 1) {
					$flag = 0;
					$json_array[$count_term]['course_grade'] = $coures_grade_content;
					$json_array[$count_term]['final_score'] = mb_convert_encoding($content[$count_all], "UTF-8", "GBK");
					$count_term++;
					$count_grade_all=0;
				}
				if (strpos(strip_tags($value),mb_convert_encoding("最终的平均学分绩点", "GBK","UTF-8"))>0) {
					$json_array['final_avg_score'] = mb_convert_encoding($content[$count_all], "UTF-8", "GBK");
				}
				if ($flag == 1) {
					
					switch ($count_grade) {
					case 2:
						$coures_grade_content[$count_grade_all]['course_name'] = mb_convert_encoding($content[$count_all], "UTF-8", "GBK");
						$count_grade++;
						break;
					case 3:
						$coures_grade_content[$count_grade_all]['type'] = mb_convert_encoding($content[$count_all], "UTF-8", "GBK");
						$count_grade++;
						break;
					case 4:
						$coures_grade_content[$count_grade_all]['score'] = $content[$count_all];
						$count_grade++;
						break;
					case 5:
						$coures_grade_content[$count_grade_all]['credit_num'] = $content[$count_all];
						$count_grade++;				
						break;
					default:
						$count_grade++;
						break;
					}
					if ($count_grade == 6) {
						//var_dump($coures_grade_content[$count_grade_all]);
						$count_grade =0;
						$count_grade_all++;
					}
				}
				$count_all++;
			}
		}
		$html->clear();
		//echo json_encode($json_array);
		return $json_array;
	}else{
		$msg = array(
			'msg' => 'error',
			);
		return $msg;
	}
}
function verify(){
	$key  = array(
		'admin' => 'admin', 
		'test'  => 'test_data',
		);
	if (isset($_GET['id'])&&isset($_GET['password'])&&isset($_GET['key'])) {
		foreach ($key as $value) {
			if($_GET['key'] == $value){
				return true;
			}else{
				return false;
			}
		}
	}else{
			return false;
	}
}
echo json_encode(json_output());
?>
