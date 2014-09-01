<?php
    require '../includes/config.php';
    
    $statusID = $_GET['status'];
    
    if(!isset($statusID) || !is_numeric($statusID) || $statusID < 1){
        echo 'Please choose a status!';
    }else{
       $orders = $order->getOrdersByStatus($statusID);
       
        if(!empty($orders)){
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
            foreach ($orders as $ord) {
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
            echo 'There are no order with ' . $order->getOrderStatus($statusID) . ' status!';
        }
        
    }
    


       
