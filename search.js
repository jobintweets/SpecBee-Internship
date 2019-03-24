$(document).ready(function(){
    
    display();
    function display(){
        // $('.filterdata').html('<div id="a"></div>')
        var test="fetch data";
        var cat_id=filter('category');
        var r_id=filter('sellers');
        // names decalred in the input field
        $.ajax({
            url: "filter.php",
            type: "POST",
            data:{
                key:test,
                cat:cat_id,
                rid:r_id

            },
            success: function (data) {
                
                    $(".filterdata").html(data);
               
               
            },
            error: function (error) {
               console.log("error occoured");
            }
        });
    }
    function filter(classname){
        var filterarray=[];
        $('.' + classname + ':checked').each(function(){
            filterarray.push($(this).val());
        });
        return filterarray;

    }
    $('.filter').click(function(){
        display();
    })

    
     
     
     
      
       
     
  
});