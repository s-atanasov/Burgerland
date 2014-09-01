var ingredients = 0;
    function addIngredient(){
        $("#ingredients").append("<div id='progLangDiv"+ ingredients +"'><select name='ingredients[]' id='ingredients"+ ingredients +"' required='true'><option value='1'>Egg</option><option value='2'>Cheese</option><option value='3'>Potatoes</option></select></div>");
        ingredients++;
        var pr = parseFloat($("#price").html());

        pr = pr + 0.50;
        $("#price").html(pr);
    }

    function removeIngredient(){
        $("#ingredients").find("div:last").remove();
        if(ingredients > 0){
            var pr = parseFloat($("#price").html());
            pr = pr - 0.50;
            $("#price").html(pr);
           ingredients--; 
        }
    }
    $(document).ready(function(){
        var lastPrice = 0;
        
        $("#burger").change(function(){
            var price = $("#price").html();
            price = price - lastPrice;
            switch($(this).val()){
                case '1':
                    lastPrice = 2.50;
                    break;
                case '2':
                    lastPrice = 3.50;
                    break;
                default:
                    lastPrice = 0;
                    break;
            }
            $("#price").html(price + lastPrice);
        });
        
    });