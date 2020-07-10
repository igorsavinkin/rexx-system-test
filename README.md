# Participation events data tables  
 
### The  has the following main files:
1. insert_json.php - to insert JSON data (events.json) into db
2. events.php - filtering and showing data in the screen 

## Installation
1. Clone the repository into an existing **PHP** enviroment.
2. Run the ``db_migration.php`` file to [drop  and] create db tables.  Alternatively you might get the content of the ``tables.sql`` file and run it at the **MySQL** server console or at the *phpMyAdmin*. 
3. Set up the **MySQL** database credentials inside of the ``db_config.php`` file.
4. Load the JSON data by running ``insert_json.php`` file.
5. Filter data ``events.php`` file.
