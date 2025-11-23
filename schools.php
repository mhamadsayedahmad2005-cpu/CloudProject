<?php
require_once 'connect.php';

if (isset($_POST['logout'])) {
  session_start();
  $_SESSION = [];
  session_destroy();
  header("Location: index.html");
  exit();
}

$schools = $conn->query("SELECT * FROM School");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>All Schools - Student Pathfinder</title>
  <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: url(grad-wp.jpg) no-repeat center center fixed;
      background-size: cover;
      color: #fff;
    }

    header {
      display: flex;
      flex-wrap: wrap;
      justify-content: space-between;
      align-items: center;
      background: rgba(0, 0, 0, 0.7);
      padding: 20px 30px;
      position: fixed;
      width: 100%;
      top: 0;
      z-index: 1000;
    }

    header h1 {
      font-size: 1.6rem;
      margin: 0;
    }

    .logout-btn {
      padding: 10px 16px;
      background: white;
      color: #000;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
      font-size: 1rem;
      transition: background 0.3s;
    }

    .logout-btn:hover {
      background: #ff4444;
      color: white;
    }

    .content {
      padding: 120px 20px 80px;
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }

    .school-card {
      background: rgba(255, 255, 255, 0.95);
      color: #000;
      padding: 20px;
      border-radius: 12px;
      width: 300px;
      box-shadow: 0 6px 12px rgba(0, 0, 0, 0.25);
      transition: transform 0.2s;
    }

    .school-card:hover {
      transform: translateY(-5px);
    }

    .school-card h3 {
      margin-top: 0;
      font-size: 1.3rem;
    }

    .school-card p {
      margin: 6px 0;
      font-size: 0.95rem;
    }

    footer {
      position: fixed;
      bottom: 0;
      width: 100%;
      background: rgba(0, 0, 0, 0.7);
      color: white;
      text-align: center;
      padding: 10px 0;
      font-size: 0.9rem;
    }

    @media (max-width: 768px) {
      header {
        flex-direction: column;
        align-items: flex-start;
      }

      .logout-btn {
        margin-top: 10px;
      }

      .school-card {
        width: 90%;
      }
    }

    @media (max-width: 480px) {
      header h1 {
        font-size: 1.3rem;
      }

      .logout-btn {
        font-size: 0.9rem;
        padding: 8px 14px;
      }

      footer {
        font-size: 0.8rem;
      }
    }
  </style>
</head>
<body>
  <header>
    <h1>Student Pathfinder</h1>
    <form method="POST">
      <button class="logout-btn" name="logout">Logout</button>
    </form>
  </header>

  <div class="content">
    <?php
    if ($schools && $schools->num_rows > 0) {
      while ($row = $schools->fetch_assoc()) {
        echo '<div class="school-card">';
        echo "<h3>{$row['Name']}</h3>";
        foreach ($row as $key => $value) {
          if ($key !== 'ID' && $key !== 'Name') {
            $label = ucfirst(str_replace('_', ' ', $key));
            echo "<p><strong>$label:</strong> $value</p>";
          }
        }
        echo '</div>';
      }
    } else {
      echo "<p>No schools found.</p>";
    }
    ?>
  </div>

  <footer>
    &copy; 2025 Student Pathfinder. All rights reserved.
  </footer>
</body>
</html>
