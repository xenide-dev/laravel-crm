"use strict";
// Class definition

var ListDatatable = function () {



    // Private functions
    var initSubmitReport = function () {
        tinymce.init({
            selector: '#tinymce-body',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | preview',
            plugins : 'advlist autolink link lists charmap preview',
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
    ListDatatable.init();
});
$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
        e.stopImmediatePropagation();
    }
});
