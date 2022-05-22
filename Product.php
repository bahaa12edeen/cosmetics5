<?php
include_once 'connect.php';
$pro_id= $_GET["pro_id"];
if(isset($_GET["id"])){
    $id= $_GET["id"];
}

$query= "SELECT * FROM products INNER JOIN categories WHERE products.category_id = categories.category_id AND id='$pro_id';";
$result= mysqli_query($conn, $query);
$row=  mysqli_fetch_assoc($result);

if(isset($_POST["submitrev"])){
    if(isset($_GET["id"])){
        $com= $_POST["comment"];
        $query= "INSERT INTO comments(comment, product_id, user_id) VALUES ('$com', '$pro_id', '$id');";
        $result= mysqli_query($conn, $query);
    }
    else{
        header ("location: login.php");
    }
}
if(isset($_GET["add"])){
    addToCart($conn, $pro_id, $id);
}
function addToCart($conn, $pro_id, $id){
    if(isset($_GET["id"])){
            $query2= "SELECT * FROM cart WHERE product_id=$pro_id AND user_id=$id;";
            $result2= mysqli_query($conn, $query2);
            $resultcheck = mysqli_num_rows($result2);
            $row3 = mysqli_fetch_assoc($result2);
                if($resultcheck > 0)
                {
                    $increase= $row3['quantity'] + 1;
                    $query4= "UPDATE cart SET quantity= $increase WHERE product_id=$pro_id AND user_id=$id;";
                    $result4= mysqli_query($conn, $query4);
                }else{
                    $query5= "INSERT INTO cart(product_id, quantity, user_id) VALUES('$pro_id', 1, '$id');";
                    $result5= mysqli_query($conn, $query5);
                }
    }else{
        header ("location: login.php");
    }
}  

if(isset($_GET["id"])){
    $user_id= $_GET["id"];
  }
  if(!isset($_GET["id"])){
    $shoppath= 'ProductsPage.php';
    $categorypath= 'CategoriesPage.php?';
    $cartpath= 'login.php';
    $homepath= 'landingpage.php';
    $about= 'aboutUS.php';
    $contact= 'contactUS.php';
  }else{
    $shoppath= 'ProductsPage.php?id='.$user_id;
    $categorypath= 'CategoriesPage.php?id='.$user_id.'&';
    $cartpath= 'other/cart.php?id='.$user_id;
    $homepath= 'landingpage.php?id='.$user_id;
    $about= 'aboutUS.php?id='.$id;
    $contact= 'contactUS.php?id='.$id;
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/Product.css">
    <script src="https://kit.fontawesome.com/aca8d5a1fa.js" crossorigin="anonymous"></script>
    <title>Product Name</title>
</head>
<body>
<nav style="display: flex;">
      
      <div>
          <img width="200px" src="./Images/logo.png">
      </div>

      <div>
          <a href="<?php echo $homepath; ?>">Home</a>
          <a href="<?php echo $shoppath; ?>">Shop</a>
          <a href="<?php echo $cartpath; ?>">Cart</a>
          <a href="<?php echo $about; ?>">About Us</a>
          <a href="<?php echo $contact; ?>">Contact Us</a>
      </div>
      
      <div>
        <?php
        if(!isset($_GET["id"])){
          echo '<a href="login.php">Login</a>
                <a href="signup.php">Register</a>';
        }else{
          echo '<a href="userpage.php?id='.$user_id.'">Account</a>';
          echo '<a href="LandingPage.php">Log Out</a>';
        }
          ?>
      </div>
  
  </nav>

    <div class="board">
        
            <br>
        <div id="parent">
            <div>
                <img src="<?php echo $row['image']?>" alt="Product">
            </div>

            <div>
                <h1><?php echo $row['name']?></h1>
                <h4>Category: <?php echo $row['category_name']?></h4>
                <h1 id="price">$<?php echo $row['price']?></h1>
                <p><?php echo $row['description']?></p><br>
                <a href='Product.php?pro_id=<?php echo $pro_id?>&id=<?php echo $id ?>&add=1' id="addtocart">Add to Cart</a>
            </div>
        </div> 

        <hr>

        <h1>Reviews</h1>

        <?php
        $sql= "SELECT * FROM comments JOIN user ON comments.user_id = user.user_id JOIN products ON comments.product_id = products.id Where product_id=$pro_id;";
        $sqlRun= mysqli_query($conn, $sql);
        $resultcheck2 = mysqli_num_rows($sqlRun);
                    if($resultcheck2 > 0)
                    {
                    while($row2 = mysqli_fetch_assoc($sqlRun))
                    {
                        echo '<div id="revs">
                                <p><i class="fa-solid fa-user"></i> <span>'.$row2['first_name'].' '.$row2['last_name'].'</span> </p>
                                <p>'.$row2['comment'].'</p>
                            </div>';
                    }
                    }
        ?>
        <br> 
        
        <div id="addrev">
            <h2>Add your review</h2>
            <h3>Your review*</h3>
            <form method="post">
            <textarea name="comment"></textarea>
            <input type="submit" name="submitrev">
            <form>
        </div>

    </div>
</body>
<footer>
    <div id="footerdiv">
        <div class="col-3">
            <img src="./Images/logo.png">
        </div>
        <div class="col-3">
            <h1 style="text-align: center;">Stay In Touch</h1><br>
            <h2 style="text-align: center;"></h2>
            <p style="text-align: center;">
            <p style="text-align: center;" >
            <a href="https://www.facebook.com/sephora/" target="_blank" ><i class="fa-brands fa-facebook"style="display: inline;"></a></i>
            <a href="https://www.instagram.com/sephora/" target="_blank" ><i class="fa-brands fa-instagram"style="display: inline;"></a></i>
            <a href="https://www.linkedin.com/company/sephora/" target="_blank" ><i class="fa-brands fa-linkedin"style="display: inline;"></a></i>
            </p>
            <br>
            <p style="text-align: center;">copyright <i class="fa-solid fa-copyright"></i> 2022 BeautyCare</p>
        </div>
        <div class="col-3">
        <h2>Our Website</h2>
       
<p> You'll find that all of our products are made of organic ingredients 
    This means that our products are free of nanoparticles, parabens,
    or other harmful or synthetic chemicals that could harm your skin.
 <b>"Our products are not tested on animals"<b>
</p>
    </div>
            </div>
    </footer>
</html>