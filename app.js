
$(document).ready(function () {

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

    
})
