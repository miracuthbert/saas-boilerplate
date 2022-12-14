<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 3/9/2018
 * Time: 11:29 AM
 */

namespace SAAS\App\ViewComposers;

use Illuminate\View\View;
use PragmaRX\Countries\Package\Countries;

class CountriesComposer
{
    /**
     * Implements countries collection.
     *
     * @var $countries
     */
    private $countries;

    /**
     * Bind countries to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        if (!$this->countries) {
            $this->countries = Countries::where('dialling.calling_code.0', '!=', '')
                ->sortBy('dialling.calling_code.0')
                ->all();

            $countries = $this->countries->map(function ($item, $key) {
                return [
                    'name' => $item->name->common,
                    'dial_code' => $item['dialling']['calling_code'][0],
                ];
            });

            $this->countries = $countries;
        }

        $view->with('countries', $this->countries);
    }
}