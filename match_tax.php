<?php

echo "<br>Before tax:";
if (preg_match("~tax ([\d]+)~", $req, $match)) {
    echo "<br> INCOME TAX>";
    $income = $match[1];
    $tax = 0;
    if ($income > 800000) {
        $tax += ( $income - 800000) * 0.3;
        $income = 800000;
    }
    if ($income > 500000) {
        $tax += ( $income - 500000) * 0.2;
        $income = 500000;
    }
    $wtax = $tax;
    $stax = $tax;
    $sstax = $tax * 1.03;

    if ($income > 180000) {
        $tax += ( $income - 180000) * 0.1;
    }

    if ($income > 190000) {
        $wtax += ( $income - 190000) * 0.1;
    }
    if ($income > 250000) {
        $stax += ( $income - 250000) * 0.1;
    }

    $tax *= 1.03;
    $wtax *= 1.03;
    $stax *= 1.03;
    
    $total_return = "Income tax for $match[1]:";
    $total_return .= "\nGeneral: $tax";
    $total_return .= "\nWomen: $wtax";
    $total_return .= "\nSenior citizen(60 to 80): $stax";
    $total_return .= "\nVery Senior citizen(above 80): $sstax";
    $to_logserver['source'] = 'tax';
    putOutput($total_return);
    exit();
}
?>