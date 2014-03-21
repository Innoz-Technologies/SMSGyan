<?php
if(preg_match("~^\bargentina\b.+\bvenezuela\b|\bvenezuela\b.+\bargentina\b~", $spell_checked)){
     echo "<br>MP3 HFZ<br>";
    $total_return = "Argentina vs Venezuela Friendly FIFA Match\nSeptember 2, 2011 7:00 PM\nVenue: Salt Lake Stadium, Kolkata";
    $options_list[] = "TEAM ARGENTINA";
    $list[] = array("content" => "team argentina", "count" => 1);
    $options_list[] = "TEAM VENEZUELA";
    $list[] = array("content" => "team venezuela", "count" => 2);
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

if (preg_match("~^\b(team|football)\b.+\bvenezuela\b|\bvenezuela\b.+\b(team|football)\b~", $spell_checked)) {
    echo "<br>TEAM VENEZUELA";
    $total_return = "TEAM VENEZUELA:\n";
    $options_list[] = "Roberto Rosales";
    $list[] = array("content" => "roberto rosales", "count" => 1);
    $options_list[] = "Jose Salomon Rondon";
    $list[] = array("content" => "jose salomon rondon", "count" => 2);
    $options_list[] = "Josmar Zambrano";
    $list[] = array("content" => "josmar zambrano", "count" => 3);
    $options_list[] = "Raul Gonzalez";
    $list[] = array("content" => "raul gonzalez", "count" => 4);
    $options_list[] = "Gabriel Cichero";
    $list[] = array("content" => "Gabriel Cichero", "count" => 5);
    $options_list[] = "Juan Arango";
    $list[] = array("content" => "juan arango", "count" => 6);
    $options_list[] = "Oswaldo Vizcarrondo";
    $list[] = array("content" => "oswaldo vizcarrondo", "count" => 7);

    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

if (preg_match("~^\b(team|football)\b.+\bargentina\b|\bargentina\b.+\b(team|football)\b~", $spell_checked)) {
    echo "<br>TEAM ARGENTINA";
    $total_return = "TEAM ARGENTINA:\n";
    $options_list[] = "Lionel Messi(C)";
    $list[] = array("content" => "lionel messi", "count" => 1);
    $options_list[] = "Gonzalo Higuain";
    $list[] = array("content" => "Gonzalo Higuain", "count" => 2);
    $options_list[] = "Sergio Aguero";
    $list[] = array("content" => "sergio aguero", "count" => 3);
    $options_list[] = "Sergio Romero";
    $list[] = array("content" => "sergio romero", "count" => 4);
    $options_list[] = "Pablo Zabaleta";
    $list[] = array("content" => "pablo zabaleta", "count" => 5);
    $options_list[] = "Angel di Maria";
    $list[] = array("content" => "angel di maria", "count" => 6);
    $options_list[] = "Javier Mascherano";
    $list[] = array("content" => "javier mascherano", "count" => 7);

    include 'allmanip.php';
    putOutput($total_return);
    exit();
}
?>