# API #

## Running with App Engine SDK/Container ##

**Using dev_appserver.py**

```bash
dev_appserver.py .
```

**Or, with the "container" version of AppEngine**

```bash
./gae_local_container.sh
```

## Running with Docker ##

Based (at the time of writing) on the Gear4music PHP 7.1 + Apache 2.4 Alpine image.

### Build command ###

Execute from project root, feel free to use image name:tag as you see fit.

```bash
docker build -t g4m/my-app:dev -f _Dockerfile .
```

### Run command ###

Use environment and port details as you need, adn the image:tag name from above.

```bash
docker run --rm -e "APP_MODE=DEV" -p 32777:80  "g4m/my-app:dev"
```