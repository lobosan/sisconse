<?php

$root = '../files/';
$node = isset($_REQUEST['node']) ? $_REQUEST['node'] : "";

if (strpos($node, '..') !== false) {
    die('Nice try buddy.');
}

$nodes = array();
$d = dir($root . $node);
while ($f = $d->read()) {
    if ($f == '.' || $f == '..' || substr($f, 0, 1) == '.') continue;

    if (is_dir($root . $node . '/' . $f)) {
        array_push($nodes, array('text' => $f, 'singleClickExpand' => 'true', 'id' => $node . '/' . $f));
    } elseif ($f != 'index.html') {
        array_push($nodes, array('text' => $f, 'id' => $node . '/' . $f, 'leaf' => true, 'iconCls' => getIcon($f)));
    }
}
$d->close();

echo json_encode($nodes);

function getIcon($name)
{
    if (preg_match("/\.png$/", $name) || preg_match("/\.jpg$/", $name) || preg_match("/\.gif$/", $name)) {
        return 'jpg-icon';
    } else if (preg_match("/\.xls$/", $name) || preg_match("/\.xlsx$/", $name)) {
        return 'xls-icon';
    } else if (preg_match("/\.ppt$/", $name) || preg_match("/\.pptx$/", $name)) {
        return 'ppt-icon';
    } else if (preg_match("/\.doc$/", $name) || preg_match("/\.docx$/", $name)) {
        return 'doc-icon';
    } else if (preg_match("/\.html$/", $name) || preg_match("/\.htm$/", $name)) {
        return 'html-icon';
    } else if (preg_match("/\.pdf$/", $name)) {
        return 'pdf-icon';
    } else {
        return 'unknow-icon';
    }
}