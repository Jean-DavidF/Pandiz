/*Template.navbar.events({
    'click #menu-icon': function (e) {
        $("#menu-open").removeClass('displaynone');
    },
    'click #cross-icon': function (e) {
        $("#menu-open").addClass('displaynone');
    },
    'click .menu-button': function(e) {
        $("#menu-open").addClass('displaynone');
    },
});*/

$(document).ready(function() {
    $(document).on('click', "#menu-icon", function() {
        $("#menu-open").removeClass('displaynone');
    });
    
    $(document).on('click', '#cross-icon', function() {
        $("#menu-open").addClass('displaynone'); 
    });
    
    $(document).on('click', '.menu-button', function() {
        $("#menu-open").addClass('displaynone'); 
    });
    
    $(document).on('click', '.listen', function() {
        $("#player").removeClass('displaynone');
    });
    
    
    $('#files-photo').change(function() {
        $('#formavatar').submit();
    });
    
    $('#files-banner').change(function() {
        $('#formbanner').submit();
    });

    $('#banner-user').mouseenter(function(){
        $('#btn-add-banner').css({
            'opacity' : '1',
        });
    });

    $('#banner-user').mouseleave(function(){
        $('#btn-add-banner').css({
            'opacity' : '0',
        });
    });
    
});

// RECUPARATION NOM SELECTION

function recup() {
    var select = document.getElementById('select-filter');
    var paragraph = document.getElementById('le-titre');
    paragraph.innerHTML=select.value;
}
$(document).ready(function() {
    recup();
});