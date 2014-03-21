<?php
class Answers {
	var $question;
	var $answer;
	
	function __construct($question) {
		$this->question = str_replace(" ","_",$question);
	}
	
	function getAnswers() {
		$out = "";
		$url = "API";
		$response = httpGet($url);
		if ($pos1 = strpos($response,'id="q_answer"')) {
			$pos1 += 14;
			if ($pos2 = strpos($response,"<!-- google_ad_section_end -->",$pos1)) {
				$answer = substr($response,$pos1,$pos2-$pos1);
				$this->answer = trim(strip_tags($answer));
			}
		} else if ( ($pos1 = strpos($response,"Is one of these your question?",0)) !== false ) {
			$pos2 = strpos($response,"No? Post your question to the community!",$pos1);
			$sub = substr($response,$pos1,$pos2-$pos1);
			preg_match_all("~<span onclick=[^<]+><img class=[^>]+>([^<]+)</span>(\s?<span [^>]+>\|</span>\s<span [^>]+>(Unanswered)</span>)?~",$sub,$matches);
			$i = 1;
			foreach($matches[1] as $key=>$match) {
				if ($matches[3][$key] == "") {
					$sender = $_GET['number'];
					$page = mysql_real_escape_string($match);
					$query = "INSERT INTO lists (sender,number,page,type) VALUES ('$sender',$i,'$page','wikianswers')";
					mysql_query($query) or die(mysql_error()." in $query");
					$out .= "$i. $match\n";
					$i++;
				}
			}
			if ($out !== "") {
				$out = "Is one of these your question? Reply GYAN OPTION (e.g GYAN 1)\n".$out;
			}
			$this->answer = trim(strip_tags($out));
		}
	}
}
?>