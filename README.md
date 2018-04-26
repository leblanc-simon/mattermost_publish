# Shaarli Mattermost Publish

This project is a plugin for [Shaarli](https://github.com/shaarli/Shaarli). 

It's allow to publish all new link saved in your Shaarli instance to a [Mattermost](https://about.mattermost.com/)'s channel.

## Install

* Clone this project into the `plugins` folder of your Shaarli instance
* Create an incoming webhook in Mattermost : 
    * https://docs.mattermost.com/developer/webhooks-incoming.html
    * Main Menu > Integrations > Incoming Webhook
* Activate and configure the plugin into Shaarli instance with URL of incoming webhook (*required*), channel (*optional*) and username (*optional*)
* Publish new links into Shaarli :)

## License

License WTFPL : http://sam.zoy.org/wtfpl/

## Author

Simon Leblanc <contact@leblanc-simon.eu>
