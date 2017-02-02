# Installation #

* Laden Sie das Plugin aus dem Shopware Store herunter
* Installieren es im Plugin Manager

# Configuration #

* Die Konfiguration findet komplett im Konfigurationsbereich des Plugins im PluginManager statt.

## Allgemein ##

### FontAwesome einbinden ###

Standardmäßig wird FontAweseome 4.7.0 (http://fontawesome.io/) via CDN eingebunden, um die Icons für die Social Login 
Buttons anzuzeigen. Deaktivieren Sie es wenn Sie bereits FontAwesome eingebunden haben oder selbst das Styling übernehmen 
möchten. 

### Country Fallback ###

Wählen Sie das Land aus, welches genommen werden soll insofern das Plugin nicht in der Lage ist anhand der Information 
des Nutzers welches es vom Social Provider bekommt abzuleiten aus welchem Land dieser kommt (z.B.: Name des Landes, ISO Code, ...). 
Da die Auswahl eines Landes von Shopware für alle Kunden gefordert wird, muss hier eines als _Fallback_ ausgewählt werden.
 
...Wir werden dies versuchen in naher Zukunft zu optimieren

## Hybrid Auth ##

### Debug Mode ###

Sie können einen der Debug Modi wählen, welcher auch von der HybridAuth Bibliothek genutzt wird. Mehr dazu unter: http://hybridauth.sourceforge.net/userguide/Debugging_and_Logging.html

### Debug File ###

Geben Sie hier den Pfad ein, in welchem die Debug Datei gespeichert werden soll.

## Facebook ##

Gehen Sie zunächst auf https://developers.facebook.com/ und registrieren eine neue Applikation. 

* Neue App erstellen
* Geben Sie Ihre Information ein
* **Facebook Login** hinzufügen
* Aktivieren Sie **Client-OAuth-Anmeldung**, **Web-OAuth-Anmeldung** und **Browser Control Redirect**
* Geben Sie eine gültige OAuth Redirect URI ein 
  * diese URL sollte folgendes Format haben:
  
```  
  http://www.shopware-portrino.de/hybridauth?hauth_done=Facebook
```

### Aktiviert ###

Setzen Sie Facebook :: Aktiviert auf `Ja`.

### App-ID ###

Geben Sie ihre App-ID ein, welche Sie auf dem dashboard in der Facebook Developer Oberfläche finden im Feld "Facebook :: App-ID" ein.

### App-Secret ###

Geben Sie ihren App-Geheimcode ein, welche Sie auf dem dashboard in der Facebook Developer Oberfläche finden im Feld "Facebook :: App-Geheimcode" ein.

### Scope ###

Geben sie hier ihren benutzerdefinierten Scope an. Mehr Information dazu unter: https://developers.facebook.com/docs/facebook-login/permissions .

_! Leeren Sie den Shop cache, nachdem Sie Änderungen an der Konfiguration vorgenommen haben_

## Google ##

Gehen Sie zunächst auf https://console.developers.google.com/ und registrieren eine neue Applikation. 

* _Projekt erstellen_
* Warten Sie bis das Projekt erstellt wurde - das kann eine Weile dauern...
* Gehen Sie zu _Zugangsdaten_
* _Anmeldedaten erstellen_
* _OAuth-Client-ID_
* _OAuth Zustimmungsbildschirm_
* _Client-ID für Webanwendung_
  * Geben Sie den Namen den Sie für Ihre Applikation verwenden möchten
  * Geben Sie die Autorisierte Weiterleitungs-URI ein
  * diese sollte folgendermaßen aussehen:
   
```  
  http://www.shopware-portrino.de/hybridauth?hauth_done
```

* Speichern sie sich die _client ID_ und den _Clientschlüssel_ oder kopieren Sie beide direkt in die Pluginkonfiguration.

* Aktivieren Sie die **Google+ API** in der API Console

### Aktiviert ###

Setzen Sie Google :: Aktiviert auf `Ja`.

### Client-ID ###

Geben Sie ihre Client-ID ein, welche Sie in der API-Console finden im Feld "Google :: Client-ID" ein.


### Clientschlüssel ###

Geben Sie ihren Clientschlüssel ein, welchen Sie in der API-Console finden im Feld "Google :: Clientschlüssel" ein.

### Scope ###

Geben Sie hier ihren benutzerdefinierten Scope an um mehr oder weniger Information vom Nutzer während des Single Sign On 
Prozess abzufragen. Mehr Information dazu unter: https://developers.google.com/identity/protocols/googlescopes .

_! Leeren Sie den Shop cache, nachdem Sie Änderungen an der Konfiguration vorgenommen haben_


## Amazon ##

Zu aller erst ist eine SSL Verbindung zu Ihrer Webseite notwendig damit das SSO via Amazon funktioniert.
Gehen Sie zunächst auf https://sellercentral.amazon.com/gp/homepage.html und registrieren eine neue Applikation. 

* _Register new application_
* Daten eingeben
* "Web Settings" aufrufen
* __Client ID__ und __Client Secret__ kopieren
* Geben Sie die **Allowed Return URL**  ein
  * diese sollte folgendermaßen aussehen:
  
```  
  https://www.shopware-portrino.de/hybridauth?hauth.done=Amazon
```

* Speichern sie sich die __Client ID__ und den __Client Secret__  oder kopieren Sie beide direkt in die Pluginkonfiguration.

### Aktiviert ###

Setzen Sie Amazon :: Aktiviert auf `Ja`.

### Client-ID ###

Geben Sie ihre Client-ID ein, welche Sie unter Web Settings ihrer Applikation in der Amazon Seller Central finden im Feld "Amazon :: Client-ID" ein.

### Clientschlüssel ###

Geben Sie ihren Clientschlüssel ein, welchen Sie unter Web Settings ihrer Applikation in der Amazon Seller Central finden im Feld "Amazon :: Clientschlüssel" ein.

_! Leeren Sie den Shop cache, nachdem Sie Änderungen an der Konfiguration vorgenommen haben_

## LinkedIn ##

Gehen Sie zunächst auf https://www.linkedin.com/developer/apps/ und registrieren eine neue Applikation. 


* Geben Sie ihre Daten ein
* Navigieren Sie zu "Authentication"
* Geben Sie die **Allowed Return URL** ein 
  * diese sollte folgendermaßen aussehen:

```  
  https://www.shopware-portrino.de/hybridauth?hauth.done=LinkedIn
```

* Speichern sie sich die __Kunden-ID__ und das __Kundengeheimnis__  oder kopieren Sie beide direkt in die Pluginkonfiguration.


### Aktiviert ###

Setzen Sie LinkedIn :: Aktiviert auf `Ja`.

### Client-ID ###

Geben Sie ihre Kunden-ID im Feld "LinkedIn :: Kunden-ID" ein.

### Clientschlüssel ###

Geben Sie ihre Kundengeheimnis im Feld "LinkedIn :: Kundengeheimnis" ein.

### Fields ###

Geben Sie hier benutzerdefinierte Felder an um mehr oder weniger Information vom Nutzer während des Single Sign On 
Prozess abzufragen. Mehr Information dazu unter: https://developer.linkedin.com/docs/fields .

_! Leeren Sie den Shop cache, nachdem Sie Änderungen an der Konfiguration vorgenommen haben_
