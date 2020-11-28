import $ from 'jquery';
import { Swappable, Sortable, Plugins } from '@shopify/draggable';

var ids = $('#liste-tirages').toArray()
var draggableListe = $('.tirage-grille').toArray()
var sortableListe = $('.is-sortable').toArray()

var containersSortable = $.merge(ids, sortableListe)

var containersSwapable = $.merge( ids, draggableListe )

const swappable = new Swappable(draggableListe, {
    draggable: '.tirage',
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
        console;log(res)
    })
    .fail(function(res){
        console.log(res)
    });

})

/*var currentValue = '';
var nextValue = '';

var origine = '';
var destination = '';


swappable.on('swappable:start', (evt) => {
    origine = evt.data.dragEvent.data
})

swappable.on('swappable:stop', (evt) => {

    console.log( evt )

    evt.data.dragEvent.data.originalSource.previousElementSibling.setAttribute('value', currentValue)
    origine['firstElementChild'].setAttribute('value', nextValue)
})

swappable.on('swappable:swapped', (evt) => {
    destination = evt.data.dragEvent.data
    var currentValue = evt.data.dragEvent.data.originalSource.innerText;
    var nextValue = evt.data.dragEvent.data.over.innerText

    console.log( evt )

    evt.data.dragEvent.data.sourceContainer.previousElementSibling.setAttribute('value', nextValue)
    evt.data.dragEvent.data.overContainer.previousElementSibling.setAttribute('value', currentValue)
});*/

/*const sortable = new Sortable(containersSortable, {
    draggable: '.tirage',
    mirror: {
        constrainDimensions: true,
    },
    plugins: [Plugins.ResizeMirror],
});*/

/*const containerTwoCapacity = 1;
let currentMediumChildren;
let capacityReached;
let lastOverContainer;

sortable.on('drag:start', (evt) => {
    currentMediumChildren = sortable.getDraggableElementsForContainer(sortable.containers[1])
        .length;
    capacityReached = currentMediumChildren === containerTwoCapacity;
    lastOverContainer = evt.sourceContainer;
});

sortable.on('sortable:sort', (evt) => {
    if (!capacityReached) {
        return;
    }

    const sourceIsCapacityContainer = evt.dragEvent.sourceContainer === sortable.containers[1];

    if (!sourceIsCapacityContainer && evt.dragEvent.overContainer === sortable.containers[1]) {
        evt.cancel();
    }
});

sortable.on('sortable:sorted', (evt) => {
    if (lastOverContainer === evt.dragEvent.overContainer) {
        return;
    }

    lastOverContainer = evt.dragEvent.overContainer;
});*/