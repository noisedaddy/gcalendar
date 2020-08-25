<?php


namespace App\Http\Controllers\Traits;

use Carbon\Carbon;

trait CalendarEventTrait
{

    /**
     * Adds event to google calendar
     * @param null $data
     * @return \Google_Service_Calendar_Event
     * @throws \Google_Exception
     */
    public function addEvent($data = null){

        $client = $this->getClient();
        $service = new \Google_Service_Calendar($client);

        $event = new \Google_Service_Calendar_Event();
        $event->setSummary($data['name']);
//        $event->setLocation();

        $event->setDescription('Description');
        $event->setVisibility('public');
        $start = new \Google_Service_Calendar_EventDateTime();
        $start->setDateTime(Carbon::create($data['datetimepicker']));
        $start->setTimeZone(config('app.timezone'));
        $event->setStart($start);
        $end = new \Google_Service_Calendar_EventDateTime();
        $end->setDateTime(Carbon::create($data['datetimepicker'])->addHour());
        $end->setTimeZone(config('app.timezone'));
        $event->setEnd($end);
        $reminder1 = new \Google_Service_Calendar_EventReminder();
        $reminder1->setMethod("email");
        $reminder1->setMinutes(15);
        $reminder2 = new \Google_Service_Calendar_EventReminder();
        $reminder2->setMethod("email");
        $reminder2->setMinutes(30);
        $reminder = new \Google_Service_Calendar_EventReminders();
        $reminder->setUseDefault(false);
        $reminder->setOverrides(array($reminder1, $reminder2));
        $event->setReminders($reminder);

        //$event->setRecurrence(array('RRULE:FREQ=WEEKLY;UNTIL=20110701T170000Z'));
//        $attendee1 = new Google_Service_Calendar_EventAttendee();
//        $attendee1->setEmail($email);
//        if ($accept == "true") {
//            $attendee1->setResponseStatus('accepted');
//        }
//        $attendees = array($attendee1);
//        $event->attendees = $attendees;
//        $optParams = array('sendNotifications' => true, 'maxAttendees' => 1000);
        /*$creator = new Google_Service_Calendar_EventCreator();
                $creator->setDisplayName("UNAD Calendar");
                $creator->setEmail("106295480288-s6a44jaogn7pembonh8mudn4gutbn28n@developer.gserviceaccount.com");

                $event->setCreator($creator);*/

//        $nEvent = $service->events->insert('applicantapplicant099@gmail.com', $event);
        $nEvent = $service->events->insert(env('GOOGLE_CALENDAR_ID'), $event);
        return $nEvent;
    }

    /**
     * Auth with oauth credentials
     * @return \Google_Client
     * @throws \Google_Exception
     */
    function getClient()
    {
        $client = new \Google_Client();
        $client->setApplicationName('Google Calendar API PHP Quickstart');
        $client->setScopes(\Google_Service_Calendar::CALENDAR);
        $client->setAuthConfig(storage_path('app/google-calendar/credentials.json'));
//        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        $tokenPath = storage_path('app/google-calendar/token.json');
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);

            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                // Request authorization from the user.
                $authUrl = $client->createAuthUrl();
                printf("Open the following link in your browser:\n%s\n", $authUrl);
                print 'Enter verification code: ';
                $authCode = trim(fgets(STDIN));

                // Exchange authorization code for an access token.
                $accessToken = $client->fetchAccessTokenWithAuthCode($authCode);
                $client->setAccessToken($accessToken);

                // Check to see if there was an error.
                if (array_key_exists('error', $accessToken)) {
                    throw new Exception(join(', ', $accessToken));
                }
            }
            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }
        return $client;
    }

    /**
     * Auth with account service - DEPRECATED
     * @return \Google_Client
     */
    public function getClientServiceAccount(){

        $client = new \Google_Client();
        //The json file you got after creating the service account
        putenv('GOOGLE_APPLICATION_CREDENTIALS='.storage_path('app/google-calendar/gcalendar-1598345431101-60755b6e583c.json'));
        $client->useApplicationDefaultCredentials();
        $client->setApplicationName("test_calendar");
        $client->setScopes(\Google_Service_Calendar::CALENDAR);
        $client->setAccessType('offline');

        return $client;
    }

}
