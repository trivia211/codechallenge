const playersAjx = $.ajax({
    url: "/api/players.php",
    method: 'get',
    dataType: 'json',
});

$(document).ready(function() {
    playersAjx
    .done(function(players) {
        let selects = $(".solution-form .player-select");
        selects.empty();
        selects.append('<option selected disabled hidden value="">Ki vagy?</option>');
        for ( let player of players )
            selects.append($('<option></option>').val(player.id).text(player.name));
    })
    .fail(function(jqXHR, textstatus, errorThrown) {
        cmn.showAjaxErrorAlert(jqXHR, errorThrown, {title: 'Nem sikerült betölteni a játékosokat.'});
    });

    $(".solution-form").submit(function(e) {
        e.preventDefault();
        let data = new FormData(this);
        let alertOpts = {
            alertDiv: $(this).find('.solution-alert'),
            scrollTo: 'alert'
        }
        $.ajax({
            url: "/process/controls-server.php",
            method: 'post',
            data: data,
            dataType: 'json',
            processData: false,
            contentType: false
        })
        .done(function(response) {
            if ( response === true )
                cmn.showSuccessAlert('Sikeresen beküldted a megoldást!', alertOpts);
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            alertOpts.title = 'Nem sikerült elküldeni a megoldást.';
            cmn.showAjaxErrorAlert(jqXHR, errorThrown, alertOpts);
        });
    });
});
