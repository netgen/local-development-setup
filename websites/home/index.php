<?php

$time = gmdate("D, d M Y H:i:s") . " GMT";

header("Expires: " . $time);
header("Last-Modified: " . $time);
header("Pragma: no-cache");
header("Cache-Control: no-cache, must-revalidate");

?><!DOCTYPE html>
<html lang="en-US">
<head>
    <title><?php echo get_current_user() . '@' . gethostname(); ?></title>
    <meta charset="UTF-8">
    <link rel="icon" type="image/png" sizes="32x32" href="favicon-32x32.png">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <h1><?php echo get_current_user() . '@' . gethostname(); ?></h1>
    <h2>websites</h2>
    <hr>
    <ol>
        <li>Media Site <a href="https://mediasite.dev.php82.ez">Frontend</a> | <a href="https://mediasite.prod.php82.ez/adminui">Admin</a></li>
    </ol>
    <details>
        <summary>Host format</summary>
        <blockquote>
            <p>Host must conform to format <code>installation_dir.symfony_environment.php_version.(ez|sf)</code></p>
            <p>For example, host <code>https://media-site.dev.php73.ez</code> is resolved to</p>
            <ul>
                <li>installation directory <code>/var/www/media-site</code></li>
                <li>public directory <code>/var/www/media-site/web</code></li>
                <li>Syfmony environment <code>dev</code></li>
                <li>PHP version 7.3</li>
                <li>Nginx configuration for eZ Platform</li>
            </ul>
            <h3>when using custom app/public directory setup</h3>
            <hr>
            <p>If installation directory part of the host contains a double dash, installation uses custom public directories and</p>
            <ul>
                <li>part before the double dash is the actual installation directory</li>
                <li>part after the double dash is the public directory</li>
            </ul>

            <p>Then in case of host <code>https://media-site--public.dev.php73.ez</code> you have</p>
            <ul>
                <li>installation directory <code>/var/www/media-site</code></li>
                <li>public directory <code>/var/www/media-site/public</code></li>
            </ul>
            <h3>when using host siteaccess matching</h3>
            <hr>
            <p>If your installation uses host siteaccess matching, symlink it into the <code>/var/www</code> separately for each subdomain</p>
            <ul>
                <li><code>ln -s /Users/<?php echo get_current_user(); ?>/projects/media-site one.media-site</code></li>
                <li><code>ln -s /Users/<?php echo get_current_user(); ?>/projects/media-site two.media-site</code></li>
            </ul>
            <p>Then access it with</p>
            <ul>
                <li><code>https://one.media-site.dev.php73.ez</code></li>
                <li><code>https://two.media-site.dev.php73.ez</code></li>
            </ul>
            <p>You can use this approach together with custom app/public directory setup described above</p>
        </blockquote>
    </details>
    <h2>services</h2>
    <hr>
    <ol>
        <li>PHP 8.4 <a href="https://phpinfo.php84">info</a> | <a href="https://home.php84/status?full&html">status</a></li>
        <li>PHP 8.3 <a href="https://phpinfo.php83">info</a> | <a href="https://home.php83/status?full&html">status</a></li>
        <li>PHP 8.2 <a href="https://phpinfo.php82">info</a> | <a href="https://home.php82/status?full&html">status</a></li>
        <li>PHP 8.1 <a href="https://phpinfo.php81">info</a> | <a href="https://home.php81/status?full&html">status</a></li>
        <li>PHP 8.0 <a href="https://phpinfo.php80">info</a> | <a href="https://home.php80/status?full&html">status</a></li>
        <li>PHP 7.4 <a href="https://phpinfo.php74">info</a> | <a href="https://home.php74/status?full&html">status</a></li>
        <li>Varnish <span class="hint">start it when needed with <code>varnishd -f /path/to/configuration.vcl -a :6081 -s malloc,256M -F</code></span></li>
        <li><a href="http://0.0.0.0:8025">Mailpit</a> <span class="hint">start it when needed with <code>mailpit</code></span></li>
        <li><a href="http://localhost:15672">RabbitMQ</a> <span class="hint">start it when needed with <code>sudo rabbitmq-server</code></span></li>
        <li><a href="http://localhost:8983/solr">Solr</a> <span class="hint">start it when needed from its installation dir with <code>~/solr/solr-x/bin/solr start -f</code></span></li>
        <li><a href="http://localhost:9998/">Tika</a> <span class="hint">start it when needed with <code>java -jar ~/jars/tika-server-x.jar</code></span></li>
    </ol>
    <h2>resources</h2>
    <hr>
    <ol>
        <li><a href="https://docs.netgen.io/projects/lds/en/latest/">Local Development Setup documentation</a></li>
    </ol>
    <p class="text-right">PHP <?php echo PHP_VERSION;?></p>
</body>
</html>
