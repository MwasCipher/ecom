<?php
function redirect($location)
{
    header("Location: $location");
}

function query($sql)
{
    global $connection;
    return mysqli_query($connection, $sql);
}

function confirm($result)
{

    global $connection;
    if (!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}

function set_message(){
    if(!empty($msg)){
        $_SESSION['message'] = $msg;
    }else{
        $msg = "";
    }
}

if (isset($_SESSION['message'])){

    echo $_SESSION['message'];
    unset($_SESSION['message']);
}

function escape_string($string)
{
    global $connection;

    return mysqli_real_escape_string($connection, $string);


}

function fetch_array($result)
{
    return mysqli_fetch_array($result);
}

function get_products()
{
    $query = query("SELECT * FROM products");
    confirm($query);

    while ($row = fetch_array($query)) {
        $product = <<<DELIMETER
     
  <div class="col-sm-4 col-lg-4 col-md-4">
                        <div class="thumbnail">
                           <a href="item.php?id={$row['product_id']}"> <img src="{$row['product_image']}" alt=""> </a> 
                            <div class="caption">
                                <h4 class="pull-right">&#36;{$row['product_price']}</h4>
                                <h4><a href="product.html">{$row['product_title']}</a>
                                </h4>
                                <p>See more snippets like this online store item at <a target="_blank" href="http://www.bootsnipp.com">Bootsnipp - http://bootsnipp.com</a>.</p>
                                <a class="btn btn-primary" target="_blank" href="item.php?id={$row['product_id']}">Add to Cart</a>
                            </div>

                        </div>
                    </div>


DELIMETER;
        echo $product;

    }
}

function get_categories()
{

    $query = query("SELECT * FROM categories");
    confirm($query);


    while ($row = fetch_array($query)) {

        $category_links = <<<DELIMETER
        <a href='category.php?id={$row['cat_id']}' class='list-group-item'> {$row['cat_title']} </a>

DELIMETER;

        
        echo $category_links;

    }


}


function get_products_in_cat_page()
{

$query = query("SELECT * FROM products WHERE product_category_id = " . escape_string($_GET['id']) . " ");
    confirm($query);


    while ($row = fetch_array($query)) {

        $product = <<<DELIMETER
        
        <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="http://placehold.it/800x500" alt="">
                    <div class="caption">
                        <h3>Feature Label</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="#" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>

DELIMETER;


        echo $product;

    }


}

function get_products_in_shop()
{

    $query = query("SELECT * FROM products");
    confirm($query);


    while ($row = fetch_array($query)) {

        $product = <<<DELIMETER
        
        <div class="col-md-3 col-sm-6 hero-feature">
                <div class="thumbnail">
                    <img src="http://placehold.it/800x500" alt="">
                    <div class="caption">
                        <h3>Feature Label</h3>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                        <p>
                            <a href="#" class="btn btn-primary">Buy Now!</a> <a href="#" class="btn btn-default">More Info</a>
                        </p>
                    </div>
                </div>
            </div>

DELIMETER;


        echo $product;

    }


}


function login_user(){

if (isset($_POST['submit'])){
    $username = escape_string($_POST['user_name']);
    $password = escape_string($_POST['password']);

    $validate_query = query("SELECT * FROM users WHERE user_name = '{$username}' AND password = '{$password}'");
    confirm($validate_query);

if (mysqli_num_rows($validate_query) ==  0){
    set_message("Your Password or Username is Invalid ");
        redirect("admin");

    }else {redirect("login.php");}




}


}

?>