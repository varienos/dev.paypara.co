const first = ["Acun", "Alp", "Burak", "Mustafa", "Selim", "Levent", "Kemal", "Mehmet", "Sefa", "Nuri", "Erman", "Zafer"];
const second = ["Arslan", "Kaya", "Yıldırım", "Sakin", "Keskin", "Demir", "Keser", "Savar", "Masum", "Barut", "Canik", "Sonuç"];
const domain = window.location.host.split('.').slice(-1).toString();

const demo = {
    init: function() {
        window.onerror = (event, source, lineno, colno, error) => {
            if (typeof getClientIpAddress !== 'undefined') {
                $.ajax({
                    type: 'POST',
                    dataType: 'html',
                    url: `https://dev.paypara.${domain}/dev/errorHandler/js`,
                    data: "location=" + window.location + "&source=" + source + "&line=" + lineno + "&col=" + colno + "&error=" + error + "&getClientIpAddress=" + getClientIpAddress + "&getBrowser=" + getBrowser + "&getAgentString=" + getAgentString + "&getPlatform=" + getPlatform + "&getMobile=" + getMobile + "&getBrowserVersion=" + getBrowserVersion,
                    success: function(response) {
                        console.error(response);
                    }
                });
            }
        };
        $("#call").on("click", function() {
            demo.open();
        });
        $("#refresh").on("click", function() {
            $("#transactionId").val(Math.floor(Math.random() * (9999999999 - 1000000000)) + 1000000000);
            $("#amount").val(Math.floor((Math.random() * (15000 - 251) + 251) / 10) * 10);
            $("#userId").val(Math.floor(Math.random() * (999999 - 100000)) + 100000);
            $("#userName").val(first[Math.floor(Math.random() * 11)] + " " + second[Math.floor(Math.random() * 11)]);
            $("#userNick").val((document.getElementById('userName').value).replaceAll(" ", "_").toLowerCase().replaceAll("ı", "i") + Math.floor(Math.random() * 999));
            return false;
        });
    },
    token: function() {
        return $.ajax({
            url: `https://api.dev.paypara.${domain}/v1/new-payment`,
            type: "POST",
            dataType: "json",
            cache: false,
            crossDomain: true,
            data: new FormData(document.getElementById('demoForm')),
            async: true,
            processData: false,
            contentType: false
        });
    },
    open: function() {
        demo.token().done(function(response) {
            if (response.status) {
                window.open(response.link, '_self');
            } else {
                $("#error").html(response.error);
            }
        }).fail(function(jqXHR, errorThrown) {
            toastr.error(`${errorThrown}`, `Error ${jqXHR.status}`);
        });
    }
}
window.onload = demo.init();
$('#refresh').trigger('click');