Set up Varnish reverse HTTP proxy
=================================

1 Install Varnish
-----------------

Since Varnish is not widely available in all necessary versions, here
you will compile it from downloaded source.

1.1 Download Varnish
^^^^^^^^^^^^^^^^^^^^

Download the required Varnish source from GitHub to your home directory:

.. code:: console

   mkdir ~/varnish
   cd ~/varnish
   wget https://github.com/varnishcache/varnish-cache/archive/varnish-6.0.6.tar.gz

Extract the downloaded archive and position into it:

.. code:: console

   cd ~/varnish
   tar xzf varnish-6.0.6.tar.gz && rm varnish-6.0.6.tar.gz
   cd varnish-cache-varnish-6.0.6

1.2 Patch Varnish
^^^^^^^^^^^^^^^^^

As nicely explained at
https://varnish-cache.org/docs/6.0/phk/platforms.html, MacOS is not the
primary platform Varnish team cares about. They will try not to break
it, but will not regularly test it and may rely on contributors to alert
about problems. Since you use MacOS, and our web technology of choice
forces us to use a bit older version of Varnish, you will need to
manually apply some patches existing in the newer versions.

Execute on the command line:

.. code:: console

   cd ~/varnish/varnish-cache-varnish-6.0.6
   subl bin/varnishd/cache/cache_lck.c

Then manually apply the following commit:
https://github.com/varnishcache/varnish-cache/commit/e5e545f9fe14b4bfd4003c26403d80645c73385a

1.3 Install tools needed to compile Varnish
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Install ``automake`` using ``brew`` if you don’t already have it:

.. code:: console

   brew info automake
   brew install automake

1.4 Compile and install Varnish
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Execute the following to compile and install Varnish binaries:

.. code:: console

   cd ~/varnish/varnish-cache-varnish-6.0.6
   ./autogen.sh
   ./configure
   make
   sudo make install

Once the process has finished, Varnish binaries will be installed on
paths ``/usr/local/bin`` and ``/usr/local/sbin``. If these are not
already under your environment ``PATH`` variable, leave them be where
they are and just symlink them to your user’s ``bin`` directory:

.. code:: console

   cd ~/bin
   ln -s /usr/local/bin/varnishadm
   ln -s /usr/local/bin/varnishhist
   ln -s /usr/local/bin/varnishlog
   ln -s /usr/local/bin/varnishncsa
   ln -s /usr/local/bin/varnishstat
   ln -s /usr/local/bin/varnishtest
   ln -s /usr/local/bin/varnishtop
   ln -s /usr/local/sbin/varnishd


2 Install Varnish modules
-------------------------

Aside from standard Varnish installation, you’ll need ``xkey`` module as
well.

2.1 Clone repository
^^^^^^^^^^^^^^^^^^^^

Clone modules repository into your home directory, position into it and
checkout branch ``6.0-lts``:

.. code:: console

   cd ~/varnish
   git clone https://github.com/varnish/varnish-modules.git
   cd varnish-modules
   git checkout 6.0-lts

2.2 Compile and install Varnish modules
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Execute the following to compile and install module binaries:

.. code:: console

   cd ~/varnish/varnish-modules
   export PKG_CONFIG_PATH=/usr/local/lib/pkgconfig
   ./bootstrap
   ./configure
   make
   sudo make install

3 Start
-------

Now start the server in the foreground on the port 8081, replacing the
example path to VCL with correct one for your project:

.. code:: console

   varnishd -f /path/to/configuration.vcl -a :6081 -T :6082 -s malloc,256M -F

With these options, configure ``purge_server`` in your eZ Platform
installation to ``http://localhost:6081``.

If needed you can adjust the amount of memory given to the Varnish
server (256M in the above example). Stop the server when needed with
``Control-C``.

4 Configure VCL
---------------

In instructions for macOS (above) Varnish is started from the command
line when needed, and the VCL configuration is provided as a parameter
to the starting command, so there is no need to configure it separately.
