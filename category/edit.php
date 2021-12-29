<?php
require '../init.php';

if(!isset($_SESSION['user']))
{
  print_r($_SESSION['user']);
  setError(('Please Login in first'));
  go('login.php');
}

//update category
if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $slug = $_GET['slug'];
    $name = $_REQUEST['name'];
    query("update category set name = ? , slug = ? where slug = ?",[$name,slug($name),$slug]);
    go('index.php');
    
}

//check category
if(isset($_GET['slug'])){
    $slug = $_GET['slug'];
    $category = getOne("select * from category where slug = ? ",[$slug]);
    if(!$category)
    {
      setError('category not found');
    go('index.php');
    die();
    }      
}else
{
    setError('category not found');
    go('index.php');
    die();
}



require '../include/header.php';
?>

 <!-- Breadcamp -->
 <div class="container-fluid pr-5 pl-5">
    <div class="row mt-3">
      <div class="col-12">
        <span class="text-white">
          <h4 class="d-inline text-white"><a href="<?= $root.'category' ?>" style="color: white;">Category</a> </h4>
          > Edit
        </span>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container-fluid pr-5 pl-5 mt-3">
    <div class="card">
      <div class="card-body">
      <a href="<?= $root.'category/index.php' ?>"" class="btn btn-sm btn-success mb-2">All</a>
      <?php
        showError();
        showMsg();
      ?>
      <form action="" class="mt-3" method="POST">
      <div class="form-group">
        <label for="">Enter Name</label>
        <input type="text" value="<?= $category->name ?>" name="name" class="form-control">
      </div>
      <input type="submit" value="Update" class="btn btn-sm btn-warning">
      
      </form>
      </div>
    </div>
  </div>


<?php
require '../include/footer.php';

?>