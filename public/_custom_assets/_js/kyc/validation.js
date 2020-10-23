const API_URL = "http://crm.test/api/";
var card = null;

function renderVerifyButton(){
    const element = document.getElementById("passbase-button");
    const apiKey = "OBQjHmUWwd1NR4mCIBufUP4i3oHzdRIOMqimkROM5vWETmIqGZyeCsfvRSl4OI9v"; // current key: sandbox
    const userId = "123456";
    // const onFinished = (identityAccessKey) => {
    //     $("#ver_key").val(identityAccessKey);
    //     Swal.fire({
    //         title: "Success",
    //         text: "Thank you for verifying yourself, You can proceed now.",
    //         icon: "info",
    //         showCancelButton: false,
    //         confirmButtonText: "Okay!",
    //         customClass: {
    //             confirmButton: "btn btn-success",
    //         }
    //     }).then(function(result) {
    //         if (result.value) {
    //             // update the verification key text field
    //             const body = {
    //                 authKey: identityAccessKey,
    //                 kid: $("body").data("kid"),
    //                 lid: $("body").data("lid")
    //             };
    //             // update via api
    //             $.ajax({
    //                 url: "/api/kyclist/update",
    //                 type: "POST",
    //                 dataType: "json",
    //                 data: {
    //                     body: body
    //                 },
    //                 success: function(result, status, xhr){
    //                     console.log(result);
    //                     // reload table
    //                     if(result.status == "success"){
    //                         notify("Success", "Thank you!, You can proceed now!", "success");
    //                     }
    //                 },
    //                 error: function(xhr, status, error){
    //                     console.log(xhr);
    //                 }
    //             });
    //         }
    //     });
    // };
    const onFinished = (error, authKey, additionalAttributes) => {
        var identityAccessKey = authKey;
        var isError = true;
        if(error) {
            console.log(error);
        }else{
            $("#ver_key").val(identityAccessKey);
            KTApp.block(card.getSelf(), {
                type: 'loader',
                state: 'success',
                message: 'Please wait...'
            });

            getDataFromPB();
        }
    }
    // TODO for version 2
    // Passbase.renderButton(element, apiKey, {
    //     onFinish: onFinished,
    //     onError: (errorCode) => { console.log(errorCode) },
    //     onStart: () => {},
    //     prefillAttributes: {
    //         country: "en",
    //     },
    //     additionalAttributes: {
    //         customer_user_id: "SOME_USER_ID"
    //     }
    // })

    Passbase.renderButton(element, onFinished, apiKey, {
        integrationType: "signup",
        prefillAttributes: {
            country: "en",
        },
        theme: {
            accentColor: "",
            font: "Arial",
        },
    });
}

$(document).ready(function() {
    renderVerifyButton();
    card = new KTCard('kyc_card');

});

function getDataFromPB() {
    const body = {
        authKey: $("#ver_key").val()
    };
    $.ajax({
        url: "/api/kyclist/get",
        type: "POST",
        dataType: "json",
        data: {
            body: body
        },
        success: function(result, status, xhr){
            console.log(result);
            if(result.status == "success"){
                KTApp.unblock(card.getSelf());
                if(result.message.authentication.additional_attributes.identifier){
                    $("#user_email").val(result.message.authentication.additional_attributes.identifier);
                }

                Swal.fire({
                    title: "Success",
                    text: "Thank you for verifying yourself, You can proceed now.",
                    icon: "info",
                    showCancelButton: false,
                    confirmButtonText: "Okay!",
                    customClass: {
                        confirmButton: "btn btn-success",
                    }
                }).then(function(result) {
                    if (result.value) {
                        // update the verification key text field
                        const body = {
                            authKey: $("#ver_key").val(),
                            kid: $("body").data("kid"),
                            lid: $("body").data("lid"),
                        };
                        // update via api
                        $.ajax({
                            url: "/api/kyclist/update",
                            type: "POST",
                            dataType: "json",
                            data: {
                                body: body
                            },
                            success: function(result, status, xhr){
                                // reload table
                                console.log(result);
                            },
                            error: function(xhr, status, error){
                                console.log(xhr);
                            }
                        });
                    }
                });
            }else if(result.status == "error"){
                setTimeout(function() {
                    getDataFromPB();
                }, 3000);
            }
        },
        error: function(xhr, status, error){
            console.log(xhr);
        }
    });
}
