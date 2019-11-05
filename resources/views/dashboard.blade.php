@extends('_layout')
@section('breadcrumb')
    داشبورد
@endsection
@section('content')

    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse" style="background-color: dodgerblue">
                <div class="card-block p-b-0" style="height:140px;">
                    <p>تعداد مدیران</p>
                    <h4 class="pull-left m-t-2">{{ (isset($userCount)) ? $userCount : '0'}}</h4>
                </div>
            </div>
        </div>
        <!--/col-->

        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse card-primary">
                <div class="card-block p-b-0" style="height:140px;">
                    <p>تعداد فایل ها</p>
                    <h4 class="pull-left m-t-2">{{ (isset($fileCount)) ? $fileCount : '0'}}</h4>
                </div>
            </div>
        </div>
        <!--/col-->

        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse" style="background-color: darkorange">
                <div class="card-block p-b-0" style="height:140px;">
                    <p>تعداد دسته بندی ها</p>
                    <h4 class="pull-left m-t-2">{{ (isset($catCount)) ? $catCount : '0'}}</h4>
                </div>
            </div>
        </div>
        <!--/col-->

        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse" style="background-color: tomato">
                <div class="card-block p-b-0" style="height:140px;">
                    <p>وب سرور</p>
                    <h5 class="pull-left m-t-2"><?php echo $_SERVER["SERVER_SOFTWARE"]; ?></h5>
                </div>
            </div>
        </div>
        <!--/col-->

    </div>
    <!--/row-->


    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse" style="background-color: darkgoldenrod">
                <div class="card-block p-b-0" style="height:140px;">
                    <p>مرورگر شما</p>
                    <h4 class="pull-left m-t-2">
                        <?php
                        function getBrowser()
                        {
                            $u_agent = $_SERVER['HTTP_USER_AGENT'];
                            $bname = 'Unknown';
                            $version = "";
                            if (preg_match('/MSIE/i', $u_agent) && !preg_match('/Opera/i', $u_agent)) {
                                $bname = 'Internet Explorer';
                                $ub = "MSIE";
                            } elseif (preg_match('/Firefox/i', $u_agent)) {
                                $bname = 'Mozilla Firefox';
                                $ub = "Firefox";
                            } elseif (preg_match('/OPR/i', $u_agent)) {
                                $bname = 'Opera';
                                $ub = "Opera";
                            } elseif (preg_match('/Chrome/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
                                $bname = 'Google Chrome';
                                $ub = "Chrome";
                            } elseif (preg_match('/Safari/i', $u_agent) && !preg_match('/Edge/i', $u_agent)) {
                                $bname = 'Apple Safari';
                                $ub = "Safari";
                            } elseif (preg_match('/Netscape/i', $u_agent)) {
                                $bname = 'Netscape';
                                $ub = "Netscape";
                            } elseif (preg_match('/Edge/i', $u_agent)) {
                                $bname = 'Edge';
                                $ub = "Edge";
                            } elseif (preg_match('/Trident/i', $u_agent)) {
                                $bname = 'Internet Explorer';
                                $ub = "MSIE";
                            }
                            $known = array('Version', $ub, 'other');
                            $pattern = '#(?<browser>' . join('|', $known) .
                                ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
                            if (!preg_match_all($pattern, $u_agent, $matches)) {
                            }
                            $i = count($matches['browser']);
                            if ($i != 1) {
                                if (strripos($u_agent, "Version") < strripos($u_agent, $ub)) {
                                    $version = $matches['version'][0];
                                } else {
                                    $version = $matches['version'][1];
                                }
                            } else {
                                $version = $matches['version'][0];
                            }

                            if ($version == null || $version == "") {
                                $version = "?";
                            }

                            return array(
                                'name' => $bname,
                                'version' => $version,
                            );
                        }

                        $ua = getBrowser();
                        print_r($ua['name'] . " " . $ua['version']);
                        ?>
                    </h4>
                </div>
            </div>
        </div>
        <!--/col-->

        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse" style="background-color: #008c69">
                <div class="card-block p-b-0" style="height:140px;">
                    <p>آدرس آی پی شما</p>
                    <h4 class="pull-left m-t-2"><?php echo $_SERVER['REMOTE_ADDR']; ?></h4>
                </div>
            </div>
        </div>
        <!--/col-->

        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse" style="background-color: #e27d60">
                <div class="card-block p-b-0" style="height:140px;">
                    <p>سقف اندازه آپلود</p>
                    <h4 class="pull-left m-t-2"><?php echo ini_get('post_max_size'); ?></h4>
                </div>
            </div>
        </div>
        <!--/col-->

        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse" style="background-color: #66fcf1">
                <div class="card-block p-b-0" style="height:140px;">
                    <p>پایگاه داده</p>
                    <h4 class="pull-left m-t-2">MySQL</h4>
                </div>
            </div>
        </div>
        <!--/col-->

    </div>
    <!--/row-->


    <div class="row">
        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse" style="background-color: #026466">
                <div class="card-block p-b-0" style="height:140px;">
                    <p>میزان مصرف CPU</p>
                    <h4 class="pull-left m-t-2">{{ (isset($cpu)) ? $cpu : ''}}</h4>
                </div>
            </div>
        </div>
        <!--/col-->

        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse" style="background-color: #943b2d">
                <div class="card-block p-b-0" style="height:140px;">
                    <p>میزان مصرف RAM</p>
                    <h4 class="pull-left m-t-2">{{ (isset($ram)) ? $ram : ''}}</h4>
                </div>
            </div>
        </div>
        <!--/col-->

        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse" style="background-color: #4e555b">
                <div class="card-block p-b-0" style="height:140px;">
                    <p>میزان فضای خالی هارد</p>
                    <h4 class="pull-left m-t-2">{{ (isset($hdd)) ? $hdd : ''}}</h4>
                </div>
            </div>
        </div>
        <!--/col-->

        <div class="col-sm-6 col-lg-3">
            <div class="card card-inverse" style="background-color: #61007c">
                <div class="card-block p-b-0" style="height:140px;">
                    <p>آپتایم سیستم</p>
                    <h5 class="pull-left m-t-2">{{ (isset($uptime)) ? $uptime : ''}}</h5>
                </div>
            </div>
        </div>
        <!--/col-->

    </div>
    <!--/row-->

@stop
