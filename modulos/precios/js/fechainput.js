

  $(document).ready( function() {
    var now = new Date();
 
    var day = ("0" + now.getDate()).slice(-2);
    var month = ("0" + (now.getMonth() + 1)).slice(-2);

    var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
    var today = "2019-02-02" ;
alert(x);

   $('#date3').val(today);
    
    $('#test').click(function(){
        
        testClicked();
        
    });
});
function testClicked()
{
    
console.log(    $('#date3').val("2018-05-05"));    
}


