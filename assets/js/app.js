/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.scss';

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.
// import $ from 'jquery';

var bulmaCalendar = require('bulma-calendar');

var calendars = bulmaCalendar.attach('[type="date"]', {
    isRange: true,
    dateFormat: 'DD/MM/YYYY'
});

// Loop on each calendar initialized
for(var i = 0; i < calendars.length; i++) {
    // Add listener to date:selected event
    calendars[i].on('select', date => {
        console.log(date);
    });
}

var element = document.querySelector('#my-element');
if (element) {
    // bulmaCalendar instance is available as element.bulmaCalendar
    element.bulmaCalendar.on('select', function(datepicker) {
        var data = datepicker.data
        var enDate = data.endDate
        var startDate = data.startDate

        var strEndDate = enDate.toJSON('DD/MM/YYYY')
        console.log( strEndDate )
    });
}