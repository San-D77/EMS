<?php

return [
    "enable_2fa" => false,
    "designations" => [
        "trainee",
        "writer",
        "senior-writer",
        "editor",
        "senior-editor",
        "site-manager",
        "superviser",
        "hr-manager",
    ],
    "employment_types" => [
        "full-time",
        "part-time"
    ],
    "nepali_months" => [
        "Baishakh",
        "Jeshth",
        "Asar",
        "Shrawan",
        "Bhadra",
        "Ashwin",
        "Kartik",
        "Mangshir",
        "Poush",
        "Magh",
        "Falgun",
        "Chaitra"
    ],

    "sidebar_components" => [
        'dashboard' => [
            'hasChildren' => 'false',
            'name' => 'dashboard',
            'route' => 'backend.dashboard',
            'parameter' => false,
            'icon' => 'box',
            'roles' => [
                'superadmin',
                'admin',
                'superviser',
                'maintainer',
                'user'
            ]
        ],
        'users' => [
            'hasChildren' => "true",
            'name' => 'users',
            'icon' => 'users',
            'roles' => [
                'superadmin',
                'admin',
                'superviser',
            ],
            'children' => [
                [
                    'name' => 'All Users',
                    'route' => 'backend.user-view',
                    'parameter' => false,
                    'roles' => [
                        'superadmin',
                        'admin',
                        'superviser',
                    ]
                ],
                [
                    'name' => 'Add New',
                    'route' => 'backend.user-create',
                    'parameter' => false,
                    'roles' => [
                        'superadmin',
                        'admin',
                    ]
                ]
            ]
        ],
        'role' => [
            'hasChildren' => "true",
            'name' => 'role',
            'icon' => 'feather',
            'roles' => [
                'superadmin',
            ],
            'children' => [
                [
                    'name' => 'Roles',
                    'route' => 'backend.role-view',
                    'parameter' => false,
                    'roles' => [
                        'superadmin',
                    ]
                ],
                [
                    'name' => 'Add New',
                    'route' => 'backend.role-create',
                    'parameter' => false,
                    'roles' => [
                        'superadmin',
                    ]
                ]
            ]
        ],
        'permission' => [
            'hasChildren' => "true",
            'name' => 'permission',
            'icon' => 'layers',
            'roles' => [
                'superadmin',
            ],
            'children' => [
                [
                    'name' => 'Permissions',
                    'route' => 'backend.permission-view',
                    'parameter' => false,
                    'roles' => [
                        'superadmin',
                    ]
                ],
                [
                    'name' => 'Add New',
                    'route' => 'backend.permission-create',
                    'parameter' => false,
                    'roles' => [
                        'superadmin',
                    ]
                ],
            ]
        ],
        'calendar' => [
            'hasChildren' => "true",
            'name' => 'calendar',
            'icon' => 'calendar',
            'roles' => [
                'superadmin',
                'admin',
                'superviser',
                'maintainer',
                'user'
            ],
            'children' => [
                [
                    'name' => 'Dates',
                    'route' => 'backend.calendar-index',
                    'parameter' => false,
                    'roles' => [
                        'superadmin',
                        'admin',
                        'superviser',
                        'maintainer',
                    ]
                ],
                [
                    'name' => 'Add New',
                    'route' => 'backend.calendar-create',
                    'parameter' => false,
                    'roles' => [
                        'superadmin',
                        'admin',
                    ]
                ],
                [
                    'name' => 'Public Holidays',
                    'route' => 'backend.calendar-public_holiday_index',
                    'parameter' => false,
                    'roles' => [
                        'superadmin',
                        'admin',
                        'superviser',
                        'maintainer',
                        'user'
                    ]
                ]
            ]
        ],
        'leave' => [
            'hasChildren' => "true",
            'name' => 'leave',
            'icon' => 'inbox',
            'roles' => [
                'superadmin',
                'admin',
                'superviser',
                'maintainer',
                'user'
            ],
            'children' => [
                [
                    'name' => 'Approvals',
                    'route' => 'backend.leave-index',
                    'parameter' => false,
                    'roles' => [
                        'superadmin',
                        'admin',
                        'superviser',
                    ]
                ],
                [
                    'name' => 'Apply for Leave',
                    'route' => 'backend.leave-create',
                    'parameter' => false,
                    'roles' => [
                        'superadmin',
                        'admin',
                        'superviser',
                        'maintainer',
                        'user'
                    ]
                ],
                [
                    'name' => 'Your Leaves',
                    'route' => 'backend.leave-individual',
                    'parameter' => true,
                    'roles' => [
                        'superadmin',
                        'admin',
                        'superviser',
                        'maintainer',
                        'user'
                    ]
                ]
            ]
        ],
        'notice' => [
            'hasChildren' => "true",
            'name' => 'notice',
            'icon' => 'bell',
            'roles' => [
                'superadmin',
                'admin',
                'superviser',
                'maintainer',
                'user'
            ],
            'children' => [
                [
                    'name' => 'Make Announcement',
                    'route' => 'backend.notice-create',
                    'parameter' => false,
                    'roles' => [
                        'superadmin',
                        'admin',
                    ]
                ],
                [
                    'name' => 'Notice',
                    'route' => 'backend.notice-view',
                    'parameter' => false,
                    'roles' => [
                        'superadmin',
                        'admin',
                        'superviser',
                        'maintainer',
                        'user'
                    ]
                ],
            ]
        ],
        'attendance' => [
            'hasChildren' => 'false',
            'name' => 'attendance',
            'route' => 'backend.attendance-view',
            'parameter' => false,
            'icon' => 'clipboard',
            'roles' => [
                'superadmin',
                'admin',
                'superviser',
                'maintainer',
                'user'
            ]
        ],
        'reports' => [
            'hasChildren' => 'false',
            'name' => 'reports',
            'route' => 'backend.attendance-view_reports',
            'parameter' => false,
            'icon' => 'book-open',
            'roles' => [
                'superadmin',
                'admin',
                'superviser',
            ]
        ],
        'today' => [
            'hasChildren' => 'false',
            'name' => 'today',
            'route' => 'backend.attendance-today',
            'parameter' => false,
            'icon' => 'loader',
            'roles' => [
                'superadmin',
                'admin',
                'superviser',
            ]
        ],
    ],

    "roles_to_check" => [
        'backend.user-view',
        'backend.user-create',
        'backend.role-view',
        'backend.role-create',
        'backend.permission-view',
        'backend.permission-create',
        'backend.calendar-index',
        'backend.calendar-create',
        'backend.calendar-public_holiday_index',
        'backend.leave-index',
        'backend.leave-create',
        'backend.leave-individual',
        'backend.notice-create',
        'backend.notice-view',
        'backend.attendance-view',
        'backend.attendance-view_reports',
        'backend.attendance-today'
    ]
];
