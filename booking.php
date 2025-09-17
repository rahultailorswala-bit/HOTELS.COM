<?php
require_once 'db.php';
$hotel_id = isset($_GET['hotel_id']) ? (int)$_GET['hotel_id'] : 0;
$checkin = isset($_GET['checkin']) ? $_GET['checkin'] : '';
$checkout = isset($_GET['checkout']) ? $_GET['checkout'] : '';
 
if ($hotel_id <= 0 || !$checkin || !$checkout) {
    die("Invalid booking details. Please try again.");
}
 
$stmt = $conn->prepare("SELECT * FROM hotels WHERE id = ?");
$stmt->execute([$hotel_id]);
$hotel = $stmt->fetch(PDO::FETCH_ASSOC);
 
if (!$hotel) {
    die("Hotel not found. Please select a valid hotel.");
}
 
$confirmation = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_name = filter_var($_POST['user_name'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    if ($user_name && $email) {
        $stmt = $conn->prepare("INSERT INTO bookings (hotel_id, user_name, email, checkin_date, checkout_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$hotel_id, $user_name, $email, $checkin, $checkout]);
        $confirmation = "Booking confirmed for $user_name at {$hotel['name']} from $checkin to $checkout! Check your email ($email) for details.";
    } else {
        $confirmation = "Invalid name or email. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Hotel</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        form {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }
        input {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 16px;
        }
        button {
            padding: 10px;
            background: #ff6f61;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background: #e55a50;
        }
        .confirmation {
            color: green;
            font-weight: bold;
            margin-top: 20px;
        }
        .error {
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }
        @media (max-width: 480px) {
            .container {
                margin: 10px;
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Book <?php echo htmlspecialchars($hotel['name']); ?></h2>
        <?php if ($confirmation): ?>
            <p class="<?php echo strpos($confirmation, 'Invalid') === false ? 'confirmation' : 'error'; ?>"><?php echo $confirmation; ?></p>
        <?php else: ?>
            <form method="POST">
                <input type="text" name="user_name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <input type="text" value="<?php echo htmlspecialchars($checkin); ?>" readonly>
                <input type="text" value="<?php echo htmlspecialchars($checkout); ?>" readonly>
                <button type="submit">Confirm Booking</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>
