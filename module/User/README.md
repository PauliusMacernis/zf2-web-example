The User module requires a database to be created in order to work.

If we want to use this module in another application where the user has completely different properties then we need to
create another user entity class with the correct annotations. We would also then need to add a service manager
application definition that overwrites the existing user entity definition, and points to the new user entity class.
We do not need to overwrite the form because it will be up to date with the user entity used. The authentication adapter
need not be overwritten either, as long as the email is the identity. If that is not the case we can overwrite the
auth-adapter service with one that works with our new user entity.

Finally, if we want use another password adapter for the user, we can overwrite the password-adapter service. Our User
module is quite flexible in that aspect. The other functionality related to page protection is also exposed via
services and can be overwritten to match the application requirements.

All definitions of triggered events resides in Module.php file.