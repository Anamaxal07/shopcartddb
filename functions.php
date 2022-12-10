<?php
    DEFINE("DB_SERVER", "localhost");
    DEFINE("DB_USERNAME", "root");
    DEFINE("DB_PASSWORD", "");
    DEFINE("DB_NAME", "shopping_db_cart");

    function openConn(){
        $con = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

            if($con === false)
                die("ERROR: Could not connect" . mysqli_connect_error());

            return($con);
    }
    function closeConn($con){
        mysqli_close($con);

    }
    function getRecord($con, $strSql){
        $arrRec = [];
        $i = 0;

        if($rs = mysqli_query($con, $strSql)){
            if(mysqli_num_rows($rs) == 1){
                $rec = mysqli_fetch_array($rs);
                foreach ($rec as $key => $value) {
                    $arrRec[$key] = $value;
                }
            }
            elseif(mysqli_num_rows($rs) > 1){
                while($rec = mysqli_fetch_array($rs)){
                    foreach ($rec as $key => $value) {
                        $arrRec[$i][$key] = $value;
                    }
                    $i++;
                }
            }
            mysqli_free_result($rs);
        }
        else 
            die("ERROR: Could not execute your request!");

        return $arrRec;
    }

    function executeInsertlastIDQuery($con, $strSql){
        if($rs = mysqli_query($con, $strSql))
            return mysqli_insert_id($con);
        else
            return 0;
    }

    function sanitizeInput($con, $input){
        return mysqli_real_escape_string($con, stripslashes(htmlspecialchars( $input)));
    }


?>