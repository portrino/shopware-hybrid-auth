# Portrino HybridAuth - 1.0.0#

Shopware Plugin for Social Login

## Product information ##

**Make it easy for your customers to log onto the Shopware shop with the help of the social log-in!**

Social login is a very useful feature used by many applications to get the user logged in easily via
Facebook, Google, etc.

Give your customers the option to sign in via any social account with the help of the "SocialLogin" to your shop easily 
and conveniently with just one click.

### New customer process ###
If the customer is not yet registered in your shop, he or she will be logged in after successful authentication against 
one of the social providers.
 
If the master data is no completed the user can fullfil them as usual in his account. In the case that the user 
wants to checkout without all master data shopware will prompt him to enter his data.

We have refrained from doing a seperate registration after social login, to prevent that the 
user leaves your shop due the complexity of the registration form.

### Existing customer process ###

Users who are already a customer in your shop, as long as the social login cookie is still valid 
are automatically logged into the shop. If the cookie is not available, the customer can sign in 
to the shop through the social log-in. A new registration is not needed here.

#### Special Case "equal email addresses" ####

If the user logs in via Google and wants to log in later via Facebook an he has the same email address on both social 
providers we **connect** the identity from Facebook to the already existing Google customer account on the shopware 
system.

#### Special Case "passwort" ####

The password will be during the login process, because shopware needs a password for each user. Unfortunatly
the user not know this password. The only way he can reset this is to click "Password Forgot?" and reset the 
passwort via email.

### Logout process ###

If the user presses the "Logout button", we logout him from all social providers so that he should reauthenticate 
when visiting the shop againt. Logout from all providers does not mean logging him out from Facebook or Google - 
that is not possible ;-) 