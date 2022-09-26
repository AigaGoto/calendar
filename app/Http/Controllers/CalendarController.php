<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Event;

class CalendarController extends Controller
{
    public function calendar (Request $request) 
    {
        //　GETパラメータで年月が送られてきたらその月を表示
        // なければ今月にしてみてください。(吉田)

        // URLからパラメータを取得
        $year = $request->year;
        $month = $request->month;

        // 年月が存在するとき（年が0年以上、月が1~12の間）とそうでない時の切り替え
        if (0 <= $year && 1 <= $month && $month <= 12) {
            $date = new Carbon("{$year}-{$month}-01");
        } else {
            $today = new Carbon('today');

            $year = $today->year;
            $month = $today->month;

            $date = new Carbon("{$year}-{$month}-01");
        }

        // 月の週がいくつあるのかを計算
        $calendarDayCount = $date->daysInMonth + $date->dayOfWeek; 
        $calendarWeekCount = ceil($calendarDayCount / 7);
        
        // カレンダーの左上のnullのために、月初日の週の日曜日まで戻す
        $date->subDay($date->dayOfWeek);
        
        $calendarWeek = [];

        // 月の週の数分配列を加える
        for ($i = 0; $i < $calendarWeekCount; $i++) {
            array_push($calendarWeek, []);
        }

        for ($i = 0; $i < $calendarWeekCount; $i++) {
            for ($j = 0; $j < 7; $j++, $date->addDay()) {
                //9月だったら、日付を配列に代入、それ以外はnull
                if ($month == $date->month) {
                    array_push($calendarWeek[$i], $date->copy()->day);
                } else {
                    array_push($calendarWeek[$i], null);
                }
            }
        }

        // イベントを取得
        $events = Event::get();
        // dd($events[0]->name);

        $calendarEvents = [];

        for ($i = 0; $i < count($events); $i++) {
            $event = [$events[$i]->name, $events[$i]->date];
            array_push($calendarEvents, $event);
        }

        return view('calendar', compact('calendarWeek', 'calendarEvents'));
    }

    public function schedule () {
        return view('calendar.schedule');
    }

    public function scheduleAdd (Request $request) {
        
        //バリデーション　イベント名・日付どちらも必須
        // https://readouble.com/laravel/6.x/ja/validation.html
        // バリデーションはOKです！
        $validatedData = $request->validate([
            'name' => 'required|max:100',
            'date' => 'required',
        ]);
        
        // dd($validatedData);
        // dd($validatedData["name"], $validatedData["date"]);

        //データベースの登録 Event::createを使ってみてください。
        // $validatedData['name'];
        Event::create([
            'name' => $validatedData["name"],
            'date' => $validatedData["date"],
        ]);

        //calendarにリダイレクト
        return redirect('calendar');
    }
}
