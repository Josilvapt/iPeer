# Install local iPeer

- <http://ipeer.ctlt.ubc.ca>
- <https://github.com/ubc/iPeer>

## Local installation of iPeer

<https://github.com/ubc/iPeer/blob/master/readme.md>

## Prerequisites

<https://github.com/ubc/compair#development-prerequisites>

- Docker Desktop for Mac contains Docker Engine and Docker Compose
- npm is installed

## Install

In Mac terminal:

```bash
mkdir -p ~/Code/ctlt && cd $_
git clone https://github.com/ubc/iPeer.git
```

## Build

```bash
cd ~/Code/ctlt/iPeer
docker-compose up -d --build
```
```
ERROR: for 7627c664aa24_ipeer_web_unittest  
Cannot start service web-unittest: b'driver failed programming external connectivity on endpoint ipeer_web_unittest 
ERROR: for web-unittest  Cannot start service web-unittest: b'driver failed programming external connectivity on endpoint ipeer_web_unittest 
(102a703dbc60ddcbda1fdf3fa11371553dc720ceac3ceef3d552d81dbbda68ac): 
Error starting userland proxy: listen tcp 0.0.0.0:8081: bind: address already in use'
ERROR: Encountered errors while bringing up the project.
```

### Fix port in ipeer_web_unittest

> McAfee Security Endpoint for Mac uses port 8081.

Change ports in `docker-compose.yml`: `services.web-unittest.ports`.

```diff
- - "8081:80"
+ - "8082:80"
```

```bash
cd ~/Code/ctlt/iPeer
docker-compose down
docker-compose up -d
```

Success.

### Install PHP Webdriver and Sausage under `vendors` directory.

```bash
git submodule init
git submodule update
```

### Run installation wizard

Browse to: <http://localhost:8080>

I see "Installation Wizard"

- Step 1: System Requirements Check
- Step 2: License Agreement
    - Check ON `I Accept the GPL License`
- Step 3: iPeer Database Configuration
    - Check ON `Installation with Sample Data`
- Step 4: System Parameters Configuration
    - Username: `root`
    - Password: `password`
    - Confirm Password: `password`

I see "iPeer Installation Complete!"

Browse to: <http://localhost:8080/login>

- root
- password

OK. I'm logged in.

### Modify users.lti_id type

```bash
docker exec -it ipeer_db mysql ipeer -u ipeer -p -e "ALTER TABLE users MODIFY lti_id VARCHAR(64) NULL DEFAULT NULL;"
```

## Dump original data

```bash
cd ~/Code/ctlt/iPeer
docker-compose up -d
docker exec -it ipeer_db sh -c "mysqldump ipeer -u ipeer -p > /tmp/ipeer.reset.sql"
docker exec -it ipeer_db ls -lAFh /tmp
docker cp ipeer_db:/tmp/ipeer.reset.sql ~/Code/ctlt/iPeer/app/config/lti13/canvas/
```