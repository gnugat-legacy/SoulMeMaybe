# SoulMeMaybe RFC

This file will contain the official documentation of the project.

## NetSoul server

SoulMeMaybe will connect to the following server:

* **name**: `10.42.1.59`;
* **port**: `4242`.

## Connection protocol

Here is the protocol to follow after connecting to the server:

1. **server**: `salut <socket number> <hash seed> <client host> <client port> <server timestamp>`;
2. **client**: `auth_ag ext_user none none`;
3. **server**: `rep 002 -- cmd end`;
4. **client**: `ext_user_log <login> <authentication hash> <client> <user location>`;
5. **server**: `ping <timeout in seconds>`;
6. **client**: `<ping answer>`.

With:

* `<authentication hash>` being `md5("<hash seed>-<client host>/<client port><password socks>")`;
* `<client>` being `<client name> <client version>`;
* `<user location>` being `<in PIE> <room> <line> <station>`.
