<?php

class BinarySearch {

    public function __construct($table, $field, $min, $condition = "", $cacheName = "") {
        if (empty($cacheName) || $cacheName == "") {
            $cacheName = $table;
        }
        $this->array = apc_fetch($cacheName, $success);
        if (!$success) {
            echo "$table FROM DATABASE";
            if (!empty($condition)) {
                echo $query = "select $field from $table where $condition order by $field";
            } else {
                echo $query = "select $field from $table order by $field";
            }
            $result = mysql_query($query) or trigger_error(mysql_error(), E_USER_ERROR);
            if (mysql_num_rows($result)) {
                echo "Sucess";
                $this->array = array();
                while ($row = mysql_fetch_array($result)) {
                    $this->array[] = strtolower($row[$field]);
                }
                apc_store($cacheName, $this->array);
            }
        }
        $this->count = count($this->array);
        $this->min = $min;
    }

    public function search($needle, $max_word = 1) {
        $words = explode(' ', $needle);
        while ($max_word >= 1) {
            if ($max_word == 1) {
                foreach ($words as $key => $value) {
                    if (strlen($value) >= $this->min) {
                        if ($this->check($value, 0, $this->count - 1)) {
                            return $value;
                        }
                    }
                }
            } else {
                $tot_count = count($words);
                for ($i = 0; ($i + $max_word) <= $tot_count; $i++) {
                    $value = '';
                    for ($j = $i; $j < ($i + $max_word); $j++) {
                        $value .= $words[$j] . ' ';
                    }
                    $value = trim($value);
                    //echo "<br> Searched for : " . $value;
                    if ($this->check($value, 0, $this->count - 1)) {
                        return $value;
                    }
                }
            }
            $max_word--;
        }
        return FALSE;
    }

    private function check($key, $start, $end) {
        if ($start > $end) {
            return 0;
        } else {
            $mid = ((int) (($end - $start) / 2)) + $start;
            $comp = strcmp($key, $this->array[$mid]);
            if ($comp == 0) {
                return $this->array[$mid];
            } else if ($comp < 0) {
                return $this->check($key, $start, $mid - 1);
            } else if ($comp > 0) {
                return $this->check($key, $mid + 1, $end);
            }
        }
    }

}

?>