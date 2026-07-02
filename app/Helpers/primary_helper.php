<?php

    function getURL($param = "")
    {
        return base_url($param);
    }

    function base_encode($text)
    {
        $txt = $text;
        for ($n = 0; $n < 6; $n++) {
            $txt = base64_encode($txt);
        }
        return $txt;
    }

    function respondAndDie($status, $msg)
    {
        echo json_encode([
            'success' => $status,
            'msg' => $msg,
            'csrfToken' => csrf_hash()
        ]);
        die;
    }

    function getSession($key)
    {
        return decrypting(session()->get($key . '-smp-session'));
    }
    function setSession($key, $value)
    {
        return session()->set($key . '-smp-session', encrypting($value));
    }
    function removeSession($key)
    {
        return session()->remove($key);
    }
    function destroySession()
    {
        return session()->destroy();
    }

    function encrypting($teks = '')
    {
        if ($teks == '') {
            return '';
        }
        $enkripsi = \Config\Services::encrypter();
        $base62 = new Tuupola\Base62;
        try {
            $result = $base62->encode($enkripsi->encrypt($teks));
        } catch (Exception $e) {
            $result = $teks;
        }
        return $result;
    }

    function decrypting($teks = '')
    {
        if ($teks == '') {
            return '';
        }
        $enkripsi = \Config\Services::encrypter();
        $base62 = new Tuupola\Base62;
        try {
            $result = $enkripsi->decrypt($base62->decode($teks));
        } catch (Exception $e) {
            $result = $teks;
        }
        return $result;
    }

    function getAvatar()
    {
        $avatar = getURL('public/images/avatar/avatar.png');
        return $avatar;
    }

?>