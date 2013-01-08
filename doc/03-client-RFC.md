# Client's RFC

This file will contain the official documentation of the project.

## NetSoul server

By default, SoulMeMaybe will connect to the following server:

* **name**: `10.42.1.59`;
* **port**: `4242`.

You can change these values in the `./app/config/parameters.yml` file, however
it is not advised to.

## Protocol

Here is the protocol followed by the client:

1. **server**: `salut <file descriptor> <hash seed> <client host> <client port> <connection timestamp>`;
2. **client**: `auth_ag ext_user none none`;
3. **server**: `rep 002 -- cmd end`;
4. **client**: `ext_user_log <user login> <authentication hash> <client description> <user location>`;
5. **server**: `rep 002 -- cmd end`;
6. **server**: `ping <timeout in seconds>`;
7. **client**: `ping`.

With:

* `<authentication hash>` being `md5("<hash seed>-<client host>/<client port><password socks>")`;
* `<client description>` being `<client name> <client version>`;
* `<user location>` being `<in PIE> <room> <line> <station>`.
