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
    <link rel="shortcut icon" href="data:image/x-icon;," type="image/x-icon">
    <link href="style.css" rel="stylesheet">
</head>
<body>
    <h1><?php echo get_current_user() . '@' . gethostname(); ?></h1>
    <h2>websites</h2>
    <hr>
    <ol>
        <li>Media Site <a href="https://media-site.dev.php73.ez">Frontend</a> | <a href="https://media-site.prod.php73.ez/ngadminui">Admin</a></li>
    </ol>
    <details>
        <summary>Host format</summary>
        <blockquote>
            <p>Host must conform to format <code>installation_dir.environment.php_version.(ez|sf)</code></p>
            <p>For example, host <code>https://media-site.dev.php73.ez</code> is resolved to</p>
            <ul>
                <li>installation directory <code>/var/www/media-site</code></li>
                <li>public directory <code>/var/www/media-site/web</code></li>
                <li>Environment <code>dev</code></li>
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
    <details>
        <summary>Environments</summary>
        <blockquote>
            <p>Wildcard certificates are generated for a set of environments that aim to cover most common use cases.</p>
            <p>Default environments:</p>
            <ul>
                <li><code>dev</code></li>
                <li><code>prod</code></li>
                <li><code>test</code></li>
            </ul>
            <p>Shared Netgen development setup environments:</p>
            <ul>
                <li><code>ng</code></li>
                <li><code>ng_dev</code></li>
                <li><code>ng_prod</code></li>
                <li><code>ng_test</code></li>
            </ul>
            <p>Your private/local environments:</p>
            <ul>
                <li><code>local</code></li>
                <li><code>local_dev</code></li>
                <li><code>local_prod</code></li>
                <li><code>local_test</code></li>
            </ul>
        </blockquote>
    </details>
    <details>
        <summary>SSL and Varnish</summary>
        <blockquote>
            <p>All hosts are configured to automatically redirect from HTTP to HTTPS.</p>
            <p>Varnish is configured on port 8080, for example <code>https://media-site.dev.php73.ez:8080</code></p>
            <p>HTTP access to host is possible through port 8082, for example <code>http://media-site.dev.php73.ez:8082</code></p>
        </blockquote>
    </details>
    <h2>services</h2>
    <hr>
    <ol>
        <li>PHP 7.4 <a href="https://phpinfo.php74">info</a> | <a href="https://home.php74/status?full&html">status</a></li>
        <li>PHP 7.3 <a href="https://phpinfo.php73">info</a> | <a href="https://home.php73/status?full&html">status</a></li>
        <li>PHP 7.2 <a href="https://phpinfo.php72">info</a> | <a href="https://home.php72/status?full&html">status</a></li>
        <li>PHP 7.1 <a href="https://phpinfo.php71">info</a> | <a href="https://home.php71/status?full&html">status</a></li>
        <li>PHP 7.0 <a href="https://phpinfo.php71">info</a> | <a href="https://home.php70/status?full&html">status</a></li>
        <li>PHP 5.6 <a href="https://phpinfo.php56">info</a> | <a href="https://home.php56/status?full&html">status</a></li>
        <li><a href="http://0.0.0.0:8025">MailHog</a> <span class="hint">start it when needed with <code>mailhog</code></span></li>
        <li><a href="http://localhost:15672">RabbitMQ</a> <span class="hint">start it when needed with <code>rabbitmq-server</code></span></li>
        <li><a href="http://localhost:8983/solr">Solr</a> <span class="hint">start it when needed from its installation dir with <code>./bin/solr start -f</code></span></li>
    </ol>
    <h2>extras</h2>
    <hr>
    <ol>
        <li><a href="https://docs.netgen.io/">Netgen Docs</a></li>
    </ol>
    <p class="text-right">PHP <?php echo PHP_VERSION;?></p>
</body>
</html>
