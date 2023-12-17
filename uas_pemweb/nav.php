<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Your Page Title</title>

    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .app-bar-expand-md {
            background-color: #f8f8f8;
            color: #333;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .brand {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: inherit;
        }

        .brand h5 {
            margin: 0;
            font-size: 1.5em;
        }

        .app-bar-menu {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
        }

        .app-bar-menu li {
            margin-right: 20px;
        }

        .app-bar-menu a {
            text-decoration: none;
            color: #333;
            font-size: 1.2em;
        }

        .app-bar-menu a:hover {
            color: #007bff;
        }
    </style>
</head>
<body>

<div class="app-bar-expand-md bg-grayWhite" data-role="appbar">
    <a href="#" class="brand no-hover">
        <h5>Data Mahasiswa KKN</h5>
    </a>

    <ul class="app-bar-menu">
        <li><a href="index.php"><span class="mif-home"></span> Home</a></li>
        <li><a href="logout.php"><span class="mif-exit"></span> Keluar</a></li>
    </ul>
</div>

</body>
</html>
