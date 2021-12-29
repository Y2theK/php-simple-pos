<?php
require '../init.php';


if(!isset($_SESSION['user']))
{
  print_r($_SESSION['user']);
  setError(('Please Login in first'));
  go('login.php');
}

if(isset($_GET['delete']))
{
  $slug = $_GET['slug'];
  query("delete from product where slug = ?",[$slug]);
  setMsg("Prdouct delete successfully");
  go('index.php');
  die();
}

if(isset($_GET['sale']) and !empty($_GET['sale']))
{
  $slug = $_GET['product_slug'];
  $product = getOne("select * from product where slug = ?",[$slug]);

  $date = date('Y-m-d');
  $product_id = $product->id;
  $sale_price = $product->sale_price;

  //total_qty 0 phit lae set descrease phit ny // sale ko why -1 always / it should ask how many cumst asked for
  $update_total_qty = $product->total_quantity - 1;
  query("update product set total_quantity = ? where slug = ?",[$update_total_qty,$slug]);
  query("insert into product_sale (product_id,sale_price,sale_date) values (?,?,?)",[$product_id,$sale_price,$date]);
  setMsg("Sale successfully");
  go('index.php');
  die();
 
}

if(isset($_GET['page']))
{
    paginationProduct(2);
    die();
}

if(isset($_GET['search']))
{
  $search = $_GET['search'];
  $product = getAll("select * from product where name like '%$search%' order by id desc limit 2 ");

}else{
  $search = '';
  $product = getAll('select * from product order by id desc limit 2 ');
}

require '../include/header.php';
?>

 <!-- Breadcamp -->
 <div class="container-fluid pr-5 pl-5">
    <div class="row mt-3">
      <div class="col-12">
        <span class="text-white">
          <h4 class="d-inline text-white">Product</h4>
          > All
        </span>
      </div>
    </div>
  </div>

  <!-- Content -->
  <div class="container-fluid pr-5 pl-5 mx-3">
    <div class="card">
      <div class="card-body">
      <a href="create.php" class="btn btn-sm btn-warning my-2">Create</a>
      <form action="" method="GET"  class="mx-2">
          <input type="text" name="search" value="<?= $search ?>" class="btn bg-white">
          <button type="submit" class="btn btn-primary"><span class="fa fa-search"></span></button>
         <?php
          if(!empty($search))
          {
            echo '<a href="index.php" class="btn btn-danger">Clear Search</a>';
          }
         ?>
      </form>
      <?php showMsg();
      showError();
      ?>
            <table class="table table-striped text-white mt-2">
            <thead>
                <tr>
                <th>Name</th>
                <th>Quantity</th>
                <th>Sale Price</th>
                <th>Options</th>
                </tr>
            
            </thead>
            <tbody id="tblData">
                <?php
                foreach($product as $p){

                ?>
                <tr>
                    <td><?= $p->name ?></td>
                    <td><?= $p->total_quantity ?></td>
                    <td><?= $p->sale_price ?></td>
                    <td>
                        <a href="detail.php?slug=<?= $p->slug ?>" class="btn btn-success btn-sm"><span class="fa fa-eye"></span></a>
                        <a href="edit.php?slug=<?= $p->slug ?>" class="btn btn-primary btn-sm"><span class="fa fa-edit"></span></a>
                        <a href="index.php?delete=true&slug=<?= $p->slug?>" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                        <a href="<?= $root."/product_buy/index.php?product_slug=".$p->slug ?>" class="btn btn-outline-success btn-sm"><span>Buy</span></a>
                        <a href="index.php?product_slug=<?= $p->slug ?>&sale=true" class="btn btn-outline-danger btn-sm"><span>Sale</span></a>
                        <a href="saleList.php?product_slug=<?= $p->slug ?>&sale=true" class="btn btn-info btn-sm"><span>Sale Histroy</span></a>
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
    var url = `index.php?page=${page}`;
    var search = "<?= $search ?>";
    if(search){
      url += `&search=${search}`;
    }
   

    $.get(url).then(function(data) {
      const d = JSON.parse(data);
      
      //data m shi tot yin fetch btn disable phit
      if(!d.length)
      {
        btnFetch.attr('disabled','disabled');
      }
      var htmlstring = "";
      d.map(function(d){
        console.log(d);
        htmlstring += `< <tr>
                    <td> ${d.name} </td>
                    <td> ${d.total_quantity} </td>
                    <td> ${d.sale_price} </td>
                    <td>
                        <a href="detail.php?slug=${d.slug}" class="btn btn-success btn-sm"><span class="fa fa-eye"></span></a>
                        <a href="edit.php?slug=${d.slug}" class="btn btn-primary btn-sm"><span class="fa fa-edit"></span></a>
                        <a href="index.php?delete=true&slug=${d.slug}" class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                        <a href="<?= $root."/product_buy/index.php?product_slug=" ?>${d.slug}" class="btn btn-outline-success btn-sm"><span>Buy</span></a>
                        <a href=index.php?product_slug=${d.slug}&sale=true" class="btn btn-outline-danger btn-sm"><span>Sale</span></a>
                        <a href="saleList.php?product_slug=${d.slug}&sale=true" class="btn btn-info btn-sm"><span>Sale Histroy</span></a>
                    </td>
                </tr>
        
        
        `;

      })
      tblData.append(htmlstring);
    })
  });
});
</script>
