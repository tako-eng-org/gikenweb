# gikenweb

https://tako-eng.com/

## Docker

```sh
# ビルド
docker-compose build

# アプリ起動(nginxを経由するアプリは全て起動します)
docker-compose up -d nginx
# access to http://localhost:8000

# pgAdmin
docker-compose up -d pgadmin
# access to http://localhost:8001
```
