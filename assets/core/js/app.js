const domain = window.location.host.split('.').slice(-1).toString();

$.varien = {
    boot: () => {
        return new Promise(function(resolve, reject) {
            fetch(window.location.protocol + "//" + window.location.hostname + "/json/resources").then(response => response.json()).then(json => resolve(json));
        });
    },
    init: () => {
        // Don't show browser alerts when datatable catches an error
        $.fn.dataTable.ext.errMode = 'none';

        $.varien.prepare();
        $.varien.stage();
    },
    prepare: () => {
        $.varien.toastr();
        $.varien.activity();
        $.varien.authorization();

        setInterval(() => {
            $.varien.activity();
        }, $.activityTimeOut);

        // Set the default timezone to Europe/Istanbul
        moment.tz.setDefault('Europe/Istanbul');

        // Display time in the footer
        setInterval(() => {
            $('.server-time').text(`${moment().format('DD.MM.YYYY - HH:mm:ss')}`);
        }, 1000);

        // Catch all completed AJAX requests
        $(document).ajaxComplete(function(xhr, options) {
            // Replace and hide error message when connection is restored
            if ($('.ajax-error').hasClass('d-none') === false && options.status === 200) {
                $('.ajax-error-icon').removeClass('bi-wifi-off').addClass('bi-check2');
                $('.ajax-error-message').text('Your connection has been restored');
                $('.ajax-error').removeClass('bg-danger').addClass('bg-success');

                $.wait(5000).then(() => {
                    $('.ajax-error').removeClass('animation-fade-in').addClass('animation-fade-out');
                }).then(() => {
                    $.wait(1000).then(() => {
                        $('.ajax-error').addClass('d-none');
                    })
                });
            }
        });

        // Catch all AJAX errors
        $(document).ajaxError((event, xhr, options, thrownError) => {
            // Notify user if connection fails
            if(xhr.status === 0) {
                const messages = {
                    userOffline: "You seem to be offline. Please check your network connection and try again.",
                    ajaxFail: "There was a problem connecting to server. Please refresh the page and try again."
                }

                $('.ajax-error-icon').removeClass('bi-check2').addClass('bi-wifi-off');
                $('.ajax-error').removeClass('d-none bg-success').addClass('bg-danger');

                // Is user offline?
                if(!navigator.onLine) {
                    $('.ajax-error-message').text(messages.userOffline);
                } else {
                    $('.ajax-error-message').text(messages.ajaxFail);
                }

                // Update latency widget as 'offline'
                $('.latency')[0].lastChild.textContent = ` offline`;
                $('.latency-badge').eq(0).addClass('badge-danger').removeClass('badge-success badge-warning');
            }
        });
    },
    stage: () => {
        if ($.varien.segment(1) == "dashboard") $.varien.dashboard.init();
        if ($.varien.segment(1) == "account") $.varien.account.init();
        if ($.varien.segment(1) == "customer") $.varien.customer.init();
        if ($.varien.segment(1) == "user") $.varien.user.init();
        if ($.varien.segment(1) == "transaction") $.varien.transaction.init();
        if ($.varien.segment(1) == "reports") $.varien.reports.init();
        if ($.varien.segment(1) == "settings") $.varien.settings.init();
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
    eventControl: (e) => {
        e.stopImmediatePropagation();
        e.stopPropagation();
        e.preventDefault();
    },
    environment: () => {
        $.host = window.location.host;
        return $.host.split('.')[0];
    },
    activity: () => {
        let start;
        $.ajax({
            url: "/user/activity",
            cache: false,
            beforeSend: () => {
                start = new Date().getTime();
            },
            success: (response) => {
                if (response === "OK") {
                    const latency = new Date().getTime() - start;

                    if (latency > 150 && latency < 220) {
                        $('.latency-badge').eq(0).addClass('badge-warning').removeClass('badge-success badge-danger');
                    } else if (latency >= 220) {
                        $('.latency-badge').eq(0).addClass('badge-danger').removeClass('badge-success badge-warning');
                    } else {
                        $('.latency-badge').eq(0).addClass('badge-success').removeClass('badge-danger badge-warning');
                    }

                    $('.latency')[0].lastChild.textContent = ` ${latency}ms`;
                } else {
                    $('.latency')[0].lastChild.textContent = ` offline`;
                    $('.latency-badge').eq(0).addClass('badge-danger').removeClass('badge-success badge-warning');
                }
            }
        });
    },
    segment: (key) => {
        $.segment = window.location.pathname.split('/');
        if (typeof $.segment[key] !== 'undefined') {
            return $.segment[key];
        } else {
            return null;
        }
    },
    toastr: () => {
        toastr.options = {
            "closeButton": false,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toastr-top-center",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "2500",
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

                        KTThemeMode.getMode() === "dark" ?
                            $(".modal-content").removeClass('border border-2 shadow-lg') :
                            $(".modal-content").removeClass('shadow-lg');
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
            if ($('[data-export]').length) {
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

                $('[data-export]').html(str).promise().done(function() {
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
            document.addEventListener('keydown', function(event) {
                if (event.key === "Home") {
                    if ($('#devmodal')[0] !== undefined) return;

                    $.varien.modal.event.load("dev", function() {
                        $(".modal-dialog").addClass('mw-75');
                        $(".modal-dialog").removeClass('mw-650px');
                        KTThemeMode.getMode() === "dark" ?
                            $(".modal-content").addClass('border border-2 shadow-lg') :
                            $(".modal-content").addClass('shadow-lg');
                    });
                }

                if (event.key === "Enter" && $('#devmodal')[0] !== undefined) {
                    let console = document.getElementById('console');
                    if (console.children[console.children.length - 1].id == 'waiting') {
                        $('#console').append("<li><br></li>")
                    }

                    $('#console').append("<li id='input' class='cmdloading'>" + $("#cmd").val() + "</li>");
                    $.varien.dev.cmd($("#cmd").val());
                    $("#cmd").val('');
                }
            });
        },
        cmd: function(cmd) {
            if (cmd == "clear") {
                let itemCount = $('[id=notice]').length + 1;
                let console = document.getElementById('console');
                for (let i = console.children.length; i > itemCount; i--) {
                    console.removeChild(console.children[i - 1]);
                }

                $('#waiting').removeClass('d-none');
                $('#waiting').addClass('cmdloading');
            } else {
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
                                if (val > 1000000) val = '₺' + (val / 1000000).toFixed(2) + 'm';
                                else if (val >= 1000 && val < 1000000) val = '₺' + (val / 1000).toFixed(0) + 'k';
                                else if (val > 0 && val < 1000) val = '₺' + val;
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
                        $.varien.account.detail.switch("on", () => {
                            toastr.success("Account has been enabled");
                            $('input[name="status"]').val('on');
                        });
                    } else {
                        $.varien.account.detail.switch(0, () => {
                            toastr.error("Account has been disabled");
                            $('input[name="status"]').val(0);
                        });
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
                                toastr.success("Customer is matched with the account");
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
            switch: function(status, callback) {
                $.ajax({
                    url: "account/status/" + $.varien.segment(3) + "/" + status,
                    type: "POST",
                    dataType: "html",
                    cache: false,
                    success: () => callback()
                });
            },
            datatable: {
                init: function() {
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
                                d.siteId = $("#siteId").val();
                                d.status = $("#status").val();
                            },
                        }
                    });
                    let delayTimer;
                    $('#search').on('input', function() {
                        let val = this.value;
                        clearTimeout(delayTimer);
                        delayTimer = setTimeout(function() {
                            $.table.search(val).draw();
                        }, 250);
                    });
                    $("#transactionDate").on("change", function() {
                        $.table.ajax.reload();
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
                            "firstDay": 1
                        },
                    }, cb);
                    cb(start, end);
                }
            },
            save: function() {
                $("form#modalForm").on('submit', (function(e) {
                    $.varien.eventControl(e);

                    let saveData = new FormData(this);
                    let accountNumber = saveData.get('account_number').replace(/[^\dA-Z]/g, '').replace(/(.{4})/g, '$1 ').trim();
                    saveData.set('account_number', accountNumber)

                    $.ajax({
                        url: "account/save",
                        type: "POST",
                        dataType: "html",
                        crossDomain: true,
                        data: saveData,
                        xhrFields: {
                            withCredentials: true
                        },
                        processData: false,
                        contentType: false,
                        success: () => toastr.success("Account updated"),
                        error: function(jqXHR, errorThrown) {
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
                $('#accountStatus').on('change', function() {
                    $.table.search(this.value).draw();
                });
                $('[data-set="status-set-all"]').on('click', function() {
                    var dataStatus = $(this).attr('data-status') == "on" ? "enabled" : "disabled";
                    var status = $(this).attr('data-status');
                    bootbox.confirm({
                        backdrop: true,
                        centerVertical: true,
                        title: "Update Account Status",
                        className: "animation animation-fade-in",
                        message: "<span class='fs-6'>All accounts will be " + dataStatus + ". Are you sure?</span>",
                        buttons: {
                            confirm: {
                                label: "Confirm"
                            },
                            cancel: {
                                label: "Cancel"
                            }
                        },
                        callback: (result) => {
                            if (result == true) {
                                $.varien.account.datatable.status(0, status, true);
                                setTimeout(() => {
                                    $.table.ajax.reload();
                                }, 50);
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
                            } else {
                                $.varien.account.datatable.status($(this).attr("data-id"), 0);
                            }
                        });
                        $.varien.account.datatable.modal();
                        $.varien.account.datatable.remove();
                    }, 50);
                });
            },
            status: function(id, status, bulk = false) {
                $.ajax({
                    url: "account/status/" + id + "/" + status + "/" + $.varien.segment(3),
                    type: "POST",
                    dataType: "html",
                    cache: false,
                    success: function() {
                        if (bulk) {
                            if (status == "on") {
                                toastr.success("All accounts are enabled");
                            } else {
                                toastr.error("All accounts are disabled");
                            }

                            return;
                        }

                        if (status == "on") {
                            toastr.success("Account has been enabled");
                        } else {
                            toastr.error("Account has been disabled");
                        }
                    },
                    error: function(jqXHR, errorThrown) {
                        toastr.error(`${errorThrown}`, `Error ${jqXHR.status}`);
                    }
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
                        success: function() {
                            $.table.ajax.reload();
                            $("#ajaxModal").modal('toggle');
                        },
                        error: function(jqXHR, errorThrown) {
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
                            confirm: {
                                label: "Confirm"
                            },
                            cancel: {
                                label: "Cancel"
                            }
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
            $.varien.transaction.dateSelect();
            $.inspect = KTDrawer.getInstance(document.querySelector("#inspect-drawer"));
            $.inspect.on("kt.drawer.show", function() {
                if ($("#sync").is(":checked") == true) {
                    $("#sync").trigger("click");
                }
            });
            $.inspect.on("kt.drawer.hide", function() {
                $.bsFirstTab = bootstrap.Tab.getInstance(document.querySelector("#detailsTab li:first-child a"));
                $.bsFirstTab.show();
                $.varien.transaction.datatable.reload();
                if ($.varien.transaction.datatable.isToday()) {
                    if ($("#sync").is(":checked") == false) {
                        $("#sync").trigger("click");
                    }
                }
            });
            $.blockMessage = '<div class="blockui-message"><span class="spinner-border text-primary"></span>Please wait...</div>';
            $.blockModalContent = new KTBlockUI(document.querySelector('#transactionForm'), {
                message: $.blockMessage
            });

            if (document.getElementById('notification') === null) {
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
            $.varien.transaction.accounts.init();
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
                    "firstDay": 1
                },
            }, cb);
            cb(start, end);
        },
        datatable: {
            init: function (colNum) {
                let searching = false;
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

                            searching = d.search.value !== '' ? true : false;
                        },
                        complete: function() {
                            if (!searching) {
                                $.varien.transaction.datatable.sound();
                            }
                        }
                    }
                });
                $.varien.transaction.datatable.onLoad();
                $.varien.transaction.datatable.sync();
                $.varien.transaction.datatable.notification();
                let delayTimer;
                $('#search').on('input', function() {
                    let val = this.value;
                    clearTimeout(delayTimer);
                    delayTimer = setTimeout(function() {
                        $.table.search(val).draw();
                    }, 250);
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
                    $.varien.transaction.datatable.reload(() => {
                        toastr.success("Transactions refreshed");
                    });
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

                if ($.varien.segment(3) == "deposit") {
                    KTCookie.set('totalDeposit', currentTxns, {
                        sameSite: 'None',
                        secure: true
                    });
                } else {
                    KTCookie.set('totalWithdraw', currentTxns, {
                        sameSite: 'None',
                        secure: true
                    });
                }
            },
            setNotifications: function(status, callback) {
                $.ajax({
                    url: "transaction/notificationSound/" + status,
                    type: "GET",
                    dataType: "html",
                    cache: false,
                    success: () => callback()
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

                        if (e.originalEvent !== undefined) {
                            toastr.success("Auto refresh enabled");
                        }
                    } else {
                        clearInterval(autoRefreshInterval);
                        clearInterval(autoDateInterval);
                        autoRefreshInterval = null;
                        autoDateInterval = null;

                        if (e.originalEvent !== undefined) {
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

                    const table = $('#datatable_content').DataTable();
                    const pending_rows = table.rows(function(index, data, node) {
                        let i = $.varien.segment(3) === 'deposit' ? 8 : 7;
                        return data[i].includes('Pending');
                    }).nodes();

                    let rows = [];
                    Array.prototype.forEach.call(pending_rows, function(node) {
                        let id = node.getAttribute('id').split("-")[0];
                        let txid = node.querySelector('td:nth-child(2)').textContent.trim();
                        rows.push({id: id, txid: txid});
                    });

                    if(pending_rows.length) {
                        bootbox.confirm({
                            backdrop: true,
                            centerVertical: true,
                            buttons: {
                                confirm: {
                                    label: "Confirm"
                                },
                                cancel: {
                                    label: "Cancel"
                                }
                            },
                            title: "Reject Pending Transactions",
                            className: "animation animation-fade-in",
                            message: "<span class='fs-6'>" + pending_rows.length + " pending transactions will be rejected. Do you confirm?</span>",
                            callback: (result) => {
                                if (result) {
                                    rows.forEach((row) => {
                                        $.reject("transaction/update", row.id).then(function() {
                                            toastr.success("#" + row.txid + ": transaction rejected");
                                        });
                                    });

                                    $.varien.transaction.datatable.reload();
                                }
                            }
                        });
                    } else {
                        toastr.error("There are no pending transactions");
                    }
                });
            },
            notification: function() {
                $("#notifications").on("click", function() {
                    if ($(this).is(":checked") == true) {
                        $.varien.transaction.datatable.setNotifications(1, () => {
                            toastr.success("Notifications enabled");
                        });
                    } else {
                        $.varien.transaction.datatable.setNotifications(0, () => {
                            toastr.error("Notifications disabled");
                        });
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
            reload: function(cb) {
                if (cb) $.table.ajax.reload(cb);
                else $.table.ajax.reload();
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
                $('#datatable_content tbody').on('click', '#inspect', function() {
                    let data = $(this).closest('tr').find('td');
                    $('[data-set-date]').text(data[0].innerText);
                    $('[data-set-txid]').text(data[1].innerText);
                    $('[data-set-userId]').text(data[2].innerText);
                    if ($.varien.segment(3) === "deposit") {
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

                        $.dataCustomerId = $(this).attr('data-customer-id');
                        if ($(this).is(":checked") == true) {
                            $.varien.customer.datatable.switch($(this).attr("name"), $.dataCustomerId, "on");
                        } else {
                            $.varien.customer.datatable.switch($(this).attr("name"), $.dataCustomerId, 0);
                        }
                    });

                    $.accountLink = $(this).attr('data-account-link');
                    $('#accountPage').on("click", function (e) {
                        $.varien.eventControl(e);
                        window.open($.accountLink, '_blank');
                    });

                    $.customerLink = $(this).attr('data-customer-link');
                    $('#customerProfile').on("click", function (e) {
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
                $('#datatable_content tbody').on('click', '#approve, #reject', function() {
                    $('#txId').val(this.dataset.rowId);
                    $('#txResponse').val($(this)[0].id);
                    $('#txStatus').val($(this)[0].id === "approve" ? "onaylandı" : "reddedildi");
                    $('#txRequest').val($.varien.segment(3));
                    $('#txSubmit').text($(this)[0].id === "approve" ? "Approve" : "Reject");

                    let data = $(this).closest('tr').find('td');

                    $('[data-set-time]').text(data[0].innerText);
                    $('[data-set-txid]').text(data[1].innerText);

                    if ($.varien.segment(3) === "deposit") {
                        $('[data-set-customer]').text(data[6].innerText);
                        $('[data-set-amount]').text(data[7].innerText);
                        $('#txnAmount').val(data[7].innerText.slice(0, -1));
                    }

                    if ($.varien.segment(3) === "withdraw") {
                        $('[data-set-customer]').text(data[4].innerText);
                        $('[data-set-amount]').text(data[6].innerText);
                        $('#txnAmount').val(data[6].innerText.slice(0, -1));
                    }

                    let element = document.getElementById('txn-info');
                    let theme = KTThemeMode.getMode() == "light" ? "light" : "dark";
                    if ($(this)[0].id === "approve" && theme == "dark") element.style.backgroundColor = "#2b6f4a";
                    if ($(this)[0].id === "approve" && theme == "light") element.style.backgroundColor = "#56e496";
                    if ($(this)[0].id === "reject" && theme == "dark") element.style.backgroundColor = "#861f37";
                    if ($(this)[0].id === "reject" && theme == "light") element.style.backgroundColor = "#f96085";
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
                const form = document.getElementById("transactionForm");
                form.addEventListener('submit', async function(event) {
                    $.varien.eventControl(event);
                    $.blockModalContent.block();

                    try {
                        const res = await $.ajax({
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
                        });

                        $.table.ajax.reload();
                        $('#description').val('');
                        $.blockModalContent.release();
                        $("#transaction").modal('toggle');
                    } catch (error) {
                        const jqXHR = error?.jqXHR;
                        const status = jqXHR?.status;
                        toastr.error(`${error?.errorThrown || 'Unknown error'}`, `Error ${status || ''}`);

                        $('#description').val('');
                        $.blockModalContent.release();
                    }
                });

                $('#transaction').on('hide.bs.modal', function(e) {
                    if ($.blockModalContent.isBlocked()) {
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
                            confirm: {
                                label: "Confirm"
                            },
                            cancel: {
                                label: "Cancel"
                            }
                        },
                        message: msg,
                        className: "animation animation-fade-in",
                        callback: (result) => {
                            if (result == true) {
                                $.ajax({
                                    type: 'POST',
                                    url: urlAjax,
                                    success: function() {
                                        $.table.ajax.reload(() => {
                                            toastr.error("Account deleted");
                                        });
                                    }
                                });
                            }
                        }
                    });
                });
            }
        },
        accounts: {
            init: function() {
                // Define constants
                $.accountsDrawer = KTDrawer.getInstance(document.querySelector("#accounts-drawer"));
                $.blockManageAccounts = new KTBlockUI(document.querySelector("#accounts-drawer-card"), {
                    message: $.blockMessage
                });

                // When drawer starts opening
                $.accountsDrawer.on("kt.drawer.show", function() {
                    // Disable main datatable sync
                    $("#sync").is(":checked") ? $("#sync").trigger("click") : null;

                    // Fetch the data and append it to the drawer DOM
                    $.varien.transaction.accounts.fetch();
                });

                // When drawer is completely hidden
                $.accountsDrawer.on("kt.drawer.after.hidden", function() {
                    // Clear DOM
                    $('#accounts-drawer-body').empty();

                    // Clear search input
                    $('#search-accounts').val('')

                    // Set default method as Papara again
                    $('#methods').val(1).trigger('change');

                    // Release UI if it's still blocked
                    if ($.blockManageAccounts.isBlocked()) $.blockManageAccounts.release();
                });

                // When selected payment method changes
                $("#methods").on("change", function() {
                    // Update 'View All' link
                    $('#view-all-link').attr("href", '/account/index/' + $(this).val());

                    // Fetch data and append the result to the DOM
                    $.varien.transaction.accounts.fetch();
                });

                // Search accounts
                let delayTimer;
                $('#search-accounts').on('input', function() {
                    let val = this.value;
                    clearTimeout(delayTimer);
                    delayTimer = setTimeout(function() {
                        if (val.length == 0) {
                            $.varien.transaction.accounts.fetch();
                        } else {
                            $.varien.transaction.accounts.fetch(val);
                        }
                    }, 250);
                });
            },
            fetch: (searchValue = null) => {
                $.blockManageAccounts.block();
                $.ajax({
                    url: "transaction/accounts",
                    type: "POST",
                    dataType: "html",
                    data: {
                        "search": searchValue,
                        "method": $('#methods').val()
                    },
                    success: function(data) {
                        $.blockManageAccounts.release();
                        $('#accounts-drawer-body').empty().append(data);
                        $.varien.transaction.accounts.onLoad();
                    },
                    error: function(jqXHR, errorThrown) {
                        toastr.error(`${errorThrown}`, `Error ${jqXHR.status}`);
                    }
                });
            },
            onLoad: () => {
                // When switch element changes
                $('[name=account-switch]').on("change", function(e) {
                    $.dataAccountId = $(this).attr('data-id');

                    if ($(this).is(":checked") == true) {
                        $.varien.transaction.accounts.switch($.dataAccountId, "on");
                    } else {
                        $.varien.transaction.accounts.switch($.dataAccountId, 0);
                    }
                });
            },
            switch: (id, status) => {
                $.ajax({
                    url: "account/status/" + id + "/" + status + "/" + $('#methods').val(),
                    type: "POST",
                    dataType: "html",
                    cache: false,
                    success: function() {
                        if (status == "on") {
                            toastr.success("Account has been enabled");
                        } else {
                            toastr.error("Account has been disabled");
                        }
                    },
                    error: function(jqXHR, errorThrown) {
                        toastr.error(`${errorThrown}`, `Error ${jqXHR.status}`);
                    }
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
                            url: 'user/datatableRole',
                            type: 'POST',
                            data: function(d) {
                                d.is2fa = $("#is2fa").val();
                                d.roleId = $("#role_id").val();
                            },
                        }
                    });
                    $.varien.user.role.datatable.onLoad();
                },
                onLoad: function() {
                    $.table.on('draw', function() {
                        $.varien.datatable.exportEvents();
                        $("tbody td:nth-child(3)").addClass('text-end');
                        $.varien.user.role.datatable.modal();
                        $.varien.user.role.datatable.remove();
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
                            error: function(jqXHR, errorThrown) {
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
                                confirm: {
                                    label: "Confirm"
                                },
                                cancel: {
                                    label: "Cancel"
                                }
                            },
                            className: "animation animation-fade-in",
                            message: "<span class='fs-6'>Do you approve to delete user role?</span>",
                            callback: (result) => {
                                if (result == true) {
                                    $.ajax({
                                        type: 'POST',
                                        url: "user/removeRole/" + id,
                                        success: function() {
                                            toastr.error("Role deleted");
                                            $.table.ajax.reload();
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
                                                toastr.success("2-Step verification has been successfully enabled");
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
                                        confirm: {
                                            label: "Remove"
                                        },
                                        cancel: {
                                            label: "Cancel"
                                        }
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
                        $("#firms").append("<li class='badge badge-secondary me-3'>" + $(this).text() + "</li>");
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
                            confirm: {
                                label: "Confirm"
                            },
                            cancel: {
                                label: "Cancel"
                            }
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
                        lengthMenu: [5, 10, 25, 50, 100],
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
                let delayTimer;
                $('#search').on('input', function() {
                    let val = this.value;
                    clearTimeout(delayTimer);
                    delayTimer = setTimeout(function() {
                        $.table.search(val).draw();
                    }, 250);
                });
                $("[app-onchange-datatable-reload]").on("change input", function(e) {
                    $.varien.eventControl(e);
                    $.varien.transaction.datatable.reload();
                });
                $("[app-onclick-datatable-reset]").on("click", function(e) {
                    $.varien.eventControl(e);
                    $("#is2fa").val("").trigger('change');
                    $("#role_id").val("").trigger('change');
                    $.varien.transaction.datatable.reload();
                });
            },
            onLoad: function() {
                $.table.on('draw', function() {
                    $.varien.datatable.exportEvents();
                    $.varien.user.datatable.modal();
                    $.varien.user.datatable.remove();
                    $("tbody td:nth-child(6)").addClass('text-center');
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
                    if ($("[app-submit-email-check]").val() !== "") {
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
                                error: function(jqXHR, errorThrown) {
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
                            confirm: {
                                label: "Confirm"
                            },
                            cancel: {
                                label: "Cancel"
                            }
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
                error: function(jqXHR, errorThrown) {
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
                let delayTimer;
                $('#search').on('input', function() {
                    let val = this.value;
                    clearTimeout(delayTimer);
                    delayTimer = setTimeout(function() {
                        $.table.search(val).draw();
                    }, 250);
                });
                $("[app-onchange-datatable-reload]").on("change input", function(e) {
                    $.varien.eventControl(e);
                    $.varien.transaction.datatable.reload();
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
                    cache: false,
                    success: () => {
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
                    }
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
                        error: function(jqXHR, errorThrown) {
                            toastr.error(`${errorThrown}`, `Error ${jqXHR.status}`);
                        }
                    });
                }));
            },
        },
        detail: {
            init: function() {
                $.varien.customer.detail.saveNote();
                $.varien.customer.detail.datatable.dateSelect();
                $.varien.customer.detail.datatable.init();
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
                        error: function(jqXHR, errorThrown) {
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
                            targets: [1, 5]
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
                    let delayTimer;
                    $('#search').on('input', function() {
                        let val = this.value;
                        clearTimeout(delayTimer);
                        delayTimer = setTimeout(function() {
                            $.table.search(val).draw();
                        }, 250);
                    });
                    $("#transactionDate").on("change", function() {
                        $.varien.customer.detail.datatable.reload();
                    });
                    $("[app-onchange-datatable-reload]").on("change input", function(e) {
                        $.varien.eventControl(e);
                        $.varien.transaction.datatable.reload();
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
                onLoad: function() {
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
        blockers: null,
        charts: {
            main: {
                chart: {
                    self: null,
                    hidden: false
                },
                init: function(data) {
                    let element = document.getElementById("chart-reports-main");
                    if (!element) return;

                    let height = parseInt(KTUtil.css(element, 'height'));
                    let labelColor = KTUtil.getCssVariableValue('--kt-gray-700');
                    let depositColor = KTUtil.getCssVariableValue('--kt-success');
                    let withdrawColor = KTUtil.getCssVariableValue('--kt-danger');
                    let borderColor = KTUtil.getCssVariableValue('--kt-border-dashed-color');

                    let options = {
                        series: [{
                            name: 'Deposit',
                            data: data.deposit,
                        }, {
                            name: 'Withdrawal',
                            data: data.withdraw,
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
                            categories: data.categories,
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
                                formatter: (value) => {
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
                                formatter: (value) => {
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

                    if(data.deposit.every(obj => obj === "0.00")) options.stroke.colors[0] = "";
                    if(data.withdraw.every(obj => obj === "0.00")) options.stroke.colors[1] = "";

                    this.chart.self = new ApexCharts(element, options);
                    this.chart.self.render();
                },
                update: function(data) {
                    let depositColor = KTUtil.getCssVariableValue('--kt-success');
                    let withdrawColor = KTUtil.getCssVariableValue('--kt-danger');

                    if(data.deposit.every(obj => obj === "0.00")) depositColor = "";
                    if(data.withdraw.every(obj => obj === "0.00")) withdrawColor = "";

                    this.chart.self.updateSeries([{
                        name: 'Deposit',
                        data: data.deposit,
                    }, {
                        name: 'Withdrawal',
                        data: data.withdraw,
                    }], true);

                    this.chart.self.updateOptions({
                        xaxis: {
                            categories: data.categories
                        },
                        stroke: {
                            colors: [depositColor, withdrawColor]
                        },
                    });
                },
                themeChange: function() {
                    // Destroy and re-initiate chart with same data when theme mode changes
                    const data = {
                        categories: this.chart.self.opts.xaxis.categories,
                        deposit: this.chart.self.opts.series[0].data.map(point => point),
                        withdraw: this.chart.self.opts.series[1].data.map(point => point)
                    };

                    this.chart.self.destroy();
                    this.init(data);
                },
                hide: function(status) {
                    if (status) {
                        let year = $('#year :selected').text();
                        let month = $('#month').select2('data')[0].text;
                        let firm = $('#firms').val() == 0 ? '' : $('#firms').select2('data')[0].text;

                        let message = `There were no transactions involving ${firm} in ${month} ${year}`;
                        let html = `<div class='d-flex flex-center text-center fs-1 fw-semibold w-100 h-300px px-5'>${message}</div>`;

                        if (this.chart.hidden) {
                            this.chart.self.el.nextSibling.innerText = message;
                        } else {
                            this.chart.self.el.classList.add('d-none');
                            this.chart.self.el.insertAdjacentHTML('afterend', html);
                            this.chart.hidden = true;
                        }
                    } else {
                        if (!this.chart.hidden) return;

                        this.chart.self.el.nextSibling.remove();
                        this.chart.self.el.classList.remove('d-none');
                        this.chart.hidden = false;
                    }
                }
            },
            pie: {
                chart: {
                    self: null,
                    hidden: false
                },
                init: function(data) {
                    let element = document.getElementById("chart-reports-pie");
                    if (!element) return;

                    if(!data.length) data = [0, 0, 0, 0, 0];

                    let options = {
                        series: data,
                        labels: ['Papara', 'Matching', 'Bank', 'Cross', 'Virtual POS'],
                        colors: ['#ba435f', '#943074', '#1a3045', '#698b55', '#bf7236'],
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

                    this.chart.self = new ApexCharts(element, options);
                    this.chart.self.render();
                },
                update: function(data) {
                    this.chart.self.updateSeries(data);
                },
                themeChange: function() {
                    // Destroy and re-initiate chart with same data when theme mode changes
                    const data = this.chart.self.opts.series;

                    this.chart.self.destroy();
                    this.init(data);
                },
                hide: function(status) {
                    if(status) {
                        let message = `There are no approved transaction`;
                        let html = `<div class='d-flex flex-center text-center fs-6 fw-semibold w-100 px-5' style="height: 221.2px;">${message}</div>`;

                        if (this.chart.hidden) {
                            this.chart.self.el.nextSibling.innerText = message;
                        } else {
                            this.chart.self.el.classList.add('d-none');
                            this.chart.self.el.insertAdjacentHTML('afterend', html);
                            this.chart.hidden = true;
                        }
                    } else {
                        if (!this.chart.hidden) return;

                        this.chart.self.el.nextSibling.remove();
                        this.chart.self.el.classList.remove('d-none');
                        this.chart.hidden = false;
                    }
                }
            }
        },
        tables: {
            transactions: {
                table: null,
                data: () => ({
                    'firm': $('#firms').val(),
                    'month': $('#month').val(),
                    'year': $('#year :selected').text()
                }),
                init() {
                  const dataTableConfig = {
                    language: Object.assign({}, $.varien.datatable.locale(), { emptyTable: "No transactions" } ),
                    dom: '<"#dtExportButtonsWrapper"B>rt<"row"<"col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"li><"col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"p>>',
                    buttons: ['copy', 'csv', 'excel', 'pdf'],
                    lengthMenu: [15, this.getMonthLength()],
                    pageLength: 15,
                    ajax: {
                      url: '/reports/transactions',
                      method: 'POST',
                      timeout: 10000,
                      data: () => this.data
                    },
                    drawCallback() {
                        $('#transactionReports').next().addClass('mt-3');
                        $('#transactionReports_info').addClass('d-none');
                        $('#transactionReports_length').addClass('py-0');
                        $('#transactionReports_paginate').addClass('py-0 pagination pagination-circle mx-1');
                    },
                    footerCallback() {
                      let totals = [];
                      const api = this.api();

                      // Calculate totals on all pages
                      api.columns().every(function (index) {
                        if(index == 0) return;

                        let columnTotal = 0;
                        const data = this.data();

                        data.each(function (value) {
                          const matches = value.match(/<div.*?>(?:₺)?([\d,]+(?:\.\d{2})?)<\/div>/i);
                          if (matches && matches.length > 0) {
                            columnTotal += parseFloat(matches[1].replace(',', ''));
                          }
                        });

                        totals.push(parseFloat(columnTotal.toFixed(2)));
                      });

                      // Update footer with total amounts
                      const isTotalsEmpty = Object.values(totals).every(value => value === 0);
                      if (!isTotalsEmpty) {
                        $(api.column(0).footer()).html('Total:');
                        const formatter = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });

                        for (let i = 0; i < totals.length; i++) {
                          let number = Number.isInteger(totals[i]) ? totals[i] : '₺' + formatter.format(totals[i])
                          $(api.column(i + 1).footer()).html(number == 0 ? "-" : number);
                        }

                        $('#transactionReports tfoot').show();
                      } else {
                        // Hide footer when if don't have any data
                        $('#transactionReports tfoot').hide();
                      }
                    },
                  };

                  this.table = new DataTable('#transactionReports', dataTableConfig);

                  this.table.on('draw', function() {
                    $.varien.datatable.exportEvents();
                    $('tbody td:nth-child(6)').addClass('border-end');
                  });
                },
                reload() {
                    this.table.ajax.reload();
                },
                getMonthLength(month = (new Date()).getMonth(), year = new Date().getFullYear()) {
                  return new Date(year, month + 1, 0).getDate();
                },
            },
            statistics: {
                table: null,
                init() {
                    const dataTableConfig = {
                      language: $.varien.datatable.locale(),
                      dom: '<"#dtExportButtonsWrapper"B>rt<"row"<"col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start"li><"col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end"p>>',
                      buttons: ['copy', 'csv', 'excel', 'pdf'],
                      lengthMenu: [10],
                      pageLength: 10,
                      scrollY: "415px",
                      ajax: {
                        url: '/reports/statistics',
                        method: 'POST',
                        timeout: 10000
                      },
                      drawCallback() {
                        $('.dataTables_scroll').next().addClass('px-13');
                        $('#statistics_info').addClass('d-none');
                        $('#statistics_paginate').addClass('pagination pagination-circle mx-1');
                      },
                    };

                    this.table = new DataTable('#statistics', dataTableConfig);

                    this.table.on('draw', function() {
                      $.varien.datatable.exportEvents();
                    });
                },
                reload() {
                    this.table.ajax.reload();
                },
            },
        },
        init: function() {
            // Initiate UI Blockers
            const _message = '<div class="blockui-message"><span class="spinner-border text-primary"></span>Please wait...</div>';

            let targets = [$('#first-row'), $('#third-row')];
            if ($('#second-row').length) targets.push($('#second-row'));

            blockers = targets.filter(Boolean).map((target) => {
                return target.length > 0 ? new KTBlockUI(target[0], {
                    message: _message
                }) : null;
            });

            // Update data when user changes year, month, or firm inputs
            $('#year, #month, #firms').on('change', () => {
                const data = {
                    'firm': $('#firms').val(),
                    'month': $('#month').val(),
                    'year': $('#year :selected').text()
                };

                // Fetch new data
                this.fetch(data);

                // Update transactions datatable
                this.tables.transactions.data = data;
                this.tables.transactions.reload();
            });

            // Destroy and re-initiate charts with same data when theme mode changes
            KTThemeMode.on("kt.thememode.change", () => {
                this.charts.pie.themeChange();
                this.charts.main.themeChange();
            });

            // Check main chart data if there is no data
            if(mainChartData.every(item => item.deposit === '0.00' && item.withdraw === '0.00')) {
                let chart = document.getElementById('chart-reports-main');
                if (chart.classList.contains('d-none')) return;

                let message = "There are no transactions within this month";
                let html = `<div class='d-flex flex-center fs-1 fw-semibold w-100 h-300px'>${message}</div>`;

                chart.classList.add('d-none');
                chart.insertAdjacentHTML('afterend', html);
                return;
            };

            // Show summary data
            this.updateSummary();

            // Initialize main chart
            this.charts.main.init({
                'deposit': mainChartData.map(item => item.deposit),
                'withdraw': mainChartData.map(item => item.withdraw),
                'categories': this.getDaysInMonth()
            });

            // Initialize transactions datatable
            this.tables.transactions.init();

            if($.resource.root) {
                // Initialize pie chart
                this.charts.pie.init(pieChartData.map(item => parseFloat(item.percentage)));

                // Initialize root datatable
                this.tables.statistics.init();
            }
        },
        fetch: function(data) {
            blockers.forEach((blocker) => blocker.block());
            $('#year, #month, #firms').attr('disabled', 'disabled');

            $.ajax({
                url: '/reports/highlights',
                method: 'POST',
                timeout: 10000,
                dataType: 'json',
                data: {
                    month: data.month,
                    year: data.year,
                    firm: data.firm
                },
                success: (response) => {
                    this.process(response, date = {
                        "month": $('#month').val() - 1,
                        "year": $('#year :selected').text(),
                    });
                },
                complete: () => {
                    blockers.forEach((blocker) => blocker.release());
                    $('#year, #month, #firms').removeAttr('disabled', 'disabled');
                }
            });
        },
        process: function(data, date = null) {
            if (!data) return;

            // Update summary data
            this.updateSummary(data.mainChart);

            // Validate data and update main chart
            if (!data.mainChart.every(obj => obj.deposit === "0.00" && obj.withdraw === "0.00")) {
                this.charts.main.hide(false);
                this.charts.main.update({
                    "deposit": data.mainChart.map(item => item.deposit),
                    "withdraw": data.mainChart.map(item => item.withdraw),
                    "categories": this.getDaysInMonth(date.month, date.year)
                });
            } else {
                this.charts.main.hide(true);
            }

            if($.resource.root) {
                // Validate data and update pie chart
                const isPieDataEmpty = data.pieChart.every(obj => obj.percentage === "0.00");
                if (data.pieChart.length > 0 && !isPieDataEmpty) {
                    this.charts.pie.hide(false);
                    this.charts.pie.update(data.pieChart.map(item => parseFloat(item.percentage)));
                } else {
                    this.charts.pie.hide(true);
                }
            }
        },
        updateSummary: function(data) {
            const calculateMonthlyAverage = (month, year, amount) => {
                const daysInMonth = new Date(year, month, 0).getDate();
                const currentDate = new Date();

                if (currentDate.getMonth() === month && currentDate.getFullYear() === year) {
                    const currentDay = currentDate.getDate();
                    return amount / currentDay;
                }

                return amount / daysInMonth;
            };

            if(!data) data = mainChartData;

            const formatter = new Intl.NumberFormat('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            const totalDeposit = data.reduce((acc, obj) => acc + parseFloat(obj.deposit), 0).toFixed(2);
            const totalWithdraw = data.reduce((acc, obj) => acc + parseFloat(obj.withdraw), 0).toFixed(2);
            const monthlyAverage = calculateMonthlyAverage($('#month').val(), $('#year :selected').text(), totalDeposit);

            $('#totalDeposits').text(formatter.format(totalDeposit));
            $('#dailyAverage').text(formatter.format(monthlyAverage));
            $('#totalWithdrawals').text(formatter.format(totalWithdraw));
        },
        getDaysInMonth: (month = (new Date()).getMonth(), year = (new Date().getFullYear())) => {
            let days;
            if (month === 1 && (year % 4 === 0 && year % 100 !== 0 || year % 400 === 0)) {
                days = 29; // February in a leap year
            } else {
                days = new Date(year, month + 1, 0).getDate();
            }

            return Array.from({ length: days }, (_, i) => {
                const day = i + 1;
                return new Date(year, month, day).toLocaleString('en-US', {
                    month: 'short',
                    day: '2-digit'
                });
            });
        },
    },
    settings: {
        init: function() {
            $('[id="updateSetting"]').on('click', function(e) {
                $('[name="maintenanceStatus"]').closest("form").attr('id');
                var formId = $(this).attr("data-form-id");
                $.varien.settings.submit(formId);
                $("form#" + formId).submit();
            });
            $('[id="apiErrorStringsSave"]').on('click', function (e) {
                $.varien.eventControl(e);
                $.varien.settings.api.errorStrings.submit();
                $("form#apiErrorStringsForm").submit();
            });

            $('input[data-set="statusSwitch"]').on('change', function () {
                var elm = $(this);
                var formId = $('input[name="' + $(this).attr('name') + '"]').closest("form").attr('id');
                if ($(this).attr("name") != "maintenanceStatus") {
                    $.varien.settings.switch($(this));
                    $.varien.settings.submitStatus(formId, $(this).attr('name'));
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
                                confirm: {
                                    label: "Confirm"
                                },
                                cancel: {
                                    label: "Cancel"
                                }
                            },
                            callback: (result) => {
                                if (result == true) {
                                    KTCookie.set('cancel', 0, {
                                        sameSite: 'None',
                                        secure: true
                                    });
                                    $.varien.settings.switch(elm);
                                    $.varien.settings.submitStatus(formId, elm.attr('name'));
                                    $("form#" + formId).submit();
                                } else {
                                    KTCookie.set('cancel', 1, {
                                        sameSite: 'None',
                                        secure: true
                                    });
                                    elm.trigger("click");
                                }
                            }
                        });
                    } else {
                        if (KTCookie.get('cancel') != 1) {
                            $.varien.settings.switch(elm);
                            $.varien.settings.submitStatus(formId, elm.attr('name'));
                            $("form#" + formId).submit();
                        }
                        KTCookie.set('cancel', 0, {
                            sameSite: 'None',
                            secure: true
                        });
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

            $('input[id="checkShowAll"]').on('change', function() {
                $.varien.settings.client.reload();
            });

            $.varien.settings.client.init();
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
                    url: "settings/update",
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
                    error: function(jqXHR, errorThrown) {
                        toastr.error(`${errorThrown}`, `Error ${jqXHR.status}`);
                    }
                });
            }));
        },
        submitStatus: function(formId, name) {
            $("form#" + formId).on('submit', (function(e) {
                $.varien.eventControl(e);
                $.ajax({
                    url: "settings/update",
                    type: "POST",
                    dataType: "html",
                    crossDomain: true,
                    data: name + "=" + $('[name="' + name + '"]').val(),
                    success: function() {
                        toastr.success("Settings updated");
                        if (name == "maintenanceStatus") location.reload();
                    },
                    error: function(jqXHR, errorThrown) {
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
                        data: function(data) {
                            return Object.assign(data, {
                                'status': $('#checkShowAll')[0].checked
                            });
                        }
                    }
                });
                $.varien.settings.client.onLoad();
                let delayTimer;
                $('#search').on('input', function() {
                    let val = this.value;
                    clearTimeout(delayTimer);
                    delayTimer = setTimeout(function() {
                        $.table.search(val).draw();
                    }, 250);
                });
                $('#datatableReload').on('click', function() {
                    $.varien.settings.client.reload();
                });
                $('#datatableReset').on('click', function() {
                    $.varien.settings.client.reset();
                });
            },
            onLoad: function() {
                $.table.on('draw', function() {
                    $.varien.datatable.exportEvents();
                    $.varien.settings.client.modal();
                    $.varien.settings.client.remove();
                    $("tbody td:nth-child(6)").addClass('text-end');
                    $('input[data-set="switch"]').on("change", function() {
                        if ($(this).is(":checked") == true) {
                            $.varien.settings.client.switch($(this).attr("name"), $(this).attr("data-id"), "on", () => {
                                toastr.success("The firm has been authorized to perform transactions");
                            });
                        } else {
                            $.varien.settings.client.switch($(this).attr("name"), $(this).attr("data-id"), 0, () => {
                                toastr.error("Firm's authorization has been revoked");
                            });
                        }
                    });
                });
            },
            modal: function() {
                $('[data-bs-target="#clientModalForm"]').on("click", function() {
                    var id = $(this).attr("data-id");
                    if (id != "0") {
                        $('[data-title]').html("Edit Firm");
                        $('#generateKey').html("Generate");
                        $.varien.settings.client.detail(id);
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
                    $.varien.settings.client.save(id);
                    $('#generateKey').on('click', function() {
                        $('[name="api_key"]').val($.varien.settings.client.generateKey());
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
            switch: function(name, id, status, callback) {
                $.ajax({
                    url: "client/switch/" + id + "/" + name + "/" + status,
                    type: "POST",
                    dataType: "html",
                    cache: false,
                    success: () => callback()
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
                    if (Number.parseFloat(limitDepositMin) < Number.parseFloat(minDeposit) ||
                        Number.parseFloat(limitDepositMax) < Number.parseFloat(maxDeposit) ||
                        Number.parseFloat(limitWithdrawMin) < Number.parseFloat(minWithdraw) ||
                        Number.parseFloat(limitWithdrawMax) < Number.parseFloat(maxWithdraw)) {
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
                        error: function(jqXHR, errorThrown) {
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
                            confirm: {
                                label: "Confirm"
                            },
                            cancel: {
                                label: "Cancel"
                            }
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
        },
        api: {
            errorStrings: {
                submit: function () {
                    $("form#apiErrorStringsForm").on('submit', (function (e) {
                        $.varien.eventControl(e);
                        var formData = new FormData(this);
                        $.ajax({
                            url: "settings/api/updateErrorStrings",
                            type: "POST",
                            dataType: "html",
                            crossDomain: true,
                            data: formData,
                            xhrFields: {
                                withCredentials: true
                            },
                            processData: false,
                            contentType: false,
                            success: function () {
                                toastr.success("Settings updated");
                            },
                            error: function (jqXHR, errorThrown) {
                                toastr.error(`${errorThrown}`, `Error ${jqXHR.status}`);
                            }
                        });
                    }));
                }
            }
        }
    }
};
$.varien.boot().then((resource) => {
    $.resource = resource;
    $.syncTime = 10000;
    $.activityTimeOut = 15000;
    $.ajaxSetup({
        cache: false
    });
    $.wait = (ms) => {
        $.defer = $.Deferred();
        setTimeout(() => {
            $.defer.resolve();
        }, ms);
        return $.defer;
    };
}).then(() => {
    $.varien.init();
});