# STREAMING PROYECT

Para ejecutar este proyecto necesitaras un entorno con  Apache, MySQL y PHP.

Los requisitos del proyecto eran:

 1. Crear un login
 2. Crear un registro
 3. Mostrar todos los videos
 4. Mostrar los detalles de cada video
 5. Editar los videos
 6. Eliminar los videos
 7. Mostrar todos los actores
 8. Editar los actores
 9. Añadir los videos
 10. Añadir los actores

La estructura del poyecto es:
streaming_project_PHP/
├── config/
│   └── db.php
├── public/
│   ├── index.php
│   ├── register.php
│   ├── login.php
│   ├── logout.php
│   ├── dashboard.php
│   ├── show_videos.php
│   ├── show_actors.php
│   ├── details_videos.php
│   ├── details_actors.php
│   ├── edit_video.php
│   ├── edit_actor.php
│   ├── add_video.php
│   └── add_actor.php
├── src/
│   ├── VideoManager.php
│   ├── ActorManager.php
│   ├── Auth.php
│   └── User.php
├── temporal/
│   ├── compr_auth.php
│   └── compr_conexion.php
└── sql/
    └── database.sql
