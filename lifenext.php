<?php

if (preg_match('~^\b(lifenext|life next) (.+)\b~', $req, $match) && str_word_count($req) <= 5) {

    var_dump($match);
    
    $name = trim($match[2]);
    if (preg_match("~\b[\d]{4}\b~", $name, $matched)) {
        $dob = $matched[0];
        $name = preg_replace("~$dob~", "", $name);
    } else {
        $total_return = "Invalid format,SMS Lifenext <space> name <space> year of birth. Eg Lifenext ajay 1992";
        $to_logserver['source'] = 'lifenext';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }


    $year = array("1902", "1903", "1904", "1905", "1906", "1907", "1908", "1909", "1910", "1911", "1912", "1913", "1914", "1915", "1916", "1917", "1918", "1919", "1920", "1921", "1922", "1923", "1924", "1925", "1926", "1927", "1928", "1929", "1930", "1931", "1932", "1933", "1934", "1935", "1936", "1937", "1938", "1939", "1940", "1941", "1942", "1943", "1944", "1945", "1946", "1947", "1948", "1949", "1950", "1951", "1952", "1953", "1954", "1955", "1956", "1957", "1958", "1959", "1960", "1961", "1962", "1963", "1964", "1965", "1966", "1967", "1968", "1969", "1970", "1971", "1972", "1973", "1974", "1975", "1976", "1977", "1978", "1979", "1980", "1981", "1982", "1983", "1984", "1985", "1986", "1987", "1988", "1989", "1990", "1991", "1992", "1993", "1994", "1995", "1996", "1997", "1998", "1999", "2000", "2001", "2002", "2003", "2004", "2005", "2006", "2007", "2008", "2009", "2010", "2011", "2012", "2013");
    $key = array_rand($year);

    $month = array("styczen", "luty", "marzec", "kwiecien", "maj", "czerwiec", "lipiec", "sierpien", "wrzesien", "pazdziernik", "listopad", "grudzien");
    $keym = array_rand($month);

    $m = $month[$keym];

//    $dob = $year[$key];
    $getresult = getlifenext($name, $dob, $m);




    if (preg_match('~<div class="result quote">(.+)<div class="sense">~Usi', $getresult, $match)) {
        $lifenxt = $match[1];
        $lifenxt = preg_replace("~[\s]+~", " ", $lifenxt);
        $lifenxt = strip_tags($lifenxt);
        $lifenxt = html_entity_decode($lifenxt);
        echo $lifenxt;

        $total_return = $lifenxt;

        if ($total_return) {
            $add_below = adscript();
            $to_logserver['source'] = 'lifenext';
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        }
    }
}

function getlifenext($name, $dob, $m) {
    $url = "http://oracle.deathdate.info/reincarnation";
    echo $fields_string = "field-1=" . urlencode($name) . "&field-2a=18&field-2b=marzec&field-2c=$dob";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array("Host: oracle.deathdate.info", 'Referer: http://oracle.deathdate.info/reincarnation'));
    $result = curl_exec($ch);
    return $result;
}

?>
