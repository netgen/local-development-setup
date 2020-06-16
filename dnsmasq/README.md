# Set up DNS forwarding with `dnsmasq`

Here you will install and configure `dnsmasq` as a DNS forwarder, used to
resolve all your custom top-level domains to `127.0.0.1`. With it, you won’t
need to update `/etc/hosts` file to add new host names as they will be
dynamically resolved.

## 1. Install `dnsmasq`

### 1.1 Install on `MacOS` using `Homebrew`

```bash
brew install dnsmasq
```

### 1.2 Install on `MacOS` using `MacPorts`

```bash
sudo port install dnsmasq
```

## 2. Update configuration file

Edit configuration file `/opt/local/etc/dnsmasq.conf` (`MacPorts`) or
`/usr/local/etc/dnsmasq.conf` (`Homebrew`) and replace the existing
configuration with the following content:

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
`/opt/local/etc/dnsmasq.conf.example` (`MacPorts`) or
`/usr/local/etc/dnsmasq.conf.default` (`Homebrew`).

## 3. Add DNS resolver configuration for your custom top-level domains

```bash
sudo mkdir -v /etc/resolver
cd /etc/resolver
echo "nameserver 127.0.0.1" | sudo tee ez php56 php70 php71 php72 php73 php74 php80 php81 php82 php83 php84 sf > /dev/null
```

## 4. Start `dnsmasq` service

### 4.1 If installed using `MacPorts`

```bash
sudo port load dnsmasq
```

This will also ensure that `dnsmasq` server starts automatically after a reboot.

### 4.1 If installed using `Homebrew`

```bash
sudo brew services start dnsmasq
```

This will also ensure that `dnsmasq` server starts automatically after a reboot.

## 5. Add `127.0.0.1` as a DNS server to your network connections

Open Network configuration in System Preferences, click Advanced on your network
connection, select DNS tab and add `127.0.0.1` as a DNS server.

Repeat this with all network connections you are using to connect to the
Internet, excluding VPN connections.

## 6. Test resolving by pinging a bogus domain on your custom top-level domain

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

If you received output similar to the above, it means `dnsmasq` is correctly
configured for the given domain. Successfully test all configured top-level
domains, and you're finished with this part of the setup.
