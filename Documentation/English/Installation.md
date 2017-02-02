# Installation #

* Download the extension via Shopware Store
* Install it via Plugin Manager

# Configuration #

* configuration takes completely place in shopware backend plugin config via plugin manager

## General ##

### Include FontAwesome ###

Include FontAwesome 4.7.0 (http://fontawesome.io/) from CDN to display nice icons for the social login buttons. Disable it if you already have included FontAweseome 
or want to override default styling.

### Country Fallback ###

Select the country which should be used if the plugin cannout determine a country for the customer during social login. A country is mandatory 
for the customer so you should select the country here.
 
...we will optimize this process soon

## Hybrid Auth ##

### Debug Mode ###

You can choose one of the debug modes. The are the same as hybridauth library uses. You can read more about this here http://hybridauth.sourceforge.net/userguide/Debugging_and_Logging.html

### Debug File ###

Enter the path where the debug file is located here.

## Facebook ##

At first go to https://developers.facebook.com/ and register a new application.

* Add new Application
* Enter your information
* Add **Facebook Login**
* activate **Client-OAuth-Anmeldung** and **Web-OAuth-Anmeldung** 
* activate **Browser Control Redirect**
* enter Valid OAuth Redirect URIs
  * this URL should look like: 
  
```  
  http://www.shopware-portrino.de/hybridauth?hauth_done=Facebook
```

### Enabled ###

Set Facebook :: Enabled to `Yes`.

### App-ID ###

Enter your App-ID, which you can find on your application dashboard into the field: "Facebook :: App-ID".

### App-Secret ###

Enter your App-Secret, which you can find on your application dashboard into the field: "Facebook :: App-Secret".

### Scope ###

Enter your custom scope in this textarea. 
More information can be found here: https://developers.facebook.com/docs/facebook-login/permissions .

_! Clear the cache after you have made configuration changes_

## Google ##

At first go to https://console.developers.google.com/ and create a new application

* _Create Project_
* Wait until the project is created
* Go to _Credentials_
* _Create Credentials_
* _Create OAuth client ID_
* Enter _OAuth consent screen data_
* _Create client ID_
  * Enter the Name you wish to use
  * Enter the Authorised redirect URIs
  * this URL __MUST__ look like this:
   
```  
  http://www.shopware-portrino.de/hybridauth?hauth_done
```

* store the _client ID_ and _client secret_ or copy it directly into your plugin configuration

* Enable Google+ API in your API console

### Enabled ###

Set Google :: Enabled to `Yes`.

### Client-ID ###

Enter your Client-ID, which you can find on your application credentials section into the field: "Google :: Client-ID".

### Clientkey ###

Enter your Clientkey, which you can find on your application credentials section into the field: "Google :: Clientkey".

### Scope ###

Enter custom scopes to retrieve more or less information from google by adding them here. More information can be found 
here: https://developers.google.com/identity/protocols/googlescopes .

_! Clear the cache after you have made configuration changes_


## Amazon ##

* first of all you have to use SSL to get amazon social login working

At first go to https://sellercentral.amazon.com/gp/homepage.html and register a new application

* _Register new application_
* Enter your data
* Go to "Web Settings"
* Get the __Client ID__ and the __Client Secret__
* Enter the Allowed Return URLs 
  * this URL __MUST__ look like this:
  
```  
  https://www.shopware-portrino.de/hybridauth?hauth.done=Amazon
```

* store the _client ID_ and _client secret_ or copy it directly into your plugin configuration

### Enabled ###

Set Amazon :: Enabled to `Yes`.

### Client-ID ###

Enter your Client-ID, which you can find on your _Web Settings_ section into the field: "Amazon :: Client-ID".

### Client Secret ###

Enter your Client Secret, which you can find on your _Web Settings_ section into the field: "Amazon :: Client Secret".

_! Clear the cache after you have made configuration changes_

## LinkedIn ##

### Enabled ###

Set LinkedIn :: Enabled to `Yes`.

At first go to https://www.linkedin.com/developer/apps/ and create a new application

* Enter your data
* Go to "Authentication"
* Enter the Allowed Return URLs 
  * this URL __MUST__ look like this:

```  
  https://www.shopware-portrino.de/hybridauth?hauth.done=LinkedIn
```

* store the _client ID_ and _client secret_ or copy it directly into your plugin configuration

### Client-ID ###

Enter your Client-ID, which you can find on your _Web Settings_ section into the field: "Amazon :: Client-ID".

### Client Secret ###

Enter your Client Secret, which you can find on your _Web Settings_ section into the field: "Amazon :: Client Secret".

_! Clear the cache after you have made configuration changes_
