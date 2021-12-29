<?php
require 'init.php';

if(!isset($_SESSION['user']))
{
  print_r($_SESSION['user']);
  setError(('Please Login in first'));
  go('login.php');
}
require 'include/header.php';

$date = date('Y-m-d');
$total_sale_price = getOne("select sum(sale_price) as total_sale from product_sale where sale_date = ? ",[$date])->total_sale;
$total_buy_price = getOne("select sum(buy_price) as total_buy from product_buy where buy_date=?",[$date])->total_buy;
$total_net_price = $total_sale_price - $total_buy_price;

$latest_sale = getAll(
  "
  select product_sale.*,product.name as product_name from product_sale 
  left join product on product.id=product_sale.product_id
  where product_sale.sale_date = ?
  order by id desc 
  limit 5
  ",
  [$date]
);


$latest_buy = getAll(
  "
  select product_buy.*,product.name as product_name from product_buy
  left join product on product.id=product_buy.product_id
  where product_buy.buy_date = ?
  order by id desc 
  limit 5
",
[$date]);
// print_r($latest_buy);




?>


<!-- dashboard -->
<div class="card my-3 mx-5">
    <div class="row">
      <div class="col-4">
        <div class="card m-3">
          <div class="card-body bg-success text-center">
            <h4 class="text-light">Total Sale</h3>
            <div class=" btn btn-sm btn-danger"><?= $total_sale_price; ?></div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card m-3">
          <div class="card-body bg-warning text-center">
            <h4 class="text-light">Total Buy</h3>
            <div class=" btn btn-sm btn-danger"><?= $total_buy_price; ?></div>
          </div>
        </div>
      </div>
      <div class="col-4">
        <div class="card m-3">
          <div class="card-body bg-info text-center">
            <h4 class="text-light">Net Income</h3>
            <div class=" btn btn-sm btn-danger"><?= $total_net_price; ?></div>
          </div>
        </div>
      </div>
      
    </div>
    <hr class="bg-white">
    <div class="row">
      <div class="col-6">
        <h4 class="text-info ml-3">Lastest Sale List</h4>
        
        
        <table class="table table-striped text-white">
          <tr>
            <td>Product Name</td>
            <td>Sale Price</td>
            
          </tr>
          <?php foreach($latest_sale as $sale): ?>
            <tr>
              <td><?= $sale->product_name; ?></td>
              <td><?= $sale->sale_price ?></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
      <div class="col-6">
        <h4 class="text-warning ml-3">Lastest Buy List</h4>
        <table class="table table-striped text-white"> 
          <tr>
            <td>Product Name</td>
            <td>Buy Price</td>
            <td>Total Quantity</td>
          </tr>
          <?php foreach($latest_buy as $buy): ?>
              <tr>
                <td><?= $buy->product_name ?></td>
                <td><?= $buy->buy_price ?></td>
                <td><?= $buy->total_quantity ?></td>

              </tr>
          <?php endforeach; ?>


        </table>
      </div>
    </div>
  </div>


<?php
require 'include/footer.php';

?>