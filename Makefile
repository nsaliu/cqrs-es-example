start:
	docker-compose up -d

stop:
	docker-compose down -v

bash:
	docker-compose exec php bash