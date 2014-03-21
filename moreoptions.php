<?php

echo "<h2>MoreOptions.php</h2>";

if (!empty($listAll["list"])) {
    $showSub = false;
    $showsuboption = FALSE;
    $options_list = $listAll["options_list"];
    $recom_opns_list = $listAll["recom_opns_list"];
    $lists = $listAll["lists"];
    $recom_list = $listAll["recom_list"];

    $totalCount = 0;

    $total_return = "More Options";

    $newOptions_list = array();
    $newList1 = $newList = array();

    if (count($options_list) > $numeric_in) {
        for ($i = $numeric_in; $i < count($options_list); $i++) {
            $newOptions_list[] = $options_list[$i];
        }

        for ($i = $numeric_in; $i < count($lists); $i++) {
            $newList[] = $lists[$i];
        }

        for ($i = $numeric_in; $i < count($list); $i++) {
            $newList1[] = $list[$i];
        }

        unset($options_list);
        unset($list);
        unset($lists);
        $options_list = $newOptions_list;
        $lists = $newList;
        $list = $newList1;
    } else {
        echo $recom_index = $numeric_in - count($options_list);
        for ($i = $recom_index; $i < count($recom_opns_list); $i++) {
            $newOptions_list[] = $recom_opns_list[$i];
        }

        for ($i = $recom_index; $i < count($recom_list); $i++) {
            $newList[] = $recom_list[$i];
        }

        for ($i = $numeric_in; $i < count($list); $i++) {
            $newList1[] = $list[$i];
        }

        unset($options_list);
        unset($list);
        unset($lists);
        unset($recom_opns_list);
        unset($recom_list);
        $recom_opns_list = $newOptions_list;
        $recom_list = $newList;
        $list = $newList1;
    }

    if (isset($arCacheData["ca"]['f'])) {
        if ($arCacheData["ca"]['f'] == 1) {
            $free = true;
            $nextfree = 1;
        } else if ($arCacheData["ap"]['d'] == date("Y-m-d")) {
            $free = true;
            $nextfree = 2;
        } else {
            $free = FALSE;
            $nextfree = 2;
        }
    }
 
    if ($total_return) {
        $isMoreOption = TRUE;
        $to_logserver['source'] = 'moreoptions';
        include 'allmanip.php';
        putOutput($total_return);
        exit();
    }
}
?>
