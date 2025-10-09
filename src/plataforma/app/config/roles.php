<?php

return [
    'admin' => [
        'name' => 'Administrador',
        'permissions' => [
            'manage_users',
            'manage_courses',
            'manage_announcements',
            'manage_scholarships',
            'view_all_grades',
            'manage_surveys'
        ]
    ],
    'capturista' => [
        'name' => 'Capturista',
        'permissions' => [
            'manage_grades',
            'view_courses',
            'view_students'
        ]
    ],
    'teacher' => [
        'name' => 'Docente',
        'permissions' => [
            'manage_own_courses',
            'manage_grades',
            'create_announcements',
            'view_schedule'
        ]
    ],
    'student' => [
        'name' => 'Estudiante',
        'permissions' => [
            'view_own_grades',
            'view_own_courses',
            'view_announcements',
            'view_scholarships',
            'take_surveys',
            'view_schedule'
        ]
    ]
];
