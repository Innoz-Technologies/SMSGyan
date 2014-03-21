<?php

class Vote {

    public function databaseconfig() {

        define("DB_DSN", "DB");
        define("DB_USERNAME", "user");
        define("DB_PASSWORD", "pass");
    }

    public function getQues() {
        $this->databaseconfig();
//        $result = array();

        try {

            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "select * from vote order by `timestamp` desc limit 1";

            $stmt = $con->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function getCount($id) {
        $this->databaseconfig();
        $result = array();

        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "select count from vote where id=$id";

            $stmt = $con->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

    public function updatecount($count, $id) {
        $this->databaseconfig();

        try {
            $con = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "update vote set count='$count' where id=$id";

            $stmt = $con->prepare($sql);
            $stmt->execute();

            return TRUE;
        } catch (Exception $exc) {
            echo $exc->getMessage();
        }
    }

}

?>
