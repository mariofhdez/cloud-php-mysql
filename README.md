# Aplicación PHP CRUD - Problemas de Rendimiento en Kubernetes

## 📋 Descripción

Aplicación web simple con CRUD de usuarios y mensajes desarrollada con:
- **Backend**: PHP 8.1
- **Base de Datos**: MySQL 8.0
- **Containerización**: Docker
- **Orquestación**: Kubernetes

## ⚠️ Estado Intencional

Esta aplicación **contiene deliberadamente problemas de rendimiento** para demonstrar:
- Consultas SQL sin optimización
- Falta de índices en base de datos
- Alto consumo de CPU en picos de tráfico
- Problemas de escalabilidad
- Gestión inadecuada de recursos en Kubernetes

## 🚀 Inicio Rápido

### Requisitos
- Docker & Docker Compose
- kubectl
- Kubernetes cluster (minikube, Docker Desktop, etc.)
- Apache Bench (opcional, para pruebas)

### 1. Pruebas locales con Docker Compose

```bash
# Construir imagen
docker build -t php:latest .

# Ejecutar con docker-compose
docker-compose up -d

# Acceder a la aplicación 
# http://localhost:8080
```

### 2. Despliegue con Kubernetes

```bash
# Construir imagen
docker build -t php:latest .

# Configuración del registry local
# Para levantar un registro local
docker run -d -p 5000:5000 --name registry registry:2
# Etiquetar la imagen (ajustar con tu registry)
docker tag php-app:latest localhost:5000/php-app:latest
docker push localhost:5000/php-app:latest


# Crear el namespace
kubectl apply -f kubernetes/namespace.yaml

# Crear secrets
kubectl apply -f kubernetes/secrets.yaml

# Crear configmap
kubectl apply -f kubernetes/configmap.yaml

# Desplegar mysql 
kubectl apply -f kubernetes/mysql.yaml

# Desplegar aplicación PHP
kubectl apply -f kubernetes/deployment.yaml

# Configurar servicios
kubectl apply -f kubernetes/service.yaml

# Verificar despliegue
kubectl get deployments -n php-mysql
kubectl get pods -n php-mysql
kubectl get services -n php-mysql

# Acceder a la ip
# http://localhost:30080

```


### 3. Despliegue con Minikube

```bash
# Construir imagen
docker build -t php:latest .

# Activar minikube
kubectl minikube start --driver=docker

# Cargar la imagen local al minikube
minikube image load php-app:latest

# Crear el namespace
kubectl apply -f kubernetes/namespace.yaml

# Crear secrets
kubectl apply -f kubernetes/secrets.yaml

# Crear configmap
kubectl apply -f kubernetes/configmap.yaml

# Desplegar mysql 
kubectl apply -f kubernetes/mysql.yaml

# Desplegar aplicación PHP
kubectl apply -f kubernetes/deployment.yaml

# Configurar servicios
kubectl apply -f kubernetes/service.yaml

# Verificar despliegue
kubectl get deployments -n php-mysql
kubectl get pods -n php-mysql
kubectl get services -n php-mysql

# Para obtener la URL de acceso con minikube
minikube service php-svc-nodeport -n php-mysql
```
## 🛠️ Comandos Útiles

```bash
# Ver estado general
kubectl get all -n app-namespace

# Describir deployment
kubectl describe deploy php-app -n app-namespace

# Ver eventos en tiempo real
kubectl get events -n app-namespace -w

# Logs en tiempo real
kubectl logs -f -l app=php-app -n app-namespace --all-containers=true

# Ejecutar comando en pod
kubectl exec -it <pod-name> -n app-namespace -- bash

# Port-forward
kubectl port-forward svc/php-app-service 8080:80 -n app-namespace

# Escalar replicas (no recomendado, empeorará los problemas)
kubectl scale deployment php-app --replicas=5 -n app-namespace

## Detener el contenedor desplegado en docker-compose con parámetros
docker-compose down -rmi all --volumes

# -rmi all: Elimina las imágenes asociadas al contenedor
# --volumes: Elimina los volumenes (eliminar persistencia)

## Detener el despliegue con minikube
kubectl stop

## Eliminar información relacionada con el despliegue
kubectl delete 

# sin parámetros elimina el clúster
# all --all: elimina pods, deployments, services, replicaSets
# deployment [nombre]: elimina un deployment específico
# service [nombre]: elimina un servicio específico
```

## 📝 Notas de Desarrollo

- **Base de Datos**: Inicia con 5 usuarios y 5 mensajes de ejemplo
- **Validación**: Mínima, enfocada en mostrar problemas
- **Seguridad**: No recomendado para producción (inyección SQL posible)
- **Versión PHP**: 8.1 con Apache
- **Versión MySQL**: 8.0

## 🔧 Próximos Pasos (Optimizaciones)

Esta aplicación es el punto de partida perfecto para:
1. Configurar resource limits en K8s
2. Agregar health checks
3. Implementar HPA (Horizontal Pod Autoscaler)

### Otras posibles mejoras identificadas
4. Agregar logging centralizado
5.  Implementar monitoring con Prometheus
6. Agregar índices a la base de datos
7. Implementar prepared statements
8. Agregar paginación
9. Implementar caching (Redis)
10. Optimizar queries (EXPLAIN ANALYZE)

## 📚 Referencias

- [PHP PDO](https://www.php.net/manual/en/book.pdo.php)
- [MySQL Best Practices](https://dev.mysql.com/doc/)
- [Kubernetes Best Practices](https://kubernetes.io/docs/concepts/cluster-administration/manage-deployment/)
- [Docker Documentation](https://docs.docker.com/)

## 📄 Licencia

Propósito educativo. Libre para usar y modificar.
