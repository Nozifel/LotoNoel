import $ from 'jquery';

import { toast } from "bulma-toast";

$(document).on('click', '.voir-liste-joueurs', function(e){
    e.preventDefault()

    var cible = $(this).attr('data-target');

    $(cible).toggleClass('is-active');
})

$(document).on('click', '.modal-close, .modal-background', function(e){
    e.preventDefault()

    $('.modal.is-active').toggleClass('is-active')
})

$(document).on('click', '.generer-tirage', function(e){
    e.preventDefault()

    var ajaxUrl = $(this).attr('href')
    var cardLoto = $(this).closest('.card-loto')

    $.ajax({
        method: "POST",
        url: ajaxUrl,
        data: {
        }
    })
    .done(function( res, status, xhr ){
        if( xhr.status == 200 )
        {
            cardLoto.replaceWith( res )
        }
        else
        {
            toast({
                message: res.message,
                type: "is-danger",
                position: 'bottom-right',
                dismissible: true,
                animate: { in: "fadeIn", out: "fadeOut" }
            });
        }
    })
    .fail(function(res){
        toast({
            message: res.responseJSON.message,
            type: "is-danger",
            position: 'bottom-right',
            dismissible: true,
            animate: { in: "fadeIn", out: "fadeOut" }
        });
    });
})