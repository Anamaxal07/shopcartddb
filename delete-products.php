<?php require_once("header-nav.php");?>
<?php
    session_start();

	if(isset($_GET['k'])){
		$_SESSION['k'] = $_GET['k'];
	}

    $con = openConn();
    $strSql= "SELECT * FROM tbl_products WHERE id = ".$_SESSION['k'];


   	if($rsProducts = mysqli_query($con, $strSql)){
        if(mysqli_num_rows($rsProducts) > 0){
           ($recProducts = mysqli_fetch_array($rsProducts));
               mysqli_free_result($rsProducts);
               }
		else{
            echo '<tr>';
                echo '<td 	No Record Found!</td>';
            echo '</tr>';
                }

   	}

   	else{
   		echo 'ERROR: Could not execute your request.';
   	}
       closeConn($con); 

    if(isset($_POST['btnDelete'])){
        $con = openConn();
        $name = sanitizeInput($con, $_POST['txtName']);
        $description = sanitizeInput($con, $_POST['txtDescription']);
        $price = $_POST['txtPrice'];

        $err = [];


        if(empty($name))
            $err[] = "Last name is required!";
        if(empty($description))
            $err[] = "Description is required!";
        if(empty($price))
            $err[] = "Price is required!";

            if(empty($err)){
                    $strSql = "
                                DELETE FROM tbl_products
                                WHERE id = ".$_SESSION['k'];
                if(mysqli_query($con, $strSql))
                    header('location:delete-success-products.php');

                else
                    echo 'ERROR: Failed to Delete Record!';

            }
        closeConn($con); 
    }

?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"> <i class="fa fa-trash"></i> Are you sure you want do delete this Product??</h1>
                </div> 
                <form method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label for="txtName" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="txtName" value="<?php echo (isset($recProducts['name']) ? $recProducts['name'] : ''); ?>" id="txtName" required>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="txtDescription" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="txtDescription" value="<?php echo (isset($recProducts['description']) ? $recProducts['description'] : ''); ?>"id="txtDescription" required>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="txtPrice" class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="txtPrice" value="<?php echo (isset($recProducts['price']) ? $recProducts['price'] : ''); ?>" id="txtPrice" required>
                                </div>
                        </div>
                        <!--<div class="form-group row">
                            <label for="filImageOne" class="col-sm-2 col-form-label"> Photo 1</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="filImageOne" value=""id="filImageOne">
                                </div>
                        </div>-->
                        <!--<div class="form-group row">
                            <label for="filImageTwo" class="col-sm-2 col-form-label"> Photo 2</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="filImageTwo" id="filImageTwo" required>
                                </div>
                        </div>-->
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" name="btnDelete" class="btn btn-danger  "><i class="fa fa-edit"></i> Delete Record</button>
                                <a href="products.php" class="btn btn-primary  ">Cancel/Go back</a>
                            </div>
                        </div>

                </form>
                <br><br>
            </main>
        </div>
    </div>       
<?php require_once("footer.php");?>