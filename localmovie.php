<?php

/*
  function getShowTimes($html) {
  if (strpos($html, '<a href="/movies?h') === false)
  return false;
  $rating = '';
  $rating = '';

  $topstuff = strpos($html, "id=topstuff") + strlen("id=topstuff>");
  //var_dump($topstuff);
  $more_cinemas = strpos($html, "More cinemas", $topstuff);
  //var_dump($more_cinemas);

  $part = substr($html, $topstuff, $more_cinemas - $topstuff);
  $part = str_replace("&nbsp;", " ", $part);

  //var_dump($part);
  if (preg_match("~Rated (\d\.\d) out of 5\.0~", $part, $matches)) {
  $review = "Rating: " . $matches[1] . "/5\n";
  }


  //    <br>10:00am  1:00 4:00 7:00 10:00 11:35<br>

  preg_match_all("~<br>((\d\d?:\d\d([ap]m)?\s*)+)<br>~", $part, $matches);
  if (is_array($matches)) {
  foreach ($matches[1] as $m) {
  $part = str_replace($m, "Showtimes: $m", $part);
  }
  }
  $part = str_replace("<br>", "\n", $part);
  $part = str_replace("<br/>", "\n", $part);
  $part = strip_tags($part);
  $part = str_replace("Reviews:", $review, $part);

  return $part;
  }


 * Old local movie search
  echo $localmovie_in;
  echo "\n<br>localmovies<br>\n";
  //echo strlen($localmovie_in);
  $showtimes = getShowTimes($localmovie_in);
  echo $showtimes;
  $num = stripos($showtimes, "More films");
  if ($num) {
  $temp = substr($showtimes, $num);
  $showtimes = str_ireplace($temp, "", $showtimes);
  }
  $localmovie_return = $showtimes;
 *
 */

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
            $url = "http://IP/gwrapper/googlemovies_wrapper.php?near=" . urlencode($this->near) . "&q=" . urlencode($this->movie);
        } else if ($this->near) {
//            $url = "http://www.google.co.in/movies?hl=en&near=" . urlencode($this->near);
            $url = "http://IP/gwrapper/googlemovies_wrapper.php?near=" . urlencode($this->near);
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
        preg_match("~id=title_bar>Showtimes for (.+), (.+)</h1>~U", $contents, $matches);
        $this->city = $matches[1];
        while (strpos($contents, '<div class=theater>', $offset)) {
            $spos = strpos($contents, '<div class=theater>', $offset) + strlen('<div class=theater>');
            $epos = strpos($contents, '<div class=theater>', $spos);
            if (!$spos || !$epos) {
                break;
            }
            $offset = $epos + strlen('<div class=theater>');
            $part = substr($contents, $spos, $epos - $spos);
            preg_match("~<h2 class=name><a[^>]+>(.+)</a></h2>~U", $part, $theater);
            preg_match_all("~<div class=name><a[^>]+>(.+)</a></div>~U", $part, $movies);
            preg_match_all('~<span class=info>(.+)(( - )?<.+alt="Rated ([^"]+)".+)?</span>~U', $part, $info);
            preg_match_all("~<div class=times>(.+)</div>~U", $part, $timings);

            $return .= trim(strtoupper($theater[1])) . "\n";
            foreach ($movies[1] as $i => $mov) {
                $this->movie_list[] = trim($mov);
                $return .= trim($mov) . "(" . trim($info[1][$i]);
                if (strlen(trim($info[4][$i]))) {
                    $return .= " Rating:" . trim($info[4][$i]);
                }
                $return .= ")\n";
                $timings[1][$i] = html_entity_decode($timings[1][$i]);
                $timings[1][$i] = str_replace("&nbsp", "", $timings[1][$i]);
                $timings[1][$i] = strip_tags($timings[1][$i]);
                $return .= trim($timings[1][$i]) . "\n";
            }
        }
        $this->movie_list = array_unique($this->movie_list);
        return ($return);
    }

    private function parse_withMovie($contents) {
        $contents = str_replace("&nbsp;", " ", $contents);
        $offset = 0;
        $return = '';
        $spos = strpos($contents, '<div class=movie>');
        if (!$spos)
            $spos = strpos($contents, '<div class=movie_results>');
        $epos = strpos($contents, '</h2>', $spos);
        if ($spos && $epos) {
            $movie_title = strip_tags(substr($contents, $spos, $epos - $spos));
            while (strpos($contents, '<div class=theater>', $offset)) {
                $spos = strpos($contents, '<div class=theater>', $offset) + strlen('<div class=theater>');
                $epos = strpos($contents, '<div class=theater>', $spos);
                if (!$spos || !$epos) {
                    if (!$return && $spos && strpos($contents, '<p class=clear>', $spos)) {
                        $epos = strpos($contents, '<p class=clear>', $spos);
                    } else {
                        break;
                    }
                }
                $offset = $epos + strlen('<div class=theater>');
                $part = substr($contents, $spos, $epos - $spos);
                preg_match("~<div class=name><a[^>]+>(.+)</a></div>~U", $part, $theater);
                preg_match("~<div class=times>(.+)</div>~U", $part, $times);
                $return .= strtoupper($theater[1]) . "\n" . $times[1] . "\n\n";
                $return = strip_tags($return);
            }
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

if (preg_match("~(.+)(movie.?time?|show.?time?|movie.timing)s? (in|at) (.+)~", $spell_checked, $matches)) {
    echo "<br>Matched Preg1";
    $localmovie = new LocalMovie($matches[4], $matches[1]);
    $nowrun_city = $matches[4];
    $jdial_city = $matches[4];
} else if (preg_match("~(movie.?time|show.?time|movie.timing)s? (for )?(.+) (in|at) (.+)~", $spell_checked, $matches)) {
    echo "<br>Matched Preg2";
    $localmovie = new LocalMovie($matches[5], $matches[3]);
    $nowrun_city = $matches[5];
    $jdial_city = $matches[5];
} else if (preg_match("~show.?times? (for )?(.+) (in|at) (.+)~", $spell_checked, $matches)) {
    echo "<br>Matched Preg3";
    $localmovie = new LocalMovie($matches[4], $matches[2]);
    $nowrun_city = $matches[4];
    $jdial_city = $matches[4];
} else if (preg_match("~(show.?time|movie.?time|movie.?timing)s?[ ;:,-]+(.+)~", $spell_checked, $matches)) {
    echo "<br>Matched Preg4";

    $search_word = trim(remwords($matches[2]));
    $arWords = explode(" ", $search_word);
    var_dump($arWords);

    foreach ($arWords as $word) {
        echo $query = "SELECT * FROM `citylist` WHERE `city_name` LIKE '%$word%'";
        $result = mysql_query($query);

        if (mysql_num_rows($result)) {
            $row = mysql_fetch_array($result);
            $movie_name = trim(str_ireplace($row["city_name"], "", $matches[2]));
            $movie_palce = $row["city_name"];
            break;
        }
    }

//    if (empty($movie_palce)) {
//        $movie_palce = $circle_city;
//        $showcity = "Showtimes for $circle_city";
//        
//    }


    if (!empty($movie_palce)) {
        $localmovie = new LocalMovie($movie_palce, $movie_name);
        $nowrun_city = $movie_palce;
        $jdial_city = $movie_palce;
    } else {
        $localmovie = new LocalMovie($matches[2]);
        $nowrun_city = $matches[2];
        $jdial_city = $matches[2];
    }
} else {
    echo "<br>Matched No Preg";
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

        $current_file = "/movies/$numbers";
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
?>
