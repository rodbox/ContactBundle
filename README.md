# ContactBundle

Gestion simple d'un annuaire téléphonique par API (ApiController.php) ou le crud (ContactController.php).

## Configuration

app/AppKernel.php
`
    new RB\ContactBundle\RBContactBundle(),
`

app/routing.yml
`
    rb_contact:
	    resource: "@RBContactBundle/Controller/"
    	type:     annotation
    	prefix:   /
`

app/config.yml
`
import:
	...
    - { resource: "@RBContactBundle/Resources/config/services.yml" }
`

## API

Pour la partie API il faut configurer son serveur Apache pour autoriser les requetes d'origine exterieur et les differences methods des requêtes. 

pour plus d'information: [enable-cors.org/server_apache.html](https://enable-cors.org/server_apache.html)
### Configuration Apache :
`sudo nano /etc/apache2/apache2.conf`
Ajouter
`<Directory /var/www/html/api>
	Header add Access-Control-Allow-Origin "*" // ou les origins autorisées.
	Header add Access-Control-Allow-Headers "origin, x-requested-with, content-type"
	Header add Access-Control-Allow-Methods "PUT, GET, POST, DELETE, OPTIONS"
</Directory>`