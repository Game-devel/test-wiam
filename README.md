# API для подачи и обработки заявки на займ

Yii2 REST API для подачи и обработки заявок на займ.

## Требования

- Docker
- Docker Compose

## Затраченное время

- Настройка Docker (Nginx, PHP-FPM, PostgreSQL): ~2-3 часа
- Реализация API эндпоинтов: ~1-1.5 часа (AI first + refactor)

**Итого: ~4 часа**

## Запуск проекта


```bash
cp .env.example .env
```
```bash
docker-compose up -d
```

Приложение будет доступно по адресу: **http://localhost** (порт 80).

## Примеры запросов

```bash
# Подача заявки
curl -X POST http://localhost/requests \
  -H "Content-Type: application/json" \
  -d '{"user_id": 1, "amount": 3000, "term": 30}'

# Обработка заявок
curl "http://localhost/processor?delay=1"
```
