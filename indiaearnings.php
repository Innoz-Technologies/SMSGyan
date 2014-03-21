<?php

/* indiaearning.com
 * fallback for google stock
 */

class IndiaEarnings {

    var $url;
    var $company;
    var $company_code;
    var $search_results;
    var $stock_value;
    var $company_codes;
    var $company_names;

    function __construct() {
        echo "<br>India Earnings<br>";
        global $word;
        echo $url = "http://indiaearnings.moneycontrol.com/sub_india/compsearch_result.php?companyname=" . urlencode($word) . "&fname=price&searchtype=new";
        $indiaearnings_in = httpGet($url);
//      var_dump($indiaearnings_in);

        $this->setCompany($indiaearnings_in);
        var_dump($this->company);
        var_dump($this->company_code);
    }

    function setCompany($html) {
        $pos = stripos($html, "search results");
        if ($pos !== false) {
            //$epos = stripos($html, '<div class="CL"></div>') ? stripos($html, '<div class="CL"></div>') : strlen($html);
            $html = substr($html, $pos);
            preg_match_all('~<a href="(comp_results\.php\?sc_did=([^"]+))" [^>]+><B>([^<]+)</B>~Ui', $html, $matches);
//            print_r($matches);
            /*
             * matches array
             * 0=>matched part
             * 1=>url
             * 2=>company code
             * 3=>company name
             */

            $this->company_codes = $matches[2];
            $this->company_names = $matches[3];
//            echo "<br>Search results:\n";
//            print_r($this->company_codes);
//            print_r($this->company_names);
//            echo "\n<br>";

            $this->company_code = $matches[2][0];
            $this->company = $matches[3][0];

            echo "<br>\nCompany code: $this->company_code\n";
            echo "company name: $this->company\n<br><br>";
        }
    }

    function getStock() {
        echo $url = "http://www.moneycontrol.com/india/stockpricequote/miningminerals/" . strtolower(str_replace(" ", '', $this->company)) . "/" . $this->company_code;
        //var_dump($url);
        $response = file_get_contents($url);
//        echo $response = httpGet($url);
        //var_dump($response);
        //Stock price page
        if (preg_match('~<!-- Add to portfolio end-->(.+)<!-- MOSL messaging starts here -->~Usi', $response, $match)) {
//            var_dump($match);
            $response = $match[0];
            $out = strip_tags($response);

            $out = str_replace('LIVE', "", $out);
            $out = preg_replace("~[\s]+~", " ", $out);
            $out = str_replace('AVERAGE VOLUME', "\nAVERAGE VOLUME", $out);
            $out = str_replace('VOLUME SHOCKER', "\nVOLUME SHOCKER", $out);
            $out = str_replace('Prev.', "\nPrev.", $out);
            $out = str_replace('Open ', "\nOpen ", $out);
            $out = str_replace('Bid ', "\nBid ", $out);
            $out = str_replace('Offer ', "\nOffer ", $out);
            $out = str_replace('NSE ', "\nNSE  ", $out);
            $out = str_replace('â€™', "'", $out);
            $out = str_replace('Today', "\nToday", $out);

            echo trim($out);
            return "Stock: " . $this->company . "\n" . trim($out);
        }
//        $pos = strpos($response, 'id="content_full">');
//        if ($pos) {
//            echo "<br>\nStocks page $pos\n<br>";
//            $html = substr($response, $pos + 18);
//            $pos = strpos($html, '<dl id="slider">');
//            if ($pos) {
//                echo "<br>\nIF2\n<br>";
//                $html = substr($html, 0, $pos);
//                $pos1 = strpos($html, '<div class="tooltip2">');
//                $pos2 = strpos($html, '<div class="brdb PA5">');
//                if ($pos1 && $pos2) {
//                    echo "<br>\nIF3\n<br>";
//                    $html = substr($html, 0, $pos1) . substr($html, $pos2);
//                    $pos1 = strpos($html, '<div class="tooltip3">');
//                    $pos2 = strpos($html, '<div class="brdb PA5">', $pos1);
//                    if ($pos1 && $pos2) {
//                        echo "<br>\nIF4\n<br>";
//                        $html = substr($html, 0, $pos1) . substr($html, $pos2);
//                        $html = str_replace("\n", " ** ", $html);
//                        $html = str_replace('<div class="FR MT2 live">LIVE</div>', "", $html);
//                        $html = strip_tags($html);
//                        $html = preg_replace("~[\s]+~", " ", $html);
//                        $html = preg_replace("~ (\*\* )+~", "\n", $html);
//                        //$html = str_replace(' ** ', "\n", $html);
//                        //$html = trim(preg_replace("~[\n]+~", "\n", $html));
////                        echo "<br>_____________________________________________________________________________<br>";
////                        var_dump($html);
////                        echo "<br>_____________________________________________________________________________<br>";
//                        return "Stock: " . $this->company . "\n" . $html;
//                    }
//                }
//            }
//        }
    }

}

?>