<div class="container-fuild" x-data="datePicker()">
    <div class="row g-2 align-items-center">
        <div class="col">
            <!-- Page pre-title -->
            <div class="page-pretitle">
                {{
                    config('future.future.dashboard.description') ?? 'Overview'
}}
            </div>
            <h2 class="page-title">
                {{
                    config('future.future.dashboard.title') ?? 'Dashboard'
}}
            </h2>
        </div>
        <!-- Page title actions -->
        <div class="col-auto ms-auto d-print-none">
            <div class="btn-list">
                <div class="input-icon mb-2">
                    <input class="form-control" placeholder="Select start date" id="startDatePicker"
                           x-ref="startDatePicker" x-model="startDate">
                    <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="icon"><path stroke="none" d="M0 0h24v24H0z"
                                                                                fill="none"></path><path
                                        d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path><path
                                        d="M16 3v4"></path><path d="M8 3v4"></path><path d="M4 11h16"></path><path
                                        d="M11 15h1"></path><path d="M12 15v3"></path></svg>
                              </span>
                </div>
                <div class="input-icon mb-2">
                    <input class="form-control" placeholder="Select end date" id="endDatePicker" x-ref="endDatePicker"
                           x-model="endDate">
                    <span class="input-icon-addon"><!-- Download SVG icon from http://tabler-icons.io/i/calendar -->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                     fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                     stroke-linejoin="round" class="icon"><path stroke="none" d="M0 0h24v24H0z"
                                                                                fill="none"></path><path
                                        d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z"></path><path
                                        d="M16 3v4"></path><path d="M8 3v4"></path><path d="M4 11h16"></path><path
                                        d="M11 15h1"></path><path d="M12 15v3"></path></svg>
                              </span>

                </div>
                <button class="btn btn-primary mb-2" wire:click="filter" wire:loading.attr="disabled"
                        wire:target="filter">
                        <span wire:loading wire:target="filter">
                            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                        </span>
                    <span wire:loading.remove wire:target="filter">Filter</span>
                </button>

            </div>
        </div>
    </div>
    @if ($widgets)
        <div class="row row-cards mt-5">
            @foreach ($widgets as $widget)
                {{$widget->dateRange($dateStart,$dateEnd)->render()}}
            @endforeach
        </div>
    @endif
</div>
@script
<script>
    Alpine.data('datePicker', () => ({
        startDate: @entangle('dateStart'),
        endDate: @entangle('dateEnd'),
        init() {
            console.log(this.startDate);
            this.$watch('startDate', (newDate) => {
                if (this.endPicker) {
                    this.endPicker.set('minDate', newDate);
                }
            });

            this.startPicker = flatpickr(this.$refs.startDatePicker, {
                defaultDate: this.startDate,
                onChange: (selectedDates, dateStr) => {
                    this.startDate = dateStr;
                }
            });

            this.endPicker = flatpickr(this.$refs.endDatePicker, {
                defaultDate: this.endDate,
                minDate: this.startDate,
                onChange: (selectedDates, dateStr) => {
                    this.endDate = dateStr;
                }
            });
        }
    }));
</script>
@endscript
