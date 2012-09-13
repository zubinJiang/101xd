<?php
session_start();

if ( isset($_GET['action']) && !empty($_GET['action'])) {
    if ('login' != $_GET['action']) exit;

    NBee::import('plugin/CSina/1.0/weibooauth');
    NBee::import('app/components/Cookies');
    NBee::import('app/models/MUser');

    $this->user   = new MUser();
    $this->cookie = new Cookies();

    $refer_url = isset($_GET['url']) ? trim($_GET['url']) : '';
    $refer_url = empty($refer_url) ? 'index' : $refer_url;

    $keys = $_COOKIE['_sina_'];
    $keys = base64_decode($keys);
    $keys = unserialize($keys);

    $sina_key    = $this->config['sina']['appKey'];
    $sina_secret = $this->config['sina']['appSecret'];

    $o = new WeiboOAuth($sina_key, $sina_secret, $keys['oauth_token'], $keys['oauth_token_secret']);
    $lastKey = $o->getAccessToken($_REQUEST['oauth_verifier'] ) ;

    $sina = new WeiboClient($sina_key, $sina_secret, $lastKey['oauth_token'], $lastKey['oauth_token_secret']);
    $me = $sina->verify_credentials();

    $sina_id   = $me['id'];
    $sina_name = $me['name'];
    $user_id   = $this->user->registerSinaUser($sina_id, $sina_name, $sina_id);

    $time  = time() + 86400*2;
    $value = "{$user_id}|{$time}|{$sina_id}";
    $value = base64_encode($value);
    $domain= $this->config['cookie']['domain'];
    setCookie('_userv_', $value, $time, '/', $domain);

    $this->cookie->_setCookie($user_id, 'Vanilla', $domain);
    $this->cookie->_setCookie($user_id, 'Vanilla-Volatile', $domain);

    $_SESSION['login_user_id']   = $user_id;
    $_SESSION['login_user_name'] = $sina_name;

    header("Location:{$refer_url}");
    exit;
}
?>
