<?php
// Define user levels
$user_levels = [
    9 => 'Super Admin',
    8 => 'Admin',
    7 => 'Manager',
    6 => 'Quality Analyst',
    2 => 'Team Leader',
    1 => 'Agent'
];

// Get current user level
$current_user_level = $user_level ?? 1; // Default to Agent if not set

// Sidebar items based on user level
$sidebar_items = [
    'common' => [
        [
            'link' => '?c=dashboard&v=index',
            'icon' => 'fa-th-large',
            'label' => 'Overview'
        ],
        [
            'link' => '?c=user&v=user_profile',
            'icon' => 'fa-user-circle-o',
            'label' => 'Profile'
        ]
    ],
    9 => [ // Super Admin
        [
            'link' => '?c=user&v=telephony_user',
            'icon' => 'fa-user-plus',
            'label' => 'User'
        ]
    ],
    'admin_manager' => [ // Admin and Manager
        [
            'link' => '?c=campaign&v=campaign_list',
            'icon' => 'fa-list',
            'label' => 'Campaigns'
        ],
        [
            'link' => '?c=user_group&v=show_user_group',
            'icon' => 'fa-users',
            'label' => 'Extensions'
        ]
    ],
    'restricted' => [ // Accessible to all except Super Admin
        [
            'link' => '?c=lists&v=lists_list',
            'icon' => 'fa-upload',
            'label' => 'Data Upload'
        ],
        [
            'link' => '?c=dashboard&v=block_no',
            'icon' => 'fa-ban',
            'label' => 'Block Number'
        ],
        [
            'link' => '?c=dashboard&v=disposition',
            'icon' => 'fa-plus-square',
            'label' => 'Dispositions'
        ],
        [
            'link' => '?c=dashboard&v=ivr_converter',
            'icon' => 'fa-volume-control-phone',
            'label' => 'IVR Converter'
        ]
    ]
];

function renderSidebar($current_user_level, $user_levels, $sidebar_items) {
    $output = "<div id=\"mySidebar\" class=\"sidebar\">\n";
    $output .= "<div class=\"dashboard-sidedrawer\">\n";
    $output .= "<img src=\"../assets/images/dashboard/next2calld.png\" alt=\"\">\n";
    $output .= "<h2>{$user_levels[$current_user_level]}</h2>\n";

    foreach ($sidebar_items['common'] as $item) {
        $output .= renderSidebarItem($item);
    }

    if ($current_user_level == 9) {
        foreach ($sidebar_items[9] as $item) {
            $output .= renderSidebarItem($item);
        }
    } elseif (in_array($current_user_level, [8, 7])) {
        foreach ($sidebar_items['admin_manager'] as $item) {
            $output .= renderSidebarItem($item);
        }
    }

    if ($current_user_level != 9) {
        foreach ($sidebar_items['restricted'] as $item) {
            $output .= renderSidebarItem($item);
        }
    }

    $output .= "</div></div>";
    return $output;
}

function renderSidebarItem($item) {
    return "<a href=\"{$item['link']}\" class=\"text_color\"><i class=\"fa {$item['icon']} cursor_p\" aria-hidden=\"true\"></i> {$item['label']}</a>\n";
}

// Render the sidebar
echo renderSidebar($current_user_level, $user_levels, $sidebar_items);
?>

<!-- Super Admin Page -->
<?php if ($current_user_level == 9): ?>
<div class="super-admin-page">
    <h1>Access Management</h1>
    <form method="POST" action="manage_access.php">
        <!-- Form for managing access -->
        <label for="user_level">User Level:</label>
        <select name="user_level" id="user_level">
            <?php foreach ($user_levels as $level => $label): ?>
                <option value="<?php echo $level; ?>"><?php echo $label; ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Save</button>
    </form>
</div>
<?php endif; ?>
