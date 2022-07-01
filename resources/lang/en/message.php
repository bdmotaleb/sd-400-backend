<?php
return [
    'failed'      => 'Something went wrong, Please try again.',
    'foreign_key' => 'Cannot delete or update a parent row: a foreign key constraint fails',
    'user'        => [
        "create" => [
            "error"   => "Oops! Unable to create a new user.",
            "success" => "Yay! A User has been successfully created.",
        ],
        "update" => [
            "error"   => "Oops! Unable to update user.",
            "success" => "Yay! A User has been successfully updated.",
        ],
        "manage" => [
            "deleted"   => "Yay! A User has been successfully deleted!",
            "not_found" => "Oops! User not found."
        ]
    ],
    'member'      => [
        "create" => [
            "error"   => "Oops! Unable to create a new member.",
            "success" => "Yay! A Member has been successfully created.",
        ],
        "update" => [
            "error"   => "Oops! Unable to update member.",
            "success" => "Yay! A Member has been successfully updated.",
        ],
        "manage" => [
            "deleted"   => "Yay! A Member has been successfully deleted!",
            "not_found" => "Oops! Member not found."
        ]
    ],
    'invoice'     => [
        "create" => [
            "error"   => "Oops! Unable to create a new invoice.",
            "success" => "Yay! A Invoice has been successfully created.",
        ],
        "update" => [
            "error"   => "Oops! Unable to update invoice.",
            "success" => "Yay! A Invoice has been successfully updated.",
        ],
        "manage" => [
            "deleted"   => "Yay! A invoice has been successfully deleted!",
            "not_found" => "Oops! Invoice not found."
        ]
    ],
    'expense'     => [
        "create" => [
            "error"   => "Oops! Unable to create a new expense.",
            "success" => "Yay! A Expense has been successfully created.",
        ],
        "update" => [
            "error"   => "Oops! Unable to update expense.",
            "success" => "Yay! A Expense has been successfully updated.",
        ],
        "manage" => [
            "deleted"   => "Yay! A Expense has been successfully deleted!",
            "not_found" => "Oops! Expense not found."
        ]
    ]
];
