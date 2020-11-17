import $ from 'jquery';

$(document).ready(function() {

    $('#loto_joueurs').select2({
        placeholder: 'Sélectionnez les joueurs'
    });

    $('.type_combinaison').select2({
        placeholder: 'Sélectionnez le type de combinaison à ajouter',
        width: 'resolve'
    });
})


$(document).on('click', '#add-combinaison', function(e){
    e.preventDefault()

    var idLoto = $(this).attr('data-loto-id')
})

$(document).on('click', '.reset-combinaison', function(e)
{
    e.preventDefault();

    $(this).parent().find('[type="checkbox"]').prop("checked", false);
})