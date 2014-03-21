<?php

//date_default_timezone_set("Asia/Calcutta");
//include 'functions.php';
$url = 'http://xml.premierleague.com/dynamicxml/matchlive/ScoresRoundUp_1.xml';
$xml_in = file_get_contents($url);
$xml = objectsIntoArray(simplexml_load_string($xml_in));

//print_r($xml);
if (isset($xml['competition']['match'][0])) {
    foreach ($xml['competition']['match'] as $i => $match) {
        $game[$i]['status'] = $match['@attributes']['statusDescription'];
        $game[$i]['venue'] = $match['@attributes']['venue'];
        $ko_IST = strtotime($match['@attributes']['ko'] . " + 5 hours 30 minutes");
        if (time() > $ko_IST) {
            $time = time() - $ko_IST;
            $mins = floor($time / 60);
            $secs = ($time % 60 < 10) ? "0" . $time % 60 : $time % 60;
            if ($mins > 45) {
                if ($mins > 90) {
                    $mins = 90;
                    $secs = '00';
                } else if ($mins > 60) {
                    $mins -= 15;
                } else {
                    $mins = 45;
                    $secs = '00';
                }
            }
            $game[$i]['time'] = "$mins:$secs";
        } else {
            $game[$i]['time'] = date('h:i A', $ko_IST) . " - KO";
        }
        $game[$i]['KO'] = $match['@attributes']['ko'];


        $homeTeam[$i]['full_name'] = $match['@attributes']['homeTeam'];
        $homeTeam[$i]['name'] = $match['@attributes']['homeTeamShortName'];
        $homeTeam[$i]['id'] = $match['@attributes']['paHomeTeamId'];
        $homeTeam[$i]['score'] = $match['@attributes']['homeTeamScore'];

        $awayTeam[$i]['full_name'] = $match['@attributes']['awayTeam'];
        $awayTeam[$i]['name'] = $match['@attributes']['awayTeamShortName'];
        $awayTeam[$i]['id'] = $match['@attributes']['paAwayTeamId'];
        $awayTeam[$i]['score'] = $match['@attributes']['awayTeamScore'];

        if (isset($match['goal'])) {
            if (isset($match['goal'][0])) {
                foreach ($match['goal'] as $goal) {
                    $player = $goal['@attributes']['playerName'];
                    $time = substr($goal['@attributes']['time'], 0, strpos($goal['@attributes']['time'], ':'));
                    $time += 1;
                    $teamId = $goal['@attributes']['teamId'];
                    $team = ($teamId == $homeTeam[$i]['id']) ? $homeTeam[$i]['name'] : $awayTeam[$i]['name'];
                    $game[$i]['goals'][] = array('name' => $player, 'time' => $time, 'team' => $team);
                }
            } else {
                $player = $match['goal']['@attributes']['playerName'];
                $time = substr($match['goal']['@attributes']['time'], 0, strpos($match['goal']['@attributes']['time'], ':'));
                $time += 1;
                $teamId = $match['goal']['@attributes']['teamId'];
                $team = ($teamId == $homeTeam[$i]['id']) ? $homeTeam[$i]['name'] : $awayTeam[$i]['name'];
                $game[$i]['goals'][] = array('name' => $player, 'time' => $time, 'team' => $team);
            }
        }
    }
} else if (isset($xml['competition']['match'])){
    $match = $xml['competition']['match'];
    $game[$i]['status'] = $match['@attributes']['statusDescription'];
    $game[$i]['venue'] = $match['@attributes']['venue'];
    $ko_IST = strtotime($match['@attributes']['ko'] . " + 5 hours 30 minutes");
    if (time() > $ko_IST) {
        $time = time() - $ko_IST;
        $mins = floor($time / 60);
        $secs = ($time % 60 < 10) ? "0" . $time % 60 : $time % 60;
        if ($mins > 45) {
            if ($mins > 90) {
                $mins = 90;
                $secs = '00';
            } else if ($mins > 60) {
                $mins -= 15;
            } else {
                $mins = 45;
                $secs = '00';
            }
        }
        $game[$i]['time'] = "$mins:$secs";
    } else {
        $game[$i]['time'] = date('h:i A', $ko_IST) . " - KO";
    }
    $game[$i]['KO'] = $match['@attributes']['ko'];


    $homeTeam[$i]['full_name'] = $match['@attributes']['homeTeam'];
    $homeTeam[$i]['name'] = $match['@attributes']['homeTeamShortName'];
    $homeTeam[$i]['id'] = $match['@attributes']['paHomeTeamId'];
    $homeTeam[$i]['score'] = $match['@attributes']['homeTeamScore'];

    $awayTeam[$i]['full_name'] = $match['@attributes']['awayTeam'];
    $awayTeam[$i]['name'] = $match['@attributes']['awayTeamShortName'];
    $awayTeam[$i]['id'] = $match['@attributes']['paAwayTeamId'];
    $awayTeam[$i]['score'] = $match['@attributes']['awayTeamScore'];

    if (isset($match['goal'])) {
        if (isset($match['goal'][0])) {
            foreach ($match['goal'] as $goal) {
                $player = $goal['@attributes']['playerName'];
                $time = substr($goal['@attributes']['time'], 0, strpos($goal['@attributes']['time'], ':'));
                $time += 1;
                $teamId = $goal['@attributes']['teamId'];
                $team = ($teamId == $homeTeam[$i]['id']) ? $homeTeam[$i]['name'] : $awayTeam[$i]['name'];
                $game[$i]['goals'][] = array('name' => $player, 'time' => $time, 'team' => $team);
            }
        } else {
            $player = $match['goal']['@attributes']['playerName'];
            $time = substr($match['goal']['@attributes']['time'], 0, strpos($match['goal']['@attributes']['time'], ':'));
            $time += 1;
            $teamId = $match['goal']['@attributes']['teamId'];
            $team = ($teamId == $homeTeam[$i]['id']) ? $homeTeam[$i]['name'] : $awayTeam[$i]['name'];
            $game[$i]['goals'][] = array('name' => $player, 'time' => $time, 'team' => $team);
        }
    }
}

$epl_result = "";
foreach ($game as $i => $g) {
    $epl_result .= $homeTeam[$i]['name'] . " " . $homeTeam[$i]['score'] . "-" . $awayTeam[$i]['score'] . " " . $awayTeam[$i]['name'] . " (" . $g['time'];
    switch ($g['status']) {
        case "Half Time":
            $epl_result .= " - HT";
            break;
        case "Full Time":
            $epl_result .= " - FT";
            break;
    }
    $epl_result .= ") " . $g['venue'];
    $epl_result .= "\n";
    if (isset($game[$i]['goals'])) {
        foreach ($game[$i]['goals'] as $goal) {
            $epl_result .= $goal['time'] . "th min " . $goal['name'] . " (" . $goal['team'] . ")\n";
        }
        $epl_result .= "-\n";
    }
}

echo $epl_result;
?>