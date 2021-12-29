<?php
require '../init.php';
if(!isset($_SESSION['user']))
{
  print_r($_SESSION['user']);
  setError(('Please Login in first'));
  go('login.php');
}

$category = getAll("select * from category");


if($_SERVER['REQUEST_METHOD'] == "POST")
{
   $category_id = $_REQUEST['category_id'];
    $slug = slug($_REQUEST['name']);
    $name = $_REQUEST['name'];
    $description = $_REQUEST['description'];

    $total_quantity = $_REQUEST['total_quantity'];
    $sale_price = $_REQUEST['sale_price'];
    $buy_price = $_REQUEST['buy_price'];
    $buy_date = $_REQUEST['buy_date'];
    print_r($_REQUEST);
    //validation image
    $file = $_FILES['image'];
    if(empty($file['name'])){
        setError("Please Choose Image");
    }
    else{
    //check image size
    //echo $file['size']; // byte nae output py (1024byte = 1kb , 1024kb = 1mb)
    $file_limit_size = 1024*1024*1;   //1mb
    $file_size = $file['size'];
        if($file_size > $file_limit_size)
        {
            setError("Image must be less than 1mb");
        }
    }
    //image upload
    $file_name = slug($file['name']);
    $file_path = "../image/".$file_name;
    $tmp = $file['tmp_name'];
    move_uploaded_file($tmp,$file_path);

    //save to product
    query(
      'insert into product(category_id,slug,name,description,image,total_quantity,sale_price) values(?,?,?,?,?,?,?)',
      [$category_id,$slug,$name,$description,$file_name,$total_quantity,$sale_price]
    );

    $product_id = $con->lastInsertId();
    echo $product_id;
    query(
      'insert into product_buy(product_id,buy_price,total_quantity,buy_date) values (?,?,?,?)',
      [$product_id,$buy_price,$total_quantity,$buy_date]
    );
    setMsg('Product Created Successfully');
    go('index.php');




    //save to product buy


    //file upload
    

}
require '../include/header.php';
?>

 <!-- Breadcamp -->
 <div class="container-fluid pr-5 pl-5">
    <div class="row mt-3">
      <div class="col-12">
        <span class="text-white">
          <h4 class="d-inline text-white"><a href="<?= $root.'product' ?>" style="color: white;">Product</a> </h4>
          > Create
        </span>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container-fluid pr-5 pl-5 mt-3">
    <div class="card">
      <div class="card-body">
      <a href="index.php" class="btn btn-sm btn-success mb-2">All</a>
       <?php 
       showError();
       //showMsg();
       
       ?>
      <form action="" class="mt-3 row text-warning" method="POST" enctype="multipart/form-data">
        <div class="col-6">
            <h4 class="text-white">Product Info</h4>
            <!-- name -->
            <div class="form-group"> 
            <label for="">Enter Name</label>
            <input type="text" name="name" class="form-control">
            </div>
            <!-- category -->
            <div class="form-group"> 
            <label for="">Choose Category</label>
            <select name="category_id" id="" class="form-control">
            <?php
                foreach($category as $c){
                    echo "
                    <option value='{$c->id}'>{$c->name}</option>
                    ";
                }
            ?>
            
            
            </select>
            </div>
            <!-- image -->
            <div class="form-group"> 
            <label for="">Choose Image</label>
            <input type="file" name="image" class="form-control">
            </div>
            <!-- description -->
            <div class="form-group"> 
            <label for="">Enter Description</label>
            <textarea name="description" id="" cols="30" rows="5" class="form-control"></textarea>
            </div>
        </div>
        <!-- product inventory -->
        <div class="col-6">
            <h4 class="text-white">Inventory</h4>
            <!-- sale info -->
            <span class="text-primary">
            <span class="fas fa-info-circle text-primary"></span>
            For sale info
            </span>
           <!-- Sale Price -->
            <div class="form-group"> 
            <label for="">Sale Price</label>
            <input type="number" name="sale_price" class="form-control">
            </div>

            <!-- buy info -->
            <span class="text-primary">
            <span class="fas fa-info-circle text-primary"></span>
            For buy info
            </span>
            </span>
             <!-- total quantity -->
             <div class="form-group"> 
            <label for="">Enter Total Quantity</label>
            <input type="number" name="total_quantity" class="form-control">
            </div>
           <!-- buy Price -->
            <div class="form-group"> 
            <label for="">Buy Price</label>
            <input type="number" name="buy_price" class="form-control">
            </div>

            
            <!-- buy date-->
            <div class="form-group"> 
            <label for="">Buy date</label>
            <input type="date" name="buy_date" class="form-control" value="<?= date('Y-m-d') ?>">
            </div>
            </div>
            <div class="col-12">
            <input type="submit" name="submit" class="btn btn-warning" value="Create">   
            </div>

      
      </form>
            
      </div>
    </div>
  </div>


<?php
require '../include/footer.php';

?>