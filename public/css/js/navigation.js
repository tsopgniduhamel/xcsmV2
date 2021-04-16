$(function(){
    $('ol li a.titre span').click(function(){
        if($(this).hasClass('caret-close')){
            $(this).removeClass('caret-close');
            $(this).removeClass('fa-caret-right').addClass('fa-caret-down');
            $(this).parent().parent().find('ol').first().show(200);
        }else{
            $(this).addClass('caret-close');
            $(this).removeClass('fa-caret-down').addClass('fa-caret-right');
            $(this).parent().parent().find('ol').hide(200);
        }
    })


})