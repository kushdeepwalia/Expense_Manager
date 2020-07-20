<?php
    session_start();
    $username=$_SESSION['username'];
    $wallet=$_SESSION['wallet'];
    $con=mysqli_connect('localhost:3306','id14247551_kush','9354752373_Kush');
    mysqli_select_db($con,$username) or die("Could connect to the database"); 
?>
<html>
  <head>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
            ['Task', 'Hours per Day'],
            <?php
                $query=mysqli_query($con,"SELECT `Sub Category`, SUM(Amount) FROM `$wallet` Where `Category`='Income' GROUP BY `Sub Category`");
                while($result=mysqli_fetch_array($query))
                {
                    echo"['".$result[0]."',".$result[1]."],";
                }
            ?>
        ]);

        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart1'));

        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {

        var data = google.visualization.arrayToDataTable([
          ['Task', 'Hours per Day'],
          <?php
            $query=mysqli_query($con,"SELECT `Sub Category`, SUM(Amount) FROM `$wallet` Where `Category`='Expense' GROUP BY `Sub Category`");
            while($result=mysqli_fetch_array($query))
                {
                    echo"['".$result[0]."',".$result[1]."],";
                }
          ?>
        ]);

        var options = {
          title: 'My Daily Activities'
        };

        var chart = new google.visualization.PieChart(document.getElementById('piechart2'));

        chart.draw(data, options);
      }
    </script>
  </head>
  <body>
    <div id="piechart1" style="width: 45vw; height: 100vh; float:left;"></div>
    <div id="piechart2" style="width: 45vw; height: 100vh; float:right;"></div>
  </body>
</html>
