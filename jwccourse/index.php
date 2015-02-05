<?php
//======================================
//		2014.2.4
//		暨大教务处查询课表
//		ver 1.0
//======================================
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
			//如果验证码失败则递归
			$result = echopicstring();
		}
	//如果访问失败则递归
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
	//=================================================================
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
	   
	}   
	if (strlen(trim($title)) != 12) {
		$output3 = "wrong";
	}
	//=======================================================================
	return $output3;
}
function json_result(){
	if (verify()) {
		$final_json_array=array();
		$output = echopicstring();
		//===========================================================
		$html = new simple_html_dom();
		$html->load($output);
		//===========================================================
		$stuname = strip_tags($html->find('#lblUserName',0));
		$final_json_array['stuname'] = iconv('gbk','utf-8',$stuname);
		//===========================================================
		$content=array();
		$k = 0;
		$i = 0;
		foreach($html->find('tr[class=DGItemStyle] td') as $post)
		{
			if ($k == 12) {
				$k = 0;
				$final_json_array[$i] = $content;
				$i++;
			}
			switch ($k) {
				case 2:
					$content['course_name'] = iconv('gbk','utf-8',strip_tags($post));
					break;
				case 5:
					$content['course_group'] = iconv('gbk','utf-8',strip_tags($post));
					break;
				case 6:
					$content['course_time'] = iconv('gbk','utf-8',strip_tags($post));
					break;
				case 7:
					$content['teacher'] = iconv('gbk','utf-8',strip_tags($post));
					break;
				case 8:
					$content['place'] = iconv('gbk','utf-8',strip_tags($post));
					break;
				default:
					break;
			}
				
				$k++;
				
		}

		$k = 0;
		foreach($html->find('tr[class=DGAlternatingItemStyle] td') as $post)
		{
			if ($k == 12) {
				$k = 0;
				$final_json_array[$i] = $content;
				$i++;
			}
			switch ($k) {
				case 2:
					$content['course_name'] = iconv('gbk','utf-8',strip_tags($post));
					break;
				case 5:
					$content['course_group'] = iconv('gbk','utf-8',strip_tags($post));
					break;
				case 6:
					$content['course_time'] = iconv('gbk','utf-8',strip_tags($post));
					break;
				case 7:
					$content['teacher'] = iconv('gbk','utf-8',strip_tags($post));
					break;
				case 8:
					$content['place'] = iconv('gbk','utf-8',strip_tags($post));
					break;
				default:
					break;
			}
				
				$k++;
				
		}
		//====================================================================
		$html->clear();
		//====================================================================
		
	}else{
		$final_json_array = array(
				'msg' => 'Error',
			);
	}
	return $final_json_array;

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
echo json_encode(json_result());
?>