<?php

class CompareString {

    private $str1, $str2;
    /**
     *
     * @var int levenshtein distance between input strings
     */
    public $levenshtein;
    /**
     *
     * @var array value, percentage
     */
    public $similarity = array('value' => false, 'percentage' => false);
    /**
     *
     * @var array levenshtein, similarity, percentage similariry
     */
    public $soundex = array('levenshtein' => false, 'similarity' => false, 'percentage' => false);
    /**
     *
     * @var array levenshtein, similarity, percentage similariry
     */
    public $metaphone = array('levenshtein' => false, 'similarity' => false, 'percentage' => false);

    public function __construct($first, $second) {
        $this->str1 = strtolower($first);
        $this->str2 = strtolower($second);
    }

    function compare($debug = false) {
        $first = $this->str1;
        $second = $this->str2;

        $this->levenshtein = levenshtein($first, $second);
        $this->similarity['value'] = $sim = similar_text($first, $second, $perc);
        $this->similarity['percentage'] = $perc;

        if ($debug) {
            echo "$first | $second<br>";
            echo "leven: " . $this->levenshtein;
            echo '<br>similarity: ' . $sim . ', ' . $perc . '%<br><br>';
        }

        $soundex1 = soundex($first);
        $soundex2 = soundex($second);
        $this->soundex['levenshtein'] = levenshtein($soundex1, $soundex2);
        $this->soundex['similarity'] = $sim = similar_text($soundex1, $soundex2, $perc);
        $this->soundex['percentage'] = $perc;

        if ($debug) {
            echo "Soundex: " . $soundex1 . ", " . $soundex2 . "<BR>";
            echo 'levenshtein: ' . $this->soundex['levenshtein'] . '<br>';
            echo 'similarity: ' . $sim . ', ' . $perc . '%<br><br>';
        }

        $m1 = metaphone($first);
        $m2 = metaphone($second);
        $this->metaphone['levenshtein'] = levenshtein($m1, $m2);
        $this->metaphone['similarity'] = $sim = similar_text($m1, $m2, $perc);
        $this->metaphone['percentage'] = $perc;

        if ($debug) {
            echo "metaphone: " . $m1 . ", " . $m2 . "<br>";
            echo 'levenshtein: ' . $this->metaphone['levenshtein'] . '<br>';
            echo 'similarity: ' . $sim . ', ' . $perc . '%<br>';
            echo '<br>-------------------<br>';
        }
        
    }

}

?>
