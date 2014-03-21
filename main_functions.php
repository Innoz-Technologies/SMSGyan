<?php
function handle_error($errno, $errstr, $errfile, $errline, $errcontext) {
    // timestamp for the error entry
    $dt = date("Y-m-d H:i:s");
    // Make log entries

    $errortype = array(
        E_ERROR => 'Error',
        E_WARNING => 'Warning',
        E_PARSE => 'Parsing Error',
        E_NOTICE => 'Notice',
        E_CORE_ERROR => 'Core Error',
        E_CORE_WARNING => 'Core Warning',
        E_COMPILE_ERROR => 'Compile Error',
        E_COMPILE_WARNING => 'Compile Warning',
        E_USER_ERROR => 'User Error',
        E_USER_WARNING => 'User Warning',
        E_USER_NOTICE => 'User Notice',
        E_STRICT => 'Runtime Notice',
        E_RECOVERABLE_ERROR => 'Catchable Fatal Error'
    );
    $error_msg = array("DT" => $dt, "E_NO" => $errno, "T" => $errortype, "E" => $errstr, "F" => $errfile, "L" => $errline);
    //$error_msg = "[$dt] $errortype[$errno] $errstr in $errfile at $errline";
    errorLog("$error_msg\n");

    //Critical errors
    $critical_errors = array(E_ERROR, E_PARSE, E_CORE_ERROR, E_USER_ERROR);

    if (in_array($errno, $critical_errors)) {
        error_log($error_msg, 1, "smsgyan@innoz.in");
        terminate($error_msg);
    }
}

// TERMINATE THE PROGRAM IN CASE OF ERRORS AND SEND THE ERROR REPORT TO DEVELOPMENT TEAM
function terminate($error) {
    die("Script terminated due to error:<br>$error");
    //TO DO: E-mail error
}

function errorLog($to_log) {
    $log = serialize($to_log);
    file_put_contents(dirname(__FILE__) . "/log/errors.log", $log . "\n", FILE_APPEND);
}

/*
 * SEND THE OUTPUT TO THE USER
 */

function putOutput($reply) {
    global $plain_text_log;
    global $query_id;
    global $time_start;
    $time_output = microtime(true);
    $time = $time_output - $time_start;
    $reply = normalize(clean(trim(clean(html_entity_decode($reply)))));
    $numbs = $_GET["mobile"];
    $myid = "AUU";
    //Log
    $response_length = strlen($reply);
    $plain_text_log .= "$reply\n----------------\n";

    file_put_contents(dirname(__FILE__) . "/log/plainlog.txt", $plain_text_log, FILE_APPEND);

    $to_log = array("Qid" => $query_id, "T" => $time, "L" => $response_length, "R" => mysql_real_escape_string($reply));
    $log = serialize($to_log);
    //$to_log = "$query_id\t$time\t$response_length\n$reply\n\n";
    file_put_contents(LOG_DIR . "/response.log", $log . "\n", FILE_APPEND);
    if ($numbs != "test" && $numbs != "ashwin" && $numbs != "abhinav" && $numbs != "suhail" && $numbs != "vineeth" && $numbs != "shyam" && $numbs != "web") {
        //$text=urldecode($_GET['content']);
        //$to=urldecode($_GET['number']);
        //$sender=urldecode($_GET['sender']);
        $url = 'http://IP/mt/send.php?sender=9822818163&number=' . $numbs . '&content=' . urlencode($reply);
        $content = file_get_contents($url);
        //echo $content;
    } else {
        echo $reply;
        echo "<br><br>" . dirname(__FILE__);
    }
//	$reply;
    /* @header("Content-Type: text/html; charset=ISO-8859-1;");
      ?><br />
      <font face="Courier New, Courier, monospace">
      <?php //echo str_replace("\n","<br>",$reply); ?>
      </font>
      <?php
      //echo "<br>----------------------------<br>".strlen($reply); */
    //exit();
}
?>