<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Modles\Visit;
use Carbon\Carbon;
use Jenssegers\Agent\Agent;
use GeoIp2\Database\Reader;
use GeoIp2\Exception\AddressNotFoundException;
use Illuminate\Support\Facades\DB;
use Torann\GeoIP\Facades\GeoIP;
class FatherController extends Controller
{
    //获取用户ip相关信息
    //判断是否是当天第一次访问，是记录到日志表，否则更新访问时间
    public $ip;
    protected $geo;

    public function __construct(Request $request)
    {
        $this->ip = $request->getClientIp();
        $blackIp = DB::table('black_ip')->where('ip',$this->ip)->first();
        if($blackIp){
            echo '<script>alert("黑名单用户！！！无权访问！！！");</script>';
            die;
        }
        $beginDate = Carbon::today()->toDateString().' 00:00:00';
        $endDate = Carbon::tomorrow()->toDateString().' 23:59:59';
        $res = Visit::where('ip',$this->ip)->whereBetween('created_at',[$beginDate,$endDate])->first();
        if(!$res){
            $agent = new Agent();
            $browser  = $agent->browser();
            $platform = $agent->platform();
            //根据ip获取国家代码
            $this->geo = new Reader('GeoLite2-Country.mmdb');
            $country_code = $this->getCountryCodeFromGeo($this->ip);
            //根据ip获取城市
            //$location = GeoIP::getLocation($this->ip)->toArray();
            //var_dump($location['state_name']);exit();
            $visit = new Visit;
            $visit->ip = $this->ip;
            $visit->country_code = $country_code;
            $visit->userAgent = $agent->getUserAgent();
            $visit->platform = $platform;
            $visit->platform_version = $agent->version($platform);
            $visit->browser = $browser;
            $visit->browser_version = $agent->version($browser);
            $visit->device = $agent->device();
            $visit->is_black = 'no';
            $visit->save();
        }else{
            $res->updated_at = Carbon::now()->toDateTimeString();
            $res->save();
        }
    }

    public function getCountryCodeFromGeo(string $ip) {
        try {
            $geo = $this->geo->country($ip);
            return $geo->country->isoCode;
        } catch (AddressNotFoundException $e) {
            return 'Unknown';
        }
    }

}