# Craft – Guest Entries Email Notification
Extend Pixel &amp; Tonic&rsquo;s [Guest Entries](https://github.com/pixelandtonic/GuestEntries/) plugin with email notifications.

**NOTE: this plugin requires the Guest Entries plugin version 1.5.0 or greater**

## Installation
1. Upload the guestentriesemail/ folder to your craft/plugins/ folder.
2. Enable the plugin in the CP.
3. Configure settings to setup emails based on content types.

## Email Notification
Here&rsquo;s the scenerio. I&rsquo;m a big fan of saving a copy of form submissions into the database as a backup for clients. While the [Contact Form](https://github.com/pixelandtonic/ContactForm/) plugin is great for a very basic contact form, I often find myself needing other form fields that have their own validation needs. The [Guest Entries](https://github.com/pixelandtonic/GuestEntries/) plugin works great for creating the backup entries, but it just lacks the notification to the client that a new submission has been added.

Currently, all this plugin does is take the field values submitted through a Guest Entries-based form and emails it to a list of people of your choosing in a `Field Name`: `Field value` pattern. I haven't fully tested this out for fields other than basic text and textarea form fields, so I don't know if it will work with things like checkboxes or radio/select fields.

For now I'm not planning on releasing this as a fully fleshed out plugin unless it turns out to be useful for other devs. If you want to see it grow or if you find any bugs, please contact me, send in a pull request, or drop a note in Issues.

## Releases
#### *0.1.0*
* Send basic emails from text and textarea form fields

Please, let me know if this plugin is useful or if you have any suggestions or issues. [@wbrowar](https://twitter.com/wbrowar)