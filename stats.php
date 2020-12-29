<html>

<head>
<title>Statistics</title>
<script type="text/javascript" src="./js/lib/jquery-3.0.0.min.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="./js/flot/excanvas.min.js"></script><![endif]-->
<script type="text/javascript" src="./js/flot/jquery.flot.min.js"></script>
<script type="text/javascript" src="./js/flot/jquery.flot.time.js"></script>    
<script type="text/javascript" src="./js/flot/jshashtable-2.1.js"></script>    
<script type="text/javascript" src="./js/flot/jquery.numberformatter-1.2.3.min.js"></script>
<script type="text/javascript" src="./js/flot/jquery.flot.symbol.js"></script>
<script type="text/javascript" src="./js/flot/jquery.flot.axislabels.js"></script>
<script>
//Sell
var data1 = [
<?php
$servername = "sql310.byethost12.com";
$username = "b12_19676790";
$password = "14goku25ko";
$database = "b12_19676790_test";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
	//die:quite programme .display message
} 


		$query = "SELECT YEAR(time) AS yy,MONTH(time) AS mm,DAY(time) AS dd,";
		$query.="HOUR(time) AS hh,MINUTE(time) AS min,SECOND(time) AS ss,";
		$query.="rate FROM test ORDER BY time";
		
		
		$result = $conn->query($query) ;
		if ($result === false) {
			echo "Error";
		}
		else {
			$records=array();
			$result->data_seek(0);
			while($record=$result->fetch_assoc()){//assoc=associated array 
				$records[] ="[gd(".$record['yy'].",".$record['mm'].",".$record['dd']
				.",".$record['hh'].",".$record['min'].",".$record['ss']."),".$record['rate']."]";
			}
			echo implode(",",$records);
		}
?>		
/*
    [gd(2013, 1, 2), 1690.25], [gd(2013, 1, 3), 1696.3], [gd(2013, 1, 4), 1659.65],
    [gd(2013, 1, 7), 1668.15], [gd(2013, 1, 8), 1656.1], [gd(2013, 1, 9), 1668.65],
    [gd(2013, 1, 10), 1668.15], [gd(2013, 1, 11), 1680.2], [gd(2013, 1, 14), 1676.7],
    [gd(2013, 1, 15), 1680.7], [gd(2013, 1, 16), 1689.75], [gd(2013, 1, 17), 1687.25],
    [gd(2013, 1, 18), 1698.3], [gd(2013, 1, 21), 1696.8], [gd(2013, 1, 22), 1701.3],
    [gd(2013, 1, 23), 1700.8], [gd(2013, 1, 24), 1686.75], [gd(2013, 1, 25), 1680],
    [gd(2013, 1, 28), 1668.65], [gd(2013, 1, 29), 1671.2], [gd(2013, 1, 30), 1675.7],
    [gd(2013, 1, 31), 1684.25]
*/

];

var dataset = [
    {
        label: "Temperature",
        data: data1,
        color: "#FF0000",
        points: { fillColor: "#FF0000", show: true },
        lines: { show: true }
    },
];

var dayOfWeek = ["Sun", "Mon", "Tue", "Wed", "Thr", "Fri", "Sat"];

var options = {
    series: {
        shadowSize: 5
    },
    xaxes: [{
        mode: "time",                
        tickFormatter: function (val, axis) {
            return dayOfWeek[new Date(val).getDay()];
        },
        color: "black",
        position: "top",
        axisLabel: "Day of week",
        axisLabelUseCanvas: true,
        axisLabelFontSizePixels: 12,
        axisLabelFontFamily: 'Verdana, Arial',
        axisLabelPadding: 5
    },
    {
        mode: "time",
        timeformat: "%m/%d",
        tickSize: [3, "day"],
        color: "black",        
        axisLabel: "Date",
        axisLabelUseCanvas: true,
        axisLabelFontSizePixels: 12,
        axisLabelFontFamily: 'Verdana, Arial',
        axisLabelPadding: 10
    }],
    yaxis: {        
        color: "black",
        tickDecimals: 2,
        axisLabel: "Day",
        axisLabelUseCanvas: true,
        axisLabelFontSizePixels: 12,
        axisLabelFontFamily: 'Verdana, Arial',
        axisLabelPadding: 5
    },
    legend: {
        noColumns: 0,
        labelFormatter: function (label, series) {
            return "<font color=\"white\">" + label + "</font>";
        },
        backgroundColor: "#000",
        backgroundOpacity: 0.9,
        labelBoxBorderColor: "#000000",
        position: "nw"
    },
    grid: {
        hoverable: true,
        borderWidth: 3,
        mouseActiveRadius: 50,
        backgroundColor: { colors: ["#ffffff", "#EDF5FF"] },
        axisMargin: 20
    }
};

$(document).ready(function () {
    $.plot($("#flot-placeholder"), dataset, options);
    $("#flot-placeholder").UseTooltip();
});




function gd(year, month, day,hour,minutes,second) {
    return new Date(year, month - 1, day,hour,minutes,second).getTime();
}

var previousPoint = null, previousLabel = null;
var monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

$.fn.UseTooltip = function () {
    $(this).bind("plothover", function (event, pos, item) {
        if (item) {
            if ((previousLabel != item.series.label) || (previousPoint != item.dataIndex)) {
                previousPoint = item.dataIndex;
                previousLabel = item.series.label;
                $("#tooltip").remove();
                
                var x = item.datapoint[0];
                var y = item.datapoint[1];
                var date = new Date(x);
                var color = item.series.color;

                showTooltip(item.pageX, item.pageY, color,
                            "<strong>" + item.series.label + "</strong><br>"  +
                            (date.getMonth() + 1) + "/" + date.getDate() +
                            " : <strong>" + y + "</strong> (USD/oz)");
            }
        } else {
            $("#tooltip").remove();
            previousPoint = null;
        }
    });
};

function showTooltip(x, y, color, contents) {
    $('<div id="tooltip">' + contents + '</div>').css({
        position: 'absolute',
        display: 'none',
        top: y - 40,
        left: x - 120,
        border: '2px solid ' + color,
        padding: '3px',
        'font-size': '9px',
        'border-radius': '5px',
        'background-color': '#fff',
        'font-family': 'Verdana, Arial, Helvetica, Tahoma, sans-serif',
        opacity: 0.9
    }).appendTo("body").fadeIn(200);
}




</script>
</head>
<body>
<div id="flot-placeholder" style="width:550px;height:300px;margin:0 auto"></div>
</body>
</html>