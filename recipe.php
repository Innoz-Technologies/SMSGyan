<?php

$recipe_kw = array("recipe", "recipes", "recipe of", "how to cook", "cook", "recepe");
//recipe search
$check_recipe = "recipe of list";
if (left($req, strlen($check_recipe)) == $check_recipe) {
    $recipe_status = true;
    include 'recipesearch.php';
    if (!empty($return_value)) {
        $total_return = $res_return;
        include 'allmanip.php';
        $to_logserver['source'] = 'recipe';
        putOutput($total_return);
        exit();
    } else {
        $list = array();
        $options_list = array();
    }
}

if (preg_match("~\b(recipe of|recipe|recipes|how to cook|cook)\b(.+)~", $spell_checked, $match)) {
    echo "<br>RECIPE SEARCH<br>";
    print_r($match);
    if (preg_match("~^[^\w]*recipe~", $spell_checked)) {
        $recipe_must = true;
    }
    $recipe = $match[2];
    include 'recipesearch.php';
    if ($res_return) {
        $total_return = $res_return;
        include 'allmanip.php';
        $to_logserver['source'] = 'recipe';
        putOutput($total_return);
        exit();
    }
}
?>
