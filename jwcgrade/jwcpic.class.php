<?php
/**
* 2015.2.1 教务处验证码识别类
*/
class Jwcpic 
{
	public $datamodel = array();
	public $hexarray = array();
	public $cookie;
	function __construct()
	{
		//=================================================
		//0-9和a-z的教务处验证码二值；
		//像素点的值
		//=================================================
		$this->datamodel=array(
		"0"=>"xxxx",
		"1"=>"xxxx",
		"2"=>"111110111111000011000111000111001110011110111100111000111111",
		"3"=>"001110111111000011000111001110000111000011000011111111111110",
		"4"=>"000110001110001110011110011110110110110110111111000110000110",
		"5"=>"111111111000111000111110111111000011000011000011111111111110111110111000",
		"6"=>"011111011111110000110000111110111111110011110011111111011110",
		"7"=>"111111000111000111001110001110011100011100011100011100011000",
		"8"=>"111111111111110011111111011111111111110011110011110011011110",
		"9"=>"011110111111110011110011111111011111000011000011111111111110",
		"a"=>"111111110111011111111111110111110111111111",
		"A"=>"000111000000111100001111100001111100011101110011101110011101110111111111111000111111000111",
		"b"=>"110000110000110000111110111111110011110011110011111111111110",
		"B"=>"1111111110011111000111100111111111111001111100011110001111001111111110",
		"c"=>"011111111111110000110000110000111111011111",
		"C"=>"00111110011101111110000011000000110000001100000011000000111000001111011101111110",
		"d"=>"000011000011000011011111111111111111110011110011111111011111",
		"D"=>"1111110110011111001111100011110001111000111100011110011111001111111110",
		"e"=>"011110111111110011111111110000111111111111",
		"E"=>"111111110000110000110000111111110000110000110000110000111111",
		"f"=>"0111101110011001111001100011000110001100011000110000100",
		"F"=>"111111110000110000110000110000111110110000110000110000110000",
		"g"=>"011111111111110011110011110011111111011111000011110111111111111111",
		"G"=>"00111110011101111110000011000000110000001100111111100011111000110111011100111111",
		"h"=>"110000110000110000111001111111111011110011110011110011110011",
		"H"=>"1100011110001111000111100011111111111000111100011110001111000111100011",
		"I"=>"1111111111111111111111",
		"j"=>"xxxx",
		"J"=>"xxxx",
		"k"=>"11000001100000110000011011101111100111100011111001111100110111011001110000001",
		"K"=>"11000111110011101101110011111000111111001111110011101100110011101100111011000111",
		"l"=>"xxxx",
		"L"=>"110000110000110000110000110000110000110000110000110000111111",
		"m"=>"1111111111111111111111001100111100110011110011001111001100111100110011",
		"M"=>"111000111111101111111101111111101111111101111111111111111111111110111011110111011110111011100000000",
		"n"=>"111111111111110011110011110011110011110011",
		"N"=>"1110011111001111110111111011111111111111111101111110011111001111100011",
		"o"=>"xxxx",
		"O"=>"xxxx",
		"p"=>"111110111111110011110011110011111111111110110000110000110000",
		"P"=>"111111011001111100011110001111001111111111110000111000011100001110000100000010000001",
		"q"=>"011111111111110011110011110011111111011111000011000011000011",
		"Q"=>"0111111011111110111001111100001111000011110000111110001111101111111111111111111100000011",
		"r"=>"1111111111001100110011001100",
		"R"=>"11111110110011101100011011000110110011101111110011011100110011101100011111000111",
		"s"=>"111111111111111111111111001111111111111111",
		"S"=>"0111111111011111100001111000111111001111110001111000011111101111111110",
		"t"=>"0110011011110110011001100110011001110011",
		"T"=>"11111110011000001100000110000011000001100000110000011000001100000110000011000",
		"u"=>"110011110011110011110011110011111111111111",
		"U"=>"1100011110001111000111100011110001111000111100011110001111101110111110",
		"v"=>"11100000011101110111011100111110001111100001111000011100",
		"V"=>"110000111111000111111000111011101110011101110011101110001111100001111100001111100000111000",
		"x"=>"11100111011111100011110000111100001111100111111011100111",
		"X"=>"111000111011101110011111110001111110000111100000111000001111100011111110011101110111000111",
		"y"=>"1100000111011111101110111110011111001111100011110001110001111001111000",
		"Y"=>"xxxx",
		"z"=>"11111001110011101110111001110011111",
		"Z"=>"1111111000011100001110001110001110000111000111000111100011100001111111",
		);

		$this->hexarray[0]="00"; $this->hexarray[1]="01"; $this->hexarray[2]="02";
		$this->hexarray[3]="03"; $this->hexarray[4]="04"; $this->hexarray[5]="05";
		$this->hexarray[6]="06"; $this->hexarray[7]="07"; $this->hexarray[8]="08";
		$this->hexarray[9]="09"; $this->hexarray[10]="0A"; $this->hexarray[11]="0B"; 
		$this->hexarray[12]="0C"; $this->hexarray[13]="0D"; $this->hexarray[14]="0E";
		$this->hexarray[15]="0F"; $this->hexarray[16]="10"; $this->hexarray[17]="11";
		$this->hexarray[18]="12"; $this->hexarray[19]="13"; $this->hexarray[20]="14";
		$this->hexarray[21]="15"; $this->hexarray[22]="16"; $this->hexarray[23]="17";
		$this->hexarray[24]="18"; $this->hexarray[25]="19"; $this->hexarray[26]="1A";
		$this->hexarray[27]="1B"; $this->hexarray[28]="1C"; $this->hexarray[29]="1D";
		$this->hexarray[30]="1E"; $this->hexarray[31]="1F"; $this->hexarray[32]="20";
		$this->hexarray[33]="21"; $this->hexarray[34]="22"; $this->hexarray[35]="23";
		$this->hexarray[36]="24"; $this->hexarray[37]="25"; $this->hexarray[38]="26";
		$this->hexarray[39]="27"; $this->hexarray[40]="28"; $this->hexarray[41]="29"; 
		$this->hexarray[42]="2A"; $this->hexarray[43]="2B"; $this->hexarray[44]="2C";
		$this->hexarray[45]="2D"; $this->hexarray[46]="2E"; $this->hexarray[47]="2F";
		$this->hexarray[48]="30"; $this->hexarray[49]="31"; $this->hexarray[50]="32";
		$this->hexarray[51]="33"; $this->hexarray[52]="34"; $this->hexarray[53]="35";
		$this->hexarray[54]="36"; $this->hexarray[55]="37"; $this->hexarray[56]="38";
		$this->hexarray[57]="39"; $this->hexarray[58]="3A"; $this->hexarray[59]="3B";
		$this->hexarray[60]="3C"; $this->hexarray[61]="3D"; $this->hexarray[62]="3E";
		$this->hexarray[63]="3F"; $this->hexarray[64]="40"; $this->hexarray[65]="41";
		$this->hexarray[66]="42"; $this->hexarray[67]="43"; $this->hexarray[68]="44";
		$this->hexarray[69]="45"; $this->hexarray[70]="46"; $this->hexarray[71]="47";
		$this->hexarray[72]="48"; $this->hexarray[73]="49"; $this->hexarray[74]="4A";
		$this->hexarray[75]="4B"; $this->hexarray[76]="4C"; $this->hexarray[77]="4D";
		$this->hexarray[78]="4E"; $this->hexarray[79]="4F"; $this->hexarray[80]="50";
		$this->hexarray[81]="51"; $this->hexarray[82]="52"; $this->hexarray[83]="53";
		$this->hexarray[84]="54"; $this->hexarray[85]="55"; $this->hexarray[86]="56";
		$this->hexarray[87]="57"; $this->hexarray[88]="58"; $this->hexarray[89]="59";
		$this->hexarray[90]="5A"; $this->hexarray[91]="5B"; $this->hexarray[92]="5C";
		$this->hexarray[93]="5D"; $this->hexarray[94]="5E"; $this->hexarray[95]="6F";
		$this->hexarray[96]="60"; $this->hexarray[97]="61"; $this->hexarray[98]="62";
		$this->hexarray[99]="63"; $this->hexarray[100]="64"; $this->hexarray[101]="65";
		$this->hexarray[102]="66"; $this->hexarray[103]="67"; $this->hexarray[104]="68";
		$this->hexarray[105]="69"; $this->hexarray[106]="6A"; $this->hexarray[107]="6B";
		$this->hexarray[108]="6C"; $this->hexarray[109]="6D"; $this->hexarray[110]="6E";
		$this->hexarray[111]="6F"; $this->hexarray[112]="70"; $this->hexarray[113]="71";
		$this->hexarray[114]="72"; $this->hexarray[115]="73"; $this->hexarray[116]="74";
		$this->hexarray[117]="75"; $this->hexarray[118]="76"; $this->hexarray[119]="77";
		$this->hexarray[120]="78"; $this->hexarray[121]="79"; $this->hexarray[122]="7A";
		$this->hexarray[123]="7B"; $this->hexarray[124]="7C"; $this->hexarray[125]="7D";
		$this->hexarray[126]="7E"; $this->hexarray[127]="7F"; $this->hexarray[128]="80";
		$this->hexarray[129]="81"; $this->hexarray[130]="82"; $this->hexarray[131]="83";
		$this->hexarray[132]="84"; $this->hexarray[133]="85"; $this->hexarray[134]="86";
		$this->hexarray[135]="87"; $this->hexarray[136]="88"; $this->hexarray[137]="89";
		$this->hexarray[138]="8A"; $this->hexarray[139]="8B"; $this->hexarray[140]="8C";
		$this->hexarray[141]="8D"; $this->hexarray[142]="8E"; $this->hexarray[143]="8F";
		$this->hexarray[144]="90"; $this->hexarray[145]="91"; $this->hexarray[146]="92"; 
		$this->hexarray[147]="93"; $this->hexarray[148]="94"; $this->hexarray[149]="95";
		$this->hexarray[150]="96"; $this->hexarray[151]="97"; $this->hexarray[152]="98";
		$this->hexarray[153]="99"; $this->hexarray[154]="9A"; $this->hexarray[155]="9B";
		$this->hexarray[156]="9C"; $this->hexarray[157]="9D"; $this->hexarray[158]="9E";
		$this->hexarray[159]="9F"; $this->hexarray[160]="A0"; $this->hexarray[161]="A1";
		$this->hexarray[162]="A2"; $this->hexarray[163]="A3"; $this->hexarray[164]="A4";
		$this->hexarray[165]="A5"; $this->hexarray[166]="A6"; $this->hexarray[167]="A7";
		$this->hexarray[168]="A8"; $this->hexarray[169]="A9"; $this->hexarray[170]="AA";
		$this->hexarray[171]="AB"; $this->hexarray[172]="AC"; $this->hexarray[173]="AD";
		$this->hexarray[174]="AE"; $this->hexarray[175]="AF"; $this->hexarray[176]="B0";
		$this->hexarray[177]="B1"; $this->hexarray[178]="B2"; $this->hexarray[179]="B3";
		$this->hexarray[180]="B4"; $this->hexarray[181]="B5"; $this->hexarray[182]="B6";
		$this->hexarray[183]="B7"; $this->hexarray[184]="B8"; $this->hexarray[185]="B9";
		$this->hexarray[186]="BA"; $this->hexarray[187]="BB"; $this->hexarray[188]="BC";
		$this->hexarray[189]="BD"; $this->hexarray[190]="BE"; $this->hexarray[191]="BF";
		$this->hexarray[192]="C0"; $this->hexarray[193]="C1"; $this->hexarray[194]="C2";
		$this->hexarray[195]="C3"; $this->hexarray[196]="C4"; $this->hexarray[197]="C5";
		$this->hexarray[198]="C6"; $this->hexarray[199]="C7"; $this->hexarray[200]="C8";
		$this->hexarray[201]="C9"; $this->hexarray[202]="CA"; $this->hexarray[203]="CB";
		$this->hexarray[204]="CC"; $this->hexarray[205]="CD"; $this->hexarray[206]="CE";
		$this->hexarray[207]="CF"; $this->hexarray[208]="D0"; $this->hexarray[209]="D1";
		$this->hexarray[210]="D2"; $this->hexarray[211]="D3"; $this->hexarray[212]="D4";
		$this->hexarray[213]="D5"; $this->hexarray[214]="D6"; $this->hexarray[215]="D7";
		$this->hexarray[216]="D8"; $this->hexarray[217]="D9"; $this->hexarray[218]="DA";
		$this->hexarray[219]="DB"; $this->hexarray[220]="DC"; $this->hexarray[221]="DD";
		$this->hexarray[222]="DE"; $this->hexarray[223]="DF"; $this->hexarray[224]="E0";
		$this->hexarray[225]="E1"; $this->hexarray[226]="E2"; $this->hexarray[227]="E3";
		$this->hexarray[228]="E4"; $this->hexarray[229]="E5"; $this->hexarray[230]="E6";
		$this->hexarray[231]="E7"; $this->hexarray[232]="E8"; $this->hexarray[233]="E9";
		$this->hexarray[234]="EA"; $this->hexarray[235]="EB"; $this->hexarray[236]="EC";
		$this->hexarray[237]="ED"; $this->hexarray[238]="EE"; $this->hexarray[239]="EF";
		$this->hexarray[240]="F0"; $this->hexarray[241]="F1"; $this->hexarray[242]="F2";
		$this->hexarray[243]="F3"; $this->hexarray[244]="F4"; $this->hexarray[245]="F5";
		$this->hexarray[246]="F6"; $this->hexarray[247]="F7"; $this->hexarray[248]="F8";
		$this->hexarray[249]="F9"; $this->hexarray[250]="FA"; $this->hexarray[251]="FB";
		$this->hexarray[252]="FC"; $this->hexarray[253]="FD"; $this->hexarray[254]="FE"; 
		$this->hexarray[255]="FF";
	}
	//输出图像数据,图像二值化
	public function imagepgm($image, $filename = null)
	{ 
	//
	$numpic = array();
	$count_head=0;
	$divide_head=array();
	$count_end=0;
	$divide_end=array();
	$temp="";

	$ymax=imagesy($image);
	$xmax=imagesx($image);
	for($x = 0; $x < imagesx($image); $x++)
	{
		$ystring="";
		for($y = 0; $y < imagesy($image); $y++)
		{
			$colors_reg = imagecolorsforindex($image, imagecolorat($image, $x, $y));
			$color = $this->hexarray[ $colors_reg['red'] ].$this->hexarray[ $colors_reg['green'] ].$this->hexarray[ $colors_reg['blue'] ];
			
			if ($color == "D3D3D3") {
				//echo "0";
				$numpic[$x][$y]=0;
				$ystring.=0;
			}elseif ($color == "696969") {
				//echo "R";
				if ($y-1 > 0&&$numpic[$x][$y-1]==1) {
					$numpic[$x][$y]=1;
					$ystring.=1;
				}else{
					$numpic[$x][$y]=0;
					$ystring.=0;
				}
			}else{
				//echo "X";
				$numpic[$x][$y]=1;
				$ystring.=1;
			}
		}
		if ($ystring!="00000000000000000000"&&$temp=="00000000000000000000") {
			$divide_head[$count_head]=$x;
			$count_head++;
		}
		if ($ystring=="00000000000000000000"&&$temp!="00000000000000000000"&&$x!=0) {
			$divide_end[$count_end]=$x;
			$count_end++;
		}
		$temp=$ystring;
	}
	// var_dump($divide_head);
	// var_dump($divide_end);
	$restring="";
	$result=array();
	if ($count_head==4&&$count_end==4) {
		for ($i=0; $i <4 ; $i++) {
			$xverify = "";
				for ($j=0; $j < $divide_end[$i]-$divide_head[$i]; $j++) { 
				 	$xverify.="0";
				 }
				for($y = 0; $y < imagesy($image); $y++)
				{
					$xstring="";
					for($x = $divide_head[$i]; $x < $divide_end[$i]; $x++)
					{
						$xstring.=$numpic[$x][$y];
						//echo $numpic[$x][$y];
					}
					if ($xstring != $xverify) {
						$restring.= $xstring;
					}
					//echo "<br >";
				}
				$restring.= "|";
				//echo "=================================================<br>";
			}
		}else{
		//echo "wrong";
		$result = "wrong";
		}
		$result = explode("|", $restring);
		//var_dump($result);
		return $result;



	}

	//=====================================
	//抓取图像和cookie
	//====================================
	public function GrabImage($url) {
	   if($url==""):return false;endif;
	   //====================
	   //curl 存cookie
	   $cookie_jar = tempnam('./tmp','JSESSIONID'); 
		$ch = curl_init($url);
		 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回  
		curl_setopt($ch, CURLOPT_BINARYTRANSFER, true) ; // 在启用 CURLOPT_RETURNTRANSFER 时候将获取数据返回 
		curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar); 
		$output = curl_exec($ch);
		$this->cookie = $cookie_jar;
		$im=imagecreatefromstring($output);
		curl_close($ch);

	   return $im;
	}
	//==============================
	//对比图像二值，识别相似验证码字符串
	//==============================
	public function pic_to_string(){
		$img=$this->GrabImage("http://202.116.0.176/ValidateCode.aspx");
		$final=array();
		$result = $this->imagepgm($img);
		$tem=80;
		$key1="";
		$string = "";
		if ($result[0]!="") {

			for ($t=0; $t < 4; $t++) { 
			foreach ($this->datamodel as $key => $value) {
				
			similar_text($result[$t],$value,$sim);
			
			if ($sim>80) {
				if ($sim>$tem) {
					$key1 = $key;
					$tem=$sim;
				}
				
			}
			
			}
			$string .= $key1; 
			$tem=80;
			$key1="";
		}
		}
		$final=array(
				"cookie"=>$this->cookie,
				"string"=>$string,
			);
		return $final;
		
	}
}
?>
