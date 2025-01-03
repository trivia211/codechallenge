(function(_this) {
    // options: see setAlertDefaultOptions except htmlMessage.
    _this.showAjaxErrorAlert = function(jqXHR, errorThrown, options = {}) {
        let error = "";
        if ( typeof jqXHR.responseJSON === 'string' ) {
            error = jqXHR.responseJSON;
        } else if ( jqXHR.responseJSON !== undefined && jqXHR.responseJSON.message !== undefined ) {
            error = jqXHR.responseJSON.message;
            if ( jqXHR.responseJSON.htmlMessage )
                options.htmlMessage = true;
            if ( jqXHR.responseJSON.title !== undefined )
                options.title = jqXHR.responseJSON.title;
            if ( jqXHR.responseJSON.htmlTitle )
                options.htmlTitle = true;
        } else if ( errorThrown instanceof Error )
            error = errorThrown.message;
        else if ( typeof errorThrown === 'string' )
            error = errorThrown;
        if ( error === "" )
            error = "Error";
        _this.showErrorAlert(error, options);
    }

    // options: see setAlertDefaultOptions
    _this.showErrorAlert = function(error, options = {}) {
        options.alertClass = 'alert-danger';
        showAlert(error, options);
    }

    // options: see setAlertDefaultOptions
    _this.showSuccessAlert = function(message, options = {}) {
        options.alertClass = 'alert-success';
        showAlert(message, options);
    }

    _this.htmlEncode = function(val) {
        return String(val).replace(/&/g, "&amp;").replace(/</g, "&lt;").replace(/>/g, "&gt;")
            .replace(/"/g, "&quot;").replace(/'/g, "&#039;");
    }
    _this.htmlDecode = function(val) {
        return $('<textarea>').html(val).text();
    }


    // options: see setAlertDefaultOptions + alertClass
    function showAlert(message, options) {
        setAlertDefaultOptions(options);
        let alertHtml = '<button type="button" class="btn-close" data-bs-dismiss="alert" ' +
            'aria-label="Close"></button>';
        if ( options.title !== null ) {
            alertHtml += '<h6 class="alert-heading">';
            alertHtml += (options.htmlTitle ? options.title : htmlEncode(options.title));
            alertHtml += '</h6>';
        }
        if ( options.htmlMessage )
            alertHtml += message;
        else
            alertHtml += '<p>' + htmlEncode(message) + '</p>';
        options.alertDiv
            .attr('class', 'alert ' + options.alertClass + ' alert-dismissible fade show')
            .attr('role', 'alert')
            .html(alertHtml);
        if ( options.scrollTo === 'top' )
            scrollTo(0, 0);
        else if ( options.scrollTo === 'alert' ) {
            options.alertDiv.css('scroll-margin-top', $(".navbar").outerHeight(true) + 'px');
            options.alertDiv[0].scrollIntoViewIfNeeded();
        }
    }

    function setAlertDefaultOptions(options) {
        if ( options.alertDiv === undefined )
            options.alertDiv = $("#alert");
        if ( options.title === undefined )
            options.title = null;
        if ( options.htmlMessage === undefined ) // does message have html formatting?
            options.htmlMessage = false;
        if ( options.htmlTitle === undefined ) // does title have html formatting?
            options.htmlTitle = false;
        if ( options.scrollTo === undefined ) // can be 'top', 'alert' or 'none'
            options.scrollTo = 'top';
    }
})(window.cmn = window.cmn || {});

if ( !Element.prototype.scrollIntoViewIfNeeded )
    // must be called with centerIfNeeded = false for consistent behaviour
    Element.prototype.scrollIntoViewIfNeeded = function ( centerIfNeeded = true ) {
        const el = this;
        new IntersectionObserver( function( [entry] ) {
            const ratio = entry.intersectionRatio;
            if (ratio < 1)
                el.scrollIntoView(true);
            this.disconnect();
        } ).observe(this);
    };

const htmlEncode = cmn.htmlEncode;
const htmlDecode = cmn.htmlDecode;
