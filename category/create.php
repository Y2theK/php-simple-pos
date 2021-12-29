<?php
require '../init.php';

if(!isset($_SESSION['user']))
{
  print_r($_SESSION['user']);
  setError(('Please Login in first'));
  go('login.php');
}

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $name = $_REQUEST['name'];
    if(empty($name))
    {
        setError("Please Enter Name");
    }
    if(!hasError()){
        $res = query("insert into category (slug,name) values (?,?)",[slug($name),$name]);
        if($res){
            setMsg("Category Created Successfully");
        }
    }
}

require '../include/header.php';
?>

 <!-- Breadcamp -->
 <div class="container-fluid pr-5 pl-5">
    <div class="row mt-3">
      <div class="col-12">
        <span class="text-white">
          <h4 class="d-inline text-white"><a href="<?= $root.'category' ?>" style="color: white;">Category</a> </h4>
          > Create
        </span>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container-fluid pr-5 pl-5 mt-3">
    <div class="card">
      <div class="card-body">
      <a href="create.php" class="btn btn-sm btn-success mb-2">All</a>
      <?php
        showError();
        showMsg();
      ?>
      <form action="" class="mt-3" method="POST">
      <div class="form-group">
        <label for="">Enter Name</label>
        <input type="text" name="name" class="form-control">
      </div>
      <input type="submit" value="create" class="btn btn-sm btn-warning">
      
      </form>
            
      </div>
    </div>
  </div>


<?php
require '../include/footer.php';

?>