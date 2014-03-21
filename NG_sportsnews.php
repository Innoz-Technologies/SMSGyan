<?php
$object=new sportsnews($spell_checked,$req);

if (!empty($object->return["sportsnews"])) {
    $total_return = $object->return["sportsnews"];
    if (!empty($object->return["options"])) {
        $options_list = array_merge($options_list, $object->return["options"]);
        $list = array_merge($list, $object->return["list"]);
    }

    $source_machine = $machine_id;
    $current_file = "/temp/$numbers";
    file_put_contents(DATA_PATH . $current_file, $total_return);
    $to_logserver['source'] = 'NGsports';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

class sportsnews{
	function __construct($spell_checked,$req){
		if($spell_checked=="sports"){
			echo $url="http://www.completesportsnigeria.com/news/category/breaking-news";
			$this->getallsportsnews($url);
		}elseif(preg_match('~__sportsnews__(.+)__~Usi',$req,$match)){
			$url=trim($match[1]);
			$this->getdetailssports($url);
		}
	}
	
	function getallsportsnews($url){
		$contents=file_get_contents($url);
		if(preg_match_all('~<h3><a href="(.+)">(.+)</a></h3>~Usi',$contents,$match)){
			if(count($match[1])>1){
				$this->return['sportsnews']="Your query matches more than one result";
				for($i=0;$i<count($match[1]);$i++){
					$link=trim($match[1][$i]);
					$title=trim($match[2][$i]);
					$this->return["options"][] = $title;
					$this->return["list"][] = array("content" => "__sportsnews__" . $link . "__");
				}
			}else{
				$this->return['sportsnews']="No data found";
			}
		}else{
			$this->return['sportsnews']="No data found";
		}
	}
	function getdetailssports($url){
		$content=file_get_contents($url);
		if(preg_match('~<div class="article_body">(.+)</div>~Usi',$content,$match)){
			$data=trim($match[1]);
			$data=preg_replace('~<script type="text/javascript">(.+)</script>~','',$data);
			$data=strip_tags($data);
			$this->return['sportsnews']=$data;
		}
	}
}
?>
