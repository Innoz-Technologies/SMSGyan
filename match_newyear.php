<?php

if ((strpos($req, 'top') !== false || strpos($req, 'hit') !== false || strpos($req, 'blockbuster') !== false || strpos($req, 'famous') !== false) && (strpos($req, '2011') !== false || strpos($req, 'this year') !== false || strpos($req, 'last year') !== false)) {
    $flag_enabled = false;
    $newyear_enabled = FALSE;
    if (strpos($req, 'song') !== false || strpos($req, 'lyrics') !== false || strpos($req, 'music') !== false) {
        $total_return = 'Top songs of 2011!';
        $options_list[] = "Chikini Chameli(Agneepath)";
        $list[] = array("content" => "lyrics Chikini Chameli(Agneepath)");
        $options_list[] = "Sadda Haq(Rockstar)";
        $list[] = array("content" => "lyrics Sadda Haq");
        $options_list[] = "Ooh La La(Dirty Picture)";
        $list[] = array("content" => "lyrics Ooh La La from Dirty Picture");
        $options_list[] = "Bhag dk bose(Delly Belly)";
        $list[] = array("content" => "lyrics Bhag dk bose(Delly Belly)");
        $options_list[] = "Chammak challo(Ra One)";
        $list[] = array("content" => "lyrics Chammak challo");
        $options_list[] = "Char Baj Gayi(F.A.L.T.U)";
        $list[] = array("content" => "lyrics Char Baj Gayi(F.A.L.T.U)");
        $options_list[] = "Dil Ke Liye(Ghost)";
        $list[] = array("content" => "lyrics Dil Ke Liye");
        $options_list[] = "Why This Kolaveri di(3)";
        $list[] = array("content" => "lyrics Why This Kolaveri di");
        include 'allmanip.php';
        $to_logserver['source'] = 'menu_newyear';
        putOutput($total_return);
        exit();
    } else if (strpos($req, 'movie') !== false || strpos($req, 'cinema') !== false || strpos($req, 'film') !== false) {
        $total_return = 'Top movies of 2011!';
        $options_list[] = "Harry Potter and the Deathly Hallows";
        $list[] = array("content" => "movie Harry Potter and the Deathly Hallows");
        $options_list[] = "Transformers: Dark of the Moon";
        $list[] = array("content" => "movie Transformers: Dark of the Moon");
        $options_list[] = "Pirates of the Caribbean: On Stranger Tides";
        $list[] = array("content" => "movie Pirates of the Caribbean: On Stranger Tides");
        $options_list[] = "MI4: Ghost Protocol";
        $list[] = array("content" => "movie Mission Impossible Ghost Protocol");
        $options_list[] = "Delhi Belly";
        $list[] = array("content" => "movie Delhi Belly");
        $options_list[] = "Zindagi Na Milegi Dobara";
        $list[] = array("content" => "movie Zindagi Na Milegi Dobara");
        $options_list[] = "Bodyguard";
        $list[] = array("content" => "movie Bodyguard");
        $options_list[] = "Ra.One";
        $list[] = array("content" => "movie Ra.One");
        $options_list[] = "Rockstar";
        $list[] = array("content" => "movie Rockstar");
        $options_list[] = "The Dirty Picture";
        $list[] = array("content" => "movie The Dirty Picture");
        $options_list[] = "Don 2";
        $list[] = array("content" => "movie Don 2");
        include 'allmanip.php';
        $to_logserver['source'] = 'menu_newyear';
        putOutput($total_return);
        exit();
    } else if (strpos($req, 'event') !== false || strpos($req, 'search') !== false || strpos($req, 'incident') !== false) {
        $total_return = 'Top events of 2011!';
        $options_list[] = "Earthquake in Japan";
        $list[] = array("content" => "Earthquake in Japan");
        $options_list[] = "India won the World Cup 2011";
        $list[] = array("content" => "India won the World Cup 2011");
        $options_list[] = "Royal Wedding";
        $list[] = array("content" => "Royal Wedding");
        $options_list[] = "Anna's fight against corruption";
        $list[] = array("content" => "Anna's fight against corruption");
        $options_list[] = "Osama bin Laden killed in Pakistan";
        $list[] = array("content" => "Osama bin Laden killed in Pakistan");
        $options_list[] = "Faster than speed of light";
        $list[] = array("content" => "Faster than speed of light");
        $options_list[] = "Wall street protest";
        $list[] = array("content" => "Wall street protest");
        $options_list[] = "Steve Jobs died";
        $list[] = array("content" => "Steve Jobs died");
        $options_list[] = "Muammar Gaddafi killed";
        $list[] = array("content" => "Muammar Gaddafi killed");
        $options_list[] = "Sehwag's world record";
        $list[] = array("content" => "Sehwag's world record");
        include 'allmanip.php';
        $to_logserver['source'] = 'menu_newyear';
        putOutput($total_return);
        exit();
    } else if (strpos($req, 'video') !== false) {
        $total_return = 'Top videos of 2011!';
        $options_list[] = "India winning the world cup";
        $list[] = array("content" => "video india's world cup winning moment");
        $options_list[] = "Sehwag's double century";
        $list[] = array("content" => "video virender sehwag's double century");
        $options_list[] = "Why this kolaveri di";
        $list[] = array("content" => "video why this kolaveri di");
        $options_list[] = "Anna hazare fast";
        $list[] = array("content" => "video anna hazare fast");
        $options_list[] = "Friday - Rebecca black";
        $list[] = array("content" => "video friday - rebecca black");
        include 'allmanip.php';
        $to_logserver['source'] = 'menu_newyear';
        putOutput($total_return);
        exit();
    }
} else {
    if (((strpos($req, 'new year') !== false || strpos($req, 'newyear') !== false) && strpos($req, 'photo') === false) || trim($spell_checked) == '2011' || trim($spell_checked) == '2012') {
        $flag_enabled = false;
        $newyear_enabled = FALSE;
        echo "<br>LIFESTAGE PLAYS";
        $total_return = 'New year special!';
//        $options_list[] = "Party search";
//        $list[] = array("content" => "party search");
        $options_list[] = "Top events 2011";
        $list[] = array("content" => "top events 2011");
        $options_list[] = "Top movies of 2011";
        $list[] = array("content" => "top movies of 2011");
        $options_list[] = "Top songs 2011";
        $list[] = array("content" => "top songs 2011");
        $options_list[] = "Top videos 2011";
        $list[] = array("content" => "top videos 2011");
        $options_list[] = "Wallpapers";
        $list[] = array("content" => "photo new year");
        $options_list[] = "Messages";
        $list[] = array("content" => "new year messages");
        $options_list[] = "Songs";
        $list[] = array("content" => "new year songs");
        include 'allmanip.php';
        $to_logserver['source'] = 'menu_newyear';
        putOutput($total_return);
        exit();
    }
}
?>