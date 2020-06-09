# Install and configure `Varnish` reverse HTTP proxy

Since `Varnish` is not widely available in all necessary versions, here you will
compile it from downloaded source.

Download the required `Varnish` source from GitHub to your home directory:

```console
cd ~
wget https://github.com/varnishcache/varnish-cache/archive/varnish-6.0.6.tar.gz
```

Extract the downloaded archive and position into it:

```console
tar xzf varnish-6.0.6.tar.gz
cd varnish-cache-varnish-6.0.6
```

Install `automake` using `brew` you don't already have it:

```console
brew info automake
brew install automake
```

Now you can execute the following to compile `Varnish` binaries:

```console
./autogen.sh
./configure
make
sudo make install
```

Once the process has finished, start the `Varnish` in the foreground with:

```console
varnishd -f /Users/brale/varnish-cache-varnish-6.0.6/etc/example.vcl -a :8081 -s malloc,256M -F
```
