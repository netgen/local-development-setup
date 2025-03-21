Netgen's Local Development Setup
================================

Overview
---------------------------------

This is a guide on setting up modern web development environment with
PHP on your local Mac or Linux machine, without using any kind of
virtualization. Web server configurations for Symfony and eZ Platform /
Ibexa CMS are provided out of the box, but the setup is not limited to
them, and new configurations for other PHP applications can be easily
added.

For all chapters in this documentation, replace ``Brale Rodijak`` with
your own name, ``brale`` user with you own username on your workstation
and if on Linux, ``staff`` group with your own group name (usually the
same as the username).

Follow the steps in this order:

1.  Git
2.  dnsmasq
3.  MySQL
4.  PHP
5.  Composer
6.  SSL
7.  NGINX
8.  HAProxy
9.  cURL
10. Redis
11. Solr
12. RabbitMQ
13. Mailpit
14. Varnish
15. Node.js
16. Tika
17. Memcached
18. XDebug
19. Exposing websites

MAC OS
---------------

.. toctree::
    :hidden:

    macos/index

.. include:: /macos/map.rst.inc

UBUNTU
--------

.. toctree::
    :hidden:

    ubuntu/index

.. include:: /ubuntu/map.rst.inc
