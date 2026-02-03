<?php
$conn = new mysqli("localhost", "root", "", "hospital_db");

// Delete
if (isset($_GET['delete'])) {
    $conn->query("DELETE FROM patient WHERE p_id=" . $_GET['delete']);
    header("Location: patient_manage.php");
    exit;
}

// Edit
$edit = null;
if (isset($_GET['edit'])) {
    $res = $conn->query("SELECT * FROM patient WHERE p_id=" . $_GET['edit']);
    $edit = $res->fetch_assoc();
}

// Insert / Update
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['p_id'])) {
        $stmt = $conn->prepare("UPDATE patient SET p_name=?, gender=?, age=?, phoneno=?, email=?, address=?, patient_history=? WHERE p_id=?");
        $stmt->bind_param("ssissssi", $_POST['p_name'], $_POST['gender'], $_POST['age'], $_POST['phoneno'], $_POST['email'], $_POST['address'], $_POST['patient_history'], $_POST['p_id']);
    } else {
        $stmt = $conn->prepare("INSERT INTO patient (p_name, gender, age, phoneno, email, address, patient_history, password) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssisssss", $_POST['p_name'], $_POST['gender'], $_POST['age'], $_POST['phoneno'], $_POST['email'], $_POST['address'], $_POST['patient_history'], $_POST['password']);
    }
    $stmt->execute();
    header("Location: patient_manage.php");
    exit;
}

$patients = $conn->query("SELECT * FROM patient");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h3><?= $edit ? 'Update' : 'Add' ?> Patient</h3>
        </div>
        <div class="card-body">
            <form method="post">
                <input type="hidden" name="p_id" value="<?= $edit['p_id'] ?? '' ?>">
                
                <div class="mb-3">
                    <label>Name</label>
                    <input type="text" name="p_name" class="form-control" value="<?= $edit['p_name'] ?? '' ?>" required>
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
                    <label>Age</label>
                    <input type="number" name="age" class="form-control" value="<?= $edit['age'] ?? '' ?>" required>
                </div>

                <div class="mb-3">
                    <label>Phone No</label>
                    <input type="text" name="phoneno" class="form-control" value="<?= $edit['phoneno'] ?? '' ?>" required>
                </div>

                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="<?= $edit['email'] ?? '' ?>">
                </div>

                <div class="mb-3">
                    <label>Address</label>
                    <textarea name="address" class="form-control"><?= $edit['address'] ?? '' ?></textarea>
                </div>

                <div class="mb-3">
                    <label>Patient History</label>
                    <textarea name="patient_history" class="form-control"><?= $edit['patient_history'] ?? '' ?></textarea>
                </div>

                <?php if (!$edit): ?>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>
                <?php endif; ?>

                <button type="submit" class="btn btn-success"><?= $edit ? 'Update' : 'Add' ?> Patient</button>
                <a href="patient_manage.php" class="btn btn-secondary">Reset</a>
            </form>
        </div>
    </div>

    <div class="mt-4 card shadow">
        <div class="card-header bg-dark text-white">
            <h4>Patient List</h4>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-hover table-striped">
                <thead>
                    <tr>
                        <th>Name</th><th>Gender</th><th>Age</th><th>Phone</th><th>Email</th><th>Address</th><th>History</th><th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while($row = $patients->fetch_assoc()): ?>
                    <tr>
                        <td><?= $row['p_name'] ?></td>
                        <td><?= $row['gender'] ?></td>
                        <td><?= $row['age'] ?></td>
                        <td><?= $row['phoneno'] ?></td>
                        <td><?= $row['email'] ?></td>
                        <td><?= $row['address'] ?></td>
                        <td><?= $row['patient_history'] ?></td>
                        <td>
                            <a href="?edit=<?= $row['p_id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="?delete=<?= $row['p_id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this patient?')">Delete</a>
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