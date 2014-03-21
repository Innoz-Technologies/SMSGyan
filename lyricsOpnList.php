<?php

echo "<h3>Hello Tune</h3>";
include 'helloTune.php';

if ($operator == "dialog") {
	include 'ask_song_sl.php';
}

echo "<h3>Lyrics Option list $req</h3>";
$lyrics_id = 0;
$movie_name = "";
$lyricsWord = preg_replace("~[\W\s]~Usi", " ", $spell_checked);
echo $lyricsWord = preg_replace("~[\s]+~", " ", $lyricsWord);

if (preg_match("~__lyrics__(.+)__(.+)__~Usi", $req, $matches)) {

    $lyrics_id = $matches[1];
    $lyricsWord = $req = $spell_checked = "lyrics " . $matches[2];
}

//echo "<h3>mDhil Tech</h3>";
//include 'mDhil.php';

include 'songDetails.php';

if (strpos($spell_checked, "how") !== false && (strpos($spell_checked, "hot") !== false || strpos($spell_checked, "cold") !== false)) {
    echo "search for city";
    echo "<h4>CITY SEARCH</h4>";
    require_once 'binary_search.php';
    $tree = new BinarySearch('msi_cities', 'city', 2);
    $btime = microtime(true);
    echo $city_name = $tree->search($spell_checked, 2);

    if (!empty($city_name)) {
        $weather_word = "weather $city_name";
    }
} else {
    if ($current_folder == "test") {
        $movieFetch = false;
        $movie_index = 0;
        if (preg_match("~__moviereview2__(.+)__(.+)__~Usi", $req, $matches)) {
            $movieFetch = TRUE;
            $movieCheck = trim($matches[1]);
            $movie_index = trim($matches[2]);
        } elseif (!preg_match("~\b(define|trace|how|when|what|which|why|route|direction|movie|song|poem|weather|review|news|stock|flames?|love|job|show ?times?|gc|tc|lyrics|epl|expand|pnr|dict|photos?|party|city)\b~i", $req)) {
            $movieFetch = TRUE;
            $movieCheck = trim($spell_checked);
        }

        if ($movieFetch) {
//            include 'checkMovie.php';
        }
    }
}
?>
