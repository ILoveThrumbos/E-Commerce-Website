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
            <div align="center">
                <p><input type="text" id="search" value="" placeholder="Search for chocolates..." />
                    <img src="../images/search.png" alt="Search Icon">
                </p>
                <div id="productList"></div>
            </div>
            <script>
                $(document).ready(function() {
                    $("#search").on("input", function() {
                        var query = $(this).val();

                        $.ajax({
                            url: "../includes/search_products.php",
                            method: "GET",
                            data: {
                                q: query
                            },
                            success: function(data) {
                                // Update the HTML content of productList div
                                $("#productList").html(data);
                            },
                            error: function() {
                                console.error("Failed to fetch search results");
                            }
                        });
                    });

                    // Display search results in the dropdown box
                    function displayResults(results) {
                        var resultsContainer = $("#searchResults");
                        resultsContainer.html('');

                        if (results.length > 0) {
                            resultsContainer.css("display", "block");

                            // Append each result to the dropdown
                            $.each(results, function(index, result) {
                                var resultDiv = $("<div class='result'></div>");
                                resultDiv.text(result.product_name);
                                resultDiv.on("click", function() {
                                    $("#searchInput").val(result.product_name);
                                    resultsContainer.css("display", "none");
                                });
                                resultsContainer.append(resultDiv);
                            });
                        } else {
                            resultsContainer.css("display", "none");
                        }
                        
                    }
                });
            </script>

    </main>
    <footer>
        <?php
        include("../includes/footer.php")
        ?>

    </footer>
</body>

</html>