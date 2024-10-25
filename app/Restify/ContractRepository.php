<?php

namespace App\Restify;

use App\Models\Contract;
use App\Models\User;
use App\Notifications\ContractNotification;
use Binaryk\LaravelRestify\Http\Requests\RestifyRequest;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

class ContractRepository extends Repository
{
    public static string $model = Contract::class;
    public static array $search = ['invoice_image', 'product_image','code' ,'description', 'total_amount', 'deposit_amount', 'confirmation_a', 'confirmation_b', 'confirmation_c', 'terms_agreed', 'status', 'estimated_delivery_date', 'post_id', 'viewed'];

    public static function indexQuery(RestifyRequest $request, Relation|Builder $query): Builder
    {
        if ($request->user()->type == 'seller') {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('id', $request->user()->id);
            });
        } else {
            $query->whereHas('partyAInfo', function ($q) use ($request) {
                $q->where('user_id', $request->user()->id);
            });
        }
        return parent::indexQuery($request, $query);
    }

    public static function stored($resource, RestifyRequest $request)
    {
        $contract = Contract::find($resource->id);
        $contract->status = 'new';
        $contract->confirmation_c = true;
        $contract->viewed_a = false;
        $contract->viewed_b = false;
        $contract->save();
        if ($resource->id_user_b != null) {
            $user = User::find($resource->id_user_b);
            $userA = $contract->partyAInfo->user;
            $user->notify(new ContractNotification('contract', 'Bạn có một hợp đồng mới',
                'Bạn có một hợp đồng mới từ ',$contract->id, $userA));
            sendFirebaseNotification($user->phone_token, 'Bạn có một hợp đồng mới', 'Bạn có một hợp đồng mới từ ' . $resource->partyAInfo->user->name, [
                'type' => 'contract',
                'id' => $resource->id,
                'user' => $resource->partyAInfo->user,
            ]);
        }
    }

    public static function related(): array
    {
        return [
            'partyAInfo' => PartyAInfoRepository::class,
            'partyBInfo' => PartyBInfoRepository::class,
            'products' => ProductRepository::class,
            ];
    }

    public function store(RestifyRequest $request)
    {
        if ($request->user()->type == 'seller') {
            return response()->json(['message' => 'Bạn không có quyền thực hiện hành động này'], 403);
        }
//        if ($request->post_id) {
//            $post = $request->user()->posts()->find($request->post_id);
//            if (!$post) {
//                return response()->json(['message' => 'Bài viết không tồn tại'], 404);
//            }
//        }
        $request->merge(['code' => 'HD' . time()]);
        return parent::store($request);
    }


    public function update(RestifyRequest $request, $repositoryId){
        if ($request->hasFile('invoice_image')) {
            $invoiceImagePath = $this->handleFileUpload($request, 'invoice_image', 'invoices');
            $request->merge(['invoice_image' => $invoiceImagePath]);
        }

        if ($request->hasFile('product_image')) {
            $productImagePaths = $this->handleFileUpload($request, 'product_image', 'products');
            //json_encode($productImagePaths);
            $productImagePaths = json_encode($productImagePaths);
            $request->merge(['product_image' => $productImagePaths]);
        }

        return parent::update($request, $repositoryId);
    }

    /**
     * Handle file uploads for both single and multiple files.
     *
     * @param RestifyRequest $request
     * @param string $inputName
     * @param string $storagePath
     * @return array|string
     */
    protected function handleFileUpload(RestifyRequest $request, string $inputName, string $storagePath) {
        $files = $request->file($inputName);
        if (is_array($files)) {
            $paths = [];
            foreach ($files as $file) {
                $paths[] = $this->uploadFile($file, $storagePath);
            }
            return $paths;
        } else {
            return $this->uploadFile($files, $storagePath);
        }
    }

    /**
     * Upload a single file and return its storage path.
     *
     * @param UploadedFile $file
     * @param string $storagePath
     * @return string
     */
    protected function uploadFile($file, string $storagePath) {
        $filename = time() . '_' . $file->getClientOriginalName();
        return $file->storeAs($storagePath, $filename, 'public');
    }

    public function fields(RestifyRequest $request): array
    {
        return [id(), field('invoice_image'),
            field('product_image'),
            field('description'),
            field('code')->canUpdate(fn() => false),
            field('total_amount')->storingRules('required')->messages(['required' => 'Tổng số tiền không được để trống',]),
            field('deposit_amount')->storingRules('required')->messages(['required' => 'Số tiền đặt cọc không được để trống',]),
            field('post_id')->storingRules('required')->messages(['required' => 'Bài viết không được để trống',]),
            field('id_party_b_info'),
            field('id_user_b')->storingRules(['required', 'exists:users,id'])->messages(['required' => 'Người dùng bên B không được để trống', 'exists' => 'Người dùng bên B không tồn tại',]),
            field('id_party_a_info')->storingRules('required', 'exists:party_a_infos,id')->messages(['required' => 'Thông tin bên A không được để trống', 'exists' => 'Thông tin bên A không tồn tại',]),
            field('viewed_a'),
            field('viewed_b'),
            field('confirmation_a'),
            field('confirmation_b'),
            field('confirmation_c'),
            field('terms_agreed'),
            field('status'),
            field('estimated_delivery_date'),];
    }
}
