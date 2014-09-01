<div>
    <div>
        <h2>Welcome <?php echo $_SESSION['userInfo']['username'] ; ?></h2>
        Click on the status to change it.
        <?php
            $userOrders = $order->getAllOrders();
            if($userOrders){
        ?>
        <table class="orders">
            <tr>
                <th>Burger</th>
                <th>Ingredients</th>
                <th>Name</th>
                <th>Phone</th>
                <th>City</th>
                <th>Address</th>
                <th>Price</th>
                <th>Date</th>
                <th>Status</th>
                <th>User</th>
            </tr>
            <?php
                foreach ($userOrders as $ord) {
                    echo '<tr>';
                    echo '<td>' . $ord['burger'] . '</td>';
                    echo '<td>' . $order->getOrderIngredients($ord['order_id']) . '</td>';
                    echo '<td>' . $ord['name'] . '</td>';
                    echo '<td>' . $ord['phone'] . '</td>';
                    echo '<td>' . $ord['city'] . '</td>';
                    echo '<td>' . $ord['address'] . '</td>';
                    echo '<td>' . $ord['price'] . '</td>';
                    echo '<td>' . $ord['date'] . '</td>';
                    echo '<td><a href="index.php?p=edit&AMP;order_id='. $ord['order_id'] .'&AMP;status_id='.$ord['status'].'" >' . $order->getOrderStatus($ord['status']) . '</a></td>';
                    echo '<td>' . $user->get_user_name($ord['user_id']) . '</td>';
                    echo '</tr>';
                }
            ?>
        </table>
        <?php
            }else{
                echo '<p>You do not have any orders yet!</p>';
            }
            
        ?>
    </div>
</div>