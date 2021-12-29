<?php
require '../init.php';
require '../include/header.php';
$product_slug = $_GET['product_slug'];
$product = getOne("select id,total_quantity from product where slug = ?",[$product_slug]);
// print_r($product->id);  
if($_SERVER['REQUEST_METHOD'] == "POST"){
  $req = $_REQUEST;
  $buy_price = $req['buy_price'];
  $total_quantity = $req['total_quantity'];
  $buy_date = $req['buy_date'];
  query(
  "insert into product_buy (product_id,buy_price,total_quantity,buy_date) values (?,?,?,?)",
  [$product->id,$buy_price,$total_quantity,$buy_date]
  );
  $total_quantity = $total_quantity + $product->total_quantity;
  query("update product set total_quantity = $total_quantity where slug='$product_slug'");
  setMsg("Product Buy added");
  go('create.php?product_slug='.$product_slug);
  die();
}

?>
 <!-- Breadcamp -->
 <div class="container-fluid pr-5 pl-5">
    <div class="row mt-3">
      <div class="col-12">
        <span class="text-white">
          <h4 class="d-inline text-white">Product Buy</h4>
          > Create
        </span>
      </div>
    </div>
  </div>

   <!-- Content -->
   <div class="container-fluid pr-5 pl-5 mt-3">
    <div class="card">
      <div class="card-body">
        <?php
          showMsg();
        ?>
          <form action="" method="POST">
              <div class="form-group">
              <label for="">Enter Buy Price</label>
              <input type="number" class="form-control" name="buy_price">

              </div>
              <div class="form-group">
                  <label for="">Enter Total Quantity</label>
                  <input type="number" class="form-control" name="total_quantity">
                
              </div>
              <div class="form-group">
                  <label for="">Enter Buy Date</label>
                  <input type="date" class="form-control" name="buy_date" value="<?= Date('Y-m-d');  ?>">
              </div>
              <input type="submit" name="submit" value="Create" class="btn btn-warning">
             
          </form>
      </div>
    </div>
   </div> 


<?php
require '../include/footer.php';
?>