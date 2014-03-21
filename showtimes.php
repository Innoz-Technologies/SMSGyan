<?php

class LocalMovie {

    var $near = false;
    var $movie = false;
    var $time = false;
    var $return = false;
    var $city = false;
    var $movie_list = array();

    function __construct($city, $movie = null) {
//        $search = $word;
//        if (preg_match("~([\w\s]+) (at|in) ([\w\s]+)~", $word, $matches)) {
//            $this->movie = $matches[1];
//            $this->near = $matches[3];
//        } else {
//            $this->near = $word;
//        }
        $this->near = $city;
        $this->movie = $movie;
        if ($this->near && $this->movie) {
//            $url = "http://www.google.co.in/movies?hl=en&near=" . urlencode($this->near) . "&q=" . urlencode($this->movie);
            //Parser
        } else if ($this->near) {
//            $url = "http://www.google.co.in/movies?hl=en&near=" . urlencode($this->near);
            //Parser
        }
        echo $url;
        $localmovie_in = httpGet($url);
        if ($this->movie) {
            $this->return = $this->parse_withMovie($localmovie_in);
        } else {
            $this->return = $this->parse($localmovie_in);
        }
    }

    private function parse($contents) {
//        echo $contents;
        $contents = str_replace("&nbsp;", " ", $contents);
        $offset = 0;
        $return = '';
        if (preg_match("~id=title_bar>Showtimes for (.+), (.+)</h1>~U", $contents, $matches)) {
            $this->city = $matches[1];
        }
        if (preg_match_all("~<div class=name><a href=.+>(.+)<span class=info>(.+)</span>(.+)‎</span></div></div>~Usi", $contents, $matchesarray)) {
//    var_dump($matchesarray);
            $out = "";
            foreach ($matchesarray[1] as $id => $value) {
                $out .= $this->striptag($value) . " (" . $this->striptag($matchesarray[2][$id]) . ")\n" . $this->striptag($matchesarray[3][$id]) . "\n";
                $this->movie_list[] = $this->striptag($value);
            }
            $return = $out;
        }
       
        $this->movie_list = array_unique($this->movie_list);
        return ($return);
    }

    function striptag($value) {

        $value = html_entity_decode($value);
        $value = str_replace("&nbsp", "", $value);
        $value = str_replace("â€Ž", "", $value);
        $value = strip_tags($value);
        $value = trim($value);
        return $value;
    }

    private function parse_withMovie($contents) {
        $contents = str_replace("&nbsp;", " ", $contents);
        $offset = 0;
        $return = '';
        $spos = strpos($contents, '<div class=movie>');

        if (preg_match("~<div class=movie_results>(.+)</h2>~U", $contents, $matches)) {
            $movie_title = $this->striptag($matches[1]);
        }
        if (preg_match_all("~<div class=name>(.+)</a></div>(.+)</a></div>(.+)</span></div></div>~Usi", $contents, $matchesarray)) {
//    var_dump($matchesarray);
            $out = "";
            foreach ($matchesarray[1] as $id => $value) {
                $out .= $this->striptag($value) . " (" . $this->striptag($matchesarray[2][$id]) . ")\n" . $this->striptag($matchesarray[3][$id]) . "\n";
            }
            $return = $out;
        }
        if ($return) {
            return "Showtimes for $movie_title\n" . $return;
        } else {
            return '';
        }
    }

}

$localmovie = false;
$showcity = '';

if ($operator == 'du') {
    echo"<br>SHOWTIME DU<br>";
    include 'showtimes_du.php';
    echo "<br><h2>TIME after SHOWTIME DU :" . (microtime(TRUE) - $time_start) . "</h2><br>";
} else {

    if (($spell_checked == "showtimes" || $spell_checked == "showtime") && $operator == "airtel") { //for location API
        $showdata = getLocAPI($number);
        var_dump($showdata);
        if (!empty($showdata["city"])) {
            echo $spell_checked = "showtimes " . trim($showdata["city"]);
        }
    } // modified on 18/01/2013

    $show_req = preg_replace("~\b((movie|show|time|timing|showtime|showtiming)s?)\b~", '', $spell_checked);
    $show_req = trim(preg_replace("~[\s]+~", " ", $show_req));
    if (preg_match("~(.*) (in|at|near) (.+)~", $spell_checked, $matches)) {
        echo "<br>Matched Preg1";
        $localmovie = new LocalMovie($matches[3], $matches[1]);
        $nowrun_city = $matches[3];
        $jdial_city = $matches[3];
    } else {
        require_once 'binary_search.php';
        echo "<br>Matched Preg2";
        $tree = new BinarySearch('citylist', 'city_name', 3);
        $btime = microtime(true);
        $city = $tree->search($show_req, 2);
        echo "<br> btime " . (microtime(true) - $btime);
        if ($city) {
            $mvi = str_replace($city, '', $show_req);
            $localmovie = new LocalMovie($city, $mvi);
            $nowrun_city = $city;
            $jdial_city = $city;
        } else {
            $localmovie = new LocalMovie($show_req);
            $nowrun_city = $show_req;
            $jdial_city = $show_req;
        }
    }
//var_dump($localmovie);



    if ($localmovie) {
        var_dump($localmovie->near);
        var_dump($localmovie->movie);
//create movie list for city
        if (count($localmovie->movie_list)) {
            $localmovie_list = array("city" => $localmovie->city, "movies" => $localmovie->movie_list);
            file_put_contents(DATA_PATH . "/localmovie/$numbers", serialize($localmovie_list));
//        $options_list = array();
//        $list = array();
            $options_list[] = strtoupper("ALL MOVIES AT " . strtoupper($localmovie->city));
            $list[] = array("content" => "localmovie_list");
        }
//write output
        $localmovie_return = trim($localmovie->return);
        $localmovie_return = strip_tags($localmovie_return);
        $localmovie_return = html_entity_decode($localmovie_return);
        $localmovie_return = htmlspecialchars_decode($localmovie_return);
        $localmovie_return = clean($localmovie_return);
        $localmovie_return = str_replace("&nbsp", "", $localmovie_return);

        if ($localmovie_return) {

            $current_file = "/movie/$numbers";
            echo "</br>" . $localmovie_return . "</br>";
            file_put_contents(DATA_PATH . $current_file, $localmovie_return);
        }
    }


    if (empty($localmovie_return)) {
        include 'justdial_showtimes.php';
    }

    if (empty($localmovie_return)) {
        include 'nowrun.php';
    }

    if (!$localmovie_return && $showtim_must) {
        $to_logserver['isresult'] = 0;
        $localmovie_return = "Sorry, no Showtimes found for your query";
    }
}
?>
