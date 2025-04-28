$(document).ready(function () {
    var yValues = [10];
    var barColors = ["#00C1D4", "#F8485E"];
    new Chart("users-stats", {
        type: "doughnut",
        data: {
            datasets: [
                {
                    backgroundColor: barColors,
                    data: yValues,
                },
            ],
        },
    });
    new Chart("campaign-stats", {
        type: "doughnut",
        data: {
            datasets: [
                {
                    backgroundColor: barColors,
                    data: yValues,
                },
            ],
        },
    });
    new Chart("lists-stats", {
        type: "doughnut",
        data: {
            datasets: [
                {
                    backgroundColor: barColors,
                    data: yValues,
                },
            ],
        },
    });
    new Chart("in-group-stats", {
        type: "doughnut",
        data: {
            datasets: [
                {
                    backgroundColor: barColors,
                    data: yValues,
                },
            ],
        },
    });
    new Chart("dids-stats", {
        type: "doughnut",
        data: {
            datasets: [
                {
                    backgroundColor: barColors,
                    data: yValues,
                },
            ],
        },
    });
})
