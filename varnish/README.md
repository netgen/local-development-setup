# Set up Varnish reverse HTTP proxy

## 1 Install Varnish 

### 1.1 If using MacOS

Since Varnish is not widely available in all necessary versions, here you will
compile it from downloaded source.

#### 1.1.1 Download Varnish

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

#### 1.1.2 Patch Varnish

As nicely explained at https://varnish-cache.org/docs/6.0/phk/platforms.html,
MacOS is not the primary platform Varnish team cares about. They will try not to
break it, but will not regularly test it and may rely on contributors to alert
about problems. Since you use MacOS, and our web technology of choice forces us
to use a bit older version of Varnish, you will need to manually apply some
patches existing in the newer versions.

Execute on the command line:

```console
cd ~/varnish/varnish-cache-varnish-6.0.6
subl bin/varnishd/cache/cache_lck.c
```

Then manually apply the following commit: https://github.com/varnishcache/varnish-cache/commit/e5e545f9fe14b4bfd4003c26403d80645c73385a

#### 1.1.3 Install tools needed to compile Varnish

Install `automake` using `brew` if you don't already have it:

```console
brew info automake
brew install automake
```

#### 1.1.4 Compile and install Varnish

Execute the following to compile and install Varnish binaries:

```console
cd ~/varnish/varnish-cache-varnish-6.0.6
./autogen.sh
./configure
make
sudo make install
```

Once the process has finished, Varnish binaries will be installed on paths
`/usr/local/bin` and `/usr/local/sbin`. If these are not already under your
environment `PATH` variable, leave them be where they are and just symlink them
to your user's `bin` directory:

```console
cd ~/bin
ln -s /usr/local/bin/varnishadm
ln -s /usr/local/bin/varnishhist
ln -s /usr/local/bin/varnishlog
ln -s /usr/local/bin/varnishncsa
ln -s /usr/local/bin/varnishstat
ln -s /usr/local/bin/varnishtest
ln -s /usr/local/bin/varnishtop
ln -s /usr/local/sbin/varnishd
```

### 1.2 If using Ubuntu

#### 1.2.1 Add GPG key

In order to install a deb repo, first you need to install the GPG key that used to
sign repository metadata. To do this, execute the following command:

```console
curl -L https://packagecloud.io/varnishcache/varnish60lts/gpgkey | sudo apt-key add -
```

#### 1.2.2 Add repository configuration

Create a file named `/etc/apt/sources.list.d/varnishcache_varnish60lts.list` with:

```console
sudo vi /etc/apt/sources.list.d/varnishcache_varnish60lts.list
```

and paste the following in it:

```console
deb https://packagecloud.io/varnishcache/varnish60lts/ubuntu/ bionic main
deb-src https://packagecloud.io/varnishcache/varnish60lts/ubuntu/ bionic main
```

#### 1.2.3 Lower default varnish package priority

Ubuntu 20.xx comes with Varnish 6.2 by default. This means that, even though
we manually installed 6.0, doing `apt upgrade`  will run over our 6.0 with the
default 6.2. In order to prevent this, we need to lower the priority of the
default 6.2 package.

To do that, create the following file:

```console
sudo vi /etc/apt/preferences.d/varnish
```

and paste this inside:

```console
Package: varnish
Pin: release o=Ubuntu
Pin-Priority: 100
```

And then create the following file:

```console
sudo vi /etc/apt/preferences.d/varnish-dev
```

and paste this inside

```console
Package: varnish-dev
Pin: release o=Ubuntu
Pin-Priority: 100
```

#### 1.2.4 Install missing library `libjemalloc1_3.6.0`

If you try to install Varnish with `apt install` at this point, you will receive
the following error:

```console
The following packages have unmet dependencies:
 varnish : Depends: libjemalloc1 (>= 2.1.1) but it is not installable
E: Unable to correct problems, you have held broken packages.
```

So we need to manually install this missing library. To download this library, go
to this link: https://packages.ubuntu.com/bionic/amd64/libjemalloc1/download and
choose any mirror. Then navigate in terminal to the directory where you downloaded
the .deb file and execute the following command:

```console
sudo dpkg -i libjemalloc1_3.6.0-11_amd64.deb
```

#### 1.2.5 Install Varnish from repositories

Now you can install Varnish (and varnish-dev) simply with

```console
sudo apt install varnish varnish-dev
```

## 2 Install Varnish modules

Aside from standard Varnish installation, you'll need `xkey` module as well.

### 2.1 If using MacOS

#### 2.1.1 Clone repository

Clone modules repository into your home directory, position into it and checkout
branch `6.0-lts`:

```console
cd ~/varnish
git clone https://github.com/varnish/varnish-modules.git
cd varnish-modules
git checkout 6.0-lts
```

#### 2.1.2 Compile and install Varnish modules

Execute the following to compile and install module binaries:

```console
cd ~/varnish/varnish-modules
export PKG_CONFIG_PATH=/usr/local/lib/pkgconfig
./bootstrap
./configure
make
sudo make install
```

### 2.2 If using Ubuntu

#### 2.2.1 Install needed tools for compiling

In order to be able to compile the modules, we need to install
the following tools:

```console
sudo apt install libtool automake docutils-common
```

#### 2.2.2 Clone repository

Clone the Varnish modules in your home directory and checkout tag `0.15.0`:

```console
cd ~
git clone https://github.com/varnish/varnish-modules.git
cd varnish-modules
git checkout 0.15.0
```

#### 2.2.3 Compile and install Varnish modules

Execute the following to compile and install module binaries:

```console
./bootstrap
./configure
make
sudo make install
```

## 3 Start

### 3.1 If using MacOS

Now start the server in the foreground on the port 8081, replacing the example
path to VCL with correct one for your project:

```console
varnishd -f /path/to/configuration.vcl -a :8081 -s malloc,256M -F
```

With these options, configure `purge_server` in your eZ Platform installation to
`http://localhost:8081`.

If needed you can adjust the amount of memory given to the Varnish server
(256M in the above example). Stop the server when needed with `Control-C`.

### 3.2 If using Ubuntu

On Ubuntu, Varnish is installed as a service so you can use the following commands:

```console
sudo systemctl start varnish
sudo systemctl stop varnish
sudo systemctl status varnish
sudo systemctl restart varnish
```

To make sure that Varnish is running, you can use the following command:

```console
ps aux | grep varnish
```

There you can see all the options which Varnish service uses to start Varnish.

If you want to enable or disable Varnish on startup (after reboot), use the following
commands:

```console
sudo systemctl enable varnish
sudo systemctl disable varnish
sudo systemctl is-enabled varnish
```

## 3 Configure VCL

### 3.1 If using MacOS

// TODO

### 3.2 If using Ubuntu

Varnish service uses the `/etc/varnish/default.vcl` VCL file for configuration. In order to
use a different file, we would have to modify the Varnish service file so it's easier to keep
using the default one.

You have to replace the `/etc/varnish/default.vcl` with desired VCL file and restart the
Varnish service. For media site installations, you can find instructions for configuration
here: https://github.com/netgen/media-site/blob/master/doc/varnish/varnish.md
