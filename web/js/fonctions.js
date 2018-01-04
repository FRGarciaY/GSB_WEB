// Autocomplete
$(document).ready(function(){
    $('#form_nomPraticien').keyup(function(){
        $('.selectionPraticien').remove();
        $('#form_praticien').val('');
        valeur = $('#form_nomPraticien').val();
        $('#form_praticien').val(null);
        $.ajax({
            url: 'Autocomplete',
            type: 'POST',
            data: 'valeur=' + valeur,
            success: function(data){
                resultat = data;
                if($('.selectionPraticien')){
                    $('.selectionPraticien').remove();
                }
                html = "<select id='selectionPraticien' class='col-xs-12 text-center selectionPraticien'><option disabled selected>Liste des praticients correspondant</option>";
                for(i=0; i<resultat.length; i++){
                    html+= "<option id='"+resultat[i]['id']+"' class='choixPraticien'>"+resultat[i]['prenom']+" "+resultat[i]['nom']+"</option>";
                }
                html+="</select>";
                $('#form_nomPraticien').after(html);
                selection();
            }
        });
    });
});
// Au focus dans l'input $('#form_nomPraticien'), on efface son contenu
$(document).ready(function(){
    $('#form_nomPraticien').focus(function(){
        $(this).val('');
        $('#form_praticien').val('');
    });
    // Faire disparaitre les messages apres un delai
    $('.flash-notice').delay(3000).hide(1000);
    // Verification de la valeur du champ form_qteOfferte
    $('#form_qteOfferte').keyup(function(){
       value = $(this).val();
       nbChiffre = $(this).val().length;
       if((value == "") || (value < 1 )){
            $(this).addClass('erreur');
            $('#form_Continuer').attr('disabled', true).addClass('desactive');
            $('#form_Valider').attr('disabled', true).addClass('desactive');
            $('#message_erreur').remove();
            $('#Qte').after('<div id="message_erreur" class="row"><div class="col-xs-12 alert alert-danger">La quantité offerte ne peut pas être vide ou égale à zéro !</div></div>');
       }else if(!$.isNumeric(value)){
            $(this).addClass('erreur');
            $('#form_Continuer').attr('disabled', true).addClass('desactive');
            $('#form_Valider').attr('disabled', true).addClass('desactive');
            $('#message_erreur').remove();
            $('#Qte').after('<div id="message_erreur" class="row"><div class="col-xs-12 alert alert-danger">La quantité offerte ne peut contenir que des chiffres</div></div>');
        }else if(nbChiffre > 11 ){
            $(this).addClass('erreur');
            $('#form_Continuer').attr('disabled', true).addClass('desactive');
            $('#form_Valider').attr('disabled', true).addClass('desactive');
            $('#message_erreur').remove();
            $('#Qte').after('<div id="message_erreur" class="row"><div class="col-xs-12 alert alert-danger">La quantité offerte ne peut contenir que 11 chiffres</div></div>');
        }else{
            $(this).removeClass('erreur');
            $('#form_Continuer').attr('disabled', false).removeClass('desactive');  
            $('#form_Valider').attr('disabled', false).removeClass('desactive');
            $('#message_erreur').remove();
       }
    });
});


//
// Fonctions
// 
// Verifier si un echantillon est selectionné
function verifChecked(){
    if ($('#form_medicament option:checked').length > 0){
        return true;
    }else{
        $( "#message" ).show().delay(3000).hide(1000);
        return false;
    }
}
function verifCheckedSupp(){
    if(verifChecked()){
        return confirmation()
    }
    
}
// Selection dans la liste de choix de l'autocomplete
function selection(){
    $('#selectionPraticien').ready(function(){
        $('#selectionPraticien').change(function(){
            optionSelected = $(this).find(".choixPraticien:selected");
            idPraticien = optionSelected.attr('id');
            nomPraticien = optionSelected.val();
            $('#form_nomPraticien').val(nomPraticien);
            $('#form_praticien').val(idPraticien);
            $('#selectionPraticien').remove();
        });
    });
};
function confirmation(){
    if(confirm('Etes-vous sûr de vouloir supprimer cet échantillon')){
        return true;
    }else{
        return false;
    }
}