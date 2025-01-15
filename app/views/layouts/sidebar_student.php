<?php
    if (session_status() == PHP_SESSION_NONE) session_start();
?>
    <aside class="sidebar" id="sidebar">
            <div class="logo">
                <img src="../images/keyce_logo.png" alt="School Logo">
                <h2 data-translate="student_dash"></h2>
            </div>
            <nav>
                <ul>
                    <li><a href="/student" id="nav-dashboard"><i class="fas fa-home"></i><span data-translate="dash"></span></a></li>
                    <br>

                    <li><a href="student_card" id="nav-studentCard"><i class="fa-solid fa-user"></i> <span data-translate="student_card"></span></a></a></li>
                    <br>

                    <li><a href="/profil" id="nav-studentInfo"><i class="fas fa-user-graduate"></i><span data-translate="student_pro"></span></a></a></li>
                    <br>

                    <li><a href="/grades?student_id=<?php echo $_SESSION['user_id']; ?>" id="nav-studentGrade"><i class="fas fa-book"></i><span data-translate="student_grade"></span></a></a></li>
                    <br>

                    <li><a href="/payments?student_id=<?php echo $_SESSION['user_id']; ?>" id="nav-studentPayment"><i class="fa-solid fa-credit-card"></i><span data-translate="student_payment"></span></a></a></li>
                    <br>

                    <li><a href="/bulletins?student_id=<?php echo $_SESSION['user_id']; ?>" id="nav-bulletins"><i class="fa-solid fa-graduation-cap"></i> <span data-translate="student_bulletin"></span></a></a></li>
                    <br>

                    <li><a href="/logout"><i class="fa-solid fa-right-from-bracket"></i> <span data-translate="logout"></span></a></a></li>
                </ul>
            </nav>
        </aside>

