"use strict";
// Class definition

var TinyMCE = function () {
    // Private functions
    var initSubmitReport = function () {
        tinymce.init({
            selector: '#tinymce-body',
            toolbar: 'advlist | autolink | link image | lists charmap | print preview',
            plugins : 'advlist autolink link image lists charmap print preview'
        });
    }

    return {
        // public functions
        init: function() {
            initSubmitReport();
        }
    };
}();

// Initialization
jQuery(document).ready(function() {
    TinyMCE.init();
});
