<?php
$ordered = false;
    if(isset($_POST['order']) && $ordered == false){
        $errorsOrder = array();

        if($order->getBurgerName($_POST['burger']) != ''){
            $burger = $order->getBurgerName($_POST['burger']);
        }else{
            $errorsOrder[] = 'Invalid Burger';
        }
        
        $ingredients = array();
        
        if(isset($_POST['ingredients'])){
            $ingre = $_POST['ingredients'];
            for($i = 0; $i < count($ingre) ;$i++) {
                $ingredients[] = $ingre[$i];
            }
        }
        if(strlen($_POST['contact']) > 2){
            $name = $_POST['contact'];
        }else{
            $errorsOrder[] = 'Invalid Contact Name';
        }
        
        if(strlen($_POST['contactPhone']) > 5){
            $phone = $_POST['contactPhone'];
        }else{
            $errorsOrder[] = 'Invalid Contact Phone';
        }
        
        if(strlen($_POST['delCity']) > 3){
            $city = $_POST['delCity'];
        }else{
            $errorsOrder[] = 'Invalid Delivery City';
        }
        
        if(strlen($_POST['delAddress']) > 3){
            $address = $_POST['delAddress'];
        }else{
            $errorsOrder[] = 'Invalid Delivery Address';
        }
        
        if($order->getBurgerPrice($_POST['burger']) > 0.00){
            $price = 0.00;
            $price = $order->getOrderPrice($_POST['burger'],$ingredients);
        }
        
        if(!$errorsOrder){
            if($order->placeOrder($_SESSION['userInfo']['user_id'],$burger,$name,$phone,$city,$address,$price,$ingredients)){
                echo 'Your order has been taken!<br/>';
                echo '<a href="index.php" >View your orders</a>';
                $ordered = true;
            }
        }
        
        
    }
    
    
    if($ordered == false){
        
?>
<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script src="dynamicSum.js"></script>
<div>
    <?php
        if(isset($errorsOrder)){
            foreach($errorsOrder as $error){
                echo '<p>'.$error.'</p>';
            }
        }
    ?>
    <form method="post" action="">
        <div>
            <span class="label"><label for="burger">Choose a burger</label></span>
        
            <select name="burger" id="burger">
                <option selected="selected" >Please choose</option>
                <option value="1">Chiken burger - 2.50</option>
                <option value="2">Pork burger - 3.50</option>
            </select>
        </div>
        <div>
            <span class="label">Ingredients Each ingredient cost <b>0.50</b></span>
            <table>
                <tr>
                    <td>
                        <span id="ingredients">
                        </span>
            
                        <input type="button" value="Remove ingredient" onclick="removeIngredient()"/>
                        <input type="button" value="Add ingredient" onclick="addIngredient()"/>
            
                    </td>
                </tr>
            </table>
            
        </div>
        <div>
            <label for="contact">Contact Name</label>
            <input type="text" name="contact" id="contact"  />
        </div>
        <div>
            <label for="contactPhone">Contact Phone</label>
            <input type="tel" name="contactPhone" id="contactPhone" require="require" />
        </div>
        <div>
            <label for="delCity">Delivery City</label>
            <input type="text" name="delCity" id="delCity"  />
        </div>
        <div>
            <label for="delAddress">Delivery Address <br/>(street and number)</label>
            <input type="text" name="delAddress" id="delAddress" require="require" />
        </div>
        <div>
            <h3>Final price: <span id="price">0</span></h3>
        </div>
        <div>
            <input type="submit" name="order" value="Order" />
        </div>
    </form>
</div>
<?php
    }
?>