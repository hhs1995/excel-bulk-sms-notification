var currentPageURL = window.location.href;    
var subMenu = $(".dropdown-menu a[href='"+currentPageURL+"']");
if(subMenu.length==0){
  $(".horizntalList-group .main-nav li a[href='"+currentPageURL+"']").addClass('active-menu');
} else {
  subMenu.addClass('active-menu-maindropmenu');        
  subMenu.closest("li.dropdown").find("a:first").addClass('active-menu'); 
  /*========== FOR VERTICAL MENU =============*/
  $(".leftsidebar ul li a[href='"+currentPageURL+"']").addClass('active-menu-leftsidebar'); 
       
}
