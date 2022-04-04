<?php

namespace App\Http\Controllers;

use App\Mail\Reminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class WelcomePageController extends Controller
{
    public function index()
    {
        // echo"hehe";
        return view('frontend.welcome-page');
    }

    public function cronjob()
    {
        $now 	= date("Y-m-d");//echo $now ;
		$tujuhhari	= date("Y-m-d", strtotime("+7days"));
		$tigaHari	= date("Y-m-d", strtotime("+3days"));
		$satuHari	= date("Y-m-d", strtotime("+1days"));
        

        $expiredMsds7Hari = DB::table('msds')
        ->selectRaw('msds.*, departements.name as departement_name, departements.email as email, sevenday, threeday, oneday')
        ->join('departements', 'msds.departement_id', '=', 'departements.id')
        ->join('table_email_notify', 'msds.id', '=', 'table_email_notify.msds_id')
        ->whereBetween("expired_date",[$now, $tujuhhari])
        ->where('table_email_notify.sevenday', '=', 0)
        ->get();

        $expiredMsds3Hari = DB::table('msds')->selectRaw('msds.*, departements.name as departement_name, departements.email as email, sevenday, threeday, oneday')
        ->join('departements', 'msds.departement_id', '=', 'departements.id')
        ->join('table_email_notify', 'msds.id', '=', 'table_email_notify.msds_id')
        ->whereBetween("expired_date",[$now, $tigaHari])
        ->where('table_email_notify.sevenday', '=', 1)->where('table_email_notify.threeday', '=', 0)
        ->get();

        $expiredMsds1Hari = DB::table('msds')->selectRaw('msds.*, departements.name as departement_name, departements.email as email, sevenday, threeday, oneday')
        ->join('departements', 'msds.departement_id', '=', 'departements.id')
        ->join('table_email_notify', 'msds.id', '=', 'table_email_notify.msds_id')
        ->whereBetween("expired_date",[$now, $satuHari])
        ->where('table_email_notify.sevenday', '=', 1)->where('table_email_notify.threeday', '=', 1)->where('table_email_notify.oneday', '=', 0)
        ->get();

        foreach ($expiredMsds7Hari as $key => $value) {
            $findTableEmail = DB::table('table_email_notify')->where('msds_id', $value->id)->first();
            if ($findTableEmail->sevenday == 0) {
                try {
                    Mail::to($value->email)->send(new Reminder($value, "7"));
                    DB::table('table_email_notify')->where('id', $findTableEmail->id)->update([
                        'sevenday' => 1,
                    ]);
                    echo "success 7";
                } catch (\Throwable $th) {
                    dd($th->getMessage());
                }   
            }
        }

        foreach ($expiredMsds3Hari as $key => $value) {
            $findTableEmail = DB::table('table_email_notify')->where('msds_id', $value->id)->first();
            if ($findTableEmail->sevenday == 1 && $findTableEmail->threeday == 0) {
                try {
                    Mail::to($value->email)->send(new Reminder($value, "3"));
                    DB::table('table_email_notify')->where('id', $findTableEmail->id)->update([
                        'sevenday' => 1,
                        'threeday' => 1,
                    ]);
                    echo "success 3";
                } catch (\Throwable $th) {
                    dd($th->getMessage());
                }   
            }
        }

        foreach ($expiredMsds1Hari as $key => $value) {
            $findTableEmail = DB::table('table_email_notify')->where('msds_id', $value->id)->first();
            if ($findTableEmail->sevenday == 1 && $findTableEmail->threeday == 1 && $findTableEmail->oneday == 0) {
                try {
                    Mail::to($value->email)->send(new Reminder($value, "1"));
                    DB::table('table_email_notify')->where('id', $findTableEmail->id)->update([
                        'sevenday' => 1,
                        'threeday' => 1,
                        'oneday' => 1,
                    ]);
                    echo "success 1";
                } catch (\Throwable $th) {
                    dd($th->getMessage());
                }   
            }
        }
    }
}