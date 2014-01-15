jQuery.noConflict();
jQuery(window).load(function(){
jQuery(document).ready(function($) {
    $('.link-sort-list').click(function(e) {
      
        var $sort = this;
        var $list = $('#acc3');
        var  $listLi = $('ul#acc3 > li').get();
        $listLi.sort(function(a, b){
            
            var keyA = $(a).text();
            var keyB = $(b).text();
         
            if($($sort).hasClass('asc')){
                return (keyA > keyB) ? 1 : 0;
            } else {
                return (keyA < keyB) ? 1 : 0;
            }
        });
        $.each($listLi, function(index, row){
            $list.append(row);
        });
        e.preventDefault();
    });
    
    
    $("html").addClass("js");
    $.fn.accordion.defaults.container = false; 
    $(function() {
      $("#acc3").accordion({initShow: "#current"});
      $("html").removeClass("js");
    });
});
});