<?php


namespace App\Http\Controllers;


use App\Log;
use App\Trap;
use App\Visit;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public static final const REFERRER = "Referer";
    public static final const USER_AGENT = "User-Agent";
    public static final const CONTENT_TYPE = "Content-Type";
    private static final const GIF_MIME_TYPE = "image/gif";
    private static final const TRANSPARENT_GIF = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7";
    private static final const MISSING = "MISSING";

    public function index(Request $request)
    {
        $q = $request->query("q");
        if(!empty($q)) {
            $trap = Trap::find($q);
            if(!empty($trap)) {
                $this->saveVisit($trap);
            }
        }
        return response()->setContent(self::TRANSPARENT_GIF)->header(self::CONTENT_TYPE, self::GIF_MIME_TYPE);
    }

    /**
     * Tracks that someone had visited a particular link
     * @param $trap Trap
     */
    private function saveVisit($trap) {
        $visit = new Visit();
        $visit->trap()->associate($trap);
        $visit->save();
        $this->saveHeader($visit, self::REFERRER);
        $this->saveHeader($visit, self::USER_AGENT);
        $this->saveIp($visit);
    }

    /**
     * @param $visit Visit
     * @param $header string
     */
    private function saveHeader($visit, $header) {
        $value = request()->header($header, self::MISSING);
        $this->saveLog($visit, $header, $value);
    }

    /**
     * @param $visit Visit
     */
    private function saveIp($visit) {
        $values = request()->ips();
        foreach($values as $key => $value) {
            $this->saveLog($visit, self::IP, $value);
        }
    }

    private function saveLog($visit, $key, $value) {
        $log = new Log();
        $log->key = $key;
        $log->value = $value;
        $log->visit()->associate($visit);
        $log->save();
    }
}
