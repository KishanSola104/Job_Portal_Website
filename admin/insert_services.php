<?php
include '../includes/db_connect.php'; // adjust path if needed

// Service Data
$service_title = "Bar & Beverage Staff";
$service_short_desc = "Provide experienced bartenders, baristas, and beverage servers for hotels, restaurants, bars, and events.";

$service_long_desc = "
We provide skilled and professional bar and beverage service staff trained to deliver high standards of hospitality, guest interaction, and drink presentation.

Our Staffing Includes:
• Bartenders (Skilled & Flair Bartenders)
• Bar Assistants / Runners
• Baristas (Coffee Specialists)
• Wine & Beverage Service Staff
• Cocktail Makers & Mixology Trained Staff
• Event & Banquet Beverage Service Teams

Key Strengths:
• Knowledge of beverages, cocktails, blends & garnishing
• Ability to handle busy bar counters with efficiency
• Strong customer engagement and guest interaction skills
• Maintains hygiene, cleanliness & proper glass handling standards
• Experience across hotel lounges, banquet bars, cafes & live events

Ideal For:
• Hotels & Resorts
• Restaurants & Lounges
• Nightclubs, Bars & Pubs
• Cafés & Coffee Shops
• Private Events & Corporate Functions
• Weddings & Banquet Functions

Our beverage service team ensures a memorable guest experience with professionalism, speed, and presentation excellence.
";

$service_image = "bar.webp"; // image must already exist in assets/images/

// Escape special chars for DB safety
$service_title = mysqli_real_escape_string($conn, $service_title);
$service_short_desc = mysqli_real_escape_string($conn, $service_short_desc);
$service_long_desc = mysqli_real_escape_string($conn, $service_long_desc);

// Insert Query
$query = "INSERT INTO services (service_title, service_short_desc, service_long_desc, service_image) 
VALUES ('$service_title', '$service_short_desc', '$service_long_desc', '$service_image')";

if(mysqli_query($conn, $query)) {
    echo "<h3 style='color:green;'>✅ Service Inserted Successfully!</h3>";
} else {
    echo "<h3 style='color:red;'>❌ Error: " . mysqli_error($conn) . "</h3>";
}
?>
