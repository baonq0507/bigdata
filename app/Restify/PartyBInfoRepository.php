<?php

namespace App\Restify;

use App\Models\Contract;
use App\Models\PartyBInfo;
use App\Notifications\ContractNotification;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\Auth;

class PartyBInfoRepository extends Repository
{
    public static string $model = PartyBInfo::class;
    public static array $search = [
        'email', 'user_id', 'tax_id', 'bank_account_number', 'bank_name', 'business_name', 'position', 'address', 'phone_number', 'full_name'
    ];
    public static function indexQuery(RestifyRequest $request, Relation|Builder $query)
    {
        return parent::indexQuery($request, $query);
    }

    public function store(RestifyRequest $request)
    {
        $request->merge(['user_id' => $request->user()->id]);
        if (Auth::user()->type == 'buyer') {
            return response()->json(['message' => 'Bạn không có quyền thực hiện hành động này'], 403);
        }
        $contract = Contract::find($request->contract_id);
        if (!$contract) {
            return response()->json(['message' => 'Hợp đồng không tồn tại'], 404);
        }
        return parent::store($request);
    }

    public static function stored($resource, RestifyRequest $request){
        $contract = Contract::find($request->contract_id);
        $contract->id_party_b_info = $resource->id;
        $contract->confirmation_b = true;
        $contract->status = 'pending';
        $contract->save();
        $userA = $contract->partyAInfo->user;
        $userB = $contract->partyBInfo->user;
        $contract->partyAInfo->user->notify(new ContractNotification('contract', 'Đối tác đã xác nhận hợp đồng',
            'Đối tác đã xác nhận hợp đồng', $contract->id,$userA));
        sendFirebaseNotification(
            $contract->partyAInfo->user->phone_token,
            'Đối tác đã xác nhận hợp đồng',
            'Đối tác đã xác nhận hợp đồng', [
            'type' => 'contract',
            'id' => $contract->id,
            'user' => $userB,
        ]);
    }

    public function fields(RestifyRequest $request): array
    {
        return [
            id(),
            field('user_id'),
            field('email')->rules('email')->messages([
                'email' => 'Email không hợp lệ',
            ]),
            field('tax_id')->rules('required')->messages([
                'required' => 'Mã số thuế không được để trống',
            ]),
            field('bank_account_number')->rules('required')->messages([
                'required' => 'Số tài khoản ngân hàng không được để trống',
            ]),
            field('delivery_id')->rules('required')->messages([
                'required' => 'Mã giao dịch không được để trống',
            ]),
            field('bank_name')->rules('required')->messages([
                'required' => 'Tên ngân hàng không được để trống',
            ]),
            field('business_name')->rules('required')->messages([
                'required' => 'Tên doanh nghiệp không được để trống',
            ]),
            field('position')->rules('required')->messages([
                'required' => 'Chức vụ không được để trống',
            ]),
            field('address')->rules('required')->messages([
                'required' => 'Địa chỉ không được để trống',
            ]),
            field('phone_number')->rules('required')->messages([
                'required' => 'Số điện thoại không được để trống',
            ]),
            field('full_name')->rules('required')->messages([
                'required' => 'Họ và tên không được để trống',
            ])
        ];
    }
}
