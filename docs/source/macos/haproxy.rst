Set up HAProxy reverse proxy and load balancer
==============================================

Here you will install and configure HAProxy as a reverse proxy for your applications. With the provided configuration,
it will only proxy requests from the client to NGINX. Any further customization depends on a project.

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

.. code:: bash

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

       http-response set-header x-haproxy-frontend local

       use_backend nginx   if { dst_port 80 }
       use_backend nginx   if { dst_port 443 }
       use_backend varnish if { dst_port 6080 }
       use_backend varnish if { dst_port 6443 }

       default_backend nginx

   backend nginx
       http-response set-header x-haproxy-backend nginx
       server nginx    127.0.0.1:8080 maxconn 32

   backend varnish
       http-response set-header x-haproxy-backend varnish
       server varnish  127.0.0.1:6081 maxconn 32

Make sure to adapt the paths to certificate chain file on your system.

3 Start
-------

3.1 If using macOS with MacPorts
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

.. code:: bash

   sudo port load haproxy

This will also start the service automatically after a reboot.

5 Test
------

After setting up NGINX server, come back here and execute:

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

If you want to see HAProxy logs, you will have to stop the HAProxy service and run it in foreground debug mode:

.. code:: bash

   sudo port unload haproxy
   haproxy -f /opt/local/etc/haproxy/haproxy.cfg -d -V
