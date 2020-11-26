import $ from 'jquery';
var toastr = require('toastr');

$(document).on('click', '.close-modal', function(){
    $(this).closest('.modal').removeClass('is-active')
})

$(document).on('click', '.show-modal', function(e){
    e.preventDefault()

    var cible = $(this).attr('data-target');

    $(cible).toggleClass('is-active');
})

$(document).on('click', '.modal-close, .modal-background', function(e){
    e.preventDefault()

    $('.modal.is-active').toggleClass('is-active')
})

var successMessage = ( message ) => {
    toastr.success('', message, {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "timeOut": "8000",
    });
}

var faillMessage = ( message ) => {
    toastr.danger('', message, {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "timeOut": "8000",
    });
}

$(document).on('click', '.generer-tirage', function(e){
    e.preventDefault()

    var ajaxUrl = $(this).attr('href')
    var cardLoto = $(this).closest('.card-loto').addClass('is-loading')

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

            successMessage('Le tirage des numéros a été généré.')
        }
        else
        {
            faillMessage( res.responseJSON.message )
        }
    })
    .fail(function(res){
        faillMessage( res.responseJSON.message )
    });
})

$(document).on('click', '.autoriser-edition-grilles', function(e){
    e.preventDefault()

    var ajaxUrl = $(this).attr('href')
    var cardLoto = $(this).closest('.card-loto').addClass('is-loading')

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

                successMessage("L'édtion des grilles a été autorisé.")
            }
            else
            {
                faillMessage( res.responseJSON.message )
            }
        })
        .fail(function(res){
            faillMessage( res.responseJSON.message )
        });
})

$(document).on('click', '.add-combinaison', function(e){
    e.preventDefault()

    var action = $(this).closest('form').attr('action')
    var form = $(this).closest('form').serialize()
    var cardLoto = $( $(this).attr('data-bloc-loto') )

    $.ajax({
        method: "POST",
        url: action,
        data: {
            form
        }
    })
    .done(function( res, status, xhr ){
        $('.modal.is-active').removeClass('is-active');
        cardLoto.addClass('is-loading')

        if( xhr.status == 200 )
        {
            cardLoto.replaceWith( res )

            successMessage('La combinaison a été ajouté.')
        }
        else
        {
            faillMessage( res.responseJSON.message )
        }
    })
    .fail(function(res){
        $('.modal.is-active').removeClass('is-active');
        faillMessage( res.responseJSON.message )
    });
})

$(document).on('click', '.delete-combinaison', function(e){
    e.preventDefault()

    var combinaison = $(this).closest('.bloc-combinaison')
    var combinaisonId = $(this).attr('data-combinaison-id')
    var modal = $( $(this).attr('data-target') ).attr('data-combinaison-id', combinaisonId)
})

$(document).on('click', '.confirm-delete-combinaison', function(e){

    var combinaisonId = $(this).closest('.modal').attr('data-combinaison-id')
    var action = $(this).attr('data-action')+"/"+combinaisonId
    var cardLoto = $( $(this).closest('.modal').attr('data-bloc-loto') )

    $.ajax({
        method: "POST",
        url: action,
        data: {}
    })
        .done(function( res, status, xhr ){
            $('.modal.is-active').removeClass('is-active');
            cardLoto.addClass('is-loading')

            if( xhr.status == 200 )
            {
                cardLoto.replaceWith( res )

                successMessage('La combinaison a été supprimé.')
            }
            else
            {
                faillMessage( res.responseJSON.message )
            }
        })
        .fail(function(res){
            $('.modal.is-active').removeClass('is-active');
            faillMessage( res.responseJSON.message )
        });
})