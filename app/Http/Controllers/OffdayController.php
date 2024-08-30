<?php

namespace App\Http\Controllers;

use App\Models\Offday;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\User;



class OffdayController extends Controller
{
    public function index()
    {
        $offdays = Offday::all();
        $users = User::all();
        return view('admin.offdays.index', compact('offdays', 'users'));
    }

    public function create()
    {
        return view('admin.offdays.create');
    }






    public function store(Request $request)
    {
        $attachmentPath = null;

        $request->validate([
            'reason' => 'required',
            'attachments' => 'nullable|file|mimes:zip',
            'offday_dates' => 'required|array',
            'offday_dates.*' => 'date',
        ]);

        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('attachments');
            $file->move($destinationPath, $fileName);
            $attachmentPath = 'attachments/' . $fileName;
        }

        foreach ($request->offday_dates as $offday_date) {
            Offday::create([
                'user_id' => Auth::id(),
                'reason' => $request->reason,
                'document' => $attachmentPath,
                'status' => 'pending',
                'offday_date' => $offday_date,
            ]);
        }

        return redirect()->route('offday.index')->with('success', 'İzin talebiniz oluşturuldu.');
    }








    public function createUser()
    {
        return view('offday.create');
    }

    public function storeUser(Request $request)
    {
        $attachmentPath = null;

        // Validate the request
        $request->validate([
            'reason' => 'required',
            'attachments' => 'nullable|file|mimes:zip',
            'offday_date' => 'required|date',
        ]);

        // Handle file upload
        if ($request->hasFile('attachments')) {
            $file = $request->file('attachments');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('attachments');
            $file->move($destinationPath, $fileName);
            $attachmentPath = 'attachments/' . $fileName;


        }

        Offday::create([
            'user_id' => Auth::id(),
            'reason' => $request->reason,
            'document' => $attachmentPath,
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

    public function search2(Request $request)
    {
        $query = User::query();

        // Kullanıcı adı ile filtreleme
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%");
        }

        // Sadece filtrelenen kullanıcıları getiriyoruz
        $users = $query->get();

        // Filtrelenen kullanıcıların izin günlerini alıyoruz
        $offdays = Offday::whereIn('user_id', $users->pluck('id'))->get();

        return view('admin.offdays.index', compact('users', 'offdays'));
    }





    public function search3(Request $request)
    {
        $query = Offday::query();

        // Kullanıcı durumuna göre filtreleme
        if ($request->filled('status')) {
            $status = $request->input('status');
            $query->where('status', $status);
        }

        // İzin tarihi ile filtreleme
        if ($request->filled('offday_date')) {
            $offdayDate = $request->input('offday_date');
            $query->whereDate('offday_date', $offdayDate);
        }

        $offdays = $query->get();

        return view('admin.offdays.index', compact('offdays'));
    }





}
