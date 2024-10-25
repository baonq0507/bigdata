@extends('future::layouts.app')
@section('style')
<style>
    p {
        margin-bottom: 5px;
    }

    /* Ẩn radio mặc định */
    input[type="radio"] {
        display: none;
    }

    /* Tạo ô vuông cho radio button */
    .custom-radio {
        display: inline-block;
        width: 15px;
        height: 15px;
        border: 2px solid #000;
        border-radius: 50%;
        position: relative;
        cursor: pointer;
    }

    /* Hiển thị dấu tích khi radio được chọn */
    input[type="radio"]:checked+.custom-radio::after {
        content: '✓';
        font-size: 14px;
        color: #fff;
        position: absolute;
        font-weight: bold;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* Thay đổi màu nền khi radio được chọn */
    input[type="radio"]:checked+.custom-radio {
        background-color: #007bff;
        border-color: #007bff;
    }
</style>
@endsection
@section('content')
<div id="kt_app_content" class="app-content">
    <div class="card">
        <div class="card-header">
            <div class="row justify-content-between w-100">
                <div class="col-md-6">
                    <a href="{{ url()->previous() }}" class="btn btn-primary">Quay lại</a>
                </div>
                <div class="col-md-6 text-end">
                    <a class="btn btn-default">Cập nhật trạng thái</a>
                    <a class="btn btn-primary">Gửi</a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row justify-content-center mb-5">
                <!--begin::Sidebar-->
            <div class="col-lg-6 col-xl-6 mb-10 col-xs-12 col-md-6">
                <div class="text-center mb-5">
                    <p>Cộng Hòa xã hội chủ nghĩa Việt Nam</p>
                    <p>Độc lập - Tự do - Hạnh phúc</p>
                </div>
                <div class="text-center">
                    <p>HỢP ĐỒNG SẢN XUẤT</p>
                </div>
                <div class="text-left">
                    <p>(Số: {{ $contract->code }}/HĐSX)</p>
                    <p>Hôm nay, ngày {{ $contract->created_at->format('d') }} tháng {{ $contract->created_at->format('m') }} năm {{ $contract->created_at->format('Y') }}, chúng tôi gồm có:</p>
                    <p>Bên A (bên đặt hàng):</p>
                    <p>Họ tên: {{ $contract->partyAInfo->user->name }}</p>
                    <p>Địa chỉ: {{ $contract->partyAInfo->user->address }}</p>
                    <p>Số điện thoại: {{ $contract->partyAInfo->user->phone }}</p>
                    <p>Số tài khoản: {{ $contract->partyAInfo->account_number }} Tại Ngân hàng: {{ $contract->partyAInfo->bank_name }}</p>
                    <p>Bên B (bên sản xuất nhận khoản):</p>
                    <p>Họ tên: {{ $contract->partyBInfo->user->name }}</p>
                    <p>Địa chỉ: {{ $contract->partyBInfo->user->address }}</p>
                    <p>Số điện thoại: {{ $contract->partyBInfo->user->phone }}</p>
                    <p>Số tài khoản: {{ $contract->partyBInfo->account_number }} Tại Ngân hàng: {{ $contract->partyBInfo->bank_name }}</p>
                    <p>Sau khi thỏa thuận, hai bên đồng ý ký kết và thực hiện HỢP ĐÔNG KHOẢN VIỆC với các điều khoản sau:</p>
                    <p>Bên B làm cho bên A sản phẩm giống với trong ảnh và các thông số bên A đã cũng cấp cho bên B.</p>
                    <p>1: Chi tiết sản phẩm:</p>
                    @foreach ($contract->products as $product)
                    <p> - Tên sản phẩm: {{ $product->name }}</p>
                    <p> - Màu sắc: {{ $product->color }}</p>
                    <p> - Số lượng: {{ $product->quantity }}</p>
                    <p> - Giá: {{ $product->price }}</p>
                    <p> - Giới tính: {{ $product->gender }}</p>
                    <p> - Kích thước: {{ $product->size }}</p>
                    <p> - Chất liệu: {{ $product->material }}</p>
                    <p> - Thông số kỹ thuật:( Bên B tự điền thông số sản phẩm)</p>
                    <p> - chiều dài: ...........</p>
                    <p> - chiều rộng: ...........</p>
                    <p> - ...........</p>
                    <p> - ...........</p>
                    <p> - ...........</p>
                    @endforeach
                    <p>2: Giá của sản phẩm: {{ $contract->total_amount }}</p>
                    <p>3: Thời gian</p>
                    <p> - Ngày bắt đầu sản xuất: {{ $contract->created_at->format('d/m/Y') }}</p>

                    <p> - Ngày hoàn thành sản phẩm: @if ($contract->estimated_delivery_date) {{ $contract->estimated_delivery_date }} @else ........... @endif</p>
                    <p> - Ngày khách hàng nhận được sản phẩm: ...........</p>
                    <p>*(Lưu ý: Ngày khách hàng nhận được sản phẩm dựa vào đơn vị vận chuyển có thể không dự kiến)</p>
                </div>
            </div>
        </div>
        <div class="row mb-5">
            <div class="col-lg-3 col-xl-3 mb-10 col-xs-12 col-md-3">
                <div class="text-left">
                    <p>Hóa đơn thanh toán</p>
                </div>
            </div>
            <div class="col-md-3 col-xs-3">
                <div class="text-left">
                    <p>Tổng tiền:</p>
                    <p>Số % cọc:</p>
                    <p>Trạng thái:</p>
                </div>
            </div>
            <div class="col-md-3 col-xs-3">
                <div class="text-left">
                    <p>{{ $contract->total_amount }} VNĐ</p>
                    <p>{{ $contract->deposit_amount }} %</p>
                    <p>{{ $contract->formatStatus() }}</p>
                </div>
            </div>
            <div class="col-md-3 col-xs-3">
                <div class="text-left">
                    <p>Ảnh sản phẩm</p>
                    @foreach ($contract->products as $product)
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" style="width: 100px; height: 100px;">
                    @endforeach
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col-lg-6 col-xl-6 mb-10 col-xs-12 col-md-6">
                <div class="text-center">
                    <p>Bên A</p>
                    <label for="partyA">
                        <input type="radio" name="partyA" id="partyA" value="1" checked readonly>
                        <span class="custom-radio"></span>
                        <span style="color: #718D6E;">Tôi chấp nhận hợp đồng</span>

                    </label>
                </div>
            </div>
            <div class="col-lg-6 col-xl-6 mb-10 col-xs-12 col-md-6">
                <div class="text-center">
                    <p>Bên B</p>
                    <label for="partyB">
                        <input type="radio" name="partyB" id="partyB" value="1" checked readonly>
                        <span class="custom-radio"></span>
                        <span style="color: #718D6E;">Tôi chấp nhận hợp đồng</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="row justify-content-center mb-5">
            <div class="col-lg-6 col-xl-6 mb-10 col-xs-12 col-md-6">
                <div class="text-center">
                    <p style="color: #718D6E;">Công ty cổ phần Dinahand xác nhận hợp đồng
                        <label for="partyC">
                            <input type="radio" name="partyC" id="partyC" value="1" checked readonly>
                            <span class="custom-radio"></span>
                        </label>
                    </p>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
