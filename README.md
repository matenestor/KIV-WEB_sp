# KIV-WEB_sp

This is semestral project for class KIV/WEB.  
Conference website for posting and reviewing articles.

**Authors** writes articles about topic of the conference.
**Reviewers** makes reviews on the articles. There may be 3 of them to make a review.
**Admin** posts or refuses the articles and may block/allow or delete user.

## Install

1. Install database to your server with `db_create.sql` and `db_fill.sql` in _.install/database_ directory.
2. Configure setting in `settings.inc.php` in _app/_ directory

    ```
        /** Database address */
        define("DB_SERVER", "<adress-of-your-server>"); // eg. localhost
        /** Database name */
        define("DB_NAME", "web_conference"); // leave like this, or rename, if you renamed the database
        /** Database username */
        define("DB_USER", "<your-username>");
        /** Database password */
        define("DB_PASS", "<your-password>");
    ```

3. Go to url: _\<adress-of-your-server\>/KIV-WEB_sp_, eg <a href="localhost/KIV-WEB_sp">localhost/KIV-WEB_sp</a>

## Default data

Users: **admin**, **author1**, **author2**, **reviewer1**, **reviewer2**, **reviewer3**, **reviewer4**  
Articles: **title1**, **title2**, **title3**

Password of each user is: **password**
