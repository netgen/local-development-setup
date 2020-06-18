# Set up Varnish reverse HTTP proxy

Since Varnish is not widely available in all necessary versions, here you will
compile it from downloaded source.

Download the required Varnish source from GitHub to your home directory:

```console
mkdir ~/varnish
cd ~/varnish
wget https://github.com/varnishcache/varnish-cache/archive/varnish-6.0.6.tar.gz
```

Extract the downloaded archive and position into it:

```console
cd ~/varnish
tar xzf varnish-6.0.6.tar.gz && rm varnish-6.0.6.tar.gz
cd varnish-cache-varnish-6.0.6
```

Install `automake` using `brew` you don't already have it:

```console
brew info automake
brew install automake
```

Execute the following to compile and install Varnish binaries:

```console
cd ~/varnish/varnish-cache-varnish-6.0.6
./autogen.sh
./configure
make
sudo make install
```

Aside from standard Varnish installation, you'll need `xkey` module as well.
Clone modules repository into your home directory, position into it and checkout
branch `6.0-lts`:

```console
cd ~/varnish
git clone https://github.com/varnish/varnish-modules.git
cd varnish-modules
git checkout 6.0-lts
```

Execute the following to compile and install module binaries:

```console
cd ~/varnish/varnish-modules
./configure
make
sudo make install
```

Once the process has finished, start the server in the foreground on the port
8081, replacing the example path to VCL with correct one for the project:

```console
varnishd -f /path/to/configuration.vcl -a :8081 -s malloc,256M -F
```

With these options, configure `purge_server` in your eZ Platform installation to
`http://localhost:8081`.

If needed you can adjust the amount of memory given to the Varnish server
(256M in the above example). Stop the server when needed with `Control-C`.
