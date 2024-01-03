<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chocolate Shop</title>
    <link rel="stylesheet" href="../css/styles.css">
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
    <checkout>
        <?php
        include('../includes/view_cart.php');
        ?>
    </checkout>
    <footer>
        <div>
            <div>
                <a href="#">FAQ & Support |</a>
                <a href="#">About Us |</a>
                <a href="#">Our Services |</a>
                <a href="#">Contact Us</a>
            </div>
            <p>&copy; 2023 Chocolate Factory</p>
        </div>
    </footer>
    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById("myDropdown");
            if (dropdown.style.display === "block") {
                dropdown.style.display = "none";
            } else {
                dropdown.style.display = "block";
            }
        }
    </script>
</body>

</html>