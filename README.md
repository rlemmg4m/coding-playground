# API #

## Quick Setup ##

Run
```bash
composer install
```
This should download required dependencies including elastic search which is used as a data store as
well as faker for the mock seeding.

Run 'seedReturnsSearchDataDev_structure_1.php' with

```bash
php seedReturnsSearchDataDev_structure_1.php
```

This will insert 10K records of fake data (more if the file constants are changed) into the single index

Run 'seedReturnsSearchDataDev_structure_2.php' with

```bash
php seedReturnsSearchDataDev_structure_1.php
```

This will insert 10K records of fake data into each different index (orders,tracking-reference,enquiries)
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
http://0.0.0.0:8081/search?search_id=12345
```
Will run the search controller with 12345 being the ID to look for

The local version of elastic search is located
```bash
http://localhost:9200
```
It can be interacted with via the URL Syntax e.g.
```bash
http://localhost:9200/index_id/index_type/_search?
```
