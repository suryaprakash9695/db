<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../styles/login.css">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Admin Dashboard</h1>
            <a href="logout.php" class="btn btn-danger">Logout</a>
        </div>

        <div class="row">
            <!-- Doctors Section -->
            <div class="col-md-6">
                <div class="card border-primary mb-4">
                    <div class="card-header bg-primary text-white">
                        <h3 class="card-title">Doctors</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Dr. John Doe</td>
                                    <td>john@example.com</td>
                                    <td>******</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                                <!-- Add more static doctor rows as needed -->
                            </tbody>
                        </table>
                        <form class="mt-3">
                            <h4>Add Doctor</h4>
                            <input type="text" placeholder="Name" class="form-control mb-2" required>
                            <input type="email" placeholder="Email" class="form-control mb-2" required>
                            <input type="password" placeholder="Password" class="form-control mb-2" required>
                            <button type="submit" class="btn btn-primary">Add Doctor</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Patients Section -->
            <div class="col-md-6">
                <div class="card border-success mb-4">
                    <div class="card-header bg-success text-white">
                        <h3 class="card-title">Patients</h3>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Password</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Jane Smith</td>
                                    <td>jane@example.com</td>
                                    <td>******</td>
                                    <td>
                                        <button class="btn btn-warning btn-sm">Edit</button>
                                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                                    </td>
                                </tr>
                                <!-- Add more static patient rows as needed -->
                            </tbody>
                        </table>
                        <form class="mt-3">
                            <h4>Add Patient</h4>
                            <input type="text" placeholder="Name" class="form-control mb-2" required>
                            <input type="email" placeholder="Email" class="form-control mb-2" required>
                            <input type="password" placeholder="Password" class="form-control mb-2" required>
                            <button type="submit" class="btn btn-primary">Add Patient</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/jquery/jquery.min.js"></script>
    <script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>

</html>