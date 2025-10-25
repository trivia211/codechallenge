const playersAjx = $.ajax({
    url: "/api/players.php",
    method: 'get',
    dataType: 'json'
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
        const opts = {title: 'Nem sikerült betölteni a játékosokat.', append: true};
        cmn.showAjaxErrorAlert(jqXHR, errorThrown, opts);
    });

    $(".solution-form").submit(function(e) {
        e.preventDefault();
        let form = $(this);
        let alertOpts = {
            alertDiv: form.find('.solution-alert'),
            scrollTo: 'alert'
        }
        cmn.submitFormAjax(form)
        .done(function(response) {
            if ( response === true ) {
                cmn.showSuccessAlert('Sikeresen beküldted a megoldást! Kis türelmedet kérem, amíg ' +
                    'megnézem!', alertOpts);
                form.find('textarea[name="code"]').val('');
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown) {
            alertOpts.title = 'Nem sikerült elküldeni a megoldást.';
            cmn.showAjaxErrorAlert(jqXHR, errorThrown, alertOpts);
        });
    });
});
