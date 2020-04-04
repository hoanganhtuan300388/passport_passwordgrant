<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\MemberSettingRepository;
use App\Entities\MemberSetting;
use App\Validators\MemberSettingValidator;

/**
 * Class MemberSettingRepositoryEloquent.
 *
 * @package namespace App\Repositories;
 */
class MemberSettingRepositoryEloquent extends BaseRepository implements MemberSettingRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return MemberSetting::class;
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
        return MemberSettingValidator::class;
    }
    
}
