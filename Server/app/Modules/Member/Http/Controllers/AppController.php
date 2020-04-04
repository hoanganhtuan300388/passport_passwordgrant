<?php

namespace App\Modules\Member\Http\Controllers;

use App\Traits\ApiHandlerTrait;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Zend\Diactoros\ServerRequest;

class AppController extends Controller
{

    use ApiHandlerTrait;


    public function __construct()
    {

    }


    /**
     * get info access token with password grant
     *
     * @param $username
     * @param $password
     * @param $accessObj
     * @return mixed
     */
    public function getAccessInfo($username, $password, $accessObj)
    {
        $data = [
            'grant_type'    => GRANT_TYPE_PASSWORD,
            'client_id'     => CLIENT_ID_PASSWORD,
            'client_secret' => CLIENT_SECRET_PASSWORD,
            'username'      => $username,
            'password'      => $password
        ];

        $request = new ServerRequest($data);
        $request = $request->withParsedBody($data);

        return json_decode($accessObj->issueToken($request)->content());
    }

}
