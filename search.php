<?php
$conn = new mysqli("localhost", "root", "", "isd");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['Search'])) {
    $major = $_POST['major'];
    $budget = $_POST['budget'];
    $location = $_POST['location'];
    
    $query = "
        SELECT 
            u.ID, 
            u.Name, 
            u.Link, 
            u.Ranking,
            m.Credits,
            us.`credit-price`,
            (m.Credits * us.`credit-price`) AS TotalCost,
            l.Name AS CampusName
        FROM 
            university u
        JOIN 
            unischool us ON u.ID = us.UniId
        JOIN 
            school s ON us.SchoolId = s.ID
        JOIN 
            major m ON m.SchoolId = s.ID
        JOIN 
            location l ON l.Uniid = u.ID
        JOIN 
            city c ON l.CityId = c.ID
        WHERE 
            m.Name = ? 
            AND c.Name = ?
            AND (m.Credits * us.`credit-price`) <= ?
        ORDER BY 
            TotalCost ASC, u.Ranking ASC
    ";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $major, $location, $budget);
    $stmt->execute();
    $result = $stmt->get_result();
    
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Search Results</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: url(grad-wp.jpg) no-repeat center center fixed;
                background-size: cover;
                color: #fff;
                margin: 0;
                padding-top: 80px;
            }
            header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                background: rgba(0, 0, 0, 0.7);
                position: fixed;
                width: 100%;
                top: 0;
                left: 0;
                z-index: 1000;
            }
            .results-container {
                background: rgba(0, 0, 0, 0.7);
                margin: 20px;
                padding: 20px;
                border-radius: 10px;
            }
            .university-card {
                background: rgba(255, 255, 255, 0.9);
                color: #000;
                padding: 15px;
                margin-bottom: 15px;
                border-radius: 5px;
            }
            .university-card h3 {
                margin-top: 0;
            }
            .back-btn {
                display: inline-block;
                padding: 10px 15px;
                background: #333;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                margin: 20px;
            }
            .back-btn:hover {
                background: #555;
            }
            footer {
                position: fixed;
                bottom: 0;
                width: 100%;
                background: rgba(0, 0, 0, 0.7);
                color: white;
                text-align: center;
                padding: 10px 0;
                font-size: 14px;
            }
        </style>
    </head>
    <body>
        <header>
            <h1>Student Pathfinder - Results</h1>
            
        </header>
        
        <div class='results-container'>";
    
    if ($result->num_rows > 0) {
        echo "<h2>Universities offering $major in $location within your budget:</h2>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<div class='university-card'>
                <h3>{$row['Name']}</h3>
                <p><strong>Ranking:</strong> {$row['Ranking']}</p>
                <p><strong>Campus:</strong> {$row['CampusName']}</p>
                <p><strong>Total Program Cost:</strong> $" . number_format($row['TotalCost']) . "</p>
                <p><strong>Calculation:</strong> {$row['Credits']} credits × {$row['credit-price']} per credit</p>
                <p><a href='https://{$row['Link']}' target='_blank'>Visit University Website</a></p>
            </div>";
        }
    } else {
        echo "<h2>No universities found matching your criteria.</h2>
              <p>Try adjusting your budget or location.</p>";
    }
    
    echo "<a href='home.php' class='back-btn'>Back to Search</a>
        </div>
        
        <footer>
            &copy; 2025 Student Pathfinder. All rights reserved.
        </footer>
    </body>
    </html>";
    
    $stmt->close();
    $conn->close();
} 
?>