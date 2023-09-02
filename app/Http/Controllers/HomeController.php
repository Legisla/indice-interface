<?php

namespace App\Http\Controllers;


use App\Enums\Configs;
use App\Models\Congressperson;
use App\Models\Contact;
use App\Models\SiteConfig;
use App\Models\State;
use App\Models\Page;
use App\Helpers\Format;
use App\Http\Requests\ContactForm;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactReceived;


class HomeController extends Controller
{

    /**
     * @return View
     */
    public function index()
    {
        $homePage = (new Page())->getbyUri('home');

        return view('home', compact('homePage'));
    }

    /**
     * @return View
     */
    public function contacts()
    {
        $contactDetails = (new Page())->getbyUri(Route::getCurrentRoute()->getName());

        return view('contacts', compact('contactDetails'));
    }

    /**
     * @param ContactForm $request
     * @return RedirectResponse
     */
    public function storeContacts(ContactForm $request)
    {
        $contact = (new Contact());

        $contact->fill($request->all());
        $contact->save();

        if(config('mail.receivers.contact') != null) {
            Mail::to(config('mail.receivers.contact'))->send(new ContactReceived($contact));
        }

        Mail::to(config('mail.receivers.contact'))->send(new ContactReceived($contact));

        session()->flash('success-message', 'sucesso!');

        return redirect()->route('contatos');
    }

    /**
     * @return View
     */
    public function institutional()
    {
        $page = (new Page())->getbyUri(Route::current()->getName());

        if (!$page) {
            abort(404);
        }

        return view('institutional', compact('page'));
    }


    /**
     * @param $id
     * @return View
     */
    public function congressperson(int $id)
    {
        $congressperson = Congressperson::getDetails($id);

        if (!$congressperson) {
            abort(404);
        }

        $nationalExpenditure = (float)SiteConfig::getByKey(Configs::NATIONAL_AVERAGE);
        $stateExpenditure = State::getExpenditure($congressperson->fk_state_id);

        $statsData = Format::getStatsData($congressperson);

        list($officeTime, $partyTime) = Format::calculateTimes($congressperson);

        //@todo - implement this all
//            'last_electoral_coefficent' => 777777, (state level)
//            'last_votes' => 888888,

        return view('congressperson', compact(
            'congressperson',
            'nationalExpenditure',
            'stateExpenditure',
            'officeTime',
            'partyTime',
            'statsData',
        ));
    }

}
