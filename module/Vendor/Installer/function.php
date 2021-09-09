<?php

define('APP_PATH', realpath(__DIR__ . '/../../../'));

include APP_PATH . '/vendor/modstart/modstart/src/Core/Env/EnvUtil.php';
include APP_PATH . '/vendor/modstart/modstart/src/Core/Util/EnvUtil.php';
include APP_PATH . '/vendor/modstart/modstart/src/Core/Util/RandomUtil.php';
include APP_PATH . '/vendor/modstart/modstart/src/Core/Util/CurlUtil.php';
include APP_PATH . '/vendor/modstart/modstart/src/Core/Util/FileUtil.php';

define('INSTALL_LOCK_FILE', APP_PATH . '/storage/install.lock');
define('ENV_FILE_EXAMPLE', APP_PATH . '/env.example');
define('ENV_FILE', APP_PATH . '/.env');
if (file_exists($licenseFile = APP_PATH . '/license.txt')) {
    define('LICENSE_URL', trim(file_get_contents($licenseFile)));
}
if (file_exists($demoData = APP_PATH . '/public/data_demo/data.php')) {
    define('DEMO_DATA', true);
}

if (!file_exists(ENV_FILE)) {
    file_put_contents(ENV_FILE, "APP_ENV=beta\nAPP_DEBUG=true\nAPP_KEY=" . \ModStart\Core\Util\RandomUtil::string(32));
}

function get_env_config($key, $default = '')
{
    static $envConfig = null;
    if (null == $envConfig) {
        $envConfig = array();
        if (!empty($configFiles = glob(APP_PATH . '/env.*.json'))) {
            foreach ($configFiles as $configFile) {
                $env = @json_decode(@file_get_contents($configFile), true);
                if (!empty($env)) {
                    $envConfig = array_merge($envConfig, $env);
                }
            }
        }
    }
    if (isset($envConfig[$key])) {
        return $envConfig[$key];
    }
    $envMap = [
        'db_host' => 'DB_HOST',
        'db_name' => 'DB_DATABASE',
        'db_username' => 'DB_USERNAME',
        'db_password' => 'DB_PASSWORD',
        'db_prefix' => 'DB_PREFIX',
        'admin_username' => 'ADMIN_USERNAME',
        'admin_password' => 'ADMIN_PASSWORD',
    ];
    if (isset($envMap[$key])) {
        return env($envMap[$key], $default);
    }
    return $default;
}

function response_json_error_quit($msg)
{
    response_json_quit(-1, $msg);
}

function response_json_quit($code, $msg, $data = null, $redirect = null)
{
    header('Content-type: application/json');
    echo json_encode([
        'code' => $code,
        'msg' => $msg,
        'data' => $data,
        'redirect' => $redirect,
    ]);
    exit();
}

function request_schema()
{
    $schema = 'http';
    if (is_https()) {
        $schema = 'https';
    }
    return $schema;
}

function request_domain()
{
    return $_SERVER['HTTP_HOST'];
}

function request_url()
{
    return request_schema() . '://' . request_domain();
}

function request_is_post()
{
    return !empty($_POST);
}

function is_https()
{
    if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
        return true;
    } elseif (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
        return true;
    } elseif (!empty($_SERVER['HTTP_FRONT_END_HTTPS']) && strtolower($_SERVER['HTTP_FRONT_END_HTTPS']) !== 'off') {
        return true;
    }
    return false;
}

function request_post($k, $defaultValue = '')
{
    return isset($_POST[$k]) ? $_POST[$k] : $defaultValue;
}

function text_success($msg)
{
    echo '<div class="ub-alert ub-alert-success">√ ' . $msg . '</div>';
}

function text_error($msg, $solutionUrl = null, $count = true)
{
    if ($count) {
        error_counter();
    }
    echo '<div class="ub-alert ub-alert-danger">× ' . $msg . ' ' . ($solutionUrl ? '<a target="_blank" href="' . $solutionUrl . '">解决办法</a>' : '') . '</div>';
}

function error_counter($inc = 1)
{
    static $error = 0;
    $error += $inc;
    return $error;
}

function env_writable()
{
    $file = APP_PATH . '/.env';
    if (!file_exists($file)) {
        if (false === file_put_contents($file, "")) {
            @unlink($file);
            return false;
        }
        @unlink($file);
        return true;
    }
    $content = @file_get_contents($file);
    if (false === file_put_contents($file, $content)) {
        return false;
    }
    return true;
}

function rewrite_check()
{
    if (file_exists(APP_PATH . '/storage/rewrite.skip')) {
        return ['code' => 0, 'msg' => 'ok'];
    }
    $domain = request_domain();
    $url = request_url() . '/install/ping';
    $ret = \ModStart\Core\Util\CurlUtil::get($url, [], [
        'timeout' => 3,
    ]);
    if ($ret['body'] === 'ok') {
        return ['code' => 0, 'msg' => ''];
    }
    $msgs = [];
    if (!empty($ret['error'])) {
        if (false !== strpos($ret['error'], 'Resolving timed out')) {
            $msgs[] = "- 域名 $domain 解析失败（可能您没有解析域名）";
            $msgs[] = "- 在服务器不能访问 $url ，需要在程序中通过改地址访问到程序";
        } else {
            $msgs[] = '- ERROR:' . $ret['error'];
        }
    }
    if (!empty($ret['code'])) {
        if (!empty($ret['body'])) {
            $msg = $ret['body'];
            $index = strpos($ret['body'], '<body>');
            if (false !== $index) {
                $msg = substr($msg, $index);
            }
            $index = strpos($ret['body'], '</body>');
            if (false !== $index) {
                $msg = substr($msg, 0, $index);
            }
            $msgs[] = '- 程序出错:' . preg_replace('/\\s+/', ' ', preg_replace('/<[^>]+>/', '', $msg));
        }
    }
    $msgs[] = "- 您还可以在浏览器访问 <a href='$url' target='_blank'>$url</a> 查看报错信息，调整配置保证测试页面提示“ok”字样";
    return ['code' => -1, 'msg' => 'Rewrite规则错误可能原因（仅供参考）：<br/>' . join('<br/>', $msgs)];
}

function env($key, $defaultValue = '')
{
    static $values = null;
    if (null === $values) {
        $values = \ModStart\Core\Env\EnvUtil::all(ENV_FILE_EXAMPLE);
    }
    return isset($values[$key]) ? $values[$key] : $defaultValue;
}
