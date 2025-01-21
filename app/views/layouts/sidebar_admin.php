<?php
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: /login');
    exit();
}
?>
<aside class="sidebar" id="sidebar">
    <div class="logo">
        <img src="../images/keyce_logo.png" alt="School Logo">
        <h2 data-translate="admin_dash"></h2>
    </div>
    <nav>
        <ul>
            <li><a href="/admin" id="nav-dashboard"><i class="fas fa-home"></i> <span data-translate="dash"></span></a>
            </li>
            <li><a href="/students" id="nav-students"><i class="fas fa-user-graduate"></i> <span
                        data-translate="student"></span></a></li>
            <li><a href="/teachers" id="nav-teachers"><i class="fas fa-chalkboard-teacher"></i> <span
                        data-translate="teacher"></span></a></li>
            <li><a href="/subjects" id="nav-subjects"><i class="fas fa-book"></i> <span
                        data-translate="subject"></span></a></li>
            <li><a href="/classes" id="nav-classes"><i class="fas fa-calendar-alt"></i> <span
                        data-translate="class"></span></a></li>
            <li><a href="/payments" id="nav-payments"><i class="fa-solid fa-credit-card"></i> <span
                        data-translate="payment"></span></a></li>
            <li><a href="/bulletins" id="nav-bulletins"><i class="fa-solid fa-graduation-cap"></i> <span
                        data-translate="bulletin"></span></a></li>
            <li><a href="/classement" id="nav-classement"><i class="fa-solid fa-graduation-cap"></i> <span
                        data-translate="classement">Classement</span></a></li>
            <li><a href="/logout"><i class="fa-solid fa-right-from-bracket"></i> <span
                        data-translate="logout"></span></a></li>
        </ul>
    </nav>
</aside>