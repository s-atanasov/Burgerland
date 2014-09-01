<?php
   if(isset($_POST['submit'])){
       
       $burger = $_POST['burger'];
       
       header("Location: index.php?p=order");
       exit();
       
   }