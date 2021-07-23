# Obesity Control App (backend)

## Description
This is the backend repository for the Obesity Control App project.

Obesity Control App is a personal project that consists of a web application for a supposed obesity clinic interested in providing obesity treatments to its patients.

The application allows:
- That **patients** enter weekly data on their physical state and can consult the treatment that is being assigned to these states.
- That **doctors** can assign treatments to the physical states of patients who have not yet been assigned treatment, as well as search for patients to consult their history of states.
- That the **office staff** can manage the users of the application.
- That the **administrator** can do the same tasks as doctors and office personnel, and also be able to manage the treatments offered by the entity.

The backend is an API RESTful developed with <a href="https://laravel.com/" target="_blank"> <img src="public/favicon.ico"> </a> version **8**, to which any frontend can be connected through its endpoints.
The frontend is in this [repository](https://github.com/noxxic3/o-c-a-frontend).

## Project Set Up

* Install dependencies
```
composer install
```

* Create the `.env` file
```
cp .env.example .env
```

* Generate an app encryption key
```
php artisan key:generate
```

* Create an empty database (the project currently uses MySQL)

* Add database information in the `.env` file
```
DB_CONNECTION=mysql
DB_HOST=
DB_PORT=
DB_DATABASE=your_db_name
DB_USERNAME=
DB_PASSWORD=
```

* Import in the previously created database the `.sql` dump file located in the directory `/database/_dump`.

* Create the symlink from `/public` to  `/storage/app/public/`.
```
php artisan storage:link
```

* Add in the folder `/storage/app/public/` the directory that contains the initial image files.


<!---
### Endpoints (API REST routes)

List the routes? It would be a long list and also, these are already on the frontend.
-->

<!---
## Contribution (Forking)
-->

## Licensing
This project is licensed under the <a href="https://opensource.org/licenses/MIT" target="_blank">MIT license</a>.  

### Credits
This project includes graphic resources taken from the following sites: 
<a href="https://www.freepik.com/" target="_blank">Freepik</a>, 
<a href="https://pixabay.com/" target="_blank">Pixabay</a>, 
<a href="https://thenounproject.com/" target="_blank">The Noun Project</a>, and 
<a href="https://fontawesome.com/" target="_blank">Font Awesome</a>, all licensed with attribution.