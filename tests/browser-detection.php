<?php
    
// $user_agent = $_SERVER['HTTP_USER_AGENT'];

// if (strpos($user_agent, 'MSIE') !== false) {
//     // Internet Explorer browser detected
//     if (preg_match('/MSIE (\d+\.\d+);/', $user_agent, $matches)) {
//         $version = $matches[1];
//         if ($version < 9) {
//             // Browser version not supported
//             echo "<p style='color:red;'>This website does not support Internet Explorer versions less than 9.</p>";
//         }
//     }
// } elseif (strpos($user_agent, 'Firefox') !== false) {
//     // Firefox browser detected
//     if (preg_match('/Firefox\/(\d+\.\d+)/', $user_agent, $matches)) {
//         $version = $matches[1];
//         if ($version < 10) {
//             // Browser version not supported
//             echo "<p style='color:red;'>This website does not support Firefox versions less than 10.</p>";
//         }
//     }
// } else {
//     // Other browser detected
//     echo "<p style='color:orange;'>This website works best with Internet Explorer or Firefox.</p>";
// }
$user_agent = $_SERVER['HTTP_USER_AGENT'];

if (strpos($user_agent, 'Chrome') !== false) {
    // Google Chrome browser detected
    if (preg_match('/Chrome\/(\d+\.\d+)/', $user_agent, $matches)) {
        $version = $matches[1];
        if ($version < 20) {
            // Browser version not supported
            echo "This website does not support Google Chrome versions less than 20.";
        }
    }
} elseif (strpos($user_agent, 'Safari') !== false) {
    // Safari browser detected
    if (preg_match('/Version\/(\d+\.\d+)/', $user_agent, $matches)) {
        $version = $matches[1];
        if ($version < 6) {
            // Browser version not supported
            echo "This website does not support Safari versions less than 6.";
        }
    }
} elseif (strpos($user_agent, 'Firefox') !== false) {
    // Firefox browser detected
    if (preg_match('/Firefox\/(\d+\.\d+)/', $user_agent, $matches)) {
        $version = $matches[1];
        if ($version < 10) {
            // Browser version not supported
            echo "This website does not support Firefox versions less than 10.";
        }
    }
} elseif (strpos($user_agent, 'MSIE') !== false) {
    // Internet Explorer browser detected
    if (preg_match('/MSIE (\d+\.\d+);/', $user_agent, $matches)) {
        $version = $matches[1];
        if ($version < 9) {
            // Browser version not supported
            echo "This website does not support Internet Explorer versions less than 9.";
        }
    }
} elseif (strpos($user_agent, 'Brave') !== false) {
    // Brave browser detected
    if (preg_match('/Brave\/(\d+\.\d+)/', $user_agent, $matches)) {
        $version = $matches[1];
        if ($version < 1.0) {
            // Browser version not supported
            echo "This website does not support Brave versions less than 1.0.";
        }
    }
} else {
    // Other browser detected
    echo "This website works best with Google Chrome, Safari, Firefox, Internet Explorer, or Brave.";
}


