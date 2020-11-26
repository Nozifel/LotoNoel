import $ from 'jquery';
import { Swappable, Sortable, Plugins } from '@shopify/draggable';

var ids = $('#liste-tirages').toArray()
var draggableListe = $('.tirage-grille').toArray()
var sortableListe = $('.is-sortable').toArray()

var containersSortable = $.merge(ids, sortableListe)

var containersSwapable = $.merge( ids, draggableListe )

const Classes = {
    draggable: 'StackedListItem--isDraggable',
    capacity: 'draggable-container-parent--capacity',
};

const swappable = new Swappable(sortableListe, {
    draggable: '.tirage',
    mirror: {
        constrainDimensions: true,
    },
    plugins: [Plugins.ResizeMirror],
});

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