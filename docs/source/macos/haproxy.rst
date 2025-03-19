Set up HAProxy reverse proxy and load balancer
==============================================

Here you will install and configure HAProxy as a reverse proxy for your applications. With the provided configuration,
it will only proxy requests from the client to NGINX. An example configuration for handling Node.js applications is also
provided, but any further customization depends on the specific project.

1 Install
---------

1.1 If using macOS with MacPorts
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code:: bash

   sudo port install haproxy

2 Configure
-----------

2.1 Create configuration file
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Create configuration file ``/opt/local/etc/haproxy/haproxy.cfg`` with the following content:

.. code:: cfg

   defaults
       mode http

       timeout connect 5000ms
       timeout client  50000ms
       timeout server  50000ms

       option  httplog

   frontend local
       mode http

       bind *:80
       bind *:6080
       bind *:443   ssl crt /Users/brodijak/ssl/chain.pem
       bind *:6443  ssl crt /Users/brodijak/ssl/chain.pem

       acl is_node req.fhdr(Host),map_str(/opt/local/etc/haproxy/node_domains_ports.map) -m found
       acl is_node_pass_through path,map_beg(/opt/local/etc/haproxy/node_pass_through_paths.txt) -m found

       http-request capture req.hdr(Host) len 128
       http-request capture req.fhdr(Referer) len 128

       http-response set-header x-haproxy-frontend local
       http-request set-header x-forwarded-proto https if { ssl_fc }

       option forwardfor

       use_backend nginx   if { path -m beg /.well-known/ } { dst_port 80 }
       use_backend nginx   if { path -m beg /.well-known/ } { dst_port 443 }
       use_backend varnish if { path -m beg /.well-known/ } { dst_port 6080 }
       use_backend varnish if { path -m beg /.well-known/ } { dst_port 6443 }

       use_backend node    if is_node !is_node_pass_through

       use_backend nginx   if { dst_port 80 }
       use_backend nginx   if { dst_port 443 }
       use_backend varnish if { dst_port 6080 }
       use_backend varnish if { dst_port 6443 }

       default_backend nginx

   backend node
       http-request set-dst-port req.fhdr(Host),map(/opt/local/etc/haproxy/node_domains_ports.map)
       http-response set-header x-haproxy-backend node
       server node 127.0.0.1:0 maxconn 32

   backend nginx
       http-request set-path '%[path,regsub(^/ngcontentapi"(/|$)",/,)]'
       http-response set-header x-haproxy-backend nginx
       server nginx 127.0.0.1:8080 maxconn 32

   backend varnish
       http-response set-header x-haproxy-backend varnish
       server varnish 127.0.0.1:6081 maxconn 32

Make sure to adapt the paths to certificate chain file on your system.

Create port map file ``/opt/local/etc/haproxy/node_domains_ports.map`` with the following content:

.. code:: console

   # Contains a list of domains handled by Node.js, mapped to a corresponding port
   # on which Node.js app is running

   example.dev.php82.ez    3000
   us.example.dev.php82.ez 3000

Create file containing pass-through patterns ``/opt/local/etc/haproxy/node_pass_through_paths.txt``
with the following content:

.. code:: console

   # Contains URL path prefixes match URLs that are found on Node.js domains,
   # but should be "passed through" to PHP instead

   # API endpoints
   /api
   /en/api
   /fr/api
   /hr/api
   /ngopenapi
   /en/ngopenapi
   /fr/ngopenapi
   /hr/ngopenapi
   /ngcontentapi

   # Admin
   /adminui
   /graphql

   # Assets
   /bundles/
   /assets/
   /var/

   # Debug
   /_wdt
   /_profiler

   # Sitemaps and robots.txt
   /sitemap/
   /robots.txt

3 Start
-------

3.1 If using macOS with MacPorts
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code:: bash

   sudo port load haproxy

That will also configure the service to start automatically after a reboot.

5 Test
------

Execute on the command line:

.. code:: bash

   curl -I phpinfo.php82

You should receive output similar to:

.. code:: bash

   HTTP/2 307
   server: nginx/1.26.3
   date: Wed, 12 Mar 2025 06:08:26 GMT
   content-type: text/html
   content-length: 171
   location: https://phpinfo.php82:8080/
   x-haproxy-backend: nginx
   x-haproxy-frontend: local

Make sure the following lines are present:

.. code:: bash

   x-haproxy-backend: nginx
   x-haproxy-frontend: local

6 Logging
---------

6.1 If using macOS with MacPorts
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

To see HAProxy logs on macOS, you need to stop the HAProxy service and run it
in the foreground with debug mode enabled. This way, logs will be displayed
directly in the terminal:

.. code:: bash

   sudo port unload haproxy
   haproxy -f /opt/local/etc/haproxy/haproxy.cfg -d -V
