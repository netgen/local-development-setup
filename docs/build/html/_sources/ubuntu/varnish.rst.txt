Set up Varnish reverse HTTP proxy
=================================

1 Install Varnish
-----------------

1.1 Add GPG key
^^^^^^^^^^^^^^^

In order to install a deb repo, first you need to install the GPG key
that used to sign repository metadata. To do this, execute the following
command:

.. code:: console

   curl -L https://packagecloud.io/varnishcache/varnish60lts/gpgkey | sudo apt-key add -

1.2 Add repository configuration
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Create a file named
``/etc/apt/sources.list.d/varnishcache_varnish60lts.list`` with:

.. code:: console

   sudo vi /etc/apt/sources.list.d/varnishcache_varnish60lts.list

and paste the following in it:

.. code:: console

   deb https://packagecloud.io/varnishcache/varnish60lts/ubuntu/ bionic main
   deb-src https://packagecloud.io/varnishcache/varnish60lts/ubuntu/ bionic main

1.3 Lower default varnish package priority
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Ubuntu 20.xx comes with Varnish 6.2 by default. This means that, even
though we manually installed 6.0, doing ``apt upgrade`` will run over
our 6.0 with the default 6.2. In order to prevent this, we need to lower
the priority of the default 6.2 package.

To do that, create the following file:

.. code:: console

   sudo vi /etc/apt/preferences.d/varnish

and paste this inside:

.. code:: console

   Package: varnish
   Pin: release o=Ubuntu
   Pin-Priority: 100

And then create the following file:

.. code:: console

   sudo vi /etc/apt/preferences.d/varnish-dev

and paste this inside

.. code:: console

   Package: varnish-dev
   Pin: release o=Ubuntu
   Pin-Priority: 100

1.4 Install missing library ``libjemalloc1_3.6.0``
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

If you try to install Varnish with ``apt install`` at this point, you
will receive the following error:

.. code:: console

   The following packages have unmet dependencies:
    varnish : Depends: libjemalloc1 (>= 2.1.1) but it is not installable
   E: Unable to correct problems, you have held broken packages.

This library ``libjemalloc1`` doesn’t exist in Ubuntu 20.xx (although it
exists in older versions, up to 18.xx) so we need to install it
manually. To do this, execute the following commands:

.. code:: console

   cd ~
   wget http://archive.ubuntu.com/ubuntu/pool/universe/j/jemalloc/libjemalloc1_3.6.0-11_amd64.deb
   sudo dpkg -i libjemalloc1_3.6.0-11_amd64.deb

1.5 Install Varnish from repositories
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Now you can install Varnish (and varnish-dev) simply with

.. code:: console

   sudo apt install varnish varnish-dev

2 Install Varnish modules
-------------------------

Aside from standard Varnish installation, you’ll need ``xkey`` module as
well.

2.1 Install needed tools for compiling
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

In order to be able to compile the modules, we need to install the
following tools:

.. code:: console

   sudo apt install libtool automake docutils-common

.. _clone-repository-1:

2.2 Clone repository
^^^^^^^^^^^^^^^^^^^^

Clone the Varnish modules in your home directory and checkout tag
``0.15.0``:

.. code:: console

   cd ~
   git clone https://github.com/varnish/varnish-modules.git
   cd varnish-modules
   git checkout 0.15.0

.. _compile-and-install-varnish-modules-1:

2.3 Compile and install Varnish modules
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Execute the following to compile and install module binaries:

.. code:: console

   ./bootstrap
   ./configure
   make
   sudo make install

3 Start
-------

On Ubuntu, Varnish is installed as a service so you can use the
following commands:

.. code:: console

   sudo systemctl start varnish
   sudo systemctl stop varnish
   sudo systemctl status varnish
   sudo systemctl restart varnish

To make sure that Varnish is running, you can use the following command:

.. code:: console

   ps aux | grep varnish

There you can see all the options which Varnish service uses to start
Varnish.

If you want to enable or disable Varnish on startup (after reboot), use
the following commands:

.. code:: console

   sudo systemctl enable varnish
   sudo systemctl disable varnish
   sudo systemctl is-enabled varnish

4 Configure VCL
---------------

Varnish service uses the ``/etc/varnish/default.vcl`` VCL file for
configuration. In order to use a different file, we would have to modify
the Varnish service file so it’s easier to keep using the default one.

You have to replace the ``/etc/varnish/default.vcl`` with desired VCL
file and restart the Varnish service. For media site installations, you
can find instructions for configuration here:
https://github.com/netgen/media-site/blob/master/doc/varnish/varnish.md
