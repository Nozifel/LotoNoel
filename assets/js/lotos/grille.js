import $ from 'jquery';
var toastr = require('toastr');
import { Swappable, Sortable, Plugins } from '@shopify/draggable'

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

var ids = $('#liste-tirages').toArray()
var draggableListe = $('.tirage-grille').toArray()
var sortableListe = $('.is-sortable').toArray()

var containersSortable = $.merge(ids, sortableListe)

var containersSwapable = $.merge( ids, draggableListe )

const swappable = new Swappable(draggableListe, {
    draggable: '.tirage-sortable',
    /*mirror: {
        appendTo: '#ma-grille .tirage-grille',
        constrainDimensions: true,
    },
    plugins: [Plugins.ResizeMirror],*/
});

$(document).on('submit', '#update-grille', function(e){
    e.preventDefault()

    var numeros = [];

    $('#ma-grille input').each(function(){
        numeros.push( $(this).val() );
    })

    console.log(numeros);

    $.ajax({
        method: "POST",
        url: $('#update-grille').attr('action'),
        data: {
            'numeros': numeros
        }
    })
    .done(function( res, status, xhr ){
        successMessage(res.message)
    })
    .fail(function(res){
        faillMessage( res.responseJSON.message )
    });

})