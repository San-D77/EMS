<!-- resources/views/errors/404.blade.php -->
<!DOCTYPE html>
<html>

<head>
    <title>Page Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }

        h1 {
            font-size: 48px;
            color: #ff6347;
        }

        p {
            font-size: 18px;
            color: #555;
        }

        .emoji {
            font-size: 100px;
        }

        .link {
            color: #0066cc;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>404 - Page Not Found</h1>
        <p>Oops! The page you are looking for could not be found.</p>
        <div class="emoji">😞</div>
        <p><a href="/" class="link">Go back to the homepage</a></p>
    </div>
</body>

</html>
