<?php
require_once 'db.php';
$destination = isset($_GET['destination']) ? $_GET['destination'] : '';
$checkin = isset($_GET['checkin']) ? $_GET['checkin'] : '';
$checkout = isset($_GET['checkout']) ? $_GET['checkout'] : '';
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'price_asc';
$price_range = isset($_GET['price_range']) ? $_GET['price_range'] : '';
$rating = isset($_GET['rating']) ? $_GET['rating'] : '';
 
$sql = "SELECT * FROM hotels WHERE city LIKE ?";
$params = ["%$destination%"];
if ($price_range) {
    $price_parts = explode('-', $price_range);
    $sql .= " AND price_per_night BETWEEN ? AND ?";
    $params[] = $price_parts[0];
    $params[] = $price_parts[1];
}
if ($rating) {
    $sql .= " AND rating >= ?";
    $params[] = $rating;
}
if ($sort == 'price_asc') {
    $sql .= " ORDER BY price_per_night ASC";
} elseif ($sort == 'price_desc') {
    $sql .= " ORDER BY price_per_night DESC";
} elseif ($sort == 'rating') {
    $sql .= " ORDER BY rating DESC";
}
 
$stmt = $conn->prepare($sql);
$stmt->execute($params);
$hotels = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Listings</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .filters {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .filters select, .filters button {
            padding: 10px;
            margin: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .filters button {
            background: #ff6f61;
            color: white;
            border: none;
            cursor: pointer;
        }
        .filters button:hover {
            background: #e55a50;
        }
        .hotel-list {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .hotel-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            width: calc(33% - 20px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .hotel-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .hotel-card h3, .hotel-card p {
            padding: 10px;
        }
        .book-btn {
            display: block;
            margin: 10px;
            padding: 10px;
            background: #ff6f61;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
        }
        .book-btn:hover {
            background: #e55a50;
        }
        @media (max-width: 768px) {
            .hotel-card {
                width: calc(50% - 20px);
            }
        }
        @media (max-width: 480px) {
            .hotel-card {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Available Hotels in <?php echo htmlspecialchars($destination); ?></h2>
        <div class="filters">
            <form id="filterForm">
                <select name="sort">
                    <option value="price_asc" <?php if ($sort == 'price_asc') echo 'selected'; ?>>Price: Low to High</option>
                    <option value="price_desc" <?php if ($sort == 'price_desc') echo 'selected'; ?>>Price: High to Low</option>
                    <option value="rating" <?php if ($sort == 'rating') echo 'selected'; ?>>Best Rated</option>
                </select>
                <select name="price_range">
                    <option value="">All Prices</option>
                    <option value="0-100" <?php if ($price_range == '0-100') echo 'selected'; ?>>$0 - $100</option>
                    <option value="100-200" <?php if ($price_range == '100-200') echo 'selected'; ?>>$100 - $200</option>
                    <option value="200-500" <?php if ($price_range == '200-500') echo 'selected'; ?>>$200 - $500</option>
                </select>
                <select name="rating">
                    <option value="">All Ratings</option>
                    <option value="3" <?php if ($rating == '3') echo 'selected'; ?>>3+ Stars</option>
                    <option value="4" <?php if ($rating == '4') echo 'selected'; ?>>4+ Stars</option>
                    <option value="5" <?php if ($rating == '5') echo 'selected'; ?>>5 Stars</option>
                </select>
                <button type="submit">Apply Filters</button>
            </form>
        </div>
        <div class="hotel-list">
            <?php foreach ($hotels as $hotel): ?>
                <div class="hotel-card">
                    <img src="<?php echo htmlspecialchars($hotel['image_url']); ?>" alt="<?php echo htmlspecialchars($hotel['name']); ?>">
                    <h3><?php echo htmlspecialchars($hotel['name']); ?></h3>
                    <p>$<?php echo $hotel['price_per_night']; ?>/night | ★<?php echo $hotel['rating']; ?></p>
                    <p><?php echo htmlspecialchars($hotel['amenities']); ?></p>
                    <a href="book.php?hotel_id=<?php echo $hotel['id']; ?>&checkin=<?php echo $checkin; ?>&checkout=<?php echo $checkout; ?>" class="book-btn">Book Now</a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
        document.getElementById('filterForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const params = new URLSearchParams();
            params.append('destination', '<?php echo addslashes($destination); ?>');
            params.append('checkin', '<?php echo $checkin; ?>');
            params.append('checkout', '<?php echo $checkout; ?>');
            for (let [key, value] of formData) {
                params.append(key, value);
            }
            window.location.href = `hotels.php?${params.toString()}`;
        });
    </script>
</body>
</html>
