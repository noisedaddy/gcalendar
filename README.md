## Usage
- Run `git clone https://github.com/noisedaddy/gcalendar.git` 
- Run `composer install` 
- Run `npm install`
- Copy .env.example to .env `cp .env.example .env`
- Run `php artisan key:generate`
- Add `GOOGLE_CALENDAR_ID=applicantapplicant099@gmail.com
       GOOGLE_CALENDAR_AUTH_PROFILE=oauth` to .env file
- Add your mail credentials(`MAIL_HOST, MAIL_PORT, MAIL_USERNAME, MAIL_PASSWORD,MAIL_ENCRYPTION`) to .env file to be able to send mails
- If does not exist, create `/storage/app/google-calendar` folder and copy files `credentials.json` and `token.json` to that folder to be able to authenticate to google api. FOlder must be writable
- Run `composer dump-autoload` and `php artisan optimize:clear`
- Run `sudo chmod -R 777 storage/` and `sudo chmod -R 777 bootstrap/` to add permissions to storage folder

## Notice
- `GOOGLE_CALENDAR_ID` is `applicantapplicant099@gmail.com` and form validates email using laravel validation. 
- You can use any email in submission form, application will submit events to `applicantapplicant099@gmail.com` google account.
- Phone number is in the description of the event
