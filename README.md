# Monitoring system prototype
Monitoring system prototype using InfluxDB as a metrics storage.

## System requirements
- Docker Compose

## Install and run
1. Run `cp .env.example .env`
2. Run `docker-compose up --build`
3. Visit InfluxDB UI: http://0.0.0.0:8086
4. Get new admin token and update it in `.env` and in `./docker/telegraf/telegraf.conf`
5. Reload project `docker-compose stop && docker-compose up`

## Usage
1. Run repeatedly `docker exec monitoring.php-fpm -- php /app/public/index.php`
2. See application metrics in InfluxDB UI on page: http://0.0.0.0:8086/orgs/\<org-hash>/data-explorer

## In future
- Alerts
- Grafana
- Must have Telegraf plugins
- Terraform

## License
MIT
