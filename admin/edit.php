<?php
if($_SESSION['userAdmin'] == NULL){
    header("Location: ../index.php");
    exit();
}

$order_id = (int)$_GET['order_id'];
if(!isset($order_id) || !is_numeric($order_id) || $order_id < 1)
{
    header('Location: ../index.php');
    exit();
}

$currOrder = $order->getOrder($order_id);
$statuses = array(
    '1' => 'ordered',
    '2' => 'in progress',
    '3' => 'on the road',
    '4' => 'delivered'
);

$updated = false;

    if(isset($_POST['update']) && $updated == false){
        
        $errorsUpdate = array();
        $status =  trim($_POST['status']);
        
        if(!isset($status) || !is_numeric($status) || $status < 1){
            $errorsUpdate[] = 'Invalid status';
        }
        
        if(!$errorsUpdate){
            if($order->updateStatus($currOrder['order_id'],$status)){
                echo 'The status has been changed!<br/>';
                echo '<a href="index.php" >View all orders</a>';
                $updated = true;
            }
        }
    }
    
    
    if($updated == false){

?>
<div>
    <form method="post" action="">
        <div>
            <label>Choose a burger</label>
            <?php echo $currOrder['burger']; ?>
        </div>
        <div>
            <label>Ingredients</label>
            <?php echo $order->getOrderIngredients($currOrder['order_id']); ?>
        </div>
        <div>
            <label>Contact Name</label>
            <?php echo $currOrder['name']; ?>
        </div>
        <div>
            <label>Contact Phone</label>
            <?php echo $currOrder['phone']; ?>
        </div>
        <div>
            <label>Delivery City</label>
            <?php echo $currOrder['city']; ?>
        </div>
        <div>
            <label>Delivery Address <br/>(street and number)</label>
            <?php echo $currOrder['address']; ?>
        </div>
        <div>
            <label>Final price:</label>
            <?php echo $currOrder['price']; ?>
        </div>
        <div>
            <label for="status">Change Status:</label>
            <select name="status" id="status">
                <?php 
                foreach ($statuses as $key => $value) {
                ?>
                   <option value="<?php echo $key; ?>" <?php if ($currOrder['status'] == $key) { echo 'selected'; } ?>><?php echo $value; ?></option>
                <?php
                }
                ?>                
            </select>
        </div>
        <div>
            <input type="submit" name="update" value="Update" />
        </div>
    </form>
</div>
<?php
    }
?>