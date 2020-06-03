# Install `Redis` in-memory cache

First install `Redis` using `brew`:

```console
brew install redis
```

By default, `brew` adds default Redis configuration to
`/usr/local/etc/redis.conf`.

To start Redis automatically on system startup execute the following:

```console
cp /usr/local/opt/redis/homebrew.mxcl.redis.plist ~/Library/LaunchAgents
launchctl load ~/Library/LaunchAgents/homebrew.mxcl.redis.plist
```

To disable automatic start:

```console
launchctl unload ~/Library/LaunchAgents/homebrew.mxcl.redis.plist
```

Starting Redis manually (on demand):

```console
redis-server /usr/local/etc/redis.conf
```

Testing if Redis server is running:

```console
redis-cli ping
```

Redis should respond with “PONG“.
