# MixUp API

> API for [MixUp](http://mixup.site)

This is the API in use for the MixUp site. It currently supports the following services
- [Github Trending](https://github.com/trending/?since=daily)
- [Top stories on HackerNews](https://news.ycombinator.com)
- [Stories on Medium's frontpage](https://medium.com)
- News headlines, from [NewsAPI](https://newsapi.org)
- [Indiehackers](https://indiehackers.com)

## Build Setup

``` bash
# create .env file
cp .env.example .env

# generate encryption key
php artisan key:generate

# install dependencies
composer install

# start the server 
php artisan serve --port=9090
```

## License

The MIT License (MIT)

Copyright (c) 2018 Olumide Falomo