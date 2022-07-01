<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Member;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;

class MemberController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {
        $members = Member::with(['user' => function ($q) {
            $q->select('id', 'name');
        }])->select('id', 'member_id', 'name', 'gender', 'mobile', 'blood_group', 'photo', 'create_by', 'status')
            ->orderBy('id', 'DESC')->get();

        return success_response($members);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            "name"        => "required|max:50",
            "gender"      => "required",
            "mobile"      => "required|min:11|max:11|unique:members",
            "blood_group" => "required",
            "address"     => "required",
            "photo"       => "required",
        ]);

        # Check validation
        if ($validator->fails()) return validation_error($validator->errors());

        try {
            $photo = image_upload($request->photo, 'members');

            $member = Member::create([
                'member_id'   => uniqid(),
                'name'        => $request->name,
                'gender'      => $request->gender,
                'mobile'      => $request->mobile,
                'blood_group' => $request->blood_group,
                'address'     => $request->address,
                'photo'       => $photo['path'],
                'create_by'   => auth()->id(),
            ]);

            $member->member_id = date('Y') . str_pad($member->id, 6, 0, STR_PAD_LEFT);
            $member->save();

            return success_response($member, __('message.member.create.success'), 201);
        } catch (Exception $e) {
            return error_response(__('message.member.create.error'));
        }
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $member = Member::with('user')->find($id);
        return $member ? success_response($member) : error_response(__('message.member.manage.not_found'), 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param         $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $member = Member::find($id);

        if ($member) {
            $validator = Validator::make($request->all(), [
                "name"        => "required|max:50",
                "gender"      => "required",
                "mobile"      => "required|min:11|max:11|unique:members,id," . $id,
                "blood_group" => "required",
                "address"     => "required",
            ]);

            # Check validation
            if ($validator->fails()) return validation_error($validator->errors());

            try {
                $member->name        = $request->name;
                $member->gender      = $request->gender;
                $member->mobile      = $request->mobile;
                $member->blood_group = $request->blood_group;
                $member->address     = $request->address;
                $member->create_by   = auth()->id();

                if (strlen($request->photo) > 100) {
                    $photo         = image_upload($request->photo, 'members');
                    $member->photo = $photo['path'];
                }

                $member->update();

                return success_response($member, __('message.member.update.success'), 202);
            } catch (Exception $e) {
                return error_response(__('message.member.update.error'));
            }
        } else {
            return error_response(__('message.member.manage.not_found'), 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id)
    {
        try {
            if ($member = Member::find($id)) {
                $member->delete();
                return success_response([], __('message.member.manage.deleted'), 203);
            } else {
                return error_response(__('message.member.manage.not_found'), 404);
            }
        } catch (Exception $e) {
            return error_response(__('message.foreign_key'));
        }
    }

    public function statusCheck()
    {
        $today        = date('Y-m-d');
        $warning_date = date('Y-m-d', time() + 5 * 24 * 60 * 60);
        DB::enableQueryLog();
        DB::table('members')->update(array('status' => 'expired'));
        DB::statement("UPDATE `members` SET `status`='active' WHERE `member_id` in ( SELECT `member_id` FROM `invoices` WHERE `start_date`<=? and `end_date`>=?)", array($today, $today));
        DB::statement("UPDATE `members` SET `status`='limited' WHERE `member_id` in ( SELECT `member_id` FROM `invoices` WHERE `start_date`<=? and `end_date`>=?)", array($warning_date, $warning_date));
        DB::table('members')->where('lock', 1)->update(array('status' => 'locked'));

        return DB::getQueryLog();
    }
}
