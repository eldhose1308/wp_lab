<?php

$db = mysqli_connect('localhost', 'root', '', 'college');


$create_table_qry = 'CREATE TABLE IF NOT EXISTS `grocery` (
    `product_id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT,
    `product_name` varchar(50) NOT NULL,
    `brand` varchar(50) NOT NULL,
    `category` varchar(50) NOT NULL,
    `price` int(11) NOT NULL
  )';

$create_table = mysqli_query($db, $create_table_qry);

$err_msg = $succ_msg = '';



if (isset($_POST['add_grocery'])) {
    $product_name = $_POST['product_name'];
    $brand = $_POST['brand'];
    $category = $_POST['category'];
    $price = $_POST['price'];

    $err_msg .= (empty($product_name)) ? '<p>Please enter  product name</p>' : '';
    $err_msg .= (empty($brand)) ? '<p>Please enter  brand</p>' : '';
    $err_msg .= (empty($category)) ? '<p>Please enter  category</p>' : '';
    $err_msg .= (empty($price)) ? '<p>Please enter price</p>' : '';

    $err_msg .= (!is_numeric($price)) ? '<p>Please enter an integer value for price</p>' : '';

    if (strlen($err_msg) == 0) {
        $insert_grocery = "INSERT INTO grocery (product_name, brand,category, price) VALUES ('$product_name','$brand','$category','$price')";
        $insert_result = mysqli_query($db, $insert_grocery);

        if ($insert_result)
            $succ_msg = "<p>Successfully added grocery</p>";
        else
            $err_msg = "<p>Could not add grocery</p>";
    }
}


$grocerys_qry = "SELECT * from grocery";
$grocerys_records = mysqli_query($db, $grocerys_qry);



?>

<title>Grocery management</title>

<body>

    <center>
        <h3>Grocery management</h3>
    </center>

    <div class="container">

        <div>

            <button id="view_grocery" name="view_grocery" onclick="show_list()">View Grocery List</button>


            <table id="table_list" style="display: none;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Product name</th>
                        <th>Brand</th>
                        <th>Catgeory</th>
                        <th>Price</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 1;
                    while ($grocerys = mysqli_fetch_array($grocerys_records)) {
                    ?>
                        <tr>
                            <td><?= $i++ ?></td>
                            <td><?= $grocerys['product_name'] ?></td>
                            <td><?= $grocerys['brand'] ?></td>
                            <td><?= $grocerys['category'] ?></td>
                            <td><?= $grocerys['price'] ?></td>

                        </tr>
                    <?php }  ?>
                </tbody>
            </table>

        </div>


        <div>

            <div class="alert alert-error" id="error_message" style="display: none;">
            </div>

            <?php if (strlen($err_msg > 0)) : ?>


                <div class="alert alert-error">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <?= $err_msg ?>
                </div>




            <?php endif; ?>

            <?php if (strlen($succ_msg > 0)) : ?>


                <div class="alert alert-success">
                    <span class="closebtn" onclick="this.parentElement.style.display='none';">&times;</span>
                    <?= $succ_msg ?>
                </div>



            <?php endif; ?>



            <form method="post" onsubmit="return check_validation()">
                <label for="fname">Product name</label>
                <input type="text" id="product_name" name="product_name">



                <label for="lname">Brand</label>
                <input type="text" id="brand" name="brand">


                <label for="lname">Category</label>
                <input type="text" id="category" name="category">


                <label for="lname">Price</label>
                <input type="text" id="price" name="price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">




                <input type="submit" name="add_grocery" value="Add grocery">
            </form>
        </div>



    </div>
</body>

<script>
    function show_list() {
        var x = document.getElementById("table_list");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }

    }

    function check_validation() {
        var product_name = document.getElementById("product_name").value;
        var brand = document.getElementById("brand").value;
        var category = document.getElementById("category").value;
        var price = document.getElementById("price").value;


        var error_message = document.getElementById("error_message");

        var err_msg = "";
        if (product_name == "")
            err_msg += "<p>Product name cannot be empty</p>";

        if (brand == "")
            err_msg += "<p>Brand cannot be empty</p>";

        if (category == "")
            err_msg += "<p>Category cannot be empty</p>";

        if (price == "" || isNaN(price))
            err_msg += "<p>Product price cannot be empty and must be an integer</p>";

        if (err_msg.length == 0)
            return true;



        error_message.style.display = 'block';
        error_message.innerHTML = err_msg;
        return false;
    }
</script>


<style>
    table {
        border-collapse: collapse;
        width: 100%;
    }

    table td,
    table th {
        border: 1px solid #ddd;
        padding: 8px;
    }


    table th {
        padding-top: 12px;
        padding-bottom: 12px;
        text-align: left;
        background-color: #007bff;
        color: white;
    }



    input[type=text],
    input[type=date],
    input[type=time],
    textarea,
    select {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        display: inline-block;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    button[name=view_grocery] {
        width: 30%;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        background-color: #46a7f5 !important;
    }

    input[type=submit] {
        width: 30%;
        background-color: #4CAF50;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    input[type=submit]:hover {
        background-color: #45a049;
    }

    div {
        border-radius: 5px;
        background-color: #f2f2f2;
        padding: 20px;
    }

    .col-3 {
        width: 50%;
    }

    .alert {
        padding: 20px;
        background-color: #f44336;
        color: #fff;
        margin-bottom: 2%;
    }

    .alert-error {
        background-color: #f44336;
    }

    .alert-success {
        background-color: #2eb885;
    }

    .closebtn {
        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }
</style>