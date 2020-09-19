import $ from 'jquery';
var toastr = require('toastr');

$(document).on('click', '.voir-liste-joueurs', function(e){
    e.preventDefault()

    var cible = $(this).attr('data-target');

    $(cible).toggleClass('is-active');
})

$(document).on('click', '.modal-close, .modal-background', function(e){
    e.preventDefault()

    $('.modal.is-active').toggleClass('is-active')
})

var tirageGenere = () => {
    toastr.success('', 'Tirage effectué', {
        "closeButton": true,
        "progressBar": true,
        "positionClass": "toast-bottom-right",
        "timeOut": "8000",
    });
}

var tirageGenereFail = ( message ) => {
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

            tirageGenere()
        }
        else
        {
            tirageGenereFail( res.responseJSON.message )
        }
    })
    .fail(function(res){
        tirageGenereFail( res.responseJSON.message )
    });
})