# PFO2 – Práctica Docker

Este proyecto levanta un servicio PHP que consulta MySQL usando Docker Compose.

## Estructura

```
PFO2/
├─ docker-compose.yml   # define servicios web y db
├─ Dockerfile           # imagen PHP que sirve index.php
├─ index.php            # página que lee la tabla people
└─ README.md            # este archivo
```

## Requisitos

* Docker Desktop o Docker Engine + Compose v2

## Puesta en marcha

```bash
# dentro de la carpeta PFO2
docker compose up -d
```

Servicios resultantes:

* Web: [http://localhost:8080](http://localhost:8080)
* MySQL: 127.0.0.1:3306  (usuario root / contraseña secret)

## SQL inicial

```sql
USE demo;
CREATE TABLE IF NOT EXISTS people (
  id   INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50)
);
INSERT INTO people (name) VALUES ('Ada'), ('Linus');
```

## index.php

```php
<?php
$pdo  = new PDO('mysql:host=db;dbname=demo','root','secret');
$rows = $pdo->query('SELECT * FROM people');

echo "<h1>Demo Docker</h1><ul>";
foreach ($rows as $r) echo "<li>{$r['name']}</li>";
echo "</ul>";
?>
```

## Dockerfile

```dockerfile
FROM php:8.2-fpm-alpine
COPY index.php /var/www/html/
WORKDIR /var/www/html
CMD ["php","-S","0.0.0.0:80","-t","/var/www/html"]
```

## docker-compose.yml

```yaml
services:
  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: secret
      MYSQL_DATABASE: demo
    volumes:
      - dbdata:/var/lib/mysql
    networks: [ webnet ]

  web:
    build: .
    depends_on: [ db ]
    ports:
      - "8080:80"
    networks: [ webnet ]

volumes:
  dbdata:

networks:
  webnet:
```

## Construir y publicar imagen

```bash
docker build -t yesicaluc/webapp:1.0 .
docker login
docker push yesicaluc/webapp:1.0
```

## Detener y limpiar

```bash
docker compose down          # detiene contenedores
docker compose down -v       # detiene y borra volumenes
```
