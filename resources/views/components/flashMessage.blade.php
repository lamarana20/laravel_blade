@props(['msg','bg'=>"bg-green-500"])

<p x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" class=" mb-2text-sm font-medium text-white  px-2 py-3 {{ $bg }}">
 {{ $msg }}

</p>