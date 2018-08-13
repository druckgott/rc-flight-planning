# rc-flight-planning
A tool to plan aircraft planning on a model day with a large number of pilots

Hallo, diesen kleine Onlinetool ist dazu gedacht, um an größeren Flugtagen eine Pilotenreihenfolge für die Modellfliegen aufzustellen.
Jeder Pilot hat einen Virtuellen Schieber mit Info zum Flugzeug und kann von den Flugplanern in die Werteliste eingeworfen werden. 

Für die Installtion ist eine MYSQL Datenbank und eine PHP Server notwendig.

In der Datei: ./flugtag_liste/V1.36/admin/database.php müssen die Datenbankeinstellungen gemacht werden. Zudem muss z.B. über PHP myadmin die SQL Datenbank installiert werden.
Dazu muss zum einen Folgende Datei ausgeführt werden:
flugtag_liste\V1.36\flugtag_2017.sql, 
sowie diese hier: einstellungen.sql 
als auch die einzelnen Inhalte dieser Datei:
SQL_Updates_Seit_V1_27.txt

Im Backend, das umbedigt mit einem htaccess geschützt werden sollte, können dann Piloten, sowie Flugzeuge angelegt werden. Es gibt dann eine Seite die auf einem TV angezeigt werden kann, als auch z.B. auf dem Handy oder einen PC aufgerufen werden kann.

Pilotengruppen können angelegt werden usw.

Viel Spaß damit, über eine kleine Spende würde ich mich freuen, wenn ihr zufrieden seit.

<a href="https://paypal.me/druckgott/10">
  <img alt="Support via PayPal" src="https://cdn.rawgit.com/twolfson/paypal-github-button/1.0.0/dist/button.svg"/>
</a>

------------------------------------------------------------------------------------------------

Hello, this little online tool is meant to set up a pilot order for the model flies on larger days of flight.
Each pilot has a virtual slider with information about the aircraft and can be thrown into the list of values ​​by the flight planners.

The installation requires a MYSQL database and a PHP server.

In the file: ./flugtag_liste/V1.36/admin/database.php the database settings must be made. In addition, e.g. via PHP myadmin the SQL database will be installed.
To do this, the following file must be executed:
flugtag_liste \ V1.36 \ flugtag_2017.sql,
as well as this here: settings.sql
as well as the individual contents of this file:
SQL_Updates_Seit_V1_27.txt

In the backend, which should be umbedigt protected with an htaccess, then pilots, and aircraft can be created. There is then a page that can be displayed on a TV as well as e.g. on the phone or a PC can be called.

Pilot groups can be created, etc.

Have fun with a small donation, I would be happy if you are satisfied.

<a href="https://paypal.me/druckgott/10">
  <img alt="Support via PayPal" src="https://cdn.rawgit.com/twolfson/paypal-github-button/1.0.0/dist/button.svg"/>
</a>


INFO:

The fontello icons are used thx for it:
https://github.com/fontello/fontello
