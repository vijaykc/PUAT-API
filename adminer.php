<?php
/** Adminer - Compact database management
* @link https://www.adminer.org/
*
* @author Jakub Vrana, https://www.vrana.cz/
* @copyright 2007 Jakub Vrana
* @license https://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
* @license https://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 (one or other)
*
* @version 4.7.0
*/error_reporting(6135);
$tc = ! preg_match('~^(unsafe_raw)?$~', ini_get('filter.default'));
if ($tc || ini_get('filter.default_flags')) {
    foreach (['_GET', '_POST', '_COOKIE', '_SERVER']as$X) {
        $Zg = filter_input_array(constant("INPUT$X"), FILTER_UNSAFE_RAW);
        if ($Zg) {
            $$X = $Zg;
        }
    }
}if (function_exists('mb_internal_encoding')) {
    mb_internal_encoding('8bit');
}function connection()
{
    global$g;

    return$g;
}function adminer()
{
    global$c;

    return$c;
}function version()
{
    global$fa;

    return$fa;
}function idf_unescape($w)
{
    $sd = substr($w, -1);

    return
    str_replace($sd.$sd, $sd, substr($w, 1, -1));
}function escape_string($X)
{
    return
    substr(q($X), 1, -1);
}function number($X)
{
    return
    preg_replace('~[^0-9]+~', '', $X);
}function number_type()
{
    return'((?<!o)int(?!er)|numeric|real|float|double|decimal|money)';
}function remove_slashes($ff, $tc = false)
{
    if (get_magic_quotes_gpc()) {
        while ([$_, $X] = each($ff)) {
            foreach ($X
            as$kd => $W) {
                unset($ff[$_][$kd]);
                if (is_array($W)) {
                    $ff[$_][stripslashes($kd)] = $W;
                    $ff[] = &$ff[$_][stripslashes($kd)];
                } else {
                    $ff[$_][stripslashes($kd)] = ($tc ? $W : stripslashes($W));
                }
            }
        }
    }
}function bracket_escape($w, $_a = false)
{
    static$Mg = [':' => ':1', ']' => ':2', '[' => ':3', '"' => ':4'];

    return
    strtr($w, ($_a ? array_flip($Mg) : $Mg));
}function min_version($nh, $Ed = '', $h = null)
{
    global$g;
    if (! $h) {
        $h = $g;
    }$Nf = $h->server_info;
    if ($Ed && preg_match('~([\d.]+)-MariaDB~', $Nf, $D)) {
        $Nf = $D[1];
        $nh = $Ed;
    }

return version_compare($Nf, $nh) >= 0;
}function charset($g)
{
    return min_version('5.5.3', 0, $g) ? 'utf8mb4' : 'utf8';
}function script($Vf, $Lg = "\n")
{
    return'<script'.nonce().">$Vf</script>$Lg";
}function script_src($eh)
{
    return"<script src='".h($eh)."'".nonce()."></script>\n";
}function nonce()
{
    return' nonce="'.get_nonce().'"';
}function target_blank()
{
    return' target="_blank" rel="noreferrer noopener"';
}function h($fg)
{
    return
    str_replace("\0", '&#0;', htmlspecialchars($fg, ENT_QUOTES, 'utf-8'));
}function nl_br($fg)
{
    return
    str_replace("\n", '<br>', $fg);
}function checkbox($F, $Y, $Na, $od = '', $oe = '', $Ra = '', $pd = '')
{
    $K = "<input type='checkbox' name='$F' value='".h($Y)."'".($Na ? ' checked' : '').($pd ? " aria-labelledby='$pd'" : '').'>'.($oe ? script("qsl('input').onclick = function () { $oe };", '') : '');

    return $od != '' || $Ra ? '<label'.($Ra ? " class='$Ra'" : '').">$K".h($od).'</label>' : $K;
}function optionlist($se, $If = null, $hh = false)
{
    $K = '';
    foreach ($se
    as$kd => $W) {
        $te = [$kd => $W];
        if (is_array($W)) {
            $K .= '<optgroup label="'.h($kd).'">';
            $te = $W;
        }foreach ($te
        as$_ => $X) {
            $K .= '<option'.($hh || is_string($_) ? ' value="'.h($_).'"' : '').(($hh || is_string($_) ? (string) $_ : $X) === $If ? ' selected' : '').'>'.h($X);
        }if (is_array($W)) {
            $K .= '</optgroup>';
        }
    }

return$K;
}function html_select($F, $se, $Y = '', $ne = true, $pd = '')
{
    if ($ne) {
        return"<select name='".h($F)."'".($pd ? " aria-labelledby='$pd'" : '').'>'.optionlist($se, $Y).'</select>'.(is_string($ne) ? script("qsl('select').onchange = function () { $ne };", '') : '');
    }$K = '';
    foreach ($se
    as$_ => $X) {
        $K .= "<label><input type='radio' name='".h($F)."' value='".h($_)."'".($_ == $Y ? ' checked' : '').'>'.h($X).'</label>';
    }

return$K;
}function select_input($wa, $se, $Y = '', $ne = '', $Se = '')
{
    $ug = ($se ? 'select' : 'input');

    return"<$ug$wa".($se ? "><option value=''>$Se".optionlist($se, $Y, true).'</select>' : " size='10' value='".h($Y)."' placeholder='$Se'>").($ne ? script("qsl('$ug').onchange = $ne;", '') : '');
}function confirm($E = '', $Jf = "qsl('input')")
{
    return
    script("$Jf.onclick = function () { return confirm('".($E ? js_escape($E) : lang(0))."'); };", '');
}function print_fieldset($v, $xd, $qh = false)
{
    echo'<fieldset><legend>',"<a href='#fieldset-$v'>$xd</a>",script("qsl('a').onclick = partial(toggle, 'fieldset-$v');", ''),'</legend>',"<div id='fieldset-$v'".($qh ? '' : " class='hidden'").">\n";
}function bold($Ga, $Ra = '')
{
    return $Ga ? " class='active $Ra'" : ($Ra ? " class='$Ra'" : '');
}function odd($K = ' class="odd"')
{
    static$u = 0;
    if (! $K) {
        $u = -1;
    }

return $u++ % 2 ? $K : '';
}function js_escape($fg)
{
    return
    addcslashes($fg, "\r\n'\\/");
}function json_row($_, $X = null)
{
    static$uc = true;
    if ($uc) {
        echo'{';
    }if ($_ != '') {
        echo($uc ? '' : ',')."\n\t\"".addcslashes($_, "\r\n\t\"\\/").'": '.($X !== null ? '"'.addcslashes($X, "\r\n\"\\/").'"' : 'null');
        $uc = false;
    } else {
        echo"\n}\n";
        $uc = true;
    }
}function ini_bool($Yc)
{
    $X = ini_get($Yc);

    return preg_match('~^(on|true|yes)$~i', $X) || (int) $X;
}function sid()
{
    static$K;
    if ($K === null) {
        $K = (SID && ! ($_COOKIE && ini_bool('session.use_cookies')));
    }

return$K;
}function set_password($mh, $O, $V, $Oe)
{
    $_SESSION['pwds'][$mh][$O][$V] = ($_COOKIE['adminer_key'] && is_string($Oe) ? [encrypt_string($Oe, $_COOKIE['adminer_key'])] : $Oe);
}function get_password()
{
    $K = get_session('pwds');
    if (is_array($K)) {
        $K = ($_COOKIE['adminer_key'] ? decrypt_string($K[0], $_COOKIE['adminer_key']) : false);
    }

return$K;
}function q($fg)
{
    global$g;

    return$g->quote($fg);
}function get_vals($I, $d = 0)
{
    global$g;
    $K = [];
    $J = $g->query($I);
    if (is_object($J)) {
        while ($L = $J->fetch_row()) {
            $K[] = $L[$d];
        }
    }

return$K;
}function get_key_vals($I, $h = null, $Qf = true)
{
    global$g;
    if (! is_object($h)) {
        $h = $g;
    }$K = [];
    $J = $h->query($I);
    if (is_object($J)) {
        while ($L = $J->fetch_row()) {
            if ($Qf) {
                $K[$L[0]] = $L[1];
            } else {
                $K[] = $L[0];
            }
        }
    }

return$K;
}function get_rows($I, $h = null, $m = "<p class='error'>")
{
    global$g;
    $eb = (is_object($h) ? $h : $g);
    $K = [];
    $J = $eb->query($I);
    if (is_object($J)) {
        while ($L = $J->fetch_assoc()) {
            $K[] = $L;
        }
    } elseif (! $J && ! is_object($h) && $m && defined('PAGE_HEADER')) {
        echo$m.error()."\n";
    }

return$K;
}function unique_array($L, $y)
{
    foreach ($y
    as$x) {
        if (preg_match('~PRIMARY|UNIQUE~', $x['type'])) {
            $K = [];
            foreach ($x['columns']as$_) {
                if (! isset($L[$_])) {
                    continue
                    2;
                }$K[$_] = $L[$_];
            }

return$K;
        }
    }
}function escape_key($_)
{
    if (preg_match('(^([\w(]+)('.str_replace('_', '.*', preg_quote(idf_escape('_'))).')([ \w)]+)$)', $_, $D)) {
        return$D[1].idf_escape(idf_unescape($D[2])).$D[3];
    }

return
    idf_escape($_);
}function where($Z, $o = [])
{
    global$g,$z;
    $K = [];
    foreach ((array) $Z['where']as$_ => $X) {
        $_ = bracket_escape($_, 1);
        $d = escape_key($_);
        $K[] = $d.($z == 'sql' && preg_match('~^[0-9]*\.[0-9]*$~', $X) ? ' LIKE '.q(addcslashes($X, '%_\\')) : ($z == 'mssql' ? ' LIKE '.q(preg_replace('~[_%[]~', '[\0]', $X)) : ' = '.unconvert_field($o[$_], q($X))));
        if ($z == 'sql' && preg_match('~char|text~', $o[$_]['type']) && preg_match('~[^ -@]~', $X)) {
            $K[] = "$d = ".q($X).' COLLATE '.charset($g).'_bin';
        }
    }foreach ((array) $Z['null']as$_) {
        $K[] = escape_key($_).' IS NULL';
    }

return
    implode(' AND ', $K);
}function where_check($X, $o = [])
{
    parse_str($X, $Ma);
    remove_slashes([&$Ma]);

    return
    where($Ma, $o);
}function where_link($u, $d, $Y, $pe = '=')
{
    return"&where%5B$u%5D%5Bcol%5D=".urlencode($d)."&where%5B$u%5D%5Bop%5D=".urlencode(($Y !== null ? $pe : 'IS NULL'))."&where%5B$u%5D%5Bval%5D=".urlencode($Y);
}function convert_fields($e, $o, $N = [])
{
    $K = '';
    foreach ($e
    as$_ => $X) {
        if ($N && ! in_array(idf_escape($_), $N)) {
            continue;
        }$ua = convert_field($o[$_]);
        if ($ua) {
            $K .= ", $ua AS ".idf_escape($_);
        }
    }

return$K;
}function cookie($F, $Y, $_d = 2592000)
{
    global$ba;

    return
    header("Set-Cookie: $F=".urlencode($Y).($_d ? '; expires='.gmdate('D, d M Y H:i:s', time() + $_d).' GMT' : '').'; path='.preg_replace('~\?.*~', '', $_SERVER['REQUEST_URI']).($ba ? '; secure' : '').'; HttpOnly; SameSite=lax', false);
}function restart_session()
{
    if (! ini_bool('session.use_cookies')) {
        session_start();
    }
}function stop_session($wc = false)
{
    if (! ini_bool('session.use_cookies') || ($wc && @ini_set('session.use_cookies', false) !== false)) {
        session_write_close();
    }
}function &get_session($_)
{
    return$_SESSION[$_][DRIVER][SERVER][$_GET['username']];
}function set_session($_, $X)
{
    $_SESSION[$_][DRIVER][SERVER][$_GET['username']] = $X;
}function auth_url($mh, $O, $V, $k = null)
{
    global$Ib;
    preg_match('~([^?]*)\??(.*)~', remove_from_uri(implode('|', array_keys($Ib)).'|username|'.($k !== null ? 'db|' : '').session_name()), $D);

    return"$D[1]?".(sid() ? SID.'&' : '').($mh != 'server' || $O != '' ? urlencode($mh).'='.urlencode($O).'&' : '').'username='.urlencode($V).($k != '' ? '&db='.urlencode($k) : '').($D[2] ? "&$D[2]" : '');
}function is_ajax()
{
    return $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
}function redirect($C, $E = null)
{
    if ($E !== null) {
        restart_session();
        $_SESSION['messages'][preg_replace('~^[^?]*~', '', ($C !== null ? $C : $_SERVER['REQUEST_URI']))][] = $E;
    }if ($C !== null) {
        if ($C == '') {
            $C = '.';
        }header("Location: $C");
        exit;
    }
}function query_redirect($I, $C, $E, $nf = true, $gc = true, $nc = false, $Ag = '')
{
    global$g,$m,$c;
    if ($gc) {
        $bg = microtime(true);
        $nc = ! $g->query($I);
        $Ag = format_time($bg);
    }$Xf = '';
    if ($I) {
        $Xf = $c->messageQuery($I, $Ag, $nc);
    }if ($nc) {
        $m = error().$Xf.script('messagesPrint();');

        return
        false;
    }if ($nf) {
        redirect($C, $E.$Xf);
    }

return
    true;
}function queries($I)
{
    global$g;
    static$if = [];
    static$bg;
    if (! $bg) {
        $bg = microtime(true);
    }if ($I === null) {
        return
        [implode("\n", $if), format_time($bg)];
    }$if[] = (preg_match('~;$~', $I) ? "DELIMITER ;;\n$I;\nDELIMITER " : $I).';';

    return$g->query($I);
}function apply_queries($I, $S, $cc = 'table')
{
    foreach ($S
    as$Q) {
        if (! queries("$I ".$cc($Q))) {
            return
            false;
        }
    }

return
    true;
}function queries_redirect($C, $E, $nf)
{
    [$if, $Ag] = queries(null);

    return
    query_redirect($if, $C, $E, $nf, false, ! $nf, $Ag);
}function format_time($bg)
{
    return
    lang(1, max(0, microtime(true) - $bg));
}function remove_from_uri($Ge = '')
{
    return
    substr(preg_replace("~(?<=[?&])($Ge".(SID ? '' : '|'.session_name()).')=[^&]*&~', '', "$_SERVER[REQUEST_URI]&"), 0, -1);
}function pagination($G, $pb)
{
    return' '.($G == $pb ? $G + 1 : '<a href="'.h(remove_from_uri('page').($G ? "&page=$G".($_GET['next'] ? '&next='.urlencode($_GET['next']) : '') : '')).'">'.($G + 1).'</a>');
}function get_file($_, $xb = false)
{
    $rc = $_FILES[$_];
    if (! $rc) {
        return
        null;
    }foreach ($rc
    as$_ => $X) {
        $rc[$_] = (array) $X;
    }$K = '';
    foreach ($rc['error']as$_ => $m) {
        if ($m) {
            return$m;
        }$F = $rc['name'][$_];
        $Ig = $rc['tmp_name'][$_];
        $fb = file_get_contents($xb && preg_match('~\.gz$~', $F) ? "compress.zlib://$Ig" : $Ig);
        if ($xb) {
            $bg = substr($fb, 0, 3);
            if (function_exists('iconv') && preg_match("~^\xFE\xFF|^\xFF\xFE~", $bg, $tf)) {
                $fb = iconv('utf-16', 'utf-8', $fb);
            } elseif ($bg == "\xEF\xBB\xBF") {
                $fb = substr($fb, 3);
            }$K .= $fb."\n\n";
        } else {
            $K .= $fb;
        }
    }

return$K;
}function upload_error($m)
{
    $Kd = ($m == UPLOAD_ERR_INI_SIZE ? ini_get('upload_max_filesize') : 0);

    return $m ? lang(2).($Kd ? ' '.lang(3, $Kd) : '') : lang(4);
}function repeat_pattern($Qe, $yd)
{
    return
    str_repeat("$Qe{0,65535}", $yd / 65535)."$Qe{0,".($yd % 65535).'}';
}function is_utf8($X)
{
    return preg_match('~~u', $X) && ! preg_match('~[\0-\x8\xB\xC\xE-\x1F]~', $X);
}function shorten_utf8($fg, $yd = 80, $jg = '')
{
    if (! preg_match('(^('.repeat_pattern("[\t\r\n -\x{10FFFF}]", $yd).')($)?)u', $fg, $D)) {
        preg_match('(^('.repeat_pattern("[\t\r\n -~]", $yd).')($)?)', $fg, $D);
    }

return
    h($D[1]).$jg.(isset($D[2]) ? '' : '<i>...</i>');
}function format_number($X)
{
    return
    strtr(number_format($X, 0, '.', lang(5)), preg_split('~~u', lang(6), -1, PREG_SPLIT_NO_EMPTY));
}function friendly_url($X)
{
    return
    preg_replace('~[^a-z0-9_]~i', '-', $X);
}function hidden_fields($ff, $Uc = [])
{
    $K = false;
    while ([$_, $X] = each($ff)) {
        if (! in_array($_, $Uc)) {
            if (is_array($X)) {
                foreach ($X
                as$kd => $W) {
                    $ff[$_."[$kd]"] = $W;
                }
            } else {
                $K = true;
                echo'<input type="hidden" name="'.h($_).'" value="'.h($X).'">';
            }
        }
    }

return$K;
}function hidden_fields_get()
{
    echo(sid() ? '<input type="hidden" name="'.session_name().'" value="'.h(session_id()).'">' : ''),(SERVER !== null ? '<input type="hidden" name="'.DRIVER.'" value="'.h(SERVER).'">' : ''),'<input type="hidden" name="username" value="'.h($_GET['username']).'">';
}function table_status1($Q, $oc = false)
{
    $K = table_status($Q, $oc);

    return $K ? $K : ['Name' => $Q];
}function column_foreign_keys($Q)
{
    global$c;
    $K = [];
    foreach ($c->foreignKeys($Q)as$p) {
        foreach ($p['source']as$X) {
            $K[$X][] = $p;
        }
    }

return$K;
}function enum_input($U, $wa, $n, $Y, $Wb = null)
{
    global$c;
    preg_match_all("~'((?:[^']|'')*)'~", $n['length'], $Fd);
    $K = ($Wb !== null ? "<label><input type='$U'$wa value='$Wb'".((is_array($Y) ? in_array($Wb, $Y) : $Y === 0) ? ' checked' : '').'><i>'.lang(7).'</i></label>' : '');
    foreach ($Fd[1]as$u => $X) {
        $X = stripcslashes(str_replace("''", "'", $X));
        $Na = (is_int($Y) ? $Y == $u + 1 : (is_array($Y) ? in_array($u + 1, $Y) : $Y === $X));
        $K .= " <label><input type='$U'$wa value='".($u + 1)."'".($Na ? ' checked' : '').'>'.h($c->editVal($X, $n)).'</label>';
    }

return$K;
}function input($n, $Y, $s)
{
    global$Ug,$c,$z;
    $F = h(bracket_escape($n['field']));
    echo"<td class='function'>";
    if (is_array($Y) && ! $s) {
        $ta = [$Y];
        if (version_compare(PHP_VERSION, 5.4) >= 0) {
            $ta[] = JSON_PRETTY_PRINT;
        }$Y = call_user_func_array('json_encode', $ta);
        $s = 'json';
    }$vf = ($z == 'mssql' && $n['auto_increment']);
    if ($vf && ! $_POST['save']) {
        $s = null;
    }$Cc = (isset($_GET['select']) || $vf ? ['orig' => lang(8)] : []) + $c->editFunctions($n);
    $wa = " name='fields[$F]'";
    if ($n['type'] == 'enum') {
        echo
        h($Cc['']).'<td>'.$c->editInput($_GET['edit'], $n, $wa, $Y);
    } else {
        $Lc = (in_array($s, $Cc) || isset($Cc[$s]));
        echo(count($Cc) > 1 ? "<select name='function[$F]'>".optionlist($Cc, $s === null || $Lc ? $s : '').'</select>'.on_help("getTarget(event).value.replace(/^SQL\$/, '')", 1).script("qsl('select').onchange = functionChange;", '') : h(reset($Cc))).'<td>';
        $ad = $c->editInput($_GET['edit'], $n, $wa, $Y);
        if ($ad != '') {
            echo$ad;
        } elseif (preg_match('~bool~', $n['type'])) {
            echo"<input type='hidden'$wa value='0'>"."<input type='checkbox'".(preg_match('~^(1|t|true|y|yes|on)$~i', $Y) ? " checked='checked'" : '')."$wa value='1'>";
        } elseif ($n['type'] == 'set') {
            preg_match_all("~'((?:[^']|'')*)'~", $n['length'], $Fd);
            foreach ($Fd[1]as$u => $X) {
                $X = stripcslashes(str_replace("''", "'", $X));
                $Na = (is_int($Y) ? ($Y >> $u) & 1 : in_array($X, explode(',', $Y), true));
                echo" <label><input type='checkbox' name='fields[$F][$u]' value='".(1 << $u)."'".($Na ? ' checked' : '').'>'.h($c->editVal($X, $n)).'</label>';
            }
        } elseif (preg_match('~blob|bytea|raw|file~', $n['type']) && ini_bool('file_uploads')) {
            echo"<input type='file' name='fields-$F'>";
        } elseif (($zg = preg_match('~text|lob~', $n['type'])) || preg_match("~\n~", $Y)) {
            if ($zg && $z != 'sqlite') {
                $wa .= " cols='50' rows='12'";
            } else {
                $M = min(12, substr_count($Y, "\n") + 1);
                $wa .= " cols='30' rows='$M'".($M == 1 ? " style='height: 1.2em;'" : '');
            }echo"<textarea$wa>".h($Y).'</textarea>';
        } elseif ($s == 'json' || preg_match('~^jsonb?$~', $n['type'])) {
            echo"<textarea$wa cols='50' rows='12' class='jush-js'>".h($Y).'</textarea>';
        } else {
            $Md = (! preg_match('~int~', $n['type']) && preg_match('~^(\d+)(,(\d+))?$~', $n['length'], $D) ? ((preg_match('~binary~', $n['type']) ? 2 : 1) * $D[1] + ($D[3] ? 1 : 0) + ($D[2] && ! $n['unsigned'] ? 1 : 0)) : ($Ug[$n['type']] ? $Ug[$n['type']] + ($n['unsigned'] ? 0 : 1) : 0));
            if ($z == 'sql' && min_version(5.6) && preg_match('~time~', $n['type'])) {
                $Md += 7;
            }echo'<input'.((! $Lc || $s === '') && preg_match('~(?<!o)int(?!er)~', $n['type']) && ! preg_match('~\[\]~', $n['full_type']) ? " type='number'" : '')." value='".h($Y)."'".($Md ? " data-maxlength='$Md'" : '').(preg_match('~char|binary~', $n['type']) && $Md > 20 ? " size='40'" : '')."$wa>";
        }echo$c->editHint($_GET['edit'], $n, $Y);
        $uc = 0;
        foreach ($Cc
        as$_ => $X) {
            if ($_ === '' || ! $X) {
                break;
            }$uc++;
        }if ($uc) {
            echo
            script("mixin(qsl('td'), {onchange: partial(skipOriginal, $uc), oninput: function () { this.onchange(); }});");
        }
    }
}function process_input($n)
{
    global$c,$l;
    $w = bracket_escape($n['field']);
    $s = $_POST['function'][$w];
    $Y = $_POST['fields'][$w];
    if ($n['type'] == 'enum') {
        if ($Y == -1) {
            return
            false;
        }if ($Y == '') {
            return'NULL';
        }

return+$Y;
    }if ($n['auto_increment'] && $Y == '') {
        return
        null;
    }if ($s == 'orig') {
        return preg_match('~^CURRENT_TIMESTAMP~i', $n['on_update']) ? idf_escape($n['field']) : false;
    }if ($s == 'NULL') {
        return'NULL';
    }if ($n['type'] == 'set') {
        return
        array_sum((array) $Y);
    }if ($s == 'json') {
        $s = '';
        $Y = json_decode($Y, true);
        if (! is_array($Y)) {
            return
            false;
        }

return$Y;
    }if (preg_match('~blob|bytea|raw|file~', $n['type']) && ini_bool('file_uploads')) {
        $rc = get_file("fields-$w");
        if (! is_string($rc)) {
            return
            false;
        }

return$l->quoteBinary($rc);
    }

return$c->processInput($n, $Y, $s);
}function fields_from_edit()
{
    global$l;
    $K = [];
    foreach ((array) $_POST['field_keys']as$_ => $X) {
        if ($X != '') {
            $X = bracket_escape($X);
            $_POST['function'][$X] = $_POST['field_funs'][$_];
            $_POST['fields'][$X] = $_POST['field_vals'][$_];
        }
    }foreach ((array) $_POST['fields']as$_ => $X) {
        $F = bracket_escape($_, 1);
        $K[$F] = ['field' => $F, 'privileges' => ['insert' => 1, 'update' => 1], 'null' => 1, 'auto_increment' => ($_ == $l->primary)];
    }

return$K;
}function search_tables()
{
    global$c,$g;
    $_GET['where'][0]['val'] = $_POST['query'];
    $Lf = "<ul>\n";
    foreach (table_status('', true)as$Q => $R) {
        $F = $c->tableName($R);
        if (isset($R['Engine']) && $F != '' && (! $_POST['tables'] || in_array($Q, $_POST['tables']))) {
            $J = $g->query('SELECT'.limit('1 FROM '.table($Q), ' WHERE '.implode(' AND ', $c->selectSearchProcess(fields($Q), [])), 1));
            if (! $J || $J->fetch_row()) {
                $bf = "<a href='".h(ME.'select='.urlencode($Q).'&where[0][op]='.urlencode($_GET['where'][0]['op']).'&where[0][val]='.urlencode($_GET['where'][0]['val']))."'>$F</a>";
                echo"$Lf<li>".($J ? $bf : "<p class='error'>$bf: ".error())."\n";
                $Lf = '';
            }
        }
    }echo($Lf ? "<p class='message'>".lang(9) : '</ul>')."\n";
}function dump_headers($Tc, $Td = false)
{
    global$c;
    $K = $c->dumpHeaders($Tc, $Td);
    $De = $_POST['output'];
    if ($De != 'text') {
        header('Content-Disposition: attachment; filename='.$c->dumpFilename($Tc).".$K".($De != 'file' && ! preg_match('~[^0-9a-z]~', $De) ? ".$De" : ''));
    }session_write_close();
    ob_flush();
    flush();

    return$K;
}function dump_csv($L)
{
    foreach ($L
    as$_ => $X) {
        if (preg_match("~[\"\n,;\t]~", $X) || $X === '') {
            $L[$_] = '"'.str_replace('"', '""', $X).'"';
        }
    }echo
    implode(($_POST['format'] == 'csv' ? ',' : ($_POST['format'] == 'tsv' ? "\t" : ';')), $L)."\r\n";
}function apply_sql_function($s, $d)
{
    return $s ? ($s == 'unixepoch' ? "DATETIME($d, '$s')" : ($s == 'count distinct' ? 'COUNT(DISTINCT ' : strtoupper("$s("))."$d)") : $d;
}function get_temp_dir()
{
    $K = ini_get('upload_tmp_dir');
    if (! $K) {
        if (function_exists('sys_get_temp_dir')) {
            $K = sys_get_temp_dir();
        } else {
            $sc = @tempnam('', '');
            if (! $sc) {
                return
                false;
            }$K = dirname($sc);
            unlink($sc);
        }
    }

return$K;
}function file_open_lock($sc)
{
    $r = @fopen($sc, 'r+');
    if (! $r) {
        $r = @fopen($sc, 'w');
        if (! $r) {
            return;
        }chmod($sc, 0660);
    }flock($r, LOCK_EX);

    return$r;
}function file_write_unlock($r, $rb)
{
    rewind($r);
    fwrite($r, $rb);
    ftruncate($r, strlen($rb));
    flock($r, LOCK_UN);
    fclose($r);
}function password_file($i)
{
    $sc = get_temp_dir().'/adminer.key';
    $K = @file_get_contents($sc);
    if ($K || ! $i) {
        return$K;
    }$r = @fopen($sc, 'w');
    if ($r) {
        chmod($sc, 0660);
        $K = rand_string();
        fwrite($r, $K);
        fclose($r);
    }

return$K;
}function rand_string()
{
    return
    md5(uniqid(mt_rand(), true));
}function select_value($X, $B, $n, $_g)
{
    global$c;
    if (is_array($X)) {
        $K = '';
        foreach ($X
        as$kd => $W) {
            $K .= '<tr>'.($X != array_values($X) ? '<th>'.h($kd) : '').'<td>'.select_value($W, $B, $n, $_g);
        }

return"<table cellspacing='0'>$K</table>";
    }if (! $B) {
        $B = $c->selectLink($X, $n);
    }if ($B === null) {
        if (is_mail($X)) {
            $B = "mailto:$X";
        }if (is_url($X)) {
            $B = $X;
        }
    }$K = $c->editVal($X, $n);
    if ($K !== null) {
        if (! is_utf8($K)) {
            $K = "\0";
        } elseif ($_g != '' && is_shortable($n)) {
            $K = shorten_utf8($K, max(0, +$_g));
        } else {
            $K = h($K);
        }
    }

return$c->selectVal($K, $B, $n, $X);
}function is_mail($Tb)
{
    $va = '[-a-z0-9!#$%&\'*+/=?^_`{|}~]';
    $Hb = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';
    $Qe = "$va+(\\.$va+)*@($Hb?\\.)+$Hb";

    return
    is_string($Tb) && preg_match("(^$Qe(,\\s*$Qe)*\$)i", $Tb);
}function is_url($fg)
{
    $Hb = '[a-z0-9]([-a-z0-9]{0,61}[a-z0-9])';

    return
    preg_match("~^(https?)://($Hb?\\.)+$Hb(:\\d+)?(/.*)?(\\?.*)?(#.*)?\$~i", $fg);
}function is_shortable($n)
{
    return
    preg_match('~char|text|json|lob|geometry|point|linestring|polygon|string|bytea~', $n['type']);
}function count_rows($Q, $Z, $gd, $t)
{
    global$z;
    $I = ' FROM '.table($Q).($Z ? ' WHERE '.implode(' AND ', $Z) : '');

    return $gd && ($z == 'sql' || count($t) == 1) ? 'SELECT COUNT(DISTINCT '.implode(', ', $t).")$I" : 'SELECT COUNT(*)'.($gd ? " FROM (SELECT 1$I GROUP BY ".implode(', ', $t).') x' : $I);
}function slow_query($I)
{
    global$c,$T,$l;
    $k = $c->database();
    $Bg = $c->queryTimeout();
    $Tf = $l->slowQuery($I, $Bg);
    if (! $Tf && support('kill') && is_object($h = connect()) && ($k == '' || $h->select_db($k))) {
        $md = $h->result(connection_id());
        echo'<script',nonce(),'>
var timeout = setTimeout(function () {
	ajax(\'',js_escape(ME),'script=kill\', function () {
	}, \'kill=',$md,'&token=',$T,'\');
}, ',1000 * $Bg,');
</script>
';
    } else {
        $h = null;
    }ob_flush();
    flush();
    $K = @get_key_vals(($Tf ? $Tf : $I), $h, false);
    if ($h) {
        echo
        script('clearTimeout(timeout);');
        ob_flush();
        flush();
    }

return$K;
}function get_token()
{
    $lf = rand(1, 1e6);

    return($lf ^ $_SESSION['token']).":$lf";
}function verify_token()
{
    [$T, $lf] = explode(':', $_POST['token']);

    return($lf ^ $_SESSION['token']) == $T;
}function lzw_decompress($Da)
{
    $Db = 256;
    $Ea = 8;
    $Ta = [];
    $wf = 0;
    $xf = 0;
    for ($u = 0; $u < strlen($Da); $u++) {
        $wf = ($wf << 8) + ord($Da[$u]);
        $xf += 8;
        if ($xf >= $Ea) {
            $xf -= $Ea;
            $Ta[] = $wf >> $xf;
            $wf &= (1 << $xf) - 1;
            $Db++;
            if ($Db >> $Ea) {
                $Ea++;
            }
        }
    }$Cb = range("\0", "\xFF");
    $K = '';
    foreach ($Ta
    as$u => $Sa) {
        $Sb = $Cb[$Sa];
        if (! isset($Sb)) {
            $Sb = $wh.$wh[0];
        }$K .= $Sb;
        if ($u) {
            $Cb[] = $wh.$Sb[0];
        }$wh = $Sb;
    }

return$K;
}function on_help($Za, $Rf = 0)
{
    return
    script("mixin(qsl('select, input'), {onmouseover: function (event) { helpMouseover.call(this, event, $Za, $Rf) }, onmouseout: helpMouseout});", '');
}function edit_form($b, $o, $L, $ch)
{
    global$c,$z,$T,$m;
    $og = $c->tableName(table_status1($b, true));
    page_header(($ch ? lang(10) : lang(11)), $m, ['select' => [$b, $og]], $og);
    if ($L === false) {
        echo"<p class='error'>".lang(12)."\n";
    }echo'<form action="" method="post" enctype="multipart/form-data" id="form">
';
    if (! $o) {
        echo"<p class='error'>".lang(13)."\n";
    } else {
        echo"<table cellspacing='0' class='layout'>".script("qsl('table').onkeydown = editingKeydown;");
        foreach ($o
        as$F => $n) {
            echo'<tr><th>'.$c->fieldName($n);
            $yb = $_GET['set'][bracket_escape($F)];
            if ($yb === null) {
                $yb = $n['default'];
                if ($n['type'] == 'bit' && preg_match("~^b'([01]*)'\$~", $yb, $tf)) {
                    $yb = $tf[1];
                }
            }$Y = ($L !== null ? ($L[$F] != '' && $z == 'sql' && preg_match('~enum|set~', $n['type']) ? (is_array($L[$F]) ? array_sum($L[$F]) : +$L[$F]) : $L[$F]) : (! $ch && $n['auto_increment'] ? '' : (isset($_GET['select']) ? false : $yb)));
            if (! $_POST['save'] && is_string($Y)) {
                $Y = $c->editVal($Y, $n);
            }$s = ($_POST['save'] ? (string) $_POST['function'][$F] : ($ch && preg_match('~^CURRENT_TIMESTAMP~i', $n['on_update']) ? 'now' : ($Y === false ? null : ($Y !== null ? '' : 'NULL'))));
            if (preg_match('~time~', $n['type']) && preg_match('~^CURRENT_TIMESTAMP~i', $Y)) {
                $Y = '';
                $s = 'now';
            }input($n, $Y, $s);
            echo"\n";
        }if (! support('table')) {
            echo'<tr>'."<th><input name='field_keys[]'>".script("qsl('input').oninput = fieldChange;")."<td class='function'>".html_select('field_funs[]', $c->editFunctions(['null' => isset($_GET['select'])]))."<td><input name='field_vals[]'>"."\n";
        }echo"</table>\n";
    }echo"<p>\n";
    if ($o) {
        echo"<input type='submit' value='".lang(14)."'>\n";
        if (! isset($_GET['select'])) {
            echo"<input type='submit' name='insert' value='".($ch ? lang(15) : lang(16))."' title='Ctrl+Shift+Enter'>\n",($ch ? script("qsl('input').onclick = function () { return !ajaxForm(this.form, '".lang(17)."...', this); };") : '');
        }
    }echo $ch ? "<input type='submit' name='delete' value='".lang(18)."'>".confirm()."\n" : ($_POST || ! $o ? '' : script("focus(qsa('td', qs('#form'))[1].firstChild);"));
    if (isset($_GET['select'])) {
        hidden_fields(['check' => (array) $_POST['check'], 'clone' => $_POST['clone'], 'all' => $_POST['all']]);
    }echo'<input type="hidden" name="referer" value="',h(isset($_POST['referer']) ? $_POST['referer'] : $_SERVER['HTTP_REFERER']),'">
<input type="hidden" name="save" value="1">
<input type="hidden" name="token" value="',$T,'">
</form>
';
}if (isset($_GET['file'])) {
    if ($_SERVER['HTTP_IF_MODIFIED_SINCE']) {
        header('HTTP/1.1 304 Not Modified');
        exit;
    }header('Expires: '.gmdate('D, d M Y H:i:s', time() + 365 * 24 * 60 * 60).' GMT');
    header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
    header('Cache-Control: immutable');
    if ($_GET['file'] == 'favicon.ico') {
        header('Content-Type: image/x-icon');
        echo
        lzw_decompress("\0\0\0` \0�\0\n @\0�C��\"\0`E�Q����?�tvM'�Jd�d\\�b0\0�\"��fӈ��s5����A�XPaJ�0���8�#R�T��z`�#.��c�X��Ȁ?�-\0�Im?�.�M��\0ȯ(̉��/(%�\0");
    } elseif ($_GET['file'] == 'default.css') {
        header('Content-Type: text/css; charset=utf-8');
        echo
        lzw_decompress("\n1̇�ٌ�l7��B1�4vb0��fs���n2B�ѱ٘�n:�#(�b.\rDc)��a7E����l�ñ��i1̎s���-4��f�	��i7������Fé�vt2���!�r0���t~�U�'3M��W�B�'c�P�:6T\rc�A�zr_�WK�\r-�VNFS%~�c���&�\\^�r����u�ŎÞ�ً4'7k����Q��h�'g\rFB\ryT7SS�P�1=ǤcI��:�d��m>�S8L�J��t.M���	ϋ`'C����889�� �Q����2�#8А����6m����j��h�<�����9/��:�J�)ʂ�\0d>!\0Z��v�n��o(���k�7��s��>��!�R\"*nS�\0@P\"��(�#[���@g�o���zn�9k�8�n���1�I*��=�n������0�c(�;�à��!���*c��>Ύ�E7D�LJ��1����`�8(��3M��\"�39�?E�e=Ҭ�~������Ӹ7;�C����E\rd!)�a*�5ajo\0�#`�38�\0��]�e���2�	mk��e]���AZs�StZ�Z!)BR�G+�#Jv2(���c�4<�#sB�0���6YL\r�=���[�73��<�:��bx��J=	m_ ���f�l��t��I��H�3�x*���6`t6��%�U�L�eق�<�\0�AQ<P<:�#u/�:T\\>��-�xJ�͍QH\nj�L+j�z��7���`����\nk��'�N�vX>�C-T˩�����4*L�%Cj>7ߨ�ި���`���;y���q�r�3#��} :#n�\r�^�=C�Aܸ�Ǝ�s&8��K&��*0��t�S���=�[��:�\\]�E݌�/O�>^]�ø�<����gZ�V��q����� ��x\\������޺��\"J�\\î��##���D��x6��5x�������\rH�l ����b��r�7��6���j|����ۖ*�FAquvyO��WeM����D.F��0�ECb�Q�<9b�hxNt��b��@pl�.'�֪�\$t�D�����������I<�\"�c+�L(1��ZEC��O	��E���.��\$&�\n#�IM&&\n�!�m�̡�t����B���洳�T����K-T����H��ŭ�� ��x�r�J��V��*�F�������߰cwq�L\$@n�t<%�T�r1߲܃��g�i�P)�L= \\@�T���,#Y�9_����N`Ѻ\"FR)�Y�;g|��i�,9X��\$�'�J=Bx��Z�@�����E�\"5F]�j�btFAk��,���'̹?Q�mE����8'���at�A����<\r��@b����P*\r�*i�u7�/�{v�Q�Z�8)���7�DI�=��y&��ea�s*hɕj�A�(꣢�\\���ni��V)��^�	|~լ��#!]�v8yRT&����2���62P�C��l&���xd!�|��9�`�_OY�=��G�[J	-eL�CvT� )�@�j-����pSk�.��=���ZE��\$\0�نkn�շ�\$���G+�I�P��.ځ� ;��qO��G%��Rj�Y[�XPf^��|��T!�;N��І�\rY�pq1�*��y~-CI|7�7�r,���7�(�̾B���;�+�����A�p����b��\r���7�\n�&b�I'�w�ZiRXl�.4o���m*�� @.��Y���ip�#���V��B��� Ha�.@G��� 0/l��:�s�^��=�H��A�[�x�`�g~L�8�H���tG�4>�<�T/�xO�'/��v`��X��/e�H/�Q��m#f��\n)���D�b`�0�\"�p��hnT��*¸&O.��W��\"*�!��ѓ��õN/՘�da�w����K�c��j�O3725�1�?z��7�w���Z�4)Ǚ�9d��]��M	��Me�m\n�-O�P	��)���)�d�\0l�vIk2jj���Z��-6�Ꟗd�l�`b\re׉u/�h�a6Z�� ¯3�c�+,��h8r���\"�dJˆ'���a}���\$�)����&��L�0���Gc/K�}6�1�\\~O�ӓ�[\\�T]\"��8�L���Pw�J�e�@�� �\0hC�W\$M/��n�!�v�L�`_zW��w������'B��W< ��=���C�Z��\r���=,X4�3�{GƝ���u+����c�N�\r� S`w�}&��{��7\\�̖ɞ֤�3�|�ps��=���\"n	{�5���L�<��X��y�<U�;����`}�CC,���-��P��8\r,���p���Y{���z*+:3j���lЯ>[� ��\n�OR΍N��-\0�`ˀ�#x�b�\nro`;Od���\0�~�)&lO����0�;��M�����#(&̎&�0��κ������N�\0�CL���P>�	����򊍎���\nh��h�ϭ���h6ł��B	��r���\r�6�n���p�\r�� F��p-��\r@�\r\0��p�qp��q �����E�\$q}���������4@�Q��Ɋ|\0``f�k���``��Nv���u��\r�)q>��y�7q\"�@��ј����`���ь_I0�L��񒚀`)����t��)�Mq����)���b�ޱo%y1s��Q��A� q�*����1wg>C��B��M�4~��d��ܒ��=�B��- ��\$rRi)!�%�RO\$�]\$��&Q�\r����\"�e`���\rR>�%��'c\$��&�R�R�&r�*Rs\$�w�o)r{#`�=\"Ď������I��\r��#��/q;2Q-R���*��.Rm\$R�%\$���Zp�/�U&��%1�0�v�GE����11�#,�&\r`�1-337&q)��3��.HA1�!2�:7&2f`��,��A�1qsi\"��y7Jƍ�kRW7�\"�8s{7����w 4Ss9Ӡ�s� ә6�\r�);�:��;ӣ!3:Q-\0�Yӳ0��=\"#=��r�0@G`�?2�e�=��-|&Q#<��@1�0\"�0���ц�p�s֘�용��@*�`�2��/.� � �C��V(ӱ@Q�ƪ�Q\rS�E�E:���	Fq\"5��F�e�\"�t.�m����6QO<��T/=�9��*���LSr?I2�J�O �[t�Kt�KS�K��`eG�08B�8�0,&������	���k!N@���֮�~*�\"��:G��14�6�D.\"���I�!�L��8b�A3M�'M�?N�\$�,��0O2��/4�B�J�b�");
    } elseif ($_GET['file'] == 'functions.js') {
        header('Content-Type: text/javascript; charset=utf-8');
        echo
        lzw_decompress("f:��gCI��\n8��3)��7���81��x:\nOg#)��r7\n\"��`�|2�gSi�H)N�S��\r��\"0��@�)�`(\$s6O!��V/=��' T4�=��iS��6IO��er�x�9�*ź��n3�\rщv�C��`���2G%�Y�����1��f���Ȃl��1�\ny�*pC\r\$�n�T��3=\\�r9O\"�	��l<�\r�\\��I,�s\nA��eh+M�!�q0��f�`(�N{c��+w���Y��p٧3�3��+I��j�����k��n�q���zi#^r�����3���[��o;��(��6�#�Ґ��\":cz>ߣC2v�CX�<�P��c*5\n���/�P97�|F��c0�����!���!���!��\nZ%�ć#CH�!��r8�\$���,�Rܔ2���^0��@�2��(�88P/��݄�\\�\$La\\�;c�H��HX���\nʃt���8A<�sZ�*�;I��3��@�2<���!A8G<�j�-K�({*\r��a1���N4Tc\"\\�!=1^���M9O�:�;j��\r�X��L#H�7�#Tݪ/-���p�;�B \n�2!���t]apΎ��\0R�C�v�M�I,\r���\0Hv��?kT�4����uٱ�;&���+&���\r�X���bu4ݡi88�2B�/⃖4���N8A�A)52������2��s�8�5���p�WC@�:�t�㾴�e��h\"#8_��cp^��I]OH��:zd�3g�(���Ök��\\6����2�ږ��i��7���]\r�xO�n�p�<��p�Q�U�n��|@���#G3��8bA��6�2�67%#�\\8\r��2�c\r�ݟk��.(�	��-�J;��� ��L�� ���W��㧓ѥɤ����n��ҧ���M��9ZНs]�z����y^[��4-�U\0ta��62^��.`���.C�j�[ᄠ% Q\0`d�M8�����\$O0`4���\n\0a\rA�<�@����\r!�:�BA�9�?h>�Ǻ��~̌�6Ȉh�=�-�A7X��և\\�\r��Q<蚧q�'!XΓ2�T �!�D\r��,K�\"�%�H�qR\r�̠��C =�������<c�\n#<�5�M� �E��y�������o\"�cJKL2�&��eR��W�AΐTw�ё;�J���\\`)5��ޜB�qhT3��R	�'\r+\":�����.��ZM'|�et:3%L��#f!�h�׀e����+ļ�N�	��_�CX��G�1��i-ãz�\$�oK@O@T�=&�0�\$	�DA�����D�SJ�x9ׁFȈml��p�Gխ�T�6Rf�@�a�\rs�R�Fgih]��f�.�7+�<nhh�* �SH	P]� :Ғ��a\"�����2�&R�)�B�Pʙ�H/��f {r|�0^�hCA�0�@�M���2�B�@��z�U���O���Cpp��\\�L�%�𛄒y��odå���p3���7E����A\\���K��Xn��i.�Z�� ���s��G�m^�tI�Y�J��ٱ�G1��R��D��c���6�tMih��9��9g��q�RL��Mj-TQ�6i�G_!�.�h�v��cN�����^��0w@n|���V�ܫ�AЭ��3�[��]�	s7�G�P@ :�1т�b� ��ݟ���w�(i��:��z\\��;���A�PU T^�]9�`UX+U��Q+��b���*ϔs������[�ۉxk�F*�ݧ_w.��6~�b��mK�sI�MK�}�ҥ���eHɲ�d�*md�l�Q��eH�2�ԍL���a҂�=��s�P�aM\"ap��:<��GB�\r2Ytx&L}}��A�ԱN�GЬza��D4�t�4Q�vS�ùS\r�;U��������~�pB��{���,���O��t;�J��ZC,&Y�:Y\"�#�����t:\n�h8r����n���h>��>Z��`&�a�pY+�x�U��A�<?�PxWա�W�	i��.�\r`�\$,���Ҿ��V�]�Zr���H��5�f\\�-KƩ�v��Z��A��(�{3�o��l.��J��.�\\t2�;���2\0��>c+�|��*;-0�n��[�t@�ڕ��=cQ\n.z���wC&��@���F�����'cBS7_*rsѨ�?j�3@����!�.@7�s�]Ӫ�L�΁G��@��_�q���&u���t�\nՎ�L�E�T��}gG����w�o�(*�����A��-�����3�mk�����פ��t��S���(�d��A�~�x\n����k�ϣ:D��+�� g��h14 ��\n.��d꫖������AlY��j���jJ���PN+b� D�j������D��P���LQ`Of��@�}�(���6�^nB�4�`�e��\n��	�trp!�lV�'�}b�*�r%|\nr\r#���@w��-�T.Vv�8��\nmF�/�p��`�Y0�����P\r8�Y\r��ݤ�	�Q���%E�/@]\0��{@�Q���\0bR M\r��'|��%0SDr����f/����b:ܭ�����%߀�3H�x\0�l\0���	��W��%�\n�8\r\0}�D���1d#�x��.�jEoHrǢlb���%t�4�p���%�4���k�z2\r�`�W@�%\rJ�1��X���1�D6!��*��{4<E��k.m�4����\r\n�^i��� �!n��!2\$������(�f������k>����N��5\$���2T�,�LĂ� � Z@��*�`^P�P%5%�t�H�W��on���E#f���<�2@K:�o����Ϧ�-��2\\Wi+f�&��g&�n�L�'e�|����nK�2�rڶ�p�*.�n��������*�+�t�Bg* ��Q�1+)1h���^�`Q#�؎�n*h���v�B��\0\\F\n�W�r f\$�=4\$G4ed�b�:J^!�0��_���%2��6�.F���Һ�EQ�����dts\"�����B(�`�\r���c�R����V����X��:R�*2E*s�\$��+�:bXl��tb��-�S>��-�d�=��\$S�\$�2�ʁ7�j�\"[́\"��]�[6��SE_>�q.\$@z`�;�4�3ʼ�CS�*�[���{DO�ުCJj峚P�:'���ȕ QEӖ�`%r��7��G+hW4E*��#TuFj�\n�e�D�^�s��r.��Rk��z@��@���D�`C�V!C���\0��ۊ)3<��Q4@�3SP��ZB�5F�L�~G�5���:���5\$X���}ƞf���I���3S8�\0XԂtd�<\nbtN� Q�;\r��H��P�\0��&\n���\$V�\r:�\0]V5gV���D`�N1:�SS4Q�4�N��5u�5�`x	�<5_FH���}7��)�SV��Ğ#�|��< ռ�˰���\\��-�z2�\0�#�WJU6kv���#��\r�췐����U��i��_��^�UVJ|Y.��ɛ\0u,�������_UQD#�ZJu�Xt��_�&JO,Du`N\r5��`�}ZQM^m�P�G[��a�b�N䞮��re�\n��%�4��o_(�^�q@Y6t;I\nGSM�3��^SAYH�hB��5�fN?NjWU�J����֯Yֳke\"\\B1�؅0� �en���*<�O`S�L�\n��.g�5Zj�\0R\$�h��n�[�\\���r���,�4����cP�p�q@R�rw>�wCK��t��}5_uvh��`/����\$�J)�R�2Du73�d\r�;��w���H�I_\"4�r�����Ͽ+�&0>�_-eqeD��V��n��f�h��\"Z����Z�W�6\\L���ke&�~������i\$ϰ�Mr�i*�����\0�.Q,��8\r���\$׭K��Y� �io�e%t�2�\0�J��~��/I/.�e��n�~x!�8��|f�h�ۄ-H���&�/��o�����.K� �^j��t��>('L\r��HsK1�e�\0��\$&3�\0�in3�� o�6�ж�����9�j������1�(b.�vC�ݎ8���:wi��\"�^w�Q����z�o~�/��Ғ���`Y2��D�V����/k�8��7Z�H����]2k2r���ϯh�=�T��]O&�\0�M\0�[8��Ȯ���8&L�Vm�v���j�ך�F��\\��	���&s��Q� \\\"�b��	��\rBs�Iw�	�Y��N �7�C/*����\n\n�H�[����*A���TE�VP.UZ(tz/}\n2��y�S���,#�3�i�~W@yCC\nKT��1\"@|�zC\$��_CZjzHB�LV�,K����O���P�@X���������;D�WZ�W�a���\0ފ�CG8�R �	�\n������P�A��&������,�pfV|@N�b�\$�[�I����������Z�@Zd\\\"�|��+�ۮ��tz�o\$�\0[����y�E���ə�bhU1��,�r\$�o8D���F��V&ځ5�h}��N�ͳ&�絕ef�ǙY��:�^z�VPu	W�Z\"r�:�h�w��h#1��O���K�hq`妄����v|�˧:wD�j�(W�������碌�?�;|Z��%�%ڡ�r@[����B�&������#���ُ��:)��Y6����&��	@�	���I��!����� ���2M���O;���W��)��C��FZ�p!��a��*F�b�I��;���#Ĥ9����S�/S�A�`z�L*�8�+��N���-�M���-kd���Li�J�·�Jn��b���>,�V�SP�8��>�w��\"E.��Rz`��u_����E\\��ɫ�3P��ӥs]���goVS���\n��	*�\r��7)�ʄ�m�PW�UՀ��ǰ���f��ܓi�ƅkЌ\r�('W`�Bd�/h*�A�l�M��_\n�������O��T�5�&A�2é`��\\R�E\"_�_��.7�M�6d;�<?��)(;���}K�[�����Z?��yI ��1p�bu\0�������{��\ri�s�QQ�Y�2��\rה0\0X�\"@q��uMb��uJ�6�NG���^��wF/t���#P�p��!7������囜!û�^V��M�!(⩀8֝�=�\0�@���80N�Sཾ�Q�_T��ĥ�qSz\"�&h�\0R.\0hZ�fx���F9�Q(�b�=�D&xs=X�bu�@o�w�d�5���P�1P>k��H�D6/ڿ�q랼��3�7TЬK�~54�	�t#�M�\rc�tx�g��T��X\r�2\$�<0�y}*��Cbi�^��L�7	�b�o����x71� b�XS`O���0)���\"�/��=Ȭ �l��Q�p�-�!��{��������a��ȕ9bAg�2,1�zf�k��j�h/o(�.4�\r���Tz&nw���7 X!����@,�<�	��`\"@:��7�CX\\	 \$1H\n=ě�O5��&�v�*(	�tH��#�\n�_X/8�k~+t���O&<v��_Yh��.��Me�Hxp�I�a��0�M\nh�`r'B���h�n8q��!	�֠eu��]^TW����d9{��H,㗂8��L�a�,!\0;��B#�#��`�)�����	ńa�Ee�ڑ�/M�P�	�l���a`	�sⲅ<(D\n���9{06�ƈ;A8��5!	���Z[T� hV���ܻ��U@�n`�V�p��h(Rb4�V�Ɖ����Rp��Ҕ\$����D3O����\$�����aQ��0xb�H`����LÔ8i��oC�����#6�x�)XH�!`�������B�%w���o\nx̀h��H���r� ʼc��mJH�LU����e1l`�(�\$\"�h�J�rv���TP�����1uHA\0��H2@(ʡU�\"�Q�@qg]l\"�%���*�\0W�j[� ���e�4���P��N����5\$H\r��IP��'@:\0�\"#t^�D��0���>�(��h� '��F,sZJ��An�#�h��X��.q��Yob�����2��?j��B�I��ߣ��������0�a�(�`Z�C����r��HSQ��\\��W	��XZ��|�E@���TԝŖq�DD:_y��İ��B�~�xP�--e��_�u�|2(�G,��-rR�Kx���d���hH�A|���w�|P�!ǉґ䎬}�T���<��,1��v�g*���z�^������_pi {��G����	LaJJC�T%N1��I:V@Z��%ɂ*�|@NNxL��L�zd \$8b#�!2=cۍ�QD��@�\0�J�dzp��\$A�|ya4)��s%!�BI�Q]d�G�6&E\$��H\$Rj\0���ܗGi\$إ�9ņY��@ʴ0�6Ħ��X�ܞ1&L��&2�	E^��a8�j�#�DEu�\$uT�*R�#&��P2�e��K��'�E%┡�YW�J��	����O`�ʕ��^l+��`�	R�1u�&F���Z[)]J�Z�E��`��FN.\r�=�� ��\0�O~���M,��FAT�b�h�z0��`-bl�\n�ǅZ�'�*I�n�\$�[�,8D��n��`����I0uʀ�hf��������AEy<!��xdA���1�a�U��t\$���'p�\"����j��P6XR)E�TR�\0S�@-�T���.S�wU\\��\\�(\r������k���g`j}\$�`aJsL�Κ�R3�T�X�}��8%��H�@�Z\0^U٭ |6A���R�T/����E�@¨�0\"� @ZA1D���.\\�f�5y]Dթb���/�8��p�hv���q�xK����Ni����\0�0\0006��\r`b��يbЩ��k☛ڷgV)ǁ�r3���X�^��\r�O3)�|��9�\r�73�	P����l��\n<��^�-Ɇ��'@m����%37SO:bAAx`�\"���?¾��%�VQ0\$�)�&��2b(�E��s��������6_�}Z�)b����<��\$.��y��Ƥc�Jb���Ɔ4dԠiQ/��\$=�U(�>��+�1���M����Ƭ0�'ڌ�z�R0��o�s�p�b�20�G!�0���֐�	�@rl���@1*�O\"�T�.�P��&}\$�x��>��Ϲ\$2�>s��X��7��D��f��O\n��%���\rDđ8����T�\\���c���T��W0���N����E��&s�{-r����1)�z��^U�׾P���K�?��\$����Y���q	7'\"Q�b�W�\"��L�!W9Y��Є����ħԸY�,�b��=)�x���%i.ӄ/�c^3�)��LJJ���\$��J\$�R��K��e*�A�-�a��o)��)3�����\r�,��HR�9���+I3+y�W�lxyA�`'�)��Y/Uz�Ύ7B(i���bw�:����㋁I��)���T*��<�x�I���*�wHmCO�Q�w(��Dw�	\nLq��L�N���@�1���!!-ڿRR1���\$!0D��󦮱�!�v�H��Q?)��Д �t܆�P��u=�s<����%��R+Z��\n�}r |EO�uU�����z?8T�B��L��ŨY�`���\$�zдj,���d�DtR{�4@�����	wY���g�q�IYҩ���!\n *&!�8|\$pm��Z!7I����N��+OQW����U@�ÁT:#���	�eRZ?XA�Tey�[N���3���X :S��~!�S�V�D	�?�.]\$:��䌪�F�iXgC�*CzMm��2��9��̯\rU�MU��W(7u��:�r,�h�l�Wwۅ�N9�ޭ�k��	�C7Ɖ�� 'rS@�T2��z=b��2�hP�1��A�T��� 0���y`� \0ش������uWt�QP\n������c�����hr6�F`\"��5���I36���-\0`%������b�U7�V5I\0�sK�=��I��5�8P�ACT(��g���&#�)���S���%��;���O��Y`q��\"<Gl�s�	g(C-`��?�j�#Ӳ�u�)hc���d6�L�����H���kP���mL����`��T�T8�P��vY\\<�OhsX�|�\\���t��!�B�GB:��!7����-czA�(S`���`+t&���_\$�'\$Pr���m�X(���LD���\\����������A5D�u*��X��X��������\0NCJ����炋*�Q�h �\nƜT�#�F7�:�	�=(ߘL����TH8t�R�	���_Ű%&CB�/����.즤�*1��-�Ḧ́��ھZ8ƀ��;%�K�^������ejssy�:�=W�WǦ.�i\n��\nHh��cK�W2���L&�^@�)\nP��>��RHp��9��R���T�T�=�=� ��S��|�\$�.������s6P����ֺ�P��h��P�ʰ5%`�*�.!�Ծ�W���24XBP�؄)6#��|��a����\0u�gB��Al~G����9Da�\\�\\\0i���U[ڄXEw*NzQ�|���J��E�\0�hKC9V7Ň��\ns6y�_\\�E �%�D�Z��Q�u�ǶI+��B��HD����:�Ɉ�tey�j��#���G�e'�P�7XZ�S��)cj�x�~~5!U�i@d��\\O�\rIp\0`�����;���g�]W4\n/�@��ϦΉ���L ����!�G��hB�B�`.�s��M@m�2�c[!����X��kO��`���?C��	l�����p1���\0��`;M[X�{V�\r��	D�_x@�M`J��4�}�P���-��H@_��������	�}�F��R��_:�T�5�\n����H��p/��[T-�?yh�n�����Lw���+~���f؅��T����[�Ԁg���x�z[:���n)	iׁl�i�5���wr#�%(9�`� ���\"�b���4���y#� PH#ְ8�'��b�Ҹ�G�\n_Ǝ{42ur\$�\$�dE�D����Q��4ňO8�(�#��1�87c�\0�9�&�`3����N?�����dR�q|����t�� X�]Jr�rE�5ۭz'��lm9�W��\n�p�ܨ�w鸝��qp\\hӕ*Qào�\"�_)^�e	\$��ظ'�\\�'yO���lB���l&�i�!s�]�Lk	�l�4x**	\n�T�������kjX�BX� �典Xa�>��ܴf�yb�Ji���a�\r�\r��H-�ĺ�N�uu\\�����m!@sæ��t�}�|�us��5�4�d���I�sU�cI���q�s9\\��	8�M(T�Jo�\n���tXT�~�Tne�]�jO�X��s�f� #� 3Y.�\0	��Om鋠7����?9(O��0�͕�ɽ�4���P���!�e%�+��qN�\r9u��Ø��~7\\�ks�Pl��4��3h���������zNa��ܥg�Á��}s��5k9�/��z�1dP>�}�(�qd�֝n�Kw\$���CY:��?T�	��)�,��w*b�ʮ\\ہ�E�'#\"����DX�����Ζ�o`ȱd{��p�|�~\\sxMM\0��u����h�ܻ�\rn@[e�\nZR��^��o���&�E�0Seݖ��hz���찌����r�s{t��,O_7L��T��K�����)�\n���]	ؤ�u�0\n�Bj4��l}ܿww�����X)	\r�NJ�\r��d��B�gV�Q ��:J!�����>�ԧ��I	n�:��DN�@ a\\��9���\r�Jt�u�V�*����;���)ـ'[B��p}�[���͈} ��T湪bdv���]�~Ѳ|��=WP3��@����ތ�`_\0N�T\r��&��T��-���O�b�!{�� ��~^4QW���i��ɲ�U�A죲�`S+��x+ק��2�IB0*�.�Q�wg>/3,=6?��,i�#ПP��\0]>~sfgh�9B��\\��������hil�H%��:c�q#����4�Ґ��y�_F.�tmr(�z��WE\r�.�\rĲ� ��'5��_k=w���X���A�&��\n�O����i�=��������h��6ⶆP� n@/F�>��w�L�� ۘ\"n��š�vn�\r؃�|*�/+�AJ'7�\\�p�Q���o\0�x��3\r��p��������~l6`��z��[�C�\$7bX���9���`ܔ�{+�mǓdg`dŧۋ���7�4��yĬs�n�ݨW'c��\rܡ�WYl��Z�>2�ge�f�bN�sG�LXT��S:��	q|���_r�6���pH4����\"EU)�Lv]�H�#�\rQT\rA�F������wpɮ2�x۽�&R,��j!L���H��p�ݟT�t�5	�x[\n�����C��v�B�w�/,�s�`����kF���K#0w�3�w\ro���/���M���\$��0'8\0f\0�o��q*����K5�12^��I�Y�x����������\"�`�|H��*R�ĸ�aI��sI~Đ?ȹ�%�'\\�K\\#.�I�X��1�&�%ƈ�q�XT��(HX�a��aWs)ɈX�=��\0001~����c;�Ti�D�C�wx�,�N�y>�v9�Y2��o�4��,4�X��,Jn��0�v�� �ظ���S�u\n��_N��~!�\rN�	\n�l��TZ��yC��m��hm����)��yJԢ�s�-�YM��F�@nthY�f���RÄ\0�	 N @�%􇒒=�� .nHk�;�1�Y#|�P�H>;1�� nᴢ|�a.I\$�6\0vb�^l���T��!���Z�w�<��3��ʓ��\$��=;�2Q����y}iD���z�>��w�	߳���EĪ/h<�`}>f~c��po���#����{��e5��o�%�yqz���Pq��%��6o/��g1���8�\\�q`oL����;�q��	�T�6��\0�@e�\\��%��v��7��]h'T��λ�R��O��<���\"���J�:[뮒���`�Wm��(&h��e��/����m������j��kH���R0�����!���<��5/{v�1#^\n|�{w4��F�x�Rh�}o����^e�F���]�=�m�G�kxk�P�0����{h-\0e��]e]CMG��,��7��u�;�.��\0ϴxm����n�~#�)�&|P( T(\0�dKY!Q��\0�a�(�tÀ�)�)�R&��D�j|����I�F`��\\�X�@h\$��.���:�Cʀ�z�q�\rP��Q@P�(���kh�\\x\\���2��Kp�TV~|��d}9P6����v�\0�ܰzaT�\"�J�J�.x7�&�5��]2p|�#�\0\n'��~�U2���ŇP��0*5/��(q�3��T_V�E%Ǳ�r�\n��6Cm؟�Y�A���+�����`�_��c�����\r�L\0�ܰ8�?����L-.�GE�@zG���5��\0��b��\n�b)#������ǀ��5�:{��\0h��\0`�3U�O�=��߈C�ޢ~x���܆E���'��4�9ߍ���%U7� K�?�����jx]��������@e�A�)D�8�A�T��g�?����Ѿ����z�E£���Ƽє�_���z�v}��5��[RЇ6M�^���=�?����>����,�����|����M�O����A�H������\r_�{C@�}9*+��Q�:h/\0��N�;W��84}\\(?����R�P�@8_��f4G�!s�Pe���0ȿ\0/��'�@t@�)j�\\���Od��?U��#~ڧ�x�\n6T�P0�t�)T����FS*���0��?��u&��� ����O?z�u�Q��9�qׅ�����2@��e�q���WK�V�O�L\0V�¢�\\@���^��@'\0�OÆ���L���\0zh��%\0���.���n�l������J;�j��K�-^I�b!M&\"�{�0�h�#@���^��6H���;��Åa|\0ă�`�fx�\r\0�kI@���HZ�F���CO�&�T���>X�my��X�V���sC�2-:�Y�T<�CP.&>\$����]�#P+���D\r\r4���SM\r\" �*\"�x��l�@��SǢ��4߀X����	�W%o��a�\r\r�Mf�D�\0�\0���M��nB\$��c�@�8#aT`�����\rj��t�o���\0d�Pc�N�[���k��`�|LԼ�E��<>y�W����k`A~c\$]�{)]w6�z\r����=p0����b�A�/0.�r�\0�0�);\$�f�0}K��e�z~�� B��hM�2\r�6�@2�");
    } elseif ($_GET['file'] == 'jush.js') {
        header('Content-Type: text/javascript; charset=utf-8');
        echo
        lzw_decompress("v0��F����==��FS	��_6MƳ���r:�E�CI��o:�C��Xc��\r�؄J(:=�E���a28�x�?�'�i�SANN���xs�NB��Vl0���S	��Ul�(D|҄��P��>�E�㩶yHch��-3Eb�� �b��pE�p�9.����~\n�?Kb�iw|�`��d.�x8EN��!��2��3���\r���Y���y6GFmY�8o7\n\r�0��\0�Dbc�!�Q7Шd8���~��N)�Eг`�Ns��`�S)�O���/�<�x�9�o�����3n��2�!r�:;�+�9�CȨ���\n<�`��b�\\�?�`�4\r#`�<�Be�B#�N ��\r.D`��j�4���p�ar��㢺�>�8�\$�c��1�c���c����{n7����A�N�RLi\r1���!�(�j´�+��62�X�8+����.\r����!x���h�'��6S�\0R����O�\n��1(W0���7q��:N�E:68n+��մ5_(�s�\r��/m�6P�@�EQ���9\n�V-���\"�.:�J��8we�q�|؇�X�]��Y X�e�zW�� �7��Z1��hQf��u�j�4Z{p\\AU�J<��k��@�ɍ��@�}&���L7U�wuYh��2��@�u� P�7�A�h����3Û��XEͅZ�]�l�@Mplv�)� ��HW���y>�Y�-�Y��/�������hC�[*��F�#~�!�`�\r#0P�C˝�f������\\���^�%B<�\\�f�ޱ�����&/�O��L\\jF��jZ�1�\\:ƴ>�N��XaF�A�������f�h{\"s\n�64������?�8�^p�\"띰�ȸ\\�e(�P�N��q[g��r�&�}Ph���W��*��r_s�P�h���\n���om������#���.�\0@�pdW �\$Һ�Q۽Tl0� ��HdH�)��ۏ��)P���H�g��U����B�e\r�t:��\0)\"�t�,�����[�(D�O\nR8!�Ƭ֚��lA�V��4�h��Sq<��@}���gK�]���]�=90��'����wA<����a�~��W��D|A���2�X�U2��yŊ��=�p)�\0P	�s��n�3�r�f\0�F���v��G��I@�%���+��_I`����\r.��N���KI�[�ʖSJ���aUf�Sz���M��%��\"Q|9��Bc�a�q\0�8�#�<a��:z1Uf��>�Z�l������e5#U@iUG��n�%Ұs���;gxL�pP�?B��Q�\\�b��龒Q�=7�:��ݡQ�\r:�t�:y(� �\n�d)���\n�X;����CaA�\r���P�GH�!���@�9\n\nAl~H���V\ns��ի�Ư�bBr���������3�\r�P�%�ф\r}b/�Α\$�5�P�C�\"w�B_��U�gAt��夅�^Q��U���j����Bvh졄4�)��+�)<�j^�<L��4U*���Bg�����*n�ʖ�-����	9O\$��طzyM�3�\\9���.o�����E(i������7	tߚ�-&�\nj!\r��y�y�D1g���]��yR�7\"������~����)TZ0E9M�YZtXe!�f�@�{Ȭyl	8�;���R{��8�Į�e�+UL�'�F�1���8PE5-	�_!�7��[2�J��;�HR��ǹ�8p痲݇@��0,ծpsK0\r�4��\$sJ���4�DZ��I��'\$cL�R��MpY&����i�z3G�zҚJ%��P�-��[�/x�T�{p��z�C�v���:�V'�\\��KJa��M�&���Ӿ\"�e�o^Q+h^��iT��1�OR�l�,5[ݘ\$��)��jLƁU`�S�`Z^�|��r�=��n登��TU	1Hyk��t+\0v�D�\r	<��ƙ��jG���t�*3%k�YܲT*�|\"C��lhE�(�\r�8r��{��0����D�_��.6и�;����rBj�O'ۜ���>\$��`^6��9�#����4X��mh8:��c��0��;�/ԉ����;�\\'(��t�'+�����̷�^�]��N�v��#�,�v���O�i�ϖ�>��<S�A\\�\\��!�3*tl`�u�\0p'�7�P�9�bs�{�v�{��7�\"{��r�a�(�^��E����g��/���U�9g���/��`�\nL\n�)���(A�a�\" ���	�&�P��@O\n師0�(M&�FJ'�! �0�<�H�������*�|��*�OZ�m*n/b�/�������.��o\0��dn�)����i�:R���P2�m�\0/v�OX���Fʳψ���\"�����0�0�����0b��gj��\$�n�0}�	�@�=MƂ0n�P�/p�ot������.�̽�g\0�)o�\n0���\rF����b�i��o}\n�̯�	NQ�'�x�Fa�J���L������\r��\r����0��'��d	oep��4D��ʐ�q(~�� �\r�E��pr�QVFH�l��Kj���N&�j!�H`�_bh\r1���n!�Ɏ�z�����\\��\r���`V_k��\"\\ׂ'V��\0ʾ`AC������V�`\r%�����\r����k@N����B�횙� �!�\n�\0Z�6�\$d��,%�%la�H�\n�#�S\$!\$@��2���I\$r�{!��J�2H�ZM\\��hb,�'||cj~g�r�`�ļ�\$���+�A1�E���� <�L��\$�Y%-FD��d�L焳��\n@�bVf�;2_(��L�п��<%@ڜ,\"�d��N�er�\0�`��Z��4�'ld9-�#`��Ŗ����j6�ƣ�v���N�͐f��@܆�&�B\$�(�Z&���278I ��P\rk\\���2`�\rdLb@E��2`P( B'�����0�&��{���:��dB�1�^؉*\r\0c<K�|�5sZ�`���O3�5=@�5�C>@�W*	=\0N<g�6s67Sm7u?	{<&L�.3~D��\rŚ�x��),r�in�/��O\0o{0k�]3>m��1\0�I@�9T34+ԙ@e�GFMC�\rE3�Etm!�#1�D @�H(��n ��<g,V`R]@����3Cr7s~�GI�i@\0v��5\rV�'������P��\r�\$<b�%(�Dd��PW����b�fO �x\0�} ��lb�&�vj4�LS��ִԶ5&dsF M�4��\".H�M0�1uL�\"��/J`�{�����xǐYu*\"U.I53Q�3Q��J��g��5�s���&jь��u�٭ЪGQMTmGB�tl-c�*��\r��Z7���*hs/RUV����B�Nˈ�����Ԋ�i�Lk�.���t�龩�rYi���-S��3�\\�T�OM^�G>�ZQj���\"���i��MsS�S\$Ib	f���u����:�SB|i��Y¦��8	v�#�D�4`��.��^�H�M�_ռ�u��U�z`Z�J	e��@Ce��a�\"m�b�6ԯJR���T�?ԣXMZ��І��p����Qv�j�jV�{���C�\r��7�Tʞ� ��5{P��]�\r�?Q�AA������2񾠓V)Ji��-N99f�l Jm��;u�@�<F�Ѡ�e�j��Ħ�I�<+CW@�����Z�l�1�<2�iF�7`KG�~L&+N��YtWH飑w	����l��s'g��q+L�zbiz���Ţ�.Њ�zW�� �zd�W����(�y)v�E4,\0�\"d��\$B�{��!)1U�5bp#�}m=��@�w�	P\0�\r�����`O|���	�ɍ����Y��JՂ�E��Ou�_�\n`F`�}M�.#1��f�*�ա��  �z�uc���� xf�8kZR�s2ʂ-���Z2�+�ʷ�(�sU�cD�ѷ���X!��u�&-vP�ر\0'L�X �L����o	��>�Վ�\r@�P�\rxF��E��ȭ�%����=5N֜��?�7�N�Å�w�`�hX�98 �����q��z��d%6̂t�/������L��l��,�Ka�N~�����,�'�ǀM\rf9�w��!x��x[�ϑ�G�8;�xA��-I�&5\$�D\$���%��xѬ���´���]����&o�-3�9�L��z���y6�;u�zZ ��8�_�ɐx\0D?�X7����y�OY.#3�8��ǀ�e�Q�=؀*��G�wm ���Y�����]YOY�F���)�z#\$e��)�/�z?�z;����^��F�Zg�����������`^�e����#�������?��e��M��3u�偃0�>�\"?��@חXv�\"������*Ԣ\r6v~��OV~�&ר�^g���đٞ�'��f6:-Z~��O6;zx��;&!�+{9M�ٳd� \r,9����W��ݭ:�\r�ٜ��@睂+��]��-�[g��ۇ[s�[i��i�q��y��x�+�|7�{7�|w�}����E��W��Wk�|J؁��xm��q xwyj���#��e��(�������ߞþ��� {��ڏ�y���M���@��ɂ��Y�(g͚-����������J(���@�;�y�#S���Y��p@�%�s��o�9;�������+��	�;����ZNٯº��� k�V��u�[�x��|q��ON?���	�`u��6�|�|X����س|O�x!�:���ϗY]�����c���\r�h�9n�������8'������\rS.1��USȸ��X��+��z]ɵ��?����C�\r��\\����\$�`��)U�|ˤ|Ѩx'՜����<�̙e�|�ͳ����L���M�y�(ۧ�l�к�O]{Ѿ�FD���}�yu��Ē�,XL\\�x��;U��Wt�v��\\OxWJ9Ȓ�R5�WiMi[�K��f(\0�dĚ�迩�\r�M����7�;��������6�KʦI�\r���xv\r�V3���ɱ.��R������|��^2�^0߾\$�Q��[�D��ܣ�>1'^X~t�1\"6L���+��A��e�����I��~����@����pM>�m<��SK��-H���T76�SMfg�=��GPʰ�P�\r��>�����2Sb\$�C[���(�)��%Q#G`u��Gwp\rk�Ke�zhj��zi(��rO�������T=�7���~�4\"ef�~�d���V�Z���U�-�b'V�J�Z7���)T��8.<�RM�\$�����'�by�\n5����_��w����U�`ei޿J�b�g�u�S��?��`���+��� M�g�7`���\0�_�-���_��?�F�\0����X���[��J�8&~D#��{P���4ܗ��\"�\0��������@ғ��\0F ?*��^��w�О:���u��3xK�^�w���߯�y[Ԟ(���#�/zr_�g��?�\0?�1wMR&M���?�St�T]ݴG�:I����)��B�� v����1�<�t��6�:�W{���x:=��ޚ��:�!!\0x�����q&��0}z\"]��o�z���j�w�����6��J�P۞[\\ }��`S�\0�qHM�/7B��P���]FT��8S5�/I�\r�\n ��O�0aQ\n�>�2�j�;=ڬ�dA=�p�VL)X�\n¦`e\$�TƦQJ����lJ����y�I�	�:����B�bP���Z��n����U;>_�\n	�����`��uM򌂂�֍m����Lw�B\0\\b8�M��[z��&�1�\0�	�\r�T������+\\�3�Plb4-)%Wd#\n��r��MX\"ϡ�(Ei11(b`@f����S���j�D��bf�}�r����D�R1���b��A��Iy\"�Wv��gC�I�J8z\"P\\i�\\m~ZR��v�1ZB5I��i@x����-�uM\njK�U�h\$o��JϤ!�L\"#p7\0� P�\0�D�\$	�GK4e��\$�\nG�?�3�EAJF4�Ip\0��F�4��<f@� %q�<k�w��	�LOp\0�x��(	�G>�@�����9\0T����GB7�-�����G:<Q��#���Ǵ�1�&tz��0*J=�'�J>���8q��Х���	�O��X�F��Q�,����\"9��p�*�66A'�,y��IF�R��T���\"��H�R�!�j#kyF���e��z�����G\0�p��aJ`C�i�@�T�|\n�Ix�K\"��*��Tk\$c��ƔaAh��!�\"�E\0O�d�Sx�\0T	�\0���!F�\n�U�|�#S&		IvL\"����\$h���EA�N\$�%%�/\nP�1���{��) <���L���-R1��6���<�@O*\0J@q��Ԫ#�@ǵ0\$t�|�]�`��ĊA]���Pᑀ�C�p\\pҤ\0���7���@9�b�m�r�o�C+�]�Jr�f��\r�)d�����^h�I\\�. g��>���8���'�H�f�rJ�[r�o���.�v���#�#yR�+�y��^����F\0᱁�]!ɕ�ޔ++�_�,�\0<@�M-�2W���R,c���e2�*@\0�P ��c�a0�\\P���O���`I_2Qs\$�w��=:�z\0)�`�h�������\nJ@@ʫ�\0�� 6qT��4J%�N-�m����.ɋ%*cn��N�6\"\r͑�����f�A���p�MۀI7\0�M�>lO�4�S	7�c���\"�ߧ\0�6�ps�����y.��	���RK��PAo1F�tI�b*��<���@�7�˂p,�0N��:��N�m�,�xO%�!��v����gz(�M���I��	��~y���h\0U:��OZyA8�<2����us�~l���E�O�0��0]'�>��ɍ�:���;�/��w�����'~3GΖ~ӭ����c.	���vT\0c�t'�;P�\$�\$����-�s��e|�!�@d�Obw��c��'�@`P\"x����0O�5�/|�U{:b�R\"�0�шk���`BD�\nk�P��c��4�^ p6S`��\$�f;�7�?ls��߆gD�'4Xja	A��E%�	86b�:qr\r�]C8�c�F\n'ьf_9�%(��*�~��iS����@(85�T��[��Jڍ4�I�l=��Q�\$d��h�@D	-��!�_]��H�Ɗ�k6:���\\M-����\r�FJ>\n.��q�eG�5QZ����' ɢ���ہ0��zP��#������r���t����ˎ��<Q��T��3�D\\����pOE�%)77�Wt�[��@����\$F)�5qG0�-�W�v�`�*)Rr��=9qE*K\$g	��A!�PjBT:�K���!��H� R0?�6�yA)B@:Q�8B+J�5U]`�Ҭ��:���*%Ip9�̀�`KcQ�Q.B��Ltb��yJ�E�T��7���Am�䢕Ku:��Sji� 5.q%LiF��Tr��i��K�Ҩz�55T%U��U�IՂ���Y\"\nS�m���x��Ch�NZ�UZ���( B��\$Y�V��u@蔻����|	�\$\0�\0�oZw2Ҁx2���k\$�*I6I�n�����I,��QU4�\n��).�Q���aI�]����L�h\"�f���>�:Z�>L�`n�ض��7�VLZu��e��X����B���B�����Z`;���J�]�����S8��f \nڶ�#\$�jM(��ޡ����a�G���+A�!�xL/\0)	C�\n�W@�4�����۩� ��RZ����=���8�`�8~�h��P ��\r�	���D-FyX�+�f�QSj+X�|��9-��s�x�����+�V�cbp쿔o6H�q�����@.��l�8g�YM��WMP��U��YL�3Pa�H2�9��:�a�`��d\0�&�Y��Y0٘��S�-��%;/�T�BS�P�%f������@�F��(�֍*�q +[�Z:�QY\0޴�JUY֓/���pkzȈ�,�𪇃j�ꀥW�״e�J�F��VBI�\r��pF�Nقֶ�*ը�3k�0�D�{����`q��ҲBq�e�D�c���V�E���n����FG�E�>j�����0g�a|�Sh�7u�݄�\$���;a��7&��R[WX���(q�#���P���ז�c8!�H���VX�Ď�j��Z������Q,DUaQ�X0��ը���Gb��l�B�t9-oZ���L���­�pˇ�x6&��My��sҐ����\"�̀�R�IWU`c���}l<|�~�w\"��vI%r+��R�\n\\����][��6�&���ȭ�a�Ӻ��j�(ړ�Tѓ��C'��� '%de,�\n�FC�эe9C�N�Ѝ�-6�Ueȵ��CX��V������+�R+�����3B��ڌJ�虜��T2�]�\0P�a�t29��(i�#�aƮ1\"S�:�����oF)k�f���Ъ\0�ӿ��,��w�J@��V򄎵�q.e}KmZ����XnZ{G-���ZQ���}��׶�6ɸ���_�؁Չ�\n�@7�` �C\0]_ ��ʵ����}�G�WW: fCYk+��b۶���2S,	ڋ�9�\0﯁+�W�Z!�e��2�������k.Oc��(v̮8�DeG`ۇ�L���,�d�\"C���B-�İ(����p���p�=����!�k������}(���B�kr�_R�ܼ0�8a%ۘL	\0���b������@�\"��r,�0T�rV>����Q��\"�r��P�&3b�P��-�x���uW~�\"�*舞�N�h�%7���K�Y��^A����C����p����\0�..`c��+ϊ�GJ���H���E����l@|I#Ac��D��|+<[c2�+*WS<�r��g���}��>i�݀�!`f8�(c����Q�=f�\n�2�c�h4�+q���8\na�R�B�|�R����m��\\q��gX����ώ0�X�`n�F���O p��H�C��jd�f��EuDV��bJɦ��:��\\�!mɱ?,TIa���aT.L�]�,J��?�?��FMct!a٧R�F�G�!�A���rr�-p�X��\r��C^�7���&�R�\0��f�*�A\n�՛H��y�Y=���l�<��A�_��	+��tA�\0B�<Ay�(fy�1�c�O;p���ᦝ`�4СM��*��f�� 5fvy {?���:y��^c��u�'���8\0��ӱ?��g��� 8B��&p9�O\"z���rs�0��B�!u�3�f{�\0�:�\n@\0����p���6�v.;�����b�ƫ:J>˂��-�B�hkR`-����aw�xEj����r�8�\0\\����\\�Uhm� �(m�H3̴��S����q\0��NVh�Hy�	��5�M͎e\\g�\n�IP:Sj�ۡٶ�<���x�&�L��;nfͶc�q��\$f�&l���i�����0%yΞ�t�/��gU̳�d�\0e:��h�Z	�^�@��1��m#�N��w@��O��zG�\$�m6�6}��ҋ�X'�I�i\\Q�Y���4k-.�:yz���H��]��x�G��3��M\0��@z7���6�-DO34�ދ\0Κ��ΰt\"�\"vC\"Jf�Rʞ��ku3�M��~����5V ��j/3���@gG�}D���B�Nq��=]\$�I��Ӟ�3�x=_j�X٨�fk(C]^j�M��F��ա��ϣCz��V��=]&�\r�A<	������6�Ԯ�״�`jk7:g��4ծ��YZq�ftu�|�h�Z��6��i〰0�?��骭{-7_:��ސtѯ�ck�`Y��&���I�lP`:�� j�{h�=�f	��[by��ʀoЋB�RS���B6��^@'�4��1U�Dq}��N�(X�6j}�c�{@8���,�	�PFC���B�\$mv���P�\"��L��CS�]����E���lU��f�wh{o�(��)�\0@*a1G� (��D4-c��P8��N|R���VM���n8G`e}�!}���p�����@_���nCt�9��\0]�u��s���~�r��#Cn�p;�%�>wu���n�w��ݞ�.���[��hT�{��值	�ˁ��J���ƗiJ�6�O�=������E��ٴ��Im���V'��@�&�{��������;�op;^��6Ŷ@2�l���N��M��r�_ܰ�Í�` �( y�6�7�����ǂ��7/�p�e>|��	�=�]�oc����&�xNm���烻��o�G�N	p����x��ý���y\\3����'�I`r�G�]ľ�7�\\7�49�]�^p�{<Z��q4�u�|��Qۙ��p���i\$�@ox�_<���9pBU\"\0005�� i�ׂ��C�p�\n�i@�[��4�jЁ�6b�P�\0�&F2~������U&�}����ɘ	��Da<��zx�k���=���r3��(l_���FeF���4�1�K	\\ӎld�	�1�H\r���p!�%bG�Xf��'\0���	'6��ps_��\$?0\0�~p(�H\n�1�W:9�͢��`��:h�B��g�B�k��p�Ɓ�t��EBI@<�%����` �y�d\\Y@D�P?�|+!��W��.:�Le�v,�>q�A���:���bY�@8�d>r/)�B�4���(���`|�:t�!����?<�@���/��S��P\0��>\\�� |�3�:V�uw���x�(����4��ZjD^���L�'���C[�'�����jº[�E�� u�{KZ[s���6��S1��z%1�c��B4�B\n3M`0�;����3�.�&?��!YA�I,)��l�W['��ITj���>F���S���BбP�ca�ǌu�N����H�	LS��0��Y`���\"il�\r�B���/����%P���N�G��0J�X\n?a�!�3@M�F&ó����,�\"���lb�:KJ\r�`k_�b��A��į��1�I,�����;B,�:���Y%�J���#v��'�{������	wx:\ni����}c��eN���`!w��\0�BRU#�S�!�<`��&v�<�&�qO�+Σ�sfL9�Q�Bʇ����b��_+�*�Su>%0�����8@l�?�L1po.�C&��ɠB��qh�����z\0�`1�_9�\"���!�\$���~~-�.�*3r?�ò�d�s\0����>z\n�\0�0�1�~���J����|Sޜ��k7g�\0��KԠd��a��Pg�%�w�D��zm�����)����j�����`k���Q�^��1���+��>/wb�GwOk���_�'��-CJ��7&����E�\0L\r>�!�q́���7����o��`9O`�����+!}�P~E�N�c��Q�)��#��#�����������J��z_u{��K%�\0=��O�X�߶C�>\n���|w�?�F�����a�ϩU����b	N�Y��h����/��)�G��2���K|�y/�\0��Z�{��P�YG�;�?Z}T!�0��=mN����f�\"%4�a�\"!�ޟ����\0���}��[��ܾ��bU}�ڕm��2�����/t���%#�.�ؖ��se�B�p&}[˟��7�<a�K���8��P\0��g��?��,�\0�߈r,�>���W����/��[�q��k~�CӋ4��G��:��X��G�r\0������L%VFLUc��䑢��H�ybP��'#��	\0п���`9�9�~���_��0q�5K-�E0�b�ϭ�����t`lm����b��Ƙ; ,=��'S�.b��S���Cc����ʍAR,����X�@�'��8Z0�&�Xnc<<ȣ�3\0(�+*�3��@&\r�+�@h, ��\$O���\0Œ��t+>����b��ʰ�\r�><]#�%�;N�s�Ŏ����*��c�0-@��L� >�Y�p#�-�f0��ʱa�,>��`����P�:9��o���ov�R)e\0ڢ\\����\nr{îX����:A*��.�D��7�����#,�N�\r�E���hQK2�ݩ��z�>P@���	T<��=�:���X�GJ<�GAf�&�A^p�`���{��0`�:���);U !�e\0����c�p\r�����:(��@�%2	S�\$Y��3�hC��:O�#��L��/����k,��K�oo7�BD0{���j��j&X2��{�}�R�x��v���أ�9A����0�;0�����-�5��/�<�� �N�8E����	+�Ѕ�Pd��;���*n��&�8/jX�\r��>	PϐW>K��O��V�/��U\n<��\0�\nI�k@��㦃[��Ϧ²�#�?���%���.\0001\0��k�`1T� ����ɐl�������p���������< .�>��5��\0��	O�>k@Bn��<\"i%�>��z��������3�P�!�\r�\"��\r �>�ad���U?�ǔ3P��j3�䰑>;���>�t6�2�[��޾M\r�>��\0��P���B�Oe*R�n���y;� 8\0���o�0���i���3ʀ2@����?x�[����L�a����w\ns����A��x\r[�a�6�clc=�ʼX0�z/>+����W[�o2���)e�2�HQP�DY�zG4#YD����p)	�H�p���&�4*@�/:�	�T�	���aH5���h.�A>��`;.���Y��a	���t/ =3��BnhD?(\n�!�B�s�\0��D�&D�J��)\0�j�Q�y��hDh(�K�/!�>�h,=�����tJ�+�S��,\"M�Ŀ�N�1�[;�Т��+��#<��I�Zğ�P�)��LJ�D��P1\$����Q�>dO��v�#�/mh8881N:��Z0Z���T �B�C�q3%��@�\0��\"�XD	�3\0�!\\�8#�h�v�ib��T�!d�����V\\2��S��Œ\nA+ͽp�x�iD(�(�<*��+��E��T���B�S�CȿT���� e�A�\"�|�u�v8�T\0002�@8D^oo�����|�N������J8[��3����J�z׳WL\0�\0��Ȇ8�:y,�6&@�� �E�ʯݑh;�!f��.B�;:���[Z3������n���ȑ��A���qP4,��Xc8^��`׃��l.����S�hޔ���O+�%P#Ρ\n?��IB��eˑ�O\\]��6�#��۽؁(!c)�N����?E��B##D �Ddo��P�A�\0�:�n�Ɵ�`  ��Q��>!\r6�\0��V%cb�HF�)�m&\0B�2I�5��#]���D>��3<\n:ML��9C���0��\0���(ᏩH\n����M�\"GR\n@���`[���\ni*\0��)������u�)��Hp\0�N�	�\"��N:9q�.\r!���J��{,�'����4�B���lq���Xc��4��N1ɨ5�Wm��3\n��F��`�'��Ҋx��&>z>N�\$4?����(\n쀨>�	�ϵP�!Cq͌��p�qGLqq�G�y�H.�^��\0z�\$�AT9Fs�Ѕ�D{�a��cc_�G�z�)� �}Q��h��HBָ�<�y!L����!\\�����'�H(��-�\"�in]Ğ���\\�!�`M�H,gȎ��*�Kf�*\0�>6���6��2�hJ�7�{nq�8����H�#c�H�#�\r�:��7�8�܀Z��ZrD��߲`rG\0�l\n�I��i\0<����\0Lg�~���E��\$��P�\$�@�PƼT03�HGH�l�Q%*\"N?�%��	��\n�CrW�C\$��p�%�uR`��%��R\$�<�`�Ifx���\$/\$�����\$���O�(���\0��\0�RY�*�/	�\rܜC9��&hh�=I�'\$�RRI�'\\�a=E����u·'̙wI�'T���������K9%�d����!��������j�����&���v̟�\\=<,�E��`�Y��\\����*b0>�r��,d�pd���0DD ̖`�,T �1�% P���/�\r�b�(���J����T0�``ƾ����J�t���ʟ((d�ʪ�h+ <Ɉ+H%i�����#�`� ���'��B>t��J�Z\\�`<J�+hR���8�hR�,J]g�I��0\n%J�*�Y���JwD��&ʖD�������R�K\"�1Q�� ��AJKC,�mV�������-���KI*�r��\0�L�\"�Kb(����J:qKr�d�ʟ-)��ˆ#Ը�޸[�A�@�.[�Ҩʼ�4���.�1�J�.̮�u#J���g\0��򑧣<�&���K�+�	M?�/d��%'/��2Y��>�\$��l�\0��+����}-t��ͅ*�R�\$ߔ��K�.����JH�ʉ�2\r��B���(P���6\"��nf�\0#Ї ��%\$��[�\n�no�LJ�����e'<����1K��y�Y1��s�0�&zLf#�Ƴ/%y-�ˣ3-��K��L�΁��0����[,��̵,������0���(�.D��@��2�L+.|�����2�(�L�*��S:\0�3����G3l��aːl�@L�3z4�ǽ%̒�L�3����!0�33=L�4|ȗ��+\"���4���7�,\$�SPM�\\��?J�Y�̡��+(�a=K��4���C̤<Ё�=\$�,��UJ]5h�W�&t�I%��5�ҳ\\M38g�́5H�N?W1H��^��Ը�Y͗ؠ�͏.�N3M�4Å�`��i/P�7�dM>�d�/�LR���=K�60>�I\0[��\0��\r2���Z@�1��2��7�9�FG+�Ҝ�\r)�hQtL}8\$�BeC#��r*H�۫�-�H�/���6��\$�RC9�ب!���7�k/P�0Xr5��3D���<T�Ԓq�K���n�H�<�F�:1SL�r�%(��u)�Xr�1��nJ�I��S�\$\$�.·9��IΟ�3 �L�l���Ι9��C�N�#ԡ�\$�/��s��9�@6�t���N�9���N�:����7�Ӭ�:D���M)<#���M}+�2�N��O&��JNy*���ٸ[;���O\"m����M�<c�´���8�K�,���N�=07s�JE=T��O<����J�=D��:�C<���ˉ=���K�ʻ̳�L3�����LTЀ3�S,�.���q-��s�7�>�?�7O;ܠ`�OA9���ϻ\$���O�;��`9�n�I�A�xp��E=O�<��5����2�O�?d�����`N�iO�>��3�P	?���O�m��S�M�ˬ��=�(�d�Aȭ9���\0�#��@��9D����&���?����i9�\n�/��A���ȭA��S�Po?kuN5�~4���6���=򖌓*@(�N\0\\۔dG��p#��>�0��\$2�4z )�`�W���+\0��80�菦������z\"T��0�:\0�\ne \$��rM�=�r\n�N�P�Cmt80�� #��J=�&��3\0*��B�6�\"������#��>�	�(Q\n���8�1C\rt2�EC�\n`(�x?j8N�\0��[��QN>���'\0�x	c���\n�3��Ch�`&\0���8�\0�\n���O`/����A`#��Xc���D �tR\n>���d�B�D�L��������Dt4���j�p�GAoQoG8,-s����K#�);�E5�TQ�G�4Ao\0�>�tM�D8yRG@'P�C�	�<P�C�\"�K\0��x��~\0�ei9���v))ѵGb6���H\r48�@�M�:��F�tQ�!H��{R} �URp���O\0�I�t8������[D4F�D�#��+D�'�M����>RgI���Q�J���U�)Em���TZ�E�'��iE����qFzA��>�)T�Q3H�#TL�qIjNT���&C��h�X\nT���K\0000�5���JH�\0�FE@'љFp�hS5F�\"�oѮ�e%aoS E)� ��DU��Q�Fm�ѣM��Ѳe(tn� �U1ܣ~>�\$��ǂ��(h�ǑG�y`�\0��	��G��3�5Sp(��P�G�\$��#��	���N�\n�V\$��]ԜP�=\"RӨ?Lzt��1L\$\0��G~��,�KN�=���GM����NS�)��O]:ԊS}�81�RGe@C�\0�OP�S�N�1��T!P�@��S����S�G`\n�:��P�j�7R� @3��\n� �������DӠ��L�����	��\0�Q5���CP��SMP�v4��?h	h�T�D0��֏��>&�ITx�O�?�@U��R8@%Ԗ��K���N�K��RyE�E#�� @����%L�Q�Q����?N5\0�R\0�ԁT�F�ԔR�S�!oTE�C(�����ĵ\0�?3i�SS@U�QeM��	K�\n4P�CeS��\0�NC�P��O�!�\"RT�����S�N���U5OU>UiI�PU#UnKP��UYT�*�C��U�/\0+���)��:ReA�\$\0���x��WD�3���`����U5�IHUY��:�P	�e\0�MJi�����Q�>�@�T�C{��u��?�^�v\0WR�]U}C��1-5+U�?�\r�W<�?5�JU-SX��L�� \\t�?�sM�b�ՃV܁t�T�>�MU+�	E�c���9Nm\rRǃC�8�S�X�'R��XjCI#G|�!Q�Gh�t�Q��� )<�Y�*��RmX0����M���OQ�Y�h���du���Z(�Ao#�NlyN�V�Z9I���M��V�ZuOՅT�T�EՇַS�e����\n�X��S�QER����[MF�V�O=/����>�gչT�V�oU�T�Z�N�*T\\*����S-p�S��V�q��M(�Q=\\�-UUUV�C���Z�\nu�V\$?M@U�WJ\r\rU��\\�'U�W]�W��W8�N�'#h=oC���F(��:9�Yu����V-U�9�]�C�:U�\\�\n�qW���(TT?5P�\$ R3�⺟C}`>\0�E]�#R��	��#R�)�W���:`#�G�)4�R��;��ViD%8�)Ǔ^�Q��#�h	�HX	��\$N�x��#i x�ԒXR��'�9`m\\���\nE��Q�`�bu@��N�dT�#YY����GV�]j5#?L�xt/#���#酽O�P��Q��6����^� �������M\\R5t�Ӛp�*��X�V\"W�D�	oRALm\rdG�N	����6�p\$�P废E5����Tx\n�+��C[��V�����8U�Du}ػF\$.��Q-;4Ȁ�NX\n�.X�b͐�\0�b�)�#�N�G4K��ZS�^״M�8��d�\"C��>��dHe\n�Y8���.� ���ҏF�D��W1cZ6��Q�KH�@*\0�^���\\Q�F�4U3Y|�=�Ӥ�E��ۤ�?-�47Y�Pm�hYw_\r�VeױM���ُe(0��F�\r�!�PUI�u�7Q�C�ю?0����gu\rqधY-Q�����=g\0�\0M#�U�S5Zt�֟ae^�\$>�ArV�_\r;t���HW�Z�@H��hzD��\0�S2J� HI�O�'ǁe�g�6�[�R�<�?� /��KM����\n>��H�Z!i����TX6���i�C !ӛg�� �G }Q6��4>�w�!ڙC}�VB�>�UQڑj�8c�U�T���'<�>����HC]�V��7jj3v���`0���23����x�@U�k�\n�:Si5��#Y�-w����M?c��MQ�GQ�уb`��\0�@��ҧ\0M��)ZrKX�֟�Wl������l�TM�D\r4�QsS�40�sQ́�mY�h�d��C`{�V�gE�\n��XkՁ�'��,4���^��6�#<4��NXnM):��OM_6d�������[\"KU�n��?l�x\0&\0�R56�T~>��ո?�Jn��� ��Z/i�6���glͦ�U��F}�.����JL�CTbM�4��cL�TjSD�}Jt���Z����:�L���d:�Ez�ʤ�>��V\$2>����[�p�6��R�9u�W.?�1��RHu���R�?58Ԯ��D��u���p�c�Z�?�r׻ Eaf��}5wY���ϒ���W�wT[Sp7'�_aEk�\"[/i��#�\$;m�fأWO����F�\r%\$�ju-t#<�!�\n:�KEA����]�\nU�Q�KE��#��X��5[�>�`/��D��֭VEp�)��I%�q���n�x):��le���[e�\\�eV[j�����7 -+��G�WEwt�WkE�~u�Q/m�#ԐW�`�yu�ǣD�A�'ױ\r��ՙO�D )ZM^��u-|v8]�g��h���L��W\0���6�X��=Y�d�Q�7ϓ��9����r <�֏�D��B`c�9���`�D�=wx�I%�,ᄬ�����j[њ����O��� ``��|�����������.�	AO���	��@�@ 0h2�\\�ЀM{e�9^>���@7\0��˂W���\$,��Ś�@؀����w^fm�,\0�yD,ם^X�.�ֆ�7����2��f;��6�\n����^�zC�קmz��n�^���&LFF�,��[��e��aXy9h�!:z�9c�Q9b� !���Gw_W�g�9���S+t���p�tɃ\nm+����_�	��\\���k5���]�4�_h�9 ��N����]%|��7�֜�];��|���X��9�|����G���[��\0�}U���MC�I:�qO�Vԃa\0\r�R�6π�\0�@H��P+r�S�W���p7�I~�p/��H�^������E�-%��̻�&.��+�Jђ;:���!���N�	�~����/�W��!�B�L+�\$��q�=��+�`/Ƅe�\\���x�pE�lpS�JS�ݢ��6��_�(ů���b\\O��&�\\�59�\0�9n���D�{�\$���K��v2	d]�v�C�����?�tf|W�:���p&��Ln��賞�{;���G�R9��T.y���I8���\rl� �	T��n�3���T.�9��3����Z�s����G����:	0���z��.�]��ģQ�?�gT�%��x�Ռ.����n<�-�8B˳,B��rgQ�����Ɏ`��2�:{�g��s��g�Z��� ׌<��w{���bU9�	`5`4�\0BxMp�8qnah�@ؼ�-�(�>S|0�����3�8h\0���C�zLQ�@�\n?��`A��>2��,���N�&��x�l8sah1�|�B�ɇD�xB�#V��V�׊`W�a'@���	X_?\n�  �_�. �P�r2�bUar�I�~��S���\0ׅ\"�2����>b;�vPh{[�7a`�\0�˲j�o�~���v��|fv�4[�\$��{�P\rv�BKGbp������O�5ݠ2\0j�لL���)�m��V�ejBB.'R{C��V'`؂ ��%�ǀ�\$�O��\0�`����4 �N�>;4���/�π��*��\\5���!��`X*�%��N�3S�AM���Ɣ,�1����\\��caϧ ��@��˃�B/����0`�v2��`hD�JO\$�@p!9�!�\n1�7pB,>8F4��f�π:��7���3��3����T8�=+~�n���\\�e�<br����Fز� ��C�N�:c�:�l�<\r��\\3�>���6�ONn��!;��@�tw�^F�L�;���,^a��\ra\"��ڮ'�:�v�Je4�א;��_d\r4\r�:����S�����2��[c��X�ʦPl�\$�ޣ�i�w�d#�B��b��������`:���~ <\0�2����R���P�\r�J8D�t@�E��\0\r͜6����7����Y���\"����\r�����3��.�+�z3�;_ʟvL����wJ�94�I�Ja,A����;�s?�N\nR��!��ݐ�Om�s�_��-zۭw���zܭ7���z���M����o����\0��a��ݹ4�8�Pf�Y�?��i��eB�S�1\0�jDTeK��UYS�?66R	�c�6Ry[c���5�]B͔�R�_eA)&�[凕XYRW�6VYaeU�fYe�w��U�b�w�E�ʆ;z�^W�9��ק�ݖ��\0<ޘ�e�9S���da�	�_-��L�8ǅ�Q��TH[!<p\0��Py5�|�#��P�	�9v��2�|Ǹ��fao��,j8�\$A@k����a���b�c��f4!4���cr,;�����b�=��;\0��ź���cd��X�b�x�a�Rx0A�h�+w�xN[��B��p���w�T�8T%��M�l2�������}��s.kY��0\$/�fU�=��s�gK���M� �?���`4c.��!�&�分g��f�/�f1�=��V AE<#̹�f\n�)���Np��`.\"\"�A�����q��X��٬:a�8��f��Vs�G��r�:�V��c�g�Vl��g=��`��W���y�gU��˙�Ẽ�eT=�����x 0� M�@����%κb���w��f��O�筘�*0���|t�%��P��p��gK���?p�@J�<Bٟ#�`1��9�2�g�!3~����nl��f��Vh���.����aC���?���-�1�68>A��a�\r��y�0��i�J�}�������z:\r�)�S���@��h@���Y���mCEg�cyφ��<���h@�@�zh<W��`��:zO���\r��W���V08�f7�(Gy���`St#��f�#����C(9���؀d���8T:���0�� q���79��phAg�6�.��7Fr�b� �j��A5��a1��h�ZCh:�%��gU��D9��Ɉ�׹��0~vTi;�VvS��w��\r΃?��f�����n�ϛiY��a��3�·9�,\n��r��,/,@.:�Y>&��F�)�����}�b���iO�i��:d�A�n��c=�L9O�h{�� 8hY.������������\r��և�����1Q�U	�C�h��e�O���+2o����N�����zp�(�]�h��Z|�O�c�zD���;�T\0j�\0�8#�>Ύ�=bZ8Fj���;�޺T酡w��)���N`���ÅB{��z\r�c���|dTG�i�/��!i��0���'`Z:�CH�(8�`V������\0�ꧩ��W��Ǫ��zgG������-[��	i��N\rq��n���o	ƥfEJ��apb��}6���=o���,t�Y+��EC\r�Px4=����@���.��F��[�zq���X6:FG��#��\$@&�ab��hE:����`�S�1�1g1���2uhY��_:Bߡdc�*���\0�ƗFYF�:���n���=ۨH*Z�Mhk�/�냡�zٹ]��h@����1\0��ZK�������^+�,vf�s��>���O�|���s�\0֜5�X��ѯF��n�A�r]|�Ii4�� ��C� h@ع����cߥ�6smO������gX�V2�6g?~��Y�Ѱ�s�cl \\R�\0��c��A+�1������\n(����^368cz:=z��(�� ;裨�s�F�@`;�,>yT��&��d�Lן��%��-�CHL8\r��b�����Mj]4�Ym9����Z�B��P}<���X���̥�+g�^�M� + B_Fd�X���l�w�~�\r⽋�\":��qA1X������3�ΓE�h�4�ZZ��&����1~!N�f��o���\nMe�଄��XI΄�G@V*X��;�Y5{V�\n���T�z\rF�3}m��p1�[�>�t�e�w����@V�z#��2��	i���{�9��p̝�gh���+[elU���A�ٶӼi1�!��omm�*K���}��!�Ƴ����{me�f`��m��C�z=�n�:}g� T�mLu1F��}=8�Z���O��mFFMf��OO����������/����ޓ���V�oqj���n!+����Z��I�.�9!nG�\\��3a�~�O+��::�K@�\n�@���Hph��\\B��dm�fvC���P�\" ��.nW&��n��HY�+\r���z�i>Mfqۤ��Qc�[�H+��o��*�1'��#āEw�D_X�)>�s��-~\rT=�������- �y�m����{�h��j�M�)�^����'@V�+i�������;F��D[�b!����B	��:MP���ۭoC�vAE?�C�IiY��#�p�P\$k�J�q�.�07���x�l�sC|���bo�2�X�>M�\rl&��:2�~��cQ����o��d�-��U�Ro�Y�nM;�n�#��\0�P�f��Po׿(C�v<���[�o۸����fѿ���;�ẖ�[�Y�.o�Up���pU���.���B!'\0���<T�:1�������<���n��F���I�ǔ��V0�ǁRO8�w��,aF��ɥ�[�Ο��YO����/\0��ox���Q�?��:ً���`h@:�����/M�m�x:۰c1������v�;���^���@��@�����\n{�����;���B���8�� g坒�\\*g�yC)��E�^�O�h	���A�u>���@�D��Y�����`o�<>��p���ķ�q,Y1Q��߸��/qg�\0+\0���D���?�� ����k:�\$����ץ6~I��=@���!��v�zO񁚲�+���9�i����a������g������?��0Gn�q�]{Ҹ,F���O���� <_>f+��,��	���&�����·�y�ǩO�:�U¯�L�\n�úI:2��-;_Ģ�|%�崿!��f�\$���Xr\"Kni����\$8#�g�t-��r@L�圏�@S�<�rN\n�D/rLdQk࣓�����e����Э��\n=4)�B���ך�");
    } else {
        header('Content-Type: image/gif');
        switch($_GET['file']) {
            case'plus.gif':echo"GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0!�����M��*)�o��) q��e���#��L�\0;";
            break;
            case'cross.gif':echo"GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0#�����#\na�Fo~y�.�_wa��1�J�G�L�6]\0\0;";
            break;
            case'up.gif':echo"GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0 �����MQN\n�}��a8�y�aŶ�\0��\0;";
            break;
            case'down.gif':echo"GIF89a\0\0�\0001���\0\0����\0\0\0!�\0\0\0,\0\0\0\0\0\0 �����M��*)�[W�\\��L&ٜƶ�\0��\0;";
            break;
            case'arrow.gif':echo"GIF89a\0\n\0�\0\0������!�\0\0\0,\0\0\0\0\0\n\0\0�i������Ӳ޻\0\0;";
            break;
        }
    }exit;
}if ($_GET['script'] == 'version') {
    $r = file_open_lock(get_temp_dir().'/adminer.version');
    if ($r) {
        file_write_unlock($r, serialize(['signature' => $_POST['signature'], 'version' => $_POST['version']]));
    }exit;
}global$c,$g,$l,$Ib,$Pb,$Zb,$m,$Cc,$Hc,$ba,$Zc,$z,$a,$rd,$me,$Re,$gg,$Mc,$T,$Og,$Ug,$bh,$fa;
if (! $_SERVER['REQUEST_URI']) {
    $_SERVER['REQUEST_URI'] = $_SERVER['ORIG_PATH_INFO'];
}if (! strpos($_SERVER['REQUEST_URI'], '?') && $_SERVER['QUERY_STRING'] != '') {
    $_SERVER['REQUEST_URI'] .= "?$_SERVER[QUERY_STRING]";
}if ($_SERVER['HTTP_X_FORWARDED_PREFIX']) {
    $_SERVER['REQUEST_URI'] = $_SERVER['HTTP_X_FORWARDED_PREFIX'].$_SERVER['REQUEST_URI'];
}$ba = ($_SERVER['HTTPS'] && strcasecmp($_SERVER['HTTPS'], 'off')) || ini_bool('session.cookie_secure');
@ini_set('session.use_trans_sid', false);
if (! defined('SID')) {
    session_cache_limiter('');
    session_name('adminer_sid');
    $He = [0, preg_replace('~\?.*~', '', $_SERVER['REQUEST_URI']), '', $ba];
    if (version_compare(PHP_VERSION, '5.2.0') >= 0) {
        $He[] = true;
    }call_user_func_array('session_set_cookie_params', $He);
    session_start();
}remove_slashes([&$_GET, &$_POST, &$_COOKIE], $tc);
if (get_magic_quotes_runtime()) {
    set_magic_quotes_runtime(false);
}@set_time_limit(0);
@ini_set('zend.ze1_compatibility_mode', false);
@ini_set('precision', 15);
$rd = ['en' => 'English', 'ar' => 'العربية', 'bg' => 'Български', 'bn' => 'বাংলা', 'bs' => 'Bosanski', 'ca' => 'Català', 'cs' => 'Čeština', 'da' => 'Dansk', 'de' => 'Deutsch', 'el' => 'Ελληνικά', 'es' => 'Español', 'et' => 'Eesti', 'fa' => 'فارسی', 'fi' => 'Suomi', 'fr' => 'Français', 'gl' => 'Galego', 'he' => 'עברית', 'hu' => 'Magyar', 'id' => 'Bahasa Indonesia', 'it' => 'Italiano', 'ja' => '日本語', 'ka' => 'ქართული', 'ko' => '한국어', 'lt' => 'Lietuvių', 'ms' => 'Bahasa Melayu', 'nl' => 'Nederlands', 'no' => 'Norsk', 'pl' => 'Polski', 'pt' => 'Português', 'pt-br' => 'Português (Brazil)', 'ro' => 'Limba Română', 'ru' => 'Русский', 'sk' => 'Slovenčina', 'sl' => 'Slovenski', 'sr' => 'Српски', 'ta' => 'த‌மிழ்', 'th' => 'ภาษาไทย', 'tr' => 'Türkçe', 'uk' => 'Українська', 'vi' => 'Tiếng Việt', 'zh' => '简体中文', 'zh-tw' => '繁體中文'];
function get_lang()
{
    global$a;

    return$a;
}function lang($w, $de = null)
{
    if (is_string($w)) {
        $Ue = array_search($w, get_translations('en'));
        if ($Ue !== false) {
            $w = $Ue;
        }
    }global$a,$Og;
    $Ng = ($Og[$w] ? $Og[$w] : $w);
    if (is_array($Ng)) {
        $Ue = ($de == 1 ? 0 : ($a == 'cs' || $a == 'sk' ? ($de && $de < 5 ? 1 : 2) : ($a == 'fr' ? (! $de ? 0 : 1) : ($a == 'pl' ? ($de % 10 > 1 && $de % 10 < 5 && $de / 10 % 10 != 1 ? 1 : 2) : ($a == 'sl' ? ($de % 100 == 1 ? 0 : ($de % 100 == 2 ? 1 : ($de % 100 == 3 || $de % 100 == 4 ? 2 : 3))) : ($a == 'lt' ? ($de % 10 == 1 && $de % 100 != 11 ? 0 : ($de % 10 > 1 && $de / 10 % 10 != 1 ? 1 : 2)) : ($a == 'bs' || $a == 'ru' || $a == 'sr' || $a == 'uk' ? ($de % 10 == 1 && $de % 100 != 11 ? 0 : ($de % 10 > 1 && $de % 10 < 5 && $de / 10 % 10 != 1 ? 1 : 2)) : 1)))))));
        $Ng = $Ng[$Ue];
    }$ta = func_get_args();
    array_shift($ta);
    $zc = str_replace('%d', '%s', $Ng);
    if ($zc != $Ng) {
        $ta[0] = format_number($de);
    }

return
    vsprintf($zc, $ta);
}function switch_lang()
{
    global$a,$rd;
    echo"<form action='' method='post'>\n<div id='lang'>",lang(19).': '.html_select('lang', $rd, $a, 'this.form.submit();')," <input type='submit' value='".lang(20)."' class='hidden'>\n","<input type='hidden' name='token' value='".get_token()."'>\n";
    echo"</div>\n</form>\n";
}if (isset($_POST['lang']) && verify_token()) {
    cookie('adminer_lang', $_POST['lang']);
    $_SESSION['lang'] = $_POST['lang'];
    $_SESSION['translations'] = [];
    redirect(remove_from_uri());
}$a = 'en';
if (isset($rd[$_COOKIE['adminer_lang']])) {
    cookie('adminer_lang', $_COOKIE['adminer_lang']);
    $a = $_COOKIE['adminer_lang'];
} elseif (isset($rd[$_SESSION['lang']])) {
    $a = $_SESSION['lang'];
} else {
    $ka = [];
    preg_match_all('~([-a-z]+)(;q=([0-9.]+))?~', str_replace('_', '-', strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE'])), $Fd, PREG_SET_ORDER);
    foreach ($Fd
    as$D) {
        $ka[$D[1]] = (isset($D[3]) ? $D[3] : 1);
    }arsort($ka);
    foreach ($ka
    as$_ => $H) {
        if (isset($rd[$_])) {
            $a = $_;
            break;
        }$_ = preg_replace('~-.*~', '', $_);
        if (! isset($ka[$_]) && isset($rd[$_])) {
            $a = $_;
            break;
        }
    }
}$Og = $_SESSION['translations'];
if ($_SESSION['translations_version'] != 4145859147) {
    $Og = [];
    $_SESSION['translations_version'] = 4145859147;
}function get_translations($qd)
{
    switch($qd) {
        case'en':$f = "A9D�y�@s:�G�(�ff�����	��:�S���a2\"1�..L'�I��m�#�s,�K��OP#I�@%9��i4�o2ύ���,9�%�P�b2��a��r\n2�NC�(�r4��1C`(�:Eb�9A�i:�&㙔�y��F��Y��\r�\n� 8Z�S=\$A����`�=�܌���0�\n��dF�	��n:Zΰ)��Q���mw����O��mfpQ�΂��q��a�į�#q��w7S�X3���=�O��ztR-�<����i��gKG4�n����r&r�\$-��Ӊ�����KX�9,�8�7�o��)�*���/�h��/Ȥ\n�9��8�Ⳉ�E\r�P�/�k��)��\\# ڵ����)jj8:�0�c�9�i}�QX@;�B#�I�\0x����C@�:�t���\$�~��8^�ㄵ�C ^(�ڳ��p̳�M�^�|�8�(Ʀ�k�Q+�;�:�hKN ����2c(�T1����0@�B�78o�J��C�:��rξ��6%�x�<�\r=�6�m�p:��ƀ٫ˌ3#�CR6#N)�4�#�u&�/���3�#;9tCX�4N`�;���#C\"�%5����£�\"�h�z7;_q�CcB����\n\"`@�Y��d��MTTR}W���y�#!�/�+|�QFN��yl@�2�J��_�(�\"��~b��h��(e �/���P�lB\r�Cx�3\r��P&E��*\r��d7(��NIQ�makw.�Iܵ���{9Z\r�l׶ԄI2^߉Fۛ/n��om���/c��4�\"�)̸�5��pAp5���Qjׯ�6��p��P*1n�}C�c�����K�s�Tr�1L�4�5M�p�8GQ��9N��QCt�z�{�FQԄGt)�Ҁ���:2�\\K��q�rP�B��ω\n�8|�D�eLi�3��֛Szqz@�:�w�{Oy�O�\$�\".�_\0><@��d�]�)�\$96th��a�u�#A�tSO��4A�ٺt��R�&bP�;�HCfd���7�Qt9an��2\$��B4\r+t�!\nQyo7稈0��G!�\$!@\$�g`�|\0���D@I�\$ƈ�, �o�;�3D4�2.eIa'Ɓ �f���nr�t��a�a�v��W��F��Jo11��\\���}Jf}y��ҙ�� LY�2RJ�i/7����a	�\$\r'2➒���@��\"ִ�c8(P�B]��/����M�Q\$��;��c#��j���e]�eWŦa��0atAH���U<OR����r:s���)�K�r��i(j�l��<Hpb��M�ˢpd�F\n��\0*��oK��B�↡I�tT�eAxO	��*�\0�B�ET�@�-9e�\rb���\rB(� C��];,k�����p	Ho5Dr����v\0T�Pf6Dȷ1<R�};�0���j���G�\r\"H��Ԕ�lYM�W�v�+@�(+ ��yϹ�3���5�af:�p�0�,g=�`��[ 	j���3�/{-��X�t����95�IF#�]%z�����UN�ڧ\n��D���ϕ%-w�2\n�U�z���ܒ��!6���R�B�?wa\0�*�1Ff��Zv�-��Qr��tx}�)�6��g��%j�P �0�&�~�rZ8M(���@E;g��`�C	/`�ExHL�ADٸ���!	�-.��BH�ݵ�'�Ӊ�)��	%�����6yz�.(3��^�loq��b�a,a��p^I�2��\\��X;)����BpG(z'��4�����<��q��H��\n\n�1�5E�A�\nK�@�2Q�/�qK�M1�G�\$ b�YB�Ceڐ���L�01d�����r\$F�,&)J��G���'�Q��n��bvg�Z�Z��t�lS^�Z�U��d�b�)��ᩥ��Ë\0��ۑsf���B�I��\n� ��U7)/�i�U�}��̭��_l���7�Od�5�N�(a5@4��Q�9�f�f�j�s�\nEL㆘#��8�z՚�cN��x_���d�@�����G��_1bdMq�S13c(hB���|W�w�O����!g@�v��i⡓�Ȏ�@iH �|���M�I����W{�l�>i.|������\\�I�.�U�{���\\L����|����5��E�C�X�D�YҦ%���ʕ\$}��n�z�+�FT����ݩѪ��������}�ϩ���s���z�Ȇa�U%�W�z��K��)��T�?g��L�Q�_u���F�s{3Y��;�6��>C\"Ri/)6<�V�8�(�<��q͏�dG��|3��_�\".��m��� `�PdS�!�6E�^fC\"�	� *º�;\"�߫�-+��Ͼ�Ƽ�z��Jvp(Tnx��qp��i��6\n�Z4�hY��7� �Qp*����9Pd���%\0�DE�D������e����s�NW��.*\rht�p���2���p���L#�~Æ�#\"�-���P��/l�lʥzV\0��j�����>��i�\r �\rmIͶ#�\r����/�(�\\�Hbo\0�\n���p<�\\.�Ɏ���Z�0��0� M}l ΂&<#0j+j��,4�����\r�`>�j/0`)��F���0Pp�m)�[��u� Ph��K<\$D#�B��D�'L[B��p�ގ�Se�+X�\rY\rj�m������	v�1�\no�Ѫ.q��m�@Kx4�Xf����z�+}�����qF�\r�.\$\0���� � ^���4�r�K\n�\"^�Q�'dp-��\"�0R@�\0��|�&\\�,91J5C0)��Q\$k`&e��i@�)�ԿC/�8�ZFBL�ɦ*L�'t�1���z�";
        break;
        case'ar':$f = "�C�P���l*�\r�,&\n�A���(J.��0Se\\�\r��b�@�0�,\nQ,l)���µ���A��j_1�C�M��e��S�\ng@�Og���X�DM�)��0��cA��n8�e*y#au4�� �Ir*;rS�U�dJ	}���*z�U�@��X;ai1l(n������[�y�d�u'c(��oF����e3�Nb���p2N�S��ӳ:LZ�z�P�\\b�u�.�[�Q`u	!��Jy��&2��(gT��SњM�x�5g5�K�K�¦����0ʀ(�7\rm8�7(�9\r�f\"7�^��pL\n7A�*�BP��<7cp�4���Y�+dHB&���O��̤��\\�<i���H��2�lk4�����ﲠƗ\ns W��HBƯ��(�z �>����%�t�\$(�R�\n�v�-��������R���0ӣ�et�@2�� ��k� ��4�x荶�I�#��C�X@0ѭӄ0�m(�4���0�ԃ����`@T@�2���D4���9�Ax^;؁p�D�pT3��(��m^9�xD��lҽC46�Q\0��|��%��[F��ڏ���t�wk��j�P���Ӭ� ��m~�s���Pi�����n�E���9\r�PΎ�\$ؠ#�����r��8#��:�Yc���(r�\"W�6Rc��6�+�)/w�I(J���'	j?��ɩ�U�H��E*�߂]Z\r�~�F�d�i�	�[�r�(�}���B6n66��61�#s�-��p@)�\"bԇ����d��l�1\\��]�����1K���ű�\"�J\\�n����S_7k����!��ٖN;�^��qj��Z��1̃Ň�W4O=7x�\" ��&��B9�`�4�J7��0�E��µɺ��ț�B���\\p����MS�6n\r�x��u��9}c�OP �,d(��M�(`���r,�\0C\naH#B��#\rO�9E�N\nS�-�����L��il]I��B���F0��9��\0�Q�Y��Ɨ��)�@�o'اC8 Q+ ƈP�dQ��Ыur���X+\rb�x�����Y��G!@踖�>�����E�S��{�%���6aW΍u���Yz{�����ɘMT��#-櫕��4�p�b��W\n�^+倰� wX� 7 `\\��j�Chu���Hm�6��������T��kCk[�L8 g�-�Au\"T���&���'��fA�S1��N�b4�9DYjƃf��Q�H�����@��ޛI�F���KK`��ÙO'n�<��_��%c��9��a\n�89B&~�\rt�\\�P��VSQ3h�R�8Χ���5���V4����7�ELN\0��qOx�v�st��%(�P�\n��6U�6j�9�7\0�!�[��8@�Y#֛��1��\nC:��{V�U)3f��C��Q�M,�<b�QJ9�9h���V�9�\$�6=!fH�y3�44��N��(n���٫p��C��� 6ĩH�*�o�R�jf�M�j!��=�xS\n�,���\\�	�~Gia���v�\n!&�%�Z�2��y�q�}�����Z;:�j]������0�(��gl[t@����u?X�{o��3R�@kU\0F\n�AO�(,���Vp��cH��i�N%TV�pBjJO�ٵ���\0U\n �@��x �&\\,��x?d��bx\\Oᆨ)A�S�h����9Bؠ�M��Yvdv����䊭`�#��||\\� �xG��<2�\\�A�n>��3Q�3���X��Ѥ�^��%��t^%��N;;�2�FOx��1�Dΐ��m%�ڊe�Kuv-9<`�\\BzRMh\\K�TA�#�\$���\n �Aݾ�1�[��\r��A���}�bs�j9���h`\n.\na�=3�G,�C>\na���j\\��(R*FO���Xѭ�݅��JK!���ݧ\"����چ?km�p�DsJ�k�lg�S%(��<���Pk�>��rw��&�Jd�گ�nAb�9O��\nĠQH������R�S�2\r@�\\c����<Ih�%\$�� T!\$.��J�z��J\n`n� )�e�F��x������cY!������)=��=�x^b���*��DT{���1ʣ2����. �����J���FW\"d�?��;��A,u4�B!�5�&v˭��kx綸�whzd\"/����Ң���q�F>O�'�%I��:L�BI��*��iqA���%�]�Ǵ��19.0d|Td3��1AR�=��p�4!At�4����H)�\0�T*��O8(n|�B�d�{�:�JB���\r2�?�F5�������a���&�a�r���N�-�撚�����>�a���;���'��L`��;ri��dK��.z�b�-�lH������(d������:�|?�ǆD��R�����B*-�ڪ�Ȃ�%m��m�(,Fd\0@�Ţ\$��ğ\0O��̜t���e��H�BB��O�>#�Xt��\n'Pʏ���	��g���d`��q0�O�N,�Kj.w���P��++n�d�������M/�)nb�8ݯr8��\"��<��f�\"y�\r�]��\0���(��41�8E-!�����HB�#	�>/�P�/\\/e�0o\\��f�d�d*�e�:�n����?�|�NܐF�d��L���+��(>��fg2���j<����B&�\r��\0���#����ܣ�m,h��*@&0���\r��q]��{��]Al��sc!� ,�\"aW������R&��3\0�6O22��o#1�\$HD_b&rF���K�P9c�`\$�]��%�\"���]�1!\r\"��\"�rvb �5'P�'��'�j���R��p+&� �02�*r��L��GrdJ���˯�O\r���|p��,�#Rw��k�_)2�k��\$r�w��lLPF�!\"&�'�r����-0i0�:K��#��0�k��q��'c��쌔eL�>p��mG}������RƲYr{�\\�O~r��d�15-�٢&��2��D�낐;�2�G�\r�V�`�`�CTtg�x}\0�����Uf��\r��RjȀ �\n���pBh�:����v�B��pHmb:c�\$o����a��dP	��:��aNzq\$���J�@��t2\r�\0E\$L{A�!K0\"�Bf	�޼Ŵ�#r8/Cs�=��%*���-��!�/�Xj�/,\"rxg-��*�,Lw(\r`0C	!�J0G	�\0�cG�B�f4CH�`�Y�0�QM��D���F��p�.E�+m�_bl���Ht�dB&�lq��Bl��B��kPqMG���#�WE�@�S ���y�Q2瘙DP8�l��:OL�j��y3���0����`F,�GuH3^�̞*�CL��G`�FB	\0�@�	�t\n`�";
        break;
        case'bg':$f = "�P�\r�E�@4�!Awh�Z(&��~\n��fa��N�`���D��4���\"�]4\r;Ae2��a�������.a���rp��@ד�|.W.X4��FP�����\$�hR�s���}@�Зp�Д�B�4�sE�΢7f�&E�,��i�X\nFC1��l7c��MEo)_G����_<�Gӭ}���,k놊qPX�}F�+9���7i��Z贚i�Q��_a���Z��*�n^���S��9���Y�V��~�]�X\\R�6���}�j�}	�l�4�v��=��3	�\0�@D|�¤���[�����^]#�s.�3d\0*��X�7��p@2�C��9(� �9�#�2�pA��tcƣ�n9G�8�:�p�4��3����Jn��<���(�5\n��Kz\0��+��+0�KX��e�>I�J���L�H��/sP�9����K�<h�T �<p(�h���.J*��p�!��S4�&�\n��<�����J��6�#tP�x�Dc�::��WY#�W��p�5`�:F#��H�4\r�p0�;�c X��9�0z\r��8a�^��H\\0��LPEc8_\"����iڡxD��lWU#4V6�r@��|��.Jb�BN���]0�Pl�8���M�'��l�<��8�ݴ�N�<���+Œد�z��B��9\r�HΏ�\"�-(�������J�䧍�_N��ݝK(B>H;h���L��|A�M\\��Ԑ�1�\n���IbU�9%��\r�M�݆���ڊ��#���|ՌL\"��\$ۛ\0��S�H�m��4�G��:ں|̙MS�\"��#�����D�)��+���� r�>�)��I��-�+�e�N���☢&!��Ɣ�L���2���LvT����P���Kb����Ƚ�y��=q��-�,�*%�����s��M|�eJ�v.�͹�C&��:1�	�\$��!�8�,��9:<	eB�SZL��HBϞ>����RlD�������'�\0��ۉ\n.(i�7��V#(lƘ��VNI\n\$�T�&�rO�>Ќ��%6�V�^�-9C�c����F��2FV�p	P ���\n�F/1%0Dǋ��:��+)ȳ4\\;�/�H�-#\r,D*3��hV!�b�`��X!�/�D���h�k�%�5���)%*	�;�uB_hn����Pv����hZI=Àj\"9z �(����@aD(��\$\0�U��U\n�9-pƒR8dUkd-����\n�\\��t�uֻf��K�z*�t2�ӹ����*�(�@IN��9�Q��E5#II�B*quAIpJ��l�ܞO�	&T|U\$D�\rA���䑳'��nM弸�\\ˡu.ɦ�׊�\r��!�T��W��A�X�S��>H&�SE��	(�2��5ᡛ}��E)Ïh�p3������4����R�^��S��\\��pЍ��I �d���4�f���уfH�\09�Ut�0u��7�uS]Ph-#\n�ܛA�x��aÀ\r�7���Y�zPԼ&�U��ЫGx�EР��Rv��9�R�An%�T�<�(�\ni%U9௬�oZ�4�`Ҍ�=Z\n�\"�@�VvD��%���㽮Pe��[R�,�Q1�o����P���kE]�e/�n9h-%��0w\r�1�%P�\rxF�\0001��K�F?e\$���i<�-�O�q������P\r���;gm7�E��\\[Ҹ��\rJ�(�\"��<0�)�c��N����i.�Q�D�*��t�`+20�,���o��������R�,o����A�ei^��\0�C���a<��'��9+Q����Y�4�_�D��G ��2W�Ԧ�G�\$�t�Mot������	�t-d��d��-�҅v#��� !��&m���b�J�8�x�_\"?j͛�I���<~�\n��>�����jee�ӽ��(��T)�ةأ��j�@OJ�����r'	���N��<�0��;��VuaTފ�os@r���iaM��@X\$��bp�Jge/#��D�9�T���cުn��)v��uᏏ�8�Bo��<�Ԏɣ�q���S6k�����7I,R��Rx��)?\r :�|k%�{si\$��M'D�9GhH�Kx�eb��rҺ��P��#��֘��qЁ�<�<�Ɔߌ;��C�1!�*CG���2g�`ʞ��ր�ݖɣX�l��ub��O7uz�^~>�X�'��'.L�����׿�>ڤ���o�wq�w*ȣr�D�S���_)�ݰ���D��oA|LO�k�c�r�Mv�)^q �;��ȑ��Lo:�RN{�;�N�xv��T4�}�HB�T!\$\0�Q@iU�n]�ެ�*�V��5�2Pa��\ra�i�^0hÌ��Ez��>,�\0������IH'\"�Z�p,�ʼ+�:�0\"K��Ǥ,�l<��a�6G`/D+�@,<� 9��7��!m���Z�*(���p'0��J��\0N��\$�g�L�ː�	�J6%�ĵ���fN튫bj�C�-rQ(���Ѕ�����-Pg�R�,�.!</\rl%�pO��gI\\-\"G��	а%�[��N��o�3� ��؅\0z�VH��bq0������2;M�3����߯�R�6���Χ6@Bj���B��M��\n��T�d�B���k����J�OT��1.���,�P+�n|.fڎ<��:�Mq�ҧ�ut=1��?��*�l�������#���.'@���y�f�J��Ǉ�m�nE��������P�����Tz\"�d�rТr'[\$�����\$��Nn3r �p���1���\n?!�7B��,i&�0jj�+��`+�(�`2J\$�q�䦛���9B�*��*�J�q�����00g�������Ș�h� *��2���+1Ω�x��}�v�Bp3�0�2�/�9-\"�@�����et?0�&pC,��%1,1ke�m2\n�c�&�0�>�3 �b��ʷ��+c�R�ޓe��,�v���E	7q�/���R*2��f�)&�&�NlO>B��'�q&2�c|���:�Zu�@s�l�R�Z�P���͖�?(�j�3�x��3���=P���xϳ��r�8B�8� vq����B&r�J|OP�F������R�3{6��ks\0�P��_t0�So+�����4A+S�.�t�2�o(d-CÎ~�,6�j��}/��D��E���{q�T3�z�(-HTr��}Ee-9iuAoN��eF�t4^�Tb����+P��f&��jf�:arS0C��S�-��6J�;d����SHoSMB8�G5�1�OOaB�<�2y�\0�s#Oi�I��92�.���]\rg�#��u*��1@�O3\$R����h6��q?�-RP�4uTrJ+��b���+j*��	O�F�ux��\r/��I[X�_W�kH��R4Yt�S�\n��F�aU�N5���3X'cT��w��P��QAZ�n�\\�ة�9W��CP�^-h���е�t�9U��\"�}uEOb?�� ���&��]�q	-�2Gn4s�Ip�C61�qr�c�Ap.&��l?��	1rl��ޖL��f���	S[cГ%�s-1�����3F�(�����b�:bb��l�(rrD +h��)]u�Q-2.\"�\n3<��/J�株\n���p��^�Bna�3-]����bb����v�\n���m`�Q)e)������ć���y �~p�|S�RÂ�&CjSR�u6?�v˲�{)'@Es�4��ET�S�.��^N��K�K��\\��9v�qp%v�m�^�/\"R\n�B�0c�2��J0igW/�@���-3drtt�`4�|���6���d�xިh��{��z��''Ƶc�p���̵}W�z�D��]p��zuZ�7�|h�G	�׉E����@�Qth�/gN�B8�+ƃ����\$N�O.�)&s*',qL�Vs�e&�7(侗%\n��e��V�(�n�)BH���ܢZ�8�F�l@���v5*I�\\�Q7�*��Hy{4�3a|��Um\"�0����x��x�0��}�b���T0�!%Nt��Ȏ0U�w�A�pj�";
        break;
        case'bn':$f = "�S)\nt]\0_� 	XD)L��@�4l5���BQp�� 9��\n��\0��,��h�SE�0�b�a%�. �H�\0��.b��2n��D�e*�D��M���,OJÐ��v����х\$:IK��g5U4�L�	Nd!u>�&������a\\�@'Jx��S���4�P�D�����z�.S��E<�OS���kb�O�af�hb�\0�B���r��)����Q��W��E�{K��PP~�9\\��l*�_W	��7��ɼ� 4N�Q�� 8�'cI��g2��O9��d0�<�CA��:#ܺ�%3��5�!n�nJ�mk����,q���@ᭋ�(n+L�9�x���k�I��2�L\0I��#Vܦ�#`�������B��4��:�� �,X���2����,(_)��7*�\n�p���p@2�C��9.�#�\0�ˋ�7�ct��.A�>����7cH�B@����G�CwF0;IF���~�#�5@��RS�z+	,��;1�O#(��w0��cG�l-�ъ����v���MYL/q���)jب�hmb0�\n�P��z��-����L��ѥ*�Sђ\n^S[�̐ ��l�6 ����x�>Ä�{�#��вh@0�/�0�o �4�����a��7��`@`�@�2���D4���9�Ax^;�p�v���3��(���&9�xD��l��I�4�6�40��}D�w)c���8�\"��ej}�PF�5�S4�|��4��/�_B�V���@�����U3��+ڳp�Aw%9Z�� +�#��&�J2!�˵�<#T�z��@�ˣs�O3�R{{F�r�Q��]�PM����.� �\n��B&80��e�;#`�2��V�����P�-�:'�sh;�k��?�U����&��6�R���/��\\N*�C�V����UW�]���},���@�mܐ1��h�U�}�+^��3�\r��=�\0�CrI\n!0�\$����lG�\0ћ4N��S݀B�\n>L�*�C�|�7R�� *#9�U��cwv��UFu�nu��D� :\\�%�-5�[�F-j6?�PQ\"Ynf���p�y�,-I̔�6��,j�\nا����|�L�Ģe�,Y-�(\"'�F#c�D�=� wN��<��3`ػ�J� �S,(�y�h��<�\0���`���\0��:LlX:)JC8aI��]�e����������<Q��!�0����5������1+jk��������hSI�=P�n��3���b���xS1�hA�S0�d�M�X1�u\n�<m���B��+'e,��2����/^I�:4ft��EI�!�(�[���6������qk�ܠ�So=;�sl���5iJ3T��~��5lI�&��K�����Ǚ\"d���vT�rl̽��5��*�gL�\$���{�k2��'`A\\Xk�>��0����Âl�uʓw�<�E ��A���UA)sj\"S\$�l��h<����p@��dG���)�\\\\�a�!|J��+ ���)�����f�\0a� �1�*�^(sQ'I���VTc�J�-u��xt�\0P	AOX�L�Tye �\\�or�\0(.@��Nd��&\\�ɘ����c��\n����{Oxer�9C�����!�;ߥg��t��-��DQ��M�\0�0@��W��MG���0X�Kf�@;���+�i�Z;ny �ua3ӥ@XQٚ��+-7OP,�-��G��\n��j\$�Q�X�6bJS]��Mb1��Q[�51� �\rev�f��;��[�DA\$�����CK�<�݄���O�/9�p̛�m\0��&��+�M����(�&�J���(�t0{EW+B�gJ�hQG��aPP�W�mO1EB�Y�z�Wv�H��diC�̎�fx���������V��n*N\r�\0�~�`�*]H0�Mn_r�?h@�pzb�A�H�ұa�dH�j��'\"�k�|��2F:�ޛ���{4_�*ad�e�&�:t%<������n�H�r�y\0���)8K�[.j#u�C�w�)��臚��r��Ň�s�Y�V��pV�nb2Nc���<���S���8��~�QM��8��[����&�Dj�v>�����4�3&=�+I�yT�������ɫ���r�e��x����Ңu�:N�Y>�+�v�t����o�^d���88������QZ�Jr-'�����k����9���\0-��1Η9�HiO\"�����e=���=��Ғ�L���\\	/�܁��ݱ�M��%.��Oܞ�����tn����)�S����L,�~nÖ׸���vQN��� C�Q�?X�/����:Ą�ņ��J��}�����\$!b���v�f��h�t���B�G��Y�)O���3ɨQo�N���X'��(��mPk �\n�� �	\0@�d�\r%�L_\0࿃��k��2�g\n)��(�Cr�^6r\n�~r���>lϲvBb���F���k��ʂ���P�YHW����0��	�H(=���0`��g���(��:��{���`�I���ʮ~�P���\$Wn�P�֥`��p\"N\0/#و90���@��D������o�Β(��h6��3L�pN�#�.��1[F��c�f����o�k ��&��BJ��-���,/<��[Ѷn��&N��H��� T+	� ~+�jX��(�Y�����(D�g&�d��q��F�/NF�D��*��1L�i�p�E\\�`݆�2ll-��5N��P:��:l�\"��ɯ08��Q�\$b&����̕�NVY�r���1.o����Q����p��v���6�������jQ�npn^�Qz0�����i��vk��N�JNU(�*2�#���V�����mr�*R�(��2\0p�H�-��.2�.lx�q>tPJQ�����V�.}�M��N�5.����'h�׮�ȾZ&Q�)3�LV1ER�GL�\\�i�����ҷ.�c.�f{�A0���Srpw�V��\\ߠ@\n심��)Y�o6�B���3R-�e0�����e�6u'q4t,�B�<3�3�<ȵ0���>�>GGS�6�'7ң*�?R��7+S��.�T�����0=з9�js��\r�r����C>V7��<#\r4&�#uB�9��Cp)C��R�\r\r(�;r��s�@�WGb��/���y��@s�B�H��CZ�p_�SH��<e}H�~7!E�fQ��-Ҟt\nZ��k�u?�@���BF�o�ZLE��T��4�n߲��K�Ah��t���Lt��1�\n*\"f����4n�<�.;>8�ڲ�r��>!��H�}\$��P�m�2��N�dy+/S9e�+��������T�D#�=�K�z��{;��;�AJuX���sQ4�Y�@�yY��KioQ��-2YOMET��B��`s5~�.XU����[�)[(G]՛\\ЗRu�]��~��k�]U�G��L�D��c4tkSn�{�6|���-�L .�Y��T,�q���hQ�)D誁KA��0��YtsZ�w�Rk�aI��=��^�fTk��^�qZ��JC�zVh8R�I�A[vA�Q�`Q�9d6�7��%��g��[O�b6�#����0ӡh~����؞�%����\0�N\\�(5�gV����c�k_��h6_ht�eo�`��A�.P��]�m6�p�q6�Z(�k��_H�[�<H�\$�T\\6�g6aK�X-��j�m_էq��_	;��g�\rq��oP�5%A2DƵ!P�`p,�)�\nt]S�25n�*eC.�F��)G^wkw�Z)�k51��oL1)�{1{E^׾��W�R*,�u�Y�E�S*��{u�r�-|R�*��+\"	|g�C��hR�@����m\r �\rd�MFx��?iD\r��\r ̔�.���\0��E���v\n���Z�>I��5\r\n�/Fb\"0(�w�pW�p����+�c|�CXv�#g3�݈N~������t|A�0(��Sd	�=�\0�b���6-rq\0����8Vf�o�.0U�׌��L\"��ɐ��c��`��� g�6`�\0Yeg�L��L��P�5B6�o�DA6��Bѱ �xR���JC�D����0��%����[��w�����8�j�S�d��ߖ��7vWuR�u�j\n��>C�<lZ�dO�ࣥ��'�oOU�t�C��Q��+y}12�|b\0|��]A<(�Wt�m�%k��e�)M�b�����᮳:GVR��6V�q\"��d\n����\r�d8�=u�H��keJ�܅�b���Kg�/� \"�(�K>b��V��<�XU��S9\\�Ya��U6�X��i�k�6/c�`0o�VT8{�Ebv4��q��	\0t	��@�\n`";
        break;
        case'bs':$f = "D0�\r����e��L�S���?	E�34S6MƨA��t7��p�tp@u9���x�N0���V\"d7����dp���؈�L�A�H�a)̅.�RL��	�p7���L�X\nFC1��l7AG���n7���(U�l�����b��eēѴ�>4����)�y��FY��\n,�΢A�f �-�����e3�Nw�|��H�\r�]�ŧ��43�X�ݣw��A!�D��6e�o7�Y>9���q�\$���iM�pV�tb�q\$�٤�\n%���LIT�k���)�乪\r��ӄ\nh@����n�@�D2�8�9�#|&�\n�������:����#�`&>n���!���2��`�(�R6���f9>��(c[Z4��br����܀�\n@�\$��,\n�hԣ4cS=�##�J8��4	\n\n:�\n��:�1�P��6����0�h@�4�L��&O��`@ #C&3��:����x�K������r�3��p^8P4�2��\r����˘ڏ£px�!�=/��	&��(��	�_;1��5��`�6:4���3��%�i.��l���p�� ���\$��\n���\"2b:!-�y\rK��{�wk!\r�*\r#�z�\r��x ��\0Zѭ�J��0�:��c-��%z�B0���l;�'�	�4�Xl�f0����5�8ɖ\nq�H�+�H�\rC�j��j1Ƣ �c���4�Z^K-\"�[&�h�4�6�\r;�׭:.(����#ː��	L���%��j�C�7`/�N㹸�H�6��5ejo��g�����'I\"\"r��B�v=<��r��+c���6~�&q�\"!CMx�d�x̳wR7��2�%�~o-ʃ{[Y���O	��|�3c���t4g�f\n��w�A/�(P9�)p�2��;��b��#l�x\\J*˶�O�r������%ªR2�*7���3��տbN��8 K�|��`ƅ���L* �(��Ԋ�R�\\;��6��rT\n���腕H>����urK���\$<�D�	2)\rdeC%��A�+�\\d���A�\n�j	B����}pQE1X.���R�aM@��anT(D�!HP���>	-pӰ����5h�48�X��z�M������	pM.d}٪�MS�q���6�\"6��&�N~��l\r�ī���c�a�!3�h��\$�,�M=�\"�@s&03&wXHi.�̗��N�5	̘���d`�#A�4>���4�1d�F�pCB�X1�D�H\rt4��ԯ�\rY�L��M���{�X����&O\$�T�L⚸h��ԕ�7h�,M��1���|��rՋ��\\�\\[~?d�Y��(��a^(u19�zs�b�eO�A4BoN��A���P�f�8i^�6'�ܼ\r��2a�:�����!�jq0�#�-Iby��R�.d�	� �@'�0����,�q\0�W�W\"xI���bfMi� Ds�g��1\n!��Z�آ�\r%3%��R��tfp\$)�G�i�A� !*M�qZ�sM���Ԙ��ٹe����HS-�؍�FVtxNT(@�( ����ɚ�Kdl0��lA\0D�0\"ۋuor1�h\n�\\b`�#�`!��9˰�AmFE�4����xpjgA�4\n���XhœC@@C:��gY__t��a�1/|�9�X�]`t�\\!�4���uG��O�<���-���L7���5\nqBY��ӄ�e�П�E���]�݄����U��ͅ	�4V	)��b@�B\n�o�6��������X�F�xQЛMq칒�ы��=�\"�B�]���4��;�5�e2��#'����� jz�v�1�4��7��n���q3F ���ێ���1:=� G�TJ�����JM�!VD|&�/*�7l�_2<�Iz��h���nC	\0��+���ZgM6jx4W�(J�'5��g�`^y�2��i��-��	����G�C'R1�����8����v���c�T����^�;�F���;wPnC���@���/��<��p��E���	\$7��dp�=d�g8&��'��]�Ƕ���l���5�yB|�D#or����分���Pa�a�브Z��T�HO*���BI��F)���sug��I#�Sd�ie\\�(b�����J:?\\Y�j��e~]-���NF��U�z�J�w=���A�>Ih:\\r�|�I����'c=�a�zȟ�/��'�'�Ysu�W�'/C\r��a2���T����y���}_��^��벷��+z���k��,�\$2���^S�#�g!��Vұ��k��7耠���'��9֏�\$aY1�!�a��4���  �24��O�4kEX&�y_�?\0������-��H��_�*II ��0m�E\0�H�O\"��\ng ��K�'N\0�@���~�M����\r��L��2�����L���0E�M��\\�L�\r\n�L`�F�'����E�(p���pz���P��2m��:�J'��`!ZJ�6fc蟢@�#�T��B�� 0�q��Ϻh� ��.b��Ԑb\nSI�V�@\$nH��̟ ��m�2�0� 0�u/�1\rR���\rŞg,�^�\"|��[0��i���8�J4���Q*�&bgc��1=P�qV���T�QE\n\r�\$�-Xs�Kq`7�r���>�\"�,�\0�ș)x�#��KOK/P%�MЏi���%�yH0���-�P2���G�Q�jQ�Z��N�+�Db>�P���#�X�1\\	�.81�'�3 M1	����Ҳ�'%����Ϯd�LrQxg����k�%�F6�K�9�\\HRH=М�0�	\r�p����*L1+�'0(z��L���\$�\r�(n��\"O(��	�?�R��(����k��E�MB^�fc~zÐ\\�1q*���b���)&ڒ��=-�p���F`�hw&M8������\\� z�PM�\0�@�\n���pA(�����h�)�\r�2�T���>2��3�{дZ�6��Tc��t�Y�'�`�\"�1/Z�#%\" �:���c6\\o����>����̖hp\r����F��9��G�}��j��F\r�n�2ԏT�Rڟ�<X�ğ3�%s�\0\0��Ɔw�=�T`S�3����T��*�s�@��0�&�\\q'>�	Ų1*0e��i6CVpv�k����k��ƚ(���B0\r��q�C\rK�j� ��@��H�T�'���}��#�@g1J��<-� 2k�7���!l4nӤJ�d�~1K�?#\nD�ML�\n��j��DM\"b�`�";
        break;
        case'ca':$f = "E9�j���e3�NC�P�\\33A�D�i��s9�LF�(��d5M�C	�@e6Ɠ���r����d�`g�I�hp��L�9��Q*�K��5L� ��S,�W-��\r��<�e4�&\"�P�b2��a��r\n1e��y��g4��&�Q:�h4�\rC�� �M���Xa����+�����\\>R��LK&��v������3��é�pt��0Y\$l�1\"P� ���d��\$�Ě`o9>U��^y�==��\n)�n�+Oo���M|���*��u���Nr9]x�&�����:��*!���p�\r#{\$��h�����h��nx8���	�c��C\"� P�2�(�2�F2�\"�^���*�8�9��@!��x��� !H�Ꞝ(�Ȓ7\r#Қ1h2���e��-�2�V��#s�:BțL�4r�+c�ڢÔ�0�c�7��y\r�#��`��N�\\�9����h42�0z\r��8a�^��\\�͉x\\���{��]9�xD���jꎯ#2�=�px�!�c#���O�&��0@6�^:�c��Y�rV���\\��}�*�	�Ų�*QL�P��ʓ�2��\0�<�\0M�{_��6�j�\n�H��qjG!Jc(�\$h��:=�1��(�0�S�콎�,�b��s #\$Y+%4����0��^I�� ��8�7�#`�7�}`�2��7(�p�a����&A�ŭz��KqM64�e�@��3\n7Z����&.��E(�7�,�H<y'BPͲ4�rŢ9�� !���D��Ҁp)��n�����B�Zס�&��� \"��=��5�s����YB �3�0\r�xѴ�*:7��4E38\n�L֫ *\r��}\$�	�<�c3g���%HE��<3�+ˌ�_sf&2��R��[�b��#{��pA�VBh�5�*NU�يE9�0ܙ��bxg�2�g�`ϑWD���@��(rR��bL���R�eM��>�C��Me�S*�T�z9/J� }���W���4�F��+��4�\$6���{�U+� Z��iz&!5#��L�H¯^�&\"G�T�\"S\niN)�@��\$,&�U��FPr�V�P8� !�>?��(u��	�a}G9\0���:/`�����BL�'B���~��<@A�����\r!�%!���h&P��a�Y9�0����{����GJ!B3qy3�vs\"�<n;Iq/�fL!�q�p��\$&�\0P	@���� D���E���B���l�[�6�z�\"\n\n�oN��7�y؄%�nJ��w���(��`�ݴOh�jz{��\\�!Ur�P�\0001��j]���72�ͱ���9�Ql�?�⅛A:�6��\nEd� a�=3�B�LBI&�o/T▚D��Q��T~il�T0�6~ݍ��U���\$�l��O\naP�%��O��4e����)��K\nϪ��=��[�1�Qj��?K�q+!1+&*n���cy��7�����ime!���@���L�Ԟ�)	Q�BZF��\$3%��eB�������O	��*�\0�B�El��\"P�m�;)�e�d�-j�(92���!\$�p�6P�ʐ�A� ꒓�vNr�w)�ڬ�xM�<&���P����%��Cx)\neNw��V�\n�s�(k\ru�fL�oM�C.��^%���\"\\<�4�E�PVE\r�\nH��/���G��z�AS ���5\n�	��\r��чqMf�a�\$KKi��^\n�rf\0��6��bNY�x�<�R+K�;����7�����!����#� �3.�2�+ -2�7#!t��i\$Fϒ�>��\ruc��9]�ls����؏�����ab�1�{Dv��7d��\r�����b�������0\$Qy�![\0�BH����'u<S�@�{����_]��lt�/�^j�v&�2����v&�n���������.�ВGu ���&�}��@\\R!�ׅv�q��c���Cc���AU�n�	�{Id��YA;��Y��7���s�����N��ۉڛ.���őܪl��L��%?!��D�9W)D��N=>�)�XjG6�Q3��*���#rn��1I+(�4p�g�bs�Y~V�Jֈ���9���0�B�N�nb>��>������F\"�^`�s-P��4;�|�=%Z��_\nD�Y��Ž�;H��tL�/����&z�یֲ<}�se�@f��`0��,��a/�������B�b�#	3���[��Z��\"�TH`F6J�;Dɠr\$ە\$�]c��=n�����oҗT3�/��۽k2l��4�G�5��|�C?O��:�@R�{�p�>k\0:��~�c�ȣ�?�\\}W�_\"]�_�꿋y��oy9�O�p�\$�\"�6� M0/M�ݧd#��\\��/�a�\$�����`@�\$0��\$Co����g ��8�Ȍ�O��'��0Uo3�O�	�\"g�L�\0.�b>�J\"�L>2f�%%x9C�`��R\rt��ZF��DzZG�//��\$:��� �*%㴟i��x�DF��!�����0���L�\\M,�9L��Хm� [�H�pF����O�쬟J�%����n�Z-8�������������of��*Hg\n�@�ll;M��\nPP湭����}kH��\\\$�\"�1&�.D��������-h���&�����(�OC��I���s�L�,��`��d\\�-*��\$�N�l�?Q/���\n����ϑ���C�t�'��\n�hS�?q�Q&G�.�Q;!H\0���I!��H�n�-dU\$Ь�v}O�Ce�NE�b���\$�-�L[\$��OB0\"��d͂�(\$��2]�_o\n\$m��\n�!�L�n�Ӣb�B\np��E��j�J��p�>��Q�g�sjG�䔊\n���ZxcO����;%�ؒ�%��s��.���0�8�� �HX���ͦ�-,%^�)�1��=�D����1m��2�!�L*�c��Ơ��lmnD-c�\n`bp���`�䙦s��ٍ���h��\ro(6E�������AN�s�Ǔ�.�����7��0�+�k��v7�\n0cP�G֚��&̀~�>q'`��C�\0_�f(���3�:��bdj/�j�;��>��ji��2�\0U�g��!FD�,z�M�`+�<.�M\"�2#��\"_���  9l�8�W*��v����8�A8��3���>.���El��xd��	\0�@�	�t\n`�";
        break;
        case'cs':$f = "O8�'c!�~\n��fa�N2�\r�C2i6�Q��h90�'Hi��b7����i��i6ȍ���A;͆Y��@v2�\r&�y�Hs�JGQ�8%9��e:L�:e2���Zt�@\nFC1��l7AP��4T�ت�;j\nb�dWeH��a1M��̬���N���e���^/J��-{�J�p�lP���D��le2b��c��u:F���\r��bʻ�P��77��LDn�[?j1F��7�����I61T7r���{�F�E3i����Ǔ^0�b�b���p@c4{�2�ф֊�â�9��C�����<@Cp���Ҡ�����:4���2�F!��c`��h�6���0���#h�CJz94�P�2��l.9\r0�<��R6�c(�N{��@C`\$��5��\n��4;��ގp�%�.��8K�D�'���2\r�����C\"\$��ɻ.V�c�@5��f��!\0��D��\0xߤ(��C@�:�t��D3��%#8^1�ax�c�R2��ɬ6F�2R�i�x�!�V+4�CDb���<� 襍mz�\nx�6��sz�L\rE�m[�+zٰCXꇵo\n\$�?�`�9]�r��P�5�M�}_���|�W�蹼h��8�*Y P�����L�B`�	#p�9���Ŋ�z�[I����z��YLX�:��\\7���\0��C�E�CCX�2���\$��+#2�-6	��\"\"H�A�@��K���_0�Կ0Lf)�\"d�L����e�(�?�l���vݺ�ك�ܶ��H�+�:'2�4p���H���-�HB���Ȓ6�lX�<s�?���+jre@P�d�oD&�J3<3��2�bx�7LL�����\r�hЍ\"WP湄d�0�\r5\"=y�Sb>�Z����76\r�ᦾ2}��[��z�/�z���죞ߺ;{��č���|���<���uy�趴��\nq��=�4����_/���\"���4�����@R��;��v��\nW��6�&.�k�w��A\"n��Lh;.eQ+j���=�~D���b��9�4�T��Q��K��6�T��Tj�+*�䪕`/���@��>M�\\9�H�*�X�t�2br��ULq�����T�LTΑ�~QI�(��(BZQ�j\"4D��(�Bu\$2pDP�-)X����T\n�;�EL��4hU�e�0ܭU��������B�L�\"`�7�`�\$QBN�s��=����S~�����*I[[Wf�������]GSHv��(�p=7�M#��j�I�E\"#�q�������҅��^���R-�|>�m5#a|^�z8	蔜hD~\0P	@P�+h|�@�D�D�R�������F(g�̚y�+�C���t���=.�l֞r.��:��w�b &�PK��#�h:)�SH�E<�Rx��G� D�!����\"�8����8L�UDN0��W9�N��,N�� �\$(�rR������=R�6��\n*\"(OpEUNT�P���g.�_�s(^����^9@0g�(�*Y�L�8 ���^儑�,���Qpf\r!�:�1=�K Z��d�3PC[&\r���NU����H(�E_�ho��*RC~L��\$������XC\r!��k\\�]�f��#���[ѥ4�a/���w	�n\"�f��nD�y�~�ڠ�j�0�\$g��5�;'lV��V١&\$�������q��P��B�|����v�Cᨔ�[�QU�d�;L\\Ʌ=��\"%�Ts�C�:.�*��s�r0�K�\r����V�p<e���d�}J�:�U�R*II�e)eECOAB�Ji�\r��>��^'���Ш�%�(E�:�#I�1a=W<��{�%��%��~��|}��2.6~��#c�<bu���\"6ֈ�-E��PC} (-8���IͿ���\nӈ��\0g�+샎��^�I����FD�q�d�ey�: ��d�������Ȣ����ˣ7�D�%��#.=vt*@��AW�䚍��w86	�`�\"5������/+��#�0��̳l��r ��E�m�> ���r�]JGV��`��-�x6���9]�弾\"�M��Xl�<�n�U�3�G��D*��r٘�&����;F%΄Q�+�oP���`[B�h��S�una�bC�_�ɷL��˺Ww�]븧���;�C�]�fur*t�QN����BG�;*��)u��0H�d��d��T*�j��F؄q2�u�U.�r�s�;�RQ��G�I��)�*�\n�M?����~~Y�C/���}~F&Ja����{�'ԍ���SrH����^������)��M����~�~�T��-��T?q?7��h�h���z ��%���b�.�4���ȭ�@�JR�L2A�]Fi�7�\n�fJd��fV���Fm@Zl�7�� �[@�4�����'g*��x�gl6\"pj\r��	Xe�f�b��.j�n�4��b�B���a��\0P�lD?�R!�(�쬾���Ls/�D����\0�dO���ƫp�u� �b=\rP�\r�D{��-� bt=\0�̃P����A���ź[�r�x����P� PD�#��0\rΜ�GT玥��#k\0^�@��CJ�8�N��+�������0\0�J�1bّf8�m1u\r��j���'����ަ/E*#1����WhjfT&!Z(��K�P�ڄpF\"#��}1����9���l��\nR�l�Ex\r�hE-�<�v'��T+/��Q�K����l�؍�1lP8�a�\\Ց�g�m�s2+\"Q�\r�GD�e��e�\n�����20�\n0�N#)1\00012�RLޒc\r����[.n�r^޲Bq@@�~ң�8����&wf	d\0�p<\\lv�\r<eC�e��1#Qo�[+QC���A�#̶���!`@��j9��	�K�]m�\$BI-�l�r�I�,��� �>1�/�\"L��N�%r4��Q��S�Х2�.M�2��.�3m�C�E��&�tI�H��\0r�\$�߳S\"q5��5��/�#�����A\"?��uCЭ�����L�p��`9	�9H���6��ʀS�#S�4s�e�s;���#(r=�l@�d#�9c#9�:�l���b�ӥ>&��1�De?\n�#CW?n�?�:�a^�%�\r�V;i�ȉ���R%�IJ*?6ARz���1֛&L��af�oBe@�\n���p���\n}S�?�\0�4dCb�17>��:4W�9FoC�}� O\"*\"�2��^f2]%�حp1��/��F O�bB9\"�HǶ��[c�߀ҏ�t���4��F�JNʯ.��'���kN^\"\$D#PG �(+�W!{O�<������@-̢%o�lΒ����u ��j^�yS5Rr�#.�TU%���<���uB<g p�#�R\\\rXFf|Յ�K#�ӊ?\0a5BG��(rRh��rS	��a\0�'I��/03�/�(�\" Z�K�c\"<�U`=\0���'U�rϊf/Q͎��r:�4�ɬu'V��,�M�S�?\\i*���(DEA4�y-��";
        break;
        case'da':$f = "E9�Q��k5�NC�P�\\33AAD����eA�\"���o0�#cI�\\\n&�Mpci�� :IM���Js:0�#���s�B�S�\nNF��M�,��8�P�FY8�0��cA��n8����h(�r4��&�	�I7�S	�|l�I�FS%�o7l51�r������(�6�n7���13�/�)��@a:0��\n��]���t��e�����8��g:`�	���h���B\r�g�Л����)�0�3��h\n!��pQT�k7���WX�'\"Sω�z�O��x�����Ԝ�:'���	�s�91�\0��6���	�zkK[	5� �\0\r P�<�(�������K`�7\"czD���#@��* �px��2(��У�TX ��j֡�x��<-掎\r�>1�rZ���f1F���4��@�:�#@8F����\0y3\r	���CC.8a�^���\\��Ȼγ��z������\r�:0���\"����^0��8��\r����B������:�A�C4���4���W�-J}-`��B��9\r�X�9�� @1W�(�Vbkd	cz>�@b��8@v������ ̐Z�1��\"�0�:��춎�>ST P���cK��6��w�+�)�N��;,���'�p���bD��p���\n�jp64c:D	��6X���e��|�c%\n\"`Z5���[���X�V�����yl�W09�,�'�����0N�.鍆�(-��/�H�(�P�\"�{#\r�2��ݢƑ��!T�xx���ϴ�x�3e�N&8��*\r�\\z<����*J�5�H+X�6�`�3�+[���T�2��R���8�--�)�B0Z��*XZ5�3�YT�����\n#�c�:\$���%m�ΎJ���@�Sh�� �7���:Nä�=O��#�c�C�+e07Q����X��8�J��|� <6@.��v�ڢP��9�G\$d�rRT�7E��5\"����ɹ8''����{O��?�W��\"�~�����ps͈���߰>)�,�2D�	�R�|Іrt���R�J����*PJM0��\0��[ �Hμ�4��x K�e������N(���)i}0���	]m����9p1p2+2DO��.o�8״N	ї3`�(��\\4�'�\0����\n_�0\$�S (U\0PC?�\\1��X�;])%�e6�ܩ�i�5g��:�T���G��@���^*\$d�&`���L*L7ș�JkK(;����@ H�dЗh��y@�Ĩ��>�L�f'�0��0�(ri���;v�T'�@�����ʗ%b&NOC���a�����'9Kd|�GeN���y�@'�0���l��*}����J�6�/�Bf.�\n�vOdAK\r'�	�H�k�_��@�d��\$�����٨-\$�yY�`��#-��Ă�E&r\$*50#.��P��P0��B�HO	��*�\0�B�Ei��\"P�l\n-Z��z������EH�&Se�[N��4���)�`F\r��b��FrK��\rH����}NZ<�FM^���%I�H���J�[K�=���l@S\\\r�T9����~�A��Ő}'�/Gڮ�I-&\$(i��t�#p�\\�T�a����Wr�Y�Lt�����B�.5g@4��*��T�au�`�J\rx-��4�5j�p}�5F\0����M*9c��%�VFF�-�al�P�N�Q�����5�Z/9Q�x�`o�J<��������O^&�}u/�#�d����f�[cRGkX\0�BHF�\$��F(\\R�ᐣ�P�g��Ia�#�)�A\0/*�@����Q��1�ڲ�6''f�'��۝3ьL��Y�\"�\0N~b�A6PA�t>y��6\n]��\n)l�o�d�@M���:T�'�b>�	`�<\r]�&��D�%�t Xټ<K ��:G�\n�������Z�h(�ʴ�)�C(b���Y�˯Iٶ\$�x��\n\0�s1nTǸ5�Sm�Y\",�����LK���m�6�u|@nj���\"��,@Cxph�F�pR.}\nx�9��ߣY���y<X���Jҭ��g��\\^�MU�JD����ɖ�B��'`c�C,{eLA���L_y�=�>T��ڴA�\n��QǕ���x:-����Yĸ� R�,kVn<v�ۖ��d����ĥ�����ɴ�L�\\*J�7�]�P��-�3�H�ݓUh=3�s�Ӻ�\0���_��:���@|Xi��궜�X�x��6�ΰ*��<'~���/C�L�'ìX2�s�Mq8�|GW=����	ϧ=Un&״��WƔ�᧛�g!\r�K݆��q[�,��v�z{���3�y	��n.%I�+�I��f��>��\0�������v�NT�j��.�	�H��l	��o���N?�H�.�\$� c\n����H{���4 ��l���C��L�H�଍(��bw��^d��p��lH�&�Pt�	\0n�P:rC�}�W#��b�U�#l_��\n�J�'��CeZ��^-#�Fy,n�n��N�\n��@05p8hCJC�bA�p\n���p\"��O�\"Op���ʐ�N��j3C\re����c�f�K��)D\r��.L�\n��xK�L�ֱ8QB��S�&Z��,fZ-���>0��W��я4�\rk�1�6���@\0�`�e\0��aJ�h��l�y�R�CL����z�L2����pv`��EŌ\$��iB���i/(B�����l��M�EB#ڿdX���&n�Az�#�ʏ�7�������/�/�Bd㖜I�n(�)8C��@g�9��'�0��຤6�\nvX�lYn�L��g\n��.9\$�B�kt6�N��D�r`(RdjFp�%�T2����\$�q(rP�f�\"b2+��<j��2���a\n�\"2m��	�����D�&0%r�djڨr(\nBB��tĞ;��)�\"��-�G\"ਵl~/d�'��X0�D���d���0�Z�|/��0B<f`�� @-I�D��";
        break;
        case'de':$f = "S4����@s4��S��%��pQ �\n6L�Sp��o��'C)�@f2�\r�s)�0a����i��i6�M�dd�b�\$RCI���[0��cI�� ��S:�y7�a��t\$�t��C��f4����(�e���*,t\n%�M�b���e6[�@���r��d��Qfa�&7���n9�ԇCіg/���* )aRA`��m+G;�=DY��:�֎Q���K\n�c\n|j�']�C�������\\�<,�:�\r٨U;Iz�d���g#��7%�_,�a�a#�\\��\n�p�7\r�:�Cx�)��ިa�\r�r��N�02�Z�i��0��C\nT��m{���lP&)�Є��C�#��x�2����2�� ���6�h`츰�s���B��9�c�:H�9#@Q��3� T�,KC��9��� ��j�6#zZ@�X�8�v1�ij7��b��Һ;�C@��PÄ�,�C#Z-�3��:�t��L#S���C8^����J���\r�R�7�Rr:\r)\0x�!�/#��,�Q[� �������������3H�/��on��	�(�:2�F=B��Ѓ���C�H��������Ip#��G�/���0��˂�ZѺSRN���{&˄�b�\$\0P��\n�7��0�3�yS�:�eĭJ*�9�X�<ֺ�e�ssB\\�;n��fS���@:B�8�#�b���xD�2\r��������.�s\0�r\\�S�����)����6�d�#�ir��MKW!�#l�58OX�<p���,�����/� �dOX� �j���cx�3\r��f �Q�؍���t;+\\��^�c`��dƀ����!apA��0��<z:�N�\n������@�Rx��#`\\�H�j�!����w���7x>��y\n�7����z(��z����h{a��0�FP7�c����(���dA�2��e�,�x}�@!D&:�Z`!�����f\rB*�ꬲ�S��!��1�\0�܁�SA�N)�N�U�T�9��䫕�`B�\0�+P}���XkϘ��ØdYIп�|Jq�g/&��C!A�K�D��`�S:�cH�݆(̲�CƈA�M��?\"��8��\\�AyU�t�!�ܭU����8����tP]?Ā��٭E���\"r��y�嚓4u\nq���ȝP��-\nj	�!ڲЉ�XЭ�r��Z��uF5\"�%l4G�0�c�A٢�K�\r�t�Ί�jsEw#�@��X��D�(r:F(��H@Jq:u%n{�b���D�?�0g��:������\nA|#���H�cX\n����]��\rơ�\0\n}@��[Ay�` 1�׆V ��1\$�8�32H:�P4d��I�@C��VQ聇p�W��E+�X�T���Y�H����w���@ ��=\"�w4q:��ȗ��ߋ��&O\n�t\"CAH!f+���A����a��Ӓ�j�!�14�h��y�/���R�!��\$a��fxS\n���(2,�0o)O��'��tA������O�����sA��cHa�D��\n*ӨF����\\ ���F�k4�N�*C\0H˰E��2Ca0Õ£.-��f��do��ȥ�\0��\r�.A8P�T��P�pSs�0��хlBwJ��˄f�OL���nOI�	��?C׊��	qG�������X�c���i�ӽDp�����sj7k,;���2S�rG�( �:�I�AXÆ�,����mݕ!\0u)S�O�ඈ�9�I\n�P����bi��������\\�'�h\0Pk'A�\r����fM����\\hrOY5:�yԙ�3�[[Z\rq��M�W��4�v�­wyg��j��m���߻�m	�Wh�����K�T����,Pd[*룓vo�D�>I`b+����F�T}#qP�3��i���J�}�d�C	\0�8�#fn�0�	�-�FLJK}s#�\0)��Yc	�C`��?�ڻ��]�h�\$>cH2�d���@�kxr�]�r�\$M @O�9/��C#ǹ�\\P��T��yzMt6����6�޺�1p�r�Cy+��k�q�^�����o�2>�Ҏ�,���:���_�H3&o����g[��'7GI���Blƒ2����3b׽'\n���]��8�RMƻ�0�������1�9i��M�chDU���ų~=aq�s��J]�G!]�\0R�G��� ��\\�[���K�{R7\0��g��Eq��ɥ���Њ/��P��\n�/�~��n�*�ɞ+���jc�sc��}i\r�D�0V�1()ԩ� ���vXN���a��2�xb����1FT^/��mRN�X��\0�8��`�\$( P	�@,.��nmo�B���,zs�#^�d�>0:�&���~�C�L}�\0���.����=`��)�.��θMNb�OT����p&@��/�n���	*�\rnn�-x΋�#\r~0P��7��\r��%P�'p3����\r|��ϛO�@�]c����\0M��#��b:#�`|�H\$%��\n��5���9龽P��\$�H\rPC��F��:	HSg�������ܲ�6+'���{QN��&j�JHmr�c��B����[P�������,�Ʊ�ь��1��̦1��l�����gb�����b�#ܑ�1�rL�Mʥ�Qĥ��>��MC�#`	JVHl`�H�a���T�����ь��	\r���R!1�ݰ�e	����ʠ���+fM\"L��\"�0:�<`��#d\"\nC\"`�f�c\"H^͔(����m�N��(_&�!�'rdN�5&-�\$Q�r�bT%1�)��Jrq2j&d�*{�\r2�?n+*�L�	�!`�!��*�=`����r@PO�)��O��� A.+�.`�.�F&`�wF|j\0��*K�v�#�`�qL'p����d�\r�W0(Hd\$\\0���\nB+�%�2���\"\n���ZJ\r�.cCh \"f�0�Q~�n����n���l#�pq������o�%T��^2qjnC5-�@�ò�R����M�mcr68����cfN�B%�f	�R:�@�#�	�4HkJ`bޡ��G��:���mI0�#��.4�\rƮ\$�R�Qg&�!L\\0o��Z#��.���T?�5\0@\0���?��CR�X��o��DC�q���\ng�Ws�Ac�D��P��2���@�G�|Hp�8G�q��P��c����TL��v'D��̪2(�p �RD�� �@CI@��<4�(b/2nSI�ָF�g�A���6`���Ғ�f�vO%��#�I) /b";
        break;
        case'el':$f = "�J����=�Z� �&r͜�g�Y�{=;	E�30��\ng%!��F��3�,�̙i��`��d�L��I�s��9e'�A��='���\nH|�x�V�e�H56�@TБ:�hΧ�g;B�=\\EPTD\r�d�.g2�MF2A�V2i�q+��Nd*S:�d�[h�ڲ�G%����..YJ�#!��j6�2�>h\n�QQ34d�%Y_���\\Rk�_��U�[\n��OW�x�:�X� +�\\�g��+�[J��y��\"���Eb�w1uXK;r���h���s3�D6%������`�Y�J�F((zlܦ&s�/�����2��/%�A�[�7���[��JX�	�đ�Kں��m늕!iBdABpT20�:�%�#���q\\�5)��*@I����\$Ф���6�>�r��ϼ�gfy�/.J��?�*��X�7��p@2�C��9)B �9�#�2�A9��t�=ϣ��9P�x�:�p�4��s\nM)����ҧ��z@K��T���L]ɒ���h�����`���3NgI\r�ذ�B@Q��m_\r�R�K>�{�����`g&��g6h�ʪ�Fq4�V��iX�Đ\\�;�5F���{_�)K���q8���H�Xmܫ���6�#t��x�CMc�<:���#ǃ��p�8 �:O#�>�H�4\r� ��;�c X���9�0z\r��8a�^��\\0���Nc8_F��H��xD��l�>`#4�6�t���|߲K�v��\"\\���MЕ\$�������u���o���\\8Ծ)���&��¼�+-�V����'�s��KЮ0�Cv3��(�C���GU�ݖl�)���g�:���M������� ��X�B�'��q>̑��z��ph=�- /f���dt�21ZP����q��v/�Ͻ��Iڪ��Z��WL�\r�fqL���E9��֩�H�4�@������!9EԮ��p�vg��8p^L�m5h���X��b� ����@L\$�i'�	�J=����ߜk�F˄���@N:R��^�\\�R��*D���^(�p[��s\\Q�8W�YQ,})X�=�Vp�a�J�T�@(�^�!A�\$�.5�O[iezk�@�H\r�Yy�q-���\0�:�-(��_��\"ȁ}�����o�N���p\n�;X��:A�eT�+FD�gEH)Y���I8�׃�L����e\$���Vy.����5����RJU,�,����S,�a[\"R�M�r!.L����RL	A0�Y�4�a̢�	�q	�\r�iqXaR�ދZ���P�C\naH#G�~�b]?h��e�E&�p�J4Cв\r=-�P�	k�r.)AP4ҡ�҈�U���\0���/jEG�F�A3f�ݜ��z��whm�4��ҚcPAѯ5 }T��l\r�t@!f��:�̨ͤR�ߊW�iq/U��:�u�lɘQ4O�)\$őm�(\r	2�=�uo�%�P*6g�3�К%7h�%��斢�j�R-I�B���ϒ.K\\�հ}E\nqf-'ն����Otx(D�CB�\\����&2���Ɍ�rW\0�B�hO�r��M\r�gk��U����J�O+�KĒ�����j���6�P��p�!�2�p��b�aՉ1@�o0l\rᝀ�6D#O���\0��)�n���63\nlͪ��������~J��R����tYA�	�7Bs��-�����\n�Y���XP	@�\n[Y�)��RVZN�yz�ܥ5\"��Tb�7���C�iOa������� a,b����*Y%m�n\"bD�[,�2+4�\"[��c!͔�0Apw\r���2�T����4�<\0�;9���``�L�)��H�B����XiN�4���ӏ�)�*#\\�lUЦ?A�nˢ]��;I3�r���QP��\$�E�\0?2u\\V%���\0�:lѩ�A[�����]2u�ҵa���,L,n��f�	�A\0P	�L*G�_N��Iz�Q#z�\r�>�ҹ����P[?G�ң򊾵3�C�¯3�E7�r/���_��-�D��Bv�b�o�����h0Tƕ��=���g���fr�|�#B���~����x����Z��N�+]R\$�J	��1LTu&��Z�zrH�1���#�Fu^\$#8L���(_[��kA\"�t�����f����R,�E��=�>T���nP��÷��H����t�a!^������%\r\r�z�nM\$�+��RDƔ���s������# ��1�H���ٓ�eR��z�\$S�*-��{S#DW�� �|g�@�&V�����#�'�InV_�6�Io.hJ�\\:��H��Y���x�%�u�;�\$\$���}h�DM�Jl��+�\r���8|��*(,B�\$\r&B��.\"�#ZY�(y�2�0����'::A���AK����p��dn�7+��e�\\�P�ɺo�~�E:�ǌ]�&o��H4T�ܡ�(�\"v�z�(�z��BA�碊�	��m�D��w���b�v��1���1e��X���G���_)�\rКI�  ��_�ԁ\" -���ЀB7PW�@G�mTm�4�o��¤�Ū�Ű@�\n�� �	\0@ �N\0�`�0f��\r��fa�]����ܒ��EEUF�u�^2t�0;C&u�|;�;g*�lK�ps	2\$f���\0007�L�a4���(� �I,���dt\"����H�M�.b{B{������\"�/�)�O��;\"��/�1��B-ó\rhZn�b�Ԛ)� H����/gZŪ!��C�[I���-��\$t�)�}\"�}#!4�u��[(4ޢ*��0����hT��DpÎ�N|���\$ K��,T����%���ٮ(,�/\r�M'�N]J:����Yk�S�%��h@���K��ĂrW!H�*C�.�X�\n+.5�*@r\0�2*�bvg�r��,v��}��]2�G00H�DD�̐ރ2�l�V��,���&p4��R�c�T�v��4J�op+�(��0��LG�950��B��6SR��/#�(��Ȃ@�S�X��W73�8�ͥ	�>�8s_9���^mh�\nG�q;.�ZN�r3���(�U��y���똗ªz���\n��T��H��^�N��➌-���m�L)�?�����\\fǢ�I�+s�/;|��l>s�B�3���j,�D-@R�S̃����X�s5��7����dT([E��F�7Tv1Ӿ�DW:�����m:r�C��9�W-i���o��R<���1*ObGG��	��ꚴ����rT�\"�J��yL���NQ�u�iCdPx�>m���.1�_FpC5��<��8U�Pj�蒖���T;I2��-�!1���\r;�&���Cԃ8�>������0��nY)�_	b���+2�DFH��bJ!�j(bfXC`�AW\$I ��CYjA'�UǊפ.��{V�\$I��Y�	�B��1��Lr�����S��T>�\r��;�L�U�Y�l퀎H2o�\n�g�����J�Xp����5I�*�s�G>r�R\r,sd�S]bJ�����H�)T�5H�d/�c�(}şO�!���Jәc5R���v_4���a�ke�p��uc�K<53JH�g��[����dL��θ���E����\"��[%ZA���v!���(��ƞH65M0�ˤ+��#K�M�-F�cT��Q[�iU1J3�oq\rKV�d��pV5i5/�xΆ�V�E�qr�!�f2��b�r�o���l<U��|'96H�����n[�Ys�P�¦Y�>�lR�T3D6�O�4JM�9v1dvl<\"cw��o�:�}IG�,�zCWt�:7�D7ih���e\r�!j�qO���#	�Uq�sB�M�n��5oiy�e}���sz�z��Z��i7p�Uh�f�sw/a�QnA���P��dwD����'	��~�EϡOwLү(�B%R6)�;28?�C\"o�4Z��&{h#{�OB\n�\r�='����6���L4�L�1\"p;7�#p7�K�O���K|��.Q�������`�\r�\n\ri�+a>�T\$��.n\\�!y}:��<�6-��V����Z���G%��n	r蘹��\n���p)@I4�ܳ~}ӄCi�����0}3�7v���Cǂ\\��o��GӠ�G)	�\n87D�! V��D�<�ϫv��t���h��=�8ŕ��bD��D��rӪ�x�n��v�b@�.&hF���\$�dK�S\\��]H���%\$��n�J��=H0&�?)�>\"��-��B�N��WS*[�Z+�X��T%��xW�+0m+g�v0����h��>��H��R9��7�Fѹ�/eUsѕVp��>�)a���y5DȞ}H59	}Vu�p�R��\0.��?�m���Z�7K����'=�S�Ep�\\�hR�Z��0q���E�\\�WJ����y'�L73,���\\1��Qho�n<JE����9��u�*h\nAp%ˍ��C��s�2xƝ5����70{@�q�ة=ǛI�28�9���C�W�0�R\"wB�Apy�wq��o�\n";
        break;
        case'es':$f = "�_�NgF�@s2�Χ#x�%��pQ8� 2��y��b6D�lp�t0�����h4����QY(6�Xk��\nx�E̒)t�e�	Nd)�\n�r��b�蹖�2�\0���d3\rF�q��n4��U@Q��i3�L&ȭV�t2�����4&�̆�1��)L�(N\"-��DˌM�Q��v�U#v�Bg����S���x��#W�Ўu��@���R <�f�q�Ӹ�pr�q�߼�n�3t\"O��B�7��(������%�vI��� ���U7�{є�9M��t�D�r07/�A\0@P��:�K��c\n�\"�t6���#�x��3�p�	��P9�B�7�+�2����V�l�(a\0Ŀ\$Q�]���ҹ����E��ǉ�F!G�|��B`޸�΃|�8n(�&�1�2\r�K�)\r�J�: �bM6#ƌ��R[)5�,�;�#������9��p��>41�0z\r��8a�^���]	L�s�-�8^���B�C ^)A�ڷ\$KH̷'.3��|�\n��p�M��\r.p����3���Ƭ�7�*h�l+�6��:��8����`+�+B��\$t<�\0M�w�D�6�l(*\r(�%C*S	#p��`1�Z:���B�8`P�2���6M���pX��݈î\rS�C�BPԔ��I�Y�.s��!�T�,B�9�yc�2ď+�+-S��wG+���3�]�Cx�o�(;,����b��U�Kv��X��j%R�)G��P���ڐ8�X��YC��2�h���ԣ)�\0P��4�\$4\$��rP݈����n�+n�Q���CB �2�,5�7l�8��Cx�3<��h!���T�#�|�*\r����C��9�c�͋�d���tDb��#8´��=�N�(P9�)�p5�B�)Π삼�p\\\n�\0ٍN��J����~��ef9\r�����Ξ^�*XI��@0�I@F�h�4��\0uN��&5:}�B]#��(�:�Tz�RjUK����\"f?*�Q��^̍{\$U`�bԮ�4HN՘\$\$�`\"�\$����#��z;M�6�zhW20���L�UB�*��4������b��I)E,�Ҝ�J�9*%H���8��V���HXL8��!��`�P '/p����}�ʞ8��2�#\$����F�>�B5HӴd�fE��|\r��G������!�*���,x�bP���lY�aC\n/��\\���3�8 �lEO\"C��L�( \n (p���q(��A�s#���:󈧤�vaA��s�F�q?��5��Fù�&���\0^E�M48�.ZN�C��N��FF���N*Ľ'�(b��\nP�_ ���GD��C�\$VI�xNf�<X\n֎1�zd��L�Da�i���>�R:���	�0��fI&m),Y��a9��y���@�!\r�V���#���(#PM�O\naQ<��NH�)-�7θ� uF���tN��au�T�'�b9K��%�����4t���ǌ������t&DGx �Rj�RF�I<��'���5>�����\"��l|�6t �0�m�IA)�:�xR\nW����C�Po_�o���) ��s4B�� \n	��ǜB2bLY�7f��SV��%��5�lyP!�mWa��&[�=E(��6ԀJ�Ė�A����o�ہ����6����&�ƌ7�dP�T���,`�}��z)@�>'t���N����5JR\$J낹5_�1���1�9K��_�\n\n�P����\0�u!`��xo��14ןi~�'y���+կ��`\nb5�<̴ے3ͷ����ĖYi9��8�Oz�dN���\n�\$��-���8�NM�q5\r���S����sX��#+D��e+<�q\rS@q\\�nX�O��s�T\n��\$�[�K���E78��MO�D%��5!���{%=w��	�\r��wmbʶKC�cbP¢6���D�3P�R�K+w�h�lPǱ�v�ڻ�k�\rʳ�L�*�莑���7{�����}]_��H2ǡ�9�v�8XsTm��#/����\r���N�L����n�*eM�0;�����d&@+��{sQ�2~��ICɷ�`sG'Y\"i�T\n1Bf������5����f	J�������z���6�;`�B&e彈��[�0Hiq�]��2��]��H%���?{ބ1\0<��_�K/��絓;�q��?Űw-�m�p16���T4� x�ќ�a\"<k�!��>�I�n��Gױ	6��κT��i��>j͆\r�՜��~�{K���/��n��@��<f�xO�1�\r��5�0O��.p�©ܿ��^yp�M?��9���ɑ����}N �#&�b.�m�|���*��ͼ�O���.ܐ��`�Kf�o��/�*d>U�\$�\0��-��\no�����d-��/C�ghl�I/C�~�@e^/o�Q����DȺ�\"���\$C��ɚ���b�%�\\�D@���>��ᣜm�x.�~'	&�\0�u�AL��d|�\"�Ϗ\0007m��B�̭�8��/\r��<�,W�4���r���Bj���R)�\0'��Z����IN�\r��\rV7�\"i�\n�\$6-%���%�|��`7�A���:9MF�@��p�N0d�p��Z�1Q1T����xfF��x7���Ri��%Q|��¬8�Qpi��#�cOGg��m��R90�f\$?��H����.�Qu�nQ��Խ-�l�;g�H=�|������q������/���f.E�8�W��v^q����X�	\"�lnv���9� ��^c\$F�P.�'�*�H�p�7%��ԍ�� F �j0ɬ�P��B0� �x�h�>*����\n���Z8c-Bh�0��P�.�r��R��B�)	�#�!���1\r\0��Kp��>�D�8��Nj�/-(p1QEK���E�K�t�p J�0U�O,tBC�p�\nKFB�0(/�o�bJ\$&�	�6[�4����@����B/I�4O)鮗�6.7�R�BC4m��\$��L����joF�Dst�c�Z�NE(\$nK�@o:�:F�P8��h�\$�K�hƐ\$P�Ns�T��x�>�n��L>N �_+���0ԀS�!�J!�v7e�Cv��~��C�0G4�g\n��JIH���P9�F��%�^a*ͦR@�	\0t	��@�\n`";
        break;
        case'et':$f = "K0���a�� 5�M�C)�~\n��fa�F0�M��\ry9�&!��\n2�IIن��cf�p(�a5��3#t����ΧS��%9�����p���N�S\$�X\nFC1��l7AGH��\n7��&xT��\n*LP�|� ���j��\n)�NfS����9��f\\U}:���Rɼ� 4Nғq�Uj;F��| ��:�/�II�����R��7�����a�ýa�����t��p���Aߚ�'#<�{�Л��]���a��	��U7�sp��r9Zf�L�\n �@�^�w�R��/�2�\r`ܝ\r�:j*���4��P�:��Ԡ���88#(��!jD0�`P��A�����#�#��x���R� �q�đ�Ch�7��p���qr\0�0��ܓ,�[����G�0޶\"�	Nx� ��B��?c �ҳ��*ԥc��0�c�;A~ծH\nR;�CC-9�H�;�# X���9�0z\r��8a�^���\\�:�x\\���x�7�\rDC ^)�}HP̴����x�&��F�1���	8*�~¨�Z��,�j�߲I �7��\"��J��7��Y�����Q3�\r#��2�B�[%�H�J��j�{��\n���#����FQ���E�+�Xl�7(J%OB%\"0���@�\r����H���D]J�B	�J��\r�T�0KX���[2���(\r7j�A���4�cZ��4p��#c�cL�\"��\n\"`Z(:hS�7Y-�-�0kR,9���~�����=G#,v��6�+��}�&G�ݛ�L���\"�[�6�F*���Ȓ6�)(\"�<���5\n6����,���\"�d��\\ʲ�jR7��26������c|�p5��<�:�:��6:�J�P�Eƾ\0�3�/j�L(S�2��R�\r�b���)�]U���[e4��q��_]���I��P���ܞ��4��� V��6 @��rQa���~�i�R\nIJ)e0���T	�Q�EL�Q�Wj��B���W��;��~{PJz4l��>bd��Al}�ݮD�I�70��B��X]��KRUF(�&�Ԫ�S*mN�u>���r���S�d\n��D\$V.L8V!P>@Gk�\"i�)8%%H��|�ä,10���p�L�\$ q��Tv^��)N��(\0�Ջ�uP\r�p��a�xi�ļf�I�P��3R*Q� q.<�dɨE*<��2��!�0	�\"V}�)�K�k����H\n�4˃�n�\0()l4OCO1�8Di#�: F&��#�xw ����Ҥq���Խ�Fj�'\"�UI�Z��]�pp<�C��Y�h8��J��[)�ӑ�\$���z�ߡ�!��9!�<AL4�����U B�y��\0(\$�@�e�% ����K9�q~)�3���D��1�M��)&�@'�0�]�%*��7+��&ԍ�Q�H�iC��(B��ū\r*%A�8����\nu���<���{��6�\0����#I��U��gJ֞S�+/\"�\0%侎��c�D)�����%_�����@B�D!P\"�P@(L���0#.��;CE���ʓLi�Ya2���a��Q��w o(��%l��s�oɑ\"�dˆUr�pd�Nc7E��ɪRtp8������n�g~c��G*��J�t�_���)��n� ���O0u�F�5�@�+*\r��(��/�șGːم\nA����L@E��\"��.\"�\\],0!�xMg(����(d���M��X\r8Ѓ����h���NYb�\\���d{Lt�J��*܋�'�\$�Z�Lȿ�\0�8/��pP�KY�K{1�9��&l�!P)���(R[̀^�f쓹\rW��������]ȏ#�#��(V�8*5�z�˜~�wwj Aa S�xi]t�H	�8'X^�Ij;Nx�� Z������r�xu�%��ݔeI~��8gc�\\@^�^k\rf<�Hbj�3�����ű�ֲM\r!*��}��î�v�\$#t,�w7��D�7�E�a#�|�\"2J��\n%7D��>J/j!!��Q�zи\r��ͫ�HwI�m�(H��\$�Ox�6H��E��͖|�n�C�d�f\r�LJ�ң�l�����)���m�J�Z�]��K�ʛ����7��-�w��Zɜ\n��xcדq�*�_u���z���\\�^�G-�g���\$ӒZbLq����2�p@D=''\"���j-A���������!X��]/K2y:5��J��ǡ�(��;*���/5�=��4��Q��N����n�B;�/~�{��G��D��\n��o�����}���tx���Zå����z��/� i\"�i�IA��M��{�ڻ]��QkeE�����|(�O��.��o~�O���9\0,ȷ��L:���8%*�ZDtR�6=鎏�.̠�fxW\$@bHm�H�/^`��Qp2�6:��j�<I��~��L2!OZ���4\$ �.ʎ�>=�Bgb�W/���,,��Z����P�l�Zɢ[E�/�c�����R[%�[�������P���y�G(l!���\nm*Jg=�\rn��x�ʏ�\0M�R5q�� QO�����#\0�X�P�\"�, @P�-6\n�>d.{aj���	'�D�_�bK�7�+����0� �����\"�o��\r#k}����/�ĩq��1y�~�n��F�x�P�|��u���=�⏀ܿmF3�]�z�ax`���d�qz������Z���o��)|��i���L����1����@Pό��\rL�K�<�07��ϙ#\rL��0���#�>��	�,�j\0� &j�q�G��p��#0<�I�^�+��H��҅'�L����q�	`����hr�&��(]�����ʎ�C��dj\r�V\rbf\\�D!���1M�\"z`�\n���p?�\$��&��Q\"�#�����An�c�dI�.n����&��\r �)v\r��P/�9o\r��9\$ԃ�K�9-\r'j��-\"RO��\$��D��f��#�H�ŉ����c������>\\n������]�US��\\��\"��#��#s�������g��9��9���N�6CJ3#6��N `�A�Nȃh�'	:��#E���`fBJ��dP��(���WL\$p���ol�o@����F�XDv�B��\nD ��b�q��=�L`B�Gd`�\n,�ac��+u�V\n��9Kº��4�o[:b�*S�].l'	p�j#|f��<`�	\0t	��@�\n`";
        break;
        case'fa':$f = "�B����6P텛aT�F6��(J.��0Se�SěaQ\n��\$6�Ma+X�!(A������t�^.�2�[\"S��-�\\�J���)Cfh��!(i�2o	D6��\n�sRXĨ\0Sm`ۘ��k6�Ѷ�m��kv�ᶹ6�	�C!Z�Q�dJɊ�X��+<NCiW�Q�Mb\"����*�5o#�d�v\\��%�ZA���#��g+���>m�c���[��P�vr��s��\r�ZU��s��/��H�r���%�)�NƓq�GXU�+)6\r��*��<�7\rcp�;��\0�9Cx��H�0�C`ʡa\rЄ%\nBÔ82���7cH�9KIh�*�YN�<̳^�&	�\\�\n���O��4,����R���nz����\nҤl�b���!\n)MrT��jRn�o*M)#�򺖰�d���Ԣ��Ō���H4� ��k�� �2°荎���Pc�1�+�3��:B�	��H�4\r���;�C X���9�0z\r��8a�^���\\0�3��|F�#�GR���\r�T&��P�I��px�!�ƌBTN�\\�*6N�J��,T�=�Z��ܬ�4�3��J��i�Q'ru��,Ȯ0�Cs�3��(��^�P�a���8q�ɰb½\"%k�>��z�HR�.����Є��2������u��3�%iV3u�h2�ɬ���e�����\"�u��0�ʊ�BH�\n�!�s��i��>�+��6��VY��FM�������\nH)�\"c�\$%���l.��笗�]33�B�5\\\\���W:Wu]�ސ�'�Li����<\"!�%\n��+6�^C�2l�)���\nC��l��ç|�����,��q�\"Y����C��66\r�JQ*ɺ���\$*d��+��v-T�!G��Ψe.�%77L�\$Db����lAt%>�\$�����=��2����JU|=�'�g͠�}M�1��ߋ�)ȱ��U�����A)� ��o\rh��C�� ��!��:6�S	\r\$ɴ����`!_����3x�I�\n\n��0�*�P�uQ��'���:�h��D��A�U��X�5j���wWj�(+��V~C!�j��}���Z�d��TV�Ya�G`���h~�[�y�����ӑ�u'ۛR��D�ĶF@�\"+M��&��޽�%3��U*�\\���V��]+Ȟ��r�XA�a\"F�Q:�Ynv>��b鈄s�`������[�q����g��\n�s�����Aޛy,�܇1\"�MI4<�@�&�0Z�hBj*6\"p@�C`l�	�heaa�3\"\$<ê�Q��:� ��9��h4B	�F���VE`�lem3\$�*e\n��LP�)��>ڊY�J��B��Qi]@\$��ԛ�ɰPP�L8,&��1w�O!y�J�!�x��b��*�9�ք�<�T\n!\n��@����@s�m�7��JU��Bs�,JC@�=\n��T` �Jmg��৕�T�Ʌ�p�C\rOA�X�4'_(�a�A��5r@�Ji\$F��q2�/��rrM��qrId�,�g�L�ZT��#M�h\$���S�iau�K�����!�@(0̂ClM��� P�AԽ�ʆ��S%J�[�uK��V�Kd�+}�fK鈚W��'�R>Â>��\$����^��I�\\�d��xllQ��zl�޳�VAt	���R�GK\r:\\|�*Sj�ш��K��m&��'�\$�3\\�����-�6�����hi�C�A<'\0� A\n��P�B`E�mE�8�(�)	\0�.��.��&��]R��\n�>M�e�L�<#�G�!)t3^\n��U�S�s�0߮�� ]Ӆw��M�|��wi���\nyvS	�]��#�����K�N:\$����U��n��b������+�-�#Att��Ǖ�+�D�V��C\"��i�I!�\n=�Y�I(�E�겆��e�8�u�d���]��N�xTI�i�xk~�K��|��+�)eݳlLa�_O>�������ڿ���nm�uҫ:h�;88�Ȳ�R�T��xzX�24K��eZ�^����D��4��-�*v0/f���\$���d�8�ѥ6�����⥰���Aa \\4T�U�|7�:\0��Ed�d�)�d�7\n\"�,��i�}�!)����p�+1�>Ծ��xN�;W����ƸQ�;z���3T��9��,C�^�ԭu�?OP�c��EWW�	��^r\$W+;\0���kO:�N+���B�UYd�\r�<2P�r�פ;��y<��G��G~�J-�9�I��8�ji�?|s|(�g����q��C���rP���VHi�YJ�ٓ�e���yܯ��_ǈ�|C������[p��s��7r�\rt�!Oc�Vm�M�6qIYN`k8�X/m0�B\"	P�Ek�`�2cL��\0'��mB�O�%O����.݁^��\\��v�\r�h�c�H��bc!\0P�n,� ��g��ϴ�n���\"tz��<3�p�)��L���8#���w�jΧ�k��Aj)J>�Z0/&�-0]'R�o���x��%k2���\"�\nfHא����釢r☂n�����c�Ű^��P�`/PŃS��\r�R߰�)�v�;�| �T2è:�?	gnI�F{��?'�\0l�Oz��а��P��\\ů��\$~?�0]n�3����Z��F\\�������b����p���\\�P��x���7����Eo������	F�N91{����q�tGh����_a�GMcn�2IATKʎ8�Z?a�	��c'�lУE���\n�0pP50�Q�Qf|�f�Q�����O��R�1	�\n<��)!.JJ2ID��H��r\$�H\$�Qp�L�\$p1��\$��R2RX��&��f4C�6F����Kq��|��R��9H�(r�rQ\n�M�ϯ�K�4IO&��v\$#��:~�t,�rj �\r4H���P`��T�D�k������I,C~5��L�bC���G���/PֳR�2��җ��ej�@�k��\0�����k�fy��o�\n���Z	.z����x�-x���4е5,G0\"�r��Mڏ�3*��Q�\nr�0�2cG�1B��|Ķ�3�dc=#��eq�?B���jz�%�2��h h*LBB�\"L;�nI).�`�1\"im�CjK��L�sgkf�J�'�B�Q96�	?������7-�?p.K�`��Ad���!��Bnz�?��-	�r1BT�Q.Ϯ�hh5g��³TH������.AF���CA,�3�.�i'��3!&��6t)�Iif��s���]mt����6%Y*���)�>0f�t``i6��m�����&�GB�G#�\r(f�sx��@ ";
        break;
        case'fi':$f = "O6N��x��a9L#�P�\\33`����d7�Ά���i��&H��\$:GNa��l4�e�p(�u:��&蔲`t:DH�b4o�A����B��b��v?K������d3\rF�q��t<�\rL5 *Xk:��+d��nd����j0�I�ZA��a\r';e�� �K�jI�Nw}�G��\r,�k2�h����@Ʃ(vå��a��p1I��݈*mM�qza��M�C^�m��v���;��c�㞄凃�����P�F����K�u�ҩ��n7��3���5\"b�&,�:�9#ͻ�2����h��:.�Ҧl��#R�7��P�:�O�2(4�L�,�&�6C\0P���)Ӹ��(ޙ��%-���2�Ix��\n	b\\�/AH�=l�ܘ�)�X0�cn�\"��79O\$|���\$%��x8#���\rcL������##��@Ā>�\$����0�c�\r�8@��ܩ�8�7�TX@��c����`@#�@�2���D4(���x�W��<ϰ���}1MS�xD��k�'c3�(�`x�!�j+%�;�Q������@݌�S�#�r�5�2����K^ر��(r�R\n�D�D�a(�׎è}_���m[���<���%�锸ӁBE���:1� Wz;\r�U����P�8�vL2 ��=F3�|32[�3?6��P�0�M<Wn���ʃ�R���7(ע��:p�������/��0�aC[Ӈ����r6� �BR�6�EҎ���+%;rqu8�K��q,�r�ÿcl�C��\"�	�\nȶ� ��Ÿ�[�\"@R�[�ds��3��3�@���52���\0�0��2č#L�X\\<8-�d��N-�:Kc�7u��5'KB4�S�J>Χ������תּ���K�'���2��'|��-\$ŵ><��1cϛ4�~��������Jj�{F����͛�A�2�6.S\nA�BR�P�.0�@Ű�Q�v.�����MB�,i������\0i*!�+4�@���'j):�0䧃\$e�O�F�U:�Uj�W�ub����V��7�0m�LU@�+�v��i5	/.R�b\\}�E�&���aw0IQ Z�]RV*�lΗsRHI�TJ�iPD�2���V*�`����J�\\�T�P|ZX\rE.��@-G�2�Oa�ym)x&����Q����R��%\$K���[!�P�d)�.A�%�C4uO�C�b�`g{�D:��	�2�Q�VK������r�i�~%\r��GB�H\n\0��3�lZ\\�\0���4V#^Ih0�\nCL�f\0\nn�2�2��JD4��EԺ�A&->!�s�Y�@㪟�cɅ���I���\$#�̕�js*';\nU]���øh\r!�o�Ϊ&B��1��MBYwb�ܞ��|P��1\\�-s#�\\I�*0h%�B���A�%�C6 �*xǨՊE̥�:\\b�Cأ=��s/������I��v�(��\0�T�6��B�e\0Pq���(���[�n8v����Apf\r!���&�J1uk<�'�L�S�9��M�:��U\n` �P(�xa��n�*���\\%d���^JiYsb�,���2Ac1d!<'\0� A\n���ЈB`E�l\r��\n���@\nH�]#\$��0N]�F��\n^�)�:����,��� ���p�R�<�,7\$����\r��ٕ'*s�g<40������p,�c�Nb��:�f��E�PL��� ��䃃x:A�}O��?�Y3��M�Sڜr��I0�\$�ٔ�s\"Mɵ��zb�!7/x�B��Z�dm9�6�p��:6����ƹLpN���CsU�(e���\$uL����W:��8���4׉��^+1w�P�y��uR��I�<�T��vDL���B�!;b䕪�8p\0PD�m��:�o�T!\$\0�I�{!>����Vj�t%4���t�j���t���i�����8%�P�eÿ���O>�@�(�;|;���}�䥆(yn�k	�Se�A��X��i�V��DՀ.N�!��|<w{&�U�C�2&�昆���9��vϘ�nnI&/�&��{��1/8�����4Α��2m���\$�Z� �����dJ�A�Љyn.GQG7�D��\n:�|]u�N���q�L��Y����@�frx��-3�q.��q�K7vؔ�̬f��yQ^S(��-��b)?�dRy~!���LP'%R�l��'�z_Nlza~C�F���V#d��1Ԫ���8 �� �7���3�\$ϷJ!�\"�!��)�鞳{O�+\r;a)D)���C\n(+�����ߪ�^���,L�f\0�P���>p~�#Ư�/�w����4K�͂I��������L�@���P\"�G����ԋ�D�r�n�\0�N:��\"v]OW/��PP�G��0��8�<t�~o��/~��>��� \$��v8�^&�-aG����Ê#�{��	��3\"v��@7�LS�,Rby\"R�<=c�`�\"-dI0�qPLM@1L\"'��ȳ����AIc\\�/G�i��1�\"o�#hا�\0���OM�\0�M�-�!P�cn�OD�z1\\N�Xi�&	������&�����{��%��P8��7�=�v�\n��o�=�T[�X��PeF�\\.�B.'tّ�=œJ6#1���Jd�#O�aGh\r-cq�MRD����|�������aQ�pQ� ��/\0�D�3�6<�I�]� ��́H2c]o<�&̣\\�P:��h��\$��	���vރ�\r�`��e�E������ȂK1<�X)�ݦlB��12�<p��\0r�R���&߰F_r�����J\$G �cnUC`��8F�n���N��	PZ��	��\n�(	D��2�mڣ��C#'��5B�/�0�d��@i���9BnU�C�0��#%�2c�0��'d)#��0��/cX5�Z�+V\$����L1\"O4��2��sGj&F.Φ��oj/�5'<�n�-�6����鐺��7,c�Г�/�8��o0Ӗ좈XF��+9P����\$���/̌\r�t�풵f��b&��=��dQe\n'R��1�.d	��:�Db#n���@#r�lHa���S�&\"���2#c�Ф��\0&�j�����dLrO-\nQdLJ�+\n��-�";
        break;
        case'fr':$f = "�E�1i��u9�fS���i7\n��\0�%���(�m8�g3I��e��I�cI��i��D��i6L��İ�22@�sY�2:JeS�\ntL�M&Ӄ��� �Ps��Le�C��f4����(�i���Ɠ<B�\n �LgSt�g�M�CL�7�j��?�7Y3���:N��xI�Na;OB��'��,f��&Bu��L�K������^�\rf�Έ����9�g!uz�c7�����'���z\\ή�����k��n��M<����3�0����3��P�퍏�*��X�7������P���\n��+�t**�1���ȍ.��c@�a��*:'\r�h�ʣ� :�\0�2�*v��H脿\r1�#�q�&�'\0P�<��P�I�cR�@P\$(�KR����p�MrQ0���ɠl\0�:Gn����+���,�N��X�(l+�# ڈ&J��,��������h��I%1��3�h4 �z֤c�\\2�\0x�����CCx8a�^���\\0��C���|�ԃ�L9�xD��j\\�\"2\\��#px�!�t �*b`�%3T؎ۊ�v���������1�r��%�xNv�zä�T`:�#`@ɍ���:B��9\rԲ:���Ɓ�N!�b��7��T|*#�}���:ʲ6T����Σ�+(��ׅ�,��7�� ˉ��+�#;:L��X�>��s��{L�R��a� P�9+�P���C{�9�/���6�����R:��\n�hπ�1쪒}P�J}\n�Zvda�Q��(����:3���1��䘧�94\\EL��+��P9��0�yZ`�#�Y���GE�oܴǽM#t��#�����@�6���\"���͗����We3����\"@TƓ�`S>�hF©U\0�ׯ�*t\"l��kcx�;�C;!;@:�uJ�-Vp[\0���F�BX��\rɼ�\0�����0��Ȱ1RM�;�+Č0��Vo�50L�Xw	:\n��5��@Rǜ��R�uB�<(�ՙP�A���++L�2rЛ��e ����I	ZK̒�@�`QU/Ē����ҮV\n�:+El�Ҽ�*�9,��Zb�������I�Siد<T��JW�o��=��S۝���R�Jr_%��B#��:��V�U^�U��V��;��zЁr�XA�a\"\$�I��Y�����@��w�PԖ�\$�̦e���P\r�[�(tP_��;f�!�ƥQ4*GjI���v�QL�1�@��jP9�c<LCy}3*y8��\r�\n2�%9tNt�r\$Oń��\0eסR)�XAP���<�E�AT\"������HXi�t�y�E`��c�(�߱�BO�!\rꈠ����oN'm>-X-Ú�D1h��kHY��@7ޘU*�S�ܛK������m��Dr�L������P��Q )�=����d��χ��3�r`U#�iҚsRj�\"�L��pe\\�*U:�Ņ|�J9.�J�Tpk]��zD\$(�	�c}�%���N���շ�4(R�v�\\��J�kI�5m���yx�I�\0M1�P�h�!�,�����x���I\$E,��	]�R��i_j��l%d���ғc\r{�J��KW�*Ke�I#�I#���P�*[�� E	���b�	��c��Vp��\rm× ޓ��wR�OUr(�Ho=�A	0�O�{)�yH|[[��0���p��~��\nL���[7q\r\n9x��)����Q�*).�(��Kyg�աKǞ�,ۤt�(�e����kg9�@���B\0S4k�T��3@�!�㏖��8BK�=�M�W�ˍ��t�����B�v�2%��8�p�a[:!%A�+�ܷkY�Q�7HQ�lg���-\\�\n�)I�O+���wk2��\$�'5�PTpp����b���<�'2�	*�s�[N�ABońIw��D|� �'\r�D�bV��m�O[����2ȃ���AN��։�Q��T* ��1���`��0��5�y@Kl��@�BH�'u��Je���� �eM�%5���?��E؈/���P�Ř����[�`M�I��D�ZRj���'������@%�rnp9ֺ����>��9�.!=!9��f	A�d���s�9:b���t���\rC?�s���Wg0}J�uI�ՅD�x�DǶu��Fx�k:���Be�j�0x�aGL��\r<�! �z1�cI]���:�p��|�+�P�@<&(��D ������x6 ���v�W�3ڇH.{�@PHH�Ic��c�]O�ȝ�v����ʂ��kZ��~������ݐM>���,aAmty��+*��\r�K�O��M���/����J�����O���T2o�¬ ��|�.f�Nܫ���va\0��L�\"��ac���`� �6����Tp=��Fl#��D/��#8�FBL�V\r͘cl&y`P�f�7\rdF\0�'g*r��\n��̪ֆ���:'�zȐ������|F0�\0p�ze	P��0\nL�\n��\n�\0000%�N?�H�g�\rH���4�Z�i ����꒰�����p�C����ν\nM�����M�/����)j�͸�aP�P�\r��M��;��p�)L\$c̜#��%�M�/�|M/6�.ڬOR��T� ��R(�6�@.zlM�\"\r��M����L���<��v��e`�=-֢�p5- ~l�B �q&۱>c�6.�|Gͦ�����c�=���C�G���=�^��\0��O:�����.\0�0��О�/�!���E�f�5!r!��#QU#����22r?#�y2L��R���(n>�\0W�HEO�cc\"�b�fKJ!Db���Q,��\$��(��#QE�� p�ep\$��ZM�Z���%��.�,.e̂fh��,rL�cڵFPdDoC*�䰫��-�GnC\"0�)I�-�ݒ�#o�#��l�/�2�\$����.�1����M�1��ehM�%�D�.@��K�#Q��S�B�r�)��*�TKSFm� �t	�u�R�N0��ۆi���X=�T����3g\n��8��{̥#S���jt�&1�.��N!�T����X�r!5�h�N�<��B� ��D���,@�k�\r-\$5c;,�t�#n]{\0\"r'b��cblQ��g\n�M�1c8C,\0\n���p�Q)��j�*�n��S��r	C�ǂ\$BI\0����Zh2�_����+F�],HT\0:\$�DƵ����@TjK��4j����fj7PEH� �{��\\rnag~��:w�!���3�<42;o\n)TYC�4,C�pgp��Ld==�	.�_5MPL��;	1��Δ�C��4�NtMt�:`�G��}öP�ڟ�ZtMF,�*2#��j-<\\�Ds�	RM�4�<?�@��muD�f�-��>���5m|G��,���FmD04\r��1�=-�Kj���}���C����,w-&\\7����F�\\�'�}ƺ	\\��8ZY�Z=��>`A`�";
        break;
        case'gl':$f = "E9�j��g:����P�\\33AAD�y�@�T���l2�\r&����a9\r�1��h2�aB�Q<A'6�XkY�x��̒l�c\n�NF�I��d��1\0��B�M��	���h,�@\nFC1��l7AF#��\n7��4u�&e7B\rƃ�b7�f�S%6P\n\$��ף���]E�FS���'�M\"�c�r5z;d�jQ�0�·[���(��p�% �\n#���	ˇ)�A`�Y��'7T8N6�Bi�R��hGcK��z&�Q\n�rǓ;��T�*��u�Z�\n9M��|~B�%IK\0000�ʨ�\0���ҲCJ*9��¡��s06�H�\"):�\r�~�7C���%p,�|0:FZߊo�J��B��Ԫ���EB+(��6<�*B�8c�5!\r�+dǊ\nRs(�jP@1���@�#\"�(�*�L���(�8\$�Kc,�r0�0�l	%����s]8�����\n43c0z\r��8a�^���]	�jP\\���{\0�(�@��xD��j���2�Ȩx�!�i\$�/�,;\r5S� #���!-��7��+pԷ@U�f���x�\"cx알�07I�P��\r�\\L��\0�<��M�u]��!\r��ھ�B�ҍ�qs\0��O#\"1�v��:O�r�K�P���(�\"�����\\JU�*ǈè�]�e�\$#;63�pЄ:�c���0�߉�4ʨyk\0��(&FJc�&\"�gt�	��p�5�Ӑ��R�J)\\��\$;��7�M�+�\"��&P#(e�+i�6rR!Oem�sr8��,p!�n��oM��'*�B�9;��\n\rCT�A�0��/8�<M�~�2��>��Ir^�\r�@R\r\\�W�>ʴzT.J*�J�{p�#������L�_�j��r�	�\\\n�����]��i�z�w����\$>'e�x��O�m��]>�|��[\0b��#\$Cp쁍�x�/쌝�[D��72�J�qK3ȥ��D��I�w\r=�%��F4\r\n�� xa�	�L�%��C%*(��Tz�RjT;�t�vҜS�����a�\"����f�P�X�:�C��_%!�0��R��+[*����e�z1u4�a]�ؖ�R\\��(�ʢ�b�R\nIJ)e1�:S�,��*��C�y���P '¥'4�\0�OA,6+t���x��ed�	�P��3� CTc�_\$�:%x�MTg�%\$9@�0�Cf4�!c�\0��� \r��3��`A7���%�6�\nqu�N� ��N=lx�4�5��2@�(��AC{�� �`RnM�S?�l���@�H�X)���WH<Y�A�ߠtНd��e��\0��	���� -�_\"�D�!�w���(_��&�l�t�\nY~�)V����O!��L���j�\$3!�Y&�(xK&5���.�dQ?(.49D%�YMHBr1��C?�@#���I�&Q�Y,�'�:\$���H������xVj��㋜�<)�G��Idǉ����C��%R~Q�}V�q�3r�;'W�EIi=�\n�bha�3����YMJ9+lA2�X3HI�;%o��\0�'9�r���V��J̚</+��cM�}D��b>F]f�٦	r��R*\nY!6!*P�HZ!Jv��P�*[�I�B	�H)^;�y� E	��݂)3Z��^�����J/!L�����Pɨp����2�\$r��=ZKi-��]0�Ɗ�н�@��S�n%�W��y��jX��2vS�t��n�Xʼ7�\0�Ԟ�[{qǨ�!�RpCL<� B@��_a�*l `t�M��~��N�*d��Y~ϦS�V_͖3�Zc��ͩ�<��t�}Ո`*9䊾m�:'�̺�8eX�Nvx����*���Vhڛs�ô����(a�ӢK��uZ��jt�MK�xg�쀝�ɪ�{R0(L�k�8.I�?a�H2������1�ף�~Y@z�A+ɔrmt�FU��\$��2��{h���w8JQ�d�P*]��z4ġ���gSc���H9����7��ܺx)\r]\$�6i�j&J\$��P�aP���*��.<L�q]e��*�,�M�s�eI�,4�kv*\n��\0�.�Q�L/�fo�cV�>A��r~1:��FJ}!��ӥe'rV�ڂ� ����%P�ڜx�!�����~r���2���b���)�a�u^������f\\�!�L	۲ÿP�HF̄�0��]�#R9�YfblhW����눘rV�{d�ș4e�}Kzx6{�_AZ�&��Л�\rCQo��&'�`|�M��I�]�gcOC,��/a\r�����g��l��WhJ+D�[?r~]8�w�^Aϔ�l��bզ58R5��?��_��{�PP�`�h���_�jLoN\$#\nt\n���T��C��qL|^c7p�I�qovY��%�4]P9�\"0�r2��& `@X���N8������pX�0]P�nX�0j��1o?m|\$+�/�>Z�������	ˋ	)P�'^�,��~�0�p�j+��\",2h�C8UBn����F�J\"��K����䘔mlC�\n�E��>�'��C򸈫\n�v_�10��рڴ�­x%,��7	�FZO�m�2�H7O�Y�BҐ���D�	pC	����\\�`��@n��p�7~x# \\�4N�j\$\$���j�\\�o�7��p��\\�\0ިod�fH����IP4�Qo�f7;gf�q�����f<�q�����#j����L�t�%�����ؤ{B�b��m�/1��\"1R�r�g675\"��oE�g��o�(��Q]%&\"i%�&��H�`�����J�2�[mr]��3�\r�j(b�4.(o���,��d#\0]��I�NIw���F��@n�g���lw�\"F\0�`� Ɲ\0�3i \"�(�1Ɇ���+��\"�\0��5��i'`�\0��Z�\n\$i�1N�BD�2�b�#\"6#�\nt�����0Mr��WfG.�,=��M�-����.�&5�\"UP�o�J�\$\$Fҩ!B�Pѓ|��h��~3>(-�3��0��k#�����p��@�E��ln�\$;)��3�S���U ��:Ӽ�p��\"�)��<���3���o\$q;\$?\rel�W��*���o�������4h�h��| BR؀ޞ��ZDӨ&C	��>#l1��H�KQ�!B�'��أ+C�3;l:%D��0*�lB)E�<TL�C�B�VF��;�e +��";
        break;
        case'he':$f = "�J5�\rt��U@ ��a��k���(�ff�P��������<=�R��\rt�]S�F�Rd�~�k�T-t�^q ��`�z�\0�2nI&�A�-yZV\r%��S��`(`1ƃQ��p9��'����K�&cu4���Q��� ��K*�u\r��u�I�Ќ4� MH㖩|���Bjs���=5��.��-���uF�}��D 3�~G=��`1:�F�9�k���)\\���N5�������%�(�n5���sp��r9�B�Q�s0���ZQ�A���>�o���2��Sq��7��#��\"\r:����������4�'�� ��Ģ�ħ�Z���iZ��K[,ס�d,ׯ�6��QZ��.�\\��n3_�	�&�!	3���K��1p�!C��`S5���# �4���@2\r�+�����8�0�c��\r�8@0����#��;�#��7��@8N#����`@M�@�2���D4���9�Ax^;ҁp�)J��\\��{�σ��@��\r��*��7?�px�!��9�RW'�j�� m+^�%q:_b��L��&v3a4j\"7�d�榥H+�#��*��J2!q�|���k�vc��\nf����L�9(j�\r�-���ű����u�Yi��ɯ&'�>'�TN��8����� '\nɮOƆ�k% .����k��8,��!�B<�\$rw\$��9z��=���JD)�\"f!5��]d5��y^G���'ijq�mb\r�����Fs�-z������@���z��{&n8z�gn�s�i�M|\")��rC�����[��cI2!�H;���RnD�G��Υ��wa%ij_��H<=̡WEԥ\\��7\r�I�8���s��rH����h���:\n���#�2JM� 2b@���=yu�n�z�!am/)ʯ�M�18�3B5EQ�u!IR��-L{���N����:V5(|�!,Y:�ժ!\$k�rpb%]Ґ7N�R�x����c2f9;D��,��T:�Qj5G�&�^ڙ<jqO�<~���@\n�S�Jb�;p\0b���C#����L�Z�&���X��CjY.X��\"N�{ \n���&G��t\r��#���A�2�@����a�2�p�c l\r�*F�v=��6\0ơ�!��64]\"��F��@Hr5� \n (\0PR�LGc�|4\0�C�M27���C�i=a�6���{�8 K��1��ڀ��(PA��^Lȃ+ql荒ܛ�|L��>�)���yOi�?�%��@ir)�uOd�a�:�\$��C�\$\r��\"^ML�70L���C	)/XS�z/bDR�4(Ի�n�hH�E�%b8�b)=%��!���Nk5c��j(�2�\$�f%9�C��P	�L*O�8IHq� n���{ȊJ�4\rQ�E\$`��+�zc�[�*�q�\"�NB0T�����h�p��/UY���Z��H3��5'�ª�'!�y��~`�{�,���]�]u��-Bp�YY�7D\r��B�È��I�OW��8(�D��z����	9m����&;iA\r�����U���2�\\��i��k)*�7�t�P�/C-���`�9�!6����a���̵9�R�3#��^Lɹ;SI�͉�(M�r4n�+r���6�H;��Ѝ��{�1�`մ���t��13w�Պ�@`R`�����2VMY��X�:�rXQpnK�I��8I��0�.��s^t+�0\\����u�X9Uv��x�	\0�a�ár!0�*f/�+]o�=�FLױc*Z�I\"!P*��t]��Aⱉh�.@_���e�C1e��H�LB�*����N3�Dq	�ffF�Y�'\rЇ��2����-I1g��ڑ�!���.W�L��╔3��c�5QXLl�.�aOXQ���i5��PB,1���fSH	j%:�M����k�ĵ\$�`饂�r�#w�a�/sLQkD䮿.�m�0-�����s�RZΩ˚��6��Ϙ���.H4���;ت`w���և|�Ĭ&��� ���|Z�l�_�F�m��p=�M�:�GA7��jǓő:)�)\0��\\!��*��fe���=�&�(_\nk�����H�z�l���s#��f�yե獐�#�)h�OJ�\r�}J�4�?C��j���l�vė�Po�B2U����N1��pI����{���&�~�,�Lm%\"�g�m��ehU�Ob#��ei��\$8���X\\��y-��^g����}WzQ�M�[J�̪��\"9˾����=hl�������CXI	���n�����넛����Z��09�z~�L\r�%`W���D=?�ߗdKtl?�\$-.Q%H��C�ѭ��R�q6�^�ozg�@��&�l�ꯄ�/Y����e�����Ʀu%�҉�7���\r������I�*�孬��V9���\rк���T�����g*�LM�����J-l`Ĩ1�N�F,��f��{������&:��́\n��0aN5�D�ʊk�-nF��,'fj5�Z:��(����`��пŪꏌ����\r6���H�h�����H��E*��l4�BvB���v8oC�e�vO ��qn����n�`��-�t.���0*\"��Jd�FL\r���C\$E*4u\"%��vB@�c:��-Ct!�<1�j0'c�\\��|�CW\"Lr02ExЌ�ߦ6��fُ�]��H���aQ�g����>�\r��Ɋ�Ll�	F4� k���m��������m)F�9��5��mK|��!O���:#q���y\"��:a� �MjOk\\����G�n�-����.�!q� �#�<H�L!2J!(��aiD�kLr�";
        break;
        case'hu':$f = "B4�����e7���P�\\33\r�5	��d8NF0Q8�m�C|��e6kiL � 0��CT�\\\n Č'�LMBl4�fj�MRr2�X)\no9��D����:OF�\\�@\nFC1��l7AL5� �\n�L��Lt�n1�eJ��7)��F�)�\n!aOL5���x��L�sT��V�\r�*DAq2Q�Ǚ�d�u'c-L� 8�'cI�'���Χ!��!4Pd&�nM�J�6�A����p�<W>do6N����\n���\"a�}�c1�=]��\n*J�Un\\t�(;�1�(6B��5��x�73��7�I��������������`A\n�C(�Ø�7�,[5�{�\r�P��\$I�4���&(.������#��*��;�z:H����(�X��CT���f	IC\r+'<�P�lBP���\"���=A\0�K�j�	#q�C�v8A�P�1�l,D7���8��Z;�,�O?6��;�� X��Ф��D4���9�Ax^;�p���pl3��@^8RT��2��\r�cZ���`��Dcpx�!�n*#��6\$�P�:C�֕1�����JR&Y���0��ς(��6��q����M\rI\n�����7=�xJ2 ɠ��w��2��:B{\rh1Z8�c&ʌ����#�a���\"��mc跈�(�0��H@;#`�2�B[f����ì1�2�֜�:�3ʨ�b��O��9\rťI��7.x�޼�c[7F�\\�8DW2mJ�<)c�)9�R68n(@9�c�i\n\"e\"9n������2�}/�h��u�7m���|U��]���)�	��j�k�p�D��i6(6M��3�#�{��#l�gh�x�<vxC�/�6�s�uW��y �\ry��܀RR�4�E�֍�0̠!I�d�L���7��FgS�A�O|7��\r/j)��0����Cv42��RM��Aث�5�B\0C\naH#\0���`���\"�<���|�\n|�\0�4�@�^��Yf��\$*�Op H��)pƉsJaM)�<��Tʠ;��XB�prV\nȒ!v:��>��B,u�q��k&H��l��tR�T��֛H9�A��s�VaڴjMJ��pJ@d��d���>�U�T�U�H��r�C�!Et���.H���)-5~2ta�J#!����D��[!\$2�IZ�X��r�U��Z5���7ʾ1�3d�1���cp�2�`�B�L4pna���7�/�c�Q�h�Ӽd�\0c�'\$4���M�qw/0�F��*a�y��fM��2�fá�^B�^�2�A\0P	BvG	�͎\\�)��9��n�!\n���OfmM��w\$�'�a2P1r�\n\n�e�C� eva�AI�sV�� �4��s�J�:�s��A\r!�P��8YE\r����dJѝKs�7��쳩 [m�I�\nV�iIHL���\"M:uF��<��:pH)H,�9��̂�3U�u5�CN�V��e���E�Z�\n<)�B`��	\\B٭��\nm�N(�����cdr�I�ʳ�\"��=��\r��Uj1T0@��2��r�\0�(#v_����e^�N#U���d�K~���O�PW�9mx��l|΍�a,,7��Mc�Y�my�BzBCgL\$83�|�Y	IMs��9�V㒈l\$���i��I�aʖ�\0�)ڥ=�&�S���3�`7�&Y�0��y0����	�w�t7�����y�f�7����l�a��j�\r �<��j�S�\n����k2c8G�fx�V+u,��\\큟�2�(��kH�LR�	 b<��NR�`���܎�����@\n	-QJ���Òq�������<.�Гs`E�\r�����@\r�A#G�L�hwH��\\� ٛ潋��=�l#C�b��.��3��D]8JL����ٓf���*@��@ �y��=:�4Ã��G�4�m�YWV�h�v��Ay_`\$X90��73sA�l�v�x��-�\"��':X;,R��\n���VU.!2V���Bw�Hޅ_{��w��ߥ��G��.�ۜ\"�4�^����(w��w��!��B��Q*m���r������ln*xo\"F��F��[�14n�`���\n�J&D���d\$�)���e�i(F���^��1>�ʋp)��>�Bw���,��j\0PC;�%MmR)bCk�����W5�de�KG3t����<�/\"�J��%a��Js��.=�\\~w!yo@A�ٍ��T���7�}Y9���uFSk=�[sK̤Fm�W3�&'�T��z@�pA/�v��\$�JV�9F��Dy�a\n5���H�L�l%�g���'�g�������AM�ܹ��^�1!)ŧn�g��^Fb#�aH��P(�Rί�'4�,, �P���L(�E#�l/�OI�TqT����ρ q/jOBl<&\r0?-bc���b����(�.0f~�Z�p���n\0����� ��Ce�X��n��L8�ι\n˜���Om���0��pL����+�\nipCk�O�.���\n/C0b�P�w��`�R�cRnFƪj�����lb�R���X�N���H�.�'6+I�������\r&-����,n'�r;f\0����g@'/�[����\"���:�&@1u\rV���~�g����o�)���#oo�?�L~1���X��|pV���B?�ŧ	b����l<�!�\$�*j˸��:B����R\r�O ��g&v�qw��BM���T����}��\\��\r�)\"�l\\;଻\0�;��:\"^�B�g�dӤ�q��C&�wq���u#�������0�m=\"22;��Hw\$���m\rn�J`�ע��rmr��d���g'�Z*�*��r���c7�L���>�2T5o�h�X#��h��P�b��2��F93,?0�c/�'�R�g�+\$\n�bV���A���a��0���S>���4NT�3A4��N�Z��j���D�e�\\5�<W��\r �~%&���o���~��\n���pB�o7�&�r~�dO��1s����'�Ӵv���<\$D\$�@�fh��%�b�d`</7�p\nD�/�N��C-r�'�K?#�<c��N;��0D&R���(s�n	�޶ez)GT\$Uc�C�7�\0cC�\\D�o:p\$�-n[�ЏX�N�\r�Q-�1N���jn�0<�4l��p'�,�j�t}+oVY�� �T�b��c���\0s/�/�|<q|+&���Vˆ�n�����	��m��C����BnrVj1�K�\$��\\���e�?�#��\$(���	CV\\muF޿�2-aG2�<t�+�)\$�j5Q´�b*���a8+ �.��~bH�h3��-af�͢@�\r�";
        break;
        case'id':$f = "A7\"Ʉ�i7�BQp�� 9�����A8N�i��g:���@��e9�'1p(�e9�NRiD��0���I�*70#d�@%9����L�@t�A�P)l�`1ƃQ��p9��3||+6bU�t0�͒Ҝ��f)�Nf������S+Դ�o:�\r��@n7�#I��l2������:c����>㘺M��p*���4Sq�����7hA�]��l�7���c'������'�D�\$��H�4�U7�z��o9KH��>:� �#��<���2�4&�ݖX���̀�R\$������:�P�0�ˀ�! #��z;\0�K��Ѝ�rP���=��r�:�#d�BjV:�q�n�	@ڜ��P�2\r�BP���� ��l���#c�1��t���V��KF�J,�V9��@��4C(��C@�:�t���(r(ܔ�@���z29̓0^)���1�@��G���|���Ғ� P�O�H�B������V˻�Z��.@P�7D	2e���ޢ!(ȓK�h�7���%#��c�0�\$�3m���!\0�:C�՜\"M��6#c��6�(N�#@#\$#:�!�jGy�p��l��r�5���ۯ��끵�����	��)�(ֈ�h��Ӹ��Z�[0��C�֔!�J)�\"`1Gj��`5euT5�J9�c,~��.q�9��s�m-B(2��09�BKV�V؜��Y�7�\r�]���\" ���rB�;�1�x�3-3�Z%��.*\r��<�	�)ʣ5�Y#:9��0�h@A�XH�ی�@����r��b��#)�b ��\0�4��n���&9\r�H��Z��7Beʱo\no��2�S!��D�1�Ȥ�51Sl�8�s��<�s���T ���-���a��.�=1M.���ŌK������w�qJ[Dr=D�V�ͣ'B�bnN	�:'d𞃺|H�M@�%�O��?�]F0|Ӄ��Z/�R8R��[�����6�]b@W�/b�يWd�����rRR�.��Ȋ(udua�CBL��TQ\r����\r8���@��*���V'�۞-�E��Ų@P'�}�HZN�AH.t��Z�*o��&�e��eXmL:sJ��>\r��AЂ���P0�4C����#)QŔF�CqԄ�2��i%H��9B���i��:�\"JfJ�����VS��5R�5���OI�9t'H93CHk(Ԗ��LA;Xr!�^iShq](��wL���#�]d�ɾM�ɚ=Dh��\0�£EtBbz]Ae,�\"�baA'���6���C�n���L�bR4�f��,��P�#�e1�H\0@e�F\n����3��!4�C�A��HC�[��U��p \n�@\"�@U@\"���Q�PN-�������C�u��RS�j\n�M�4�C/NeQ��*0rBtN��%�m��=%\n]t��!�rvbΡ�]�}�����)�f�	�Re�0AX�:��r\nĢ��h<Y�bQ�ƈ�R�M\"�0���t}Q1#)��c���e��yK�<� ���{�U�����W9=�T�4�P��y�@��jZ&wّ��D��Ӑs���U�A���NJ�di1��w�2=��E��ο��*��w�B4���!\n�ƚ�&���G���`�BH����c�zLI�BF���F�%S)����&WFP����e	�r���48��'��A�J��[�\nd��\\#�v�͡@%�7c\n��Z���%,��xN�H�l�r\"xIF9ّ���H��1&��J����%4H��R��3�G������4�+:1k7՛�\n��H�k�4�Pt��]\$S�h/��\\�h�Nj�W9=����U�Nv9@�Еv����\r'�RW��q�U�e��=M`\\��׺�}�UY�u��!���[U�}�Du+U`�L;���B�hr*Ń0=%�wj�	�q�յ֙�{R�]���i7���g��f\n\rc#঵3�bѧ���ʓ`W;\\8V�\$zvg�p�^xy��{�f5n1�8��'{�U�D�\rn.�F^��ౡGXx���|t���.����q~u[}8�{�onKίE;u=�����]2M���3�3J	�`d܎�R�A�\0j�5�b��~�m�3&7���8?צ�ٻ[Ϫ�Fm��Z:����t5�s���K�Q��%���s|_(��3�]q��١Х�m��hE��N�y_E:�g\$Ǿ����6KY���� ��_fWи��8Ar*�Gc,uf|�}�j�N+�zS���o��~���'��)%o�}y�'dcsT��my#=��g��\n�x\"�t`�I�EW��ju8΃M��R�����<�(��oi\0o�Ez��\"���E����EL�R��%�4�M��8�h��T�a,J�c��O�3o�Ќ��Zb�T[��k ���q���l�&Ǡ�@ �`�- �\"�ʤ�]Dn��_`�o�%����Z���q@�\n���p>K�	�z�nf0�n�^=,<AN�lCLV����:[\0I�:,ö_ɦ2k�(� 7�>���\"�r\$dW��E~%��\r�>Q�.T1(c�:B�_���4�.����d����'b�,�@��F�f�b�5M��bm���O��˧�J_`��G��ʦ�hr�#bU�@E��\n\n�'Lkj|�0��t��a�jb\r���^�J�ŋ&J@�j���/�\0�#�dc�&1�0n�߱P@��BH�hJ�N@ qc��Z\nk�5���k& DA����B�O�";
        break;
        case'it':$f = "S4�Χ#x�%���(�a9@L&�)��o����l2�\r��p�\"u9��1qp(�a��b�㙦I!6�NsY�f7��Xj�\0��B��c���H 2�NgC,�Z0��cA��n8���S|\\o���&��N�&(܂ZM7�\r1��I�b2�M��s:�\$Ɠ9�ZY7�D�	�C#\"'j	�� ���!���4Nz��S����fʠ 1�����c0���x-T�E%�� �����\n\"�&V��3��Nw⩸�#;�pPC������h�EB�b�����)�4�M%�>W8�2��(��B#L�=����*�P��@�8�7���g��^�2Ó�����t9��@���u\0#�@�O�\0&\r�RJ80I�܊���6�l27���4c��#�#�ù�`ҮQS��X��Ɍ�G�C X���9�0z\r��8a�^��\\0��ʴ�z*��L�J0|6��3-	�v��x�%��T޺C��)��-,�-�M4�*c�\\: k��/��8��K���5���6/�r�;#�3\r�P��\r�r��\0�<��M�eY��7��\"�\n�L�i�����+X�4[��4�#��#�C`�\0\nu�b�/�3yؠP�3��C|@����8��P�0��R�����-�ph�Č��F�*6�\0^սj��#�nd�\"0)�\"`0�L+���5ei*.qXU�k�1��Ї4T�2����q+@�6ΰ�H�%K��9ꚶ�2���iyЈ!NA|/�\\<�2H�B7��3���+	l\r��t<��D�Ì�PAj�Ü��o���e� \r�p�aJZ*\r�Z*b��#)�-�4�Ap@)�[8�W^�4�s��.J��2���jܤ�������(�5t`��&�p�G܃1���5�̬��5M�t�9N����Oc��?�Ke7P���N�T�&��	�<E��t���䚦)v�Y�:*�@����O�p\r)�2:g���JkM��8�4�ӺyGo���}ɩ\$P��@��p>(��\n���hI˚q�\$t�	hL\$'����O��0���2>J�1U[�)7Ζ�.�d�<b(�Cf�i!���G#�K!�4�vD�\n��Hݖ���J��+Й��pȱ�	�ĥ2�HX�r���(����Y� �`RLZ�\$\r!���І��,NJ&����@g�KY5f��\$�nük��0��C]xQƚ�H�R{�\$��E\\��2&K����R<S���t�7.A\$L?/�L4�`���1�Q)I#��\n�I&D����C������1�:Ak̃I\n^PƵR�d���L��4Hʝ�B�0Rt�\r48�n�d�[�}֗�Л�I�/F���ΪX�M�fSF�S�RYF02��P\nm�RC����\\3��Rt\$;%�I�*�9#�nU�ac�<'\0� A\n��TЈB`E�e�\nF�����]K�)\n��.�қaA�|U�Z��?9',)��`�\r}vv��P�ڮ�*J��X*J�,W#gM�MT6��ʜ�,�P�rp΁ \r��;�~M@PV\"�##^\\�0V0Q��'W@�%C��BHhV���y/��ܑ@um�y6���KԖ>�5ꉀ�I|�W� �Ѯ���UH��Q��P�hcY��\n�\\��^�S;VJ�]^�\n��<@>J;�v�/S6`����c	+�+`���=T??������6d�ʾ�u�i�FQ�b��Ăt�y���r�B�T!\$	�DL�ߜ�\"D��Tt��2�.���x/d��³�)�?�^L�ZBF�N=0M�'��Ƴ�4��f��ݲnOǘ�*eb��Xʊ�d�\$���N�M[���Z�h��K?2g|���{�0�\$e,���+���:���\0003y��#�@�CHy�k�0G�ȱ)����X�KA8t��p��ZӶ�H�;i��H*�DޥJ�*� �K]�K�E���\n��Vy{BnX'E_��t��n��N8��Z6�ۚ���#��/<�{d�9{��TE�˫cw��ռˁV�|(���-�\"1�5���J�Ѕd5UEdp�\n������xs�%���r��=S�]m��z.j�\r�(.��U)���Yy����0Œ=�\09݄����NB�u@C�(h)a�vn:Z������v�h	騹 �H���g1y�-DL�U	nM\0`-�u�k ��\0�V��ȗq�N��v��n'q�Ts�t�����#EL�f(��Iܴ�T�G�h9)�8�h�T=VHs�' 0�uoj��Ҝ?�f�RI�׈��W������9D7�Z1~xm����	X-\n&�ݻ%>�w_9��+�5��m���s���a���:C���\0006z����Y_ְ/7�8|'�J�G ���ŷa޸���n���p�O�%�뮆vO�g���d�.D����R���#��/�3K<�p.uP��@\$p�������\$����x��.�k�\n����laD\"-����Dn�o\rQ	&��b	t?�O*���l��\nux`���>��&׍��к �>��<b����B�Y�\"��-�\0�i��B�#�]KP��H*CNq��bX\"�1c��y�0�N�Wż���(~c�\r�V���8�-�������Z��()�%	�QJ�\n���p=�r/G�%��1����˭\n-(�&I��h�f�ޢ`\$bJ\$�hf���gPW+f����F�L#.D���*b0]�� ޥ%��p%����DDl/��&B��#�E��f�V�v\$�0VNb�,��%�CfI�*�i# �M��1!�8�R\"�\"Q���݈��b@5c(��si�7d��h5�/�v)�BU�`@�g�w������\\c\nҲQ�'�`Sk��lFpi&8�*�+BI��@F�R�@�-�2�I.\"��,*�g f���ޮ��l��1,O���,�KHX�Z_F8��J��,��	\0t	��@�\n`";
        break;
        case'ja':$f = "�W'�\nc���/�ɘ2-޼O���ᙘ@�S��N4UƂP�ԑ�\\}%QGq�B\r[^G0e<	�&��0S�8�r�&����#A�PKY}t ��Q�\$��I�+ܪ�Õ8��B0��<���h5\r��S�R�9P�:�aKI �T\n\n>��Ygn4\n�T:Shi�1zR��xL&���g`�ɼ� 4N�Q�� 8�'cI��g2��My��d0�5�CA�tt0����S�~���9�����s��=��O�\\�������F�q��E:S*Lҡ\0�U'�����(TB��5�ø����7�N`��9-���A�@����A\n�C(��\rØ�7�.a�K��.r��zJ�RzK��12�#�R>\\��B�H*�AU#dp��DBA���Oj���E�8�i�\\��A\\t�/�>�K(� �ҡlr�j�H�h�^��dL�*J��-*�^A\n�f��øs�D\"��������2\r�d�{r֍�@9�ÄO#���Oh@0��0�m`�4��5H�V���`@U�@�2���D4���9�Ax^;�p�JR�l3��(���v9�xD���l�=�46�1��|�#���*��9t�B8I��,�I(\$I�M������	]���I�P�96W �q�^��13���7=�8��̫��d]'�(�f�Iy��_��JȂ%�0��e<;#`�2�	psO��KG4a�2sd|s���ZNiv]��!\"���|���)����V]��\$�n���J�d�#h#cwS��7=\"���#��\"�g��lns��^�į*G�R`�D�Υ�)Ob�At��N�=�}ߩ�PT�S=��4��S���w����a�Q%����{KS���B\"�t�Zc��M#MU�p��3\r���F�	B?4����݃p���SU6�\r�x�{�������O` � ���P�N(`��Ap#G0�dU0��2=J��A�39D3i�uܡ\r��6�8��y)O�CR����O�T�p@��r	W��\" ȥ��Xkc����Vz�Zq%k%���z�B��w. }�i�^�z!vJ��we\r���|'��,Jb���n���b���� D|2�����`p��j�^ ��J���_����B�Y�9hu��r	�]l��<�\$\\K�\$���m�j���!0A.U�)7��0��Ч��	~2�6��J�r�����̏	%���f H�P��*Xȉ�\r�1ɒ��e!�3I>��<�N	�����!�\r�9�r��A���4L\"����s\n� �(�3�Ėbx@Pc#��Q*)E�E!� ���gF���%i1�L�Y\r#�0��tф4I*CdUS؛3jm�+)TA�:���\$�\r�ޤ�X/`؁I0�AN:�jz�kuS��q@nA\\I5��C��a�_��β��F��Ubs\0���T�Q+�MD��\"8G�t�1�#L:��I��m�� ��&���%6�<���-E�H�y{�4��\\���n�G�,0��Ú��,6�yP��Bo�X�*��M��\n<)�G2�ҵ(\$�@�qC�1\$2?<�4R�h�V�XZ��j�`�rbE���*m��V:����jdT���xӸdo���Uu�\0��\0f����*�����P*[*8p�\"�A&���H%�H�x���QN՛P�M�'��@B�D!P\"��j E	��Z�u�MI��pݛ���\"���z ��9��(�!HPD�[�j]w��׺}��}�9�D|2�,���洫��&{\r-��\\j���ٷ4�g��ʡ-O�-�c�)�>&������l9�*Q*,�{�x�Hx��p�R\0�I(���\\^�4���	Q*�\$�1Y&�Ÿ�H�c��S�\$��4���O��iL2�j�ROy�>`*GI\n�v3)6��;�F\0 �Y�.��V�D��[[����G�.iH��-(���v&�����.y2�TI���}�� ���ŇegdG��q���^�Y��/\"]a6^E�����:a�R)HK�h4К�3y�+�@��@ ��\$4��Dk-��,�I����L�8���RL@ �������Q� �g)g�ln��	6�\"=o�]�>��6�lڗѳ?O?Q#�#��v@{ib�\"���`iR�y�vOc�)WyT֙�蝼�VR5�\"SM��t��s�J\"\"���)2:�������0p��t��@��W��Ͻ0N{�x~� �Ka�Z5b�9D�w����� b�s�B�9E�5�\$sa9Dp�#}�@̓�d��blU����H�G_gQ�y�\$b\$NP/�\$o����2�0��x��f�����c\r����y.bc�?O	���~q�����!���&��N���(�#���M(6�->��|uЁp�pM���M���@b0D\"0���a���.�f�n�����M�0ҍ�W/�\nd��xf��\"o\n\n^�oΫ�\r����<��\0p+��а�\nQa�!x�8,\"�Q�\\��,�� ���>�N��\rL��,V�P\$��Q>߇X�P��qO.�����'�ނ>��@�fE��\rfh̡N\nr0GN<���J�t�o�ɳ\n�����pʻB�+���du�>0�����1k\\�\r���B��F#M�v%�m��\$�s��q�`1E\r1[�`qe m� b�M2�	2 �!���\"a�_B���t2����6?B\0���|0�Vrã��N2yry� #�h���#m�i梲��m��(�D��ʲa�r2�\0F5&�)h�)�9)�0c�P�ݰ��� ,�!��QU�Ц��q�����q�.����2��R�F�'���dz�������KS\r��}��f	`�`�&NL��v�rc!�a0��v�p0�a��ʳd\\�Jn}\rs��nm��#�@/��x(�t�j���2�%6am�m\$.�s�\0�\"�6h\r�V�`�`�CdU��hÆ~\0޶��~eh9���`گ�<�H\n���Z,��h=��N�s�vgzt�T11g�ܐ �g���.�	��\r3�*C�1���&�pPxA%B#\"2b��\r�\\��8�C��d��D�z'�j1����j����+<�g�pÅ��qB�Na�ot}�q���-��1p�\n�07CR5j���C`���*�(�t��LTI	��2\n�����k-�Ck��&���p���D��.�ֻ�4 ��@�T����Ea\0{\n��E�\rFg���(i��a��`�Gc�iX`N�Mq�l�iB1H��.��H��IT���Ab#�=M��E,�F�E��W�uQ�t#\$";
        break;
        case'ka':$f = "�A� 	n\0��%`	�j���ᙘ@s@��1��#�		�(�0��\0���T0��V�����4��]A�����C%�P�jX�P����\n9��=A�`�h�Js!O���­A�G�	�,�I#�� 	itA�g�\0P�b2��a��s@U\\)�]�'V@�h]�'�I��.%��ڳ��:Bă�� �UM@T��z�ƕ�duS�*w����y��yO��d�(��OƐNo�<�h�t�2>\\r��֥����;�7HP<�6�%�I��m�s�wi\\�:���\r�P���3ZH>���{�A��:���P\"9 jt�>���M�s��<�.ΚJ��l��*-;�����XK�Ú��\$����,��v��Hf�1K2��\$�;Z�?��(IܘL(�vN�/�^�#�3*���J��*\$j�?��`��N:=3AprR�\"r���\n����r��I��:��R���,�A�jsZ�N�s�;�j�\0ԭ�<C@N��L�t��7Ml^��j��k2NNHm��Ðl��a\0�2\r�H�2�Am6���D�ޣ��'t�Z�R��n�\$��R�H!��\r��3��:����x�w��\r�aX�p�9�x�7��9�c��2��@*Mx���x�8*�D�1��v�󋮝�\r�o�l�4�P�6��͎ݵ����8��;��	�Z�N�z9^�ͺ8�OsN�J���d0�J2\$���8��g��N4�F��J����(�I;[8�)>4����G8�Ʃ�e\$p���u;A�*#Rַ4�k���I��;��=+�	;�+H��G��N�o�\r���il����D%,�h�P�����)U_X���1A��A�)˾�jTȏq�*JO�+��d�e*��k>`��}�|�9)�*)�\"e��'|�g�@R=�9Ыw�w�Eo�oJj��s�zQg�G�^�z�~Uc,G\n�4��G�r�}�a�T�Y���G�J�Z\naۻ����By��藗�n�;qN�9��8\0���C!�:'眉�(�L�#D���+2����%a\rރ�ͦ£�+��of�Ĝ���G��P'i9X����\$�������<u��4�Jn��fS���R�l��/)� ���!\0uL�LF��4uDx��5���a�mp�̓s��TnC�����)�̀�u�|IBG�i*K���Xk5Iw��ġsI��Ө�a�iB��Bʆu��G[ˁq.E̺R�]��y,V����_��7���L�`�\"%���n��C�����NY�*���G���uHq��F��.JNeU Ȗ\\�\"yglJb@���)�r��5��@\"�h�\$��e[>I9ז�Z0L5¸�*�]+�v���eR�^��}����s�+�9�����T�r��n�S&-�~|+e���a�:��� ����4�+\$�ӣ�Y�kwp�X���'T��z�)5��	�_E�:q�{j�1#�>��5Y?Պ\"\r\r�U��P\rY���C�G��,)5�IINP�\rAr�]��X^q�T�������'lI>���Y	XR�����A_&�Qê6��\rxu��-Õ0���&��2���W�lD�+�X�oQB ��եQL��]�\\���\n�<��>ar� �٤;M�4���Xɤ%'�#�h�+r8���jN��%���\"�*f���b�[�E�v�����99A�b��Qf;�&��qGj��r��sO�P��r�{r�ω8q��d�Ė�9x��i?\n<)�J���}~rPԒ�+�m��4�0|���n��Xl�c	�|*�>Cȹg[��IܝI}yn�d�NS�V���棓O)�gǭ\"�7�G��'w�`��5��P���&u��F.��f�\0�\$�A��s<�;?0�� ��G�K�3��|O�B�(YJ5/WQ��rT`��7681f�'��&���Vw��54�pw�ɛ&�֓Hm�˧LG�e�)[Q���r�\r\"d7T\"��2i�!��奕�L��2��3�_|���S��l^MԦ�u���5��X'{����F��'bȪ[RW�6�p�̒�ꯃU)����q�'�/c���T�(7�J�U��<ш�Ѣ9�&�������L�w�v�P��p�!��>dS��o�Y۬���K��\n<�U���2�n/��n��T&�#���l�Φ v�)�|�Q;�ꓝgԦMSe��aMO���E[�d��(�f��N?|v��޹}J ݡv�)��֘�|���i�b;��f�ё���B�T!\$=�8�0�c����Y�h:|<}k<���Q���V3���+���!R��Z�bW����o���Lg�|����U�m�7]\0�'�j}����XE��e�\$\n�����Ϣߊ�f����l���lŮ���\"��\"v+�⎜�N�Nf���6v�&F�V�\"��2�*,=��/+�(|	�8�4}p+�T�l\0�l�M4�	�E��F��J�F��p�����꼨tN��)�h�J���	�N��=��NM��� �ʪ9�~�,&�\n86���vc�\\�b\0���Je�z�����\\4�_�V�����飐7�ҝ�f�������j�m�ړ��K8n\$l�Cw����i�9B�\"0Rj�.� t��\$�Rp�.�����?�r�j�y\r��2(��e��(,N��4��N�l1%�\$ P�g�g�1 ��}M����t�����i8�M�(�j����)1J�*�(���Ѵ�0v����(����.��dΊ�7qv���p��ދ���.&֮�u��\$�6Q�|D��B�\"�T챁fq�;\"n֝��E�ܫ媋\$����'��c{\$�\$��Ӭ���PDӮ�'p��o�n���r����_�7'��AJ��q��G~�k��\$p0b/��������Rц�-���L&�<\$�@hRhn2�(������mo�#��P��J������q����.V�&@���#0�������D)��\n���t�7\0m�e�14�Q�/�51�0T�J)�:�rW1�b4�Tr�6�}S?6S{6��5�^~���\"�8�]8	g4��8qX��^��n��j�.7qP��;��A��y��L���J\$�\n�;�5��1�� (�=�71�\$�=��3�3�=8cN(Rzq%�9FY/��Ks� �,��e�W+���.��P@M� Ix��uBT4o\r�(�o;�390ֱ��B����\r2��G�FI�!1��_\0002,�CseFoG�2���{(��AQ���\"�9�i9��A��|����4O|��[K��?q��t�Kg-L�@���S�t/{A�K?�� ���\0�G\0��ga6�t;A�4�U�J姗;�4�4�N��T�\$�(�\${\r� ���֧�*GZ�js;��慠�p��+nA�htM���+FyE\n�(��\$�U3B�RV-��\n���(\"���O�GC�\r���̫�-���K���0WS�Td�貇(K�Q謓�2��8J4�sE1<ތ��h�P��T�K*�R��X�oG+/�� a�k�7m1Z�2A0��]���v%�v��T�N�@(�Jd�R��E��U�Q;��������i8�Kr��ye�W)9W�ڡ�;ZP���wFm�F��g0`��,�v�F��a�~+���꒹K���d//F�I��8�-D�*��m	����C\rO10�2�Ӣ�v�RU�@VYV+�ǵr�Z'm�(�hOuC����.֞�\"������z�<H�7Qy��W;eU^�w8��S�.�j.�mdhGē���V�b�A\r����?�RfMA� v�XW&f�>#�CI�ͨ���";
        break;
        case'ko':$f = "�E��dH�ڕL@����؊Z��h�R�?	E�30�شD���c�:��!#�t+�B�u�Ӑd��<�LJ����N\$�H��iBvr�Z��2X�\\,S�\n�%�ɖ��\n�؞VA�*zc�*��D���0��cA��n8ȡ�R`�M�i��XZ:�	J���>��]��ñN������,�	�v%�qU�Y7�D�	�� 7����i6L�S���:�����h4�N���P +�[�G�bu,�ݔ#������^�hA?�IR���(�X E=i��g̫z	��[*K��XvEH*��[b;��\0�9Cx䠈�K�ܪm�%\rл^��@2�(�9�#|N��ec*O\rvZ�H/�ZX�Q�U)q:����O��ă�|F�\n��BZ�!�\$�J��B&�zvP�GYM�e�u�2�v�ğ(Ȳ��+Ȳ�|��E�*N��a0@�E�P'a8^%ɝ#@�s��2\r���{x�\r�@9�#�%Q#��E�@0ӎ#�0�mx�4��MP�փ��	�`@V@�2���D4���9�Ax^;ځp�LSP�\$3��(���~9�xD��l\$׾�4\$6��H��}J��Q0BXGři\$��\0��4�x.Ya(9[�/9NF&%\$�\n��7>�8挌�9`�O\$U\nK�3��v���T�nT��YL��1:�>B%�0��eD;#`�2��!@v�rTF��,H��2�dL|U	�@꒧Y@V/��D?��̈́ű|c�\$�ʡA�h\n��(��C��0�Ϙ�&<�RZP;Lf�<s��=���-x6���iRe9�sr�=�tOk��ߔQ�߅�����\\#��4����}�6�1Q)�c�w�w��*Jܪ�ˁB\"�/����M;SW���3\r��Y@PK3�M�`P�7�W��<��N:�U`͢�`�ϰsXA�9?@��	�(�U2�����������!�0��0�i�X��@HS1.�v\n2P\"��:P�?���%_[�\n����������K����*E�M�CV��J�Y�=h�5���2�Kqo�:�C��\\��/�����TB��B���ǡwХK\0�\"r���,@\\!�_,�iX�D匲R�Y�Ai-@�nA�m�վ�2(EK�t��\r�m[��4�2%R�d��XֻpA��Uƨ�BD�*L��Tǘ`B���\r�T�T�lo��ˠ��S%!�@�7��#�o��\0 �nq���Ta�U\0�\"�Xii!��	��x�I/���#Z̈\n\n (i�t�\0(*����)`�h��<'�A�,���`����c�*�ZCln\r�ed��9CzrU��A�;Ҩ-D�T�q�)Y���a�V�p���N:�\r������(w9�4K\0��` ���׸0�Nx�K�|�y�3)(�t�L������/4�@�!��\\�9}MHc�'tPBI/|2�JlU�\r���ՎZXsTA��؉&T�IA���+Y�L	�(!@'�0�y�p�OT4u�B�+\n��\"�ҙ`�-�T)�<����;!�H��X�QNQ_����&)�\${�&��84p_��U�j��\0���\0f�\0�۫\0�(+�d��S�xf��A�	��2.X���}�6f��p \n�@\"�@V\"�����qH��1�*��X�G�u����t�y�h�A��V����qN���OOE,9s9oa�͸�>=7A`!��u���������5;1�ՇrO=�c�0���������*��JA)\r̝\"q�P?��+�@J�� tv�y�U!��\0����K��ڢ\"��v�LY�\r!�Q�OZ`S��R��~�T�3���FJm�(w`,\r�<F%1`�\$�B<�b�]#/���F����a�\$v_����l�\0]���6e���)�(e���q)��[@ur]GT���ز L�'���J7y��`�BHa��>Ǎ}���Y_����\r���r�A\0/��N±HoD&W�_x�{����q�{��\$�5Z.Z�S��m�\\��G��7�&��b=ʹ6@�\$���쌑���&1�ե���ZKɊ;,�^��CC^��K����#^\n�1P��A��t�4�]R�K�����1T�@��]�<�\$c�:m'�2��f���&�Lʙr���vY(Nt�d����3��q�ķ`�Ddޱ&)�؞�{�h�_��4ڻ\r��F昇��>����I��_ɰ��<l4bS[i1�~\\Qf.��z�D8!�1�w2Q��_�����_�(�o�����n�r���|S��~��:�a�PĤ�\$����G�Ȥ��̒?o��0ˬ���MnFd���*�T�춸0 ������N<4��̣\0��{�����m���N�*۰\\*fJ�O��Z��J�M��Bs��m�����t��Дذ��By*!O�/�s'pN<��Z%b���gFx\$�h��&Kd�K\0,��������#�v�A>%��O��J 0��u�,+�+p��������l��a�2�Tu�2Մ�p���&�L��pOW�L���p�,�����;P9���IdY�}Qn�<3�BZ�1�td\$-�;�\"i�r�m��·�7Pg����g�xa*j�p�0���&#.]�y����j\"r�!jFT�K������-� q@�r 2�a!��)�E!�-���t>��-�P���\r�o�rLF1%D�%��`\0�V���e�bvj�<�4&�Ge\ra��׎(��R,�+\0>��b=Q�c !1c�@#�;E���R�������Qojh\r�V���`�D\$V�iC�~ ޱ��~�p( ��`ګ�D�h\n���Z8�+>��#>�lpأC\$aq,�̪j.X�#3MC/`�/���dz�m��2�^	�޼E�|#�9`6Ůd\"DɀH��t*2,�Bk�~�#�A`��*��P%H~�8�3����0�%H���%G3+D���x�q2�4��C�z5�\\�@�[�B�S-L9�;�E=#����:OI�F�k�B�p\n�k�\0\r�-qB�@a8lf�@�U ���/�:�1.ѤjJP��_��S�8��'���0��gp\r��d�%\n�/��:*��vLdtL�t#�";
        break;
        case'lt':$f = "T4��FH�%���(�e8NǓY�@�W�̦á�@f�\r��Q4�k9�M�a���Ō��!�^-	Nd)!Ba����S9�lt:��F �0��cA��n8��Ui0���#I��n�P!�D�@l2����Kg\$)L�=&:\nb+�u����l�F0j���o:�\r#(��8Yƛ���/:E����@t4M���HI��'S9���P춛h��b&Nq���|�J��PV�u��o���^<k4�9`��\$�g,�#H(�,1XI�3&�U7��sp��r9X�I�������5��t@P8�<.crR7�� �2���)�h\"��<� ��؂C(h��h \"�(�2��:l�(�6�\"��(�*V�>�jȆ���д*\\M���_\r�\")1�ܻH��B��4�C����\nB;%�2�L̕���6��@���l�4c��:�1��K�@���X�2���42\0�5(��`@RcC�3��:����x�U���:�Ar�3��^��t�0�I�|6�l��3,iZ;�x�\$���n �*�1��(��e�:�&)V9;k�����\0�C%��܎\"�#n\n��N�R���0ܳ��hJ2K(\$,9�7����.\0��+���\r��膠���0�8��@\$���+�Xʐ��̖�(gZ��1\rc�7�#;�3�S�\$���*��c��9B�4��*W'��RT��8��BbT�P�*�3�4�2�#��fc`����`�0���&��5�ir��+���K�rٺ-ľi���+�x�L��#��c�;b������.6�r�1�q�b_�G��4�l�n��#l�#�B*Q��n�7#��z�6^V�G,KR��!P�b�C��̨�3�d�f��L�1���ދ%cp��íB��J�7��u5g�nB���4�7c�(P9�)\"\\�a�(\0�!�0��8o#E�9��@��3;���g&G�+8qN��7�@�R9�\$�)o�>��ql4��������2gė�C~K�� NO����Ƅ	HdN�p�)�B��*�U*�;��^P���V����б�\"�Y����� S3�3ǬR�Ta������A�;+�e�H�*fN��]&\0�Á�/P:\")�O�\"�U\n�V*�yC��V�-������p.�/��\0��J0&Pu���r|,f0�0Ԗ�# !�8v�G��8�a�v����\0�G6��eeL6G\0000�b�o�3�W/���'�1y�r�00��@ȋ�,���ڤ��*\r!�7�b�P��.-�:�H���P	A5<.GW�X������\nc��R&�ZQ�jO��u\$ڃxw�d99%�G�\\qM��Ň����D0���&��\r����Er����5.ZPUG1��6a�2�@�o�#���4��^\\�O,�,6RĞ�X;P�F�\\�K<@Ӕ\$���d�}OJ��\0j\rQ�,����a�ONƠ���EQ&Ѫ\"&x��^͠ \n<)�H6��h sM<_V�cˍZ\r(P�(�zT�5&���P��*� l�5A��p���9h\0�V��}M\"U� 1[\$����2�mI�`�? �!vI��\0�]�bA>漮4dA)'F *X���S�t-թ��sJ��,����6!V'b�\\���%ԍ7Qɘ\"U}}�p�%�X:KDT��T�:�d��f�F�د\\� �4�}��#�=��J�,,���yf#���ż@Ĺ/\"%���(c}�K���ǻ����²5��� s���0��ݳmH(J\\K\nHOh0��?*lT����7Y�t�R��8\$���ᗳ:μw���˼��8Lc+����˨;�)\0�P��}��<��g�0ӟ���)\"���Cs���6�!Cd�c�,���1E,�̀�FC\\:�<�\"u\"�x��Z'l�S�3C}ַ��._�9���ށB�\\�\r�E܎�%�g\0W3���V��� 2��m�Q�!P*�s����ִ��	rȽ�V��C�Je���b�h�(){p��Χ	a�W�5&F6�3B�x�x��.<P_7�,t�Ʌ)�*Sr=�8tn�|U�r�)ƹZe����Wl�R|f|8���xA`��s^1��W\"�|Ӏ�����1�3��ޯ�*7Pέm@�ﴉ��\re��6r|g��b_��7/e�κ!�!N��O�zp]��Э؈� 3�g��4G�����-i�� �\\�;�����\r�X�����\n���\"�I=O�\\��N_c��;F���r�~[���\$��g�)���Y�s�>{���g���y�5b���d\req�c)��3��:��p@ㆶl,;�`95���o�_w�����/\"��LӍH��rB:5�:%���.��&\0Pl\"l+�����+2Ȍ^�fD��El[�`MD����LS�.��8)�DxpI�h�/�\0����N.�R�nzᬝ\0�<��M�[�{�V�B�j�P��m�	�+�`��B���%�t�B\"�O\\��nFP��H\"/�����\rGNwn��\rTFF�7�:���[J�\"�,���B<c�\"#��#��}���J�2��b\"6\$^���!V8��=����F���7�.*M� (��i���Z&����|ϋ��\rf,�s� x\r�ҥ�\rpk\r�|���M�1��ou��sO��%�]C�0-��N���)���ͻp���������0܇y\n��K�\\�GTQf<��N��D�pC�=Ч	Q��O\\�����\r��-іv�H	p�&h���!�lZ*A 0v[��?!��#-�3,�\"��9��\$j���b�zر���%m~�q�BB�%���!�O&���ܭ�'��	�Iq�;�HĐ)N�#���Z�K �\\�ҢI1����\0ҹ��-R,'4�(e���%�/�\r\$��g�Y�gЍ-�-\0�� r��R�\$,�q��.o��d i�`h��	�;/R��R\n�.|�,��S �Ђ��\nQ�2P�¢He�\r�Vg�`�A��fX2�<Xj��;\"z�I@�j�~`�\n���p@h~�`�\$���n����4���N�2c�\"39��0|\$nRg��%��p	��+��i �+��8��0��,b�/d�8�B\\��\0!Bt2���=��>�9%��\"�J(Dk ޷e��CJ, �@��K�\\I�fW~�d�?����e,-O�tĲ�잏Xn�X�loC���,24/{;ϼ*�\$��Z�T=q�D�N?��2dZ���\r�km �',u/�Fϼ:E���Th�\\�Ft�f�&\\H��ogD��anD,\0Fr�&�B%��E��E#�H����\r�	�N�2=��-�N��o��mfQBlp\0�D�\0L�0�<��&�t�ǅ���V<��HD�=�J��-Sك\n2)d��#39`";
        break;
        case'ms':$f = "A7\"���t4��BQp�� 9���S	�@n0�Mb4d� 3�d&�p(�=G#�i��s4�N����n3����0r5����h	Nd))W�F��SQ��%���h5\r��Q��s7�Pca�T4� f�\$RH\n*���(1��A7[�0!��i9�`J��Xe6��鱤@k2�!�)��Bɝ/���Bk4���C%�A�4�Js.g��@��	�œ��oF�6�sB�������e9NyCJ|y�`J#h(�G�uH�>�T�k7������r��1��I9�=�	����?C�\0002�xܘ-,JL:0�P�7��z�0��Z��%�\nL��H˼�p�2�s��(�2l����8'�8��BZ*���b(�&�:��7h�ꉃzr��T�%���1!�B�6�.�t7���ҋ9C������1˩�p��Q��9���:\rx�2��0�;�� X��9�0z\r��8a�^��\\�Ks�=�8^��(�=ϡxD��k���#3ޖ�Hx�!�J(\r+l/�c\n\n�(H;�5�C����5�oa��X�BK��0è+Rp���#\n<��M�m�舖7��蔟1�J��o�4�3��	ժ2G��i[B3��Eq�EB\$2;!� Rw�jZ�\$Γ&3�p��\"B�����(Nz_*��p��<-�i�)X�6J��С\nb��7��7\n�d��^���B�9�	k��LK�)���q!莭��&,�>����:B*_�lAe.�x��-p\"[]j4��d*�(��'#x�3-��K'��j)a\n��z:���l�ƃ���kwĕ�H�^��)��(�&�_	,����oҳ�J*\r��v!�b��1��棅�g��ct�O|���l��3�2w.�GУ\n�.��^�&(��)�:�4����Jԫ�?�,����G@�C�4]G�#�'+�/�2��p/�����Ҩ�)>�@���bl��9��#�\$��r�A̸VP[I*:H�蛴�-Y0Y;�����2�QJ1G)\$��JiN D� \n�`����B����F�C8eHf\0�'bZI	�N��8�N�q�׆�i�NA���غ�Pr3�h0�c���RgM!�:��ؒ�H NI��Fcxg��o���\\��7���'A\0P	@��pPR�I:1]5��U\n��:�X�#0A\$�Mm`��pJ��'��22H�-�˻\r��*��ވ*h5��:*���ʟO��mp�CHK�D�9\n}�a:A���d�&#�!�Si�P���3[Nn]!����}����J�yCo3\0�E���z�H��&�+�\"�;�P��Z�o4\"#�2T�!�Ž7v|�j��\$b��d�hS�u\$sj~Ux��m4�.FH�V���K\"rOi9�qfX#I8�\r��3�..��oL�+(i�3��ƹ\n4iA<'\0� A\n���P�B`E�k�e�]	l]B4��E�ǒ\n�_m�c�I,�g�p��H�\0�F�R�gH�Fǘ�^^���H����ؑl#��	Y��hHY\$� �/lHm�\r�4V��-����l��p�{���a�4W�EN�\n\n�B.�t�*�/�Yݛ�Zn�Ԝ)O:4�^�i��l)�RB��Iz-�(!�\nZ@PJm,�����CJ-�@873�|�r�X��z1SXe��6�i]��HR\",����3'���u���({�d�cSWd�>M���lECv+�'n���ڑa�z/}~��*��w5,Ðp�g�U�͝��& C��/M\n�zF��h,����&�E�)�9D9���x ��7\"������� d��nK��[��R0�K��0t��>�E��v��_5�<��ή�E��K���cKk>&Ei�%JԉS�1��'l�s�CUC\n/_��Uh��C	�Mwn�\$C��N�Ќ�1eP;Xp9��ce�6]��Oq��duVq��0RQf{/v�4�H\\�f�l	.�)[nս�3/o��e��rZ��k�f�5ێQW��|���i��ז\\�	��F��42݀7��d(������P#I�\\�j��Q�!�a.~w�;���t���Y�\\���%Mx:�y�[�=�CN��Y\\����IއzD`��^�mmL��DW�sޏ�9_<y�� Ϯ�Z[�Zq򇩠5X�8��u��/B^\$�x���������D���E���Q�KHa���U�y�2fUer�QQ�8aO�[	mؼs6�\\���xd��<�;:%T�J���{�&-[�y�X�`B�~B��bWbg�^�u8v���������:N\\���~Dk۠v��2)���4��������j��um�3��H�2����\"7��+��FjR]xk�ÙI��ˉ�����z�i���W\0���(#��-�����ZXO��-�#��b�X5C�\nC�b��P:�ϴ�/���@ŏtw��0C\0��pN�+6�V�M<CO���V�Σo��s�R�pvF����\$�4h����CG�;�vf�ĺ��!���[���\$:p��Gâx/�'��d��M�����\"Jd\r�Vb�g �#T(�,��63�* B�%c8���(�hɨ�\r�0\n���ZJ�n���k�TKl(N����.v��48K�K���BƠ@��Z}�2H\"��g\r�_	�n�Py��У%�%ɮXJ���)�\r���>�hF��.\0��o/�����wg����\\�����6&izjMC\\Cjo��a\n��u.l ��N�c�r�Nv&��^��ބ`�P��\n��\n���n	�k��;�\$��^1�,�\n�4-�%'�EqH�g\njN��	�õ\$�M##�r0���-���9\0��@";
        break;
        case'nl':$f = "W2�N�������)�~\n��fa�O7M�s)��j5�FS���n2�X!��o0���p(�a<M�Sl��e�2�t�I&���#y��+Nb)̅5!Q��q�;�9��`1ƃQ��p9 &pQ��i3�M�`(��ɤf˔�Y;�M`����@�߰���\n,�ঃ	�Xn7�s�����4'S���,:*R�	��5'�t)<_u�������FĜ������'5����>2��v�t+CN��6D�Ͼ��G#��U7�~	ʘr��*[[�R��	���*���9�+暊�ZJ�\$�#\"\"(i����P�������#H�#�f�/�xځ.�(0C�1�6�B��2O[چC��0ǂ��1�������ѐ�7%�;�ã�R(���^6�P�2\r���'�@��m`� rXƒA�@�Ѭn<m�5:�Q��'���x�8��Rh��Ax^;�rc4�o��3��^8P�@��J�|�D��3.�j����^0�ɪ�\rʜn�i\\N�1�*:=��:�@P����ORq��ڣ���jZ�P����ҕ�.��0��*R1)Xu\$WjH	cz_\n���qt^7\$Τ�:�A\0ܞE����0�:���0���d%�Ȱ�:��2�)أ\"-'�Z��b��膲\"̗�iC2�nS	 l(Ε���獰��l�cz)�\"d֎R\\���,�������L�\")ɑۮ�C��뵐AYdѤ�?�=d\nC,��BH�9�V\"\"���k�v���ϻ\\d\"@P׏�6k2���`�3e�Rj*�r̷b��8�W���;ڣ6 K+������3Ī*��%4�2��R�L(�ȼ�)���:Yn:���v�Mz��2�<�2��aP��\$ �>*���O#8A3ӈk�1��K�Qh5HRT�-L��К��rT\n�2%fX�@>��X:�l���F�T��q�d�����\n�%D��rn�N:�T���`�����~�D���.�T�\0�}P��B��Z�U\n���vLä���� ��KpeD��Ud^�5G�P�6r~Q�eIp4��R؃Q�\n�=��x�	#4D5��RC2�\"���7LAvj4���A,h��0\0��y�8H%��\$QJ�#��(��\$�]\$m��#�q�AUw`)~���Ǔ�4a�Қx^h��S6i�=�@�b_w������U䑍l�'�*��\"6\$���V�+��&6r�J4��L=�RnNI�=LT��H�9��!�D�6��I\"���'���q&qD�4NX�%����\0'Ed�?�f��5\n<)�@Z�fiP)e6y��\\��2 �8�y�H��S��R�\n�yxY��2�W1E5�������CJƘ�S����+eE��H�B�mG��b�K�E!��?	�`O	��*�\0�B�E\"��\"P�k��^ȹ#���u\$J¯�x���dn`j�\n���ңTvI�[	ᶚp��q�<����94K,���Y�A{4�4�mV������%�pA�����\n�RG�6�I�b����������R �B,I:bw��9�b�fN��1'1~�{c�;���J�]5��>X�2���yNa7XR<��RiC(wY�B�6�X���J��\0�V���L9���۠��A̫��3� ��;�X��-�,0�8�\r\0��Cb�H�����3�p��(x�������)�`Y�\$�{�^\$���*@��@ �5���[/�poо��8E�Ðy\"���e��%&Tȅ-�H\"�,�D�L��M����b��ht�q���QI��;��%�Xdi���g�Fp�a�^aϧFI��9���Œ�:9�z\\9�Ӟ��fN`:b�\"��I)�܋�KT�0���[�:�K���6zl�\$̆�	��(�ޭ��@�8�^�����A)�:����;��P`(\"�����,FD��H^Lʖ�*Kt �b�H�K&	+��^��>w�`#�Ry�Uȁl~{|(B���7�o���L�pS��x�2\r|Z��;\n���ٔ�;�4.S��!����5ig^&:�6đnY� ��IGS]�4���8\0�/�/^��(gD��㞏-ZU�֣��AΩ?\r��)�.2s����K��G��t�̶��;�Lo���dϹ�p�.��;_m���,ݟ�wʸS9󉿸��TV>��	/��~��\n�P-Ci��������8LL���5*�ӣ�>��k#D ɗ�	�	EjgI��B���g�А<DGM|f�	O�&%X|nFx4�۰V��z^�`��~|f�������֏_�{%h[6M�bB���Nԓ_��?���=rc�9(�&��o��,Z����ܷ�f�&�n��D�f䥆`î�#T\r��;�h�lU��� �0>k�PH��Z�N�F6c�[F��LkPL��F8g��=�znY����\$�/����O��0�ìG\0O,B�\npp[�A	���,�X�tFO��|Hp���=L~H����аLO2C8bL��Pn@1�&h���!fL^G¦5\r�Αưr�\"Jjn\n��\r\$����vcT`\"�\nm�f,�\\dw\r�=��*n����Y\0�`�#�B�c&�xrBz&B���1C.ʘl��H�v`�\n���pCg�w��&���0\0�-��� -:��\0�#���n�#4(\">\$/���W�^� ��\0�̴n\"��&m\r����Pŀ@Q�\r`D@�j�oC�6Xl�;bj	�t��Zp�<�P8��\"�9��D%�^��C(\$� `0���:0���.B��2D�RJ�b%�-\n\0�6�\$�Г|��W\$��(��'�*c8��F8Q 'K���m�)'��8e�\"�I�d(�BJ��L.@mGP��x���+��g��\n�*n>�ĖYdx�tb����:��G2蕥�^��	<%b�	� 9��&�M�NOb�!��F�0�.�Rt�2����7�W�TC��	\0t	��@�\n`";
        break;
        case'no':$f = "E9�Q��k5�NC�P�\\33AAD����eA�\"a��t����l��\\�u6��x��A%���k����l9�!B)̅)#I̦��Zi�¨q�,�@\nFC1��l7AGCy�o9L�q��\n\$�������?6B�%#)��\n̳h�Z�r��&K�(�6�nW��mj4`�q���e>�䶁\rKM7'�*\\^�w6^MҒa��>mv�>��t��4�	����j���	�L��w;i��y�`N-1�B9{�Sq��o;�!G+D��P�^h�-%/���4��)�@7 �|\0��c�@�Br`6� ²?M�f27*�@�Ka�S78ʲ�kK<�+39���!Kh�7B�<ΎP�:.���ܹm��\nS\"���p�孀P�2\r�b�2\r�+D�Øꑭp�1�r��\n�*@;�#��7���@8Fc��2�\0y1\r	���CBl8a�^��(\\�ɨ��-8^����9�Q�^(��ڴ#`̴2)��|����z2L�P�� �3�:���Եc��2��Un�#�`���ˈŁB��9\r�`�9�� @1)\0�V�Ah	c|��Gb��8Gv��H�[\0 ͣz�5��@���0�:��p���R6�P����T�\nc\rΥ�å��0)ۼ4�C:6�*�)�,��1اx2HH*)��d3��P���e��_c^�����0\"���k,�(M0���H�w_W�YaGZe���cP�ȁBzF�J���0�� �z��(-5��H�8c��[�7�ζ����i�,v\"Ur�E02�����	���3d���6d����A6��x�Hv2++K���|#�D:��3l0��*�iQ3h�aJR*���ؿL�)�Hߐh@�5.~��2,23�͘*��8ε�Kb<�R*\r+EO�#����tJ:�p� 3�A<޳��:P��BNQj5G��^�j����@���\"�%#L���Ca;9�8P�̖zFsH�7�0ܵC�)%eD9�\$��C�j�d��P*\rB�u� �J9H���`Z�m����\"A�t7��||��z��՘Ü��C)p���P��C�;&�`6�0��[e<!�iL���ap)3�E�F#�A�H0�d.AC��Rn��=�b�Q2�!ͅ��qci-�̔��Sj�1����C��V1��E`��-�!�Q�\\\n\n())��=B�\\�UA\rx�����;a��R�RɢV	Q0��_]۽w�!������#��>B�FMbi�.�\$ԧCppM��8�4�Hc\r����\$���(0���`�WI�\$���J���Hr�E��Aҗ������\"\\�~ZSR[-\$Ԭ	�q_�d3�b�`\0)��#�jNh��s)���F��b�y�}��@�	������^\n�d�JB��9Eh�uk8ߑ~'�Zf>#AY�#�x��\"H])�\nl��fl��F\n�A����Zqt����Q�R��\r�H�\0�h�٘O	��*�\0�B�Ek6L\"P�l�[��\"�b��E��&T��[�\r�{dȓ��Hl��ۛvEРFj�1�ͣ��څl7\$Ϳu��ّ�g`�FE���QkGm�\\���OaARl��e�&��@�=��EDC��Qb�	_,e��?@&#ץ	��(�(#�Z�KJ��e��7f�P:�L4��w1{�U��y�C�oI]�-�T��t�(�Ø�Z`��-����2N�Bi�-���\$%mikW�LH���Z^�R73;�dZ�BA�&J1�ɋ�V_(=�N%��lW�ܶ�n���!'Z�@��@ �D)]ΓWI�t�� 2�P�o��v'����@ʾ�1A�k�-`Ynfɴ3EÜ�Zu�F.�Ut�L):F�iM,4ƚ��,�Ս?�d�)�s��@N�'�CV�J4�<��,h�A������`�����M9ǰ;����#��k���L�A*��ؠ���Q��\0+�P�Rh�u��gE�p[�-n�ؔ3g�ޫ�c5{����,Z�''dŲ��Q���H�)j��@n�x��V�˻xy\n��p�q��s�6%С��1]P��`sTl��nk����V��6-��(�~A�|���doʄ�(h�\nt�g|X9���E�s�R�U��.8��2��u�4��r�5�C+1�������� 7�4�[�Y��~)����QJa!?��Ǻ����θ�d�=��e�n�Y�pyW7���X���j��|�N�z���-@upi��td\"�b��E�ܺ�؏l=������{��!?��C���n�+�m�-����� �)]�ֹ�^��7�S1�)ӿ��v䈝N]޹�\\�/R�O���e4��Ʉ����-�r�f�6&�9�܍����W`�zO��S#�����!B��z:cz�%�ƌow\"R����.��U�g�\\i��̆컃�l�f�\n`�M��	\n\"U��f�����.��:�RH�<��6�0�o0�p��f���#N<��FxM��/�Gk�k�J`����;`�( ��60ej������\"|p�*Ng�a�@�0�����:�λ�A\0���\\��~(#��P1q*E�,��REl���v��^c2������i�m���✣�lfL��ܼI�˧O��Rb��s@�[墙\$p_\$�~;-6�<�M`��^ӯL���@��`�fB�b��,�}J4�Z5������LL�\n�\n���pq)�<��Y�S�<\r*�7�Dر����d.��\"���f\0X.n)p�m��C�8�#*9\"C����H8qʩ��:j2A��U�j����v ä	����G�d�5���L �h1��ņ��n�r�P�j#��#�h ��2|�B��Q&�~5(C�\$Bf2+��l���(��Nڦ\"�k�#&n�c�	��,���22ŦS.m�Wk��mX�h�p�kR��lj\"ڷLj\nf�!�N�2x^`��C�C%	���|;%�)��ȝb:H�弄�";
        break;
        case'pl':$f = "C=D�)��eb��)��e7�BQp�� 9���s�����\r&����yb������ob�\$Gs(�M0��g�i��n0�!�Sa�`�b!�29)�V%9���	�Y 4���I��0��cA��n8��X1�b2���i�<\n!Gj�C\r��6\"�'C��D7�8k��@r2юFF��6�Վ���Z�B��.�j4� �U��i�'\n���v7v;=��SF7&�A�<�؉����r���Z��p��k'��z\n*�κ\0Q+�5Ə&(y���7�����r7���J���2�\n�@���\0���#�9A.8���Ø�7�)��ȠϢ�'�h�99#�ܷ�\n���0�\"b��/J�9D`P�2����9.�P���m`�0� P�������j3<��BDX���Ĉ��M��47c`�3�Г��+���5��\n5LbȺ�pcF���x�3c��;�#Ƃ�Cp�K2�@p�4\r���Ń�����`@(#C 3��:����x�S���C�s�3��^8R4�&�J�|��\r��3?)��	���^0�ʘ�5�)�D�-v:�l\":֯̀���\r\n9he��Lv��[\n\$�'>� ����FC:2��3:7��58W��!���	cx��\0P�<�Dr�/�p ��X�7l�<��C����-r�i�µYvixë�ӭ�\n82���	#V�� ��b��s�\n'���B�r�\\���:R:��>J��L �8o�HC�I�r��G��orf>n�>���˚���\0�(��T�;���V�=�5�}N]�-K�5�9�itL��f�#��#sQ7�K.L�*����.��^I��>5��P�6�Y\"�]��*�\n��Nd��}!-[p�6�+�\r��ʂ��L3�F�\n�̽00͓Eեih���{k*1���4��9}n4������Ns��K�����W�G��o��7\"�����5�������0@G��D\n��}��8 � [�B�U\0Au��C�6	�=Ґ�ȕ�)���\0�F��)�Rk!�s%!���\0�C�l^e�\n:w���#r%i�6��~C��C9d��E���d@	�8!��c�xz;�8���� SA�N)�@��\"�U\n�6��^��`/4ea�Ep�|9Bec,�l�Øj(0�ġ�[�L!��ERZ�sb)(4%9>9)`ͬ���\\by�q�O�F�U9����C%`\$HeA�A	H�r��\r.������>(Q,9��щqEAK�[�d���D5l�����b��bw&�R�\0P	A�\0�dhn(A�6�L��NC��0�b�~P�(�Ծ��Z�5T�&T\0�M+.��9�����C���2��.�R#.t6��@���%�ę�f��Jz%/5:�\0���;xs~\0PTL���a2v'��52�?�FB��uFp���	`I�����&�'�3��4�rTMZ\0����\0VT!V��_R;�ZwV��I)B�K�.��O���C	l�AA�����\\�'\$����\n�l�zR�ʗ�@�P�'EȨ`�BᯫP�IĲRBQ�#�\n\"�&\$�L��4��ϐo*m�O�Wl��&\$�D5�V�|�M�e�ʷ��X[�R��^�nD-p 8�4�;RU���j�[� UMK{	���\\���L)S�5\$�Z+aq*T2�Q\\�wP����l�]M�)��B�<w�s(����@U�d\$�̺��m[���e��_@ƏBrD;��0�u�c�AV�u �ՄXkM�'�ha�I���x��IM����<�AO��PY����D \n�Xȟ�J���	l�\$M��v/��s�\">���=���8�@����uGK����Czn���j��1l#H~L��F�^\$\\�3|�%س9\r�����\r��C& ((�g��\"'.�*���\n!Flz��w��B5<9�ج\$?J�Hz��KV.#�wv&�2;��������dC��e��Ѻ��W��&�\\���;��K�oU �e�Ss�<9>�𩅧�{G�)�_�FX.N�jJQ(��͝��ۛ��ZG1:�Z��cw/���C	bo���Oj�3-�'���������ԣ1�EJ�����6}D�C���+D]!1|2�k�G�OW�Nv>w�C�g�Qr/�ܷ;��@+�.��;���(S�w��߱��%?�w<�e�ՙd�Ŕ治S)=��x%���!5;���9޼�O��ղ�=���Z,BE~�a��iN�ؑ�:�fAL#Dsd��(rN��m����H�����)��q���mӿ��͒; \$�\$c|���(b�bf�FZ��E���%^?\$z{�Te�v���9�� ��;�:^\r��RuM���&����AE��|�*�,@P6�p::HB͜(0N��ȍ��pa�[0Q�\0X�j��Tr���B��L�n��6\0�\rh�4h�d+���L����ǚd��\"@�^c�4�W\n0�dC�gl��l��Q\nB���d\r��'pp�/\"u\n�B� W����a`ڞ�P�̴l`R�P�Jǈ��^�p(Ȥ���(-��Ci^��xб�q+1Q�m�jD����0�l\n��Q��؋N���c�s���L��O\n�JO�q<��P��.�0���*^6�qc0��k�]��qx�����k�qp.a��J��;#sь�.09qB��l�m���:.LK̖h�((���^\$�gVjLm��-e,OB%�E�Zd��C	�d����5��@?\$���q+_\"�d��@6��8,�LQ����#B�}�[�i#̛���E��qi12�%���aPc�*r�ݒ���M0w��)-�\\���Ȧ���%pe�\".^��-k�p�=R�,-,P�=��ޯ9-�[*�..Hs/�ؤTy��bBZc�8�j/2@�<H�,Ҿ����ʢ��Č��epsp-�5R��A.Q3����v]V\ri'5��4��Lgx�\"�5�c6򰎱������᣺��mR�L�78�|��(��9ӑ:3U.��6O8�U/G0�s�⦾Eb3+�`;�I��I�_:Ҝ���='Y=h**�-:S�>No=��S�6IZenB�43N<k\"Dz�e�3c;AFV��1��0C#��Bob��0��4�T8���3b�ie���[�aD1����Աv�E����B��l�1�R�Ldv\r�V\rb�#�̶��N i�9�;����Č)�HBBL&J�LX�\0���\n���p&�qQ��'hOpF��-PP����T�@�Mn�2��T�dJ�ГuCJ�0���B;%Q8�g�\$SdG�~���is�5�6\$��4�R�Ҍkg;�lg�\0dСc�O�X��UhH˘a���>=M';�����\r�&/�U|��� L2%��{rl(���	��Bt�Y�Y3<�X/գN��i�EZ�s��X�P[��+hr=C�gȐQ5w=k2�5\"O��\np���o\$|�,zNQ9`#n^p�C�aJt[��r�E�THn�^�D0˕�'�Bg�\"�\$V<H�j��u�j�Ն��E�z��FDFHM\r�\\3�6bChid���V�1^	�\r�S<��.�";
        break;
        case'pt':$f = "T2�D��r:OF�(J.��0Q9��7�j���s9�էc)�@e7�&��2f4��SI��.&�	��6��'�I�2d��fsX�l@%9��jT�l 7E�&Z!�8���h5\r��Q��z4��F��i7M�ZԞ�	�&))��8&�̆���X\n\$��py��1~4נ\"���^��&��a�V#'��ٞ2��H���d0�vf�����β�����K\$�Sy��x��`�\\[\rOZ��x���N�-�&�����gM�[�<��7�ES�<�n5���st��I��̷�*��.�:�15�:\\����.,�p!�#\"h0���ڃ��P�ܺm2�	���K��B8����V1-�[\r\rG��\nh:T�8�thG�����rCȔ4�T|�ɒ3��p�ǉ�\n�4�n�'*C��6�<�7�-P艶����h2@�rdH1G�\0�4����>�0�;�� X� �Ό��D4���9�Ax^;�t36\r�8\\��zP�)9�xD��3:/2�9�hx�!�q\"��*�HQ�K�kb�Iì�1Lbb�%J�8ılk�g�V��%�Ȥ�EK���\r�:(��\0�<� M�y^��!��`꼧#J=}Ǝt^��p����r2 �ϊ��k��2���6Nku�2�v-�����a����4��J((&��ǎ.ٚ��`��/b}`�1��ؠ�vA͈Jr�����٫�� ������3@Û7`��ܤ��&L����j��l� KR�n��p�>B�o�c��,Ǵ�-��h�6#k�B\$������,���Z[���U,q{��!L�>�\"��Ѵ�d7��3�R�\0�R9L�@�\n�z���!�9���b9���A�.��x��0���{Ԓp�aOr7�i@@!�b����֤���9I}w����T�a����̹	wg�����s&��ӟ�d��hui�5*B�تCD�H�e(��S�yPuD��jU\n�7�^U�-@���ί�\n�ye��j�C\n�N����U������a4�@\":��z���?:��� S*mN��B��J�J�U�Q�j�V�P8���C��7��U�s���N	�wą�%�H@�yʆŸ���C1PN<�B:A��^!�3D�^i&zeA�Sv�I�hhh���#H��\r		Fs���u'���Fc\$��P	A:9�pl�AP\$��KC���\$����K\$S�#�8׆s�GK�t6F��'2�΃�U2���FK��/�0��f����A=�?CppP�E��o	� M��L/\$\r?�+2d�(�9Z��1A(e�#��H���g=!��b��\n&\"��4�P1P'\$��H�J񜩝���zgY�^��؁AXS)��cgIaB��7��P	�L*'��I�K`�3���_���ԅ��|ؚu7���GӃ:s�s��\$����ށ�7k�6��2�Cvl��\"8��\0F\n������C>)�9D��9\$��0���~E�Y��4��P�*[Ki� E	�֑T�m\n�C�)���K��g��V��Ã-eF-cӔk�(�jYh���-���D݅\0C�r\\��%g�i�}��z�g|�L�=n�cæEs���O��Μ��|`\nE+i��v��V%��Ҷ�@\n\n���r��q�K�T�(/���S�`\"�VةF�� �Fl���3���@�a�\"dd�ʽ�Bd��W�7�X�\0�v:^\$�2�|\$fqzeƮ�a���LW��Z�8��,���)u���,��\\��qjw1��{2���*�p*f)���+�����b��|'��痀�y1��7\r]]����09��p�0�(����)?%+XC	\0��T�쓔�rӨ\"��2^Na�cf�/^XW��]+�x�@E�c�L<d�~�]���dj��p	�/#a��`���׻-�lݟJH�� X�ƚ�Y�6�,'��J���1\\�6�V�RѶ��9���0�v+2������L	Ù�'�(C8~Ȥl�'(Ɣ��ĈF3:�]qR�HP������ˣW*�1��zr�gHb@秀�r[Ǌf���;q�b��5rԳ��S�M��HEWD��\\L�LxE1s���=�V��k�Ք�߇V�D�N�N����%��;�ahW_1ݷ)�r\n����KF��������z.���Dk:֗&����~B	�mN���\\�)ޓ� ��?`�tgH�U��ģ7��hX	qz�2s�A�����!��o�'�|���\nJgO������J��Ľ���x�9<8�OY��\n~��{l}�������g�ήl����@�g8���\$���^��js���}��|�ޙ���H~��9��/,<vl�|��+�ΐ�6;ƞC��(�f`@�Q�4��&�� OX�<I6O^ߤ����9b2�ɴR�%��p:�>������H~�;�?F��Ì�L�,����[��\n�T�O���������4�ր�ҩ��k�p��μ���f\0����~P�.K�%��jC\"\$K��L�C\rfbH�#,R���8� ���u\nn�����	���q�Q\n���&�&L�l��K�f1�e�'�+19g<�m#Ƥ\n�4q<A\$xuO@�Br�Ŝ�n����v.��\rQ/�Zα���\0A����r &b�\n�8J\$�'�q�:A1 ����%�,�`�0���`�d8�*N�����^��\"2�P��%��6Q��\$.gL�֣T��/o1��P�6�/�H��q�.<@�j�\r&qBN(En#1b%��:n� ZgB����D�ǲ\n���Zb��\r��E�W\n@�'�׏���'ﺖ�)�<Oi�L��τ��B� ���n������fУ���\$�c��L���VĴր�-���z\$8atc���Cb���#_�����\\&�	�Z!'�jce*S\0��N KȽ��^6O�0��b�|�Pt�w+�0��k�,��|���M��Շ>S߫\n&^6&j@�vq��߳f\"�r�+�i�~�dC8b}8�F �Q#�#\$R�:�E�\"�fIt��Z��/\$�1�&.��\\�J8��_츻c�I˰�S�8�����)�lr�L�5��m �D�";
        break;
        case'pt-br':$f = "V7��j���m̧(1��?	E�30��\n'0�f�\rR 8�g6��e6�㱤�rG%����o��i��h�Xj���2L�SI�p�6�N��Lv>%9��\$\\�n 7F��Z)�\r9���h5\r��Q��z4��F��i7M�����&)A��9\"�*R�Q\$�s��NXH��f��F[���\"��M�Q��'�S���f��s���!�\r4g฽�䧂�f���L�o7T��Y|�%�7RA\\�i�A��_f�������DIA��\$���QT�*��f�y�ܕM8䜈����+	�`����A��ȃ2��.��c�0��څ�O[|0��\0�0�Bc>�\"�\0���Ў2�or�\nqZ!ij�;ì`��i[\\Ls�\r�\rꒋ���N͉�z����z7%h0 �����)-�b:\"��B�ƅ\$oL�&�c�ꒀ:� ��c��2�\0y\r\r��C@�:�t��,CS/�8^����GAC ^+�ѻ�p̾'����|�=�,�����<��n�σ�O/��4�%�\"7dYVMb��pޯ�M\$V�\n�x����(�C��W%�ہB�6�\nt4�7lj��k�,1�p���3�桪c����dٌ�2ȭ�t�2�5�a��kvLN1�]��N1�̢h�&�X@6 ,'԰c7\rߍ���R�/'rځ&��0�:/B?g��bR�M�,1�״���b��1o�����d�n���h��hl0X甾�o�m�@�����˱�r\\5�I��6#��B\$��[����m�ra�1�T��I��.\"Z�s]�vK6�5�{�7��0���0��'Cz��!�9��{n9��^W+<+�،#?V��u�1O�(P9�)Ȩ7�iX@!�b��V��N��������_-aiz�خ���������S\$���s��|}��9L��X2Cd�C���r�RJQKu0�]BS�|7�`U�@���ҭ��\$f�4��\n�M`���r`�;���>���@PM1�(�(H��)�����UTZ�Q�EI�U.�`��JyP!2V�΂�U.8W��|:��#az'}4%���N1�/���F���6����̛�'A��&�2��)1����4>��f���8;�u*y��\0�t>BM:\$�6�8GAC0�R,�0���v7�I��v@n�H\n	���0@\n\n�)%E�U �HV�'\r�`�%��t�9�\$Ϳ�e����?���؆NO�]\r!�4��G�/l0�Rw�uO�)V��Z�=Tj\r<�#~QϾ{5\0�f	�Q:��'�Q\n2\$I�A)���T�ő�Q����A�>�)�I&�&�D�E�\\g8&�Ѳ��\r9�FN���\$e8I�3À�TN�)�����\0gD�eԂ��&'\r��YIa�s2F���f�\0g\$1D���X���e�i9����Bd,��0�\0�%�>\\e�F�p|�r\$�\rv��N��1>�����f���/	��*�\0�B�E�@�\"P�m	F���䵤�L\n�a�(�y��>(�81��̓0\$�8r�Q���eI��ܛ�S�i�l�{���osd�=��;R� o\r��B��SmD�\n�9��v[�gq���6dB��5;���tB�1C\$�}�_���Z�#�`F#|��ȩ�(�+s.e�XE)Z�0b��p�A�QӐ�6��`a���Ř�.�C�]���3�_�Fn,�Hq��%��;���g�,1��1vg+l,������E\r��a�����������Cu�X�S,�P�E���:���f�\n�>K�����+M�\n���]@�t�s�\$���ݵ����_)|*@��@ e%�3:*^�����!\0��s̻1DEq��ҺM�<��t.=b��\n��+'\n�n�!B��h� �{��.:��k�\r��Q��Z�bk3q\$vBO'!:X�=`�q/׻@����\0vmLmd��nG���Ȥ�+s�\r�c��qݚ��m�+!<��C~l�Q���?�^.G3�L�����31�:�8�M�&��H\r�V��3I4�|_�])����r`�(bB.#���@W\na7�����R�<��ȓ\0���BD!!�1f_X2)��P��`�}Vڦ��^�6mv�8e�kYu�_z\r�\$�'�����OgU���rw��'r% ��K���o]M���A�1O�_���[�p��\n(���Xh����[��N��|�9\\NQ�ʝ�]�:�z�=ŋז/��'�����3�'�\rh���H[.U�8�w�H\nU]6���v��7����)|h�r4g�޿�}o/r�{�|���/?�l=�2�(�9��{�`�cE��6�'\0'�h�������nح������`���N��/�x/�zl�{�\"� ʄ����0+�%\$N�Dn�p�ό�d/Ǥo\"��ƀ\$�<.XC��(�\n^��P���#�ib#�Z�TJI�00TCp^?��#��o���WJ��=�L���Or��?��2I�j6�+���̎�P6��:�0��'����3�����b`Y��� ��h���Q	��	G��H��W�̜����/Q162���&�B�]�PK�8�Ⱥ���zkʬ�-O\$����P��p��f�/���&r,/`m���:}Q8���q;�(�>\n�tl����ʬ����͌�eQi1!����rD���}��k�&����b��c6\n�^�4_��H%��Q'.� BF1��\n�R|���r	\r\0�P�G�!c*p��3e�G��YD��-j�k�\$/�D�*����e��Ճb7#0oF2��*CC�\r\$�v���%��'�`<��j~\r&R\"��EX#��B�q�1@Ze�r��\r�M	x��\n���q�2L��ͨ����{�O\n#O%ow.(��23�<\$Di������Q��2*1�T\"�?�ħFσ�:�&��Č`��Иc*kJ��Uf��sE-C�\n�J�PatY\"���n�L:>qVh��7\r.�E�j	f+stŬS7�4G�y�7*1��`�L�`�8n�8��\$���Ck9�^;Ӝ?���*,�2�Gp�8���~J3��	O8�W�(Ŋ����\"~���\nO�0#�T�G1n�\"�\0d�be���p�0,J2�/�����*�(͓~2�~��4&\$�o̾�/C�4]��1@����ED��\$�^E�/��";
        break;
        case'ro':$f = "S:���VBl� 9�L�S������BQp����	�@p:�\$\"��c���f���L�L�#��>e�L��1p(�/���i��i�L��I�@-	Nd���e9�%�	��@n��h��|�X\nFC1��l7AFsy�o9B�&�\rن�7F԰�82`u���Z:LFSa�zE2`xHx(�n9�̹�g��I�f;���=,��f��o��NƜ��� :n�N,�h��2YY�N�;���΁� �A�f����2�r'-K��� �!�{��:<�ٸ�\nd& g-�(��0`P�ތ�P�7\rcp�;�)��'�\"��\n�@�*�12���B��\r.�枿#Jh��8@��C�����ڔ�B#�;.��.�����H��/c��(�6���Z�)���'I�M(E��B�\r,+�%�R�0�B�1T\n��L�7��Rp8&j(�\r�肥�i�Z7��R����FJ�愾��[�m@;�CCeF#�\r;� X�`����D4���9�Ax^;ցr��Oc�\\��|4���PC ^*A�ڼ'�̼(��J7�x�9�����c>�J�i��@�7�)rP�<���=O���t\r7S�Ȳcbj/�X��S�Ҋ�Pܽ��&2B�����`�n �H!��x�73�(�����:��\"a%�\nC'�L�2��Pح����vո��Ǌ����N�&.��3��;�E�L;V�5h|��)�����CF�DI����2�bm|C�^6�\n\"`@8���jC��o;�s�#M��Mr�&��\\��:�X�2��-��7w Ί{� �0w�8�(��7�.��	#m9\\\0P�<uc�\$�9W��͜<\n\"@SB��oH��m�7;B�0�6P)蒂&:0�7��� ,p�Gc2�6N��G)z�꽄F\"�;�P9�)�)�B3�7�p���\r�H�op \nID����ÑE*�U��4��;�+�*DS�C�R�'�pL��D��*P@�ق�U��X+%hղ�W*��+���!�1KMc��r_��Z�^\n#�hHI\r\$� ���R�A�p9�p�u��200̘OBj�?juO�2�Q�0�*�V�Uz�Vj�[�t�!�����Ŏ�]Hp2�@�D0|��\"QSL0�����J�x�,m>-�����R������z�rw/��GG��R��2n�BPa��3F7���6|\rt����p%;}K�����_Q9�C)3��e2���6���î��7�\r�<pڂ�\0��?@�ܩR25w�v�c�)�%C�Ԃ�R[[N/��Ć�X(<6D٘��r��Ɖ���X�	W}&���H\$��X�0;����:�0D⊢�ThI�6%%��r<��*�5�����f�8%�<��Ȃ��a\rE�0�¤�y6H�4���hZl�9'��MZ������7���9�X&�0���P	�L*L����E<�*@S4A1� 䁊��tBQD%\$���2;\n\"%�-�P���L�'d����I�	�|)I?�8ۉ[C��`��QG�.HUt�NC�;WL]ǐy���\n;t�ã��b�p(���x&Oپh̼����̔b��}�d���	�q� &�[:1!�3�zb��I@ptĄVoU�\$������rP*j=.æ�&�^`d,���O�A�\r<+L��҄�!�����߷q��BB2&剕�(^\0PVISQҝ#ƁB�\r�	� u\"a�svc�\0�-AR@P0��#I�~:/������ ��\"%��� uD��3���&g�0���?� 7a�;��\\�iAS'c>a��b�){���3��!�|��?�a�O��4L�i3c�����6LSh��/r��T�0�87i�\noT:�I='�]�q2;-#-�����w�I��:�P\"��!B:q�_���t�K!P*��u&T8�up݌��L�9�z�eUn�,�A�)�S`A�n��k�PQn�\\�-�����̜\\'J�P	�D�z��dw�Qݦ�w�����u)4�\n�H@������< �����x9�۳h�@[�8��'���)���:rk%i�v�Q��%�d��\0��R�+|��>�4h����}�y<�RY?�\r'�al�w�g_����P�p�����\nL6��e����ͷ��+%�c�rC�)�3��d�Z\"UF;V���r\rr���x��<-=�((�`?\0��B�D�g��m(~p�����ϣ%��/N =�&ޒbr\$r����k���]����\"�w<��L�ːzG*DK!�7�n�J��64����bSL���C<�KrC�'�p��@S(y��,�,ދ�k��5�è(t_X	`y��jz����k�w'BRL�0﨡O�\0�\0���\0�0�P\$����O*: �.R�\rFA��db�.�F�����0C0F�l9��CS�\\#�7/��,����f�����Lkk���OI09	Њ�0�=Oh>P�4Oo�+�4����8��*�>�> �֏���<�ȓ��,c\0�\\U\\\r��c�G��l�&��#( [�{	�j�0��o�ͪ���ҍ�3��]�Dk�9���,Ne03	o�P�P�4p�أ�]�@�F�פ4k��P��2�}�D�p3\n�`uц�|���i�-\0p`�d�rG&C1���~�0:@�aDC�vB~[f�:c�:�f����h�cc���q�<%�µ����c���|b��pJ�E�²�@��%�!��c��(c�\$P�/&,���Q��L��/\$��I2D�{�_��\r-\$d�\"��%\$�H�UQv�ZI��2J��O(d���i%p_q�\n����(�gBz	<q�pP3��O*���pDoX?ep���\"��`���,H�B�� Lg�Ň�_��2\"lb/�.���Z:����.䧱�.�v�C\\~D�\r�V��\rq7\0�N� BhRG��z'�:\r��+I\\}\0�\n���pC\"N^���Jba�Vu�D�p\$�P=��7�J�B:#�B\$g~�C�����Ά�l��`<#4iO�3�>cH �\0�ǎ����V,��p�!�bzNk8Ym�8��>H�>�ʗ��&��r'��O?�_oP[O�1�&�� ��@�+A1��OcA\nuAK���)B	���L����*)�h6�&@��L)�s'@�'{�N��/&.eIĽ��H��G#���4�ZT�w/�g�b:E��ȧ�_�%GD�/r@�EF�^@/��:&14���IC:t�#J	�B�C/��s��M�M�Zc4xMbhb:�(��l�#� @	\0�@�	�t\n`�";
        break;
        case'ru':$f = "�I4Qb�\r��h-Z(KA{���ᙘ@s4��\$h�X4m�E�FyAg�����\nQBKW2)R�A@�apz\0]NKWRi�Ay-]�!�&��	���p�CE#���yl��\n@N'R)��\0�	Nd*;AEJ�K����F���\$�V�&�'AA�0�@\nFC1��l7c+�&\"I�Iз��>Ĺ���K,q��ϴ�.��u�9�꠆��L���,&��NsD�M�����e!_��Z��G*�r�;i��9X��p�d����'ˌ6ky�}�V��\n�P����ػN�3\0\$�,�:)�f�(nB>�\$e�\n��mz������!0<=�����S<��lP�*�E�i�䦖�;�(P1�W�j�t�E��B��5��x�7(�9\r㒎\"\r#��1\r�*�9���7Kr�0�S8�<�(�9�#|���n;���%;�����(�?IQp�C%�G�N�C;���&�:±Æ�~��hk��ή�hO�i�9�\0G�BЌ�\nu�/*��=��*4�?@NՒ2��)�56d+R�C��<�%�N����=�jtB ��h�7JA\0�7���:\"��8J� �1�w�7�\0�o#��0�r��4��@�:�A\0�|c��2�\0yy���3��:����x�\r�m�At�3��p_��x.�K�|6ʲ��3J�m�8���^0�˪\"���wR��S��N����-X�,�dO!��ifE�dn�G&�Z�!�6��\r۴Ci��=@Z.�-j:b��9\r��Ό�#V�&�N󽯯���l����u�B�)���M/*~���*������3�I!J	t������0�p�����D.�_#��(h�P\"hGH�.��\"b�)d2�F�)t2Y�2i]/4]LY%J���iU8�k�B`��.L����2����M��{�G7�sp��q]�6eE��I�B�E��B�����ُ�AL(��Zۏ:\$d�����DZH)���s�ך��E� �2Tp��6�=�5��`��P��6���a�\r)��C;	\n�Xe�b���[s�w\ny���IZh�#\"��Ȟ�љ26�����!��X'�VEQ#:��rH��B(�\ni�P��	3��N*\"7�DD'w���K�v����\0��,RЩ���i	\0.%Q���A��(1\$�G@�`Z�Ї�3� �p	T�zB�9S�I{���-�Tm]���2VK�)3&�̝wҁ�9HO�Z<;���>�+����2�A�W\"��!z�h�^H��0#���e�K�����Г��O�Y�S&y��2���R�+I�u:�i�?�\nCU��*�)� �O�D>S�e��\"�N��'1AWBb��D�d+1�����W \$�tr��Ǣ�hV�3(�P4���i��x�����	i�8E���\ra�E��V.�X�wc�~�2 ��2�L�ќ2�}V���gL�:'i�G�)�E���2�}�&�|]0����L��ǁdU�K�d2 �Ԥ�\$vB�y�9J�S\n�p��H�LA�1F,��c����6J�*lM��92�\\4��4�L�oX���1��/��qD]�%(5��4dw\$TY��G�B�/����	��,i�\\�A�!ѽi�Xi�hKˮ�' @��`l�/�NCheoA�3&��ê�]��:� ��:ۻ��4�������T`�Wlt	�#!P�[*�իA)^��q��3\\�D�I��Dʹ�@�G�ACB���(2mAAr%!�%������� ��J]���.���A�^W�'^�w(��\$EJ\$�#衛lw�\$�Z��p���)�O�Y]��̓�l\rv���pn�0F��w\r�1�մ؝�K��1�vK�\$�x�<�\0��!~���eGHJ�c�����Kh�)�R�Bg8���#0O��%B��+�>J&ir.�T�G����\$刿��}�9�D�(\"V)� �:a\r�iB�F�� � �A��,\$ڛ��;q!�*��DEC�@xS\n�>2�Y����V�ȩ�� X�f�+�:��S��5. ʫO�\r���Y-S�T�i�NtkLy�4�-��U8��/�I�r��vD�INk|�6�S�ۆ@�NK�<|�*�2��ґ^(�xl��m�ص��*�ϥ܅ӎ���j�{�\r�6�Q5N#��[q8Y��^?[!�\rf!�t�R�}�I+�kڷ�l�/��7�?���څ�(�<�`�*F�yXur�G(���o4���C�\0�i�nFua��O���]�\rdc߫_�U��b����6��cj�Aކ�;����,�~+�Z�m��\\�Q]Vv�ؿr�����g����v+�X�\\��gء@\$\n �1>�P�/�5�QK��_d�,����q�5�+�3��_X�J��s��fЁKP5�8��\rj��`F�&k�2*\n���J�Ȉ��&j�^����G�2j������Z����@'�x~���\"jO����vU���m8T�L��k�flG��H�:(�\$@*�����,/G����h�f�ڢ�y��!h��͂��,���b��P��J*�d�B�k�H@\"�bj#!K��\r�L\$��jƘ Nn�熊����/&S������%���*L�|En�e �\n��`���Il,�\\��P�ΦYΞ&�N��Ym�5��ZM�8�L�\$o@^1��Ԋ�\$ڇ¥q��u�Z���m�������&uC\0�Q>�bN��u��ؑ��+��͌��,)���Qaq1�����BF�nv����!�r����v,hߥr��Q�F(��qi(֎�F�#��(N�\$�c!1@�e�!�\"2�ò��\"�	��C��R/rA\"���;'���\n��B%� �X�n^-av=E�U\"�'�'be2~�\"F=��Z!qЂ\$aC�(b���Y2�L��է|(2��R�3�\\ш^��\$E��鞄q@�m�>�`qb����R�p�WO�r���RK/�8C��̺�2�nYn�Q�0dP��*��.K�ג7ƴu����\0�|�{2+W2sO(�x��5��p�3����5b�6��N�2��&N�k��7���5&�!�u�4vF�Gj)�nw&�w��J��K�#\0e���6E��C[<Ӥ#n����=���XWn\$.����0h�T>O^q�����;�'>�t�PCG��S8�Y8���H���43Z��_4�~h�0��lXRBC2i��C��B�D�4E7��(�8oMD��	�Dc�@�EF8�d��#F�#�'8p�����°a21�gH�q3`�T�4T�*��@�������\$�\$��T5)��@2_JԤ��K��K�L!aLr�'�L�uG�Vΐ��*r��n���5̧4�%�9	��P�����\$B�Q�w84n.�� d4�k�\r(1���l��E*�TB���z�P��t�����\r��2#k �*�\r�\\#�A&�xP5B���0i]W*\r1c�R��Q�	�Ԛuh���'n�u0�l�U6�e/�T���%F�P9���cOIO�=\"��83H���\"���C�G_p��J�u���f@���vAҩ�_Ϟ�)�_�G`H���m�c#]ct�G�d��VIS��c��]_FG�R��/3���fn6k�܉kV�2r*(A\rh\"ZBƯ�#C���\\��@M�|u�@4��SkJT9a)3_p�_��OTwrW8��ؖ�lv8ef�Ue��la	g�;G�nH\\�T�lB`�1f��nώwv!H4�o�vX�Bd�0�B��(�gP���SvQ\"4�./B�R5�R���1t6�a����oPhC�ѷA�QpP�s�\0�\0P��tuv��Ei���Q�QP�/&Y�*VWEl�yW��ny��חUS��%�:˨	l�L�x4��u�2Ҩ�d}J�e֟\"�V��A�w�M�~'U�	~�ܓ4�4I~�����3IX=��r�jD�yǀ 2ĜI�(ѿ7�XU�X��`�8?@BI��x`6KO�CL��;�{%F�#��� �a�0�REJ{HT+��Ӱ&S��a�����X1RVaZ�3+��(5�B��4/)PuP|+�#��\n�ZZ՗[�0����2�dU��O'�n��l��f�x���{{�R�1v1�������V#	0��X̬���6s�uЈ��*���jEd7�U�7��-��-��/����#��0�a���F\nV�x�nbPAw2�['Bc'���jCF�(�}'���BS�ugi��*a0!\$�BSVbVC��w:OR呕r�Q9H�T�F�4K�9�cM69�\0%��χ��c@sQ\\�ф����ΈO�R���휅N6���S�t�^v�y��)�VH�5C����@�#\0�H��ayU�q0G}�b�����DD!�Ð4{j\"GP�T���C �x��8�z1Q(x��e�(���V�y]!0���0j�%v�l�+����yI]�Ў�و�����6�2��|c�<S.(3�54CHם�:�j";
        break;
        case'sk':$f = "N0��FP�%���(��]��(a�@n2�\r�C	��l7��&�����������P�\r�h���l2������5��rxdB\$r:�\rFQ\0��B���18���-9���H�0��cA��n8��)���D�&sL�b\nb�M&}0�a1g�̤�k0��2pQZ@�_bԷ���0 �_0��ɾ�h��\r�Y�83�Nb���p�/ƃN��b�a��aWw�M\r�+o;I���Cv��\0��!����F\"<�lb�Xj�v&�g��0��<���zn5������9\"iH�ڰ	ժ��\n�)�����9�#|&��C*N�c(b��6 P��+Ck�8�\n- I��<�B�K��2��h�:3(p�eHڇ?���\n� �-�~	\rRA-�����6&��9Ģ����H@���\nr4���6���@2\r�R.7��c^�S��1ã�(7�[b�E�`�4��C=AMqp�;�c X��H2���D4���9�Ax^;Ձr�:#�\\���zr��09�xD��j&�.�2&������|�����9S�Q����<2\0�5�������s��\r	��rM�#n�(�'9	�4ݍq(����B��\0Ă�N�`��\r��cSZ;!á�](�\n��%ǩ��P�b�քH�1�C-�:D�\0�:����:�֍�V̌`�:��#>R3�+��t���\rc ʠ����H���C҄����R6&�_-d\"�h^}�c`��Ah`�0��p�&Mka[|�K��#�f`�7���v�tXĶ�Rh�r���\"������S'#^B�6����\0�Ƃz֘����#m���^���w�w�-��;ZV���l꒎��x�3\r��R'��iC12b�ސ�cp�g���B5C�͘	�	�r�0��\n�}�=a���@��\"r3��zk9)� ���:��HŌ��`d\0�=3��ތi�����*_\$!�5�#4IHT4�������JrV�M�4,�qS��O�F�U:�Uj�W�Ud��n�����,���LK'�f,��VQ<ZA���¦�d6DU��#Ɗ���\$�����T2�`%\\8�R D;���R*eP��`wU��#+0�U�'(R'����hp'�*���#pLֱ��\rяEu\r`��'I�ʡB,��D&�ܜ�XR\nb����G��O�G�0�cdE��Pύ��gޣԉ��UPZpnY'|9���^�� G��̇�rp)E1<�_*��2�0=BPȠ#S�:S�=NA[9� 9�\0�����cY*\"NSNMKu�ڧ�ۃxw������Qtjg�0�¸�%�)~��5r�_��R+7F�c����O���\$��E1��X6JB7o-=\0ij��Y-%���BZ�(ND��A��[���v�\0��9)	\$,<���X	�O�l70#EYHqf�dd\0���F�g�1�74���5\$�.�7�xI�>(	\0�¢�%��.S�l�8\$��AJ�Y!��E\$����\\é���5V�R���)�r�73�k�|Ea���\0����)�(�`�\ru~����!_k�I'���0���\rd��T��D�Av93���P�*[�{� E	���2�rcb���\n�	�%�\$���ȉB�o'��&�8w��<G�.��xD\n\"�e8W��I��Kh�?�\\[�\"��F����3�\"O5B��T�>x�ĺ'���yv��� �aEE�7�VчeREb&\$Ɵ��E�p:��vz�\0�t��s�u�*^�to�O�ś�xb��a&�R��?\n�xBC����\$�qB�����\0�.cJ�9{y�%�����`oi�A��+�WF�K��Ӄƫ�\0005Pd���f|��T1���@o���5���jC�4K��j�]��a�{,y�c��cs��\0(#,tQ�r��\\H�*���Q2�v�s��+R��D��*�z?�R�䟃���t4C�����C���fS�kafbpN'�\n����T�@��~���5�U7����5�����p	�m�B�ȸ�I�a����j��?.�(Ϙ�>;��7���rB���[�P��#�7���t�p==�g�n��#��,�3�SO�=s��a����ӻg�]ӄ�u�ى��k��>�\0�CH\$�E��?�����0��&R�)6'�������(�<���4D��*�~���lV\\��Iai�,���ఀ���xJ i`~��#@�mW�H+D�|��a�/�9a���Wį&�d<��]�gN��5�N���\$������ɻ����MO����W��]L(�����/�c�\0��Gj��\n�����\"~o�\n��:B6�\"�RB�O�h�\0 �� F���#@�]M\$j��\r�h	����7��^@��P<FL�t&�y\0n~�%��-`s�b�ƠPV��\00m\0��ķ/�ҏ%���)R'/�\0��tlk'�o���������cK����\0\", o4�B��M��.��N�@;�t\$�O�.��Ǒ\0����0�e��0����D�����N��X@컭|��C���z�p��P�T�QX�]!{m~�@�-���p\n��f\r��^��\"�F'��&&\n`��������f\rn�6%���ZE6&f�}���Nx����i�^����^*�V#f��d��6\"Ѩ\"®��\$�y����\$^�C�\n[!mvLp�b�B�f�D�o�\"�]\n��*]R.�,��d�g3-E\$C��(��#��\r-�;�^9p�0&�\r&�RL���9〻�l(c&r��(��'�/�K#�cd,N.	bL�����.���'Q| p0J-���\n�'#����Q#0-�3P�e�\r-r(��g����11�)RR��xmR�%l�����P\$��1��d�.m�#��&r4س0N�QHR��2��v]�Z5�H�\r1���>�]%��m�J��S5�5\$����v'�s#3�73�JA}RK/3:��@<1�,��K��ғĶ1��{���q�Q0����x[�-,1%<��q,��]<*��fʌ��6\$�1�C��(\$�\n��k��C\"i�@A��@�u3�\r�H\0�`�y���^��8Se�\"k(:D:�p2BR˔�\n�O�@�+�\n���p?�N#c���%�^�g�n���yG��N��De>.�H�G���)��Т�L��B:#�Fx&pi`�G\0�F����J\$dh5��I�\\��6F\$08�G�#S�2(�;M� �	�޸E��EO��j�b,�_+�Di��\r�ҬU�0\r6xN���\r-K!��e'�\r�G(U:0p~ǐ(\r�n���4���c3qcT�5c@'�~�UTY\$�ӂ�s��\0�Ee�\$T�2,Z���HHw&2�c-�\n�\$(2��,�0ro®r�\$��N�T5�\nN+LE��H�MW����\"g�1������Ò1�MM#f�`-�ZĕB�P�+ht0��U@��O*�W c&\n\$n���&�9VE�	\0�@�	�t\n`�";
        break;
        case'sl':$f = "S:D��ib#L&�H�%���(�6�����l7�WƓ��@d0�\r�Y�]0���XI�� ��\r&�y��'��̲��%9���J�nn��S鉆^ #!��j6� �!��n7��F�9�<l�I����/*�L��QZ�v���c���c��M�Q��3���g#N\0�e3�Nb	P��p�@s��Nn�b���f��.������Pl5MB�z67Q�����fn�_�T9�n3��'�Q�������(�p�]/�Sq��w�NG(�/Ktˈ)Ѐ��Q�_�����Ø�7�){�F)@������8�!#\n*)�h�ھKp�9!�P�2��h�:HLB)���� �5��Z1!��x���4�B�\n�l�\"�(*5�R<ɍ2< ��ڠ9\$�{4ȧ�?'��1�P�3�	�B�B��\r\\�Ø��`@&�`�3��:����x�E�ʹ�������x�:����J@|���8̍\r�L7�x�%��� c{B��B��5�)L=�h�1-\"�2�͓�3��#�aث��-\"p�;2c,��B�>�L�J2b:6��q�7-�q\rI-�sݶ���\r���1�cH�	q+Nr22�s\$�&hH�;!j4?�#�؟�`�%U�R�#�(�(�B��9���:�J�5�Òx�8��K&���b7�@P�4�k�7��Ԟ�*�{��c�`��>�1�n�pފb����89��u����5�=X6f\r\"�*��ea�mN&�R��ԕ\"��#�;\r�C��A`�Yˬ���� �\r.�4bx�C��3'J�^'��:L9�B���T�p��@#��2�ؐ@�-��t��0����+�P9�06�H�9[���)�pA[:��H�Tc�ۉC���>�[Z:%�,�Ǧ��{:��^*1�+7��4�*Q��1��	,O�j\n��P�!E(�[���R���D��\"��8�TΪUY�`�ܣ+X\n��=�����Z�hI)A�^P�K\n\\9�d�}��p\r%��?��\0�P�%E�u�`@rR!�I�S��S�������`#6���q\\uR�BH@�S�_�Y#bn��������\"HI�(o��F�r���Jid��җ	^���e�C42\"��2CWZ�݁�M�Ѵ��\0c/K�4���K�7�9Y�%�]NB�V-d9PЖejԎ<\$\0@\n\n@)#��'��p�xC@�BA�����Z��Z��J�KJ\r��k<\"r�ʁ�o\$�@�5㊗L�N�p��S�5S+�;�@�-��gPr&v��9q1a\"6�tIY���Ks�nXn��y���<\r�i�B�Oҭ\"a�ŒpҸB]>���\nX�>����d��d��9����� �䝰udJI�&�@'�0��ӥ\rG]q�*��EF�3d�0�=UM��A�𛔃IZ��3��&��[U	�΄#\0M�0T��-p3��l��4D�\$98����&\rf�:��u!�\rIDX�:�j8u,����f��N^���)@��l`5����2<�i!Š�3�Pn��sY'�\$B6O1&�l\"�K�l�qps��ؘ�nzOq��4�%%sGI�Y����jlW|�!�>d�|�^K	����\0�E���m��^Z��VT��R��^V����O��)\0('�2f��PZ��ŇE�e�#�IS*+�Ԕ���Z�DǇ\$!��'M�p\0�լzY%�8dCs\rh	��F�[�Ӡ���:��Ͷ����Ab��	k�ʄ#2�*9�|�]�f�cI_#C���bE͟eHJq�>\r��5�x����1Vg��>xQ�;JaP*�0cIm�̈́��&\n]\\�b�I��/�����a3P]�����Fau(e���酬��\\|ϠP­\\!z�x��\$�;��A�*�%[k}aOu�����k}rE6�s���b݂��v�\r�8���^�١�L��v�he�ڤ�k����5���[0��E����\r2�_�mB��0ujkN�o]2����[�'�D+7Y�ۛe�kHTU!Y<\r�<�.n%����\\\\�S�5��:���wq]����\r�d*����������6ȭ\$\n��X�H���]���TJ��l(��{s6]��H<��2�:L�t�\$Qu�fc0XZW\"����x�H*F�J�l�: s��H�iFC�q���ٕ[P�^�J�kZ0t��g{�n�^1���e�u�>�Mk�C�C��ϯ��v�ڏ�Իzm�{hg���9�84?�Ul�4����p̫݀v4Fk[BJ��`p��9[���	ұ�?;�Bgi�Q�����\$��^�1|���]��_Z�8������-0��`w�AH~;�z���j\$ �x��}O�\0\r��������>���t���'J����io.%E�\rmt��|�-��-���9;++���`l�0�\rB\r-��/*l��^׍�\"�%MS�,!p107p=��l-�MH0���̠����J�P�7p�!/�{l�����0��tȃd6�>7d�E�^�@��xD�LE�����#d\$��y��*b�&�Kc��c�6�B����c�n6��*�\$��\rC\$���e�L�P�����&�v��l,��KF^�bY	����\r^Y0��.��Qk0m�hpGV1`YL����S\"���u�Aq�����7+���;��\$�,HaBX_�	�B����\rc\r�D%l�P;��0YF���	Ohϱh��x\$�ZcĢl��1�1��Jfc��c�1P!�/�Z���_L�ˤf��d��%K�ʌ�'q��D �I#���� ���V;�m�U#���B�þ�X* �\$�F��\$�eR~F�~0���'��6\"�2*�	�/�8��Cq��p�߫В�j��I�b�Cؒ�K,Ì��#-c5�_����%K��_��,�\nq�R�v[�B����\r�& ��Ȭ����1�@���2��2\r�	�6󥦙\$P\r�V�rL���'�~�`�7�\$%��������6��\n���p>���L��o�U1m�ԭ�\n��-�2�FԲ�9Kd>��C峗	Ӎ9�\"�0#E���p�x�d\r � \nO[\"\0��3^Z�ƍ��4S�h�&k����#b�?8��V0�^	�ޭ�@ D�gT8#�F��@�8\$b��\"��l����.�I���t8�E������Bx�Cb��G\n��E.3c2�x��\$�6ŃTndE�hX�feBaIf��i�l\r^@��'Bx�C��4���d��H�<��T�B���X\n���\$���G�0\0\"�Mfh�����5�\08��&*�����dZ�F��n����TX&#�D�P�#�*KѬ.E�";
        break;
        case'sr':$f = "�J4����4P-Ak	@��6�\r��h/`��P�\\33`���h���E����C��\\f�LJⰦ��e_���D�eh��RƂ���hQ�	��jQ����*�1a1�CV�9��%9��P	u6cc�U�P���/�A�B�P�b2��a��s\$_��T���I0�.\"u�Z�H��-�0ՃAcYXZ�5�V\$Q�4�Y�iq���c9m:��M�Q��v2�\r����i;M�S9�� :q�!���:\r<��˵ɫ�x�b���x�>D�q�M��|];ٴRT�R�Ҕ=�q0�!/kV֠�N�)\nS�)��H�3��<��Ӛ�ƨ2E�H�2	��׊�p���p@2�C��9(B#��9a�Fqx�81�{��î7cH�\$-ed]!Hc.�&Bد�O)y*,R�դ�T2�?ƃ0�*�R4��d�@��\"���Ʒ�O�X�(��F�Nh�\\������!�\n��M\$�31j���)�l�Ů)!?N�2HQ1O;�13�rζ�P�2\r��`�{��\r�D��l0�c�\$�a\0�X:���9�#���uۋc�c�f2�\0ya���3��:����x�s��\rYWF�����p^8Z��2��\r���	ј��ICpx�!�D�3������ښL��#G�(�O,�,��*�KƂZ�Ҍ��d��M������\n#l�㏭\n��7BC:F��#>�N��(��a�h�����ƄH��ʵ>�����ȺHH'ixZ�ӈ¾Dl/@�m�#��[��:����a�y�R<�ԠC&�3���k�+��5/!�'G�쒀�y~+@)��Ǯ��,�'prHI�T	G��.5F�sĠ�Q�fh��N��u�%)�i���\\����\nb���xtC:�R�zb�C\0Rx񼭺q��Y>�Ζ�IE�y�2hy/�\r&E�hRs�,3�@�����Ԍate/�L\"H@JqP*O-��ޠR��ŪVt}ً �ѣ���Ĕ����!C\$����na�ܛ�����f��W�<ɔ�\n���00�A\0uI�^���܁\0l\r�	5��@!�0� A�Z�\r��낀�\nKYD,f݌��R�A��ŋ�e�d�A��H�~�T���\"O�b+���\"�\r�*9�9D����H�j�4��C\"�Z��m-ż��\\ˡuI5��z����F\n�A��`�M����矃�\"&����pY��9.�X-VЩ��oAP	E��P�j�:�5z5���xx�mH�&���[�}p�5ʹú�]a��ܼ�EH�%%���Chp9a�x�Ij��ϟ�1��@��Z�V��C��Z��R�ѯ��(E�1e�!�A��'��Z�p�pU�I`�e������FOƊC4�V�kDz_�b.YGd�RrDg� sv~����Y�C�2<��Q)#/zdJ�ahb���&�\0�*�Z���A�^L��'�L�4�;�X4���s+EW!�:��.\r����eѬAզ��WI���9�9�E}�q�_�8Eş5��E�h1��C:ߦb�6�\\pK��[�+��oH��挕}o1�`�5Y��q��hQ,D��݌�L����Iy���4�S���@n��h筠������6�֫�.q)dT[�m�d����xS\n�x����u�ʫH*��M`\r&j�Q�od�luK�����9�яFJ��s3I�'d�|�'�P�Ѽ�ȸ�ĥ԰���5�j�J��R���ʺ����\$`p��r-���&I�[�hpP�!e��s�	�8P�T��Lr%�T)����V�@�H\n�`�\"P�s�t��X�=���	(%B�@�U#�qCX&ɔ�>M0�\\�qT0�E\r�K�/)�V��DY[�)(pO��dH\$�s(�͵���_�������c�ʡQ�\nB�kS�����Tq|�H�8Dk%�-�)�E_(�\$���l\"��v��;a��b}��B��^@a�5��X�D�V��Q9�a����v4��M�j�Z.T.6��=��9X>��6�}�A\$��:���39*2Oy�\r��J�\r!��i��S�.��Ƿ��5�Fi��i�)���M(�3�E�[���(�r�}#|0���Z\\	�eB�`@ALM��c�p�]���]�v���~TY��+m�V�=�S���@\nw�����<��%��R\\Ie2����pN[����e��C;�f^s�(�3��C	\0���\0Ҭ������8X3�7�;����A�R�K����W��\r�� _A�(�S|��� �G� �j��D]�����wێ���P\\~�7�Z��/�c#������Hg���������R�/�'o��/�ۏ����GO��Fnv*�e046\n��+�&�ă� ��:gG!��P������0L�o���iʹ��'�pJ��%\0�p�)~'P`�~�0��\r���p�4��\r%ZV�d�<\$κx\"耂�I�����Q\n,t�9m`�Lb-�cp\$�\0)��� %/\r��Gg� �*E�Q�Dv�|b�vFh�P���>��b����0�B�b�0c\r�=��*?/��FrD�|KTP��!��B�VˤO��f\"��o��D���n\rM��NQX?��<1Q���̈́�������Ϳ1�܃A�~@�*ě����w�d~��<�c7�@�1~3�x�*rM���p���LD��d\n#�����sH'#V���L�%�F��З�v�1�4�qc\$�\"Gn���B�Ϊ�=�^>M+!\n3\r<Rn�ޑ��1n��ڐH�j�0d�%�����&͟'\r�'Q�'�SRY&�_'1�1�/\0����f�B�Q�+����-C����6��B�\0�2���2�&2��R����d�\0R�&�O�*��(�d�Ga,��������\n��ˤ�2�۱���c)3��1����2,��L�1�k\r�u&���&���B�.m2��U���g*�I�>�-�6 E�w�٧�5���eBi�.�D�){)\"�8�H#��1�5��AGD���ͣ��!3P�s2G�1n���w9����'�8���3Xf�\n���2ң32�eS��&q:�r��@&�7���O֎N�-�,���?�3!AG&���>C����Ab���)�PF�G3Cb����Dt({��P�X}DF�����\$�:b0u�>��\nt^v��3+�M2���kHR�Tt2�T�-Ҵ��J�'�����v�TiK/�e\r�|#�~o-J�9K��pStwT�ݴ=h,&\r��C=Ϭ�\"���k�����AH�>�\"OBуC�	C�]J��LNȫ� �M�M-�SSA�!�\\L%EO>kѢ��uP�!>�IU-Q�1?�Hxu`D5%3D\$�J��(Mo1If�BK*���e2��O�\"�߂�d�3���N�*<�b,чZ��7M�/��p�ԐZôdc����5�{��v���30��*Pn���bu\00040����_o0t`���\r�V,�&��ϥ\"G��*�b�̎\r��+f��\n���pG�,��'p+,R�=���Ϩ��t|˴,k#[����e��������b&�e,�.�d��9θd`�\r������J�&��1U6V~�6-\"�3Sl�v'!�T��Q���`\r�'&H�v�O1w9�.�x%���P�Kav�����m��3VpUph4er*��v�-g`1��d[\$��r.w+p��_ѡU�9q�sq�12�~��\$���e�4��\rhr����P��,매\$�\"5��1&��\0ԧam�\\�tٮ�8���3�%���,S��W����X��uQ6J�l*�\nQ�d��0��>�>�\"�������y6V�+��\0M��R�y��r&ro�R4���Ԅ%�׆L5-:�\rl�#D`k�";
        break;
        case'ta':$f = "�W* �i��F�\\Hd_�����+�BQp�� 9���t\\U�����@�W��(<�\\��@1	|�@(:�\r��	�S.WA��ht�]�R&����\\�����I`�D�J�\$��:��TϠX��`�*���rj1k�,�Յz@%9���5|�Ud�ߠj䦸��C��f4����~�L��g�����p:E5�e&���@.�����qu����W[��\"�+@�m��\0��,-��һ[�׋&��a;D�x��r4��&�)��s<�!���:\r?����8\nRl�������[zR.�<���\n��8N\"��0���AN�*�Åq`��	�&�B��%0dB���Bʳ�(B�ֶnK��*���9Q�āB��4��:�����Nr\$��Ţ��)2��0�\n*��[�;��\0�9Cx�����/��3\r�{����2���9�#|�\0�*�L��c��\$�h�7\r�/�iB��&�r̤ʲp�����I��G��:�.�z���X�.����p{��s^�8�7��-�EyqVP�\0�<�o��F��h�*r�M�����V�6����(��ѰP*�s=�I�\$�H������D�l\"�D,m�JY�D�J�f�茙еEθ*5&ܡםEK# �\$L�\0�7���:\$\n�5d��1���8���7h@;�/˹��٨�;�C X���9�0z\r��8a�^���\\��ct�MC8^2��x�h���L\0|6�O�3MCk�@���^0��\\�����LD�/�R�����^6fY�)JV��h�]H�K|%(b��0��R��1d;Na�u\"/sf��U�o�)��uM\n�����W��zr2�CV��P�0�Ct�3�!(�v�x�z��^�C�]J�X���x��\"�A�=�*�����e)�_�rկ��H�Cc\$��6Pʥ��7�����0u\r��:7BBr�AV|����;H��A-E0����eI0�ѫ|'��F��;�y&�\"X�+�Y����ֈXK�~i`�@���s�`..1V����l\r��;\0�CrE\n!0�=�������PLQR�_n�+��\0�Nc�Jq�:7X+�i0\n�̿t0���4��>�d� ]��C0�H��\"�sH�^�g6qc�!{ϙ|/�\"^���4r&I�P�\$��/*X�Ett��Kރ`����d#󉥾Ah�ɴ�B����O�I�eQ����3c�u��ؑH�ݢ\\:�iIԟ(%4Ǝ��Gxl�� B�����/��D�9\0��w^a�\r�3�8p��U�	P����+r\r��A �Y[-�\00Β�CX����AI��Y��0RW�S\nA�3\r'�h-N|��|��h.FJ���L���0�.b9�n��\$�s�L�P�#M\n{�&=�gR(K�-�rd�8]/�r�+�P����e��1����cPJ\00021֊w�CJi�9�5&�՚�Mmu��>�`��m\0�Ƿ4�ݛ���[�dj�R�&��j͗~��ؿ��nL��P�KU�>\$t�dJ�*��F����O�qla͟���ii��W���Z[Mi�E��P���Պk�ɯ6��[��M�9��P�3`�`'@�Y��>W�0�����g�W��O�:�l�H4\r�&�b����.%�����M�c����4&UdS+8�@�1+����za�3\\KFn%�tz�3��|p� +;�z�LuY��:��s��J�ҏ)�\0((����J\"��<�ì��%��0�JZ~W@PCPMj\n<��yO9�=g�2�6N���?l��Š��j����?�jߌ5 �uJzvu�鿡�U�Rs��C�ce��2�����+g���0�~�h��3��8~1�_����bK�uZ�H�<w��k�Яƛ��*P����	J����N7�fT�fUR���n��l!�!�P1zϗ��v�D.�P���%Ω��T�+L�8�0�\n	\$|<��<^��d��7_#�|@q��Dd�k��kU�K&P�Pٱ��m��YׅOGuj!�R�xS\n�R9��Uy\$�_��L>�u.u�޷�k\$�����+�WLV�H\n+�nڐ:�(H�C%�������V&S�s�k{E��PJEfsR\0��.k���`����\r3K8RvI��! [�l�P��=��v�f�\$,W	��\"6|��P�*_�� E	�ư9�[��:s�cS�V�WK�5�����_�@Py��c.��3�3�)T�|!l����\0��'�Q�%H�\n�ms��Y0��\n�K0��JHJ(�_�ķdy�^Z(ӄ�([�+���T�k�^}�Ԇ7���W�)��c�V+j@v|�;K^�h\"��Ot����h��\$<�'�\nx��f�)F��\n]E����ʵ�wol7�r�(`��Vڅn���,�F�	�F P\nǘ�#�=� N8D&\n%0i\0[���V5np\\h֘)&K�?\$��J��쀼&�N%T�K<a�*���0x��0�e�\nF�i\0�\r�^��0��dp��2�&\n`�H�CN�h[�؂�������~�,r���zc���gB���G�vĜu�\"�n�r���ߤ�(�{o�,��	�@���R��8��*��+�}��JN�����ܐW�@�D����ojHQW���\$�o�s�l\"G-g �O��)���DLzCH��0��䚅�bƴ�%%:�pX��>Ũ�D,���Dl`�U����5o�	�V\"TKp����xi��	9QbO\n��`�L��d*ΆJ�>��a�R�,����0(\"#�#g���X�m�z�\r�&Q��r@F�D�h�)� m�GO��d5q\0�hg�&��:�P���(�%)A%C��2y\0c�`咫(dg�(O�*��)�j�o>د�qq,���Ғ�p\0���\$�Щ��\0���F���*��.R�����1ó%���'�6�J}.�10,���-D���i�(���'3,�҃3Gz��Jֲ�12������5���`��fr��.�m��͜��\0�d&(�(���c	8q��V���q'�9�R4dtڭ�=/\0�rS4��4�)��+�x�g��R�\$`��C=O��0��е9���0*q`��e1�Fb\0����s5�B���w��P��636��+\r�2ٔ��<���W��|�Z\0�=��Z�\\v���p#��	3!S��E6|O���µ��80GT~��44r�}6?6M�HTq.ʈ��ˑ{=3��t�<T�4-[I����\"����Ҩה��ԿK��\r͝D�AL��M�����4�#Lg�J)�K'�H��N��\r��Li��l����A<^�qg�<��Ǭ�o�'�����.��\"��s�.Db@�M �N\"5�r-�)T%Uetؓ@������3/��R�~.|���Q)��:`Q*�e*'p�4�,��I�;Xo6�	��GY @\n��0f�s6�����y<�\\S.�1��25�̆�gO՟1��5��ƃH�Q��5q.��֒��A^̣_�2���)=IvC�/�2�_G�Y��^v	K��A\\��T��?B�p5�)^VC��x�% ��-�a��cT �Ho\rg!0�)I�xq�q��?.5et�e��M�1f+<\"i=Rp�)v��r��@6ig�O%�����Bs&���h��5�#M4���TsZ��Y��i��Z4�n�p�t۲����7�ZL�@#������c.�A��d\\tSY6S�=.H\"qC��Kt��R\0� Q\0�L��e���r ˇ����<A��72�rlC�\0DͰ&�DI�A\\7p4�w9kC�O�x�\\V�r\$h�p!'���&�\\5� ���Ȗ�~j�7n��b�i�vT��os�Im�P�ďQ^�U,+�nQSz}o׏mD۷n�%	hHQnS�k�Pod��G_u�e��,v%m�/cv2 �kIms�^�&t�F)1������A���%\"[��< ���^8QJV;^�����y�	�v�QMN��X?+_��s���Xu��}Ow���bc��q��#�TS��{���䥆��x����ػ���!�JD?K��qdC�'�Z��/��F�O�-��S̊z���-k�7��AvG�^�-�{�X;i��c�Ii֋�w��7^�͕yC�����cb=mب���(&�qS'�0)�`��en����\$̥��݌�����	�y����F�ךdL~vj�1#Wy�w�*7�8)`��AQ�h��n��`9Oo5	cㅞ0Il�Mf�o�ys��S�xWy���)��ː�Q�9��9����|EL�x����^��Nh^F����7mYu�pr��8�q��- �Ӟ�!��u��Q��g��ͦ�-:1������	j ɓ������^\"Y)_�\r�:7������O)�w8��]��T�q3�UH3Gl�e�7�rJwA�OU�K��f�������Ee��&-F3�{E���rz�5���XKH�w�rP�Gk��K��F�����Vzq�m�s��,��\r�V���`�O\$�f(��� �� ̢�r+���@��fHí(�\0��Z�N�I\"��W�&Q��Xd�z�U����.%+u�X���?�w!j�'W��x�i����2❼7D�W~�\0u\r��i�/�,��	_;��D���'�	�v\r;z��{@u�TB\0���\\�d,��y�iSB��.���Ҧ!��A\\3�{�׫���K�nsO��Q+��9��m�d?���y𧜖�(�v�r�j���h�&��{�c6y���平�W��~QY�>�ڥ��ʇf�b�4�2ͼV'�|�W��[v���+��{��r9-��?�ԻʶӔ��͖�\n��>�<-Nl�5yt֘�A1�����L<�1igFqϧ�X����{\rөU\n�WO�u �/���c�L���W�ae-s\0�(��F�f\0�ij�������\r�O����'����7U�x�#}�/=]��g.��0�}�4�G,�<qn\\�~\n������7n�qg��Gl8��w;�p���������X�K��w��=/��}ٲA���:���>6\0�	\0t	��@�\n`";
        break;
        case'th':$f = "�\\! �M��@�0tD\0�� \nX:&\0��*�\n8�\0�	E�30�/\0ZB�(^\0�A�K�2\0���&��b�8�KG�n����	I�?J\\�)��b�.��)�\\�S��\"��s\0C�WJ��_6\\+eV�6r�Jé5k���]�8��@%9��9��4��fv2� #!��j6�5��:�i\\�(�zʳy�W e�j�\0MLrS��{q\0�ק�|\\Iq	�n�[�R�|��馛��7;Z��4	=j����.����Y7�D�	�� 7����i6L�S�������0��x�4\r/��0�O�ڶ�p��\0@�-�p�BP�,�JQpXD1���jCb�2�α;�󤅗\$3��\$\r�6��мJ���+��.�6��Q󄟨1���`P���#pά����P.�JV�!��\0�0@P�7\ro��7(�9\r㒰\"A0c�ÿ���7N�{OS��<@�p�4��4�È���r�|��2DA4��h��1#R��-t��I1��R� �-QaT8n󄙠΃����\$!- �i�S��#�������3\0\\�+�b��p����qf�V��U�J�T�E��^R��m,�s7(��\\1圔�خm��]���]�N�*��� ��l�7 ��>x�p�8�c�1��<�8l	#��;�0;ӌ�y(�;�# X��9�0z\r��8a�^��(\\0�8\\�8��x�7�]�C ^1��8���8��%7�x�8�l��Ŏ��r��t��Jd�\\�i�~��V+h��\n4`\\;.�KM�|�G%6p��R����\r<1���I{�����B��9\rҨ�9�#\"L�CIu��&qd�'q�c�|i(��Qj{\$�>�\\V\"���7��'6���RŐ�`���߬�B&r0��f&;#`�2�[�)Ћ��*Sw��t4���\n��6*��G��%^�U�\n�����l�\"�\0(���IHq߻C�OIڥ'�8��㾇�+-�{,��J��_\0(#>���a�7?�\0��D���)���ձTC*h�!T/ˑ��T��S.� \r��\"�'����%�C��[	Yo����h�R�c�턓+(MaނȵsƢQD�vhJ����1�m���ʍ�[�tB��EUb�|��!>�:��S�@(��N{�xf�����X�W��;k�\r��ϓa\r��UX�τ��Ҩsfa�9K���\nUH�������<�VQ�<2U\$\0�Fu�T�\$�^v͂�-ԜH��<��0�s��\"�v�ѷZr���{,����!X��J��,x�q���{A�k��^���D�M��1��c5=l�3�|�Dh�\"�4���Zx/a��:66���bJ͕�����[u��=<8q��� ��jK\n�'��wP��_g��-Ꚁ�3hy�PMd��5 ��يm�4�����6��ힳ����(wh�\$7&�\\�sPPjC����BHm�6���Q�xU�:��f�kk�L8&�ue�]0+�;����9���!D�h��=Q ���n�}�Tnʺ���c�r��8o1�Ble�[p�l� u�����,�:G=\rOS���͍q%�ǗX�1ݽ%����w	g�P	@�\nc��B�mB�@\n��^-��U�PCQ6ܺ��|���?�2��.���A,E�������+��^#;�T�V�75���C�Rc�M6 v����e���:��#��\r!����uO|;����%zR/o�	�߄�.�K%U��º[��6	��e�v�STe���ǔt���B���JOK\r\r.���6L��?��8�p���2p\r���0�|��d�W�#���T�K8�_�!�t]�O`��\\�]I�o��r:�<�Z�4�(�!�#�QvՇ	���c�u�����߁�f���֞}�b��!�d�\"0 �lvB������4�&14�b���'(|�\"�d +8�dU���2Tg�K(��xNT(@�(\n� �\"P�x��Y(�o�d\"�H;� \"p��5��9�br�\"\"�Q')g�\"~v��t�E5L�N�Nآ�(���`��sJ�ktd���ipp�Œ�ۉc��!��\rCZ\$��z�8<`���Ѣ��S��oAc�b�\\�����\"�VB]b/7%GS�����=XЫ����Q�R���!?�̸	�u���R.z�,+.e����\"F(�8�k� �_�u����1�hpC�c�9\n��0��F�Se�Ts�np�X7�&�+>�>�;����d��-����L(dV�1�N��s��E~�x��u�������P`�t��m��nB���\"&�.�%bq��9���f��v&��>��?iFDG<'�~/;�F+/�DM�1�L<)^�%bE�8�js�^Ԃ�V�ˎV\"�pF��t.��嚋ÒZ\$�Z�t�� �	\0@ѯ�b	Nċ�>@����~m��ä�e^��@�1DJI����\n��K0�K\"g(�j�s��;uθ������F�/d��\"�h��bWG_�w\r�\r��Pi�^i\nw������E�\$�&�	��e @N\0�u�N5g��g�c(��'�B�x/`9Qn�P�q+\\�)��0L�.� ~X%�t'v\n��FLM��M���yЌBCZ�gڟNE�J-��H��XX\"v��X0RX1tnb�n�P9�h9�zSÛc��_�L�hVf�.|X�D8Ð��P����1h'h:V/N�g�B�H1FTh! l�<.{\0Q�X��\$�;���}H�p\$V��sqD�Evs`n�V\"�;r*b�'�0�r~XD�mR��\$�P�� ߲���5�'���f�I��/!n��e��������N\0�O\0~+1�H�q��C�h+f�.)~\$).�5*�8�ȯ/�.o�IΛ,�Z��ro���C���r�A�+�������Ĝ���������N3������14IN�'X�'1����E�5��,s.����sx�h��c*p\r#�1��2�2S��f�7�i9�̬eJ9�\"��Tpb�b�&�;H;�!P�%��u�\rbT����f�#�A�f��\0\nD����#��)M�?M�&s���3#h9��7�:'@r���~4�0��)�~5�D�}Aq�P�Do�)���7\0@{H*~,d���;�7�Ρ��?E��sԛ�q-)�F��n�(�G7E���vQ�\rf<4Zv�DwcE0Eh/?�@��9h��	��MOT���/�M\"�y0&'t�pt��1�q��<�Ȍ.|q�r�(A��G��3kP�Q�;�%D2jH���o�x� -�50<뮩P0iR�r ��OT�O�QO��S���S5GS�z��?UKXr���SRͣS\r�SS��Q�[�T*��N\$o-B�:#h+���B�xF�a�8X2�<0L�U�X��qot\nFVargVgQ�\\I�\\���J����']	]Jz�����J5iA�l��#Oc�j\r�*Q3�`P��N8��gJ6�����C�\r�b'�\$�PX\$�T��P�c	���`��1_29\\�e��e��6�aU�P�*�i�f�c8c�D�@�qTӡ`A'cV�M�a�EWU�%5D�sg������R�6�o`5�<0�k�_��D6�X&ߖ��1��Vz+\0�d����S#L�ˌ�'�*+3�����[=�,��\rP���TB��T-�n-��gZ��ZB�&��\"�6po��S�'�r�a>c�G&s6�����ɘ\r�V� �`�ג����D��9F��B���\r��bl��@�\n���pOjJ�U��8��P��+�:�j�R�V-r�mI>�μ�I��*� �{\0�.^.�v[G�9�� 	2�Y�PL�6��nC=�MµxN�w�\rB\$ukl�u1��p� 	��ۆ�gDA`���uG�����R�V5�Tg�nn�X2<��+2�'֎����,����r�hG��'�\$t�6��)�5ӏ6k�ҡhVe��\n��?��=̜��P\0০�*��H߈oh�WU\r'�[�h��+��h�5G�F����t��K|�nǏT��W�8HB.�I+�'F�_.��J4��<�\r\0\n�4��\r��&����[GB��6F'�<��T��NWH�mP����#��*c�W��E�/��q�x��T�8<3�,Db�)���867<IG�x\"�5{X�桖�o��;y�.g~	\0�@�	�t\n`�";
        break;
        case'tr':$f = "E6�M�	�i=�BQp�� 9������ 3����!��i6`'�y�\\\nb,P!�= 2�̑H���o<�N�X�bn���)̅'��b��)��:GX���@\nFC1��l7ASv*|%4��F`(�a1\r�	!���^�2Q�|%�O3���v��K��s��fSd��kXjya��t5��XlF�:�ډi��x���\\�F�a6�3���]7��F	�Ӻ��AE=�� 4�\\�K�K:�L&�QT�k7��8��KH4���(�K�7z�?q��<&0n	��=�S���#`�����ք�p�Bc��\$.�RЍ�H#��z�:#���\r�X�7�{T���b1��P���0+%��1;q��4��+���@�:(1��2 #r<���+�𰣘�8	+\n0�l��\r�8@���:�0�mp�4��@ި\"��9��(��.4C(��C@�:�t��2b��(��!|�/Σ���J(|6��r3\$�l�4�!�^0��<p��+6#��@��m���492+�ڼ6ʘҲ���Ƨ	⤪YP�\"[�;�����Xț0C�����ԉq���/�����(�:C�;0 �RAb��;�E�)?^�u�N�փ\$���%�L�D�_43E8� .��:�+f, ��l\"4�-H�ϥ�������Ym���lc�Sq��(���<��P�Y��;wW���z��v}�O�.��O\$V�c�jz���/p�:�����p@��9�c��m�z��qȂ5�H�|�����k�Ųj�0�VLb\"@T�Y��\0a��j>6���>�m�p������rd;��=���x�l�L�I�b�V���̖!u�o�� �k8.�\rn����D�Û��4a@�)�B0R\rL��:��9\r�X����3���{7ao����n[�\$�\\�'�qc��\n�>s�d͒���Xk]�莑�F��|O�A(E�PwQ�9'e\$�p/&g�d�8��%��L�C!x,�^�T�c�v�v�#�L��uO��@�LA�yDa 58[\0���meP3'ӌ@��O�� G�l'����VxP��,�I?��T:�Qj5����Ԩe?'�TB:���)��/\"�n���E����rGU��7F��Fb�O��&f,̑'�ڍmC&a����L��5��O��b�ȸo�F壊wt���x����rV�\$&M�\$NPpn_F��%'�HRq\n (���P�y��W���V0���y[a�K��P�H�E�,�˔���E�����X�	#<�m�稵YD�&ĂS͒NATGЋ�4�d��M��7��Ӣv݌4@C:�&ƺ��	�SI'%-���(�K�\"�,5�ܘ�,�'τ&DX�@�j�#�d�&5�Pb��'�L2�'��Ð'�dd���tSI�4a��/�R�V�r_R1Һp�^�x3@'�0�MOHiO�&6KZ��Q\"��>��F��L:��Ή�8�=nʠO�8F\n�T�69`M��r�gٟ�fR��q�\$�JV8oҲ()锁��\\q�p:M編V'��PH{����\n�YS\0���\0U\n �@�7A�O� �c%UZ\rR&���AMκ\"���u����r05�\n΁Ƽ��t�\"�Q�3gf}>�7xwC�'la���T�rN��#����i�r��u���\\�[�*�!�_���E=!���\\��{i���!�8q��L��ǰv��Z{�l�Y�O\"Dʼ �5cP�^��D��,�E��/h:>i���9���y3%���[\$f%:A�Y[�W��р@�%\\��s\\f�,�]������\rb`R9/-� �\0���%���+�儲��1#��9�]4GX\\�k����.��2����a�g�0���0�n�\\�F\$_<	S�h�����bcJ%]�h�\\P����gD'`�\"�ɐ�)Ӻ�P �0�p#�ٕ��^��@��SRA�2�̷�\0/*�j�g����@��un��Uì3s�;-�vO���Q����>�	��w�����Z�����R��qc�w�������a��\0��k�%�&��.��z?]�+%u��z���'{��ZU�|[��W�s{�����r��)CE\$���6t����5�~LL�UD��v!��(b\"���MC��\n睹�Y�S6�lǨ��c�Gh�F1�ͭ��y&�AHZ܀��l����/9CR��k6�Ǖ�B�3+�|��䇷Z�0༿��:��L.%�˚5p�� �������^��5�R�����̅a,E�x���`�\"5�����)a{��xJ�Knb�M��Ԧ	 ��M��t�K��]D\\l��S��%�vю������5~3 � /Xj���/���ll�;(��&���^�HT]��7\0@�b���x���N����@�d�704�8��[�F�D�����Ft\"��-^��b�p\"��u���eojԭNA�\"�F����LmL(j\0�/І�:lEL���	d�	��@��9�h������A�X��`0����0�,��g�j�l��LZ.MXk�����׍&ү��[\0���j��R���-���W�)Њ�+��p��^���\r�;� |@��ԑ81p��ĉ�b��;��>�Tø-�L�DhG^����1o3	�\nЂO�Vu��a#�\"��Yьk��#I�\$He��:0�G\r�6D����`�\"6�K����E�3���w�	�xq��H�咒Q���3�:`�A�\$Vڨ��14�)!f���\$��E�!0�	��F1�V�L_\$	(��<:m�jc,x�:_n|w���T��+%�Vw��,F���0\\���,���&�P�Y(�Mo2F8��ɯZ2�3�6^I�@d@\r�V_B�kJ��+�\n���ph@�@�|�p���2�\\�ҮG+p��=&)r��a/2n��pV-bc�\"R�nFbC,��\0�/'1��`q�G�|�%�\$6#f\\\r�;e�s����\$�B.�'Y\nkT9%h�I�æ@gRq��\n�{�f�0�,�Zr2^��ç6'��7���t���Y��3�}(��� d�\$){�^l�:�7�O�W��ٌX�M�BJ��`��!>h��#��>��C\r�Xi�4��_��K���\\�Rr�4E�/��I�\0��pc�?f�r#ǉ\no��S�F\"����9�l-���CF�� ��]��X�\$";
        break;
        case'uk':$f = "�I4�ɠ�h-`��&�K�BQp�� 9��	�r�h-��-}[��Z����H`R������db��rb�h�d��Z����G��H�����\r�Ms6@Se+ȃE6�J�Td�Jsh\$g�\$�G��f�j>���C��f4����j��SdR�B�\rh��SE�6\rV�G!TI��V�����{Z�L����ʔi%Q�B���vUXh���Z<,�΢A��e�����v4��s)�@t�NC	Ӑt4z�C	��kK�4\\L+U0\\F�>�kC�5�A��2@�\$M��4�TA��J\\G�OR����	�.�%\nK���B��4��;\\��\r�'��T��SX5���5�C�����7�I���<����G��� �8A\"�C(��\rØ�7�-*b�E�N��I!`���<��̔`@�E\n.��hL%� h'L�6K#D��#�a�+�a�56d\nhͶ�Jb��s�b��d,��(3�@#D� �Щ{V�F:4O�j�@���#E�1- h�F�G\n7��iR%e�Nܦ�����2�GB�6��@2\r7��ô8G���1�n���\r����K��Z�e�9�����4C(��C@�:�t��6=�ǃ8^2��x�uݣ���K8|6ǎD@3G�k�)���^0��Z��1|0���F���ZS_?4�@5j��g�7�|�>�r����6-Hٴv#j�������t(+�#����J2 �ė�;ʜ׻N�l��|YS*jH�!��4Q\$���>!�s=@O�!\n&hٲK�3���A�Dp(|\"^��6Z#��6�,G�eO�4R5{ɢѮ��5õJ������^��5����六&�g�Y�Mi:�%ur�E���!Hl0EP\n�X3�r��C���������0���&C)Z#S�|�11<ޔ����mK@)/鵳\"�R�y3V0�5~��)|\"��g�����L�A����W&�����F�U��=��hb��T�T�J�ז��zi��n!&���X�jM�B��@PDOԒ�����S�@(��6�rxf��d�f�kB�o9lx7�@R�u[h39�@xgD�x@��g(�G�Բpu;��9���f��sV�	H'@@R�t�W��!y�u�b��a`��p��BP#2��4�\"V�A�trh��b��I���*Tfu��r��l3�� ��iQ)E���\"�^��}����X� 90��bG�������\"d��5,�a�A2\$�/�s�(�z�&b����2~}�Yl�9T������Oj�;�	��5ػ��x�z�I14��_�~/�\0���`������jNJ	I*1F,Chp:A��I�� ������C[Z!��J{;z�\"\\�\"������eg�AhTCĴ�\r!k�4�(l|��T��0i�d!���(�E�k���S�u�4�:;OCK�r�=���噳�0���RK�W@\$\0[cŽ�>�0��\nh�\$�9���9B���S�0�����a�| �xҥ,s�nTc�sΉ���j �u��Zը7�{�cQ���TVKP�r�'���\$rƎ��l=l��nx�n	uQf\"���a���ξ�l�!��U�Z�\r�h�̻+�Q!�������oZ1H7���9o ����9�)0ZM[��&�3��U>�srN�J�OI'	e���r���\r��e�]sZ!��ٍJ�U�F�8.;tXy�=&M��`C�~.*��v�E�	�L*<��1<p.L���z�9T �|�B'!�s�5������],��*Fʠ���M�*eN�K�x�ѹڎn���������0T\nw!��r�c�Kɤa�tz�Z�..�S]av�l�;.yx�\n��I��e�LC�O�q�,hl��Ts�cB�ͤfUb���Ѫ�F���]Q/1������T{D5/�[���,�0�Jb�ԽQu%=��l�\n��3����4��D��	���\"3;��D)kUl���\n�M[O��NWg:tOe|v��htL ���j/����48Q��ɴ��W���Ih5���.�6��*%�G�0u�E����}SY)�vJ�E�ѓd����?�]u~ɽ�Ѳ6����=�B�B\nv�A�gƟS�S\r!��\\\ns �S�J�ܾ)�_�\n�4N�����e�Sct-�1iƋ���SS�K03��H�0���/]G.hLp��ȣ��B�7٨ed�\\���#�qF�\r�`���\nbi�5J;|8�l�#.�M/w��Ղs)����O(�\r�;�]✩�9\nw��,�T���p�S�C���t�cXLŊ\n�� �	\0@�r\r%���Z@๣���n����@I�~e<O���mE\0��`m�q��Je�0n��='��V�ǶCN��mvCL`�N��\"O�q�*�\"c����\"��f��z�B��h䰗p�F�%�)������#𪁰�,����nk��p:��J�V�0�j��xmH��h��'�*�����k��p�Q	\n�ׂ?F���np�o#���|�plރZ	��Y�G`�#0���Z6\$ߢ�N�FA�\\�`r��B�h�5�@��8�!j=\n�%,��-�vѭ���e\"�(e�Z)�*Qe��5g����k��c�u�.f+ �龜�x�Q�)��4\$�#CFf�p�X�ip��44��@�dqi`Xm����尀�pfP��3\n�+2�II�\"�)\\�1�.��\"r�2CB����\\�RQ\"�\rG�%�D�\r�%nB�r�bT��H�E{%�HO\0*hN��\$�#r~)�#�6�1؄����G`�Hb\$L\$Rw�\"��GⴠdL��'��,ox���)�t����� o�'�W&�%�B*a~.r��E���EB=�F� P�\"�bT2��M��q���^��;%\$H&2E�T����/���d�zjA2FQH\r4�M5|��4sc3SO3��/�10\r�*c*�&b6�#&p6\$��9L���������^	\$�5E\"��!e�9��2��/���P�Fw�=7Я3�9�<.79��4����e;��!��\"���v�O�8h�23�%SA@�p!mu\ni�ϕA�y/�}7�^=4\rB�kB��iB:q\"�,�f��Z�m�EB�.�rj��0StR*\0u�22��B���\\�4a!FWc�r�.���D��� ��z�&0�Ŕ�kH�KH⺑�*TBQB��Db4�g\"´�{�Jj�������HܔVA����@so8&���wA�>(�Pd�TJ�h/PsD���/;P/,��QYA���5\$�3\"�m5�@+�E@\"�6�#8�ie�B�)I4�U�L��E3\rH�U!�SB@1b���N.��*0�&pr����R�B(O9��g�UP�Q*�T΍<��)5Cs�4N�[��\\UGU�G\\�_,�nu(lv��]��IO�<ғV��U�(�_�/^��:5����0KRϱ�Y�0�kj��^�½S�+420R��;S�V7b��D�mU��^n�/�E\"L�Ee\"�b�0KC&�OU�_��d�b�W5��\0%=*��&S�CV=huhpQ5��o�U�^�r��CU�?6\rM�%*���т��`URgCQ\\�U��_�(0������p��ܪ\"n3�=�-�rUp�o\n�c~n��.ǎE�NE1���0�n��I7\n��@VOn��\"6�>v�;5J)S�s�oo��T��pw;!J���\r�WM#|2�&��,��')��E��̷UN�'N34@�Ԡ��Ţ�H�\n���Z��`�l�\r��2u6�|#԰x�T��C��w����OEA%��I���{�a|�5�*�d�(-����(��X��\r����A�dWct%1�>�J@�M�NօED�Al�/��O�bl�C�x5`&ӠC2�Y�x	��ӆ0^��<��F\nl���oC!\$�Diܔ#�2(�z�.�'2`�7R2\$6iOPr\\�t�F6�Mon.%�c��(��	����\\؟'X�;�Y[�D\"qN4�7�\$�>6��]�t�(?\$�H��eU)��sԥF09(���!V����.`����w�N�\$��ģ]�£:Y4\nŮ��\r�a��Nx��'_�f���!G�eĳQ���\"���B�z�2��Ɔ?�%֬�h\n�E�΁��ߋ�Q���-3�y�]Gih����F�a~";
        break;
        case'vi':$f = "Bp��&������ *�(J.��0Q,��Z���)v��@Tf�\n�pj�p�*�V���C`�]��rY<�#\$b\$L2��@%9���I�����Γ���4˅����d3\rF�q��t9N1�Q�E3ڡ�h�j[�J;���o��\n�(�Ub��da���I¾Ri��D�\0\0�A)�X�8@q:�g!�C�_#y�̸�6:����ڋ�.���K;�.���}F��ͼS0��6�������\\��v����N5��n5���x!��r7���CI��1\r�*�9��@2������2��9�#x�9���:�����d����@3��:�ܙ�n�d	�F\r����\r�	B()�2	\njh�-��C&I�N�%h\"4�'�H�2JV�����-ȆcG�I>����2���A��QtV�\0P����8�i@�!K�쪒Ep ��k��=cx�>R��:���.�#�G��2#��0�p�4��x�L�H9�����4C(��C@�:�t�㽌4M�?#8_�p�XVAxD��k�;c3�6�0���|�+��2�dRC�\"Eނh	J�-t��NR������V\r����;�1B��9\r��Ί�\"�<�A@��B\0�G��:��I�a��ڤ�2#!-�%t0��d�;#`�2�WK!�HJpT�cvT�'��s����c[�_�K�K.ޥ�S�er�EzP<:��P�]h	O����6�NHG�,� P\$����/x(����va�\n#��T�.�@�-��3�6X��\r�o)�\"`<]@P��acM �d�H!�b'4��\\J�i��©�މ�W;{_����PµE�X�MJ>�3��/NS{Z���r`�2\"i��vMI3r\"\\�;�@P�U|7��5�7�X��#�?.jD�	\$���B_\r;�G轺9F���h�A�R���4(�X82D���a%���\"p Ιh(n�)h\0`�6DȽ>�r�^QH�3I�]\n��K�j6&��.��,߲.\rho ��HڈQO�9+@ƅ��dQ��+�t���XKcu����.Y�<7�ȅ�\nZ��7���ė\"�%�@4��Q�;E4������t�0M�2�6�C�+�-�Ծ.�\\F�!.�Z�U��Wj�_���V:Ɋg�5%���B�k-�z�0�&R\0006ǐ|�g<�-�����U�ȑ�ĸD���~�	L�t,8l\r���Cheb��3!\$��Ҝ�Ԕ��PA9&��N\n�b�n����H]�D�I�]�r��a���8!t-��P	@�534G���'ܙ;r��P��qܻGn�i;H3�%Z��!�3a�LM��8�\\z����A2(a�W)��U�B�\r��U��^�C���]��ί��� ��R�f��d��),]6�9#�����Dn���iva6���SȮ\"v����P�M'\"����A�]P��|\nIpI\"A��@�Ŕ��\r�X��%rjz]����%�<נl\rꖊ�E]KO�i]�d���HJ�`/\n<)�Hw�9���F6r��Y93#�ĝ�P���'a�G/W�E����[QBI\nE�f��\$r?mfi�'���%����9�>��n��+�Mپ\$2�`5�#L������\$�Y��D����\$��}(ɉb]	�9(�6�#�2d!&���L9�:�	:��S	�%�y	E���>A�\"-dl2\\�>wp��	���ˠA���b,a1B�H�'��գ�o��b.F��52�� h3�x��BT�����R�J�K&����AX���|G�y\"�0��:��ێ���dl�]�&�0���Z��8����#EB}�K9\r!����[6d]�^7\"����G��b��u�֧�T�\$.N�ax�\0��ρ�|-�5l32�[d F�6#��+ˤ���%�xH��8�i�3�����\"�D�f\n-��7.�P�t�M�RWie��C	'P(��P,ʓR�^�9\"�E�y���!��\0��d�\n�טX�����lGV����]�'˲A8Y��r5��1���Ɂ�92�\$��n-�8�3��q��B.�ə*/ٖt-�R]?܊;[�Sd�4�\ri�ւE\0�D��/%dˬ)Ci��u��XX��R[Bi<�w\\g���L#�?X()�a8eا�����z˓��Bf�g\$V��(�X9Wj��Fr<�6��9.z��ZCm���H�'�=?�#}����H�u\n����Gt�9ͬ\$_��p�I�-U;G���^�����0�()\0�Gƺ�#� \"Ķ~aDA.�e��x���w�`E�-r֏���\"�Ð5�l����!�<qĺ���q��\r&8i�Xc���/n�#���n����˼���zto�țuB\\�4C�FI��UeV�Ru�X�Nl���or\"Є�h0�/���{��%А�M�	n�	�6�l�0D��9�~k+k�b&j���߄���i��J!-gn&1��v�g����&��:bd�͡\r�*��+0�\n���P��GYF�C�R����6`F		�	�\n-S	�����V�15\0�J)l�z\rT�����Р݅�\0���VvY\rg-Z91m�m�|�Ǯޱ�ݮ0�a^K�d�rۣ�P&H!��C�>�\$��â_eh��_!YDo�n�1qQ#��Qq�{�C^���x�O\$�jއn�� .����ɏ�/c�5q���\r��F�\r�pG��R0ق0#_\"22�r	#�&aeD�B`��q��В���M��,<�f��k!�M�%+�H��(o��ʮ��ť�%Px�X0�(�2�`�4�����OjF���p�;�d�)r�!�8NJ���sπy�� ��-	��f��L�E�!.\"�X���\$�r�p�/O�4�6L\n���ZH�����B�e��P�1�Є�]S0|%��G\nEҔ�\"�X�cf_E%\$'H\$wU/�F6��4a40�7\$�E�fG��G��Q\$qG�����P���r���y�:��t�,\n�7(,g�'mQF�3�18'�H7w#<��`@JXj&�m+��P�4����:{�h�7�4<�_)+���m�@�wA&�'mqmj�򶏰�d@3,f-4��&���@t�*͂	hr� �0�@��<�\nВ���.-�\\x��\$�����7��4itƴu\"~:��;��*�4�L�3��J�U4��h-��_�uH2";
        break;
        case'zh':$f = "�^��s�\\�r����|%��:�\$\nr.���2�r/d�Ȼ[8� S�8�r�!T�\\�s���I4�b�r��ЀJs!Kd�u�e�V���D�X,#!��j6� �:�t\nr���U:.Z�Pˑ.�\rVWd^%�䌵�r�T�Լ�*�s#U�`Qd�u'c(��oF����e3�Nb�`�p2N�S��ӣ:LY�ta~��&6ۊ��r�s���k��{��6�������c(��2��f�q�ЈP:S*@S�^�t*���ΔT���^\\�nNG#y�j\"5�>�4o��7@L��@�X�<5cp�4��j��9XS#%�Z��!J��1.[\$�h���rDa�_�g)[-9@��)6_��D�eۂ�%�yP������1[�\$j�W��9@@��Cr�D��L�r	*ݜ�as̓0 ��k�� ��2�x�m8���c�1�P��3�T�#�*;�-k@�4h�;�� X�H�9�0z\r��8a�^��h\\0�3�����x�7�-LC ^(�����������T(7�x�6�I\0D��YRs0�I\\����RN	&s�#lWġrt�4|_\\�Mֺ�E��]�VĽm���7;�8懌�0tIdlK����O-�1fT\$9��Q�E)DOb�x\"T#�6Oc��6�(iZ��r^�Yy7wBZH�9i!����B(e�s����G0�D�)�s�Fq�V�%�a�n����HF��6T �#d�cIσ�7;\"��r�(�v��I&r��[��7NU�u_V��1pW��TI��EF����\\,�0��1t���N�z��^:=�C����]E��\r0�jNaj� VP91�}PA�0�6Nm�%��X�7�H�<��\$:�t(͓�`�3���6:^`�3�.�A��,�7�XP9�>l\0�)�B0@���9F*ةI��+H��Q�#D��xc��&�\"���\n�H�5��j���8>s���Ba�:)�\"��TʡU*�\\� �J�[�����W������Vy�\nje�an,���D�1\n�n��lL���p��M\\WA�K����iT�)�=\n�T�U���Ոn?@�Z+ep�ЊB��`����mV�� �\$�`��DֱS�p?O*A�(��X0���P���(�Y	�B	�*��̘R��#+\$���L0�h������M�=g�~��4��>c�a���7�\\�y#�X�q�4����4��t�H\n\0�iMDz#��!� ���c�A��yf��4�����\r�O*V��?q��V��J~�)�Q!�](G�~\rj�\r����X��(w5��4H���( ��ʶ�꣍���\$��`L�	5&��B!��+���d%X�%F>��1�\$���tK2��G�k��,�9���l�)Ҍ�����tàJ�СqHƅ!Û�@'�0�9Ɋ*ΜG�\"�@�/B\0B��=R\$8����F�)a�2\r��w��E*���)� @�� 3�\$#I���(i�������є?ŠR	h҅L����P�*[{o� E	�▁Z%���J��G�%�t�H��S2��'-��:��F�\0`���DT]ޑ{ �g��>�*\",�1��#�c�x��a1��k`�꜕y �����*[u��G��BYQ�	q���'aS�^��{R��\n�j�D�ĪPJB�s�-�-�#�ݞU��Hze��?��]�����~��H�fc��LΆP�yWj���=�����WS>Yx��� Y��x��Z-�(���	E��6)4���X)��υ�M��&�H��,�����1Ӥq�8H`�\"ԑ��%���\"�O�3M�P*�[?A�</�+T��p�Ʈ2�>)O6cu0L�@@�����\\\n�D�E=� הW�X��A��] ��\$�l\n�&�?�>*�E�1�Aϗo�oಁ�m���(_�w�;��T�A����>HEJ'�6�p\r�9���Bw\\1����bNA\\2�.����%���ƛ��ea� D���\0]�V����<¼���#���l��_y����x>i�qs	�i\0:GJ.����+�?KW��\"�va]O���^�LG2�v&	���\0^23� ?;�F.9X�{���w���DG��/�/1��,.uݛ�.�4�-A��qa�z�F�*�u8���rU��k?z�L,��%��X4��4�`��{iՉv����Wk�_�t��|_�1s򳷬��噘X�B3���dԜL�M��.O�'V\0s�!\n�����5��>9�.GT���z7�2��J\nx�/�L�z*����n��u��-\n��F��]��G�ɰ0]�쬳N��gW�~���2)����V%>up^%\"��f��dM4lF�-��\\G>I^q�\\��l ��70P�N��*�u��*���%�\n�ri��Nf�ͥ����qaO>�ȓ\rg\0A6��a���0R��ϐ�]P��D�L��,�0j����\nϰH_�nJE\$W��	�dJp�1.�c	�����jF��@-t���î��,��v�V���F���b&�B(�F81hHm�:������	�{��j�\r �\rd?eFX5��\r�ǘR#j�B\r�^OjV|@�\n���p@�B��6�����H0P�#B8�#���	��\r1�!f��.!惌����!��-�F�.�J�ax1��\r�0Xgx5#b޲E���j!:Hjl!.�o!\0.P����v,�X.��z����f����o���09'��\n�4c\$2�T�nA���\$��g�q��dN��pL^�E�2��x�K\0- �rf�O,���˯!./0Ӂ]'�RC�?`�P@���#x*A��\\���G&�n\\�bJ�t�x<����l^�\n��\\l\r2҄�Qll#�����\$���\$T@�	\0t	��@�\n`";
        break;
        case'zh-tw':$f = "�^��%ӕ\\�r�����|%��:�\$\ns�.e�UȸE9PK72�(�P�h)ʅ@�:i	%��c�Je �R)ܫ{��	Nd T�P���\\��Õ8�C��f4����aS@/%����N����Nd�%гC��ɗB�Q+����B�_MK,�\$���u��ow�f\0Y7�D�	�� 7����i6L�S���:���|�h4�N��].B,�i�\n�S9�+�:���a��>E������:�\n)�M&�<����N�Rzd�@�t�`�n5�N����9\r�~\"7-�R����7@���APx�<6�p�4��~����d����8���*�O���t�ě�K�����\$d��qr_ �ּ/D��]g9f]��b�����*��\\gA2��y��L��!�h�2]��*�X!rB���# ���\0�7��\0�:�b8@3��1�md.���7��ώ�Kn��M9����4C(��C@�:�t��\\3��@#8^2��x�K�#���JP|6�,��3@#ki\r��^0����@�1&C���t�%y�RRI s-�~Wġr��GALKF75�u[+���:���PM��\\\n��7<c8懌�\0�<��@���a	[e	<r�˂d]�9F���Q�E���.�B%D0��d�;#`�2�v��C��9zr��}�M��) D)��8��!v]��!���sĔ��'��UFLs� ���8*Bs��J��L�d�8�h��A���0��\0�&)\"^�OQ�D�qb�r�.�t�7���ޒ&�\\W']�%Yz�<���H��s��|��|�r��)]%����t�I0��e�j��V\\92��P�0�6N���2v{8��YCp����BP�6Z\r�x��t��9z��0�a��3��:���ĩ���\0�F5��5��\0:���4�&�x�I�~�XWa�\"	���=��,��5� 9=��q~G�N42��\"uS�mP�5J��J�U��Xµh�����E���DYg�g-~�2�p\"�Y-1��`��.@�(�2�5GXJ�Ú�SG�<\0ҨC .S�~�EL�R�U��X+ ��r�V�崫�.�V�	!�8�ڮ�M� H�&�M|�0�'�������E�~!W؈�U�Q+Ϭ\r}A�iJ�CcwF~O�(I#�Haљ>��^�w|/��)nk��}2<8�\$K1o܍�1hK�(��\$�C]KJh�t���#ţ�@\$\0@�����3�r��R�`�2�\r����D�4������T\0r��ܧ�.Cxw��q���l9�0�����,�EQA�]�W�\r��\r���)hүXHw7�4IP��3\n6�E��Uo�@��G�bL��¸Z��q�-�\0�\"���b�(P �,H�yx��4��B�xn��֪��Ú|�\0006��i��o�G�\n*��Y�\n<)�@@�#\"(&�	��H������@Z�9k\$���V�bW�1�3M��¬TK\n���)��@�h 4�(#I��Hi��N�z��O�@D�R	a�/�0��Ԧ�BP��O	��*�\0�B�EWh@�-�b,L^�! #G93%�<A�f�|/�km�鷻��!W�b;'l��vEE��/�N.�I��ٔ�e��劃��,�ٻ�v�u��d�z�ȕ�A-�����0wB�EUb0\"�\0����q\"��!�i�Q�����zpN)�-_�JLX@FB�.�[p,�Q��5ֻ��/b��Hzf�F?Fi\rM���	��#4�y����p��h�]��x���9Š�g��r.w!�4P�ї@s� F��.P\\�P.uкWQ���9R�#v�|S�a2/5AXɡ5J�\0(������`�H�.j��]�v-�\"A�Nx�C	gS�T\n�!��A]��iO,����(���%4O�Q�*E>�|t���z�� ���X�B#	p��Psn]�(�\0O	qgx�A�#ĸ���t�����pN]�N�є2�j*��\"H��;ܤ��� ^��ۣ��=�.�\0;�r�N�\"z��rH����NU��'6w�xr\$ԟ�H������8�G7k�o��֙Ⱥݳ�^�9�h�%�T-տطp������͂Tgb0`�+���t�2������s����z���b��_�ο��T:Ջ�/��I�C�ǧCa�2�x�^b��f_Q�ݳ����^���Z��lP	I��PD@����Doyb�aň��|0�Ͼ�ܗ�]=V��:,�i\r���h�_��@Iw��Xg\r����b�\\1<N����9}�%̸_�}�r��H�6-`�¾,^A�X�(��2��n�8O��˚�뢺o��%��8�o��0D�P<��8Ң~C��!PHP\\�N�\"^����D�&�����\"�.]f�\"w�P�.�����m\$9>���*�po	Ç�7pP����M=lh�Ah��<u�G/R����E�^���2]��F0JĐ�А�����JO���f��m��&�o�8O�͎2�@1(��đ2[a,���s!:!���}��.'�|�8È�F��j��b�kP��qsa��vFv�._b~*���l^gFy���a�f.\$p��Qe-J���!�^�1zw\r[��P�M`�16�q��REdZؑ�f��>�г��]Q������������Q�f��&|j��u'jL\"�0��d\0���X+���N��A���az#pga\n.Jp.P#k\$��ް���81P(��|��k\r �\rd ?�fd6Ǩ\r��ǮRC~�r\r��O�v��\n���pAh\\���Cl6v(�&.4��2#b:����	��\r2�[a.�����:# #��\$j�j9�,	�޶�yf7`1Eb`�x\"��a���_s,p�r.�2���!pM����\"z,5Z��B�PU�b�[N�P2��5�83ʄW �Nl��w�\nsM�r�P�a���vƌi\\�Ou9�2���#�d��mӼ��E�.߄B@�P`���2�\0 fv,����.]�T^S2\"�4��v�U5�'�^�lE@�\$�S%f�P%®��MdXE��	\0t	��@�\n`";
        break;
    }$Og = [];
    foreach (explode("\n", lzw_decompress($f))as$X) {
        $Og[] = (strpos($X, "\t") ? explode("\t", $X) : $X);
    }

return$Og;
}if (! $Og) {
    $Og = get_translations($a);
    $_SESSION['translations'] = $Og;
}if (extension_loaded('pdo')) {
    class Min_PDO extends PDO
    {
        public $_result;

        public $server_infovar;

        public $affected_rowsvar;

        public $errnovar;

        public $errorvar;

        public function __construct()
        {
            global$c;
            $Ue = array_search('SQL', $c->operators);
            if ($Ue !== false) {
                unset($c->operators[$Ue]);
            }
        }

        public function dsn($Mb, $V, $Oe, $se = [])
        {
            try {
                parent::__construct($Mb, $V, $Oe, $se);
            } catch(Exception$ec) {
                auth_error(h($ec->getMessage()));
            }$this->setAttribute(13, ['Min_PDOStatement']);
            $this->server_info = @$this->getAttribute(4);
        }

        public function query($I, $Vg = false)
        {
            $J = parent::query($I);
            $this->error = '';
            if (! $J) {
                [, $this->errno, $this->error] = $this->errorInfo();
                if (! $this->error) {
                    $this->error = lang(21);
                }

return
                false;
            }$this->store_result($J);

            return$J;
        }

        public function multi_query($I)
        {
            return$this->_result = $this->query($I);
        }

        public function store_result($J = null)
        {
            if (! $J) {
                $J = $this->_result;
                if (! $J) {
                    return
                    false;
                }
            }if ($J->columnCount()) {
                $J->num_rows = $J->rowCount();

                return$J;
            }$this->affected_rows = $J->rowCount();

            return
            true;
        }

        public function next_result()
        {
            if (! $this->_result) {
                return
                false;
            }$this->_result->_offset = 0;

            return@$this->_result->nextRowset();
        }

        public function result($I, $n = 0)
        {
            $J = $this->query($I);
            if (! $J) {
                return
                false;
            }$L = $J->fetch();

            return$L[$n];
        }
    }class Min_PDOStatement extends PDOStatement
    {
        public $_offset = 0;

        public $num_rowsvar;

        public function fetch_assoc()
        {
            return$this->fetch(2);
        }

        public function fetch_row()
        {
            return$this->fetch(3);
        }

        public function fetch_field()
        {
            $L = (object) $this->getColumnMeta($this->_offset++);
            $L->orgtable = $L->table;
            $L->orgname = $L->name;
            $L->charsetnr = (in_array('blob', (array) $L->flags) ? 63 : 0);

            return$L;
        }
    }
}$Ib = [];
class Min_SQL
{
    public $_conn;

    public function __construct($g)
    {
        $this->_conn = $g;
    }

    public function select($Q, $N, $Z, $t, $ue = [], $A = 1, $G = 0, $bf = false)
    {
        global$c,$z;
        $gd = (count($t) < count($N));
        $I = $c->selectQueryBuild($N, $Z, $t, $ue, $A, $G);
        if (! $I) {
            $I = 'SELECT'.limit(($_GET['page'] != 'last' && $A != '' && $t && $gd && $z == 'sql' ? 'SQL_CALC_FOUND_ROWS ' : '').implode(', ', $N)."\nFROM ".table($Q), ($Z ? "\nWHERE ".implode(' AND ', $Z) : '').($t && $gd ? "\nGROUP BY ".implode(', ', $t) : '').($ue ? "\nORDER BY ".implode(', ', $ue) : ''), ($A != '' ? +$A : null), ($G ? $A * $G : 0), "\n");
        }$bg = microtime(true);
        $K = $this->_conn->query($I);
        if ($bf) {
            echo$c->selectQuery($I, $bg, ! $K);
        }

return$K;
    }

    public function delete($Q, $jf, $A = 0)
    {
        $I = 'FROM '.table($Q);

        return
        queries('DELETE'.($A ? limit1($Q, $I, $jf) : " $I$jf"));
    }

    public function update($Q, $P, $jf, $A = 0, $Mf = "\n")
    {
        $kh = [];
        foreach ($P
        as$_ => $X) {
            $kh[] = "$_ = $X";
        }$I = table($Q)." SET$Mf".implode(",$Mf", $kh);

        return
        queries('UPDATE'.($A ? limit1($Q, $I, $jf, $Mf) : " $I$jf"));
    }

    public function insert($Q, $P)
    {
        return
        queries('INSERT INTO '.table($Q).($P ? ' ('.implode(', ', array_keys($P)).")\nVALUES (".implode(', ', $P).')' : ' DEFAULT VALUES'));
    }

    public function insertUpdate($Q, $M, $af)
    {
        return
        false;
    }

    public function begin()
    {
        return
        queries('BEGIN');
    }

    public function commit()
    {
        return
        queries('COMMIT');
    }

    public function rollback()
    {
        return
        queries('ROLLBACK');
    }

    public function slowQuery($I, $Bg)
    {
    }

    public function convertSearch($w, $X, $n)
    {
        return$w;
    }

    public function value($X, $n)
    {
        return method_exists($this->_conn, 'value') ? $this->_conn->value($X, $n) : (is_resource($X) ? stream_get_contents($X) : $X);
    }

    public function quoteBinary($Df)
    {
        return
        q($Df);
    }

    public function warnings()
    {
        return'';
    }

    public function tableHelp($F)
    {
    }
}$Ib = ['server' => 'MySQL'] + $Ib;
if (! defined('DRIVER')) {
    $Xe = ['MySQLi', 'MySQL', 'PDO_MySQL'];
    define('DRIVER', 'server');
    if (extension_loaded('mysqli')) {
        class Min_DB extends MySQLi
        {
            public $extension = 'MySQLi';

            public function __construct()
            {
                parent::init();
            }

            public function connect($O = '', $V = '', $Oe = '', $tb = null, $Te = null, $Uf = null)
            {
                global$c;
                mysqli_report(MYSQLI_REPORT_OFF);
                [$Rc, $Te] = explode(':', $O, 2);
                $ag = $c->connectSsl();
                if ($ag) {
                    $this->ssl_set($ag['key'], $ag['cert'], $ag['ca'], '', '');
                }$K = @$this->real_connect(($O != '' ? $Rc : ini_get('mysqli.default_host')), ($O.$V != '' ? $V : ini_get('mysqli.default_user')), ($O.$V.$Oe != '' ? $Oe : ini_get('mysqli.default_pw')), $tb, (is_numeric($Te) ? $Te : ini_get('mysqli.default_port')), (! is_numeric($Te) ? $Te : $Uf), ($ag ? 64 : 0));
                $this->options(MYSQLI_OPT_LOCAL_INFILE, false);

                return$K;
            }

            public function set_charset($La)
            {
                if (parent::set_charset($La)) {
                    return
                    true;
                }parent::set_charset('utf8');

                return$this->query("SET NAMES $La");
            }

            public function result($I, $n = 0)
            {
                $J = $this->query($I);
                if (! $J) {
                    return
                    false;
                }$L = $J->fetch_array();

                return$L[$n];
            }

            public function quote($fg)
            {
                return"'".$this->escape_string($fg)."'";
            }
        }
    } elseif (extension_loaded('mysql') && ! ((ini_bool('sql.safe_mode') || ini_bool('mysql.allow_local_infile')) && extension_loaded('pdo_mysql'))) {
        class Min_DB
        {
            public $extension = 'MySQL';

            public $server_infovar;

            public $affected_rowsvar;

            public $errnovar;

            public $errorvar;

            public $_linkvar;

            public $_resultvar;

            public function connect($O, $V, $Oe)
            {
                if (ini_bool('mysql.allow_local_infile')) {
                    $this->error = lang(22, "'mysql.allow_local_infile'", 'MySQLi', 'PDO_MySQL');

                    return
                    false;
                }$this->_link = @mysql_connect(($O != '' ? $O : ini_get('mysql.default_host')), ("$O$V" != '' ? $V : ini_get('mysql.default_user')), ("$O$V$Oe" != '' ? $Oe : ini_get('mysql.default_password')), true, 131072);
                if ($this->_link) {
                    $this->server_info = mysql_get_server_info($this->_link);
                } else {
                    $this->error = mysql_error();
                }

return(bool) $this->_link;
            }

            public function set_charset($La)
            {
                if (function_exists('mysql_set_charset')) {
                    if (mysql_set_charset($La, $this->_link)) {
                        return
                        true;
                    }mysql_set_charset('utf8', $this->_link);
                }

return$this->query("SET NAMES $La");
            }

            public function quote($fg)
            {
                return"'".mysql_real_escape_string($fg, $this->_link)."'";
            }

            public function select_db($tb)
            {
                return
                mysql_select_db($tb, $this->_link);
            }

            public function query($I, $Vg = false)
            {
                $J = @($Vg ? mysql_unbuffered_query($I, $this->_link) : mysql_query($I, $this->_link));
                $this->error = '';
                if (! $J) {
                    $this->errno = mysql_errno($this->_link);
                    $this->error = mysql_error($this->_link);

                    return
                    false;
                }if ($J === true) {
                    $this->affected_rows = mysql_affected_rows($this->_link);
                    $this->info = mysql_info($this->_link);

                    return
                    true;
                }

return
                new
                Min_Result($J);
            }

            public function multi_query($I)
            {
                return$this->_result = $this->query($I);
            }

            public function store_result()
            {
                return$this->_result;
            }

            public function next_result()
            {
                return
                false;
            }

            public function result($I, $n = 0)
            {
                $J = $this->query($I);
                if (! $J || ! $J->num_rows) {
                    return
                    false;
                }

return
                mysql_result($J->_result, 0, $n);
            }
        }class Min_Result
        {
            public $num_rows;

            public $_resultvar;

            public $_offsetvar = 0;

            public function __construct($J)
            {
                $this->_result = $J;
                $this->num_rows = mysql_num_rows($J);
            }

            public function fetch_assoc()
            {
                return
                mysql_fetch_assoc($this->_result);
            }

            public function fetch_row()
            {
                return
                mysql_fetch_row($this->_result);
            }

            public function fetch_field()
            {
                $K = mysql_fetch_field($this->_result, $this->_offset++);
                $K->orgtable = $K->table;
                $K->orgname = $K->name;
                $K->charsetnr = ($K->blob ? 63 : 0);

                return$K;
            }

            public function __destruct()
            {
                mysql_free_result($this->_result);
            }
        }
    } elseif (extension_loaded('pdo_mysql')) {
        class Min_DB extends Min_PDO
        {
            public $extension = 'PDO_MySQL';

            public function connect($O, $V, $Oe)
            {
                global$c;
                $se = [PDO::MYSQL_ATTR_LOCAL_INFILE => false];
                $ag = $c->connectSsl();
                if ($ag) {
                    $se += [PDO::MYSQL_ATTR_SSL_KEY => $ag['key'], PDO::MYSQL_ATTR_SSL_CERT => $ag['cert'], PDO::MYSQL_ATTR_SSL_CA => $ag['ca']];
                }$this->dsn('mysql:charset=utf8;host='.str_replace(':', ';unix_socket=', preg_replace('~:(\d)~', ';port=\1', $O)), $V, $Oe, $se);

                return
                true;
            }

            public function set_charset($La)
            {
                $this->query("SET NAMES $La");
            }

            public function select_db($tb)
            {
                return$this->query('USE '.idf_escape($tb));
            }

            public function query($I, $Vg = false)
            {
                $this->setAttribute(1000, ! $Vg);

                return
                parent::query($I, $Vg);
            }
        }
    }class Min_Driver extends Min_SQL
    {
        public function insert($Q, $P)
        {
            return $P ? parent::insert($Q, $P) : queries('INSERT INTO '.table($Q)." ()\nVALUES ()");
        }

        public function insertUpdate($Q, $M, $af)
        {
            $e = array_keys(reset($M));
            $Ye = 'INSERT INTO '.table($Q).' ('.implode(', ', $e).") VALUES\n";
            $kh = [];
            foreach ($e
            as$_) {
                $kh[$_] = "$_ = VALUES($_)";
            }$jg = "\nON DUPLICATE KEY UPDATE ".implode(', ', $kh);
            $kh = [];
            $yd = 0;
            foreach ($M
            as$P) {
                $Y = '('.implode(', ', $P).')';
                if ($kh && (strlen($Ye) + $yd + strlen($Y) + strlen($jg) > 1e6)) {
                    if (! queries($Ye.implode(",\n", $kh).$jg)) {
                        return
                        false;
                    }$kh = [];
                    $yd = 0;
                }$kh[] = $Y;
                $yd += strlen($Y) + 2;
            }

return
            queries($Ye.implode(",\n", $kh).$jg);
        }

        public function slowQuery($I, $Bg)
        {
            if (min_version('5.7.8', '10.1.2')) {
                if (preg_match('~MariaDB~', $this->_conn->server_info)) {
                    return"SET STATEMENT max_statement_time=$Bg FOR $I";
                } elseif (preg_match('~^(SELECT\b)(.+)~is', $I, $D)) {
                    return"$D[1] /*+ MAX_EXECUTION_TIME(".($Bg * 1000).") */ $D[2]";
                }
            }
        }

        public function convertSearch($w, $X, $n)
        {
            return preg_match('~char|text|enum|set~', $n['type']) && ! preg_match('~^utf8~', $n['collation']) && preg_match('~[\x80-\xFF]~', $X['val']) ? "CONVERT($w USING ".charset($this->_conn).')' : $w;
        }

        public function warnings()
        {
            $J = $this->_conn->query('SHOW WARNINGS');
            if ($J && $J->num_rows) {
                ob_start();
                select($J);

                return
                ob_get_clean();
            }
        }

        public function tableHelp($F)
        {
            $Dd = preg_match('~MariaDB~', $this->_conn->server_info);
            if (information_schema(DB)) {
                return
                strtolower(($Dd ? "information-schema-$F-table/" : str_replace('_', '-', $F).'-table.html'));
            }if (DB == 'mysql') {
                return $Dd ? "mysql$F-table/" : 'system-database.html';
            }
        }
    }function idf_escape($w)
    {
        return'`'.str_replace('`', '``', $w).'`';
    }function table($w)
    {
        return
        idf_escape($w);
    }function connect()
    {
        global$c,$Ug,$gg;
        $g = new
        Min_DB;
        $mb = $c->credentials();
        if ($g->connect($mb[0], $mb[1], $mb[2])) {
            $g->set_charset(charset($g));
            $g->query('SET sql_quote_show_create = 1, autocommit = 1');
            if (min_version('5.7.8', 10.2, $g)) {
                $gg[lang(23)][] = 'json';
                $Ug['json'] = 4294967295;
            }

return$g;
        }$K = $g->error;
        if (function_exists('iconv') && ! is_utf8($K) && strlen($Df = iconv('windows-1250', 'utf-8', $K)) > strlen($K)) {
            $K = $Df;
        }

return$K;
    }function get_databases($vc)
    {
        $K = get_session('dbs');
        if ($K === null) {
            $I = (min_version(5) ? 'SELECT SCHEMA_NAME FROM information_schema.SCHEMATA ORDER BY SCHEMA_NAME' : 'SHOW DATABASES');
            $K = ($vc ? slow_query($I) : get_vals($I));
            restart_session();
            set_session('dbs', $K);
            stop_session();
        }

return$K;
    }function limit($I, $Z, $A, $fe = 0, $Mf = ' ')
    {
        return" $I$Z".($A !== null ? $Mf."LIMIT $A".($fe ? " OFFSET $fe" : '') : '');
    }function limit1($Q, $I, $Z, $Mf = "\n")
    {
        return
        limit($I, $Z, 1, 0, $Mf);
    }function db_collation($k, $Xa)
    {
        global$g;
        $K = null;
        $i = $g->result('SHOW CREATE DATABASE '.idf_escape($k), 1);
        if (preg_match('~ COLLATE ([^ ]+)~', $i, $D)) {
            $K = $D[1];
        } elseif (preg_match('~ CHARACTER SET ([^ ]+)~', $i, $D)) {
            $K = $Xa[$D[1]][-1];
        }

return$K;
    }function engines()
    {
        $K = [];
        foreach (get_rows('SHOW ENGINES')as$L) {
            if (preg_match('~YES|DEFAULT~', $L['Support'])) {
                $K[] = $L['Engine'];
            }
        }

return$K;
    }function logged_user()
    {
        global$g;

        return$g->result('SELECT USER()');
    }function tables_list()
    {
        return
        get_key_vals(min_version(5) ? 'SELECT TABLE_NAME, TABLE_TYPE FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() ORDER BY TABLE_NAME' : 'SHOW TABLES');
    }function count_tables($j)
    {
        $K = [];
        foreach ($j
        as$k) {
            $K[$k] = count(get_vals('SHOW TABLES IN '.idf_escape($k)));
        }

return$K;
    }function table_status($F = '', $oc = false)
    {
        $K = [];
        foreach (get_rows($oc && min_version(5) ? 'SELECT TABLE_NAME AS Name, ENGINE AS Engine, TABLE_COMMENT AS Comment FROM information_schema.TABLES WHERE TABLE_SCHEMA = DATABASE() '.($F != '' ? 'AND TABLE_NAME = '.q($F) : 'ORDER BY Name') : 'SHOW TABLE STATUS'.($F != '' ? ' LIKE '.q(addcslashes($F, '%_\\')) : ''))as$L) {
            if ($L['Engine'] == 'InnoDB') {
                $L['Comment'] = preg_replace('~(?:(.+); )?InnoDB free: .*~', '\1', $L['Comment']);
            }if (! isset($L['Engine'])) {
                $L['Comment'] = '';
            }if ($F != '') {
                return$L;
            }$K[$L['Name']] = $L;
        }

return$K;
    }function is_view($R)
    {
        return$R['Engine'] === null;
    }function fk_support($R)
    {
        return
        preg_match('~InnoDB|IBMDB2I~i', $R['Engine']) || (preg_match('~NDB~i', $R['Engine']) && min_version(5.6));
    }function fields($Q)
    {
        $K = [];
        foreach (get_rows('SHOW FULL COLUMNS FROM '.table($Q))as$L) {
            preg_match('~^([^( ]+)(?:\((.+)\))?( unsigned)?( zerofill)?$~', $L['Type'], $D);
            $K[$L['Field']] = ['field' => $L['Field'], 'full_type' => $L['Type'], 'type' => $D[1], 'length' => $D[2], 'unsigned' => ltrim($D[3].$D[4]), 'default' => ($L['Default'] != '' || preg_match('~char|set~', $D[1]) ? $L['Default'] : null), 'null' => ($L['Null'] == 'YES'), 'auto_increment' => ($L['Extra'] == 'auto_increment'), 'on_update' => (preg_match('~^on update (.+)~i', $L['Extra'], $D) ? $D[1] : ''), 'collation' => $L['Collation'], 'privileges' => array_flip(preg_split('~, *~', $L['Privileges'])), 'comment' => $L['Comment'], 'primary' => ($L['Key'] == 'PRI')];
        }

return$K;
    }function indexes($Q, $h = null)
    {
        $K = [];
        foreach (get_rows('SHOW INDEX FROM '.table($Q), $h)as$L) {
            $F = $L['Key_name'];
            $K[$F]['type'] = ($F == 'PRIMARY' ? 'PRIMARY' : ($L['Index_type'] == 'FULLTEXT' ? 'FULLTEXT' : ($L['Non_unique'] ? ($L['Index_type'] == 'SPATIAL' ? 'SPATIAL' : 'INDEX') : 'UNIQUE')));
            $K[$F]['columns'][] = $L['Column_name'];
            $K[$F]['lengths'][] = ($L['Index_type'] == 'SPATIAL' ? null : $L['Sub_part']);
            $K[$F]['descs'][] = null;
        }

return$K;
    }function foreign_keys($Q)
    {
        global$g,$me;
        static$Qe = '(?:`(?:[^`]|``)+`)|(?:"(?:[^"]|"")+")';
        $K = [];
        $kb = $g->result('SHOW CREATE TABLE '.table($Q), 1);
        if ($kb) {
            preg_match_all("~CONSTRAINT ($Qe) FOREIGN KEY ?\\(((?:$Qe,? ?)+)\\) REFERENCES ($Qe)(?:\\.($Qe))? \\(((?:$Qe,? ?)+)\\)(?: ON DELETE ($me))?(?: ON UPDATE ($me))?~", $kb, $Fd, PREG_SET_ORDER);
            foreach ($Fd
            as$D) {
                preg_match_all("~$Qe~", $D[2], $Vf);
                preg_match_all("~$Qe~", $D[5], $vg);
                $K[idf_unescape($D[1])] = ['db' => idf_unescape($D[4] != '' ? $D[3] : $D[4]), 'table' => idf_unescape($D[4] != '' ? $D[4] : $D[3]), 'source' => array_map('idf_unescape', $Vf[0]), 'target' => array_map('idf_unescape', $vg[0]), 'on_delete' => ($D[6] ? $D[6] : 'RESTRICT'), 'on_update' => ($D[7] ? $D[7] : 'RESTRICT')];
            }
        }

return$K;
    }function view($F)
    {
        global$g;

        return
        ['select' => preg_replace('~^(?:[^`]|`[^`]*`)*\s+AS\s+~isU', '', $g->result('SHOW CREATE VIEW '.table($F), 1))];
    }function collations()
    {
        $K = [];
        foreach (get_rows('SHOW COLLATION')as$L) {
            if ($L['Default']) {
                $K[$L['Charset']][-1] = $L['Collation'];
            } else {
                $K[$L['Charset']][] = $L['Collation'];
            }
        }ksort($K);
        foreach ($K
        as$_ => $X) {
            asort($K[$_]);
        }

return$K;
    }function information_schema($k)
    {
        return(min_version(5) && $k == 'information_schema') || (min_version(5.5) && $k == 'performance_schema');
    }function error()
    {
        global$g;

        return
        h(preg_replace('~^You have an error.*syntax to use~U', 'Syntax error', $g->error));
    }function create_database($k, $Wa)
    {
        return
        queries('CREATE DATABASE '.idf_escape($k).($Wa ? ' COLLATE '.q($Wa) : ''));
    }function drop_databases($j)
    {
        $K = apply_queries('DROP DATABASE', $j, 'idf_escape');
        restart_session();
        set_session('dbs', null);

        return$K;
    }function rename_database($F, $Wa)
    {
        $K = false;
        if (create_database($F, $Wa)) {
            $uf = [];
            foreach (tables_list()as$Q => $U) {
                $uf[] = table($Q).' TO '.idf_escape($F).'.'.table($Q);
            }$K = (! $uf || queries('RENAME TABLE '.implode(', ', $uf)));
            if ($K) {
                queries('DROP DATABASE '.idf_escape(DB));
            }restart_session();
            set_session('dbs', null);
        }

return$K;
    }function auto_increment()
    {
        $za = ' PRIMARY KEY';
        if ($_GET['create'] != '' && $_POST['auto_increment_col']) {
            foreach (indexes($_GET['create'])as$x) {
                if (in_array($_POST['fields'][$_POST['auto_increment_col']]['orig'], $x['columns'], true)) {
                    $za = '';
                    break;
                }if ($x['type'] == 'PRIMARY') {
                    $za = ' UNIQUE';
                }
            }
        }

return" AUTO_INCREMENT$za";
    }function alter_table($Q, $F, $o, $xc, $bb, $Xb, $Wa, $ya, $Le)
    {
        $sa = [];
        foreach ($o
        as$n) {
            $sa[] = ($n[1] ? ($Q != '' ? ($n[0] != '' ? 'CHANGE '.idf_escape($n[0]) : 'ADD') : ' ').' '.implode($n[1]).($Q != '' ? $n[2] : '') : 'DROP '.idf_escape($n[0]));
        }$sa = array_merge($sa, $xc);
        $cg = ($bb !== null ? ' COMMENT='.q($bb) : '').($Xb ? ' ENGINE='.q($Xb) : '').($Wa ? ' COLLATE '.q($Wa) : '').($ya != '' ? " AUTO_INCREMENT=$ya" : '');
        if ($Q == '') {
            return
            queries('CREATE TABLE '.table($F)." (\n".implode(",\n", $sa)."\n)$cg$Le");
        }if ($Q != $F) {
            $sa[] = 'RENAME TO '.table($F);
        }if ($cg) {
            $sa[] = ltrim($cg);
        }

return $sa || $Le ? queries('ALTER TABLE '.table($Q)."\n".implode(",\n", $sa).$Le) : true;
    }function alter_indexes($Q, $sa)
    {
        foreach ($sa
        as$_ => $X) {
            $sa[$_] = ($X[2] == 'DROP' ? "\nDROP INDEX ".idf_escape($X[1]) : "\nADD $X[0] ".($X[0] == 'PRIMARY' ? 'KEY ' : '').($X[1] != '' ? idf_escape($X[1]).' ' : '').'('.implode(', ', $X[2]).')');
        }

return
        queries('ALTER TABLE '.table($Q).implode(',', $sa));
    }function truncate_tables($S)
    {
        return
        apply_queries('TRUNCATE TABLE', $S);
    }function drop_views($ph)
    {
        return
        queries('DROP VIEW '.implode(', ', array_map('table', $ph)));
    }function drop_tables($S)
    {
        return
        queries('DROP TABLE '.implode(', ', array_map('table', $S)));
    }function move_tables($S, $ph, $vg)
    {
        $uf = [];
        foreach (array_merge($S, $ph)as$Q) {
            $uf[] = table($Q).' TO '.idf_escape($vg).'.'.table($Q);
        }

return
        queries('RENAME TABLE '.implode(', ', $uf));
    }function copy_tables($S, $ph, $vg)
    {
        queries("SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO'");
        foreach ($S
        as$Q) {
            $F = ($vg == DB ? table("copy_$Q") : idf_escape($vg).'.'.table($Q));
            if (! queries("CREATE TABLE $F LIKE ".table($Q)) || ! queries("INSERT INTO $F SELECT * FROM ".table($Q))) {
                return
                false;
            }foreach (get_rows('SHOW TRIGGERS LIKE '.q(addcslashes($Q, '%_\\')))as$L) {
                $Pg = $L['Trigger'];
                if (! queries('CREATE TRIGGER '.($vg == DB ? idf_escape("copy_$Pg") : idf_escape($vg).'.'.idf_escape($Pg))." $L[Timing] $L[Event] ON $F FOR EACH ROW\n$L[Statement];")) {
                    return
                    false;
                }
            }
        }foreach ($ph
        as$Q) {
            $F = ($vg == DB ? table("copy_$Q") : idf_escape($vg).'.'.table($Q));
            $oh = view($Q);
            if (! queries("CREATE VIEW $F AS $oh[select]")) {
                return
                false;
            }
        }

return
        true;
    }function trigger($F)
    {
        if ($F == '') {
            return
            [];
        }$M = get_rows('SHOW TRIGGERS WHERE `Trigger` = '.q($F));

        return
        reset($M);
    }function triggers($Q)
    {
        $K = [];
        foreach (get_rows('SHOW TRIGGERS LIKE '.q(addcslashes($Q, '%_\\')))as$L) {
            $K[$L['Trigger']] = [$L['Timing'], $L['Event']];
        }

return$K;
    }function trigger_options()
    {
        return
        ['Timing' => ['BEFORE', 'AFTER'], 'Event' => ['INSERT', 'UPDATE', 'DELETE'], 'Type' => ['FOR EACH ROW']];
    }function routine($F, $U)
    {
        global$g,$Zb,$Zc,$Ug;
        $qa = ['bool', 'boolean', 'integer', 'double precision', 'real', 'dec', 'numeric', 'fixed', 'national char', 'national varchar'];
        $Wf = "(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";
        $Tg = '(('.implode('|', array_merge(array_keys($Ug), $qa)).")\\b(?:\\s*\\(((?:[^'\")]|$Zb)++)\\))?\\s*(zerofill\\s*)?(unsigned(?:\\s+zerofill)?)?)(?:\\s*(?:CHARSET|CHARACTER\\s+SET)\\s*['\"]?([^'\"\\s,]+)['\"]?)?";
        $Qe = "$Wf*(".($U == 'FUNCTION' ? '' : $Zc).")?\\s*(?:`((?:[^`]|``)*)`\\s*|\\b(\\S+)\\s+)$Tg";
        $i = $g->result("SHOW CREATE $U ".idf_escape($F), 2);
        preg_match("~\\(((?:$Qe\\s*,?)*)\\)\\s*".($U == 'FUNCTION' ? "RETURNS\\s+$Tg\\s+" : '').'(.*)~is', $i, $D);
        $o = [];
        preg_match_all("~$Qe\\s*,?~is", $D[1], $Fd, PREG_SET_ORDER);
        foreach ($Fd
        as$Ge) {
            $F = str_replace('``', '`', $Ge[2]).$Ge[3];
            $o[] = ['field' => $F, 'type' => strtolower($Ge[5]), 'length' => preg_replace_callback("~$Zb~s", 'normalize_enum', $Ge[6]), 'unsigned' => strtolower(preg_replace('~\s+~', ' ', trim("$Ge[8] $Ge[7]"))), 'null' => 1, 'full_type' => $Ge[4], 'inout' => strtoupper($Ge[1]), 'collation' => strtolower($Ge[9])];
        }if ($U != 'FUNCTION') {
            return
            ['fields' => $o, 'definition' => $D[11]];
        }

return
        ['fields' => $o, 'returns' => ['type' => $D[12], 'length' => $D[13], 'unsigned' => $D[15], 'collation' => $D[16]], 'definition' => $D[17], 'language' => 'SQL'];
    }function routines()
    {
        return
        get_rows('SELECT ROUTINE_NAME AS SPECIFIC_NAME, ROUTINE_NAME, ROUTINE_TYPE, DTD_IDENTIFIER FROM information_schema.ROUTINES WHERE ROUTINE_SCHEMA = '.q(DB));
    }function routine_languages()
    {
        return
        [];
    }function routine_id($F, $L)
    {
        return
        idf_escape($F);
    }function last_id()
    {
        global$g;

        return$g->result('SELECT LAST_INSERT_ID()');
    }function explain($g, $I)
    {
        return$g->query('EXPLAIN '.(min_version(5.1) ? 'PARTITIONS ' : '').$I);
    }function found_rows($R, $Z)
    {
        return $Z || $R['Engine'] != 'InnoDB' ? null : $R['Rows'];
    }function types()
    {
        return
        [];
    }function schemas()
    {
        return
        [];
    }function get_schema()
    {
        return'';
    }function set_schema($Ff)
    {
        return
        true;
    }function create_sql($Q, $ya, $hg)
    {
        global$g;
        $K = $g->result('SHOW CREATE TABLE '.table($Q), 1);
        if (! $ya) {
            $K = preg_replace('~ AUTO_INCREMENT=\d+~', '', $K);
        }

return$K;
    }function truncate_sql($Q)
    {
        return'TRUNCATE '.table($Q);
    }function use_sql($tb)
    {
        return'USE '.idf_escape($tb);
    }function trigger_sql($Q)
    {
        $K = '';
        foreach (get_rows('SHOW TRIGGERS LIKE '.q(addcslashes($Q, '%_\\')), null, '-- ')as$L) {
            $K .= "\nCREATE TRIGGER ".idf_escape($L['Trigger'])." $L[Timing] $L[Event] ON ".table($L['Table'])." FOR EACH ROW\n$L[Statement];;\n";
        }

return$K;
    }function show_variables()
    {
        return
        get_key_vals('SHOW VARIABLES');
    }function process_list()
    {
        return
        get_rows('SHOW FULL PROCESSLIST');
    }function show_status()
    {
        return
        get_key_vals('SHOW STATUS');
    }function convert_field($n)
    {
        if (preg_match('~binary~', $n['type'])) {
            return'HEX('.idf_escape($n['field']).')';
        }if ($n['type'] == 'bit') {
            return'BIN('.idf_escape($n['field']).' + 0)';
        }if (preg_match('~geometry|point|linestring|polygon~', $n['type'])) {
            return(min_version(8) ? 'ST_' : '').'AsWKT('.idf_escape($n['field']).')';
        }
    }function unconvert_field($n, $K)
    {
        if (preg_match('~binary~', $n['type'])) {
            $K = "UNHEX($K)";
        }if ($n['type'] == 'bit') {
            $K = "CONV($K, 2, 10) + 0";
        }if (preg_match('~geometry|point|linestring|polygon~', $n['type'])) {
            $K = (min_version(8) ? 'ST_' : '')."GeomFromText($K)";
        }

return$K;
    }function support($pc)
    {
        return! preg_match('~scheme|sequence|type|view_trigger|materializedview'.(min_version(8) ? '' : '|descidx'.(min_version(5.1) ? '' : '|event|partitioning'.(min_version(5) ? '' : '|routine|trigger|view'))).'~', $pc);
    }function kill_process($X)
    {
        return
        queries('KILL '.number($X));
    }function connection_id()
    {
        return'SELECT CONNECTION_ID()';
    }function max_connections()
    {
        global$g;

        return$g->result('SELECT @@max_connections');
    }$z = 'sql';
    $Ug = [];
    $gg = [];
    foreach ([lang(24) => ['tinyint' => 3, 'smallint' => 5, 'mediumint' => 8, 'int' => 10, 'bigint' => 20, 'decimal' => 66, 'float' => 12, 'double' => 21], lang(25) => ['date' => 10, 'datetime' => 19, 'timestamp' => 19, 'time' => 10, 'year' => 4], lang(23) => ['char' => 255, 'varchar' => 65535, 'tinytext' => 255, 'text' => 65535, 'mediumtext' => 16777215, 'longtext' => 4294967295], lang(26) => ['enum' => 65535, 'set' => 64], lang(27) => ['bit' => 20, 'binary' => 255, 'varbinary' => 65535, 'tinyblob' => 255, 'blob' => 65535, 'mediumblob' => 16777215, 'longblob' => 4294967295], lang(28) => ['geometry' => 0, 'point' => 0, 'linestring' => 0, 'polygon' => 0, 'multipoint' => 0, 'multilinestring' => 0, 'multipolygon' => 0, 'geometrycollection' => 0]]as$_ => $X) {
        $Ug += $X;
        $gg[$_] = array_keys($X);
    }$bh = ['unsigned', 'zerofill', 'unsigned zerofill'];
    $qe = ['=', '<', '>', '<=', '>=', '!=', 'LIKE', 'LIKE %%', 'REGEXP', 'IN', 'FIND_IN_SET', 'IS NULL', 'NOT LIKE', 'NOT REGEXP', 'NOT IN', 'IS NOT NULL', 'SQL'];
    $Cc = ['char_length', 'date', 'from_unixtime', 'lower', 'round', 'floor', 'ceil', 'sec_to_time', 'time_to_sec', 'upper'];
    $Hc = ['avg', 'count', 'count distinct', 'group_concat', 'max', 'min', 'sum'];
    $Pb = [['char' => 'md5/sha1/password/encrypt/uuid', 'binary' => 'md5/sha1', 'date|time' => 'now'], [number_type() => '+/-', 'date' => '+ interval/- interval', 'time' => 'addtime/subtime', 'char|text' => 'concat']];
}define('SERVER', $_GET[DRIVER]);
define('DB', $_GET['db']);
define('ME', preg_replace('~^[^?]*/([^?]*).*~', '\1', $_SERVER['REQUEST_URI']).'?'.(sid() ? SID.'&' : '').(SERVER !== null ? DRIVER.'='.urlencode(SERVER).'&' : '').(isset($_GET['username']) ? 'username='.urlencode($_GET['username']).'&' : '').(DB != '' ? 'db='.urlencode(DB).'&'.(isset($_GET['ns']) ? 'ns='.urlencode($_GET['ns']).'&' : '') : ''));
$fa = '4.7.0';
class Adminer
{
    public $operators;

    public function name()
    {
        return"<a href='https://www.adminer.org/'".target_blank()." id='h1'>Adminer</a>";
    }

    public function credentials()
    {
        return
        [SERVER, $_GET['username'], get_password()];
    }

    public function connectSsl()
    {
    }

    public function permanentLogin($i = false)
    {
        return
        password_file($i);
    }

    public function bruteForceKey()
    {
        return$_SERVER['REMOTE_ADDR'];
    }

    public function serverName($O)
    {
        return
        h($O);
    }

    public function database()
    {
        return
        DB;
    }

    public function databases($vc = true)
    {
        return
        get_databases($vc);
    }

    public function schemas()
    {
        return
        schemas();
    }

    public function queryTimeout()
    {
        return
        2;
    }

    public function headers()
    {
    }

    public function csp()
    {
        return
        csp();
    }

    public function head()
    {
        return
        true;
    }

    public function css()
    {
        $K = [];
        $sc = 'adminer.css';
        if (file_exists($sc)) {
            $K[] = $sc;
        }

return$K;
    }

    public function loginForm()
    {
        global$Ib;
        echo"<table cellspacing='0' class='layout'>\n",$this->loginFormField('driver', '<tr><th>'.lang(29).'<td>', html_select('auth[driver]', $Ib, DRIVER)."\n"),$this->loginFormField('server', '<tr><th>'.lang(30).'<td>', '<input name="auth[server]" value="'.h(SERVER).'" title="hostname[:port]" placeholder="localhost" autocapitalize="off">'."\n"),$this->loginFormField('username', '<tr><th>'.lang(31).'<td>', '<input name="auth[username]" id="username" value="'.h($_GET['username']).'" autocapitalize="off">'.script("focus(qs('#username'));")),$this->loginFormField('password', '<tr><th>'.lang(32).'<td>', '<input type="password" name="auth[password]">'."\n"),$this->loginFormField('db', '<tr><th>'.lang(33).'<td>', '<input name="auth[db]" value="'.h($_GET['db']).'" autocapitalize="off">'."\n"),"</table>\n","<p><input type='submit' value='".lang(34)."'>\n",checkbox('auth[permanent]', 1, $_COOKIE['adminer_permanent'], lang(35))."\n";
    }

    public function loginFormField($F, $Oc, $Y)
    {
        return$Oc.$Y;
    }

    public function login($Bd, $Oe)
    {
        if ($Oe == '') {
            return
            lang(36, target_blank());
        }

return
        true;
    }

    public function tableName($ng)
    {
        return
        h($ng['Name']);
    }

    public function fieldName($n, $ue = 0)
    {
        return'<span title="'.h($n['full_type']).'">'.h($n['field']).'</span>';
    }

    public function selectLinks($ng, $P = '')
    {
        global$z,$l;
        echo'<p class="links">';
        $Ad = ['select' => lang(37)];
        if (support('table') || support('indexes')) {
            $Ad['table'] = lang(38);
        }if (support('table')) {
            if (is_view($ng)) {
                $Ad['view'] = lang(39);
            } else {
                $Ad['create'] = lang(40);
            }
        }if ($P !== null) {
            $Ad['edit'] = lang(41);
        }$F = $ng['Name'];
        foreach ($Ad
        as$_ => $X) {
            echo" <a href='".h(ME)."$_=".urlencode($F).($_ == 'edit' ? $P : '')."'".bold(isset($_GET[$_])).">$X</a>";
        }echo
        doc_link([$z => $l->tableHelp($F)], '?'),"\n";
    }

    public function foreignKeys($Q)
    {
        return
        foreign_keys($Q);
    }

    public function backwardKeys($Q, $mg)
    {
        return
        [];
    }

    public function backwardKeysPrint($Aa, $L)
    {
    }

    public function selectQuery($I, $bg, $nc = false)
    {
        global$z,$l;
        $K = "</p>\n";
        if (! $nc && ($sh = $l->warnings())) {
            $v = 'warnings';
            $K = ", <a href='#$v'>".lang(42).'</a>'.script("qsl('a').onclick = partial(toggle, '$v');", '')."$K<div id='$v' class='hidden'>\n$sh</div>\n";
        }

return"<p><code class='jush-$z'>".h(str_replace("\n", ' ', $I))."</code> <span class='time'>(".format_time($bg).')</span>'.(support('sql') ? " <a href='".h(ME).'sql='.urlencode($I)."'>".lang(10).'</a>' : '').$K;
    }

    public function sqlCommandQuery($I)
    {
        return
        shorten_utf8(trim($I), 1000);
    }

    public function rowDescription($Q)
    {
        return'';
    }

    public function rowDescriptions($M, $yc)
    {
        return$M;
    }

    public function selectLink($X, $n)
    {
    }

    public function selectVal($X, $B, $n, $Be)
    {
        $K = ($X === null ? '<i>NULL</i>' : (preg_match('~char|binary|boolean~', $n['type']) && ! preg_match('~var~', $n['type']) ? "<code>$X</code>" : $X));
        if (preg_match('~blob|bytea|raw|file~', $n['type']) && ! is_utf8($X)) {
            $K = '<i>'.lang(43, strlen($Be)).'</i>';
        }if (preg_match('~json~', $n['type'])) {
            $K = "<code class='jush-js'>$K</code>";
        }

return $B ? "<a href='".h($B)."'".(is_url($B) ? target_blank() : '').">$K</a>" : $K;
    }

    public function editVal($X, $n)
    {
        return$X;
    }

    public function tableStructurePrint($o)
    {
        echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap'>\n",'<thead><tr><th>'.lang(44).'<td>'.lang(45).(support('comment') ? '<td>'.lang(46) : '')."</thead>\n";
        foreach ($o
        as$n) {
            echo'<tr'.odd().'><th>'.h($n['field']),"<td><span title='".h($n['collation'])."'>".h($n['full_type']).'</span>',($n['null'] ? ' <i>NULL</i>' : ''),($n['auto_increment'] ? ' <i>'.lang(47).'</i>' : ''),(isset($n['default']) ? " <span title='".lang(48)."'>[<b>".h($n['default']).'</b>]</span>' : ''),(support('comment') ? '<td>'.h($n['comment']) : ''),"\n";
        }echo"</table>\n","</div>\n";
    }

    public function tableIndexesPrint($y)
    {
        echo"<table cellspacing='0'>\n";
        foreach ($y
        as$F => $x) {
            ksort($x['columns']);
            $bf = [];
            foreach ($x['columns']as$_ => $X) {
                $bf[] = '<i>'.h($X).'</i>'.($x['lengths'][$_] ? '('.$x['lengths'][$_].')' : '').($x['descs'][$_] ? ' DESC' : '');
            }echo"<tr title='".h($F)."'><th>$x[type]<td>".implode(', ', $bf)."\n";
        }echo"</table>\n";
    }

    public function selectColumnsPrint($N, $e)
    {
        global$Cc,$Hc;
        print_fieldset('select', lang(49), $N);
        $u = 0;
        $N[''] = [];
        foreach ($N
        as$_ => $X) {
            $X = $_GET['columns'][$_];
            $d = select_input(" name='columns[$u][col]'", $e, $X['col'], ($_ !== '' ? 'selectFieldChange' : 'selectAddRow'));
            echo'<div>'.($Cc || $Hc ? "<select name='columns[$u][fun]'>".optionlist([-1 => ''] + array_filter([lang(50) => $Cc, lang(51) => $Hc]), $X['fun']).'</select>'.on_help("getTarget(event).value && getTarget(event).value.replace(/ |\$/, '(') + ')'", 1).script("qsl('select').onchange = function () { helpClose();".($_ !== '' ? '' : " qsl('select, input', this.parentNode).onchange();").' };', '')."($d)" : $d)."</div>\n";
            $u++;
        }echo"</div></fieldset>\n";
    }

    public function selectSearchPrint($Z, $e, $y)
    {
        print_fieldset('search', lang(52), $Z);
        foreach ($y
        as$u => $x) {
            if ($x['type'] == 'FULLTEXT') {
                echo'<div>(<i>'.implode('</i>, <i>', array_map('h', $x['columns'])).'</i>) AGAINST'," <input type='search' name='fulltext[$u]' value='".h($_GET['fulltext'][$u])."'>",script("qsl('input').oninput = selectFieldChange;", ''),checkbox("boolean[$u]", 1, isset($_GET['boolean'][$u]), 'BOOL'),"</div>\n";
            }
        }$Ka = 'this.parentNode.firstChild.onchange();';
        foreach (array_merge((array) $_GET['where'], [[]])as$u => $X) {
            if (! $X || ("$X[col]$X[val]" != '' && in_array($X['op'], $this->operators))) {
                echo'<div>'.select_input(" name='where[$u][col]'", $e, $X['col'], ($X ? 'selectFieldChange' : 'selectAddRow'), '('.lang(53).')'),html_select("where[$u][op]", $this->operators, $X['op'], $Ka),"<input type='search' name='where[$u][val]' value='".h($X['val'])."'>",script("mixin(qsl('input'), {oninput: function () { $Ka }, onkeydown: selectSearchKeydown, onsearch: selectSearchSearch});", ''),"</div>\n";
            }
        }echo"</div></fieldset>\n";
    }

    public function selectOrderPrint($ue, $e, $y)
    {
        print_fieldset('sort', lang(54), $ue);
        $u = 0;
        foreach ((array) $_GET['order']as$_ => $X) {
            if ($X != '') {
                echo'<div>'.select_input(" name='order[$u]'", $e, $X, 'selectFieldChange'),checkbox("desc[$u]", 1, isset($_GET['desc'][$_]), lang(55))."</div>\n";
                $u++;
            }
        }echo'<div>'.select_input(" name='order[$u]'", $e, '', 'selectAddRow'),checkbox("desc[$u]", 1, false, lang(55))."</div>\n","</div></fieldset>\n";
    }

    public function selectLimitPrint($A)
    {
        echo'<fieldset><legend>'.lang(56).'</legend><div>';
        echo"<input type='number' name='limit' class='size' value='".h($A)."'>",script("qsl('input').oninput = selectFieldChange;", ''),"</div></fieldset>\n";
    }

    public function selectLengthPrint($_g)
    {
        if ($_g !== null) {
            echo'<fieldset><legend>'.lang(57).'</legend><div>',"<input type='number' name='text_length' class='size' value='".h($_g)."'>","</div></fieldset>\n";
        }
    }

    public function selectActionPrint($y)
    {
        echo'<fieldset><legend>'.lang(58).'</legend><div>',"<input type='submit' value='".lang(49)."'>"," <span id='noindex' title='".lang(59)."'></span>",'<script'.nonce().">\n",'var indexColumns = ';
        $e = [];
        foreach ($y
        as$x) {
            $qb = reset($x['columns']);
            if ($x['type'] != 'FULLTEXT' && $qb) {
                $e[$qb] = 1;
            }
        }$e[''] = 1;
        foreach ($e
        as$_ => $X) {
            json_row($_);
        }echo";\n","selectFieldChange.call(qs('#form')['select']);\n","</script>\n","</div></fieldset>\n";
    }

    public function selectCommandPrint()
    {
        return! information_schema(DB);
    }

    public function selectImportPrint()
    {
        return! information_schema(DB);
    }

    public function selectEmailPrint($Ub, $e)
    {
    }

    public function selectColumnsProcess($e, $y)
    {
        global$Cc,$Hc;
        $N = [];
        $t = [];
        foreach ((array) $_GET['columns']as$_ => $X) {
            if ($X['fun'] == 'count' || ($X['col'] != '' && (! $X['fun'] || in_array($X['fun'], $Cc) || in_array($X['fun'], $Hc)))) {
                $N[$_] = apply_sql_function($X['fun'], ($X['col'] != '' ? idf_escape($X['col']) : '*'));
                if (! in_array($X['fun'], $Hc)) {
                    $t[] = $N[$_];
                }
            }
        }

return
        [$N, $t];
    }

    public function selectSearchProcess($o, $y)
    {
        global$g,$l;
        $K = [];
        foreach ($y
        as$u => $x) {
            if ($x['type'] == 'FULLTEXT' && $_GET['fulltext'][$u] != '') {
                $K[] = 'MATCH ('.implode(', ', array_map('idf_escape', $x['columns'])).') AGAINST ('.q($_GET['fulltext'][$u]).(isset($_GET['boolean'][$u]) ? ' IN BOOLEAN MODE' : '').')';
            }
        }foreach ((array) $_GET['where']as$_ => $X) {
            if ("$X[col]$X[val]" != '' && in_array($X['op'], $this->operators)) {
                $Ye = '';
                $db = " $X[op]";
                if (preg_match('~IN$~', $X['op'])) {
                    $Wc = process_length($X['val']);
                    $db .= ' '.($Wc != '' ? $Wc : '(NULL)');
                } elseif ($X['op'] == 'SQL') {
                    $db = " $X[val]";
                } elseif ($X['op'] == 'LIKE %%') {
                    $db = ' LIKE '.$this->processInput($o[$X['col']], "%$X[val]%");
                } elseif ($X['op'] == 'ILIKE %%') {
                    $db = ' ILIKE '.$this->processInput($o[$X['col']], "%$X[val]%");
                } elseif ($X['op'] == 'FIND_IN_SET') {
                    $Ye = "$X[op](".q($X['val']).', ';
                    $db = ')';
                } elseif (! preg_match('~NULL$~', $X['op'])) {
                    $db .= ' '.$this->processInput($o[$X['col']], $X['val']);
                }if ($X['col'] != '') {
                    $K[] = $Ye.$l->convertSearch(idf_escape($X['col']), $X, $o[$X['col']]).$db;
                } else {
                    $Ya = [];
                    foreach ($o
                    as$F => $n) {
                        if ((preg_match('~^[-\d.'.(preg_match('~IN$~', $X['op']) ? ',' : '').']+$~', $X['val']) || ! preg_match('~'.number_type().'|bit~', $n['type'])) && (! preg_match("~[\x80-\xFF]~", $X['val']) || preg_match('~char|text|enum|set~', $n['type']))) {
                            $Ya[] = $Ye.$l->convertSearch(idf_escape($F), $X, $n).$db;
                        }
                    }$K[] = ($Ya ? '('.implode(' OR ', $Ya).')' : '1 = 0');
                }
            }
        }

return$K;
    }

    public function selectOrderProcess($o, $y)
    {
        $K = [];
        foreach ((array) $_GET['order']as$_ => $X) {
            if ($X != '') {
                $K[] = (preg_match('~^((COUNT\(DISTINCT |[A-Z0-9_]+\()(`(?:[^`]|``)+`|"(?:[^"]|"")+")\)|COUNT\(\*\))$~', $X) ? $X : idf_escape($X)).(isset($_GET['desc'][$_]) ? ' DESC' : '');
            }
        }

return$K;
    }

    public function selectLimitProcess()
    {
        return isset($_GET['limit']) ? $_GET['limit'] : '50';
    }

    public function selectLengthProcess()
    {
        return isset($_GET['text_length']) ? $_GET['text_length'] : '100';
    }

    public function selectEmailProcess($Z, $yc)
    {
        return
        false;
    }

    public function selectQueryBuild($N, $Z, $t, $ue, $A, $G)
    {
        return'';
    }

    public function messageQuery($I, $Ag, $nc = false)
    {
        global$z,$l;
        restart_session();
        $Pc = &get_session('queries');
        if (! $Pc[$_GET['db']]) {
            $Pc[$_GET['db']] = [];
        }if (strlen($I) > 1e6) {
            $I = preg_replace('~[\x80-\xFF]+$~', '', substr($I, 0, 1e6))."\n...";
        }$Pc[$_GET['db']][] = [$I, time(), $Ag];
        $Zf = 'sql-'.count($Pc[$_GET['db']]);
        $K = "<a href='#$Zf' class='toggle'>".lang(60)."</a>\n";
        if (! $nc && ($sh = $l->warnings())) {
            $v = 'warnings-'.count($Pc[$_GET['db']]);
            $K = "<a href='#$v' class='toggle'>".lang(42)."</a>, $K<div id='$v' class='hidden'>\n$sh</div>\n";
        }

return" <span class='time'>".@date('H:i:s').'</span>'." $K<div id='$Zf' class='hidden'><pre><code class='jush-$z'>".shorten_utf8($I, 1000).'</code></pre>'.($Ag ? " <span class='time'>($Ag)</span>" : '').(support('sql') ? '<p><a href="'.h(str_replace('db='.urlencode(DB), 'db='.urlencode($_GET['db']), ME).'sql=&history='.(count($Pc[$_GET['db']]) - 1)).'">'.lang(10).'</a>' : '').'</div>';
    }

    public function editFunctions($n)
    {
        global$Pb;
        $K = ($n['null'] ? 'NULL/' : '');
        foreach ($Pb
        as$_ => $Cc) {
            if (! $_ || (! isset($_GET['call']) && (isset($_GET['select']) || where($_GET)))) {
                foreach ($Cc
                as$Qe => $X) {
                    if (! $Qe || preg_match("~$Qe~", $n['type'])) {
                        $K .= "/$X";
                    }
                }if ($_ && ! preg_match('~set|blob|bytea|raw|file~', $n['type'])) {
                    $K .= '/SQL';
                }
            }
        }if ($n['auto_increment'] && ! isset($_GET['select']) && ! where($_GET)) {
            $K = lang(47);
        }

return
        explode('/', $K);
    }

    public function editInput($Q, $n, $wa, $Y)
    {
        if ($n['type'] == 'enum') {
            return(isset($_GET['select']) ? "<label><input type='radio'$wa value='-1' checked><i>".lang(8).'</i></label> ' : '').($n['null'] ? "<label><input type='radio'$wa value=''".($Y !== null || isset($_GET['select']) ? '' : ' checked').'><i>NULL</i></label> ' : '').enum_input('radio', $wa, $n, $Y, 0);
        }

return'';
    }

    public function editHint($Q, $n, $Y)
    {
        return'';
    }

    public function processInput($n, $Y, $s = '')
    {
        if ($s == 'SQL') {
            return$Y;
        }$F = $n['field'];
        $K = q($Y);
        if (preg_match('~^(now|getdate|uuid)$~', $s)) {
            $K = "$s()";
        } elseif (preg_match('~^current_(date|timestamp)$~', $s)) {
            $K = $s;
        } elseif (preg_match('~^([+-]|\|\|)$~', $s)) {
            $K = idf_escape($F)." $s $K";
        } elseif (preg_match('~^[+-] interval$~', $s)) {
            $K = idf_escape($F)." $s ".(preg_match("~^(\\d+|'[0-9.: -]') [A-Z_]+\$~i", $Y) ? $Y : $K);
        } elseif (preg_match('~^(addtime|subtime|concat)$~', $s)) {
            $K = "$s(".idf_escape($F).", $K)";
        } elseif (preg_match('~^(md5|sha1|password|encrypt)$~', $s)) {
            $K = "$s($K)";
        }

return
        unconvert_field($n, $K);
    }

    public function dumpOutput()
    {
        $K = ['text' => lang(61), 'file' => lang(62)];
        if (function_exists('gzencode')) {
            $K['gz'] = 'gzip';
        }

return$K;
    }

    public function dumpFormat()
    {
        return
        ['sql' => 'SQL', 'csv' => 'CSV,', 'csv;' => 'CSV;', 'tsv' => 'TSV'];
    }

    public function dumpDatabase($k)
    {
    }

    public function dumpTable($Q, $hg, $id = 0)
    {
        if ($_POST['format'] != 'sql') {
            echo"\xef\xbb\xbf";
            if ($hg) {
                dump_csv(array_keys(fields($Q)));
            }
        } else {
            if ($id == 2) {
                $o = [];
                foreach (fields($Q)as$F => $n) {
                    $o[] = idf_escape($F)." $n[full_type]";
                }$i = 'CREATE TABLE '.table($Q).' ('.implode(', ', $o).')';
            } else {
                $i = create_sql($Q, $_POST['auto_increment'], $hg);
            }set_utf8mb4($i);
            if ($hg && $i) {
                if ($hg == 'DROP+CREATE' || $id == 1) {
                    echo'DROP '.($id == 2 ? 'VIEW' : 'TABLE').' IF EXISTS '.table($Q).";\n";
                }if ($id == 1) {
                    $i = remove_definer($i);
                }echo"$i;\n\n";
            }
        }
    }

    public function dumpData($Q, $hg, $I)
    {
        global$g,$z;
        $Hd = ($z == 'sqlite' ? 0 : 1048576);
        if ($hg) {
            if ($_POST['format'] == 'sql') {
                if ($hg == 'TRUNCATE+INSERT') {
                    echo
                    truncate_sql($Q).";\n";
                }$o = fields($Q);
            }$J = $g->query($I, 1);
            if ($J) {
                $bd = '';
                $Ia = '';
                $ld = [];
                $jg = '';
                $qc = ($Q != '' ? 'fetch_assoc' : 'fetch_row');
                while ($L = $J->$qc()) {
                    if (! $ld) {
                        $kh = [];
                        foreach ($L
                        as$X) {
                            $n = $J->fetch_field();
                            $ld[] = $n->name;
                            $_ = idf_escape($n->name);
                            $kh[] = "$_ = VALUES($_)";
                        }$jg = ($hg == 'INSERT+UPDATE' ? "\nON DUPLICATE KEY UPDATE ".implode(', ', $kh) : '').";\n";
                    }if ($_POST['format'] != 'sql') {
                        if ($hg == 'table') {
                            dump_csv($ld);
                            $hg = 'INSERT';
                        }dump_csv($L);
                    } else {
                        if (! $bd) {
                            $bd = 'INSERT INTO '.table($Q).' ('.implode(', ', array_map('idf_escape', $ld)).') VALUES';
                        }foreach ($L
                        as$_ => $X) {
                            $n = $o[$_];
                            $L[$_] = ($X !== null ? unconvert_field($n, preg_match(number_type(), $n['type']) && $X != '' && ! preg_match('~\[~', $n['full_type']) ? $X : q(($X === false ? 0 : $X))) : 'NULL');
                        }$Df = ($Hd ? "\n" : ' ').'('.implode(",\t", $L).')';
                        if (! $Ia) {
                            $Ia = $bd.$Df;
                        } elseif (strlen($Ia) + 4 + strlen($Df) + strlen($jg) < $Hd) {
                            $Ia .= ",$Df";
                        } else {
                            echo$Ia.$jg;
                            $Ia = $bd.$Df;
                        }
                    }
                }if ($Ia) {
                    echo$Ia.$jg;
                }
            } elseif ($_POST['format'] == 'sql') {
                echo'-- '.str_replace("\n", ' ', $g->error)."\n";
            }
        }
    }

    public function dumpFilename($Tc)
    {
        return
        friendly_url($Tc != '' ? $Tc : (SERVER != '' ? SERVER : 'localhost'));
    }

    public function dumpHeaders($Tc, $Td = false)
    {
        $De = $_POST['output'];
        $kc = (preg_match('~sql~', $_POST['format']) ? 'sql' : ($Td ? 'tar' : 'csv'));
        header('Content-Type: '.($De == 'gz' ? 'application/x-gzip' : ($kc == 'tar' ? 'application/x-tar' : ($kc == 'sql' || $De != 'file' ? 'text/plain' : 'text/csv').'; charset=utf-8')));
        if ($De == 'gz') {
            ob_start('ob_gzencode', 1e6);
        }

return$kc;
    }

    public function importServerPath()
    {
        return'adminer.sql';
    }

    public function homepage()
    {
        echo'<p class="links">'.($_GET['ns'] == '' && support('database') ? '<a href="'.h(ME).'database=">'.lang(63)."</a>\n" : ''),(support('scheme') ? "<a href='".h(ME)."scheme='>".($_GET['ns'] != '' ? lang(64) : lang(65))."</a>\n" : ''),($_GET['ns'] !== '' ? '<a href="'.h(ME).'schema=">'.lang(66)."</a>\n" : ''),(support('privileges') ? "<a href='".h(ME)."privileges='>".lang(67)."</a>\n" : '');

        return
        true;
    }

    public function navigation($Sd)
    {
        global$fa,$z,$Ib,$g;
        echo'<h1>
',$this->name(),' <span class="version">',$fa,'</span>
<a href="https://www.adminer.org/#download"',target_blank(),' id="version">',(version_compare($fa, $_COOKIE['adminer_version']) < 0 ? h($_COOKIE['adminer_version']) : ''),'</a>
</h1>
';
        if ($Sd == 'auth') {
            $uc = true;
            foreach ((array) $_SESSION['pwds']as$mh => $Of) {
                foreach ($Of
                as$O => $ih) {
                    foreach ($ih
                    as$V => $Oe) {
                        if ($Oe !== null) {
                            if ($uc) {
                                echo"<p id='logins'>".script("mixin(qs('#logins'), {onmouseover: menuOver, onmouseout: menuOut});");
                                $uc = false;
                            }$wb = $_SESSION['db'][$mh][$O][$V];
                            foreach (($wb ? array_keys($wb) : [''])as$k) {
                                echo"<a href='".h(auth_url($mh, $O, $V, $k))."'>($Ib[$mh]) ".h($V.($O != '' ? '@'.$this->serverName($O) : '').($k != '' ? " - $k" : ''))."</a><br>\n";
                            }
                        }
                    }
                }
            }
        } else {
            if ($_GET['ns'] !== '' && ! $Sd && DB != '') {
                $g->select_db(DB);
                $S = table_status('', true);
            }echo
            script_src(preg_replace('~\\?.*~', '', ME).'?file=jush.js&version=4.7.0');
            if (support('sql')) {
                echo'<script',nonce(),'>
';
                if ($S) {
                    $Ad = [];
                    foreach ($S
                    as$Q => $U) {
                        $Ad[] = preg_quote($Q, '/');
                    }echo"var jushLinks = { $z: [ '".js_escape(ME).(support('table') ? 'table=' : 'select=')."\$&', /\\b(".implode('|', $Ad).")\\b/g ] };\n";
                    foreach (['bac', 'bra', 'sqlite_quo', 'mssql_bra']as$X) {
                        echo"jushLinks.$X = jushLinks.$z;\n";
                    }
                }$Nf = $g->server_info;
                echo'bodyLoad(\'',(is_object($g) ? preg_replace('~^(\d\.?\d).*~s', '\1', $Nf) : ''),'\'',(preg_match('~MariaDB~', $Nf) ? ', true' : ''),');
</script>
';
            }$this->databasesPrint($Sd);
            if (DB == '' || ! $Sd) {
                echo"<p class='links'>".(support('sql') ? "<a href='".h(ME)."sql='".bold(isset($_GET['sql']) && ! isset($_GET['import'])).'>'.lang(60)."</a>\n<a href='".h(ME)."import='".bold(isset($_GET['import'])).'>'.lang(68)."</a>\n" : '').'';
                if (support('dump')) {
                    echo"<a href='".h(ME).'dump='.urlencode(isset($_GET['table']) ? $_GET['table'] : $_GET['select'])."' id='dump'".bold(isset($_GET['dump'])).'>'.lang(69)."</a>\n";
                }
            }if ($_GET['ns'] !== '' && ! $Sd && DB != '') {
                echo'<a href="'.h(ME).'create="'.bold($_GET['create'] === '').'>'.lang(70)."</a>\n";
                if (! $S) {
                    echo"<p class='message'>".lang(9)."\n";
                } else {
                    $this->tablesPrint($S);
                }
            }
        }
    }

    public function databasesPrint($Sd)
    {
        global$c,$g;
        $j = $this->databases();
        if ($j && ! in_array(DB, $j)) {
            array_unshift($j, DB);
        }echo'<form action="">
<p id="dbs">
';
        hidden_fields_get();
        $ub = script("mixin(qsl('select'), {onmousedown: dbMouseDown, onchange: dbChange});");
        echo"<span title='".lang(71)."'>".lang(72).'</span>: '.($j ? "<select name='db'>".optionlist(['' => ''] + $j, DB)."</select>$ub" : "<input name='db' value='".h(DB)."' autocapitalize='off'>\n"),"<input type='submit' value='".lang(20)."'".($j ? " class='hidden'" : '').">\n";
        if ($Sd != 'db' && DB != '' && $g->select_db(DB)) {
        }foreach (['import', 'sql', 'schema', 'dump', 'privileges']as$X) {
            if (isset($_GET[$X])) {
                echo"<input type='hidden' name='$X' value=''>";
                break;
            }
        }echo"</p></form>\n";
    }

    public function tablesPrint($S)
    {
        echo"<ul id='tables'>".script("mixin(qs('#tables'), {onmouseover: menuOver, onmouseout: menuOut});");
        foreach ($S
        as$Q => $cg) {
            $F = $this->tableName($cg);
            if ($F != '') {
                echo'<li><a href="'.h(ME).'select='.urlencode($Q).'"'.bold($_GET['select'] == $Q || $_GET['edit'] == $Q, 'select').'>'.lang(73).'</a> ',(support('table') || support('indexes') ? '<a href="'.h(ME).'table='.urlencode($Q).'"'.bold(in_array($Q, [$_GET['table'], $_GET['create'], $_GET['indexes'], $_GET['foreign'], $_GET['trigger']]), (is_view($cg) ? 'view' : 'structure'))." title='".lang(38)."'>$F</a>" : "<span>$F</span>")."\n";
            }
        }echo"</ul>\n";
    }
}$c = (function_exists('adminer_object') ? adminer_object() : new
Adminer);
if ($c->operators === null) {
    $c->operators = $qe;
}function page_header($Dg, $m = '', $Ha = [], $Eg = '')
{
    global$a,$fa,$c,$Ib,$z;
    page_headers();
    if (is_ajax() && $m) {
        page_messages($m);
        exit;
    }$Fg = $Dg.($Eg != '' ? ": $Eg" : '');
    $Gg = strip_tags($Fg.(SERVER != '' && SERVER != 'localhost' ? h(' - '.SERVER) : '').' - '.$c->name());
    echo'<!DOCTYPE html>
<html lang="',$a,'" dir="',lang(74),'">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="robots" content="noindex">
<title>',$Gg,'</title>
<link rel="stylesheet" type="text/css" href="',h(preg_replace('~\\?.*~', '', ME).'?file=default.css&version=4.7.0'),'">
',script_src(preg_replace('~\\?.*~', '', ME).'?file=functions.js&version=4.7.0');
    if ($c->head()) {
        echo'<link rel="shortcut icon" type="image/x-icon" href="',h(preg_replace('~\\?.*~', '', ME).'?file=favicon.ico&version=4.7.0'),'">
<link rel="apple-touch-icon" href="',h(preg_replace('~\\?.*~', '', ME).'?file=favicon.ico&version=4.7.0'),'">
';
        foreach ($c->css()as$ob) {
            echo'<link rel="stylesheet" type="text/css" href="',h($ob),'">
';
        }
    }echo'
<body class="',lang(74),' nojs">
';
    $sc = get_temp_dir().'/adminer.version';
    if (! $_COOKIE['adminer_version'] && function_exists('openssl_verify') && file_exists($sc) && filemtime($sc) + 86400 > time()) {
        $nh = unserialize(file_get_contents($sc));
        $hf = '-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAwqWOVuF5uw7/+Z70djoK
RlHIZFZPO0uYRezq90+7Amk+FDNd7KkL5eDve+vHRJBLAszF/7XKXe11xwliIsFs
DFWQlsABVZB3oisKCBEuI71J4kPH8dKGEWR9jDHFw3cWmoH3PmqImX6FISWbG3B8
h7FIx3jEaw5ckVPVTeo5JRm/1DZzJxjyDenXvBQ/6o9DgZKeNDgxwKzH+sw9/YCO
jHnq1cFpOIISzARlrHMa/43YfeNRAm/tsBXjSxembBPo7aQZLAWHmaj5+K19H10B
nCpz9Y++cipkVEiKRGih4ZEvjoFysEOdRLj6WiD/uUNky4xGeA6LaJqh5XpkFkcQ
fQIDAQAB
-----END PUBLIC KEY-----
';
        if (openssl_verify($nh['version'], base64_decode($nh['signature']), $hf) == 1) {
            $_COOKIE['adminer_version'] = $nh['version'];
        }
    }echo'<script',nonce(),'>
mixin(document.body, {onkeydown: bodyKeydown, onclick: bodyClick',(isset($_COOKIE['adminer_version']) ? '' : ", onload: partial(verifyVersion, '$fa', '".js_escape(ME)."', '".get_token()."')"); ?>});
document.body.className = document.body.className.replace(/ nojs/, ' js');
var offlineMessage = '<?php echo
    js_escape(lang(75)),'\';
var thousandsSeparator = \'',js_escape(lang(5)),'\';
</script>

<div id="help" class="jush-',$z,' jsonly hidden"></div>
',script("mixin(qs('#help'), {onmouseover: function () { helpOpen = 1; }, onmouseout: helpMouseout});"),'
<div id="content">
';
    if ($Ha !== null) {
        $B = substr(preg_replace('~\b(username|db|ns)=[^&]*&~', '', ME), 0, -1);
        echo'<p id="breadcrumb"><a href="'.h($B ? $B : '.').'">'.$Ib[DRIVER].'</a> &raquo; ';
        $B = substr(preg_replace('~\b(db|ns)=[^&]*&~', '', ME), 0, -1);
        $O = $c->serverName(SERVER);
        $O = ($O != '' ? $O : lang(30));
        if ($Ha === false) {
            echo"$O\n";
        } else {
            echo"<a href='".($B ? h($B) : '.')."' accesskey='1' title='Alt+Shift+1'>$O</a> &raquo; ";
            if ($_GET['ns'] != '' || (DB != '' && is_array($Ha))) {
                echo'<a href="'.h($B.'&db='.urlencode(DB).(support('scheme') ? '&ns=' : '')).'">'.h(DB).'</a> &raquo; ';
            }if (is_array($Ha)) {
                if ($_GET['ns'] != '') {
                    echo'<a href="'.h(substr(ME, 0, -1)).'">'.h($_GET['ns']).'</a> &raquo; ';
                }foreach ($Ha
                as$_ => $X) {
                    $Ab = (is_array($X) ? $X[1] : h($X));
                    if ($Ab != '') {
                        echo"<a href='".h(ME."$_=").urlencode(is_array($X) ? $X[0] : $X)."'>$Ab</a> &raquo; ";
                    }
                }
            }echo"$Dg\n";
        }
    }echo"<h2>$Fg</h2>\n","<div id='ajaxstatus' class='jsonly hidden'></div>\n";
    restart_session();
    page_messages($m);
    $j = &get_session('dbs');
    if (DB != '' && $j && ! in_array(DB, $j, true)) {
        $j = null;
    }stop_session();
    define('PAGE_HEADER', 1);
}function page_headers()
{
    global$c;
    header('Content-Type: text/html; charset=utf-8');
    header('Cache-Control: no-cache');
    header('X-Frame-Options: deny');
    header('X-XSS-Protection: 0');
    header('X-Content-Type-Options: nosniff');
    header('Referrer-Policy: origin-when-cross-origin');
    foreach ($c->csp()as$nb) {
        $Nc = [];
        foreach ($nb
        as$_ => $X) {
            $Nc[] = "$_ $X";
        }header('Content-Security-Policy: '.implode('; ', $Nc));
    }$c->headers();
}function csp()
{
    return
    [['script-src' => "'self' 'unsafe-inline' 'nonce-".get_nonce()."' 'strict-dynamic'", 'connect-src' => "'self'", 'frame-src' => 'https://www.adminer.org', 'object-src' => "'none'", 'base-uri' => "'none'", 'form-action' => "'self'"]];
}function get_nonce()
{
    static$be;
    if (! $be) {
        $be = base64_encode(rand_string());
    }

return$be;
}function page_messages($m)
{
    $dh = preg_replace('~^[^?]*~', '', $_SERVER['REQUEST_URI']);
    $Qd = $_SESSION['messages'][$dh];
    if ($Qd) {
        echo"<div class='message'>".implode("</div>\n<div class='message'>", $Qd).'</div>'.script('messagesPrint();');
        unset($_SESSION['messages'][$dh]);
    }if ($m) {
        echo"<div class='error'>$m</div>\n";
    }
}function page_footer($Sd = '')
{
    global$c,$T;
    echo'</div>

';
    switch_lang();
    if ($Sd != 'auth') {
        echo'<form action="" method="post">
<p class="logout">
<input type="submit" name="logout" value="',lang(76),'" id="logout">
<input type="hidden" name="token" value="',$T,'">
</p>
</form>
';
    }echo'<div id="menu">
';
    $c->navigation($Sd);
    echo'</div>
',script('setupSubmitHighlight(document);');
}function int32($Vd)
{
    while ($Vd >= 2147483648) {
        $Vd -= 4294967296;
    }while ($Vd <= -2147483649) {
        $Vd += 4294967296;
    }

return(int) $Vd;
}function long2str($W, $rh)
{
    $Df = '';
    foreach ($W
    as$X) {
        $Df .= pack('V', $X);
    }if ($rh) {
        return
        substr($Df, 0, end($W));
    }

return$Df;
}function str2long($Df, $rh)
{
    $W = array_values(unpack('V*', str_pad($Df, 4 * ceil(strlen($Df) / 4), "\0")));
    if ($rh) {
        $W[] = strlen($Df);
    }

return$W;
}function xxtea_mx($yh, $xh, $kg, $kd)
{
    return
    int32((($yh >> 5 & 0x7FFFFFF) ^ $xh << 2) + (($xh >> 3 & 0x1FFFFFFF) ^ $yh << 4)) ^ int32(($kg ^ $xh) + ($kd ^ $yh));
}function encrypt_string($eg, $_)
{
    if ($eg == '') {
        return'';
    }$_ = array_values(unpack('V*', pack('H*', md5($_))));
    $W = str2long($eg, true);
    $Vd = count($W) - 1;
    $yh = $W[$Vd];
    $xh = $W[0];
    $H = floor(6 + 52 / ($Vd + 1));
    $kg = 0;
    while ($H-- > 0) {
        $kg = int32($kg + 0x9E3779B9);
        $Ob = $kg >> 2 & 3;
        for ($Ee = 0; $Ee < $Vd; $Ee++) {
            $xh = $W[$Ee + 1];
            $Ud = xxtea_mx($yh, $xh, $kg, $_[$Ee & 3 ^ $Ob]);
            $yh = int32($W[$Ee] + $Ud);
            $W[$Ee] = $yh;
        }$xh = $W[0];
        $Ud = xxtea_mx($yh, $xh, $kg, $_[$Ee & 3 ^ $Ob]);
        $yh = int32($W[$Vd] + $Ud);
        $W[$Vd] = $yh;
    }

return
    long2str($W, false);
}function decrypt_string($eg, $_)
{
    if ($eg == '') {
        return'';
    }if (! $_) {
        return
        false;
    }$_ = array_values(unpack('V*', pack('H*', md5($_))));
    $W = str2long($eg, false);
    $Vd = count($W) - 1;
    $yh = $W[$Vd];
    $xh = $W[0];
    $H = floor(6 + 52 / ($Vd + 1));
    $kg = int32($H * 0x9E3779B9);
    while ($kg) {
        $Ob = $kg >> 2 & 3;
        for ($Ee = $Vd; $Ee > 0; $Ee--) {
            $yh = $W[$Ee - 1];
            $Ud = xxtea_mx($yh, $xh, $kg, $_[$Ee & 3 ^ $Ob]);
            $xh = int32($W[$Ee] - $Ud);
            $W[$Ee] = $xh;
        }$yh = $W[$Vd];
        $Ud = xxtea_mx($yh, $xh, $kg, $_[$Ee & 3 ^ $Ob]);
        $xh = int32($W[0] - $Ud);
        $W[0] = $xh;
        $kg = int32($kg - 0x9E3779B9);
    }

return
    long2str($W, true);
}$g = '';
$Mc = $_SESSION['token'];
if (! $Mc) {
    $_SESSION['token'] = rand(1, 1e6);
}$T = get_token();
$Re = [];
if ($_COOKIE['adminer_permanent']) {
    foreach (explode(' ', $_COOKIE['adminer_permanent'])as$X) {
        [$_] = explode(':', $X);
        $Re[$_] = $X;
    }
}function add_invalid_login()
{
    global$c;
    $r = file_open_lock(get_temp_dir().'/adminer.invalid');
    if (! $r) {
        return;
    }$ed = unserialize(stream_get_contents($r));
    $Ag = time();
    if ($ed) {
        foreach ($ed
        as$fd => $X) {
            if ($X[0] < $Ag) {
                unset($ed[$fd]);
            }
        }
    }$dd = &$ed[$c->bruteForceKey()];
    if (! $dd) {
        $dd = [$Ag + 30 * 60, 0];
    }$dd[1]++;
    file_write_unlock($r, serialize($ed));
}function check_invalid_login()
{
    global$c;
    $ed = unserialize(@file_get_contents(get_temp_dir().'/adminer.invalid'));
    $dd = $ed[$c->bruteForceKey()];
    $ae = ($dd[1] > 29 ? $dd[0] - time() : 0);
    if ($ae > 0) {
        auth_error(lang(77, ceil($ae / 60)));
    }
}$xa = $_POST['auth'];
if ($xa) {
    session_regenerate_id();
    $mh = $xa['driver'];
    $O = $xa['server'];
    $V = $xa['username'];
    $Oe = (string) $xa['password'];
    $k = $xa['db'];
    set_password($mh, $O, $V, $Oe);
    $_SESSION['db'][$mh][$O][$V][$k] = true;
    if ($xa['permanent']) {
        $_ = base64_encode($mh).'-'.base64_encode($O).'-'.base64_encode($V).'-'.base64_encode($k);
        $cf = $c->permanentLogin(true);
        $Re[$_] = "$_:".base64_encode($cf ? encrypt_string($Oe, $cf) : '');
        cookie('adminer_permanent', implode(' ', $Re));
    }if (count($_POST) == 1 || DRIVER != $mh || SERVER != $O || $_GET['username'] !== $V || DB != $k) {
        redirect(auth_url($mh, $O, $V, $k));
    }
} elseif ($_POST['logout']) {
    if ($Mc && ! verify_token()) {
        page_header(lang(76), lang(78));
        page_footer('db');
        exit;
    } else {
        foreach (['pwds', 'db', 'dbs', 'queries']as$_) {
            set_session($_, null);
        }unset_permanent();
        redirect(substr(preg_replace('~\b(username|db|ns)=[^&]*&~', '', ME), 0, -1), lang(79).' '.lang(80));
    }
} elseif ($Re && ! $_SESSION['pwds']) {
    session_regenerate_id();
    $cf = $c->permanentLogin();
    foreach ($Re
    as$_ => $X) {
        [, $Qa] = explode(':', $X);
        [$mh, $O, $V, $k] = array_map('base64_decode', explode('-', $_));
        set_password($mh, $O, $V, decrypt_string(base64_decode($Qa), $cf));
        $_SESSION['db'][$mh][$O][$V][$k] = true;
    }
}function unset_permanent()
{
    global$Re;
    foreach ($Re
    as$_ => $X) {
        [$mh, $O, $V, $k] = array_map('base64_decode', explode('-', $_));
        if ($mh == DRIVER && $O == SERVER && $V == $_GET['username'] && $k == DB) {
            unset($Re[$_]);
        }
    }cookie('adminer_permanent', implode(' ', $Re));
}function auth_error($m)
{
    global$c,$Mc;
    $Pf = session_name();
    if (isset($_GET['username'])) {
        header('HTTP/1.1 403 Forbidden');
        if (($_COOKIE[$Pf] || $_GET[$Pf]) && ! $Mc) {
            $m = lang(81);
        } else {
            restart_session();
            add_invalid_login();
            $Oe = get_password();
            if ($Oe !== null) {
                if ($Oe === false) {
                    $m .= '<br>'.lang(82, target_blank(), '<code>permanentLogin()</code>');
                }set_password(DRIVER, SERVER, $_GET['username'], null);
            }unset_permanent();
        }
    }if (! $_COOKIE[$Pf] && $_GET[$Pf] && ini_bool('session.use_only_cookies')) {
        $m = lang(83);
    }$He = session_get_cookie_params();
    cookie('adminer_key', ($_COOKIE['adminer_key'] ? $_COOKIE['adminer_key'] : rand_string()), $He['lifetime']);
    page_header(lang(34), $m, null);
    echo"<form action='' method='post'>\n",'<div>';
    if (hidden_fields($_POST, ['auth'])) {
        echo"<p class='message'>".lang(84)."\n";
    }echo"</div>\n";
    $c->loginForm();
    echo"</form>\n";
    page_footer('auth');
    exit;
}if (isset($_GET['username']) && ! class_exists('Min_DB')) {
    unset($_SESSION['pwds'][DRIVER]);
    unset_permanent();
    page_header(lang(85), lang(86, implode(', ', $Xe)), false);
    page_footer('auth');
    exit;
}stop_session(true);
if (isset($_GET['username'])) {
    [$Rc, $Te] = explode(':', SERVER, 2);
    if (is_numeric($Te) && $Te < 1024) {
        auth_error(lang(87));
    }check_invalid_login();
    $g = connect();
    $l = new
    Min_Driver($g);
}$Bd = null;
if (! is_object($g) || ($Bd = $c->login($_GET['username'], get_password())) !== true) {
    $m = (is_string($g) ? h($g) : (is_string($Bd) ? $Bd : lang(88)));
    auth_error($m.(preg_match('~^ | $~', get_password()) ? '<br>'.lang(89) : ''));
}if ($xa && $_POST['token']) {
    $_POST['token'] = $T;
}$m = '';
if ($_POST) {
    if (! verify_token()) {
        $Yc = 'max_input_vars';
        $Ld = ini_get($Yc);
        if (extension_loaded('suhosin')) {
            foreach (['suhosin.request.max_vars', 'suhosin.post.max_vars']as$_) {
                $X = ini_get($_);
                if ($X && (! $Ld || $X < $Ld)) {
                    $Yc = $_;
                    $Ld = $X;
                }
            }
        }$m = (! $_POST['token'] && $Ld ? lang(90, "'$Yc'") : lang(78).' '.lang(91));
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $m = lang(92, "'post_max_size'");
    if (isset($_GET['sql'])) {
        $m .= ' '.lang(93);
    }
}function select($J, $h = null, $xe = [], $A = 0)
{
    global$z;
    $Ad = [];
    $y = [];
    $e = [];
    $Fa = [];
    $Ug = [];
    $K = [];
    odd('');
    for ($u = 0; (! $A || $u < $A) && ($L = $J->fetch_row()); $u++) {
        if (! $u) {
            echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap'>\n",'<thead><tr>';
            for ($jd = 0; $jd < count($L); $jd++) {
                $n = $J->fetch_field();
                $F = $n->name;
                $we = $n->orgtable;
                $ve = $n->orgname;
                $K[$n->table] = $we;
                if ($xe && $z == 'sql') {
                    $Ad[$jd] = ($F == 'table' ? 'table=' : ($F == 'possible_keys' ? 'indexes=' : null));
                } elseif ($we != '') {
                    if (! isset($y[$we])) {
                        $y[$we] = [];
                        foreach (indexes($we, $h)as$x) {
                            if ($x['type'] == 'PRIMARY') {
                                $y[$we] = array_flip($x['columns']);
                                break;
                            }
                        }$e[$we] = $y[$we];
                    }if (isset($e[$we][$ve])) {
                        unset($e[$we][$ve]);
                        $y[$we][$ve] = $jd;
                        $Ad[$jd] = $we;
                    }
                }if ($n->charsetnr == 63) {
                    $Fa[$jd] = true;
                }$Ug[$jd] = $n->type;
                echo'<th'.($we != '' || $n->name != $ve ? " title='".h(($we != '' ? "$we." : '').$ve)."'" : '').'>'.h($F).($xe ? doc_link(['sql' => 'explain-output.html#explain_'.strtolower($F), 'mariadb' => 'explain/#the-columns-in-explain-select']) : '');
            }echo"</thead>\n";
        }echo'<tr'.odd().'>';
        foreach ($L
        as$_ => $X) {
            if ($X === null) {
                $X = '<i>NULL</i>';
            } elseif ($Fa[$_] && ! is_utf8($X)) {
                $X = '<i>'.lang(43, strlen($X)).'</i>';
            } else {
                $X = h($X);
                if ($Ug[$_] == 254) {
                    $X = "<code>$X</code>";
                }
            }if (isset($Ad[$_]) && ! $e[$Ad[$_]]) {
                if ($xe && $z == 'sql') {
                    $Q = $L[array_search('table=', $Ad)];
                    $B = $Ad[$_].urlencode($xe[$Q] != '' ? $xe[$Q] : $Q);
                } else {
                    $B = 'edit='.urlencode($Ad[$_]);
                    foreach ($y[$Ad[$_]]as$Ua => $jd) {
                        $B .= '&where'.urlencode('['.bracket_escape($Ua).']').'='.urlencode($L[$jd]);
                    }
                }$X = "<a href='".h(ME.$B)."'>$X</a>";
            }echo"<td>$X";
        }
    }echo($u ? "</table>\n</div>" : "<p class='message'>".lang(12))."\n";

    return$K;
}function referencable_primary($Kf)
{
    $K = [];
    foreach (table_status('', true)as$og => $Q) {
        if ($og != $Kf && fk_support($Q)) {
            foreach (fields($og)as$n) {
                if ($n['primary']) {
                    if ($K[$og]) {
                        unset($K[$og]);
                        break;
                    }$K[$og] = $n;
                }
            }
        }
    }

return$K;
}function textarea($F, $Y, $M = 10, $Ya = 80)
{
    global$z;
    echo"<textarea name='$F' rows='$M' cols='$Ya' class='sqlarea jush-$z' spellcheck='false' wrap='off'>";
    if (is_array($Y)) {
        foreach ($Y
        as$X) {
            echo
            h($X[0])."\n\n\n";
        }
    } else {
        echo
        h($Y);
    }echo'</textarea>';
}function edit_type($_, $n, $Xa, $q = [], $mc = [])
{
    global$gg,$Ug,$bh,$me;
    $U = $n['type'];
    echo'<td><select name="',h($_),'[type]" class="type" aria-labelledby="label-type">';
    if ($U && ! isset($Ug[$U]) && ! isset($q[$U]) && ! in_array($U, $mc)) {
        $mc[] = $U;
    }if ($q) {
        $gg[lang(94)] = $q;
    }echo
    optionlist(array_merge($mc, $gg), $U),'</select>
',on_help('getTarget(event).value', 1),script("mixin(qsl('select'), {onfocus: function () { lastType = selectValue(this); }, onchange: editingTypeChange});", ''),'<td><input name="',h($_),'[length]" value="',h($n['length']),'" size="3"',(! $n['length'] && preg_match('~var(char|binary)$~', $U) ? " class='required'" : '');
    echo' aria-labelledby="label-length">',script("mixin(qsl('input'), {onfocus: editingLengthFocus, oninput: editingLengthChange});", ''),'<td class="options">',"<select name='".h($_)."[collation]'".(preg_match('~(char|text|enum|set)$~', $U) ? '' : " class='hidden'").'><option value="">('.lang(95).')'.optionlist($Xa, $n['collation']).'</select>',($bh ? "<select name='".h($_)."[unsigned]'".(! $U || preg_match(number_type(), $U) ? '' : " class='hidden'").'><option>'.optionlist($bh, $n['unsigned']).'</select>' : ''),(isset($n['on_update']) ? "<select name='".h($_)."[on_update]'".(preg_match('~timestamp|datetime~', $U) ? '' : " class='hidden'").'>'.optionlist(['' => '('.lang(96).')', 'CURRENT_TIMESTAMP'], (preg_match('~^CURRENT_TIMESTAMP~i', $n['on_update']) ? 'CURRENT_TIMESTAMP' : $n['on_update'])).'</select>' : ''),($q ? "<select name='".h($_)."[on_delete]'".(preg_match('~`~', $U) ? '' : " class='hidden'")."><option value=''>(".lang(97).')'.optionlist(explode('|', $me), $n['on_delete']).'</select> ' : ' ');
}function process_length($yd)
{
    global$Zb;

    return preg_match("~^\\s*\\(?\\s*$Zb(?:\\s*,\\s*$Zb)*+\\s*\\)?\\s*\$~", $yd) && preg_match_all("~$Zb~", $yd, $Fd) ? '('.implode(',', $Fd[0]).')' : preg_replace('~^[0-9].*~', '(\0)', preg_replace('~[^-0-9,+()[\]]~', '', $yd));
}function process_type($n, $Va = 'COLLATE')
{
    global$bh;

    return" $n[type]".process_length($n['length']).(preg_match(number_type(), $n['type']) && in_array($n['unsigned'], $bh) ? " $n[unsigned]" : '').(preg_match('~char|text|enum|set~', $n['type']) && $n['collation'] ? " $Va ".q($n['collation']) : '');
}function process_field($n, $Sg)
{
    return
    [idf_escape(trim($n['field'])), process_type($Sg), ($n['null'] ? ' NULL' : ' NOT NULL'), default_value($n), (preg_match('~timestamp|datetime~', $n['type']) && $n['on_update'] ? " ON UPDATE $n[on_update]" : ''), (support('comment') && $n['comment'] != '' ? ' COMMENT '.q($n['comment']) : ''), ($n['auto_increment'] ? auto_increment() : null)];
}function default_value($n)
{
    $yb = $n['default'];

    return $yb === null ? '' : ' DEFAULT '.(preg_match('~char|binary|text|enum|set~', $n['type']) || preg_match('~^(?![a-z])~i', $yb) ? q($yb) : $yb);
}function type_class($U)
{
    foreach (['char' => 'text', 'date' => 'time|year', 'binary' => 'blob', 'enum' => 'set']as$_ => $X) {
        if (preg_match("~$_|$X~", $U)) {
            return" class='$_'";
        }
    }
}function edit_fields($o, $Xa, $U = 'TABLE', $q = [], $cb = false)
{
    global$Zc;
    $o = array_values($o);
    echo'<thead><tr>
';
    if ($U == 'PROCEDURE') {
        echo'<td>';
    }echo'<th id="label-name">',($U == 'TABLE' ? lang(98) : lang(99)),'<td id="label-type">',lang(45),'<textarea id="enum-edit" rows="4" cols="12" wrap="off" style="display: none;"></textarea>',script("qs('#enum-edit').onblur = editingLengthBlur;"),'<td id="label-length">',lang(100),'<td>',lang(101);
    if ($U == 'TABLE') {
        echo'<td id="label-null">NULL
<td><input type="radio" name="auto_increment_col" value=""><acronym id="label-ai" title="',lang(47),'">AI</acronym>',doc_link(['sql' => 'example-auto-increment.html', 'mariadb' => 'auto_increment/', 'sqlite' => 'autoinc.html', 'pgsql' => 'datatype.html#DATATYPE-SERIAL', 'mssql' => 'ms186775.aspx']),'<td id="label-default">',lang(48),(support('comment') ? "<td id='label-comment'".($cb ? '' : " class='hidden'").'>'.lang(46) : '');
    }echo'<td>',"<input type='image' class='icon' name='add[".(support('move_col') ? 0 : count($o))."]' src='".h(preg_replace('~\\?.*~', '', ME).'?file=plus.gif&version=4.7.0')."' alt='+' title='".lang(102)."'>".script('row_count = '.count($o).';'),'</thead>
<tbody>
',script("mixin(qsl('tbody'), {onclick: editingClick, onkeydown: editingKeydown, oninput: editingInput});");
    foreach ($o
    as$u => $n) {
        $u++;
        $ye = $n[($_POST ? 'orig' : 'field')];
        $Eb = (isset($_POST['add'][$u - 1]) || (isset($n['field']) && ! $_POST['drop_col'][$u])) && (support('drop_col') || $ye == '');
        echo'<tr',($Eb ? '' : " style='display: none;'"),'>
',($U == 'PROCEDURE' ? '<td>'.html_select("fields[$u][inout]", explode('|', $Zc), $n['inout']) : ''),'<th>';
        if ($Eb) {
            echo'<input name="fields[',$u,'][field]" value="',h($n['field']),'" data-maxlength="64" autocapitalize="off" aria-labelledby="label-name">',script("qsl('input').oninput = function () { editingNameChange.call(this);".($n['field'] != '' || count($o) > 1 ? '' : ' editingAddRow.call(this);').' };', '');
        }echo'<input type="hidden" name="fields[',$u,'][orig]" value="',h($ye),'">
';
        edit_type("fields[$u]", $n, $Xa, $q);
        if ($U == 'TABLE') {
            echo'<td>',checkbox("fields[$u][null]", 1, $n['null'], '', '', 'block', 'label-null'),'<td><label class="block"><input type="radio" name="auto_increment_col" value="',$u,'"';
            if ($n['auto_increment']) {
                echo' checked';
            }echo' aria-labelledby="label-ai"></label><td>',checkbox("fields[$u][has_default]", 1, $n['has_default'], '', '', '', 'label-default'),'<input name="fields[',$u,'][default]" value="',h($n['default']),'" aria-labelledby="label-default">',(support('comment') ? '<td'.($cb ? '' : " class='hidden'")."><input name='fields[$u][comment]' value='".h($n['comment'])."' data-maxlength='".(min_version(5.5) ? 1024 : 255)."' aria-labelledby='label-comment'>" : '');
        }echo'<td>',(support('move_col') ? "<input type='image' class='icon' name='add[$u]' src='".h(preg_replace('~\\?.*~', '', ME).'?file=plus.gif&version=4.7.0')."' alt='+' title='".lang(102)."'> "."<input type='image' class='icon' name='up[$u]' src='".h(preg_replace('~\\?.*~', '', ME).'?file=up.gif&version=4.7.0')."' alt='↑' title='".lang(103)."'> "."<input type='image' class='icon' name='down[$u]' src='".h(preg_replace('~\\?.*~', '', ME).'?file=down.gif&version=4.7.0')."' alt='↓' title='".lang(104)."'> " : ''),($ye == '' || support('drop_col') ? "<input type='image' class='icon' name='drop_col[$u]' src='".h(preg_replace('~\\?.*~', '', ME).'?file=cross.gif&version=4.7.0')."' alt='x' title='".lang(105)."'>" : '');
    }
}function process_fields(&$o)
{
    $fe = 0;
    if ($_POST['up']) {
        $sd = 0;
        foreach ($o
        as$_ => $n) {
            if (key($_POST['up']) == $_) {
                unset($o[$_]);
                array_splice($o, $sd, 0, [$n]);
                break;
            }if (isset($n['field'])) {
                $sd = $fe;
            }$fe++;
        }
    } elseif ($_POST['down']) {
        $_c = false;
        foreach ($o
        as$_ => $n) {
            if (isset($n['field']) && $_c) {
                unset($o[key($_POST['down'])]);
                array_splice($o, $fe, 0, [$_c]);
                break;
            }if (key($_POST['down']) == $_) {
                $_c = $n;
            }$fe++;
        }
    } elseif ($_POST['add']) {
        $o = array_values($o);
        array_splice($o, key($_POST['add']), 0, [[]]);
    } elseif (! $_POST['drop_col']) {
        return
        false;
    }

return
    true;
}function normalize_enum($D)
{
    return"'".str_replace("'", "''", addcslashes(stripcslashes(str_replace($D[0][0].$D[0][0], $D[0][0], substr($D[0], 1, -1))), '\\'))."'";
}function grant($Dc, $ef, $e, $le)
{
    if (! $ef) {
        return
        true;
    }if ($ef == ['ALL PRIVILEGES', 'GRANT OPTION']) {
        return $Dc == 'GRANT' ? queries("$Dc ALL PRIVILEGES$le WITH GRANT OPTION") : queries("$Dc ALL PRIVILEGES$le") && queries("$Dc GRANT OPTION$le");
    }

return
    queries("$Dc ".preg_replace('~(GRANT OPTION)\([^)]*\)~', '\1', implode("$e, ", $ef).$e).$le);
}function drop_create($Jb, $i, $Kb, $yg, $Lb, $C, $Pd, $Nd, $Od, $ie, $Yd)
{
    if ($_POST['drop']) {
        query_redirect($Jb, $C, $Pd);
    } elseif ($ie == '') {
        query_redirect($i, $C, $Od);
    } elseif ($ie != $Yd) {
        $lb = queries($i);
        queries_redirect($C, $Nd, $lb && queries($Jb));
        if ($lb) {
            queries($Kb);
        }
    } else {
        queries_redirect($C, $Nd, queries($yg) && queries($Lb) && queries($Jb) && queries($i));
    }
}function create_trigger($le, $L)
{
    global$z;
    $Cg = " $L[Timing] $L[Event]".($L['Event'] == 'UPDATE OF' ? ' '.idf_escape($L['Of']) : '');

    return'CREATE TRIGGER '.idf_escape($L['Trigger']).($z == 'mssql' ? $le.$Cg : $Cg.$le).rtrim(" $L[Type]\n$L[Statement]", ';').';';
}function create_routine($Af, $L)
{
    global$Zc,$z;
    $P = [];
    $o = (array) $L['fields'];
    ksort($o);
    foreach ($o
    as$n) {
        if ($n['field'] != '') {
            $P[] = (preg_match("~^($Zc)\$~", $n['inout']) ? "$n[inout] " : '').idf_escape($n['field']).process_type($n, 'CHARACTER SET');
        }
    }$zb = rtrim("\n$L[definition]", ';');

    return"CREATE $Af ".idf_escape(trim($L['name'])).' ('.implode(', ', $P).')'.(isset($_GET['function']) ? ' RETURNS'.process_type($L['returns'], 'CHARACTER SET') : '').($L['language'] ? " LANGUAGE $L[language]" : '').($z == 'pgsql' ? ' AS '.q($zb) : "$zb;");
}function remove_definer($I)
{
    return
    preg_replace('~^([A-Z =]+) DEFINER=`'.preg_replace('~@(.*)~', '`@`(%|\1)', logged_user()).'`~', '\1', $I);
}function format_foreign_key($p)
{
    global$me;

    return' FOREIGN KEY ('.implode(', ', array_map('idf_escape', $p['source'])).') REFERENCES '.table($p['table']).' ('.implode(', ', array_map('idf_escape', $p['target'])).')'.(preg_match("~^($me)\$~", $p['on_delete']) ? " ON DELETE $p[on_delete]" : '').(preg_match("~^($me)\$~", $p['on_update']) ? " ON UPDATE $p[on_update]" : '');
}function tar_file($sc, $Hg)
{
    $K = pack('a100a8a8a8a12a12', $sc, 644, 0, 0, decoct($Hg->size), decoct(time()));
    $Pa = 8 * 32;
    for ($u = 0; $u < strlen($K); $u++) {
        $Pa += ord($K[$u]);
    }$K .= sprintf('%06o', $Pa)."\0 ";
    echo$K,str_repeat("\0", 512 - strlen($K));
    $Hg->send();
    echo
    str_repeat("\0", 511 - ($Hg->size + 511) % 512);
}function ini_bytes($Yc)
{
    $X = ini_get($Yc);
    switch(strtolower(substr($X, -1))) {
        case'g':$X *= 1024;
        case'm':$X *= 1024;
        case'k':$X *= 1024;
    }

return$X;
}function doc_link($Pe, $zg = '<sup>?</sup>')
{
    global$z,$g;
    $Nf = $g->server_info;
    $nh = preg_replace('~^(\d\.?\d).*~s', '\1', $Nf);
    $fh = ['sql' => "https://dev.mysql.com/doc/refman/$nh/en/", 'sqlite' => 'https://www.sqlite.org/', 'pgsql' => "https://www.postgresql.org/docs/$nh/static/", 'mssql' => 'https://msdn.microsoft.com/library/', 'oracle' => 'https://download.oracle.com/docs/cd/B19306_01/server.102/b14200/'];
    if (preg_match('~MariaDB~', $Nf)) {
        $fh['sql'] = 'https://mariadb.com/kb/en/library/';
        $Pe['sql'] = (isset($Pe['mariadb']) ? $Pe['mariadb'] : str_replace('.html', '/', $Pe['sql']));
    }

return $Pe[$z] ? "<a href='$fh[$z]$Pe[$z]'".target_blank().">$zg</a>" : '';
}function ob_gzencode($fg)
{
    return
    gzencode($fg);
}function db_size($k)
{
    global$g;
    if (! $g->select_db($k)) {
        return'?';
    }$K = 0;
    foreach (table_status()as$R) {
        $K += $R['Data_length'] + $R['Index_length'];
    }

return
    format_number($K);
}function set_utf8mb4($i)
{
    global$g;
    static$P = false;
    if (! $P && preg_match('~\butf8mb4~i', $i)) {
        $P = true;
        echo'SET NAMES '.charset($g).";\n\n";
    }
}function connect_error()
{
    global$c,$g,$T,$m,$Ib;
    if (DB != '') {
        header('HTTP/1.1 404 Not Found');
        page_header(lang(33).': '.h(DB), lang(106), true);
    } else {
        if ($_POST['db'] && ! $m) {
            queries_redirect(substr(ME, 0, -1), lang(107), drop_databases($_POST['db']));
        }page_header(lang(108), $m, false);
        echo"<p class='links'>\n";
        foreach (['database' => lang(109), 'privileges' => lang(67), 'processlist' => lang(110), 'variables' => lang(111), 'status' => lang(112)]as$_ => $X) {
            if (support($_)) {
                echo"<a href='".h(ME)."$_='>$X</a>\n";
            }
        }echo'<p>'.lang(113, $Ib[DRIVER], '<b>'.h($g->server_info).'</b>', "<b>$g->extension</b>")."\n",'<p>'.lang(114, '<b>'.h(logged_user()).'</b>')."\n";
        $j = $c->databases();
        if ($j) {
            $Gf = support('scheme');
            $Xa = collations();
            echo"<form action='' method='post'>\n","<table cellspacing='0' class='checkable'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),'<thead><tr>'.(support('database') ? '<td>' : '').'<th>'.lang(33)." - <a href='".h(ME)."refresh=1'>".lang(115).'</a>'.'<td>'.lang(116).'<td>'.lang(117).'<td>'.lang(118)." - <a href='".h(ME)."dbsize=1'>".lang(119).'</a>'.script("qsl('a').onclick = partial(ajaxSetHtml, '".js_escape(ME)."script=connect');", '')."</thead>\n";
            $j = ($_GET['dbsize'] ? count_tables($j) : array_flip($j));
            foreach ($j
            as$k => $S) {
                $_f = h(ME).'db='.urlencode($k);
                $v = h('Db-'.$k);
                echo'<tr'.odd().'>'.(support('database') ? '<td>'.checkbox('db[]', $k, in_array($k, (array) $_POST['db']), '', '', '', $v) : ''),"<th><a href='$_f' id='$v'>".h($k).'</a>';
                $Wa = h(db_collation($k, $Xa));
                echo'<td>'.(support('database') ? "<a href='$_f".($Gf ? '&amp;ns=' : '')."&amp;database=' title='".lang(63)."'>$Wa</a>" : $Wa),"<td align='right'><a href='$_f&amp;schema=' id='tables-".h($k)."' title='".lang(66)."'>".($_GET['dbsize'] ? $S : '?').'</a>',"<td align='right' id='size-".h($k)."'>".($_GET['dbsize'] ? db_size($k) : '?'),"\n";
            }echo"</table>\n",(support('database') ? "<div class='footer'><div>\n".'<fieldset><legend>'.lang(120)." <span id='selected'></span></legend><div>\n"."<input type='hidden' name='all' value=''>".script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^db/)); };")."<input type='submit' name='drop' value='".lang(121)."'>".confirm()."\n"."</div></fieldset>\n"."</div></div>\n" : ''),"<input type='hidden' name='token' value='$T'>\n","</form>\n",script('tableCheck();');
        }
    }page_footer('db');
}if (isset($_GET['status'])) {
    $_GET['variables'] = $_GET['status'];
}if (isset($_GET['import'])) {
    $_GET['sql'] = $_GET['import'];
}if (! (DB != '' ? $g->select_db(DB) : isset($_GET['sql']) || isset($_GET['dump']) || isset($_GET['database']) || isset($_GET['processlist']) || isset($_GET['privileges']) || isset($_GET['user']) || isset($_GET['variables']) || $_GET['script'] == 'connect' || $_GET['script'] == 'kill')) {
    if (DB != '' || $_GET['refresh']) {
        restart_session();
        set_session('dbs', null);
    }connect_error();
    exit;
}$me = 'RESTRICT|NO ACTION|CASCADE|SET NULL|SET DEFAULT';
class TmpFile
{
    public $handler;

    public $size;

    public function __construct()
    {
        $this->handler = tmpfile();
    }

    public function write($gb)
    {
        $this->size += strlen($gb);
        fwrite($this->handler, $gb);
    }

    public function send()
    {
        fseek($this->handler, 0);
        fpassthru($this->handler);
        fclose($this->handler);
    }
}$Zb = "'(?:''|[^'\\\\]|\\\\.)*'";
$Zc = 'IN|OUT|INOUT';
if (isset($_GET['select']) && ($_POST['edit'] || $_POST['clone']) && ! $_POST['save']) {
    $_GET['edit'] = $_GET['select'];
}if (isset($_GET['callf'])) {
    $_GET['call'] = $_GET['callf'];
}if (isset($_GET['function'])) {
    $_GET['procedure'] = $_GET['function'];
}if (isset($_GET['download'])) {
    $b = $_GET['download'];
    $o = fields($b);
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.friendly_url("$b-".implode('_', $_GET['where'])).'.'.friendly_url($_GET['field']));
    $N = [idf_escape($_GET['field'])];
    $J = $l->select($b, $N, [where($_GET, $o)], $N);
    $L = ($J ? $J->fetch_row() : []);
    echo$l->value($L[0], $o[$_GET['field']]);
    exit;
} elseif (isset($_GET['table'])) {
    $b = $_GET['table'];
    $o = fields($b);
    if (! $o) {
        $m = error();
    }$R = table_status1($b, true);
    $F = $c->tableName($R);
    page_header(($o && is_view($R) ? $R['Engine'] == 'materialized view' ? lang(122) : lang(123) : lang(124)).': '.($F != '' ? $F : h($b)), $m);
    $c->selectLinks($R);
    $bb = $R['Comment'];
    if ($bb != '') {
        echo"<p class='nowrap'>".lang(46).': '.h($bb)."\n";
    }if ($o) {
        $c->tableStructurePrint($o);
    }if (! is_view($R)) {
        if (support('indexes')) {
            echo"<h3 id='indexes'>".lang(125)."</h3>\n";
            $y = indexes($b);
            if ($y) {
                $c->tableIndexesPrint($y);
            }echo'<p class="links"><a href="'.h(ME).'indexes='.urlencode($b).'">'.lang(126)."</a>\n";
        }if (fk_support($R)) {
            echo"<h3 id='foreign-keys'>".lang(94)."</h3>\n";
            $q = foreign_keys($b);
            if ($q) {
                echo"<table cellspacing='0'>\n",'<thead><tr><th>'.lang(127).'<td>'.lang(128).'<td>'.lang(97).'<td>'.lang(96)."<td></thead>\n";
                foreach ($q
                as$F => $p) {
                    echo"<tr title='".h($F)."'>",'<th><i>'.implode('</i>, <i>', array_map('h', $p['source'])).'</i>',"<td><a href='".h($p['db'] != '' ? preg_replace('~db=[^&]*~', 'db='.urlencode($p['db']), ME) : ($p['ns'] != '' ? preg_replace('~ns=[^&]*~', 'ns='.urlencode($p['ns']), ME) : ME)).'table='.urlencode($p['table'])."'>".($p['db'] != '' ? '<b>'.h($p['db']).'</b>.' : '').($p['ns'] != '' ? '<b>'.h($p['ns']).'</b>.' : '').h($p['table']).'</a>','(<i>'.implode('</i>, <i>', array_map('h', $p['target'])).'</i>)','<td>'.h($p['on_delete'])."\n",'<td>'.h($p['on_update'])."\n",'<td><a href="'.h(ME.'foreign='.urlencode($b).'&name='.urlencode($F)).'">'.lang(129).'</a>';
                }echo"</table>\n";
            }echo'<p class="links"><a href="'.h(ME).'foreign='.urlencode($b).'">'.lang(130)."</a>\n";
        }
    }if (support(is_view($R) ? 'view_trigger' : 'trigger')) {
        echo"<h3 id='triggers'>".lang(131)."</h3>\n";
        $Rg = triggers($b);
        if ($Rg) {
            echo"<table cellspacing='0'>\n";
            foreach ($Rg
            as$_ => $X) {
                echo"<tr valign='top'><td>".h($X[0]).'<td>'.h($X[1]).'<th>'.h($_)."<td><a href='".h(ME.'trigger='.urlencode($b).'&name='.urlencode($_))."'>".lang(129)."</a>\n";
            }echo"</table>\n";
        }echo'<p class="links"><a href="'.h(ME).'trigger='.urlencode($b).'">'.lang(132)."</a>\n";
    }
} elseif (isset($_GET['schema'])) {
    page_header(lang(66), '', [], h(DB.($_GET['ns'] ? ".$_GET[ns]" : '')));
    $pg = [];
    $qg = [];
    $da = ($_GET['schema'] ? $_GET['schema'] : $_COOKIE['adminer_schema-'.str_replace('.', '_', DB)]);
    preg_match_all('~([^:]+):([-0-9.]+)x([-0-9.]+)(_|$)~', $da, $Fd, PREG_SET_ORDER);
    foreach ($Fd
    as$u => $D) {
        $pg[$D[1]] = [$D[2], $D[3]];
        $qg[] = "\n\t'".js_escape($D[1])."': [ $D[2], $D[3] ]";
    }$Jg = 0;
    $Ca = -1;
    $Ff = [];
    $rf = [];
    $wd = [];
    foreach (table_status('', true)as$Q => $R) {
        if (is_view($R)) {
            continue;
        }$Ue = 0;
        $Ff[$Q]['fields'] = [];
        foreach (fields($Q)as$F => $n) {
            $Ue += 1.25;
            $n['pos'] = $Ue;
            $Ff[$Q]['fields'][$F] = $n;
        }$Ff[$Q]['pos'] = ($pg[$Q] ? $pg[$Q] : [$Jg, 0]);
        foreach ($c->foreignKeys($Q)as$X) {
            if (! $X['db']) {
                $ud = $Ca;
                if ($pg[$Q][1] || $pg[$X['table']][1]) {
                    $ud = min(floatval($pg[$Q][1]), floatval($pg[$X['table']][1])) - 1;
                } else {
                    $Ca -= .1;
                }while ($wd[(string) $ud]) {
                    $ud -= .0001;
                }$Ff[$Q]['references'][$X['table']][(string) $ud] = [$X['source'], $X['target']];
                $rf[$X['table']][$Q][(string) $ud] = $X['target'];
                $wd[(string) $ud] = true;
            }
        }$Jg = max($Jg, $Ff[$Q]['pos'][0] + 2.5 + $Ue);
    }echo'<div id="schema" style="height: ',$Jg,'em;">
<script',nonce(),'>
qs(\'#schema\').onselectstart = function () { return false; };
var tablePos = {',implode(',', $qg)."\n",'};
var em = qs(\'#schema\').offsetHeight / ',$Jg,';
document.onmousemove = schemaMousemove;
document.onmouseup = partialArg(schemaMouseup, \'',js_escape(DB),'\');
</script>
';
    foreach ($Ff
    as$F => $Q) {
        echo"<div class='table' style='top: ".$Q['pos'][0].'em; left: '.$Q['pos'][1]."em;'>",'<a href="'.h(ME).'table='.urlencode($F).'"><b>'.h($F).'</b></a>',script("qsl('div').onmousedown = schemaMousedown;");
        foreach ($Q['fields']as$n) {
            $X = '<span'.type_class($n['type']).' title="'.h($n['full_type'].($n['null'] ? ' NULL' : '')).'">'.h($n['field']).'</span>';
            echo'<br>'.($n['primary'] ? "<i>$X</i>" : $X);
        }foreach ((array) $Q['references']as$wg => $sf) {
            foreach ($sf
            as$ud => $of) {
                $vd = $ud - $pg[$F][1];
                $u = 0;
                foreach ($of[0]as$Vf) {
                    echo"\n<div class='references' title='".h($wg)."' id='refs$ud-".($u++)."' style='left: $vd".'em; top: '.$Q['fields'][$Vf]['pos']."em; padding-top: .5em;'><div style='border-top: 1px solid Gray; width: ".(-$vd)."em;'></div></div>";
                }
            }
        }foreach ((array) $rf[$F]as$wg => $sf) {
            foreach ($sf
            as$ud => $e) {
                $vd = $ud - $pg[$F][1];
                $u = 0;
                foreach ($e
                as$vg) {
                    echo"\n<div class='references' title='".h($wg)."' id='refd$ud-".($u++)."' style='left: $vd".'em; top: '.$Q['fields'][$vg]['pos'].'em; height: 1.25em; background: url('.h(preg_replace('~\\?.*~', '', ME).'?file=arrow.gif) no-repeat right center;&version=4.7.0')."'><div style='height: .5em; border-bottom: 1px solid Gray; width: ".(-$vd)."em;'></div></div>";
                }
            }
        }echo"\n</div>\n";
    }foreach ($Ff
    as$F => $Q) {
        foreach ((array) $Q['references']as$wg => $sf) {
            foreach ($sf
            as$ud => $of) {
                $Rd = $Jg;
                $Jd = -10;
                foreach ($of[0]as$_ => $Vf) {
                    $Ve = $Q['pos'][0] + $Q['fields'][$Vf]['pos'];
                    $We = $Ff[$wg]['pos'][0] + $Ff[$wg]['fields'][$of[1][$_]]['pos'];
                    $Rd = min($Rd, $Ve, $We);
                    $Jd = max($Jd, $Ve, $We);
                }echo"<div class='references' id='refl$ud' style='left: $ud"."em; top: $Rd"."em; padding: .5em 0;'><div style='border-right: 1px solid Gray; margin-top: 1px; height: ".($Jd - $Rd)."em;'></div></div>\n";
            }
        }
    }echo'</div>
<p class="links"><a href="',h(ME.'schema='.urlencode($da)),'" id="schema-link">',lang(133),'</a>
';
} elseif (isset($_GET['dump'])) {
    $b = $_GET['dump'];
    if ($_POST && ! $m) {
        $jb = '';
        foreach (['output', 'format', 'db_style', 'routines', 'events', 'table_style', 'auto_increment', 'triggers', 'data_style']as$_) {
            $jb .= "&$_=".urlencode($_POST[$_]);
        }cookie('adminer_export', substr($jb, 1));
        $S = array_flip((array) $_POST['tables']) + array_flip((array) $_POST['data']);
        $kc = dump_headers((count($S) == 1 ? key($S) : DB), (DB == '' || count($S) > 1));
        $hd = preg_match('~sql~', $_POST['format']);
        if ($hd) {
            echo"-- Adminer $fa ".$Ib[DRIVER]." dump\n\n";
            if ($z == 'sql') {
                echo"SET NAMES utf8;
SET time_zone = '+00:00';
".($_POST['data_style'] ? "SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';
" : '').'
';
                $g->query("SET time_zone = '+00:00';");
            }
        }$hg = $_POST['db_style'];
        $j = [DB];
        if (DB == '') {
            $j = $_POST['databases'];
            if (is_string($j)) {
                $j = explode("\n", rtrim(str_replace("\r", '', $j), "\n"));
            }
        }foreach ((array) $j
        as$k) {
            $c->dumpDatabase($k);
            if ($g->select_db($k)) {
                if ($hd && preg_match('~CREATE~', $hg) && ($i = $g->result('SHOW CREATE DATABASE '.idf_escape($k), 1))) {
                    set_utf8mb4($i);
                    if ($hg == 'DROP+CREATE') {
                        echo'DROP DATABASE IF EXISTS '.idf_escape($k).";\n";
                    }echo"$i;\n";
                }if ($hd) {
                    if ($hg) {
                        echo
                        use_sql($k).";\n\n";
                    }$Ce = '';
                    if ($_POST['routines']) {
                        foreach (['FUNCTION', 'PROCEDURE']as$Af) {
                            foreach (get_rows("SHOW $Af STATUS WHERE Db = ".q($k), null, '-- ')as$L) {
                                $i = remove_definer($g->result("SHOW CREATE $Af ".idf_escape($L['Name']), 2));
                                set_utf8mb4($i);
                                $Ce .= ($hg != 'DROP+CREATE' ? "DROP $Af IF EXISTS ".idf_escape($L['Name']).";;\n" : '')."$i;;\n\n";
                            }
                        }
                    }if ($_POST['events']) {
                        foreach (get_rows('SHOW EVENTS', null, '-- ')as$L) {
                            $i = remove_definer($g->result('SHOW CREATE EVENT '.idf_escape($L['Name']), 3));
                            set_utf8mb4($i);
                            $Ce .= ($hg != 'DROP+CREATE' ? 'DROP EVENT IF EXISTS '.idf_escape($L['Name']).";;\n" : '')."$i;;\n\n";
                        }
                    }if ($Ce) {
                        echo"DELIMITER ;;\n\n$Ce"."DELIMITER ;\n\n";
                    }
                }if ($_POST['table_style'] || $_POST['data_style']) {
                    $ph = [];
                    foreach (table_status('', true)as$F => $R) {
                        $Q = (DB == '' || in_array($F, (array) $_POST['tables']));
                        $rb = (DB == '' || in_array($F, (array) $_POST['data']));
                        if ($Q || $rb) {
                            if ($kc == 'tar') {
                                $Hg = new
                                TmpFile;
                                ob_start([$Hg, 'write'], 1e5);
                            }$c->dumpTable($F, ($Q ? $_POST['table_style'] : ''), (is_view($R) ? 2 : 0));
                            if (is_view($R)) {
                                $ph[] = $F;
                            } elseif ($rb) {
                                $o = fields($F);
                                $c->dumpData($F, $_POST['data_style'], 'SELECT *'.convert_fields($o, $o).' FROM '.table($F));
                            }if ($hd && $_POST['triggers'] && $Q && ($Rg = trigger_sql($F))) {
                                echo"\nDELIMITER ;;\n$Rg\nDELIMITER ;\n";
                            }if ($kc == 'tar') {
                                ob_end_flush();
                                tar_file((DB != '' ? '' : "$k/")."$F.csv", $Hg);
                            } elseif ($hd) {
                                echo"\n";
                            }
                        }
                    }foreach ($ph
                    as$oh) {
                        $c->dumpTable($oh, $_POST['table_style'], 1);
                    }if ($kc == 'tar') {
                        echo
                        pack('x512');
                    }
                }
            }
        }if ($hd) {
            echo'-- '.$g->result('SELECT NOW()')."\n";
        }exit;
    }page_header(lang(69), $m, ($_GET['export'] != '' ? ['table' => $_GET['export']] : []), h(DB));
    echo'
<form action="" method="post">
<table cellspacing="0" class="layout">
';
    $vb = ['', 'USE', 'DROP+CREATE', 'CREATE'];
    $rg = ['', 'DROP+CREATE', 'CREATE'];
    $sb = ['', 'TRUNCATE+INSERT', 'INSERT'];
    if ($z == 'sql') {
        $sb[] = 'INSERT+UPDATE';
    }parse_str($_COOKIE['adminer_export'], $L);
    if (! $L) {
        $L = ['output' => 'text', 'format' => 'sql', 'db_style' => (DB != '' ? '' : 'CREATE'), 'table_style' => 'DROP+CREATE', 'data_style' => 'INSERT'];
    }if (! isset($L['events'])) {
        $L['routines'] = $L['events'] = ($_GET['dump'] == '');
        $L['triggers'] = $L['table_style'];
    }echo'<tr><th>'.lang(134).'<td>'.html_select('output', $c->dumpOutput(), $L['output'], 0)."\n";
    echo'<tr><th>'.lang(135).'<td>'.html_select('format', $c->dumpFormat(), $L['format'], 0)."\n";
    echo($z == 'sqlite' ? '' : '<tr><th>'.lang(33).'<td>'.html_select('db_style', $vb, $L['db_style']).(support('routine') ? checkbox('routines', 1, $L['routines'], lang(136)) : '').(support('event') ? checkbox('events', 1, $L['events'], lang(137)) : '')),'<tr><th>'.lang(117).'<td>'.html_select('table_style', $rg, $L['table_style']).checkbox('auto_increment', 1, $L['auto_increment'], lang(47)).(support('trigger') ? checkbox('triggers', 1, $L['triggers'], lang(131)) : ''),'<tr><th>'.lang(138).'<td>'.html_select('data_style', $sb, $L['data_style']),'</table>
<p><input type="submit" value="',lang(69),'">
<input type="hidden" name="token" value="',$T,'">

<table cellspacing="0">
',script("qsl('table').onclick = dumpClick;");
    $Ze = [];
    if (DB != '') {
        $Na = ($b != '' ? '' : ' checked');
        echo'<thead><tr>',"<th style='text-align: left;'><label class='block'><input type='checkbox' id='check-tables'$Na>".lang(117).'</label>'.script("qs('#check-tables').onclick = partial(formCheck, /^tables\\[/);", ''),"<th style='text-align: right;'><label class='block'>".lang(138)."<input type='checkbox' id='check-data'$Na></label>".script("qs('#check-data').onclick = partial(formCheck, /^data\\[/);", ''),"</thead>\n";
        $ph = '';
        $sg = tables_list();
        foreach ($sg
        as$F => $U) {
            $Ye = preg_replace('~_.*~', '', $F);
            $Na = ($b == '' || $b == (substr($b, -1) == '%' ? "$Ye%" : $F));
            $bf = '<tr><td>'.checkbox('tables[]', $F, $Na, $F, '', 'block');
            if ($U !== null && ! preg_match('~table~i', $U)) {
                $ph .= "$bf\n";
            } else {
                echo"$bf<td align='right'><label class='block'><span id='Rows-".h($F)."'></span>".checkbox('data[]', $F, $Na)."</label>\n";
            }$Ze[$Ye]++;
        }echo$ph;
        if ($sg) {
            echo
            script("ajaxSetHtml('".js_escape(ME)."script=db');");
        }
    } else {
        echo"<thead><tr><th style='text-align: left;'>","<label class='block'><input type='checkbox' id='check-databases'".($b == '' ? ' checked' : '').'>'.lang(33).'</label>',script("qs('#check-databases').onclick = partial(formCheck, /^databases\\[/);", ''),"</thead>\n";
        $j = $c->databases();
        if ($j) {
            foreach ($j
            as$k) {
                if (! information_schema($k)) {
                    $Ye = preg_replace('~_.*~', '', $k);
                    echo'<tr><td>'.checkbox('databases[]', $k, $b == '' || $b == "$Ye%", $k, '', 'block')."\n";
                    $Ze[$Ye]++;
                }
            }
        } else {
            echo"<tr><td><textarea name='databases' rows='10' cols='20'></textarea>";
        }
    }echo'</table>
</form>
';
    $uc = true;
    foreach ($Ze
    as$_ => $X) {
        if ($_ != '' && $X > 1) {
            echo($uc ? '<p>' : ' ')."<a href='".h(ME).'dump='.urlencode("$_%")."'>".h($_).'</a>';
            $uc = false;
        }
    }
} elseif (isset($_GET['privileges'])) {
    page_header(lang(67));
    echo'<p class="links"><a href="'.h(ME).'user=">'.lang(139).'</a>';
    $J = $g->query('SELECT User, Host FROM mysql.'.(DB == '' ? 'user' : 'db WHERE '.q(DB).' LIKE Db').' ORDER BY Host, User');
    $Dc = $J;
    if (! $J) {
        $J = $g->query("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', 1) AS User, SUBSTRING_INDEX(CURRENT_USER, '@', -1) AS Host");
    }echo"<form action=''><p>\n";
    hidden_fields_get();
    echo"<input type='hidden' name='db' value='".h(DB)."'>\n",($Dc ? '' : "<input type='hidden' name='grant' value=''>\n"),"<table cellspacing='0'>\n",'<thead><tr><th>'.lang(31).'<th>'.lang(30)."<th></thead>\n";
    while ($L = $J->fetch_assoc()) {
        echo'<tr'.odd().'><td>'.h($L['User']).'<td>'.h($L['Host']).'<td><a href="'.h(ME.'user='.urlencode($L['User']).'&host='.urlencode($L['Host'])).'">'.lang(10)."</a>\n";
    }if (! $Dc || DB != '') {
        echo'<tr'.odd()."><td><input name='user' autocapitalize='off'><td><input name='host' value='localhost' autocapitalize='off'><td><input type='submit' value='".lang(10)."'>\n";
    }echo"</table>\n","</form>\n";
} elseif (isset($_GET['sql'])) {
    if (! $m && $_POST['export']) {
        dump_headers('sql');
        $c->dumpTable('', '');
        $c->dumpData('', 'table', $_POST['query']);
        exit;
    }restart_session();
    $Qc = &get_session('queries');
    $Pc = &$Qc[DB];
    if (! $m && $_POST['clear']) {
        $Pc = [];
        redirect(remove_from_uri('history'));
    }page_header((isset($_GET['import']) ? lang(68) : lang(60)), $m);
    if (! $m && $_POST) {
        $r = false;
        if (! isset($_GET['import'])) {
            $I = $_POST['query'];
        } elseif ($_POST['webfile']) {
            $Yf = $c->importServerPath();
            $r = @fopen((file_exists($Yf) ? $Yf : "compress.zlib://$Yf.gz"), 'rb');
            $I = ($r ? fread($r, 1e6) : false);
        } else {
            $I = get_file('sql_file', true);
        }if (is_string($I)) {
            if (function_exists('memory_get_usage')) {
                @ini_set('memory_limit', max(ini_bytes('memory_limit'), 2 * strlen($I) + memory_get_usage() + 8e6));
            }if ($I != '' && strlen($I) < 1e6) {
                $H = $I.(preg_match("~;[ \t\r\n]*\$~", $I) ? '' : ';');
                if (! $Pc || reset(end($Pc)) != $H) {
                    restart_session();
                    $Pc[] = [$H, time()];
                    set_session('queries', $Qc);
                    stop_session();
                }
            }$Wf = "(?:\\s|/\\*[\s\S]*?\\*/|(?:#|-- )[^\n]*\n?|--\r?\n)";
            $_b = ';';
            $fe = 0;
            $Wb = true;
            $h = connect();
            if (is_object($h) && DB != '') {
                $h->select_db(DB);
            }$ab = 0;
            $bc = [];
            $Ie = '[\'"'.($z == 'sql' ? '`#' : ($z == 'sqlite' ? '`[' : ($z == 'mssql' ? '[' : ''))).']|/\*|-- |$'.($z == 'pgsql' ? '|\$[^$]*\$' : '');
            $Kg = microtime(true);
            parse_str($_COOKIE['adminer_export'], $la);
            $Nb = $c->dumpFormat();
            unset($Nb['sql']);
            while ($I != '') {
                if (! $fe && preg_match("~^$Wf*+DELIMITER\\s+(\\S+)~i", $I, $D)) {
                    $_b = $D[1];
                    $I = substr($I, strlen($D[0]));
                } else {
                    preg_match('('.preg_quote($_b)."\\s*|$Ie)", $I, $D, PREG_OFFSET_CAPTURE, $fe);
                    [$_c, $Ue] = $D[0];
                    if (! $_c && $r && ! feof($r)) {
                        $I .= fread($r, 1e5);
                    } else {
                        if (! $_c && rtrim($I) == '') {
                            break;
                        }$fe = $Ue + strlen($_c);
                        if ($_c && rtrim($_c) != $_b) {
                            while (preg_match('('.($_c == '/*' ? '\*/' : ($_c == '[' ? ']' : (preg_match('~^-- |^#~', $_c) ? "\n" : preg_quote($_c).'|\\\\.'))).'|$)s', $I, $D, PREG_OFFSET_CAPTURE, $fe)) {
                                $Df = $D[0][0];
                                if (! $Df && $r && ! feof($r)) {
                                    $I .= fread($r, 1e5);
                                } else {
                                    $fe = $D[0][1] + strlen($Df);
                                    if ($Df[0] != '\\') {
                                        break;
                                    }
                                }
                            }
                        } else {
                            $Wb = false;
                            $H = substr($I, 0, $Ue);
                            $ab++;
                            $bf = "<pre id='sql-$ab'><code class='jush-$z'>".$c->sqlCommandQuery($H)."</code></pre>\n";
                            if ($z == 'sqlite' && preg_match("~^$Wf*+ATTACH\\b~i", $H, $D)) {
                                echo$bf,"<p class='error'>".lang(140)."\n";
                                $bc[] = " <a href='#sql-$ab'>$ab</a>";
                                if ($_POST['error_stops']) {
                                    break;
                                }
                            } else {
                                if (! $_POST['only_errors']) {
                                    echo$bf;
                                    ob_flush();
                                    flush();
                                }$bg = microtime(true);
                                if ($g->multi_query($H) && is_object($h) && preg_match("~^$Wf*+USE\\b~i", $H)) {
                                    $h->query($H);
                                }do {
                                    $J = $g->store_result();
                                    if ($g->error) {
                                        echo($_POST['only_errors'] ? $bf : ''),"<p class='error'>".lang(141).($g->errno ? " ($g->errno)" : '').': '.error()."\n";
                                        $bc[] = " <a href='#sql-$ab'>$ab</a>";
                                        if ($_POST['error_stops']) {
                                            break
                                            2;
                                        }
                                    } else {
                                        $Ag = " <span class='time'>(".format_time($bg).')</span>'.(strlen($H) < 1000 ? " <a href='".h(ME).'sql='.urlencode(trim($H))."'>".lang(10).'</a>' : '');
                                        $na = $g->affected_rows;
                                        $sh = ($_POST['only_errors'] ? '' : $l->warnings());
                                        $th = "warnings-$ab";
                                        if ($sh) {
                                            $Ag .= ", <a href='#$th'>".lang(42).'</a>'.script("qsl('a').onclick = partial(toggle, '$th');", '');
                                        }$ic = null;
                                        $jc = "explain-$ab";
                                        if (is_object($J)) {
                                            $A = $_POST['limit'];
                                            $xe = select($J, $h, [], $A);
                                            if (! $_POST['only_errors']) {
                                                echo"<form action='' method='post'>\n";
                                                $ce = $J->num_rows;
                                                echo'<p>'.($ce ? ($A && $ce > $A ? lang(142, $A) : '').lang(143, $ce) : ''),$Ag;
                                                if ($h && preg_match("~^($Wf|\\()*+SELECT\\b~i", $H) && ($ic = explain($h, $H))) {
                                                    echo", <a href='#$jc'>Explain</a>".script("qsl('a').onclick = partial(toggle, '$jc');", '');
                                                }$v = "export-$ab";
                                                echo", <a href='#$v'>".lang(69).'</a>'.script("qsl('a').onclick = partial(toggle, '$v');", '')."<span id='$v' class='hidden'>: ".html_select('output', $c->dumpOutput(), $la['output']).' '.html_select('format', $Nb, $la['format'])."<input type='hidden' name='query' value='".h($H)."'>"." <input type='submit' name='export' value='".lang(69)."'><input type='hidden' name='token' value='$T'></span>\n"."</form>\n";
                                            }
                                        } else {
                                            if (preg_match("~^$Wf*+(CREATE|DROP|ALTER)$Wf++(DATABASE|SCHEMA)\\b~i", $H)) {
                                                restart_session();
                                                set_session('dbs', null);
                                                stop_session();
                                            }if (! $_POST['only_errors']) {
                                                echo"<p class='message' title='".h($g->info)."'>".lang(144, $na)."$Ag\n";
                                            }
                                        }echo $sh ? "<div id='$th' class='hidden'>\n$sh</div>\n" : '';
                                        if ($ic) {
                                            echo"<div id='$jc' class='hidden'>\n";
                                            select($ic, $h, $xe);
                                            echo"</div>\n";
                                        }
                                    }$bg = microtime(true);
                                } while ($g->next_result());
                            }$I = substr($I, $fe);
                            $fe = 0;
                        }
                    }
                }
            }if ($Wb) {
                echo"<p class='message'>".lang(145)."\n";
            } elseif ($_POST['only_errors']) {
                echo"<p class='message'>".lang(146, $ab - count($bc))," <span class='time'>(".format_time($Kg).")</span>\n";
            } elseif ($bc && $ab > 1) {
                echo"<p class='error'>".lang(141).': '.implode('', $bc)."\n";
            }
        } else {
            echo"<p class='error'>".upload_error($I)."\n";
        }
    }echo'
<form action="" method="post" enctype="multipart/form-data" id="form">
';
    $gc = "<input type='submit' value='".lang(147)."' title='Ctrl+Enter'>";
    if (! isset($_GET['import'])) {
        $H = $_GET['sql'];
        if ($_POST) {
            $H = $_POST['query'];
        } elseif ($_GET['history'] == 'all') {
            $H = $Pc;
        } elseif ($_GET['history'] != '') {
            $H = $Pc[$_GET['history']][0];
        }echo'<p>';
        textarea('query', $H, 20);
        echo
        script(($_POST ? '' : "qs('textarea').focus();\n")."qs('#form').onsubmit = partial(sqlSubmit, qs('#form'), '".remove_from_uri('sql|limit|error_stops|only_errors')."');"),"<p>$gc\n",lang(148).": <input type='number' name='limit' class='size' value='".h($_POST ? $_POST['limit'] : $_GET['limit'])."'>\n";
    } else {
        echo'<fieldset><legend>'.lang(149).'</legend><div>';
        $Ic = (extension_loaded('zlib') ? '[.gz]' : '');
        echo(ini_bool('file_uploads') ? "SQL$Ic (&lt; ".ini_get('upload_max_filesize')."B): <input type='file' name='sql_file[]' multiple>\n$gc" : lang(150)),"</div></fieldset>\n";
        $Vc = $c->importServerPath();
        if ($Vc) {
            echo'<fieldset><legend>'.lang(151).'</legend><div>',lang(152, '<code>'.h($Vc)."$Ic</code>"),' <input type="submit" name="webfile" value="'.lang(153).'">',"</div></fieldset>\n";
        }echo'<p>';
    }echo
    checkbox('error_stops', 1, ($_POST ? $_POST['error_stops'] : isset($_GET['import'])), lang(154))."\n",checkbox('only_errors', 1, ($_POST ? $_POST['only_errors'] : isset($_GET['import'])), lang(155))."\n","<input type='hidden' name='token' value='$T'>\n";
    if (! isset($_GET['import']) && $Pc) {
        print_fieldset('history', lang(156), $_GET['history'] != '');
        for ($X = end($Pc); $X; $X = prev($Pc)) {
            $_ = key($Pc);
            [$H, $Ag, $Rb] = $X;
            echo'<a href="'.h(ME."sql=&history=$_").'">'.lang(10).'</a>'." <span class='time' title='".@date('Y-m-d', $Ag)."'>".@date('H:i:s', $Ag).'</span>'." <code class='jush-$z'>".shorten_utf8(ltrim(str_replace("\n", ' ', str_replace("\r", '', preg_replace('~^(#|-- ).*~m', '', $H)))), 80, '</code>').($Rb ? " <span class='time'>($Rb)</span>" : '')."<br>\n";
        }echo"<input type='submit' name='clear' value='".lang(157)."'>\n","<a href='".h(ME.'sql=&history=all')."'>".lang(158)."</a>\n","</div></fieldset>\n";
    }echo'</form>
';
} elseif (isset($_GET['edit'])) {
    $b = $_GET['edit'];
    $o = fields($b);
    $Z = (isset($_GET['select']) ? ($_POST['check'] && count($_POST['check']) == 1 ? where_check($_POST['check'][0], $o) : '') : where($_GET, $o));
    $ch = (isset($_GET['select']) ? $_POST['edit'] : $Z);
    foreach ($o
    as$F => $n) {
        if (! isset($n['privileges'][$ch ? 'update' : 'insert']) || $c->fieldName($n) == '') {
            unset($o[$F]);
        }
    }if ($_POST && ! $m && ! isset($_GET['select'])) {
        $C = $_POST['referer'];
        if ($_POST['insert']) {
            $C = ($ch ? null : $_SERVER['REQUEST_URI']);
        } elseif (! preg_match('~^.+&select=.+$~', $C)) {
            $C = ME.'select='.urlencode($b);
        }$y = indexes($b);
        $Xg = unique_array($_GET['where'], $y);
        $kf = "\nWHERE $Z";
        if (isset($_POST['delete'])) {
            queries_redirect($C, lang(159), $l->delete($b, $kf, ! $Xg));
        } else {
            $P = [];
            foreach ($o
            as$F => $n) {
                $X = process_input($n);
                if ($X !== false && $X !== null) {
                    $P[idf_escape($F)] = $X;
                }
            }if ($ch) {
                if (! $P) {
                    redirect($C);
                }queries_redirect($C, lang(160), $l->update($b, $P, $kf, ! $Xg));
                if (is_ajax()) {
                    page_headers();
                    page_messages($m);
                    exit;
                }
            } else {
                $J = $l->insert($b, $P);
                $td = ($J ? last_id() : 0);
                queries_redirect($C, lang(161, ($td ? " $td" : '')), $J);
            }
        }
    }$L = null;
    if ($_POST['save']) {
        $L = (array) $_POST['fields'];
    } elseif ($Z) {
        $N = [];
        foreach ($o
        as$F => $n) {
            if (isset($n['privileges']['select'])) {
                $ua = convert_field($n);
                if ($_POST['clone'] && $n['auto_increment']) {
                    $ua = "''";
                }if ($z == 'sql' && preg_match('~enum|set~', $n['type'])) {
                    $ua = '1*'.idf_escape($F);
                }$N[] = ($ua ? "$ua AS " : '').idf_escape($F);
            }
        }$L = [];
        if (! support('table')) {
            $N = ['*'];
        }if ($N) {
            $J = $l->select($b, $N, [$Z], $N, [], (isset($_GET['select']) ? 2 : 1));
            if (! $J) {
                $m = error();
            } else {
                $L = $J->fetch_assoc();
                if (! $L) {
                    $L = false;
                }
            }if (isset($_GET['select']) && (! $L || $J->fetch_assoc())) {
                $L = null;
            }
        }
    }if (! support('table') && ! $o) {
        if (! $Z) {
            $J = $l->select($b, ['*'], $Z, ['*']);
            $L = ($J ? $J->fetch_assoc() : false);
            if (! $L) {
                $L = [$l->primary => ''];
            }
        }if ($L) {
            foreach ($L
            as$_ => $X) {
                if (! $Z) {
                    $L[$_] = null;
                }$o[$_] = ['field' => $_, 'null' => ($_ != $l->primary), 'auto_increment' => ($_ == $l->primary)];
            }
        }
    }edit_form($b, $o, $L, $ch);
} elseif (isset($_GET['create'])) {
    $b = $_GET['create'];
    $Je = [];
    foreach (['HASH', 'LINEAR HASH', 'KEY', 'LINEAR KEY', 'RANGE', 'LIST']as$_) {
        $Je[$_] = $_;
    }$qf = referencable_primary($b);
    $q = [];
    foreach ($qf
    as$og => $n) {
        $q[str_replace('`', '``', $og).'`'.str_replace('`', '``', $n['field'])] = $og;
    }$_e = [];
    $R = [];
    if ($b != '') {
        $_e = fields($b);
        $R = table_status($b);
        if (! $R) {
            $m = lang(9);
        }
    }$L = $_POST;
    $L['fields'] = (array) $L['fields'];
    if ($L['auto_increment_col']) {
        $L['fields'][$L['auto_increment_col']]['auto_increment'] = true;
    }if ($_POST && ! process_fields($L['fields']) && ! $m) {
        if ($_POST['drop']) {
            queries_redirect(substr(ME, 0, -1), lang(162), drop_tables([$b]));
        } else {
            $o = [];
            $ra = [];
            $gh = false;
            $xc = [];
            $ze = reset($_e);
            $pa = ' FIRST';
            foreach ($L['fields']as$_ => $n) {
                $p = $q[$n['type']];
                $Sg = ($p !== null ? $qf[$p] : $n);
                if ($n['field'] != '') {
                    if (! $n['has_default']) {
                        $n['default'] = null;
                    }if ($_ == $L['auto_increment_col']) {
                        $n['auto_increment'] = true;
                    }$gf = process_field($n, $Sg);
                    $ra[] = [$n['orig'], $gf, $pa];
                    if ($gf != process_field($ze, $ze)) {
                        $o[] = [$n['orig'], $gf, $pa];
                        if ($n['orig'] != '' || $pa) {
                            $gh = true;
                        }
                    }if ($p !== null) {
                        $xc[idf_escape($n['field'])] = ($b != '' && $z != 'sqlite' ? 'ADD' : ' ').format_foreign_key(['table' => $q[$n['type']], 'source' => [$n['field']], 'target' => [$Sg['field']], 'on_delete' => $n['on_delete']]);
                    }$pa = ' AFTER '.idf_escape($n['field']);
                } elseif ($n['orig'] != '') {
                    $gh = true;
                    $o[] = [$n['orig']];
                }if ($n['orig'] != '') {
                    $ze = next($_e);
                    if (! $ze) {
                        $pa = '';
                    }
                }
            }$Le = '';
            if ($Je[$L['partition_by']]) {
                $Me = [];
                if ($L['partition_by'] == 'RANGE' || $L['partition_by'] == 'LIST') {
                    foreach (array_filter($L['partition_names'])as$_ => $X) {
                        $Y = $L['partition_values'][$_];
                        $Me[] = "\n  PARTITION ".idf_escape($X).' VALUES '.($L['partition_by'] == 'RANGE' ? 'LESS THAN' : 'IN').($Y != '' ? " ($Y)" : ' MAXVALUE');
                    }
                }$Le .= "\nPARTITION BY $L[partition_by]($L[partition])".($Me ? ' ('.implode(',', $Me)."\n)" : ($L['partitions'] ? ' PARTITIONS '.(+$L['partitions']) : ''));
            } elseif (support('partitioning') && preg_match('~partitioned~', $R['Create_options'])) {
                $Le .= "\nREMOVE PARTITIONING";
            }$E = lang(163);
            if ($b == '') {
                cookie('adminer_engine', $L['Engine']);
                $E = lang(164);
            }$F = trim($L['name']);
            queries_redirect(ME.(support('table') ? 'table=' : 'select=').urlencode($F), $E, alter_table($b, $F, ($z == 'sqlite' && ($gh || $xc) ? $ra : $o), $xc, ($L['Comment'] != $R['Comment'] ? $L['Comment'] : null), ($L['Engine'] && $L['Engine'] != $R['Engine'] ? $L['Engine'] : ''), ($L['Collation'] && $L['Collation'] != $R['Collation'] ? $L['Collation'] : ''), ($L['Auto_increment'] != '' ? number($L['Auto_increment']) : ''), $Le));
        }
    }page_header(($b != '' ? lang(40) : lang(70)), $m, ['table' => $b], h($b));
    if (! $_POST) {
        $L = ['Engine' => $_COOKIE['adminer_engine'], 'fields' => [['field' => '', 'type' => (isset($Ug['int']) ? 'int' : (isset($Ug['integer']) ? 'integer' : '')), 'on_update' => '']], 'partition_names' => ['']];
        if ($b != '') {
            $L = $R;
            $L['name'] = $b;
            $L['fields'] = [];
            if (! $_GET['auto_increment']) {
                $L['Auto_increment'] = '';
            }foreach ($_e
            as$n) {
                $n['has_default'] = isset($n['default']);
                $L['fields'][] = $n;
            }if (support('partitioning')) {
                $Bc = 'FROM information_schema.PARTITIONS WHERE TABLE_SCHEMA = '.q(DB).' AND TABLE_NAME = '.q($b);
                $J = $g->query("SELECT PARTITION_METHOD, PARTITION_ORDINAL_POSITION, PARTITION_EXPRESSION $Bc ORDER BY PARTITION_ORDINAL_POSITION DESC LIMIT 1");
                [$L['partition_by'], $L['partitions'], $L['partition']] = $J->fetch_row();
                $Me = get_key_vals("SELECT PARTITION_NAME, PARTITION_DESCRIPTION $Bc AND PARTITION_NAME != '' ORDER BY PARTITION_ORDINAL_POSITION");
                $Me[''] = '';
                $L['partition_names'] = array_keys($Me);
                $L['partition_values'] = array_values($Me);
            }
        }
    }$Xa = collations();
    $Yb = engines();
    foreach ($Yb
    as$Xb) {
        if (! strcasecmp($Xb, $L['Engine'])) {
            $L['Engine'] = $Xb;
            break;
        }
    }echo'
<form action="" method="post" id="form">
<p>
';
    if (support('columns') || $b == '') {
        echo
        lang(165),': <input name="name" data-maxlength="64" value="',h($L['name']),'" autocapitalize="off">
';
        if ($b == '' && ! $_POST) {
            echo
            script("focus(qs('#form')['name']);");
        }echo($Yb ? "<select name='Engine'>".optionlist(['' => '('.lang(166).')'] + $Yb, $L['Engine']).'</select>'.on_help('getTarget(event).value', 1).script("qsl('select').onchange = helpClose;") : ''),' ',($Xa && ! preg_match('~sqlite|mssql~', $z) ? html_select('Collation', ['' => '('.lang(95).')'] + $Xa, $L['Collation']) : ''),' <input type="submit" value="',lang(14),'">
';
    }echo'
';
    if (support('columns')) {
        echo'<div class="scrollable">
<table cellspacing="0" id="edit-fields" class="nowrap">
';
        $cb = ($_POST ? $_POST['comments'] : $L['Comment'] != '');
        if (! $_POST && ! $cb) {
            foreach ($L['fields']as$n) {
                if ($n['comment'] != '') {
                    $cb = true;
                    break;
                }
            }
        }edit_fields($L['fields'], $Xa, 'TABLE', $q, $cb);
        echo'</table>
</div>
<p>
',lang(47),': <input type="number" name="Auto_increment" size="6" value="',h($L['Auto_increment']),'">
',checkbox('defaults', 1, ! $_POST || $_POST['defaults'], lang(167), 'columnShow(this.checked, 5)', 'jsonly'),($_POST ? '' : script('editingHideDefaults();')),(support('comment') ? "<label><input type='checkbox' name='comments' value='1' class='jsonly'".($cb ? ' checked' : '').'>'.lang(46).'</label>'.script("qsl('input').onclick = partial(editingCommentsClick, true);").' <input name="Comment" value="'.h($L['Comment']).'" data-maxlength="'.(min_version(5.5) ? 2048 : 60).'"'.($cb ? '' : ' class="hidden"').'>' : ''),'<p>
<input type="submit" value="',lang(14),'">
';
    }echo'
';
    if ($b != '') {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, $b));
    }if (support('partitioning')) {
        $Ke = preg_match('~RANGE|LIST~', $L['partition_by']);
        print_fieldset('partition', lang(169), $L['partition_by']);
        echo'<p>
',"<select name='partition_by'>".optionlist(['' => ''] + $Je, $L['partition_by']).'</select>'.on_help("getTarget(event).value.replace(/./, 'PARTITION BY \$&')", 1).script("qsl('select').onchange = partitionByChange;"),'(<input name="partition" value="',h($L['partition']),'">)
',lang(170),': <input type="number" name="partitions" class="size',($Ke || ! $L['partition_by'] ? ' hidden' : ''),'" value="',h($L['partitions']),'">
<table cellspacing="0" id="partition-table"',($Ke ? '' : " class='hidden'"),'>
<thead><tr><th>',lang(171),'<th>',lang(172),'</thead>
';
        foreach ($L['partition_names']as$_ => $X) {
            echo'<tr>','<td><input name="partition_names[]" value="'.h($X).'" autocapitalize="off">',($_ == count($L['partition_names']) - 1 ? script("qsl('input').oninput = partitionNameChange;") : ''),'<td><input name="partition_values[]" value="'.h($L['partition_values'][$_]).'">';
        }echo'</table>
</div></fieldset>
';
    }echo'<input type="hidden" name="token" value="',$T,'">
</form>
',script("qs('#form')['defaults'].onclick();".(support('comment') ? " editingCommentsClick.call(qs('#form')['comments']);" : ''));
} elseif (isset($_GET['indexes'])) {
    $b = $_GET['indexes'];
    $Xc = ['PRIMARY', 'UNIQUE', 'INDEX'];
    $R = table_status($b, true);
    if (preg_match('~MyISAM|M?aria'.(min_version(5.6, '10.0.5') ? '|InnoDB' : '').'~i', $R['Engine'])) {
        $Xc[] = 'FULLTEXT';
    }if (preg_match('~MyISAM|M?aria'.(min_version(5.7, '10.2.2') ? '|InnoDB' : '').'~i', $R['Engine'])) {
        $Xc[] = 'SPATIAL';
    }$y = indexes($b);
    $af = [];
    if ($z == 'mongo') {
        $af = $y['_id_'];
        unset($Xc[0]);
        unset($y['_id_']);
    }$L = $_POST;
    if ($_POST && ! $m && ! $_POST['add'] && ! $_POST['drop_col']) {
        $sa = [];
        foreach ($L['indexes']as$x) {
            $F = $x['name'];
            if (in_array($x['type'], $Xc)) {
                $e = [];
                $zd = [];
                $Bb = [];
                $P = [];
                ksort($x['columns']);
                foreach ($x['columns']as$_ => $d) {
                    if ($d != '') {
                        $yd = $x['lengths'][$_];
                        $Ab = $x['descs'][$_];
                        $P[] = idf_escape($d).($yd ? '('.(+$yd).')' : '').($Ab ? ' DESC' : '');
                        $e[] = $d;
                        $zd[] = ($yd ? $yd : null);
                        $Bb[] = $Ab;
                    }
                }if ($e) {
                    $hc = $y[$F];
                    if ($hc) {
                        ksort($hc['columns']);
                        ksort($hc['lengths']);
                        ksort($hc['descs']);
                        if ($x['type'] == $hc['type'] && array_values($hc['columns']) === $e && (! $hc['lengths'] || array_values($hc['lengths']) === $zd) && array_values($hc['descs']) === $Bb) {
                            unset($y[$F]);

                            continue;
                        }
                    }$sa[] = [$x['type'], $F, $P];
                }
            }
        }foreach ($y
        as$F => $hc) {
            $sa[] = [$hc['type'], $F, 'DROP'];
        }if (! $sa) {
            redirect(ME.'table='.urlencode($b));
        }queries_redirect(ME.'table='.urlencode($b), lang(173), alter_indexes($b, $sa));
    }page_header(lang(125), $m, ['table' => $b], h($b));
    $o = array_keys(fields($b));
    if ($_POST['add']) {
        foreach ($L['indexes']as$_ => $x) {
            if ($x['columns'][count($x['columns'])] != '') {
                $L['indexes'][$_]['columns'][] = '';
            }
        }$x = end($L['indexes']);
        if ($x['type'] || array_filter($x['columns'], 'strlen')) {
            $L['indexes'][] = ['columns' => [1 => '']];
        }
    }if (! $L) {
        foreach ($y
        as$_ => $x) {
            $y[$_]['name'] = $_;
            $y[$_]['columns'][] = '';
        }$y[] = ['columns' => [1 => '']];
        $L['indexes'] = $y;
    }echo'
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
<thead><tr>
<th id="label-type">',lang(174),'<th><input type="submit" class="wayoff">',lang(175),'<th id="label-name">',lang(176),'<th><noscript>',"<input type='image' class='icon' name='add[0]' src='".h(preg_replace('~\\?.*~', '', ME).'?file=plus.gif&version=4.7.0')."' alt='+' title='".lang(102)."'>",'</noscript>
</thead>
';
    if ($af) {
        echo'<tr><td>PRIMARY<td>';
        foreach ($af['columns']as$_ => $d) {
            echo
            select_input(' disabled', $o, $d),"<label><input disabled type='checkbox'>".lang(55).'</label> ';
        }echo"<td><td>\n";
    }$jd = 1;
    foreach ($L['indexes']as$x) {
        if (! $_POST['drop_col'] || $jd != key($_POST['drop_col'])) {
            echo'<tr><td>'.html_select("indexes[$jd][type]", [-1 => ''] + $Xc, $x['type'], ($jd == count($L['indexes']) ? 'indexesAddRow.call(this);' : 1), 'label-type'),'<td>';
            ksort($x['columns']);
            $u = 1;
            foreach ($x['columns']as$_ => $d) {
                echo'<span>'.select_input(" name='indexes[$jd][columns][$u]' title='".lang(44)."'", ($o ? array_combine($o, $o) : $o), $d, 'partial('.($u == count($x['columns']) ? 'indexesAddColumn' : 'indexesChangeColumn').", '".js_escape($z == 'sql' ? '' : $_GET['indexes'].'_')."')"),($z == 'sql' || $z == 'mssql' ? "<input type='number' name='indexes[$jd][lengths][$u]' class='size' value='".h($x['lengths'][$_])."' title='".lang(100)."'>" : ''),(support('descidx') ? checkbox("indexes[$jd][descs][$u]", 1, $x['descs'][$_], lang(55)) : ''),' </span>';
                $u++;
            }echo"<td><input name='indexes[$jd][name]' value='".h($x['name'])."' autocapitalize='off' aria-labelledby='label-name'>\n","<td><input type='image' class='icon' name='drop_col[$jd]' src='".h(preg_replace('~\\?.*~', '', ME).'?file=cross.gif&version=4.7.0')."' alt='x' title='".lang(105)."'>".script("qsl('input').onclick = partial(editingRemoveRow, 'indexes\$1[type]');");
        }$jd++;
    }echo'</table>
</div>
<p>
<input type="submit" value="',lang(14),'">
<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET['database'])) {
    $L = $_POST;
    if ($_POST && ! $m && ! isset($_POST['add_x'])) {
        $F = trim($L['name']);
        if ($_POST['drop']) {
            $_GET['db'] = '';
            queries_redirect(remove_from_uri('db|database'), lang(177), drop_databases([DB]));
        } elseif (DB !== $F) {
            if (DB != '') {
                $_GET['db'] = $F;
                queries_redirect(preg_replace('~\bdb=[^&]*&~', '', ME).'db='.urlencode($F), lang(178), rename_database($F, $L['collation']));
            } else {
                $j = explode("\n", str_replace("\r", '', $F));
                $ig = true;
                $sd = '';
                foreach ($j
                as$k) {
                    if (count($j) == 1 || $k != '') {
                        if (! create_database($k, $L['collation'])) {
                            $ig = false;
                        }$sd = $k;
                    }
                }restart_session();
                set_session('dbs', null);
                queries_redirect(ME.'db='.urlencode($sd), lang(179), $ig);
            }
        } else {
            if (! $L['collation']) {
                redirect(substr(ME, 0, -1));
            }query_redirect('ALTER DATABASE '.idf_escape($F).(preg_match('~^[a-z0-9_]+$~i', $L['collation']) ? " COLLATE $L[collation]" : ''), substr(ME, 0, -1), lang(180));
        }
    }page_header(DB != '' ? lang(63) : lang(109), $m, [], h(DB));
    $Xa = collations();
    $F = DB;
    if ($_POST) {
        $F = $L['name'];
    } elseif (DB != '') {
        $L['collation'] = db_collation(DB, $Xa);
    } elseif ($z == 'sql') {
        foreach (get_vals('SHOW GRANTS')as$Dc) {
            if (preg_match('~ ON (`(([^\\\\`]|``|\\\\.)*)%`\.\*)?~', $Dc, $D) && $D[1]) {
                $F = stripcslashes(idf_unescape("`$D[2]`"));
                break;
            }
        }
    }echo'
<form action="" method="post">
<p>
',($_POST['add_x'] || strpos($F, "\n") ? '<textarea id="name" name="name" rows="10" cols="40">'.h($F).'</textarea><br>' : '<input name="name" id="name" value="'.h($F).'" data-maxlength="64" autocapitalize="off">')."\n".($Xa ? html_select('collation', ['' => '('.lang(95).')'] + $Xa, $L['collation']).doc_link(['sql' => 'charset-charsets.html', 'mariadb' => 'supported-character-sets-and-collations/', 'mssql' => 'ms187963.aspx']) : ''),script("focus(qs('#name'));"),'<input type="submit" value="',lang(14),'">
';
    if (DB != '') {
        echo"<input type='submit' name='drop' value='".lang(121)."'>".confirm(lang(168, DB))."\n";
    } elseif (! $_POST['add_x'] && $_GET['db'] == '') {
        echo"<input type='image' class='icon' name='add' src='".h(preg_replace('~\\?.*~', '', ME).'?file=plus.gif&version=4.7.0')."' alt='+' title='".lang(102)."'>\n";
    }echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET['call'])) {
    $ca = ($_GET['name'] ? $_GET['name'] : $_GET['call']);
    page_header(lang(181).': '.h($ca), $m);
    $Af = routine($_GET['call'], (isset($_GET['callf']) ? 'FUNCTION' : 'PROCEDURE'));
    $Wc = [];
    $Ce = [];
    foreach ($Af['fields']as$u => $n) {
        if (substr($n['inout'], -3) == 'OUT') {
            $Ce[$u] = '@'.idf_escape($n['field']).' AS '.idf_escape($n['field']);
        }if (! $n['inout'] || substr($n['inout'], 0, 2) == 'IN') {
            $Wc[] = $u;
        }
    }if (! $m && $_POST) {
        $Ja = [];
        foreach ($Af['fields']as$_ => $n) {
            if (in_array($_, $Wc)) {
                $X = process_input($n);
                if ($X === false) {
                    $X = "''";
                }if (isset($Ce[$_])) {
                    $g->query('SET @'.idf_escape($n['field'])." = $X");
                }
            }$Ja[] = (isset($Ce[$_]) ? '@'.idf_escape($n['field']) : $X);
        }$I = (isset($_GET['callf']) ? 'SELECT' : 'CALL').' '.table($ca).'('.implode(', ', $Ja).')';
        $bg = microtime(true);
        $J = $g->multi_query($I);
        $na = $g->affected_rows;
        echo$c->selectQuery($I, $bg, ! $J);
        if (! $J) {
            echo"<p class='error'>".error()."\n";
        } else {
            $h = connect();
            if (is_object($h)) {
                $h->select_db(DB);
            }do {
                $J = $g->store_result();
                if (is_object($J)) {
                    select($J, $h);
                } else {
                    echo"<p class='message'>".lang(182, $na)."\n";
                }
            } while ($g->next_result());
            if ($Ce) {
                select($g->query('SELECT '.implode(', ', $Ce)));
            }
        }
    }echo'
<form action="" method="post">
';
    if ($Wc) {
        echo"<table cellspacing='0' class='layout'>\n";
        foreach ($Wc
        as$_) {
            $n = $Af['fields'][$_];
            $F = $n['field'];
            echo'<tr><th>'.$c->fieldName($n);
            $Y = $_POST['fields'][$F];
            if ($Y != '') {
                if ($n['type'] == 'enum') {
                    $Y = +$Y;
                }if ($n['type'] == 'set') {
                    $Y = array_sum($Y);
                }
            }input($n, $Y, (string) $_POST['function'][$F]);
            echo"\n";
        }echo"</table>\n";
    }echo'<p>
<input type="submit" value="',lang(181),'">
<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET['foreign'])) {
    $b = $_GET['foreign'];
    $F = $_GET['name'];
    $L = $_POST;
    if ($_POST && ! $m && ! $_POST['add'] && ! $_POST['change'] && ! $_POST['change-js']) {
        $E = ($_POST['drop'] ? lang(183) : ($F != '' ? lang(184) : lang(185)));
        $C = ME.'table='.urlencode($b);
        if (! $_POST['drop']) {
            $L['source'] = array_filter($L['source'], 'strlen');
            ksort($L['source']);
            $vg = [];
            foreach ($L['source']as$_ => $X) {
                $vg[$_] = $L['target'][$_];
            }$L['target'] = $vg;
        }if ($z == 'sqlite') {
            queries_redirect($C, $E, recreate_table($b, $b, [], [], [" $F" => ($_POST['drop'] ? '' : ' '.format_foreign_key($L))]));
        } else {
            $sa = 'ALTER TABLE '.table($b);
            $Jb = "\nDROP ".($z == 'sql' ? 'FOREIGN KEY ' : 'CONSTRAINT ').idf_escape($F);
            if ($_POST['drop']) {
                query_redirect($sa.$Jb, $C, $E);
            } else {
                query_redirect($sa.($F != '' ? "$Jb," : '')."\nADD".format_foreign_key($L), $C, $E);
                $m = lang(186)."<br>$m";
            }
        }
    }page_header(lang(187), $m, ['table' => $b], h($b));
    if ($_POST) {
        ksort($L['source']);
        if ($_POST['add']) {
            $L['source'][] = '';
        } elseif ($_POST['change'] || $_POST['change-js']) {
            $L['target'] = [];
        }
    } elseif ($F != '') {
        $q = foreign_keys($b);
        $L = $q[$F];
        $L['source'][] = '';
    } else {
        $L['table'] = $b;
        $L['source'] = [''];
    }$Vf = array_keys(fields($b));
    $vg = ($b === $L['table'] ? $Vf : array_keys(fields($L['table'])));
    $pf = array_keys(array_filter(table_status('', true), 'fk_support'));
    echo'
<form action="" method="post">
<p>
';
    if ($L['db'] == '' && $L['ns'] == '') {
        echo
        lang(188),':
',html_select('table', $pf, $L['table'], "this.form['change-js'].value = '1'; this.form.submit();"),'<input type="hidden" name="change-js" value="">
<noscript><p><input type="submit" name="change" value="',lang(189),'"></noscript>
<table cellspacing="0">
<thead><tr><th id="label-source">',lang(127),'<th id="label-target">',lang(128),'</thead>
';
        $jd = 0;
        foreach ($L['source']as$_ => $X) {
            echo'<tr>','<td>'.html_select('source['.(+$_).']', [-1 => ''] + $Vf, $X, ($jd == count($L['source']) - 1 ? 'foreignAddRow.call(this);' : 1), 'label-source'),'<td>'.html_select('target['.(+$_).']', $vg, $L['target'][$_], 1, 'label-target');
            $jd++;
        }echo'</table>
<p>
',lang(97),': ',html_select('on_delete', [-1 => ''] + explode('|', $me), $L['on_delete']),' ',lang(96),': ',html_select('on_update', [-1 => ''] + explode('|', $me), $L['on_update']),doc_link(['sql' => 'innodb-foreign-key-constraints.html', 'mariadb' => 'foreign-keys/', 'pgsql' => 'sql-createtable.html#SQL-CREATETABLE-REFERENCES', 'mssql' => 'ms174979.aspx', 'oracle' => 'clauses002.htm#sthref2903']),'<p>
<input type="submit" value="',lang(14),'">
<noscript><p><input type="submit" name="add" value="',lang(190),'"></noscript>
';
    }if ($F != '') {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, $F));
    }echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET['view'])) {
    $b = $_GET['view'];
    $L = $_POST;
    $Ae = 'VIEW';
    if ($z == 'pgsql' && $b != '') {
        $cg = table_status($b);
        $Ae = strtoupper($cg['Engine']);
    }if ($_POST && ! $m) {
        $F = trim($L['name']);
        $ua = " AS\n$L[select]";
        $C = ME.'table='.urlencode($F);
        $E = lang(191);
        $U = ($_POST['materialized'] ? 'MATERIALIZED VIEW' : 'VIEW');
        if (! $_POST['drop'] && $b == $F && $z != 'sqlite' && $U == 'VIEW' && $Ae == 'VIEW') {
            query_redirect(($z == 'mssql' ? 'ALTER' : 'CREATE OR REPLACE').' VIEW '.table($F).$ua, $C, $E);
        } else {
            $xg = $F.'_adminer_'.uniqid();
            drop_create("DROP $Ae ".table($b), "CREATE $U ".table($F).$ua, "DROP $U ".table($F), "CREATE $U ".table($xg).$ua, "DROP $U ".table($xg), ($_POST['drop'] ? substr(ME, 0, -1) : $C), lang(192), $E, lang(193), $b, $F);
        }
    }if (! $_POST && $b != '') {
        $L = view($b);
        $L['name'] = $b;
        $L['materialized'] = ($Ae != 'VIEW');
        if (! $m) {
            $m = error();
        }
    }page_header(($b != '' ? lang(39) : lang(194)), $m, ['table' => $b], h($b));
    echo'
<form action="" method="post">
<p>',lang(176),': <input name="name" value="',h($L['name']),'" data-maxlength="64" autocapitalize="off">
',(support('materializedview') ? ' '.checkbox('materialized', 1, $L['materialized'], lang(122)) : ''),'<p>';
    textarea('select', $L['select']);
    echo'<p>
<input type="submit" value="',lang(14),'">
';
    if ($b != '') {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, $b));
    }echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET['event'])) {
    $aa = $_GET['event'];
    $cd = ['YEAR', 'QUARTER', 'MONTH', 'DAY', 'HOUR', 'MINUTE', 'WEEK', 'SECOND', 'YEAR_MONTH', 'DAY_HOUR', 'DAY_MINUTE', 'DAY_SECOND', 'HOUR_MINUTE', 'HOUR_SECOND', 'MINUTE_SECOND'];
    $dg = ['ENABLED' => 'ENABLE', 'DISABLED' => 'DISABLE', 'SLAVESIDE_DISABLED' => 'DISABLE ON SLAVE'];
    $L = $_POST;
    if ($_POST && ! $m) {
        if ($_POST['drop']) {
            query_redirect('DROP EVENT '.idf_escape($aa), substr(ME, 0, -1), lang(195));
        } elseif (in_array($L['INTERVAL_FIELD'], $cd) && isset($dg[$L['STATUS']])) {
            $Ef = "\nON SCHEDULE ".($L['INTERVAL_VALUE'] ? 'EVERY '.q($L['INTERVAL_VALUE'])." $L[INTERVAL_FIELD]".($L['STARTS'] ? ' STARTS '.q($L['STARTS']) : '').($L['ENDS'] ? ' ENDS '.q($L['ENDS']) : '') : 'AT '.q($L['STARTS'])).' ON COMPLETION'.($L['ON_COMPLETION'] ? '' : ' NOT').' PRESERVE';
            queries_redirect(substr(ME, 0, -1), ($aa != '' ? lang(196) : lang(197)), queries(($aa != '' ? 'ALTER EVENT '.idf_escape($aa).$Ef.($aa != $L['EVENT_NAME'] ? "\nRENAME TO ".idf_escape($L['EVENT_NAME']) : '') : 'CREATE EVENT '.idf_escape($L['EVENT_NAME']).$Ef)."\n".$dg[$L['STATUS']].' COMMENT '.q($L['EVENT_COMMENT']).rtrim(" DO\n$L[EVENT_DEFINITION]", ';').';'));
        }
    }page_header(($aa != '' ? lang(198).': '.h($aa) : lang(199)), $m);
    if (! $L && $aa != '') {
        $M = get_rows('SELECT * FROM information_schema.EVENTS WHERE EVENT_SCHEMA = '.q(DB).' AND EVENT_NAME = '.q($aa));
        $L = reset($M);
    }echo'
<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>',lang(176),'<td><input name="EVENT_NAME" value="',h($L['EVENT_NAME']),'" data-maxlength="64" autocapitalize="off">
<tr><th title="datetime">',lang(200),'<td><input name="STARTS" value="',h("$L[EXECUTE_AT]$L[STARTS]"),'">
<tr><th title="datetime">',lang(201),'<td><input name="ENDS" value="',h($L['ENDS']),'">
<tr><th>',lang(202),'<td><input type="number" name="INTERVAL_VALUE" value="',h($L['INTERVAL_VALUE']),'" class="size"> ',html_select('INTERVAL_FIELD', $cd, $L['INTERVAL_FIELD']),'<tr><th>',lang(112),'<td>',html_select('STATUS', $dg, $L['STATUS']),'<tr><th>',lang(46),'<td><input name="EVENT_COMMENT" value="',h($L['EVENT_COMMENT']),'" data-maxlength="64">
<tr><th><td>',checkbox('ON_COMPLETION', 'PRESERVE', $L['ON_COMPLETION'] == 'PRESERVE', lang(203)),'</table>
<p>';
    textarea('EVENT_DEFINITION', $L['EVENT_DEFINITION']);
    echo'<p>
<input type="submit" value="',lang(14),'">
';
    if ($aa != '') {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, $aa));
    }echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET['procedure'])) {
    $ca = ($_GET['name'] ? $_GET['name'] : $_GET['procedure']);
    $Af = (isset($_GET['function']) ? 'FUNCTION' : 'PROCEDURE');
    $L = $_POST;
    $L['fields'] = (array) $L['fields'];
    if ($_POST && ! process_fields($L['fields']) && ! $m) {
        $ye = routine($_GET['procedure'], $Af);
        $xg = "$L[name]_adminer_".uniqid();
        drop_create("DROP $Af ".routine_id($ca, $ye), create_routine($Af, $L), "DROP $Af ".routine_id($L['name'], $L), create_routine($Af, ['name' => $xg] + $L), "DROP $Af ".routine_id($xg, $L), substr(ME, 0, -1), lang(204), lang(205), lang(206), $ca, $L['name']);
    }page_header(($ca != '' ? (isset($_GET['function']) ? lang(207) : lang(208)).': '.h($ca) : (isset($_GET['function']) ? lang(209) : lang(210))), $m);
    if (! $_POST && $ca != '') {
        $L = routine($_GET['procedure'], $Af);
        $L['name'] = $ca;
    }$Xa = get_vals('SHOW CHARACTER SET');
    sort($Xa);
    $Bf = routine_languages();
    echo'
<form action="" method="post" id="form">
<p>',lang(176),': <input name="name" value="',h($L['name']),'" data-maxlength="64" autocapitalize="off">
',($Bf ? lang(19).': '.html_select('language', $Bf, $L['language'])."\n" : ''),'<input type="submit" value="',lang(14),'">
<div class="scrollable">
<table cellspacing="0" class="nowrap">
';
    edit_fields($L['fields'], $Xa, $Af);
    if (isset($_GET['function'])) {
        echo'<tr><td>'.lang(211);
        edit_type('returns', $L['returns'], $Xa, [], ($z == 'pgsql' ? ['void', 'trigger'] : []));
    }echo'</table>
</div>
<p>';
    textarea('definition', $L['definition']);
    echo'<p>
<input type="submit" value="',lang(14),'">
';
    if ($ca != '') {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, $ca));
    }echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET['trigger'])) {
    $b = $_GET['trigger'];
    $F = $_GET['name'];
    $Qg = trigger_options();
    $L = (array) trigger($F) + ['Trigger' => $b.'_bi'];
    if ($_POST) {
        if (! $m && in_array($_POST['Timing'], $Qg['Timing']) && in_array($_POST['Event'], $Qg['Event']) && in_array($_POST['Type'], $Qg['Type'])) {
            $le = ' ON '.table($b);
            $Jb = 'DROP TRIGGER '.idf_escape($F).($z == 'pgsql' ? $le : '');
            $C = ME.'table='.urlencode($b);
            if ($_POST['drop']) {
                query_redirect($Jb, $C, lang(212));
            } else {
                if ($F != '') {
                    queries($Jb);
                }queries_redirect($C, ($F != '' ? lang(213) : lang(214)), queries(create_trigger($le, $_POST)));
                if ($F != '') {
                    queries(create_trigger($le, $L + ['Type' => reset($Qg['Type'])]));
                }
            }
        }$L = $_POST;
    }page_header(($F != '' ? lang(215).': '.h($F) : lang(216)), $m, ['table' => $b]);
    echo'
<form action="" method="post" id="form">
<table cellspacing="0" class="layout">
<tr><th>',lang(217),'<td>',html_select('Timing', $Qg['Timing'], $L['Timing'], 'triggerChange(/^'.preg_quote($b, '/')."_[ba][iud]$/, '".js_escape($b)."', this.form);"),'<tr><th>',lang(218),'<td>',html_select('Event', $Qg['Event'], $L['Event'], "this.form['Timing'].onchange();"),(in_array('UPDATE OF', $Qg['Event']) ? " <input name='Of' value='".h($L['Of'])."' class='hidden'>" : ''),'<tr><th>',lang(45),'<td>',html_select('Type', $Qg['Type'], $L['Type']),'</table>
<p>',lang(176),': <input name="Trigger" value="',h($L['Trigger']),'" data-maxlength="64" autocapitalize="off">
',script("qs('#form')['Timing'].onchange();"),'<p>';
    textarea('Statement', $L['Statement']);
    echo'<p>
<input type="submit" value="',lang(14),'">
';
    if ($F != '') {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, $F));
    }echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET['user'])) {
    $ea = $_GET['user'];
    $ef = ['' => ['All privileges' => '']];
    foreach (get_rows('SHOW PRIVILEGES')as$L) {
        foreach (explode(',', ($L['Privilege'] == 'Grant option' ? '' : $L['Context']))as$hb) {
            $ef[$hb][$L['Privilege']] = $L['Comment'];
        }
    }$ef['Server Admin'] += $ef['File access on server'];
    $ef['Databases']['Create routine'] = $ef['Procedures']['Create routine'];
    unset($ef['Procedures']['Create routine']);
    $ef['Columns'] = [];
    foreach (['Select', 'Insert', 'Update', 'References']as$X) {
        $ef['Columns'][$X] = $ef['Tables'][$X];
    }unset($ef['Server Admin']['Usage']);
    foreach ($ef['Tables']as$_ => $X) {
        unset($ef['Databases'][$_]);
    }$Xd = [];
    if ($_POST) {
        foreach ($_POST['objects']as$_ => $X) {
            $Xd[$X] = (array) $Xd[$X] + (array) $_POST['grants'][$_];
        }
    }$Ec = [];
    $je = '';
    if (isset($_GET['host']) && ($J = $g->query('SHOW GRANTS FOR '.q($ea).'@'.q($_GET['host'])))) {
        while ($L = $J->fetch_row()) {
            if (preg_match('~GRANT (.*) ON (.*) TO ~', $L[0], $D) && preg_match_all('~ *([^(,]*[^ ,(])( *\([^)]+\))?~', $D[1], $Fd, PREG_SET_ORDER)) {
                foreach ($Fd
                as$X) {
                    if ($X[1] != 'USAGE') {
                        $Ec["$D[2]$X[2]"][$X[1]] = true;
                    }if (preg_match('~ WITH GRANT OPTION~', $L[0])) {
                        $Ec["$D[2]$X[2]"]['GRANT OPTION'] = true;
                    }
                }
            }if (preg_match("~ IDENTIFIED BY PASSWORD '([^']+)~", $L[0], $D)) {
                $je = $D[1];
            }
        }
    }if ($_POST && ! $m) {
        $ke = (isset($_GET['host']) ? q($ea).'@'.q($_GET['host']) : "''");
        if ($_POST['drop']) {
            query_redirect("DROP USER $ke", ME.'privileges=', lang(219));
        } else {
            $Zd = q($_POST['user']).'@'.q($_POST['host']);
            $Ne = $_POST['pass'];
            if ($Ne != '' && ! $_POST['hashed']) {
                $Ne = $g->result('SELECT PASSWORD('.q($Ne).')');
                $m = ! $Ne;
            }$lb = false;
            if (! $m) {
                if ($ke != $Zd) {
                    $lb = queries((min_version(5) ? 'CREATE USER' : 'GRANT USAGE ON *.* TO')." $Zd IDENTIFIED BY PASSWORD ".q($Ne));
                    $m = ! $lb;
                } elseif ($Ne != $je) {
                    queries("SET PASSWORD FOR $Zd = ".q($Ne));
                }
            }if (! $m) {
                $yf = [];
                foreach ($Xd
                as$ee => $Dc) {
                    if (isset($_GET['grant'])) {
                        $Dc = array_filter($Dc);
                    }$Dc = array_keys($Dc);
                    if (isset($_GET['grant'])) {
                        $yf = array_diff(array_keys(array_filter($Xd[$ee], 'strlen')), $Dc);
                    } elseif ($ke == $Zd) {
                        $he = array_keys((array) $Ec[$ee]);
                        $yf = array_diff($he, $Dc);
                        $Dc = array_diff($Dc, $he);
                        unset($Ec[$ee]);
                    }if (preg_match('~^(.+)\s*(\(.*\))?$~U', $ee, $D) && (! grant('REVOKE', $yf, $D[2], " ON $D[1] FROM $Zd") || ! grant('GRANT', $Dc, $D[2], " ON $D[1] TO $Zd"))) {
                        $m = true;
                        break;
                    }
                }
            }if (! $m && isset($_GET['host'])) {
                if ($ke != $Zd) {
                    queries("DROP USER $ke");
                } elseif (! isset($_GET['grant'])) {
                    foreach ($Ec
                    as$ee => $yf) {
                        if (preg_match('~^(.+)(\(.*\))?$~U', $ee, $D)) {
                            grant('REVOKE', array_keys($yf), $D[2], " ON $D[1] FROM $Zd");
                        }
                    }
                }
            }queries_redirect(ME.'privileges=', (isset($_GET['host']) ? lang(220) : lang(221)), ! $m);
            if ($lb) {
                $g->query("DROP USER $Zd");
            }
        }
    }page_header((isset($_GET['host']) ? lang(31).': '.h("$ea@$_GET[host]") : lang(139)), $m, ['privileges' => ['', lang(67)]]);
    if ($_POST) {
        $L = $_POST;
        $Ec = $Xd;
    } else {
        $L = $_GET + ['host' => $g->result("SELECT SUBSTRING_INDEX(CURRENT_USER, '@', -1)")];
        $L['pass'] = $je;
        if ($je != '') {
            $L['hashed'] = true;
        }$Ec[(DB == '' || $Ec ? '' : idf_escape(addcslashes(DB, '%_\\'))).'.*'] = [];
    }echo'<form action="" method="post">
<table cellspacing="0" class="layout">
<tr><th>',lang(30),'<td><input name="host" data-maxlength="60" value="',h($L['host']),'" autocapitalize="off">
<tr><th>',lang(31),'<td><input name="user" data-maxlength="80" value="',h($L['user']),'" autocapitalize="off">
<tr><th>',lang(32),'<td><input name="pass" id="pass" value="',h($L['pass']),'" autocomplete="new-password">
';
    if (! $L['hashed']) {
        echo
        script("typePassword(qs('#pass'));");
    }echo
    checkbox('hashed', 1, $L['hashed'], lang(222), "typePassword(this.form['pass'], this.checked);"),'</table>

';
    echo"<table cellspacing='0'>\n","<thead><tr><th colspan='2'>".lang(67).doc_link(['sql' => 'grant.html#priv_level']);
    $u = 0;
    foreach ($Ec
    as$ee => $Dc) {
        echo'<th>'.($ee != '*.*' ? "<input name='objects[$u]' value='".h($ee)."' size='10' autocapitalize='off'>" : "<input type='hidden' name='objects[$u]' value='*.*' size='10'>*.*");
        $u++;
    }echo"</thead>\n";
    foreach (['' => '', 'Server Admin' => lang(30), 'Databases' => lang(33), 'Tables' => lang(124), 'Columns' => lang(44), 'Procedures' => lang(223)]as$hb => $Ab) {
        foreach ((array) $ef[$hb]as$df => $bb) {
            echo'<tr'.odd().'><td'.($Ab ? ">$Ab<td" : " colspan='2'").' lang="en" title="'.h($bb).'">'.h($df);
            $u = 0;
            foreach ($Ec
            as$ee => $Dc) {
                $F = "'grants[$u][".h(strtoupper($df))."]'";
                $Y = $Dc[strtoupper($df)];
                if ($hb == 'Server Admin' && $ee != (isset($Ec['*.*']) ? '*.*' : '.*')) {
                    echo'<td>';
                } elseif (isset($_GET['grant'])) {
                    echo"<td><select name=$F><option><option value='1'".($Y ? ' selected' : '').'>'.lang(224)."<option value='0'".($Y == '0' ? ' selected' : '').'>'.lang(225).'</select>';
                } else {
                    echo"<td align='center'><label class='block'>","<input type='checkbox' name=$F value='1'".($Y ? ' checked' : '').($df == 'All privileges' ? " id='grants-$u-all'>" : '>'.($df == 'Grant option' ? '' : script("qsl('input').onclick = function () { if (this.checked) formUncheck('grants-$u-all'); };"))),'</label>';
                }$u++;
            }
        }
    }echo"</table>\n",'<p>
<input type="submit" value="',lang(14),'">
';
    if (isset($_GET['host'])) {
        echo'<input type="submit" name="drop" value="',lang(121),'">',confirm(lang(168, "$ea@$_GET[host]"));
    }echo'<input type="hidden" name="token" value="',$T,'">
</form>
';
} elseif (isset($_GET['processlist'])) {
    if (support('kill') && $_POST && ! $m) {
        $nd = 0;
        foreach ((array) $_POST['kill']as$X) {
            if (kill_process($X)) {
                $nd++;
            }
        }queries_redirect(ME.'processlist=', lang(226, $nd), $nd || ! $_POST['kill']);
    }page_header(lang(110), $m);
    echo'
<form action="" method="post">
<div class="scrollable">
<table cellspacing="0" class="nowrap checkable">
',script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});");
    $u = -1;
    foreach (process_list()as$u => $L) {
        if (! $u) {
            echo"<thead><tr lang='en'>".(support('kill') ? '<th>' : '');
            foreach ($L
            as$_ => $X) {
                echo"<th>$_".doc_link(['sql' => 'show-processlist.html#processlist_'.strtolower($_), 'pgsql' => 'monitoring-stats.html#PG-STAT-ACTIVITY-VIEW', 'oracle' => '../b14237/dynviews_2088.htm']);
            }echo"</thead>\n";
        }echo'<tr'.odd().'>'.(support('kill') ? '<td>'.checkbox('kill[]', $L[$z == 'sql' ? 'Id' : 'pid'], 0) : '');
        foreach ($L
        as$_ => $X) {
            echo'<td>'.(($z == 'sql' && $_ == 'Info' && preg_match('~Query|Killed~', $L['Command']) && $X != '') || ($z == 'pgsql' && $_ == 'current_query' && $X != '<IDLE>') || ($z == 'oracle' && $_ == 'sql_text' && $X != '') ? "<code class='jush-$z'>".shorten_utf8($X, 100, '</code>').' <a href="'.h(ME.($L['db'] != '' ? 'db='.urlencode($L['db']).'&' : '').'sql='.urlencode($X)).'">'.lang(227).'</a>' : h($X));
        }echo"\n";
    }echo'</table>
</div>
<p>
';
    if (support('kill')) {
        echo($u + 1).'/'.lang(228, max_connections()),"<p><input type='submit' value='".lang(229)."'>\n";
    }echo'<input type="hidden" name="token" value="',$T,'">
</form>
',script('tableCheck();');
} elseif (isset($_GET['select'])) {
    $b = $_GET['select'];
    $R = table_status1($b);
    $y = indexes($b);
    $o = fields($b);
    $q = column_foreign_keys($b);
    $ge = $R['Oid'];
    parse_str($_COOKIE['adminer_import'], $ma);
    $zf = [];
    $e = [];
    $_g = null;
    foreach ($o
    as$_ => $n) {
        $F = $c->fieldName($n);
        if (isset($n['privileges']['select']) && $F != '') {
            $e[$_] = html_entity_decode(strip_tags($F), ENT_QUOTES);
            if (is_shortable($n)) {
                $_g = $c->selectLengthProcess();
            }
        }$zf += $n['privileges'];
    }[$N, $t] = $c->selectColumnsProcess($e, $y);
    $gd = count($t) < count($N);
    $Z = $c->selectSearchProcess($o, $y);
    $ue = $c->selectOrderProcess($o, $y);
    $A = $c->selectLimitProcess();
    if ($_GET['val'] && is_ajax()) {
        header('Content-Type: text/plain; charset=utf-8');
        foreach ($_GET['val']as$Yg => $L) {
            $ua = convert_field($o[key($L)]);
            $N = [$ua ? $ua : idf_escape(key($L))];
            $Z[] = where_check($Yg, $o);
            $K = $l->select($b, $N, $Z, $N);
            if ($K) {
                echo
                reset($K->fetch_row());
            }
        }exit;
    }$af = $ah = null;
    foreach ($y
    as$x) {
        if ($x['type'] == 'PRIMARY') {
            $af = array_flip($x['columns']);
            $ah = ($N ? $af : []);
            foreach ($ah
            as$_ => $X) {
                if (in_array(idf_escape($_), $N)) {
                    unset($ah[$_]);
                }
            }break;
        }
    }if ($ge && ! $af) {
        $af = $ah = [$ge => 0];
        $y[] = ['type' => 'PRIMARY', 'columns' => [$ge]];
    }if ($_POST && ! $m) {
        $vh = $Z;
        if (! $_POST['all'] && is_array($_POST['check'])) {
            $Oa = [];
            foreach ($_POST['check']as$Ma) {
                $Oa[] = where_check($Ma, $o);
            }$vh[] = '(('.implode(') OR (', $Oa).'))';
        }$vh = ($vh ? "\nWHERE ".implode(' AND ', $vh) : '');
        if ($_POST['export']) {
            cookie('adminer_import', 'output='.urlencode($_POST['output']).'&format='.urlencode($_POST['format']));
            dump_headers($b);
            $c->dumpTable($b, '');
            $Bc = ($N ? implode(', ', $N) : '*').convert_fields($e, $o, $N)."\nFROM ".table($b);
            $Gc = ($t && $gd ? "\nGROUP BY ".implode(', ', $t) : '').($ue ? "\nORDER BY ".implode(', ', $ue) : '');
            if (! is_array($_POST['check']) || $af) {
                $I = "SELECT $Bc$vh$Gc";
            } else {
                $Wg = [];
                foreach ($_POST['check']as$X) {
                    $Wg[] = '(SELECT'.limit($Bc, "\nWHERE ".($Z ? implode(' AND ', $Z).' AND ' : '').where_check($X, $o).$Gc, 1).')';
                }$I = implode(' UNION ALL ', $Wg);
            }$c->dumpData($b, 'table', $I);
            exit;
        }if (! $c->selectEmailProcess($Z, $q)) {
            if ($_POST['save'] || $_POST['delete']) {
                $J = true;
                $na = 0;
                $P = [];
                if (! $_POST['delete']) {
                    foreach ($e
                    as$F => $X) {
                        $X = process_input($o[$F]);
                        if ($X !== null && ($_POST['clone'] || $X !== false)) {
                            $P[idf_escape($F)] = ($X !== false ? $X : idf_escape($F));
                        }
                    }
                }if ($_POST['delete'] || $P) {
                    if ($_POST['clone']) {
                        $I = 'INTO '.table($b).' ('.implode(', ', array_keys($P)).")\nSELECT ".implode(', ', $P)."\nFROM ".table($b);
                    }if ($_POST['all'] || ($af && is_array($_POST['check'])) || $gd) {
                        $J = ($_POST['delete'] ? $l->delete($b, $vh) : ($_POST['clone'] ? queries("INSERT $I$vh") : $l->update($b, $P, $vh)));
                        $na = $g->affected_rows;
                    } else {
                        foreach ((array) $_POST['check']as$X) {
                            $uh = "\nWHERE ".($Z ? implode(' AND ', $Z).' AND ' : '').where_check($X, $o);
                            $J = ($_POST['delete'] ? $l->delete($b, $uh, 1) : ($_POST['clone'] ? queries('INSERT'.limit1($b, $I, $uh)) : $l->update($b, $P, $uh, 1)));
                            if (! $J) {
                                break;
                            }$na += $g->affected_rows;
                        }
                    }
                }$E = lang(230, $na);
                if ($_POST['clone'] && $J && $na == 1) {
                    $td = last_id();
                    if ($td) {
                        $E = lang(161, " $td");
                    }
                }queries_redirect(remove_from_uri($_POST['all'] && $_POST['delete'] ? 'page' : ''), $E, $J);
                if (! $_POST['delete']) {
                    edit_form($b, $o, (array) $_POST['fields'], ! $_POST['clone']);
                    page_footer();
                    exit;
                }
            } elseif (! $_POST['import']) {
                if (! $_POST['val']) {
                    $m = lang(231);
                } else {
                    $J = true;
                    $na = 0;
                    foreach ($_POST['val']as$Yg => $L) {
                        $P = [];
                        foreach ($L
                        as$_ => $X) {
                            $_ = bracket_escape($_, 1);
                            $P[idf_escape($_)] = (preg_match('~char|text~', $o[$_]['type']) || $X != '' ? $c->processInput($o[$_], $X) : 'NULL');
                        }$J = $l->update($b, $P, ' WHERE '.($Z ? implode(' AND ', $Z).' AND ' : '').where_check($Yg, $o), ! $gd && ! $af, ' ');
                        if (! $J) {
                            break;
                        }$na += $g->affected_rows;
                    }queries_redirect(remove_from_uri(), lang(230, $na), $J);
                }
            } elseif (! is_string($rc = get_file('csv_file', true))) {
                $m = upload_error($rc);
            } elseif (! preg_match('~~u', $rc)) {
                $m = lang(232);
            } else {
                cookie('adminer_import', 'output='.urlencode($ma['output']).'&format='.urlencode($_POST['separator']));
                $J = true;
                $Ya = array_keys($o);
                preg_match_all('~(?>"[^"]*"|[^"\r\n]+)+~', $rc, $Fd);
                $na = count($Fd[0]);
                $l->begin();
                $Mf = ($_POST['separator'] == 'csv' ? ',' : ($_POST['separator'] == 'tsv' ? "\t" : ';'));
                $M = [];
                foreach ($Fd[0]as$_ => $X) {
                    preg_match_all("~((?>\"[^\"]*\")+|[^$Mf]*)$Mf~", $X.$Mf, $Gd);
                    if (! $_ && ! array_diff($Gd[1], $Ya)) {
                        $Ya = $Gd[1];
                        $na--;
                    } else {
                        $P = [];
                        foreach ($Gd[1]as$u => $Ua) {
                            $P[idf_escape($Ya[$u])] = ($Ua == '' && $o[$Ya[$u]]['null'] ? 'NULL' : q(str_replace('""', '"', preg_replace('~^"|"$~', '', $Ua))));
                        }$M[] = $P;
                    }
                }$J = (! $M || $l->insertUpdate($b, $M, $af));
                if ($J) {
                    $J = $l->commit();
                }queries_redirect(remove_from_uri('page'), lang(233, $na), $J);
                $l->rollback();
            }
        }
    }$og = $c->tableName($R);
    if (is_ajax()) {
        page_headers();
        ob_start();
    } else {
        page_header(lang(49).": $og", $m);
    }$P = null;
    if (isset($zf['insert']) || ! support('table')) {
        $P = '';
        foreach ((array) $_GET['where']as$X) {
            if ($q[$X['col']] && count($q[$X['col']]) == 1 && ($X['op'] == '=' || (! $X['op'] && ! preg_match('~[_%]~', $X['val'])))) {
                $P .= '&set'.urlencode('['.bracket_escape($X['col']).']').'='.urlencode($X['val']);
            }
        }
    }$c->selectLinks($R, $P);
    if (! $e && support('table')) {
        echo"<p class='error'>".lang(234).($o ? '.' : ': '.error())."\n";
    } else {
        echo"<form action='' id='form'>\n","<div style='display: none;'>";
        hidden_fields_get();
        echo DB != '' ? '<input type="hidden" name="db" value="'.h(DB).'">'.(isset($_GET['ns']) ? '<input type="hidden" name="ns" value="'.h($_GET['ns']).'">' : '') : '';
        echo'<input type="hidden" name="select" value="'.h($b).'">',"</div>\n";
        $c->selectColumnsPrint($N, $e);
        $c->selectSearchPrint($Z, $e, $y);
        $c->selectOrderPrint($ue, $e, $y);
        $c->selectLimitPrint($A);
        $c->selectLengthPrint($_g);
        $c->selectActionPrint($y);
        echo"</form>\n";
        $G = $_GET['page'];
        if ($G == 'last') {
            $Ac = $g->result(count_rows($b, $Z, $gd, $t));
            $G = floor(max(0, $Ac - 1) / $A);
        }$Hf = $N;
        $Fc = $t;
        if (! $Hf) {
            $Hf[] = '*';
            $ib = convert_fields($e, $o, $N);
            if ($ib) {
                $Hf[] = substr($ib, 2);
            }
        }foreach ($N
        as$_ => $X) {
            $n = $o[idf_unescape($X)];
            if ($n && ($ua = convert_field($n))) {
                $Hf[$_] = "$ua AS $X";
            }
        }if (! $gd && $ah) {
            foreach ($ah
            as$_ => $X) {
                $Hf[] = idf_escape($_);
                if ($Fc) {
                    $Fc[] = idf_escape($_);
                }
            }
        }$J = $l->select($b, $Hf, $Z, $Fc, $ue, $A, $G, true);
        if (! $J) {
            echo"<p class='error'>".error()."\n";
        } else {
            if ($z == 'mssql' && $G) {
                $J->seek($A * $G);
            }$Vb = [];
            echo"<form action='' method='post' enctype='multipart/form-data'>\n";
            $M = [];
            while ($L = $J->fetch_assoc()) {
                if ($G && $z == 'oracle') {
                    unset($L['RNUM']);
                }$M[] = $L;
            }if ($_GET['page'] != 'last' && $A != '' && $t && $gd && $z == 'sql') {
                $Ac = $g->result(' SELECT FOUND_ROWS()');
            }if (! $M) {
                echo"<p class='message'>".lang(12)."\n";
            } else {
                $Ba = $c->backwardKeys($b, $og);
                echo"<div class='scrollable'>","<table id='table' cellspacing='0' class='nowrap checkable'>",script("mixin(qs('#table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true), onkeydown: editingKeydown});"),'<thead><tr>'.(! $t && $N ? '' : "<td><input type='checkbox' id='all-page' class='jsonly'>".script("qs('#all-page').onclick = partial(formCheck, /check/);", '')." <a href='".h($_GET['modify'] ? remove_from_uri('modify') : $_SERVER['REQUEST_URI'].'&modify=1')."'>".lang(235).'</a>');
                $Wd = [];
                $Cc = [];
                reset($N);
                $mf = 1;
                foreach ($M[0]as$_ => $X) {
                    if (! isset($ah[$_])) {
                        $X = $_GET['columns'][key($N)];
                        $n = $o[$N ? ($X ? $X['col'] : current($N)) : $_];
                        $F = ($n ? $c->fieldName($n, $mf) : ($X['fun'] ? '*' : $_));
                        if ($F != '') {
                            $mf++;
                            $Wd[$_] = $F;
                            $d = idf_escape($_);
                            $Sc = remove_from_uri('(order|desc)[^=]*|page').'&order%5B0%5D='.urlencode($_);
                            $Ab = '&desc%5B0%5D=1';
                            echo'<th>'.script("mixin(qsl('th'), {onmouseover: partial(columnMouse), onmouseout: partial(columnMouse, ' hidden')});", ''),'<a href="'.h($Sc.($ue[0] == $d || $ue[0] == $_ || (! $ue && $gd && $t[0] == $d) ? $Ab : '')).'">';
                            echo
                            apply_sql_function($X['fun'], $F).'</a>';
                            echo"<span class='column hidden'>","<a href='".h($Sc.$Ab)."' title='".lang(55)."' class='text'> ↓</a>";
                            if (! $X['fun']) {
                                echo'<a href="#fieldset-search" title="'.lang(52).'" class="text jsonly"> =</a>',script("qsl('a').onclick = partial(selectSearch, '".js_escape($_)."');");
                            }echo'</span>';
                        }$Cc[$_] = $X['fun'];
                        next($N);
                    }
                }$zd = [];
                if ($_GET['modify']) {
                    foreach ($M
                    as$L) {
                        foreach ($L
                        as$_ => $X) {
                            $zd[$_] = max($zd[$_], min(40, strlen(utf8_decode($X))));
                        }
                    }
                }echo($Ba ? '<th>'.lang(236) : '')."</thead>\n";
                if (is_ajax()) {
                    if ($A % 2 == 1 && $G % 2 == 1) {
                        odd();
                    }ob_end_clean();
                }foreach ($c->rowDescriptions($M, $q)as$Vd => $L) {
                    $Xg = unique_array($M[$Vd], $y);
                    if (! $Xg) {
                        $Xg = [];
                        foreach ($M[$Vd]as$_ => $X) {
                            if (! preg_match('~^(COUNT\((\*|(DISTINCT )?`(?:[^`]|``)+`)\)|(AVG|GROUP_CONCAT|MAX|MIN|SUM)\(`(?:[^`]|``)+`\))$~', $_)) {
                                $Xg[$_] = $X;
                            }
                        }
                    }$Yg = '';
                    foreach ($Xg
                    as$_ => $X) {
                        if (($z == 'sql' || $z == 'pgsql') && preg_match('~char|text|enum|set~', $o[$_]['type']) && strlen($X) > 64) {
                            $_ = (strpos($_, '(') ? $_ : idf_escape($_));
                            $_ = 'MD5('.($z != 'sql' || preg_match('~^utf8~', $o[$_]['collation']) ? $_ : "CONVERT($_ USING ".charset($g).')').')';
                            $X = md5($X);
                        }$Yg .= '&'.($X !== null ? urlencode('where['.bracket_escape($_).']').'='.urlencode($X) : 'null%5B%5D='.urlencode($_));
                    }echo'<tr'.odd().'>'.(! $t && $N ? '' : '<td>'.checkbox('check[]', substr($Yg, 1), in_array(substr($Yg, 1), (array) $_POST['check'])).($gd || information_schema(DB) ? '' : " <a href='".h(ME.'edit='.urlencode($b).$Yg)."' class='edit'>".lang(237).'</a>'));
                    foreach ($L
                    as$_ => $X) {
                        if (isset($Wd[$_])) {
                            $n = $o[$_];
                            $X = $l->value($X, $n);
                            if ($X != '' && (! isset($Vb[$_]) || $Vb[$_] != '')) {
                                $Vb[$_] = (is_mail($X) ? $Wd[$_] : '');
                            }$B = '';
                            if (preg_match('~blob|bytea|raw|file~', $n['type']) && $X != '') {
                                $B = ME.'download='.urlencode($b).'&field='.urlencode($_).$Yg;
                            }if (! $B && $X !== null) {
                                foreach ((array) $q[$_]as$p) {
                                    if (count($q[$_]) == 1 || end($p['source']) == $_) {
                                        $B = '';
                                        foreach ($p['source']as$u => $Vf) {
                                            $B .= where_link($u, $p['target'][$u], $M[$Vd][$Vf]);
                                        }$B = ($p['db'] != '' ? preg_replace('~([?&]db=)[^&]+~', '\1'.urlencode($p['db']), ME) : ME).'select='.urlencode($p['table']).$B;
                                        if ($p['ns']) {
                                            $B = preg_replace('~([?&]ns=)[^&]+~', '\1'.urlencode($p['ns']), $B);
                                        }if (count($p['source']) == 1) {
                                            break;
                                        }
                                    }
                                }
                            }if ($_ == 'COUNT(*)') {
                                $B = ME.'select='.urlencode($b);
                                $u = 0;
                                foreach ((array) $_GET['where']as$W) {
                                    if (! array_key_exists($W['col'], $Xg)) {
                                        $B .= where_link($u++, $W['col'], $W['val'], $W['op']);
                                    }
                                }foreach ($Xg
                                as$kd => $W) {
                                    $B .= where_link($u++, $kd, $W);
                                }
                            }$X = select_value($X, $B, $n, $_g);
                            $v = h("val[$Yg][".bracket_escape($_).']');
                            $Y = $_POST['val'][$Yg][bracket_escape($_)];
                            $Qb = ! is_array($L[$_]) && is_utf8($X) && $M[$Vd][$_] == $L[$_] && ! $Cc[$_];
                            $zg = preg_match('~text|lob~', $n['type']);
                            if (($_GET['modify'] && $Qb) || $Y !== null) {
                                $Jc = h($Y !== null ? $Y : $L[$_]);
                                echo'<td>'.($zg ? "<textarea name='$v' cols='30' rows='".(substr_count($L[$_], "\n") + 1)."'>$Jc</textarea>" : "<input name='$v' value='$Jc' size='$zd[$_]'>");
                            } else {
                                $Cd = strpos($X, '<i>...</i>');
                                echo"<td id='$v' data-text='".($Cd ? 2 : ($zg ? 1 : 0))."'".($Qb ? '' : " data-warning='".h(lang(238))."'").">$X</td>";
                            }
                        }
                    }if ($Ba) {
                        echo'<td>';
                    }$c->backwardKeysPrint($Ba, $M[$Vd]);
                    echo"</tr>\n";
                }if (is_ajax()) {
                    exit;
                }echo"</table>\n","</div>\n";
            }if (! is_ajax()) {
                if ($M || $G) {
                    $fc = true;
                    if ($_GET['page'] != 'last') {
                        if ($A == '' || (count($M) < $A && ($M || ! $G))) {
                            $Ac = ($G ? $G * $A : 0) + count($M);
                        } elseif ($z != 'sql' || ! $gd) {
                            $Ac = ($gd ? false : found_rows($R, $Z));
                            if ($Ac < max(1e4, 2 * ($G + 1) * $A)) {
                                $Ac = reset(slow_query(count_rows($b, $Z, $gd, $t)));
                            } else {
                                $fc = false;
                            }
                        }
                    }$Fe = ($A != '' && ($Ac === false || $Ac > $A || $G));
                    if ($Fe) {
                        echo(($Ac === false ? count($M) + 1 : $Ac - $G * $A) > $A ? '<p><a href="'.h(remove_from_uri('page').'&page='.($G + 1)).'" class="loadmore">'.lang(239).'</a>'.script("qsl('a').onclick = partial(selectLoadMore, ".(+$A).", '".lang(240)."...');", '') : ''),"\n";
                    }
                }echo"<div class='footer'><div>\n";
                if ($M || $G) {
                    if ($Fe) {
                        $Id = ($Ac === false ? $G + (count($M) >= $A ? 2 : 1) : floor(($Ac - 1) / $A));
                        echo'<fieldset>';
                        if ($z != 'simpledb') {
                            echo"<legend><a href='".h(remove_from_uri('page'))."'>".lang(241).'</a></legend>',script("qsl('a').onclick = function () { pageClick(this.href, +prompt('".lang(241)."', '".($G + 1)."')); return false; };"),pagination(0, $G).($G > 5 ? ' ...' : '');
                            for ($u = max(1, $G - 4); $u < min($Id, $G + 5); $u++) {
                                echo
                                pagination($u, $G);
                            }if ($Id > 0) {
                                echo($G + 5 < $Id ? ' ...' : ''),($fc && $Ac !== false ? pagination($Id, $G) : " <a href='".h(remove_from_uri('page').'&page=last')."' title='~$Id'>".lang(242).'</a>');
                            }
                        } else {
                            echo'<legend>'.lang(241).'</legend>',pagination(0, $G).($G > 1 ? ' ...' : ''),($G ? pagination($G, $G) : ''),($Id > $G ? pagination($G + 1, $G).($Id > $G + 1 ? ' ...' : '') : '');
                        }echo"</fieldset>\n";
                    }echo'<fieldset>','<legend>'.lang(243).'</legend>';
                    $Fb = ($fc ? '' : '~ ').$Ac;
                    echo
                    checkbox('all', 1, 0, ($Ac !== false ? ($fc ? '' : '~ ').lang(143, $Ac) : ''), "var checked = formChecked(this, /check/); selectCount('selected', this.checked ? '$Fb' : checked); selectCount('selected2', this.checked || !checked ? '$Fb' : checked);")."\n","</fieldset>\n";
                    if ($c->selectCommandPrint()) {
                        echo'<fieldset',($_GET['modify'] ? '' : ' class="jsonly"'),'><legend>',lang(235),'</legend><div>
<input type="submit" value="',lang(14),'"',($_GET['modify'] ? '' : ' title="'.lang(231).'"'),'>
</div></fieldset>
<fieldset><legend>',lang(120),' <span id="selected"></span></legend><div>
<input type="submit" name="edit" value="',lang(10),'">
<input type="submit" name="clone" value="',lang(227),'">
<input type="submit" name="delete" value="',lang(18),'">',confirm(),'</div></fieldset>
';
                    }$zc = $c->dumpFormat();
                    foreach ((array) $_GET['columns']as$d) {
                        if ($d['fun']) {
                            unset($zc['sql']);
                            break;
                        }
                    }if ($zc) {
                        print_fieldset('export', lang(69)." <span id='selected2'></span>");
                        $De = $c->dumpOutput();
                        echo($De ? html_select('output', $De, $ma['output']).' ' : ''),html_select('format', $zc, $ma['format'])," <input type='submit' name='export' value='".lang(69)."'>\n","</div></fieldset>\n";
                    }$c->selectEmailPrint(array_filter($Vb, 'strlen'), $e);
                }echo"</div></div>\n";
                if ($c->selectImportPrint()) {
                    echo'<div>',"<a href='#import'>".lang(68).'</a>',script("qsl('a').onclick = partial(toggle, 'import');", ''),"<span id='import' class='hidden'>: ","<input type='file' name='csv_file'> ",html_select('separator', ['csv' => 'CSV,', 'csv;' => 'CSV;', 'tsv' => 'TSV'], $ma['format'], 1);
                    echo" <input type='submit' name='import' value='".lang(68)."'>",'</span>','</div>';
                }echo"<input type='hidden' name='token' value='$T'>\n","</form>\n",(! $t && $N ? '' : script('tableCheck();'));
            }
        }
    }if (is_ajax()) {
        ob_end_clean();
        exit;
    }
} elseif (isset($_GET['variables'])) {
    $cg = isset($_GET['status']);
    page_header($cg ? lang(112) : lang(111));
    $lh = ($cg ? show_status() : show_variables());
    if (! $lh) {
        echo"<p class='message'>".lang(12)."\n";
    } else {
        echo"<table cellspacing='0'>\n";
        foreach ($lh
        as$_ => $X) {
            echo'<tr>',"<th><code class='jush-".$z.($cg ? 'status' : 'set')."'>".h($_).'</code>','<td>'.h($X);
        }echo"</table>\n";
    }
} elseif (isset($_GET['script'])) {
    header('Content-Type: text/javascript; charset=utf-8');
    if ($_GET['script'] == 'db') {
        $lg = ['Data_length' => 0, 'Index_length' => 0, 'Data_free' => 0];
        foreach (table_status()as$F => $R) {
            json_row("Comment-$F", h($R['Comment']));
            if (! is_view($R)) {
                foreach (['Engine', 'Collation']as$_) {
                    json_row("$_-$F", h($R[$_]));
                }foreach ($lg + ['Auto_increment' => 0, 'Rows' => 0]as$_ => $X) {
                    if ($R[$_] != '') {
                        $X = format_number($R[$_]);
                        json_row("$_-$F", ($_ == 'Rows' && $X && $R['Engine'] == ($Xf == 'pgsql' ? 'table' : 'InnoDB') ? "~ $X" : $X));
                        if (isset($lg[$_])) {
                            $lg[$_] += ($R['Engine'] != 'InnoDB' || $_ != 'Data_free' ? $R[$_] : 0);
                        }
                    } elseif (array_key_exists($_, $R)) {
                        json_row("$_-$F");
                    }
                }
            }
        }foreach ($lg
        as$_ => $X) {
            json_row("sum-$_", format_number($X));
        }json_row('');
    } elseif ($_GET['script'] == 'kill') {
        $g->query('KILL '.number($_POST['kill']));
    } else {
        foreach (count_tables($c->databases())as$k => $X) {
            json_row("tables-$k", $X);
            json_row("size-$k", db_size($k));
        }json_row('');
    }exit;
} else {
    $tg = array_merge((array) $_POST['tables'], (array) $_POST['views']);
    if ($tg && ! $m && ! $_POST['search']) {
        $J = true;
        $E = '';
        if ($z == 'sql' && $_POST['tables'] && count($_POST['tables']) > 1 && ($_POST['drop'] || $_POST['truncate'] || $_POST['copy'])) {
            queries('SET foreign_key_checks = 0');
        }if ($_POST['truncate']) {
            if ($_POST['tables']) {
                $J = truncate_tables($_POST['tables']);
            }$E = lang(244);
        } elseif ($_POST['move']) {
            $J = move_tables((array) $_POST['tables'], (array) $_POST['views'], $_POST['target']);
            $E = lang(245);
        } elseif ($_POST['copy']) {
            $J = copy_tables((array) $_POST['tables'], (array) $_POST['views'], $_POST['target']);
            $E = lang(246);
        } elseif ($_POST['drop']) {
            if ($_POST['views']) {
                $J = drop_views($_POST['views']);
            }if ($J && $_POST['tables']) {
                $J = drop_tables($_POST['tables']);
            }$E = lang(247);
        } elseif ($z != 'sql') {
            $J = ($z == 'sqlite' ? queries('VACUUM') : apply_queries('VACUUM'.($_POST['optimize'] ? '' : ' ANALYZE'), $_POST['tables']));
            $E = lang(248);
        } elseif (! $_POST['tables']) {
            $E = lang(9);
        } elseif ($J = queries(($_POST['optimize'] ? 'OPTIMIZE' : ($_POST['check'] ? 'CHECK' : ($_POST['repair'] ? 'REPAIR' : 'ANALYZE'))).' TABLE '.implode(', ', array_map('idf_escape', $_POST['tables'])))) {
            while ($L = $J->fetch_assoc()) {
                $E .= '<b>'.h($L['Table']).'</b>: '.h($L['Msg_text']).'<br>';
            }
        }queries_redirect(substr(ME, 0, -1), $E, $J);
    }page_header(($_GET['ns'] == '' ? lang(33).': '.h(DB) : lang(249).': '.h($_GET['ns'])), $m, true);
    if ($c->homepage()) {
        if ($_GET['ns'] !== '') {
            echo"<h3 id='tables-views'>".lang(250)."</h3>\n";
            $sg = tables_list();
            if (! $sg) {
                echo"<p class='message'>".lang(9)."\n";
            } else {
                echo"<form action='' method='post'>\n";
                if (support('table')) {
                    echo'<fieldset><legend>'.lang(251)." <span id='selected2'></span></legend><div>","<input type='search' name='query' value='".h($_POST['query'])."'>",script("qsl('input').onkeydown = partialArg(bodyKeydown, 'search');", '')," <input type='submit' name='search' value='".lang(52)."'>\n","</div></fieldset>\n";
                    if ($_POST['search'] && $_POST['query'] != '') {
                        $_GET['where'][0]['op'] = 'LIKE %%';
                        search_tables();
                    }
                }$Gb = doc_link(['sql' => 'show-table-status.html']);
                echo"<div class='scrollable'>\n","<table cellspacing='0' class='nowrap checkable'>\n",script("mixin(qsl('table'), {onclick: tableClick, ondblclick: partialArg(tableClick, true)});"),'<thead><tr class="wrap">','<td><input id="check-all" type="checkbox" class="jsonly">'.script("qs('#check-all').onclick = partial(formCheck, /^(tables|views)\[/);", ''),'<th>'.lang(124),'<td>'.lang(252).doc_link(['sql' => 'storage-engines.html']),'<td>'.lang(116).doc_link(['sql' => 'charset-charsets.html', 'mariadb' => 'supported-character-sets-and-collations/']),'<td>'.lang(253).$Gb,'<td>'.lang(254).$Gb,'<td>'.lang(255).$Gb,'<td>'.lang(47).doc_link(['sql' => 'example-auto-increment.html', 'mariadb' => 'auto_increment/']),'<td>'.lang(256).$Gb,(support('comment') ? '<td>'.lang(46).$Gb : ''),"</thead>\n";
                $S = 0;
                foreach ($sg
                as$F => $U) {
                    $oh = ($U !== null && ! preg_match('~table~i', $U));
                    $v = h('Table-'.$F);
                    echo'<tr'.odd().'><td>'.checkbox(($oh ? 'views[]' : 'tables[]'), $F, in_array($F, $tg, true), '', '', '', $v),'<th>'.(support('table') || support('indexes') ? "<a href='".h(ME).'table='.urlencode($F)."' title='".lang(38)."' id='$v'>".h($F).'</a>' : h($F));
                    if ($oh) {
                        echo'<td colspan="6"><a href="'.h(ME).'view='.urlencode($F).'" title="'.lang(39).'">'.(preg_match('~materialized~i', $U) ? lang(122) : lang(123)).'</a>','<td align="right"><a href="'.h(ME).'select='.urlencode($F).'" title="'.lang(37).'">?</a>';
                    } else {
                        foreach (['Engine' => [], 'Collation' => [], 'Data_length' => ['create', lang(40)], 'Index_length' => ['indexes', lang(126)], 'Data_free' => ['edit', lang(41)], 'Auto_increment' => ['auto_increment=1&create', lang(40)], 'Rows' => ['select', lang(37)]]as$_ => $B) {
                            $v = " id='$_-".h($F)."'";
                            echo $B ? "<td align='right'>".(support('table') || $_ == 'Rows' || (support('indexes') && $_ != 'Data_length') ? "<a href='".h(ME."$B[0]=").urlencode($F)."'$v title='$B[1]'>?</a>" : "<span$v>?</span>") : "<td id='$_-".h($F)."'>";
                        }$S++;
                    }echo support('comment') ? "<td id='Comment-".h($F)."'>" : '';
                }echo'<tr><td><th>'.lang(228, count($sg)),'<td>'.h($z == 'sql' ? $g->result('SELECT @@storage_engine') : ''),'<td>'.h(db_collation(DB, collations()));
                foreach (['Data_length', 'Index_length', 'Data_free']as$_) {
                    echo"<td align='right' id='sum-$_'>";
                }echo"</table>\n","</div>\n";
                if (! information_schema(DB)) {
                    echo"<div class='footer'><div>\n";
                    $jh = "<input type='submit' value='".lang(257)."'> ".on_help("'VACUUM'");
                    $re = "<input type='submit' name='optimize' value='".lang(258)."'> ".on_help($z == 'sql' ? "'OPTIMIZE TABLE'" : "'VACUUM OPTIMIZE'");
                    echo'<fieldset><legend>'.lang(120)." <span id='selected'></span></legend><div>".($z == 'sqlite' ? $jh : ($z == 'pgsql' ? $jh.$re : ($z == 'sql' ? "<input type='submit' value='".lang(259)."'> ".on_help("'ANALYZE TABLE'").$re."<input type='submit' name='check' value='".lang(260)."'> ".on_help("'CHECK TABLE'")."<input type='submit' name='repair' value='".lang(261)."'> ".on_help("'REPAIR TABLE'") : '')))."<input type='submit' name='truncate' value='".lang(262)."'> ".on_help($z == 'sqlite' ? "'DELETE'" : "'TRUNCATE".($z == 'pgsql' ? "'" : " TABLE'")).confirm()."<input type='submit' name='drop' value='".lang(121)."'>".on_help("'DROP TABLE'").confirm()."\n";
                    $j = (support('scheme') ? $c->schemas() : $c->databases());
                    if (count($j) != 1 && $z != 'sqlite') {
                        $k = (isset($_POST['target']) ? $_POST['target'] : (support('scheme') ? $_GET['ns'] : DB));
                        echo'<p>'.lang(263).': ',($j ? html_select('target', $j, $k) : '<input name="target" value="'.h($k).'" autocapitalize="off">')," <input type='submit' name='move' value='".lang(264)."'>",(support('copy') ? " <input type='submit' name='copy' value='".lang(265)."'>" : ''),"\n";
                    }echo"<input type='hidden' name='all' value=''>";
                    echo
                    script("qsl('input').onclick = function () { selectCount('selected', formChecked(this, /^(tables|views)\[/));".(support('table') ? " selectCount('selected2', formChecked(this, /^tables\[/) || $S);" : '').' }'),"<input type='hidden' name='token' value='$T'>\n","</div></fieldset>\n","</div></div>\n";
                }echo"</form>\n",script('tableCheck();');
            }echo'<p class="links"><a href="'.h(ME).'create=">'.lang(70)."</a>\n",(support('view') ? '<a href="'.h(ME).'view=">'.lang(194)."</a>\n" : '');
            if (support('routine')) {
                echo"<h3 id='routines'>".lang(136)."</h3>\n";
                $Cf = routines();
                if ($Cf) {
                    echo"<table cellspacing='0'>\n",'<thead><tr><th>'.lang(176).'<td>'.lang(45).'<td>'.lang(211)."<td></thead>\n";
                    odd('');
                    foreach ($Cf
                    as$L) {
                        $F = ($L['SPECIFIC_NAME'] == $L['ROUTINE_NAME'] ? '' : '&name='.urlencode($L['ROUTINE_NAME']));
                        echo'<tr'.odd().'>','<th><a href="'.h(ME.($L['ROUTINE_TYPE'] != 'PROCEDURE' ? 'callf=' : 'call=').urlencode($L['SPECIFIC_NAME']).$F).'">'.h($L['ROUTINE_NAME']).'</a>','<td>'.h($L['ROUTINE_TYPE']),'<td>'.h($L['DTD_IDENTIFIER']),'<td><a href="'.h(ME.($L['ROUTINE_TYPE'] != 'PROCEDURE' ? 'function=' : 'procedure=').urlencode($L['SPECIFIC_NAME']).$F).'">'.lang(129).'</a>';
                    }echo"</table>\n";
                }echo'<p class="links">'.(support('procedure') ? '<a href="'.h(ME).'procedure=">'.lang(210).'</a>' : '').'<a href="'.h(ME).'function=">'.lang(209)."</a>\n";
            }if (support('event')) {
                echo"<h3 id='events'>".lang(137)."</h3>\n";
                $M = get_rows('SHOW EVENTS');
                if ($M) {
                    echo"<table cellspacing='0'>\n",'<thead><tr><th>'.lang(176).'<td>'.lang(266).'<td>'.lang(200).'<td>'.lang(201)."<td></thead>\n";
                    foreach ($M
                    as$L) {
                        echo'<tr>','<th>'.h($L['Name']),'<td>'.($L['Execute at'] ? lang(267).'<td>'.$L['Execute at'] : lang(202).' '.$L['Interval value'].' '.$L['Interval field']."<td>$L[Starts]"),"<td>$L[Ends]",'<td><a href="'.h(ME).'event='.urlencode($L['Name']).'">'.lang(129).'</a>';
                    }echo"</table>\n";
                    $dc = $g->result('SELECT @@event_scheduler');
                    if ($dc && $dc != 'ON') {
                        echo"<p class='error'><code class='jush-sqlset'>event_scheduler</code>: ".h($dc)."\n";
                    }
                }echo'<p class="links"><a href="'.h(ME).'event=">'.lang(199)."</a>\n";
            }if ($sg) {
                echo
                script("ajaxSetHtml('".js_escape(ME)."script=db');");
            }
        }
    }
}page_footer();
