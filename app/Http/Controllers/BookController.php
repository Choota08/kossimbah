<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class BookController extends Controller
{
    /* ======================
       USER BOOK KOS
       ====================== */
    public function store(Request $request)
    {
        $request->validate([
            'kos_id'     => 'required|integer',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date'   => 'required|date|after:start_date',
        ]);

        $userId = Auth::id();

        // ⏰ PAKSA JAM 10 PAGI
        $startDate = Carbon::parse($request->start_date)->setTime(10, 0, 0);
        $endDate   = Carbon::parse($request->end_date)->setTime(10, 0, 0);

        // ❌ CEGAH BOOKING HARI INI SETELAH JAM 10
        if ($startDate->isToday() && now()->hour >= 10) {
            return response()->json([
                'message' => 'Booking hari ini sudah ditutup'
            ], 422);
        }

        // 🔴 CEGAH BOOKING JIKA KOS SUDAH TERISI (CONFIRMED)
        $kosOccupied = Book::where('kos_id', $request->kos_id)
            ->where('status', 'confirmed')
            ->exists();

        if ($kosOccupied) {
            return response()->json([
                'message' => 'Kos sudah terisi'
            ], 409);
        }

        // 🔒 CEGAH DOUBLE BOOKING USER (pending / confirmed)
        $exists = Book::where('user_id', $userId)
            ->where('kos_id', $request->kos_id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => 'Kamu masih memiliki booking aktif untuk kos ini'
            ], 409);
        }

        // 🔒 CEGAH OVERLAP TANGGAL BOOKING
        $overlap = Book::where('kos_id', $request->kos_id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->where(function ($q) use ($startDate, $endDate) {
                $q->whereBetween('start_date', [$startDate, $endDate])
                  ->orWhereBetween('end_date', [$startDate, $endDate])
                  ->orWhere(function ($q) use ($startDate, $endDate) {
                      $q->where('start_date', '<=', $startDate)
                        ->where('end_date', '>=', $endDate);
                  });
            })
            ->exists();

        if ($overlap) {
            return response()->json([
                'message' => 'Tanggal booking bentrok dengan booking lain'
            ], 409);
        }

        // ✅ CREATE BOOKING
        $booking = Book::create([
            'kos_id'     => $request->kos_id,
            'user_id'    => $userId,
            'start_date' => $startDate,
            'end_date'   => $endDate,
            'status'     => 'pending',
        ]);

        return response()->json([
            'message' => 'Booking berhasil, menunggu persetujuan admin',
            'data'    => $booking,
        ], 201);
    }

    /* ======================
       USER CANCEL BOOKING
       ====================== */
    public function cancel($id)
    {
        $booking = Book::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        if (!$booking->isPending()) {
            return response()->json([
                'message' => 'Booking tidak dapat dibatalkan'
            ], 400);
        }

        $booking->update(['status' => 'cancelled']);

        return response()->json([
            'message' => 'Booking berhasil dibatalkan'
        ]);
    }

    /* ======================
       ADMIN - LIST BOOKING
       ====================== */
    public function index(Request $request)
    {
        if (!Auth::user()->isAdmin()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return Book::with(['user', 'kos'])
            ->when($request->status, fn ($q) =>
                $q->where('status', $request->status)
            )
            ->latest()
            ->get();
    }

    /* ======================
       ADMIN APPROVE
       ====================== */
    public function approve($id)
    {
        if (!Auth::user()->isAdmin()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $booking = Book::findOrFail($id);

        if (!$booking->isPending()) {
            return response()->json([
                'message' => 'Booking tidak bisa disetujui'
            ], 400);
        }

        $booking->update(['status' => 'confirmed']);

        return response()->json([
            'message' => 'Booking disetujui'
        ]);
    }

    /* ======================
       ADMIN REJECT
       ====================== */
    public function reject($id)
    {
        if (!Auth::user()->isAdmin()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $booking = Book::findOrFail($id);

        if (!$booking->isPending()) {
            return response()->json([
                'message' => 'Booking tidak bisa ditolak'
            ], 400);
        }

        $booking->update(['status' => 'rejected']);

        return response()->json([
            'message' => 'Booking ditolak'
        ]);
    }

    /* ======================
       ADMIN COMPLETE
       ====================== */
    public function complete($id)
    {
        if (!Auth::user()->isAdmin()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $booking = Book::findOrFail($id);

        if (!$booking->isConfirmed()) {
            return response()->json([
                'message' => 'Booking belum disetujui'
            ], 400);
        }

        $booking->update(['status' => 'completed']);

        return response()->json([
            'message' => 'Booking selesai (kos kosong)'
        ]);
    }

    /* ======================
       ADMIN DELETE
       ====================== */
    public function destroy($id)
    {
        if (!Auth::user()->isAdmin()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        Book::findOrFail($id)->delete();

        return response()->json([
            'message' => 'Booking dihapus'
        ]);
    }

    /* ======================
       USER - RIWAYAT BOOKING
       ====================== */
    public function myBookings()
    {
        return Book::with(['kos.images'])
            ->where('user_id', Auth::id())
            ->latest()
            ->get();
    }

    /* ======================
       USER - DOWNLOAD STRUK
       ====================== */
    public function downloadInvoice($id)
    {
        $booking = Book::with(['kos', 'user'])
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $pdf = Pdf::loadView('pdf.invoice', compact('booking'));

        return $pdf->download(
            'struk-booking-' . $booking->id . '.pdf'
        );
    }
}
