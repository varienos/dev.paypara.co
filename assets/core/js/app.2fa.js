const twoFA = {
    init: function() {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toastr-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "3000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        $('[verify]').on('click', function(e) {
            if ($("[verificationCode]").val() != "" && $("[verificationCode]").val().length >= 6) {
                twoFA.authorization().then(response => {
                    if (response == 200) {
                        window.location = window.location.protocol + "//" + window.location.hostname + "/dashboard/success";
                    }
                }).catch(e => {
                    toastr.error("Kod doğrulanamadı. Tekrar deneyiniz.");
                });
            } else {
                toastr.error("6 rakamlı doğrulama kodunu giriniz !");
            }
        });
    },
    authorization: function() {
        return new Promise(function(resolve, reject) {
            if ($("[verificationCode]")) {
                var xhttp = new XMLHttpRequest();
                xhttp.open("GET", window.location.protocol + "//" + window.location.hostname + "/secure/2fa/verify/" + $("[verificationCode]").val(), true);
                xhttp.onload = function() {
                    if (this.status == 200) {
                        resolve(this.status);
                    } else {
                        reject(this.status);
                    }
                };
                xhttp.send();
            }
        });
    }
};
$(function() {
    twoFA.init();
});