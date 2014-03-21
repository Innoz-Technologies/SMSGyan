<?php
$object=new Nigerianews($spell_checked,$req);

if (!empty($object->return["news"])) {
    $total_return = $object->return["news"];
    if (!empty($object->return["options"])) {
        $options_list = array_merge($options_list, $object->return["options"]);
        $list = array_merge($list, $object->return["list"]);
    }

    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'nigerianews';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

class Nigerianews{

	function __construct($spell_checked,$req){
		if($spell_checked=="news"){
			$url="http://www.punchng.com/";
			$this->getallnews($url);
		}elseif(preg_match('~news (.+)~',$spell_checked,$matches)){
			$searched=trim($matches[1]);
			echo $url="http://www.punchng.com/?s=".urlencode($searched);
			$this->searchednews($url);
		}elseif(preg_match('~__nigerianews__(.+)__~Usi',$req,$match)){
			$url=trim($match[1]);
			$this->wholecontent($url);
		}
	}
	
	function getallnews($url){
		$content=httpGet($url);
		if(preg_match_all('~<a title="(.+)" href="(.+)/">~Usi',$content,$match)){
			if(count($match[1]>1)){
				$this->return["news"]="Your query matches more than one result";
				for($i=0;$i<count($match[1]);$i++){
					$title=trim(strip_tags($match[1][$i]));
					$link=trim(strip_tags($match[2][$i]));
					$this->return["options"][] = $title;
					$this->return["list"][] = array("content" => "__nigerianews__" . $link . "__");
				}
			}else{
				$this->return["news"]="No data found";
			}
		}else{
			$this->return["news"]="No data found";
		}
	}
	
	function searchednews($url){
		$content=httpGet($url);
		if(preg_match_all('~<h2 class="entry-title"><a href="(.+)/" title="(.+)" rel=".+">~Usi',$content,$match)){
			if(count($match[1]>1)){
				$this->return["news"]="Your query matches more than one result";
				for($i=0;$i<count($match[1]);$i++){
					$title=trim(strip_tags($match[2][$i]));
					$link=trim(strip_tags($match[1][$i]));
					$this->return["options"][] = $title;
					$this->return["list"][] = array("content" => "__nigerianews__" . $link . "__");
				}
			}else{
				$this->return["news"]="No data found";
			}
		}else{
			$this->return["news"]="No data found";
		}
	}
	
	function wholecontent($url){
		echo $url;
		$content=file_get_contents($url);
		echo "<h2>inside whole content</h2>";
		if(preg_match('~<div class="entry-content">(.+)</div>~Usi',$content,$match)){
			echo "<h2>inside preg match</h2>";
			$data=trim($match[1]);
			$data=strip_tags($data);
			$data=html_entity_decode($data);
			$this->return["news"]=$data;
		}
	}

}
?>
