<?php

namespace App\Http\Controllers;

use App\Category;
use App\File;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Linfo\Linfo;
use Matriphe\Larinfo\Larinfo;

class HomeController extends Controller
{
    function get_system_cores()
    {
        $cmd = "uname";
        $OS = strtolower(trim(shell_exec($cmd)));

        switch ($OS) {
            case('linux'):
                $cmd = "cat /proc/cpuinfo | grep processor | wc -l";
                break;
            case('freebsd'):
                $cmd = "sysctl -a | grep 'hw.ncpu' | cut -d ':' -f2";
                break;
            default:
                unset($cmd);
        }

        if ($cmd != '') {
            $cpuCoreNo = intval(trim(shell_exec($cmd)));
        }

        return empty($cpuCoreNo) ? 1 : $cpuCoreNo;
    }

    public function cpu_usage($coreCount = 2, $interval = 1)
    {
        $rs = sys_getloadavg();
        $interval = $interval >= 1 && 3 <= $interval ? $interval : 1;
        $load = $rs[$interval];
        return round(($load * 100) / $coreCount, 2) . ' %';
    }

    function get_server_memory_usage()
    {
        $free = shell_exec('free');
        $free = (string)trim($free);
        $free_arr = explode("\n", $free);
        $mem = explode(" ", $free_arr[1]);
        $mem = array_filter($mem);
        $mem = array_merge($mem);
        return floor($mem[2] / 1000) . ' مگابایت';
    }

    function get_disk_usage()
    {
        $diskfree = disk_free_space('/');
        return floor($diskfree / 1000000000) . ' گیگابایت';
    }

    function get_server_uptime()
    {
        $str = @file_get_contents('/proc/uptime');
        $num = floatval($str);
        $secs = $num % 60;
        $num = (int)($num / 60);
        $mins = $num % 60;
        $num = (int)($num / 60);
        $hours = $num % 24;
        $num = (int)($num / 24);
        $days = $num;
        return $days . ' روز و ' . $hours . ' ساعت و ' . $mins . ' دقیقه و ' . $secs . ' ثانیه';
    }

    public function index(Request $request)
    {
        try {
            $softwareInfo = (new Larinfo($request, new Linfo()))->getServerInfoSoftware();
            if ($softwareInfo['os'] == 'Microsoft Windows 10 Pro') {
                $uptimeInfo = (new Larinfo($request, new Linfo()))->getUptime();
                $uptime = $uptimeInfo['uptime'] ? $uptimeInfo['uptime'] : 'نامشخص';
                $hardwareInfo = (new Larinfo($request, new Linfo()))->getServerInfoHardware();
                $ram = floor(($hardwareInfo['ram']['total'] - $hardwareInfo['ram']['free']) / 1000000) . ' مگابایت';
                $cpu = 'نامشخص';
                $hdd = floor(($hardwareInfo['disk']['free']) / 1000000000) . ' گیگابایت';
            } elseif ($softwareInfo['os'] == 'Linux') {
                $uptime = $this->get_server_uptime();
                $ram = $this->get_server_memory_usage();
                $cpu = $this->cpu_usage($this->get_system_cores());
                $hdd = $this->get_disk_usage();
            } else {
                $uptimeInfo = (new Larinfo($request, new Linfo()))->getUptime();
                $uptime = $uptimeInfo['uptime'];
                $hardwareInfo = (new Larinfo($request, new Linfo()))->getServerInfoHardware();
                $ram = floor(($hardwareInfo['ram']['total'] - $hardwareInfo['ram']['free']) / 1000000) . ' مگابایت';
                $cpu = 'نامشخص';
                $hdd = floor(($hardwareInfo['disk']['free']) / 1000000000) . ' گیگابایت';
            }

        } catch (\Exception $ex) {
            $uptime = 'نامشخص';
            $ram = 'نامشخص';
            $cpu = 'نامشخص';
            $hdd = 'نامشخص';
        }

        try {
            $userCount = User::all()->count();
            $catCount = Category::all()->count();
            $fileCount = File::all()->count();
        } catch (\Exception $ex) {

        }

        return view('dashboard', compact('userCount', 'catCount', 'fileCount', 'cpu', 'ram', 'hdd', 'uptime'));
    }

    public function login()
    {
        return view('login');
    }

    public function doLogin(Request $request)
    {

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials)) {
            return redirect('/admin');
        }
        return redirect()->back()->with('loginError', 'نام کاربری یا رمز عبور اشتباه می باشد');

    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }
}
