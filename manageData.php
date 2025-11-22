<?php
$conn = new mysqli("localhost", "root", "", "isd");

// Handle Add Major (Prepared Statement)
if (isset($_POST['submit_major'])) {
  $stmt = $conn->prepare("INSERT INTO major (Name, Credits, SchoolId) VALUES (?, ?, ?)");
  $stmt->bind_param("sii", $_POST['major_name'], $_POST['credits'], $_POST['school_id']);
  $stmt->execute();
  $stmt->close();
}

// Handle Add School (Prepared Statement)
if (isset($_POST['submit_school'])) {
  $stmt = $conn->prepare("INSERT INTO school (Name, Description) VALUES (?, ?)");
  $stmt->bind_param("ss", $_POST['school_name'], $_POST['school_desc']);
  $stmt->execute();
  $stmt->close();
}

// Handle Delete Major
if (isset($_GET['delete'])) {
  $stmt = $conn->prepare("DELETE FROM major WHERE ID = ?");
  $stmt->bind_param("i", $_GET['delete']);
  $stmt->execute();
  $stmt->close();
}

// Handle Update Major
if (isset($_POST['update'])) {
  $stmt = $conn->prepare("UPDATE major SET Name = ?, Credits = ?, SchoolId = ? WHERE ID = ?");
  $stmt->bind_param("siii", $_POST['edit_name'], $_POST['edit_credits'], $_POST['edit_school_id'], $_POST['major_id']);
  $stmt->execute();
  $stmt->close();
}

// Handle Logout
if (isset($_POST['logout'])) {
  session_start();
  $_SESSION = [];
  session_destroy();
  header("Location: index.html");
  exit();
}

// Fetch data
$schools = $conn->query("SELECT DISTINCT s.ID, s.Name FROM school s JOIN unischool u ON s.ID = u.SchoolId");
$majors = $conn->query("SELECT m.ID, m.Name, m.Credits, s.Name as School FROM major m JOIN school s ON m.SchoolId = s.ID");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Manage Majors & Schools</title>
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
      margin: 0;
      font-size: 1.5rem;
    }

    .logout-btn {
      padding: 10px 16px;
      background: white;
      color: #000;
      border: none;
      border-radius: 5px;
      font-weight: bold;
      cursor: pointer;
    }

    .logout-btn:hover {
      background: #ff4444;
      color: white;
    }

    .container {
      padding: 120px 20px 80px;
      max-width: 1200px;
      margin: auto;
    }

    .forms {
      display: flex;
      flex-wrap: wrap;
      gap: 30px;
      margin-bottom: 40px;
    }

    .form-box {
      background: rgba(255,255,255,0.95);
      color: #000;
      padding: 25px;
      border-radius: 10px;
      flex: 1;
      min-width: 280px;
      max-width: 450px;
    }

    .form-box h2 {
      text-align: center;
      margin-bottom: 20px;
    }

    .form-box input,
    .form-box select,
    .form-box textarea,
    .form-box button {
      width: 100%;
      margin-bottom: 12px;
      padding: 10px;
      border-radius: 5px;
      font-size: 1rem;
      border: 1px solid #ccc;
    }

    .form-box button {
      background: #000;
      color: #fff;
      font-weight: bold;
      border: none;
      cursor: pointer;
    }

    .form-box button:hover {
      background: gray;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: white;
      color: black;
    }

    th, td {
      padding: 12px;
      border: 1px solid #ccc;
      text-align: center;
    }

    th {
      background-color: #444;
      color: white;
    }

    .edit-input, .edit-select {
      padding: 5px;
      font-size: 0.95rem;
      width: 90%;
    }

    .idd {
      padding: 6px 10px;
      background: gray;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      text-decoration: none;
      font-size: 0.9rem;
    }

    .idd:hover {
      background: #ff4444;
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

      .form-box {
        width: 100%;
      }

      table {
        font-size: 0.9rem;
      }
    }

    @media (max-width: 480px) {
      header h1 {
        font-size: 1.2rem;
      }

      .logout-btn {
        font-size: 0.9rem;
      }

      .idd {
        padding: 5px 8px;
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

<div class="container">
  <div class="forms">
    <div class="form-box">
      <h2>Add Major</h2>
      <form method="POST">
        <input type="text" name="major_name" placeholder="Major Name" required />
        <input type="number" name="credits" placeholder="Credits" required />
        <select name="school_id" required>
          <option value="" disabled selected>Select School</option>
          <?php $schools->data_seek(0); while($s = $schools->fetch_assoc()) echo "<option value='{$s['ID']}'>{$s['Name']}</option>"; ?>
        </select>
        <button type="submit" name="submit_major">Add Major</button>
      </form>
    </div>

    <div class="form-box">
      <h2>Add School</h2>
      <form method="POST">
        <input type="text" name="school_name" placeholder="School Name" required />
        <textarea name="school_desc" rows="4" placeholder="School Description" required></textarea>
        <button type="submit" name="submit_school">Add School</button>
      </form>
    </div>
  </div>

  <h2 style="color: white;">All Majors</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Major Name</th>
      <th>Credits</th>
      <th>School</th>
      <th>Actions</th>
    </tr>
    <?php while ($m = $majors->fetch_assoc()): ?>
      <tr>
        <form method="POST">
          <td><?= $m['ID'] ?></td>
          <td><input class="edit-input" type="text" name="edit_name" value="<?= htmlspecialchars($m['Name']) ?>"></td>
          <td><input class="edit-input" type="number" name="edit_credits" value="<?= $m['Credits'] ?>"></td>
          <td>
            <select name="edit_school_id" class="edit-select">
              <?php
                $schools->data_seek(0);
                while ($s = $schools->fetch_assoc()) {
                  $selected = ($s['Name'] == $m['School']) ? "selected" : "";
                  echo "<option value='{$s['ID']}' $selected>{$s['Name']}</option>";
                }
              ?>
            </select>
          </td>
          <td>
            <input type="hidden" name="major_id" value="<?= $m['ID'] ?>">
            <button type="submit" name="update" class="idd">Update</button>
            <a href="?delete=<?= $m['ID'] ?>" onclick="return confirm('Are you sure?')" class="idd">Delete</a>
          </td>
        </form>
      </tr>
    <?php endwhile; ?>
  </table>
</div>

<footer>
  &copy; 2025 Student Pathfinder. All rights reserved.
</footer>

</body>
</html>
