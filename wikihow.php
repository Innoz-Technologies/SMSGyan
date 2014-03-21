<?php

function get_content($out, $getLinks = true) {
    echo strlen($out);
    if (!$out) {
        return false;
    }
    global $disamb;

    $infobox = '';

    $out = html_entity_decode($out);


    #Replace currency symbols
    $out = str_replace("�", "JPY", $out);
    $out = str_replace("�", "EUR", $out);

    #Replace {{ndash}} with -
    $out = str_replace("{{ndash}}", "-", $out);

    //Remove <!-- ... -->
    if (strpos($out, "<!--") !== false) {
        $apos = strpos($out, "<!--");
        $bpos = strpos($out, "-->", $apos) + 3;
        $to_cut = substr($out, $apos, $bpos - $apos);
        echo "<br>cutting $to_cut<br>";
        $out = str_replace($to_cut, "", $out);
    }

    //Remove <gallery> ... </gallery>
    while (strpos($out, "<gallery>") !== false) {
        $spos = strpos($out, "<gallery>");
        $epos = strpos($out, "</gallery>", $spos);
        $gallery = substr($out, $spos, $epos + 10);
        $out = str_replace($gallery, "", $out);
    }
    //Remove <timeline> ... </timeline>
    while (strpos($out, "<timeline>") !== false) {
        $spos = strpos($out, "<timeline>");
        $epos = strpos($out, "</timeline>", $spos);
        $gallery = substr($out, $spos, $epos + 10);
        $out = str_replace($gallery, "", $out);
    }
    echo " 2: " . strlen($out);
    //$out = $ordered_info . $out;
    //$out = preg_replace("~<([A-Z][A-Z0-9]*)\b[^>]*>.*?</\1>~s","",$out);
    //Remove <br/>
    $out = preg_replace("~<br\s?/?>~i", " ", $out);
    /* preg_match_all("~<([^>]+).*>.*</\1>~",$out,$matches);
      print_r($matches);
      $out = preg_replace("~<([^>]+.*)>.*</\1>~Us","",$out); */


    # Look for {{disambig}}
    if (preg_match("~\{\{disambig[^}]*\}\}~Ui", $out, $match)) {
        $out = str_replace($match[0], "", $out);
        $disamb = true;
        if ($getLinks !== FALSE) // false only if value passed
            $getLinks = true;
    } else
        $getLinks = false;

    if ($pos = stripos($out, "== Gallery ==")) {
        $out = substr($out, 0, $pos);
    }
    echo " 3: " . strlen($out);
    $out = preg_replace("~\[\[\w{2}:.*\]\]~U", "", $out);
    $out = preg_replace("~\{\{lang\|\w{2}\|\'\'\[\[(\w+)\]\]\'\'\}\}~", "$1", $out);

//Remove __STUFF__
    preg_match_all('|__\w+__|', $out, $matches);
    foreach ($matches[0] as $match) {
        $out = str_replace($match, "", $out);
    }

//Remove [[Category:Some Category]]
    if ($pos = stripos($out, "[[Category:")) {
        //   $out = substr($out, 0, $pos);
        //}
        $out = preg_replace("~\[\[Category:[^]]+\]\]~", "", $out);
    }

//Replace [http://stuff text] with text
    while (preg_match('|\[http[^]\s]+\s?([\w\s]+)\]|', $out, $match)) {
        //print_r($match);
        $out = str_replace($match[0], $match[1], $out);
    }
    #Remove [[Image:STUFF]] [[File:STUFF]]  /*EDIT LOG: MOVED UP AFTER CASE 'bee'*/
//      File:D-amphetamine.svg|[[Dextroamphetamine|D-amphetamine]]
//      File:D-amphetamine-3D-vdW.png
//
//      <div style="float:right; text-align:center">
//      <gallery widths="100px" heights="80px" perrow="2" caption="[Chirality (chemistry)|Optical isomers]] of [[amphetamine]">
//      File:D-amphetamine.svg|[[Dextroamphetamine|D-amphetamine]]
//      File:L-amphetamine.svg|[[Levoamphetamine|L-amphetamine]]
//      File:D-amphetamine-3D-vdW.png
//      File:L-amphetamine-3D-vdW.png
//      </gallery>
//
//      </div>
//    [[File:Le Louvre - Aile Richelieu.jpg|thumb|The [[Louvre]] in [[Paris]], [[France]].]]
//    [[File:Coffee Plantation1.jpg|thumb|right|300px|Coffee plantation in India]]
//    $out = preg_replace("~\[\[File:[^[]+\]\]~U","",$out);

    while (($start = stripos($out, "[[Image:")) !== false || ($start = stripos($out, "[[File:")) !== false) {
        $ctr = 1;
        $stack_string = "[";
        for ($i = $start + 1; ($i < strlen($out) && $ctr > 0); $i++) {
            if (substr($out, $i, 2) == '[[') {
                $ctr++;
                $stack_string .= substr($out, $i, 2);
                $i++;
            } else if (substr($out, $i, 2) == ']]') {
                $ctr--;
                $stack_string .= substr($out, $i, 2);
                $i++;
            } else
                $stack_string .= substr($out, $i, 1);
        }
        $removed[] = $stack_string;
        $out = str_replace($stack_string, "", $out);
    }
    //var_dump($stack_string);
    //	print_r($removed);

    $out = preg_replace("~File:.*~", "", $out);
    //echo $out;
    # CHANGING [[LINKS]] to LINKS:link:text:
//    [[one:two|three]] to three ;found for 'Hola' [[wikt:Hola|Hola]]
    while (preg_match("|\[\[([^]]+:[^]]+)\|([^]]+)\]\]|", $out, $xx)) {
        $stuff["one:two|three"][] = $xx[0];
        $out = str_replace($xx[0], $xx[2], $out);
    }
//  [[one|two]] to LINK:one:two:
//while ( preg_match("~\[\[([^\|\]]+)\|([^\]]+)\]\]~",$out,$xx) ) { //"|\[\[([#\w\s&_)(%,\.\d\.!,'-]+)\|([#\w\s&_)(%,\.\d\.!,'-]+)\]\]|"
    while (preg_match("~\[\[([^]]+?)\|([^]]+?)\]\]~", $out, $xx)) {     //Regex from stackoverflow
        $stuff["one|two"][] = $xx[0];
        //$xx[1] = str_replace(".", "", $xx[1]);
        //$xx[2] = str_replace(".", "", $xx[2]);
        if ($getLinks)
            $out = str_replace($xx[0], "LINK:$xx[1]:$xx[2]:", $out);
        else
            $out = str_replace($xx[0], $xx[2], $out);
    }
    // change [[stuff]] to LINK::stuff:
    while (preg_match("|\[\[([^]]+)\]\]|", $out, $xx)) { //"|\[\[([#\w\s\(\)\d!\.,'-]+)\]\]|"
        $stuff["stuff"][] = $xx[0];
        $replacement["stuff"][] = "LINK::$xx[1]:";
        // $xx[1] = str_replace(".", "", $xx[1]);
        if ($getLinks)
            $out = str_replace($xx[0], "LINK::$xx[1]:", $out);
        else
            $out = str_replace($xx[0], $xx[1], $out);
    }

    #Phonetics and pronounciations
    //pronounced {{IPA-en|?br?z??r|UK}} pronounced {{IPA-sa|?kr????|}}
    // (pronounced {{IPAc-en|En-us-Mexico.ogg|'|m|?|k|s|?|k|?}};
    preg_match_all("~pronounced\s+\{\{IPA.*\}\}~Ui", $out, $match);
    foreach ($match[0] as $mat) {
        $out = str_replace($mat, "", $out);
    }


    #Transliterations
    //????? in [[Devanagari]]
    $lang = array();
    preg_match_all("~[^\x{00}-\x{80}]+ in (\[\[)?\w+(\]\])?~", $out, $match, PREG_SET_ORDER);
    foreach ($match as $m) {
        $out = str_replace($m[0], "", $out);
    }
    #Birth Date
    //{{birth date|mf=yes|1963|2|9}} //year|month|date

    while (preg_match("~\{\{birth date\|[^|]+\|([^|]+)\|([^|]+)\|([^|]+)\}\}~i", $out, $matches)) {
        //print_r($matches);
        $timestamp = strtotime("$matches[1]/$matches[2]/$matches[3]");
        $birthdate = date("F j, Y", $timestamp);

        $out = str_replace($matches[0], $birthdate, $out, $count);
    }

    #Measurement units
    /*
      {{gaps|2.589|988|km2}}
      {{gaps|2.589|988|km2}}
      {{gaps|0.404|7|ha}}
     */
    $out = preg_replace("~\{\{gaps\|([\d\.]+)\|(\d+)\|([\w\d]+)\}\}~", "$1 $2 $3", $out);

    //{{IAST|Govinda}}
    preg_match_all("~\{\{IAST\|([^}]+)\}\}~", $out, $match);
    if (is_array($match)) {
        //print_r($match);
        foreach ($match[0] as $k => $m) {
            $out = str_replace($m, $match[1][$k], $out);
        }
    }
    //''{{IAST|kr.s.n.a}}''  in [[IAST]]
    preg_match_all("~'*\{\{[^}]+\}\}'*\s+in\s+(\[\[)?\w+(\]\])?~", $out, $match, PREG_SET_ORDER);
    foreach ($match as $m) {
        $out = str_replace($m[0], "", $out);
    }

    preg_match_all("~\[\[\w+]]:?\s\{\{[^}]+}};?~", $out, $match);
    foreach ($match[0] as $m) {
        $lang[] = $match[0];
        $out = str_replace($m, "", $out);
    }
    preg_match_all("~\{\{[^}]+}}:\s\{\{[^}]+}};?~", $out, $match);
    foreach ($match[0] as $m) {
        $lang[] = $match[0];
        $out = str_replace($m, "", $out);
    }
    preg_match_all("~\[\[[^]]+\]\]:\s[^;]+;?~", $out, $match);
    foreach ($match[0] as $m) {
        $lang[] = $match[0];
        $out = str_replace($m, "", $out);
    }
    preg_match_all("~\{\{lang-\w{2}\|[^}]+}}\s*\w+(\s\w+)?~", $out, $match);
    foreach ($match[0] as $m) {
        $lang[] = $match[0];
        $out = str_replace($m, "", $out);
    }
    //var_dump($out);
    echo " 5: " . strlen($out);
    #Measurement units
    //replace {{convert|a|b|c}}
    while (preg_match('|{{convert[^{}]+}}|ms', $out, $match)) {
        $a = strpos($match[0], "|"); // pipe 1
        $b = strpos($match[0], "|", $a + 1); //pipe 2
        $c = strpos($match[0], "|", $b + 1); //pipe 3
        $val = substr($match[0], $a + 1, $b - $a - 1);
        $unit = substr($match[0], $b + 1, $c - $b - 1);
        $out = str_replace($match[0], "$val $unit", $out);
    }

    #Coordinates
    //{{coord|23.7621400|N|75.5599100|E |source:yahoomaps_region:IN |format=dms}}
    while (preg_match('/\{\{(coord|Coord)\|(\d+\.\d+)\|([EWNS])\|(\d+\.\d+)\|([EWNS])\s?\|([\w:_\s\|=]+)*\}\}/', $out, $match)) {
        $lat = round($match[2], 3);
        $long = round($match[4], 3);
        $replacement = "$lat $match[3], $long $match[5]";
        $out = str_replace($match[0], $replacement, $out);
    }
    //{{coord|11|11|44|N|76|14|09|E|display=it}}
    while (preg_match("/\{\{(coord|Coord)\|(\d+)\|(\d+)\|(\d+)\|([EWNS])\|(\d+)\|(\d+)\|(\d+)\|([EWNS])\|[\w=:_]+\}\}/", $out, $match)) {
        //print_r($match);
        $lat = round($match[2] + ($match[3] / 60) + ($match[4] / 3600), 3);
        $long = round($match[6] + ($match[7] / 60) + ($match[8] / 3600), 3);
        $out = str_replace($match[0], "$lat $match[5], $long $match[9]", $out);
    }

    #Nihongo (Japanese)
    // Japanese language: {{nihongo|'''Sony Corporation'''|???????|Soni [[Kabushiki Gaisha]]}}
    // {{nihongo|'''Nissan Motor Company, Ltd.'''|[[Japanese language|Japanese]]: ?????????|Nissan Jidosha [[Kabushiki kaisha|Kabushiki-gaisha]]}}
    // {{nihongo|'''Kabushiki gaisha''' or '''kabushiki kaisha'''|????||lit. "stock companies"}}
    // {{Nihongo|'''Seiko Holdings Corporation'''|?????????????|Seiko Horudingusu Kabushiki-gaisha}}
    // {{nihongo|'''''Makuuchi'''''|***}}
    // {{nihongo|'''''makunouchi'''''|***}}
    preg_match_all("~{{nihongo\|([^|}]+)\|[^}]+}}~Ui", $out, $nihongo, PREG_SET_ORDER);
    //print_r($nihongo);

    foreach ($nihongo as $match) {
        $replacement = $match[1];
        if (isset($match[2]))
            $replacement .= " (" . $match[2] . ")";
        $out = str_replace($match[0], $replacement, $out);
    }

    # {{stuff}}
    while (($start = strpos($out, "{{")) !== false) {
        $ctr = 1;
        $stack_string = "{";
        for ($i = $start + 1; ($i < strlen($out) && $ctr > 0); $i++) {
            if (substr($out, $i, 2) == '{{') {
                $ctr++;
                $stack_string .= substr($out, $i, 2);
                $i++;
            } else if (substr($out, $i, 2) == '}}') {
                $ctr--;
                $stack_string .= substr($out, $i, 2);
                $i++;
            } else
                $stack_string .= substr($out, $i, 1);
        }
        $removed[] = $stack_string;
        $out = str_replace($stack_string, "", $out);
    }

    //var_dump($stack_string);
    echo " 6:" . strlen($out);
    //	print_r($removed);
    $removed = array();
    while (preg_match('~{{((?!{{|}}).)*}}~ms', $out, $matches)) { //regex with look back
        $out = str_replace($matches[0], "", $out);
    }
    //echo "7: " . strlen($out);
    while (preg_match("~\{\{[^{{]*\}\}~U", $out, $matches)) {
        $out = str_replace($matches[0], "", $out);
    }

    #References
    //remove <ref text/>
    while (preg_match("|<ref[^>]+/>|Um", $out, $match)) {

        $out = str_replace($match[0], "", $out);
    }
    // <ref> stuff </ref>
    while (preg_match("|<[Rr]ef.*</ref>|Ums", $out, $match)) {

        $out = str_replace($match[0], "", $out);
    }

    $out = preg_replace("~'{2,}~", "'", $out);

    #''Quotes''
    $i = 0;
    while (preg_match("|''([^']*)''|", $out, $matches) && $i < 100) {
        //echo $matches[0] . " by " . $matches[1] . "<br>";
        //echo strip_tags(substr($out,0,1500)). "<br>";
        $out = str_replace($matches[0], $matches[1], $out);
        //$out = preg_replace("|''([^']+)''|m","$1",$out);
    }

    #HEADINGS
    //replace == stuff == with =Stuff=
    while (preg_match("|={2,4}\s?([^=]+)\s?+={2,4}|m", $out, $matches)) {
        $out = str_replace($matches[0], strtoupper($matches[1]), $out);
        //$out = preg_replace("|={1,4}\s?([^=]+)\s?={1,4}|m", "$1", $out);
    }

    $out = preg_replace("~;(\w+)\b~", "$1", $out);

    //remove <!--Citation needed>
    while (preg_match("|<!--[^>]*>|Um", $out, $matches)) {
        $out = preg_replace("|<!--[^>]*>|Um", "", $out);
    }
    echo " 8: " . strlen($out);
    //var_dump($out);
    #Cut at See Also
    if (($pos = strpos($out, "SEE ALSO"))) {
        //var_dump($pos);
        $out = substr($out, 0, $pos);
    }
    #Cut at References
    if (($pos = strpos($out, "REFERENCES"))) {
        //var_dump($pos);
        $out = substr($out, 0, $pos);
    }
    #Cut at External Links
    if (($pos = strpos($out, "EXTERNAL LINKS"))) {
        //var_dump($pos);
        $out = substr($out, 0, $pos);
    }
    unset($match);
    echo " 8.5: " . strlen($out);
    //change [[stuff]] to ""
    while (preg_match("|\[\[[^[]+\]\]|", $out, $xx)) {
        $stuff["allstuff"][] = $xx;
        $out = str_replace($xx[0], "", $out);
    }
    //	var_dump($out);
    echo " 9: " . strlen($out);
    //print_r($stuff);
    //remove [[foo:bar]]
    while (preg_match("|\[\[[^[]+\]\]|m", $out, $matches)) {
        $stuff["foo:bar"][] = $xx;
        $out = preg_replace("|\[\[[^[]]+\]\]|m", "", $output);
    }

    //Remove starting :For the other stuff see stuff
    if (substr(ltrim($out), 0, 1) == ':') {
        $epos = strpos($out, "\n");
        echo substr($out, 0, $epos);
        $out = substr($out, $epos + 1);
    }
    $out = trim($out);
    if (substr($out, 0, 1) == ":") {
        $epos = strpos($out, "\n");
        $to_cut = substr($out, 0, $epos);
        echo "<br>cutting: $to_cut<br>";
        $out = str_replace($to_cut, "", $out);
    }
//    while (preg_match("~^:.*\n~", $out, $match)) {
//        print_r($match);
//        $out = str_replace($match[0], "", $out);
//    }
    //Removing coords at the start
    $sub = substr($out, 0, 20);
    if (preg_match("~\d+\.\d+\s?[NEWS],?\s?\d+\.\d+\s?[NEWS]~", $sub, $coords)) {
        //print_r($coords); die();
        $out = str_replace($coords[0], "", $out);
    }
    //echo var_dump($out);
    #Final clean ups
    $out = preg_replace("~\(\s*IAST:[^)]+\)~Ui", "", $out);
    //Image:Cacostomus squamosus sjh.jpg|Cacostomus squamosus
    //	$out = preg_replace("~Image:[^|]+\|\w+~Ui","",$out);
    //remove ( )
    while (preg_match("|\(\s*\)|", $out)) {
        $out = preg_replace("|\(\s*\)|", "", $out);
    }
    //remove ()
    while (strpos($out, "()") !== false) {
        $out = str_replace("()", "", $out);
    }

    //remove (language: )
    while (preg_match("|\(\w+:\s*\)|", $out, $match)) {
        $out = str_replace($match[0], "", $out);
    }

    //remove ( , , , ) (e.g: Dipavali)
    while (preg_match("|\([,\s]+\)|", $out, $match)) {
        $out = str_replace($match[0], "", $out);
    }

    //remove (LINK::text::  )
    while (preg_match("|\(LINK::\w+::\s*\)|", $out, $match)) {
        $out = str_replace($match[0], "", $out);
    }

    while (preg_match('~\[((?!\[|\]).)*\]~ms', $out, $matches)) { //regex with look back
        $out = str_replace($matches[0], "", $out);
    }

    $out = str_replace("&nbsp;", " ", $out);
    $out = str_replace("&mdash;", "-", $out);
    $out = str_replace("&mdash", "-", $out);
    while (strpos($out, "\n\n") !== false) {
        $out = str_replace("\n\n", "\n", $out);
    }
    $out = preg_replace("~LINK:{2}\s~", "", $out);
    $out = trim(strip_tags(html_entity_decode($out)));
    //	preg_replace("~<(\w+).*>.*</\1>~U","",$out);
    $out = str_replace("; ,", "", $out);

    while (stripos($out, "  ") !== false) {
        $out = str_replace("  ", " ", $out);
    }

    $out = str_replace("\n\n", "\n", $out);
    $out = preg_replace("~\n\s*\n~", "\n", $out);

    #Remove ending headings
    /*
     * ....multiple lines....
     * HEADING
     */

    $ewithhead = true;
    echo "<br>remove ending headers<br>";

    do {
        $out = trim($out);
        $nl = strrpos($out, "\n");
        $last_line = substr($out, $nl, (strlen($out) - 1) - $nl);
        if (!$last_line || strlen(trim($last_line)) == 0) {
            $ewithhead = false;
        } else {
            if (!preg_match("~[a-z]+~", $last_line, $matches)) { //matches a HEADING
                echo "removing $last_line.........$i<bR>";
                $out = substr($out, 0, $nl + 1);
            } else {
                $ewithhead = false;
            }
        }
    } while ($ewithhead);

    echo "<br>-=-=--=-=-=-=-=-=<bR>";

    if (strlen($out) < 101)
        $out = '';

    //To remove =Headings=
//    do {
//        $hrpos = strrpos($out, "="); //occurence of last =
//        var_dump($hrpos);
//        echo " " . strlen($out) . '<br>';
//        if ($hrpos !== false) {
//            if (strlen($out) <= $hrpos + 1) { //Ends with a heading
//                $hspos = strrpos(substr($out, 0, $hrpos), "="); //second last =
//                if ($hspos !== false) {
//                    $to_remove = substr($out, $hspos, $hrpos - $hspos + 1);
//                    echo "<br>Replacing $to_remove<br>";
//                    $out = trim(str_replace($to_remove, "", $out));
//                }
//            } else {
//                $ewithhead = false;
//            }
//        } else {
//            $ewithhead = false;
//        }
//    } while ($ewithhead == true);

    echo " last: " . strlen($out);
    #Return parsed text

    $out = str_ireplace("INSERT NON-FORMATTED TEXT HERE", "", $out);
    $out = str_ireplace("#", "-", $out);
    $out = str_ireplace("*", "-", $out);
    $out = str_ireplace("VIDEO", "", $out);
    $t = stripos($out, "RELATED WIKIHOWS");


    if ($t) {
        $out = substr($out, 0, $t);
        $out = trim($out);
    }

    return $out;
}

//function get_closest($query) {
//
//    $search = "site:www.wikihow.com " . $query . " -Discussion -user";
//    echo "<br>Google url: $url<br>";
//
//    $ttime = microtime(true);
//    $response = rawurldecode(httpGet($url));
//    $ttime = microtime(true) - $ttime;
//    //file_put_contents("wikihowgle.htm",$response);
//    echo "<br>Google Search: $ttime<br>";
//
//    if (strpos($response, "Your client does not have permission ")) {
//        $ttime = microtime(true);
//        return _getClosest($query);
//        $ttime = microtime(true) - $ttime;
//        echo "<Br>Wikipedia search: $ttime<br>";
//    } else {
//        preg_match_all('~<a href="http://www.wikihow.com/([^":]+)"~', $response, $matches);
//        echo "Google search results:\n";
//        $google_search_results = $matches[1];
//        $google_search_results = array_values($google_search_results);
//        print_r($google_search_results);
//        echo "\n------------------<br>\n";
//        if (isset($matches[1][0])) {
//            echo "<br>Google search result: $google_search_results[0]<br>";
//            return urldecode($google_search_results[0]);
//        } else
//            return '';
//    }
//}

function get_closest($query) {
//    $search = "site:www.wikihow.com " . $query . " -Discussion -user";
    $search = "site:www.wikihow.com " . $query;
    $bing_results = bing_search($search);
    $return = '';
    foreach ($bing_results['urls'] as $response) {
        preg_match('~http://www.wikihow.com/(.+)~', $response, $matches);
        if (!empty($matches[1])) {
            $res = $matches[1];
        }

        if (substr($res, 0, 9) != 'Category:' && substr($res, 0, 11) != 'Discussion:' && substr($res, 0, 5) != 'User:') {
            $return = $res;
            break;
        }
//        $google_search_results[] = $matches[1];
    }

//    foreach ($google_search_results as $res) {
//        if (substr($res, 0, 9) != 'Category:') {
//            $return = $res;
//        }
//    }
    return $return;
//    if (count($google_search_results)) {
//        return $google_search_results[0];
//    } else {
//        return '';
//    }
}

function wikihow($kw) {
    echo "<br>wikihow()<br>";
    $missing = false;
    $i = 0;
    $spell = 0;
    $content = '';
    $wttime = microtime(true);
    do {

        $query = urlencode($kw);
        $url = "API";

        echo "<h2>wikihow url : $url</h2>>";


        $ttime = microtime(true);
        $response = httpGet($url);
        $ttime = microtime(true) - $ttime;
        echo "<br>calling $url: $ttime<br>";

        //echo $response;
        $xmlObj = simplexml_load_string($response);
        $arrXml = objectsIntoArray($xmlObj);

        if (!isset($arrXml['query']) || isset($arrXml['query']['pages']['page']['@attributes']['missing']) || isset($arrXml['query']['pages']['page']['@attributes']['invalid'])) {
            echo "get Closest returning false";
            return false;
        } else if (isset($arrXml['query']['pages']['page']['revisions']['rev'])) {
            #Handle redirections
            $content = @$arrXml['query']['pages']['page']['revisions']['rev'];
            $kw = '';
            echo "<br>page title: " . $arrXml['query']['pages']['page']['@attributes']['title'] . '<br>';

            if (stripos($content, '#REDIRECT') !== false) {
                preg_match("~^#[A-Za-z]+\s*\[\[([^[\]]+)\]\]~", $content, $xx);
                $kw = $xx[1];
                if (strpos($kw, "#") !== false) {
                    $kw = substr($kw, 0, strpos($kw, "#"));
                }
                echo "Redirect: $kw<br>";
            }
            echo "Key word: ";
            var_dump($kw);
        }
        //die($kw);
        $i++;

        echo "<br>kw: $kw<br>";
    } while ($kw != '' && $i < 5); //while ( stripos($content,"#REDIRECT") !== false && $i < 5);
    $ttime = microtime(true) - $wttime;
    echo "<bR>mwiki while loop: $ttime<br>";
    echo "iterations: $i<br>";
    echo "<br>--------mediawiki()--------<br>";
    if ($i > 4) { // =>redirected more than 4 times
        return false;
    } else {
        if (!isset($arrXml['query']) || isset($arrXml['query']['pages']['page']['@attributes']['missing']) || $arrXml['query']['pages']['page'] == '')
            return false;
        else
            return $arrXml['query']['pages']['page'];
    }
}

echo "<h1>wikihow:" . $req . "</h1>";
$e = get_closest($spell_checked);
$ret = wikihow($e);
$content = $ret['revisions']['rev'];
$out = get_content($content);
//file_put_contents("out.txt",$out);
// echo "<br>------------<br>";
//echo $out;
if ($out) {
    $current_file = "/how/$global_id";
    $files = DATA_PATH . "/how/$global_id";
    @unlink($files);
    file_put_contents($files, $out);

    $wikihow_return = $out;
    echo "<br>length here: " . strlen($wikihow_return) . '<br>';
} else {
    $wikihow_return = '';
}
?>