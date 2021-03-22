# Exposing you local websites to the outside access

Sometimes you will need to make your local installation accessible from outside
your machine, for example for testing it on a different device or just for
showing it to someone.

You can do this with a utility programs like `localtunnel` and `ngrok`.

## Exposing your website to the world using `localtunnel`

First you will need to install `localtunnel` with:

```shell
npm install -g localtunnel
```

After that, you can open a tunnel to you local website from a public domain
with:

```shell
lt --port 80 --local-host example.dev.php74.sf
```

You should receive an output like:

```text
your url is: https://fast-turtle-21.loca.lt
```

Now you can access you local installation `example.dev.php74.sf` through a
public domain `https://fast-turtle-42.loca.lt`.

## Exposing yor website to the world using `ngrok`

First head to https://ngrok.com, sign up and follow the instructions to install
the `ngrok` utility. After that, you will be able to open a tunnel to you local
website with:

```shell
ngrok http -host-header=rewrite example.dev.php74.sf
```

You should receive an output like:

```text
ngrok by @inconshreveable (Ctrl+C to quit)

Session Status                online
Account                       Brale Rodijak (Plan: Free)
Version                       2.3.35
Region                        United States (us)
Web Interface                 http://127.0.0.1:4040
Forwarding                    http://2e7eb4d1bd1c.ngrok.io -> http://example.dev.php74.sf:443/
Forwarding                    https://2e7eb4d1bd1c.ngrok.io -> http://example.dev.php74.sf:443/

Connections                   ttl     opn     rt1     rt5     p50     p90
                              0       0       0.00    0.00    0.00    0.00
```

Now you can access you local installation `example.dev.php74.sf` through a
public domain `https://2e7eb4d1bd1c.ngrok.io`.

## Exposing you website on a local network only

You can also expose you website on you local network only. To do this, find
`local_network_proxy` configuration for your `nginx` server, uncomment it and
adjust it as needed. Then, restart `nginx` with:

```shell
sudo port reload nginx
```

Now your website will be exposed on a local network through your IP address on
it, for example on `http://192.168.10.42`.
