# Documentación de la API de Notas

## Rutas de la API

| Método | URI                        | Descripción                          | Parámetros Requeridos                                           | Ejemplo de Solicitud                              |
|--------|----------------------------|-------------------------------------|----------------------------------------------------------------|---------------------------------------------------|
| GET    | /api/notes                 | Listar todas las notas              | Ninguno                                                       | `GET http://example.com/api/notes`            |
| GET    | /api/notes/sorted          | Listar notas ordenadas              | `sort_by` (string: `creation_date` o `due_date`)           | `GET http://example.com/api/notes/sorted?sort_by=creation_date` |
| POST   | /api/notes                 | Crear una nueva nota                | `title`, `description`, `creation_date`, `due_date`, `user_id`, `tags`, `image` | `POST http://example.com/api/notes` con JSON: <br> `{ "title": "Nota 1", "description": "Descripción", "creation_date": "2024-01-01", "due_date": "2024-01-10", "user_id": 1, "tags": "tag1,tag2", "image": "url-imagen" }` |
| GET    | /api/notes/{id}            | Mostrar una nota específica         | `id` (int)                                                    | `GET http://example.com/api/notes/1`          |
| PUT    | /api/notes/{id}            | Actualizar una nota                 | `title`, `description`, `creation_date`, `due_date`, `user_id`, `tags`, `image` | `PUT http://example.com/api/notes/1` con JSON: <br> `{ "title": "Nota Actualizada", "description": "Nueva Descripción", "creation_date": "2024-01-01", "due_date": "2024-01-15", "user_id": 1, "tags": "tag1", "image": "nueva-url-imagen" }` |
| DELETE | /api/notes/{id}            | Eliminar una nota                   | `id` (int)                                                    | `DELETE http://example.com/api/notes/1`       |

## Comandos de Consola

| Comando                                 | Descripción                                        | Parámetros Opcionales                           | Ejemplo de Uso                                        |
|-----------------------------------------|---------------------------------------------------|------------------------------------------------|------------------------------------------------------|
| `php artisan note index`                | Listar todas las notas                            | Ninguno                                        | `php artisan note index`                             |
| `php artisan note show --id={id}`       | Mostrar una nota específica                       | `--id` (int)                                   | `php artisan note show --id=1`                       |
| `php artisan note create --title={title} --description={description} --due_date={due_date} --user={user_id} --tags={tags} --image={image}` | Crear una nueva nota | `--title`, `--description`, `--due_date`, `--user`, `--tags`, `--image` | `php artisan note create --title="Nota 1" --description="Descripción" --due_date="2024-01-10" --user=1 --tags="tag1,tag2" --image="url-imagen"` |
| `php artisan note update --id={id} --title={title} --description={description} --due_date={due_date} --user={user_id} --tags={tags} --image={image}` | Actualizar una nota | `--id`, `--title`, `--description`, `--due_date`, `--user`, `--tags`, `--image` | `php artisan note update --id=1 --title="Nota Actualizada" --description="Nueva Descripción" --due_date="2024-01-15" --user=1 --tags="tag1" --image="nueva-url-imagen"` |
| `php artisan note destroy --id={id}`    | Eliminar una nota                                | `--id` (int)                                   | `php artisan note destroy --id=1`                    |

## Notas

- Asegúrate de que tu servidor de Laravel esté en ejecución antes de hacer las solicitudes.
- Las respuestas de la API suelen ser en formato JSON.
- Puedes usar herramientas como Postman o cURL para probar las solicitudes a la API.
- Utiliza los comandos de consola para interactuar con la API de notas de manera sencilla y efectiva.
