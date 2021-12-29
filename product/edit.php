<?php
require '../init.php';
if(!isset($_SESSION['user']))
{
  print_r($_SESSION['user']);
  setError(('Please Login in first'));
  go('login.php');
}

$category = getAll("select * from category");
if(isset($_GET['slug']) and !empty($_GET['slug']))
{
    $slug = $_GET['slug'];
   
    $product = getOne("select * from product where slug = '$slug'");
    if(!$product)
    {
        setError('Wrong slug');
         go('index.php');
        die();
    }
    
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $request = $_REQUEST;
        $name = $request['name'];
        $category_id = $request['category_id'];
        $sale_price = $request['sale_price'];
        $description = $request['description'];
        $file = $_FILES['image'];
        if(isset($file) and !empty($file['name']))
        {
          $file_limit_size = 1024*1024*1;   //1mb
          $file_size = $file['size'];
                  if($file_size > $file_limit_size)
                  {
                      setError("Image must be less than 1mb");
                  }
           //image upload
           $file_name = slug($file['name']);
           $file_path = "../image/".$file_name;
           $tmp = $file['tmp_name'];
           move_uploaded_file($tmp,$file_path);
           if(file_exists('../image/'.$product->image)){
             unlink('../image/'.$product->image); //file deleted
           }
        }
        else{
          $file_name = $product->image;

        }
             

              // update
              $sql = "
              update product set name='$name',category_id=$category_id,description='$description',image='$file_name',sale_price='$sale_price'
              where slug='$slug'
              ";
              // die($sql);
             $res =  query($sql);
             if($res)
             {
               setMsg("Update Successfully");
               go('edit.php?slug='.$product->slug);
               die();
             }else{
                 setError("Update failed");
              go('edit.php?slug='.$product->slug);
              die();
             }
              
    }
}
else{
    setError('Wrong slug');
    go('index.php');  //go() yae a paw mr html tag twy shi lox m ya
    die();
}



require '../include/header.php';
?>

 <!-- Breadcamp -->
 <div class="container-fluid pr-5 pl-5">
    <div class="row mt-3">
      <div class="col-12">
        <span class="text-white">
          <h4 class="d-inline text-white"><a href="<?= $root.'product' ?>" style="color: white;">Category</a> </h4>
          > Edit
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
       showMsg();
       
       ?>
      <form action="" class="mt-3 row text-warning" method="POST" enctype="multipart/form-data">
        <div class="col-12">
            <h4 class="text-white">Product Info</h4>
            <!-- name -->
            <div class="form-group"> 
            <label for="">Enter Name</label>
            <input type="text" name="name" class="form-control" value="<?= $product->name ?>">
            </div>
            <!-- category -->
            <div class="form-group"> 
            <label for="">Choose Category</label>
            <select name="category_id" id="" class="form-control">
            <?php
                foreach($category as $c){
                    $selected = $c->id == $product->category_id ? 'selected' : '';
                    echo "
                    <option value='{$c->id}' $selected>{$c->name}</option>
                    ";
                }
            ?>
            
            
            </select>
            </div>
            <!-- image -->
            <div class="form-group"> 
            <label for="">Choose Image</label>
            <input type="file" name="image" class="form-control">
            <img src="<?= $root.'/image/'.$product->image ?>" alt="" width="200px" class="img-thumbnail">
            </div>
            <!-- description -->
            <div class="form-group"> 
            <label for="">Enter Description</label>
            <textarea name="description" id="" cols="20" rows="5" class="form-control"><?= $product->description ?>
            </textarea>
            </div>
            <!-- Sale Price -->
            <div class="form-group"> 
            <label for="">Sale Price</label>
            <input type="number" name="sale_price" class="form-control" value="<?= $product->sale_price ?>">
            </div>
        </div>
        <div class="col-12">
        <input type="submit" name="submit" class="btn btn-warning" value="Update">   
        </div>

       
      
      </form>
            
      </div>
    </div>
  </div>


<?php
require '../include/footer.php';

?>