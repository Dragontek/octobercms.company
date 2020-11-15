<?php namespace Dragontek\Company\Controllers;

use BackendMenu;
use Flash;
use Dragontek\Company\Models\Role;
use Lang;

/**
 * Roles Back-end Controller
 */
class Roles extends Controller
{

    public $requiredPermissions = ['dragontek.company.access_employees'];

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('Dragontek.Company', 'company', 'roles');
    }

    /**
     * Deleted checked roles.
     */
    public function index_onDelete()
    {
        if (($checkedIds = post('checked')) && is_array($checkedIds) && count($checkedIds)) {

            foreach ($checkedIds as $roleId) {
                if (!$role = Role::find($roleId)) {
                    continue;
                }

                $role->delete();
            }

            Flash::success(Lang::get('dragontek.company::lang.roles.delete_selected_success'));
        } else {
            Flash::error(Lang::get('dragontek.company::lang.roles.delete_selected_empty'));
        }

        return $this->listRefresh();
    }
}
