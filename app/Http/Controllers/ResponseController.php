use App\Models\Response;
use App\Models\Report;
use Illuminate\Support\Facades\Auth;

public function store(Request $request, $reportId)
{
    $request->validate([
        'message' => 'required'
    ]);

    Response::create([
        'report_id' => $reportId,
        'user_id' => Auth::id(),
        'message' => $request->message
    ]);

    return back()->with('success', 'Balasan dikirim');
}