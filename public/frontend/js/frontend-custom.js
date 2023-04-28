$(document).ready(function (){

//   mobile search bar
    $('.top-search a').click(function (){
        $('body').toggleClass('openSearchbar');
    });

    $('.closeIcon').click(function (){
        $('body').removeClass('openSearchbar');
    })
});
