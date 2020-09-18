/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import '../css/app.scss';
import $ from 'jquery';
require('select2');

require('./navigation/navbar')
require('./lotos/loto')
require('./lotos/formulaire')

// Need jQuery? Install it with "yarn add jquery", then uncomment to import it.

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

var element = document.querySelector('#date-picker');
if (element) {
    // bulmaCalendar instance is available as element.bulmaCalendar
    element.bulmaCalendar.on('select', function(datepicker) {
        var data = datepicker.data
        var _enDate = data.endDate
        var _startDate = data.startDate

        var endDate = {
            day: _enDate.getDate(),
            month: _enDate.getMonth() + 1,
            year: _enDate.getFullYear(),
        };

        var startDate = {
            day: _startDate.getDate(),
            month: _startDate.getMonth() + 1,
            year: _startDate.getFullYear(),
        };

        $("[name='loto[date_debut][day]']").val( startDate.day )
        $("[name='loto[date_debut][month]']").val( startDate.month )
        $("[name='loto[date_debut][year]']").val( startDate.year )

        $("[name='loto[date_fin][day]']").val( endDate.day )
        $("[name='loto[date_fin][month]']").val( endDate.month )
        $("[name='loto[date_fin][year]']").val( endDate.year )
    });
}