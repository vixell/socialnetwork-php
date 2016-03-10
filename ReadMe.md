# How to use `SocialNetwork` Class #

  1. Configure Constant Variables
  1. Call methods


## Configure Constant Variables ##

### Get Twitter Token ###
You have to create an application twitter as Browser
https://dev.twitter.com/apps/new

After submit, get your Consumer key and your Consumer secret in OAuth Section.
And replace into the twitter.inc.php file

Launch twitter.php and get your TOKEN ;)


### Get Your Facebook Token ###

First, create facebook application here : http://www.facebook.com/developers/createapp.php

Secondly, get your API Key and SECRET Key here:
http://www.facebook.com/developers/apps.php

### Get Your Bit.Ly API KEY ###

Go On Bit.ly http://bit.ly/a/account
Get Your API Key.


## Methods ##

### `SocialNetwork::postToTwitter($My_Message);` ###

This method post $My\_Message on your twitter account linked to your application.

The message was parse to shorten links with Bit.ly service.

The method return the tweet's status.


### `SocialNetwork::postOnFacebookFanPage($message,$title,$caption,$picture,$description,$link,$action)` ###

  * $message : The message what you want to attach to your link
  * $title : the link's title
  * $caption : the legend's title
  * $picture : the picture's src
  * $description : A short description
  * $link : the link ;)
  * $action : This is an array of Action . See an example:
```
$action = array(
array('name' => 'Action name', 'link' => 'http://')
);
```

To Allow your facebook application to publish on a facebook page, you have to configure your Fan page.

Replace APPLICATION\_ID (you can get this on your facebook apps list - http://www.facebook.com/developers/apps.php )
and go to
http://www.facebook.com/connect/uiserver.php?app_id=APPLICATION_ID&next=http://www.facebook.com/&display=popup&locale=fr_FR&perms=publish_stream&enable_profile_selector=1&fbconnect=true&legacy_return=1&method=permissions.request


And select your facebook fan page.