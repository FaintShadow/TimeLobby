<script>
    import './main.css'
    import {createSwapy} from "swapy";
    import {onMount} from "svelte";

    let container

    onMount(() => {
        if (container) {
            const swapy = createSwapy(container)
        }
    })
</script>

<div class="relative w-full h-screen content-center overflow-hidden bg-gray-900">
    <div class="relative max-w-4xl mx-auto px-4 sm:px-6 md:px-8">
        <div class="container" data-v-9ba7cd63="" bind:this={container}>
            <div class="slot slot-tl" data-swapy-slot="tl" data-v-9ba7cd63="">
                <div class="item" data-swapy-item="a" data-v-9ba7cd63="">
                    <div class="text-gray-900 p-2.5 flex h-full item-card started" data-v-9ba7cd63="">
                        <div
                            class="relative h-full w-full bg-gray-200 rounded-[10px] flex items-center justify-center">
                            <div
                                class="self-start absolute w-full text-gray-400 flex justify-between px-3.5 py-2.5 text-xs font-semibold">
                                <div>September</div>
                                <div>2024</div>
                            </div>
                            <div class="text-center text-5xl text-sky-800 font-light">21</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slot slot-tr" data-swapy-slot="tr" data-v-9ba7cd63="">
                <div class="item" data-swapy-item="b" data-v-9ba7cd63="">
                    <div class="text-gray-900 p-2.5 flex h-full item-card" data-v-9ba7cd63="">
                        <div
                            class="w-full text-gray-400 flex items-start flex-col px-3.5 py-2 text-xs font-semibold">
                            <div> My Todos</div>
                            <ul class="mt-2 divide-y w-full">
                                <li class="py-1 text-gray-600 text-base">
                                    <div class="flex items-center gap-x-2">
                                        <div>
                                            <svg version="1.1" id="fi_711239" xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 408.576 408.576"
                                                 style="enable-background:new 0 0 408.576 408.576;" fill="currentColor"
                                                 xml:space="preserve" class="w-4 text-sky-600"><g><g><path d="M204.288,0C91.648,0,0,91.648,0,204.288s91.648,204.288,204.288,204.288s204.288-91.648,204.288-204.288
			S316.928,0,204.288,0z M318.464,150.528l-130.56,129.536c-7.68,7.68-19.968,8.192-28.16,0.512L90.624,217.6
			c-8.192-7.68-8.704-20.48-1.536-28.672c7.68-8.192,20.48-8.704,28.672-1.024l54.784,50.176L289.28,121.344
			c8.192-8.192,20.992-8.192,29.184,0C326.656,129.536,326.656,142.336,318.464,150.528z"></path></g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g></svg>
                                        </div>
                                        <div>Todo 1</div>
                                    </div>
                                </li>
                                <li class="py-1 text-gray-600 text-base">
                                    <div class="flex items-center gap-x-2">
                                        <div>
                                            <svg version="1.1" id="fi_711239" xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 408.576 408.576"
                                                 style="enable-background:new 0 0 408.576 408.576;" fill="currentColor"
                                                 xml:space="preserve" class="w-4 text-sky-600"><g><g><path d="M204.288,0C91.648,0,0,91.648,0,204.288s91.648,204.288,204.288,204.288s204.288-91.648,204.288-204.288
			S316.928,0,204.288,0z M318.464,150.528l-130.56,129.536c-7.68,7.68-19.968,8.192-28.16,0.512L90.624,217.6
			c-8.192-7.68-8.704-20.48-1.536-28.672c7.68-8.192,20.48-8.704,28.672-1.024l54.784,50.176L289.28,121.344
			c8.192-8.192,20.992-8.192,29.184,0C326.656,129.536,326.656,142.336,318.464,150.528z"></path></g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g></svg>
                                        </div>
                                        <div>Todo 2</div>
                                    </div>
                                </li>
                                <li class="py-1 text-gray-600 text-base">
                                    <div class="flex items-center gap-x-2">
                                        <div>
                                            <svg version="1.1" id="fi_711239" xmlns="http://www.w3.org/2000/svg"
                                                 xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                 viewBox="0 0 408.576 408.576"
                                                 style="enable-background:new 0 0 408.576 408.576;" fill="currentColor"
                                                 xml:space="preserve" class="w-4 text-sky-600"><g><g><path d="M204.288,0C91.648,0,0,91.648,0,204.288s91.648,204.288,204.288,204.288s204.288-91.648,204.288-204.288
			S316.928,0,204.288,0z M318.464,150.528l-130.56,129.536c-7.68,7.68-19.968,8.192-28.16,0.512L90.624,217.6
			c-8.192-7.68-8.704-20.48-1.536-28.672c7.68-8.192,20.48-8.704,28.672-1.024l54.784,50.176L289.28,121.344
			c8.192-8.192,20.992-8.192,29.184,0C326.656,129.536,326.656,142.336,318.464,150.528z"></path></g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g>
                                                <g></g></svg>
                                        </div>
                                        <div>Todo 3</div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slot slot-ml" data-swapy-slot="ml" data-v-9ba7cd63="">
                <div class="item" data-swapy-item="c" data-v-9ba7cd63="">
                    <div class="text-gray-900 flex h-full item-card" data-v-9ba7cd63="" data-v-39059132="">
                        <div
                            class="relative w-full text-gray-400 flex items-start flex-col text-xs font-semibold overflow-hidden"
                            data-v-39059132="">
                            <div class="absolute top-0 left-0 w-full flex items-center justify-between px-6 py-4"
                                 data-v-39059132="">
                                <div data-v-39059132="">Sales</div>
                                <svg version="1.1" id="fi_74742" xmlns="http://www.w3.org/2000/svg"
                                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                     viewBox="0 0 339.004 339.004"
                                     style="enable-background:new 0 0 339.004 339.004;" fill="currentColor"
                                     xml:space="preserve" class="w-3.5 text-gray-300" data-v-39059132=""><path d="M262.122,232.344c0.197-26.82-10.405-48.031-31.552-63.01c-16.333-11.533-36.154-17.549-55.325-23.33
	c-39.936-12.107-51.521-18.484-51.521-37.582c0-21.273,27.646-28.842,51.313-28.842c17.236,0,37.066,5.359,49.381,13.301
	l24.415-37.812c-16.095-10.434-38.123-17.551-59.875-19.76V0H143.92v37.785c-40.035,8.807-65.255,34.973-65.255,70.637
	c0,24.977,10.379,44.785,30.79,58.756c15.524,10.666,34.457,16.393,52.746,21.938c39.172,11.84,55.079,19.055,54.898,42.949
	l-0.001,0.176c0,20.055-26.577,27.184-49.346,27.184c-21.508,0-44.897-9.426-58.155-23.441l-32.719,30.949
	c16.79,17.758,41.184,30.313,67.041,35.234v36.838h45.039v-36.045C233.445,296.592,262.078,269.809,262.122,232.344z"></path>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g>
                                    <g></g></svg>
                            </div>
                            <div class="chart" data-v-39059132=""></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slot slot-mr" data-swapy-slot="mr" data-v-9ba7cd63="">
                <div class="item" data-swapy-item="d" data-v-9ba7cd63="">
                    <div class="p-5 w-full h-full flex flex-col justify-end items-start item-card"
                         data-v-9ba7cd63="">
                        <div class="mb-1 text-gray-400 text-xs font-semibold">New subscribers</div>
                        <div class="text-sky-700 font-bold text-5xl">700+</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
