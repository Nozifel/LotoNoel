import $ from 'jquery';
$(document).on('change', '.type_combinaison', function(){
    var bloc = $(this).closest('form')
    var val = $(this).val()

    bloc.find('[class^="choix"]').hide()

    switch (val) {
        case '1_ligne':
            break;

        case '1_colonne':
            break;

        case 'combinaison':
            bloc.find('.choix-combinaison').show()
            break;

        case 'numero':
            bloc.find('.choix-numero').show()
            break;

        case 'ordre':
            bloc.find('.choix-ordre').show()
            break;
    }
})
