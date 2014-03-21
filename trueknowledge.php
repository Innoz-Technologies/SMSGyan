<?php

function get_trueknowledge_result() {
    global $trueknowledge_in;
    global $global_id;
    $return = '';

    $xml_parser = xml_parser_create("UTF-8");
    xml_parse_into_struct($xml_parser, $trueknowledge_in, $values);
//print_r($values);
    $tk_response = $values[0];
    if ($tk_response['attributes']['UNDERSTOOD'] == 'true' && $tk_response['attributes']['ANSWERED'] == 'true') {
        $tk_status = $values[1];
        $completeness = $tk_status['value']; //Status of the output to assign prirority
        //Answer
        $tk_text_result = $values[3];
        $type = $tk_text_result['type'];

        $return = $tk_text_result['value'];
        if ($return == 'Result set may be incomplete' || strpos($return, 'true knowledge') !== false) {
            $return = false;
        } else {
            file_put_contents(DATA_PATH . "/trueknowledge/$global_id", $return);
        }
    } else {
        $return = false;
    }
    return $return;
}

$trueknowledge_return = get_trueknowledge_result();
echo '<br>Trueknowledge<br>';
var_dump($trueknowledge_return);
echo '<br>---------------<br>';
?>