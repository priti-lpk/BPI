<?php
ob_start();
class DBAdapter {

    private $con;

    public function __construct() {
        include 'dbconn.php';
        include_once 'Controls.php';
        $this->con = $con;
    }

    function setData($table, $field) {
        //include 'dbconn.php';
        $string = '';
        $field_val = '';
        $count = count($field) - 1;
        $i = 0;
        $text = "INSERT INTO " . $table . " (";
        foreach (array_keys($field)as $key) {
            if ($i == $count) {
                $string = $string . $key;
            } else {
                $string = $string . $key . ",";
            }
            $i++;
        }
        $i = 0;
        foreach ($field as $val) {
            if ($i == $count) {
                $field_val = $field_val . "'" . mysqli_real_escape_string($this->con, $val) . "'";
            } else {
                $field_val = $field_val . "'" . mysqli_real_escape_string($this->con, $val) . "',";
            }
            $i++;
        }
        $query = $text . $string . ") " . "VALUES(" . $field_val . ");";

        //echo $query;
        $result = mysqli_query($this->con, $query);
        if ($result) {
            return TRUE;
        } else {
            mysqli_error($this->con);
            return false;
        }
    }

    function getData($table, $field) {
        include 'dbconn.php';
        $string = "";
        $query = "";
        $data = null;
        $text = "select ";
        $count = count($field) - 1;
        $i = 0;
        foreach ($field as $col) {
            if ($i == $count) {
                $string = $string . $col;
            } else {
                $string = $string . $col . ",";
            }
            $i++;
        }
        $query = $text . $string . " from " . $table;
        $result = mysqli_query($this->con, $query);
        if ($result) {
            $i = 0;
            while ($row = mysqli_fetch_row($result)) {
                $data[$i] = $row;
                $i++;
            }
            return $data;
        } else {
            echo 'Data can not fetch<br>';
            return FALSE;
        }
        echo $query;
    }

    function getRow($table, $field, $clause) {
        include 'dbconn.php';
        $string = "";
        $query = "";
        $text = "select ";
        $data = null;
        $count = count($field) - 1;
        $i = 0;
        foreach ($field as $col) {
            if ($i == $count) {
                $string = $string . $col;
            } else {
                $string = $string . $col . ",";
            }
            $i++;
        }
        $query = $text . $string . " from " . $table . " where " . $clause;
        //echo '<br><br><br><br><br>';
        //echo $query;
        $result = mysqli_query($this->con, $query);
        if ($result) {
            $i = 0;
            while ($row = mysqli_fetch_row($result)) {
                $data[$i] = $row;
                $i++;
            }
            if ($data === NULL) {
                return NULL;
            } else {
                return $data;
            }
        } else {
            return FALSE;
        }
    }

    function getLastID($field, $table, $clause) {
        include 'dbconn.php';
        $query = "select " . $field . " from " . $table . " where " . $clause . " order by " . $field . " desc limit 1";
        //echo $query;
        $result = mysqli_query($this->con, $query);
        if ($result) {
            $data = 0;
            while ($row = mysqli_fetch_row($result)) {
                $data = $row[0];
            }
            return $data;
        } else {
            return FALSE;
        }
    }

    function updateRow($table, $field, $clouse) {
        include 'dbconn.php';
        $query = "";
        $string = "";
        $fiel_array = array_keys($field);
        $count = count($field) - 1;
        $i = 0;
        foreach ($field as $key) {
            if ($i == $count) {
                $string = $string . $fiel_array[$i] . '=' . "'" . mysqli_real_escape_string($con, $key) . "'";
            } else {
                $string = $string . $fiel_array[$i] . '=' . "'" . mysqli_real_escape_string($con, $key) . "',";
            }
            $i++;
        }
        $query = "update " . $table . " set " . $string . " where " . $clouse;
        //echo $query;
        $result = mysqli_query($this->con, $query);
        if (!$result) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function delRow($table, $clous) {
        include 'dbconn.php';
        $query = "Delete from " . $table . " where id=" . $clous;
        echo $query;
        $result = mysqli_query($this->con, $query);
        if (!$result) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    function closeDB() {
        $result = mysqli_query($this->con, "SHOW FULL PROCESSLIST");
        while ($row = mysqli_fetch_array($result)) {
            if ($row["Time"] > $max_excution_time) {
                $sql = "KILL " . $row["Id"];
                mysqli_query($sql);
            }
        }
        mysqli_close($this->con);
    }

    function updateStock($item_id, $stockVal) {
        include 'dbconn.php';
        $query = "select id,item_id, qnty from item_stock where item_id=" . $item_id;
        //echo $query;

        $result = mysqli_query($this->con, $query);
        if ($result) {

            while ($row = mysqli_fetch_row($result)) {
                $stock = $row[2] - ($stockVal);

                $query1 = "update item_stock set qnty=" . $stock . "  where item_id=" . $item_id;
                mysqli_query($this->con, $query1);
                // echo $query1;
            }
        }
    }

    function updatePartyAmount($id, $amount, $creditDebit) {
        include 'dbconn.php';
        $query = "select party_amount from party_list where id=" . $id;
        //echo $query;
        $result = mysqli_query($this->con, $query);
        $newAmount = 0;
        if ($result) {
            while ($row = mysqli_fetch_row($result)) {
                // print_r($amount);
                if ($creditDebit == "Debit") {
                    //  print_r($row[0]);
                    $newAmount = $row[0] + $amount;
                    // print_r($newAmount);
                } elseif ($creditDebit == "Credit") {
                    $newAmount = $row[0] - $amount;
                    // print_r($newAmount);
                }
            }
        } else {
            $newAmount = $amount;
            //  print_r($newAmount);
        }
        $query1 = "update party_list set party_amount=" . $newAmount . "  where id=" . $id;
        mysqli_query($this->con, $query1);
        //echo $query1;
    }

    function createdby() {
        if (!isset($_SESSION)) {
        session_start();
    }
        $cdba = new Controls();
        $user = $_POST['user_fullname'];
//        print_r($user);
        $ip_id = $cdba->get_client_ip();

        $user_array = array($user, $ip_id);

        $user_string = json_encode($user_array, TRUE);
        return $user_string;
    }

}

?>
