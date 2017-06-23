$(document).ready(function () {

    //mini galeria - pokazanie wybranego, małego zdjęcia w większym oknie. - product.php

    $('#smallPhotos div').click(function () {
        var path = $(this).find('img').attr('src');
       $('#mainPhoto').attr({src: path});
    })

    //zmiana kursora po najechaniu na zdjęcie - product.php

    $('#smallPhotos div').mouseover(function () {
        $(this).css( 'cursor', 'pointer' );
    })

    //przy edycji danych użytkownika - pokazywanie i chowanie pola edycji danych - changeUserData.php

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

    $('.itemId').each(function() {
        $(this).change(function () {
            if (parseInt($(this).val()) > parseInt($(this).attr('max'))) {
                alert("Brak wystarczjącej ilości produktów na stanie");
                var max = parseInt($(this).attr('max'));
                $(this).val(max);
            }
        })
    })

    // KOSZYK.PHP
    //usuwanie całego wiersza w koszyk.php - usunięcie elementu z koszyka

    $('.deleteItemInBasket').click(function() {
        $(this).parent().parent().html('');
    })

    // określam user_id którego będe potrzebował przy zapisywaniu zamówienia do bazy danych, dane przesyłane jako GET
    var userId = $('#userId').attr('userId');

    //zapisuje ilosc przedmiotów, dane te przesyłam jako GET
    var i = $('.productInCart').length;

    //zmiany zapisują sie przy każdym kliknięciu na zmiane ilości któregokolwiek z produktów znajdujących się w koszyku

    $('.quantityItem').click( function() {

        //deklaruje pomocniczą zmienną j - dzieki niej nadam każdemu z przekazywanych danych wyjatkowy numer
        var j =1;
        //deklaruje zmienna, ktora bedzie przetrzymywac czesc stringa potrzebnego do przesłania danych GETEM
        var sing ='';

        //dla każdego produktu zapisuje dynamicznie id i ilosc kupowanego produktu
        $('.itemId').each( function() {
            var id = $(this).attr('id');
            var quantity = $(this).val();
            sing += '&id' + j + '=' + id + '&quantity' + j + '=' + quantity;
            j++;
        })

        //określanie ilości wybranego produktu oraz łącznej sumy za dany produkt
        var quantity = $(this).val();
        var value = ($(this).parent().parent().next().attr('name'));
        sum = quantity * value;
        $(this).parent().parent().next().html(sum);

        var totalSum = 0;

        //obliczanie łącznej sumy za wszystkie produkty

            $('.price').each(function(index) {
                var partOfSum = parseInt($(this).html());
                totalSum += partOfSum;
            })

        $('#sum').html(totalSum);

        //zapisywanie łącznej sumy w GET jako sum

        $('#buttonPay').parent().attr('href', '../order.php?sum=' + totalSum + '&userId=' + userId + sing + '&i=' + i);
    })

    $(function () {
        $messageList = $('.flash-message');

        if ($messageList.length) {
            setTimeout(function () {
                $messageList.slideUp(200);
            }, 3000);
        }

        $('.toggle-comment-form .toggle').on('click', function () {
            $('.toggle-comment-form').toggleClass('s-expanded');
        });
    });

});
