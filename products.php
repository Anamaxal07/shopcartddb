<?php
    session_start();
    $_SESSION['CURR_PAGE'] = 'products';
?>
<?php require_once("header-nav.php");?>
<?php

    if(isset($_POST['btnAdd']) && isset($_FILES['filImageOne']) && isset($_FILES['filImageTwo'])){
        $con = openConn();
        $name = sanitizeInput($con, $_POST['txtName']);
        $description = sanitizeInput($con, $_POST['txtDescription']);
        $price = $_POST['txtPrice'];

        $err = [];
        //for image 1
        $fileName = $_FILES['filImageOne']['name'];
        $fileSize = $_FILES['filImageOne']['size'];
        $fileTemp = $_FILES['filImageOne']['tmp_name'];
        $fileType = $_FILES['filImageOne']['type'];

        $fileExtTemp = explode('.', $fileName); //array
        $fileExt = strtolower(end( $fileExtTemp));

        //for image 2
        $fileNameTwo = $_FILES['filImageTwo']['name'];
        $fileSizeTwo = $_FILES['filImageTwo']['size'];
        $fileTempTwo = $_FILES['filImageTwo']['tmp_name'];
        $fileTypeTwo = $_FILES['filImageTwo']['type'];

        $fileExtTempTwo = explode('.', $fileNameTwo); //array
        $fileExtTwo = strtolower(end( $fileExtTempTwo));

        $allowed = array('jpeg', 'jpg', 'png');

    
        $uploadDir = 'uploads/' . $fileName;
        $uploadDirTwo = 'uploads/' . $fileNameTwo;

        if (in_array($fileExt, $allowed) === false && in_array($fileExtTwo, $allowed) === false)
            $err[] = "Extension file is not allowed";
        if ($fileSize > 5000000 && $fileSizeTwo > 5000000 )
            $err[] = "File Should be 5mb Maximum";
        if(empty($name))
            $err[] = "Last name is required!";
        if(empty($description))
            $err[] = "Description is required!";
        if(empty($price))
            $err[] = "Price is required!";

        if(empty($err)){
                $strSql ="
                        INSERT INTO tbl_products(name, description, price, photo1, photo2)
                        VALUES('$name', '$description', '$price', '$fileName', '$fileNameTwo')
                    ";
                    /*$strSql ="
                        INSERT INTO tblproducts(name, description)
                        VALUES('$name', '$description')
                    ";*/

                if(mysqli_query($con, $strSql)){
                    move_uploaded_file($fileTemp , $uploadDir);
                    move_uploaded_file($fileTempTwo , $uploadDirTwo);
                    header("location:add-success-products.php ");
                }          
                else
                    echo 'Error: Failed to insert record';
           
        }
        closeConn($con); 
    }

?>
            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2"> <i class="fa-brands fa-plus"></i> Add Products</h1>
                </div> 
                <form method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label for="txtName" class="col-sm-2 col-form-label">Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="txtName" id="txtName" required>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="txtDescription" class="col-sm-2 col-form-label">Description</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" name="txtDescription" id="txtDescription" required>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="txtPrice" class="col-sm-2 col-form-label">Price</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" name="txtPrice" id="txtPrice" required>
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="filImageOne" class="col-sm-2 col-form-label"> Photo 1</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="filImageOne" id="filImageOne">
                                </div>
                        </div>
                        <div class="form-group row">
                            <label for="filImageTwo" class="col-sm-2 col-form-label"> Photo 2</label>
                                <div class="col-sm-10">
                                    <input type="file" class="form-control" name="filImageTwo" id="filImageTwo" required>
                                </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-10">
                                <button type="submit" name="btnAdd" class="btn btn-primary  "><i class="fa fa-plus"></i> Add New Record</button>
                            </div>
                        </div>

                </form>
                <br><br>
                <h3> <i class="fa fa-table"></i>Products List</h1>
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Photo</th>
                                    <th colspan="2" >Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    $con = openConn();
                                    $strSql = "SELECT * FROM tbl_products";
                                    $recProducts = getRecord($con, $strSql);

                                    if(!empty($recProducts)){
                                        foreach ($recProducts as $key => $value) {
                                        echo '<tr>';
                                            echo '<td>' . $value['name'] .'</td>';
                                            echo '<td>' . $value['description'] .'</td>';
                                            echo '<td>' . $value['price'] .'</td>';
                                            echo '<td><img src="uploads/'. $value['photo1'] .'" style="height: 50px;"></td>';
                                            echo '<td>'; 
                                                echo '<a href="edit-products.php?k=' . $value['id'] .'" class="btn btn-success"><i class="fa fa-edit"></i>Edit</a> ';
                                                echo '<a href="delete-products.php?k=' . $value['id'] .'" class="btn btn-danger"><i class="fa fa-trash"></i>Remove</a>';
                                            echo '</td>';
                                        echo '</tr>';                       
                                        }
                                    }
                                    else{
                                        echo '<tr>';
                                            echo '<td colspan="5" class="text-center"> No Records found</td>';
                                            echo '</tr>';
                                    }
                                    closeConn($con);                  
                                ?>
                                
                            </tbody>
                        </table>
                    </div>      
            </main>
        </div>
    </div>       
<?php require_once("footer.php");?>