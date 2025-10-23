@props(['value', 'icon', 'description', 'color' => 'primary'])
<div class="card card-sm">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-auto">
                <span class="bg-{{ $color }} text-white avatar">
                    <i class="{{ $icon }}"></i>
                </span>
            </div>
            <div class="col">
                <div class="font-weight-medium">{{ $value }}</div>
                <div class="text-secondary">{{ $description }}</div>
            </div>
        </div>
    </div>
</div>