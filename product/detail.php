<?php
require '../init.php';

if(isset($_GET['slug']) and !empty($_GET['slug']))
{
    $slug = $_GET['slug'];
    $product = getOne(
        "select product.*,category.name as category_name,
        (select count(id) from product_sale where product.id=product_sale.product_id) as sale_count
        from product
        left join category on category.id=product.category_id
        where product.slug='$slug';
        "
    );
    if(!$product){
        setError("Wrong slug");
        go('index.php');
        die();
    }
}else{
    setError("Wrong slug");
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
                    <h4 class="d-inline text-white"><a href="<?= $root.'product' ?>" style="color: white;">Product</a> </h4>
                    > Details
                </span>
            </div>
        </div>
    </div>

    <!-- Content -->
    <div class="container-fluid pr-5 pl-5 mt-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- image -->
                    <div class="col-3">
                        <img src="<?= $root.'/image/'.$product->image ?>"
                            class="img-thumbnail w-100" alt="">
                    </div>
                    <div class="col-9">
                        <div class="card bg-dark p-3">
                            <h4 class="text-white">ProducT Title</h4>
                            <div>
                                Category : <span class="badge bg-primary text-white"><?= $product->category_name ?></span>
                            </div>
                            <div class="rounded bg-primary p-3 mt-3 text-white">
                                <table class="table  text-white">
                                    <thead>
                                        <tr>
                                            <th>Sale Count</th>
                                            <th>Sale Price</th>
                                            <th>Remain Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?= $product->sale_count ?></td>
                                            <td><?= $product->sale_price ?></td>
                                            <td><?= $product->total_quantity ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="mt-2 bg-primary p-3">
                                <p class="text-white"><?= $product->description ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
require '../include/footer.php';
?>