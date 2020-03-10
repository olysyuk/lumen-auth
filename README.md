# Lumen Auth Demo

Demo authentication service that stores users in MongoDB.

Features:
1. Registration functionality that validates user data.
2. Email verification by sending activation code.
3. Login functionality.


## Development environment setup

Current dev environment setup is based on laradock and docker-compose. First run builds images - that may take 2-5 minutes.

```
git clone git@github.com:olysyuk/lumen-auth.git .
git submodule update --init --recursive
cp laradock.env laradock/.env
cd laradock
docker-compose up -d nginx mongo workspace
```

When docker-compose reports that all 5 services are running it's possible to open http://localhost and see running app.



In order to access workspace console run:
```
docker-compose exec workspace bash
```
