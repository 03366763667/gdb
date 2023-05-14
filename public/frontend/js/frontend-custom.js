$(document).ready(function (){

    //  mobile nav
    $('.mobileBtn').click(function (){
        $(this).toggleClass('toggle-btn');
        $('.menuNanBar').slideToggle();
    });

    //  mobile search
    $('.mobileSearch i').click(function (){
        $('.mobileSearchForm').slideToggle();
    });

    //  mobile sub menu dropdown
    $('.menuNanBar ul li .openSubCategory').click(function (){
        $(this).parent().children('.dropdown.sub-dropdown').slideToggle();
    });


});
