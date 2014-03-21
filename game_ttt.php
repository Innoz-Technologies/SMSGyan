<?php

if ($req == 'play ttt' || $spell_checked == 'play tictactoe' || $spell_checked == 'play tic tac toe') {
    $total_return = "Welcome to Tic-tac-toe.";
    $options_list[] = "Easy";
    $list[] = array("content" => "__ttt__easy");
    $options_list[] = "Hard";
    $list[] = array("content" => "__ttt__hard");
    $options_list[] = "Rules";
    $list[] = array("content" => "__ttt__rules");
    $to_logserver['source'] = 'game_ttt';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

if (substr($req, 0, 7) == '__ttt__') {

    if ($req == '__ttt__rules') {
        $total_return = "-The game is played on a grid that's 3 squares by 3 squares.
-You are X, opposition is O. Reply with specific number to mark corresponding box.
-The first player to get 3 of her marks in a row (up, down, across, or diagonally) is the winner.
-When all 9 squares are full, the game is over. If no player has 3 marks in a row, the game ends in a tie.";
        $options_list[] = "Easy";
        $list[] = array("content" => "__ttt__easy");
        $options_list[] = "Hard";
        $list[] = array("content" => "__ttt__hard");

        $to_logserver['source'] = 'game_ttt';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }

    $difc = '';
    $next_move = '';

    $err = '';
    if ($req == '__ttt__easy') {
        $difc = 0;
        $next_move = '000000000';
    } else if ($req == '__ttt__hard') {
        $difc = 1;
        $next_move = '000000000';
    } else if (preg_match("~__ttt__(\d)_(\d{9})~", $req, $match)) {
        $difc = $match[1];
        $next_move = $match[2];
    } else if (preg_match("~__ttt__err__(\d)_(\d{9})~", $req, $match)) {
        $err = "The box is already marked. Please select unmarked one.\n";
        $difc = $match[1];
        $next_move = $match[2];
    }

    if ($next_move) {
        $url = "http://IP/tictactoe/index.php?tw_subkey=play&game_mode=$difc&move_next=$next_move";
        $resp = file_get_contents($url);
        $resp_ar = objectsIntoArray(simplexml_load_string($resp));
        $total_return = $err . $resp_ar['response'];
        if ($resp_ar['status'] == 0) {
            $list = array();
            $options_list = array();
            $moves = str_split($resp_ar['next_move']);
            for ($i = 0; $i < 9; $i++) {
                if ($moves[$i] == 0) {
                    $tmp = $moves;
                    $tmp[$i] = 1;
                    $list[] = array("content" => "__ttt__$difc" . "_" . implode('', $tmp));
                } else {
                    $list[] = array("content" => "__ttt__err__$difc" . "_$next_move");
                }
            }
        } else if ($resp_ar['status'] == 2) {
            $options_list[] = "Play Again";
            $list[] = array("content" => "play ttt");
        } else {
            $options_list[] = "Try Again";
            $list[] = array("content" => "play ttt");
        }
        if ($resp_ar['status'] != 0) {
            $query = "insert into game_ttt(msisdn,circle,status,response) values('$number','$circle_short'," . $resp_ar['status'] . ",'" . mysql_real_escape_string($resp_ar['response']) . "')";
            mysql_query($query) or trigger_error(mysql_error());
        }
        $to_logserver['source'] = 'game_ttt';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>