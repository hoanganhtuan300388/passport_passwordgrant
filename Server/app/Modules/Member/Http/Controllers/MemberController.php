<?php

namespace App\Modules\Member\Http\Controllers;

use App\Entities\Contact;
use App\Repositories\ContactRepository;
use App\Repositories\MemberRepository;
use App\Validators\BaseValidatorInterface;
use App\Validators\MemberContactValidator;
use App\Validators\MemberSettingValidator;
use App\Validators\MemberValidator;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Http\Controllers\AccessTokenController as AccessToken;
use Prettus\Validator\Exceptions\ValidatorException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class MemberController extends AppController
{

    protected $memberRepository;
    protected $memberValidator;
    protected $contactRepository;
    protected $memberContactValidator;
    protected $memberSettingValidator;


    public function __construct(
        MemberRepository $memberRepository,
        MemberValidator $memberValidator,
        ContactRepository $contactRepository,
        MemberContactValidator $memberContactValidator,
        MemberSettingValidator $memberSettingValidator
    )
    {
        parent::__construct();

        $this->memberRepository         = $memberRepository;
        $this->memberValidator          = $memberValidator;
        $this->contactRepository        = $contactRepository;
        $this->memberContactValidator   = $memberContactValidator;
        $this->memberSettingValidator   = $memberSettingValidator;
    }


    /**
     * Member register api
     *
     * @param Request $request
     * @param AccessToken $accessObj
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidatorException
     */
    public function register(Request $request, AccessToken $accessObj)
    {
        DB::beginTransaction();
        try {
            $this->memberValidator->with($request->all())->passesOrFail(BaseValidatorInterface::RULE_MEMBER_REGISTER);

            $memberData = [
                'username'  => $request->get('username'),
                'password'  => Hash::make($request->get('password')),
                'name'      => $request->get('name'),
                'avatar'    => $request->has('avatar') ? $request->get('avatar') : null,
                'city'      => $request->has('city') ? $request->get('city') : null,
                'country'   => $request->has('country') ? $request->get('country') : null,
                'birthday'  => $request->has('birthday') ? $request->get('birthday') : null,
                'gender'    => $request->has('gender') ? $request->get('gender') : 'other',
                'status'    => 'active',
            ];

            $contactData = [
                'email'         => $request->get('email'),
                'mobile_phone'  => $request->has('mobile_phone') ? $request->get('mobile_phone') : null,
                'home_phone'    => $request->has('home_phone') ? $request->get('home_phone') : null,
                'office_phone'  => $request->has('office_phone') ? $request->get('office_phone') : null,
                'address1'      => $request->has('address1') ? $request->get('address1') : null,
                'address2'      => $request->has('address2') ? $request->get('address2') : null,
            ];

            $settingData = [
                'display_location'  => $request->has('display_location') ? $request->get('display_location') : 0,
                'display_contact'   => $request->has('display_contact') ? $request->get('display_contact') : 1,
                'offline_email'     => $request->has('offline_email') ? $request->get('offline_email') : 1,
            ];

            $member = $this->memberRepository->create($memberData);
            $member->contact()->create($contactData);
            $member->setting()->create($settingData);
            $member->load('contact', 'setting');

            $output = [
                'member'    => $member,
                'token'     => parent::getAccessInfo($request->get('username'), $request->get('password'), $accessObj)
            ];

            DB::commit();
            return $this->jsonResponse(STATUS_CREATED, __('Register member success'), $output);
        } catch (ValidatorException $exception) {
            DB::rollback();
            throw $exception;
        }
    }


    /**
     * Member login api with password grant
     *
     * @param Request $request
     * @param AccessToken $accessObj
     * @return \Illuminate\Http\JsonResponse
     * @throws UnauthorizedHttpException
     * @throws ValidatorException
     */
    public function login(Request $request, AccessToken $accessObj)
    {
        try {
            $login = $request->only(['username', 'password']);
            $this->memberValidator->with($login)->passesOrFail(BaseValidatorInterface::RULE_MEMBER_LOGIN);

            $token = parent::getAccessInfo($login['username'], $login['password'], $accessObj);

            if (empty($token->error)) {
                $member = $this->memberRepository->with(['contact', 'setting'])
                    ->findWhere([
                        'username'  => $login['username'],
                    ], [
                        'id', 'username', 'name', 'avatar', 'city', 'country', 'birthday', 'gender', 'status'
                    ])
                    ->first();

                $output = [
                    'member'    => $member,
                    'token'     => $token
                ];

                return $this->jsonResponse(STATUS_CREATED, __('SignIn success'), $output);
            } else {
                throw new UnauthorizedHttpException(__('Invalid credentials'));
            }
        } catch (ValidatorException $exception) {
            throw $exception;
        }
    }


    /**
     * Member logout api
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        $member = auth()->guard('api')->user()->token();
        $member->revoke();

        return $this->jsonResponse(STATUS_CREATED, __('Logout success'));
    }


    /**
     * Member get profile api
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function profile(Request $request)
    {
        $output = auth()->guard('api')->user();
        $output->load('contact', 'setting');

        return $this->jsonResponse(STATUS_OK, __('Member profile'), $output);
    }


    /**
     * Member update profile api
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidatorException
     */
    public function editMember(Request $request)
    {
        DB::beginTransaction();
        try {
            $member = auth()->guard('api')->user();
            $this->memberValidator->setId($member->id);
            $this->memberValidator->with($request->all())->passesOrFail(BaseValidatorInterface::RULE_MEMBER_EDIT_PROFILE);

            $memberData = [
                'id'        => $member->id,
                'name'      => $request->get('name'),
                'city'      => $request->has('city') ? $request->get('city') : $member->city,
                'country'   => $request->has('country') ? $request->get('country') : $member->country,
                'birthday'  => $request->has('birthday') ? $request->get('birthday') : $member->birthday,
                'gender'    => $request->has('gender') ? $request->get('gender') : $member->gender
            ];

            $member->update($memberData);
            $member->load('contact', 'setting');

            $output = $member;

            DB::commit();
            return $this->jsonResponse(STATUS_CREATED, __('Update member profile success'), $output);
        } catch (ValidatorException $exception) {
            DB::rollback();
            throw $exception;
        }
    }


    /**
     * Member update contact api
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidatorException
     */
    public function editContact(Request $request)
    {
        DB::beginTransaction();
        try {
            $member = auth()->guard('api')->user();
            $this->memberContactValidator->setId($member->contact->id);
            $this->memberContactValidator->with($request->all())->passesOrFail(BaseValidatorInterface::RULE_UPDATE);

            $contactData = [
                'email'         => $request->has('email') ? $request->get('email') : $member->contact->email,
                'mobile_phone'  => $request->has('mobile_phone') ? $request->get('mobile_phone') : $member->contact->mobile_phone,
                'home_phone'    => $request->has('home_phone') ? $request->get('home_phone') : $member->contact->home_phone,
                'office_phone'  => $request->has('office_phone') ? $request->get('office_phone') : $member->contact->office_phone,
                'address1'      => $request->has('address1') ? $request->get('address1') : $member->contact->address1,
                'address2'      => $request->has('address2') ? $request->get('address2') : $member->contact->address2,
            ];

            $member->contact->update($contactData);
            $member->load('contact', 'setting');

            $output = $member;

            DB::commit();
            return $this->jsonResponse(STATUS_CREATED, __('Update member contact success'), $output);
        } catch (ValidatorException $exception) {
            DB::rollback();
            throw $exception;
        }
    }


    /**
     * Member update setting api
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidatorException
     */
    public function editSetting(Request $request)
    {
        DB::beginTransaction();
        try {
            $member = auth()->guard('api')->user();
            $this->memberSettingValidator->setId($member->setting->id);
            $this->memberSettingValidator->with($request->all())->passesOrFail(BaseValidatorInterface::RULE_UPDATE);

            $settingData = [
                'display_location'  => $request->has('display_location') ? $request->get('display_location') : $member->setting->display_location,
                'display_contact'   => $request->has('display_contact') ? $request->get('display_contact') : $member->setting->display_contact,
                'offline_email'     => $request->has('offline_email') ? $request->get('offline_email') : $member->setting->offline_email,
            ];

            $member->setting->update($settingData);
            $member->load('contact', 'setting');

            $output = $member;

            DB::commit();
            return $this->jsonResponse(STATUS_CREATED, __('Update member setting success'), $output);
        } catch (ValidatorException $exception) {
            DB::rollback();
            throw $exception;
        }
    }


    /**
     * Member add friend api
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidatorException
     */
    public function friend(Request $request)
    {
        DB::beginTransaction();
        try {
            $member = auth()->guard('api')->user();
            $request->merge(['member_id' => $member->id]);

            $this->memberValidator->with($request->all())->passesOrFail(BaseValidatorInterface::RULE_MEMBER_ADD_FRIEND);

            $member->friends()->attach($request->get('friend_id'));

            DB::commit();
            return $this->jsonResponse(STATUS_CREATED, __('Add friend success'));
        } catch (ValidatorException $exception) {
            DB::rollback();
            throw $exception;
        }
    }


    /**
     * Group add member api
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws ValidatorException
     */
    public function group(Request $request)
    {
        DB::beginTransaction();
        try {
            $this->memberValidator->with($request->all())->passesOrFail(BaseValidatorInterface::RULE_MEMBER_ADD_GROUP);

            $member = $this->memberRepository->findWhere(['id' => $request->get('member_id')])->first();

            $member->groups()->attach($request->get('group_id'));

            Contact::where(['group_id' => $request->get('group_id')])
                ->update(['action_at' => date('Y-m-d H:i:s')]);

            DB::commit();
            return $this->jsonResponse(STATUS_CREATED, __('Add member to group success'));
        } catch (ValidatorException $exception) {
            DB::rollback();
            throw $exception;
        }
    }

}
