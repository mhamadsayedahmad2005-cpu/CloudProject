<?php
$conn = mysqli_connect($host, $username, $password, $database);
$majors = $conn->query("SELECT Name FROM Major");
$cities = $conn->query("SELECT Name FROM City");
if (isset($_POST['logout'])) {
    $_SESSION = [];
    session_destroy();
    header("Location: index.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Student Pathfinder - Home</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background: url(grad-wp.jpg) no-repeat center center fixed;
      background-size: cover;
      color: #fff;
    }

    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: rgba(0, 0, 0, 0.7);
      padding: 15px 20px;
      position: fixed;
      width: 100%;
      top: 0;
      left: 0;
      z-index: 1000;
      flex-wrap: wrap;
    }

    header h1 {
      margin: 0;
      font-size: 1.5rem;
    }

    .logout-btn {
      padding: 10px 16px;
      margin-right:30px;
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

    .main-container {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      align-items: flex-start;
      min-height: 100vh;
      padding: 100px 20px 80px;
      box-sizing: border-box;
    }

    .form-section, .image-section {
      width: 100%;
      max-width: 500px;
      margin: 10px;
    }

    .form-section {
      background: rgba(255, 255, 255, 0.9);
      padding: 30px;
      border-radius: 10px;
      color: #000;
    }

    .form-section h2 {
      text-align: center;
      margin-bottom: 20px;
      font-size: 1.5rem;
    }

    .form-section form {
      display: flex;
      flex-direction: column;
    }

    .form-section input,
    .form-section select {
      margin-bottom: 15px;
      padding: 10px;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 5px;
    }

    .form-section button {
      padding: 10px;
      font-size: 1rem;
      background-color: black;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }

    .form-section button:hover {
      background-color: gray;
    }

    .form-section a {
      text-align: center;
      display: block;
      margin-top: 10px;
      color: #000;
      text-decoration: underline;
      font-size: 0.95rem;
    }

    .image-section img {
      width: 100%;
      max-height: 500px;
      object-fit: contain;
      border-radius: 10px;
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

    /* Media Queries */
    @media (max-width: 768px) {
      header {
        flex-direction: column;
        align-items: flex-start;
      }

      .logout-btn {
        margin-top: 10px;
      }

      .form-section, .image-section {
        max-width: 100%;
      }

      .main-container {
        padding: 100px 10px 80px;
      }
    }

    @media (max-width: 480px) {
      header h1 {
        font-size: 1.2rem;
      }

      .logout-btn {
        font-size: 0.9rem;
        padding: 8px 14px;
      }

      .form-section h2 {
        font-size: 1.3rem;
      }

      .form-section input,
      .form-section select,
      .form-section button {
        font-size: 0.95rem;
        padding: 8px;
      }

      .form-section a {
        font-size: 0.85rem;
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
    <form action="" method="POST">
      <button class="logout-btn" name="logout">Logout</button>
    </form>
  </header>

  <div class="main-container">
    <div class="form-section">
      <h2>Enter the required information</h2>
      <form method="POST" action="search.php">
        <select name="major">
          <?php while($m = $majors->fetch_assoc()) echo "<option>{$m['Name']}</option>"; ?>
        </select>

        <input type="number" name="budget" placeholder="Budget in USD ($)" required />

        <select name="location">
          <?php while($c = $cities->fetch_assoc()) echo "<option>{$c['Name']}</option>"; ?>
        </select>

        <button type="submit" name="Search">Search</button>
        <a href="schools.php">Don't have major in mind?</a>
      </form>
    </div>

    <div class="image-section">
      <img src="uni-logos.jpg" alt="University Logos">
    </div>
  </div>

  <footer>
    &copy; 2025 Student Pathfinder. All rights reserved.
  </footer>
</body>
</html>
