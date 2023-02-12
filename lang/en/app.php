<?php

/*
|--------------------------------------------------------------------------
| Application Language Lines
|--------------------------------------------------------------------------
|
| The following language lines are used for the Application.
|
*/

return [

    'jetstream' => [

        'Forgot Password' => 'Forgot Password',
        'Two-factor Confirmation' => 'Two-factor Confirmation',
        'Email Verification' => 'Email Verification',

    ],

    'general' => [

        'attributes' => [

            'id' => [
                'label' => 'ID',
                'helper' => '',
                'hint' => '',
            ],

            'name' => [
                'label' => 'Name',
                'helper' => '',
                'hint' => '',
            ],

            'created_at' => [
                'label' => 'Created at',
                'helper' => '',
                'hint' => '',
            ],

            'updated_at' => [
                'label' => 'Updated at',
                'helper' => '',
                'hint' => '',
            ],

        ],

    ],

    'models' => [

        'ssh_key' => [

            'label' => 'SSH Key',
            'plural_label' => 'SSH Keys',
            'navigation_group' => 'Content',

            'attributes' => [

                'public_file' => [
                    'label' => 'Public Key File',
                    'helper' => 'This is the public key generated for access on your server. It is only used to shutdown the server remotely via this application using the provided shutdown command set on the computer. To add this to your server google "[server] ssh key access".',
                    'hint' => '',
                ],

                'private_file' => [
                    'label' => 'Private Key File',
                    'helper' => '',
                    'hint' => '',
                ],

            ],

        ],

        'computer' => [

            'label' => 'Computer',
            'plural_label' => 'Computers',
            'navigation_group' => 'Content',

            'attributes' => [

                'mac_address' => [
                    'label' => 'MAC Address',
                    'helper' => '',
                    'hint' => '',
                ],

                'ip_address' => [
                    'label' => 'IP Address',
                    'helper' => '',
                    'hint' => '',
                ],

                'ssh_user' => [
                    'label' => 'SSH User',
                    'helper' => '',
                    'hint' => '',
                ],

                'ssh_shutdown_command' => [
                    'label' => 'SSH Shutdown Command',
                    'helper' => '',
                    'hint' => '',
                ],

            ],

            'relations' => [

                'ssh_key' => [
                    'label' => 'SSH Key',
                    'helper' => '',
                    'hint' => '',
                ],

            ],

        ],

        'user' => [

            'label' => 'User',
            'plural_label' => 'Users',
            'navigation_group' => 'Authorization',

            'attributes' => [

                'email' => [
                    'label' => 'Email',
                    'helper' => '',
                    'hint' => '',
                ],

                'email_verified_at' => [
                    'label' => 'Email verified at',
                    'helper' => '',
                    'hint' => '',
                ],

                'password' => [
                    'label' => 'Password',
                    'helper' => '',
                    'hint' => '',
                ],

                'name' => [
                    'label' => 'Name',
                    'helper' => '',
                    'hint' => '',
                ],

            ],

            'relations' => [

                'roles' => [
                    'label' => 'Roles',
                    'helper' => '',
                    'hint' => '',
                ],

                'links' => [
                    'label' => 'Links',
                    'helper' => '',
                    'hint' => '',
                ],

            ],

        ],

        'permission' => [

            'label' => 'Permission',
            'plural_label' => 'Permissions',
            'navigation_group' => 'Authorization',

            'attributes' => [

                'guard_name' => [
                    'label' => 'Guard name',
                    'helper' => '',
                    'hint' => '',
                ],

            ],

            'relations' => [

                'roles' => [
                    'label' => 'Roles',
                    'helper' => '',
                    'hint' => '',
                ],

            ],

        ],

        'role' => [

            'label' => 'Role',
            'plural_label' => 'Roles',
            'navigation_group' => 'Authorization',

            'attributes' => [

                'guard_name' => [
                    'label' => 'Guard name',
                    'helper' => '',
                    'hint' => '',
                ],

            ],

            'relations' => [

                'permissions' => [
                    'label' => 'Permissions',
                    'helper' => '',
                    'hint' => '',
                ],

            ],

        ],

    ],

    'filament' => [

        'navigation_groups' => [

            'content' => [
                'label' => 'Content',
            ],

            'authorization' => [
                'label' => 'Authorization',
            ],

        ],

        'forms' => [

            'actions' => [

                'create_and_back' => [
                    'label' => 'Create & back',
                ],

                'save_and_back' => [
                    'label' => 'Save & back',
                ],

            ],

            'sections' => [

                'authorization' => [
                    'label' => 'Authorization',
                ],

                'metadata' => [
                    'label' => 'Metadata',
                ],

                'general_information' => [
                    'label' => 'General information',
                ],

                'data' => [
                    'label' => 'Data',
                ],

                'statistics' => [
                    'label' => 'Statistics',
                ],

                'additional_information' => [
                    'label' => 'Additional information',
                ],

                'ssh_information' => [
                    'label' => 'Remote shutdown SSH information',
                ],

            ],

        ],

        'tables' => [

            'filters' => [

                'verified' => [
                    'label' => 'Verified',
                    'placeholder' => 'All',
                    'true_label' => 'Verified',
                    'false_label' => 'Unverified',
                ],

                'show' => [
                    'label' => 'Show',
                    'placeholder' => 'All',
                    'true_label' => 'Is showing',
                    'false_label' => 'Is hidden',
                ],

            ],

        ],

    ],

    'other' => [

        'yes' => 'Yes',
        'no' => 'No',

    ],

];
