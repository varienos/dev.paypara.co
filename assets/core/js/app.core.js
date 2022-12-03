$.varien = {
    boot: () => {
        return new Promise(function(resolve, reject) {
            fetch(window.location.protocol + "//" + window.location.hostname + "/json/resources").then(response => response.json()).then(json => resolve(json));
        });
    },
    init: function() {
        $.varien.prepare();
        $.varien.stage();
    },
    errorHandler: function(event, source, lineno, colno, error) {
        var xhttp = new XMLHttpRequest();
        xhttp.open("POST", "https://dev.paypara.co/dev/errorHandler/js", true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhttp.onload = () => {
            console.error(event);
            console.error('$.varien.errorHandler.source: ' + source);
            console.error('$.varien.errorHandler.source.line: ' + lineno);
            console.error('$.varien.errorHandler.source.col: ' + colno);
        };
        xhttp.send("location=" + window.location + "&source=" + source + "&line=" + lineno + "&col=" + colno + "&error=" + error + "&getClientIpAddress=" + $.resource.getClientIpAddress + "&getBrowser=" + $.resource.getBrowser + "&getAgentString=" + $.resource.getAgentString + "&getPlatform=" + $.resource.getPlatform + "&getMobile=" + $.resource.getMobile + "&getBrowserVersion=" + $.resource.getBrowserVersion);
    },
    prepare: function() {
        $.varien.authorization();
        $.varien.toastr();
        $.varien.activity();
        setInterval(function() {
            $.varien.activity();
        }, $.activityTimeOut);
    },
    stage: function() {
        if ($.varien.segment(1) == "dashboard") $.varien.dashboard.init();
        if ($.varien.segment(1) == "account") $.varien.account.init();
        if ($.varien.segment(1) == "customer") $.varien.customer.init();
        if ($.varien.segment(1) == "user") $.varien.user.init();
        if ($.varien.segment(1) == "transaction") $.varien.transaction.init();
        if ($.varien.segment(1) == "setting") $.varien.setting.init();
        if ($.varien.environment() == 'dev') $.varien.dev.init();
    },
    authorization: () => {
        $('[auth="false"]').each(function(i) {
            $(this).remove();
        });
        setTimeout(function() {
            $("body").addClass("ready");
        }, 500);
    },
    eventControl: function(e) {
        e.stopImmediatePropagation();
        e.stopPropagation();
        e.preventDefault();
    },
    environment: () => {
        $.host = window.location.host
        return $.host.split('.')[0];
    },
    activity: function() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4) {
                if (this.status == 200) {}
            }
        };
        xhttp.open("GET", 'user/activity', true);
        xhttp.send();
    },
    include: function(file, attribute) {
        return new Promise(function(resolve, reject) {
            if ($("[" + attribute + "]")) {
                var xhttp = new XMLHttpRequest();
                xhttp.open("POST", file, true);
                xhttp.onload = function() {
                    if (this.status == 200) {
                        $("[datatable-head]").html(this.responseText).promise().done(function() {
                            resolve($("#datatable_content thead tr th").length);
                        });
                    }
                    if (this.status == 404) {
                        reject({
                            status: this.status,
                            statusText: xhr.statusText
                        });
                    }
                };
                xhttp.send();
            }
        });
    },
    segment: function(key) {
        $.segment = window.location.pathname.split('/');
        if (typeof $.segment[key] !== 'undefined') {
            return $.segment[key];
        } else {
            return null;
        }
    },
    toastr: function() {
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
    },
    modal: {
        ajax: {
            element: () => {
                return $("#ajaxModal");
            },
            content: () => {
                return $("#ajaxModalContent");
            },
            preloader: () => {
                return '<div class="blockui-overlay"><span class="spinner-border text-primary"></span></div>';
            }
        },
        event: {
            load: function(url, callback) {
                $.varien.modal.event.show();
                $.varien.modal.event.hide();
                if ($(".modal.fade.show").length) {
                    $("#ajaxModalContent").html('').promise().done(function() {});
                } else {
                    $("#ajaxModal").modal('toggle');
                }
                $("#ajaxModalContent").load(url, '', function() {
                    callback();
                });
            },
            hide: function() {
                $("#ajaxModal").on('hidden.bs.modal', function(e) {
                    $("#ajaxModalContent").html('');
                    if ($(".modal-dialog").length) $(".modal-dialog").removeClass('mx-wi-p-80');
                });
            },
            show: function() {
                $("#ajaxModal").on('shown.bs.modal', function(e) {});
            },
            toggle: function() {
                $("#ajaxModal").modal('toggle');
            }
        }
    },
    datatable: {
        locale: function() {
            return {
                "emptyTable": "Kayıt yok",
                "infoEmpty": "Kayıt yok",
                "infoFiltered": "(_MAX_ Kayıt İçerisinden Bulunan)",
                "loadingRecords": "Yükleniyor...",
                "processing": "Yükleniyor...",
                "zeroRecords": "Eşleşen kayıt bulunamadı",
                "info": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor"
            };
        },
        exportEvents: () => {
            if ($('#datatableExport').length) {
                var str = '<div class="menu-item px-3">';
                str += '<a href="javascript:;" class="menu-link px-3" export-copy>Panoya Kopyala</a>';
                str += '</div>';
                str += '<div class="menu-item px-3">';
                str += '<a href="javascript:;" class="menu-link px-3" export-xls>Excel olarak aktar</a>';
                str += '</div>';
                str += '<div class="menu-item px-3">';
                str += '<a href="javascript:;" class="menu-link px-3" export-csv>CSV olarak aktar</a>';
                str += '</div>';
                str += '<div class="menu-item px-3">';
                str += '<a href="javascript:;" class="menu-link px-3" export-pdf>PDF olarak aktar</a>';
                str += '</div>';
                $('#datatableExport').html(str).promise().done(function() {
                    $('[export-csv]').on('click', function(e) {
                        e.preventDefault();
                        $(".buttons-csv ").trigger('click');
                        return false;
                    });
                    $('[export-xls]').on('click', function(e) {
                        e.preventDefault();
                        $(".buttons-excel ").trigger('click');
                        return false;
                    });
                    $('[export-copy]').on('click', function(e) {
                        e.preventDefault();
                        $(".buttons-copy ").trigger('click');
                        return false;
                    });
                    $('[export-pdf]').on('click', function(e) {
                        e.preventDefault();
                        $(".buttons-pdf ").trigger('click');
                        return false;
                    });
                    $('[export-print]').on('click', function(e) {
                        e.preventDefault();
                        $(".buttons-print ").trigger('click');
                        return false;
                    });
                });
            }
        }
    },
    dev: {
        init: function() {
            $.getScript(window.location.protocol + "//" + window.location.hostname + "/" + $.resource.gulpAssets + "/plugins/custom/css-element-queries/css.element.queries.bundle.js");
            document.addEventListener('keydown', function(event) {
                if (event.keyCode == 36) {
                    $.varien.modal.event.load("dev", function() {
                        $(".modal-dialog").addClass('mx-wi-p-80');
                        new ResizeSensor(document.getElementById('console'), function() {
                            $("#devConsole").animate({
                                scrollTop: $('#devConsole').prop("scrollHeight")
                            }, 100);
                        });
                        document.addEventListener('keydown', function(event) {
                            if (event.keyCode == 13) {
                                $('#console').append("<li class='cmdloading'>" + $("#cmd").val() + "</li>");
                                $.varien.dev.cmd($("#cmd").val());
                                $("#cmd").val('');
                            }
                        });
                    });
                }
            });
        },
        cmd: function(cmd) {
            if (cmd == "string.manage") {
                $.varien.modal.event.load('dev/string', function() {});
            } else {
                $.ajax({
                    url: window.location.protocol + "//" + window.location.hostname + "/dev/console",
                    type: "POST",
                    dataType: "html",
                    data: "cmd=" + cmd,
                    success: function(response) {
                        $('#console').append(response);
                        $('#console li').removeClass('cmdloading');
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('#console').append(jqXHR.status + "<br>" + textStatus + "<br>" + errorThrown);
                    }
                });
            }
        }
    },
    dashboard: {
        init: function() {
            var datacount = depositFetchWeekly[0].dayTotal + depositFetchWeekly[1].dayTotal + depositFetchWeekly[2].dayTotal + depositFetchWeekly[3].dayTotal + depositFetchWeekly[4].dayTotal + depositFetchWeekly[5].dayTotal + depositFetchWeekly[6].dayTotal;
            datacount += withdrawFetchWeekly[0].dayTotal + withdrawFetchWeekly[1].dayTotal + withdrawFetchWeekly[2].dayTotal + withdrawFetchWeekly[3].dayTotal + withdrawFetchWeekly[4].dayTotal + withdrawFetchWeekly[5].dayTotal + withdrawFetchWeekly[6].dayTotal;
            if (datacount > 0) {
                let element = document.getElementById('kt_apexcharts_1');
                let height = parseInt(KTUtil.css(element, 'height'));
                let labelColor = '#7E8299';
                let baseColor = '#a4d19f';
                let secondaryColor = '#e3868c';
                let options = {
                    series: [{
                        name: 'Yatırım',
                        data: [depositFetchWeekly[0].dayTotal, depositFetchWeekly[1].dayTotal, depositFetchWeekly[2].dayTotal, depositFetchWeekly[3].dayTotal, depositFetchWeekly[4].dayTotal, depositFetchWeekly[5].dayTotal, depositFetchWeekly[6].dayTotal]
                    }, {
                        name: 'Çekim',
                        data: [withdrawFetchWeekly[0].dayTotal, withdrawFetchWeekly[1].dayTotal, withdrawFetchWeekly[2].dayTotal, withdrawFetchWeekly[3].dayTotal, withdrawFetchWeekly[4].dayTotal, withdrawFetchWeekly[5].dayTotal, withdrawFetchWeekly[6].dayTotal]
                    }],
                    chart: {
                        type: 'line',
                        height: height,
                        toolbar: {
                            show: false
                        },
                        zoom: {
                            enabled: false
                        }
                    },
                    legend: {
                        show: true,
                        position: 'top',
                        horizontalAlign: 'right'
                    },
                    fill: {
                        type: 'gradient',
                        gradient: {
                            shadeIntensity: .25,
                            type: 'vertical'
                        }
                    },
                    stroke: {
                        width: 4,
                        curve: 'smooth',
                    },
                    xaxis: {
                        categories: [withdrawFetchWeekly[0].day, withdrawFetchWeekly[1].day, withdrawFetchWeekly[2].day, withdrawFetchWeekly[3].day, withdrawFetchWeekly[4].day, withdrawFetchWeekly[5].day, withdrawFetchWeekly[6].day],
                        tickPlacement: 'between',
                        axisBorder: {
                            show: false
                        },
                        axisTicks: {
                            show: false
                        },
                        labels: {
                            style: {
                                colors: labelColor,
                                fontSize: '12px',
                                fontWeight: '500'
                            }
                        },
                        tooltip: {
                            enabled: false
                        }
                    },
                    yaxis: {
                        show: false
                    },
                    tooltip: {
                        style: {
                            fontSize: '13px'
                        },
                        y: {
                            formatter: function(value) {
                                let val = Math.abs(value);
                                if (val <= 1000000) {
                                    val = (val / 1000).toFixed(0) + 'k';
                                } else {
                                    val = (val / 1000000).toFixed(2) + 'm';
                                }
                                return val;
                            }
                        }
                    },
                    colors: [baseColor, secondaryColor],
                    grid: {
                        yaxis: {
                            lines: {
                                show: false
                            }
                        },
                    }
                };
                let chart = new ApexCharts(element, options);
                chart.render();
            }
        },
    },
    account: {
        init: () => {
            //console.log("$.varien.account.init");
            if ($.varien.segment(2) == "index") {
                if ($.varien.segment(3) == "1") {
                    $("[data-page-title]").html("Normal Hesaplar");
                    $.varien.account.setType(1);
                    $.varien.include("account/include/datatableHeadNormal", "datatable-head").then(function(colNum) {
                        $.varien.account.datatable.init(colNum);
                    });
                }
                if ($.varien.segment(3) == "2") {
                    $("[data-page-title]").html("Eşleşme Hesapları");
                    $.varien.account.setType(2);
                    $.varien.include("account/include/datatableHeadMatch", "datatable-head").then(function(colNum) {
                        $.varien.account.datatable.init(colNum);
                    });
                }
                if ($.varien.segment(3) == "3") {
                    $("[data-page-title]").html("Banka Hesapları");
                    $.varien.account.setType(3);
                    $.varien.include("account/include/datatableHeadBank", "datatable-head").then(function(colNum) {
                        $.varien.account.datatable.init(colNum);
                    });
                }
            }
            if ($.varien.segment(2) == "detail") {
                $.varien.account.detail.init();
            }
        },
        detail: {
            init: function() {
                $.varien.account.detail.datatable.init();
                if ($.varien.segment(4) == "2") {
                    $.varien.account.detail.refreshMatchTotalBadge();
                    $.varien.account.detail.datatable.listDisableMatch.init();
                    $.varien.account.detail.listMatch();
                }
                $.varien.account.detail.save();
                $('input[data-set="switch"]').on("change", function() {
                    if ($(this).is(":checked") == true) {
                        $.varien.account.detail.switch("on");
                        $('input[name="status"]').val('on');
                        toastr.success("Hesap aktif duruma getirildi");
                    } else {
                        $.varien.account.detail.switch(0);
                        $('input[name="status"]').val(0);
                        toastr.error("Hesap pasif duruma getirildi");
                    }
                });
                $('#formReset').click(function() {
                    $('input[name="account_name"]').val('');
                    $('input[name="account_number"]').val('');
                    $('input[name="limitProcess"]').val('');
                    $('input[name="limitDeposit"]').val('');
                    $('select[name="perm_site[]"]').val([]).change();
                });
            },
            refreshMatchTotalBadge: function() {
                $.varien.account.detail.accountTotalMatch().done(function(response) {
                    $("span.badge.badge.badge-circle").html(response.total);
                });
            },
            customerQuery: function(s, account_id) {
                if (s.length > 3) {
                    $("#customerQuery").css("display", "");
                    $.ajax({
                        url: "account/customerQuery",
                        type: "POST",
                        dataType: "html",
                        data: "s=" + s + "&account_id=" + account_id,
                        success: function(response) {
                            if (response != "") {
                                $("#customerQuery ul").html(response);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            $("#customerQuery").html(jqXHR.status + "<br>" + textStatus + "<br>" + errorThrown);
                        }
                    });
                } else {
                    $("#customerQuery").css("display", "none");
                }
            },
            customerQueryFocusOut: function() {
                setTimeout(function() {
                    $("#customerQuery").css("display", "none");
                    $("#customerQueryInput").val("");
                }, 500);
            },
            accountTotalMatch: function() {
                return $.ajax({
                    url: "account/accountTotalMatch/" + $.varien.segment(3),
                    dataType: "json"
                });
            },
            match: function(customer_id) {
                var matchLimit = $('input[name="match_limit"]').val();
                //console.log("match");
                $.varien.account.detail.accountTotalMatch().done(function(response) {
                    var accountTotalGamerMatch = response.total;
                    if (accountTotalGamerMatch >= matchLimit) {
                        toastr.error("İlişkili Müşteri Limiti Aşılamaz !");
                        return false;
                    } else {
                        $.ajax({
                            url: "account/match/" + $.varien.segment(3),
                            type: "POST",
                            dataType: "html",
                            data: "customer_id=" + customer_id,
                            success: function() {
                                toastr.success("Müşteri Hesap ile Eşleştirildi !");
                                $.varien.account.detail.listMatch();
                                //$.varien.account.detail.listDisableMatch();
                                $.varien.account.detail.datatable.listDisableMatch.reload();
                                $.varien.account.detail.refreshMatchTotalBadge();
                            }
                        });
                    }
                });
            },
            removeMatch: function(id) {
                $.ajax({
                    url: "account/removeMatch/" + id,
                    dataType: "html",
                    success: function() {
                        $.varien.account.detail.listMatch();
                        //$.varien.account.detail.listDisableMatch();
                        $.varien.account.detail.datatable.listDisableMatch.reload();
                        $.varien.account.detail.refreshMatchTotalBadge();
                    }
                });
            },
            listMatch: function() {
                $.ajax({
                    dataType: 'html',
                    url: "account/listMatch/" + $.varien.segment(3),
                    success: function(response) {
                        if ($("#listMatch").length) $("#listMatch").html(response);
                    }
                });
            },
            listDisableMatch: function() {
                $.ajax({
                    dataType: 'html',
                    url: "account/listDisableMatch/" + $.varien.segment(3),
                    success: function(response) {
                        if ($("#listDisableMatch").length) $("#listDisableMatch").html(response);
                    }
                });
            },
            switch: function(status) {
                $.ajax({
                    url: "account/status/" + $.varien.segment(3) + "/" + status,
                    type: "POST",
                    dataType: "html",
                    cache: false
                });
            },
            datatable: {
                init: function() {
                    $('button#filtre').css("width", "130px");
                    $('input#transactionDate').css("width", "210px");
                    $.table = new DataTable('#accountTransactions', {
                        bStateSave: false,
                        language: $.varien.datatable.locale(),
                        dom: '<"#dtExportButtonsWrapper"B>rt<"row"<"col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"li><"col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"p>>',
                        buttons: ['copy', 'csv', 'excel', 'pdf'],
                        stateSave: false,
                        lengthMenu: [10, 25, 50, 100],
                        order: [0, 'desc'],
                        searching: true,
                        ordering: true,
                        processing: true,
                        serverSide: true,
                        pageLength: 10,
                        ajax: {
                            url: 'account/transaction/' + $.varien.segment(3),
                            type: 'POST',
                            data: function(d) {
                                d.transactionDate = $("#transactionDate").val();
                            }
                        }
                    });
                    $('#search').on('keyup', function() {
                        $.table.search(this.value).draw();
                    });
                    $("#transactionDate").on("change", function() {
                        $.table.ajax.reload();
                    });
                    $.varien.account.detail.datatable.dateSelect();
                    $.varien.account.detail.datatable.onLoad();
                },
                listDisableMatch: {
                    init: function() {
                        $.tableListDisableMatch = new DataTable('#listDisableMatch', {
                            bStateSave: false,
                            language: $.varien.datatable.locale(),
                            dom: '<"#dtExportButtonsWrapper"B>rt<"row"<"col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"li><"col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"p>>',
                            buttons: ['copy', 'csv', 'excel', 'pdf'],
                            stateSave: false,
                            lengthMenu: [10, 25, 50, 100],
                            order: [0, 'desc'],
                            searching: false,
                            ordering: false,
                            processing: true,
                            serverSide: true,
                            pageLength: 10,
                            ajax: {
                                url: 'account/listDisableMatch/' + $.varien.segment(3),
                            }
                        });
                        $.varien.account.detail.datatable.listDisableMatch.onLoad();
                    },
                    reload: function() {
                        $.tableListDisableMatch.ajax.reload();
                    },
                    onLoad: function() {
                        $.tableListDisableMatch.on('draw', function() {});
                    },
                },
                onLoad: function() {
                    $.table.on('draw', function() {
                        setTimeout(function() {
                            $.varien.datatable.exportEvents();
                        }, 300);
                    });
                },
                dateSelect: function() {
                    $("#transactionDate").css("text-align", "center");
                    let start = moment().startOf("month");
                    let end = moment().endOf("month");

                    function cb(start, end) {
                        $("#transactionDate").html(start.format("DD.MM.YYYY") + " - " + end.format("DD.MM.YYYY"));
                    }
                    $("#transactionDate").daterangepicker({
                        startDate: start,
                        endDate: end,
                        ranges: {
                            "Bugün": [moment(), moment()],
                            "Dün": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                            "Son 7 Gün": [moment().subtract(6, "days"), moment()],
                            "Bu Ay": [moment().startOf("month"), moment().endOf("month")],
                            "Geçen Ay": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                        },
                        "locale": {
                            "format": "DD/MM/YYYY",
                            "separator": " - ",
                            "applyLabel": "Uygula",
                            "cancelLabel": "Vazgeç",
                            "customRangeLabel": "Özel Aralık",
                            "daysOfWeek": ["Pzt", "Sal", "Çar", "Per", "Cum", "Cmt", "Paz"],
                            "monthNames": ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
                            "firstDay": 1
                        },
                    }, cb);
                    cb(start, end);
                }
            },
            save: function() {
                $("form#modalForm").on('submit', (function(e) {
                    $.varien.eventControl(e);
                    $.ajax({
                        url: "account/save",
                        type: "POST",
                        dataType: "html",
                        crossDomain: true,
                        data: new FormData(this),
                        xhrFields: {
                            withCredentials: true
                        },
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            toastr.success("Hesap güncellendi");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            Swal.fire({
                                text: "XHR ERROR - " + jqXHR.status + " " + textStatus + " " + errorThrown,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "kapat",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    });
                }));
            }
        },
        getType: function() {
            return $("[data-account-type]").attr("data-account-type");
        },
        setType: function(dataType) {
            $("[data-account-type]").attr("data-account-type", dataType);
        },
        datatable: {
            init: (colNum) => {
                if ($.varien.segment(3) == "1") $.notOrderCols = [colNum - 1];
                if ($.varien.segment(3) == "2") $.notOrderCols = [colNum - 1];
                if ($.varien.segment(3) == "3") $.notOrderCols = [colNum - 1];
                if ($.resource.edit_papara_account != 1 && $.resource.delete_papara_account != 1 && ($.varien.segment(3) == "1" || $.varien.segment(3) == "2")) $.noVisibleCols = [colNum - 1];
                if ($.resource.edit_bank_account != 1 && $.resource.delete_bank_account != 1 && $.varien.segment(3) == "3") $.noVisibleCols = [colNum - 1];
                $.table = new DataTable('#datatable_content', {
                    bStateSave: false,
                    language: $.varien.datatable.locale(),
                    dom: '<"#dtExportButtonsWrapper"B>rt<"row"<"col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"li><"col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"p>>',
                    buttons: ['copy', 'csv', 'excel', 'pdf'],
                    stateSave: false,
                    lengthMenu: [10, 25, 50, 100],
                    columnDefs: [{
                        orderable: false,
                        targets: (Array.isArray($.notOrderCols) == true ? $.notOrderCols : [])
                    }, {
                        targets: (Array.isArray($.noVisibleCols) == true ? $.noVisibleCols : []),
                        visible: false
                    }],
                    searching: true,
                    ordering: true,
                    processing: true,
                    serverSide: true,
                    pageLength: 10,
                    ajax: {
                        url: 'account/datatable/' + $.varien.segment(3),
                        type: 'POST',
                        data: $('#formFilter').serializeArray()
                    }
                });
                $.varien.account.datatable.onLoad();
                $('#search').on('keyup', function() {
                    $.table.search(this.value).draw();
                });
                $('#accountStatus').on('change', function() {
                    $.table.search(this.value).draw();
                });
                $('[data-set="status-set-all"]').on('click', function() {
                    var dataStatus = $(this).attr('data-status') == "on" ? "Aktif" : "Pasif";
                    var status = $(this).attr('data-status');
                    bootbox.confirm({
                        backdrop: true,
                        centerVertical: true,
                        title: "Hesapların Durumu Toplu Olarak Değiştirilecek",
                        message: "Tüm hesapların durumunu " + dataStatus + " olarak değiştirmek istediğinizden emin misiniz ?",
                        buttons: {
                            confirm: {
                                label: "Onayla"
                            },
                            cancel: {
                                label: "Vazgeç"
                            }
                        },
                        callback: (result) => {
                            if (result == true) {
                                $.varien.account.datatable.status(0, status);
                                toastr.success("Tüm hesaplar " + dataStatus + " duruma getirildi !");
                                setTimeout(() => {
                                    $.table.ajax.reload();
                                }, 500);
                            }
                        }
                    });
                });
            },
            onLoad: function() {
                $.table.on('draw', function() {
                    setTimeout(function() {
                        $.varien.datatable.exportEvents();
                        if ($.varien.segment(3) == "1") $("tbody td:nth-child(7)").addClass('text-end');
                        if ($.varien.segment(3) == "2") $("tbody td:nth-child(8)").addClass('text-end');
                        if ($.varien.segment(3) == "3") $("tbody td:nth-child(8)").addClass('text-end');
                        $('input[data-set="index"]').on("change", function() {
                            if ($(this).is(":checked") == true) {
                                $.varien.account.datatable.status($(this).attr("data-id"), "on");
                                toastr.success("Hesap aktif duruma getirildi");
                            } else {
                                $.varien.account.datatable.status($(this).attr("data-id"), 0);
                                toastr.error("Hesap pasif duruma getirildi");
                            }
                        });
                        $.varien.account.datatable.modal();
                        $.varien.account.datatable.remove();
                    }, 300);
                });
            },
            status: function(id, status) {
                $.ajax({
                    url: "account/status/" + id + "/" + status + "/" + $.varien.segment(3),
                    type: "POST",
                    dataType: "html",
                    cache: false
                });
            },
            modal: function() {
                $('[id="formAjax"]').on('click', function() {
                    $.varien.modal.event.load($(this).attr('data-url'), function() {
                        $.varien.account.datatable.submit();
                        $('#ajaxModalContent select[name="perm_site[]"]').select2();
                        $('#ajaxModalContent select[name="bank_id"]').select2();
                    });
                });
            },
            submit: function() {
                $("form#modalForm").on('submit', (function(e) {
                    $.varien.eventControl(e);
                    $.ajax({
                        url: "account/save",
                        type: "POST",
                        dataType: "html",
                        crossDomain: true,
                        data: new FormData(this),
                        xhrFields: {
                            withCredentials: true
                        },
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $.table.ajax.reload();
                            $("#ajaxModal").modal('toggle');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            Swal.fire({
                                text: "XHR ERROR - " + jqXHR.status + " " + textStatus + " " + errorThrown,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "kapat",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    });
                }));
            },
            remove: function() {
                $('[data-set="delete"]').on('click', function() {
                    var urlAjax = $(this).attr('delete-url');
                    var msg = $(this).attr('delete-msg');
                    bootbox.confirm({
                        backdrop: true,
                        centerVertical: true,
                        title: "Hesabı Sil",
                        message: "Hesabı silme işlemini onaylıyor musunuz? Bu işlemin geri dönüşü yoktur!",
                        buttons: {
                            confirm: {
                                label: "Onayla"
                            },
                            cancel: {
                                label: "Vazgeç"
                            }
                        },
                        callback: (result) => {
                            if (result == true) {
                                $.ajax({
                                    type: 'POST',
                                    url: urlAjax,
                                    success: function() {
                                        $.table.ajax.reload();
                                        toastr.error("Hesap verisi silindi !");
                                    }
                                });
                            }
                        }
                    });
                });
            }
        }
    },
    transaction: {
        init: function() {
            $('button#filtre').css("width", "180px");
            $('input#transactionDate').css("width", "210px");
            $(".modal-dialog").addClass("w-325px");
            $.varien.transaction.dateSelect();
            $.bsFirstTab = bootstrap.Tab.getInstance(document.querySelector("#myTab li:first-child a"));
            $.drawer = KTDrawer.getInstance(document.querySelector("#drawer"));
            $.drawer.on("kt.drawer.show", function() {
                if ($("#sync").is(":checked") == true) {
                    $("#sync").trigger("click");
                }
            });
            $.drawer.on("kt.drawer.hide", function() {
                $.bsFirstTab.show();
                $.varien.transaction.datatable.reload();
                if ($.varien.transaction.datatable.isToday()) {
                    if ($("#sync").is(":checked") == false) {
                        $("#sync").trigger("click");
                    }
                }
            });
            $.blockDatatable = new KTBlockUI(document.querySelector("#datatable_content"));
            $.blockModalContent = new KTBlockUI(document.querySelector("#ajaxModalContent"));
            KTCookie.set('recordsTotal', 0);
            let created = false;
            $(document).on("click", () => {
                if (!created) {
                    created = true;
                    console.log('document.createElement("audio")');
                    let v = document.createElement("audio");
                    v.setAttribute("src", $.resource.coreAssets + "/audio/notification.mp3");
                    v.setAttribute("muted", "muted");
                    v.setAttribute("id", "notification");
                    document.body.appendChild(v);
                }
            });
            if ($.varien.segment(3) == "deposit") {
                $("[data-page-title]").html("Yatırımlar");
                $.varien.include("transaction/include/datatableHeadDeposit", "datatable-head").then(function(colNum) {
                    $.varien.transaction.datatable.init(colNum);
                });
            }
            if ($.varien.segment(3) == "withdraw") {
                $("[data-page-title]").html("Çekimler");
                $.varien.include("transaction/include/datatableHeadWithdraw", "datatable-head").then(function(colNum) {
                    $.varien.transaction.datatable.init(colNum);
                });
            }
            $.varien.transaction.datatable.getNotifications().done(function(response) {
                if (response.status == 1) {
                    if ($("#notifications").is(":checked") == false) {
                        $("#notifications").trigger("click");
                    }
                }
                if (response.status == 0) {
                    if ($("#notifications").is(":checked") == true) {
                        $("#notifications").trigger("click");
                    }
                }
            });
            $.varien.transaction.datatable.rejectAll();
        },
        dateSelect: function() {
            $("#transactionDate").css("text-align", "center");
            let start = moment();
            let end = moment();

            function cb(start, end) {
                $("#transactionDate").html(start.format("DD.MM.YYYY") + " - " + end.format("DD.MM.YYYY"));
            }
            $("#transactionDate").daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    "Bugün": [moment(), moment()],
                    "Dün": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                    "Son 7 Gün": [moment().subtract(6, "days"), moment()],
                    "Bu Ay": [moment().startOf("month"), moment().endOf("month")],
                    "Geçen Ay": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                },
                "locale": {
                    "format": "DD/MM/YYYY",
                    "separator": " - ",
                    "applyLabel": "Uygula",
                    "cancelLabel": "Vazgeç",
                    "customRangeLabel": "Özel Aralık",
                    "daysOfWeek": ["Pzt", "Sal", "Çar", "Per", "Cum", "Cmt", "Paz"],
                    "monthNames": ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
                    "firstDay": 1
                },
            }, cb);
            cb(start, end);
        },
        datatable: {
            init: function(colNum) {
                if ($.varien.segment(3) == "deposit") $.notOrderCols = [1, 2, 3, (colNum - 2), (colNum - 1)];
                if ($.varien.segment(3) == "withdraw") $.notOrderCols = [1, 2, 3, 4, 5, 6, 8, 9];
                if ($.resource.edit_transaction_deposit != 1 && $.varien.segment(3) == "deposit") $.noVisibleCols = [colNum - 1];
                if ($.resource.edit_transaction_withdraw != 1 && $.varien.segment(3) == "withdraw") $.noVisibleCols = [colNum - 1];
                $.table = new DataTable('#datatable_content', {
                    language: $.varien.datatable.locale(),
                    dom: '<"#dtExportButtonsWrapper"B>rt<"row"<"col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"li><"col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"p>>',
                    buttons: ['copy', 'csv', 'excel', 'pdf'],
                    bStateSave: false,
                    stateSave: false,
                    lengthMenu: [10, 25, 50, 100],
                    order: [0, 'desc'],
                    columnDefs: [{
                        orderable: false,
                        targets: (Array.isArray($.notOrderCols) == true ? $.notOrderCols : [])
                    }, {
                        targets: (Array.isArray($.noVisibleCols) == true ? $.noVisibleCols : []),
                        visible: false
                    }],
                    searching: true,
                    ordering: true,
                    processing: true,
                    serverSide: true,
                    pageLength: 10,
                    ajax: {
                        url: 'transaction/datatable/' + $.varien.segment(3),
                        type: 'POST',
                        data: function(d) {
                            d.transactionDate = $("#transactionDate").val();
                            d.siteId = $("#siteId").val();
                            d.method = $("#method").val();
                            d.status = $("#status").val();
                            d.accountId = $("#accountIdFilter").val();
                        }
                    }
                });
                $.varien.transaction.datatable.onLoad();
                $.varien.transaction.datatable.sync();
                $.varien.transaction.datatable.notification();
                $('#search').on('keyup', function() {
                    $.table.search(this.value).draw();
                });
                $("#transactionDate").on("change", function() {
                    var val = $("#transactionDate").val();
                    var parseSelectedDate = val.split(" - ");
                    var parseStartDate = parseSelectedDate[0].split("/");
                    var parseEndDate = parseSelectedDate[1].split("/");
                    var start = new Date(parseStartDate[2] + "-" + parseStartDate[1] + "-" + parseStartDate[0]);
                    var end = new Date(parseEndDate[2] + "-" + parseEndDate[1] + "-" + parseEndDate[0]);
                    var today = new Date();
                    start.setHours(0, 0, 0, 0);
                    end.setHours(0, 0, 0, 0);
                    today.setHours(0, 0, 0, 0);
                    if (start.toDateString() === today.toDateString() && end.toDateString() === today.toDateString()) {
                        if ($("#sync").is(":checked") == false) {
                            $("#sync").trigger("click");
                            $.varien.transaction.datatable.reload();
                        }
                    }
                    if (start.toDateString() !== today.toDateString() || end.toDateString() !== today.toDateString()) {
                        if ($("#sync").is(":checked") == true) {
                            $("#sync").trigger("click");
                        }
                        $.varien.transaction.datatable.reload();
                    }
                });
                $("#refresh").on("click", function(e) {
                    $.varien.eventControl(e);
                    $.varien.transaction.datatable.reload();
                    toastr.success("İşlemler Yenilendi");
                });
                $("[app-onchange-datatable-reload]").on("change input", function(e) {
                    $.varien.eventControl(e);
                    $.varien.transaction.datatable.reload();
                    //toastr.success("İşlemler Filtrelendi");
                });
                $("[app-onclick-datatable-reset]").on("click", function(e) {
                    $.varien.eventControl(e);
                    $("#siteId").val("").trigger('change');
                    $("#method").val("").trigger('change');
                    $("#status").val("").trigger('change');
                    $("#accountIdFilter").val('');
                    $.varien.transaction.datatable.reload();
                    //toastr.success("Filtre Temizlendi");
                });
                /*
                $("#notificationSound").on("click", function()
                {
                    if ($(this).is(":checked") == false)
                    {
                        $.varien.transaction.datatable.notificationSound(0);
                        toastr.error("Bildirim Sesi Kapatıldı");
                    }

                    if ($(this).is(":checked") == true)
                    {
                        $.varien.transaction.datatable.notificationSound(1);
                        toastr.success("Bildirim Sesi Açıldı");
                    }

                });
                */
            },
            isToday: function() {
                var val = $("#transactionDate").val();
                var parseSelectedDate = val.split(" - ");
                var parseStartDate = parseSelectedDate[0].split("/");
                var parseEndDate = parseSelectedDate[1].split("/");
                var start = new Date(parseStartDate[2] + "-" + parseStartDate[1] + "-" + parseStartDate[0]);
                var end = new Date(parseEndDate[2] + "-" + parseEndDate[1] + "-" + parseEndDate[0]);
                var today = new Date();
                start.setHours(0, 0, 0, 0);
                end.setHours(0, 0, 0, 0);
                today.setHours(0, 0, 0, 0);
                if (start.toDateString() === today.toDateString() && end.toDateString() === today.toDateString()) {
                    return true;
                } else {
                    return false;
                }
            },
            sound: () => {
                document.getElementById('notification').muted = false;
                document.getElementById("notification").loop = false;
                document.getElementById('notification').play();
            },
            setNotifications: function(status) {
                $.ajax({
                    url: "transaction/notificationSound/" + status,
                    type: "GET",
                    dataType: "html",
                    cache: false
                });
            },
            getNotifications: function() {
                return $.ajax({
                    url: "transaction/getNotificationSoundStatus",
                    dataType: "json"
                });
            },
            autoDate: function() {
                $.varien.transaction.dateSelect();
            },
            sync: function() {
                autoRefreshInterval = setInterval($.varien.transaction.datatable.reload, $.syncTime);
                autoDateInterval = setInterval($.varien.transaction.datatable.autoDate, $.syncTime);
                $('#sync').on("click", function() {
                    if ($(this).is(":checked") == true) {
                        if (typeof autoRefreshInterval === 'object') autoRefreshInterval = setInterval($.varien.transaction.datatable.reload, $.syncTime);
                        if (typeof autoDateInterval === 'object') autoDateInterval = setInterval($.varien.transaction.datatable.autoDate, $.syncTime);
                        toastr.success("Otomatik yenileme aktif");
                    } else {
                        clearInterval(autoRefreshInterval);
                        clearInterval(autoDateInterval);
                        autoRefreshInterval = null;
                        autoDateInterval = null;
                        toastr.error("Otomatik yenileme pasif");
                    }
                });
            },
            rejectAll: () => {
                $.reject = function(url, id) {
                    return new Promise(function(resolve, reject) {
                        var xhttp = new XMLHttpRequest();
                        xhttp.open("POST", url, true);
                        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhttp.onload = function() {
                            if (this.status == 200) {
                                resolve(200);
                            }
                            if (this.status == 404) {
                                reject({
                                    status: this.status,
                                    statusText: xhr.statusText
                                });
                            }
                        };
                        xhttp.send('request=' + $.varien.segment(3) + '&status=reddedildi&response=reject&id=' + id);
                    });
                };
                $("#reject-all-button").on("click", function(e) {
                    $.varien.eventControl(e);
                    $.rowCount = 0;
                    $.rowArray = [];
                    if ($('tbody > tr').length) {
                        $('tbody > tr').each(function(index, row) {
                            if ($(row).attr('id') !== undefined) {
                                if ($(row).attr('id').indexOf("-1") > 0) {
                                    $.rowCount += 1;
                                    $.rowArray.push({
                                        id: $(row).attr('id').split('-')[0],
                                        transId: $(row).attr('id').split('-')[2]
                                    });
                                }
                            }
                        });
                    }
                    if ($.rowCount == 0) {
                        toastr.error("Beklemede talep yok");
                    } else {
                        bootbox.confirm({
                            backdrop: true,
                            centerVertical: true,
                            title: "Bekleyen Talepleri Reddet",
                            buttons: {
                                confirm: {
                                    label: "Onayla"
                                },
                                cancel: {
                                    label: "Vazgeç"
                                }
                            },
                            message: $.rowCount + " bekleyen talep reddedilecek. İşlemi onaylıyor musunuz ?",
                            callback: (result) => {
                                if (result == true) {
                                    $.each($.rowArray, function(index, value) {
                                        $.reject("transaction/update", value.id).then(function(response) {
                                            toastr.success("#" + value.transId + ": talep otomatik reddedildi");
                                            $.varien.transaction.datatable.reload();
                                        });
                                    });
                                }
                            }
                        });
                    }
                });
            },
            notification: function() {
                $("#notifications").on("click", function() {
                    if ($(this).is(":checked") == true) {
                        toastr.success("Bildirimler aktif edildi.");
                        $.varien.transaction.datatable.setNotifications(1);
                        $.varien.transaction.datatable.sound();
                    } else {
                        toastr.error("Bildirimler pasif edildi.");
                        $.varien.transaction.datatable.setNotifications(0);
                    }
                });
                var info = $.table.page.info();
                if (KTCookie.get('recordsTotal') < info.recordsTotal) {
                    if ($("#notifications").is(":checked") == true) {
                        $.varien.transaction.datatable.sound();
                    }
                }
                KTCookie.set('recordsTotal', info.recordsTotal);
            },
            onLoad: function() {
                $.table.on('draw', function() {
                    setTimeout(function() {
                        $.varien.datatable.exportEvents();
                        $('input[data-set="index"]').on("change", function() {
                            if ($(this).is(":checked") == true) {
                                $.varien.transaction.datatable.status($(this).attr("data-id"), "on");
                            } else {
                                $.varien.transaction.datatable.status($(this).attr("data-id"), 0);
                            }
                        });
                        $.varien.transaction.datatable.modal();
                        $.varien.transaction.datatable.inspect();
                    }, 500);
                });
            },
            reload: function() {
                $.table.ajax.reload();
            },
            status: function(id, status) {
                $.ajax({
                    url: "transaction/status/" + id + "/" + status + "/" + $.varien.segment(3),
                    type: "POST",
                    dataType: "html",
                    cache: false
                });
            },
            inspect: function() {
                $('[id="inspect"]').on('click', function(e) {
                    e.preventDefault(e);
                    $.rowId = $(this).attr('data-row-id');
                    $.userName = $(this).attr('data-user-name');
                    $.userNote = $(this).attr('data-customer-note');
                    $.accountName = $(this).attr('data-account-name');
                    $.accountLink = $(this).attr('data-account-link');
                    $.customerLink = $(this).attr('data-customer-link');
                    $.customerId = $(this).attr('data-customer-id');
                    $.customerDeposit = $(this).attr('data-customer-deposit');
                    $.customerWithdraw = $(this).attr('data-customer-withdraw');
                    $.isVip = $(this).attr('data-customer-vip');
                    $.switch = $('input[data-set="switch"]');
                    $('input[data-set="switch"]').attr('data-id', $.customerId);
                    if ($.customerDeposit == 'on' && $("#deposit").is(":checked") == false) $('#deposit').prop('checked', true);
                    if ($.customerDeposit != 'on' && $("#deposit").is(":checked") == true) $('#deposit').prop('checked', false);
                    if ($.customerWithdraw == 'on' && $("#withdraw").is(":checked") == false) $('#withdraw').prop('checked', true);
                    if ($.customerWithdraw != 'on' && $("#withdraw").is(":checked") == true) $('#withdraw').prop('checked', false);
                    $.switch.on("change", function(e) {
                        $.varien.eventControl(e);
                        if ($(this).is(":checked") == true) {
                            $.varien.customer.datatable.switch($(this).attr("name"), $(this).attr("data-id"), "on");
                            if ($(this).attr("name") == "deposit") {
                                toastr.success("Müşteri yatırım talepleri aktif edildi");
                            } else if ($(this).attr("name") == "withdraw") {
                                toastr.success("Müşteri çekim talepleri aktif edildi");
                            } else if ($(this).attr("name") == "isVip") {
                                toastr.success("Müşteri VIP durumu aktif edildi");
                            }
                        } else {
                            $.varien.customer.datatable.switch($(this).attr("name"), $(this).attr("data-id"), 0);
                            if ($(this).attr("name") == "deposit") {
                                toastr.error("Müşteri yatırım talepleri pasif edildi");
                            } else if ($(this).attr("name") == "withdraw") {
                                toastr.error("Müşteri çekim talepleri pasif edildi");
                            } else if ($(this).attr("name") == "isVip") {
                                toastr.error("Müşteri VIP durumu pasif edildi");
                            }
                        }
                    });
                    if ($.isVip == 'on' && $("#isVip").is(":checked") == false) $('#isVip').prop('checked', true);
                    if ($.isVip != 'on' && $("#isVip").is(":checked") == true) $('#isVip').prop('checked', false);
                    if (!$.resource.edit_customer) {
                        $("#deposit").prop("disabled", true);
                        $("#withdraw").prop("disabled", true);
                        $("#isVip").prop("disabled", true);
                    }
                    $('[data-set-accountLink]').on("click", function(e) {
                        $.varien.eventControl(e);
                        window.open($.accountLink, '_blank');
                    });
                    $('[data-set-customerLink]').on("click", function(e) {
                        $.varien.eventControl(e);
                        window.open($.customerLink, '_blank');
                    });
                    /*
                        0: TARİH 
                        1: TXID
                        2: USERID
                        3: HESAP
                        4: FİRMA
                        5: YÖNTEM
                        6: MÜŞTERİ
                        7: TUTAR
                        8: DURUM
                        9: SÜRE
                        10: İŞLEMLER
                        .find('p').contents().unwrap();
                        badge-light-warning: beklemede
                        badge-light-success: onaylandı
                        badge-light-danger: reddedildi
      
                    */
                    $.requestTime = $('#' + $.rowId).find("td").eq(0).html();
                    $.txid = $('#' + $.rowId).find("td").eq(1).html();
                    $.customerSiteId = $('#' + $.rowId).find("td").eq(2).html();
                    $.accountId = $('#' + $.rowId).find("td").eq(3).html();
                    $.client = $('#' + $.rowId).find("td").eq(4).html();
                    $.method = $('#' + $.rowId).find("td").eq(5).html();
                    $.customer = $('#' + $.rowId).find("td").eq(6).html();
                    $.amount = $('#' + $.rowId).find("td").eq(7).html();
                    $.status = $('#' + $.rowId).find("td").eq(8).html();
                    $.time = $('#' + $.rowId).find("td").eq(9).html();
                    $('[data-set-date]').html($.requestTime);
                    $('[data-set-time]').html($.time);
                    $('[data-set-txid]').html($.txid);
                    $('[data-set-accountName]').html($.accountName);
                    $('[data-set-accountId]').html($.accountId);
                    $('[data-set-client]').html($.client);
                    $('[data-set-method]').html($.method).find('div').contents().unwrap();
                    $('[data-set-customer]').html($.customer);
                    $('[data-set-status]').html($.status).find('div').contents().unwrap();
                    if ($.trim($('[data-set-status]').html()) == 'Beklemede') {
                        $('[data-set-status]').addClass('text-gray-800 badge-light-warning');
                        $('[data-set-status]').removeClass('badge-light-success');
                        $('[data-set-status]').removeClass('badge-light-danger');
                    }
                    if ($.trim($('[data-set-status]').html()) == 'Onaylandı') {
                        $('[data-set-status]').addClass('badge-light-success');
                        $('[data-set-status]').removeClass('text-gray-800 badge-light-warning');
                        $('[data-set-status]').removeClass('badge-light-danger');
                    }
                    if ($.trim($('[data-set-status]').html()) == 'Reddedildi') {
                        $('[data-set-status]').addClass('badge-light-danger');
                        $('[data-set-status]').removeClass('text-gray-800 badge-light-warning');
                        $('[data-set-status]').removeClass('badge-light-success');
                    }
                    $('[data-set-user]').html($.userName);
                    $('[data-set-note]').html($.userNote);
                    $('[data-set-amount]').html($.amount);
                    $('[data-set-customerId]').html($.customerSiteId);
                });
            },
            modal: function() {
                $('[data-bs-target="#ajaxModal"]').on('click', function() {
                    $.varien.modal.event.load($(this).attr('data-url'), function() {
                        $.varien.transaction.datatable.submit();
                    });
                });
            },
            process: function(options) {
                return new Promise(function(resolve, reject) {
                    $.ajax(options).done(resolve).fail(reject);
                });
            },
            submit: function() {
                $("form#modalForm").on('submit', (function(e) {
                    $.varien.eventControl(e);
                    $.blockDatatable.block();
                    $.blockModalContent.block();
                    $.formData = new FormData(this);
                    $.varien.transaction.datatable.process({
                        url: "transaction/update",
                        type: "POST",
                        dataType: "html",
                        crossDomain: true,
                        data: $.formData,
                        xhrFields: {
                            withCredentials: true
                        },
                        processData: false,
                        contentType: false
                    }).then(function success(data) {
                        $.table.ajax.reload();
                        $("#ajaxModal").modal('toggle');
                        $.blockDatatable.release();
                        $.blockModalContent.release();
                    }, function error(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            text: jqXHR.status + " " + textStatus + " " + errorThrown,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "kapat",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                        $.blockDatatable.release();
                        $.blockModalContent.release();
                    }).catch(function(error) {
                        Swal.fire({
                            text: error.message,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "kapat",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                        $.blockDatatable.release();
                        $.blockModalContent.release();
                    });
                }));
            },
            remove: function() {
                $('[data-set="delete"]').on('click', function() {
                    var urlAjax = $(this).attr('delete-url');
                    var msg = $(this).attr('delete-msg');
                    bootbox.confirm({
                        buttons: {
                            confirm: {
                                label: "Onayla"
                            },
                            cancel: {
                                label: "Vazgeç"
                            }
                        },
                        message: msg,
                        callback: (result) => {
                            if (result == true) {
                                $.ajax({
                                    type: 'POST',
                                    url: urlAjax,
                                    success: function() {
                                        $.table.ajax.reload();
                                        toastr.error("hesap verisi silindi !");
                                    }
                                });
                            }
                        }
                    });
                });
            }
        }
    },
    user: {
        init: function() {
            $("[data-page-title]").html("Kullanıcılar");
            if ($.varien.segment(2) == "index") {
                $.varien.include("user/include/datatableHead", "datatable-head").then(function(colNum) {
                    $.varien.user.datatable.init(colNum)
                });
            }
            if ($.varien.segment(2) == "detail") {
                $.varien.user.detail.init();
            }
            if ($.varien.segment(2) == "roles") {
                $.varien.user.role.init();
            }
        },
        role: {
            init: function() {
                $.varien.user.role.datatable.init();
            },
            accountType: function() {
                $("select").on("change", function() {
                    if ($(this).val() == 1) {
                        $('input[name="partner"]').val(1);
                        $('input[name="root"]').val(0);
                    }
                    if ($(this).val() == 2) {
                        $('input[name="partner"]').val(0);
                        $('input[name="root"]').val(1);
                    }
                });
            },
            datatable: {
                init: function() {
                    var colNum = $("thead tr th").length;
                    if ($.resource.edit_role != 1 && $.resource.delete_role != 1) $.noVisibleCols = [colNum - 1];
                    $.table = new DataTable('#datatableRole', {
                        language: $.varien.datatable.locale(),
                        dom: '<"#dtExportButtonsWrapper"B>rt<"row"<"col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"li><"col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"p>>',
                        buttons: ['copy', 'csv', 'excel', 'pdf'],
                        bStateSave: false,
                        stateSave: false,
                        lengthMenu: [10, 25, 50, 100],
                        order: [0, 'desc'],
                        columnDefs: [{
                            orderable: false,
                            targets: [1, 2]
                        }, {
                            targets: (Array.isArray($.noVisibleCols) == true ? $.noVisibleCols : []),
                            visible: false
                        }],
                        searching: false,
                        ordering: false,
                        processing: true,
                        serverSide: true,
                        pageLength: 10,
                        ajax: {
                            url: 'user/datatableRole'
                        }
                    });
                    $.varien.user.role.datatable.onLoad();
                },
                onLoad: function() {
                    $.table.on('draw', function() {
                        setTimeout(function() {
                            $.varien.datatable.exportEvents();
                            $("tbody td:nth-child(3)").addClass('text-end');
                            $.varien.user.role.datatable.modal();
                            $.varien.user.role.datatable.remove();
                        }, 300);
                    });
                },
                modal: function() {
                    $('[id="formAjax"]').on('click', function() {
                        $.varien.modal.event.load($(this).attr('data-url'), function() {
                            $.varien.user.role.datatable.submit();
                            $.varien.user.role.accountType();
                            $("select").select2();
                        });
                    });
                },
                submit: function() {
                    $("form#roleForm").on('submit', (function(e) {
                        $.varien.eventControl(e);
                        $.ajax({
                            url: "user/saveRole",
                            type: "POST",
                            dataType: "html",
                            crossDomain: true,
                            data: new FormData(this),
                            xhrFields: {
                                withCredentials: true
                            },
                            processData: false,
                            contentType: false,
                            success: function() {
                                $.table.ajax.reload();
                                $("#ajaxModal").modal('toggle');
                                toastr.success("İzinler Yapılandırıldı.");
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                Swal.fire({
                                    text: "XHR ERROR - " + jqXHR.status + " " + textStatus + " " + errorThrown,
                                    icon: "error",
                                    buttonsStyling: false,
                                    confirmButtonText: "kapat",
                                    customClass: {
                                        confirmButton: "btn btn-primary"
                                    }
                                });
                            }
                        });
                    }));
                },
                remove: function() {
                    $('[data-set="remove"]').on('click', function() {
                        var id = $(this).attr('data-id');
                        bootbox.confirm({
                            backdrop: true,
                            centerVertical: true,
                            title: "Kullanıcı Rolünü Sil",
                            buttons: {
                                confirm: {
                                    label: "Onayla"
                                },
                                cancel: {
                                    label: "Vazgeç"
                                }
                            },
                            message: "Kullanıcı rolünü silme işlemini onaylıyor musunuz ?",
                            callback: (result) => {
                                if (result == true) {
                                    $.ajax({
                                        type: 'POST',
                                        url: "user/removeRole/" + id,
                                        success: function() {
                                            $.table.ajax.reload();
                                            toastr.error("Kullanıcı rolü silindi !");
                                        }
                                    });
                                }
                            }
                        });
                    });
                },
                reload: function() {
                    $.table.ajax.reload();
                }
            }
        },
        detail: {
            init: function() {
                $.varien.user.detail.remove();
                $.varien.user.detail.update();
                $.varien.user.detail.twoFA.init();
                $.varien.user.detail.selectedFirms();
                $.varien.user.detail.isRoot();
                $.varien.user.detail.sessiontable.init();
            },
            isRoot: function() {
                if ($.resource.root) $("[current-password-wrapper]").hide();
            },
            twoFA: {
                init: function() {
                    $('[id="formAjax"]').on('click', function() {
                        $.varien.modal.event.load($(this).attr('data-url'), function() {
                            $.wait(500).then(function() {
                                $.varien.user.detail.twoFA.button.qr();
                                $.varien.user.detail.twoFA.button.manual();
                                $.varien.user.detail.twoFA.button.next();
                                $.varien.user.detail.twoFA.button.back();
                                $.varien.user.detail.twoFA.button.authorization();
                            })
                        });
                    });
                    $.varien.user.detail.twoFA.button.disable();
                },
                authorization: function() {
                    return new Promise(function(resolve, reject) {
                        if ($("[verificationCode]")) {
                            var xhttp = new XMLHttpRequest();
                            xhttp.open("POST", window.location.protocol + "//" + window.location.hostname + "/secure/2fa/verify/" + $("[verificationCode]").val(), true);
                            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhttp.onload = function() {
                                if (this.status == 200) {
                                    resolve(this.status);
                                } else {
                                    reject(this.status);
                                }
                            };
                            xhttp.send('secret=' + $("form#2fa").attr("data-secret"));
                        }
                    });
                },
                set2fa: function() {
                    return new Promise(function(resolve, reject) {
                        if ($("[verificationCode]")) {
                            var xhttp = new XMLHttpRequest();
                            xhttp.open("POST", window.location.protocol + "//" + window.location.hostname + "/secure/2fa/setup", true);
                            xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                            xhttp.onload = function() {
                                if (this.status == 200) {
                                    resolve(this.status);
                                } else {
                                    reject(this.status);
                                }
                            };
                            xhttp.send('secret=' + $("form#2fa").attr("data-secret"));
                        }
                    });
                },
                disable2fa: function() {
                    return new Promise(function(resolve, reject) {
                        var xhttp = new XMLHttpRequest();
                        xhttp.open("POST", window.location.protocol + "//" + window.location.hostname + "/secure/2fa/disable", true);
                        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                        xhttp.onload = function() {
                            if (this.status == 200) {
                                resolve(this.status);
                            } else {
                                reject(this.status);
                            }
                        };
                        xhttp.send('user_id=' + $.varien.segment(3));
                    });
                },
                button: {
                    qr: () => {
                        $('[data-action-button-qr]').on('click', function() {
                            $("[data-set-2fa-qr]").addClass("d-none");
                            $("[data-set-2fa-manual]").removeClass("d-none");
                        });
                    },
                    manual: () => {
                        $('[data-action-button-manual]').on('click', function() {
                            $("[data-set-2fa-manual]").addClass("d-none");
                            $("[data-set-2fa-qr]").removeClass("d-none");
                        });
                    },
                    next: () => {
                        $('[data-action-button-next]').on('click', function() {
                            $("[data-set-2fa-qr]").addClass("d-none");
                            $("[data-set-2fa-manual]").addClass("d-none");
                            $("[data-action-button-next]").addClass("d-none");
                            $("[data-set-2fa-verify]").removeClass("d-none");
                        });
                    },
                    back: () => {
                        $('[data-action-button-back]').on('click', function() {
                            $("[data-set-2fa-qr]").removeClass("d-none");
                            $("[data-action-button-next]").removeClass("d-none");
                            $("[data-set-2fa-manual]").addClass("d-none");
                            $("[data-set-2fa-verify]").addClass("d-none");
                            $("[verificationCode]").val("");
                        });
                    },
                    authorization: () => {
                        $('[data-action-button-verify]').on('click', (e) => {
                            if ($("[verificationCode]").val() != "" && $("[verificationCode]").val().length >= 6) {
                                $.varien.user.detail.twoFA.authorization().then(response => {
                                    if (response == 200) {
                                        $.varien.user.detail.twoFA.set2fa().then(response => {
                                            console.log(response);
                                            if (response == 200) {
                                                $.varien.modal.event.toggle();
                                                Swal.fire({
                                                    text: "2 Adımlı doğrulama hesabınızda başarıyla aktive edildi ve sayfa tekrar yüklenecek",
                                                    icon: "success",
                                                    buttonsStyling: false,
                                                    confirmButtonText: "Kapat",
                                                    customClass: {
                                                        confirmButton: "btn btn-primary"
                                                    }
                                                });
                                                $.wait(3000).then(() => {
                                                    location.reload();
                                                });
                                            }
                                        }).catch(e => {
                                            toastr.error("Kod doğrulanamadı. Tekrar deneyiniz.");
                                        });
                                    }
                                }).catch(e => {
                                    toastr.error("Kod doğrulanamadı. Tekrar deneyiniz.");
                                });
                            } else {
                                toastr.error("6 rakamlı doğrulama kodunu giriniz !");
                            }
                        });
                    },
                    disable: () => {
                        if ($('[data-disable-2fa]').length) {
                            $('[data-disable-2fa]').on('click', function(e) {
                                bootbox.confirm({
                                    backdrop: true,
                                    centerVertical: true,
                                    buttons: {
                                        confirm: {
                                            label: "Kaldır"
                                        },
                                        cancel: {
                                            label: "Vazgeç"
                                        }
                                    },
                                    title: "İki Adımlı Doğrulamayı Kaldır",
                                    message: "İki adımlı doğrulamayı kaldırmak istediğinize emin misiniz ?",
                                    callback: (result) => {
                                        if (result == true) {
                                            $.varien.user.detail.twoFA.disable2fa().then(response => {
                                                if (response == 200) {
                                                    toastr.success("İki adımlı doğrulama başarıyla kaldırıldı.");
                                                    $.wait(1000).then(function() {
                                                        location.reload();
                                                    });
                                                }
                                            }).catch(e => {
                                                toastr.error("İşlem Başarısız. Tekrar deneyiniz.");
                                            });
                                        }
                                    }
                                });
                            });
                        }
                    }
                },
            },
            selectedFirms: () => {
                $("#firms").html("");
                if ($("#perm_site").val() != "") {
                    $("#perm_site option:selected").each(function() {
                        $("#firms").append("<li>" + $(this).text() + "</li>");
                    });
                } else {
                    $("#firms").append("<li>Tüm Firmalar</li>");
                }
            },
            remove: function() {
                $('[data-set="remove"]').on('click', function() {
                    var id = $(this).attr("data-id");
                    bootbox.confirm({
                        backdrop: true,
                        centerVertical: true,
                        buttons: {
                            confirm: {
                                label: "Onayla"
                            },
                            cancel: {
                                label: "Vazgeç"
                            }
                        },
                        title: "Kullanıcıyı Sil",
                        message: "Kullanıcıyı silmek istediğinize emin misiniz ?",
                        callback: (result) => {
                            if (result == true) {
                                $.ajax({
                                    type: 'POST',
                                    url: "user/remove/" + id,
                                    success: function() {
                                        toastr.error("Kullanıcı sistemden silindi !");
                                        window.location.href = "user/index";
                                    }
                                });
                            }
                        }
                    });
                });
            },
            password: function() {
                var d = $("a[data-pass]").attr("data-pass");
                var c = $("#current_password").val();
                var n = $("#user_pass").val();
                var v = $("#confirm_password").val();
                if (c == "" && root !== 1) {
                    toastr.error("Mevcut Şifrenizi Giriniz !");
                    $("#current_password").focus();
                    return false;
                }
                if (n == "") {
                    toastr.error("Yeni Şifrenizi Giriniz !");
                    $("#user_pass").focus();
                    return false;
                }
                if (v == "") {
                    toastr.error("Yeni Şifrenizi Tekrar Giriniz !");
                    $("#confirm_password").focus();
                    return false;
                }
                if (c != d && root !== 1) {
                    toastr.error("Mevcut Şifrenizi Yanlış Girdiniz !");
                    $("#current_password").focus();
                    return false;
                }
                if (n != v) {
                    toastr.error("Yeni şifrenizi yanlış girdiniz !");
                    $("#confirm_password").focus();
                    return false;
                }
                if (n.length < 8) {
                    toastr.error("Yeni şifreniz en az 8 karakterli olmalı !");
                    $("#user_pass").focus();
                    return false;
                }
                return true;
            },
            update: function() {
                $('[data-set="update"]').on('click', function(e) {
                    $.varien.eventControl(e);
                    var id = $(this).attr("data-id");
                    var modal = $(this).attr("data-modal");
                    var dataName = $(this).attr("data-name");
                    var dataValue = $("#" + dataName).val();
                    if (dataName == "user_pass") {
                        if (!$.varien.user.detail.password()) {
                            return false;
                        }
                    }
                    if (dataName == "email") {
                        $.varien.user.check("email", $("[app-submit-email-check]").val(), $("[app-submit-email-check]").attr('current-email')).then((response) => {
                            if (response > 0) {
                                toastr.error($("[app-submit-email-check]").val() + " adresi zaten mevcut");
                                $("[app-submit-email-check]").addClass('inputError');
                                $("[app-submit-email-check]").focus();
                                return false;
                            } else {
                                $.ajax({
                                    type: 'POST',
                                    url: "user/update/" + id,
                                    data: "dataName=" + dataName + "&dataValue=" + dataValue,
                                    success: function() {
                                        $('[name=' + dataName + ']').html(dataValue);
                                        toastr.success("Kullanıcı verisi güncellendi !");
                                        $("#" + modal).modal('toggle');
                                    }
                                });
                            }
                        });
                    } else {
                        $.ajax({
                            type: 'POST',
                            url: "user/update/" + id,
                            data: "dataName=" + dataName + "&dataValue=" + dataValue,
                            success: function() {
                                if (dataName == "perm_site") {
                                    $.varien.user.detail.selectedFirms();
                                } else {
                                    $('[name=' + dataName + ']').html(dataValue);
                                }
                                toastr.success("Kullanıcı verisi güncellendi !");
                                $("#" + modal).modal('toggle');
                                if (dataName == "role_id") location.reload();
                            }
                        });
                    }
                });
            },
            sessiontable: {
                init: function() {
                    $.table = new DataTable('#sessionTable', {
                        language: $.varien.datatable.locale(),
                        dom: '<"#dtExportButtonsWrapper"B>rt<"row"<"col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"li><"col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"p>>',
                        buttons: ['copy', 'csv', 'excel', 'pdf'],
                        bStateSave: false,
                        stateSave: false,
                        lengthMenu: [10, 25, 50, 100],
                        order: [0, 'desc'],
                        columnDefs: [{
                            orderable: false,
                            targets: [1, 2, 3]
                        }],
                        searching: false,
                        ordering: true,
                        processing: true,
                        serverSide: true,
                        pageLength: 10,
                        ajax: {
                            url: 'user/sessiontable/' + $.varien.segment(3)
                        }
                    });
                    $.varien.user.detail.sessiontable.onLoad();
                },
                onLoad: function() {
                    $.table.on('draw', function() {
                        $.varien.datatable.exportEvents();
                        $("#sessionTable_info").css("display", "none");
                    });
                },
                reload: function() {
                    $.table.ajax.reload();
                }
            }
        },
        check: function(param, value, current = "") {
            return new Promise(function(resolve, reject) {
                var xhttp = new XMLHttpRequest();
                xhttp.open("POST", 'user/check', true);
                xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhttp.onload = function() {
                    if (this.status == 200) resolve(parseInt(this.responseText));
                    if (this.status != 200) reject({
                        status: this.status,
                        statusText: this.statusText
                    });
                };
                xhttp.send('param=' + param + '&value=' + value + '&current=' + current);
            });
        },
        datatable: {
            init: function(colNum) {
                if ($.resource.edit_user != 1 && $.resource.delete_user != 1) $.noVisibleCols = [colNum - 1];
                if ($.resource.edit_user == 1 || $.resource.delete_user == 1) $.notOrderCols = [colNum - 1];
                else $.notOrderCols = [];
                $.table = new DataTable('#datatable_content', {
                    language: $.varien.datatable.locale(),
                    dom: '<"#dtExportButtonsWrapper"B>rt<"row"<"col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"li><"col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"p>>',
                    buttons: ['copy', 'csv', 'excel', 'pdf'],
                    bStateSave: false,
                    stateSave: false,
                    lengthMenu: [10, 25, 50, 100],
                    order: [0, 'desc'],
                    columnDefs: [{
                        orderable: false,
                        targets: $.notOrderCols
                    }, {
                        targets: (Array.isArray($.noVisibleCols) == true ? $.noVisibleCols : []),
                        visible: false
                    }],
                    searching: true,
                    ordering: true,
                    processing: true,
                    serverSide: true,
                    pageLength: 10,
                    ajax: {
                        url: 'user/datatable',
                        type: 'POST',
                        data: function(d) {
                            d.is2fa = $("#is2fa").val();
                            d.role_id = $("#role_id").val();
                        }
                    }
                });
                $.varien.user.datatable.onLoad();
                $('#search').on('keyup', function() {
                    $.table.search(this.value).draw();
                });
                $('#accountStatus').on('change', function() {
                    $.table.search(this.value).draw();
                });
            },
            onLoad: function() {
                $.table.on('draw', function() {
                    setTimeout(function() {
                        $.varien.datatable.exportEvents();
                        $("tbody td:nth-child(1)").addClass('d-flex align-items-center');
                        $("tbody td:nth-child(6)").addClass('text-end');
                        $.varien.user.datatable.modal();
                        $.varien.user.datatable.remove();
                    }, 300);
                });
            },
            modal: function() {
                $('[id="formAjax"]').on('click', function() {
                    $.varien.modal.event.load($(this).attr('data-url'), function() {
                        $('select').select2();
                        $.varien.user.datatable.submit();
                    });
                });
            },
            submit: function() {
                $("[app-submit-email-check]").focusout(function() {
                    $.varien.user.check("email", $("[app-submit-email-check]").val()).then((response) => {
                        if (response > 0) {
                            toastr.error($("[app-submit-email-check]").val() + " adresi zaten mevcut");
                            $("[app-submit-email-check]").addClass('inputError');
                            $("[app-submit-email-check]").focus();
                            $(':input[type="submit"]').prop('disabled', true);
                            return false;
                        } else {
                            toastr.success($("[app-submit-email-check]").val() + " adresi kullanılabilir");
                            $("[app-submit-email-check]").removeClass('inputError');
                            $(':input[type="submit"]').prop('disabled', false);
                        }
                    });
                });
                $("form#modalForm").on('submit', (function(e) {
                    $.varien.eventControl(e);
                    $.varien.user.check("email", $("[app-submit-email-check]").val()).then((response) => {
                        if (response > 0) {
                            toastr.error($("[app-submit-email-check]").val() + " adresi zaten mevcut");
                            $("[app-submit-email-check]").addClass('inputError');
                            $("[app-submit-email-check]").focus();
                            $(':input[type="submit"]').prop('disabled', true);
                            return false;
                        } else {
                            $.ajax({
                                url: "user/save",
                                type: "POST",
                                dataType: "html",
                                crossDomain: true,
                                data: new FormData(document.getElementById('modalForm')),
                                xhrFields: {
                                    withCredentials: true
                                },
                                processData: false,
                                contentType: false,
                                success: function() {
                                    $.table.ajax.reload();
                                    $("#ajaxModal").modal('toggle');
                                    toastr.success("Kullanıcı Eklendi !");
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    Swal.fire({
                                        text: "XHR ERROR - " + jqXHR.status + " " + textStatus + " " + errorThrown,
                                        icon: "error",
                                        buttonsStyling: false,
                                        confirmButtonText: "kapat",
                                        customClass: {
                                            confirmButton: "btn btn-primary"
                                        }
                                    });
                                }
                            });
                        }
                    });
                }));
            },
            remove: function() {
                $('[data-set="remove"]').on('click', function() {
                    var id = $(this).attr('data-id');
                    bootbox.confirm({
                        backdrop: true,
                        centerVertical: true,
                        title: "Kullanıcıyı Sil",
                        buttons: {
                            confirm: {
                                label: "Onayla"
                            },
                            cancel: {
                                label: "Vazgeç"
                            }
                        },
                        message: "Kullanıcı silme işlemini onaylıyor musunuz ?",
                        callback: (result) => {
                            if (result == true) {
                                $.ajax({
                                    type: 'POST',
                                    url: "user/remove/" + id,
                                    success: function() {
                                        $.table.ajax.reload();
                                        toastr.error("Kullanıcı verisi silindi !");
                                    }
                                });
                            }
                        }
                    });
                });
            },
            reload: function() {
                $.table.ajax.reload();
            },
            reset: function() {
                $("select#is2fa").val("");
                $("select#role").val("");
                $.table.ajax.reload();
            },
        }
    },
    customer: {
        init: function() {
            $("[data-page-title]").html("Müşteriler");
            if ($.varien.segment(2) == "index") {
                $.varien.include("customer/include/datatableHead", "datatable-head").then(function(colNum) {
                    $.varien.customer.datatable.init(colNum)
                });
                $.varien.customer.selectClient();
            }
            if ($.varien.segment(2) == "detail") {
                $.varien.customer.detail.init();
            }
        },
        selectClient: function() {
            $.ajax({
                url: "client/json",
                dataType: "json",
                success: function(response) {
                    $.each(response, function(i) {
                        //console.log(response);
                        $("#selectClient").append('<option value="' + response[i].id + '">' + response[i].name + '</option>');
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        text: "XHR ERROR - " + jqXHR.status + "*" + textStatus + "*" + errorThrown,
                        icon: "error",
                        buttonsStyling: false,
                        confirmButtonText: "kapat",
                        customClass: {
                            confirmButton: "btn btn-primary"
                        }
                    });
                }
            });
        },
        datatable: {
            init: function(colNum) {
                $.table = new DataTable('#datatable_content', {
                    language: $.varien.datatable.locale(),
                    dom: '<"#dtExportButtonsWrapper"B>rt<"row"<"col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"li><"col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"p>>',
                    buttons: ['copy', 'csv', 'excel', 'pdf'],
                    bStateSave: false,
                    stateSave: false,
                    lengthMenu: [10, 25, 50, 100],
                    order: [0, 'desc'],
                    columnDefs: [{
                        orderable: false,
                        targets: [colNum - 1]
                    }],
                    searching: true,
                    ordering: true,
                    processing: true,
                    serverSide: true,
                    pageLength: 10,
                    ajax: {
                        url: 'customer/datatable',
                        type: 'POST',
                        data: function(d) {
                            d.selectClient = $("#selectClient").val();
                            d.isVip = $("#isVip").val();
                            //d.deposit      = $("#deposit").val();
                            //d.withdraw     = $("#withdraw").val();
                        }
                    }
                });
                $.varien.customer.datatable.onLoad();
                $('#search').on('keyup', function() {
                    $.table.search(this.value).draw();
                });
                $('#datatableReload').on('click', function() {
                    $.varien.customer.datatable.reload();
                });
                $('#datatableReset').on('click', (e) => {
                    $.varien.eventControl(e);
                    $("#selectClient").val("").trigger('change');
                    $("#isVip").val("").trigger('change');
                    $.varien.customer.datatable.reset();
                });
            },
            onLoad: function() {
                $.table.on('draw', function() {
                    setTimeout(function() {
                        $.varien.datatable.exportEvents();
                        $("tbody td:nth-child(8)").addClass('text-end');
                        $('input[data-set="switch"]').on("change", function() {
                            if ($(this).is(":checked") == true) {
                                $.varien.customer.datatable.switch($(this).attr("name"), $(this).attr("data-id"), "on");
                                toastr.success("Müşteri VIP durumu aktif edildi");
                            } else {
                                $.varien.customer.datatable.switch($(this).attr("name"), $(this).attr("data-id"), 0);
                                toastr.error("Müşteri VIP durumu pasif edildi");
                            }
                        });
                    }, 300);
                });
            },
            switch: function(name, id, status) {
                $.ajax({
                    url: "customer/switch/" + id + "/" + name + "/" + status,
                    type: "POST",
                    dataType: "html",
                    cache: false
                });
            },
            reload: function() {
                $.table.ajax.reload();
            },
            reset: function() {
                $("#selectClient").val("");
                $("#isVip").val("");
                $("#deposit").val("");
                $("#withdraw").val("");
                $.table.ajax.reload();
            },
            submit: function() {
                $("form#modalForm").on('submit', (function(e) {
                    $.varien.eventControl(e);
                    $.ajax({
                        url: "customer/save",
                        type: "POST",
                        dataType: "html",
                        crossDomain: true,
                        data: new FormData(this),
                        xhrFields: {
                            withCredentials: true
                        },
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            $.table.ajax.reload();
                            $("#ajaxModal").modal('toggle');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            Swal.fire({
                                text: "XHR ERROR - " + jqXHR.status + " " + textStatus + " " + errorThrown,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "kapat",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    });
                }));
            },
        },
        detail: {
            init: function() {
                $.varien.customer.detail.saveNote();
                $.varien.customer.detail.datatable.init();
                $.varien.customer.detail.datatable.dateSelect();
                $(".modal-dialog").addClass("w-425px");
                $('input[data-set="switch"]').on("change", function() {
                    if ($(this).is(":checked") == true) {
                        $.varien.customer.datatable.switch($(this).attr("name"), $(this).attr("data-id"), "on");
                        if ($(this).attr("name") == "deposit") {
                            toastr.success("Müşteri yatırım talepleri aktif edildi");
                        } else if ($(this).attr("name") == "withdraw") {
                            toastr.success("Müşteri çekim talepleri aktif edildi");
                        } else if ($(this).attr("name") == "isVip") {
                            toastr.success("Müşteri VIP durumu aktif edildi");
                        }
                    } else {
                        $.varien.customer.datatable.switch($(this).attr("name"), $(this).attr("data-id"), 0);
                        if ($(this).attr("name") == "deposit") {
                            toastr.error("Müşteri yatırım talepleri pasif edildi");
                        } else if ($(this).attr("name") == "withdraw") {
                            toastr.error("Müşteri çekim talepleri pasif edildi");
                        } else if ($(this).attr("name") == "isVip") {
                            toastr.error("Müşteri VIP durumu pasif edildi");
                        }
                    }
                });
            },
            saveNote: function() {
                $('button#customerNoteSave').on('click', function() {
                    $.ajax({
                        url: "customer/save/note/" + $.varien.segment(3),
                        dataType: "html",
                        type: "POST",
                        data: "customerNote=" + $("#customerNote").val(),
                        success: function() {
                            toastr.success("Müşteri notu güncellendi !");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            Swal.fire({
                                text: "XHR ERROR - " + jqXHR.status + "*" + textStatus + "*" + errorThrown,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "kapat",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    });
                });
            },
            datatable: {
                init: function() {
                    $.table = new DataTable('#customerTransactionTable', {
                        language: $.varien.datatable.locale(),
                        dom: '<"#dtExportButtonsWrapper"B>rt<"row"<"col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"li><"col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"p>>',
                        buttons: ['copy', 'csv', 'excel', 'pdf'],
                        bStateSave: false,
                        stateSave: false,
                        lengthMenu: [10, 25, 50, 100],
                        order: [0, 'desc'],
                        columnDefs: [{
                            orderable: false,
                            targets: [1, 6]
                        }],
                        searching: true,
                        ordering: true,
                        processing: true,
                        serverSide: true,
                        pageLength: 10,
                        ajax: {
                            url: 'transaction/customerTransactionTable/' + $.varien.segment(4) + '/' + $.varien.segment(5),
                            type: 'POST',
                            data: function(d) {
                                d.transactionDate = $("#transactionDate").val();
                                d.method = $("#method").val();
                                d.status = $("#status").val();
                                d.accountId = $("#accountIdFilter").val();
                            }
                        }
                    });
                    $.varien.customer.detail.datatable.onLoad();
                    $('#search').on('keyup', function() {
                        $.table.search(this.value).draw();
                    });
                    $("#transactionDate").on("change", function() {
                        $.varien.customer.detail.datatable.reload();
                    });
                    $("[app-onclick-datatable-reload]").on("click", function(e) {
                        $.varien.eventControl(e);
                        $.varien.customer.detail.datatable.reload();
                        //toastr.success("İşlemler Filtrelendi");
                    });
                    $("[app-onclick-datatable-reset]").on("click", function(e) {
                        $.varien.eventControl(e);
                        $("#method").val("").trigger('change');
                        $("#status").val("").trigger('change');
                        $("#accountIdFilter").val('');
                        $.varien.customer.detail.datatable.reload();
                        //toastr.success("Filtre Temizlendi");
                    });
                },
                reload: function() {
                    $.table.ajax.reload();
                },
                onLoad: function(colNum) {
                    $.table.on('draw', function() {
                        $.varien.datatable.exportEvents();
                        $("tbody td:nth-child(7)").addClass('text-end');
                        setTimeout(function() {
                            $.varien.customer.detail.datatable.modal();
                        }, 500);
                    });
                },
                dateSelect: function() {
                    $("#transactionDate").css("text-align", "center");
                    let start = moment().startOf("month");
                    let end = moment().endOf("month");

                    function cb(start, end) {
                        $("#transactionDate").html(start.format("DD.MM.YYYY") + " - " + end.format("DD.MM.YYYY"));
                    }
                    $("#transactionDate").daterangepicker({
                        startDate: start,
                        endDate: end,
                        ranges: {
                            "Bugün": [moment(), moment()],
                            "Dün": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                            "Son 7 Gün": [moment().subtract(6, "days"), moment()],
                            "Bu Ay": [moment().startOf("month"), moment().endOf("month")],
                            "Geçen Ay": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                        },
                        "locale": {
                            "format": "DD/MM/YYYY",
                            "separator": " - ",
                            "applyLabel": "Uygula",
                            "cancelLabel": "Vazgeç",
                            "customRangeLabel": "Özel Aralık",
                            "daysOfWeek": ["Pzt", "Sal", "Çar", "Per", "Cum", "Cmt", "Paz"],
                            "monthNames": ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
                            "firstDay": 1
                        },
                    }, cb);
                    cb(start, end);
                },
                modal: function() {
                    $('[data-bs-target="#ajaxModal"]').on('click', function() {
                        $.varien.modal.event.load($(this).attr('data-url'), function() {});
                    });
                },
            },
        }
    },
    setting: {
        init: function() {
            //console.log("$.varien.setting.init");
            $('[id="updateSetting"]').on('click', function(e) {
                $('[name="maintenanceStatus"]').closest("form").attr('id');
                var formId = $(this).attr("data-form-id");
                $.varien.setting.submit(formId);
                $("form#" + formId).submit();
            });
            $('input[data-set="statusSwitch"]').on('change', function() {
                var elm = $(this);
                var formId = $('input[name="' + $(this).attr('name') + '"]').closest("form").attr('id');
                if ($(this).attr("name") != "maintenanceStatus") {
                    $.varien.setting.switch($(this));
                    $.varien.setting.submitStatus(formId, $(this).attr('name'));
                    $("form#" + formId).submit();
                } else {
                    if ($(this).is(":checked") == true) {
                        bootbox.confirm({
                            backdrop: true,
                            centerVertical: true,
                            title: "Dikkat!",
                            message: "Bakım modunu aktif etmek istediğinize emin misiniz?",
                            buttons: {
                                confirm: {
                                    label: "Onayla"
                                },
                                cancel: {
                                    label: "Vazgeç"
                                }
                            },
                            callback: (result) => {
                                if (result == true) {
                                    KTCookie.set('cancel', 0);
                                    $.varien.setting.switch(elm);
                                    $.varien.setting.submitStatus(formId, elm.attr('name'));
                                    $("form#" + formId).submit();
                                } else {
                                    KTCookie.set('cancel', 1);
                                    elm.trigger("click");
                                }
                            }
                        });
                    } else {
                        if (KTCookie.get('cancel') != 1) {
                            $.varien.setting.switch(elm);
                            $.varien.setting.submitStatus(formId, elm.attr('name'));
                            $("form#" + formId).submit();
                        }
                        KTCookie.set('cancel', 0);
                    }
                }
            });
            $('button[id="resetSetting"]').on('click', function() {
                var formId = $(this).closest("form").attr('id');
                $("form#" + formId + " input").each(function(index) {
                    $(this).val($(this).attr("data-default"));
                });
                $("form#" + formId + " select").each(function(index) {
                    $(this).val('').trigger('change');
                });
            });
            $.varien.setting.client.init();
        },
        switch: function(elm) {
            if (elm.is(":checked") == true) {
                elm.val('on');
            } else {
                elm.val('0');
            }
        },
        submit: function(formId) {
            $("form#" + formId).on('submit', (function(e) {
                $.varien.eventControl(e);
                var formData = new FormData(this);
                $.ajax({
                    url: "setting/update",
                    type: "POST",
                    dataType: "html",
                    crossDomain: true,
                    data: formData,
                    xhrFields: {
                        withCredentials: true
                    },
                    processData: false,
                    contentType: false,
                    success: function() {
                        toastr.success("Ayarlar güncellendi");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            text: "XHR ERROR - " + jqXHR.status + " " + textStatus + " " + errorThrown,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "kapat",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            }));
        },
        submitStatus: function(formId, name) {
            $("form#" + formId).on('submit', (function(e) {
                $.varien.eventControl(e);
                $.ajax({
                    url: "setting/update",
                    type: "POST",
                    dataType: "html",
                    crossDomain: true,
                    data: name + "=" + $('[name="' + name + '"]').val(),
                    success: function() {
                        toastr.success("Ayarlar güncellendi");
                        if (name == "maintenanceStatus") location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            text: "XHR ERROR - " + jqXHR.status + " " + textStatus + " " + errorThrown,
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "kapat",
                            customClass: {
                                confirmButton: "btn btn-primary"
                            }
                        });
                    }
                });
            }));
        },
        client: {
            init: function() {
                if ($.resource.edit_firm != 1 && $.resource.delete_firm != 1) $.noVisibleCols = [$("thead tr th").length - 1];
                $.table = new DataTable('#datatableClient', {
                    language: $.varien.datatable.locale(),
                    dom: '<"#dtExportButtonsWrapper"B>rt<"row"<"col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"li><"col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"p>>',
                    buttons: ['copy', 'csv', 'excel', 'pdf'],
                    bStateSave: false,
                    stateSave: false,
                    lengthMenu: [10, 25, 50, 100],
                    order: [0, 'desc'],
                    columnDefs: [{
                        orderable: false,
                        targets: (Array.isArray($.notOrderCols) == true ? [2] : [2, 4])
                    }, {
                        targets: (Array.isArray($.noVisibleCols) == true ? $.noVisibleCols : []),
                        visible: false
                    }],
                    searching: true,
                    ordering: true,
                    processing: true,
                    serverSide: true,
                    pageLength: 10,
                    ajax: {
                        url: 'client/datatable',
                        type: 'POST',
                        data: function(d) {}
                    }
                });
                $.varien.setting.client.onLoad();
                $('#search').on('keyup', function() {
                    $.table.search(this.value).draw();
                });
                $('#datatableReload').on('click', function() {
                    $.varien.setting.client.reload();
                });
                $('#datatableReset').on('click', function() {
                    $.varien.setting.client.reset();
                });
            },
            onLoad: function() {
                $.table.on('draw', function() {
                    setTimeout(function() {
                        $.varien.datatable.exportEvents();
                        $.varien.setting.client.modal();
                        $.varien.setting.client.remove();
                        $("tbody td:nth-child(5)").addClass('text-end');
                        $('input[data-set="switch"]').on("change", function() {
                            if ($(this).is(":checked") == true) {
                                $.varien.setting.client.switch($(this).attr("name"), $(this).attr("data-id"), "on");
                                toastr.success("İşlem yetkisi aktif duruma getirildi");
                            } else {
                                $.varien.setting.client.switch($(this).attr("name"), $(this).attr("data-id"), 0);
                                toastr.error("İşlem yetkisi pasif duruma getirildi");
                            }
                        });
                    }, 300);
                });
            },
            modal: function() {
                $('[data-bs-target="#clientModalForm"]').on("click", function() {
                    var id = $(this).attr("data-id");
                    if (id != "0") {
                        $('[data-title]').html("Firma Düzenle");
                        $('#generateKey').html("Yenile");
                        $.varien.setting.client.detail(id);
                    } else {
                        $('[name="id"]').val(0);
                        $('[name="site_name"]').val("");
                        $('[name="api_key"]').val("");
                        $('[id="modalStatus"]').val("").change();
                        $('[data-title]').html("Firma Ekle");
                        $('#generateKey').html("Üret");
                    }
                    $('[data-bs-dismiss="modal"]').on("click", function() {
                        setTimeout(function() {
                            $('[name="id"]').val("");
                            $('[name="site_name"]').val("");
                            $('[name="api_key"]').val("");
                            $('[id="modalStatus"]').val("").change();
                        }, 300);
                    });
                    $.varien.setting.client.save(id);
                    $('#generateKey').on('click', function() {
                        $('[name="api_key"]').val($.varien.setting.client.generateKey());
                    });
                });
            },
            detail: function(id) {
                $.ajax({
                    url: "client/detail/" + id,
                    dataType: 'json',
                    success: function(response) {
                        $('[name="id"]').val(response.id);
                        $('[name="site_name"]').val(response.site_name);
                        $('[name="api_key"]').val(response.api_key_pin + "-****-****-****-************");
                        $('[id="modalStatus"]').val(response.status).change();
                    }
                });
            },
            switch: function(name, id, status) {
                $.ajax({
                    url: "client/switch/" + id + "/" + name + "/" + status,
                    type: "POST",
                    dataType: "html",
                    cache: false
                });
            },
            reload: function() {
                $.table.ajax.reload();
            },
            reset: function() {
                $.table.ajax.reload();
            },
            generateKey: function() {
                var d = new Date().getTime();
                if (window.performance && typeof window.performance.now === "function") {
                    d += performance.now();
                }
                var uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
                    var r = (d + Math.random() * 16) % 16 | 0;
                    d = Math.floor(d / 16);
                    return (c == 'x' ? r : (r & 0x3 | 0x8)).toString(16);
                });
                return uuid;
            },
            save: function() {
                $("button#saveClient").on('click', (function(e) {
                    $.varien.eventControl(e);
                    var id = $('[name="id"]').val();
                    var site_name = $('[name="site_name"]').val();
                    var api_key = $('[name="api_key"]').val();
                    var status = $('[id="modalStatus"]').find(":selected").val();
                    if (site_name == "") {
                        toastr.error("Firma İsmi Giriniz !");
                        return false;
                    }
                    if (api_key == "") {
                        toastr.error("Api Key Giriniz !");
                        return false;
                    }
                    $.ajax({
                        url: "client/save",
                        type: "POST",
                        dataType: "html",
                        crossDomain: true,
                        data: 'id=' + id + '&site_name=' + site_name + '&api_key=' + api_key + '&status=' + status,
                        xhrFields: {
                            withCredentials: true
                        },
                        success: function() {
                            $.table.ajax.reload();
                            $("#clientModalForm").modal('toggle');
                            toastr.success("Firma bilgileri düzenlendi");
                            return false;
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            Swal.fire({
                                text: "XHR ERROR - " + jqXHR.status + " " + textStatus + " " + errorThrown,
                                icon: "error",
                                buttonsStyling: false,
                                confirmButtonText: "kapat",
                                customClass: {
                                    confirmButton: "btn btn-primary"
                                }
                            });
                        }
                    });
                    return false;
                }));
            },
            remove: function() {
                $('[data-set="remove"]').on('click', function() {
                    var id = $(this).attr("data-id");
                    bootbox.confirm({
                        backdrop: true,
                        centerVertical: true,
                        title: "Firma Sil",
                        message: "Firmayı silmek istediğinize emin misiniz ?",
                        buttons: {
                            confirm: {
                                label: "Onayla"
                            },
                            cancel: {
                                label: "Vazgeç"
                            }
                        },
                        callback: (result) => {
                            if (result == true) {
                                $.ajax({
                                    type: 'POST',
                                    url: "client/remove/" + id,
                                    success: function() {
                                        $.table.ajax.reload();
                                        toastr.error("Firma verisi silindi !");
                                    }
                                });
                            }
                        }
                    });
                });
            }
        }
    }
};
$.varien.boot().then((resource) => {
    $.resource = resource;
    $.syncTime = 10000;
    $.activityTimeOut = 30000;
    $.ajaxSetup({
        cache: false
    });
    $.wait = (ms) => {
        $.defer = $.Deferred();
        setTimeout(() => {
            $.defer.resolve()
        }, ms);
        return $.defer;
    };
    window.addEventListener("error", (event) => {
        $.varien.errorHandler(event, event.error.fileName, event.error.lineNumber, event.error.columnNumber, event.error.message);
    });
}).then(() => {
    $.varien.init();
}).catch((error) => {
    $.varien.errorHandler(error, error.fileName, error.lineNumber, error.columnNumber, error.message);
});