<?php
require '../init.php';
require '../include/header.php';

if(isset($_GET['delete']) )
{
    //product total_quantity ko pyn paung
    $product_slug = $_GET['product_slug'];
    $sale_id = $_GET['id'];
    $product_id = getOne("select product_id from product_sale where id=?",[$sale_id])->product_id;
    query("update product set total_quantity=total_quantity+1 where id=?",[$product_id]);
    //product_sale ko delete
    query("delete from product_sale where id=?",[$sale_id]);
    setMsg("Sale delete Successfully");
    go('saleList.php?product_slug='.$product_slug);
    
}
if(isset($_GET['product_slug']) and !empty($_GET['product_slug']))
{
    $slug = $_GET['product_slug'];
    $product = getOne("select * from product where slug = ?",[$slug]);
    $sale = getAll("select * from product_sale where product_id = ?",[$product->id]);
    // print_r($sale);
}


?>
 <!-- Breadcamp -->
 <div class="container-fluid pr-5 pl-5">
    <div class="row mt-3">
      <div class="col-12">
        <span class="text-white">
          <h4 class="d-inline text-white"><a href="<?= $root.'product' ?>" style="color: white;">Product > </a> </h4>
          <span class="text-dark"><?= $product->name; ?></span>
          > Sale List
        </span>
      </div>
    </div>
  </div>
   <!-- Content -->
   <div class="container-fluid pr-5 pl-5 m-3">
    <div class="card  ">
      <div class="card-body">
          <?php showError();
          showMsg(); ?>
          <table class="table table-striped text-white">
              <tr>
                  <td>Sale Price</td>
                  <td>Date</td>
                  <td>Options</td>
              </tr>
              
              <?php foreach($sale as $s): ?>
                <tr>
                <td><?= $s->sale_price ?></td>
                <td><?= $s->sale_date ?></td>
                <td><a href="saleList.php?delete=true&id=<?= $s->id ?>&product_slug=<?= $slug ?>" onclick="confirm('Sure');" class="btn btn-sm btn-danger"><span class="fa fa-trash"></span></a></td>
                </tr>
              <?php endforeach; ?>
                  
             
          </table>
      </div>
    </div>
   </div>
<?php
require '../include/footer.php';

?>