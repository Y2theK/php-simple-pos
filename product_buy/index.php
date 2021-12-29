<?php
require '../init.php';
require '../include/header.php';

if(isset($_GET['action']))

{
  $id = $_GET['id'];
  $product_slug = $_GET['product_slug'];
  $product_buy_data = getOne("select * from product_buy where id=?",[$id]);
  $product_data = getOne("select * from product where slug=?",[$product_slug]);
  
  $total_quantity = $product_data->total_quantity - $product_buy_data->total_quantity;
  // echo($total_quantity);
  query("delete from product_buy where id=?",[$id]);
  query("update product set total_quantity=? where slug = ?",[$total_quantity,$product_slug]);
  setMsg("Product Buy Delete");
  go('index.php?product_slug='.$product_slug);
  die();
}
$product_slug = $_GET['product_slug'];
$product = getOne("select * from product where slug=?",[$product_slug]);
// die($product->id);
$buy = getAll("select * from product_buy where product_id=?",[$product->id]);

// print_r($buy);



?>
 <!-- Breadcamp -->
 <div class="container-fluid pr-5 pl-5">
    <div class="row mt-3">
      <div class="col-12">
        <span class="text-white">
          <h4 class="d-inline text-white">Product Buy</h4>
          > All
        </span>
      </div>
    </div>
  </div>

   <!-- Content -->
   <div class="container-fluid pr-5 pl-5 mt-3">
    <div class="card">
      <div class="card-body">
        <a href="create.php?product_slug=<?= $product_slug ?>" class="btn btn-warning  my-2">Create</a>
        <?php showMsg();
        showError(); ?>
         <table class="table table-striped text-white">
           <tr>
             <td>Buy Price</td>
             <td>Buy Quantity</td>
             <td>Buy Date</td>
             <td>Options</td>
           </tr>
           <?php foreach($buy as $b){ ?>
           <tr class="text-white">
            
              <td><?= $b->buy_price; ?></td>
              <td><?= $b->total_quantity; ?></td>
              <td><?= $b->buy_date; ?></td>
              <td><a href="index.php?action=delete&product_slug=<?= $product_slug ?>&id=<?= $b->id ?>" class="btn btn-danger btn-sm" onclick="confirm('Are you sure');"><span class="fa fa-trash"></span></a></td>

             <?php

             } ?>

           </tr>
         </table>
      </div>
    </div>
   </div> 


<?php
require '../include/footer.php';
?>