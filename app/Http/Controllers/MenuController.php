<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Enums\UserRole;

class MenuController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $restaurant = $user->primaryRestaurant();

        if (!$restaurant && $user->role === UserRole::ADMIN) {
            return redirect()->route('restaurants.index');
        }

        $items = MenuItem::with('category')
            ->where('restaurant_id', $restaurant->id)
            ->get()
            ->groupBy(fn($item) => $item->category->name ?? 'Sem Categoria');

        $restaurant = auth()->user()->primaryRestaurant();
        $categories = Category::where('restaurant_id', $restaurant->id)->orderBy('name')->get();

        return view('menu.index', compact('items', 'categories'));
    }

    public function publicMenu(Request $request, $restaurant)
{
     $restaurant = \App\Models\Restaurant::findOrFail($restaurant);

    $query = MenuItem::with('category')
        ->where('restaurant_id', $restaurant->id)
        ->where('is_active', true);

    if ($request->has('search')) {
        $search = $request->input('search');
        $query->where(function($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('description', 'like', "%{$search}%");
        });
    }

    if ($request->has('category')) {
        $categoryId = $request->input('category');
        $query->where('category_id', $categoryId);
    }

    $currentTime = now()->format('H:i:s');
    $query->where(function($q) use ($currentTime) {
        $q->whereNull('availability_start_time')
          ->orWhereNull('availability_end_time')
          ->orWhere(function($q) use ($currentTime) {
              $q->where('availability_start_time', '<=', $currentTime)
                ->where('availability_end_time', '>=', $currentTime);
          });
    });

    $query->where(function($q) {
        $q->whereNull('stock_quantity')
          ->orWhere('stock_quantity', '>', 0);
    });

    $items = $query->get()->groupBy(fn ($item) => $item->category->name ?? 'Sem Categoria');

    $categories = Category::where('restaurant_id', $restaurant->id)
                          ->orderBy('name')
                          ->get();

    $whatsappNumber = $restaurant->phone ?? '5511999999999'; // Fallback if no phone number is set

    // Get restaurant hours
    $hours = $restaurant->hours()->orderBy('day_of_week')->get();

    // If no hours exist, create default ones
    if ($hours->isEmpty()) {
        $hours = collect();
        for ($day = 0; $day < 7; $day++) {
            $hours->push((object)[
                'day_of_week' => $day,
                'is_open' => $day > 0 && $day < 6, // Closed on weekends by default
                'opening_time' => '08:00',
                'closing_time' => '18:00',
                'day_name' => $this->getDayName($day),
            ]);
        }
    } else {
        // Add day_name to each hour
        $hours->each(function($hour) {
            $hour->day_name = $this->getDayName($hour->day_of_week);
        });
    }

    // Use the current server time for determining restaurant status
    $currentTime = now();

    $currentDay = $currentTime->dayOfWeek;
    $currentHour = $currentTime->hour;
    $currentMinute = $currentTime->minute;

    // Determine if restaurant is currently open
    $isOpen = false;
    $openingInfo = null;

    // Find today's hours
    $todayHours = $hours->firstWhere('day_of_week', $currentDay);

    if ($todayHours && $todayHours->is_open) {
        // Extract hours and minutes from opening and closing times
        // First, ensure we're working with string values
        $openingTimeStr = is_string($todayHours->opening_time)
            ? $todayHours->opening_time
            : (is_object($todayHours->opening_time) && method_exists($todayHours->opening_time, 'format')
                ? $todayHours->opening_time->format('H:i')
                : '08:00');

        $closingTimeStr = is_string($todayHours->closing_time)
            ? $todayHours->closing_time
            : (is_object($todayHours->closing_time) && method_exists($todayHours->closing_time, 'format')
                ? $todayHours->closing_time->format('H:i')
                : '18:00');

        // Parse the time strings
        $openTime = explode(':', $openingTimeStr);
        $closeTime = explode(':', $closingTimeStr);

        // Calculate minutes for comparison
        $openHour = isset($openTime[0]) ? (int)$openTime[0] : 8;
        $openMin = isset($openTime[1]) ? (int)$openTime[1] : 0;
        $closeHour = isset($closeTime[0]) ? (int)$closeTime[0] : 18;
        $closeMin = isset($closeTime[1]) ? (int)$closeTime[1] : 0;

        $openMinutes = $openHour * 60 + $openMin;
        $closeMinutes = $closeHour * 60 + $closeMin;
        $currentMinutes = $currentHour * 60 + $currentMinute;

        // Debug information
        \Log::info("Server time: " . now()->format('Y-m-d H:i:s') . " | Local time: " . $currentTime->format('Y-m-d H:i:s') . " (Day: $currentDay, Time: $currentHour:$currentMinute) | Is open: " . ($currentMinutes >= $openMinutes && $currentMinutes < $closeMinutes ? 'Yes' : 'No') . " | Status: " . ($currentMinutes >= $openMinutes && $currentMinutes < $closeMinutes ? 'open' : ($currentMinutes < $openMinutes ? 'opening_soon' : 'closed')));
        \Log::info("Today's hours: " . ($todayHours->day_name ?? 'Unknown') . " | Is day open: " . ($todayHours->is_open ? 'Yes' : 'No') . " | Opening: $openingTimeStr | Closing: $closingTimeStr");

        // Force the restaurant to be open for testing if needed
        // $isOpen = true;

        if ($currentMinutes >= $openMinutes && $currentMinutes < $closeMinutes) {
            $isOpen = true;
            $openingInfo = [
                'status' => 'open',
                'minutesUntilClose' => $closeMinutes - $currentMinutes
            ];
        } else if ($currentMinutes < $openMinutes) {
            $openingInfo = [
                'status' => 'opening_soon',
                'minutesUntilOpen' => $openMinutes - $currentMinutes
            ];
        } else {
            $openingInfo = [
                'status' => 'closed'
            ];
        }
    } else {
        $openingInfo = [
            'status' => 'closed'
        ];
    }

    return view('menu.public', compact('items', 'categories', 'whatsappNumber', 'restaurant', 'request', 'hours', 'isOpen', 'openingInfo', 'currentDay', 'currentHour', 'currentMinute', 'todayHours'));
}


    public function show($id)
    {
        $item = MenuItem::findOrFail($id);
        return view('menu.show', compact('item'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('menu.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $restaurant = $user->primaryRestaurant();

        if (!$restaurant) {
            return back()->with('error', 'Restaurante não vinculado.');
        }

        $request->merge([
            'price' => $this->parseCurrencyToFloat($request->input('price')),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
            'is_active' => 'boolean',
            'stock_quantity' => 'nullable|integer|min:0',
            'availability_start_time' => 'nullable|date_format:H:i',
            'availability_end_time' => 'nullable|date_format:H:i|after:availability_start_time',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_url'] = Storage::url($request->file('image')->store('menu-images', 'public'));
        }

        $validated['restaurant_id'] = $restaurant->id;

        MenuItem::create($validated);

        return back()->with('success', 'Item criado com sucesso!');
    }

    private function parseCurrencyToFloat($value)
    {
        if (!$value) return 0;
        $value = str_replace(['R$', ' '], '', $value);
        $value = preg_replace('/\.(?=\d{3,})/', '', $value);
        return floatval(str_replace(',', '.', $value));
    }

    /**
     * Get the day name in Portuguese.
     */
    private function getDayName($dayOfWeek)
    {
        $days = [
            0 => 'Domingo',
            1 => 'Segunda-feira',
            2 => 'Terça-feira',
            3 => 'Quarta-feira',
            4 => 'Quinta-feira',
            5 => 'Sexta-feira',
            6 => 'Sábado',
        ];

        return $days[$dayOfWeek] ?? '';
    }

    public function edit($id)
    {
        $item = MenuItem::findOrFail($id);
        $restaurant = Auth::user()->primaryRestaurant();
        if ($item->restaurant_id !== $restaurant?->id) {
            abort(403);
        }
        return view('menu.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $item = MenuItem::findOrFail($id);
        $restaurant = Auth::user()->primaryRestaurant();
        if ($item->restaurant_id !== $restaurant?->id) {
            abort(403);
        }

        $request->merge([
            'price' => $this->parseCurrencyToFloat($request->input('price')),
        ]);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'stock_quantity' => 'nullable|integer|min:0',
            'availability_start_time' => 'nullable|date_format:H:i',
            'availability_end_time' => 'nullable|date_format:H:i|after:availability_start_time',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_url'] = Storage::url($request->file('image')->store('menu-images', 'public'));
        }

        if (isset($validated['is_active'])) {
            $item->is_active = $validated['is_active'];
            unset($validated['is_active']);
        }

        $item->update(array_filter($validated, fn($value) => $value !== null));

        return redirect()->route('menu')->with('success', 'Item atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $item = MenuItem::findOrFail($id);
        $restaurant = Auth::user()->primaryRestaurant();
        if ($item->restaurant_id !== $restaurant?->id) {
            abort(403);
        }
        $item->delete();

        return redirect()->route('menu')->with('success', 'Item excluído com sucesso!');
    }

    public function storeCategory(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create([
            'name' => $validated['name'],
            'slug' => \Illuminate\Support\Str::slug($validated['name']),
        ]);

        return back()->with('success', 'Categoria criada com sucesso!');
    }

    // pagina inicial sem menu
    public function home()
    {
        $restaurants = \App\Models\Restaurant::orderBy('name')->get();
        return view('home', compact('restaurants'));
    }

}
