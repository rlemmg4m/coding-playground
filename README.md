# API #

## Quick Setup ##

Run
```bash
composer install
```
This should download required dependencies including elastic search which is used as a data store as
well as faker for the mock seeding.

Run 'seedReturnsSearchDataDev.php' with

```bash
php seedReturnsSearchDataDev.php
```

This will insert 1000 records of fake data, feel free to mofigy it to suit your needs.

## Running with Docker ##

**Using docker-compose with terminal output**

```bash
docker-compose up
```

**Using docker-compose detached**

```bash
docker-compose up -d
```
This should install a local google app engine within docker with elastic-search
## Using / Viewing ##
To use the API locally with the docker image, using either Postman or a web-browser
you can visit or GET request
```bash
http://0.0.0.0:8081/search?[params]
```

The local version of elastic search is located
```bash
http://localhost:9200
```
It can be interacted with via the URL Syntax e.g.
```bash
http://localhost:9200/index_id/index_type/_search?
```
