<?php
$conn = new mysqli("localhost", "root", "", "hospital_db");

// Delete
if (isset($_GET['delete'])) {
    $conn->query("DELETE FROM doctor WHERE D_id=" . $_GET['delete']);
    header("Location: doctor_manage.php");
    exit;
}

// Edit
$edit = null;
if (isset($_GET['edit'])) {
    $res = $conn->query("SELECT * FROM doctor WHERE D_id=" . $_GET['edit']);
    $edit = $res->fetch_assoc();
}

// Insert / Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['D_id'])) {
        $stmt = $conn->prepare("UPDATE doctor SET D_name=?, age=?, contactno=?, email=?, gender=?, specialization=? WHERE D_id=?");
        $stmt->bind_param("sissssi", $_POST['D_name'], $_POST['age'], $_POST['contactno'], $_POST['email'], $_POST['gender'], $_POST['specialization'], $_POST['D_id']);
    } else {
        $stmt = $conn->prepare("INSERT INTO doctor (D_name, age, contactno, email, gender, specialization, password) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisssss", $_POST['D_name'], $_POST['age'], $_POST['contactno'], $_POST['email'], $_POST['gender'], $_POST['specialization'], $_POST['password']);
    }
    $stmt->execute();
    header("Location: doctor_manage.php");
    exit;
}

$doctors = $conn->query("SELECT * FROM doctor");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Doctor Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h3><?= $edit ? 'Update' : 'Add' ?> Doctor</h3>
        </div>
        <div class="card-body">
            <form method="post">
                <input type="hidden" name="D_id" value="<?= $edit['D_id'] ?? '' ?>">

                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="D_name" class="form-control" value="<?= $edit['D_name'] ?? '' ?>" required>
                </div>

                <div class="mb-3">
                    <label>Age</label>
                    <input type="number" name="age" class="form-control" value="<?= $edit['age'] ?? '' ?>" required>
                </div>

                <div class="mb-3">
                    <label>Contact No</label>
                    <input type="text" name="contactno" class="form-control" value="<?= $edit['contactno'] ?? '' ?>" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $edit['email'] ?? '' ?>" required>
                </div>

                <div class="mb-3">
                    <label>Gender</label>
                    <select name="gender" class="form-select">
                        <option <?= ($edit['gender'] ?? '') == 'Male' ? 'selected' : '' ?>>Male</option>
                        <option <?= ($edit['gender'] ?? '') == 'Female' ? 'selected' : '' ?>>Female</option>
                        <option <?= ($edit['gender'] ?? '') == 'Other' ? 'selected' : '' ?>>Other</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label>Specialization</label>
                    <input type="text" name="specialization" class="form-control" value="<?= $edit['specialization'] ?? '' ?>" required>
                </div>

                <?php if (!$edit): ?>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                <?php endif; ?>

                <button type="submit" class="btn btn-primary"><?= $edit ? 'Update' : 'Add' ?> Doctor</button>
                <a href="doctor_manage.php" class="btn btn-secondary">Reset</a>
            </form>
        </div>
    </div>

    <div class="mt-4 card shadow">
        <div class="card-header bg-dark text-white">
            <h4>Doctor List</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped table-hover">
                <thead>
                    <tr>
                        <th>Name</th><th>Age</th><th>Contact</th><th>Email</th><th>Gender</th><th>Specialization</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($row = $doctors->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['D_name'] ?></td>
                        <td><?= $row['age'] ?></td>
                        <td><?= $row['contactno'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['gender'] ?></td>
                        <td><?= $row['specialization'] ?></td>
                        <td>
                            <a href="?edit=<?= $row['D_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="?delete=<?= $row['D_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this doctor?')">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>