<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
 // Set session cookie lifetime to 30 minutes (adjust as needed)
 $sessionLifetime = 2300; // 5 minutes in seconds
 session_set_cookie_params($sessionLifetime);
  // start the session
  session_start();
  
  
 // Check if the session expiration time is set
 if (isset($_SESSION['expire_time'])) {
   // Check if the session has expired
   if (time() > $_SESSION['expire_time']) {
       // Redirect to logout.php
       header("Location: logout.php");
       exit();
   }
 }
 
 // Set the new expiration time
 $_SESSION['expire_time'] = time() + $sessionLifetime;

        // Simulating sales data retrieval from the database
        $salesData = [
            'Mn' => 10,
            'Tu' => 15,
            'Wn' => 12,
            'Th' => 20,
            'Fr' => 10,
            'st' => 20,
            'Sn' => 25,
        ];

        // Prepare the data for Chart.js
        $labels = json_encode(array_keys($salesData));
        $values = json_encode(array_values($salesData));

        // Simulating sales data retrieval from the database
        $dailySalesData = [
            'Mn' => 100,
            'Tu' => 200,
            'Wd' => 150,
            'Th' => 300,
            'Fr' => 250,
            'Sr' => 180,
            'Sn' => 220,
        ];

        // Calculate total sales and prepare data for Chart.js
        $totalSales = array_sum($dailySalesData);
        $labels1 = json_encode(array_keys($dailySalesData));
        $values1 = json_encode(array_values($dailySalesData));
    
         // Simulating product sales data retrieval from the database
         $productSalesData = [
            'Product A' => 100,
            'Product B' => 150,
            'Product C' => 200,
            'Product D' => 80,
            'Product E' => 120,
            'Product F' => 250,
        ];

        // Sort the product sales data in descending order
        arsort($productSalesData);

        // Get the top 5 best-selling products
        $topProducts = array_slice($productSalesData, 0, 5, true);

        // Prepare the data for Chart.js
        $productLabels = json_encode(array_keys($topProducts));
        $productValues = json_encode(array_values($topProducts));
    
        $lastWeekData = [
            'Mn' => 100,
            'Tu' => 150,
            'Wd' => 120,
            'Th' => 180,
            'Fr' => 90,
            'Sa' => 200,
            'Sn' => 160,
        ];

        $thisWeekData = [
            'Monday' => 130,
            'Tuesday' => 180,
            'Wednesday' => 150,
            'Thursday' => 210,
            'Friday' => 110,
            'Saturday' => 250,
            'Sunday' => 190,
        ];

        $labels = json_encode(array_keys($lastWeekData)); // Assuming the same days of the week for both weeks
        $lastWeekValues = json_encode(array_values($lastWeekData));
        $thisWeekValues = json_encode(array_values($thisWeekData));
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=JetBrains Mono">
    <link rel="stylesheet" href="style.css">
    <link rel="shortcut icon" href="../img/LionReads-logo.png" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://kit.fontawesome.com/ff24e75514.js" crossorigin="anonymous"></script>
    <title>Admin Dashboard | LionReads</title>
</head>
<body>
    <!-- Admin Navbar include -->
    <?php include 'adminSidepanel.php';?>

    <!-- Order Section Starts -->
    <div class="order_container">
        <div class="order-container">
        <div class="order">
            <div class="order_details">
                <span>
                    <h2>Total Processed Orders</h2>
                    <h2>10</h2>
                </span>
                <h3>Today</h3>
                <canvas id="salesChart" class="salesChart"></canvas>
            </div>
        </div>

        <div class="order">
            <div class="order_details">
                <span>
                    <h2>Total Daily Product Sales</h2>
                    <h2>10</h2>
                </span>
                <h3>Today</h3>
                <canvas id="salesChart1" class="salesChart"></canvas>
            </div>
        </div>

        <div class="order">
            <div class="order_details">
                <span>
                    <h2>Lifetime Total Sales</h2>
                    <h2>N2M</h2>
                </span>
                <h3>Lifetime</h3>
                <canvas id="salesChart2" class="salesChart"></canvas>
            </div>
        </div>

        <div class="order">
            <div class="order_details">
                <span>
                    <h2>Best Selling Product</h2>
                    <h2>79%</h2>
                </span>
                <h3>Sales contribution</h3>
                <canvas id="bestSellingChart"></canvas>
            </div>
        </div>
        </div>

        <div class="order-volume">
            <canvas id="orderVolumeChart"></canvas>
        </div>
    </div>



    
<script>    
        /* Set the width of the sidebar to 250px (show it) */
    function openNav() {
        document.getElementById("mySidepanel").style.width = "75%";
    }
    /* Set the width of the sidebar to 0 (hide it) */
    function closeNav() {
        document.getElementById("mySidepanel").style.width = "0";
    }

    </script>
     <script>
        // Retrieve the sales data from PHP
        var salesData = {
            labels: <?php echo $labels; ?>,
            datasets: [{
                label: 'Sales',
                fill: 'origin',
                data: <?php echo $values; ?>,
                backgroundColor: 'rgba(153, 102, 255, 01)',
                borderColor: 'rgba(0, 123, 255, 0)',
                borderWidth: 0,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 1,
                tension: 0
            }]
        };

        // Initialize and configure the chart
        var ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: salesData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                elements: {
            line: {
                tension: 0, // Set tension to 0 for straight lines
                borderWidth: 0 // Remove the borders
            },
            point: {
                radius: 0 // Remove the data points
            }
        },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(0, 0, 0, 0.1)',
                            borderColor: 'rgba(0, 0, 0, 0)',
                            borderWidth: 0,
                            display: false
                        },
                        ticks: {
                            // 
                            display: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                          
                            display:false
                        }
                    }
                },
                interaction:{
                    mode: 'index',
                    intersect: true
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
                
            }
        });
    </script>

<script>
        // Retrieve the sales data from PHP
        var dailySalesData = {
            labels: <?php echo $labels1; ?>,
            datasets: [{
                label: 'Daily Sales',
                fill: 'origin',
                data: <?php echo $values1; ?>,
                backgroundColor:  'rgba(75, 192, 192, 01)',
                borderColor: '#ffffff',
                borderWidth: 2,
                pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                pointBorderColor: '#fff',
                pointBorderWidth: 2,
                pointRadius: 1,
                tension: 0
            }]
        };

        var totalSalesData = {
            labels: ['Total Sales'],
            datasets: [{
                label: 'Total Sales',
                data: [<?php echo $totalSales; ?>],
                backgroundColor: 'rgba(54, 162, 235,1)',
                borderColor:'rgba(84, 12, 235, 1)', 
                borderWidth: 0
            }]
        };

        // Initialize and configure the chart for daily sales
        var dailySalesCtx = document.getElementById('salesChart1').getContext('2d');
        new Chart(dailySalesCtx, {
            type: 'line',
            data: dailySalesData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                elements: {
            line: {
                tension: 0, // Set tension to 0 for straight lines
                borderWidth: 0 // Remove the borders
            },
            point: {
                radius: 0 // Remove the data points
            }
        },
                scales: {
                    y: {
                        ticks: {
                          
                          display:false
                      },
                    grid: {
                            display: false
                        },
                        beginAtZero: true
                    },
                    x:{
                        ticks: {
                          
                          display:false
                      },
                        grid: {
                            display: false
                        },
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Initialize and configure the chart for total sales
        var totalSalesCtx = document.getElementById('salesChart2').getContext('2d');
        new Chart(totalSalesCtx, {
            type: 'doughnut',
            data: totalSalesData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>

<script>
        // Retrieve the product sales data from PHP
        var productSalesData = {
            labels: <?php echo $productLabels; ?>,
            datasets: [{
                label: 'Sales Quantity',
                data: <?php echo $productValues; ?>,
                backgroundColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 01)', 'rgba(255, 205, 86, 01)', 'rgba(75, 192, 192, 01)', 'rgba(153, 102, 255, 01)'], // Array of colors for each area
                borderColor: ['rgba(54, 162, 235, 1)', 'rgba(255, 99, 132, 1)', 'rgba(255, 205, 86, 1)', 'rgba(75, 192, 192, 1)', 'rgba(153, 102, 255, 1)'], // Border colors for each area
                borderWidth: 2
            }]
        };

        // Initialize and configure the chart
        var ctx = document.getElementById('bestSellingChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: productSalesData,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>

    <script>
          // Retrieve the order volume data from PHP
          var orderVolumeData = {
            labels: <?php echo $labels; ?>,
            datasets: [
                {
                    label: 'Last Week',
                    data: <?php echo $lastWeekValues; ?>,
                    backgroundColor: 'rgba(54, 162, 235, 1)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2
                },
                {
                    label: 'This Week',
                    data: <?php echo $thisWeekValues; ?>,
                    backgroundColor: 'rgba(255, 99, 132, 1)',
                    borderColor: 'rgba(255, 99, 132, 1)',
                    borderWidth: 2
                }
            ]
        };

        // Initialize and configure the chart
var ctx = document.getElementById('orderVolumeChart').getContext('2d');
new Chart(ctx, {
    type: 'bar',
    data: orderVolumeData,
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    color: '#555555'
                }
            },
            y: {
                beginAtZero: true,
                ticks: {
                    color: '#555555',
                    display: false
                },
                grid: {
                  
                    display: false
                }
            }
        },
        plugins: {
            legend: {
                display: false,
                labels: {
                    font: {
                        size: 14,
                        weight: 'bold'
                    }
                }
            }
        },
        layout: {
            padding: {
                top: 10,
                right: 5,
                bottom: 10,
                left: 5
            }
        }
    }
});

    </script>
</body>
</html>