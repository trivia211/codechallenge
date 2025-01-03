const playersAjx = $.ajax({
    url: "/api/players.php",
    method: 'GET',
    dataType: 'json',
});

$(document).ready(function() {
    playersAjx
    .done(function(data) {
    })
    .fail(function(jqXHR, textstatus, errorThrown) {
        cmn.showAjaxErrorAlert(jqXHR, errorThrown, {title: 'Nem sikerült betölteni a játékosokat.'});
    });
});
