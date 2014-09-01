<?php

require_once('includes/config.php');

if(isset($_POST['submit'])){

    $username = $_POST['username'];
    $password = $_POST['password'];

    if($user->login($username,$password)){ 

        if($user->is_logged_in() && isset($_SESSION['userAdmin'])){
            header('Location: admin/index.php');
        }

    } else {
        $errors[] = 'Wrong username or password.';
    }

}

$title = 'Burger Land';

require('layout/header.php'); 
?>

	
<div id="content">
    <div id="colOne">
        <?php
        if(!$user->is_logged_in()){
        ?>
        <div>
            Please log in to order a burger or view your orders.<br/>
            Normal User:<br/>
            Username: <b>guest</b><br/>
            Password: <b>guess</b>
            <p>
                Admin User:<br/>
                Username: <b>admin</b><br/>
                Password: <b>admin</b>
            </p>
        </div>
        <?php
        }else{
           if (isset ($_GET['p'])){
            
                $p = $_GET['p'];

                switch ($p){
                    case "order": 
                        include 'order.php' ;
                        break ;
                    default :
                        include 'homepage.php';
                        break;
                }
            }else{
                include 'homepage.php';
            } 
        }
        
    ?>
    </div>
    <div id="colTwo">
        <p><img src="images/1.jpg" width="198" height="231" /></p>	
        <ul>
            <li>
                <h2>Navigation :</h2>
                <?php 
                    if($user->is_logged_in()) { 
                ?>
                <ul>
                    <li class="active"><a href="index.php">Home</a></li>
                    <li><a href="?p=order">Place a order</a></li>
                </ul>
            </li>
            <?php
                }else{
                    echo "<ul>Plese log in!</ul>";
                }
            ?>
            <li>
                <h2>Please Login</h2>
                <ul>
                    <?php

                        if($user->is_logged_in()) {
                            $user = $_SESSION['userInfo'];
                            echo "Welcome <b>".$user['username']."</b><br/>"; 
                            echo "<a href=logout.php>Logout</a>";
                        }else{
                    ?>
                    <form method="post" action="" autocomplete="off">
                        <label for="username">Портебител:</label><input type="text" name="username" id="username" placeholder="User Name" value="<?php if(isset($error)){ echo $_POST['username']; } ?>" tabindex="1"><br />
                        <label for="password">Парола:</label><input type="password" name="password" id="password" placeholder="Password" tabindex="2"><br />
                        <input type="submit" name="submit" value="Login" tabindex="3">
                    </form>
                    <?php
                            if(isset($errors)){
                                foreach($errors as $error){
                                    echo '<p>'.$error.'</p>';
                                }
                            }
                        }
                    ?>
                </ul>
            </li>
    </div>
</div>


<?php 
require('layout/footer.php'); 
?>