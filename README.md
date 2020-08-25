## Usage
- Run `git clone https://github.com/noisedaddy/gcalendar.git` 
- Run `composer install` 
- Run `npm install`
- Copy .env.example to .env `cp .env.example .env`
- Run `php artisan key:generate`
- Add `GOOGLE_CALENDAR_ID=applicantapplicant099@gmail.com
       GOOGLE_CALENDAR_AUTH_PROFILE=oauth` to .env file
- Create `/storage/app/google-calendar` folder and copy files `credentials.json` and `token.json` to that folder to be able to authenticate to google api
- Run `sudo chmod -R 777 storage/` and `sudo chmod -R 777 bootstrap/` to add permissions to storage 
- Run `composer dump-autoload` and `php artisan optimize:clear`
## Notice
- `GOOGLE_CALENDAR_ID` is `applicantapplicant099@gmail.com` and form validates email using laravel validation. 
- You can use any email in submission form, application will submit events to `applicantapplicant099@gmail.com` google account.
- Phone number is in the description of the event
