function _(elem) {
    return document.getElementById(elem);
}

function uploadFile() {
    var file = _("fileload").files[0];
    if(!checkSize(file.size) || !checkType(file.type)){
        return ;
    };
    var formdata = new FormData();

    jQuery.each($('#fileload')[0].files, function(i, file) {
        formdata.append('fileload', file);
    });

    $.ajax({
        type: "POST",
        url: "php/upload.php",
        data: formdata,
        processData: false,
        contentType: false,
        xhr: function() {
            var ajax = new window.XMLHttpRequest();
            ajax.upload.addEventListener("progress", progressHandler, false);
            // ajax.addEventListener("load", completeHandler, false);
            ajax.addEventListener("error", errorHandler, false);
            ajax.addEventListener("abort", abortHandler, false);
            return ajax;
        },
        success: function (data) {
            _("progressBar").value = 100;
            _("progressBar").style.width = "100%";
            _("status").innerHTML = "Завершено";
        },
        always:function (data) {
            result = JSON.parse(data);
            _("status").innerHTML = result.text;
        }
    });
}

function progressHandler(event) {
    var percent = (event.loaded / event.total) * 100;
    _("progressBar").value = Math.round(percent);
    _("progressBar").style.width = Math.round(percent) + "%";
}
//
// function completeHandler(event) {
//     _("progressBar").value = 100;
//     _("progressBar").style.width = "100%";
//     _("status").innerHTML = "Завершено";
// }

function errorHandler(event) {
    _("status").innerHTML = "Помилка завантаження файлу";
}

function abortHandler(event) {
    _("status").innerHTML = "Ви відмінили завантаження";
}

function checkSize(file_size) {
    var maxsize = 28311552;
    if (file_size > maxsize) {
        _("status").innerHTML = "Файл надто великий!!!";
        return false;
    }
    return true;
}

function checkType(file_type) {
    var acceptable = ["image/jpeg",
                        "image/jpg",
                        "image/png",
                        "image/gif",
                        "application/pdf"];
    if (acceptable.indexOf(file_type) == -1){
        _("status").innerHTML = "Неправильне розширення файлу";
        return false;
    }
    return true;
}

// FORM
$(document).ready(function () {
    $("form").submit(function (event) {
        event.preventDefault();
        var fullname = $("#fullname").val();
        var email = $("#email").val();
        var address = $("#address").val();
        var postindex = $("#postindex").val();
        var study = $("#study").val();
        $("#form-result").load("php/form.php", {
            fullname: fullname,
            email: email,
            address: address,
            postindex: postindex,
            study: study
        });
    });
});