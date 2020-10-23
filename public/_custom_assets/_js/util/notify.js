function notify(title = "", message, type = "success") {
    var icon_name = "fas fa-check-circle";
    if(type == "danger"){
        icon_name = "fas fa-times-circle";
    }else if(type == "warning"){
        icon_name = "fas fa-exclamation-triangle";
    }else if(type == "info") {
        icon_name = "fas fa-exclamation-circle";
    }
    var content = {
        title: title,
        icon: 'icon ' + icon_name,
        message: message
    };

    var notify = $.notify(content, {
        type: type,
        allow_dismiss: true,
        newest_on_top: true,
        timer: 5000,
        z_index: 10000,
        animate: {
            enter: 'animate__animated animate__swing',
            exit: 'animate__animated animate__fadeOut'
        }
    });
}
