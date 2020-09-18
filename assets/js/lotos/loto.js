import $ from 'jquery';

$(document).on('click', '.voir-liste-joueurs', function(e){
    e.preventDefault()

    var cible = $(this).attr('data-target');

    $(cible).toggleClass('is-active');
})

$(document).on('click', '.modal-close', function(e){
    e.preventDefault()

    $('.modal.is-active').toggleClass('is-active')
})