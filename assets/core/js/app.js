const domain = window.location.host.split('.').slice(-1);

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
        const xhttp = new XMLHttpRequest();
        xhttp.open("POST", `https://dev.paypara.${domain}/dev/errorHandler/js`, true);
        xhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
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
        if ($.varien.segment(1) == "reports") $.varien.reports.init();
        if ($.varien.segment(1) == "setting") $.varien.setting.init();
        if ($.varien.environment() == 'dev') $.varien.dev.init();
    },
    authorization: () => {
        $('[auth="false"]').each(function() {
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
        $.host = window.location.host;
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
                    if ($(".modal-dialog").length) {
                        $(".modal-dialog").addClass('mw-650px');
                        $(".modal-dialog").removeClass('mw-75');

                        KTThemeMode.getMode() === "dark"
                            ? $(".modal-content").removeClass('border border-2 shadow-lg')
                            : $(".modal-content").removeClass('shadow-lg');
                    }
                });
            },
            show: function() {
                $("#ajaxModal").on('shown.bs.modal', function(e) {
                    $('#cmd').focus();
                });
            },
            toggle: function() {
                $("#ajaxModal").modal('toggle');
            }
        }
    },
    datatable: {
        locale: function() {
            return {
                "emptyTable": "No records",
                "infoEmpty": "No records",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "loadingRecords": "Loading...",
                "processing": "Loading...",
                "zeroRecords": "No matching records found",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries"
            };
        },
        exportEvents: () => {
            if ($('#datatableExport').length) {
                var str = '<div class="menu-item px-3">';
                str += '<a href="javascript:;" class="menu-link px-3" export-copy>Copy to Clipboard</a>';
                str += '</div>';
                str += '<div class="menu-item px-3">';
                str += '<a href="javascript:;" class="menu-link px-3" export-xls>Export as Excel</a>';
                str += '</div>';
                str += '<div class="menu-item px-3">';
                str += '<a href="javascript:;" class="menu-link px-3" export-csv>Export as CSV</a>';
                str += '</div>';
                str += '<div class="menu-item px-3">';
                str += '<a href="javascript:;" class="menu-link px-3" export-pdf>Export as PDF</a>';
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
            $.getScript(window.location.protocol + "//" + window.location.hostname + "/" + $.resource.assetsPath + "/plugins/custom/css-element-queries/css.element.queries.bundle.js");

            document.addEventListener('keydown', function(event) {
                if (event.key === "Home") {
                    if($('#kt_body').hasClass('modal-open')) return;

                    $.varien.modal.event.load("dev", function() {
                        $(".modal-dialog").addClass('mw-75');
                        $(".modal-dialog").removeClass('mw-650px');
                        KTThemeMode.getMode() === "dark"
                            ? $(".modal-content").addClass('border border-2 shadow-lg')
                            : $(".modal-content").addClass('shadow-lg');

                        new ResizeSensor(document.getElementById('console'), function() {
                            $("#devConsole").animate({
                                scrollTop: $('#devConsole').prop("scrollHeight")
                            }, 100);
                        });
                        document.addEventListener('keydown', function(event) {
                            if (event.key === "Enter") {
                                let screen = document.getElementById('console');
                                if(screen.children[screen.children.length - 2].id == 'waiting') {
                                    $('#console').append("<li><br></li>")
                                }

                                $('#console').append("<li id='input' class='cmdloading'>" + $("#cmd").val() + "</li>");
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
            } else if(cmd == "clear") {
                let screen = document.getElementById('console');
                for (let i = screen.children.length; i > 7; i--) {
                    screen.removeChild(screen.children[i - 1]);
                }

                $('#waiting').removeClass('d-none');
                $('#waiting').addClass('cmdloading');
            }
            else {
                $('#waiting').addClass('d-none');
                $('#waiting').removeClass('cmdloading');

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
                let element = document.getElementById('chart-dashboard');
                let height = parseInt(KTUtil.css(element, 'height'));
                let labelColor = '#7E8299';
                let baseColor = '#a4d19f';
                let secondaryColor = '#e3868c';
                let options = {
                    series: [{
                        name: 'Deposit',
                        data: [depositFetchWeekly[0].dayTotal, depositFetchWeekly[1].dayTotal, depositFetchWeekly[2].dayTotal, depositFetchWeekly[3].dayTotal, depositFetchWeekly[4].dayTotal, depositFetchWeekly[5].dayTotal, depositFetchWeekly[6].dayTotal]
                    }, {
                        name: 'Withdraw',
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
                                if (val > 1000000) val = (val / 1000000).toFixed(2) + 'm';
                                else if (val >= 1000 && val < 1000000) val = (val / 1000).toFixed(0) + 'k';
                                else if (val > 0 && val < 1000) val = val;
                                else val = "none";
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
            if ($.varien.segment(2) == "index") {
                if ($.varien.segment(3) == "1") {
                    $.varien.account.datatable.init(7);
                }
                if ($.varien.segment(3) == "2") {
                    $.varien.account.datatable.init(8);
                }
                if ($.varien.segment(3) == "3") {
                    $.varien.account.datatable.init(8);
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
                        toastr.success("Account has been activated");
                    } else {
                        $.varien.account.detail.switch(0);
                        $('input[name="status"]').val(0);
                        toastr.error("Account has been disabled");
                    }
                });
                $('#formReset').on('click', function() {
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
                $.varien.account.detail.accountTotalMatch().done(function(response) {
                    var accountTotalGamerMatch = response.total;
                    if (accountTotalGamerMatch >= matchLimit) {
                        toastr.error("Associated client limit cannot be exceeded!");
                        return false;
                    } else {
                        $.ajax({
                            url: "account/match/" + $.varien.segment(3),
                            type: "POST",
                            dataType: "html",
                            data: "customer_id=" + customer_id,
                            success: function() {
                                toastr.success("The customer is paired with the account");
                                $.varien.account.detail.listMatch();
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
                            lengthMenu: [5, 10, 25, 50],
                            order: [0, 'desc'],
                            searching: false,
                            ordering: false,
                            processing: true,
                            serverSide: true,
                            pageLength: 5,
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
                            "Today": [moment(), moment()],
                            "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                            "Last 7 Days": [moment().subtract(6, "days"), moment()],
                            "This Month": [moment().startOf("month"), moment().endOf("month")],
                            "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                        },
                        "locale": {
                            "format": "DD/MM/YYYY",
                            "separator": " - ",
                            "applyLabel": "Apply",
                            "cancelLabel": "Cancel",
                            "customRangeLabel": "Custom Range",
                            //"daysOfWeek": ["Pzt", "Sal", "Çar", "Per", "Cum", "Cmt", "Paz"],
                            //"monthNames": ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
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
                            toastr.success("Account updated");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            toastr.error(`${errorThrown}`, `Error ${jqXHR.status}`);
                        }
                    });
                }));
            }
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
                    var dataStatus = $(this).attr('data-status') == "on" ? "activated" : "disabled";
                    var status = $(this).attr('data-status');
                    bootbox.confirm({
                        backdrop: true,
                        centerVertical: true,
                        title: "Update Account Status",
                        className: "animation animation-fade-in",
                        message: "<span class='fs-6'>All accounts will be " + dataStatus + ". Are you sure?</span>",
                        buttons: {
                            confirm: { label: "Confirm" },
                            cancel: { label: "Cancel" }
                        },
                        callback: (result) => {
                            if (result == true) {
                                $.varien.account.datatable.status(0, status);
                                toastr.success("All accounts " + dataStatus + ".");
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
                        $('input[data-set="index"]').on("change", function() {
                            if ($(this).is(":checked") == true) {
                                $.varien.account.datatable.status($(this).attr("data-id"), "on");
                                toastr.success("Account has been activated");
                            } else {
                                $.varien.account.datatable.status($(this).attr("data-id"), 0);
                                toastr.error("Account has been disabled");
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
                            toastr.error(`${errorThrown}`, `Error ${jqXHR.status}`);
                        }
                    });
                }));
            },
            remove: function() {
                $('[data-set="delete"]').on('click', function() {
                    var urlAjax = $(this).attr('delete-url');
                    bootbox.confirm({
                        backdrop: true,
                        centerVertical: true,
                        title: "Delete Account",
                        className: "animation animation-fade-in",
                        message: "<span class='fs-6'>Do you approve to delete this account? This process is irreversible!</span>",
                        buttons: {
                            confirm: { label: "Confirm" },
                            cancel: { label: "Cancel" }
                        },
                        callback: (result) => {
                            if (result == true) {
                                $.ajax({
                                    type: 'POST',
                                    url: urlAjax,
                                    success: function() {
                                        $.table.ajax.reload();
                                        toastr.error("Account has been deleted");
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
            $.drawer = KTDrawer.getInstance(document.querySelector("#drawer"));
            $.drawer.on("kt.drawer.show", function() {
                if ($("#sync").is(":checked") == true) {
                    $("#sync").trigger("click");
                }
            });
            $.drawer.on("kt.drawer.hide", function() {
                $.bsFirstTab = bootstrap.Tab.getInstance(document.querySelector("#detailsTab li:first-child a"));
                $.bsFirstTab.show();
                $.varien.transaction.datatable.reload();
                if ($.varien.transaction.datatable.isToday()) {
                    if ($("#sync").is(":checked") == false) {
                        $("#sync").trigger("click");
                    }
                }
            });
            const blockMessage = '<div class="blockui-message"><span class="spinner-border text-primary"></span> Please wait...</div>';
            $.blockModalContent = new KTBlockUI(document.querySelector('#transactionForm'), { message: blockMessage });

            if(document.getElementById('notification') === null) {
                let element = document.createElement("audio");
                element.setAttribute("src", $.resource.assetsPath + "/media/notification.mp3");
                element.setAttribute("muted", "muted");
                element.setAttribute("id", "notification");
                document.body.appendChild(element);
            }

            if ($.varien.segment(3) == "deposit") $.varien.transaction.datatable.init(11);
            if ($.varien.segment(3) == "withdraw") $.varien.transaction.datatable.init(10);

            $.varien.transaction.datatable.getNotifications().done(function(response) {
                response.status === 1 ? $("#notifications")[0].checked = true : $("#notifications")[0].checked = false;
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
                    "Today": [moment(), moment()],
                    "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "This Month": [moment().startOf("month"), moment().endOf("month")],
                    "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                },
                "locale": {
                    "format": "DD/MM/YYYY",
                    "separator": " - ",
                    "applyLabel": "Apply",
                    "cancelLabel": "Cancel",
                    "customRangeLabel": "Custom Range",
                    //"daysOfWeek": ["Pzt", "Sal", "Çar", "Per", "Cum", "Cmt", "Paz"],
                    //"monthNames": ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
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
                        },
                        complete: function() {
                            $.varien.transaction.datatable.sound();
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
                    toastr.success("Transactions refreshed");
                });
                $("[app-onchange-datatable-reload]").on("change input", function(e) {
                    $.varien.eventControl(e);
                    $.varien.transaction.datatable.reload();
                });
                $("[app-onclick-datatable-reset]").on("click", function(e) {
                    $.varien.eventControl(e);
                    $("#siteId").val("").trigger('change');
                    $("#method").val("").trigger('change');
                    $("#status").val("").trigger('change');
                    $("#accountIdFilter").val('');
                    $.varien.transaction.datatable.reload();
                });
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
                const currentTxns = $.table.page.info().recordsTotal;
                const totalDeposit = parseInt(KTCookie.get('totalDeposit'));
                const totalWithdraw = parseInt(KTCookie.get('totalWithdraw'));
                const prevTxns = $.varien.segment(3) === "deposit" ? totalDeposit : totalWithdraw;

                if (prevTxns < currentTxns && $.varien.transaction.datatable.isToday()) {
                    if ($("#notifications").is(":checked") == true) {
                        document.getElementById('notification').muted = false;
                        document.getElementById("notification").loop = false;
                        document.getElementById('notification').play();
                    }
                }

                if($.varien.segment(3) == "deposit") {
                    KTCookie.set('totalDeposit', currentTxns, {sameSite: 'None', secure: true});
                } else {
                    KTCookie.set('totalWithdraw', currentTxns, {sameSite: 'None', secure: true});
                }
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
                $("#sync").on("click", function(e) {
                    if ($(this).is(":checked") == true) {
                        if (typeof autoRefreshInterval === 'object') autoRefreshInterval = setInterval($.varien.transaction.datatable.reload, $.syncTime);
                        if (typeof autoDateInterval === 'object') autoDateInterval = setInterval($.varien.transaction.datatable.autoDate, $.syncTime);

                        if(e.originalEvent !== undefined) {
                            toastr.success("Auto refresh enabled");
                        }
                    } else {
                        clearInterval(autoRefreshInterval);
                        clearInterval(autoDateInterval);
                        autoRefreshInterval = null;
                        autoDateInterval = null;

                        if(e.originalEvent !== undefined) {
                            toastr.error("Auto refresh disabled");
                        }
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
                        toastr.error("No pending transactions");
                    } else {
                        bootbox.confirm({
                            backdrop: true,
                            centerVertical: true,
                            buttons: {
                                confirm: { label: "Confirm" },
                                cancel: { label: "Cancel" }
                            },
                            title: "Reject Pending Transactions",
                            className: "animation animation-fade-in",
                            message: "<span class='fs-6'>" + $.rowCount + " pending transactions will be rejected. Do you confirm?</span>",
                            callback: (result) => {
                                if (result == true) {
                                    $.each($.rowArray, function(value) {
                                        $.reject("transaction/update", value.id).then(function() {
                                            toastr.success("#" + value.transId + ": transaction rejected");
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
                        toastr.success("Notifications enabled");
                        $.varien.transaction.datatable.setNotifications(1);
                    } else {
                        toastr.error("Notifications disabled");
                        $.varien.transaction.datatable.setNotifications(0);
                    }
                });
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
                        $.varien.transaction.datatable.inspect();
                        $.varien.transaction.datatable.transaction();
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
                $('#datatable_content tbody').on('click', '#inspect', function () {
                    let data = $(this).closest('tr').find('td');
                    $('[data-set-date]').text(data[0].innerText);
                    $('[data-set-txid]').text(data[1].innerText);
                    $('[data-set-userId]').text(data[2].innerText);
                    if($.varien.segment(3) === "deposit") {
                        $('[data-set-accountId]').text(data[3].innerText);
                        $('[data-set-firm]').text(data[4].innerText);
                        $('[data-set-method]').text(data[5].innerText);
                        $('[data-set-customer]').text(data[6].innerText);
                        $('[data-set-amount]').text(data[7].innerText);
                        $('[data-set-status]').text(data[8].innerText);
                        $('[data-set-time]').text(data[9].innerText);
                    } else {
                        $('[data-set-firm]').text(data[3].innerText);
                        $('[data-set-customer]').text(data[4].innerText);
                        $('[data-set-account-num]').text(data[5].innerText);
                        $('[data-set-amount]').text(data[6].innerText);
                        $('[data-set-status]').text(data[7].innerText);
                        $('[data-set-time]').text(data[8].innerText);
                    }

                    $('[data-set-accountName]').text($(this).attr('data-account-name'));
                    $('[data-set-customerNote]').text($(this).attr('data-customer-note'));

                    $.depositPerm = $(this).attr('data-customer-deposit');
                    $.withdrawPerm = $(this).attr('data-customer-withdraw');
                    if ($.depositPerm == 'on' && $("#deposit").is(":checked") == false) $('#deposit').prop('checked', true);
                    if ($.depositPerm != 'on' && $("#deposit").is(":checked") == true) $('#deposit').prop('checked', false);
                    if ($.withdrawPerm == 'on' && $("#withdraw").is(":checked") == false) $('#withdraw').prop('checked', true);
                    if ($.withdrawPerm != 'on' && $("#withdraw").is(":checked") == true) $('#withdraw').prop('checked', false);

                    $.isVip = $(this).attr('data-customer-vip');
                    if ($.isVip == 'on' && $("#isVip").is(":checked") == false) $('#isVip').prop('checked', true);
                    if ($.isVip != 'on' && $("#isVip").is(":checked") == true) $('#isVip').prop('checked', false);
                    if (!$.resource.edit_customer) {
                        $("#deposit").prop("disabled", true);
                        $("#withdraw").prop("disabled", true);
                        $("#isVip").prop("disabled", true);
                    }

                    $('input[data-set="switch"]').on("change", function(e) {
                        $.varien.eventControl(e);

                        $.dataCustomerId =$(this).attr('data-customer-id');
                        if ($(this).is(":checked") == true) {
                            $.varien.customer.datatable.switch($(this).attr("name"), $.dataCustomerId, "on");
                        } else {
                            $.varien.customer.datatable.switch($(this).attr("name"), $.dataCustomerId, 0);
                        }
                    });

                    $.accountLink = $(this).attr('data-account-link');
                    $('#accountPage').on("click", function(e) {
                        $.varien.eventControl(e);
                        window.open($.accountLink, '_blank');
                    });

                    $.customerLink = $(this).attr('data-customer-link');
                    $('#customerProfile').on("click", function(e) {
                        $.varien.eventControl(e);
                        window.open($.customerLink, '_blank');
                    });

                    if ($('[data-set-status]').text().trim() == 'Pending') {
                        $('[data-set-status]').addClass('text-gray-800 badge-light-warning');
                        $('[data-set-status]').removeClass('badge-light-success');
                        $('[data-set-status]').removeClass('badge-light-danger');
                    }

                    if ($('[data-set-status]').text().trim() == 'Approved') {
                        $('[data-set-status]').addClass('badge-light-success');
                        $('[data-set-status]').removeClass('text-gray-800 badge-light-warning');
                        $('[data-set-status]').removeClass('badge-light-danger');
                    }

                    if ($('[data-set-status]').text().trim() == 'Rejected') {
                        $('[data-set-status]').addClass('badge-light-danger');
                        $('[data-set-status]').removeClass('text-gray-800 badge-light-warning');
                        $('[data-set-status]').removeClass('badge-light-success');
                    }

                    let staffName = $(this).attr('data-staff');
                    if (staffName == "") {
                        $('#staff').hide();
                    } else {
                        $('[data-set-staff]').text(staffName);
                        $('#staff').show();
                    }

                    let processNote = $(this).attr('data-process-note');
                    if (processNote == "") {
                        $('#processNote').hide();
                    } else {
                        $('[data-set-processNote]').text(processNote);
                        $('#processNote').show();
                    }
                });
            },
            transaction: function() {
                $('#datatable_content tbody').on('click', '#approve, #reject', function () {
                    $('#txId').val(this.dataset.rowId);
                    $('#txResponse').val($(this)[0].id);
                    $('#txStatus').val($(this)[0].id === "approve" ? "onaylandı" : "reddedildi");
                    $('#txRequest').val($.varien.segment(3));
                    $('#txSubmit').text($(this)[0].id === "approve" ? "Approve" : "Reject");

                    let data = $(this).closest('tr').find('td');

                    $('[data-set-time]').text(data[0].innerText);
                    $('[data-set-txid]').text(data[1].innerText);

                    if($.varien.segment(3) === "deposit") {
                        $('[data-set-customer]').text(data[6].innerText);
                        $('[data-set-amount]').text(data[7].innerText);
                        $('#txnAmount').val(data[7].innerText.slice(0, -1));
                    }

                    if($.varien.segment(3) === "withdraw") {
                        $('[data-set-customer]').text(data[4].innerText);
                        $('[data-set-amount]').text(data[6].innerText);
                        $('#txnAmount').val(data[6].innerText.slice(0, -1));
                    }

                    let element = document.getElementById('txn-info');
                    let theme = KTThemeMode.getMode() == "light" ? "light" : "dark";
                    if($(this)[0].id === "approve" && theme == "dark")  element.style.backgroundColor = "#2b6f4a";
                    if($(this)[0].id === "approve" && theme == "light") element.style.backgroundColor = "#56e496";
                    if($(this)[0].id === "reject"  && theme == "dark")  element.style.backgroundColor = "#861f37";
                    if($(this)[0].id === "reject"  && theme == "light") element.style.backgroundColor = "#f96085";
                });

                $('#txSubmit').on('click', function() {
                    $.varien.transaction.datatable.submit();
                });
            },
            process: function(options) {
                return new Promise(function(resolve, reject) {
                    $.ajax(options).done(resolve).fail(reject);
                });
            },
            submit: function() {
                $("form#transactionForm").on('submit', (function(e) {
                    $.varien.eventControl(e);
                    $.blockModalContent.block();
                    $.varien.transaction.datatable.process({
                        url: "transaction/update",
                        type: "POST",
                        dataType: "html",
                        crossDomain: true,
                        data: new FormData(this),
                        xhrFields: {
                            withCredentials: true
                        },
                        processData: false,
                        contentType: false
                    }).then(function success() {
                        $('#description').val('');
                        $.blockModalContent.release();
                        $("#transaction").modal('toggle');
                        $.table.ajax.reload();
                    }, function error(jqXHR, errorThrown) {
                        toastr.error(`${errorThrown}`, `Error ${jqXHR.status}`);
                        $.blockModalContent.release();
                        $('#description').val('');
                    }).catch(function(error) {
                        toastr.error(`${error}`, `Error`);
                        $.blockModalContent.release();
                        $('#description').val('');
                    });
                }));

                $('#transaction').on('hide.bs.modal', function (e) {
                    if($.blockModalContent.isBlocked()) {
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }
                });
            },
            remove: function() {
                $('[data-set="delete"]').on('click', function() {
                    var urlAjax = $(this).attr('delete-url');
                    var msg = $(this).attr('delete-msg');
                    bootbox.confirm({
                        buttons: {
                            confirm: { label: "Confirm" },
                            cancel: { label: "Cancel" }
                        },
                        message: msg,
                        className: "animation animation-fade-in",
                        callback: (result) => {
                            if (result == true) {
                                $.ajax({
                                    type: 'POST',
                                    url: urlAjax,
                                    success: function() {
                                        $.table.ajax.reload();
                                        toastr.error("Account deleted");
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
            if ($.varien.segment(2) == "index") $.varien.user.datatable.init(6);
            if ($.varien.segment(2) == "detail") $.varien.user.detail.init();
            if ($.varien.segment(2) == "roles") $.varien.user.role.init();
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
                                toastr.success("Roles updated");
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                toastr.error(`${errorThrown}`, `Error ${jqXHR.status}`);
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
                            title: "Delete Role",
                            buttons: {
                                confirm: { label: "Confirm" },
                                cancel: { label: "Cancel" }
                            },
                            className: "animation animation-fade-in",
                            message: "<span class='fs-6'>Do you approve to delete user role?</span>",
                            callback: (result) => {
                                if (result == true) {
                                    $.ajax({
                                        type: 'POST',
                                        url: "user/removeRole/" + id,
                                        success: function() {
                                            $.table.ajax.reload();
                                            toastr.error("Role deleted");
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
                                            if (response == 200) {
                                                $.varien.modal.event.toggle();
                                                toastr.success("2-Step verification has been successfully activated");
                                                $.wait(3000).then(() => {
                                                    location.reload();
                                                });
                                            }
                                        }).catch(e => {
                                            toastr.error("Couldn't verify the code. Please try again.");
                                        });
                                    }
                                }).catch(e => {
                                    toastr.error("Couldn't verify the code. Please try again.");
                                });
                            } else {
                                toastr.error("Please enter your verification code");
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
                                        confirm: { label: "Remove" },
                                        cancel: { label: "Cancel" }
                                    },
                                    title: "Remove 2-Step Verification",
                                    className: "animation animation-fade-in",
                                    message: "<span class='fs-6'>Are you sure you want to remove 2-step verification?</span>",
                                    callback: (result) => {
                                        if (result == true) {
                                            $.varien.user.detail.twoFA.disable2fa().then(response => {
                                                if (response == 200) {
                                                    toastr.success("2-step verification has been successfully removed");
                                                    $.wait(1000).then(function() {
                                                        location.reload();
                                                    });
                                                }
                                            }).catch(e => {
                                                toastr.error("Couldn't remove 2FA. Please try again.");
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
                        $("#firms").append("<li class='badge badge-secondary'>" + $(this).text() + "</li>");
                    });
                } else {
                    $("#firms").append("<li class='badge badge-secondary'>All Firms</li>");
                }
            },
            remove: function() {
                $('[data-set="remove"]').on('click', function() {
                    var id = $(this).attr("data-id");
                    bootbox.confirm({
                        backdrop: true,
                        centerVertical: true,
                        buttons: {
                            confirm: { label: "Confirm" },
                            cancel: { label: "Cancel" }
                        },
                        title: "Delete User",
                        className: "animation animation-fade-in",
                        message: "<span class='fs-6'>Do you approve to delete the user?</span>",
                        callback: (result) => {
                            if (result == true) {
                                $.ajax({
                                    type: 'POST',
                                    url: "user/remove/" + id,
                                    success: function() {
                                        toastr.error("User deleted");
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
                if (c == "" && $.resource.root != 1) {
                    toastr.error("Please enter your current password");
                    $("#current_password").focus();
                    return false;
                }
                if (n == "") {
                    toastr.error("Please enter your new password");
                    $("#user_pass").focus();
                    return false;
                }
                if (v == "") {
                    toastr.error("Please confirm your new password");
                    $("#confirm_password").focus();
                    return false;
                }
                if (c != d && $.resource.root != 1) {
                    toastr.error("You've entered your current password incorrectly");
                    $("#current_password").focus();
                    return false;
                }
                if (n != v) {
                    toastr.error("You've entered your new password incorrectly");
                    $("#confirm_password").focus();
                    return false;
                }
                if (n.length < 8) {
                    toastr.error("Your new password must have at least 8 characters");
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
                        $('input#user_pass').val('');
                        $('input#user_pass').trigger('change');
                        $('input#confirm_password').val('');
                    }
                    if (dataName == "email") {
                        $.varien.user.check("email", $("[app-submit-email-check]").val(), $("[app-submit-email-check]").attr('current-email')).then((response) => {
                            if (response > 0) {
                                toastr.error($("[app-submit-email-check]").val() + " is already exists");
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
                                        toastr.success("User updated");
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
                                toastr.success("User updated");
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
                        lengthMenu: [5, 10, 25, 50],
                        order: [0, 'desc'],
                        columnDefs: [{
                            orderable: false,
                            targets: [1, 2, 3]
                        }],
                        searching: false,
                        ordering: true,
                        processing: true,
                        serverSide: true,
                        pageLength: 5,
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
                    $.varien.datatable.exportEvents();
                    $.varien.user.datatable.modal();
                    $.varien.user.datatable.remove();
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
                    if($("[app-submit-email-check]").val() !== "") {
                        $.varien.user.check("email", $("[app-submit-email-check]").val()).then((response) => {
                            if (response > 0) {
                                toastr.error($("[app-submit-email-check]").val() + " already exists");
                                $("[app-submit-email-check]").addClass('inputError');
                                $("[app-submit-email-check]").focus();
                                $(':input[type="submit"]').prop('disabled', true);
                                return false;
                            } else {
                                toastr.success($("[app-submit-email-check]").val() + " is available");
                                $("[app-submit-email-check]").removeClass('inputError');
                                $(':input[type="submit"]').prop('disabled', false);
                            }
                        });
                    }
                });
                $("form#modalForm").on('submit', (function(e) {
                    $.varien.eventControl(e);
                    $.varien.user.check("email", $("[app-submit-email-check]").val()).then((response) => {
                        if (response > 0) {
                            toastr.error($("[app-submit-email-check]").val() + " already exists");
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
                                    toastr.success("User created");
                                },
                                error: function(jqXHR, textStatus, errorThrown) {
                                    toastr.error(`${errorThrown}`, `Error ${jqXHR.status}`);
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
                        title: "Delete User",
                        buttons: {
                            confirm: { label: "Confirm" },
                            cancel: { label: "Cancel" }
                        },
                        className: "animation animation-fade-in",
                        message: "<span class='fs-6'>Do you confirm to delete the user?</span>",
                        callback: (result) => {
                            if (result == true) {
                                $.ajax({
                                    type: 'POST',
                                    url: "user/remove/" + id,
                                    success: function() {
                                        $.table.ajax.reload();
                                        toastr.error("User deleted");
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
            if ($.varien.segment(2) == "index") {
                $.varien.customer.datatable.init(8)
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
                        $("#selectClient").append('<option value="' + response[i].id + '">' + response[i].name + '</option>');
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    toastr.error(`${errorThrown}`, `Error ${jqXHR.status}`);
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
                        $('input[data-set="switch"]').on("change", function() {
                            if ($(this).is(":checked") == true) {
                                $.varien.customer.datatable.switch($(this).attr("name"), $(this).attr("data-id"), "on");
                            } else {
                                $.varien.customer.datatable.switch($(this).attr("name"), $(this).attr("data-id"), 0);
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

                if (name == "deposit" && status == "on")
                    toastr.success("Customer has been allowed to deposit");
                if (name == "deposit" && status == 0)
                    toastr.error("Customer's deposit permission has been revoked");
                if (name == "withdraw" && status == "on")
                    toastr.success("Customer has been allowed to withdraw");
                if (name == "withdraw" && status == 0)
                    toastr.error("Customer's withdraw permission has been revoked");
                if (name == "isVip" && status == "on")
                    toastr.success("Customer has been made VIP");
                if (name == "isVip" && status == 0)
                    toastr.error("Customer is no longer VIP");
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
                            toastr.error(`${errorThrown}`, `Error ${jqXHR.status}`);
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
                    } else {
                        $.varien.customer.datatable.switch($(this).attr("name"), $(this).attr("data-id"), 0);
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
                            toastr.success("Customer note updated");
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            toastr.error(`${errorThrown}`, `Error ${jqXHR.status}`);
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
                    });
                    $("[app-onclick-datatable-reset]").on("click", function(e) {
                        $.varien.eventControl(e);
                        $("#method").val("").trigger('change');
                        $("#status").val("").trigger('change');
                        $("#accountIdFilter").val('');
                        $.varien.customer.detail.datatable.reload();
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
                            "Today": [moment(), moment()],
                            "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
                            "Last 7 Days": [moment().subtract(6, "days"), moment()],
                            "This Month": [moment().startOf("month"), moment().endOf("month")],
                            "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
                        },
                        "locale": {
                            "format": "DD/MM/YYYY",
                            "separator": " - ",
                            "applyLabel": "Apply",
                            "cancelLabel": "Cancel",
                            "customRangeLabel": "Custom Range",
                            //"daysOfWeek": ["Pzt", "Sal", "Çar", "Per", "Cum", "Cmt", "Paz"],
                            //"monthNames": ["Ocak", "Şubat", "Mart", "Nisan", "Mayıs", "Haziran", "Temmuz", "Ağustos", "Eylül", "Ekim", "Kasım", "Aralık"],
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
    reports: {
        init: () => {
            $.varien.reports.charts.pie.init();
            $.varien.reports.charts.main.init();
        },
        charts: {
            pie: {
                init: () => {
                    let chart = {
                        self: null,
                        rendered: false
                    };

                    let initChart = (chart) => {
                        let element = document.getElementById("chart-reports-pie");
                        if (!element) return;
                        let options = {
                            series: [39, 30, 16, 9, 6], // TODO: To be replaced with dynamic data
                            labels: ['Papara', 'Matching', 'Bank', 'Cross', 'Virtual POS'],
                            colors: ['#ba435f', '#CA3660', '#21416f', '#698b55', '#ed8a3d'],
                            chart: {
                                type: 'pie'
                            },
                            legend: {
                                show: false
                            },
                            stroke: {
                                colors: undefined
                            },
                            tooltip: {
                                y: {
                                    formatter: (value) => value + "%"
                                }
                            },
                            dataLabels: {
                                background: {
                                    padding: 4,
                                    opacity: 0.5,
                                    enabled: true,
                                    borderWidth: 1,
                                    borderRadius: 2,
                                    foreColor: '#000',
                                    borderColor: '#000'
                                }
                            },
                            responsive: [{
                                breakpoint: 1200,
                                options: {
                                    chart: {
                                        width: 250
                                    }
                                }
                            }]
                        };
                        chart.self = new ApexCharts(element, options);
                        // Set timeout to properly get the parent elements width
                        setTimeout(function() {
                            chart.self.render();
                            chart.rendered = true;
                        }, 200);
                    }

                    // Public methods
                    (function () {
                        initChart(chart);
                        // Update chart on theme mode change
                        KTThemeMode.on("kt.thememode.change", function() {
                            if (chart.rendered) {
                                chart.self.destroy();
                            }
                            initChart(chart);
                        });
                    })();
                }
            },
            main: {
                init: () => {
                    let chart = {
                        self: null,
                        rendered: false
                    };

                    let initChart = (chart) => {
                        let element = document.getElementById("chart-reports-main");
                        if (!element) return;
                        let height = parseInt(KTUtil.css(element, 'height'));
                        let labelColor = KTUtil.getCssVariableValue('--kt-gray-700');
                        let depositColor = KTUtil.getCssVariableValue('--kt-success');
                        let withdrawColor = KTUtil.getCssVariableValue('--kt-danger');
                        let borderColor = KTUtil.getCssVariableValue('--kt-border-dashed-color');
                        let options = {
                            // TODO: To be replaced with dynamic data
                            series: [{
                                name: 'Deposit',
                                data: [725821.52, 1165700.50, 925822.75, 1090432.50, 759523.40, 1054352.40, 826915.50, 725821.52, 1165700.50, 925822.75, 1090432.50, 759523.40, 1054352.40, 826915.50, 725821.52, 1165700.50, 925822.75, 1090432.50, 759523.40, 1054352.40, 826915.50, 725821.52, 1165700.50, 925822.75, 1090432.50, 759523.40, 1054352.40, 826915.50],
                            }, {
                                name: 'Withdrawal',
                                data: [458127.50, 627180.00, 561320.15, 321572.90, 857251.65, 165281.75, 627582.00, 458127.50, 627180.00, 561320.15, 321572.90, 857251.65, 165281.75, 627582.00, 458127.50, 627180.00, 561320.15, 321572.90, 857251.65, 165281.75, 627582.00, 458127.50, 627180.00, 561320.15, 321572.90, 857251.65, 165281.75, 627582.00],
                            }],
                            chart: {
                                type: 'area',
                                height: height,
                                fontFamily: 'inherit',
                                toolbar: {
                                    show: false
                                },
                                zoom: {
                                    enabled: false
                                }
                            },
                            legend: {
                                show: false
                            },
                            dataLabels: {
                                enabled: false
                            },
                            fill: {
                                type: "gradient",
                                gradient: {
                                    opacityTo: 0,
                                    opacityFrom: .5,
                                    shadeIntensity: .5,
                                    stops: [0, 80, 100]
                                }
                            },
                            stroke: {
                                width: 3,
                                colors: [depositColor, withdrawColor]
                            },
                            xaxis: {
                                tickAmount: 5,
                                tickPlacement: "between",
                                axisTicks: {
                                    show: false
                                },
                                axisBorder: {
                                    show: false
                                },
                                // TODO: To be replaced with dynamic data
                                // Shows entire month day by day
                                categories: ["Apr 01", "Apr 02", "Apr 03", "Apr 04", "Apr 05", "Apr 06", "Apr 07", "Apr 08", "Apr 09", "Apr 10", "Apr 11", "Apr 12", "Apr 13", "Apr 14", "Apr 17", "Apr 18", "Apr 19", "Apr 21", "Apr 22", "Apr 23", "Apr 24", "Apr 25", "Apr 26", "Apr 27", "Apr 28", "Apr 29", "Apr 30", "Apr 31"],
                                labels: {
                                    rotate: -25,
                                    rotateAlways: true,
                                    style: {
                                        fontSize: '12px',
                                        colors: labelColor
                                    }
                                },
                            },
                            yaxis: {
                                tickAmount: 5,
                                labels: {
                                    style: {
                                        colors: labelColor,
                                        fontSize: '12px'
                                    },
                                    formatter: function(value) {
                                        let val = Math.abs(value);
                                        if (val > 1000 && val < 1000000) val = (val / 1000).toFixed(0) + 'k';
                                        if (val > 1000000) val = (val / 1000000).toFixed(0) + 'm';
                                        return "₺" + val;
                                    }
                                }
                            },
                            tooltip: {
                                style: {
                                    fontSize: '13px'
                                },
                                y: {
                                    formatter: function(value) {
                                        let val = Math.abs(value);
                                        if (val > 1000 && val < 1000000) val = (val / 1000).toFixed(0) + 'k';
                                        if (val > 1000000) val = (val / 1000000).toFixed(2) + 'm';
                                        return val == 0 ? 'none' : "₺" + val;
                                    }
                                }
                            },
                            colors: [depositColor, withdrawColor],
                            grid: {
                                strokeDashArray: 4,
                                borderColor: borderColor,
                            }
                        };
                        chart.self = new ApexCharts(element, options);
                        // Set timeout to properly get the parent elements width
                        setTimeout(function() {
                            chart.self.render();
                            chart.rendered = true;
                        }, 200);
                    }

                    // Public methods
                    (function () {
                        initChart(chart);
                        // Update chart on theme mode change
                        KTThemeMode.on("kt.thememode.change", function() {
                            if (chart.rendered) {
                                chart.self.destroy();
                            }
                            initChart(chart);
                        });
                    })();
                }
            }
        }
    },
    setting: {
        init: function() {
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
                            title: "Warning!",
                            className: "animation animation-fade-in",
                            message: "<span class='fs-6'>Are you sure you want to activate maintenance mode?</span>",
                            buttons: {
                                confirm: { label: "Confirm" },
                                cancel: { label: "Cancel" }
                            },
                            callback: (result) => {
                                if (result == true) {
                                    KTCookie.set('cancel', 0, {sameSite: 'None', secure: true});
                                    $.varien.setting.switch(elm);
                                    $.varien.setting.submitStatus(formId, elm.attr('name'));
                                    $("form#" + formId).submit();
                                } else {
                                    KTCookie.set('cancel', 1, {sameSite: 'None', secure: true});
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
                        KTCookie.set('cancel', 0, {sameSite: 'None', secure: true});
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
                        toastr.success("Settings updated");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        toastr.error(`${errorThrown}`, `Error ${jqXHR.status}`);
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
                        toastr.success("Settings updated");
                        if (name == "maintenanceStatus") location.reload();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        toastr.error(`${errorThrown}`, `Error ${jqXHR.status}`);
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
                        targets: (Array.isArray($.notOrderCols) == true ? [2, 3] : [2, 3, 5])
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
                        $("tbody td:nth-child(6)").addClass('text-end');
                        $('input[data-set="switch"]').on("change", function() {
                            if ($(this).is(":checked") == true) {
                                $.varien.setting.client.switch($(this).attr("name"), $(this).attr("data-id"), "on");
                                toastr.success("The firm has been authorized to perform transactions");
                            } else {
                                $.varien.setting.client.switch($(this).attr("name"), $(this).attr("data-id"), 0);
                                toastr.error("Firm's authorization has been revoked");
                            }
                        });
                    }, 300);
                });
            },
            modal: function() {
                $('[data-bs-target="#clientModalForm"]').on("click", function() {
                    var id = $(this).attr("data-id");
                    if (id != "0") {
                        $('[data-title]').html("Edit Firm");
                        $('#generateKey').html("Generate");
                        $.varien.setting.client.detail(id);
                    } else {
                        $('[name="id"]').val(0);
                        $('[name="site_name"]').val("");
                        $('[name="limitDepositMin"]').val($('[name="limitDepositMin"]').attr('data-default'));
                        $('[name="limitDepositMax"]').val($('[name="limitDepositMax"]').attr('data-default'));
                        $('[name="limitWithdrawMin"]').val($('[name="limitWithdrawMin"]').attr('data-default'));
                        $('[name="limitWithdrawMax"]').val($('[name="limitWithdrawMax"]').attr('data-default'));
                        $('[name="api_key"]').val("");
                        $('[id="modalStatus"]').val("").change();
                        $('[data-title]').html("Add New Firm");
                        $('#generateKey').html("Generate");
                    }
                    $('[data-bs-dismiss="modal"]').on("click", function() {
                        setTimeout(function() {
                            $('[name="id"]').val("");
                            $('[name="site_name"]').val("");
                            $('[name="limitDepositMin"]').val($('[name="limitDepositMin"]').attr('data-default'));
                            $('[name="limitDepositMax"]').val($('[name="limitDepositMax"]').attr('data-default'));
                            $('[name="limitWithdrawMin"]').val($('[name="limitWithdrawMin"]').attr('data-default'));
                            $('[name="limitWithdrawMax"]').val($('[name="limitWithdrawMax"]').attr('data-default'));
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
                        $('[name="limitDepositMin"]').val(response.limitDepositMin);
                        $('[name="limitDepositMax"]').val(response.limitDepositMax);
                        $('[name="limitWithdrawMin"]').val(response.limitWithdrawMin);
                        $('[name="limitWithdrawMax"]').val(response.limitWithdrawMax);
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
                    var limitDepositMin = $('[name="limitDepositMin"]').val();
                    var limitDepositMax = $('[name="limitDepositMax"]').val();
                    var limitWithdrawMin = $('[name="limitWithdrawMin"]').val();
                    var limitWithdrawMax = $('[name="limitWithdrawMax"]').val();
                    var minDeposit = $('[name="minDeposit"]').val();
                    var maxDeposit = $('[name="maxDeposit"]').val();
                    var minWithdraw = $('[name="minWithdraw"]').val();
                    var maxWithdraw = $('[name="maxWithdraw"]').val();
                    if (site_name == "") {
                        toastr.error("Please enter firm's name");
                        return false;
                    }
                    if (api_key == "") {
                        toastr.error("Please enter API Key");
                        return false;
                    }
                    if (limitDepositMin == "" || limitDepositMax == "") {
                        toastr.error("Please enter deposit limits correctly");
                        return false;
                    }
                    if (limitWithdrawMin == "" || limitWithdrawMax == "") {
                        toastr.error("Please enter withdraw limits correctly");
                        return false;
                    }
                    if (Number.parseFloat(limitDepositMin) < Number.parseFloat(minDeposit)
                     || Number.parseFloat(limitDepositMax) < Number.parseFloat(maxDeposit)
                     || Number.parseFloat(limitWithdrawMin) < Number.parseFloat(minWithdraw)
                     || Number.parseFloat(limitWithdrawMax) < Number.parseFloat(maxWithdraw)) {
                        toastr.error("Firm's limit range must be between globally defined limit range.");
                        return false;
                    }
                    $.ajax({
                        url: "client/save",
                        type: "POST",
                        dataType: "html",
                        crossDomain: true,
                        data: 'id=' + id + '&site_name=' + site_name + '&api_key=' + api_key + '&limitDepositMin=' + limitDepositMin + '&limitDepositMax=' + limitDepositMax + '&limitWithdrawMin=' + limitWithdrawMin + '&limitWithdrawMax=' + limitWithdrawMax + '&status=' + status,
                        xhrFields: {
                            withCredentials: true
                        },
                        success: function() {
                            $.table.ajax.reload();
                            $("#clientModalForm").modal('toggle');
                            toastr.success("Firm's data has been updated");
                            return false;
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            toastr.error(`${errorThrown}`, `Error ${jqXHR.status}`);
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
                        title: "Delete Firm",
                        className: "animation animation-fade-in",
                        message: "<span class='fs-6'>Are you sure to delete the firm?</span>",
                        buttons: {
                            confirm: { label: "Confirm" },
                            cancel: { label: "Cancel" }
                        },
                        callback: (result) => {
                            if (result == true) {
                                $.ajax({
                                    type: 'POST',
                                    url: "client/remove/" + id,
                                    success: function() {
                                        $.table.ajax.reload();
                                        toastr.error("The firm has been deleted");
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
    if(domain !== "co") return;

    $.varien.errorHandler(error, error.fileName, error.lineNumber, error.columnNumber, error.message);
});