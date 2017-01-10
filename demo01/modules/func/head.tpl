<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-ransitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ja" xml:lang="ja">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta http-equiv="Content-Script-Type" content="text/javascript" />
<meta http-equiv="Content-Style-Type" content="text/css" />

<?php
    foreach ($G_HTML_STYLE_ARR as $style_name) {
        print "<link rel='stylesheet' href='".$style_name."' type='text/css' media='all' />\n";
    }
?>

<?php
    foreach ($G_HTML_JS_ARR as $js_name) {
        print "<script type='text/javascript' src='".$$js_name."'></script>\n";
    }
?>

<title>{$html_title}</title>
<meta name="description" content="{$html_description}" />
<meta name="keywords"    content="{$html_keywords}" />
</head>
