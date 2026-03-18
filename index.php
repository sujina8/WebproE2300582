<?php
// index.php - EduSkill Homepage
// Author: Sujina
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduSkill - Online Learning Platform</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="assets/css/Sujina.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <a class="navbar-brand" href="index.php"><b>EduSkill</b></a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navMenu">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navMenu">
        <ul class="navbar-nav ml-auto mr-3">
            <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
            <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            <li class="nav-item"><a class="nav-link" href="#reviews">Reviews</a></li>
        </ul>

        <!-- Login / Signup dropdown -->
        <div class="dropdown">
            <button class="btn btn-login dropdown-toggle" type="button" id="authDropdown" data-toggle="dropdown">
                Login / Sign Up
            </button>
            <div class="dropdown-menu dropdown-menu-right">
                <h6 class="dropdown-header">Login As</h6>
                <a class="dropdown-item" href="student/login.php"><i class="fas fa-user-graduate mr-2"></i>Student Login</a>
                <a class="dropdown-item" href="provider/login.php"><i class="fas fa-chalkboard-teacher mr-2"></i>Provider Login</a>
                <a class="dropdown-item" href="admin/login.php"><i class="fas fa-user-shield mr-2"></i>Admin Login</a>
                <div class="dropdown-divider"></div>
                <h6 class="dropdown-header">New Here?</h6>
                <a class="dropdown-item" href="student/signup.php"><i class="fas fa-user-plus mr-2"></i>Student Sign Up</a>
                <a class="dropdown-item" href="provider/register.php"><i class="fas fa-building mr-2"></i>Provider Register</a>
            </div>
        </div>

    </div>
</nav>

<!-- Hero Section -->
<div class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-7">
                <h1>Learn New Skills Online</h1>
                <p class="lead">EduSkill is an online platform where students can find and enroll in courses offered by approved training providers in Malaysia.</p>
                <a href="student/signup.php" class="btn btn-main btn-lg mr-2">Get Started</a>
                <a href="about.php" class="btn btn-outline-main btn-lg">Learn More</a>
            </div>
            <div class="col-md-5 text-center mt-4 mt-md-0">
                <div class="hero-img-placeholder">
                    <i class="fas fa-graduation-cap fa-5x"></i>
                    <p class="mt-2">Add hero image here<br><small>assets/images/hero.jpg</small></p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- About Platform -->
<div class="container py-5">
    <div class="row align-items-center">
        <div class="col-md-6 mb-4 mb-md-0">
            <div class="about-img-placeholder">
                <i class="fas fa-image fa-3x text-muted"></i>
                <p class="mt-2 text-muted">Add image here<br><small>assets/images/about.jpg</small></p>
            </div>
        </div>
        <div class="col-md-6">
            <h2>What is EduSkill?</h2>
            <p class="text-muted">EduSkill is an online marketplace platform developed under the Ministry of Human Resources, Malaysia. It connects learners with trusted training providers.</p>
            <p class="text-muted">Students can browse available courses, enroll online, and track their enrollment status. Training providers can register and manage their course listings after getting approved by the admin.</p>
            <ul class="list-unstyled mt-3">
                <li class="mb-2"><i class="fas fa-check check-icon mr-2"></i> Approved training providers only</li>
                <li class="mb-2"><i class="fas fa-check check-icon mr-2"></i> Easy online enrollment</li>
                <li class="mb-2"><i class="fas fa-check check-icon mr-2"></i> Track your enrollment status</li>
                <li class="mb-2"><i class="fas fa-check check-icon mr-2"></i> Ministry certified courses</li>
            </ul>
        </div>
    </div>
</div>

<!-- How it Works -->
<div class="how-section py-5">
    <div class="container">
        <h2 class="text-center mb-4">How It Works</h2>
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="step-card p-4">
                    <i class="fas fa-user-plus fa-2x step-icon mb-3"></i>
                    <h5>Create Account</h5>
                    <p class="text-muted">Sign up as a student to get started.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="step-card p-4">
                    <i class="fas fa-search fa-2x step-icon mb-3"></i>
                    <h5>Browse Courses</h5>
                    <p class="text-muted">Find courses from verified providers.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="step-card p-4">
                    <i class="fas fa-graduation-cap fa-2x step-icon mb-3"></i>
                    <h5>Enroll and Learn</h5>
                    <p class="text-muted">Submit your enrollment and start learning.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Who Can Use -->
<div class="container py-5">
    <h2 class="text-center mb-4">Who Can Use EduSkill?</h2>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center p-3">
                <div class="card-body">
                    <i class="fas fa-user-graduate fa-3x role-icon mb-3"></i>
                    <h5 class="card-title">Students</h5>
                    <p class="card-text text-muted">Register, browse courses, and enroll. Check your enrollment status from your dashboard.</p>
                    <a href="student/signup.php" class="btn btn-main btn-sm">Sign Up</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center p-3">
                <div class="card-body">
                    <i class="fas fa-chalkboard-teacher fa-3x role-icon mb-3"></i>
                    <h5 class="card-title">Training Providers</h5>
                    <p class="card-text text-muted">Register your organisation and list your courses after getting approved by the Ministry.</p>
                    <a href="provider/register.php" class="btn btn-main btn-sm">Register</a>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card h-100 text-center p-3">
                <div class="card-body">
                    <i class="fas fa-user-shield fa-3x role-icon mb-3"></i>
                    <h5 class="card-title">Ministry Admin</h5>
                    <p class="card-text text-muted">Approve provider registrations and manage student enrollment requests.</p>
                    <a href="admin/login.php" class="btn btn-main btn-sm">Admin Login</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Reviews Section -->
<div class="reviews-section py-5" id="reviews">
    <div class="container">
        <h2 class="text-center mb-4">What Our Students Say</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="review-card p-4">
                    <div class="stars mb-2">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="review-text">"EduSkill made it really easy for me to find a good course. The enrollment process was simple and I got approved quickly."</p>
                    <div class="reviewer">
                        <div class="reviewer-avatar">A</div>
                        <div>
                            <strong>Ahmad Razif</strong>
                            <p class="mb-0 small text-muted">Web Development Course</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="review-card p-4">
                    <div class="stars mb-2">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                    </div>
                    <p class="review-text">"I registered as a training provider and the approval process was smooth. Now I have many students enrolled in my courses."</p>
                    <div class="reviewer">
                        <div class="reviewer-avatar">S</div>
                        <div>
                            <strong>Siti Nabilah</strong>
                            <p class="mb-0 small text-muted">Training Provider</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="review-card p-4">
                    <div class="stars mb-2">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <p class="review-text">"Great platform. I completed a digital marketing course and it really helped me in my career. Highly recommended!"</p>
                    <div class="reviewer">
                        <div class="reviewer-avatar">R</div>
                        <div>
                            <strong>Rajesh Kumar</strong>
                            <p class="mb-0 small text-muted">Digital Marketing Course</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Footer -->
<footer class="footer mt-2">
    <div class="container">
        <div class="row">
            <div class="col-md-4 mb-3">
                <h5><b>EduSkill</b></h5>
                <p class="small">An online skills marketplace by the Ministry of Human Resources, Malaysia.</p>
            </div>
            <div class="col-md-2 mb-3">
                <h6>Links</h6>
                <ul class="list-unstyled small">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="#reviews">Reviews</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-3">
                <h6>Get Started</h6>
                <ul class="list-unstyled small">
                    <li><a href="student/signup.php">Student Signup</a></li>
                    <li><a href="provider/register.php">Provider Register</a></li>
                    <li><a href="student/login.php">Student Login</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-3">
                <h6>Contact</h6>
                <p class="small mb-1"><i class="fas fa-envelope mr-1"></i> info@eduskill.gov.my</p>
                <p class="small mb-1"><i class="fas fa-phone mr-1"></i> +60 3-1234 5678</p>
                <p class="small"><i class="fas fa-map-marker-alt mr-1"></i> Putrajaya, Malaysia</p>
            </div>
        </div>
        <hr class="footer-hr">
        <p class="text-center small mb-0">&copy; 2024 EduSkill. Ministry of Human Resources, Malaysia.</p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="assets/js/Sujina.js"></script>
</body>
</html>
