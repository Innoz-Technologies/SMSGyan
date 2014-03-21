<?php

$arNumber = array("7353970716", "9741804522");

if (strpos($req, "bid") !== false && (in_array($number, $arNumber) || $operator == "idea")) {

    echo "<h3>Bid Number</h3>";
    $arBid = array();
    if (preg_match("~\b^(bids?)\b~si", $req)) {
        $bidWord = preg_replace("~bids?~", "", $req);

        if (empty($bidWord)) {
            $total_return = "Select a number type";
            $options_list[] = "Platinum";
            $list[] = array("content" => "__bid__platinum__0__oth__");
            $options_list[] = "Gold";
            $list[] = array("content" => "__bid__gold__0__oth__");
            $options_list[] = "Silver";
            $list[] = array("content" => "__bid__silver__0__oth__");
        } else {
            if (isset($arCacheData["bi"])) {
                $arBid = $arCacheData["bi"];
                $bidID = $arBid["i"];
                $bidWord = preg_replace("~^[\d]~si", "", $bidWord);
                if (empty($bidWord)) {
                    $bidWord = 0;
                    if ($arBid["b"] == "bid")
                        $total_return = "The amount should be greater than zero";
                    else
                        $total_return = "Please enter valid mobile number.";
                } else {
                    if ($arBid["b"] == "bid") {
                        $total_return = "Your bid is successfully send to our customer care center. We will get back to you once you win the bid.";

                        $q = "Insert into bid_borrowers(`number`,`circle`,`operator`,`bidNumID`,`amount`) values('$number','$circle_short','$operator',$bidID,$bidWord)";
                        if (mysql_query($q)) {
                            echo "<br>Inserted";
                        }
                        unset($arCacheData["bi"]);
                    } elseif ($arBid["b"] == "enter") {

                        echo $query = "select * from bid_numbers where number ='$bidWord'";
                        $result = mysql_query($query);

                        if (mysql_num_rows($result)) {
                            $row = mysql_fetch_array($result);
                            $total_return = "Available post paid number " . $row['number'];
                            $bidNumID = $row["id"];
                            $options_list[] = "Bid for this number";
                            $list[] = array("content" => "__bid__" . $bidType . "__" . $bidNumID . "__bid__");
                            $options_list[] = "Show next number";
                            $list[] = array("content" => "__bid__" . $bidType . "__" . $bidNumID . "__show__");
                            $options_list[] = "Enter your choice";
                            $list[] = array("content" => "__bid__" . $bidType . "__" . $bidNumID . "__enter__");
                        } else {
                            $total_return = "Sorry, No bid found for this number.";
                        }
                        unset($arCacheData["bi"]);
                    }
                }
            } else {
                $total_return = "Please initiate with BID\nie: BID to $shortcode";
            }
        }
    } elseif (preg_match("~__bid__(.+)__(.+)__(.+)__~si", $req, $matches)) {
        echo "<br>" . $bidType = $matches[1];
        echo "<br>" . $bidID = $matches[2];
        echo "<br>" . $bidOpn = $matches[3];

        if ($bidID == 0 || $bidOpn == "show") {
            if ($bidOpn == "show") {
                $q = "Select * from bid_numbers where `type`='$bidType' and id>$bidID order by id limit 1";
            } else {
                $q = "Select * from bid_numbers where `type`='$bidType' order by id limit 1";
            }
            $result = mysql_query($q);

            if (mysql_num_rows($result)) {
                $row = mysql_fetch_array($result);
                $total_return = "Available post paid number " . $row['number'];
                $bidNumID = $row["id"];
                $options_list[] = "Bid for this number";
                $list[] = array("content" => "__bid__" . $bidType . "__" . $bidNumID . "__bid__");
                $options_list[] = "Show next number";
                $list[] = array("content" => "__bid__" . $bidType . "__" . $bidNumID . "__show__");
                $options_list[] = "Enter your choice";
                $list[] = array("content" => "__bid__" . $bidType . "__" . $bidNumID . "__enter__");
            } elseif ($bidOpn == "show") {
                $total_return = "Sorry no more bid number exists.";
            } else {
                $total_return = "Sorry no more bid number exists in this category.";
            }
        } elseif ($bidOpn == "bid") {
            echo $q = "SELECT amount AS amt FROM bid_numbers, bid_borrowers WHERE bid_borrowers.bidNumID = bid_numbers.id AND bid_numbers.id =$bidID order by amount desc  limit 1";
            $result = mysql_query($q);

            if (mysql_num_rows($result)) {
                $row = mysql_fetch_array($result);

                $amount = $row["amt"];
                $amount1 = $amount + 1;
            } else {
                if ($bidType == "platinum")
                    $amount = 2000;
                elseif ($bidType == "gold")
                    $amount = 1000;
                elseif ($bidType == "silver")
                    $amount = 500;
                $amount1 = $amount + 1;
            }
            $total_return = "Current bid on  this number: $amount INR\nIf you want to bid for this number, SMS BID<space>amount to $shortcode\nEg: BID $amount1";
            $arBid["b"] = "bid";
            $arBid["i"] = $bidID;
            $arBid["expiry"] = date("Y-m-d H:i:s", strtotime("+1 day"));
            $arCacheData["bi"] = $arBid;
        } elseif ($bidOpn == "enter") {
            $total_return = "If you want to search a number for bidding then, SMS BID<space>10 digit number to $shortcode \nEg: BID 99xxxxxxxx";
            $arBid["b"] = "enter";
            $arBid["i"] = $bidID;
            $arBid["expiry"] = date("Y-m-d H:i:s", strtotime("+1 day"));
            $arCacheData["bi"] = $arBid;
        }
    }

    if ($total_return) {
        $to_logserver['source'] = 'bid';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
} elseif (isset($arCacheData["bi"])) {
    unset($arCacheData["bi"]);
}
?>
