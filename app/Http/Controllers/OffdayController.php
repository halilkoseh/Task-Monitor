<?php

namespace App\Http\Controllers;

use App\Models\Offday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class OffdayController extends Controller
{
    // Admin tarafındaki index metodu
    public function index()
    {
        $offdays = Offday::all();
        return view('admin.offdays.index', compact('offdays'));
    }

    // Admin tarafındaki create metodu
    public function create()
    {
        return view('admin.offdays.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'offday_date' => 'required|date',


        ]);

        $documentPath = $request->file('document') ? $request->file('document')->store('documents') : null;

        Offday::create([
            'user_id' => Auth::id(),
            'reason' => $request->reason,
            'document' => $documentPath,
            'status' => 'pending',
            'offday_date' => $request->offday_date,

        ]);

        return redirect()->route('admin.offdays.index')->with('success', 'İzin talebiniz oluşturuldu.');
    }

    // Kullanıcı tarafındaki create metodu
    public function createUser()
    {
        return view('offday.create');
    }

    // Kullanıcı tarafındaki store metodu
    public function storeUser(Request $request)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
            'offday_date' => 'required|date',

        ]);

        $documentPath = $request->file('document') ? $request->file('document')->store('documents') : null;

        Offday::create([
            'user_id' => Auth::id(),
            'reason' => $request->reason,
            'document' => $documentPath,
            'status' => 'pending',
            'offday_date' => $request->offday_date,

        ]);

        return redirect()->route('offday.index')->with('success', 'İzin talebiniz oluşturuldu.');
    }

    public function show($id)
    {
        $offday = Offday::findOrFail($id);
        return view('admin.offdays.show', compact('offday'));
    }

    public function approve($id)
    {
        $offday = Offday::findOrFail($id);
        $offday->update(['status' => 'approved']);

        return redirect()->route('admin.offdays.index')->with('success', 'İzin talebi onaylandı.');
    }

    public function reject($id)
    {
        $offday = Offday::findOrFail($id);
        $offday->update(['status' => 'rejected']);

        return redirect()->route('admin.offdays.index')->with('success', 'İzin talebi reddedildi.');
    }

    public function edit($id)
    {
        $offday = Offday::findOrFail($id);
        return view('admin.offdays.edit', compact('offday'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'reason' => 'required|string|max:255',
            'document' => 'nullable|file|mimes:pdf,jpg,jpeg,png',
        ]);

        $offday = Offday::findOrFail($id);
        $documentPath = $request->file('document') ? $request->file('document')->store('documents') : $offday->document;

        $offday->update([
            'reason' => $request->reason,
            'document' => $documentPath,
        ]);

        return redirect()->route('admin.offdays.index')->with('success', 'İzin talebi güncellendi.');
    }

    public function destroy($id)
    {
        $offday = Offday::findOrFail($id);
        $offday->delete();

        return redirect()->route('admin.offdays.index')->with('success', 'İzin talebi silindi.');
    }

    // Kullanıcı tarafındaki index metodu
    public function indexUser()
    {
        $offdays = Offday::where('user_id', Auth::id())->get();
        return view('offday.index', compact('offdays'));
    }


    public function getMonthlyOffdayData()
{
    $data = Offday::select(DB::raw('MONTH(offday_date) as month, COUNT(*) as count'))
        ->whereYear('offday_date', Carbon::now()->year)
        ->groupBy(DB::raw('MONTH(offday_date)'))
        ->get();

    return response()->json($data);
}






}
