<?php
    if (session_status() == PHP_SESSION_NONE) session_start();
?>


    <aside class="sidebar" id="sidebar">
            <div class="logo">
                <img src="../images/keyce_logo.png" alt="School Logo">
                <h2>Student Dashboard</h2>
            </div>
            <nav>
                <ul>
                    <li><a href="/student" id="nav-dashboard"><i class="fas fa-home"></i>Dashboard</a></li>

                    <li><a href="student_card" id="nav-studentCard"><i class="fa-solid fa-user"></i> Student information card</a></li>

                    <li><a href="/profil" id="nav-studentInfo"><i class="fas fa-user-graduate"></i>View Profile</a></li>

                    <li><a href="/grades?student_id=<?php echo $_SESSION['user_id']; ?>" id="nav-studentGrade"><i class="fas fa-book"></i>View Grades</a></li>

                    <li><a href="/payments?student_id=<?php echo $_SESSION['user_id']; ?>" id="nav-studentPayment"><i class="fa-solid fa-credit-card"></i>View payments</a></li>

                    <li><a href="/bulletins?student_id=<?php echo $_SESSION['user_id']; ?>" id="nav-bulletins"><i class="fa-solid fa-graduation-cap"></i> View Bulletins</a></li>

                    <li><a href="/logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                </ul>
            </nav>
        </aside>

