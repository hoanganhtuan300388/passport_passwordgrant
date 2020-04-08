<?php

namespace App\Modules\Member\Http\Controllers;

use App\Repositories\MessageRepository;
use App\Validators\MessageValidator;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class MessageController extends Controller
{

    protected $messageRepository;
    protected $messageValidator;


    public function __construct(
        MessageRepository $messageRepository,
        MessageValidator $messageValidator
    )
    {
        parent::__construct();

        $this->messageRepository = $messageRepository;
        $this->messageValidator  = $messageValidator;
    }

}
