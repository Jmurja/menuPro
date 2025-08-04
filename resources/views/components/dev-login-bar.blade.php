@if(!app()->environment('production'))
    <div class="flex items-center space-x-4 justify-center bg-[#2096a8]">
        <div class="flex space-x-4 justify-between font-black">
            <span class="py-1 px-4 rounded-md bg-[#207e90] border-[#3ad4bd] text-white">
                {{ $branch }}
            </span>
            <span class="py-1 px-4 rounded-md bg-[#207e90] border-[#3ad4bd] text-white">
                {{ $env }}
            </span>
        </div>

        <form action="{{ route('dev-login') }}" method="GET" class="font-semibold flex-col rounded-lg p-1">
            <label class="flex-auto text-white">
                <select name="user" class="rounded-md bg-[#207e90] border-[#3ad4bd] p-1 px-4">
                    @foreach($users as $user)
                        <option value="{{ $user['id'] }}">{{ $user['name'] }}</option>
                    @endforeach
                </select>
            </label>
            <button type="submit"
                    class="px-4 py-1 bg-[#207e90] border-[#3ad4bd] hover:bg-[#1aaab3] hover:border-[#3ad4bd] text-white rounded-md">
                Login
            </button>
        </form>
    </div>
@endif
