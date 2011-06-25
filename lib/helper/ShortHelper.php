<?php

function link_self($url) {
  return content_tag('a', $url, array('href' => $url));
}

function short_link($id) {
  return link_self(url_for('@redirect?short='.$id, array('absolute' => true)));
}