<?php 
if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin'){
    header('Location: /login');
    exit();
}
?>



    <aside class="sidebar" id="sidebar">
            <div class="logo">
                <img src="../images/keyce_logo.png" alt="School Logo">
                <h2>School Dashboard</h2>
            </div>
            <nav>
                <ul>
                    <li ><a href="/admin" id="nav-dashboard" data-translate="dash"><i class="fas fa-home"></i> </a></li>
                    <li><a href="/students" id="nav-students"><i class="fas fa-user-graduate"></i> Etudiants</a></li>
                    <li><a href="/teachers" id="nav-teachers"><i class="fas fa-chalkboard-teacher"></i> Enseignants</a></li>
                    <li><a href="/subjects" id="nav-subjects"><i class="fas fa-book"></i> Matières</a></li>
                    <li><a href="/classes" id="nav-classes"><i class="fas fa-calendar-alt"></i> Classes</a></li>
                    <li><a href="/payments" id="nav-payments"><i class="fa-solid fa-credit-card"></i> Versements</a></li>
                    <li><a href="/bulletins" id="nav-bulletins"><i class="fas fa-chart-bar"></i> Manage Bulletins</a></li>
                    <li><a href="/logout"><i class="fa-solid fa-right-from-bracket"></i> Logout</a></li>
                </ul>
            </nav>
        </aside>

