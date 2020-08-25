<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Http\Controllers\Traits\CalendarEventTrait;
use App\Jobs\SendEmailNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CalendarController extends Controller
{
    use CalendarEventTrait;

    /**
     * home page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        return view('welcome');
    }

    /**
     * Store calendar event
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|numeric',
            'datetimepicker' => 'required|date_format:Y/m/d H:i',
            'captcha' => 'required|captcha',
        ]);

        $event = $this->addEvent($validatedData);

        if (isset($event->iCalUID)) {
            dispatch(new SendEmailNotification((object)$validatedData));
        } else {
            return response()->json('Something went wrong, please try again!');
        };

        return back()->with('success', 'Event submitted successfully.');

    }

    /**
     * Refresh captcha
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refreshCaptcha()
    {
        return captcha_img();
    }

}
