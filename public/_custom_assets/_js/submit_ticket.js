"use strict";

var datatable_name_id = "list-datatable";
var tagifyTo = null;
var whitelistJSON = [];
var frm_Item = "frmCreateItem";
var frmValidation = null;

// Class definition
var ListDatatable = function () {
    function convertToSlug(text)
    {
        return text
            .toLowerCase()
            .replace(/[^\w ]+/g,'')
            .replace(/ +/g,'-')
            ;
    }

    var table = $('#' + datatable_name_id);

    var initTable1 = function() {
        // begin first table
        table.DataTable({
            responsive: true,
            // searchDelay: 500,
            ajax: {
                url: "/api/list/tickets",
                type: 'POST',
                data: {
                    api_token: document.querySelector("meta[name='at']").getAttribute("content")
                },
            },
            columns: [
                {data: 'id'},
                {data: 'created_at'},
                {data: 'input_names'},
                {data: 'status'},
                {data: 'options', responsivePriority: -1},
            ],
            columnDefs: [
                {
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return `
							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Edit details">
								<i class="la la-edit"></i>
							</a>` + (!full.iM ? `
							<a href="javascript:;" class="btn btn-sm btn-clean btn-icon" title="Delete">
								<i class="la la-trash text-danger"></i>
							</a>`: '');
                    },
                },
            ],
        });
    };

    var initWhitelist = function() {
        $.ajax({
            url: "/api/basicload/reported",
            type: "POST",
            dataType: "json",
            data: {
                api_token: document.querySelector("meta[name='at']").getAttribute("content")
            },
            success: function(result, status, xhr){
                whitelistJSON = result;
            },
            error: function(xhr, status, error){
                console.log(xhr);
            }
        });
    }

    var tagify = function() {
        // Init autocompletes
        var toEl = document.getElementById('report_names');
        tagifyTo = new Tagify(toEl, {
            delimiters: ", ", // add new tags when a comma or a space character is entered
            keepInvalidTags: true, // do not remove invalid tags (but keep them marked as invalid)
            whitelist: whitelistJSON,
            templates: {
                dropdownItem : function(tagData){
                    try {
                        var html = '';

                        html += '<div class="tagify__dropdown__item">';
                        html += '   <div class="d-flex align-items-center">';
                        html += '       <div class="d-flex flex-column">';
                        html += '           <a href="#" class="text-dark-75 text-hover-primary font-weight-bold">'+ (tagData.value ? tagData.value : '') + '</a>';
                        html += '           <span class="text-muted font-weight-bold">ID Number: ' + (tagData.id_number ? tagData.id_number : '') + '</span>';
                        html += '           <span class="text-danger font-weight-bold">Active Case: ' + tagData.active_case + '</span>';
                        html += '       </div>';
                        html += '   </div>';
                        html += '</div>';

                        return html;
                    } catch (err) {}
                }
            },
            transformTag: function(tagData) {
                tagData.class = 'tagify__tag tagify__tag--primary';
            },
            dropdown : {
                classname : "color-blue",
                enabled   : 1,
                maxItems  : 5
            }
        });
        tagifyTo.on('add', function(e){
            var template = `<div id="node-${convertToSlug(e.detail.data.value)}">
                                <p>For <b>${e.detail.data.value}</b>:</p>
                                <ul>
                                    <li>Organization: <i>change this line</i></li>
                                    <li>Body message: <i>change this line</i></li>
                                    ${e.detail.data.id ? '' : `<li>ID Number: <i>change this line</i></li>` }
                                </ul>
                           </div>`;
            tinymce.activeEditor.setContent(tinymce.activeEditor.getContent() + template);
        });
        tagifyTo.on('remove', function(e){
            try {
                var id = "node-" + convertToSlug(e.detail.data.value);
                tinymce.activeEditor.dom.remove(id);
            }catch(err) {
                console.log(err);
            }
        });
    }
    var initSubmitReport = function () {
        tinymce.init({
            selector: '#tinymce-body',
            placeholder: 'Please enter the names first',
            toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | outdent indent | preview',
            plugins : 'advlist autolink link lists charmap preview',
        });
    }

    var initValidation = function () {
        frmValidation = FormValidation.formValidation(
            document.getElementById(frm_Item),
            {
                fields: {
                    full_names: {
                        validators: {
                            notEmpty: {
                                message: 'Names is required'
                            },
                        }
                    },
                    message: {
                        validators: {
                            notEmpty: {
                                message: 'Message is required'
                            },
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger(),
                    bootstrap: new FormValidation.plugins.Bootstrap(),
                    submitButton: new FormValidation.plugins.SubmitButton(),
                    // defaultSubmit: new FormValidation.plugins.DefaultSubmit(),
                }
            }
        );
        $("#btnSubmit").on("click", function() {
            if(frmValidation){
                frmValidation.validate().then(function(status) {
                    if(status == "Valid"){
                        Swal.fire({
                            title: "Are you sure?",
                            text: "This ticket will be submitted",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonText: "Yes, submit it now!",
                            cancelButtonText: "No, cancel!",
                            reverseButtons: true,
                            customClass: {
                                confirmButton: "btn btn-success",
                                cancelButton: "btn btn-default"
                            }
                        }).then(function(result) {
                            if (result.value) {
                                $("#" + frm_Item).submit();
                            } else if (result.dismiss === "cancel") {

                            }
                        });
                    }else{
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light"
                            }
                        });
                    }
                });
            }
        });
    }

    return {
        // public functions
        init: function() {
            initTable1();
            initSubmitReport();
        },
        initSet: function() {
            initWhitelist();
            tagify();
            initValidation();
        }
    };
}();

// Initialization
jQuery(document).ready(function() {
    ListDatatable.init();
    ListDatatable.initSet();
});
$(document).on('focusin', function(e) {
    if ($(e.target).closest(".tox-tinymce-aux, .moxman-window, .tam-assetmanager-root").length) {
        e.stopImmediatePropagation();
    }
});
