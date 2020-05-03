<!DOCTYPE html>
<html lang="en-US">
<head>
    <title>ERROR: Invalid Host Format</title>
    <meta charset="UTF-8">
    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
    <style>
        html,
        body {
            height: 100%;
        }

        body {
            box-sizing: border-box;
            margin: 0;
            border: 32px solid transparent;
            font-size: 100%;
            background: linear-gradient(to top left, #f2f4f5, #dcdde0, #dcdde0, #dcdde0, #d2d3d6);
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            line-height: 1.52em;
        }

        hr {
            border-top: 1px dotted #8c8b8b;
            border-bottom: 1px dotted #fff;
        }

        h1,
        h2 {
            color:#555555
        }

        a {
            text-decoration: none;
            outline: none;
            color: rgb(0, 0, 238);
            padding: 2px;
        }

        a,
        a:visited,
        a:active {
            color: #0000ee;
        }

        a:hover {
            color: #f2f4f5;
            background: #0000ee;
            border-radius: 3px;
        }

        h1 {
            margin-top: 0;
            text-align: right;
        }

        h2 {
            font-variant: small-caps;
            margin-bottom: 0;
        }

        p.text-right {
            color: #555555;
            text-align: right;
        }

        code {
            font-size: 14px;
            background: lightgoldenrodyellow;
            border-radius: 2px;
            padding: 0 2px;
        }
    </style>
</head>
<body>
    <h1>ERROR: Invalid Host Format</h1>
    <h2>Host format</h2>
    <hr>
    <p>Host must conform to format <code>installation_dir.symfony_environment.php_version.(ez|sf)</code></p>
    <p>For example, host <code>media-site.dev.php73.ez</code> is resolved to</p>
    <ul>
        <li>installation directory <code>/var/www/media-site</code></li>
        <li>public directory <code>/var/www/media-site/web</code></li>
        <li>Syfmony environment <code>dev</code></li>
        <li>PHP version 7.3</li>
        <li>Nginx configuration for eZ Platform</li>
    </ul>
    <h2>When using custom app/public directory setup</h2>
    <hr>
    <p>If installation directory part of the host contains a double dash, installation uses custom public directories and</p>
    <ul>
        <li>part before the double dash is the actual installation directory</li>
        <li>part after the double dash is the public directory</li>
    </ul>

    <p>Then in case of host <code>media-site--public.dev.php73.ez</code> you have</p>
    <ul>
        <li>installation directory <code>/var/www/media-site</code></li>
        <li>public directory <code>/var/www/media-site/public</code></li>
    </ul>
    <h2>When using host siteaccess matching</h2>
    <hr>
    <p>If your installation uses host siteaccess matching, symlink it into the <code>/var/www</code> separately for each subdomain</p>
    <ul>
        <li><code>ln -s /Users/<?php echo get_current_user(); ?>/projects/media-site one.media-site</code></li>
        <li><code>ln -s /Users/<?php echo get_current_user(); ?>/projects/media-site two.media-site</code></li>
    </ul>
    <p>Then access it with</p>
    <ul>
        <li><code>one.media-site.dev.php73.ez</code></li>
        <li><code>two.media-site.dev.php73.ez</code></li>
    </ul>
    <p>You can use this approach together with custom app/public directory setup described above</p>
</body>
</html>
