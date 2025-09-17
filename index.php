<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking - Homepage</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        header {
            background: #1a2a44;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .search-bar {
            background: white;
            padding: 20px;
            margin: 20px auto;
            max-width: 800px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.2);
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .search-bar input, .search-bar button {
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
        }
        .search-bar input {
            flex: 1;
            min-width: 200px;
            border: 1px solid #ddd;
        }
        .search-bar button {
            background: #ff6f61;
            color: white;
            cursor: pointer;
            transition: background 0.3s;
        }
        .search-bar button:hover {
            background: #e55a50;
        }
        .featured {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
        }
        .hotel-card {
            background: white;
            border-radius: 10px;
            overflow: hidden;
            margin: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            display: inline-block;
            width: calc(33% - 20px);
            vertical-align: top;
        }
        .hotel-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .hotel-card h3, .hotel-card p {
            padding: 10px;
        }
        @media (max-width: 768px) {
            .hotel-card {
                width: calc(50% - 20px);
            }
            .search-bar {
                flex-direction: column;
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
    <header>
        <h1>Hotel Booking Platform</h1>
    </header>
    <div class="search-bar">
        <form id="searchForm" action="hotels.php" method="GET">
            <input type="text" name="destination" placeholder="Enter destination" required>
            <input type="date" name="checkin" required>
            <input type="date" name="checkout" required>
            <button type="submit">Book Hotels</button>
        </form>
    </div>
    <div class="featured">
        <h2>Featured Hotels</h2>
        <div class="hotel-card">
            <img src="https://via.placeholder.com/300x200?text=Hotel+1" alt="Hotel 1">
            <h3>Luxury Resort</h3>
            <p>$200/night | ★★★★☆</p>
        </div>
        <div class="hotel-card">
            <img src="https://via.placeholder.com/300x200?text=Hotel+2" alt="Hotel 2">
            <h3>City Hotel</h3>
            <p>$150/night | ★★★★☆</p>
        </div>
        <div class="hotel-card">
            <img src="https://via.placeholder.com/300x200?text=Hotel+3" alt="Hotel 3">
            <h3>Beach Inn</h3>
            <p>$180/night | ★★★★★</p>
        </div>
    </div>
    <script>
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const destination = document.querySelector('input[name="destination"]').value;
            const checkin = document.querySelector('input[name="checkin"]').value;
            const checkout = document.querySelector('input[name="checkout"]').value;
            window.location.href = `hotels.php?destination=${encodeURIComponent(destination)}&checkin=${checkin}&checkout=${checkout}`;
        });
    </script>
</body>
</html>
