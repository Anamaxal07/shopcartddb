<?php require("functions.php");?>
<?php
        $con = openConn();
        $strSql = "SELECT * FROM tbl_products";
        $products = getRecord($con, $strSql);

        closeConn($con);                  
?>