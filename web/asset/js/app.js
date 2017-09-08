var getTimeZone = function() { return -((new Date()).getTimezoneOffset() / 60); };

var getSize = function(size, fixed, k) {
    var K = k || 1024;
    size = parseInt(size || 0);
    var unit = ["B", "KB", "MB", "GB"];

    var j = 0;
    for (var i = 0; i < unit.length; i++) {
        if (size >= Math.pow(K, i) - 1) {
            j = i;
        }
    }
    var result = (size / Math.pow(K, j));
    if (fixed !== undefined) {
        result = result.toFixed(j === 0 ? 0 : fixed);
    }
    return result + " " + unit[j];
}

var customUsageTooltip = function(tooltip) {
    // Tooltip Element
    var tooltipEl = this._chart.canvas.parentNode.querySelector('.chartjs-tooltip');

    if (!tooltipEl) {
        tooltipEl = document.createElement('div');
        tooltipEl.classList = 'chartjs-tooltip tooltip top in';
        tooltipEl.innerHTML = '<div class="tooltip-arrow"></div><div class="tooltip-inner"></div>';
        this._chart.canvas.parentNode.appendChild(tooltipEl);
    }

    // Hide if no tooltip
    if (tooltip.opacity === 0) {
        tooltipEl.style.opacity = 0;
        return;
    }

    function getBody(bodyItem) {
        return bodyItem.yLabel;
    }

    // Set Text
    if (tooltip.body) {
        var bodyLines = tooltip.dataPoints.map(getBody);
        var titleLines = tooltip.title || [];
        var innerHtml = '';

        innerHtml += '<table><tbody class="text-left">';

        titleLines.forEach(function(title) {
            innerHtml += '<tr><th>' + moment(parseInt(title)).format("MM/DD HH:mm") + '</th></tr>';
        });

        bodyLines.forEach(function(body, i) {
            var spanColor = "";
            if (tooltip.displayColors) {
                var color = tooltip.labelColors[i];
                var style = 'background:' + color.borderColor + '; border-color:' + color.borderColor;
                spanColor = '<span class="chartjs-tooltip-key" style="' + style + '"></span>';
            }
            innerHtml += '<tr><td>' + spanColor + (body ? getSize(body, 2) : "-") + '</td></tr>';
        });
        innerHtml += '</tbody></table>';

        var tableRoot = tooltipEl.querySelector('.tooltip-inner');
        tableRoot.innerHTML = innerHtml;
    }

    var positionY = this._chart.canvas.offsetTop;
    var positionX = this._chart.canvas.offsetLeft;
    var height = this._chart.canvas.offsetHeight;

    // Display, position, and set styles for font
    tooltipEl.style.opacity = "";
    tooltipEl.style.left = positionX + tooltip.caretX + 'px';
    tooltipEl.style.bottom = height - tooltip.caretY + 'px';
};

var getTimePoint = function(date, interval) {
    return Math.floor((+new Date() / 1000 + getTimeZone() * 3600) / interval) * interval;
}
var getUsage = function(from, to, step, data) {
    var usage = {};
    var usage_u = [];
    var usage_d = [];
    var usage_t = [];
    var labels = [];
    for (var i = 0; i < data.length; i++) {
        usage[data[i].t] = data[i];
    }
    var offset = getTimeZone() * 3600 * 1000;
    for (var i = from; i <= to; i += step) {
        usage_u.push(usage[i] ? usage[i].u : 0);
        usage_d.push(usage[i] ? usage[i].d : 0);
        labels.push(i * 1000 - offset);
    }
    return {
        labels: labels,
        u: usage_u,
        d: usage_d,
        t: usage_t
    }
}
var showUsage = function(ctx, from, to, step, data) {
    var usage = getUsage(from, to, step, data);

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
            enabled: false,
            mode: 'index',
            position: 'nearest',
            intersect: false,
            displayColors: false,
            custom: customUsageTooltip
        },
        legend: {
            display: false
        },
        elements: {
            line: {
                tension: 0,
            },
            point: {
                hoverRadius: 1.5,
            }
        },
        scales: {
            yAxes: [{
                display: false
            }],
            xAxes: [{
                display: false
            }]
        },
        responsive: false,
        animation: {
            duration: 0, // general animation time
        },
        hover: {
            intersect: false,
            animationDuration: 0, // duration of animations when hovering an item
        },
        responsiveAnimationDuration: 0, // animation duration after a resize
    };

    var datasets = [{
        data: usage.d,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
        pointRadius: .1
    }];
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: usage.labels,
            datasets: datasets
        },
        options: options
    });
}
var getChartYAxis = function(from, to, data) {
    var K = 1024;
    var m = Math.max.apply(null, data);
    var i = 0;
    while (m > K) {
        m = m / K;
        i++;
    }

    var unit = Math.pow(10, (parseInt(m)).toString().length - 1);
    var maxNum = parseInt(m / unit) + 1;
    var max = maxNum * unit * Math.pow(K, i);
    var min = 0;
    split = [0, 4, 4, 6, 4, 5, 4, 5, 4, 5, 5, 5][maxNum];
    stepSize = max / split;

    return {
        max: max,
        min: min,
        stepSize: stepSize
    }
}
var showChart = function(ctx, from, to, step, data) {
    var usage = getUsage(from, to, step, data);
    var chartYAxis = getChartYAxis(from, to, usage.u.concat(usage.d));

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
            enabled: false,
            mode: 'index',
            position: 'nearest',
            intersect: false,
            displayColors: true,
            custom: customUsageTooltip
        },
        legend: {
            display: true
        },
        elements: {
            line: {
                tension: 0,
            },
            point: {
                hoverRadius: 1.5,
            }
        },
        scales: {
            yAxes: [{
                display: true,
                gridLines: {
                    drawBorder: false
                },
                ticks: {
                    max: chartYAxis.max,
                    min: chartYAxis.min,
                    stepSize: chartYAxis.stepSize,
                    callback: function(value, index, values) {
                        return getSize(value, 2);
                    }
                }
            }],
            xAxes: [{
                display: false,
                gridLines: {
                    drawBorder: false,
                    display: false,
                },
                ticks: {
                    callback: function(value, index, values) {
                        return value;
                    }
                }
            }]
        },
        responsive: true,
        animation: {
            duration: 0, // general animation time
        },
        hover: {
            intersect: false,
            animationDuration: 0, // duration of animations when hovering an item
        },
        responsiveAnimationDuration: 0, // animation duration after a resize
    };

    var datasets = [{
        label: "下行",
        data: usage.d,
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1,
        pointRadius: .1
    }, {
        label: "上行",
        data: usage.u,
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        borderColor: 'rgba(255, 99, 132, 1)',
        borderWidth: 1,
        pointRadius: .1
    }];
    var chart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: usage.labels,
            datasets: datasets
        },
        options: options
    });
}

!(function() {
    var timezone = getTimeZone();
    $.cookie('timezone', timezone, { expires: 30, path: '/' });
})();