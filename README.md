# Основы работы с Kubernetes (часть 3)

Установка:

```shell
git clone https://github.com/vmeling/kubernetes-part3.git
cd kubernetes-part3
# Установка базы данных
helm install pg bitnami/postgresql -f pg-chart/values.yaml 
helm install app user-chart
```

Проверка:

В корне репозитория лежит коллекция Postman (postman_collection.json)