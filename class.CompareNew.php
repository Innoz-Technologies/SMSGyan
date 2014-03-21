<?php

class CompareStringArray {

    private $key;
    private $array = array();
    
    /**
     *
     * @var int metaphone  shortest levenshtein key value
     */
    public $meta_lev_key=0;
    
    /**
     *
     * @var string matched value
     */
    public $matched_value="";
    
    /**
     *
     * @var int metaphone  smallest percentage key value
     */
    public $meta_perc_key="";
    /**
     *
     * @var int levenshtein distance between input strings
     */
    public $levenshtein=array();

    /**
     *
     * @var array value, percentage
     */
    public $similarity = array();

    /**
     *
     * @var array levenshtein, similarity, percentage similariry
     */
    public $soundex = array();

    /**
     *
     * @var array levenshtein, similarity, percentage similariry
     */
    public $metaphone = array();

    public function __construct($key, $array) {
        $this->key = strtolower($key);
        $this->array = $array;
    }

    function compare($debug = false) {
        $serchkey = $this->key;
        $array = $this->array;

        $soundex = array();
        $metaphone = array();
        $levenshtein = array();
        $similarity = array();
        
        //checking for best match in metaphone
        $lev_value=-1;
        $perc_value=0.0;
        $cur_key_lev="";
        $cur_key_per="";
        //looping through the array to find best matching
        
        foreach ($array as $key => $value) {
            $levenshtein[$key] = levenshtein($serchkey, $value);
            $similarity[$key]['value'] = $sim = similar_text($serchkey, $value, $perc);
            $similarity[$key]['perc'] = $perc;

            if ($debug) {
                echo "KEY=>$key <br>$serchkey | $value<br>";
                echo "leven: " . $levenshtein[$key];
                echo '<br>similarity: ' . $sim . ', ' . $perc . '%<br><br>';
            }

            $soundex1 = soundex($serchkey);
            $soundex2 = soundex($value);
            $soundex[$key]['levenshtein'] = levenshtein($soundex1, $soundex2);
            $soundex[$key]['similarity'] = $sim = similar_text($soundex1, $soundex2, $perc);
            $soundex[$key]['percentage'] = $perc;

            if ($debug) {
                echo "Soundex: " . $soundex1 . ", " . $soundex2 . "<BR>";
                echo 'levenshtein: ' . $soundex[$key]['levenshtein'] . '<br>';
                echo 'similarity: ' . $sim . ', ' . $perc . '%<br><br>';
            }

            $m1 = metaphone($serchkey);
            $m2 = metaphone($value);
            $metaphone['levenshtein'][$key] = levenshtein($m1, $m2);
            $metaphone['similarity'][$key] = $sim = similar_text($m1, $m2, $perc);
            $metaphone['percentage'][$key] = $perc;
            $metaphone['value'][$key]=$value;
            
            if ($debug) {
                echo "metaphone: " . $m1 . ", " . $m2 . "<br>";
                echo 'levenshtein: ' . $metaphone[$key]['levenshtein'] . '<br>';
                echo 'similarity: ' . $sim . ', ' . $perc . '%<br>';
                echo '<br>-------------------<br>';
            }
        }
        
        $this->levenshtein=$levenshtein;
        $this->metaphone=$metaphone;
        $this->similarity=$similarity;
        $this->soundex=$soundex;
        
        asort($metaphone['levenshtein']);
        arsort($metaphone['percentage']);
        
        foreach ($array as $key => $value) {
            //echo "<br>$value Lev: $lev_value Perc: $perc_value<br>";
            if($lev_value>$metaphone['levenshtein'][$key] ||$lev_value==-1){
                $lev_value=$metaphone['levenshtein'][$key];
                $cur_key_lev=$key;
            }
            if($perc_value<$metaphone['percentage'][$key]){
                $perc_value=$metaphone['percentage'][$key];
                $cur_key_per=$key;
            }
        }
        
        $this->meta_lev_key=$cur_key_lev;
        $this->meta_perc_key=$cur_key_per;
        $this->matched_value=$this->array[$this->meta_perc_key];
        
        
    }

}

?>
