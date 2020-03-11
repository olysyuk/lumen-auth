# Lumen Auth Demo

Demo authentication service that stores users in MongoDB.

Features:

1. Registration functionality that validates user data.
2. Login functionality.

TODO

1. Email verification functionality

## Sample api calls
```
# Registration
curl --header "Content-Type: application/json" \
  --request POST \
  --data '{"email":"e@e.com","password":"testpassword"}' \
  http://localhost/api/users

Expected response:
{"message":"Registration is finished. Please check e@e.com for activation instructions."}

# Registration data validation
curl --header "Content-Type: application/json" \
  --request POST \
  --data '{"email":"ee.com","password":""}' \
  http://localhost/api/users

Expected response:
{"email":["The email must be a valid email address."],"password":["The password field is required."]}

# Login
curl --header "Content-Type: application/json" \
  --request POST \
  --data '{"email":"e@e.com","password":"testpassword"}' \
  http://localhost/api/users/login

Expected response
{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2FwaVwvdXNlcnNcL2xvZ2luIiwiaWF0IjoxNTgzOTY0MjE0LCJleHAiOjE1ODM5Njc4MTQsIm5iZiI6MTU4Mzk2NDIxNCwianRpIjoidXFkUHg3d1BlVWZ2aDVKVSIsInN1YiI6IjVlNjk1ZmViMTQyMjlkMGI0YjA5MDQyOSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.zg17qGB--zDeBnzWpAj86LI1T2jXeTj_r-Duvm9gsTY"}

# Check if current user is authenticated
curl http://localhost/api/users/me?token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9sb2NhbGhvc3RcL2FwaVwvdXNlcnNcL2xvZ2luIiwiaWF0IjoxNTgzOTY0MjE0LCJleHAiOjE1ODM5Njc4MTQsIm5iZiI6MTU4Mzk2NDIxNCwianRpIjoidXFkUHg3d1BlVWZ2aDVKVSIsInN1YiI6IjVlNjk1ZmViMTQyMjlkMGI0YjA5MDQyOSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.zg17qGB--zDeBnzWpAj86LI1T2jXeTj_r-Duvm9gsTY

Expected response
{"id":"5e695feb14229d0b4b090429","email":"e@e.com"}

```


## Development environment setup

Current dev environment setup is based on laradock and docker-compose. First run builds images - that may take 2-5 minutes.


### 1. Build laradock images and start

```
git clone git@github.com:olysyuk/lumen-auth.git .
git submodule update --init --recursive
cp laradock.env laradock/.env
cd project_dir/laradock
docker-compose up -d nginx mongo workspace
```

When docker-compose reports that all 5 services are running it's possible to open http://localhost and see running app.

### 2. Create local env file
```
cd project_dir
ln -s .env.example .env
```

### 3. Create local mongo database user
```
docker exec -it laradock_mongo_1 bash
mongo
> use admin;
> db.createUser({user:"homestead", pwd:"secret", roles:["userAdminAnyDatabase", "dbAdminAnyDatabase", "readWriteAnyDatabase"]});
```

### 4. Run commands in workspace.
```
cd project_dir/laradock
docker-compose exec workspace bash
```
