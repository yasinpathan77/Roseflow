<?php

namespace SpondonIt\Service\Repositories;
ini_set('max_execution_time', -1);

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class LicenseRepository
{
    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    public function revoke()
    {
		//
    }


    public function revokeModule($params)
    {
		//
    }

    protected function disableModule($module_name, $row = false, $file = false)
    {
		//
    }

    public function revokeTheme($params)
    {
		//

    }

}
