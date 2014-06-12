$(document).ready(function() {
   tab();
});
function tab() {
    $('.tab_content').hide();
    $('.tab_content:first').show();
    $('.tab_nav li a:first').addClass('active');
    $('.tab_nav li a').click(function(){
       var  id_content = $(this).attr("href"); 
       $('.tab_content').hide();
       $(id_content).fadeIn();
       $('.tab_nav li a').removeClass('active');
       $(this).addClass('active');
       return false;
    });

}
