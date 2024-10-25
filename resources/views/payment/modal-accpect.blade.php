<div class="modal modal-blur fade" wire:ignore.self id="{{$name}}" tabindex="-1" aria-labelledby="{{$name}}Label"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <!-- <h5 class="modal-title">Modal title</h5> -->
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        @isset($contract->deposit_amount)
                        <div class="form-group mb-3">
                            <label class="form-label">Số tiền thanh toán</label>
                            <input type="text" class="form-control" value="{{ $contract->deposit_amount }}"
                                readonly>
                        </div>
                        @else
                        <span>0</span>
                        @endisset

                        @isset($contract->partyAInfo->user->name)
                        <div class="form-group mb-3">
                            <label class="form-label">Họ và tên khách hàng</label>
                            <input type="text" class="form-control" value="{{ $contract->partyAInfo->user->name }}"
                                readonly>
                        </div>
                        @endisset

                    </div>
                    <div class="col-md-6">
                        @isset($contract->status)
                        <div class="form-group mb-3">
                            <span>Trạng thái thanh toán: <span
                                    class="badge bg-{{ $contract->status == 'accepted' ? 'success' : 'danger' }} text-white">{{ $contract->formatStatus() }}</span>
                            </span>
                        </div>
                        @endisset
                        @isset($contract->code)
                        <div class="form-group mb-3">
                            <span>Mã thanh toán: <span class="text-warning">{{ $contract->code }}</span></span>
                        </div>
                        @endisset
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary" wire:click="acceptPayment">Đồng ý thanh toán</button>
                <button class="btn btn-danger" wire:click="rejectPayment">Từ chối thanh toán</button>
            </div>
        </div>
    </div>
</div>
