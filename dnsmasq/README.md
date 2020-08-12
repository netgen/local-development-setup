# Set up DNS forwarding with dnsmasq

Here you will install and configure dnsmasq as a DNS forwarder, used to
resolve all your custom top-level domains to `127.0.0.1`. With it, you won’t
need to update `/etc/hosts` file to add new host names as they will be
dynamically resolved.

## 1 Install

### 1.1 If using MacOS with Homebrew

```bash
brew install dnsmasq
```

### 1.2 If using MacOS with MacPorts

```bash
sudo port install dnsmasq
```

### 1.3 Install on Ubuntu

Installation on Ubuntu is a little bit tricky, since `systemd-resolved` does not
play very well with `NetworkManager` when configured with `dnsmasq`. The following
steps will enable proper configuration so that `dnsmasq` gets started from 
`NetworkManager` and that network connectivity changes are handled transparently.

First we need to install `dnsmasq`:

```bash
sudo apt install dnsmasq
```

After installation, you will get an error message that the process
cannot start, like this:

```text
Job for dnsmasq.service failed because the control process exited with error code.
See "systemctl status dnsmasq.service" and "journalctl -xe" for details.
```

This is happening because `systemd-resolved` is already listening on that port.
Ignore this for now. Next, enable `dnsmasq` in `NetworkManager`:

```bash
sudo vi /etc/NetworkManager/NetworkManager.conf
```

Change `dns` to `dnsmasq` in the `[main]` section so that it looks like this:

```text
[main]
plugins=ifupdown,keyfile
dns=dnsmasq

[ifupdown]
managed=false

[device]
wifi.scan-rand-mac-address=no
```

And then execute the following command to let `NetworkManager` manage `/etc/resolv.conf`:

```bash
sudo rm /etc/resolv.conf ; sudo ln -s /var/run/NetworkManager/resolv.conf /etc/resolv.conf
```

Finally, restart the NetworkManager:

```bash
sudo systemctl reload NetworkManager
```

**Note:** if you want to revert back to `systemd-resolved`,
`/etc/resolv.conf` points to `/run/systemd/resolve/stub-resolv.conf` by default. 

## 2 Configure

### 2.1 Update configuration file

Edit configuration file `/opt/local/etc/dnsmasq.conf` (MacPorts) or
`/usr/local/etc/dnsmasq.conf` (Homebrew) or
`/etc/NetworkManager/dnsmasq.d/dnmasq.conf` (Ubuntu) and replace the
existing configuration with the following content:

```bash
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
address=/sf/127.0.0.1
```

Default configuration will still be available for reference in
`/opt/local/etc/dnsmasq.conf.example` (MacPorts) or
`/usr/local/etc/dnsmasq.conf.default` (Homebrew).

### 2.2 Add DNS resolver configuration (MacOS only)

Add DNS resolver configuration for your custom top-level domains by executing on
the command line:

```bash
sudo mkdir -v /etc/resolver
cd /etc/resolver
echo "nameserver 127.0.0.1" | sudo tee ez php56 php70 php71 php72 php73 php74 php80 php81 php82 php83 php84 sf > /dev/null
```

## 3 Start

### 3.1 If using MacOS with MacPorts

```bash
sudo port load dnsmasq
```

This will also start the server automatically after a reboot.

### 3.2 If using MacOS with Homebrew

```bash
sudo brew services start dnsmasq
```

This will also start the server automatically after a reboot.

### 3.3 If using Ubuntu

On Ubuntu this process will be started automatically and it's enabled
to start after a reboot by default.

If you need to start/stop or enable/disable it, use `systemctl`:

```bash
sudo systemctl start NetworkManager
sudo systemctl stop NetworkManager
sudo systemctl is-enabled NetworkManager
sudo systemctl enable NetworkManager
sudo systemctl disable NetworkManager
```

## 4 Update network connections (MacOS only)

Open Network configuration in System Preferences, click Advanced on your network
connection, select DNS tab and add `127.0.0.1` as a DNS server.

Repeat this with all network connections you are using to connect to the
Internet, excluding VPN connections.

## 5 Test

Test resolving by pinging a bogus domain on your custom top-level domain.

Execute on the command line:

```bash
ping asdfghjkl.sf
```

You should get a response from `127.0.0.1`:

```bash
PING asdfghjkl.sf (127.0.0.1): 56 data bytes
64 bytes from 127.0.0.1: icmp_seq=0 ttl=64 time=0.028 ms
64 bytes from 127.0.0.1: icmp_seq=1 ttl=64 time=0.045 ms
64 bytes from 127.0.0.1: icmp_seq=2 ttl=64 time=0.130 ms
^C
--- asdfghjkl.sf ping statistics ---
3 packets transmitted, 3 packets received, 0.0% packet loss
round-trip min/avg/max/stddev = 0.028/0.068/0.130/0.045 ms
```

If you received output similar to the above, it means dnsmasq is correctly
configured for the given domain. Successfully test all configured top-level
domains, and you're finished with this part of the setup.
