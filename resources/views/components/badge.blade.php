@props(['background', 'title', 'total', 'icon'])

<div class="w-full mt-4">
    <div class="flex justify-between p-4 w-full {{ $background }} rounded-lg">
        <div>
            <h6 class="text-xs font-medium leading-none tracking-wider text-white uppercase">
                {{ $title }}
            </h6>
            <span class="text-xl font-semibold text-white">${{ $total }}</span>
        </div>
        <span>
            <i class="text-4xl text-white bx {{ $icon }}"></i>
        </span>
    </div>
</div>
