# Install and configure `Varnish` reverse HTTP proxy

Since `Varnish` is not widely available in all necessary versions, here you will
compile it from downloaded source.

Download the required `Varnish` source from GitHub to you home directory:

```console
cd ~
wget https://github.com/varnishcache/varnish-cache/archive/varnish-6.0.6.tar.gz
```

Extract the downloaded archive and position into it:

```console
tar xzf varnish-6.0.6.tar.gz
cd varnish-cache-varnish-6.0.6
```

heck that you have `automake` installed and install it if it's missing:

```console
brew info automake
brew install automake
```

Now you can execute the following to compile `Varnish` binaries:

```console
./autogen.sh
./configure
make
```

Once the binaries are built, start the `Varnish` with:

```console
./bin/varnishd/varnishd -f /Users/brale/varnish-cache-varnish-6.0.6/etc/example.vcl -a :8081 -s file,/Users/brale/varnishcache,500M -d
```

In the `Varnish` console, type start to start the child process (todo automatic):

```shell script
start
```
