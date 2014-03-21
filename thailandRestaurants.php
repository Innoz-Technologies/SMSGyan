<?php
if (preg_match("~\b^(restaurant|restaurants)\b(.+)?~si", $spell_checked, $match)) {
	echo "<h4>INSIDE THAILAND RESTAURANT SEARCH</h4>";
	
	var_dump($match);
	
	if(isset($match[2]) && trim($match[2]) != "") {
		$thai_rest = searchAllThailandRestaurants(trim($match[2]));
	} else {
		$thai_rest = searchAllThailandRestaurants("");
	}
	
	if (!empty($thai_rest)) {
		$options_list = $thai_rest['options_list'];
		$list = $thai_rest['list'];
		
		if(isset($match[2]) && trim($match[2]) != "") {
			$total_return = "Restaurants in " . ucwords(trim($match[2]));
		} else {
			$total_return = "Restaurants in Thailand";
		}
		$source_machine = $machine_id;
		$current_file = "/temp/$numbers";
		file_put_contents(DATA_PATH . $current_file, $total_return);
		$to_logserver['source'] = 'thai_rest';
		include 'allmanip.php';
		putOutput($total_return);
		exit();
	}/* else {
		$total_return = "No restaurants found!";
		$to_logserver['source'] = 'thai_rest';
		$to_logserver['isresult'] = 0;
		include 'allmanip.php';
		putOutput($total_return);
		exit();
	}*/
} else if(preg_match("~__thai__rest__(.+)~si", $req, $match)) {
	echo "<h4>INSIDE THAILAND RESTAURANT SEARCH</h4>";
	echo $url = $match[1];
	
	$thai_rest = getThailandRestaurant($url);
	
	if (!empty($thai_rest)) {	
		$total_return = $thai_rest;
		$source_machine = $machine_id;
		$current_file = "/temp/$numbers";
		file_put_contents(DATA_PATH . $current_file, $total_return);
		$to_logserver['source'] = 'thai_rest';
		include 'allmanip.php';
		putOutput($total_return);
		exit();
	} else {
		$total_return = "No news found!";
		$to_logserver['source'] = 'thai_rest';
		$to_logserver['isresult'] = 0;
		include 'allmanip.php';
		putOutput($total_return);
		exit();
	}
}

function getThailandRestaurant($url) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$content = curl_exec ($ch);	
	curl_close ($ch);
	
	$result = "";
	
	if(preg_match('~<p class="thumbnail">(.+)<h2>Overview</h2>~Usi', $content, $match)){
		$result = preg_replace('~See map</a></p>(.+)<h2>Information</h2>~Usi', "***", $match[1]);
		$result = preg_replace('~</h2>(.+)<p class="detail">~Usi', "***", $result);	
		
		$result = trim(str_replace('<p class="infoDetailR">', ": ", $result));
		$result = trim(str_replace("</p>", "***", $result));
		$result = strip_tags($result);
		$result = trim(preg_replace("~[\s]+~", " ", $result));
		$result = trim(str_replace("***", "\n", $result));
		$result = trim(str_replace("\n ", "\n", $result));
		$result = htmlspecialchars_decode($result);
		$result = str_replace("&#039", "'", $result);
	}
	
	return $result;
}

function searchAllThailandRestaurants($search) {
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, "http://www.bangkokpost.com/lifestyle/restaurants/search/province/" . $search);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	$content = curl_exec ($ch);	
	curl_close ($ch);
	
	$return = array();
	
	if (preg_match('~<table summary="detail of directories" id="detailOfDirectories" cellpadding="0" cellspacing="0">(.+)</table>~Usi', $content, $match)) {
		if (preg_match_all("~<h2>(.+)</h2>~Usi", $match[1], $matches)) {
			//var_dump($matches);
			for($i = 0; $i < count($matches[1]); $i++) {
				//if (preg_match("~<h3>(.+)</h3>~Usi", $matches[1][$i], $match1)) {
					$title = trim(htmlspecialchars_decode(strip_tags($matches[1][$i])));
					$title = str_replace("&#039", "'", $title);
					//echo "<br>";
				//}
				
				if (preg_match('~<a href="(.+)" title="~Usi', $matches[1][$i], $match1)) {
					$link = trim(htmlspecialchars_decode($match1[1]));
				}
				
				$options_list[$i] = $title;
				$list[$i] = array("content" => "__thai__rest__http://www.bangkokpost.com" . $link);
			}
		}
		
		$return['options_list'] = $options_list;
		$return['list'] = $list;
	}
	
	return $return;
}
?>