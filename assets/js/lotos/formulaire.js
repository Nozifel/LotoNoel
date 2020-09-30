import $ from 'jquery';

$('#loto_joueurs').select2({
    placeholder: 'Sélectionnez les joueurs'
});

$(document).on('click', '#add-combinaison', function(e){
    e.preventDefault()

    var idLoto = $(this).attr('data-loto-id')
})

$(document).on('click', '.reset-combinaison', function(e)
{
    e.preventDefault();

    $(this).parent().find('[type="checkbox"]').prop("checked", false);
})