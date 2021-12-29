<?php
require '../init.php';
require '../include/header.php';
if(!isset($_SESSION['user']))
{
  print_r($_SESSION['user']);
  setError(('Please Login in first'));
  go('login.php');
}

$user = $_SESSION['user'];

//user and email update
if(isset($_POST['update']))
{
  $email = $_POST['email'];
      $name = $_POST['name'];
    if(!empty($email) and !empty($name))
    {
      $email = $_POST['email'];
      $name = $_POST['name'];
      query("update users set email = ?,name = ?,slug = ? where id = ?",[$email,$name,slug($name),$user->id]);
      setMsg("User Update successfully");
   
      $user->email = $email;
      $user->name = $name;
      go('index.php');
      die();
    }
    else
    {
      setError("Empty field exixt");
    }
    
    
    
}
if(isset($_POST['updatePassword']))
{
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    // print_r($user->passward);

    // verify db password and old password
    $ver = password_verify($old_password,$user->passward);
   
    if(!$ver)
    {
      setError("Old Password Incorrect");
    }
    else{
      if(!empty($new_password))
      {
        if($new_password != $confirm_password)
        {
          setError("Rewrite your new password");
        }
      }
      else
      {
        setError("Your passward is empty");
      }
     
      
    }
    if(!hasError())
      {
        
        //password hash and update
        $new_hash = password_hash($new_password,PASSWORD_BCRYPT);
        print_r($new_hash);
        query("update users set passward = ? where id = ?",[$new_hash,$user->id]);
        setMsg("Password updated successfully");
        $user->passward = $new_hash;
        go('index.php');
        die();



      }
}

?>
<!-- Breadcamp -->
<div class="container-fluid pr-5 pl-5">
    <div class="row mt-3">
      <div class="col-12">
        <span class="text-white">
          <h4 class="d-inline text-white"><a href="<?= $root ?>" style="color: white;">Manage Account</a> </h4>
          > All
        </span>
      </div>
    </div>
  </div>

<!-- Content -->
<div class="container-fluid pr-5 pl-5 m-3 ">
    <div class="card">
      <div class="card-body text-white">
          <?php 
          showMsg();
          showError();
          
            ?>
          <form action="" method="POST">
              <div class="form-group">
                 <label for="">Email</label>
                 <input type="text" class="form-control" name="email" value="<?= $user->email ?>">
              </div>
              <div class="form-group">
                 <label for="">Name</label>
                 <input type="text" class="form-control" name="name" value="<?= $user->name ?>">
              </div>
              <input type="submit" name="update" value="Update" class="btn btn-warning">
              <a href="index.php?updPasswordBtn=true" class="btn btn-danger">Update Password</a>
          </form>
      </div>
    </div>
    <?php if(isset($_GET['updPasswordBtn'])):   ?>
        <div class="card">
    <?php else: ?>
        <div class="card" hidden>
    
    <?php endif ?>
    
    
   
   
      <div class="card-body text-white">
          <?php 
          showMsg();
          showError();
          
            ?>
          <form action="" method="POST">
              <div class="form-group">
                  <label for="">Old Password</label>
                  <input type="text" name="old_password" class="form-control">
              </div>
              <div class="form-group">
                  <label for="">New Password</label>
                  <input type="text" name="new_password" class="form-control">
              </div>
              <div class="form-group">
                  <label for="">Confirm Password</label>
                  <input type="text" name="confirm_password" class="form-control">
              </div>
              <input type="submit" name="updatePassword" id="" value="Update" class="btn btn-warning">
          </form>
      </div>
    </div>
</div>
</div>
<?php
require '../include/footer.php';