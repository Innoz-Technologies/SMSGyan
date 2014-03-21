<?php
	if ($spell_checked == "tv") {
		$total_return = "TV SCHEDULE MENU:";
		$options_list[] = "Gemini";
		$list[] = array("content" => "tv Gemini");
		$options_list[] = "Gemini Movie";
		$list[] = array("content" => "tv Gemini Movie");
		$options_list[] = "ETV";
		$list[] = array("content" => "tv ETV");
		$options_list[] = "MAA TV";
		$list[] = array("content" => "tv MAA TV");
		/*$options_list[] = "ZEE Telugu";
		$list[] = array("content" => "tv ZEE Telugu");*/
		/*$options_list[] = "Maa Music";
		$list[] = array("content" => "tv Maa Music");*/
		$options_list[] = "ETV2";
		$list[] = array("content" => "tv ETV2");
		/*$options_list[] = "Gemini Music";
		$list[] = array("content" => "tv Gemini Music");*/
		
		if ($total_return) {
			$add_below = "\n--\nYou can also get program schedule for next 6 days, Eg: TV Gemini ON 8th June ";
			$free = true;
			include 'allmanip.php';
			$to_logserver['source'] = 'tv';
			putOutput($total_return);
			exit();
		}
	}
?>