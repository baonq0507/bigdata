<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\Delivery;
use App\Models\Product;
use App\Models\User;
use App\Models\UserDeliveryInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use ViettelPostAPI;

class ViettelPostController extends Controller
{
    public function getService(Request $request)
    {
        try {
            // Thu thập thông tin từ request
            $inputDelivery = $request->only(['sender_id', 'receiver_id']);
            $product = $request->only(['weight', 'price', 'length', 'width', 'height']);
            // Tìm thông tin giao hàng của người gửi và người nhận
            $sender = UserDeliveryInfo::find($inputDelivery['sender_id']);
            $receiver = UserDeliveryInfo::find($inputDelivery['receiver_id']);

            // Kiểm tra người gửi và người nhận có tồn tại không
            if (!$sender || !$receiver) {
                return response()->json(['error' => 'Không tìm thấy thông tin người gửi hoặc người nhận.'], 404);
            }
            // xóa " -" chuyen sang ","
            $sender->address = str_replace(' -', ',', $sender->address);
            $receiver->address = str_replace(' -', ',', $receiver->address);
            // Chuẩn bị dữ liệu cho API
            $input = [
                "SENDER_DISTRICT" => $sender->district_id,
                "SENDER_PROVINCE" => $sender->province_id,
                "RECEIVER_DISTRICT" => $receiver->district_id,
                "RECEIVER_PROVINCE" => $receiver->province_id,
                "PRODUCT_TYPE" => "HH",
                "PRODUCT_WEIGHT" => $product['weight'],
                "PRODUCT_PRICE" => $product['price'],
                "MONEY_COLLECTION" => "0",
                "PRODUCT_LENGTH" => $product['length'],
                "PRODUCT_WIDTH" => $product['width'],
                "PRODUCT_HEIGHT" => $product['height'],
                "TYPE" => 1,
            ];
            // Gọi API để lấy dịch vụ
            $ViettelPostAPI = new ViettelPostAPI();
            $response = $ViettelPostAPI->getService($input);

            // Trả về phản hồi từ API
            return response()->json($response);

        } catch (\Exception $e) {
            // Xử lý ngoại lệ nếu có
            return response()->json(['error' => 'Đã xảy ra lỗi: ' . $e->getMessage()], 500);
        }
    }


    public function getPrice(Request $request)
    {
        try {
            $sender = UserDeliveryInfo::find($request->get('sender_id'));
            $receiver = UserDeliveryInfo::find($request->get('receiver_id'));

            // Check if sender and receiver information is found
            if (!$sender || !$receiver) {
                return response()->json(['error' => 'Không tìm thấy thông tin người gửi hoặc người nhận.'], 204); // No Content
            }

            $data = [
                "PRODUCT_WEIGHT" => $request->input('weight'),
                "PRODUCT_PRICE" => $request->input('price'),
                "MONEY_COLLECTION" => 0,
                "ORDER_SERVICE_ADD" => $request->input('service_add'),
                "ORDER_SERVICE" => $request->input('service'),
                "SENDER_DISTRICT" => $sender->district_id,
                "SENDER_PROVINCE" => $sender->province_id,
                "RECEIVER_DISTRICT" => $receiver->district_id,
                "RECEIVER_PROVINCE" => $receiver->province_id,
                "PRODUCT_LENGTH" => $request->input('length'),
                "PRODUCT_WIDTH" => $request->input('width'),
                "PRODUCT_HEIGHT" => $request->input('height'),
                "PRODUCT_TYPE" => "HH",
                "NATIONAL_TYPE" => 1
            ];
            // Call API to get price
            $ViettelPostAPI = new ViettelPostAPI();
            $response = $ViettelPostAPI->getPrice($data);
            // Return API response
            return response()->json($response);
        } catch (\Exception $e) {
            // Handle exceptions that occur during API call or data processing
            return response()->json(['error' => 'Lỗi xử lý yêu cầu: ' . $e->getMessage()], 500);
        }
    }


    public function createOrder(Request $request)
    {
        // Validate request parameters upfront

        try {
            $validated = $request->validate([
                'sender_id' => 'required|exists:user_delivery_info,id',
                'receiver_id' => 'required|exists:user_delivery_info,id',
                'contract_id' => 'required|exists:contracts,id',
                'product_name' => 'required',
                'product_description' => 'required',
                'product_quantity' => 'required|numeric',
                'product_price' => 'required|numeric',
                'product_weight' => 'required|numeric',
                'product_length' => 'required|numeric',
                'product_width' => 'required|numeric',
                'product_height' => 'required|numeric',
                'service' => 'required',
                'note' => 'required',
                'list_items'=>'required'
            ]);
            $sender = UserDeliveryInfo::findOrFail($validated['sender_id']);
            $receiver = UserDeliveryInfo::findOrFail($validated['receiver_id']);
            $contract = Contract::findOrFail($validated['contract_id']);

            // Fetch products associated with the contract
            $products = Product::where('contract_id', $contract->id)->get();
            if ($products->isEmpty()) {
                throw new \Exception("Không tìm thấy sản phẩm nào cho mã hợp đồng đã cung cấp.");
            }

            $listItems = $request->input('list_items');
            // đổi - thành ,
            $sender->address = str_replace(' -', ',', $sender->address);
            $receiver->address = str_replace(' -', ',', $receiver->address);
            $orderDetails = [
                "SENDER_FULLNAME" => $sender->receiver_name,
                "SENDER_ADDRESS" => $sender->address,
                "SENDER_PHONE" => $sender->phone,
                "RECEIVER_FULLNAME" => $receiver->receiver_name,
                "RECEIVER_ADDRESS" => $receiver->address,
                "RECEIVER_PHONE" => $receiver->phone,
                "LIST_ITEM" => $listItems,
                "ORDER_PAYMENT" => 3,
                "ORDER_SERVICE" => $validated['service'],
                "ORDER_SERVICE_ADD" => $validated['service_add'] ?? "",
                "ORDER_NOTE" => $validated['note'],
                "MONEY_COLLECTION" => 56827,
                "EXTRA_MONEY" => 0,
                "CHECK_UNIQUE" => true,
                "PRODUCT_TYPE" => "HH",
                "PRODUCT_NAME" => $validated['product_name'],
                "PRODUCT_DESCRIPTION" => $validated['product_description'],
                "PRODUCT_QUANTITY" => $validated['product_quantity'],
                "PRODUCT_PRICE" => $validated['product_price'],
                "PRODUCT_WEIGHT" => $validated['product_weight'],
                "PRODUCT_LENGTH" => $validated['product_length'],
                "PRODUCT_WIDTH" => $validated['product_width'],
                "PRODUCT_HEIGHT" => $validated['product_height'],
            ];
            $ViettelPostAPI = new ViettelPostAPI();
            $response = $ViettelPostAPI->createOrder($orderDetails);
            if(!$response['error']){

                $delivery = Delivery::create([
                    'name' => $validated['product_name'],
                    'contract_id' => $request->input('contract_id'),
                    'code' => $response['data']['ORDER_NUMBER'],
                    'product_price' => $orderDetails['PRODUCT_PRICE'],
                    'order_service_add' => $orderDetails['ORDER_SERVICE_ADD'] ?? null,
                    'order_service' => $orderDetails['ORDER_SERVICE'],
                    'delivery_user_a_info'=>json_encode($receiver),
                    'delivery_user_b_info'=>json_encode($sender),
                    'product_length' => $orderDetails['PRODUCT_LENGTH'],
                    'product_width' => $orderDetails['PRODUCT_WIDTH'],
                    'product_height' => $orderDetails['PRODUCT_HEIGHT'],
                    'product_weight' => $orderDetails['PRODUCT_WEIGHT'],
                    'money_total_ship' => $response['data']['MONEY_TOTAL'],
                    'list_products' => json_encode($listItems),
                    'status' => 'awaiting_processing',
                ]);
            }else{
                return response()->json($response);
            }
            return response()->json($delivery);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }

    public function updateDeleteOrder(Request $request)
    {
        try {
            $validated = $request->validate([
                'code' => 'required|exists:deliveries,code',
            ]);
            $delivery = Delivery::where('code', $validated['code'])->first();
            $ViettelPostAPI = new ViettelPostAPI();
            $data = [
                'ORDER_NUMBER' => $delivery->code,
                'TYPE' => 4,
                'NOTE'=>'Huỷ đơn hàng'
            ];
            $response = $ViettelPostAPI->updateOrder($data);
            if(!$response['error']){
                $delivery->status = 'delivery_cancelled';
                $delivery->save();
            }
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 400);
        }
    }
}
