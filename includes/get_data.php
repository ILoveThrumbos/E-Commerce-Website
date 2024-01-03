<html> 
<head> 
    <title>Get user Data</title> 
<?php  
//GET the ID from url
$id = $_GET["id"];
$info = "";
//Connect to the database
include_once("conn_ecommercedb.php");
$query = "select * from product where product_id=?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
if($result->num_rows == 1)
{
    $row = $result->fetch_array();
    $info = $row["product_name"]." ".$row["product_price"]." ".$row["product_type"]." ".$row["product_qty"];
}
else
{
    $info = "Record not found.";
}
$mysqli->close();

?> 
    
    

</head> 
<body> 
    <div id="phpOutput"> <?php echo $info ?> </div> 
</body> 
</html>