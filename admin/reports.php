<?php
if($_SESSION['userAdmin'] == NULL){
    header("Location: ../index.php");
    exit();
}

$statuses = array(
    '1' => 'ordered',
    '2' => 'in progress',
    '3' => 'on the road',
    '4' => 'delivered'
);

?>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script>
$(function() {
 
    $("#status").bind("change", function() {
        $.ajax({
            type: "GET", 
            url: "change.php",
            data: "status="+$("#status").val(),
            success: function(html) {
                $("#results").html(html);
            }
        });
    });
			
 
});
</script>
<div>
    <label for="status">Select Status:</label>
    <select name="status" id="status">
        <option selected>Select Status</option>
        <?php 
        foreach ($statuses as $key => $value) {
        ?>
           <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
        <?php
        }
        ?>                
    </select>
    <hr/>
    <div id="results">
        
    </div>
</div>