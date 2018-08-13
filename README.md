# rc-flight-planning
A tool to plan aircraft planning on a model day with a large number of pilots

Hallo, dieses kleine Onlinetool ist dazu gedacht, um an größeren Flugtagen eine Pilotenreihenfolge für die Modellflieger aufzustellen.
Jeder Pilot hat einen virtuellen "Schieber" mit Info zum Flugzeug und den Namen des Piloten und kann von den Flugplanern in die Warteliste eingeworfen werden. 

Für die Installation ist eine MYSQL Datenbank und eine PHP Server notwendig.

In der Datei: /admin/database.php müssen die Datenbankeinstellungen gemacht werden. Zudem muss z.B. über PHP myadmin die SQL Datenbank erstellt und angelegt werden.
Dazu muss folgende Datei ausgeführt werden:
flugtag_2017.sql

Im Backend, das umbedingt mit einem htaccess Password geschützt werden sollte, können dann Piloten, sowie Flugzeuge angelegt, verschoben, editiert ... werden . Es gibt eine extra Seite die auf einem TV angezeigt werden kann. Diese kann aber auch z.B. auf dem Handy oder einen PC aufgerufen werden und aktuallisiert sich alle paar Sekunden.

Fluggruppen können angelegt werden usw. (siehe auch Changelog)

Bilder siehe weiter unten

Viel Spaß damit. Über eine kleine Spende würde ich mich freuen, wenn ihr zufrieden seit, da ich das alles Privat und in meiner Freizeit gemacht habe.

<a href="https://paypal.me/druckgott/10">
  <img alt="Support via PayPal" src="https://cdn.rawgit.com/twolfson/paypal-github-button/1.0.0/dist/button.svg"/>
</a>


------------------------------------------------------------------------------------------------

Hello, this little online tool is meant to set up a pilot order for model airplanes on larger days of flight.
Each pilot has a virtual "slider" with information on the aircraft and the name of the pilot and can be dropped by the flight planners on the waiting list.

The installation requires a MYSQL database and a PHP server.

In the file: /admin/database.php the database settings must be made. In addition, e.g. PHP myadmin creates and creates the SQL database.
To do this, the following file must be executed:
flugtag_2017.sql

In the backend, which should absolutely be protected with an htaccess password, pilots and planes can be created, moved, edited .... There is an extra page that can be viewed on a TV. However, this can also be, for example, be called on the phone or a PC and be updated every few seconds.

Flight groups can be created, etc. (see also changelog)

Pictures below

Have fun with it. About a small donation, I would be happy, if you are satisfied since, since I have done everything in private and in my spare time.

<a href="https://paypal.me/druckgott/10">
  <img alt="Support via PayPal" src="https://cdn.rawgit.com/twolfson/paypal-github-button/1.0.0/dist/button.svg"/>
</a>

<img src="https://github.com/druckgott/rc-flight-planning/blob/master/tempsnip.png" alt="Bild1">
<img src="https://github.com/druckgott/rc-flight-planning/blob/master/tempsnip2.png" alt="Bild2">


INFO:

The fontello icons are used thx for it:
https://github.com/fontello/fontello
