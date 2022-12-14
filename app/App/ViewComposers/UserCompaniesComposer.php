<?php
/**
 * Created by PhpStorm.
 * User: Cuthbert Mirambo
 * Date: 4/28/2018
 * Time: 4:40 PM
 */

namespace SAAS\App\ViewComposers;

use Illuminate\View\View;

class UserCompaniesComposer
{
    private $teams;

    /**
     * Share list of roles.
     *
     * @param View $view
     */
    public function compose(View $view)
    {
        if (!$this->teams) {
            $this->teams = auth()->check() ? auth()->user()->teams : collect([]);
            
            if ($this->teams->count() > 0) {
                $this->teams->load([
                    'owner'
                ]);
            }
        }

        $view->with('teams', $this->teams);
    }

}