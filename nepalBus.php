<?php

if (preg_match("~\b(b[au]s)\b~", $req, $match)) {

    if (strpos($spell_checked, 'bus') === 0 || strpos($spell_checked, 'bas') === 0) {
        $first_BUS = true;
    } else {
        $first_BUS = false;
    }

    if (!preg_match("~\b(who|how|route|direction|movie|song|poem|weather|climate|cricket|cri|score|review)\b~", $req)) {
        echo 'bus 1 ' . $bus_req = preg_replace("~\b((trains?|trauns?|tran|trn|local|busstop|bus|number|time|timing)s?|stations?|which|when|give me|tell me|please|pleese|what|go|show|me|long|travel|do|have|been|the|of|in|no|pnr|journey|need|know|help|all|and|or|before|after|then|list|first|last|i want to|want|for|go|is|was|i|express|exp|passenger|passanger|pasienger|mail|ticket|charge|fron|murder|metro|next|hour)\b~", "", $req);

        $splited = matchdate($bus_req);
        if (isset($splited[2])) {
            $bus_req = $splited[0];
            $getdate = $splited[2];
        }

        echo '<br>bus 2 ' . $bus_req = trim(preg_replace("~[\s]+~", " ", $bus_req));    //removing more spaces

        $bus_route = trim($bus_req);  //regaining value

        $bus_req = preg_replace("~[^\w\s]~", " ", $bus_req);        //replacing special chars with space

        $ismatched = false;
        if (preg_match("~\bto\b ([\w\s]+) fro?m ([\w\s]+)~", $bus_req, $match)) {
            echo '<br>Reg 1:';
            print_r($match);
            $placeFrom = $match[2];
            $placeTo = $match[1];
            $ismatched = true;
        } else if (preg_match("~.*(\b(fro?m)\b) ?([\w\s]+) to ([\w\s]+)~", $bus_req, $match)) {
            echo '<br>Reg 2:';
            print_r($match);
            $placeFrom = $match[3];
            $placeTo = $match[4];
            $ismatched = true;
        } else if (preg_match("~([\w\s]+) to ([\w\s]+)~", $bus_req, $match)) {
            echo '<br>Reg 3:';
            print_r($match);
            $placeFrom = $match[1];
            $placeTo = $match[2];
            $ismatched = true;
        } else if (preg_match("~([\w\s]+) (fro?m) ([\w\s]+)~", $bus_req, $match)) {
            echo '<br>Reg 4:';
            print_r($match);
            $placeFrom = $match[3];
            $placeTo = $match[1];
            $ismatched = true;
        } else if (preg_match("~([\w]+) ([\w]+)~", $bus_req, $match)) {
            echo '<br>Reg 5:';
            print_r($match);
            $placeFrom = $match[1];
            $placeTo = $match[2];
            $ismatched = true;
        }

        include 'nepal_bus.php';
        if (empty($bus_return) && $first_BUS) {
            $bus_return = "Sorry No result found for your query.";
            //$free = True;
            $to_logserver['isresult'] = 0;
        }

        if ($bus_return != '') {
            $total_return = $bus_return;
            $source_machine = $machine_id;
            $current_file = "/temp/$numbers";
            file_put_contents(DATA_PATH . $current_file, $bus_return);
            $to_logserver['source'] = 'bus';
            include 'allmanip.php';
            putOutput($total_return);
            exit();
        }
    }
}
?>
