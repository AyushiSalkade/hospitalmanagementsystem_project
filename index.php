<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Hospital Management System</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Header Section -->
    <header>
        <h1>Welcome to Our Hospital</h1>
        <nav>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="login.php">Login</a></li>
                <li><a href="admin.php">Admin</a></li>
                <li class="register-btn">
                    <a href="#" onclick="toggleRegisterOptions()">Register</a>
                    <div id="register-options" class="hidden">
                        <a href="patientreg1.html">Register as Patient</a>
                        <a href="doctorreg.html">Register as Doctor</a>
                    </div>
                </li>
                <li><a href="about.html">About Us</a></li>

                
                <!--<li><a href="contact.html">Contact Us</a></li>-->
            </ul>
        </nav>
    </header>
    
        
   

    <!--Hero Section -->
    <section class="hero">
        <h2>Providing Quality Healthcare</h2>
        <p>Book an appointment with our expert doctors and get the best treatment.</p>
        
    </section>
    
   

    <!-- Services Section -->
    <section class="services">
        <h2>Our Services</h2>
        <div class="service-box">
            <div class="service">
                <h3>24/7 Emergency</h3>
                <p>We provide round-the-clock emergency services for patients.</p>
            </div>
            <div class="service">
                <h3>Specialist Doctors</h3>
                <p>Consult highly qualified and experienced doctors.</p>
            </div>
            <div class="service">
                <h3>Online Appointments</h3>
                <p>Schedule an appointment from the comfort of your home.</p>
            </div>
        </div>
    </section>
    <section class="doctors">
        <h2>Meet Our Doctors</h2>
        <div class="doctor-container">
            <div class="doctor-card">
                <img src="images/Docimage1.jpeg" alt="Dr. Rahul Verma">
                <h3>Dr. Rahul Verma</h3>
                <p>Cardiologist</p>
                <a href="doctor1-profile.html" class="btn">View Profile</a>
            </div>
            <div class="doctor-card">
                <img src="images/Docimage2.jpeg" alt="Dr. Aisha Sharma">
                <h3>Dr. Aisha Sharma</h3>
                <p>Neurologist</p>
                <a href="doctor2-profile.html" class="btn">View Profile</a>
            </div>
            <div class="doctor-card">
                <img src="images/Docimage3.jpeg" alt="Dr. Ankit Kapoor">
                <h3>Dr. Ankit Kapoor</h3>
                <p>Orthopedic Surgeon</p>
                <a href="doctor3-profile.html" class="btn">View Profile</a>
            </div>
        </div>
    </section>

    

    <!-- Testimonials Section -->
    <section class="testimonials">
        <h2>What Our Patients Say</h2>
        <p>"Great service! The doctors are very professional and caring." - John Doe</p>
        <p>"Easy appointment booking and excellent facilities." - Jane Smith</p>
    </section>

    <!-- Footer Section -->
    <footer>
        <p>&copy; 2025 Online Hospital Management System | Contact: +123 456 7890</p>
    </footer>
    <script src="home.js"></script>
    
    <a href="login.php" class="btn">Login </a>
    
       

</body>
</html>
