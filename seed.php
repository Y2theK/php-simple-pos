<?php
require 'init.php';

// users seed
query('delete from users');
query('alter table users auto_increment=1');
// print_r(getOne("select * from users where email = ?",['userone@one.com']));
query("insert into users(slug,name,email,passward) values(?,?,?,?)",[slug('slug'),'admin','admin@a.com',password_hash('admin',PASSWORD_BCRYPT)]);
echo "user seed success";
//category seed 
query('delete from category');
query('alter table category auto_increment=1');

$cat = ['food','cake','juice','drink'];
foreach($cat as $c)
{
    
    query('insert into category (slug,name) values (?,?)',
    [slug($c),$c]
    );
}
echo 'success category';

//seeed product
query('delete from product');
query('alter table product auto_increment=1');
$product = [
    ['category_id'=>1,'name'=>'Harry','slug'=>slug('Harry'),'image'=>'image','description'=>'desr','total_quantity'=>2,'sale_price'=>1250],
    ['category_id'=>3,'name'=>'Jennie','slug'=>slug('Jennie'),'image'=>'image','description'=>'desr','total_quantity'=>2,'sale_price'=>1250],
    ['category_id'=>2,'name'=>'Eminem','slug'=>slug('Eminem'),'image'=>'image','description'=>'desr','total_quantity'=>2,'sale_price'=>1250],
    ['category_id'=>4,'name'=>'Y2K','slug'=>slug('Y2K'),'image'=>'image','description'=>'desr','total_quantity'=>2,'sale_price'=>1250],
    
];
foreach($product as $p)
{
    query(
         "
         insert into product (category_id,name,slug,image,description,total_quantity,sale_price) values(
         '{$p['category_id']}','{$p['name']}','{$p['slug']}','{$p['image']}','{$p['description']}','{$p['total_quantity']}','{$p['sale_price']}')
             "
         );
}

// seed product_sale
query("delete from product_sale");
query('alter table product_sale auto_increment=1');
// seed product_buy
query("delete from product_buy");
query('alter table product_buy auto_increment=1');
echo 'product seed';


?>