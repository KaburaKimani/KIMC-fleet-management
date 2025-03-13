<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Vehicles</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            background-color: white;
        }

        .sidebar {
            width: 150px;
            background-color: royalblue;
            color: white;
            height: 100vh;
            position: fixed;
            border-top-right-radius: 30px;
            top: 0;
            left: 0;
            padding: 20px;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        }

        .sidebar h2 {
            text-align: left;
            margin-bottom: 20px;
            font-size: 30px;
            color: white;
        }

        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            display: block;
            padding: 10px;
            border-radius: 4px;
            transition: background-color 0.3s;
        }

        .sidebar ul li a:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        .main-content {
            margin-left: 250px; 
            padding: 20px;
            width: calc(100% - 250px);
        }

        h1 {
            text-align: center;
            color: black;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: visa blue; 
            color: black;
        }

        tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        tr:hover {
            background-color: #ddd;
        }

        button {
            background-color: royalblue;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: darkblue;
        }

        a {
            color: white;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <h2>Admin</h2>
        <ul>
            <li><a href="adashboarddrivers.php">Drivers</a></li>
            <li><a href="adashboardvehicles.php">Vehicles</a></li>
            <li><a href="adashboardreports.php">Reports</a></li>
            <li><a href="settings.html">Settings</a></li>
        </ul>
    </div>

        <h1>Vehicles</h1>
        <table>
            <tr>
                <th>Vehicle ID</th>
                <th>Make</th>
                <th>Model</th>
                <th>Year</th>
                <th>License Plate</th>
                <th>Update</th>
                <th>Delete</th>
            </tr>
            <?php
                include 'connect.php';
                $sql = "SELECT * FROM vehicles";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $vehicleid = htmlspecialchars($row['vehicleid']);
                        $make = htmlspecialchars($row['make']);
                        $model = htmlspecialchars($row['model']);
                        $year = htmlspecialchars($row['year']);
                        $licenseplate = htmlspecialchars($row['licenseplate']);
                        echo "<tr>
                            <td>$vehicleid</td>
                            <td>$make</td>
                            <td>$model</td>
                            <td>$year</td>
                            <td>$licenseplate</td>
                            <td>
                                <button>
                                    <a href='update.php?updateid=$vehicleid'>Update</a>
                                </button>
                            </td>
                            <td>
                                <button>
                                    <a href='delete.php?deleteid=$vehicleid'>Delete</a>
                                </button>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align:center;color:red;'>Error fetching data: " . mysqli_error($conn) . "</td></tr>";
                }
                mysqli_close($conn);
            ?>
        ?>
        </table>