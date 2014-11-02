<html>
    <head>

        <!----------
        jqPlot 
       ---------->

        <script language="javascript" type="text/javascript" src="../jquery/jqplot/jquery.jqplot.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../jquery/jqplot/jquery.jqplot.min.css" />

        <script type="text/javascript" src="../jquery/jqplot/plugins/jqplot.barRenderer.min.js"></script>
        <script type="text/javascript" src="../jquery/jqPlot/plugins/jqplot.categoryAxisRenderer.min.js"></script>
        <script type="text/javascript" src="../jquery/jqPlot/plugins/jqplot.pointLabels.min.js"></script>
        <script type="text/javascript" src="../jquery/jqPlot/plugins/jqplot.dateAxisRenderer.min.js"></script>

        <?php
        /*
         * Copyright (C) 2014 rdgmus
         *
         * This program is free software: you can redistribute it and/or modify
         * it under the terms of the GNU General Public License as published by
         * the Free Software Foundation, either version 3 of the License, or
         * (at your option) any later version.
         *
         * This program is distributed in the hope that it will be useful,
         * but WITHOUT ANY WARRANTY; without even the implied warranty of
         * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
         * GNU General Public License for more details.
         *
         * You should have received a copy of the GNU General Public License
         * along with this program.  If not, see <http://www.gnu.org/licenses/>.
         */
        ?>

        <script type="text/javascript">
            $(document).ready(function () {
                function getConnectionPerMonth() {
                    sql = "SELECT count(*) as connessioni, month(when_registered) as mese, \n" +
                            "year(when_registered) as anno \n" +
                            "FROM scuola.utenti_logger` WHERE `msg_type`=\'LOGIN_SUCCESS\'\n" +
                            "GROUP BY month(`when_registered`)";

//        $.ajax({
//            type: "POST",
//            url: 'login.php',
//            data: mydata,
//            success: function (response) {//response is value returned from php (for your example it's "bye bye"
//                //alert(response);
//                $("#password").val(response);
//                $("#password").focus(100);
//                $.prompt.goToState('state1');
//            }});

                }

                /**
                 * 
                 * @returns {undefined}
                 */
                function connectionsPerMonthGraph() {
                    var line1 = [
                        ['2008-09-15 4:00PM', 4],
                        ['2008-10-15 4:00PM', 6.5],
                        ['2008-11-15 4:00PM', 5.7],
                        ['2008-12-15 4:00PM', 9],
                        ['2009-01-15 4:00PM', 8.2]
                    ];
                    var plot1 = $.jqplot('connectionsPerMonthGraph', [line1], {
                        title: 'Connessioni mensili',
                        axes: {xaxis: {renderer: $.jqplot.DateAxisRenderer}, yaxis: {min: 0, max: 10}},
                        series: [{lineWidth: 4, markerOptions: {style: 'square'}}]
                    });

                }

                /**
                 * 
                 * @returns {undefined}
                 */
                function applicationStatsGraph() {
                    var s1 = [200, 600, 700, 1000];
                    var s2 = [460, -210, 690, 820];
                    var s3 = [-260, -440, 320, 200];
                    // Can specify a custom tick Array.
                    // Ticks should match up one for each y value (category) in the series.
                    var ticks = ['May', 'June', 'July', 'August'];

                    var plot1 = $.jqplot('applicationStatsGraph', [s1, s2, s3], {
                        title: "Statistiche PhpRegistroScuola 1.0",
                        // The "seriesDefaults" option is an options object that will
                        // be applied to all series in the chart.
                        seriesDefaults: {
                            renderer: $.jqplot.BarRenderer,
                            rendererOptions: {fillToZero: true}
                        },
                        // Custom labels for the series are specified with the "label"
                        // option on the series option.  Here a series option object
                        // is specified for each series.
                        series: [
                            {label: 'Hotel'},
                            {label: 'Event Regristration'},
                            {label: 'Airfare'}
                        ],
                        // Show the legend and put it outside the grid, but inside the
                        // plot container, shrinking the grid to accomodate the legend.
                        // A value of "outside" would not shrink the grid and allow
                        // the legend to overflow the container.
                        legend: {
                            show: true,
                            placement: 'outsideGrid'
                        },
                        axes: {
                            // Use a category axis on the x axis and use our custom ticks.
                            xaxis: {
                                renderer: $.jqplot.CategoryAxisRenderer,
                                ticks: ticks
                            },
                            // Pad the y axis just a little so bars can get close to, but
                            // not touch, the grid boundaries.  1.2 is the default padding.
                            yaxis: {
                                pad: 1.05,
                                tickOptions: {formatString: '$%d'}
                            }
                        }
                    });
                }

                connectionsPerMonthGraph();
                applicationStatsGraph();


            });
        </script>
    </head>

    <body>
            <tr>
                <td bgcolor="white">
                    <div id="applicationStatsGraph" style="height:200px;width:500px; "></div>

                </td>
                <td bgcolor="white">
                    <div id="connectionsPerMonthGraph" style="height:200px;width:500px; "></div>
                </td>
            </tr>

    </body>
</html>