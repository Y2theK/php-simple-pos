<?php
require '../init.php';

if(!isset($_SESSION['user']))
{
  print_r($_SESSION['user']);
  setError(('Please Login in first'));
  go('login.php');
}

//page pagination
if(isset($_GET['page']))
{
  paginationCategory(2);
  die();
}

//delete
if(isset($_GET['action']))
{
  $slug = $_GET['slug'];
  query("delete from category where slug = ?",[$slug]);
  setMsg("Delete Successfully");
}

$category = getAll("select * from category order by id desc limit 2");


require '../include/header.php';
?>

 <!-- Breadcamp -->
 <div class="container-fluid pr-5 pl-5">
    <div class="row mt-3">
      <div class="col-12">
        <span class="text-white">
          <h4 class="d-inline text-white">Category</h4>
          > All
        </span>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container-fluid pr-5 pl-5 mt-3">
    <div class="card">
      <div class="card-body">
      <a href="create.php" class="btn btn-sm btn-warning my-2">Create</a>
      <?php showMsg();
      showError();
      ?>
            <table class="table table-striped text-white mt-2">
            <thead>
                <tr>
                <th>Name</th>
                <th>Options</th>
                </tr>
            
            </thead>
            <tbody id="tblData">
              <?php
                  foreach($category as $c){ ?>
              <tr>
              <td><?= $c->name ?></td>
              <td>
            <a href="<?= $root.'category/edit.php?slug='.$c->slug ?>" class="btn btn-sm btn-primary">
            <span class="fas fa-edit"></span>
            </a>
            <a onclick="return confirm('Are you sure to delete?')" href="<?= $root.'category/index.php?action=delete&slug='.$c->slug ?>" class="btn btn-sm btn-danger">
            <span class="fa fa-trash"></span>
            </a>
              </td>
              </tr>

              <?php
                  }
              ?>

           
            
            </tbody>
            
            </table>
            <div class="text-center">
            <button class="btn btn-warning btn-sm" id="btnFetch">
            <span class="fas fa-arrow-down"></span>
            
            </button>
            </div>
      </div>
    </div>
  </div>


<?php
require '../include/footer.php';

?>
<script>

$(function(){
  var page = 1;
  var tblData = $('#tblData');
  var btnFetch = $('#btnFetch');
  btnFetch.click(function(){
    page += 1;
    $.get(`index.php?page=${page}`).then(function(data) {
      const d = JSON.parse(data);
      
      //data m shi tot yin fetch btn disable phit
      if(!d.length)
      {
        btnFetch.attr('disabled','disabled');
      }
      var htmlstring = "";
      d.map(function(d){
        // console.log(d);
        htmlstring += `<tr>
              <td>${d.name}</td>
              <td>
            <a href="edit.php?slug=${d.slug}" class="btn btn-sm btn-primary">
            <span class="fas fa-edit"></span>
            </a>
            <a onclick="return confirm('Are you sure to delete?')" href="index.php?slug=${d.slug}" class="btn btn-sm btn-danger">
            <span class="fa fa-trash"></span>
            </a>
              </td>
              </tr>
        
        
        `;

      })
      tblData.append(htmlstring);
    })
  });
});
</script>