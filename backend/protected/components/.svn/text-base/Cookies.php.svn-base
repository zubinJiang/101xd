<?php
class Cookies {

    public static function Hash($Data, $CookieHashMethod, $CookieSalt) {
        return self::HashHMAC($CookieHashMethod, $Data, $CookieSalt);
    }


    public static function HashHMAC($HashMethod, $Data, $Key) {
        $PackFormats = array('md5' => 'H32', 'sha1' => 'H40');

        if (!isset($PackFormats[$HashMethod])) { return false; }

        $PackFormat = $PackFormats[$HashMethod];
        if (isset($Key[63])) {

            $Key = pack($PackFormat, $HashMethod($Key));
        } else {
            $Key = str_pad($Key, 64, chr(0));
        }

        $InnerPad = (substr($Key, 0, 64) ^ str_repeat(chr(0x36), 64));
        $OuterPad = (substr($Key, 0, 64) ^ str_repeat(chr(0x5C), 64));

        return $HashMethod($OuterPad . pack($PackFormat, $HashMethod($InnerPad . $Data)));
    }

    public static function _setCookie($UserID, $CookieName, $Domain='.101xd.com', $Persist=false) {
        if ($Persist !== FALSE) {
            $Expiration = $Expire = time() + 2592000;
        } else {
            $Expiration = time() + 172800;
            $Expire = 0;
        }

        $CookieHashMethod = 'md5';
        $CookieSalt       = '0ZFYOTKOQ0';
        $KeyData          = $UserID.'-'.$Expiration;
        $CookieContents   = array($UserID, $Expiration);

        $Key  = self::Hash($KeyData, $CookieHashMethod, $CookieSalt);
        $Hash = self::HashHMAC($CookieHashMethod, $KeyData, $Key);

        $Cookie = array($KeyData,$Hash,time());

        if (!is_null($CookieContents)) {
            if (!is_array($CookieContents)) { $CookieContents = array($CookieContents); }
            $Cookie = array_merge($Cookie, $CookieContents);
        }

        $CookieContents = implode('|',$Cookie);

        setcookie($CookieName, $CookieContents, $Expire, '/', $Domain);
        $_COOKIE[$CookieName] = $CookieContents;
    }
}
?>
