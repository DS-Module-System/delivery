# Delivery

Входящи доставки от доставчик към склад, с редове по продукт и количество. Складът слуша промените и обновява наличностите.

## Функционалност

- CRUD на доставки (дата, доставчик, склад, крайна цена)
- CRUD на редове (`DeliveryItem`: продукт + количество)
- Търсене и филтриране
- Роля за одобрение

## Интеграция в системата

Copy-in модул: файловете се копират в хоста под `App\`.

- Пътища: `src/Controller|Entity|Form|Repository/Delivery/`, `templates/delivery/`, `templates/delivery_item/`, `translations/delivery*.yaml`, `config/roles/delivery.yaml`
- Меню: Доставки (`delivery_list`) при `ROLE_DELIVERY_VIEW`
- Роли: `ROLE_DELIVERY_{VIEW,CREATE,EDIT,DELETE,APPROVE}`
- Маршрути: `/deliveries`, `/delivery-items/{deliveryId}`

Обновяването на стока е в **warehouse** (`DeliveryListener`), не в този модул.

## Структура

- `DeliveryController`, `DeliveryItemController`
- Ентитети: `Delivery`, `DeliveryItem`
- Форми: доставка, ред, търсене

## Зависимости

- **erp-core** (`BaseUser`)
- **supplier**
- **warehouse**
- **product**

## Документация

- [docs/delivery/README.md](docs/delivery/README.md)
- [docs/delivery/installation-guide.md](docs/delivery/installation-guide.md)
- [docs/delivery/installation-summary.md](docs/delivery/installation-summary.md)
- [docs/delivery/quick-start.md](docs/delivery/quick-start.md)
