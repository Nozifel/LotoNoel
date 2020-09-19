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
var bulmaCalendar = require('bulma-calendar');

require('./navigation/navbar')
require('./lotos/loto')
require('./lotos/formulaire')

if( $('#edit-loto').length > 0 ) {
    var dateDebutDay = $("[name='loto[date_debut][day]']").val()
    var dateDebutMonth = $("[name='loto[date_debut][month]']").val()
    var dateDebutYear = $("[name='loto[date_debut][year]']").val()
    var dateDebut = dateDebutMonth + "/" + dateDebutDay + "/" + dateDebutYear

    var dateFinDay = $("[name='loto[date_fin][day]']").val()
    var dateFinMonth = $("[name='loto[date_fin][month]']").val()
    var dateFinYear = $("[name='loto[date_fin][year]']").val()
    var dateFin = dateFinMonth + "/" + dateFinDay + "/" + dateFinYear
}

var calendars = bulmaCalendar.attach('[type="date"]', {
    isRange: true,
    dateFormat: 'DD/MM/YYYY',
    startDate: dateDebutDay ? new Date(dateDebut) : null,
    endDate: dateDebutDay ? new Date(dateFin) : null,
    onReady: (datepicker) => {

    }
});

for(var i = 0; i < calendars.length; i++) {
    calendars[i].on('select', date => {
    })
}

var element = document.querySelector('#date-picker');
if (element) {
    element.bulmaCalendar.on('select', function(datepicker) {
        console.log( datepicker )
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