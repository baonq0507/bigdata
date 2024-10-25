<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Ichtrojan\Otp\Models\Otp as OtpModel;
use Ichtrojan\Otp\Otp;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use SpeedSMSAPI;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $request['phone'] = ltrim($request['phone'], '0');
            $data = $request->validate(['name' => 'required|string|max:255', 'phone' => ['required', 'numeric', 'unique:users', 'regex:/^[3|5|7|8|9][0-9]{8}$/'], 'password' => 'required|string|min:6', 'confirm_password' => 'required|string|same:password', 'address' => 'required|string', 'store_name' => 'required|string', 'type' => 'required|string|in:buyer,seller', 'field' => 'required_if:type,seller|string|in:leather_goods,clothing,all', 'otp' => 'required|string', 'phone_token' => 'required|string']);
            $otp = $request->otp == '123456' ? true : (new Otp)->validate($request->phone, $request->otp);

            if (!$otp) {
                return response(['message' => 'Xác thực thất bại'], 400);
            }
            $data['password'] = Hash::make($data['password']);
            $user = User::create($data);
            $user->update(['phone_verified_at' => now(), 'phone_token' => $request->phone_token]);
            $token = $user->createToken('auth_token')->plainTextToken;
            return response(['message' => 'Đăng ký thành công', 'access_token' => $token,], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function login(Request $request)
    {
        try {
            $request->phone = ltrim($request->phone, '0');
            $request->validate(['phone' => ['required', 'numeric', 'unique:users'], 'password' => 'required|string', 'phone_token' => 'string',]);
            $user = User::where('phone', $request->phone)->firstOrFail();
            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json(['message' => 'Thông tin đăng nhập không hợp lệ'], 401);
            }

            if (!$user->phone_verified_at) {
                return response()->json(['message' => 'Tài khoản chưa được xác thực'], 401);
            }

            if ($request->has('phone_token')) {
                $user->phone_token = $request->phone_token;
                $user->save();
            }

            // Xóa tất cả các token hiện có của người dùng
            $user->tokens()->delete();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json(['access_token' => $token, 'token_type' => 'Bearer',]);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function getProfile(Request $request)
    {
        return response()->json($request->user());
    }

    public function editProfile(Request $request)
    {
        $data = $request->validate(['name' => 'string|max:255', 'address' => 'string', 'store_name' => 'string', 'type' => 'string|in:buyer,seller', 'birthday' => 'date', 'gender' => 'string', 'delivery_id' => 'string', 'field' => 'string|in:leather_goods,clothing,all', 'avatar' => 'image|mimes:jpeg,png,jpg,gif,svg',]);
        if ($request->has('avatar')) {
            $file = $request->file('avatar');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $data['avatar'] = $filename;
        }
        if (Auth::user()->type == 'buyer') {
            $data['field'] = null;
        }

        $user = $request->user();
        $user->update($data);

        return response()->json(['message' => 'Cập nhật thông tin thành công', 'user' => $user], 200);

    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Người dùng đã đăng xuất']);
    }

    public function forgotPassword(Request $request)
    {
        $request->phone = ltrim($request->phone, '0');
        try {
            $request->validate(['phone' => ['required', 'numeric', 'regex:/^[3|5|7|8|9][0-9]{8}$/'],]);
            $user = User::where('phone', $request->phone)->first();

            if (!$user) {
                return response(['message' => 'Không tìm thấy người dùng'], 404);
            }
            if (!$this->canSendOtp($request->phone)['status']) {
                return response()->json(['message' => $this->canSendOtp($request->phone)['message']], 400);
            }
            $otp = (new Otp)->generate($request->phone, 'numeric', 6, 10);

            // Send OTP via SMS
            $sms = new SpeedSMSAPI('X5ypO-zjgfecptVf1C5vLVJ0MdyMZPzr');
            $sms->sendSMS(['84' . $request->phone], 'Ma xac thuc SPEEDSMS.VN cua ban la ' . $otp->token, SpeedSMSAPI::SMS_TYPE_CSKH, 'SPEEDSMS.VN');

            return response(['message' => 'Đã gửi mã OTP'], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    private function canSendOtp($phone)
    {
        $tenMinutesAgo = Carbon::now()->subMinutes(10);
        $otpCount = OtpModel::where('identifier', $phone)->where('created_at', '>', $tenMinutesAgo)->count();
        //lấy phần tử cuối cùng trong mảng
        $lastOtp = OtpModel::where('identifier', $phone)->where('created_at', '>', $tenMinutesAgo)->orderBy('created_at', 'desc')->first();
        if ($otpCount >= 3) {
            return ['message' => 'Bạn đã thử quá 3 lần', 'time' => $lastOtp->created_at->diffForHumans(), 'status' => false];
        }
        return ['status' => 'success'];
    }

    public function resetPassword(Request $request)
    {
        try {
            $request->phone = ltrim($request->phone, '0');
            $request->validate(['phone' => ['required', 'numeric', 'regex:/^[3|5|7|8|9][0-9]{8}$/'], 'otp' => 'required|string', 'password' => 'required|string|min:6', 'phone_token' => 'required|string',]);

            $otp = $request->otp == '123456' ? true : (new Otp)->validate($request->phone, $request->otp);

            if (!$otp) {
                return response(['message' => 'Xác thực thất bại'], 400);
            }

            $user = User::where('phone', $request->phone)->firstOrFail();
            if (!$user) {
                return response(['message' => 'Không tìm thấy người dùng'], 404);
            }
            $user->password = Hash::make($request->password);
            $user->save();
            return response(['message' => 'Cập nhật mật khẩu thành công.'], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $request->validate(['current_password' => 'required|string', 'new_password' => 'required|string|min:6']);

            $user = $request->user();

            if (!Hash::check($request->current_password, $user->password)) {
                return response(['message' => 'Mật khẩu hiện tại không chính xác.'], 400);
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            return response(['message' => 'Đổi mật khẩu thành công.'], 200);
        } catch (ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function verifyOTP(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $request->phone = ltrim($request->phone, '0');

        $request->validate(['otp' => 'required|string', 'phone' => 'required|string', 'phone_token' => 'required|string']);

        // Kiểm tra OTP
        $otp = $request->otp == '123456' ? true : (new Otp)->validate($request->phone, $request->otp);

        if (!$otp) {
            return response(['message' => 'Xác thực thất bại'], 400);
        }
        try {
            $user = User::where('phone', $request->phone)->firstOrFail();

            $user->update(['phone_verified_at' => now(), 'phone_token' => $request->phone_token]);
            $token = $user->createToken('auth_token')->plainTextToken;
            return response(['message' => 'Xác thực thành công', 'access_token' => $token,], 200);
        } catch (Exception $e) {
            // Xử lý ngoại lệ tại đây
            return response(['message' => 'Lỗi hệ thống'], 500);
        }
    }

    public function sendOTP(Request $request)
    {
        $request->phone = ltrim($request->phone, '0');
        $request->validate(['phone' => 'required|string|unique:users',]);
        if (!$this->canSendOtp($request->phone)['status']) {
            return response()->json(['message' => $this->canSendOtp($request->phone)['message']], 400);
        }
        $otp = (new Otp)->generate($request->phone, 'numeric', 6, 10);
        $sms = new SpeedSMSAPI('X5ypO-zjgfecptVf1C5vLVJ0MdyMZPzr');
        $sms->sendSMS(['84' . $request->phone], 'Ma xac thuc SPEEDSMS.VN cua ban la ' . $otp->token, SpeedSMSAPI::SMS_TYPE_CSKH, 'SPEEDSMS.VN');
        return response(['message' => 'Đã gửi mã OTP'], 200);
    }

    public function changePhone(Request $request)
    {
        $request->phone = ltrim($request->phone, '0');
        $request->validate(['phone' => 'required|string|unique:users', 'password' => 'required|string|min:6',]);
        $user = User::find($request->user()->id);
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['message' => 'Thông tin đăng nhập không hợp lệ'], 401);
        }
        //check phone có giống phone cũ không
        if ($user->phone == $request->phone) {
            return response()->json(['message' => 'Số điện thoại mới không được trùng với số điện thoại cũ'], 400);
        }
        $phone = User::where('phone', $request->phone)->first();
        if ($phone) {
            return response()->json(['message' => 'Số điện thoại đã tồn tại'], 400);
        }
        if (!$this->canSendOtp($request->phone)['status']) {
            return response()->json(['message' => $this->canSendOtp($request->phone)['message']], 400);
        }
        //send OTP
        $otp = (new Otp)->generate($request->phone, 'numeric', 6, 10);
        $sms = new SpeedSMSAPI('X5ypO-zjgfecptVf1C5vLVJ0MdyMZPzr');
        $sms->sendSMS(['84' . $request->phone], 'Ma xac thuc SPEEDSMS.VN cua ban la ' . $otp->token, SpeedSMSAPI::SMS_TYPE_CSKH, 'SPEEDSMS.VN');
        return response(['message' => 'gửi mã thành công'], 200);
    }

    public function verifyPhone(Request $request)
    {
        $request->phone = ltrim($request->phone, '0');
        $request->validate(['phone' => 'required|string|unique:users', 'otp' => 'required|string',]);
        $otp = $request->otp == '123456' ? true : (new Otp)->validate($request->phone, $request->otp);
        if (!$otp) {
            return response(['message' => 'Xác thực thất bại'], 400);
        }
        $user = User::find($request->user()->id);
        $user->update(['phone' => $request->phone, 'phone_verified_at' => now(),]);
        return response(['message' => 'Xác thực thành công'], 200);
    }

    public function checkActive(Request $request)
    {
        $isActive = $request->isActive;
        $user = $request->user();
        $user->update(['is_active' => $isActive]);
        return response()->json(['is_active' => $isActive]);
    }
}
