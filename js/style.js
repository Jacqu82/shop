$(document).ready(function () {

    $('#smallPhotos div').click(function () {
        var path = $(this).find('img').attr('src');
       $('#mainPhoto').attr({src: path});
    })

    $('#smallPhotos div').mouseover(function () {
        $(this).css( 'cursor', 'pointer' );
    })

    $('.button').click(function(){
        //sprawdzam czy element ma klasę visible, jeśli nie to nadaje mu ją, pokazuje element i zmieniam wartość przycisku na 'hide'
        if (!$(this).hasClass('visible')) {
            $(this).next().next().fadeIn(300);
            $(this).addClass('visible');
            $(this).prop('value', 'Hide');
        } else {
            //a tutaj operacja odwrotna do tamtej
            $(this).next().next().fadeOut(300);
            $(this).removeClass('visible');
            $(this).prop('value', 'Change');
        }
    })

    $('.deleteItemInBasket').click(function() {
        console.log("hej");
        $(this).parent().parent().html('');
        //var url = "delete.php";
        //window.location = url;
    })


});
