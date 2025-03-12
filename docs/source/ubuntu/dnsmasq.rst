Set up DNS forwarding with dnsmasq
==================================

Here you will install and configure dnsmasq as a DNS forwarder, used to
resolve all your custom top-level domains to ``127.0.0.1``. With it, you
won’t need to update ``/etc/hosts`` file to add new host names as they
will be dynamically resolved.

1 Install
---------

Installation on Ubuntu is a little bit tricky, since
``systemd-resolved`` does not play very well with ``NetworkManager``
when configured with ``dnsmasq``. The following steps will enable proper
configuration so that ``dnsmasq`` gets started from ``NetworkManager``
and that network connectivity changes are handled transparently.

First we need to install ``dnsmasq``:

.. code:: bash

   sudo apt install dnsmasq

After installation, you will get an error message that the process
cannot start, like this:

.. code:: text

   Job for dnsmasq.service failed because the control process exited with error code.
   See "systemctl status dnsmasq.service" and "journalctl -xe" for details.

This is happening because ``systemd-resolved`` is already listening on
that port. Ignore this for now. Next, enable ``dnsmasq`` in
``NetworkManager``:

.. code:: bash

   sudo vi /etc/NetworkManager/NetworkManager.conf

Change ``dns`` to ``dnsmasq`` in the ``[main]`` section so that it looks
like this:

.. code:: text

   [main]
   plugins=ifupdown,keyfile
   dns=dnsmasq

   [ifupdown]
   managed=false

   [device]
   wifi.scan-rand-mac-address=no

And then execute the following command to let ``NetworkManager`` manage
``/etc/resolv.conf``:

.. code:: bash

   sudo rm /etc/resolv.conf ; sudo ln -s /var/run/NetworkManager/resolv.conf /etc/resolv.conf

Finally, restart the NetworkManager:

.. code:: bash

   sudo systemctl reload NetworkManager

**Note:** if you want to revert to ``systemd-resolved``,
``/etc/resolv.conf`` points to ``/run/systemd/resolve/stub-resolv.conf``
by default.

2 Configure
-----------

2.1 Update configuration file
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Edit configuration file ``/etc/NetworkManager/dnsmasq.d/dnsmasq.conf`` and replace the
existing configuration with the following content:

.. code:: bash

   no-resolv
   address=/ez/127.0.0.1
   address=/php56/127.0.0.1
   address=/php70/127.0.0.1
   address=/php71/127.0.0.1
   address=/php72/127.0.0.1
   address=/php73/127.0.0.1
   address=/php74/127.0.0.1
   address=/php80/127.0.0.1
   address=/php81/127.0.0.1
   address=/php82/127.0.0.1
   address=/php83/127.0.0.1
   address=/php84/127.0.0.1
   address=/php85/127.0.0.1
   address=/php90/127.0.0.1
   address=/php91/127.0.0.1
   address=/php92/127.0.0.1
   address=/php93/127.0.0.1
   address=/php94/127.0.0.1
   address=/sf/127.0.0.1
   address=/wp/127.0.0.1

If the file does not exist in the directory you need to create it.

Default configuration will still be available for reference in
``/etc/dnsmasq.conf``

3 Start
-------

On Ubuntu this process will be started automatically in the future and it’s enabled to
start after a reboot by default.

But for now you need to restart NetworkManager for config to be loaded

.. code:: bash

   sudo systemctl restart NetworkManager

If you need to start/stop or enable/disable it, use ``systemctl``:

.. code:: bash

   sudo systemctl start NetworkManager
   sudo systemctl stop NetworkManager
   sudo systemctl is-enabled NetworkManager
   sudo systemctl enable NetworkManager
   sudo systemctl disable NetworkManager

4 Test
------

Test resolving by pinging a bogus domain on your custom top-level
domain.

Execute on the command line:

.. code:: bash

   ping asdfghjkl.sf

You should get a response from ``127.0.0.1``:

.. code:: bash

   PING asdfghjkl.sf (127.0.0.1): 56 data bytes
   64 bytes from 127.0.0.1: icmp_seq=0 ttl=64 time=0.028 ms
   64 bytes from 127.0.0.1: icmp_seq=1 ttl=64 time=0.045 ms
   64 bytes from 127.0.0.1: icmp_seq=2 ttl=64 time=0.130 ms
   ^C
   --- asdfghjkl.sf ping statistics ---
   3 packets transmitted, 3 packets received, 0.0% packet loss
   round-trip min/avg/max/stddev = 0.028/0.068/0.130/0.045 ms

If you received output similar to the above, it means dnsmasq is
correctly configured for the given domain. Successfully test all
configured top-level domains, and you’re finished with this part of the
setup.
