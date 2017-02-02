# Portrino HybridAuth - 1.0.0 #

Shopware Plugin für Social Login

## Produktinformation ##

Ermöglichen Sie es Ihren Kunden sich über verschiedenste Soziale Netzwerke / Anbieter in Ihrem Shop anzumelden.

Social Logins sind sehr hilfreich und wird bereits von vielen WebApplikationen angeboten um sich schnell und einfach via
Facebook  Google oder Amazon zu registrieren bzw. einzuloggen.

Geben Sie Ihren Kunden die Chance sich mit einem Klick zu "connecten"!

### Prozess für neue Kunden ###

Wenn ein neuer Kunde sich via Social Login in Ihrem Shop registriert, wird er als Kunde in der Datenbank
angelegt und danach sofort eingeloggt.

Sollten seine Stammdaten nicht vollständig sein, muss er diese spätestens im Checkout Prozess ausfüllen.

Wir haben uns dagegen entschieden eine zusätzlichen Registrerungsschritt mit der Abfrage der restlichen Stammdaten 
nach dem Social Login einzubauen, da dies möglicherweise ein Hürde für den Kunden darstellt.

### Prozess bei bestehenden Kunden ###

Ist ein Nutzer bereits registrierter Kunde in Ihrem Shop wird diese solange der Social Login Cookie aktiv ist
eingeloggt. Ist der Cookie nicht mehr verfügbar oder die Session abgelaufen kann der Nutzer sich über 
einen Klick auf den jeweiligen Social Login Button anmelden. Eine erneute Registrierung ist nicht notwendig. 

Hinweis: Die Identifierung des Kunden erfolg über seine eindeutige ID, welche vom Social Provider vergeben wird.

#### Spezial Fall: "Kunde mit gleicher E-Mail Adresse bereits im System" ####

Ist beispielsweise ein Kunde bereits via Google in Ihrem Shop registriert und möchte sich später via 
Facebook anmelden und hat bei beiden Social Providern die gleiche E-Mail Adresse, so werden beide 
Identitäten verknüpft. Im Shop bleibt er ein Nutzer. Dieser Fall tritt jedoch recht selten auf, da die meisten
Nutzer sich üblicherweise über einen Social Provider anmelden.

#### Spezial Fall: Passwort ####

Um den Single Sign On Prozess so schlank wie möglich zu halten haben wir auf einen Zwischenschritt zur Registrierung 
verzichtet. Dadurch hat der Nutzer natürlich auch zunächst keine Möglichkeit ein Passwort für seinen Account 
einzugeben. Wir generieren ein zufälliges Passwort während des Single Sign On für den Kunden, da Shopware dies 
vorraussetzt.

Die einzige Möglichkeit das Passwort zu ändern ist es dieses via Anmeldeformular zurückzusetzen. Der Kunde bekommt
dann eine E-Mail und kann via Link das Passwort zurücksetzen.

### Prozess beim Ausloggen ###

Wenn ein angemeldeter Kunde den "Logout Button" klickt, loggen wir Ihn auch von allen Social Providers und 
invalidieren die Session. Bei Facebook, Google etc. selbst ist er natürlich noch angemeldet.