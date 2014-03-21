<?php

$object = new resolution($spell_checked, $req);
if (!empty($object->return["response"])) {
    $total_return = $object->return["response"];
    $to_logserver['source'] = 'resolution';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

if (!empty($arCacheData["res"]) && preg_match('~([\d]{2})-([\d]{2})-([\d]{4})~', $req)) {
    $data = $arCacheData["res"]["data"];
    $no = $arCacheData["res"]["no"];

    $req = date("Y-m-d", strtotime($req));
    $conn = getAppDB2Con();
    echo $query = "UPDATE resolution SET tillDate='$req' WHERE number='$no' AND resolution='$data'";
    $result = mysqli_query($conn, $query);
    $total_return = "Your resolution has been updated.";

    unset($arCacheData["res"]);
    $to_logserver['source'] = 'resolution';
    include 'allmanip.php';
    putOutput($total_return);
    exit();
}

class resolution {

    public $return;

    function __construct($spell_checked, $req) {
        $return = array();
        if ($spell_checked == "resolution") {
            $this->return["response"] = "SMS #resolution <the resolution you wanted to make for this new year>";
        } elseif (preg_match('~resolution (.+)~', $req, $match)) {
            $data = trim($match[1]);
            $this->storeResolution($data);
        }
    }

    function storeResolution($data) {
        global $circle_short, $operator, $number, $arCacheData;
        $conn = getAppDB2Con();

        echo $query = "REPLACE INTO resolution(`number`,`operator`,`circle`,`resolution`) VALUES ('$number','$operator','$circle_short','" . mysql_real_escape_string($data) . "')";
        $result = mysqli_query($conn, $query);

        if ($result) {
            $this->return["response"] = "Your resolution has been stored.Please reply with the date as <dd-mm-yyyy> till which you want to keep this resolution";
            $hit_time = date("Y-m-d H:i:s");
            $expiry_time = date("Y-m-d H:i:s", strtotime($hit_time . " +1 day"));
            $arCacheData["res"]["data"] = $data;
            $arCacheData["res"]["no"] = $number;
            $arCacheData["res"]["expiry"] = $expiry_time;
        } else {
            $this->return["response"] = "Some internal error occured.Please try after some time";
        }
    }

}

?>
