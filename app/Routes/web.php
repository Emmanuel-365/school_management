<?php

$routes = [
    "/" => "home.php",
    '/login' => 'users/login.php',
    '/logout' => 'users/logout.php',
    '/change_password' => 'users/change_password.php',

    '/admin/' => 'admin/index.php', 
    '/admin' => 'admin/index.php',  

    '/student' => 'student/index.php',
    '/profil' => 'student/profil.php',

    '/teacher' => 'teacher/index.php',
    '/teacher_card' => 'teacher/teacher_card.php', 

    '/students' => 'students/read.php',  
    '/students/create' => 'students/create.php',  
    '/students/update' => 'students/update.php',  
    '/students/delete' => 'students/delete.php',  
    '/student_card' => 'student/student_card.php',
    '/search_student' => 'students/search_student.php',
    '/chatbot' => 'student/chatbot.php',

    '/teachers' => 'teachers/read.php',
    '/teachers/update' => 'teachers/update.php',
    '/teachers/delete' => 'teachers/delete.php',
    '/teachers/create' => 'teachers/create.php',

    '/subjects' => 'subjects/read.php',
    '/subjects/update' => 'subjects/update.php',
    '/subjects/delete' => 'subjects/delete.php',
    '/subjects/create' => 'subjects/create.php',

    '/classes' => 'classes/read.php',
    '/classes/update' => 'classes/update.php',
    '/classes/delete' => 'classes/delete.php',
    '/classes/create' => 'classes/create.php',

    '/payments' => 'payments/read.php',
    '/payments/create' => 'payments/create.php',

    '/grades' => 'grades/read.php',
    '/grades/update' => 'grades/update.php',
    '/grades/delete' => 'grades/delete.php',
    '/grades/create' => 'grades/create.php',

    '/bulletins' => 'bulletins/read.php',
    '/bulletins/bulletin' => 'bulletins/bulletin.php',
    '/bulletins/update' => 'bulletins/update.php',
    '/bulletins/delete' => 'bulletins/delete.php',
    '/bulletins/create' => 'bulletins/create.php',

    '/send_mail' => 'bulletins/send_mail.php',
    '/savepdf' => 'bulletins/save_and_sign_pdf.php',





];

return $routes;
