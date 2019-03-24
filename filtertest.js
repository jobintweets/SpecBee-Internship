$(document).ready(function(){

  function calculate(pid,price)
  {
    var action='fetch';
      var quantity=$("#"+pid).val();
      var existing_price=$("#price"+pid).text();
    //   appending to the id and fetching the value
      var rupee=parseInt(price,10);
      var updated_price=rupee*quantity;
    //   $400 quantity 4 then 4*400
    var t_price=$(".total").text();
    var total_price=parseInt(t_price,10);
    // fetching the total prce from the cart using the class name gien tothe span
    if( existing_price>updated_price){
      var t_sum=total_price-(existing_price-updated_price);
    }
    else{
      var t_sum=total_price+updated_price-rupee;
    }
   
    $("#price"+pid).text(updated_price);
   $(".total").text(t_sum);
   $.ajax({
     url:"checkout.php",
     method:"post",
     data:{
       action:action,
       product_id:pid,
       quantity:quantity
      }
   });
  }  
    
   

    
     
$('input').change(function(){
    var pid=$(this).attr("id");
    // var sum=$(".total").attr("id");
    var price=$(this).attr("custom");
    calculate(pid,price);
});
     
      
       
     
  
});