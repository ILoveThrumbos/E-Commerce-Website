<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chocolate Shop</title>
    <link rel="stylesheet" href="../css/styles.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
</head>

<body>
    <header>
        <?php
        include("../includes/header.php")
        ?>
    </header>
    <nav>
        <div>
            <div>
                <a href="index.html">Home</a>
                <a href="viewproducts_page.php">View All Products</a>
                <a href="search_page.php">Search Product</a>
                <a href="cartdisplay_page.php">
                    <img src="../images/Cart.pnga" alt="Cart Icon">
                </a>
            </div>
        </div>
    </nav>
    <main>
        <div class="catalog-scroll" align="center">
            <h1>Chocolate List</h1>
            <p>Each chocolate packs a punch of flavor.</p>

            <?php
            include('../includes/products.php');
            ?>

        </div>

    </main>

    <footer>
        <?php
        include("../includes/footer.php")
        ?>

    </footer>
</body>

</html>