<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MemberContactRepository;
use App\Entities\MemberContact;
use App\Validators\MemberContactValidator;

/**
 * Class MemberContactRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MemberContactRepositoryEloquent extends BaseRepository implements MemberContactRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MemberContact::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }



    /**
     * Specify Validator class name
     *
     * @return mixed
     */
    public function validator()
    {
        return MemberContactValidator::class;
    }

}
