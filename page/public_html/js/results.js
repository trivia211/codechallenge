const resultsAjx = $.ajax({
    url: "/api/results.php",
    method: 'get',
    dataType: 'json'
});

$(document).ready(function() {
    resultsAjx
    .done(function(results) {
        let table = $(".results-table");
        let tHeadTr = table.find("thead tr");
        tHeadTr.empty().append($('<th></th>').attr('scope', 'col'));
        for ( const challenge of results.challenges )
            tHeadTr.append($('<th></th>').attr('scope', 'col').text(challenge.title));
        let tBody = table.find("tbody");
        tBody.empty();
        for ( const player of results.players ) {
            let tr = $('<tr></tr>');
            tr.append($('<th></th>').attr('scope', 'row').text(player.name));
            for ( const challenge of results.challenges ) {
                let td = $('<td></td>')
                    .css('background-image', 'url("/img/' + challenge.name + '/badge-bg.jpg")');
                if ( results.results[player.id] !== undefined &&
                        results.results[player.id][challenge.id] !== undefined ) {
                    let result = results.results[player.id][challenge.id];
                    let badge = results.badges[result];
                    let img = $('<img></img>')
                        .attr('src', badge.img)
                        .css('width', badge.width + "%");
                    td.append(img);
                }
                tr.append(td);
            }
            tBody.append(tr);
        }
    })
    .fail(function(jqXHR, textstatus, errorThrown) {
        const opts = {title: 'Nem sikerült betölteni az eredményeket.', append: true};
        cmn.showAjaxErrorAlert(jqXHR, errorThrown, opts);
    });
});
