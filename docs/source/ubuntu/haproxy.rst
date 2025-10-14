Set up HAProxy reverse proxy and load balancer
==============================================

Here you will install and configure HAProxy as a reverse proxy for your applications. With the provided configuration,
it will only proxy requests from the client to NGINX. An example configuration for handling Node.js applications is also
provided, but any further customization depends on the specific project.

1 Install
---------

1.1 Install via APT package manager
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code:: bash

   sudo apt install haproxy

2 Configure
-----------

2.1 Create configuration file
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Create configuration file ``/etc/haproxy/haproxy.cfg`` with the following content:

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
       bind *:443   ssl crt /home/brodijak/ssl/chain.pem
       bind *:6443  ssl crt /home/brodijak/ssl/chain.pem

       acl is_node req.fhdr(Host),map_str(/etc/haproxy/node_domains_ports.map) -m found
       acl is_node_pass_through path,map_beg(/etc/haproxy/node_pass_through_paths.txt) -m found
       acl is_admin_sa req.fhdr(X-Siteaccess) -i adminui

       http-request capture req.hdr(Host) len 128
       http-request capture req.fhdr(Referer) len 128

       http-response set-header x-haproxy-frontend local
       http-request set-header x-forwarded-proto https if { ssl_fc }
       http-request set-header x-forwarded-port %[dst_port]

       use_backend nginx   if { path -m beg /.well-known/ } { dst_port 80 }
       use_backend nginx   if { path -m beg /.well-known/ } { dst_port 443 }
       use_backend varnish if { path -m beg /.well-known/ } { dst_port 6080 }
       use_backend varnish if { path -m beg /.well-known/ } { dst_port 6443 }

       use_backend node    if is_node !is_node_pass_through !is_admin_sa

       use_backend nginx   if { dst_port 80 }
       use_backend nginx   if { dst_port 443 }
       use_backend varnish if { dst_port 6080 }
       use_backend varnish if { dst_port 6443 }

       default_backend nginx

   backend node
       http-request set-dst-port req.fhdr(Host),map(/etc/haproxy/node_domains_ports.map)
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

Create port map file ``/etc/haproxy/node_domains_ports.map`` with the following content:

.. code:: console

   # Contains a list of domains handled by Node.js, mapped to a corresponding port
   # on which Node.js app is running

   example.dev.php82.ez    3000
   us.example.dev.php82.ez 3000

Create file containing pass-through patterns ``/etc/haproxy/node_pass_through_paths.txt``
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
3.1 Activate HAProxy Service
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code:: bash

   sudo systemctl enable --now haproxy

That will also configure the service to start automatically after a reboot.

.. caution::

   If you encounter an error stating that port 80 is already in use, you can check which process is using the port with:

   .. code:: bash

       sudo ss -tulpen | grep ':80'

   If the output shows that **nginx** is using port 80, remove the default site configuration:

   .. code:: bash

       sudo rm /etc/nginx/sites-enabled/default

   Then restart the nginx service to apply changes:

   .. code:: bash

       sudo systemctl restart nginx

   Finally, retry enabling HAProxy:

   .. code:: bash

       sudo systemctl enable --now haproxy


4 Test
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

5 Logging
---------

5.1 On Ubuntu or Linux systems
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

To monitor HAProxy service logs directly in the terminal, use the following command:

.. code:: bash

   sudo journalctl -u haproxy -f
