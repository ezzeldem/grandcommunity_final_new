var options = {
    series: [44, 55, 13, 33],
    chart: {
        width: 350,
        type: "donut",
    },
    dataLabels: {
        enabled: false,
    },
    labels: ["Team A", "Team B", "Team C", "Team D"],
    responsive: [
        {
            breakpoint: 480,
            options: {
                chart: {
                    width: 200,
                },
                legend: {
                    show: false,
                },
            },
        },
    ],
    legend: {
        position: "right",
        offsetY: 0,
        height: 230,
    },
};
var chart = new ApexCharts(document.querySelector("#chart"), options);
chart.render();
var options2 = {
    series: [
        {
            name: "Website Blog",
            type: "column",
            data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160],
        },
        {
            name: "Social Media",
            type: "line",
            data: [23, 42, 35, 27, 43, 22, 17, 31, 22, 22, 12, 16],
        },
    ],
    chart: {
        height: 350,
        type: "line",
    },
    stroke: {
        width: [0, 4],
    },
    title: {
        text: "",
    },
    dataLabels: {
        enabled: true,
        enabledOnSeries: [1],
    },
    labels: [
        "01 Jan",
        "02 Jan",
        "03 Jan",
        "04 Jan",
        "05 Jan",
        "06 Jan",
        "07 Jan",
        "08 Jan",
        "09 Jan",
        "10 Jan",
        "11 Jan",
        "12 Jan",
    ],
    xaxis: {
        type: "datetime",
    },
    yaxis: [
        {
            title: {
                text: "",
            },
        },
        {
            opposite: true,
            title: {
                text: "",
            },
        },
    ],
};
var chart2 = new ApexCharts(document.querySelector("#chart2"), options2);
chart2.render();

var options3 = {
    series: [
        {
            name: "Net Profit",
            data: [44, 55, 57, 56, 61, 58, 63, 60, 66],
        },
        {
            name: "Revenue",
            data: [76, 85, 101, 98, 87, 105, 91, 114, 94],
        },
        {
            name: "Free Cash Flow",
            data: [35, 41, 36, 26, 45, 48, 52, 53, 41],
        },
    ],
    chart: {
        type: "bar",
        height: 350,
    },
    plotOptions: {
        bar: {
            horizontal: false,
            columnWidth: "55%",
            endingShape: "rounded",
        },
    },
    dataLabels: {
        enabled: false,
    },
    stroke: {
        show: true,
        width: 2,
        colors: ["transparent"],
    },
    xaxis: {
        categories: [
            "Feb",
            "Mar",
            "Apr",
            "May",
            "Jun",
            "Jul",
            "Aug",
            "Sep",
            "Oct",
        ],
    },
    yaxis: {
        title: {
            text: "$ (thousands)",
        },
    },
    fill: {
        opacity: 1,
    },
    tooltip: {
        y: {
            formatter: function (val) {
                return "$ " + val + " thousands";
            },
        },
    },
};
var chart3 = new ApexCharts(document.querySelector("#chart3"), options3);
chart3.render();
