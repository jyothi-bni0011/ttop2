/**
 *  Document   : chartjs-data.js
 *  Description: Script for chartjs data.
 *
 **/
'use strict';

function draw_chart( email_sent, to_verify, in_process, verified ) {
    var color = Chart.helpers.color;
     var barChartData = {
         labels: ["Email Sent", "To Verify", "In Process", "Verified"],
         datasets: [{
             label: 'Users',
             backgroundColor: [
                color(window.chartColors.orange).alpha(0.5).rgbString(),
                color(window.chartColors.yellow).alpha(0.5).rgbString(),
                color(window.chartColors.green).alpha(0.5).rgbString(),
                color(window.chartColors.blue).alpha(0.5).rgbString()
             ],
             borderColor: [
                window.chartColors.orange,
                window.chartColors.yellow,
                window.chartColors.green,
                window.chartColors.blue
            ],
             borderWidth: 1,
             data: [
                email_sent,
                to_verify,
                in_process,
                verified
                 /*randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor(),
                 randomScalingFactor()*/
             ]
             
         }]

     };

    var chartjs_bar = document.getElementById("chartjs_bar");
    chartjs_bar.height = 120;
    var myBar;
    if( chartjs_bar !== null ) {

        var ctx = chartjs_bar.getContext("2d");
        myBar = new Chart(ctx, {
            type: 'bar',
            data: barChartData,
            options: {
                responsive: true,
                legend: {
                    display: false,
                    position: 'bottom',
                },
                title: {
                    display: true,
                    text: ''
                }
            }
        });

       
    }

    return myBar;
}