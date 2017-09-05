var getTimeZone = function() { return -((new Date()).getTimezoneOffset() / 60); };

var getSize = function(size, fixed) {
    var K = 1024; //1024;
    size = parseInt(size || 0);
    var unit = ["B", "KB", "MB", "GB"];

    var j = 0;
    for (var i = 0; i < unit.length; i++) {
        if (size >= Math.pow(K, i) - 1) {
            j = i;
        }
    }
    var result = (size / Math.pow(K, j));
    if (fixed) {
        result = result.toFixed(j === 0 ? 0 : 2);
    }
    return result + " " + unit[j];
}

var showUsage = function(elem, from, to, step, data) {
    var options = {
        layout: {
            padding: {
                left: 2,
                right: 2,
                top: 2,
                bottom: 2
            }
        },
        tooltips: {
            enabled: false
        },
        legend: {
            display: false
        },
        elements: {
            line: {
                tension: 0, // disables bezier curves
            },
            point: {
                hoverRadius: 1.5,
            }
        },
        scales: {
            yAxes: [{
                display: false,
                ticks: {
                    beginAtZero: true,
                    display: false,
                },
                gridLines: {
                    display: false
                }
            }],
            xAxes: [{
                display: false,
                ticks: {
                    beginAtZero: false,
                    display: false,
                },
                gridLines: {
                    display: false,
                }
            }]
        },
        responsive: false,
        animation: {
            duration: 0, // general animation time
        },
        hover: {
            animationDuration: 0, // duration of animations when hovering an item
        },
        responsiveAnimationDuration: 0, // animation duration after a resize
    };

    var ctx = $(elem);
    var usage = {};
    var usage_u = [];
    var usage_d = [];
    var labels = [];
    for (var i = 0; i < data.length; i++) {
        usage[data[i].t] = data[i];
    }
    var t = 0;
    for (var i = from; i <= to; i += step) {
        usage_u.push(usage[i] ? usage[i].u : 0);
        usage_d.push(usage[i] ? usage[i].d : 0);
        labels.push(t++);
    }
    var datasets = [{
        lineTension: 0,
        data: usage_d,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
        pointRadius: .1
    }];
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: labels,
            datasets: datasets
        },
        options: options
    });
}

!(function() {
    var timezone = getTimeZone();
    $.cookie('timezone', timezone, { expires: 30, path: '/' });
})();